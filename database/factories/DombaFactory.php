<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Domba>
 */
class DombaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // tanggal lahir random dalam 1–10 tahun terakhir
        $tanggalLahir = $this->faker->dateTimeBetween('-10 years', 'now');

        // hitung umur saat ini berdasarkan tanggal lahir
        $ageNow = Carbon::parse($tanggalLahir)->age;
        $age = $ageNow; // disamakan agar konsisten

        // tentukan rentang berat sesuai umur
        if ($ageNow <= 1) {
            $minWeight = 2;
            $maxWeight = 15;
        } elseif ($ageNow <= 3) {
            $minWeight = 15;
            $maxWeight = 30;
        } elseif ($ageNow <= 6) {
            $minWeight = 30;
            $maxWeight = 60;
        } else {
            $minWeight = 60;
            $maxWeight = 90;
        }

        // berat sekarang dan berat sebelumnya
        $weightNow = $this->faker->randomFloat(1, $minWeight, $maxWeight);
        $weight = $this->faker->randomFloat(1, max(1, $minWeight - 1), $weightNow);

        // jenis & kelamin
        $jenis = $this->faker->randomElement(['Garut', 'Ekor Gemuk', 'Ekor Tipis', 'Texel', 'Dorper']);
        $jenisKelamin = $this->faker->randomElement(['Jantan', 'Betina']);

        // buat nama sesuai format
        $name = "Domba {$jenis} {$jenisKelamin}";

        // Hitung harga berdasarkan weight_now (2–90 kg => 1–14 juta)
        $minPrice = 1000000;
        $maxPrice = 14000000;
        $harga = $minPrice + (($weightNow - 2) / (90 - 2)) * ($maxPrice - $minPrice);
        $harga = round($harga, -3); // bulat ribuan

        return [
            'user_id'       => User::inRandomOrder()->first()?->id ?? 1,
            'tanggal_lahir' => Carbon::parse($tanggalLahir)->format('Y-m-d'),
            'name'          => $name,
            'type_domba'    => $jenis,
            'jenis_kelamin' => $jenisKelamin,
            'age'           => $age,
            'age_now'       => $ageNow,
            'image'         => 'default.jpg',
            'imageCaption'  => 'Gambar domba',
            'weight'        => $weight,
            'weight_now'    => $weightNow,
            'for_sale'      => 'yes',
            'faksin_status' => $this->faker->randomElement([
                'Vaksin PMK',
                'Vaksin Antraks',
                'Vaksin Brucellosis',
                'Tidak Aktif'
            ]),
            'healt_status'  => 'Sehat',
            'harga'         => $harga,
        ];
    }
}
