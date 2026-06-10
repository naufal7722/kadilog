<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Operator;
use App\Models\User;
use App\Models\Pelabuhan;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class OperatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $pelabuhans = Pelabuhan::all();
        $counter = 1;

        foreach ($pelabuhans as $pelabuhan) {
            for ($i = 1; $i <= 3; $i++) {
                $operator = Operator::create([
                    'nama_operator' => $faker->name . ' / KM ' . $pelabuhan->nama_pulau . ' ' . $i,
                    'no_hp' => $faker->phoneNumber,
                    'kode_pelabuhan' => $pelabuhan->kode_pelabuhan,
                ]);

                // Buat akun user untuk operator ini (format email yang unik)
                $email = 'operator.p' . $pelabuhan->kode_pelabuhan . '_' . $i . '@kasalog.id';
                
                User::create([
                    'name' => $operator->nama_operator,
                    'email' => $email, 
                    'password' => Hash::make('password'),
                    'role' => 'operator',
                    'kode_operator' => $operator->kode_operator,
                ]);
                
                $counter++;
            }
        }
    }
}
