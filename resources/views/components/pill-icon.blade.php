<div
    {{ $attributes->class([
        'shrink-0 inline-flex h-10 w-10
                             items-center justify-center
                             rounded-xl bg-[var(--color-pill)] text-[var(--color-g1)] font-semibold',
    ]) }}>
    {{ $slot }}
</div>
