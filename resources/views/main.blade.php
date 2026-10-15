@extends('layouts.app')
@section('title', 'Beranda - Fisio Riswan')

@php
    $waLink = 'https://wa.me/62xxxxxxxxxxx?text=halo, chat ini dikirim melalui tombol pada website!%0ANama: [Nama]';

    $kondisi = [
        ['icon' => 'activity', 'judul' => 'Nyeri Punggung & Leher', 'teks' => 'Meredakan nyeri akibat postur kerja, saraf kejepit ringan, dan otot yang kaku.'],
        ['icon' => 'zap', 'judul' => 'Pasca Stroke & Neurologi', 'teks' => 'Melatih kembali gerak, keseimbangan, dan kemandirian aktivitas sehari-hari.'],
        ['icon' => 'shield', 'judul' => 'Pemulihan Pasca Operasi', 'teks' => 'Mengembalikan kekuatan dan rentang gerak setelah operasi lutut, panggul, atau bahu.'],
        ['icon' => 'target', 'judul' => 'Cedera Olahraga', 'teks' => 'Penanganan keseleo, cedera ligamen, dan program kembali berolahraga dengan aman.'],
        ['icon' => 'users', 'judul' => 'Lansia & Mobilitas', 'teks' => 'Menjaga kekuatan otot dan keseimbangan untuk mencegah risiko jatuh.'],
        ['icon' => 'heart', 'judul' => 'Kondisi Kronis', 'teks' => 'Pendampingan rutin untuk radang sendi, osteoartritis, dan nyeri berkepanjangan.'],
    ];

    $langkah = [
        ['judul' => 'Konsultasi via WhatsApp', 'teks' => 'Ceritakan keluhan dan kondisi Anda. Tim kami akan membantu menentukan jenis terapi yang tepat.'],
        ['judul' => 'Pilih paket & jadwal', 'teks' => 'Tentukan paket yang sesuai serta tanggal dan jam kunjungan yang paling nyaman untuk Anda.'],
        ['judul' => 'Terapis datang ke rumah', 'teks' => 'Fisioterapis datang membawa peralatan lengkap dan memulai sesi pemulihan di rumah Anda.'],
    ];

    // harga = null → paket ditampilkan dengan deskripsi dan tombol "Hubungi Kami"
    $paket = [
        ['nama' => 'Kunjungan Tunggal', 'harga' => 'Rp 199rb', 'satuan' => '/kunjungan', 'populer' => false,
            'fitur' => ['1x kunjungan 45–60 menit', 'Infrared / Ultrasound / TENS', 'Bebas pilih tanggal']],
        ['nama' => 'Kunjungan Reguler', 'harga' => 'Rp 720rb', 'satuan' => '/4x kunjungan', 'populer' => true,
            'fitur' => ['4x kunjungan 45–60 menit', 'Fisioterapis yang sama', 'Evaluasi dari sesi sebelumnya']],
        ['nama' => 'Paket Intensif', 'harga' => 'Rp 1,35jt', 'satuan' => '/8x kunjungan', 'populer' => false,
            'fitur' => ['8x kunjungan 45–60 menit', 'Rencana pemulihan personal', 'Prioritas penjadwalan']],
        ['nama' => 'Paket Intensif+', 'harga' => 'Rp 3jt', 'satuan' => '/12x kunjungan', 'populer' => false,
            'fitur' => ['12x kunjungan 45–60 menit', 'Rencana pemulihan personal', 'Prioritas penjadwalan']],
        ['nama' => 'Fisioterapi Acara', 'harga' => null, 'icon' => 'calendar', 'populer' => false,
            'deskripsi' => 'Pesan Pulihkan untuk acara Anda! Kami akan berikan pelayanan sesuai dengan kebutuhan acara Anda.'],
        ['nama' => 'Fisioterapi Wellness', 'harga' => null, 'icon' => 'heart', 'populer' => false,
            'deskripsi' => 'Sering melakukan kegiatan fisik berat? Pesan Pulihkan Wellness sebagai fisioterapis pribadi Anda!'],
    ];

    // TODO: ganti dengan data testimoni dari database / controller saat integrasi
    $testimoni = $testimoni ?? [
        ['nama' => 'Nama Pasien', 'kondisi' => 'Nyeri punggung', 'rating' => 5, 'teks' => 'Contoh testimoni. Terapisnya datang tepat waktu, ramah, dan menjelaskan latihan dengan sangat jelas.'],
        ['nama' => 'Nama Pasien', 'kondisi' => 'Pasca stroke', 'rating' => 5, 'teks' => 'Contoh testimoni. Tidak perlu repot membawa orang tua ke klinik, perkembangannya terasa setiap minggu.'],
        ['nama' => 'Nama Pasien', 'kondisi' => 'Cedera lutut', 'rating' => 5, 'teks' => 'Contoh testimoni. Programnya jelas dan saya bisa kembali berolahraga lebih cepat dari perkiraan.'],
        ['nama' => 'Nama Pasien', 'kondisi' => 'Pasca operasi', 'rating' => 4, 'teks' => 'Contoh testimoni. Jadwalnya fleksibel dan terapis selalu mengevaluasi kemajuan dari sesi sebelumnya.'],
    ];
@endphp

@section('content')
    {{-- 1. Hero --}}
    <section class="-mx-24 -mt-8 px-24 py-20 bg-white">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="load-in flex flex-col gap-6">
                <span class="w-fit rounded-full bg-g5 text-g1 text-[12px] font-medium px-3 py-1">
                    Fisioterapi Home Visit
                </span>
                <h1 class="font-fraunces font-semibold text-b1 text-4xl lg:text-5xl leading-tight">
                    Terapi kesehatan, tanpa harus meninggalkan rumah.
                </h1>
                <p class="text-gray-600 text-[15px] leading-relaxed max-w-lg">
                    Pulihkan menghadirkan fisioterapis berpengalaman langsung ke rumah Anda. Pemulihan lebih nyaman,
                    tanpa antre, dan tanpa perjalanan yang melelahkan.
                </p>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ $waLink }}" target="_blank"
                        class="inline-flex items-center gap-2 rounded-full bg-b1 px-5 py-2.5 text-[14px] text-white transition hover:opacity-90">
                        Pesan via WhatsApp
                        @include('components.icon', ['name' => 'arrow-right', 'class' => 'w-4 h-4'])
                    </a>
                    <a href="#paket"
                        class="inline-flex items-center rounded-full border border-b1 px-5 py-2.5 text-[14px] text-b1 transition hover:bg-b5">
                        Lihat paket
                    </a>
                </div>
                {{-- TODO: sesuaikan angka statistik dengan data asli --}}
                <div class="flex flex-wrap gap-10 pt-4 border-t border-gray-200">
                    <div>
                        <p class="font-fraunces font-semibold text-2xl text-b1">500+</p>
                        <p class="text-[12px] text-gray-500">Pasien dilayani</p>
                    </div>
                    <div>
                        <p class="font-fraunces font-semibold text-2xl text-b1">1.000+</p>
                        <p class="text-[12px] text-gray-500">Sesi terapi</p>
                    </div>
                    <div>
                        <p class="font-fraunces font-semibold text-2xl text-b1">4.9/5</p>
                        <p class="text-[12px] text-gray-500">Rating pasien</p>
                    </div>
                </div>
            </div>

            @include('components.beranda-foto', [
                'src' => 'images/beranda/hero.jpg',
                'alt' => 'Fisioterapis Pulihkan sedang menangani pasien di rumah',
                'class' => 'aspect-[4/5] max-h-[560px] w-full',
                'load' => true,
                'delay' => 150,
            ])
        </div>
    </section>

    {{-- 2. Masalah & solusi --}}
    <section class="-mx-24 px-24 py-20">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            @include('components.beranda-foto', [
                'src' => 'images/beranda/klinik.jpg',
                'alt' => 'Pasien beristirahat dengan nyaman di rumah',
                'class' => 'aspect-[4/3] order-last lg:order-first',
            ])

            <div class="reveal flex flex-col gap-6">
                <h2 class="font-fraunces font-semibold text-b1 text-3xl leading-snug">
                    Perawatan di klinik sering merepotkan yang justru butuh istirahat.
                </h2>
                <p class="text-gray-600 text-[15px] leading-relaxed">
                    Perjalanan, antrean, dan jadwal yang kaku bisa menguras tenaga pasien. Kami membawa terapi ke tempat
                    Anda paling nyaman: rumah sendiri.
                </p>
                <ul class="flex flex-col gap-5">
                    @foreach ([
                        ['icon' => 'home', 'judul' => 'Terapi di rumah Anda', 'teks' => 'Tanpa perjalanan dan antrean, cukup tunggu terapis datang.'],
                        ['icon' => 'clock', 'judul' => 'Jadwal fleksibel', 'teks' => 'Pilih hari dan jam kunjungan, setiap hari pukul 07.00–21.00.'],
                        ['icon' => 'user-check', 'judul' => 'Terapis berpengalaman', 'teks' => 'Fisioterapis berlisensi dengan peralatan terapi yang lengkap.'],
                    ] as $poin)
                        <li class="flex gap-4">
                            <span class="shrink-0 flex items-center justify-center w-10 h-10 rounded-full bg-g5 text-g1">
                                @include('components.icon', ['name' => $poin['icon']])
                            </span>
                            <div>
                                <p class="font-semibold text-b1 text-[15px]">{{ $poin['judul'] }}</p>
                                <p class="text-gray-600 text-[14px]">{{ $poin['teks'] }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>

    {{-- 3. Kondisi yang ditangani --}}
    <section class="-mx-24 px-24 py-20 bg-g5/40">
        <div class="reveal text-center max-w-2xl mx-auto mb-12">
            <span class="inline-block rounded-full bg-g5 text-g1 text-[12px] font-medium px-3 py-1 mb-4">Layanan</span>
            <h2 class="font-fraunces font-semibold text-b1 text-3xl">Terapi yang disesuaikan dengan kondisi Anda</h2>
            <p class="text-gray-600 text-[15px] mt-3">
                Setiap program disusun berdasarkan hasil pemeriksaan awal, sehingga terapi tepat sasaran.
            </p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($kondisi as $item)
                <div class="reveal group flex flex-col gap-3 rounded-2xl bg-white p-6 border border-gray-100 transition duration-300 hover:-translate-y-1 hover:shadow-lg"
                    style="--reveal-delay: {{ $loop->index * 60 }}ms">
                    <span class="flex items-center justify-center w-11 h-11 rounded-full bg-g5 text-g1 transition group-hover:bg-g1 group-hover:text-white">
                        @include('components.icon', ['name' => $item['icon']])
                    </span>
                    <h3 class="font-semibold text-b1 text-[16px]">{{ $item['judul'] }}</h3>
                    <p class="text-gray-600 text-[14px] leading-relaxed">{{ $item['teks'] }}</p>
                    <a href="{{ route('layanan') }}" class="mt-auto inline-flex items-center gap-1 text-[13px] font-medium text-g1 hover:gap-2 transition-all">
                        Selengkapnya
                        @include('components.icon', ['name' => 'arrow-right', 'class' => 'w-3.5 h-3.5'])
                    </a>
                </div>
            @endforeach
        </div>
    </section>

    {{-- 4. Langkah pemesanan --}}
    <section class="-mx-24 px-24 py-20 bg-white">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
            <div class="reveal flex flex-col gap-4">
                <span class="w-fit rounded-full bg-g5 text-g1 text-[12px] font-medium px-3 py-1">Cara Pemesanan</span>
                <h2 class="font-fraunces font-semibold text-b1 text-3xl">Tiga langkah menuju sesi pertama Anda</h2>
                <p class="text-gray-600 text-[15px] leading-relaxed">
                    Proses pemesanan singkat dan tanpa formulir rumit. Semua cukup lewat WhatsApp.
                </p>
            </div>
            <ol class="flex flex-col">
                @foreach ($langkah as $item)
                    <li class="reveal relative flex gap-5 pb-8 last:pb-0" style="--reveal-delay: {{ $loop->index * 100 }}ms">
                        @unless ($loop->last)
                            <span class="absolute left-5 top-10 bottom-0 w-px bg-b5" aria-hidden="true"></span>
                        @endunless
                        <span class="relative z-10 shrink-0 flex items-center justify-center w-10 h-10 rounded-full bg-b1 text-white font-semibold">
                            {{ $loop->iteration }}
                        </span>
                        <div class="pt-1.5">
                            <p class="font-semibold text-b1 text-[16px]">{{ $item['judul'] }}</p>
                            <p class="text-gray-600 text-[14px] leading-relaxed mt-1">{{ $item['teks'] }}</p>
                        </div>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    {{-- 5. Paket (slider) --}}
    <section id="paket" class="-mx-24 px-24 py-20 scroll-mt-28" data-slider>
        <div class="reveal text-center max-w-2xl mx-auto mb-10">
            <span class="inline-block rounded-full bg-g5 text-g1 text-[12px] font-medium px-3 py-1 mb-4">Paket</span>
            <h2 class="font-fraunces font-semibold text-b1 text-3xl">Pilih paket sesuai kebutuhan pemulihan</h2>
            <p class="text-gray-600 text-[15px] mt-3">Geser untuk melihat semua paket yang tersedia.</p>
        </div>

        <div class="no-scrollbar flex gap-6 justify-center-safe overflow-x-auto snap-x snap-mandatory scroll-smooth py-4 -my-4 cursor-grab"
            data-slider-track>
            @foreach ($paket as $item)
                @php $populer = $item['populer']; @endphp
                <article data-slide
                    class="slide-card snap-start shrink-0 basis-full md:basis-[calc((100%-1.5rem)/2)] lg:basis-[calc((100%-3rem)/3)] flex flex-col gap-5 rounded-2xl p-7 border transition duration-300 hover:-translate-y-1 hover:shadow-xl
                    {{ $populer ? 'bg-b1 border-b1 text-white' : 'bg-white border-gray-100 text-b1' }}">
                    <div class="flex items-center justify-between gap-2">
                        <h3 class="font-semibold text-[16px]">{{ $item['nama'] }}</h3>
                        @if ($populer)
                            <span class="rounded-full bg-g1 text-white text-[11px] font-medium px-2.5 py-1">Paling Populer</span>
                        @endif
                    </div>

                    @if ($item['harga'])
                        <p>
                            <span class="font-fraunces font-semibold text-3xl">{{ $item['harga'] }}</span>
                            <span class="text-[13px] {{ $populer ? 'text-b5' : 'text-gray-500' }}">{{ $item['satuan'] }}</span>
                        </p>
                        <ul class="flex flex-col gap-3 text-[14px]">
                            @foreach ($item['fitur'] as $fitur)
                                <li class="flex items-start gap-2">
                                    <span class="shrink-0 mt-0.5 {{ $populer ? 'text-g3' : 'text-g1' }}">
                                        @include('components.icon', ['name' => 'check', 'class' => 'w-4 h-4'])
                                    </span>
                                    <span class="{{ $populer ? 'text-white' : 'text-gray-700' }}">{{ $fitur }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <span class="flex items-center justify-center w-11 h-11 rounded-full bg-g5 text-g1">
                            @include('components.icon', ['name' => $item['icon']])
                        </span>
                        <p class="text-gray-700 text-[14px] leading-relaxed">{{ $item['deskripsi'] }}</p>
                    @endif

                    <a href="{{ $waLink }}" target="_blank"
                        class="mt-auto inline-flex justify-center items-center gap-2 rounded-full px-5 py-2.5 text-[14px] transition
                        {{ $populer ? 'bg-g1 text-white hover:bg-g2' : 'border border-b1 text-b1 hover:bg-b1 hover:text-white' }}">
                        {{ $item['harga'] ? 'Pesan Sekarang' : 'Hubungi Kami' }}
                    </a>
                </article>
            @endforeach
        </div>

        @include('components.slider-nav')
    </section>

    {{-- 6. Testimoni (slider) --}}
    <section class="-mx-24 px-24 py-20 bg-white" data-slider>
        <div class="reveal text-center max-w-2xl mx-auto mb-10">
            <span class="inline-block rounded-full bg-g5 text-g1 text-[12px] font-medium px-3 py-1 mb-4">Testimoni</span>
            <h2 class="font-fraunces font-semibold text-b1 text-3xl">Pengalaman yang mereka rasakan</h2>
            <p class="text-gray-600 text-[15px] mt-3">Cerita pasien setelah menjalani terapi bersama Pulihkan.</p>
        </div>

        <div class="no-scrollbar flex gap-6 justify-center-safe overflow-x-auto snap-x snap-mandatory scroll-smooth py-4 -my-4 cursor-grab"
            data-slider-track>
            @forelse ($testimoni as $item)
                <article data-slide
                    class="snap-start shrink-0 basis-full md:basis-[calc((100%-1.5rem)/2)] lg:basis-[calc((100%-3rem)/3)] flex flex-col gap-5 rounded-2xl bg-[#f5f5f5] p-7 transition duration-300 hover:-translate-y-1 hover:shadow-lg">
                    <div class="flex gap-1 text-g1">
                        @for ($i = 1; $i <= 5; $i++)
                            @include('components.icon', [
                                'name' => 'star',
                                'fill' => $i <= $item['rating'] ? 'currentColor' : 'none',
                                'class' => 'w-4 h-4',
                            ])
                        @endfor
                    </div>
                    <p class="text-gray-700 text-[14px] leading-relaxed">“{{ $item['teks'] }}”</p>
                    <div class="mt-auto flex items-center gap-3 pt-4 border-t border-gray-200">
                        <span class="flex items-center justify-center w-10 h-10 rounded-full bg-b5 text-b1 font-semibold">
                            {{ mb_substr($item['nama'], 0, 1) }}
                        </span>
                        <div>
                            <p class="font-semibold text-b1 text-[14px]">{{ $item['nama'] }}</p>
                            <p class="text-gray-500 text-[12px]">{{ $item['kondisi'] }}</p>
                        </div>
                    </div>
                </article>
            @empty
                <p class="text-gray-500 text-[14px]">Belum ada testimoni.</p>
            @endforelse
        </div>

        @include('components.slider-nav')
    </section>

    {{-- CTA --}}
    <section class="-mx-24 px-24 py-16">
        <div class="reveal flex flex-col md:flex-row md:items-center md:justify-between gap-6 rounded-3xl bg-b1 px-10 py-10 text-white">
            <div>
                <h2 class="font-fraunces font-semibold text-2xl">Siap memulai pemulihan Anda?</h2>
                <p class="text-b5 text-[14px] mt-2">Konsultasikan kebutuhan terapi Anda sekarang, gratis tanpa komitmen.</p>
            </div>
            <a href="{{ $waLink }}" target="_blank"
                class="shrink-0 inline-flex items-center gap-2 rounded-full bg-g1 px-5 py-2.5 text-[14px] text-white transition hover:bg-g2">
                Pesan Sekarang
                @include('components.icon', ['name' => 'arrow-right', 'class' => 'w-4 h-4'])
            </a>
        </div>
    </section>
@endsection
