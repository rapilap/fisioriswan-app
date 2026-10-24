@props(['fullname' => 'User', 'city' => '', 'image' => null, 'testimonial' => null, 'rating' => 5])

<article {{ $attributes->class(['flex w-full flex-col rounded-[20px] border border-line bg-(--bg-card) p-7']) }}>

    {{-- Foto testimoni (opsional) --}}
    <div
        class="relative h-51.25 overflow-hidden rounded-[20px] border border-line bg-linear-to-br from-photo-from to-photo-to">
        <div class="absolute inset-0 flex items-center justify-center text-[#8a9a90]">
            @include('components.icon', ['name' => 'image', 'class' => 'w-13 h-13', 'stroke' => 1.5])
        </div>
        <span class="absolute bottom-4 left-4 text-[12px] font-medium text-[#8a9a90]">Tanpa foto</span>
        @if ($image)
            <img src="{{ asset('storage/' . $image) }}" alt="Foto dari {{ $fullname }}" loading="lazy"
                onerror="this.remove()" class="absolute inset-0 h-full w-full object-cover">
        @endif
    </div>

    {{-- Rating bintang --}}
    <x-rating-stars :rating="$rating" class="mt-3" />

    {{-- Isi testimoni --}}
    <p class="mt-2.5 line-clamp-4 min-h-26.5 text-[16px] leading-relaxed text-(--text-primary)">
        “{{ $testimonial }}”
    </p>

    {{-- Nama dan kota --}}
    <div class="mt-9 flex items-center gap-3">
        <span
            class="flex h-10.5 w-10.5 shrink-0 items-center justify-center rounded-full bg-pill font-fraunces text-[16px] font-bold text-g1">
            {{ mb_strtoupper(mb_substr(trim($fullname), 0, 1)) }}
        </span>
        <div class="min-w-0">
            <h3 class="truncate text-[14px] font-semibold text-(--text-primary)">{{ $fullname }}</h3>
            <p class="truncate text-[13px] text-(--text-paragraph)">{{ $city }}</p>
        </div>
    </div>
</article>
