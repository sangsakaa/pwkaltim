<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function home()
    {
        $posts = Post::where('status', 'approved')
            ->latest()
            ->take(3)
            ->get();

        return view('home', compact('posts'));
    }
    public function create()
    {   
        $categories = Category::all();
        return view('administrator.post.post',compact('categories'));
    }
    public function showPublic($id)
    {
        $user = auth()->user();

        $query = Post::query()
            ->where('status', 'approved');

        // 🔐 FILTER BERDASARKAN ROLE SAJA
        if ($user && $user->role !== 'admin') {
            // user biasa tetap boleh lihat post approved
            // kalau mau dibatasi, bisa tambah filter lain nanti
        }

        // Ambil post utama
        $post = (clone $query)->findOrFail($id);

        // Previous post
        $previousPost = (clone $query)
            ->where('id', '<', $post->id)
            ->orderByDesc('id')
            ->first();

        // Next post
        $nextPost = (clone $query)
            ->where('id', '>', $post->id)
            ->orderBy('id', 'asc')
            ->first();

        // Sidebar: latest posts
        $latestPosts = (clone $query)
            ->where('id', '!=', $post->id)
            ->latest()
            ->take(5)
            ->get();

        // Sidebar: older posts
        $olderPosts = (clone $query)
            ->where('id', '!=', $post->id)
            ->oldest()
            ->take(5)
            ->get();

        return view('administrator.post.detail', compact(
            'post',
            'previousPost',
            'nextPost',
            'latestPosts',
            'olderPosts'
        ));
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:posts,slug',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $photoPath = null;

        if ($request->hasFile('photo')) {
            // Simpan file dan ambil path relatifnya dari "storage/app/public"
            $photoPath = $request->file('photo')->store('posts', 'public');
        }

        Post::create([
            'title' => $request->title,
            'slug' => $request->slug,
            'content' => $request->content,
            'category_id' => $request->category_id,
            'photo' => $photoPath,
            'created_by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Postingan berhasil dibuat.');
    }


    public function approval()
    {
        $posts = Post::with('creator')
            ->latest()
            ->get();

        return view('administrator.post.approval', [
            'allPosts' => $posts,

            'pendingPosts' => $posts->where('status', 'pending')->values(),
            'rejectedPosts' => $posts->where('status', 'rejected')->values(),
            'approvedPosts' => $posts->where('status', 'approved')->values(), // kalau ada
        ]);
    }
    public function approve(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        if (!in_array($request->action, ['approve', 'reject'])) {
            return back()->with('error', 'Aksi tidak valid');
        }

        $post->status = $request->action === 'approve'
            ? 'approved'
            : 'rejected';

        $post->approved_by = auth()->id();
        $post->approved_at = now();

        // optional flag
        $post->was_approved = $request->action === 'approve';

        $post->save();

        return back()->with('success', 'Status post berhasil diperbarui');
    }
    public function rejectedAfterApproval()
    {
        $posts = Post::where('status', 'rejected')
            ->where('was_approved', true)
            ->get();

        return view('administrator.post.reject', compact('posts'));
    }
    public function approvedList()
    {
        $posts = Post::where('status', 'approved')
            ->with(['creator', 'approver'])
            ->latest('approved_at')
            ->get();

        return view('administrator.post.list', compact('posts'));
    }
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        // Optional: batasi hanya admin_kabupaten yang bisa hapus posting miliknya
        if (auth()->user()->role === 'admin-kabupaten' && $post->created_by !== auth()->id()) {
            abort(403, 'Anda tidak memiliki izin untuk menghapus postingan ini.');
        }

        $post->delete();

        return redirect()->back()->with('success', 'Postingan berhasil dihapus.');
    }
}
