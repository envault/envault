<div>
    <ul class="max-h-44 overflow-y-auto text-sm">
        @foreach ($variable->versions()->orderBy('created_at', 'desc')->get()->whereNotNull('value') as $version)
            <div
                wire:click="selectVersion({{ $version->id }}, '{{ $version->value }}', '{{ $version->created_at->toFormattedDateTimeString() }}')"
                wire:loading.class="opacity-75 cursor-wait"
                class="cursor-pointer @if (!$loop->last || $selectedVersionId == $version->id) border-b @endif border-gray-200 px-3 py-2 hover:bg-gray-50 @if ($selectedVersionId == $version->id) bg-gray-100 @endif"
            >
                {{ $version->created_at->toFormattedDateTimeString() }}
            </div>
        @endforeach
    </ul>
    <div>
        @if ($selectedVersionValue)
            <div>
                <div class="w-full rounded-b-md">
                    <div class="mt-4 border-t">
                        <input wire:model.defer="selectedVersionValue" type="text" readonly
                               class="font-mono rounded-none flex-1 block border-0 bg-gray-50 block w-full transition ease-in-out duration-150 text-sm sm:leading-5"
                        />
                    </div>
                    <button wire:click="$emit('variableRolledBack', '{{ $selectedVersionValue }}')" type="button"
                            wire:loading.class="opacity-75 cursor-wait"
                            class="inline-flex cursor-pointer items-center justify-end w-full px-3 py-3 text-sm leading-4 font-medium text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition ease-in-out duration-150"
                    >
                        <div>Roll back to {{ $selectedVersionCreatedAt }}</div>
                        <x-heroicon-s-cloud-download class="ml-1 h-4 w-4" />
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>
