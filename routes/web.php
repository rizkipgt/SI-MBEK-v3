<?php

use App\Http\Controllers\KambingForsale;
use App\Http\Controllers\KambingUserController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdmin\KambingController;
use App\Http\Controllers\SuperAdmin\DombaController;
use App\Http\Controllers\ContactController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/teamproject', function () {
    return view('developer');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::resource('kambings', KambingForsale::class);
Route::get('/forsale', [KambingForsale::class, 'index'])->name('forsale');

// Manual transfer TANPA middleware dulu untuk testing
Route::post('/manual/transfer', [OrderController::class, 'manualTransfer'])->name('manual.transfer');

// Route order untuk user login
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/order', [OrderController::class, 'index'])->name('order.index');
    Route::get('/order/invoice/{order_id}', [OrderController::class, 'invoice'])->name('order.invoice');
    
    // PENTING: Route spesifik harus di ATAS sebelum route wildcard
    Route::get('/order/manual-invoice/{order_id}', [OrderController::class, 'manualInvoice'])
        ->name('order.manual-invoice');
    
    // Route wildcard harus di BAWAH - tambahkan constraint untuk keamanan
    Route::get('/order/{category}/{id}', [OrderController::class, 'show'])
        ->where('category', 'kambing|domba')
        ->where('id', '[0-9]+')
        ->name('order.show');
    
    Route::post('/midtrans/token', [OrderController::class, 'getSnapToken'])->name('midtrans.token');
    Route::get('/transaksi', [OrderController::class, 'transaksi'])->name('order.transaksi');
});

Route::post('/kambing/{kambing}/history', [KambingController::class, 'storeHistory'])
    ->name('super-admin.kambing.history.store');
Route::post('/domba/{domba}/history', [DombaController::class, 'storeHistory'])
    ->name('super-admin.domba.history.store');

Route::get('/dashboard', [KambingUserController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');
Route::post('/midtrans/webhook', [OrderController::class, 'midtransWebhook']);

require __DIR__ . '/auth.php';
require __DIR__ . '/superadmin.php';

// CATATAN: Setelah manual transfer berhasil, pindahkan route ke dalam middleware:
// Route::middleware(['auth', 'verified'])->group(function () {
//     Route::post('/manual/transfer', [OrderController::class, 'manualTransfer'])->name('manual.transfer');
// });