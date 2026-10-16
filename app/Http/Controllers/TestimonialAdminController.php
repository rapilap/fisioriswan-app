<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class TestimonialAdminController extends Controller
{
    private const PER_PAGE = 6;

    /** Daftar testimoni yang sudah disetujui (tampil di beranda). */
    public function index(): View
    {
        return $this->listing('approved', 'published');
    }

    /** Testimoni baru yang menunggu ditinjau admin. */
    public function pending(): View
    {
        return $this->listing('pending', 'pending');
    }

    public function approve(Testimonial $testimonial): RedirectResponse
    {
        $testimonial->update(['status' => 'approved']);

        return back()->with('status', "Testimoni dari {$testimonial->fullname} sekarang ditampilkan di beranda.");
    }

    public function destroy(Testimonial $testimonial): RedirectResponse
    {
        if ($testimonial->image) {
            Storage::disk('public')->delete($testimonial->image);
        }

        $testimonial->delete();

        return back()->with('status', "Testimoni dari {$testimonial->fullname} telah dihapus.");
    }

    private function listing(string $status, string $mode): View
    {
        $testimonials = Testimonial::query()
            ->where('status', $status)
            ->latest()
            ->paginate(self::PER_PAGE);

        return view('testimoniadmin', compact('testimonials', 'mode'));
    }
}
