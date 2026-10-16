@extends('layouts.app')
@section('title', 'Event & Kolaborasi - Fisio Riswan')
@section('main_class', 'py-0')

@php
    $waKolaborasi = 'https://wa.me/62xxxxxxxxxxx?text=halo, saya ingin mengajukan kolaborasi event dengan Pulihkan!%0ANama: [Nama]%0AInstansi: [Instansi]';

    // TODO: ganti dengan data dari database / admin saat integrasi
    // Format: tanggal (angka), bulan (singkatan), judul, waktu, lokasi, deskripsi
    $events = $events ?? [
        ['tanggal' => '21', 'bulan' => 'OKT', 'judul' => 'Cek Kesehatan Gratis: Nyeri Sendi & Lansia', 'waktu' => '09.00 – 12.00 WIB', 'lokasi' => 'Balai Warga Kemang, Jakarta Selatan', 'deskripsi' => 'Skrining gratis dan konsultasi singkat bersama fisioterapis Pulihkan untuk warga usia 50 tahun ke atas.'],
        ['tanggal' => '08', 'bulan' => 'NOV', 'judul' => 'Pendampingan Fisioterapi — Bandung City Run 10K', 'waktu' => '05.30 – 10.00 WIB', 'lokasi' => 'Lapangan Gasibu, Bandung', 'deskripsi' => 'Tim fisioterapis siaga di titik finish untuk penanganan cedera ringan dan pemulihan pasca-lari.'],
        ['tanggal' => '29', 'bulan' => 'NOV', 'judul' => 'Webinar: Mengenal Tanda Awal Saraf Kejepit', 'waktu' => '19.00 – 20.30 WIB', 'lokasi' => 'Daring via Zoom', 'deskripsi' => 'Sesi edukasi bersama fisioterapis senior kami, terbuka untuk umum dan gratis.'],
    ];

    // TODO: ganti dengan data dokumentasi event dari admin
    // 'foto' = path di folder public, mis. images/event/sorotan-1.jpg
    $sorotan = $sorotan ?? [
        ['judul' => 'Fun Run Jakarta 2026', 'keterangan' => 'Pendampingan 300+ pelari', 'foto' => 'images/event/sorotan-1.jpg'],
        ['judul' => 'Posyandu Lansia Bekasi', 'keterangan' => 'Skrining gratis 120 warga', 'foto' => 'images/event/sorotan-2.jpg'],
        ['judul' => 'Health Talk Kantor XYZ', 'keterangan' => 'Edukasi ergonomi untuk 80 karyawan', 'foto' => 'images/event/sorotan-3.jpg'],
    ];
@endphp

@section('content')
    {{-- 1. Hero --}}
    <section class="bg-cream px-6 py-18">
        <div class="mx-auto max-w-6xl">
            <div class="load-in mb-6">
                @include('components.breadcrumb')
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-14 items-center">
                <div class="load-in" style="--load-delay: 100ms">
                    <h1 class="font-fraunces font-semibold text-primary text-[48px] leading-[1.1] max-w-[480px]">
                        Menghadirkan fisioterapi di setiap acara Anda
                    </h1>
                    <p class="mt-5 max-w-[680px] text-[18px] leading-[1.75] text-secondary">
                        Dari edukasi kesehatan komunitas hingga pendampingan medis di event olahraga — tim Pulihkan
                        siap berkolaborasi dengan instansi, klinik, dan penyelenggara acara.
                    </p>
                </div>

                {{-- Letakkan foto di public/images/event/hero.jpg --}}
                @include('components.beranda-foto', [
                    'src' => 'images/event/hero.jpg',
                    'alt' => 'Tim fisioterapi Pulihkan di sebuah acara',
                    'caption' => 'Tim fisioterapi di sebuah acara',
                    'icon' => 'users',
                    'class' => 'aspect-[4/5] w-full',
                    'load' => true,
                    'delay' => 200,
                ])
            </div>
        </div>
    </section>

    {{-- 2. Event mendatang --}}
    <section class="bg-sage px-6 py-22">
        <div class="mx-auto max-w-6xl">
            <div class="reveal mb-12">
                <span class="inline-block rounded-full bg-pill px-3 py-2 text-[12px] leading-[13px] font-semibold text-g2">
                    Akan berlangsung
                </span>
                <h2 class="mt-5 font-fraunces font-semibold text-primary text-[42px] leading-[1.1]">Event mendatang</h2>
            </div>

            <div class="flex flex-col gap-5">
                @forelse ($events as $event)
                    <article class="reveal flex gap-5.5 rounded-2xl border border-line bg-white p-7 transition duration-300 hover:shadow-lg"
                        style="--reveal-delay: {{ $loop->index * 80 }}ms">
                        <div class="shrink-0 flex h-[74px] w-[74px] flex-col items-center justify-center rounded-xl bg-b1 text-white">
                            <span class="text-[24px] leading-none font-bold">{{ $event['tanggal'] }}</span>
                            <span class="mt-1.5 text-[12px] leading-none">{{ $event['bulan'] }}</span>
                        </div>

                        <div class="flex flex-col items-start gap-2">
                            <h3 class="font-fraunces font-semibold text-primary text-[22px] leading-tight">
                                {{ $event['judul'] }}
                            </h3>
                            <div class="flex flex-wrap gap-x-5 gap-y-1 text-[13px] text-secondary">
                                <span class="inline-flex items-center gap-1.5">
                                    @include('components.icon', ['name' => 'clock', 'class' => 'w-3.5 h-3.5'])
                                    {{ $event['waktu'] }}
                                </span>
                                <span class="inline-flex items-center gap-1.5">
                                    @include('components.icon', ['name' => 'map-pin', 'class' => 'w-3.5 h-3.5'])
                                    {{ $event['lokasi'] }}
                                </span>
                            </div>
                            <p class="max-w-[660px] text-[15px] leading-relaxed text-secondary">{{ $event['deskripsi'] }}</p>
                            <a href="{{ $waKolaborasi }}" target="_blank"
                                class="mt-3 inline-flex items-center rounded-full border border-line px-4.5 py-2.5 text-[14px] font-semibold text-primary transition hover:border-b1 hover:bg-b1 hover:text-white">
                                Daftar Sekarang
                            </a>
                        </div>
                    </article>
                @empty
                    <p class="text-[14px] text-secondary">Belum ada event yang dijadwalkan.</p>
                @endforelse
            </div>
        </div>
    </section>

    {{-- 3. Kolaborasi --}}
    <section class="bg-cream px-6 py-22">
        <div class="mx-auto max-w-6xl grid grid-cols-1 lg:grid-cols-2 gap-14 items-center">
            <div class="reveal">
                <span class="inline-block rounded-full bg-pill px-3 py-2 text-[12px] leading-[13px] font-semibold text-g2">
                    Kolaborasi
                </span>
                <h2 class="mt-5 font-fraunces font-semibold text-primary text-[42px] leading-[1.1]">
                    Bermitra dengan Pulihkan untuk acara Anda
                </h2>
                <p class="mt-4 text-[16px] leading-relaxed text-secondary">
                    Kami bekerja sama dengan perusahaan, komunitas, klinik, dan penyelenggara olahraga untuk
                    menghadirkan layanan fisioterapi dan edukasi kesehatan langsung di lokasi acara.
                </p>
                <ul class="mt-5 flex flex-col gap-4 text-[16px] text-secondary">
                    @foreach ([
                        'Pendampingan medis di event olahraga & komunitas',
                        'Talkshow & webinar edukasi kesehatan untuk karyawan',
                        'Skrining kesehatan gratis untuk komunitas & RT/RW',
                    ] as $poin)
                        <li class="flex items-center gap-3.5">
                            <span class="shrink-0 text-b1">
                                @include('components.icon', ['name' => 'check', 'class' => 'w-4 h-4'])
                            </span>
                            {{ $poin }}
                        </li>
                    @endforeach
                </ul>
                <a href="{{ $waKolaborasi }}" target="_blank"
                    class="mt-8 inline-flex items-center rounded-full bg-g1 px-7 py-4 text-[15px] font-semibold text-white transition hover:bg-g2">
                    Ajukan Kolaborasi
                </a>
            </div>

            {{-- Letakkan foto di public/images/event/kolaborasi.jpg --}}
            @include('components.beranda-foto', [
                'src' => 'images/event/kolaborasi.jpg',
                'alt' => 'Tim Pulihkan di lokasi event',
                'caption' => 'Tim di lokasi event',
                'icon' => 'users',
                'class' => 'aspect-[4/5] w-full',
            ])
        </div>
    </section>

    {{-- 4. Sorotan event sebelumnya --}}
    <section class="bg-sage px-6 pt-22">
        <div class="mx-auto max-w-6xl">
            <div class="reveal mb-12">
                <span class="inline-block rounded-full bg-pill-green px-3 py-2 text-[12px] leading-[13px] font-semibold text-g2">
                    Dokumentasi
                </span>
                <h2 class="mt-5 font-fraunces font-semibold text-primary text-[42px] leading-[1.1]">
                    Sorotan event sebelumnya
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($sorotan as $item)
                    <article class="reveal" style="--reveal-delay: {{ $loop->index * 80 }}ms">
                        @include('components.beranda-foto', [
                            'src' => $item['foto'],
                            'alt' => $item['judul'],
                            'caption' => $item['judul'],
                            'icon' => 'image',
                            'iconClass' => 'w-13 h-13',
                            'radius' => 'rounded-[20px]',
                            'class' => 'aspect-[4/3] w-full',
                            'reveal' => false,
                        ])
                        <h3 class="mt-4 text-[16px] font-semibold text-primary">{{ $item['judul'] }}</h3>
                        <p class="mt-1 text-[14px] text-secondary">{{ $item['keterangan'] }}</p>
                    </article>
                @empty
                    <p class="text-[14px] text-secondary">Belum ada dokumentasi event.</p>
                @endforelse
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="bg-sage px-6 py-22">
        <div class="mx-auto max-w-6xl">
            <div class="reveal rounded-3xl bg-b1 px-14 py-14 text-white">
                <h2 class="font-fraunces font-semibold text-[38px] leading-[1.15]">Ingin berkolaborasi dengan kami?</h2>
                <p class="mt-3 text-[16px] text-b5">
                    Ceritakan kebutuhan acara Anda, tim kami akan menyesuaikan bentuk kerja sama yang tepat.
                </p>
                <a href="{{ $waKolaborasi }}" target="_blank"
                    class="mt-8 inline-flex items-center rounded-full bg-g1 px-7 py-4 text-[15px] font-semibold text-white transition hover:bg-g2">
                    Hubungi Tim Kemitraan
                </a>
            </div>
        </div>
    </section>
@endsection
