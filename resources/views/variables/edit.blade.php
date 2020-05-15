<div class="bg-white rounded-lg overflow-hidden shadow-xl mx-auto">
    <form wire:submit.prevent="update" spellcheck="false">
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="flex items-center justify-between flex-wrap sm:flex-no-wrap">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Edit
                        <span class="font-mono">{{ $variable->key }}</span>
                    </h3>
                </div>

                <x-flash-message event="variable.updated" message="Saved!" />
            </div>

            <x-inputs.text label="Key" name="key" :key="$variable->id" context="edit" font="font-mono"
                           maxWidth="max-w-lg" class="mt-6"
            />

            <x-inputs.base label="Value" name="value" :key="$variable->id" context="edit" maxWidth="max-w-lg"
                           class="mt-6 sm:border-t sm:border-gray-200 sm:pt-5"
            >
                <div class="flex @if ($openRollBack) rounded-t-md @else rounded-md @endif shadow-sm">
                    <div class="relative flex-grow focus-within:z-10">
                        <input wire:model.lazy="value" id="valueEdit{{ $variable->id }}"
                               class="form-input font-mono block w-full rounded-none @if ($openRollBack) rounded-tl-md @else rounded-l-md @endif transition ease-in-out duration-150 sm:text-sm sm:leading-5 @error('value') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @enderror"
                        />
                    </div>

                    <button wire:click="toggleOpenRollBack" type="button"
                            wire:loading.attr="disabled" wire:loading.class="opacity-75 cursor-wait"
                            class="-ml-px relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium @if ($openRollBack) rounded-tr-md @else rounded-r-md @endif text-gray-700 bg-gray-50 hover:text-gray-500 hover:bg-white focus:outline-none focus:shadow-outline-indigo focus:border-indigo-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150"
                    >
                        <x-heroicon-s-collection class="h-5 w-5 text-gray-400" />
                    </button>
                </div>

                @if ($openRollBack)
                    <div class="bg-white border-l border-r border-b border-gray-300 rounded-b-md overflow-hidden">
                        @livewire('variables.edit.roll-back', ['variable' => $variable])
                    </div>
                @endif
            </x-inputs.base>
        </div>
        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse sm:justify-between">
            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                <button type="submit" wire:loading.attr="disabled" wire:loading.class="opacity-75 cursor-wait"
                        class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-indigo-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo transition ease-in-out duration-150 sm:text-sm sm:leading-5"
                >
                    Save
                    <x-heroicon-s-check class="ml-1.5 -mr-1 h-5 w-5" />
                </button>
            </span>
            <div class="sm:flex sm:flex-row-reverse">
                @can('delete', $variable)
                    <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:ml-3 sm:w-auto">
                        <button @click="context = 'delete'" type="button"
                                class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-red-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red transition ease-in-out duration-150 sm:text-sm sm:leading-5"
                        >
                            <x-heroicon-s-trash class="h-5 w-5" />
                        </button>
                    </span>
                @endcan
                <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                    <button @click="context = 'show'" type="button"
                            class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline transition ease-in-out duration-150 sm:text-sm sm:leading-5"
                    >
                        <x-heroicon-s-cheveron-left class="-ml-1 mr-1.5 h-5 w-5" />
                        Back
                    </button>
                </span>
            </div>
        </div>
    </form>
</div>
