<footer class="border-t bg-white dark:bg-gray-900">

    <div class="px-6 py-4">

        <div class="flex flex-col md:flex-row items-center justify-between gap-3 text-sm text-gray-600 dark:text-gray-400">

            {{-- LEFT --}}
            <div class="text-center md:text-left">
                <span class="text-gray-500">© {{ date('Y') }}</span>
                <span class="font-semibold text-gray-800 dark:text-gray-200 ml-1">
                    Sistem Informasi Pengamal Kaltim
                </span>
            </div>

            {{-- RIGHT --}}
            <div class="flex items-center gap-2">
                <span class="text-gray-500">v</span>
                <span class="px-2 py-0.5 rounded-md bg-gray-100 dark:bg-gray-800 text-xs font-semibold">
                    {{ config('app.version', '1.0.0') }}
                </span>
            </div>

        </div>

        {{-- BOTTOM --}}
        <div class="mt-3 text-center text-xs text-gray-400">
            Kalimantan Timur • Dashboard Terpadu • All rights reserved
        </div>

    </div>

</footer>