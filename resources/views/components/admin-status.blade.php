{{-- Pesan sukses setelah simpan / hapus --}}
@if (session('status'))
    <div role="status"
        class="mb-6 flex items-center gap-2.5 rounded-xl border border-(--border-line) bg-(--bg-card) px-5 py-3 text-[14px] font-medium text-(--text-primary)">
        <span class="text-g1">@include('components.icon', ['name' => 'check', 'class' => 'w-4 h-4'])</span>
        {{ session('status') }}
    </div>
@endif
