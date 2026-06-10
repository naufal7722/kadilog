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
        $kota = ['Batam', 'Bintan', 'Karimun', 'Natuna'];

        for ($i = 0; $i < 10; $i++) {
            $randomKota = $faker->randomElement($kota);
            
            Supplier::create([
                'nama_umkm' => $faker->company,
                'alamat' => $faker->streetAddress . ', ' . $randomKota,
                'nama_pic' => $faker->name,
                'no_hp_pic' => $faker->phoneNumber,
            ]);
        }
    }
}
