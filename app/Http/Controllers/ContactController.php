<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use App\Notifications\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class ContactController extends Controller
{
    public function send(Request $request)
{
    $validated = $request->validate([
        'nama' => 'required|string|max:255',
        'email' => 'required|email',
        'telepon' => [
        'required',
        'regex:/^[\d\s\+\-]+$/', 
        'max:20'
    ],
        'pesan' => 'required|string',
    ],[
    'nama.required' => 'Nama wajib diisi.',
    'email.required' => 'Email wajib diisi.',
    'email.email' => 'Format email tidak valid.',
    'telepon.required' => 'Nomor telepon wajib diisi.',
    'telepon.regex' => 'Nomor telepon hanya boleh berisi angka, spasi, tanda plus (+), dan minus (-).',
    'telepon.max' => 'Nomor telepon tidak boleh lebih dari 20 karakter.',
    'pesan.required' => 'Pesan wajib diisi.',
    ]);

    try {
        $settings = SiteSetting::first();
        $toEmail = $settings->contact['email'] ?? 'default@email.com';

        Notification::route('mail', $toEmail)
            ->notify(new ContactMessage($validated));

        return back()->with('success', 'Pesan Anda berhasil dikirim!');
    } catch (\Exception $e) {
        return back()->with('error', 'Pesan gagal dikirim. Silakan coba lagi nanti.');
    }
}
}