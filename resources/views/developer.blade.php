<x-home-layout>
    <x-navbar />

    <main class="mt-6 max-w-[85rem] mx-auto my-10 ">

        <div class="bg-white py-6 sm:py-8 lg:py-12">
            <div class="mx-auto max-w-screen-xl px-4 md:px-8">
                <!-- text - start -->
                <div class="mb-10 md:mb-16">
                    <h2 class="mb-4 text-center text-2xl font-bold text-gray-800 md:mb-6 lg:text-3xl">Meet our Team</h2>

                    {{-- <p class="mx-auto max-w-screen-md text-center text-gray-500 md:text-lg">This is a section of some simple filler text, also known as placeholder text. It shares some characteristics of a real written text but is random or otherwise generated.</p> --}}
                </div>
                <!-- text - end -->

                <div class="grid grid-cols-2 gap-x-4 gap-y-8 md:grid-cols-3 lg:gap-x-8 lg:gap-y-12">
                    <!-- person - start -->
                    <div>
                        <div class="mb-2 h-48 overflow-hidden rounded-lg bg-gray-100 shadow-lg sm:mb-4 sm:h-60 md:h-80">
                            <img src="https://www.iyos.my.id/assets/yoa-rCbkOboG.png"
                                loading="lazy" alt="Photo by Radu Florin"
                                class="h-full w-full object-cover object-center" />
                        </div>

                        <div>
                            <div class="font-bold text-indigo-500 md:text-lg">Yos Sianipar</div>
                            <p class="mb-3 text-sm text-gray-500 md:mb-4 md:text-base">Programer</p>

                            <!-- social - start -->
                            <div class="flex">
                                <div class="flex gap-4">
                                    <a href="https://www.iyos.my.id/" target="_blank"
                                        class="text-gray-400 transition duration-100 hover:text-gray-500 active:text-gray-600">
                                        <svg class="h-6 w-6" width="24" height="24" viewBox="0 0 24 24"
                                            fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M9 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4H7Zm8-1a1 1 0 0 1 1-1h1v-1a1 1 0 1 1 2 0v1h1a1 1 0 1 1 0 2h-1v1a1 1 0 1 1-2 0v-1h-1a1 1 0 0 1-1-1Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </a>



                                </div>
                            </div>
                            <!-- social - end -->
                        </div>
                    </div>
                    <!-- person - end -->

                    <!-- person - start -->
                    <div>
                        <div class="mb-2 h-48 overflow-hidden rounded-lg bg-gray-100 shadow-lg sm:mb-4 sm:h-60 md:h-80">
                            <img src="https://rizkipgt.github.io/Portfolioku/assets/images/rizkim4.png"
                                loading="lazy" alt="Photo by christian ferrer"
                                class="h-full w-full object-cover object-center" />
                        </div>

                        <div>
                            <div class="font-bold text-indigo-500 md:text-lg">Rizky Pangestu</div>
                            <p class="mb-3 text-sm text-gray-500 md:mb-4 md:text-base">UI/UX</p>

                            <!-- social - start -->
                            <div class="flex">
                                <div class="flex gap-4">
                                    <a href="https://id.linkedin.com/in/rizki-pangestu" target="_blank"
                                    class="text-gray-400 transition duration-100 hover:text-gray-500 active:text-gray-600">
                                    <svg class="h-5 w-5" width="24" height="24" viewBox="0 0 24 24"
                                        fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                                    </svg>
                                </a>
                                </div>
                            </div>
                            <!-- social - end -->
                        </div>
                    </div>
                    <!-- person - end -->

                    <!-- person - start -->
                    <div>
                        <div class="mb-2 h-48 overflow-hidden rounded-lg bg-gray-100 shadow-lg sm:mb-4 sm:h-60 md:h-80">
                            <img src="https://raw.githubusercontent.com/ElikaDwiUtami/portfolio-photos/main/foto%20elika.jpg"
                                loading="lazy" alt="Photo by Ayo Ogunseinde"
                                class="h-full w-full object-cover object-center" />
                        </div>

                        <div>
                            <div class="font-bold text-indigo-500 md:text-lg">Elika</div>
                            <p class="mb-3 text-sm text-gray-500 md:mb-4 md:text-base">UI/UX</p>

                            <!-- social - start -->
                            <div class="flex">
                                <div class="flex gap-4">
                                    <a href="#" target="_blank"
                                        class="text-gray-400 transition duration-100 hover:text-gray-500 active:text-gray-600">
                                        <svg class="h-5 w-5" width="24" height="24" viewBox="0 0 24 24"
                                            fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                                        </svg>
                                    </a>

                                    <a href="#" target="_blank"
                                        class="text-gray-400 transition duration-100 hover:text-gray-500 active:text-gray-600">
                                        <svg class="h-5 w-5" width="24" height="24" viewBox="0 0 24 24"
                                            fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            <!-- social - end -->
                        </div>
                    </div>
                    <!-- person - end -->


                </div>
            </div>
        </div>

        <script>
            AOS.init();
        </script>

    </main>
</x-home-layout>
