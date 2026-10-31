@extends('layouts.app')
@section('title', 'Beranda - Fisio Riswan')
@section('main_class', 'py-0')

@php

    $kondisi = [
        // Format item: "Istilah medis/Arti dalam Indonesia" (bagian setelah "/" boleh dikosongkan)
        [
            'icon' => 'zap',
            'judul' => 'Gangguan Saraf',
            'items' => [
                'Radiculopati/Iritasi Akar Saraf',
                'HNP/Saraf Kejepit Punggung',
                'Multiple Sclerosis',
                'Stroke',
                'Parkinson',
                'Neuropati/Kerusakan Saraf',
                'Bells Palsy/Kelumpuhan Otot Wajah',
                'Cubital Tunnel Syndrome/Saraf Kejepit Siku',
                'Carpal Tunnel Syndrome/Saraf Kejepit Pergelangan Tangan',
                'Guyon Tunnel Syndrome/Saraf Kejepit Jari Manis',
                'Sciatica/Iritasi Saraf Sciatic',
                'Tarsal Tunnel Syndrome/Saraf Kejepit Pergelangan Kaki',
            ],
        ],
        [
            'icon' => 'activity',
            'judul' => 'Gangguan Otot dan Tulang',
            'items' => [
                'Myalgia/Nyeri Otot',
                'Muscle Spasm/Kram Otot',
                'Muscle Tightness/Tegang Otot',
                'Acute Inflammation/Peradangan Akut',
                'Chronic Inflammation/Peradangan Kronik',
                'Scoliosis',
                'Low Back Pain Myogenic/Sakit Otot Pinggang',
            ],
        ],
        [
            'icon' => 'smile',
            'judul' => 'Pediatri',
            'items' => ['Delay Development/Keterlambatan Perkembangan', 'Cerebral Palsy/Kelumpuhan Otak'],
        ],
        [
            'icon' => 'user',
            'judul' => 'Geriatric',
            'items' => [
                'Osteoarthritis/Radang Sendi',
                'Osteoporosis/Pengeroposan Tulang',
                'Spondylosis/Penuaan Tulang Belakang',
            ],
        ],
        [
            'icon' => 'clipboard',
            'judul' => 'Pasca Operasi',
            'items' => [
                'Post Op Fraktur/Pasca Operasi Patah Tulang',
                'Post Op Shoulder/Pasca Operasi Bahu',
                'Post Op Elbow/Pasca Operasi Siku',
                'Post Op Wrist/Pasca Operasi Pergelangan Tangan',
                'Post Op Knee/Pasca Operasi Lutut',
                'Post Op Ankle/Pasca Operasi Pergelangan Kaki',
            ],
        ],
        [
            'icon' => 'target',
            'judul' => 'Cedera Olahraga',
            'items' => [
                'Strain/Cedera Otot',
                'Sprain/Cedera Ligament',
                'Tendon Injury/Cedera Tendon',
                'Meniscus Injury/Cedera Meniscus',
            ],
        ],
    ];

    $langkah = [
        [
            'judul' => 'Konsultasi via WhatsApp',
            'teks' => 'Ceritakan keluhan dan kondisi Anda. Tim kami akan membantu menentukan jenis terapi yang tepat.',
        ],
        [
            'judul' => 'Pilih paket & jadwal',
            'teks' => 'Tentukan paket yang sesuai serta tanggal dan jam kunjungan yang paling nyaman untuk Anda.',
        ],
        [
            'judul' => 'Terapis datang ke rumah',
            'teks' => 'Fisioterapis datang membawa peralatan lengkap dan memulai sesi pemulihan di rumah Anda.',
        ],
    ];

    // harga = null → paket ditampilkan dengan deskripsi dan tombol "Hubungi Kami"
    $paket = [
        [
            'nama' => 'Kunjungan Tunggal',
            'harga' => 'Rp 450rb',
            'satuan' => '/kunjungan',
            'populer' => false,
            'fitur' => ['1x kunjungan 45–60 menit', 'Infrared / Ultrasound / TENS', 'Bebas pilih tanggal'],
        ],
        [
            'nama' => 'Kunjungan Reguler',
            'harga' => 'Rp 1,2jt',
            'satuan' => '/4x kunjungan',
            'populer' => true,
            'fitur' => ['4x kunjungan 45–60 menit', 'Fisioterapis yang sama', 'Evaluasi dari sesi sebelumnya'],
        ],
        [
            'nama' => 'Paket Intensif',
            'harga' => 'Rp 3jt',
            'satuan' => '/8x kunjungan',
            'populer' => false,
            'fitur' => ['8x kunjungan 45–60 menit', 'Rencana pemulihan personal', 'Prioritas penjadwalan'],
        ],
        [
            'nama' => 'Paket Intensif+',
            'harga' => 'Rp 4,2jt',
            'satuan' => '/12x kunjungan',
            'populer' => false,
            'fitur' => ['12x kunjungan 45–60 menit', 'Rencana pemulihan personal', 'Prioritas penjadwalan'],
        ],
        [
            'nama' => 'Fisioterapi Event',
            'harga' => null,
            'icon' => 'calendar',
            'populer' => false,
            'deskripsi' =>
                'Pesan Ermaya untuk acara Anda! Kami akan berikan pelayanan sesuai dengan kebutuhan acara Anda.',
        ],
        [
            'nama' => 'Fisioterapi Wellness',
            'harga' => null,
            'icon' => 'heart',
            'populer' => false,
            'deskripsi' =>
                'Sering melakukan kegiatan fisik berat? Pesan Ermaya Wellness sebagai fisioterapis pribadi Anda!',
        ],
    ];

    // TODO: ganti dengan data testimoni dari database / controller saat integrasi
    $testimoni = $testimoni ?? [
        [
            'nama' => 'Nama Pasien',
            'kondisi' => 'Nyeri punggung',
            'rating' => 5,
            'teks' =>
                'Contoh testimoni. Terapisnya datang tepat waktu, ramah, dan menjelaskan latihan dengan sangat jelas.',
        ],
        [
            'nama' => 'Nama Pasien',
            'kondisi' => 'Pasca stroke',
            'rating' => 5,
            'teks' =>
                'Contoh testimoni. Tidak perlu repot membawa orang tua ke klinik, perkembangannya terasa setiap minggu.',
        ],
        [
            'nama' => 'Nama Pasien',
            'kondisi' => 'Cedera lutut',
            'rating' => 5,
            'teks' =>
                'Contoh testimoni. Programnya jelas dan saya bisa kembali berolahraga lebih cepat dari perkiraan.',
        ],
        [
            'nama' => 'Nama Pasien',
            'kondisi' => 'Pasca operasi',
            'rating' => 4,
            'teks' =>
                'Contoh testimoni. Jadwalnya fleksibel dan terapis selalu mengevaluasi kemajuan dari sesi sebelumnya.',
        ],
    ];

    $message =
        "Halo, saya tertarik dengan paket *Isi nama paket Anda!*\n" .
        "\nMohon isi data diri di bawah ini dengan benar dan teliti untuk pemesanan: \n" .
        "Nama Lengkap: \n" .
        "Alamat Lengkap: \n" .
        "Tanggal Mulai (Contoh: DD/MM/YYYY): \n" .
        "Waktu Mulai (Contoh: HH:MM): \n" .
        "\nTerima kasih, saya menunggu konfirmasi dari Anda.";

    $whatsappUrlNonPack = 'https://wa.me/' . config('services.whatsapp.number') . '?text=' . urlencode($message);
@endphp

@section('content')
    {{-- 1. Hero --}}
    <section class="bg-(--bg-primary) px-6 pt-16 pb-6">
        <div class="mx-auto max-w-6xl grid grid-cols-1 lg:grid-cols-2 gap-14 items-center">
            <div class="load-in">
                <h1 class="font-fraunces font-semibold text-(--text-primary) text-[60px] leading-[1.1]">
                    Terapi kesehatan, tanpa harus meninggalkan rumah.
                </h1>
                <p class="mt-7 max-w-135 text-[18px] leading-[1.75] text-(--text-paragraph)">
                    Ermaya Physio menghadirkan Fisioterapis berpengalaman langsung ke rumah Anda.
                    Pemulihan lebih nyaman, tanpa antre, dan tanpa perjalanan yang melelahkan.
                </p>
                <div class="mt-10 flex flex-wrap gap-3">
                    <a href="{{ $whatsappUrlNonPack }}" target="_blank"
                        class="inline-flex items-center gap-2 rounded-full bg-b1 px-7 py-4 text-[15px] font-semibold text-white transition hover:opacity-90">
                        Pesan via WhatsApp
                    </a>
                    <a href="#paket"
                        class="inline-flex items-center rounded-full border border-line bg-white px-7 py-4 text-[15px] font-semibold text-b1 transition hover:bg-b5">
                        Lihat paket
                    </a>
                </div>
                {{-- TODO: sesuaikan angka statistik dengan data asli --}}
                <div class="mt-11 flex flex-wrap gap-x-10 gap-y-4">
                    <div>
                        <p class="font-fraunces font-semibold text-[30px] leading-none text-(--text-highlight)">500+</p>
                        <p class="mt-1.5 text-[13px] text-(--text-paragraph)">Pasien dilayani</p>
                    </div>
                    <div>
                        <p class="font-fraunces font-semibold text-[30px] leading-none text-(--text-highlight)">1.000+</p>
                        <p class="mt-1.5 text-[13px] text-(--text-paragraph)">Sesi terapi</p>
                    </div>
                    <div>
                        <p class="font-fraunces font-semibold text-[30px] leading-none text-(--text-highlight)">4.9/5</p>
                        <p class="mt-1.5 text-[13px] text-(--text-paragraph)">Rating pasien</p>
                    </div>
                </div>
            </div>

            {{-- Letakkan foto di public/images/beranda/hero.jpg --}}
            @include('components.beranda-foto', [
                'src' => 'images/beranda/hero.jpg',
                'alt' => 'Fisioterapis Ermaya sedang menangani pasien di rumah',
                'caption' => 'Fisioterapis Ermaya di rumah pasien',
                'icon' => 'heart',
                'class' => 'aspect-[4/5] w-full',
                'load' => true,
                'delay' => 150,
            ])
        </div>
    </section>

    {{-- 2. Masalah & solusi --}}
    <section class="bg-(--bg-secondary) px-6 pt-16 pb-16">
        <div class="mx-auto max-w-6xl grid grid-cols-1 lg:grid-cols-2 gap-14 items-center">
            {{-- Letakkan foto di public/images/beranda/klinik.jpg --}}
            @include('components.beranda-foto', [
                'src' => 'images/beranda/klinik.jpg',
                'alt' => 'Pasien beristirahat dengan nyaman di rumah',
                'caption' => 'Pasien beristirahat dengan nyaman di rumah',
                'icon' => 'users',
                'class' => 'aspect-square w-full order-last lg:order-first',
            ])

            <div class="reveal">
                <h2 class="font-fraunces font-semibold text-(--text-primary) text-[40px] leading-[1.15]">
                    Perawatan di klinik sering merepotkan untuk yang butuh istirahat.
                </h2>
                <ul class="mt-8 flex flex-col gap-7">
                    @foreach ([['icon' => 'home', 'judul' => 'Terapi di rumah Anda', 'teks' => 'Perawatan di klinik sering merepotkan untuk yang butuh istirahat, cukup tunggu terapis datang membawa peralatan lengkap.'], ['icon' => 'clock', 'judul' => 'Jadwal fleksibel', 'teks' => 'Pilih hari dan jam kunjungan yang paling nyaman, setiap hari pukul 09.00 – 18.00.'], ['icon' => 'user-check', 'judul' => 'Terapis berpengalaman', 'teks' => 'Fisioterapis yang menyusun khusus program rehabilitasi sesuai kondisi dan target anda.']] as $poin)
                        <li class="flex gap-4">
                            <x-pill-icon>
                                @include('components.icon', [
                                    'name' => $poin['icon'],
                                    'class' => 'w-5 h-5',
                                ])
                            </x-pill-icon>
                            <div>
                                <p class="text-[16px] font-semibold text-(--text-primary)">{{ $poin['judul'] }}</p>
                                <p class="mt-1 text-[14px] leading-relaxed text-(--text-paragraph)">{{ $poin['teks'] }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>

    {{-- 3. Kondisi yang ditangani --}}
    <section class="bg-(--bg-primary) px-6 py-30">
        <div class="mx-auto max-w-6xl">
            <div class="reveal mx-auto max-w-150 text-center">
                <x-pill>
                    Layanan Kami
                </x-pill>
                <h2 class="mt-5 font-fraunces font-semibold text-(--text-primary) text-[40px] leading-[1.15]">
                    Terapi yang disesuaikan dengan kondisi Anda
                </h2>
                <p class="mx-auto mt-4 max-w-140 text-[16px] leading-relaxed text-(--text-paragraph)">
                    Setiap program disusun berdasarkan hasil pemeriksaan awal, sehingga terapi tepat sasaran dan
                    sesuai kebutuhan Anda.
                </p>
            </div>

            {{-- Semua kartu sama tinggi; daftar yang panjang digulir di dalam kartu --}}
            <div class="mt-14 grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($kondisi as $item)
                    <div class="reveal group flex h-100 flex-col rounded-2xl border border-(--border-line) bg-(--bg-card) p-7 transition duration-300 hover:shadow-lg"
                        style="--reveal-delay: {{ ($loop->index % 3) * 60 }}ms">
                        <x-pill-icon class="shrink-0 transition group-hover:bg-g1 group-hover:text-white">
                            @include('components.icon', ['name' => $item['icon'], 'class' => 'w-5 h-5'])
                        </x-pill-icon>
                        <h3
                            class="mt-5 shrink-0 font-fraunces text-[20px] font-semibold leading-tight text-(--text-primary)">
                            {{ $item['judul'] }}</h3>

                        <ul tabindex="0" aria-label="Daftar kondisi: {{ $item['judul'] }}"
                            class="thin-scroll -mr-3 mt-4 flex min-h-0 flex-1 flex-col gap-3 overflow-y-auto overscroll-contain pr-3 focus-visible:outline-2 focus-visible:outline-b1">
                            @foreach ($item['items'] as $kondisiItem)
                                @php [$istilah, $arti] = array_pad(explode('/', $kondisiItem, 2), 2, null); @endphp
                                <li class="flex gap-2.5 text-[14px] leading-snug">
                                    <span class="mt-1.75 h-1.5 w-1.5 shrink-0 rounded-full bg-g2" aria-hidden="true"></span>
                                    <span>
                                        <span class="font-medium text-(--text-primary)">{{ trim($istilah) }}</span>
                                        @if ($arti)
                                            <span
                                                class="mt-0.5 block text-[13px] text-(--text-paragraph)">{{ trim($arti) }}</span>
                                        @endif
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- 4. Langkah pemesanan --}}
    <section class="bg-(--bg-secondary) px-6 pt-21 pb-15">
        <div class="mx-auto max-w-6xl grid grid-cols-1 lg:grid-cols-2 gap-14 items-start">
            <div class="reveal">
                <x-pill>
                    Cara Pemesanan
                </x-pill>
                <h2 class="mt-5 font-fraunces font-semibold text-(--text-primary) text-[40px] leading-[1.15]">
                    Tiga langkah menuju sesi pertama Anda
                </h2>
                <p class="mt-4 max-w-130 text-[16px] leading-relaxed text-(--text-paragraph)">
                    Proses pemesanan singkat dan tanpa formulir rumit. Semua cukup lewat WhatsApp.
                </p>
            </div>

            <ol class="flex flex-col gap-13">
                @foreach ($langkah as $item)
                    <li class="reveal flex gap-4" style="--reveal-delay: {{ $loop->index * 100 }}ms">
                        <span
                            class="shrink-0 flex h-9 w-9 items-center justify-center rounded-full bg-(--bg-point) text-[14px] font-semibold text-white">
                            {{ $loop->iteration }}
                        </span>
                        <div>
                            <p class="text-[16px] font-semibold text-(--text-highlight)">{{ $item['judul'] }}</p>
                            <p class="mt-1 text-[14px] leading-relaxed text-(--text-paragraph)">{{ $item['teks'] }}</p>
                        </div>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    {{-- 5. Paket (slider) --}}
    <section id="paket" class="scroll-mt-28 bg-(--bg-secondary) px-6 pt-30 pb-23" data-slider>
        <div class="mx-auto max-w-6xl">
            <div class="reveal mx-auto max-w-135 text-center">
                <x-pill>
                    Paket Layanan
                </x-pill>
                <h2 class="mt-5 font-fraunces font-semibold text-(--text-primary) text-[40px] leading-[1.15]">
                    Pilih paket sesuai kebutuhan pemulihan
                </h2>
                <p class="mt-4 text-[16px] text-(--text-paragraph)">Geser untuk melihat semua paket yang tersedia.</p>
            </div>

            <div class="no-scrollbar mt-12 flex gap-6 justify-center-safe overflow-x-auto snap-x snap-mandatory scroll-smooth py-4 -my-4 cursor-grab"
                data-slider-track>
                @foreach ($paket as $item)
                    @php $populer = $item['populer']; @endphp
                    <article data-slide style="--reveal-delay: {{ $loop->index * 90 }}ms"
                        class="reveal paket-card snap-start shrink-0 basis-full md:basis-[calc((100%-1.5rem)/2)] lg:basis-[calc((100%-3rem)/3)] flex flex-col rounded-2xl p-7 transition duration-300 hover:-translate-y-1 hover:shadow-xl gap-5
                        {{ $populer ? 'paket-populer bg-b1 text-white' : 'bg-(--bg-card) text-(--text-primary)' }}">
                        @if ($populer)
                            <span
                                class="mb-3 w-fit rounded-full bg-white/15 px-3 py-1.5 text-[12px] leading-none font-semibold text-white">
                                Paling Populer
                            </span>
                        @endif
                        <h3
                            class="font-fraunces text-[20px] font-semibold leading-tight {{ $populer ? 'text-white' : 'text-(--text-primary)' }}">
                            {{ $item['nama'] }}
                        </h3>

                        @if ($item['harga'])
                            <p class="mt-3">
                                <span
                                    class="font-fraunces text-[30px] font-semibold leading-none {{ $populer ? 'text-white' : 'text-(--text-primary)' }}">{{ $item['harga'] }}</span>
                                <span
                                    class="text-[13px] {{ $populer ? 'text-b5' : 'text-(--text-paragraph)' }}">{{ $item['satuan'] }}</span>
                            </p>
                            <ul class="mt-5 flex flex-col gap-3 text-[14px]">
                                @foreach ($item['fitur'] as $fitur)
                                    <li class="flex items-start gap-2.5">
                                        <span class="mt-0.5 shrink-0 {{ $populer ? 'text-g3' : 'text-g1' }}">
                                            @include('components.icon', [
                                                'name' => 'check',
                                                'class' => 'w-4 h-4',
                                            ])
                                        </span>
                                        <span
                                            class="{{ $populer ? 'text-white' : 'text-(--text-paragraph)' }}">{{ $fitur }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            {{-- <span class="mt-4 flex h-10 w-10 items-center justify-center rounded-xl bg-pill text-g1">
                                @include('components.icon', [
                                    'name' => $item['icon'],
                                    'class' => 'w-5 h-5',
                                ])
                            </span> --}}
                            <p class="mt-4 text-[14px] leading-relaxed text-(--text-paragraph)">{{ $item['deskripsi'] }}
                            </p>
                        @endif

                        @php
                            $message =
                                "Halo, saya tertarik dengan paket *{$item['nama']}*\n" .
                                "\nMohon isi data diri di bawah ini dengan benar dan teliti untuk pemesanan: \n" .
                                "Nama Lengkap: \n" .
                                "Alamat Lengkap: \n" .
                                "Tanggal Mulai (Contoh: DD/MM/YYYY): \n" .
                                "Waktu Mulai (Contoh: HH:MM): \n" .
                                "\nTerima kasih, saya menunggu konfirmasi dari Anda.";
                            $whatsappUrl =
                                'https://wa.me/' . config('services.whatsapp.number') . '?text=' . urlencode($message);
                        @endphp

                        <a href="{{ $whatsappUrl }}" target="_blank"
                            class="mt-8 inline-flex w-full items-center justify-center rounded-full px-5 py-3.5 text-[14px] font-semibold transition
                            {{ $populer ? 'mt-auto bg-g1 text-white hover:bg-g2' : 'mt-auto border border-line text-(--text-button) hover:border-b1 hover:bg-b1 hover:text-white' }}">
                            {{ $item['harga'] ? 'Pesan Sekarang' : 'Hubungi Kami' }}
                        </a>
                    </article>
                @endforeach
            </div>

            @include('components.slider-nav')
        </div>
    </section>

    {{-- 6. Testimoni (slider) --}}
    <section class="bg-(--bg-primary) px-6 pt-24 pb-15" data-slider>
        <div class="mx-auto max-w-6xl">
            <div class="reveal mx-auto max-w-150 text-center">
                <x-pill>
                    Testimoni
                </x-pill>
                <h2 class="mt-5 font-fraunces font-semibold text-(--text-primary) text-[40px] leading-[1.15]">
                    Pengalaman yang mereka rasakan
                </h2>
            </div>

            <div class="no-scrollbar mt-12 flex gap-6 justify-center-safe overflow-x-auto snap-x snap-mandatory scroll-smooth py-4 -my-4 cursor-grab"
                data-slider-track>
                @forelse ($testimoni as $item)
                    <article data-slide
                        class="snap-start shrink-0 basis-full md:basis-[calc((100%-1.5rem)/2)] lg:basis-[calc((100%-3rem)/3)] flex flex-col rounded-2xl bg-(--bg-card) p-7 transition duration-300 hover:-translate-y-1 hover:shadow-lg">
                        <x-rating-stars :rating="$item['rating']" size="w-4 h-4" />
                        <p class="mt-4 text-[14px] leading-relaxed text-(--text-paragraph)">“{{ $item['teks'] }}”</p>
                        <div class="mt-auto flex items-center gap-3 pt-5">
                            <span
                                class="flex h-10 w-10 items-center justify-center rounded-full bg-pill font-semibold text-g1">
                                {{ mb_substr($item['nama'], 0, 1) }}
                            </span>
                            <div>
                                <p class="text-[14px] font-semibold text-(--text-primary)">{{ $item['nama'] }}</p>
                                <p class="text-[13px] text-(--text-paragraph)">{{ $item['kondisi'] }}</p>
                            </div>
                        </div>
                    </article>
                @empty
                    <p class="text-[14px] text-(--text-paragraph)">Belum ada testimoni.</p>
                @endforelse
            </div>

            @include('components.slider-nav')

            {{-- CTA --}}
            <div
                class="reveal mt-14 flex flex-col gap-6 rounded-3xl bg-b1 px-14 py-12 text-white md:flex-row md:items-center md:justify-between">
                <div>
                    <h2 class="font-fraunces text-[38px] font-semibold leading-[1.15]">Siap memulai pemulihan Anda?</h2>
                    <p class="mt-2 text-[16px] text-b5">Konsultasikan kebutuhan terapi Anda sekarang, gratis tanpa komitmen.
                    </p>
                </div>
                <a href="{{ $whatsappUrlNonPack }}" target="_blank"
                    class="inline-flex shrink-0 items-center justify-center rounded-full bg-g1 px-7 py-4 text-[15px] font-semibold text-white transition hover:bg-g2">
                    Pesan Sekarang
                </a>
            </div>
        </div>
    </section>
@endsection
