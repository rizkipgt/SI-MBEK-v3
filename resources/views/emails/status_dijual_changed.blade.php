@php
    $settings = App\Models\SiteSetting::first();
@endphp

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Perubahan {{ $jenisHewan }}</title>
</head>

<body style="margin:0; padding:0; background-color:#FEF1DC; font-family:sans-serif;">
    <div
        style="max-width:600px; margin:40px auto; background-color:#ffffff; border-radius:20px; overflow:hidden; box-shadow:0 4px 10px rgba(0,0,0,0.1);">
        <div style="padding:30px; background-color:#FFF7EC; border-bottom:1px solid #fcd9a7;">
            <div style="display:flex; align-items:center; margin-bottom:15px;">
                <img src="{{ $settings->site_logo ? asset('storage/'.$settings->site_logo) : asset('logo/logosiembek.png') }}"
                    alt="Logo SI MBEK" style="height:32px; margin-right:10px;">
                <h1 style="font-size:20px; font-weight:bold; color:#E28700; margin:0;">
                    {{ e($settings->site_name ?? 'SI MBEK') }}
                </h1>
            </div>

            @if($statusBerubah)
            <h2 style="font-size:22px; font-weight:800; color:#333333; margin:0 0 10px;">
                Perubahan Status {{ $jenisHewan }}
            </h2>
            @else
            <h2 style="font-size:22px; font-weight:800; color:#333333; margin:0 0 10px;">
                Perubahan Harga {{ $jenisHewan }}
            </h2>
            @endif

            <p style="color:#444444; margin:0 0 15px; font-size: 14px;">
                Halo {{ e($user->name ?? 'Pengguna') }},
            </p>

            @if($statusBerubah)
            <p style="color:#444444; margin:0 0 20px; font-size: 14px;">
                Status dijual untuk {{ strtolower($jenisHewan) }} Anda telah diubah.
            </p>
            @else
            <p style="color:#444444; margin:0 0 20px; font-size: 14px;">
                Harga untuk {{ strtolower($jenisHewan) }} Anda yang dijual telah diubah.
            </p>
            @endif

            <div style="background-color:#FFF7EC; border-radius:12px; padding:20px; margin:20px 0; border:1px solid #fcd9a7; box-shadow:0 2px 8px rgba(0, 0, 0, 0.05);">
                <div style="display:flex; margin-bottom:12px; padding-bottom:12px; border-bottom:1px dashed #fcd9a7;">
                    <span style="font-weight:600; min-width:120px; color:#E28700; font-size:14px;">Nama
                        {{ $jenisHewan }}:</span>
                    <span style="flex:1; font-size:14px;">{{ $hewan->name }}</span>
                </div>

                <div style="display:flex; margin-bottom:12px; padding-bottom:12px; border-bottom:1px dashed #fcd9a7;">
                    <span style="font-weight:600; min-width:120px; color:#E28700; font-size:14px;">ID
                        {{ $jenisHewan }}:</span>
                    <span style="flex:1; font-size:14px;">{{ $hewan->id }}</span>
                </div>

                @if($statusBerubah)
                <div style="display:flex; margin-bottom:12px; padding-bottom:12px; border-bottom:1px dashed #fcd9a7;">
                    <span style="font-weight:600; min-width:120px; color:#E28700; font-size:14px;">Status
                        Lama:</span>
                    <span style="flex:1; font-size:14px;">
                        <span
                            style="display:inline-block; padding:4px 10px; border-radius:16px; font-weight:600; font-size:12px; background-color:{{ $oldStatus == 'yes' ? '#dcfce7' : '#fee2e2' }}; color:{{ $oldStatus == 'yes' ? '#166534' : '#b91c1c' }};">
                            {{ $oldStatus == 'yes' ? 'Ya' : 'Tidak' }}
                        </span>
                    </span>
                </div>

                <div style="display:flex; margin-bottom:12px; padding-bottom:12px; border-bottom:1px dashed #fcd9a7;">
                    <span style="font-weight:600; min-width:120px; color:#E28700; font-size:14px;">Status
                        Baru:</span>
                    <span style="flex:1; font-size:14px;">
                        <span
                            style="display:inline-block; padding:4px 10px; border-radius:16px; font-weight:600; font-size:12px; background-color:{{ $newStatus == 'yes' ? '#dcfce7' : '#fee2e2' }}; color:{{ $newStatus == 'yes' ? '#166534' : '#b91c1c' }};">
                            {{ $newStatus == 'yes' ? 'Ya' : 'Tidak' }}
                        </span>
                    </span>
                </div>
                @endif

                @if($hargaBerubah)
                <div style="display:flex; margin-bottom:12px; padding-bottom:12px; border-bottom:1px dashed #fcd9a7;">
                    <span style="font-weight:600; min-width:120px; color:#E28700; font-size:14px;">Harga
                        Lama:</span>
                    <span style="flex:1; font-size:18px; font-weight:bold; color:#E28700;">Rp
                        {{ number_format($oldHarga, 0, ',', '.') }}</span>
                </div>

                <div style="display:flex; margin-bottom:12px; padding-bottom:12px; border-bottom:1px dashed #fcd9a7;">
                    <span style="font-weight:600; min-width:120px; color:#E28700; font-size:14px;">Harga
                        Baru:</span>
                    <span style="flex:1; font-size:18px; font-weight:bold; color:#E28700;">Rp
                        {{ number_format($newHarga, 0, ',', '.') }}</span>
                    <span
                        style="display:inline-block; padding:3px 8px; border-radius:12px; font-size:12px; margin-left:8px; vertical-align:middle; background-color:{{ $newHarga > $oldHarga ? '#dcfce7' : '#fee2e2' }}; color:{{ $newHarga > $oldHarga ? '#166534' : '#b91c1c' }};">
                        {{ $newHarga > $oldHarga ? '↑ Naik' : '↓ Turun' }}
                        Rp {{ number_format(abs($newHarga - $oldHarga), 0, ',', '.') }}
                    </span>
                </div>

                <div
                    style="background-color:#FFF0D9; border-left:4px solid #E28700; padding:12px; border-radius:0 8px 8px 0; margin:15px 0;">
                    <p style="color:#444444; margin-bottom:6px; font-size: 13px;">Perubahan harga ini berlaku efektif
                        sejak email ini dikirimkan.</p>
                    <p style="color:#444444; margin-bottom:0; font-size: 13px;">Jika Anda memiliki pertanyaan tentang
                        perubahan harga, silakan hubungi tim kami.</p>
                </div>
                @endif

                @if($newStatus == 'yes' && !$hargaBerubah)
                <div style="display:flex; margin-bottom:12px; padding-bottom:12px; border-bottom:1px dashed #fcd9a7;">
                    <span style="font-weight:600; min-width:120px; color:#E28700; font-size:14px;">Harga:</span>
                    <span style="flex:1; font-size:18px; font-weight:bold; color:#E28700;">Rp
                        {{ number_format($hewan->harga, 0, ',', '.') }}</span>
                </div>
                @endif
            </div>

            <p style="color:#444444; margin-bottom:15px; font-size: 14px;">Anda dapat melihat detail
                {{ strtolower($jenisHewan) }} di aplikasi kami.</p>

            <div style="text-align:center; margin:25px 0;">
                <a href="{{ route('dashboard') }}"
                    style="background-color:#E28700; color:#ffffff; padding:10px 20px; border-radius:8px; text-decoration:none; font-weight:bold; font-size: 14px;">
                    Lihat Detail {{ $jenisHewan }}
                </a>
            </div>

            <hr style="border:none; border-top:1px solid #fcd9a7; margin:15px 0;">

            <p style="color:#444444; margin-bottom:8px; font-size: 13px;">Jika Anda memiliki pertanyaan atau
                membutuhkan bantuan, jangan ragu untuk menghubungi tim dukungan kami melalui:</p>
            <ul style="color:#444444; margin-bottom:15px; padding-left:20px; font-size: 13px;">
                <li style="margin-bottom:3px;">Email: {{ $settings->contact['email'] ?? 'yangpunyausahambek@gmail.com' }}</li>
                <li style="margin-bottom:3px;">Telepon: {{ $settings->contact['phone'] ?? '+62-xxx-xxxx-xxxx' }}</li>
            </ul>
        </div>

        <div style="padding:15px; text-align:center; font-size:11px; color:#aaaaaa;">
            &copy; {{ date('Y') }} {{ e($settings->site_name ?? 'SI MBEK') }}. All rights reserved.
        </div>
    </div>
</body>

</html>