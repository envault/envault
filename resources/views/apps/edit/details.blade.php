<div class="bg-white shadow overflow-hidden rounded-md">
    <form wire:submit.prevent="update">
        <div class="bg-white px-4 py-5 border-b border-gray-200 sm:px-6">
            <div class="flex items-center justify-between flex-wrap sm:flex-no-wrap">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Details
                    </h3>
                </div>

                <x-flash-message event="app.updated" message="Saved!" />
            </div>
        </div>

        <div class="px-4 py-6 sm:px-6">
            <x-inputs.text label="Name" name="name" maxWidth="max-w-lg" />
        </div>

        <div class="bg-gray-50 px-4 py-4 sm:px-6 flex">
            @can('delete', $app)
                <div class="inline-flex flex-shrink-0" x-data="{ open: false }">
                    <button @click="open = true" type="button"
                            class="justify-center p-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-red-600 hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red active:bg-red-700 transition duration-150 ease-in-out"
                    >
                        <x-heroicon-s-trash class="h-5 w-5" />
                    </button>

                    <div x-show.transition.opacity="open"
                         class="fixed bottom-0 z-10 inset-x-0 px-4 pb-4 sm:inset-0 sm:flex sm:items-center sm:justify-center"
                    >
                        <div class="fixed inset-0">
                            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                        </div>

                        <div @click.away="open = false" @keydown.escape.window="open = false"
                             class="z-10 bg-white rounded-lg overflow-hidden shadow-xl sm:max-w-lg sm:w-full"
                        >
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div
                                        class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10"
                                    >
                                        <x-heroicon-o-exclamation class="h-6 w-6 text-red-600" />
                                    </div>
                                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                                            Delete this app
                                        </h3>
                                        <div class="mt-2">
                                            <p class="text-sm leading-5 text-gray-500">
                                                Are you sure you want to delete {{ $app->name }}? This action is
                                                permanent.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                                    <button wire:click="destroy" @click="open = false" type="button"
                                            wire:loading.class="opacity-75 cursor-wait"
                                            class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-red-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red transition ease-in-out duration-150 sm:text-sm sm:leading-5"
                                    >
                                        Confirm
                                    </button>
                                </span>
                                <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                                    <button @click="open = false" type="button"
                                            wire:loading.class="opacity-75 cursor-wait"
                                            class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-indigo-300 focus:shadow-outline transition ease-in-out duration-150 sm:text-sm sm:leading-5"
                                    >
                                        Cancel
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan
            <div class="flex w-full justify-end">
                <span class="inline-flex">
                    <button type="submit" wire:loading.class="opacity-75 cursor-wait"
                            class="inline-flex shadow-sm justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out"
                    >
                        Save
                        <x-heroicon-s-check class="ml-1.5 -mr-1 h-5 w-5" />
                    </button>
                </span>
            </div>
        </div>
    </form>
</div>
