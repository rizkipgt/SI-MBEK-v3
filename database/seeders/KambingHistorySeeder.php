<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KambingHistorySeeder extends Seeder
{
    public function run(): void
    {
        // Ambil data kambing
        $kambingList = DB::table('kambing')->select('id', 'weight_now', 'harga')->get();
        
        // Jika tidak ada data kambing, keluar dari seeder
        if ($kambingList->isEmpty()) {
            $this->command->info('Tidak ada data kambing. Seeder dihentikan.');
            return;
        }

        $today = Carbon::today();
        $startDate = $today->copy()->subMonths(3); // 3 bulan ke belakang

        $allData = [];

        foreach ($kambingList as $kambing) {
            // Hitung nilai awal (70% dari nilai akhir)
            $berat = $kambing->weight_now * 0.7;
            $harga = $kambing->harga * 0.7;
            
            // Hitung kenaikan harian untuk mencapai nilai akhir dalam 3 bulan
            $daysDiff = $startDate->diffInDays($today);
            $beratIncrement = ($kambing->weight_now - $berat) / $daysDiff;
            $hargaIncrement = ($kambing->harga - $harga) / $daysDiff;

            for ($date = $startDate->copy(); $date->lte($today); $date->addDay()) {
                // Tambahkan kenaikan harian dengan sedikit variasi acak
                $berat += $beratIncrement + $this->randomFloat(-0.05, 0.05);
                $harga += $hargaIncrement + rand(-5000, 5000);
                
                // Pastikan tidak melebihi nilai akhir
                $berat = min($berat, $kambing->weight_now);
                $harga = min($harga, $kambing->harga);
                
                // Pastikan tidak kurang dari nilai awal
                $berat = max($berat, $kambing->weight_now * 0.7);
                $harga = max($harga, $kambing->harga * 0.7);

                $allData[] = [
                    'kambing_id' => $kambing->id,
                    'bulan'      => $date->format('Y-m'), // Format tahun-bulan
                    'berat'      => round($berat, 2),
                    'harga'      => round($harga, -3), // Dibulatkan ke ribuan
                    'tanggal'    => $date->toDateString(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                // Batasi memori dengan melakukan insert batch setiap 1000 data
                if (count($allData) >= 1000) {
                    foreach (array_chunk($allData, 500) as $chunk) {
                        DB::table('kambing_histories')->insert($chunk);
                    }
                    $allData = [];
                }
            }
        }

        // Insert sisa data
        if (!empty($allData)) {
            foreach (array_chunk($allData, 500) as $chunk) {
                DB::table('kambing_histories')->insert($chunk);
            }
        }
    }

    private function randomFloat(float $min, float $max): float
    {
        return $min + mt_rand() / mt_getrandmax() * ($max - $min);
    }
}