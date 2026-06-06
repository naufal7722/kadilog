@props([
    'label' => '',
    'name' => '',
    'type' => 'text',
    'value' => '',
    'placeholder' => '',
    'required' => false,
    'options' => [],
    'rows' => 3,
])

<div class="space-y-1.5">
    <label for="{{ $name }}" class="block text-sm font-medium text-secondary-700">
        {{ $label }}
        @if ($required)
            <span class="text-danger-500">*</span>
        @endif
    </label>

    @if ($type === 'select')
        <select name="{{ $name }}" id="{{ $name }}"
                class="w-full px-3.5 py-2.5 bg-white border border-secondary-300 rounded-xl text-sm text-secondary-700 focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-colors outline-none"
                {{ $required ? 'required' : '' }}>
            <option value="">{{ $placeholder ?: 'Pilih...' }}</option>
            @foreach ($options as $optValue => $optLabel)
                <option value="{{ $optValue }}" {{ $value == $optValue ? 'selected' : '' }}>{{ $optLabel }}</option>
            @endforeach
        </select>
    @elseif ($type === 'textarea')
        <textarea name="{{ $name }}" id="{{ $name }}" rows="{{ $rows }}"
                  class="w-full px-3.5 py-2.5 bg-white border border-secondary-300 rounded-xl text-sm text-secondary-700 focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-colors outline-none resize-none"
                  placeholder="{{ $placeholder }}"
                  {{ $required ? 'required' : '' }}>{{ $value }}</textarea>
    @else
        <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}"
               value="{{ $value }}"
               class="w-full px-3.5 py-2.5 bg-white border border-secondary-300 rounded-xl text-sm text-secondary-700 focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-colors outline-none"
               placeholder="{{ $placeholder }}"
               {{ $required ? 'required' : '' }}>
    @endif
</div>
