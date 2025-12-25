@props(['hover' => true, 'padding' => true])

@php
$classes = 'card-premium';
if ($hover) {
    $classes .= ' card-hover';
}
if ($padding) {
    $classes .= ' p-6';
}
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>
