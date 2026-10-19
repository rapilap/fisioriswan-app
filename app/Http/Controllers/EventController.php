<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventHighlight;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class EventController extends Controller
{
    /** Jumlah sorotan yang ditampilkan di halaman Event. */
    private const SOROTAN_LIMIT = 6;

    public function index(): View
    {
        // Jika tabel belum ada (belum migrate), view memakai data contoh.
        if (! Schema::hasTable('events') || ! Schema::hasTable('event_highlights')) {
            return view('event');
        }

        $events = Event::upcoming()
            ->get()
            ->map(fn (Event $e) => [
                'tanggal' => $e->tanggalAngka(),
                'bulan' => $e->bulanSingkat(),
                'rentang' => $e->rentangDenganDurasi(), // hanya terisi untuk event beberapa hari
                'judul' => $e->title,
                'waktu' => $e->waktuLabel(),
                'lokasi' => $e->location,
                'deskripsi' => $e->description,
                'link' => $e->registration_url,
            ])
            ->all();

        $sorotan = EventHighlight::query()
            ->latest()
            ->take(self::SOROTAN_LIMIT)
            ->get()
            ->map(fn (EventHighlight $h) => [
                'judul' => $h->title,
                'keterangan' => $h->description,
                'foto' => $h->imagePath(),
            ])
            ->all();

        return view('event', compact('events', 'sorotan'));
    }
}
