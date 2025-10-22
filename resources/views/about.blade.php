<x-home-layout>
    <x-navbar-v2 />

    <main class="mt-6 max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 mb-16">
        <div class="bg-white rounded-2xl shadow-md p-6 sm:p-10 md:p-12">
            @php
                $settings = App\Models\SiteSetting::first();
                $about = $settings->about_page ?? [];
            @endphp

            @if($about['active'] ?? true)
            <div class="text-center">
                <h1 class="text-4xl font-bold text-gray-800">{{ $about['title'] ?? 'Tentang Kami' }}</h1>
                <p class="mt-3 text-xl text-brand-orange font-semibold">{{ $about['subtitle'] ?? 'Raman Farm' }}</p>
            </div>

            <div class="mt-12 space-y-10 text-gray-700 text-justify">
                @foreach($about['sections'] ?? [] as $section)
                <section>
                    <h2 class="text-2xl font-semibold text-gray-800">{{ $section['title'] ?? '' }}</h2>
                    
                    @if(!empty($section['content']))
                    <div class="mt-4">
                        {!! nl2br(e($section['content'])) !!}
                    </div>
                    @endif
                    
                    @if(!empty($section['items']))
                    <ul class="mt-4 list-disc list-inside space-y-3">
                        @foreach((array)$section['items'] as $item)
                        <li>{!! $item !!}</li>
                        @endforeach
                    </ul>
                    @endif
                </section>
                @endforeach
            </div>
            @else
            <div class="text-center py-12">
                <p class="text-xl text-gray-600">Halaman Tentang Kami sedang tidak tersedia</p>
            </div>
            @endif
        </div>
    </main>
</x-home-layout>