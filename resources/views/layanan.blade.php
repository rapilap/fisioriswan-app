@extends('layouts.app')
@section('title', 'Testimoni - Fisio Riswan')
@section('main_class', 'py-0')

@section('content')
    <section class="bg-(--bg-primary) px-4 sm:px-6 pt-12 sm:pt-16 lg:pt-18 pb-16 sm:pb-20 lg:pb-22">
        <div class="mx-auto max-w-6xl load-in w-full h-fit bg-cover bg-center relative" style="--load-delay: 100ms">
            {{-- Section 1 --}}
            @include('components.breadcrumb')
            <h1
                class="text-(--text-title) font-fraunces font-semibold
           text-[32px] leading-[1.1]
           sm:text-[36px]
           md:text-[40px]
           lg:text-[45px] lg:leading-[1.1]
           w-full md:w-[70%] lg:w-[50%]
           mt-2">
                Perawatan kesehatan yang mendekat ke rumah Anda.
            </h1>

            <p class="text-(--text-paragraph) text-base sm:text-lg mt-3 w-full sm:w-[90%] md:w-[75%] max-w-3xl">
                Pulihkan berdiri untuk memastikan setiap orang bisa mendapat perawatan
                fisioterapi yang nyaman dan praktis — tanpa antrean panjang, tanpa harus
                ke klinik, dan tanpa proses yang rumit.
            </p>
        </div>

        {{-- Section 2 --}}
        <div class="load-in w-full h-auto bg-cover bg-center relative py-8 sm:py-10 px-4 sm:px-6 lg:px-12 xl:px-24 flex flex-col items-center justify-center gap-3 bg-(--bg-secondary)"
            style="--load-delay: 200ms">
            <x-pill>Cara Pesan</x-pill>
            <h1
                class="text-(--text-primary) font-fraunces font-semibold
           text-[28px] leading-[1.2]
           sm:text-[32px]
           md:text-[38px]
           lg:text-[45px] lg:leading-[1.1]
           w-full md:w-[75%] xl:w-[55%]
           mt-2 text-center">
                Bagaimana cara pesan layanan Kami?
            </h1>
            {{-- Card --}}
            <div class="grid w-full grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 lg:gap-5 mt-6 sm:mt-8">
                <div
                    class="w-full min-w-0 flex flex-col items-start justify-start gap-2 bg-(--bg-card) p-5 sm:p-6 rounded-2xl border-(--border-line) border-2">
                    <x-pill-icon>
                        <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M19.0673 4.21668C18.5987 3.74552 18.0417 3.37161 17.4282 3.11647C16.8146 2.86133 16.1567 2.72998 15.4923 2.72998C14.8278 2.72998 14.1699 2.86133 13.5564 3.11647C12.9428 3.37161 12.3858 3.74552 11.9173 4.21668L11.0006 5.13335L10.0839 4.21668C9.13579 3.26853 7.84982 2.73587 6.50894 2.73587C5.16805 2.73587 3.88209 3.26853 2.93394 4.21668C1.98579 5.16483 1.45313 6.4508 1.45313 7.79168C1.45312 9.13257 1.98579 10.4185 2.93394 11.3667L3.85061 12.2833L11.0006 19.25L18.1506 12.2833L19.0673 11.3667C19.5384 10.8982 19.9123 10.3411 20.1675 9.72759C20.4226 9.11406 20.554 8.45615 20.554 7.79168C20.554 7.12722 20.4226 6.46931 20.1675 5.85578C19.9123 5.24225 19.5384 4.68521 19.0673 4.21668Z"
                                stroke="#B89633" stroke-width="1.65" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </x-pill-icon>
                    <span class="text-(--text-primary) font-fraunces text-xl font-semibold">Konsultasi</span>
                    <p class="text-(--text-secondary) text-base sm:text-lg">
                        Lakukan konsultasi penyakit dengan Kami melalui chat WhatsApp.
                    </p>
                </div>
                <div
                    class="w-full min-w-0 flex flex-col items-start justify-start gap-2 bg-(--bg-card) p-5 sm:p-6 rounded-2xl border-(--border-line) border-2">
                    <x-pill-icon>
                        <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_38_6063)">
                                <path
                                    d="M11 12.8334C14.0376 12.8334 16.5 10.3709 16.5 7.33337C16.5 4.29581 14.0376 1.83337 11 1.83337C7.96243 1.83337 5.5 4.29581 5.5 7.33337C5.5 10.3709 7.96243 12.8334 11 12.8334Z"
                                    stroke="#B89633" stroke-width="1.65" />
                                <path d="M7.79102 12.375L6.41602 20.1667L10.9993 17.4167L15.5827 20.1667L14.2077 12.375"
                                    stroke="#B89633" stroke-width="1.65" />
                            </g>
                            <defs>
                                <clipPath id="clip0_38_6063">
                                    <rect width="22" height="22" fill="white" />
                                </clipPath>
                            </defs>
                        </svg>

                    </x-pill-icon>
                    <span class="text-(--text-primary) font-fraunces text-xl font-semibold">Konfirmasi Waktu</span>
                    <p class="text-(--text-secondary) text-base sm:text-lg">
                        Konfirmasi jadwal kunjungan dengan Kami.
                    </p>
                </div>
                <div
                    class="w-full min-w-0 flex flex-col items-start justify-start gap-2 bg-(--bg-card) p-5 sm:p-6 rounded-2xl border-(--border-line) border-2">
                    <x-pill-icon>
                        <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M11 1.83337L2.75 5.50004V11C2.75 15.5834 6.23333 18.975 11 20.1667C15.7667 18.975 19.25 15.5834 19.25 11V5.50004L11 1.83337Z"
                                stroke="#B89633" stroke-width="1.65" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>

                    </x-pill-icon>
                    <span class="text-(--text-primary) font-fraunces text-xl font-semibold">Pembayaran</span>
                    <p class="text-(--text-secondary) text-base sm:text-lg">
                        Lakukan pembayaran secara digital melalui QRIS atau transfer bank.
                    </p>
                </div>
                <div
                    class="w-full min-w-0 flex flex-col items-start justify-start gap-2 bg-(--bg-card) p-5 sm:p-6 rounded-2xl border-(--border-line) border-2">
                    <x-pill-icon>
                        <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M15.5827 19.25V17.4167C15.5827 16.4442 15.1964 15.5116 14.5087 14.8239C13.8211 14.1363 12.8885 13.75 11.916 13.75H4.58268C3.61022 13.75 2.67759 14.1363 1.98996 14.8239C1.30232 15.5116 0.916016 16.4442 0.916016 17.4167V19.25"
                                stroke="#B89633" stroke-width="1.65" stroke-linecap="round" stroke-linejoin="round" />
                            <path
                                d="M8.25065 10.0833C10.2757 10.0833 11.9173 8.44171 11.9173 6.41667C11.9173 4.39162 10.2757 2.75 8.25065 2.75C6.22561 2.75 4.58398 4.39162 4.58398 6.41667C4.58398 8.44171 6.22561 10.0833 8.25065 10.0833Z"
                                stroke="#B89633" stroke-width="1.65" stroke-linecap="round" stroke-linejoin="round" />
                            <path
                                d="M21.0827 19.25V17.4166C21.0821 16.6042 20.8117 15.815 20.3139 15.1729C19.8162 14.5308 19.1193 14.0722 18.3327 13.8691M14.666 2.86914C15.4547 3.07108 16.1538 3.52978 16.653 4.17293C17.1522 4.81607 17.4232 5.60707 17.4232 6.42122C17.4232 7.23538 17.1522 8.02638 16.653 8.66952C16.1538 9.31266 15.4547 9.77136 14.666 9.97331"
                                stroke="#B89633" stroke-width="1.65" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>

                    </x-pill-icon>
                    <span class="text-(--text-primary) font-fraunces text-xl font-semibold">Sesi Terapi</span>
                    <p class="text-(--text-secondary) text-base sm:text-lg">
                        Tunggu Kami dan Kami berikan pengalaman terbaik dari layanan terapi Kami!
                    </p>
                </div>
            </div>
        </div>

        {{-- Section 3  --}}
        <div class="load-in w-full h-auto bg-cover bg-center relative py-8 sm:py-10 px-4 sm:px-6 lg:px-12 xl:px-24 flex flex-col items-center justify-center gap-3"
            style="--load-delay: 300ms">
            <x-pill>Layanan Kami</x-pill>
            <h1
                class="text-(--text-primary) font-fraunces font-semibold
           text-[28px] leading-[1.2]
           sm:text-[32px]
           md:text-[38px]
           lg:text-[45px] lg:leading-[1.1]
           w-full md:w-[75%] xl:w-[55%]
           mt-2 pb-8 sm:pb-12 text-center">
                Pilih paket sesuai kebutuhan pemulihan Anda.
            </h1>

            <div
                class="reveal grid w-full max-w-6xl grid-cols-1 gap-4 sm:gap-5
                    sm:grid-cols-2 lg:grid-cols-3 items-center justify-center">

                <x-package-card title="Kunjungan Tunggal" price="Rp 199rb" unit="kunjungan" :features="['1x kunjungan, 45-60 menit', 'Infrared / Ultrasound / TENS', 'Bebas pilih tanggal']" />

                <x-package-card title="Paket Reguler" price="Rp 720rb" unit="4 kunjungan" :features="['4x kunjungan, 45-60 menit', 'Fisioterapis tetap yang sama', 'Evaluasi progres tiap sesi']" />

                <x-package-card title="Paket Intensif" price="Rp 1,35jt" unit="8 kunjungan" :features="['8x kunjungan, 45-60 menit', 'Rencana pemulihan personal', 'Prioritas penjadwalan']" />

                <x-package-card title="Paket Intensif+" price="Rp 3jt" unit="12 kunjungan" :features="['12x kunjungan, 45-60 menit', 'Infrared / Ultrasound / TENS', 'Bebas pilih tanggal']" />

                <x-package-card title="Fisioterapi Acara"
                    description="Pesan Ermaya untuk acara Anda!
Kami akan berikan pelayanan sesuai dengan kebutuhan acara Anda." />

                <x-package-card title="Fisioterapi Wellness"
                    description="Sering melakukan kegiatan fisik berat? Pesan Ermaya Wellness sebagai fisioterapis pribadi Anda!" />

            </div>
        </div>
    </section>
@endsection
