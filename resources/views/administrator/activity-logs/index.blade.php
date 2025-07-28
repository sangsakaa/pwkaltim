<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">User Activity Logs</h2>
    </x-slot>

    <div class="p-4">
        <form method="GET" class="mb-4">
            <input type="text" name="search" value="{{ request('search') }}"
                class="border rounded p-2 w-1/3" placeholder="Cari aktivitas...">
            <button class="px-4 py-2 bg-blue-600 text-white rounded">Cari</button>
        </form>

        <div class="overflow-auto">
            <table class="w-full table-auto border">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="p-2">User</th>
                        <th class="p-2">Log</th>
                        <th class="p-2">IP</th>
                        <th class="p-2">User Agent</th>
                        <th class="p-2">Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($logs as $log)
                    <tr class="border-t">
                        <td class="p-2">{{ $log->causer?->name ?? 'System' }}</td>
                        <td class="p-2">{{ $log->description }}</td>
                        <td class="p-2">{{ $log->properties['ip'] ?? '-' }}</td>
                        <td class="p-2 text-xs">{{ $log->properties['user_agent'] ?? '-' }}</td>
                        <td class="p-2">{{ $log->created_at->diffForHumans() }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-4 text-center">Tidak ada log ditemukan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $logs->links() }}
        </div>
    </div>
</x-app-layout>