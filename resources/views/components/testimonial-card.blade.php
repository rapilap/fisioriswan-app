@props(['fullname' => 'User', 'city' => '', 'image' => null, 'testimonial' => null])

<article {{ $attributes->class(['flex h-fit w-[331px] flex-col rounded-xl bg-white p-7 sm:p-6 drop-shadow-lg']) }}>

    {{-- Gambar testimoni --}}
    @if ($image)
        <img src="{{ asset('storage/' . $image) }}" alt="{{ $fullname }}"
            class="h-full w-full object-cover rounded-lg mb-4" />
    @endif

    {{-- Rating bintang --}}
    <div class="flex gap-1 text-lg leading-none text-g1" aria-label="5 dari 5 bintang">
        @for ($i = 0; $i < 5; $i++)
            <span aria-hidden="true">★</span>
        @endfor
    </div>

    {{-- Isi testimoni --}}
    <p class="mt-2 mb-5 text-md leading-relaxed text-secondary">
        “{{ $testimonial }}”
    </p>
    <div class="flex items-center gap-3">

        {{-- Foto atau inisial nama --}}
        <x-pill-icon>
            {{ mb_strtoupper(mb_substr(trim($fullname), 0, 1)) }}
        </x-pill-icon>


        {{-- Nama dan kota --}}
        <div class="min-w-0">
            <h3 class="truncate font-semibold text-gray-900">
                {{ $fullname }}
            </h3>

            <p class="text-sm text-gray-500">
                {{ $city }}
            </p>
        </div>
    </div>

</article>
