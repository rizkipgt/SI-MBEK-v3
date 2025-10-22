@php
    use App\Models\Kambing;
    use App\Models\Domba;

    $kategoriProduk = request('kategori_produk', 'semua');
    $jenisList = [];
    $currentProduk = collect();

    if ($kategoriProduk === 'kambing') {
        $jenisList = Kambing::whereNotNull('type_goat')->distinct()->pluck('type_goat')->toArray();
        $currentProduk = $kambings;
    } elseif ($kategoriProduk === 'domba') {
        $jenisList = Domba::whereNotNull('type_domba')->distinct()->pluck('type_domba')->toArray();
        $currentProduk = $dombas;
    } else {
        // Gabungkan kambing dan domba untuk kategori "semua"
        $jenisList = array_merge(
            Kambing::whereNotNull('type_goat')->distinct()->pluck('type_goat')->toArray(),
            Domba::whereNotNull('type_domba')->distinct()->pluck('type_domba')->toArray(),
        );
        $currentProduk = $kambings->concat($dombas);
    }
@endphp

<x-home-layout>
    <x-navbar-v2 />

    <main class="max-w-7xl mx-auto mt-12 px-4">
        {{-- FILTER ATAS --}}
        @php
            $baseParams = request()->except('kategori_produk', 'jenis', 'page');
        @endphp

        <div class="flex flex-col lg:flex-row gap-6">
            {{-- SIDEBAR --}}
            <aside class="w-full lg:w-1/5">
                <div class="bg-white rounded-xl shadow p-4 sticky top-20">
                    <h2 class="text-lg font-bold mb-4">Etalase Toko ({{ $totalProduk }})</h2>
                    <ul class="space-y-2 text-gray-700 text-sm">
                        {{-- Semua Produk --}}
                        <li>
                            <a href="{{ url()->current() . '?' . http_build_query(array_merge($baseParams, ['kategori_produk' => 'semua'])) }}"
                                class="block px-3 py-2 rounded font-bold {{ $kategoriProduk === 'semua' ? 'bg-brand-orange text-white font-bold' : 'hover:bg-orange-50' }}">
                                Semua Produk
                            </a>
                        </li>
                        {{-- Kambing --}}
                        <li>
                            @php
                                // Ambil hanya jenis kambing yang ada stok for_sale = 'yes'
                                $jenisKambingList = Kambing::where('for_sale', 'yes')
                                    ->whereNotNull('type_goat')
                                    ->distinct()
                                    ->pluck('type_goat');
                                $isKambingActive =
                                    $kategoriProduk === 'kambing' ||
                                    ($kategoriProduk === 'kambing' && request('jenis')) ||
                                    ($kategoriProduk === 'kambing' && $jenisKambingList->contains(request('jenis')));
                            @endphp
                            <a href="{{ url()->current() . '?' . http_build_query(array_merge($baseParams, ['kategori_produk' => 'kambing'])) }}"
                                class="block px-3 py-2 rounded font-bold {{ $isKambingActive ? 'bg-brand-orange text-white font-bold' : 'hover:bg-orange-50' }}">
                                Kambing
                            </a>
                            {{-- Dropdown Jenis Kambing --}}
                            @if ($jenisKambingList->count())
                                <details class="group mt-1" {{ $isKambingActive && request('jenis') ? 'open' : '' }}>
                                    <summary class="cursor-pointer hover:text-brand-orange py-1 pl-4">
                                        Jenis Kambing
                                    </summary>
                                    <ul class="ml-6 mt-2 space-y-1 text-sm text-gray-600">
                                        @foreach ($jenisKambingList as $jenis)
                                            <li>
                                                <a href="{{ url()->current() . '?' . http_build_query(array_merge($baseParams, ['kategori_produk' => 'kambing', 'jenis' => $jenis])) }}"
                                                    class="block px-2 py-1 rounded {{ $kategoriProduk === 'kambing' && request('jenis') === $jenis ? 'bg-orange-100 text-brand-orange font-bold' : 'hover:bg-orange-50' }}">
                                                    {{ $jenis }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </details>
                            @endif
                        </li>
                        {{-- Domba --}}
                        <li>
                            @php
                                // Ambil hanya jenis domba yang ada stok for_sale = 'yes'
                                $jenisDombaList = Domba::where('for_sale', 'yes')
                                    ->whereNotNull('type_domba')
                                    ->distinct()
                                    ->pluck('type_domba');
                                $isDombaActive =
                                    $kategoriProduk === 'domba' ||
                                    ($kategoriProduk === 'domba' && request('jenis')) ||
                                    ($kategoriProduk === 'domba' && $jenisDombaList->contains(request('jenis')));
                            @endphp
                            <a href="{{ url()->current() . '?' . http_build_query(array_merge($baseParams, ['kategori_produk' => 'domba'])) }}"
                                class="block px-3 py-2 rounded font-bold {{ $isDombaActive ? 'bg-brand-orange text-white font-bold' : 'hover:bg-orange-50' }}">
                                Domba
                            </a>
                            {{-- Dropdown Jenis Domba --}}
                            @if ($jenisDombaList->count())
                                <details class="group mt-1" {{ $isDombaActive && request('jenis') ? 'open' : '' }}>
                                    <summary class="cursor-pointer hover:text-brand-orange py-1 pl-4">
                                        Jenis Domba
                                    </summary>
                                    <ul class="ml-6 mt-2 space-y-1 text-sm text-gray-600">
                                        @foreach ($jenisDombaList as $jenis)
                                            <li>
                                                <a href="{{ url()->current() . '?' . http_build_query(array_merge($baseParams, ['kategori_produk' => 'domba', 'jenis' => $jenis])) }}"
                                                    class="block px-2 py-1 rounded {{ $kategoriProduk === 'domba' && request('jenis') === $jenis ? 'bg-orange-100 text-brand-orange font-bold' : 'hover:bg-orange-50' }}">
                                                    {{ $jenis }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </details>
                            @endif
                        </li>
                    </ul>
                </div>
            </aside>
            {{-- KONTEN UTAMA --}}
            <section class="w-full lg:flex-1">
                <!-- Filter dan Search -->
                <form method="GET" class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                    <input type="hidden" name="kategori_produk" value="{{ request('kategori_produk', 'semua') }}">
                    @foreach (request()->except(['kategori_produk', 'sort', 'page', 'harga_min', 'harga_max']) as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach

                    <div class="flex gap-2 w-full md:w-2/3">

                        <input type="text" name="q" value="{{ request('q') }}"
                            class="w-full rounded border-gray-300 focus:ring-2 focus:ring-blue-500"
                            placeholder="Cari...">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-brand-orange text-white font-semibold rounded hover:bg-orange-700 transition">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <circle cx="11" cy="11" r="8" />
                                <line x1="21" y1="21" x2="16.65" y2="16.65" />
                            </svg>
                        </button>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-2 w-full md:w-auto items-center">
                        <select name="sort" onchange="this.form.submit()"
                            class="rounded border-gray-300 focus:ring-2 focus:ring-blue-500 w-full sm:w-auto">
                            <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Terbaru
                            </option>
                            <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Terlama
                            </option>
                            <option value="price_low" {{ request('sort') === 'price_low' ? 'selected' : '' }}>Harga
                                Terendah
                            </option>
                            <option value="price_high" {{ request('sort') === 'price_high' ? 'selected' : '' }}>Harga
                                Tertinggi
                            </option>
                        </select>
                        <div
                            class="flex items-center gap-1 bg-gray-50 px-2 py-1 rounded border border-gray-200 w-full sm:w-auto min-w-0">
                            <label class="text-gray-500 text-sm whitespace-nowrap">Harga</label>
                            <input type="text" name="harga_min" value="{{ request('harga_min') }}"
                                class="flex-1 min-w-0 rounded border-gray-300 focus:ring-2 focus:ring-blue-500 px-2"
                                placeholder="Min" pattern="[0-9]*" inputmode="numeric"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                            <span class="text-gray-400">-</span>
                            <input type="text" name="harga_max" value="{{ request('harga_max') }}"
                                class="flex-1 min-w-0 rounded border-gray-300 focus:ring-2 focus:ring-blue-500 px-2"
                                placeholder="Max" pattern="[0-9]*" inputmode="numeric"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        </div>
                    </div>
                </form>
                @if ($errors->has('harga_min'))
                    <div class="w-full md:w-auto mb-4">
                        <div
                            class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded text-sm flex items-center gap-2">
                            <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"
                                    fill="none" />
                                <line x1="12" y1="8" x2="12" y2="12" stroke="currentColor"
                                    stroke-width="2" />
                                <circle cx="12" cy="16" r="1" fill="currentColor" />
                            </svg>
                            {{ $errors->first('harga_min') }}
                        </div>
                    </div>
                @endif

                <!-- Grid Produk -->
                <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-6">
                    @forelse($currentProduk as $produk)
                        @php
                            $isPending = \App\Models\Order::isProductPending($produk->id);
                        @endphp

                        <div class="bg-white border rounded-xl shadow-sm hover:shadow-md transition overflow-hidden 
                            {{ $isPending ? 'opacity-75' : '' }}">
                            <div class="aspect-[4/3] overflow-hidden">
                                <img src="{{ $produk->image ? asset($produk->image) : asset('uploads/default.png') }}"
                                    alt="{{ $produk->name }}" class=" w-full h-full object-cover">
                            </div>
                            <div class="p-3">
                                <h3 class="font-medium text-sm text-gray-800 truncate mb-2">
                                    {{ $produk->name ?? ucfirst($kategoriProduk) }}
                                </h3>
                                <p class="text-xs text-gray-500 mb-1">Jenis:
                                    @if (isset($produk->type_goat))
                                        {{ $produk->type_goat ?? '-' }}
                                    @elseif (isset($produk->type_domba))
                                        {{ $produk->type_domba ?? '-' }}
                                    @else
                                        -
                                    @endif
                                </p>
                                <p class="text-xs text-gray-500 mb-2">
                                    Berat: {{ $produk->weight_now ? $produk->weight_now . ' kg' : '-' }}
                                </p>
                                <p class="text-sm font-semibold text-gray-900 mt-1">
                                    Rp{{ number_format($produk->harga ?? 0, 0, ',', '.') }}
                                </p>
                                <div class="flex items-center text-sm gap-1.5 text-gray-600 mt-2">
                                    @if (($produk->jenis_kelamin ?? null) === 'Jantan')
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-gender-male" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                d="M9.5 2a.5.5 0 0 1 0-1h5a.5.5 0 0 1 .5.5v5a.5.5 0 0 1-1 0V2.707L9.871 6.836a5 5 0 1 1-.707-.707L13.293 2zM6 6a4 4 0 1 0 0 8 4 4 0 0 0 0-8" />
                                        </svg>
                                        <p>{{ $produk->jenis_kelamin ?? '-' }}</p>
                                    @elseif (($produk->jenis_kelamin ?? null) === 'Betina')
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-gender-female" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                d="M8 1a4 4 0 1 0 0 8 4 4 0 0 0 0-8M3 5a5 5 0 1 1 5.5 4.975V12h2a.5.5 0 0 1 0 1h-2v2.5a.5.5 0 0 1-1 0V13h-2a.5.5 0 0 1 0-1h2V9.975A5 5 0 0 1 3 5" />
                                        </svg>
                                        <p>{{ $produk->jenis_kelamin ?? '-' }}</p>
                                    @else
                                        <p>-</p>
                                    @endif
                                </div>
                                @if($isPending)
                                    <div class="mt-3">
                                        <button disabled 
                                            class="w-full text-center text-sm px-3 py-1.5 rounded bg-orange-100 text-gray-600 cursor-not-allowed">
                                            Sedang Diproses
                                        </button>
                                    </div>
                                @else
                                    <div class="mt-3">
                                        <a href="{{ route('order.show', [
                                            'category' => isset($produk->type_goat) ? 'kambing' : (isset($produk->type_domba) ? 'domba' : 'produk'),
                                            'id' => $produk->id,
                                        ]) }}"
                                            class="block text-center text-white text-sm bg-brand-orange hover:bg-orange-700 px-3 py-1.5 rounded">
                                            Beli
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center text-gray-500 py-10">
                            Tidak ada produk ditemukan.
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="mt-10 flex justify-center p-4">
                    @if ($kategoriProduk === 'kambing')
                        {{ $kambings->appends(request()->query())->links() }}
                    @elseif ($kategoriProduk === 'domba')
                        {{ $dombas->appends(request()->query())->links() }}
                    @else
                        @if ($kambings->count() > 0)
                            {{ $kambings->appends(request()->query())->links() }}
                            <!-- Tampilkan pagination untuk kambing -->
                        @endif
                        @if ($dombas->count() > 0)
                            {{ $dombas->appends(request()->query())->links() }}
                            <!-- Tampilkan pagination untuk domba -->
                        @endif
                    @endif
                </div>
            </section>
        </div>
    </main>
    <script>
        function clearJenisAndSubmit(selectElement) {
            const form = selectElement.form;
            const jenisInput = form.querySelector('input[name="jenis"]');
            if (jenisInput) jenisInput.remove();
            form.submit();
        }
    </script>
</x-home-layout>
