<?php

namespace App\Support;

use App\Models\Testimonial;

/**
 * Statistik Beranda: angka awal + kontribusi tiap testimoni yang sudah disetujui admin.
 *
 *  - Pasien dilayani : awal + 1 per testimoni
 *  - Sesi terapi     : awal + jumlah kunjungan paket yang diambil
 *  - Rating          : rata-rata dari seluruh pasien awal + rating tiap testimoni baru
 *
 * Dihitung saat halaman dibuka, jadi menyetujui / menarik testimoni langsung tercermin.
 */
class ClinicStats
{
    /** @return array{patients: int, sessions: int, rating: float} */
    public static function get(): array
    {
        $base = config('testimonial.stats_base');
        $paket = config('testimonial.packages');

        $patients = $base['patients'];
        $sessions = $base['sessions'];
        $ratingTotal = $base['rating'] * $base['patients'];
        $ratingCount = $base['patients'];

        Testimonial::query()
            ->where('status', 'approved')
            ->get(['package', 'rating'])
            ->each(function (Testimonial $t) use (&$patients, &$sessions, &$ratingTotal, &$ratingCount, $paket) {
                $patients++;
                $sessions += $paket[$t->package]['visits'] ?? 0;
                $ratingTotal += $t->rating;
                $ratingCount++;
            });

        return [
            'patients' => $patients,
            'sessions' => $sessions,
            'rating' => round($ratingTotal / $ratingCount, 1),
        ];
    }

    public static function formatRating(float $rating): string
    {
        return (floor($rating) == $rating ? (string) (int) $rating : number_format($rating, 1, '.', '')).'/5';
    }
}
