<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat user default
        $users = [
            [
                'name' => 'Master Admin',
                'email' => 'admin@pln.co.id',
                'password' => Hash::make('admin12345'),
                'role' => 'asisten_manager',
            ],
            [
                'name' => 'PIC Keuangan',
                'email' => 'keuangan@pln.co.id',
                'password' => Hash::make('pic12345'),
                'role' => 'pic_keuangan',
            ],
            [
                'name' => 'PIC Perencanaan Operasi',
                'email' => 'operasi@pln.co.id',
                'password' => Hash::make('pic12345'),
                'role' => 'pic_perencanaan_operasi',
            ],
            [
                'name' => 'PIC Sekretaris Perusahaan',
                'email' => 'sekretaris@pln.co.id',
                'password' => Hash::make('pic12345'),
                'role' => 'pic_sekretaris_perusahaan',
            ],
            [
                'name' => 'PIC Perencanaan Korporat',
                'email' => 'pkorporat@pln.co.id',
                'password' => Hash::make('pic12345'),
                'role' => 'pic_perencanaan_korporat',
            ],
            [
                'name' => 'PIC Manajemen Risiko',
                'email' => 'risiko@pln.co.id',
                'password' => Hash::make('pic12345'),
                'role' => 'pic_manajemen_risiko',
            ],
            [
                'name' => 'PIC Pengembangan Bisnis',
                'email' => 'bisnis@pln.co.id',
                'password' => Hash::make('pic12345'),
                'role' => 'pic_pengembangan_bisnis',
            ],
            [
                'name' => 'PIC Human Capital',
                'email' => 'hcm@pln.co.id',
                'password' => Hash::make('pic12345'),
                'role' => 'pic_human_capital',
            ],
            [
                'name' => 'PIC K3L',
                'email' => 'k3l@pln.co.id',
                'password' => Hash::make('pic12345'),
                'role' => 'pic_k3l',
            ],
            [
                'name' => 'Karyawan',
                'email' => 'karyawan@pln.co.id',
                'password' => Hash::make('karyawan12345'),
                'role' => 'karyawan',
            ],
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }

        // Panggil seeder lain sesuai urutan
        $this->call([
            BidangSeeder::class,
            PilarSeeder::class,
            IndikatorSeeder::class,
        ]);
    }
}
