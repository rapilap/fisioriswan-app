@extends('layouts.app')
@section('title', 'Event & Kolaborasi - Fisio Riswan')

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
    <section class="-mx-24 -mt-8 px-24 py-14 bg-white">
        <div class="load-in text-[13px] mb-8">
            @include('components.breadcrumb')
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="load-in flex flex-col gap-5" style="--load-delay: 100ms">
                <h1 class="font-fraunces font-semibold text-b1 text-4xl lg:text-5xl leading-tight">
                    Menghadirkan fisioterapi di setiap acara Anda
                </h1>
                <p class="text-gray-600 text-[15px] leading-relaxed">
                    Dari edukasi kesehatan komunitas hingga pendampingan medis di event olahraga — tim Pulihkan siap
                    berkolaborasi dengan instansi, klinik, dan penyelenggara acara.
                </p>
            </div>

            {{-- Letakkan foto di public/images/event/hero.jpg --}}
            @include('components.beranda-foto', [
                'src' => 'images/event/hero.jpg',
                'alt' => 'Tim fisioterapi Pulihkan di sebuah acara',
                'class' => 'aspect-[4/5] max-h-[560px] w-full',
                'load' => true,
                'delay' => 200,
            ])
        </div>
    </section>

    {{-- 2. Event mendatang --}}
    <section class="-mx-24 px-24 py-20">
        <div class="reveal mb-10">
            <span class="inline-block rounded-full bg-g5 text-g1 text-[12px] font-medium px-3 py-1 mb-4">Akan berlangsung</span>
            <h2 class="font-fraunces font-semibold text-b1 text-3xl">Event mendatang</h2>
        </div>

        <div class="flex flex-col gap-5">
            @forelse ($events as $event)
                <article class="reveal flex gap-5 rounded-2xl bg-white border border-gray-100 p-6 transition duration-300 hover:-translate-y-1 hover:shadow-lg"
                    style="--reveal-delay: {{ $loop->index * 80 }}ms">
                    <div class="shrink-0 flex flex-col items-center justify-center w-14 h-14 rounded-xl bg-b1 text-white">
                        <span class="font-semibold text-xl leading-none">{{ $event['tanggal'] }}</span>
                        <span class="text-[11px] mt-1">{{ $event['bulan'] }}</span>
                    </div>
                    <div class="flex flex-col gap-2 items-start">
                        <h3 class="font-fraunces font-semibold text-b1 text-lg">{{ $event['judul'] }}</h3>
                        <div class="flex flex-wrap gap-x-5 gap-y-1 text-[12px] text-gray-500">
                            <span class="inline-flex items-center gap-1.5">
                                @include('components.icon', ['name' => 'clock', 'class' => 'w-3.5 h-3.5'])
                                {{ $event['waktu'] }}
                            </span>
                            <span class="inline-flex items-center gap-1.5">
                                @include('components.icon', ['name' => 'map-pin', 'class' => 'w-3.5 h-3.5'])
                                {{ $event['lokasi'] }}
                            </span>
                        </div>
                        <p class="text-gray-600 text-[14px] leading-relaxed max-w-2xl">{{ $event['deskripsi'] }}</p>
                        <a href="{{ $waKolaborasi }}" target="_blank"
                            class="mt-2 inline-flex items-center rounded-full border border-gray-300 px-4 py-2 text-[13px] font-medium text-b1 transition hover:bg-b1 hover:text-white hover:border-b1">
                            Daftar Sekarang
                        </a>
                    </div>
                </article>
            @empty
                <p class="text-gray-500 text-[14px]">Belum ada event yang dijadwalkan.</p>
            @endforelse
        </div>
    </section>

    {{-- 3. Kolaborasi --}}
    <section class="-mx-24 px-24 py-20 bg-white">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="reveal flex flex-col gap-5">
                <span class="w-fit rounded-full bg-g5 text-g1 text-[12px] font-medium px-3 py-1">Kolaborasi</span>
                <h2 class="font-fraunces font-semibold text-b1 text-3xl leading-snug">
                    Bermitra dengan Pulihkan untuk acara Anda
                </h2>
                <p class="text-gray-600 text-[15px] leading-relaxed">
                    Kami bekerja sama dengan perusahaan, komunitas, klinik, dan penyelenggara olahraga untuk
                    menghadirkan layanan fisioterapi dan edukasi kesehatan langsung di lokasi acara.
                </p>
                <ul class="flex flex-col gap-3 text-[14px] text-gray-700">
                    @foreach ([
                        'Pendampingan medis di event olahraga & komunitas',
                        'Talkshow & webinar edukasi kesehatan untuk karyawan',
                        'Skrining kesehatan gratis untuk komunitas & RT/RW',
                    ] as $poin)
                        <li class="flex items-start gap-2.5">
                            <span class="shrink-0 mt-0.5 text-b1">
                                @include('components.icon', ['name' => 'check', 'class' => 'w-4 h-4'])
                            </span>
                            {{ $poin }}
                        </li>
                    @endforeach
                </ul>
                <a href="{{ $waKolaborasi }}" target="_blank"
                    class="mt-2 w-fit inline-flex items-center gap-2 rounded-full bg-g1 px-6 py-3 text-[14px] font-medium text-white transition hover:bg-g2">
                    Ajukan Kolaborasi
                </a>
            </div>

            {{-- Letakkan foto di public/images/event/kolaborasi.jpg --}}
            @include('components.beranda-foto', [
                'src' => 'images/event/kolaborasi.jpg',
                'alt' => 'Tim Pulihkan di lokasi event',
                'class' => 'aspect-[4/5] max-h-[560px] w-full',
            ])
        </div>
    </section>

    {{-- 4. Sorotan event sebelumnya --}}
    <section class="-mx-24 px-24 py-20">
        <div class="reveal mb-10">
            <span class="inline-block rounded-full bg-b5 text-b1 text-[12px] font-medium px-3 py-1 mb-4">Dokumentasi</span>
            <h2 class="font-fraunces font-semibold text-b1 text-3xl">Sorotan event sebelumnya</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($sorotan as $item)
                <article class="reveal group flex flex-col gap-4" style="--reveal-delay: {{ $loop->index * 80 }}ms">
                    <div class="relative aspect-[4/3] overflow-hidden rounded-2xl bg-b5/40">
                        <div class="absolute inset-0 flex flex-col items-center justify-center gap-2 text-b3">
                            @include('components.icon', ['name' => 'image', 'class' => 'w-9 h-9', 'stroke' => 1.5])
                            <span class="text-[11px]">public/{{ $item['foto'] }}</span>
                        </div>
                        <img src="{{ asset($item['foto']) }}" alt="{{ $item['judul'] }}" loading="lazy"
                            onerror="this.remove()"
                            class="relative w-full h-full object-cover transition duration-500 group-hover:scale-105">
                    </div>
                    <div>
                        <h3 class="font-semibold text-b1 text-[15px]">{{ $item['judul'] }}</h3>
                        <p class="text-gray-500 text-[13px] mt-0.5">{{ $item['keterangan'] }}</p>
                    </div>
                </article>
            @empty
                <p class="text-gray-500 text-[14px]">Belum ada dokumentasi event.</p>
            @endforelse
        </div>
    </section>

    {{-- CTA --}}
    <section class="-mx-24 px-24 pb-20">
        <div class="reveal flex flex-col gap-5 items-start rounded-3xl bg-b1 px-10 py-12 text-white">
            <h2 class="font-fraunces font-semibold text-3xl">Ingin berkolaborasi dengan kami?</h2>
            <p class="text-b5 text-[14px] max-w-xl">
                Ceritakan kebutuhan acara Anda, tim kami akan menyesuaikan bentuk kerja sama yang tepat.
            </p>
            <a href="{{ $waKolaborasi }}" target="_blank"
                class="inline-flex items-center rounded-full bg-g1 px-6 py-3 text-[14px] font-medium text-white transition hover:bg-g2">
                Hubungi Tim Kemitraan
            </a>
        </div>
    </section>
@endsection
