<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $produksi = $this->app->isProduction();

        // Di produksi, tolak perintah yang menghapus seluruh isi database
        // (migrate:fresh, migrate:refresh, migrate:reset, db:wipe). Satu salah ketik
        // saat publish tidak akan menghapus testimoni, event, dan akun admin.
        DB::prohibitDestructiveCommands($produksi);

        if ($produksi) {
            // Semua link & redirect memakai https bila website dipasang dengan https.
            if (str_starts_with((string) config('app.url'), 'https://')) {
                URL::forceScheme('https');
            }

            // APP_DEBUG=true di produksi membocorkan kode, path, dan isi .env lewat halaman error.
            if (config('app.debug')) {
                Log::critical('APP_DEBUG=true di lingkungan produksi. Segera ubah menjadi false di .env.');
            }
        }
    }
}
