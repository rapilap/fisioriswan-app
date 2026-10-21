<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;

/**
 * Contoh data agar halaman Event dan batas "3 terlihat, sisanya digulir" bisa langsung dicoba.
 * Jalankan: php artisan db:seed --class=EventSeeder
 */
class EventSeeder extends Seeder
{
    public function run(): void
    {
        if (Event::query()->exists()) {
            return;
        }

        $hari = fn (int $tambah) => now(Event::TIMEZONE)->addDays($tambah)->toDateString();

        $contoh = [
            [
                'title' => 'Cek Kesehatan Gratis: Nyeri Sendi & Lansia',
                'event_date' => $hari(3),
                'start_time' => '09:00',
                'end_time' => '12:00',
                'location' => 'Balai Warga Kemang, Jakarta Selatan',
                'description' => 'Skrining gratis dan konsultasi singkat bersama fisioterapis Pulihkan untuk warga usia 50 tahun ke atas.',
                'registration_url' => 'https://forms.gle/contoh-cek-kesehatan',
            ],
            [
                'title' => 'Pendampingan Fisioterapi — Bandung City Run 10K',
                'event_date' => $hari(21),
                'end_date' => $hari(22), // contoh event dua hari
                'start_time' => '05:30',
                'end_time' => '10:00',
                'location' => 'Lapangan Gasibu, Bandung',
                'description' => 'Tim fisioterapis siaga di titik finish untuk penanganan cedera ringan dan pemulihan pasca-lari.',
                'registration_url' => 'https://forms.gle/contoh-city-run',
            ],
            [
                'title' => 'Webinar: Mengenal Tanda Awal Saraf Kejepit',
                'event_date' => $hari(30),
                'start_time' => '19:00',
                'end_time' => '20:30',
                'location' => 'Daring via Zoom',
                'description' => 'Sesi edukasi bersama fisioterapis senior kami, terbuka untuk umum dan gratis.',
                'registration_url' => 'https://zoom.us/webinar/register/contoh',
            ],
            [
                'title' => 'Talkshow Ergonomi untuk Karyawan Kantor',
                'event_date' => $hari(45),
                'start_time' => '13:00',
                'end_time' => '15:00',
                'location' => 'Aula Kantor Mitra, Kota Bandung',
                'description' => 'Edukasi posisi duduk dan peregangan singkat untuk mencegah nyeri punggung dan leher akibat kerja di depan layar.',
                'registration_url' => null,
            ],
            [
                'title' => 'Posyandu Lansia Bersama Komunitas',
                'event_date' => $hari(60),
                'start_time' => '08:00',
                'end_time' => null,
                'location' => 'Balai RW 05, Kota Cimahi',
                'description' => 'Pemeriksaan keseimbangan dan latihan gerak ringan untuk lansia bersama kader posyandu setempat.',
                'registration_url' => 'https://wa.me/62xxxxxxxxxxx',
            ],
        ];

        foreach ($contoh as $event) {
            Event::create($event);
        }
    }
}
