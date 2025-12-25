@props(['type' => 'default', 'size' => 'md'])

@php
$sizeClasses = [
    'sm' => 'text-xs px-2.5 py-1',
    'md' => 'text-sm px-3 py-1.5',
    'lg' => 'text-base px-4 py-2',
];

$typeClasses = [
    'workshop' => 'badge-workshop',
    'tuv' => 'badge-tuv',
    'tire_dealer' => 'badge-tire-dealer',
    'default' => 'bg-gray-100 text-gray-700',
];

$classes = 'badge-premium ' . ($typeClasses[$type] ?? $typeClasses['default']) . ' ' . ($sizeClasses[$size] ?? $sizeClasses['md']);
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</span>
