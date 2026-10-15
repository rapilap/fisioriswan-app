<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Testimonial::insert([
            [
                'fullname' => 'Andi Pratama',
                'city' => 'Kota Bandung',
                'image' => null,
                'testimonial' => 'Pelayanannya ramah dan sangat membantu.',
                'status' => 'approved',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'fullname' => 'Siti Rahma',
                'city' => 'Kota Cimahi',
                'image' => 'testimonials/testimonial-1.png',
                'testimonial' => 'Terapis menjelaskan kondisi dengan jelas.',
                'status' => 'approved',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'fullname' => 'Budi Santoso',
                'city' => 'Kabupaten Bandung',
                'image' => null,
                'testimonial' => 'Pengalaman terapi cukup nyaman.',
                'status' => 'approved',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
