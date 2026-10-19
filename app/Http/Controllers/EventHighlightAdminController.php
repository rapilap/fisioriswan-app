<?php

namespace App\Http\Controllers;

use App\Models\EventHighlight;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class EventHighlightAdminController extends Controller
{
    private const PER_PAGE = 9;

    public function index(): View
    {
        $highlights = EventHighlight::query()->latest()->paginate(self::PER_PAGE);

        return view('admin.sorotan.index', compact('highlights'));
    }

    public function create(): View
    {
        return view('admin.sorotan.form', ['highlight' => new EventHighlight]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request, creating: true);
        $data['image'] = $request->file('image')->store('sorotan', 'public');

        $highlight = EventHighlight::create($data);

        return redirect()
            ->route('admin.sorotan.index')
            ->with('status', "Sorotan “{$highlight->title}” berhasil ditambahkan.");
    }

    public function edit(EventHighlight $highlight): View
    {
        return view('admin.sorotan.form', compact('highlight'));
    }

    public function update(Request $request, EventHighlight $highlight): RedirectResponse
    {
        $data = $this->validated($request, creating: false);

        // Foto hanya diganti jika admin memilih file baru.
        if ($request->hasFile('image')) {
            $fotoLama = $highlight->image;
            $data['image'] = $request->file('image')->store('sorotan', 'public');
            Storage::disk('public')->delete($fotoLama);
        }

        $highlight->update($data);

        return redirect()
            ->route('admin.sorotan.index')
            ->with('status', "Sorotan “{$highlight->title}” sudah diperbarui.");
    }

    public function destroy(EventHighlight $highlight): RedirectResponse
    {
        Storage::disk('public')->delete($highlight->image);
        $highlight->delete();

        return back()->with('status', "Sorotan “{$highlight->title}” telah dihapus.");
    }

    private function validated(Request $request, bool $creating): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:120'],
            'description' => ['required', 'string', 'max:200'],
            'image' => [$creating ? 'required' : 'nullable', 'file', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ], [
            'title.required' => 'Judul sorotan wajib diisi.',
            'title.max' => 'Judul maksimal 120 karakter.',
            'description.required' => 'Keterangan singkat wajib diisi.',
            'description.max' => 'Keterangan maksimal 200 karakter.',
            'image.required' => 'Foto wajib diunggah.',
            'image.mimes' => 'Foto harus berformat JPG, PNG, atau WEBP.',
            'image.max' => 'Ukuran foto maksimal 5 MB.',
            'image.uploaded' => 'Foto gagal diunggah. Pastikan ukurannya tidak lebih dari 5 MB.',
        ]);
    }
}
