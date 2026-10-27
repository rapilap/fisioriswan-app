<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     *
     * Sengaja TIDAK membuat akun pengguna: setiap akun bisa masuk ke halaman admin,
     * jadi akun dengan kata sandi bawaan ("password") adalah celah keamanan.
     * Buat akun admin dengan: php artisan admin:create
     */
    public function run(): void
    {
        //
    }
}
