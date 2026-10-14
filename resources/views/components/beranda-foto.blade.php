{{-- Foto dengan placeholder: taruh file gambar di public/{{ $src }}
     Opsi: 'load' => true untuk animasi saat halaman dimuat (section pertama), 'delay' => ms --}}
<div class="{{ ($load ?? false) ? 'load-in' : 'reveal' }} relative overflow-hidden rounded-3xl bg-b5/40 {{ $class ?? '' }}"
    @if ($load ?? false) style="--load-delay: {{ $delay ?? 0 }}ms" @endif>
    <div class="absolute inset-0 flex flex-col items-center justify-center gap-2 text-b3">
        @include('components.icon', ['name' => 'image', 'class' => 'w-10 h-10', 'stroke' => 1.5])
        <span class="text-[12px]">public/{{ $src }}</span>
    </div>
    <img src="{{ asset($src) }}" alt="{{ $alt }}" loading="lazy" onerror="this.remove()"
        class="relative w-full h-full object-cover">
</div>
