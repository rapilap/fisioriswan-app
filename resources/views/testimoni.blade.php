<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @extends('layouts.app')
    @section('title', 'Testimoni - Fisio Riswan')
</head>
@section('content')
    <section>
        <div class=" w-full h-fit bg-cover bg-center relative px-24 pb-10">
            {{-- Section 1 --}}
            @include('components.breadcrumb')
            <h1
                class="text-primary font-fraunces font-semibold
           text-[32px] leading-[1.1]
           sm:text-[36px]
           md:text-[40px]
           lg:text-[45px] lg:leading-[1.1]
           w-full md:w-[70%] lg:w-[50%]
           mt-2 mx-2">
                Apa komentar setelah pasien menjalani fisioterapi di Ermaya Physio?
            </h1>

            <p class="text-secondary text-lg mt-2 mx-2 w-[75%]">
                Ulasan seputar layanan fisioterapi bersama tim fisioterapis Ermaya Physio.
            </p>
        </div>

        {{-- Section 2 --}}
        <div class="load-in w-full h-auto bg-cover bg-center relative py-10 px-24 flex flex-col items-center justify-center gap-3 bg-[#FBF8F2]"
            style="--load-delay: 100ms">
            <x-pill>
                Testimoni
            </x-pill>
            <h1
                class="text-primary font-fraunces font-semibold
           text-[32px] leading-[1.2]
           sm:text-[36px]
           md:text-[40px]
           lg:text-[45px] lg:leading-[1.1]
           w-full md:w-[65%] lg:w-[45%]
           mt-2 mx-2 text-center">
                Ini kata pasien!
            </h1>
            <p class="flex items-center justify-center text-secondary text-center text-md mt-2 mx-2 w-[50%]">
                Setiap ulasan pasien menjadi motivasi dan pembelajaran bagi kami untuk terus memberikan layanan yang
                terbaik.
            </p>

            <div class="columns-1 justify-items-center gap-6 sm:columns-2 lg:columns-3">
                @forelse ($testimonials as $item)
                    <div class="reveal mb-5 break-inside-avoid">
                        <x-testimonial-card :fullname="$item->fullname" :city="$item->city" :image="$item->image" :testimonial="$item->testimonial" />
                    </div>
                @empty
                    <p class="col-span-full
                        text-center text-gray-500">
                        Belum ada testimoni yang tersedia.
                    </p>
                @endforelse

            </div>
        </div>
    </section>
@endsection

</html>
