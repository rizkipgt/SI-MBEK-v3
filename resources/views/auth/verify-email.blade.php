@php
    $settings = App\Models\SiteSetting::first();
@endphp
<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-[#FEF1DC] px-4">
        <div class="flex flex-col md:flex-row bg-white shadow-lg rounded-[20px] overflow-hidden w-full max-w-4xl">
            <!-- Left: Verify Email Content -->
            <div class="w-full md:w-1/2 p-8 md:p-10 bg-[#FFF7EC] shadow-xl rounded-b-[20px] md:rounded-[20px_0_0_20px] ring-1 ring-orange-200">
                <!-- Logo & Title -->
  
                <div class="flex items-center mb-6">
                <img class="h-8 w-8 me-2" 
                     src="{{ $settings->site_logo ? asset('storage/'.$settings->site_logo) : asset('logo/logosiembek.png') }}" 
                     alt="Site Logo">
                
                <!-- Dynamic Site Name -->
                <span class="font-bold text-lg">
                    {{ $settings->site_name ?? 'SI MBEK' }}
                </span>
                </div>

                <h2 class="text-2xl md:text-3xl font-extrabold text-gray-800 mb-4">Verifikasi Email</h2>

                <div class="mb-4 text-sm text-gray-600">
                    Terima kasih telah mendaftar! Sebelum memulai, silakan verifikasi email Anda dengan mengklik tautan yang telah kami kirim ke email Anda.
                    Jika belum menerima email tersebut, kami dengan senang hati akan mengirim ulang.
                </div>

                @if (session('status') == 'verification-link-sent')
                    <div class="mb-4 font-medium text-sm text-green-600">
                        Tautan verifikasi baru telah dikirim ke alamat email Anda.
                    </div>
                @endif

                <div class="mt-4 flex items-center justify-between">
                    <!-- Resend Verification -->
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <x-primary-button>
                            {{ __('Kirim Ulang Email Verifikasi') }}
                        </x-primary-button>
                    </form>

                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                            {{ __('logout') }}
                        </button>
                    </form>
                </div>
            </div>

            <!-- Right: Goat Image -->
            <div class="hidden md:flex relative bg-[#FFF3E4] p-10 items-center justify-center w-full md:w-1/2">
                <!-- Lingkaran orange -->
                <div class="w-48 md:w-64 h-48 md:h-64 bg-orange-300 rounded-full shadow-xl relative z-10"></div>

                <!-- Gambar kambing PNG keluar dari lingkaran -->
                <img src="{{ asset('logo/kambing6 1.png') }}" 
                     alt="Kambing Raman Farm" 
                     class="absolute w-52 md:w-80 h-auto z-20 -translate-y-4 md:-translate-y-6" />
            </div>
        </div>
    </div>
</x-guest-layout>
