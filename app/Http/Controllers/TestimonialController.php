<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TestimonialController extends Controller
{
    private const PER_PAGE = 6;

    /** Daftar testimoni yang sudah disetujui admin. */
    public function index(): View
    {
        $testimonials = Testimonial::query()
            ->where('status', 'approved')
            ->latest()
            ->paginate(self::PER_PAGE);

        return view('testimoni', compact('testimonials'));
    }

    /** Formulir pengiriman testimoni oleh pelanggan. */
    public function create(): View
    {
        return view('testimonials.create', [
            'cities' => config('testimonial.cities'),
        ]);
    }

    /** Simpan testimoni baru sebagai "pending" sampai ditinjau admin. */
    public function store(Request $request): RedirectResponse
    {
        $sukses = 'Terima kasih! Testimoni Anda sudah kami terima dan akan ditinjau terlebih dahulu sebelum ditampilkan.';

        // Jebakan spam (honeypot): bot mengisi kolom tersembunyi, manusia tidak.
        if ($request->filled('website')) {
            return redirect()->route('inputTestimoni')->with('status', $sukses);
        }

        $data = $request->validate([
            'fullname' => ['required', 'string', 'max:100'],
            'city' => ['required', Rule::in(config('testimonial.cities'))],
            'rating' => ['required', 'integer', 'between:1,5'],
            'testimonial' => ['required', 'string', 'min:10', 'max:1000'],
            // Maks. 5 MB; format foto umum. Isi file diperiksa, dan SVG (bisa berisi skrip) ditolak.
            'image' => ['nullable', 'file', 'image', 'mimes:jpg,jpeg,png,webp,gif,bmp', 'max:5120'],
        ], [
            'rating.required' => 'Silakan beri rating bintang.',
            'rating.between' => 'Rating harus antara 1 sampai 5 bintang.',
            'rating.integer' => 'Rating tidak valid.',
            'fullname.required' => 'Nama lengkap wajib diisi.',
            'fullname.max' => 'Nama lengkap maksimal 100 karakter.',
            'city.required' => 'Silakan pilih kota domisili.',
            'city.in' => 'Kota domisili tidak valid.',
            'testimonial.required' => 'Testimoni wajib diisi.',
            'testimonial.min' => 'Testimoni minimal 10 karakter.',
            'testimonial.max' => 'Testimoni maksimal 1000 karakter.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Foto harus berformat JPG, PNG, WEBP, GIF, atau BMP.',
            'image.max' => 'Ukuran foto maksimal 5 MB.',
            'image.uploaded' => 'Foto gagal diunggah. Pastikan ukurannya tidak lebih dari 5 MB.',
        ]);

        Testimonial::create([
            'fullname' => $data['fullname'],
            'city' => $data['city'],
            'testimonial' => $data['testimonial'],
            'rating' => $data['rating'],
            'image' => $request->file('image')?->store('testimonials', 'public'),
            'status' => 'pending',
        ]);

        return redirect()->route('inputTestimoni')->with('status', $sukses);
    }
}
