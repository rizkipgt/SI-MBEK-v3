<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DombaHistory extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'domba_id',
        'bulan',
        'tanggal',
        'berat',
        'harga'
    ];
}