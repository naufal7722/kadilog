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
        // Temukan pelabuhan di Bintan, Natuna, dan Karimun untuk dijadikan destinasi rute dari Batam
        $bintan = Pelabuhan::where('nama_pulau', 'Bintan')->first();
        $natuna = Pelabuhan::where('nama_pulau', 'Natuna')->first();
        $karimun = Pelabuhan::where('nama_pulau', 'Karimun')->first();

        if ($bintan) {
            Rute::create([
                'kode_pelabuhan' => $bintan->kode_pelabuhan,
                'jarak' => 45.00,
            ]);
        }

        if ($natuna) {
            Rute::create([
                'kode_pelabuhan' => $natuna->kode_pelabuhan,
                'jarak' => 300.00,
            ]);
        }

        if ($karimun) {
            Rute::create([
                'kode_pelabuhan' => $karimun->kode_pelabuhan,
                'jarak' => 50.00,
            ]);
        }
    }
}
