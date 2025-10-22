@php
    $settings = App\Models\SiteSetting::first();
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pesan Kontak dari {{ $nama }}</title>
</head>
<body style="margin:0; padding:0; background-color:#FEF1DC; font-family:sans-serif;">
    <div style="max-width:600px; margin:40px auto; background-color:#ffffff; border-radius:20px; overflow:hidden; box-shadow:0 4px 10px rgba(0,0,0,0.1);">
        <div style="padding:30px; background-color:#FFF7EC; border-bottom:1px solid #fcd9a7;">
            <div style="display:flex; align-items:center; margin-bottom:15px;">
                <img src="{{ $settings->site_logo ? asset('storage/'.$settings->site_logo) : asset('logo/logosiembek.png') }}"
                    alt="Logo SI MBEK" style="height:32px; margin-right:10px;">
                <h1 style="font-size:20px; font-weight:bold; color:#E28700; margin:0;">
                    {{ e($settings->site_name ?? 'SI MBEK') }}
                </h1>
            </div>
            <h2 style="font-size:22px; font-weight:800; color:#333333; margin:0 0 10px;">
                Pesan Kontak Baru
            </h2>
            <p style="color:#444444; margin:0 0 15px; font-size: 14px;">
                Anda menerima pesan baru dari formulir kontak SI MBEK.
            </p>
            <div style="background-color:#FFF7EC; border-radius:12px; padding:20px; margin:20px 0; border:1px solid #fcd9a7; box-shadow:0 2px 8px rgba(0, 0, 0, 0.05);">
                <div style="display:flex; margin-bottom:12px; padding-bottom:12px; border-bottom:1px dashed #fcd9a7;">
                    <span style="font-weight:600; min-width:120px; color:#E28700; font-size:14px;">Nama:</span>
                    <span style="flex:1; font-size:14px;">{{ $nama }}</span>
                </div>
                <div style="display:flex; margin-bottom:12px; padding-bottom:12px; border-bottom:1px dashed #fcd9a7;">
                    <span style="font-weight:600; min-width:120px; color:#E28700; font-size:14px;">Email:</span>
                    <span style="flex:1; font-size:14px;">{{ $email }}</span>
                </div>
                @if($telepon)
                <div style="display:flex; margin-bottom:12px; padding-bottom:12px; border-bottom:1px dashed #fcd9a7;">
                    <span style="font-weight:600; min-width:120px; color:#E28700; font-size:14px;">Telepon:</span>
                    <span style="flex:1; font-size:14px;">{{ $telepon }}</span>
                </div>
                @endif
                <div style="display:flex;">
                    <span style="font-weight:600; min-width:120px; color:#E28700; font-size:14px;">Pesan:</span>
                    <span style="flex:1; font-size:14px; white-space:pre-line;">{{ $pesan }}</span>
                </div>
            </div>
            <p style="color:#444444; margin-bottom:15px; font-size: 14px;">
                Silakan balas email ini untuk menanggapi pesan dari pengirim.
            </p>
        </div>
        <div style="padding:15px; text-align:center; font-size:11px; color:#aaaaaa;">
            &copy; {{ date('Y') }} {{ e($settings->site_name ?? 'SI MBEK') }}. All rights reserved.
        </div>
    </div>
</body>
</html>