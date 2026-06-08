<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Supplier;
use App\Models\Operator;
use App\Models\Konsumen;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat Data Profil (Supplier, Konsumen, Operator)
        $supplier = Supplier::create([
            'kode_supplier' => 'SUP-001',
            'nama_umkm' => 'PT. Maju Sejahtera',
            'alamat' => 'Jl. Industri No.1, Batam',
            'nama_pic' => 'Budi Santoso',
            'no_hp_pic' => '081234567890'
        ]);

        $konsumen = Konsumen::create([
            'kode_konsumen' => 'KON-001',
            'nama_konsumen' => 'Toko Laris Natuna',
            'nama_pic_konsumen' => 'Ahmad'
        ]);

        $operator = Operator::create([
            'kode_operator' => 'OP-001',
            'nama_operator' => 'Operator Pelabuhan Batam',
            'no_hp' => '08111222333'
        ]);

        // 2. Buat Akun Users dan hubungkan dengan profil
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@kasalog.id',
            'password' => Hash::make('password'),
            'role' => 'superadmin',
        ]);

        User::create([
            'name' => 'Staff / Konsumen',
            'email' => 'staff@kasalog.id',
            'password' => Hash::make('password'),
            'role' => 'staff', // atau konsumen
            'kode_konsumen' => $konsumen->kode_konsumen,
        ]);

        User::create([
            'name' => 'Supplier Satu',
            'email' => 'supplier@kasalog.id',
            'password' => Hash::make('password'),
            'role' => 'supplier',
            'kode_supplier' => $supplier->kode_supplier,
        ]);

        User::create([
            'name' => 'Operator Satu',
            'email' => 'operator@kasalog.id',
            'password' => Hash::make('password'),
            'role' => 'operator',
            'kode_operator' => $operator->kode_operator,
        ]);
    }
}
