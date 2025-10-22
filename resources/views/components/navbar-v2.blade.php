<header class="bg-orange-100 shadow-sm">
    <nav class="max-w-6xl w-full mx-auto px-4 py-3">
        <div class="flex items-center justify-between">
            <!-- Logo Section -->
            <div class="flex items-center space-x-3">
                
                <!-- Dynamic Logo -->
                <img class="w-12 h-12" 
                     src="{{ $settings->site_logo ? asset('storage/'.$settings->site_logo) : asset('logo/logosiembek.png') }}" 
                     alt="Site Logo">
                
                <!-- Dynamic Site Name -->
                <span class="text-2xl font-bold text-gray-800">
                    {{ $settings->site_name ?? 'SI MBEK' }}
                </span>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-6">
                <a href="{{ route('home') }}"
                   class="{{ request()->routeIs('home') ? 'font-bold text-brand-orange' : 'text-gray-600 hover:text-brand-orange' }} transition-colors">
                   Beranda
                </a>
                <a href="{{ route('forsale', ['kategori_produk' => 'semua']) }}"
                   class="{{ request()->routeIs('forsale') ? 'font-bold text-brand-orange' : 'text-gray-600 hover:text-brand-orange' }} transition-colors">
                   Produk
                </a>
                <a href="/about"
                   class="{{ request()->is('about') ? 'font-bold text-brand-orange' : 'text-gray-600 hover:text-brand-orange' }} transition-colors">
                   Tentang Kami
                </a>
                <a href="/contact"
                   class="{{ request()->is('contact') ? 'font-bold text-brand-orange' : 'text-gray-600 hover:text-brand-orange' }} transition-colors">
                   Kontak
                </a>

                <!-- Auth Section -->
                <div class="flex items-center space-x-4 ml-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}"
                               class="{{ request()->is('dashboard') ? 'font-bold text-brand-orange' : 'text-brand-orange hover:text-orange-500' }} transition-colors pl-12">
                               Dashboard
                            </a>
                        @else
                            <a href="{{ url('/login') }}"
                               class="{{ request()->is('login') ? 'font-bold text-brand-orange' : 'text-brand-orange hover:text-gray-600' }} transition-colors pl-12">
                               Masuk
                            </a>
                            @if (Route::has('register'))
                                <span class="text-gray-300">|</span>
                                <a href="{{ url('/register') }}"
                                   class="{{ request()->is('register') ? 'font-bold text-brand-orange' : 'text-brand-orange hover:text-gray-600' }} transition-colors">
                                   Daftar
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>

            <!-- Mobile Menu Button -->
            <button type="button"
                class="hs-collapse-toggle md:hidden p-2 inline-flex justify-center items-center gap-x-2 rounded-lg border border-gray-200 bg-white text-black shadow-sm hover:bg-gray-50"
                data-hs-collapse="#navbar-collapse"
                aria-controls="navbar-collapse"
                aria-label="Toggle navigation">
                <svg class="hs-collapse-open:hidden flex-shrink-0 size-4" 
                    width="24" height="24" viewBox="0 0 24 24" 
                    fill="none" stroke="currentColor" stroke-width="2" 
                    stroke-linecap="round" stroke-linejoin="round">
                    <line x1="3" x2="21" y1="6" y2="6" />
                    <line x1="3" x2="21" y1="12" y2="12" />
                    <line x1="3" x2="21" y1="18" y2="18" />
                </svg>
                <svg class="hs-collapse-open:block hidden flex-shrink-0 size-4" 
                    width="24" height="24" viewBox="0 0 24 24" 
                    fill="none" stroke="currentColor" stroke-width="2" 
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 6 6 18" />
                    <path d="m6 6 12 12" />
                </svg>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div id="navbar-collapse"
             class="hs-collapse hidden overflow-hidden transition-all duration-300 basis-full grow md:hidden">
            <div class="flex flex-col gap-2 mt-4">
                <a href="{{ route('home') }}"
                   class="py-2 px-4 rounded-lg {{ request()->routeIs('home') ? 'font-bold text-brand-orange bg-gray-100' : 'text-gray-600 hover:bg-gray-50' }}">
                   Beranda
                </a>
                <a href="{{ route('forsale', ['kategori_produk' => 'semua']) }}"
                   class="py-2 px-4 rounded-lg {{ request()->routeIs('forsale') ? 'font-bold text-brand-orange bg-gray-100' : 'text-gray-600 hover:bg-gray-50' }}">
                   Produk
                </a>
                <a href="/about"
                   class="py-2 px-4 rounded-lg {{ request()->is('about') ? 'font-bold text-brand-orange bg-gray-100' : 'text-gray-600 hover:bg-gray-50' }}">
                   Tentang Kami
                </a>
                <a href="/contact"
                   class="py-2 px-4 rounded-lg {{ request()->is('contact') ? 'font-bold text-brand-orange bg-gray-100' : 'text-gray-600 hover:bg-gray-50' }}">
                   Kontak
                </a>

                <div class="pt-4 border-t">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}"
                               class="block py-2 px-4 rounded-lg {{ request()->is('dashboard') ? 'font-bold text-brand-orange bg-gray-100' : 'text-gray-600 hover:bg-gray-50' }}">
                               Dashboard
                            </a>
                        @else
                            <a href="{{ url('/login') }}"
                               class="block py-2 px-4 rounded-lg {{ request()->is('login') ? 'font-bold text-brand-orange bg-gray-100' : 'text-gray-600 hover:bg-gray-50' }}">
                               Masuk
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ url('/register') }}"
                                   class="block py-2 px-4 rounded-lg {{ request()->is('register') ? 'font-bold text-brand-orange bg-gray-100' : 'text-gray-600 hover:bg-gray-50' }}">
                                   Daftar
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>
</header>
