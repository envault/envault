@props(['context' => null, 'key' => null, 'label', 'name'])

<div {{ $attributes }}>
    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
        <label for="{{ $name }}{{ ucfirst($context) }}{{ $key }}" class="block text-sm font-medium leading-5 text-gray-700 sm:mt-px sm:pt-2">
            {{ $label }}
        </label>

        <div class="mt-1 sm:mt-0 sm:col-span-2">
            {{ $slot }}

            @error($name)
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>
