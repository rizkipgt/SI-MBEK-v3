<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SiteSetting;

class SiteSettingSeeder extends Seeder
{
    public function run()
    {
        SiteSetting::updateOrCreate(
            ['id' => 1],
            [
                'site_name' => 'SI MBEK',
                'site_logo' => null,
                'sections' => ([
                    'hero' => [
                        'active' => true,
                        'title' => 'Judul Default',
                        'subtitle' => 'Subjudul Default',
                        'description' => 'Deskripsi Default',
                        'image' => null,
                        'button_text' => 'Selengkapnya',
                        'button_url' => '/about',
                    ],
                    'why' => [
                        'active' => true,
                        'heading' => 'Mengapa Si Mbek?',
                        'items' => [
                            ['title' => 'Item 1', 'description' => 'Deskripsi 1'],
                            ['title' => 'Item 2', 'description' => 'Deskripsi 2'],
                            ['title' => 'Item 3', 'description' => 'Deskripsi 3'],
                        ],
                        'images' => [
                            'pageimage/kambing2.jpeg',
                            'pageimage/depan-raman.jpeg',
                            'pageimage/kambing3.jpeg',
                            'pageimage/kambing4.jpeg',
                        ],
                    ],
                    'cta' => [
                        'active' => true,
                        'heading' => 'Bergabung Dengan Si Mbek',
                        'subheading' => 'Subjudul CTA Default',
                        'button_text' => 'DAFTAR SEKARANG',
                        'button_url' => '/register',
                    ],
                    'info' => [
                        'active' => true,
                        'title' => 'Informasi Kambing',
                        'subtitle' => 'Pelajari lebih lanjut...',
                        'boxes' => [
                            ['title' => 'Jenis-jenis Kambing', 'content' => '<ul><li>...</li></ul>'],
                            ['title' => 'Vaksin Wajib', 'content' => '<ul><li>...</li></ul>'],
                            ['title' => 'Perawatan Kambing', 'content' => '<ul><li>...</li></ul>'],
                            ['title' => 'Tips Penting', 'content' => '<ul><li>...</li></ul>'],
                        ],
                    ],
                ]),
                'social' => ([
                    'twitter' => ['active' => false, 'url' => '#'],
                    'facebook' => ['active' => false, 'url' => '#'],
                    'instagram' => ['active' => false, 'url' => '#'],
                    'linkedin' => ['active' => false, 'url' => '#']
                ]),
                'contact' => ([
                    'address' => 'Alamat Default',
                    'phone' => '08123456789',
                    'email' => 'email@example.com',
                ]),
                'map' => ([
                    'active' => false,
                    'embed_code' => '<iframe>...</iframe>',
                ]),
                'about_page' => ([
                    'active' => true,
                    'title' => 'Tentang Kami',
                    'subtitle' => 'Raman Farm',
                    'sections' => [
                        [
                            'title' => 'Profil Perusahaan',
                            'content' => 'Raman Farm adalah sebuah usaha peternakan ...',
                        ],
                        [
                            'title' => 'Layanan Kami',
                            'content' => '',
                            'items' => [
                                '<strong>Hotel Ternak:</strong> ...',
                                '<strong>Tabungan Qurban:</strong> ...'
                            ],
                        ],
                    ],
                ]),
            ]
        );
    }
}