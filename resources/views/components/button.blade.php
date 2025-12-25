@props(['variant' => 'primary', 'size' => 'md', 'href' => null])

@php
$baseClasses = 'btn-premium inline-flex items-center justify-center font-semibold transition-all';

$variantClasses = [
    'primary' => 'btn-primary text-white',
    'secondary' => 'bg-gray-200 hover:bg-gray-300 text-gray-900',
    'outline' => 'border-2 border-gray-300 hover:border-primary-500 hover:bg-primary-50 text-gray-700',
    'ghost' => 'hover:bg-gray-100 text-gray-700',
];

$sizeClasses = [
    'sm' => 'px-4 py-2 text-sm',
    'md' => 'px-6 py-3 text-base',
    'lg' => 'px-8 py-4 text-lg',
];

$classes = $baseClasses . ' ' . ($variantClasses[$variant] ?? $variantClasses['primary']) . ' ' . ($sizeClasses[$size] ?? $sizeClasses['md']);
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['class' => $classes, 'type' => 'button']) }}>
        {{ $slot }}
    </button>
@endif
