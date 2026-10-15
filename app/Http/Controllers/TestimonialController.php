<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;

use App\Models\Testimonial;
use Illuminate\View\View;

class TestimonialController extends Controller
{
    public function index(): View
    {
        $testimonials = Testimonial::query()
        ->where('status', 'approved')
        ->latest()
        ->get();

        return view('testimoni', compact('testimonials'));
    }

    public function create(): View
    {
        return view('testimonials.create', [
            'cities' => config('testimonial.cities'),
        ]);
    }

}
