@props(['context' => null, 'disabled' => false, 'key' => null, 'label', 'maxWidth' => 'max-w-xs', 'name', 'options' => [], 'value' => null])

<div {{ $attributes }}>
    <x-inputs.base :context="$context" :key="$key" :label="$label" :name="$name">
        <div class="{{ $maxWidth }} rounded-md shadow-sm">
            <select @if (!$disabled) wire:model="{{ $name }}" @else disabled @endif id="{{ $name }}{{ ucfirst($context) }}{{ $key }}"
                    class="@if ($disabled) bg-gray-50 cursor-not-allowed @endif block border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-md w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
            >
                @foreach ($options as $key => $label)
                    <option @if ($key == $value) selected @endif @if ($key) value="{{ $key }}" @endif>{{ $label }}</option>
                @endforeach
            </select>
        </div>
    </x-inputs.base>
</div>
