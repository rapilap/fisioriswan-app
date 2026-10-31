@extends('layouts.app')
@section('title', 'Event & Kolaborasi - Fisio Riswan')
@section('main_class', 'py-0')

@php
    $waKolaborasi =
        'https://wa.me/62xxxxxxxxxxx?text=halo, saya ingin mengajukan kolaborasi event dengan Ermaya!%0ANama: [Nama]%0AInstansi: [Instansi]';

    // Data asli dikirim EventController dari database (admin: menu Event). Contoh ini hanya tampil sebelum migrate.
    // Format: tanggal (angka), bulan (singkatan), judul, waktu, lokasi, deskripsi, link (tombol Daftar Sekarang)
    $events = $events ?? [
        [
            'tanggal' => '21',
            'bulan' => 'OKT',
            'judul' => 'Cek Kesehatan Gratis: Nyeri Sendi & Lansia',
            'waktu' => '09.00 – 12.00 WIB',
            'lokasi' => 'Balai Warga Kemang, Jakarta Selatan',
            'deskripsi' =>
                'Skrining gratis dan konsultasi singkat bersama fisioterapis Ermaya untuk warga usia 50 tahun ke atas.',
            'link' => '#',
        ],
        [
            'tanggal' => '08',
            'bulan' => 'NOV',
            'judul' => 'Pendampingan Fisioterapi — Bandung City Run 10K',
            'waktu' => '05.30 – 10.00 WIB',
            'lokasi' => 'Lapangan Gasibu, Bandung',
            'deskripsi' =>
                'Tim fisioterapis siaga di titik finish untuk penanganan cedera ringan dan pemulihan pasca-lari.',
            'link' => '#',
        ],
        [
            'tanggal' => '29',
            'bulan' => 'NOV',
            'judul' => 'Webinar: Mengenal Tanda Awal Saraf Kejepit',
            'waktu' => '19.00 – 20.30 WIB',
            'lokasi' => 'Daring via Zoom',
            'deskripsi' => 'Sesi edukasi bersama fisioterapis senior kami, terbuka untuk umum dan gratis.',
            'link' => '#',
        ],
    ];

    // Data asli dari admin (menu Sorotan Event). 'foto' = path di folder public.
    $sorotan = $sorotan ?? [
        [
            'judul' => 'Fun Run Jakarta 2026',
            'keterangan' => 'Pendampingan 300+ pelari',
            'foto' => 'images/event/sorotan-1.jpg',
        ],
        [
            'judul' => 'Posyandu Lansia Bekasi',
            'keterangan' => 'Skrining gratis 120 warga',
            'foto' => 'images/event/sorotan-2.jpg',
        ],
        [
            'judul' => 'Health Talk Kantor XYZ',
            'keterangan' => 'Edukasi ergonomi untuk 80 karyawan',
            'foto' => 'images/event/sorotan-3.jpg',
        ],
    ];
@endphp

@section('content')
    {{-- 1. Hero --}}
    <section class="bg-(--bg-primary) px-6 py-18">
        <div class="mx-auto max-w-6xl">
            <div class="load-in mb-6">
                @include('components.breadcrumb')
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-14 items-center">
                <div class="load-in" style="--load-delay: 100ms">
                    <h1 class="font-fraunces font-semibold text-(--text-primary) text-[48px] leading-[1.1] max-w-120">
                        Menghadirkan fisioterapi di setiap acara Anda
                    </h1>
                    <p class="mt-5 max-w-170 text-[18px] leading-[1.75] text-(--text-paragraph)">
                        tim Ermaya Physio siap berkolaborasi dengan instansi, dan penyelenggara acara untuk
                        menghadirkan layanan fisioterapi dan edukasi kesehatan langsung di lokasi acara.
                    </p>
                </div>

                {{-- Letakkan foto di public/images/event/hero.jpg --}}
                @include('components.beranda-foto', [
                    'src' => 'images/event/hero.jpg',
                    'alt' => 'Tim fisioterapi Ermaya di sebuah acara',
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
    <section class="bg-(--bg-secondary) px-6 py-22">
        <div class="mx-auto max-w-6xl">
            <div class="reveal mb-12">
                <x-pill>
                    Akan berlangsung
                </x-pill>
                <h2 class="mt-5 font-fraunces font-semibold text-(--text-primary) text-[42px] leading-[1.1]">Event mendatang
                </h2>
            </div>

            {{-- Menampilkan 3 event; jika lebih, sisanya bisa digulir di dalam daftar ini (tinggi diatur app.js) --}}
            @if (count($events))
                <div data-scroll-limit="3" class="reveal">
                    <div data-scroll-list tabindex="0" role="region" aria-label="Daftar event mendatang"
                        class="thin-scroll -m-1.5 flex max-h-190 flex-col gap-5 overflow-y-auto overscroll-contain p-1.5 pr-3 focus-visible:outline-2 focus-visible:outline-b1">
                        @foreach ($events as $event)
                            <article
                                class="flex shrink-0 gap-5.5 rounded-2xl border border-(--border-line) bg-(--bg-card) p-7 transition duration-300 hover:shadow-md">
                                {{-- Event beberapa hari: lencana menampilkan rentang, mis. "21–23" / "OKT" --}}
                                <div
                                    class="shrink-0 flex h-18.5 w-18.5 flex-col items-center justify-center rounded-xl bg-b1 text-white">
                                    <span
                                        class="{{ mb_strlen($event['tanggal']) > 2 ? 'text-[18px]' : 'text-[24px]' }} leading-none font-bold">{{ $event['tanggal'] }}</span>
                                    <span class="mt-1.5 text-[12px] leading-none">{{ $event['bulan'] }}</span>
                                </div>

                                <div class="flex min-w-0 flex-col items-start gap-2">
                                    <h3 class="font-fraunces font-semibold text-(--text-primary) text-[22px] leading-tight">
                                        {{ $event['judul'] }}
                                    </h3>
                                    <div class="flex flex-wrap gap-x-5 gap-y-1 text-[13px] text-(--text-paragraph)">
                                        @if (!empty($event['rentang']))
                                            <span
                                                class="inline-flex items-center gap-1.5 font-medium text-(--text-primary)">
                                                @include('components.icon', [
                                                    'name' => 'calendar',
                                                    'class' => 'w-3.5 h-3.5',
                                                ])
                                                {{ $event['rentang'] }}
                                            </span>
                                        @endif
                                        <span class="inline-flex items-center gap-1.5">
                                            @include('components.icon', [
                                                'name' => 'clock',
                                                'class' => 'w-3.5 h-3.5',
                                            ])
                                            {{ $event['waktu'] }}
                                        </span>
                                        <span class="inline-flex items-center gap-1.5">
                                            @include('components.icon', [
                                                'name' => 'map-pin',
                                                'class' => 'w-3.5 h-3.5',
                                            ])
                                            {{ $event['lokasi'] }}
                                        </span>
                                    </div>
                                    <p class="max-w-165 text-[15px] leading-relaxed text-(--text-paragraph)">
                                        {{ $event['deskripsi'] }}</p>
                                    {{-- Link diisi admin; tanpa link, tombol tidak tampil --}}
                                    @if (!empty($event['link']))
                                        <a href="{{ $event['link'] }}" target="_blank" rel="noopener noreferrer"
                                            class="mt-3 inline-flex items-center rounded-full border border-line px-4.5 py-2.5 text-[14px] font-semibold text-(--text-button) transition hover:border-b1 hover:bg-b1 hover:text-white">
                                            Daftar Sekarang
                                        </a>
                                    @endif
                                </div>
                            </article>
                        @endforeach
                    </div>

                    @if (count($events) > 3)
                        <p data-scroll-hint
                            class="mt-5 flex items-center justify-center gap-2 text-[13px] font-medium text-secondary transition-opacity duration-300">
                            <span class="animate-bounce text-b1">@include('components.icon', ['name' => 'chevron-down', 'class' => 'w-4 h-4'])</span>
                            Gulir untuk melihat {{ count($events) - 3 }} event lainnya
                        </p>
                    @endif
                </div>
            @else
                <p class="text-[14px] text-secondary">Belum ada event yang dijadwalkan.</p>
            @endif
        </div>
    </section>

    {{-- 3. Kolaborasi --}}
    <section class="bg-(--bg-primary) px-6 py-22">
        <div class="mx-auto max-w-6xl grid grid-cols-1 lg:grid-cols-2 gap-14 items-center">
            <div class="reveal">
                <x-pill>
                    Kolaborasi
                </x-pill>
                <h2 class="mt-5 font-fraunces font-semibold text-(--text-primary) text-[42px] leading-[1.1]">
                    Bermitra dengan Ermaya Physio untuk acara Anda
                </h2>
                <p class="mt-4 text-[16px] leading-relaxed text-(--text-paragraph)">
                    Kami bekerja sama dengan perusahaan, komunitas, dan penyelenggara olahraga untuk
                    menghadirkan layanan fisioterapi dan edukasi kesehatan langsung di lokasi acara.
                </p>
                <ul class="mt-5 flex flex-col gap-4 text-[16px] text-(--text-paragraph)">
                    @foreach (['Pendampingan medis di event olahraga & komunitas', 'Talkshow, Seminar dan Webinar untuk edukasi kesehatan', 'Skrining kesehatan gratis untuk komunitas'] as $poin)
                        <li class="flex items-center gap-3.5">
                            <span class="shrink-0 text-(--bg-point)">
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
                'alt' => 'Tim Ermaya di lokasi event',
                'caption' => 'Tim di lokasi event',
                'icon' => 'users',
                'class' => 'aspect-[4/5] w-full',
            ])
        </div>
    </section>

    {{-- 4. Sorotan event sebelumnya --}}
    <section class="bg-(--bg-secondary) px-6 pt-22">
        <div class="mx-auto max-w-6xl">
            <div class="reveal mb-12">
                <x-pill>
                    Dokumentasi
                </x-pill>
                <h2 class="mt-5 font-fraunces font-semibold text-(--text-primary) text-[42px] leading-[1.1]">
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
                        <h3 class="mt-4 text-[16px] font-semibold text-(--text-primary)">{{ $item['judul'] }}</h3>
                        <p class="mt-1 text-[14px] text-(--text-paragraph)">{{ $item['keterangan'] }}</p>
                    </article>
                @empty
                    <p class="text-[14px] text-(--text-paragraph)">Belum ada dokumentasi event.</p>
                @endforelse
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="bg-(--bg-secondary) px-6 py-22">
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
