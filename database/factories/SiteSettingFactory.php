<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\SiteSetting;

class SiteSettingFactory extends Factory
{
    protected $model = SiteSetting::class;

    public function definition(): array
    {
        return [
            'site_name' => $this->faker->company, // contoh: nama instansi/website
            'site_logo' => $this->faker->imageUrl(200, 200, 'business', true, 'logo'),
            'sections'  => json_encode([
                'home' => true,
                'services' => true,
                'portfolio' => false,
                'blog' => true,
            ]),
            'social' => json_encode([
                'facebook' => $this->faker->url,
                'twitter'  => $this->faker->url,
                'instagram'=> $this->faker->url,
            ]),
            'contact' => json_encode([
                'email' => $this->faker->companyEmail,
                'phone' => $this->faker->phoneNumber,
                'address' => $this->faker->address,
            ]),
            'map' => json_encode([
                'latitude' => $this->faker->latitude,
                'longitude' => $this->faker->longitude,
            ]),
            'about_page' => json_encode([
                'title' => 'About Us',
                'content' => $this->faker->paragraph(3),
            ]),
        ];
    }
}
