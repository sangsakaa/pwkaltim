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
    
    public function create()
    {   
        $categories = Category::all();
        return view('administrator.post.post',compact('categories'));
    }
    public function showPublic($id)
    {
        $post = Post::where('status', 'approved')->findOrFail($id);

        // Ambil post sebelumnya
        $previousPost = Post::where('status', 'approved')
            ->where('id', '<', $post->id)
            ->orderByDesc('id')
            ->first();

        // Ambil post berikutnya
        $nextPost = Post::where('status', 'approved')
            ->where('id', '>', $post->id)
            ->orderBy('id')
            ->first();

        return view('administrator.post.detail', compact('post', 'previousPost', 'nextPost'));
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
        $posts = Post::where('status', 'pending')->with('creator')->get();
        $rejectposts = Post::where('status', 'rejected')->with('creator')->get();
        return view('administrator.post.approval', compact('posts', 'rejectposts'));
    }

    public function approve(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        if ($request->action === 'approve') {
            $post->update([
                'status' => 'approved',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
                'was_approved' => true,
            ]);
        } elseif ($request->action === 'reject') {
            $post->update([
                'status' => 'rejected',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
                // 'was_approved' => false,
            ]);
        }

        return redirect()->back()->with('success', 'Aksi berhasil dilakukan.');
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
