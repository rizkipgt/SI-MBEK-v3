@php
    $settings = App\Models\SiteSetting::first();
@endphp
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<x-home-layout>
    <x-navbar-v2 />

    <div class="container mx-auto px-4 py-16 grid grid-cols-1 md:grid-cols-2 gap-12 items-start">
        <!-- Info Kontak -->
        <div>
            <h2 class="text-4xl font-bold text-gray-900 leading-tight">
                Hubungi Kami<br>
                Untuk Info Lebih Lanjut
            </h2>
            <p class="text-gray-600 text-lg mt-4">
                Hubungi kami dan beri tahu saya apa yang bisa saya bantu.<br>
                Isi formulir dan saya akan menghubungi Anda sesegera mungkin.
            </p>

            <div class="space-y-4 mt-8">
                <div class="flex items-start gap-3">
                    <div class="mt-1">
                        <svg class="w-5 h-5 text-brand-orange" ...>...</svg>
                    </div>
                    <div>
                        <p class="font-semibold text-brand-orange">Alamat</p>
                        <p class="text-gray-800 text-sm mt-1">
                            {{ $settings->contact['address'] ?? 'Seputih Raman, Lampung' }}</p>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <div class="mt-1">
                        <svg class="w-5 h-5 text-brand-orange" ...>...</svg>
                    </div>
                    <div>
                        <p class="font-semibold text-brand-orange">Telepon</p>
                        <p class="text-gray-800 text-sm mt-1">{{ $settings->contact['phone'] ?? '+62-xxx-xxxx-xxxx' }}
                        </p>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <div class="mt-1">
                        <svg class="w-5 h-5 text-brand-orange" ...>...</svg>
                    </div>
                    <div>
                        <p class="font-semibold text-brand-orange">Email</p>
                        <p class="text-gray-800 text-sm mt-1">
                            {{ $settings->contact['email'] ?? 'yangpunyausahambek@gmail.com' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulir Kontak -->
        <div class="bg-brand-orange text-white p-8 rounded-xl shadow-lg w-full">
            <form action="#" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block mb-1">Nama</label>
                    <input type="text" name="nama" placeholder="Nama"
                        value="{{ auth()->check() ? auth()->user()->name : '' }}"
                        class="w-full rounded-lg px-4 py-2 text-gray-900 focus:outline-none" />
                    @error('nama')
                        <p class="text-sm text-black mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block mb-1">Email</label>
                    <input type="email" name="email" placeholder="contoh@gmail.com"
                        value="{{ auth()->check() ? auth()->user()->email : '' }}"
                        class="w-full rounded-lg px-4 py-2 text-gray-900 focus:outline-none" />
                    @error('email')
                        <p class="text-sm text-black mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block mb-1">No. Telepon</label>
                    <input type="text" name="telepon" placeholder="Nomor Telepon"
                        value="{{ auth()->check() ? auth()->user()->no_telepon ?? '' : '' }}"
                        class="w-full rounded-lg px-4 py-2 text-gray-900 focus:outline-none" />
                    @error('telepon')
                        <p class="text-sm text-black mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block mb-1">Pesan</label>
                    <textarea name="pesan" rows="4" placeholder="Tulis pesan Anda..."
                        class="w-full rounded-lg px-4 py-2 text-gray-900 focus:outline-none"></textarea>
                    @error('pesan')
                        <p class="text-sm text-black mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit"
                    class="w-full bg-white text-black font-bold py-2 rounded-lg hover:bg-gray-100 transition">
                    KIRIM
                </button>
            </form>
        </div>
    </div>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#e58609',
                confirmButtonText: 'OK'
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                confirmButtonColor: '#d33',
                confirmButtonText: 'Coba Lagi'
            });
        </script>
    @endif

</x-home-layout>
