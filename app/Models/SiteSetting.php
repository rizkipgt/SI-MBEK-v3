<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_name',
        'site_logo',
        'sections',
        'social',
        'contact',
        'map',
        'about_page'
    ];

    protected $casts = [
        'sections' => 'array',
        'social' => 'array',
        'contact' => 'array',
        'map' => 'array',
        'about_page' => 'array'
    ];
}
