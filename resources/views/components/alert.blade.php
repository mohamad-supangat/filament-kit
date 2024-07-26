@aware(['color'])
@props(['title', 'message', 'icon' => 'heroicon-s-information-circle', 'color'])

@php
    $colorClass = '';
    if ($color == 'success') {
        $colorClass = 'bg-green-100  text-green-800';
        $icon = 'heroicon-o-check-circle';
    } elseif ($color == 'danger') {
        $colorClass = 'bg-red-100  text-red-800';
    }
@endphp
<div id="alert-custom" {{ $attributes->merge(['class' => 'px-5 py-4 rounded-2xl ' . $colorClass]) }} role="alert">
    <div class="flex justify-between items-top">
        <div class="flex items-center">
            <x-icon :name="$icon" class="mr-2 h-7 w-7" />
            <h3 class="text-sm font-semibold">{{ $title }}</h3>
        </div>
    </div>
    @if ($message ?? (false || $slot ?? false))
        <div class="mt-2 text-xs">
            {{ $message ?? null }}
            {{ $slot }}
        </div>
    @endif
</div>
