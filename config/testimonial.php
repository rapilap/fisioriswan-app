<?php

return [
    'cities' => [
        'Kota Bandung',
        'Kota Cimahi',
        'Kabupaten Bandung',
        'Kabupaten Bandung Barat',
        'Kabupaten Sumedang',
    ],

    // Paket yang bisa dipilih pelanggan di formulir testimoni.
    // 'visits' = jumlah sesi terapi yang ditambahkan ke statistik Beranda saat testimoninya ditampilkan.
    'packages' => [
        'kunjungan-tunggal' => ['nama' => 'Kunjungan Tunggal', 'visits' => 1],
        'kunjungan-reguler' => ['nama' => 'Kunjungan Reguler (4x)', 'visits' => 4],
        'paket-intensif' => ['nama' => 'Paket Intensif (8x)', 'visits' => 8],
        'paket-intensif-plus' => ['nama' => 'Paket Intensif+ (12x)', 'visits' => 12],
        'fisioterapi-event' => ['nama' => 'Fisioterapi Event', 'visits' => 0],
        'fisioterapi-wellness' => ['nama' => 'Fisioterapi Wellness', 'visits' => 0],
    ],

    // Angka awal statistik Beranda (sebelum ada testimoni dari website).
    // 'rating' = rata-rata bintang dari seluruh 'patients' yang sudah dilayani.
    // Setiap testimoni baru ikut dihitung sebagai 1 penilaian tambahan dalam rata-rata.
    'stats_base' => [
        'patients' => 727,
        'sessions' => 928,
        'rating' => 4.89367,
    ],
];
