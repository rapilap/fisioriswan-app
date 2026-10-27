<?php

use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Membuat akun admin (atau menjadikan akun yang ada sebagai admin & mengganti password-nya).
// Password diketik tersembunyi, jadi tidak tersimpan di riwayat terminal.
Artisan::command('admin:create {email}', function (string $email) {
    $name = $this->ask('Nama admin', 'Admin');
    $password = $this->secret('Password (min. 12 karakter, huruf besar & kecil, angka, simbol)');
    $konfirmasi = $this->secret('Ulangi password');

    $validator = Validator::make(
        ['email' => $email, 'password' => $password, 'password_confirmation' => $konfirmasi],
        [
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'confirmed', Password::min(12)->mixedCase()->numbers()->symbols()->uncompromised()],
        ],
    );

    if ($validator->fails()) {
        foreach ($validator->errors()->all() as $pesan) {
            $this->error($pesan);
        }

        return 1;
    }

    // forceFill: 'role' sengaja tidak fillable agar tidak bisa diisi dari form publik.
    $user = User::firstOrNew(['email' => $email]);
    $user->forceFill(['name' => $name, 'password' => $password, 'role' => 'admin'])->save();

    $this->info("Akun admin {$email} siap dipakai di /admin/login.");
})->purpose('Buat atau perbarui akun admin');
