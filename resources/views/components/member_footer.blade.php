{{-- Footer --}}
<footer class="bg-gray-900 text-gray-300 py-8">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
                {{-- Logo & Social --}}
                <div class="flex items-center gap-4">
                    <img src="{{ asset('logo.png') }}" class="h-14 flex-shrink-0" alt="Perpustakaan Provinsi Papua">
                    <div>
                        <p class="text-white font-semibold text-sm">Perpustakaan Daerah</p>
                        <p class="text-gray-500 text-xs">Provinsi Papua</p>
                        <div class="flex gap-2 mt-2">
                            <a href="#" class="w-7 h-7 rounded-md bg-gray-800 hover:bg-indigo-600 flex items-center justify-center transition-colors">
                                <svg class="w-3.5 h-3.5 text-gray-400 hover:text-white" viewBox="0 0 24 24" fill="currentColor"><path d="M15.12 5.32H17V2.14A26.11 26.11 0 0 0 14.26 2c-2.72 0-4.58 1.66-4.58 4.7v2.62H6.61v3.56h3.07V22h3.68v-9.12h3.06l.46-3.56h-3.52V7.05c0-1.05.28-1.73 1.76-1.73Z"/></svg>
                            </a>
                            <a href="#" class="w-7 h-7 rounded-md bg-gray-800 hover:bg-indigo-600 flex items-center justify-center transition-colors">
                                <svg class="w-3.5 h-3.5 text-gray-400 hover:text-white" viewBox="0 0 24 24" fill="currentColor"><path d="M17.34 5.46a1.2 1.2 0 1 0 1.2 1.2a1.2 1.2 0 0 0-1.2-1.2Zm4.6 2.42a7.59 7.59 0 0 0-.46-2.43a4.94 4.94 0 0 0-1.16-1.77a4.7 4.7 0 0 0-1.77-1.15a7.3 7.3 0 0 0-2.43-.47C15.06 2 14.72 2 12 2s-3.06 0-4.12.06a7.3 7.3 0 0 0-2.43.47a4.78 4.78 0 0 0-1.77 1.15a4.7 4.7 0 0 0-1.15 1.77a7.3 7.3 0 0 0-.47 2.43C2 8.94 2 9.28 2 12s0 3.06.06 4.12a7.3 7.3 0 0 0 .47 2.43a4.7 4.7 0 0 0 1.15 1.77a4.78 4.78 0 0 0 1.77 1.15a7.3 7.3 0 0 0 2.43.47C8.94 22 9.28 22 12 22s3.06 0 4.12-.06a7.3 7.3 0 0 0 2.43-.47a4.7 4.7 0 0 0 1.77-1.15a4.85 4.85 0 0 0 1.16-1.77a7.59 7.59 0 0 0 .46-2.43c0-1.06.06-1.4.06-4.12s0-3.06-.06-4.12ZM20.14 16a5.61 5.61 0 0 1-.34 1.86a3.06 3.06 0 0 1-.75 1.15a3.19 3.19 0 0 1-1.15.75a5.61 5.61 0 0 1-1.86.34c-1 .05-1.37.06-4 .06s-3 0-4-.06a5.73 5.73 0 0 1-1.94-.3a3.27 3.27 0 0 1-1.1-.75a3 3 0 0 1-.74-1.15a5.54 5.54 0 0 1-.4-1.9c0-1-.06-1.37-.06-4s0-3 .06-4a5.54 5.54 0 0 1 .35-1.9A3 3 0 0 1 5 5a3.14 3.14 0 0 1 1.1-.8A5.73 5.73 0 0 1 8 3.86c1 0 1.37-.06 4-.06s3 0 4 .06a5.61 5.61 0 0 1 1.86.34a3.06 3.06 0 0 1 1.19.8a3.06 3.06 0 0 1 .75 1.1a5.61 5.61 0 0 1 .34 1.9c.05 1 .06 1.37.06 4s-.01 3-.06 4ZM12 6.87A5.13 5.13 0 1 0 17.14 12A5.12 5.12 0 0 0 12 6.87Zm0 8.46A3.33 3.33 0 1 1 15.33 12A3.33 3.33 0 0 1 12 15.33Z"/></svg>
                            </a>
                            <a href="#" class="w-7 h-7 rounded-md bg-gray-800 hover:bg-indigo-600 flex items-center justify-center transition-colors">
                                <svg class="w-3.5 h-3.5 text-gray-400 hover:text-white" viewBox="0 0 24 24" fill="currentColor"><path d="M23 9.71a8.5 8.5 0 0 0-.91-4.13a2.92 2.92 0 0 0-1.72-1A78.36 78.36 0 0 0 12 4.27a78.45 78.45 0 0 0-8.34.3a2.87 2.87 0 0 0-1.46.74c-.9.83-1 2.25-1.1 3.45a48.29 48.29 0 0 0 0 6.48a9.55 9.55 0 0 0 .3 2a3.14 3.14 0 0 0 .71 1.36a2.86 2.86 0 0 0 1.49.78a45.18 45.18 0 0 0 6.5.33c3.5.05 6.57 0 10.2-.28a2.88 2.88 0 0 0 1.53-.78a2.49 2.49 0 0 0 .61-1a10.58 10.58 0 0 0 .52-3.4c.04-.56.04-3.94.04-4.54ZM9.74 14.85V8.66l5.92 3.11c-1.66.92-3.85 1.96-5.92 3.08Z"/></svg>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Quick Links --}}
                <div>
                    <h5 class="text-white font-semibold text-sm mb-3">Tautan Cepat</h5>
                    <div class="flex flex-wrap gap-x-6 gap-y-1.5">
                        <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-indigo-400 transition-colors text-xs">Home</a>
                        <a href="{{ route('allBuku') }}" class="text-gray-400 hover:text-indigo-400 transition-colors text-xs">Semua Buku</a>
                        <a href="{{ route('allCategories') }}" class="text-gray-400 hover:text-indigo-400 transition-colors text-xs">Kategori</a>
                        @if (Auth::check() && Auth::user()->role == 'member')
                        <a href="{{ route('pinjam') }}" class="text-gray-400 hover:text-indigo-400 transition-colors text-xs">Peminjaman Saya</a>
                        @endif
                    </div>
                </div>

                {{-- Contact --}}
                <div>
                    <h5 class="text-white font-semibold text-sm mb-3">Hubungi Kami</h5>
                    <div class="space-y-1.5">
                        <p class="text-xs text-gray-400 flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 text-indigo-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            +62 877 4316 0171
                        </p>
                        <p class="text-xs text-gray-400 flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 text-indigo-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Provinsi Papua, Indonesia
                        </p>
                    </div>
                </div>
            </div>

            {{-- Divider + Copyright --}}
            <div class="mt-6 pt-4 border-t border-gray-800 text-center">
                <p class="text-xs text-gray-500">&copy; 2025 Perpustakaan Daerah Provinsi Papua. Hak cipta dilindungi.</p>
            </div>
        </div>
    </div>
</footer>
