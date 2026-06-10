<?php

namespace Database\Seeders;

use App\Models\Rute;
use App\Models\Pelabuhan;
use Illuminate\Database\Seeder;

class RuteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil ID pelabuhan yang dibutuhkan sesuai urutan Barat ke Timur
        $ports = [
            Pelabuhan::where('nama_pelabuhan', 'Pelabuhan Tanjung Balai Karimun')->first(),
            Pelabuhan::where('nama_pelabuhan', 'Pelabuhan Sekupang')->first(),
            Pelabuhan::where('nama_pelabuhan', 'Pelabuhan Batu Ampar')->first(),
            Pelabuhan::where('nama_pelabuhan', 'Pelabuhan Sri Bintan Pura')->first(),
            Pelabuhan::where('nama_pelabuhan', 'Pelabuhan Selat Lampa')->first(),
        ];

        // Pastikan semua pelabuhan ada
        foreach ($ports as $port) {
            if (!$port) return;
        }

        // Estimasi jarak kasar antar pelabuhan yang berdekatan (West to East)
        // Karimun-Sekupang: 35, Sekupang-BatuAmpar: 10, BatuAmpar-Bintan: 20, Bintan-Natuna: 315
        $distances = [35.00, 10.00, 20.00, 315.00];

        $totalPorts = count($ports);

        // Buat semua kemungkinan rute (Origin to Destination)
        for ($i = 0; $i < $totalPorts; $i++) {
            for ($j = 0; $j < $totalPorts; $j++) {
                if ($i === $j) continue;

                $origin = $ports[$i];
                $dest = $ports[$j];
                $transits = [];
                $totalJarak = 0;

                if ($i < $j) {
                    // Arah Timur (Kiri ke Kanan)
                    for ($k = $i + 1; $k < $j; $k++) {
                        $transits[] = $ports[$k]->kode_pelabuhan;
                    }
                    for ($k = $i; $k < $j; $k++) {
                        $totalJarak += $distances[$k];
                    }
                } else {
                    // Arah Barat (Kanan ke Kiri)
                    for ($k = $i - 1; $k > $j; $k--) {
                        $transits[] = $ports[$k]->kode_pelabuhan;
                    }
                    for ($k = $j; $k < $i; $k++) {
                        $totalJarak += $distances[$k];
                    }
                }

                Rute::create([
                    'kode_pelabuhan_asal' => $origin->kode_pelabuhan,
                    'kode_pelabuhan_tujuan' => $dest->kode_pelabuhan,
                    'titik_transit' => $transits,
                    'jarak' => $totalJarak,
                ]);
            }
        }
    }
}
