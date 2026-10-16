<?php

use App\Http\Controllers\TestimonialAdminController;
use App\Http\Controllers\TestimonialController;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

// "/" dan "/beranda" menampilkan halaman yang sama
$beranda = function () {
    // Testimoni yang disetujui admin tampil di bagian "Pengalaman yang mereka rasakan".
    // Jika tabel belum ada (belum migrate), view memakai data contoh.
    $testimoni = Schema::hasTable('testimonials')
        ? Testimonial::query()
            ->where('status', 'approved')
            ->latest()
            ->take(12)
            ->get()
            ->map(fn (Testimonial $t) => [
                'nama' => $t->fullname,
                'kondisi' => $t->city,
                'rating' => $t->rating,
                'teks' => $t->testimonial,
            ])
            ->all()
        : null;

    return view('main', compact('testimoni'));
};

Route::get('/', $beranda);
Route::get('/beranda', $beranda)->name('beranda');

Route::get('/event', function () {
    return view('event');
})->name('event');

Route::get('/layanan', function () {
    return view('layanan');
})->name('layanan');

Route::get('/testimoni', [TestimonialController::class, 'index'])->name('testimoni');
Route::get('/testimoni/input', [TestimonialController::class, 'create'])->name('inputTestimoni');
Route::post('/testimoni', [TestimonialController::class, 'store'])
    ->middleware('throttle:5,1') // batasi 5 kiriman per menit per pengunjung
    ->name('testimoni.store');

// Admin: kelola testimoni
// TODO: bungkus dengan middleware auth setelah login admin tersedia
Route::prefix('admin/testimoni')
    ->name('admin.testimoni.')
    ->controller(TestimonialAdminController::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/pending', 'pending')->name('pending');
        Route::patch('/{testimonial}/approve', 'approve')->name('approve');
        Route::delete('/{testimonial}', 'destroy')->name('destroy');
    });
