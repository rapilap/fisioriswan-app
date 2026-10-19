{{-- Admin: daftar "Sorotan event sebelumnya" (foto, judul, keterangan singkat). --}}
@extends('layouts.admin')
@section('title', 'Sorotan Event - Admin Pulihkan')

@section('content')
    <x-admin-header title="Sorotan Event"
        subtitle="Dokumentasi event yang sudah berlangsung. Foto, judul, dan keterangan singkat tampil di bagian “Sorotan event sebelumnya” pada halaman Event.">
        <a href="{{ route('admin.sorotan.create') }}"
            class="inline-flex h-11 items-center gap-2 rounded-[10px] bg-b1 px-5 text-[14px] font-semibold text-white transition hover:opacity-90">
            @include('components.icon', ['name' => 'plus', 'class' => 'w-4 h-4'])
            Tambah Sorotan
        </a>
    </x-admin-header>

    <div class="mt-8">
        <x-admin-status />

        @if ($highlights->isEmpty())
            <div class="rounded-[20px] border border-line bg-white px-6 py-20 text-center">
                <p class="font-fraunces text-[24px] font-semibold text-primary">Belum ada sorotan event</p>
                <p class="mx-auto mt-2 max-w-[420px] text-[14px] leading-relaxed text-secondary">
                    Unggah foto kegiatan event sebelumnya agar pengunjung bisa melihat hasil kolaborasi Pulihkan.
                </p>
                <a href="{{ route('admin.sorotan.create') }}"
                    class="mt-6 inline-flex h-11 items-center gap-2 rounded-[10px] bg-b1 px-5 text-[14px] font-semibold text-white transition hover:opacity-90">
                    @include('components.icon', ['name' => 'plus', 'class' => 'w-4 h-4'])
                    Tambah Sorotan Pertama
                </a>
            </div>
        @else
            @if ($highlights->total() > 6)
                <div class="mb-5 flex items-start gap-3 rounded-xl border border-line bg-white px-5 py-3.5 text-[14px] leading-relaxed text-secondary">
                    <span class="mt-0.5 shrink-0 text-b2">@include('components.icon', ['name' => 'info', 'class' => 'w-4 h-4'])</span>
                    <p>Halaman Event menampilkan <strong class="text-primary">6 sorotan terbaru</strong>. Yang lebih lama tetap tersimpan di sini.</p>
                </div>
            @endif

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($highlights as $item)
                    <article class="flex flex-col rounded-[20px] border border-line bg-white p-5">
                        <div class="relative aspect-[4/3] overflow-hidden rounded-2xl border border-line bg-linear-to-br from-photo-from to-photo-to">
                            <div class="absolute inset-0 flex items-center justify-center text-g3">
                                @include('components.icon', ['name' => 'image', 'class' => 'w-12 h-12', 'stroke' => 1.5])
                            </div>
                            <img src="{{ asset($item->imagePath()) }}" alt="{{ $item->title }}" loading="lazy"
                                onerror="this.remove()" class="absolute inset-0 h-full w-full object-cover">
                        </div>

                        <h2 class="mt-4 text-[16px] font-semibold leading-snug text-primary">{{ $item->title }}</h2>
                        <p class="mt-1 line-clamp-2 flex-1 text-[14px] leading-relaxed text-secondary">{{ $item->description }}</p>

                        <div class="mt-5 flex gap-3">
                            <a href="{{ route('admin.sorotan.edit', $item) }}"
                                class="inline-flex h-10 flex-1 items-center justify-center gap-2 rounded-[10px] border border-b1 text-[14px] font-semibold text-b1 transition hover:bg-b1 hover:text-white">
                                @include('components.icon', ['name' => 'pencil', 'class' => 'w-4 h-4'])
                                Edit
                            </a>
                            <form method="POST" action="{{ route('admin.sorotan.destroy', $item) }}" class="flex-1"
                                onsubmit="return confirm(@js('Hapus sorotan “' . $item->title . '”? Foto juga ikut terhapus dan tindakan ini tidak bisa dibatalkan.'))">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="inline-flex h-10 w-full cursor-pointer items-center justify-center gap-2 rounded-[10px] bg-danger text-[14px] font-semibold text-white transition hover:opacity-90">
                                    @include('components.icon', ['name' => 'trash', 'class' => 'w-4 h-4'])
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </article>
                @endforeach
            </div>

            {{ $highlights->links('pagination.circles') }}
        @endif
    </div>
@endsection
