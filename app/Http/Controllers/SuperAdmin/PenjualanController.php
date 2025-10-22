<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Models\Kambing;
use App\Models\Domba;
use App\Http\Controllers\Controller;
use App\Models\Order; 
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    // Invoice Otomatis
    public function invoice($order_id)
    {
        $order = Order::with(['user', 'kambing', 'domba'])
            ->where('order_id', $order_id)
            ->firstOrFail();

        // Cek akses: hanya super admin
        if (!auth('super_admin')->check()) {
            abort(403, 'Unauthorized access.');
        }

        return view('superadmin.invoice', compact('order'));
    }

    // Invoice Manual
    public function manualInvoice($order_id)
    {
        $order = Order::with(['user', 'kambing', 'domba'])
            ->where('order_id', $order_id)
            ->firstOrFail();

        // Cek akses: hanya super admin
        if (!auth('super_admin')->check()) {
            abort(403, 'Unauthorized access.');
        }

        return view('superadmin.manual-invoice', compact('order'));
    }
}
