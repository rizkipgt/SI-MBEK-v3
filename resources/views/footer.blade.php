<!-- ========== FOOTER ========== -->
@php
    $settings = App\Models\SiteSetting::first();
@endphp

<footer class="bg-orange-100 text-gray-800">
    <div class="max-w-7xl mx-auto px-4 py-8 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-3 gap-8 mb-8">
            <!-- Kolom 1: Navigasi + Sosmed -->
            <div class="space-y-4">
                <div class="flex flex-col font-semibold space-y-2">
                    <a href="/" class="hover:text-brand-orange transition-colors">Beranda</a>
                    <a href="/about" class="hover:text-brand-orange transition-colors">Tentang Kami</a>
                    <a href="/contact" class="hover:text-brand-orange transition-colors">Kontak</a>
                </div>
                
                <!-- Ikon Media Sosial -->
                <div class="flex gap-3 pt-4">
                    @foreach(['twitter', 'facebook', 'instagram'] as $social)
                        @if($settings->social[$social]['active'] ?? false)
                            <a href="{{ $settings->social[$social]['url'] }}" 
                               class="bg-brand-orange p-2 rounded-full hover:bg-yellow-500 transition-colors"
                               target="_blank">
                                @if($social === 'twitter')
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                                </svg>
                                @elseif($social === 'facebook')
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm3 8h-1.35c-.538 0-.65.221-.65.778v1.222h2l-.209 2h-1.791v7h-3v-7h-2v-2h2v-2.308c0-1.769.931-2.692 3.029-2.692h1.971v3z"/>
                                </svg>
                                @elseif($social === 'instagram')
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                                @endif
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Kolom 2: Kontak -->
            <div class="space-y-4">
                <div class="flex items-start gap-3">
                    <div class="mt-1">
                        <svg class="w-5 h-5 text-brand-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-brand-orange">Alamat</p>
                        <p class="text-gray-800 text-sm mt-1">
                            {{ $settings->contact['address'] ?? 'Seputih Raman, Lampung' }}
                        </p>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <div class="mt-1">
                        <svg class="w-5 h-5 text-brand-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-brand-orange">Telepon</p>
                        <p class="text-gray-800 text-sm mt-1">
                            {{ $settings->contact['phone'] ?? '+62-xxx-xxxx-xxxx' }}
                        </p>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <div class="mt-1">
                        <svg class="w-5 h-5 text-brand-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-brand-orange">Email</p>
                        <p class="text-gray-800 text-sm mt-1">
                            {{ $settings->contact['email'] ?? 'yangpunyausahambek@gmail.com' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Kolom 3: Map -->
            @if($settings->map['active'] ?? false)
            <div class="h-48 md:h-56 lg:h-64 bg-gray-800 rounded-lg overflow-hidden">
                {!! $settings->map['embed_code'] !!}
            </div>
            @endif
        </div>

        <!-- Copyright -->
        <div class="text-center pt-6 border-t border-gray-700">
            <p class="text-sm text-gray-400">
                &copy; <script>document.write(new Date().getFullYear())</script> 
                {{ $settings->site_name ?? 'SI MBEK' }}. PMKU UNILA || LABKOM UNILA
            </p>
        </div>
    </div>
</footer>