@php
    $settings = App\Models\SiteSetting::first();
@endphp
<!DOCTYPE html>
<html lang="id">

<head>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
    </style>
    <meta charset="UTF-8">
    <title>Reset Kata Sandi</title>
</head>

<body style="margin:0; padding:0; background-color:#FEF1DC; font-family:sans-serif;">
    <div
        style="max-width:600px; margin:40px auto; background-color:#ffffff; border-radius:20px; overflow:hidden; box-shadow:0 4px 10px rgba(0,0,0,0.1);">
        <div style="padding:30px; background-color:#FFF7EC; border-bottom:1px solid #fcd9a7;">
            <!-- Header -->
            <div style="display:flex; align-items:center; margin-bottom:20px;">
                <img src="{{ $settings->site_logo ? asset('storage/' . $settings->site_logo) : asset('logo/logosiembek.png') }}"
                    alt="Logo SI MBEK" style="height:32px; margin-right:10px;">
                <h1 style="font-size:20px; font-weight:bold; color:#E28700; margin:0;">
                    {{ e($settings->site_name ?? 'SI MBEK') }}
                </h1>
            </div>

            <!-- Title -->
            <h2 style="font-size:24px; font-weight:800; color:#333333; margin:0 0 10px;">
                Permintaan Reset Kata Sandi
            </h2>

            <!-- Greeting -->
            <p style="color:#444444; margin:0 0 10px;">
                Halo {{ e($user->name ?? 'Pengguna') }},
            </p>

            <!-- Message -->
            <p style="color:#444444; margin:0 0 20px;">
                Kami menerima permintaan untuk mengatur ulang kata sandi Anda. Klik tombol di bawah ini untuk
                melanjutkan.
            </p>

            <!-- CTA Button -->
            <div style="text-align:center; margin:30px 0;">
                <a href="{{ $url }}"
                    style="background-color:#E28700; color:#ffffff; padding:12px 24px; border-radius:8px; text-decoration:none; font-weight:bold;">
                    Reset Kata Sandi
                </a>
            </div>

            <!-- Footer Note -->
            <p style="font-size:14px; color:#888888; margin-bottom:20px;">
                Jika Anda tidak meminta reset kata sandi, abaikan email ini. Kata sandi Anda tidak akan berubah.
            </p>

            <!-- Garis Pembatas -->
            <hr style="border:none; border-top:1px solid #fcd9a7; margin:20px 0;">

            <!-- Fallback URL -->
            <p style="color:#444444; margin-bottom:8px;">
                Jika Anda mengalami kesulitan mengklik tombol <strong>"Reset Kata Sandi"</strong>, salin dan tempel URL
                di bawah ini ke peramban Anda:
            </p>
            <p style="word-break:break-all; color:#1a0dab; margin-bottom:0;">
                <a href="{{ $url }}">{{ $url }}</a>
            </p>
        </div>

        <!-- Footer -->
        <div style="padding:20px; text-align:center; font-size:12px; color:#aaaaaa;">
            &copy; {{ date('Y') }} {{ e($settings->site_name ?? 'SI MBEK') }}. All rights reserved.
        </div>
    </div>
</body>

</html>
