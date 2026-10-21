<?php

namespace App\Support;

use Carbon\CarbonInterface;

/**
 * Format tanggal dan jam event dalam bahasa Indonesia.
 * Sengaja dipisah dari model agar mudah diuji dan tidak bergantung pada locale aplikasi.
 */
final class EventFormat
{
    public const BULAN = [
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember',
    ];

    public const BULAN_SINGKAT = [
        1 => 'JAN', 'FEB', 'MAR', 'APR', 'MEI', 'JUN',
        'JUL', 'AGU', 'SEP', 'OKT', 'NOV', 'DES',
    ];

    /** "09:00", "12:00" → "09.00 – 12.00 WIB". Tanpa jam selesai → "09.00 WIB". */
    public static function waktu(string $mulai, ?string $selesai = null): string
    {
        $titik = fn (string $jam) => str_replace(':', '.', substr($jam, 0, 5));

        return $selesai
            ? $titik($mulai).' – '.$titik($selesai).' WIB'
            : $titik($mulai).' WIB';
    }

    /** (21, 10, 2026) → "21 Oktober 2026" */
    public static function tanggal(int $hari, int $bulan, int $tahun): string
    {
        return $hari.' '.self::BULAN[$bulan].' '.$tahun;
    }

    /**
     * Rentang tanggal event:
     *   satu hari        → "21 Oktober 2026"
     *   bulan yang sama  → "21 – 23 Oktober 2026"
     *   beda bulan       → "30 Oktober – 2 November 2026"
     *   beda tahun       → "30 Desember 2026 – 2 Januari 2027"
     */
    public static function rentang(CarbonInterface $mulai, ?CarbonInterface $selesai = null): string
    {
        $akhir = $selesai ? self::tanggal($selesai->day, $selesai->month, $selesai->year) : null;

        if (! $selesai || self::sehari($mulai, $selesai)) {
            return self::tanggal($mulai->day, $mulai->month, $mulai->year);
        }

        if ($mulai->year === $selesai->year && $mulai->month === $selesai->month) {
            return $mulai->day.' – '.$akhir;
        }

        if ($mulai->year === $selesai->year) {
            return $mulai->day.' '.self::BULAN[$mulai->month].' – '.$akhir;
        }

        return self::tanggal($mulai->day, $mulai->month, $mulai->year).' – '.$akhir;
    }

    /** Angka di lencana tanggal: "21", "21–23", atau "30–02" (beda bulan). */
    public static function lencanaAngka(CarbonInterface $mulai, ?CarbonInterface $selesai = null): string
    {
        if (! $selesai || self::sehari($mulai, $selesai)) {
            return $mulai->format('d');
        }

        return $mulai->format('d').'–'.$selesai->format('d');
    }

    /** Bulan di lencana tanggal: "OKT", atau "OKT–NOV" bila melewati pergantian bulan. */
    public static function lencanaBulan(CarbonInterface $mulai, ?CarbonInterface $selesai = null): string
    {
        $awal = self::BULAN_SINGKAT[$mulai->month];

        if (! $selesai || self::sehari($mulai, $selesai) || $selesai->month === $mulai->month) {
            return $awal;
        }

        return $awal.'–'.self::BULAN_SINGKAT[$selesai->month];
    }

    /** "https://www.forms.gle/abc" → "forms.gle/abc" (untuk ditampilkan ringkas di admin). */
    public static function linkRingkas(?string $url, int $maks = 48): ?string
    {
        if (! $url) {
            return null;
        }

        $ringkas = preg_replace('~^https?://(www\.)?~i', '', $url);
        $ringkas = rtrim($ringkas, '/');

        return mb_strlen($ringkas) > $maks ? mb_substr($ringkas, 0, $maks - 1).'…' : $ringkas;
    }

    private static function sehari(CarbonInterface $a, CarbonInterface $b): bool
    {
        return $a->format('Y-m-d') === $b->format('Y-m-d');
    }
}
