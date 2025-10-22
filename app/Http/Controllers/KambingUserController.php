<?php

namespace App\Http\Controllers;

use App\Models\Kambing;
use App\Models\Domba;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KambingUserController extends Controller
{
    public function index()
    {
        $user = Auth::user();
    $kambings = Kambing::where('user_id', $user->id)->get();
    $dombas = Domba::where('user_id', $user->id)->get();
    
    return view('dashboard', compact('user', 'kambings', 'dombas'));
}
}
