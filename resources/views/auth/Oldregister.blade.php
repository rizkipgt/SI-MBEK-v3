<x-guest-layout>
    <div class="w-full bg-gray-100 min-h-sreen bg-no-repeat bg-cover bg-center relative">
        <div class="min-h-screen p-4 mx-auto bcg-white ">
           <div class="mx-auto md:max-w-md mb-6 justify-center bg-orange-700 rounded-md text-white text-center ">
            {{-- <img class="w-24 justify-center" src="{{ asset('logo/logosiembek.png') }}"/> --}}

            <h1 class="capitalize p-5 ">Registrasi simbek</h1>
           </div>
            <div class="md:max-w-md bg-white m-auto p-4 rounded-md">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                            :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div class="mt-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                            :value="old('email')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    <div class="mt-4">
                        <x-input-label for="alamat" :value="__('Alamat')" />
                        <x-text-input id="alamat" class="block mt-1 w-full" type="text" name="alamat"
                            :value="old('alamat')" required autofocus autocomplete="alamat" />
                        <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                    </div>
                    <div class="mt-4">
                        <x-input-label for="no_telepon" :value="__('No Telepon')" />
                        <x-text-input id="no_telepon" class="block mt-1 w-full" type="number" name="no_telepon"
                            :value="old('no_telepon')" required autofocus autocomplete="no_telepon" />
                        <x-input-error :messages="$errors->get('no_telepon')" class="mt-2" />
                    </div>


                    <!-- Password -->
                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Password')" />

                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                            autocomplete="new-password" />

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mt-4">
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                        <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                            name="password_confirmation" required autocomplete="new-password" />

                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            href="{{ route('login') }}">
                            {{ __('Sudah punya akun?') }}
                        </a>

                        <x-primary-button class="ms-4">
                            {{ __('Register') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
