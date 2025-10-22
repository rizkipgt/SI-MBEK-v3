<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DombaHistorySeeder extends Seeder
{
    public function run(): void
    {
        // Ambil data domba
        $dombaList = DB::table('domba')->select('id', 'weight_now', 'harga')->get();
        
        // Jika tidak ada data domba, keluar dari seeder
        if ($dombaList->isEmpty()) {
            $this->command->info('Tidak ada data domba. Seeder dihentikan.');
            return;
        }

        $today = Carbon::today();
        $startDate = $today->copy()->subMonths(3); // 3 bulan ke belakang

        $allData = [];

        foreach ($dombaList as $domba) {
            // Hitung nilai awal (70% dari nilai akhir)
            $berat = $domba->weight_now * 0.7;
            $harga = $domba->harga * 0.7;
            
            // Hitung kenaikan harian untuk mencapai nilai akhir dalam 3 bulan
            $daysDiff = $startDate->diffInDays($today);
            $beratIncrement = ($domba->weight_now - $berat) / $daysDiff;
            $hargaIncrement = ($domba->harga - $harga) / $daysDiff;

            for ($date = $startDate->copy(); $date->lte($today); $date->addDay()) {
                // Tambahkan kenaikan harian dengan sedikit variasi acak
                $berat += $beratIncrement + $this->randomFloat(-0.05, 0.05);
                $harga += $hargaIncrement + rand(-5000, 5000);
                
                // Pastikan tidak melebihi nilai akhir
                $berat = min($berat, $domba->weight_now);
                $harga = min($harga, $domba->harga);
                
                // Pastikan tidak kurang dari nilai awal
                $berat = max($berat, $domba->weight_now * 0.7);
                $harga = max($harga, $domba->harga * 0.7);

                $allData[] = [
                    'domba_id'   => $domba->id, // Berubah dari kambing_id ke domba_id
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
                        DB::table('domba_histories')->insert($chunk); // Berubah ke domba_histories
                    }
                    $allData = [];
                }
            }
        }

        // Insert sisa data
        if (!empty($allData)) {
            foreach (array_chunk($allData, 500) as $chunk) {
                DB::table('domba_histories')->insert($chunk); // Berubah ke domba_histories
            }
        }
    }

    private function randomFloat(float $min, float $max): float
    {
        return $min + mt_rand() / mt_getrandmax() * ($max - $min);
    }
}