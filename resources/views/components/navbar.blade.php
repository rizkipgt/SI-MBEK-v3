<header class="relative flex flex-wrap sm:justify-start sm:flex-nowrap w-full bg-white text-sm pt-4 text-black">
    <nav class="max-w-[70rem] w-full mx-auto px-4 sm:flex sm:items-center sm:justify-between" aria-label="Global">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <img class="w-20" src="{{ asset('logo/logosiembek.png') }}" alt="">
                <a class="flex-none text-xl font-semibold text-black uppercase" href="/">SI MBEK</a>
            </div>
            <div class="sm:hidden">
                <button type="button"
                    class="hs-collapse-toggle p-2 inline-flex justify-center items-center gap-x-2 rounded-lg border border-gray-200 bg-white text-black shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-transparent dark:border-neutral-700 dark:text-white dark:hover:bg-white/10"
                    data-hs-collapse="#navbar-with-mega-menu" aria-controls="navbar-with-mega-menu"
                    aria-label="Toggle navigation">
                    <svg class="hs-collapse-open:hidden flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="black"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="3" x2="21" y1="6" y2="6" />
                        <line x1="3" x2="21" y1="12" y2="12" />
                        <line x1="3" x2="21" y1="18" y2="18" />
                    </svg>
                    <svg class="hs-collapse-open:block hidden flex-shrink-0 size-4"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="black" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M18 6 6 18" />
                        <path d="m6 6 12 12" />
                    </svg>
                </button>
            </div>
        </div>
        <div id="navbar-with-mega-menu"
            class="hs-collapse hidden overflow-hidden transition-all duration-300 basis-full grow sm:block">
            <div class="flex flex-col gap-2 mt-5 sm:flex-row sm:items-center sm:justify-end sm:mt-0 sm:ps-5">

                {{-- <a class="font-bold text-white hover:text-gray-400 bg-orange-600 P-2 rounded-md dark:hover:text-neutral-500"
                    href="/teamproject"></a> --}}
                <a class="text-white font-bold hover:text-grsay-400 bg-orange-500 p-2 rounded-md     dark:hover:font-normal"
                            href="{{route('kambings.index')}}">List Kambing</a>
                <a class="text-white font-bold hover:text-grsay-400 bg-orange-500 p-2 rounded-md     dark:hover:font-normal"
                            href="/about">Tentang Kami</a>
                {{-- <a class="text-white font-bold hover:text-grsay-400 bg-orange-500 p-2 rounded-md     dark:hover:font-normal"
                            href="/teamproject">Team Project</a> --}}
                    {{--
                <a class="font-medium text-black hover:text-gray-400     dark:hover:text-neutral-500"
                    href="#">Kontak</a> --}}

                {{-- <div class="hs-dropdown [--strategy:static] sm:[--strategy:fixed] [--adaptive:none] ">
                    <button id="hs-mega-menu-basic-dr" type="button"
                        class="flex items-center w-full text-black hover:text-gray-400 font-medium   dark:hover:text-neutral-500 ">
                        Dropdown
                        <svg class="ms-1 flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="m6 9 6 6 6-6" />
                        </svg>
                    </button>

                    <div
                        class="text-white hs-dropdown-menu transition-[opacity,margin] duration-[0.1ms] sm:duration-[150ms] hs-dropdown-open:opacity-100 opacity-0 sm:w-48 z-10 bg-white sm:shadow-md rounded-lg p-2  sm:dark:border dark:border-neutral-700 dark:divide-neutral-700 before:absolute top-full sm:border before:-top-5 before:start-0 before:w-full before:h-5 hidden">
                        <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500      dark:hover:bg-neutral-700 dark:hover:text-neutral-300"
                            href="#">
                            About
                        </a>
                        <div
                            class="hs-dropdown relative [--strategy:static] sm:[--strategy:absolute] [--adaptive:none] ">
                            <button type="button"
                                class="w-full flex justify-between items-center text-sm text-gray-800 rounded-lg py-2 px-3 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500    dark:hover:bg-neutral-700 dark:hover:text-neutral-300">
                                Sub Menu
                                <svg class="sm:-rotate-90 ms-2 flex-shrink-0 size-4 text-black  "
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m6 9 6 6 6-6" />
                                </svg>
                            </button>

                            <div
                                class="hs-dropdown-menu transition-[opacity,margin] duration-[0.1ms] sm:duration-[150ms] hs-dropdown-open:opacity-100 opacity-0 sm:w-48 hidden z-10 sm:mt-2 bg-white sm:shadow-md rounded-lg p-2  sm:dark:border dark:border-neutral-700 dark:divide-neutral-700 before:absolute sm:border before:-end-5 before:top-0 before:h-full before:w-5 !mx-[10px] top-0 end-full">
                                <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500      dark:hover:bg-neutral-700 dark:hover:text-neutral-300"
                                    href="#">
                                    About
                                </a>
                                <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500      dark:hover:bg-neutral-700 dark:hover:text-neutral-300"
                                    href="#">
                                    Downloads
                                </a>
                                <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500      dark:hover:bg-neutral-700 dark:hover:text-neutral-300"
                                    href="#">
                                    Team Account
                                </a>
                            </div>
                        </div>

                        <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500      dark:hover:bg-neutral-700 dark:hover:text-neutral-300"
                            href="#">
                            Downloads
                        </a>
                        <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500      dark:hover:bg-neutral-700 dark:hover:text-neutral-300"
                            href="#">
                            Team Account
                        </a>
                    </div>
                </div> --}}
                @if (Route::has('login'))
                    @auth

                        <a class="text-white font-bold hover:text-grsay-400 bg-blue-500 p-2 rounded-md     dark:hover:font-normal"
                            href="{{ url('/dashboard') }}">Dashboard</a>
                    @else
                        <a class=" text-white font-bold hover:text-grsay-400 bg-blue-500 p-2 rounded-md     dark:hover:font-normal"
                            href="{{ url('/login') }}">Login</a>
                        @if (Route::has('register'))
                            <a class=" text-white font-bold hover:text-s-400 bg-blue-500 p-2 rounded-md     dark:hover:font-normal"
                                href="{{ url('/register') }}">Register</a>
                        @endif
                    @endauth

                @endif
            </div>
        </div>
    </nav>
</header>
