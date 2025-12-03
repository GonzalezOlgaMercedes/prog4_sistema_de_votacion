@props(['align' => 'right', 'width' => '48'])

@php
$alignmentClasses = match($align) {
    'left' => 'origin-top-left left-0',
    'top' => 'origin-top',
    default => 'origin-top-right right-0',
};

$widthClass = match($width) {
    '48' => 'w-48',
    '56' => 'w-56',
    default => 'w-48',
};
@endphp

<div class="relative" x-data="{ open: false }" @click.outside="open = false" @keydown.escape.window="open = false">
    <div @click="open = !open">
        {{ $trigger }}
    </div>

    <div
        x-show="open"
        x-transition
        class="absolute z-50 mt-2 {{ $widthClass }} rounded-xl shadow-xl {{ $alignmentClasses }}"
        style="display: none;"
    >
        <div class="rounded-xl bg-slate-900 border border-slate-700/60 py-1">
            {{ $content }}
        </div>
    </div>
</div>
