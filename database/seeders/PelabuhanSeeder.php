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
                'koordinat' => '1.1615, 104.0042',
            ],
            [
                'nama_pelabuhan' => 'Pelabuhan Punggur',
                'nama_pulau' => 'Batam',
                'nama_gudang' => 'Gudang Transit Punggur',
                'koordinat' => '1.0505, 104.1481',
            ],
            [
                'nama_pelabuhan' => 'Pelabuhan Sri Bintan Pura',
                'nama_pulau' => 'Bintan',
                'nama_gudang' => 'Gudang Logistik Bintan Utama',
                'koordinat' => '0.9238, 104.4442',
            ],
            [
                'nama_pelabuhan' => 'Pelabuhan Tanjung Balai Karimun',
                'nama_pulau' => 'Karimun',
                'nama_gudang' => 'Gudang Transit Karimun',
                'koordinat' => '1.0028, 103.4286',
            ],
            [
                'nama_pelabuhan' => 'Pelabuhan Selat Lampa',
                'nama_pulau' => 'Natuna',
                'nama_gudang' => 'Gudang Logistik Natuna',
                'koordinat' => '3.6766, 108.1256',
            ],
        ];

        foreach ($pelabuhans as $data) {
            Pelabuhan::create($data);
        }
    }
}
