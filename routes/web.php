<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\EventAdminController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventHighlightAdminController;
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

Route::get('/event', [EventController::class, 'index'])->name('event');

Route::get('/layanan', function () {
    return view('layanan');
})->name('layanan');

Route::get('/testimoni', [TestimonialController::class, 'index'])->name('testimoni');
Route::get('/testimoni/input', [TestimonialController::class, 'create'])->name('inputTestimoni');
Route::post('/testimoni', [TestimonialController::class, 'store'])
    ->middleware('throttle:5,1') // batasi 5 kiriman per menit per pengunjung
    ->name('testimoni.store');

// Admin
Route::get('/admin/login', [
    AdminAuthController::class,
    'showLogin',
])->name('admin.login');

Route::post('/admin/login', [
    AdminAuthController::class,
    'login',
])->middleware('throttle:5,1')->name('admin.login.submit');

Route::post('/admin/logout', [
    AdminAuthController::class,
    'logout',
])->middleware('auth')->name('admin.logout');

// TODO: bungkus dengan middleware auth setelah login admin tersedia
Route::prefix('admin/testimoni')
    ->name('admin.testimoni.')
    ->controller(TestimonialAdminController::class)
    ->middleware(['auth', 'admin'])
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/pending', 'pending')->name('pending');
        Route::patch('/{testimonial}/approve', 'approve')->name('approve');
        Route::delete('/{testimonial}', 'destroy')->name('destroy');
    });

// Admin: kelola event mendatang (hasil kolaborasi)
// TODO: bungkus dengan middleware auth setelah login admin tersedia
Route::prefix('admin/event')
    ->name('admin.event.')
    ->controller(EventAdminController::class)
    ->middleware(['auth', 'admin'])
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{event}/edit', 'edit')->name('edit');
        Route::put('/{event}', 'update')->name('update');
        Route::delete('/{event}', 'destroy')->name('destroy');
    });

// Admin: kelola "Sorotan event sebelumnya"
// TODO: bungkus dengan middleware auth setelah login admin tersedia
Route::prefix('admin/sorotan')
    ->name('admin.sorotan.')
    ->controller(EventHighlightAdminController::class)
    ->middleware(['auth', 'admin'])
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{highlight}/edit', 'edit')->name('edit');
        Route::put('/{highlight}', 'update')->name('update');
        Route::delete('/{highlight}', 'destroy')->name('destroy');
    });
