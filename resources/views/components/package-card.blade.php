@props([
    'title',
    'price' => null,
    'unit' => null,
    'description' => null,
    'features' => [],
    'buttonText' => 'Pesan Sekarang',
    'href' => '#',
])

<article
    {{ $attributes->class([
        'paket-card paket-populer flex h-[355px] w-[331px] flex-col rounded-xl bg-[var(--color-b1)] p-7 text-white transition duration-300 hover:-translate-y-1 hover:shadow-xl sm:p-6',
    ]) }}>
    {{-- Nama paket --}}
    <h3 class="font-fraunces text-lg font-semibold">
        {{ $title }}
    </h3>

    {{-- Harga, jika tersedia --}}
    @if ($price)
        <p class="mt-2 py-2">
            <span class="font-fraunces text-2xl font-bold">
                {{ $price }}
            </span>

            @if ($unit)
                <span class="text-sm">
                    / {{ $unit }}
                </span>
            @endif
        </p>
    @endif

    {{-- Deskripsi, jika tersedia --}}
    @if ($description)
        <p class="my-5 text-md leading-relaxed text-white/90">
            {{ $description }}
        </p>
    @endif

    {{-- Daftar fasilitas --}}
    @if (count($features))
        <ul class="my-5 space-y-3">
            @foreach ($features as $feature)
                <li class="flex items-start gap-2 text-md leading-relaxed">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.5" class="mt-0.5 h-4 w-4 shrink-0" aria-hidden="true">
                        <path d="m5 12 4 4L19 6" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>

                    <span>{{ $feature }}</span>
                </li>
            @endforeach
        </ul>
    @endif

    {{-- Tombol selalu berada di bawah --}}
    @php
        $message =
            "Halo, saya tertarik dengan paket *{$title}*\n" .
            "\nMohon isi data diri di bawah ini dengan benar dan teliti untuk pemesanan: \n" .
            "Nama Lengkap: \n" .
            "Alamat Lengkap: \n" .
            "Tanggal Mulai (Contoh: DD/MM/YYYY): \n" .
            "Waktu Mulai (Contoh: HH:MM): \n" .
            "\nTerima kasih, saya menunggu konfirmasi dari Anda.";
        $whatsappUrl = 'https://wa.me/' . config('services.whatsapp.number') . '?text=' . urlencode($message);
    @endphp

    <a href="{{ $whatsappUrl }}"
        class="mt-auto block rounded-full bg-[#B78A00]
               px-4 py-3 text-center text-md font-semibold
               text-white transition hover:bg-[#997300]
               focus-visible:outline-2
               focus-visible:outline-offset-2
               focus-visible:outline-white
               {{ $price || $description || count($features) ? 'mt-6' : 'mt-6' }}"
        target="_blank">
        {{ $buttonText }}
    </a>
</article>
