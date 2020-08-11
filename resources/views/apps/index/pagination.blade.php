<div>
    @if ($paginator->hasPages())
        <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
            <div class="hidden sm:block">
                <p class="text-sm leading-5 text-gray-700">
                    <span>Showing</span>
                    <span class="font-medium">{{ $paginator->toArray()['from'] }}</span>
                    <span>to</span>
                    <span class="font-medium">{{ $paginator->toArray()['to'] }}</span>
                    <span>of</span>
                    <span class="font-medium">{{ $paginator->toArray()['total'] }}</span>
                    <span>results</span>
                </p>
            </div>
            <div class="flex-1 flex justify-between sm:justify-end">
                <div>
                    @if (!$paginator->onFirstPage())
                        <button wire:click="previousPage" type="button" wire:loading.class="opacity-75 cursor-wait"
                                class="relative cursor-pointer inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:shadow-outline-indigo focus:border-indigo-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150"
                        >
                            Previous
                        </button>
                    @endif
                </div>
                <div>
                    @if ($paginator->hasMorePages())
                        <button wire:click="nextPage" type="button" wire:loading.class="opacity-75 cursor-wait"
                                class="@if (!$paginator->onFirstPage()) ml-3 @endif relative cursor-pointer inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:shadow-outline-indigo focus:border-indigo-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150"
                        >
                            Next
                        </button>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
