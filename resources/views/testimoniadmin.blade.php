{{--
    Halaman admin testimoni. Dipakai untuk dua tab:
    - $mode = 'published' → Daftar Testimoni (status approved, tampil di beranda)
    - $mode = 'pending'   → Testimoni Pending (menunggu ditinjau admin)
--}}
@extends('layouts.admin')
@section('title', ($mode === 'pending' ? 'Testimoni Pending' : 'Daftar Testimoni') . ' - Admin Pulihkan')

@section('content')
    <h1 class="sr-only">{{ $mode === 'pending' ? 'Testimoni Pending' : 'Daftar Testimoni' }}</h1>

    @if (session('status'))
        <div role="status"
            class="mb-6 flex items-center gap-2.5 rounded-xl border border-line bg-white px-5 py-3 text-[14px] font-medium text-primary">
            <span class="text-g1">@include('components.icon', ['name' => 'check', 'class' => 'w-4 h-4'])</span>
            {{ session('status') }}
        </div>
    @endif

    @if ($testimonials->isEmpty())
        <div class="rounded-[20px] border border-line bg-white px-6 py-20 text-center">
            <p class="font-fraunces text-[24px] font-semibold text-primary">
                {{ $mode === 'pending' ? 'Tidak ada testimoni yang menunggu' : 'Belum ada testimoni yang ditampilkan' }}
            </p>
            <p class="mt-2 text-[14px] text-secondary">
                {{ $mode === 'pending'
                    ? 'Ulasan baru dari pelanggan akan muncul di sini untuk Anda tinjau.'
                    : 'Setujui testimoni dari halaman Testimoni Pending agar tampil di beranda.' }}
            </p>
        </div>
    @else
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3 lg:gap-x-3">
            @foreach ($testimonials as $item)
                <article class="flex flex-col rounded-[20px] border border-(--border-line) bg-(--bg-card) p-7">
                    {{-- Foto testimoni (opsional) --}}
                    <div
                        class="relative aspect-[326/205] overflow-hidden rounded-[20px] border border-line bg-linear-to-br from-photo-from to-photo-to">
                        <div class="absolute inset-0 flex items-center justify-center text-[#8a9a90]">
                            @include('components.icon', [
                                'name' => 'image',
                                'class' => 'w-13 h-13',
                                'stroke' => 1.5,
                            ])
                        </div>
                        <span class="absolute bottom-4 left-4 text-[12px] font-medium text-[#8a9a90]">Tanpa foto</span>
                        @if ($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" alt="Foto dari {{ $item->fullname }}"
                                loading="lazy" onerror="this.remove()" class="absolute inset-0 h-full w-full object-cover">
                        @endif
                    </div>

                    {{-- Bintang --}}
                    <x-rating-stars :rating="$item->rating" class="mt-5" />

                    {{-- Isi testimoni --}}
                    <p class="mt-3 line-clamp-4 min-h-[104px] text-[16px] leading-relaxed text-(--text-primary)">
                        “{{ $item->testimonial }}”
                    </p>

                    {{-- Pengirim --}}
                    <div class="mt-5 flex items-center gap-3">
                        <span
                            class="flex h-[42px] w-[42px] shrink-0 items-center justify-center rounded-full bg-pill font-fraunces text-[16px] font-bold text-g1">
                            {{ mb_strtoupper(mb_substr(trim($item->fullname), 0, 1)) }}
                        </span>
                        <div class="min-w-0">
                            <p class="truncate text-[14px] font-semibold text-(--text-primary)">{{ $item->fullname }}</p>
                            <p class="truncate text-[13px] text-(--text-paragraph)">{{ $item->city }}</p>
                        </div>
                    </div>

                    {{-- Aksi --}}
                    <div class="mt-5 flex gap-5">
                        @if ($mode === 'pending')
                            <form method="POST" action="{{ route('admin.testimoni.approve', $item) }}" class="flex-1">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="flex h-10 w-full cursor-pointer items-center justify-center gap-2 rounded-[10px] bg-b1 text-[14px] font-semibold text-white transition hover:opacity-90">
                                    @include('components.icon', ['name' => 'check', 'class' => 'w-4 h-4'])
                                    Tampilkan
                                </button>
                            </form>
                        @endif

                        <form method="POST" action="{{ route('admin.testimoni.destroy', $item) }}" class="flex-1"
                            onsubmit="return confirm(@js('Hapus testimoni dari ' . $item->fullname . '? Tindakan ini tidak bisa dibatalkan.'))">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="flex h-10 w-full cursor-pointer items-center justify-center gap-2 rounded-[10px] bg-danger text-[14px] font-semibold text-white transition hover:opacity-90">
                                @if ($mode === 'pending')
                                    @include('components.icon', ['name' => 'x', 'class' => 'w-4 h-4'])
                                @endif
                                Hapus
                            </button>
                        </form>
                    </div>
                </article>
            @endforeach
        </div>

        {{ $testimonials->links('pagination.circles') }}
    @endif
@endsection
