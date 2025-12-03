@props(['status'])

@if ($status)
    <div {{ $attributes->merge([
        'class' =>
            'rounded-xl border border-emerald-500/40 bg-emerald-500/10 
            text-emerald-300 text-xs px-4 py-2
            flex items-center justify-center'
    ]) }}>
        {{ $status }}
    </div>
@endif
