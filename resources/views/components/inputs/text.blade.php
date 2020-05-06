@props(['context' => null, 'disabled' => false, 'font' => 'font-sans', 'key' => null, 'label', 'maxWidth' => 'max-w-xs', 'name', 'placeholder' => null, 'type' => 'text', 'value' => null])

<div {{ $attributes }}>
    <x-inputs.base :context="$context" :key="$key" :label="$label" :name="$name">
        <div class="{{ $maxWidth }} rounded-md shadow-sm">
            <input @if (!$disabled) wire:model.lazy="{{ $name }}" @else disabled value="{{ $value }}" @endif id="{{ $name }}{{ ucfirst($context) }}{{ $key }}" placeholder="{{ $placeholder }}" type="{{ $type }}"
                   class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5 {{ $font }} @if ($disabled) bg-gray-50 cursor-not-allowed @endif @error($name) border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @enderror"
            />
        </div>
    </x-inputs.base>
</div>
