{{-- Kontrol slider (panah + titik indikator), diletakkan di tengah di bawah track --}}
<div class="flex items-center justify-center gap-4 mt-8">
    <button type="button" data-slider-prev aria-label="Sebelumnya"
        class="flex items-center justify-center w-10 h-10 rounded-full border border-b1 text-b1 transition hover:bg-b1 hover:text-white disabled:opacity-30 disabled:pointer-events-none">
        @include('components.icon', ['name' => 'chevron-left'])
    </button>
    <div class="flex items-center gap-2" data-slider-dots></div>
    <button type="button" data-slider-next aria-label="Berikutnya"
        class="flex items-center justify-center w-10 h-10 rounded-full border border-b1 text-b1 transition hover:bg-b1 hover:text-white disabled:opacity-30 disabled:pointer-events-none">
        @include('components.icon', ['name' => 'chevron-right'])
    </button>
</div>
