@php
    $settings = App\Models\SiteSetting::first();
    $hero = data_get($settings->sections, 'hero', []);
@endphp
<x-home-layout>
    <x-navbar-v2 />

    {{-- Section 1 - Hero --}}
    @php
        $hero = data_get($settings->sections, 'hero', []);
    @endphp
    @if (data_get($hero, 'active', true))
        @if (data_get($hero, 'active', true))
            <div class="bg-orange-100 min-h-screen flex items-center py-16 px-4 sm:px-6">
                <div class="max-w-6xl mx-auto w-full">
                    <div class="flex flex-col md:flex-row items-center gap-8 md:gap-12">
                        {{-- Image Section (Left) --}}
                        <div class="md:w-1/2 w-full">
                            <div class="relative max-w-xl mx-auto">
                                <div class="relative z-10">
                                    <div class="w-full max-w-xs sm:max-w-sm md:max-w-md bg-orange-300 aspect-square rounded-full overflow-hidden border-1 shadow-xl mx-auto">
                                        <img src="{{ \Storage::url(data_get($hero, 'image', 'logo/kambing6 1.png')) }}"
                                            alt="Hero Image"
                                            class="w-full h-full object-cover object-center transform translate-y-8">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Text Content (Right) --}}
                        <div class="md:w-1/2 w-full space-y-6 text-center md:text-left">
                            <h1 class="text-4xl md:text-5xl font-bold text-gray-800">
                                {{ $hero['title'] ?? 'Raman Farm' }}
                            </h1>

                            <p class="text-xl md:text-2xl text-gray-800 font-semibold" style="margin-top: 0rem">
                                {{ $hero['subtitle'] ?? 'Pantau Pertumbuhan, Tingkatkan Produktivitas' }}
                            </p>

                            <p class="text-gray-600 text-lg md:text-xl leading-relaxed max-w-lg mx-auto md:mx-0">
                                {{ $hero['description'] ??
                                    "Selamat datang di website Sistem Informasi
                                Monitoring Pembesaran Kambing Raman Farm
                                di Desa Rukti Endah–Seputih Raman." }}
                            </p>

                            <div class="mt-6">
                                <a href="{{ $hero['button_url'] ?? '/about' }}"
                                    class="inline-flex items-center bg-brand-orange text-white px-8 py-3 rounded-full hover:bg-orange-700 transition-all duration-300 text-lg font-semibold shadow-md gap-2">
                                    {{ $hero['button_text'] ?? 'Selengkapnya' }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif
    

    {{-- Section 2 - Why --}}
    @php
        $why = data_get($settings->sections, 'why', []);
        $whyDefaults = [
            'heading' => 'Mengapa Si Mbek?',
            'items' => [
                [
                    'title' => 'Pantau Pertumbuhan dengan Mudah',
                    'description' =>
                        'Dengan Si Mbek, Anda dapat memantau berat badan, kesehatan, dan perkembangan kambing secara real-time. Data tersimpan aman dan mudah diakses.',
                ],
                [
                    'title' => 'Pelatihan dan Pendampingan',
                    'description' =>
                        'Tim ahli kami akan mendampingi dan melatih peternak dalam penggunaan sistem secara optimal.',
                ],
                [
                    'title' => 'Evaluasi Berkala',
                    'description' => 'Sistem evaluasi terintegrasi untuk terus meningkatkan kualitas layanan kami.',
                ],
            ],
            'images' => [
                'pageimage/kambing2.jpeg',
                'pageimage/depan-raman.jpeg',
                'pageimage/kambing3.jpeg',
                'pageimage/kambing4.jpeg',
            ],
        ];
        $why = array_merge($whyDefaults, $why);
    @endphp
    @if (data_get($why, 'active', true))
        <div class="bg-white-50 w-full py-16 px-4 sm:px-6">
            <div class="max-w-6xl mx-auto">
                <div class="flex flex-col md:flex-row gap-8 md:gap-12">
                    {{-- Left Text --}}
                    <div class="md:w-1/2 space-y-8">
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-800">
                            {{ data_get($why, 'heading') }}
                        </h2>
                        <div class="space-y-6">
                            @foreach (data_get($why, 'items', []) as $idx => $item)
                                <div class="flex gap-4">
                                    <div class="flex-shrink-0">
                                        <div
                                            class="w-10 h-10 bg-brand-orange rounded-full flex items-center justify-center text-white font-bold">
                                            {{ $idx + 1 }}
                                        </div>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $item['title'] }}</h3>
                                        <p class="text-gray-600">{{ $item['description'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Right Images --}}
                    <div class="md:w-1/2">
                        <div class="grid grid-cols-2 gap-4">
                            @foreach (data_get($why, 'images', []) as $img)
                                <div class="aspect-square rounded-xl overflow-hidden shadow-lg">
                                    <img src="{{ \Storage::url($img) }}" alt="Why Image"
                                        class="w-full h-full object-cover hover:scale-105 transition duration-300">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Section 3 - CTA --}}
    @php
        $cta = data_get($settings->sections, 'cta', []);
        $ctaDefaults = [
            'heading' => 'Bergabung Dengan Si Mbek',
            'subheading' =>
                'Mulailah perjalanan Anda menuju peternakan yang lebih modern dan produktif. Daftarkan diri Anda sekarang dan rasakan manfaatnya!',
            'button_text' => 'DAFTAR SEKARANG',
            'button_url' => route('login'),
        ];
        $cta = array_merge($ctaDefaults, $cta);
    @endphp
    @if (data_get($cta, 'active', true))
        <div class="bg-orange-100 w-full py-16 px-4 sm:px-6">
            <div class="max-w-4xl mx-auto">
                <div class="bg-orange-50 rounded-2xl shadow-xl p-8 md:p-12 text-center">
                    <div class="max-w-3xl mx-auto space-y-6">
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-800">{{ data_get($cta, 'heading') }}</h2>
                        <p class="text-gray-600 text-lg md:text-xl leading-relaxed">{{ data_get($cta, 'subheading') }}
                        </p>
                        <div class="mt-8">
                            @guest
                                <a href="{{ route('register') }}"
                                    class="inline-flex items-center bg-brand-orange text-white px-8 py-4 
                  rounded-full hover:bg-orange-700 transition-all duration-300 
                  text-lg font-semibold shadow-lg hover:shadow-xl gap-3">
                                    DAFTAR SEKARANG
                                </a>
                            @else
                                <a href="{{ route('dashboard') }}"
                                    class="inline-flex items-center bg-brand-orange text-white px-8 py-4 
                  rounded-full hover:bg-orange-700 transition-all duration-300 
                  text-lg font-semibold shadow-lg hover:shadow-xl gap-3">
                                    MASUK KE DASHBOARD
                                </a>
                            @endguest
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Section 4 - Informasi Kambing --}}
    @php
        $info = data_get($settings->sections, 'info', []);
        $infoDefaults = [
            'title' => 'Informasi Kambing',
            'subtitle' =>
                'Pelajari lebih lanjut tentang jenis-jenis kambing, vaksin yang diperlukan, dan cara merawat mereka dengan baik untuk kesehatan yang optimal.',
            'boxes' => [
                [
                    'title' => 'Jenis-jenis Kambing',
                    'content' =>
                        '<ul class="list-disc pl-5"><li>Kambing Peranakan Etawa (PE): Kambing unggul untuk diambil susunya.</li><li>Kambing Boer: Kambing pedaging dengan pertumbuhan cepat.</li><li>Kambing Skeang: Kambing lokal yang tahan kondisi iklim.</li><li>Kambing Saaren: Kambing perah dengan produksi susu tinggi.</li></ul>',
                ],
                [
                    'title' => 'Vaksin Wajib',
                    'content' =>
                        '<ul class="list-disc pl-5"><li>Enterotoxemia: Mencegah penyakit pencernaan.</li><li>Tetanus: Proteksi setelah prosedur bedah.</li><li>Vaksin CCPP: Melindungi kambing dari penyakit paru-paru yang serius.</li><li>Foot-and-Mouth Disease (FMD): Cegah penyakit mulut dan kuku.</li></ul>',
                ],
                [
                    'title' => 'Perawatan Kambing',
                    'content' =>
                        '<ul class="list-disc pl-5"><li>Kebersihan Kandang: Ventilasi dan pencahayaan memadai.</li><li>Pakan Berkualitas: Kombinasi rumput, jerami, dan konsentrat.</li><li>Check-up Rutin: Pemeriksaan kesehatan berkala oleh dokter hewan.</li></ul>',
                ],
                [
                    'title' => 'Tips Penting',
                    'content' =>
                        '<ul class="list-disc pl-5"><li>Pilih bibit dengan genetika unggul.</li><li>Manajemen pakan sesuai usia dan kebutuhan.</li><li>Vaksinasi rutin untuk pencegahan penyakit.</li></ul>',
                ],
            ],
        ];
        $info = array_merge($infoDefaults, $info);
    @endphp
    @if (data_get($info, 'active', true))
        <div class="bg-gray-50">
            <div class="max-w-6xl mx-auto">
                <div class="p-8 md:p-12">
                    <div class="text-center mb-8">
                        <h2 class="text-3xl font-bold text-gray-800 mb-2">{{ data_get($info, 'title') }}</h2>
                        <p class="text-gray-500">{!! data_get($info, 'subtitle') !!}</p>
                    </div>
                    <div class="grid md:grid-cols-2 gap-8">
                        @foreach (data_get($info, 'boxes', []) as $box)
                            <div class="bg-orange-50 shadow-lg p-6 rounded-xl">
                                <div class="mb-6">
                                    <h3 class="font-bold text-gray-800 mb-3">{{ $box['title'] }}</h3>
                                    <div class="text-gray-600">{!! $box['content'] !!}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (session('status') === 'account-deleted')
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Akun Dihapus!',
            text: 'Akun Anda berhasil dihapus dari sistem.',
            timer: 3000,
            showConfirmButton: false
        });
    </script>
@endif
</x-home-layout>