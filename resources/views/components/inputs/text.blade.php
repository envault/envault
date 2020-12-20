@props(['context' => null, 'disabled' => false, 'font' => 'font-sans', 'key' => null, 'label', 'maxWidth' => 'max-w-xs', 'name', 'placeholder' => null, 'type' => 'text', 'value' => null])

<div {{ $attributes }}>
    <x-inputs.base :context="$context" :key="$key" :label="$label" :name="$name">
        <input @if (!$disabled) wire:model.defer="{{ $name }}" @else disabled value="{{ $value }}" @endif id="{{ $name }}{{ ucfirst($context) }}{{ $key }}" placeholder="{{ $placeholder }}" type="{{ $type }}"
               class="{{ $maxWidth }} shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md {{ $font }} @if ($disabled) bg-gray-50 cursor-not-allowed @endif @error($name) border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
        />
    </x-inputs.base>
</div>
