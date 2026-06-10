<?php

namespace Database\Seeders;

use App\Models\Pelabuhan;
use Illuminate\Database\Seeder;

class PelabuhanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pelabuhans = [
            [
                'nama_pelabuhan' => 'Pelabuhan Batu Ampar',
                'nama_pulau' => 'Batam',
                'nama_gudang' => 'Gudang Logistik Batam 1',
                'koordinat' => '1.16628, 104.00447',
            ],
            [
                'nama_pelabuhan' => 'Pelabuhan Sekupang',
                'nama_pulau' => 'Batam',
                'nama_gudang' => 'Gudang Transit Sekupang',
                'koordinat' => '1.1247129707821863, 103.92663650093392',
            ],
            [
                'nama_pelabuhan' => 'Pelabuhan Sri Bintan Pura',
                'nama_pulau' => 'Bintan',
                'nama_gudang' => 'Gudang Logistik Bintan Utama',
                'koordinat' => '0.9319, 104.4367',
            ],
            [
                'nama_pelabuhan' => 'Pelabuhan Tanjung Balai Karimun',
                'nama_pulau' => 'Karimun',
                'nama_gudang' => 'Gudang Transit Karimun',
                'koordinat' => '0.9883, 103.4362',
            ],
            [
                'nama_pelabuhan' => 'Pelabuhan Selat Lampa',
                'nama_pulau' => 'Natuna',
                'nama_gudang' => 'Gudang Logistik Natuna',
                'koordinat' => '3.6639, 108.1306',
            ],
        ];

        foreach ($pelabuhans as $data) {
            Pelabuhan::create($data);
        }
    }
}
