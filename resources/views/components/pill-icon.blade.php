<div
    {{ $attributes->class([
        'inline-flex h-[46px] w-[46px]
                         items-center justify-center
                         rounded-[12px] bg-[var(--color-pill)] text-[var(--color-g1)] font-semibold',
    ]) }}>
    {{ $slot }}
</div>
