<?php

namespace Tests\Feature;

use App\Models\Testimonial;
use App\Support\ClinicStats;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClinicStatsTest extends TestCase
{
    use RefreshDatabase;

    private function testimoni(string $status, ?string $paket, int $rating): void
    {
        Testimonial::create([
            'fullname' => 'Budi', 'city' => 'Kota Bandung', 'package' => $paket,
            'testimonial' => 'Pelayanan sangat baik.', 'rating' => $rating, 'status' => $status,
        ]);
    }

    public function test_angka_awal_tanpa_testimoni(): void
    {
        $this->assertSame(['patients' => 727, 'sessions' => 928, 'rating' => 4.87], ClinicStats::get());
        $this->get('/')->assertSee('727')->assertSee('928')->assertSee('4.87/5');
    }

    public function test_testimoni_disetujui_menambah_pasien_sesi_dan_rata_rata_rating(): void
    {
        $this->testimoni('approved', 'paket-intensif', 3);     // +1 pasien, +8 sesi
        $this->testimoni('approved', 'kunjungan-tunggal', 4);  // +1 pasien, +1 sesi
        $this->testimoni('pending', 'paket-intensif-plus', 1); // belum disetujui: tidak dihitung

        $stats = ClinicStats::get();

        $this->assertSame(729, $stats['patients']);
        $this->assertSame(937, $stats['sessions']);
        // (4.89367 × 727 + 3 + 4) / 729 = 4.890 → 4.9
        $this->assertSame(4.87, $stats['rating']);
    }

    public function test_rating_turun_bila_banyak_rating_rendah(): void
    {
        for ($i = 0; $i < 73; $i++) {
            $this->testimoni('approved', null, 1);
        }

        // (4.89367 × 727 + 73) / 800 = 4.539 → 4.5
        $this->assertSame(4.5, ClinicStats::get()['rating']);
        $this->assertSame('4.5/5', ClinicStats::formatRating(4.5));
    }

    public function test_formulir_wajib_memilih_paket_yang_valid(): void
    {
        $data = ['fullname' => 'Ani', 'city' => 'Kota Bandung', 'rating' => 5, 'testimonial' => 'Pelayanan sangat baik.'];

        $this->post(route('testimoni.store'), $data)->assertSessionHasErrors('package');
        $this->post(route('testimoni.store'), $data + ['package' => 'paket-palsu'])->assertSessionHasErrors('package');
        $this->post(route('testimoni.store'), $data + ['package' => 'paket-intensif'])->assertSessionHasNoErrors();

        $this->assertSame('paket-intensif', Testimonial::first()->package);
    }
}
