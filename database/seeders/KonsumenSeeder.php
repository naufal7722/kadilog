<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Konsumen;
use Faker\Factory as Faker;

class KonsumenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $pelabuhans = \App\Models\Pelabuhan::all();

        for ($i = 0; $i < 10; $i++) {
            $randomPelabuhan = $pelabuhans->random();
            
            Konsumen::create([
                'nama_konsumen' => 'Toko ' . $faker->company . ' ' . $randomPelabuhan->nama_pulau,
                'nama_pic_konsumen' => $faker->name,
                'kode_pelabuhan' => $randomPelabuhan->kode_pelabuhan,
            ]);
        }
    }
}
