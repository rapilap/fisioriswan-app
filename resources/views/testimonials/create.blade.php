@extends('layouts.app')
@section('title', 'Input Testimoni - Fisio Riswan')
@section('main_class', 'py-0')

@php
    $field = 'h-8 w-full rounded border bg-sage px-2 text-[16px] text-primary placeholder:text-[#b7b9b5] focus:border-b1 focus:outline-none';
    $border = fn (string $name) => $errors->has($name) ? 'border-danger' : 'border-[#d9d9d9]';
@endphp

@section('content')
    {{-- 1. Hero --}}
    <section class="bg-cream px-6 pt-18 pb-22">
        <div class="mx-auto max-w-6xl">
            <div class="load-in mb-6">
                @include('components.breadcrumb')
            </div>
            <div class="load-in" style="--load-delay: 100ms">
                <h1 class="font-fraunces text-[34px] font-semibold leading-[1.1] text-primary md:text-[48px]">
                    Berikan Komentar Anda di Sini!
                </h1>
                <p class="mt-5 max-w-[760px] text-[18px] leading-[1.75] text-secondary">
                    Isi formulir di bawah ini untuk mengisi testimoni tentang pengalaman terbaik Anda.
                </p>
            </div>
        </div>
    </section>

    {{-- 2. Formulir --}}
    <section class="bg-sage px-6 pt-3 pb-25">
        <div class="mx-auto max-w-[1216px]">
            <div class="reveal text-center">
                <x-pill>Formulir Testimoni</x-pill>
                <h2 class="mt-2 font-fraunces text-[28px] font-semibold leading-tight text-primary">Ini Kata Pasien!</h2>

                <p class="mx-auto mt-1 flex max-w-[480px] items-start gap-3 rounded-[10px] border border-b2 bg-[#dcdde6] px-3 py-2.5 text-left text-[16px] leading-relaxed text-primary">
                    <span class="mt-1.5 flex h-4 w-4 shrink-0 items-center justify-center rounded-full bg-b1 text-[11px] font-bold leading-none text-white" aria-hidden="true">!</span>
                    <span><strong>Perhatian:</strong> Sesuai pengalaman Anda, mohon isi testimoni dengan bahasa yang baik.</span>
                </p>
            </div>

            @if (session('status'))
                <div role="status"
                    class="mx-auto mt-4 flex max-w-[640px] items-start gap-2.5 rounded-xl border border-line bg-white px-5 py-3 text-[15px] font-medium text-primary">
                    <span class="mt-0.5 shrink-0 text-g1">@include('components.icon', ['name' => 'check', 'class' => 'w-4 h-4'])</span>
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('testimoni.store') }}" enctype="multipart/form-data" novalidate
                class="reveal mt-4 rounded-xl border border-b3 bg-sage px-8 py-5">
                @csrf

                {{-- Jebakan spam: kolom ini disembunyikan dari pengguna asli --}}
                <div class="absolute -left-[9999px]" aria-hidden="true">
                    <label>Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label>
                </div>

                <div class="grid grid-cols-1 gap-x-3.5 gap-y-3 md:grid-cols-3">
                    <div>
                        <label for="fullname" class="block text-[16px] text-black">Nama Lengkap*</label>
                        <input id="fullname" name="fullname" type="text" value="{{ old('fullname') }}" maxlength="100"
                            required placeholder="Contoh: Ahmad" class="mt-1.5 {{ $field }} {{ $border('fullname') }}">
                        @error('fullname') <p class="mt-1 text-[13px] text-danger">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="city" class="block text-[16px] text-black">Kota Domisili*</label>
                        <div class="relative mt-1.5">
                            <select id="city" name="city" required
                                class="{{ $field }} {{ $border('city') }} appearance-none pr-8 {{ old('city') ? '' : 'text-[#b7b9b5]' }}">
                                <option value="" disabled @selected(! old('city'))>Pilih Kota Domisili</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city }}" class="text-primary" @selected(old('city') === $city)>{{ $city }}</option>
                                @endforeach
                            </select>
                            <span class="pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 text-secondary">
                                @include('components.icon', ['name' => 'chevron-down', 'class' => 'w-4 h-4'])
                            </span>
                        </div>
                        @error('city') <p class="mt-1 text-[13px] text-danger">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="image" class="block text-[16px] text-black">Foto</label>
                        <input id="image" name="image" type="file" accept="image/*"
                            class="mt-1.5 h-8 w-full rounded border bg-sage text-[14px] text-secondary file:mr-3 file:h-full file:cursor-pointer file:border-0 file:bg-pill file:px-3 file:text-[13px] file:font-medium file:text-g1 {{ $border('image') }}">
                        <p id="image-error" class="mt-1 text-[13px] text-danger" @if (! $errors->has('image')) hidden @endif>{{ $errors->first('image') }}</p>
                        <p class="mt-1 text-[12px] text-secondary">Semua format foto, maksimal 5 MB.</p>
                    </div>
                </div>

                <div class="mt-3">
                    <span id="rating-label" class="block text-[16px] text-black">Rating*</span>
                    <div class="star-rating mt-1.5" role="radiogroup" aria-labelledby="rating-label">
                        @foreach ([5, 4, 3, 2, 1] as $nilai)
                            <input type="radio" name="rating" id="rating-{{ $nilai }}" value="{{ $nilai }}"
                                @checked((int) old('rating') === $nilai) required>
                            <label for="rating-{{ $nilai }}" title="{{ $nilai }} dari 5 bintang">
                                <span class="sr-only">{{ $nilai }} bintang</span>
                                @include('components.icon', ['name' => 'star', 'fill' => 'currentColor', 'stroke' => 1, 'class' => 'w-7 h-7'])
                            </label>
                        @endforeach
                    </div>
                    @error('rating') <p class="mt-1 text-[13px] text-danger">{{ $message }}</p> @enderror
                </div>

                <div class="mt-3">
                    <label for="testimonial" class="block text-[16px] text-black">Testimoni Anda*</label>
                    <textarea id="testimonial" name="testimonial" required maxlength="1000"
                        placeholder="Ceritakan pengalaman Anda menggunakan layanan kami..."
                        class="mt-1.5 h-[292px] w-full resize-y rounded border bg-sage px-2 py-1.5 text-[16px] text-primary placeholder:text-[#b7b9b5] focus:border-b1 focus:outline-none {{ $border('testimonial') }}">{{ old('testimonial') }}</textarea>
                    @error('testimonial') <p class="mt-1 text-[13px] text-danger">{{ $message }}</p> @enderror
                </div>

                <div class="mt-8 flex flex-wrap items-center justify-center gap-5">
                    <button type="submit"
                        class="inline-flex h-[38px] cursor-pointer items-center gap-2.5 rounded-lg bg-b1 px-4 text-[16px] text-white transition hover:opacity-90">
                        @include('components.icon', ['name' => 'send', 'class' => 'w-4 h-4'])
                        Kirim Testimoni
                    </button>
                    <button type="reset"
                        class="inline-flex h-[38px] cursor-pointer items-center gap-2.5 rounded-lg border border-b1 bg-white px-4 text-[16px] text-b1 transition hover:bg-b5">
                        @include('components.icon', ['name' => 'rotate-cw', 'class' => 'w-4 h-4'])
                        Reset
                    </button>
                </div>
            </form>
        </div>
    </section>

    {{-- Cek ukuran foto di browser sebelum dikirim (server tetap memvalidasi) --}}
    <script>
        (() => {
            const input = document.getElementById('image');
            const pesan = document.getElementById('image-error');
            const batas = 5 * 1024 * 1024;
            input.addEventListener('change', () => {
                const file = input.files[0];
                if (file && file.size > batas) {
                    input.value = '';
                    pesan.textContent = 'Ukuran foto maksimal 5 MB.';
                    pesan.hidden = false;
                } else {
                    pesan.hidden = true;
                }
            });
        })();
    </script>
@endsection
