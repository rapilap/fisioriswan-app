{{-- Admin: tambah / edit sorotan event (foto, judul, keterangan singkat). --}}
@extends('layouts.admin')

@php
    $edit = $highlight->exists;
    $judulHalaman = $edit ? 'Edit Sorotan' : 'Tambah Sorotan';
    $fotoSaatIni = $edit ? asset($highlight->imagePath()) : null;

    $input =
        'h-11 w-full rounded-[10px] border bg-sage px-3.5 text-[15px] text-primary placeholder:text-[#a3aaa5] focus:border-b1 focus:outline-none focus:ring-2 focus:ring-b1/15';
    $border = fn(string $name) => $errors->has($name) ? 'border-danger' : 'border-line';
@endphp

@section('title', $judulHalaman . ' - Admin Pulihkan')

@section('content')
    <a href="{{ route('admin.sorotan.index') }}"
        class="mb-5 inline-flex items-center gap-2 text-[14px] font-medium text-secondary transition hover:text-b1">
        @include('components.icon', ['name' => 'arrow-left', 'class' => 'w-4 h-4'])
        Kembali ke daftar sorotan
    </a>

    <x-admin-header :title="$judulHalaman"
        subtitle="Unggah foto kegiatan, beri judul, dan tulis keterangan singkat tentang apa yang dilakukan di event tersebut." />

    <div class="mt-8 grid items-start gap-8 lg:grid-cols-[minmax(0,1fr)_400px]">
        <form method="POST" enctype="multipart/form-data" novalidate
            action="{{ $edit ? route('admin.sorotan.update', $highlight) : route('admin.sorotan.store') }}"
            class="rounded-[20px] border border-(--border-line) bg-(--bg-card) p-7 highlight-submit-form">
            @csrf
            @if ($edit)
                @method('PUT')
            @endif

            @if ($errors->any())
                <div role="alert"
                    class="mb-6 flex items-start gap-2.5 rounded-xl border border-danger/30 bg-danger/5 px-4 py-3 text-[14px] text-danger">
                    @include('components.icon', ['name' => 'alert', 'class' => 'mt-0.5 w-4 h-4 shrink-0'])
                    <p>Beberapa kolom belum benar. Periksa pesan berwarna merah di bawah.</p>
                </div>
            @endif

            <div class="flex flex-col gap-5">
                {{-- Foto --}}
                <div>
                    <span class="mb-1.5 block text-[14px] font-semibold text-(--text-primary)">
                        Foto @unless ($edit)
                            <span class="text-danger">*</span>
                        @endunless
                    </span>
                    <label for="image"
                        class="group relative flex aspect-4/3 cursor-pointer flex-col items-center justify-center overflow-hidden rounded-2xl border-2 border-dashed bg-sage text-center transition hover:border-b1 has-focus-visible:border-b1 has-focus-visible:ring-2 has-focus-visible:ring-b1/20
                        {{ $errors->has('image') ? 'border-danger' : 'border-b4' }}">
                        <input id="image" name="image" type="file" accept="image/jpeg,image/png,image/webp"
                            class="sr-only">

                        <img id="foto-preview" alt="Pratinjau foto"
                            @if ($fotoSaatIni) src="{{ $fotoSaatIni }}" @else hidden @endif
                            class="absolute inset-0 h-full w-full object-cover">

                        <div id="foto-kosong"
                            class="flex flex-col items-center gap-2 px-6 text-secondary {{ $fotoSaatIni ? 'hidden' : '' }}">
                            <span class="flex size-12 items-center justify-center rounded-full bg-white text-b1 shadow-sm">
                                @include('components.icon', ['name' => 'upload', 'class' => 'w-5 h-5'])
                            </span>
                            <span class="text-[15px] font-semibold text-primary">Klik untuk memilih foto</span>
                            <span class="text-[12px]">JPG, PNG, atau WEBP · maksimal 5 MB · disarankan rasio 4:3</span>
                        </div>

                        @if ($fotoSaatIni)
                            <span id="foto-ganti"
                                class="absolute bottom-3 right-3 inline-flex items-center gap-1.5 rounded-full bg-white/90 px-3 py-1.5 text-[12px] font-semibold text-b1 shadow-sm backdrop-blur transition group-hover:bg-b1 group-hover:text-white">
                                @include('components.icon', ['name' => 'upload', 'class' => 'w-3.5 h-3.5'])
                                Ganti foto
                            </span>
                        @endif
                    </label>
                    <p id="foto-error" class="mt-1.5 text-[13px] text-danger"
                        @if (!$errors->has('image')) hidden @endif>{{ $errors->first('image') }}</p>
                    @if ($edit)
                        <p class="mt-1.5 text-[12px] text-secondary">Biarkan kosong jika tidak ingin mengganti foto.</p>
                    @endif
                </div>

                <div>
                    <label for="title" class="mb-1.5 block text-[14px] font-semibold text-(--text-primary)">Judul <span
                            class="text-danger">*</span></label>
                    <input id="title" name="title" type="text" maxlength="120" required
                        value="{{ old('title', $highlight->title) }}" placeholder="Contoh: Fun Run Jakarta 2026"
                        class="{{ $input }} {{ $border('title') }}">
                    @error('title')
                        <p class="mt-1.5 text-[13px] text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <div class="mb-1.5 flex items-end justify-between">
                        <label for="description" class="text-[14px] font-semibold text-(--text-primary)">Keterangan singkat
                            <span class="text-danger">*</span></label>
                        <span class="text-[12px] text-secondary"><span id="hitung">0</span>/200</span>
                    </div>
                    <textarea id="description" name="description" rows="3" maxlength="200" required
                        placeholder="Contoh: Pendampingan 300+ pelari"
                        class="w-full resize-y rounded-[10px] border bg-sage px-3.5 py-2.5 text-[15px] leading-relaxed text-primary placeholder:text-[#a3aaa5] focus:border-b1 focus:outline-none focus:ring-2 focus:ring-b1/15 {{ $border('description') }}">{{ old('description', $highlight->description) }}</textarea>
                    @error('description')
                        <p class="mt-1.5 text-[13px] text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-8 flex flex-wrap items-center gap-3 border-t border-line pt-6">
                <button type="submit"
                    class="inline-flex h-11 cursor-pointer items-center gap-2 rounded-[10px] bg-b1 px-6 text-[14px] font-semibold text-white transition hover:opacity-90">
                    @include('components.icon', ['name' => 'check', 'class' => 'w-4 h-4'])
                    {{ $edit ? 'Simpan Perubahan' : 'Simpan Sorotan' }}
                </button>
                <a href="{{ route('admin.sorotan.index') }}"
                    class="inline-flex h-11 items-center rounded-[10px] border border-line px-6 text-[14px] font-semibold text-secondary transition hover:border-b1 hover:text-b1">
                    Batal
                </a>
            </div>
        </form>

        {{-- Pratinjau --}}
        <aside class="lg:sticky lg:top-6" aria-label="Pratinjau di website">
            <p class="mb-3 text-[12px] font-semibold uppercase tracking-wider text-(--text-paragraph)">Pratinjau di website
            </p>
            <div class="rounded-[20px] bg-(--bg-shadow) p-4">
                <article>
                    <div
                        class="relative aspect-4/3 overflow-hidden rounded-[20px] border border-line bg-linear-to-br from-photo-from to-photo-to">
                        <div class="absolute inset-0 flex items-center justify-center text-g3">
                            @include('components.icon', [
                                'name' => 'image',
                                'class' => 'w-12 h-12',
                                'stroke' => 1.5,
                            ])
                        </div>
                        <img id="pv-foto" alt=""
                            @if ($fotoSaatIni) src="{{ $fotoSaatIni }}" @else hidden @endif
                            class="absolute inset-0 h-full w-full object-cover">
                    </div>
                    <h3 id="pv-judul" class="mt-4 text-[16px] font-semibold text-(--text-primary) wrap-break-words"></h3>
                    <p id="pv-keterangan" class="mt-1 text-[14px] text-(--text-paragraph) wrap-break-words"></p>
                </article>
            </div>
        </aside>
    </div>

    @push('scripts')
        <script>
            (() => {
                const el = (id) => document.getElementById(id);
                const input = el('image');
                const judul = el('title');
                const ket = el('description');
                const batas = 5 * 1024 * 1024;
                const tipe = ['image/jpeg', 'image/png', 'image/webp'];
                let urlSementara = null;

                const tampilFoto = (src) => {
                    ['foto-preview', 'pv-foto'].forEach((id) => {
                        el(id).src = src;
                        el(id).hidden = false;
                    });
                    el('foto-kosong').classList.add('hidden');
                };

                const isi = (node, nilai, contoh) => {
                    node.textContent = nilai || contoh;
                    node.classList.toggle('opacity-50', !nilai);
                };

                input.addEventListener('change', () => {
                    const file = input.files[0];
                    const pesan = el('foto-error');
                    if (!file) return;

                    if (file.size > batas || !tipe.includes(file.type)) {
                        input.value = '';
                        pesan.textContent = file.size > batas ?
                            'Ukuran foto maksimal 5 MB.' :
                            'Foto harus berformat JPG, PNG, atau WEBP.';
                        pesan.hidden = false;
                        return;
                    }

                    pesan.hidden = true;
                    if (urlSementara) URL.revokeObjectURL(urlSementara);
                    urlSementara = URL.createObjectURL(file);
                    tampilFoto(urlSementara);
                });

                const render = () => {
                    isi(el('pv-judul'), judul.value.trim(), 'Judul sorotan');
                    isi(el('pv-keterangan'), ket.value.trim(), 'Keterangan singkat kegiatan.');
                    el('hitung').textContent = ket.value.length;
                };
                judul.addEventListener('input', render);
                ket.addEventListener('input', render);
                render();
            })();

            const styles = getComputedStyle(document.documentElement);

            const colorB1 = styles.getPropertyValue('--color-b1').trim();

            document.addEventListener('DOMContentLoaded', function() {
                const form = document.querySelector('.highlight-submit-form');

                if (!form) return;

                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Apakah kamu yakin?',
                        text: 'Pastikan data sorotan sudah benar sebelum disimpan.',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: colorB1,
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, simpan!',
                        cancelButtonText: 'Periksa kembali'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
