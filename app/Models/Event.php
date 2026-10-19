<?php

namespace App\Models;

use App\Support\EventFormat;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    /** Zona waktu untuk menentukan "hari ini" (server default-nya UTC). */
    public const TIMEZONE = 'Asia/Jakarta';

    /** Batas jumlah hari satu event (mencegah salah ketik, mis. 300 hari). */
    public const MAKS_HARI = 30;

    protected $fillable = [
        'title',
        'event_date',
        'end_date',
        'start_time',
        'end_time',
        'location',
        'description',
        'registration_url',
    ];

    protected $casts = [
        'event_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Event yang belum selesai, paling dekat dulu. Event beberapa hari tetap dihitung
     * "mendatang" selama hari terakhirnya belum lewat (termasuk yang sedang berlangsung).
     */
    public function scopeUpcoming(Builder $query): Builder
    {
        return $query
            ->whereRaw('COALESCE(end_date, event_date) >= ?', [now(self::TIMEZONE)->toDateString()])
            ->orderBy('event_date')
            ->orderBy('start_time');
    }

    /** Event yang seluruh harinya sudah lewat, terbaru dulu. */
    public function scopePast(Builder $query): Builder
    {
        return $query
            ->whereRaw('COALESCE(end_date, event_date) < ?', [now(self::TIMEZONE)->toDateString()])
            ->orderByDesc('event_date')
            ->orderByDesc('start_time');
    }

    public function isUpcoming(): bool
    {
        return $this->tanggalAkhir()->toDateString() >= now(self::TIMEZONE)->toDateString();
    }

    /** Hari terakhir event (sama dengan hari pertama untuk event satu hari). */
    public function tanggalAkhir(): CarbonInterface
    {
        return $this->end_date ?? $this->event_date;
    }

    /** Jumlah hari event berlangsung, minimal 1. */
    public function jumlahHari(): int
    {
        $selisih = $this->tanggalAkhir()->timestamp - $this->event_date->timestamp;

        return max(1, (int) round($selisih / 86400) + 1);
    }

    public function berlangsungBeberapaHari(): bool
    {
        return $this->jumlahHari() > 1;
    }

    /** "21" atau "21–23" (angka di lencana tanggal) */
    public function tanggalAngka(): string
    {
        return EventFormat::lencanaAngka($this->event_date, $this->tanggalAkhir());
    }

    /** "OKT" atau "OKT–NOV" (bulan di lencana tanggal) */
    public function bulanSingkat(): string
    {
        return EventFormat::lencanaBulan($this->event_date, $this->tanggalAkhir());
    }

    /** "21 Oktober 2026" atau "21 – 23 Oktober 2026" */
    public function tanggalLengkap(): string
    {
        return EventFormat::rentang($this->event_date, $this->tanggalAkhir());
    }

    /** "21 – 23 Oktober 2026 · 3 hari" untuk event beberapa hari, selain itu null. */
    public function rentangDenganDurasi(): ?string
    {
        return $this->berlangsungBeberapaHari()
            ? $this->tanggalLengkap().' · '.$this->jumlahHari().' hari'
            : null;
    }

    /** "09.00 – 12.00 WIB" (untuk event beberapa hari ditambah "setiap hari") */
    public function waktuLabel(): string
    {
        $waktu = EventFormat::waktu($this->start_time, $this->end_time);

        return $this->berlangsungBeberapaHari() ? $waktu.' setiap hari' : $waktu;
    }

    public function linkRingkas(): ?string
    {
        return EventFormat::linkRingkas($this->registration_url);
    }
}
