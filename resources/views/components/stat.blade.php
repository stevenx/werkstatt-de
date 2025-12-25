@props(['number', 'label', 'icon' => null])

<div class="stat-card">
    @if($icon)
        <div class="icon-container bg-primary-100 mb-4">
            {!! $icon !!}
        </div>
    @endif
    <div class="stat-number mb-2">{{ $number }}</div>
    <div class="text-gray-600 text-sm font-medium">{{ $label }}</div>
</div>
