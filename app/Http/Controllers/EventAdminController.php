<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class EventAdminController extends Controller
{
    private const PER_PAGE = 10;

    /** Daftar event. Tab "mendatang" (default) atau "lewat". */
    public function index(Request $request): View
    {
        $tampil = $request->query('tampil') === 'lewat' ? 'lewat' : 'mendatang';

        $events = ($tampil === 'lewat' ? Event::past() : Event::upcoming())
            ->paginate(self::PER_PAGE)
            ->withQueryString();

        return view('admin.event.index', [
            'events' => $events,
            'tampil' => $tampil,
            'jumlahMendatang' => Event::upcoming()->count(),
            'jumlahLewat' => Event::past()->count(),
        ]);
    }

    public function create(): View
    {
        return view('admin.event.form', ['event' => new Event]);
    }

    public function store(Request $request): RedirectResponse
    {
        $event = Event::create($this->validated($request, creating: true));

        return redirect()
            ->route('admin.event.index')
            ->with('status', "Event “{$event->title}” berhasil ditambahkan dan tampil di halaman Event.");
    }

    public function edit(Event $event): View
    {
        return view('admin.event.form', compact('event'));
    }

    public function update(Request $request, Event $event): RedirectResponse
    {
        $event->update($this->validated($request, creating: false));

        return redirect()
            ->route('admin.event.index', $event->isUpcoming() ? [] : ['tampil' => 'lewat'])
            ->with('status', "Perubahan event “{$event->title}” sudah disimpan.");
    }

    public function destroy(Event $event): RedirectResponse
    {
        $event->delete();

        return back()->with('status', "Event “{$event->title}” telah dihapus.");
    }

    private function validated(Request $request, bool $creating): array
    {
        // Admin sering menempel link tanpa "https://" (mis. "wa.me/62..."); lengkapi otomatis.
        $request->merge(['registration_url' => $this->lengkapiUrl($request->input('registration_url'))]);

        $hariIni = now(Event::TIMEZONE)->toDateString();

        $data = $request->validate([
            'title' => ['required', 'string', 'max:120'],
            // Jumlah hari event berlangsung (1 = satu hari). Tanggal selesai dihitung dari sini.
            'days' => ['nullable', 'integer', 'min:1', 'max:'.Event::MAKS_HARI],
            // Event baru tidak boleh di masa lalu; saat mengedit, event lama tetap boleh disimpan.
            'event_date' => ['required', 'date_format:Y-m-d', ...($creating ? ["after_or_equal:{$hariIni}"] : [])],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['nullable', 'date_format:H:i', ...((int) $request->input('days', 1) === 1 ? ['after:start_time'] : [])],
            'location' => ['required', 'string', 'max:150'],
            'description' => ['required', 'string', 'max:500'],
            // Hanya http/https: menolak "javascript:" dan skema berbahaya lain.
            'registration_url' => ['nullable', 'url:http,https', 'max:2048'],
        ], [
            'title.required' => 'Judul event wajib diisi.',
            'title.max' => 'Judul event maksimal 120 karakter.',
            'event_date.required' => 'Tanggal event wajib diisi.',
            'event_date.date_format' => 'Format tanggal tidak valid.',
            'event_date.after_or_equal' => 'Tanggal event tidak boleh di masa lalu.',
            'days.integer' => 'Jumlah hari harus berupa angka.',
            'days.min' => 'Jumlah hari minimal 1.',
            'days.max' => 'Jumlah hari maksimal '.Event::MAKS_HARI.'.',
            'start_time.required' => 'Jam mulai wajib diisi.',
            'start_time.date_format' => 'Format jam mulai tidak valid.',
            'end_time.date_format' => 'Format jam selesai tidak valid.',
            'end_time.after' => 'Jam selesai harus setelah jam mulai.',
            'location.required' => 'Lokasi event wajib diisi.',
            'location.max' => 'Lokasi maksimal 150 karakter.',
            'description.required' => 'Deskripsi event wajib diisi.',
            'description.max' => 'Deskripsi maksimal 500 karakter.',
            'registration_url.url' => 'Link pendaftaran tidak valid. Contoh: https://forms.gle/abc123',
            'registration_url.max' => 'Link pendaftaran terlalu panjang.',
        ]);

        // Jumlah hari → tanggal selesai (kosong untuk event satu hari)
        $hari = (int) ($data['days'] ?? 1);
        unset($data['days']);
        $data['end_date'] = $hari > 1
            ? Carbon::parse($data['event_date'])->addDays($hari - 1)->toDateString()
            : null;

        return $data;
    }

    private function lengkapiUrl(?string $url): ?string
    {
        $url = trim((string) $url);

        if ($url === '') {
            return null;
        }

        return preg_match('~^https?://~i', $url) ? $url : "https://{$url}";
    }
}
