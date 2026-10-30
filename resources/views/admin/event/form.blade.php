{{-- Admin: tambah / edit event. Panel kanan menampilkan pratinjau kartu seperti di halaman Event. --}}
@extends('layouts.admin')

@php
    $edit = $event->exists;
    $judulHalaman = $edit ? 'Edit Event' : 'Tambah Event';

    $input =
        'h-11 w-full rounded-[10px] border bg-sage px-3.5 text-[15px] text-(--text-primary) placeholder:text-[#a3aaa5] focus:border-b1 focus:outline-none focus:ring-2 focus:ring-b1/15';
    $border = fn(string $name) => $errors->has($name) ? 'border-danger' : 'border-line';
@endphp

@section('title', $judulHalaman . ' - Admin Pulihkan')

@section('content')
    <a href="{{ route('admin.event.index') }}"
        class="mb-5 inline-flex items-center gap-2 text-[14px] font-medium text-(--text-paragraph) transition hover:text-b1">
        @include('components.icon', ['name' => 'arrow-left', 'class' => 'w-4 h-4'])
        Kembali ke daftar event
    </a>

    <x-admin-header :title="$judulHalaman"
        subtitle="Isi detail event. Pratinjau di sebelah kanan menunjukkan tampilannya di halaman Event." />

    <div class="mt-8 grid items-start gap-8 lg:grid-cols-[minmax(0,1fr)_400px]">
        {{-- Formulir --}}
        <form method="POST" novalidate
            action="{{ $edit ? route('admin.event.update', $event) : route('admin.event.store') }}"
            class="rounded-[20px] border border-(--border-line) bg-(--bg-card) p-7 event-submit-form">
            @csrf
            @if ($edit)
                @method('PUT')
            @endif

            @if ($errors->any())
                <div role="alert"
                    class="mb-6 flex items-start gap-2.5 rounded-xl border border-danger/30 bg-danger/5 px-4 py-3 text-[14px] text-danger">
                    @include('components.icon', ['name' => 'alert', 'class' => 'mt-0.5 w-4 h-4 shrink-0'])
                    <p>Beberapa kolom belum benar. Periksa pesan berwarna merah di bawah.</p>
                </div>
            @endif

            <div class="flex flex-col gap-5">
                <div>
                    <label for="title"
                        class="mb-1.5 block text-[14px] font-semibold text-(--text-(--text-primary))">Judul event
                        <span class="text-danger">*</span></label>
                    <input id="title" name="title" type="text" maxlength="120" required
                        value="{{ old('title', $event->title) }}" placeholder="Contoh: Cek Kesehatan Gratis untuk Lansia"
                        class="{{ $input }} {{ $border('title') }} text-black">
                    @error('title')
                        <p class="mt-1.5 text-[13px] text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
                    <div>
                        <label for="event_date" class="mb-1.5 block text-[14px] font-semibold text-(--text-primary)">Tanggal
                            mulai
                            <span class="text-danger">*</span></label>
                        <input id="event_date" name="event_date" type="date" required
                            @unless ($edit) min="{{ now(\App\Models\Event::TIMEZONE)->toDateString() }}" @endunless
                            value="{{ old('event_date', $event->event_date?->format('Y-m-d')) }}"
                            class="{{ $input }} {{ $border('event_date') }} text-black">
                        @error('event_date')
                            <p class="mt-1.5 text-[13px] text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="days" class="mb-1.5 block text-[14px] font-semibold text-(--text-primary)">Jumlah
                            hari <span class="text-danger">*</span></label>
                        <div class="relative">
                            <input id="days" name="days" type="number" inputmode="numeric" required min="1"
                                max="{{ \App\Models\Event::MAKS_HARI }}" step="1"
                                value="{{ old('days', $event->exists ? $event->jumlahHari() : 1) }}"
                                class="{{ $input }} pr-14 {{ $border('days') }} text-black">
                            <span
                                class="pointer-events-none absolute right-3.5 top-1/2 -translate-y-1/2 text-[13px] text-(--text-paragraph)">hari</span>
                        </div>
                        @error('days')
                            <p class="mt-1.5 text-[13px] text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <span class="mb-1.5 block text-[14px] font-semibold text-(--text-primary)">Tanggal selesai</span>
                        <output id="tanggal_selesai" for="event_date days"
                            class="flex h-11 w-full items-center rounded-[10px] border border-line bg-sage-deep px-3.5 text-[15px] text-(--text-paragraph)">—</output>
                    </div>
                </div>
                <p class="-mt-3 text-[12px] text-(--text-paragraph)">
                    Isi 1 untuk event satu hari. Untuk event beberapa hari, isi jumlah harinya (maks.
                    {{ \App\Models\Event::MAKS_HARI }}); tanggal selesai dihitung otomatis dan website menampilkan
                    rentangnya, mis. “21 – 23 Oktober”.
                </p>

                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <div>
                        <label for="start_time" class="mb-1.5 block text-[14px] font-semibold text-(--text-primary)">Jam
                            mulai <span class="text-danger">*</span></label>
                        <input id="start_time" name="start_time" type="time" required
                            value="{{ old('start_time', $event->start_time) }}"
                            class="{{ $input }} {{ $border('start_time') }} text-black">
                        @error('start_time')
                            <p class="mt-1.5 text-[13px] text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="end_time" class="mb-1.5 block text-[14px] font-semibold text-(--text-primary)">Jam
                            selesai</label>
                        <input id="end_time" name="end_time" type="time"
                            value="{{ old('end_time', $event->end_time) }}"
                            class="{{ $input }} {{ $border('end_time') }} text-black">
                        @error('end_time')
                            <p class="mt-1.5 text-[13px] text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <p class="-mt-3 text-[12px] text-(--text-paragraph)">
                    Waktu ditampilkan dalam WIB dan berlaku setiap hari. Jam selesai boleh dikosongkan.
                </p>

                <div>
                    <label for="location" class="mb-1.5 block text-[14px] font-semibold text-(--text-primary)">Lokasi <span
                            class="text-danger">*</span></label>
                    <input id="location" name="location" type="text" maxlength="150" required
                        value="{{ old('location', $event->location) }}"
                        placeholder="Contoh: Balai Warga Kemang, Jakarta Selatan"
                        class="{{ $input }} {{ $border('location') }} text-black">
                    @error('location')
                        <p class="mt-1.5 text-[13px] text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <div class="mb-1.5 flex items-end justify-between">
                        <label for="description" class="text-[14px] font-semibold text-(--text-primary)">Deskripsi <span
                                class="text-danger">*</span></label>
                        <span class="text-[12px] text-(--text-paragraph)"><span id="hitung">0</span>/500</span>
                    </div>
                    <textarea id="description" name="description" rows="4" maxlength="500" required
                        placeholder="Jelaskan singkat apa yang akan dilakukan di event ini dan siapa yang bisa ikut."
                        class="w-full resize-y rounded-[10px] border bg-sage px-3.5 py-2.5 text-[15px] leading-relaxed text-black placeholder:text-[#a3aaa5] focus:border-b1 focus:outline-none focus:ring-2 focus:ring-b1/15 {{ $border('description') }}">{{ old('description', $event->description) }}</textarea>
                    @error('description')
                        <p class="mt-1.5 text-[13px] text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="registration_url" class="mb-1.5 block text-[14px] font-semibold text-(--text-primary)">Link
                        pendaftaran</label>
                    <div class="relative">
                        <span
                            class="pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-(--text-paragraph)">
                            @include('components.icon', ['name' => 'link', 'class' => 'w-4 h-4'])
                        </span>
                        <input id="registration_url" name="registration_url" type="text" inputmode="url"
                            autocomplete="off" value="{{ old('registration_url', $event->registration_url) }}"
                            placeholder="https://forms.gle/abc123"
                            class="{{ $input }} pl-10 {{ $border('registration_url') }} text-black">
                    </div>
                    @error('registration_url')
                        <p class="mt-1.5 text-[13px] text-danger">{{ $message }}</p>
                    @else
                        <p class="mt-1.5 text-[12px] leading-relaxed text-(--text-paragraph)">
                            Tempel link Google Form, WhatsApp, atau halaman pendaftaran lain. Pengunjung yang menekan
                            tombol “Daftar Sekarang” akan dibawa ke link ini. Kosongkan jika event tidak perlu pendaftaran,
                            tombolnya tidak akan tampil.
                        </p>
                    @enderror
                </div>
            </div>

            <div class="mt-8 flex flex-wrap items-center gap-3 border-t border-line pt-6">
                <button type="submit"
                    class="inline-flex h-11 cursor-pointer items-center gap-2 rounded-[10px] bg-b1 px-6 text-[14px] font-semibold text-white transition hover:opacity-90">
                    @include('components.icon', ['name' => 'check', 'class' => 'w-4 h-4'])
                    {{ $edit ? 'Simpan Perubahan' : 'Simpan Event' }}
                </button>
                <a href="{{ route('admin.event.index') }}"
                    class="inline-flex h-11 items-center rounded-[10px] border border-line px-6 text-[14px] font-semibold text-(--text-paragraph) transition hover:border-b1 hover:text-b1">
                    Batal
                </a>
            </div>
        </form>

        {{-- Pratinjau --}}
        <aside class="lg:sticky lg:top-6" aria-label="Pratinjau di website">
            <p class="mb-3 text-[12px] font-semibold uppercase tracking-wider text-(--text-paragraph)">Pratinjau di website
            </p>
            <div class="rounded-[20px] bg-(--bg-shadow) p-4">
                <article class="flex gap-4 rounded-2xl border border-(--border-line) bg-(--bg-primary) p-5">
                    <div class="flex h-16 w-16 shrink-0 flex-col items-center justify-center rounded-xl bg-b1 text-white">
                        <span id="pv-hari" class="text-[22px] font-bold leading-none">--</span>
                        <span id="pv-bulan" class="mt-1.5 text-[11px] leading-none">---</span>
                    </div>
                    <div class="flex min-w-0 flex-col items-start gap-1.5">
                        <h3 id="pv-judul"
                            class="font-fraunces text-[18px] font-semibold leading-tight text-(--text-primary) wrap-break-words">
                        </h3>
                        <div class="flex flex-col gap-0.5 text-[12px] text-(--text-paragraph)">
                            <span id="pv-rentang-baris"
                                class="inline-flex items-center gap-1.5 font-medium text-(--text-primary)" hidden>
                                @include('components.icon', [
                                    'name' => 'calendar',
                                    'class' => 'w-3 h-3 shrink-0',
                                ])
                                <span id="pv-rentang"></span>
                            </span>
                            <span class="inline-flex items-center gap-1.5">
                                @include('components.icon', [
                                    'name' => 'clock',
                                    'class' => 'w-3 h-3 shrink-0',
                                ])
                                <span id="pv-waktu"></span>
                            </span>
                            <span class="inline-flex items-start gap-1.5">
                                @include('components.icon', [
                                    'name' => 'map-pin',
                                    'class' => 'mt-0.5 w-3 h-3 shrink-0',
                                ])
                                <span id="pv-lokasi" class="wrap-break-words"></span>
                            </span>
                        </div>
                        <p id="pv-deskripsi"
                            class="line-clamp-4 text-[13px] leading-relaxed text-(--text-paragraph) wrap-break-words">
                        </p>
                        <span id="pv-tombol"
                            class="mt-1.5 inline-flex items-center rounded-full border border-line px-3.5 py-2 text-[12px] font-semibold text-(--text-primary)">
                            Daftar Sekarang
                        </span>
                    </div>
                </article>
            </div>
            <p class="mt-3 text-[12px] leading-relaxed text-(--text-paragraph)">
                Event yang tanggalnya sudah lewat otomatis hilang dari halaman Event.
            </p>
        </aside>
    </div>

    @push('scripts')
        <script>
            (() => {
                const el = (id) => document.getElementById(id);
                const bulan = ['JAN', 'FEB', 'MAR', 'APR', 'MEI', 'JUN', 'JUL', 'AGU', 'SEP', 'OKT', 'NOV', 'DES'];
                const bulanPanjang = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus',
                    'September', 'Oktober', 'November', 'Desember'
                ];
                const MAKS_HARI = {{ \App\Models\Event::MAKS_HARI }};
                const f = {
                    judul: el('title'),
                    tanggal: el('event_date'),
                    hari: el('days'),
                    mulai: el('start_time'),
                    selesai: el('end_time'),
                    lokasi: el('location'),
                    deskripsi: el('description'),
                    link: el('registration_url'),
                };
                const pv = {
                    hari: el('pv-hari'),
                    bulan: el('pv-bulan'),
                    judul: el('pv-judul'),
                    waktu: el('pv-waktu'),
                    lokasi: el('pv-lokasi'),
                    deskripsi: el('pv-deskripsi'),
                    tombol: el('pv-tombol'),
                    rentang: el('pv-rentang'),
                    rentangBaris: el('pv-rentang-baris'),
                };
                const keluaran = el('tanggal_selesai');

                // Tanggal mulai + jumlah hari → tanggal selesai (UTC agar tidak bergeser oleh zona waktu)
                const tanggalSelesai = (mulai, jumlah) => {
                    const d = new Date(Date.UTC(Number(mulai[1]), Number(mulai[2]) - 1, Number(mulai[3])));
                    d.setUTCDate(d.getUTCDate() + jumlah - 1);
                    return {
                        h: d.getUTCDate(),
                        b: d.getUTCMonth(),
                        t: d.getUTCFullYear()
                    };
                };
                const dua = (n) => String(n).padStart(2, '0');
                const lengkap = (x) => `${x.h} ${bulanPanjang[x.b]} ${x.t}`;

                // Isi kolom ditampilkan; kalau kosong tampilkan contoh dengan warna pudar
                const isi = (node, nilai, contoh) => {
                    node.textContent = nilai || contoh;
                    node.classList.toggle('opacity-50', !nilai);
                };

                const render = () => {
                    isi(pv.judul, f.judul.value.trim(), 'Judul event Anda');
                    isi(pv.lokasi, f.lokasi.value.trim(), 'Lokasi event');
                    isi(pv.deskripsi, f.deskripsi.value.trim(), 'Deskripsi singkat event akan tampil di sini.');

                    const tgl = /^(\d{4})-(\d{2})-(\d{2})$/.exec(f.tanggal.value);
                    const jumlah = Math.min(MAKS_HARI, Math.max(1, parseInt(f.hari.value, 10) || 1));
                    const banyak = jumlah > 1;

                    if (!tgl) {
                        pv.hari.textContent = '--';
                        pv.bulan.textContent = '---';
                        pv.rentangBaris.hidden = true;
                        keluaran.textContent = '—';
                    } else {
                        const awal = {
                            h: Number(tgl[3]),
                            b: Number(tgl[2]) - 1,
                            t: Number(tgl[1])
                        };
                        const akhir = tanggalSelesai(tgl, jumlah);
                        const sebulan = awal.b === akhir.b && awal.t === akhir.t;

                        // Lencana: "21" / "21–23" / "30–02", bulan "OKT" / "OKT–NOV"
                        pv.hari.textContent = banyak ? `${dua(awal.h)}–${dua(akhir.h)}` : dua(awal.h);
                        pv.hari.classList.toggle('text-[22px]', !banyak);
                        pv.hari.classList.toggle('text-[16px]', banyak);
                        pv.bulan.textContent = banyak && !sebulan ? `${bulan[awal.b]}–${bulan[akhir.b]}` : bulan[awal
                            .b];

                        // Teks rentang: "21 – 23 Oktober 2026 · 3 hari"
                        let teks = lengkap(awal);
                        if (banyak) {
                            if (sebulan) teks = `${awal.h} – ${lengkap(akhir)}`;
                            else if (awal.t === akhir.t) teks = `${awal.h} ${bulanPanjang[awal.b]} – ${lengkap(akhir)}`;
                            else teks = `${lengkap(awal)} – ${lengkap(akhir)}`;
                        }
                        pv.rentang.textContent = `${teks} · ${jumlah} hari`;
                        pv.rentangBaris.hidden = !banyak;
                        keluaran.textContent = lengkap(akhir);
                    }

                    const titik = (jam) => jam.replace(':', '.');
                    const waktu = f.mulai.value ?
                        titik(f.mulai.value) + (f.selesai.value ? ' – ' + titik(f.selesai.value) : '') + ' WIB' +
                        (banyak ? ' setiap hari' : '') :
                        '';
                    isi(pv.waktu, waktu, 'Jam event');

                    pv.tombol.hidden = !f.link.value.trim();
                    el('hitung').textContent = f.deskripsi.value.length;
                };

                Object.values(f).forEach((node) => node.addEventListener('input', render));
                render();
            })();

            const styles = getComputedStyle(document.documentElement);

            const colorB1 = styles.getPropertyValue('--color-b1').trim();

            document.addEventListener('DOMContentLoaded', function() {
                const form = document.querySelector('.event-submit-form');

                if (!form) return;

                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Apakah kamu yakin?',
                        text: 'Pastikan data event sudah benar sebelum disimpan.',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: colorB1,
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, simpan!',
                        cancelButtonText: 'Periksa kembali'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
