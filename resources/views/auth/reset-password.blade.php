@php
    $settings = \App\Models\SiteSetting::first();
@endphp

<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-[#FEF1DC] px-4">
        <div class="w-full max-w-md bg-white shadow-lg rounded-[20px] p-8 md:p-10 ring-1 ring-orange-200">
            <!-- Header -->
            <div class="flex items-center justify-center mb-6">
                <img src="{{ $settings && $settings->site_logo ? asset('storage/' . $settings->site_logo) : asset('logo/logosiembek.png') }}"
                     alt="Logo SI MBEK" class="h-10 me-2">
                <span class="font-bold text-xl text-[#E28700]">{{ $settings->site_name ?? 'SI MBEK' }}</span>
            </div>

            <h2 class="text-2xl font-extrabold text-center text-gray-800 mb-6">Reset Kata Sandi</h2>

            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                <!-- Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email -->
                <div class="mb-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="mt-1 block w-full border-[#E28700] focus:ring-orange-400 focus:border-orange-400"
                                  type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- New Password -->
                <div class="mb-4">
                    <x-input-label for="password" :value="__('Kata Sandi Baru')" />
                    <x-text-input id="password" class="mt-1 block w-full border-[#E28700] focus:ring-orange-400 focus:border-orange-400"
                                  type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mb-6">
                    <x-input-label for="password_confirmation" :value="__('Konfirmasi Kata Sandi')" />
                    <x-text-input id="password_confirmation" class="mt-1 block w-full border-[#E28700] focus:ring-orange-400 focus:border-orange-400"
                                  type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Submit -->
                <div>
                    <button type="submit"
                            class="w-full py-2 px-4 bg-brand-orange hover:bg-orange-700 text-white rounded-md font-semibold shadow-sm">
                        Reset Kata Sandi
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
