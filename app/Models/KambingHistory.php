<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KambingHistory extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'kambing_id',
        'bulan',
        'tanggal',
        'berat',
        'harga'
    ];
}