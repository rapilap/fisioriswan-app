@extends('layouts.app')
@section('title', 'Testimoni - Fisio Riswan')
@section('main_class', 'py-0')

@section('content')
    {{-- 1. Hero --}}
    <section class="bg-cream px-6 pt-18 pb-22">
        <div class="mx-auto max-w-6xl">
            <div class="load-in mb-6">
                @include('components.breadcrumb')
            </div>
            <div class="load-in" style="--load-delay: 100ms">
                <h1 class="max-w-[700px] font-fraunces text-[34px] font-semibold leading-[1.1] text-primary md:text-[48px]">
                    Apa Komentar Setelah Pasien Menjalani Fisioterapi?
                </h1>
                <p class="mt-5 max-w-[380px] text-[18px] leading-[1.75] text-secondary">
                    Ulasan seputar layanan fisioterapi bersama tim fisioterapis Pulihkan.
                </p>
            </div>
        </div>
    </section>

    {{-- 2. Daftar testimoni --}}
    <section class="bg-sage px-6 pt-5 pb-16">
        <div class="mx-auto max-w-6xl">
            <div class="reveal text-center">
                <x-pill>Testimoni</x-pill>
                <h2 class="mt-2 font-fraunces text-[28px] font-semibold leading-tight text-primary">Ini Kata Pasien!</h2>
                <p class="mx-auto mt-1.5 max-w-[480px] text-[15px] leading-relaxed text-secondary">
                    Setiap ulasan pasien menjadi motivasi dan pembelajaran bagi kami untuk terus memberikan layanan
                    yang terbaik.
                </p>
            </div>

            <div class="mt-12 grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                @forelse ($testimonials as $item)
                    <x-testimonial-card class="reveal" style="--reveal-delay: {{ ($loop->index % 3) * 80 }}ms"
                        :fullname="$item->fullname" :city="$item->city" :image="$item->image"
                        :testimonial="$item->testimonial" :rating="$item->rating" />
                @empty
                    <p class="col-span-full rounded-[20px] border border-line bg-white px-6 py-16 text-center text-[15px] text-secondary">
                        Belum ada testimoni yang tersedia.
                    </p>
                @endforelse
            </div>

            <div class="mt-2">
                {{ $testimonials->links('pagination.circles') }}
            </div>

            {{-- CTA --}}
            <div class="reveal mt-16 flex flex-col gap-6 rounded-3xl bg-b1 px-14 py-14 text-white md:flex-row md:items-center md:justify-between">
                <div>
                    <h2 class="font-fraunces text-[38px] font-semibold leading-[1.15]">Pernah terapi bersama kami?</h2>
                    <p class="mt-3 max-w-[600px] text-[16px] leading-relaxed text-b5">
                        Buat ulasan Anda agar dapat membantu meyakinkan pasien lain untuk memilih layanan fisioterapi
                        Pulihkan.
                    </p>
                </div>
                <a href="{{ route('inputTestimoni') }}"
                    class="inline-flex shrink-0 items-center justify-center rounded-full bg-g1 px-6 py-3 text-[14px] font-semibold text-white transition hover:bg-g2">
                    Berikan Ulasan Anda di sini!
                </a>
            </div>
        </div>
    </section>
@endsection
