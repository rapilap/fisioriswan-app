{{-- Judul halaman admin + tombol aksi di kanan. Pakai: <x-admin-header title="..." subtitle="..."> ...tombol... </x-admin-header> --}}
@props(['title', 'subtitle' => null])

<div class="flex flex-wrap items-end justify-between gap-4">
    <div class="min-w-0">
        <h1 class="font-fraunces text-[32px] font-semibold leading-tight text-primary">{{ $title }}</h1>
        @if ($subtitle)
            <p class="mt-1.5 max-w-[640px] text-[15px] leading-relaxed text-secondary">{{ $subtitle }}</p>
        @endif
    </div>
    @if (! $slot->isEmpty())
        <div class="flex shrink-0 flex-wrap items-center gap-3">{{ $slot }}</div>
    @endif
</div>
