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
        $kota = ['Batam', 'Bintan', 'Karimun', 'Natuna'];

        for ($i = 0; $i < 10; $i++) {
            $randomKota = $faker->randomElement($kota);
            
            Konsumen::create([
                'nama_konsumen' => 'Toko ' . $faker->company . ' ' . $randomKota,
                'nama_pic_konsumen' => $faker->name,
            ]);
        }
    }
}
