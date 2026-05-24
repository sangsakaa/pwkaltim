<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <div>
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
          Daftar Surat Tugas
        </h2>
        <p class="text-sm text-gray-500 dark:text-gray-400">
          Kelola data surat tugas dengan mudah
        </p>
      </div>

      <a href="{{ route('surat-tugas.create') }}"
        class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl shadow transition duration-200">

        <svg xmlns="http://www.w3.org/2000/svg"
          class="w-5 h-5"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor">
          <path stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M12 4v16m8-8H4" />
        </svg>

        Tambah Surat
      </a>
    </div>
  </x-slot>

  <div class="p-6">
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl overflow-hidden">

      <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-600 dark:text-gray-300">
          <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 uppercase text-xs tracking-wider">
            <tr>
              <th class="px-6 py-4">No</th>
              <th class="px-6 py-4">Nomor Surat</th>
              <th class="px-6 py-4">Nama</th>
              <th class="px-6 py-4">Tanggal</th>
              <th class="px-6 py-4 text-center">Aksi</th>
            </tr>
          </thead>

          <tbody class="divide-y divide-gray-200 dark:divide-gray-700">

            @forelse($surat as $s)
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-200">

              <td class="px-6 py-4 font-medium">
                {{ $loop->iteration + ($surat->currentPage() - 1) * $surat->perPage() }}
              </td>

              <td class="px-6 py-4 font-semibold text-gray-800 dark:text-white">
                {{ $s->nomor }}
              </td>

              <td class="px-6 py-4">
                {{ $s->nama }}
              </td>

              <td class="px-6 py-4">
                <span
                  class="inline-flex items-center px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold">
                  {{ $s->tanggal_masehi }}
                </span>
              </td>

              <td class="px-6 py-4">
                <div class="flex items-center justify-center gap-2 flex-wrap">

                  {{-- Detail --}}
                  <a href="{{ route('surat-tugas.show', $s->id) }}"
                    class="px-3 py-2 rounded-lg bg-sky-100 text-sky-700 hover:bg-sky-200 transition text-xs font-semibold">
                    Detail
                  </a>

                  {{-- Edit --}}
                  <a href="{{ route('surat-tugas.edit', $s->id) }}"
                    class="px-3 py-2 rounded-lg bg-yellow-100 text-yellow-700 hover:bg-yellow-200 transition text-xs font-semibold">
                    Edit
                  </a>

                  {{-- PDF --}}
                  <a href="{{ route('surat-tugas.pdf', $s->id) }}"
                    target="_blank"
                    class="px-3 py-2 rounded-lg bg-green-100 text-green-700 hover:bg-green-200 transition text-xs font-semibold">
                    PDF
                  </a>

                  {{-- Hapus --}}
                  <form action="{{ route('surat-tugas.destroy', $s->id) }}"
                    method="POST"
                    onsubmit="return confirm('Yakin ingin menghapus data ini?')">

                    @csrf
                    @method('DELETE')

                    <button type="submit"
                      class="px-3 py-2 rounded-lg bg-red-100 text-red-700 hover:bg-red-200 transition text-xs font-semibold">
                      Hapus
                    </button>
                  </form>

                </div>
              </td>
            </tr>

            @empty
            <tr>
              <td colspan="5" class="text-center py-12">
                <div class="flex flex-col items-center gap-3 text-gray-400">
                  <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-14 h-14"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="1.5"
                      d="M9 12h6m-6 4h6M7 4h10a2 2 0 012 2v12a2 2 0 01-2
                                                2H7a2 2 0 01-2-2V6a2 2 0 012-2z" />
                  </svg>

                  <p class="text-lg font-medium">
                    Belum ada data surat tugas
                  </p>
                </div>
              </td>
            </tr>
            @endforelse

          </tbody>
        </table>
      </div>

      {{-- Pagination --}}
      <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
        {{ $surat->links() }}
      </div>

    </div>
  </div>
</x-app-layout>