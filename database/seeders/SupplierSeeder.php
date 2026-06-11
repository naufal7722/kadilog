<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Supplier;
use Faker\Factory as Faker;

class SupplierSeeder extends Seeder
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
            
            Supplier::create([
                'nama_umkm' => $faker->company,
                'alamat' => $faker->streetAddress . ', ' . $randomPelabuhan->nama_pulau,
                'nama_pic' => $faker->name,
                'no_hp_pic' => $faker->phoneNumber,
                'kode_pelabuhan' => $randomPelabuhan->kode_pelabuhan,
            ]);
        }
    }
}
