<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-[#FEF1DC] px-4 py-8">
        <!-- Container -->
        <main class="w-full max-w-md bg-white rounded-xl shadow-lg ring-1 ring-orange-200 p-6">
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Title -->
            <div class="text-center">
                <h1 class="text-2xl font-bold text-gray-800">Lupa Kata Sandi?</h1>
                <p class="mt-2 text-sm text-gray-600">
                    Sudah ingat kata sandi Anda?
                    <a href="{{ route('login') }}" class="text-[#E28700] hover:underline font-medium">
                        Masuk di sini
                    </a>
                </p>
            </div>

            <!-- Form -->
            <div class="mt-6">
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="space-y-4">
                        <!-- Email -->
                        <div>
                            <x-input-label for="email" :value="__('Email')" class="text-sm" />
                            <input
                                id="email"
                                name="email"
                                type="email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                placeholder="Masukkan email Anda"
                                class="mt-1 block w-full text-sm py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-orange-400 focus:border-orange-400 transition"
                            />
                            <x-input-error :messages="$errors->get('email')" class="mt-1 text-sm text-red-500" />
                        </div>

                        <!-- Submit -->
                        <button
                            type="submit"
                            class="w-full py-2.5 px-4 flex justify-center items-center rounded-md font-semibold text-white bg-brand-orange hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-[#E28700] focus:ring-offset-1 transition text-sm"
                        >
                            Kirim Tautan Reset Kata Sandi
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</x-guest-layout>