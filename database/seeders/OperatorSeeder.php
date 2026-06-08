<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Operator;
use Faker\Factory as Faker;

class OperatorSeeder extends Seeder
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
            
            Operator::create([
                'nama_operator' => $faker->name . ' / KM ' . $faker->firstName . ' ' . $randomKota,
                'no_hp' => $faker->phoneNumber,
            ]);
        }
    }
}
