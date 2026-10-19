{{--
    Admin: daftar event.
    - Tab "Akan datang": event yang tampil di halaman Event (3 terlihat, sisanya digulir pengunjung)
    - Tab "Sudah lewat" : arsip, tidak tampil di website
--}}
@extends('layouts.admin')
@section('title', 'Event - Admin Pulihkan')

@section('content')
    <x-admin-header title="Event"
        subtitle="Isi jadwal event hasil kolaborasi. Event yang akan datang otomatis tampil di halaman Event website, lengkap dengan tombol pendaftaran.">
        <a href="{{ route('admin.event.create') }}"
            class="inline-flex h-11 items-center gap-2 rounded-[10px] bg-b1 px-5 text-[14px] font-semibold text-white transition hover:opacity-90">
            @include('components.icon', ['name' => 'plus', 'class' => 'w-4 h-4'])
            Tambah Event
        </a>
    </x-admin-header>

    {{-- Tab --}}
    <nav aria-label="Filter event" class="mt-8 flex flex-wrap gap-2">
        @foreach ([
            ['kunci' => 'mendatang', 'label' => 'Akan datang', 'jumlah' => $jumlahMendatang],
            ['kunci' => 'lewat', 'label' => 'Sudah lewat', 'jumlah' => $jumlahLewat],
        ] as $tab)
            @php $aktif = $tampil === $tab['kunci']; @endphp
            <a href="{{ route('admin.event.index', $tab['kunci'] === 'lewat' ? ['tampil' => 'lewat'] : []) }}"
                @if ($aktif) aria-current="page" @endif
                class="inline-flex items-center gap-2 rounded-full border px-4 py-2 text-[14px] font-semibold transition
                {{ $aktif ? 'border-b1 bg-b1 text-white' : 'border-line bg-white text-secondary hover:border-b1 hover:text-b1' }}">
                {{ $tab['label'] }}
                <span class="rounded-full px-2 py-0.5 text-[12px] leading-none {{ $aktif ? 'bg-white/20' : 'bg-sage-deep' }}">{{ $tab['jumlah'] }}</span>
            </a>
        @endforeach
    </nav>

    <div class="mt-6">
        <x-admin-status />

        {{-- Penjelasan batas 3 event di website --}}
        @if ($tampil === 'mendatang' && $jumlahMendatang > 3)
            <div class="mb-5 flex items-start gap-3 rounded-xl border border-line bg-white px-5 py-3.5 text-[14px] leading-relaxed text-secondary">
                <span class="mt-0.5 shrink-0 text-b2">@include('components.icon', ['name' => 'info', 'class' => 'w-4 h-4'])</span>
                <p>
                    Halaman Event menampilkan <strong class="text-primary">3 event teratas</strong> sekaligus.
                    Event berikutnya muncul saat pengunjung menggulir daftar, jadi semua tetap bisa dilihat.
                </p>
            </div>
        @endif

        @if ($events->isEmpty())
            <div class="rounded-[20px] border border-line bg-white px-6 py-20 text-center">
                <p class="font-fraunces text-[24px] font-semibold text-primary">
                    {{ $tampil === 'lewat' ? 'Belum ada event yang sudah lewat' : 'Belum ada event yang akan datang' }}
                </p>
                <p class="mx-auto mt-2 max-w-[420px] text-[14px] leading-relaxed text-secondary">
                    {{ $tampil === 'lewat'
                        ? 'Event yang tanggalnya sudah lewat akan berpindah ke sini secara otomatis.'
                        : 'Tambahkan event hasil kolaborasi agar pengunjung bisa langsung mendaftar lewat halaman Event.' }}
                </p>
                @if ($tampil === 'mendatang')
                    <a href="{{ route('admin.event.create') }}"
                        class="mt-6 inline-flex h-11 items-center gap-2 rounded-[10px] bg-b1 px-5 text-[14px] font-semibold text-white transition hover:opacity-90">
                        @include('components.icon', ['name' => 'plus', 'class' => 'w-4 h-4'])
                        Tambah Event Pertama
                    </a>
                @endif
            </div>
        @else
            <div class="flex flex-col gap-4">
                @foreach ($events as $event)
                    @php
                        $lewat = ! $event->isUpcoming();
                        $urutan = $events->firstItem() + $loop->index; // urutan di antara event yang akan datang
                    @endphp
                    <article class="flex flex-col gap-5 rounded-[20px] border border-line bg-white p-6 sm:flex-row sm:items-start">
                        {{-- Tanggal --}}
                        <div
                            class="flex h-[74px] w-[74px] shrink-0 flex-col items-center justify-center rounded-xl text-white {{ $lewat ? 'bg-secondary' : 'bg-b1' }}">
                            <span class="{{ mb_strlen($event->tanggalAngka()) > 2 ? 'text-[18px]' : 'text-[24px]' }} font-bold leading-none">{{ $event->tanggalAngka() }}</span>
                            <span class="mt-1.5 text-[12px] leading-none">{{ $event->bulanSingkat() }}</span>
                        </div>

                        {{-- Isi --}}
                        <div class="min-w-0 flex-1">
                            <div class="flex flex-wrap items-center gap-x-3 gap-y-1.5">
                                <h2 class="font-fraunces text-[22px] font-semibold leading-tight text-primary">{{ $event->title }}</h2>
                                @if ($lewat)
                                    <span class="rounded-full bg-sage-deep px-2.5 py-1 text-[12px] font-semibold leading-none text-secondary">Tidak tampil di website</span>
                                @elseif ($urutan > 3)
                                    <span class="rounded-full bg-pill px-2.5 py-1 text-[12px] font-semibold leading-none text-g1">Tampil setelah digulir</span>
                                @else
                                    <span class="rounded-full bg-pill-green px-2.5 py-1 text-[12px] font-semibold leading-none text-b1">Tampil di website</span>
                                @endif
                            </div>

                            <div class="mt-2 flex flex-wrap gap-x-5 gap-y-1 text-[13px] text-secondary">
                                <span class="inline-flex items-center gap-1.5">
                                    @include('components.icon', ['name' => 'calendar', 'class' => 'w-3.5 h-3.5'])
                                    {{ $event->rentangDenganDurasi() ?? $event->tanggalLengkap() }}
                                </span>
                                <span class="inline-flex items-center gap-1.5">
                                    @include('components.icon', ['name' => 'clock', 'class' => 'w-3.5 h-3.5'])
                                    {{ $event->waktuLabel() }}
                                </span>
                                <span class="inline-flex items-center gap-1.5">
                                    @include('components.icon', ['name' => 'map-pin', 'class' => 'w-3.5 h-3.5'])
                                    {{ $event->location }}
                                </span>
                            </div>

                            <p class="mt-2.5 line-clamp-2 max-w-[680px] text-[15px] leading-relaxed text-secondary">{{ $event->description }}</p>

                            {{-- Link tombol pendaftaran --}}
                            <div class="mt-3">
                                @if ($event->registration_url)
                                    <a href="{{ $event->registration_url }}" target="_blank" rel="noopener noreferrer"
                                        class="inline-flex max-w-full items-center gap-1.5 rounded-full border border-line bg-sage px-3 py-1.5 text-[13px] font-medium text-b1 transition hover:border-b1">
                                        @include('components.icon', ['name' => 'link', 'class' => 'w-3.5 h-3.5 shrink-0'])
                                        <span class="truncate">{{ $event->linkRingkas() }}</span>
                                        @include('components.icon', ['name' => 'external', 'class' => 'w-3 h-3 shrink-0 opacity-60'])
                                    </a>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-g5 px-3 py-1.5 text-[13px] font-medium text-g1">
                                        @include('components.icon', ['name' => 'alert', 'class' => 'w-3.5 h-3.5'])
                                        Belum ada link, tombol “Daftar Sekarang” tidak tampil
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Aksi --}}
                        <div class="flex shrink-0 gap-2 sm:flex-col">
                            <a href="{{ route('admin.event.edit', $event) }}"
                                class="inline-flex h-10 flex-1 items-center justify-center gap-2 rounded-[10px] border border-b1 px-4 text-[14px] font-semibold text-b1 transition hover:bg-b1 hover:text-white sm:flex-none">
                                @include('components.icon', ['name' => 'pencil', 'class' => 'w-4 h-4'])
                                Edit
                            </a>
                            <form method="POST" action="{{ route('admin.event.destroy', $event) }}" class="flex-1 sm:flex-none"
                                onsubmit="return confirm(@js('Hapus event “' . $event->title . '”? Tindakan ini tidak bisa dibatalkan.'))">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="inline-flex h-10 w-full cursor-pointer items-center justify-center gap-2 rounded-[10px] bg-danger px-4 text-[14px] font-semibold text-white transition hover:opacity-90">
                                    @include('components.icon', ['name' => 'trash', 'class' => 'w-4 h-4'])
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </article>
                @endforeach
            </div>

            {{ $events->links('pagination.circles') }}
        @endif
    </div>
@endsection
