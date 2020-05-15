<div class="bg-white shadow overflow-hidden rounded-lg">
    <div class="bg-white px-4 py-5 border-b border-gray-200 sm:px-6">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            New app
        </h3>
    </div>
    <div class="px-4 py-4 sm:px-6">
        <form wire:submit.prevent="store" spellcheck="false" class="sm:flex sm:items-center">
            <div class="w-full">
                <div class="rounded-md shadow-sm">
                    <input wire:model.lazy="name"
                           class="form-input flex-1 block w-full rounded-none rounded-md transition duration-150 ease-in-out text-sm sm:leading-5 @error('name') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @enderror"
                           placeholder="My Awesome App"
                    />
                </div>
            </div>
            <span class="mt-3 flex flex-shrink-0 justify-end rounded-md sm:mt-0 sm:ml-3 sm:w-auto">
                <button type="submit" wire:loading.attr="disabled" wire:loading.class="opacity-75 cursor-wait"
                        class="inline-flex shadow-sm items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition ease-in-out duration-150"
                >
                    Continue &rarr;
                </button>
            </span>
        </form>

        @error('name')
        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>
