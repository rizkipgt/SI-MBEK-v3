<x-home-layout>
    <x-navbar-v2/>

    <main class="mt-12 max-w-[70rem] mx-auto my-10">
        <!-- Hero -->
        <h1 class="text-center p-8 text-3xl font-semibold text-gray-800">
            Berikut ini adalah List Kambing Sedang Dijual
        </h1>
        <!-- End Hero -->

        {{-- SALE KAMBING --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6 p-4">
            @forelse($kambings as $kambing)
            <div class="flex flex-col bg-cyan-700 border shadow-sm rounded-xl text-white dark:border-neutral-700 dark:shadow-neutral-700/70">
                <div class="aspect-[4/3] w-full overflow-hidden rounded-t-xl">
                    <img class="w-full h-full object-cover"
                    src="{{ $kambing->image ? asset($kambing->image) : asset('uploads/default.png') }}"
                    alt="Gambar Kambing {{ $kambing->name }}">
                </div>
                <div class="p-4 md:p-5">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white">Nama Kambing : {{ $kambing->name }}</h3>
                    <div class="mt-2">
                        <p><strong>Pemilik :</strong> {{ $kambing->user->name}}</p>
                        <p><strong>Umur :</strong> {{ $kambing->age_now }} Bulan</p>
                        <p><strong>Jenis :</strong> {{ $kambing->type_goat }}</p>
                        <p><strong>Berat :</strong> {{ $kambing->weight_now }} kg</p>
                        <p><strong>Status Vaksin:</strong> {{ $kambing->faksin_status }}</p>
                        <p><strong>Status Kesehatan :</strong> {{ $kambing->healt_status }}</p>
                        <p><strong>Harga : Rp {{ number_format($kambing->harga, 0, ',', '.') }}</p>
                    </div>
                        <hr class="border-gray-300 my-4">
                        <a href="{{ route('order.show', $kambing->id) }}" class="mt-4 inline-block py-2 px-4 text-center bg-white text-black font-medium rounded-lg hover:bg-blue-700">
                            Beli
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-1 md:col-span-2 lg:col-span-2 text-center p-8">
                    <p class="text-xl text-gray-600">Tidak ada kambing yang sedang dijual saat ini.</p>
                </div>
            @endforelse
        </div>
        {{-- END SALE KAMBING --}}
    </main>
</x-home-layout>
