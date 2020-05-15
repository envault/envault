<div>
    <div x-data="{ importOpen: false }" x-cloak class="bg-white shadow overflow-hidden rounded-md">
        <div class="bg-white px-4 py-5 sm:p-6 border-b border-gray-200">
            <div class="flex items-center justify-between flex-wrap sm:flex-no-wrap">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        New variable
                    </h3>
                </div>

                <div>
                    <x-flash-message event="variable.created" message="Added!" />

                    <div x-data="{ createdCount: 0, visible: false }"
                         x-init="window.livewire.on('variables.imported', (count) => {
                                createdCount = count;
                                visible = true;
                                setTimeout(() => { visible = false }, 5000);
                            })"
                         x-show.transition.out="visible"
                         x-cloak
                         role="alert"
                    >
                        <div class="flex-shrink-0">
                            <span class="inline-flex">
                                <span
                                    class="relative inline-flex items-center text-xs leading-5 font-medium text-green-600"
                                >
                                    <span x-text="'Imported ' + createdCount + ' variables!'"></span>

                                    <x-heroicon-s-check-circle class="ml-1 -mr-0.5 h-4 w-4" />
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <form wire:submit.prevent="store" spellcheck="false">
            <div class="px-4 py-6 sm:px-6">
                <x-inputs.text label="Key" name="key" placeholder="MAIL_USERNAME" font="font-mono"
                               maxWidth="max-w-lg"
                />

                <x-inputs.text label="Value" name="value" placeholder="3c683983b21e1f" font="font-mono"
                               maxWidth="max-w-lg" class="mt-6 sm:border-t sm:border-gray-200 sm:pt-5"
                />
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse sm:justify-between">
                <span class="flex w-full rounded-md shadow-sm sm:w-auto">
                    <button type="submit" wire:loading.attr="disabled" wire:loading.class="opacity-75 cursor-wait"
                            class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-indigo-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo transition ease-in-out duration-150 sm:text-sm sm:leading-5"
                    >
                        Create

                        <x-heroicon-s-check class="ml-1.5 -mr-1 h-5 w-5" />
                    </button>
                </span>
                <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                    <button @click="importOpen = true" type="button"
                            class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline transition ease-in-out duration-150 sm:text-sm sm:leading-5"
                    >
                        Import
                    </button>

                    <div x-show.transition.opacity="importOpen"
                         class="fixed bottom-0 z-10 inset-x-0 px-4 pb-4 sm:inset-0 sm:flex sm:items-center sm:justify-center"
                    >
                        <div class="fixed inset-0">
                            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                        </div>

                        <div @click.away="importOpen = false" @keydown.escape.window="importOpen = false"
                             class="z-10 bg-white rounded-lg overflow-hidden shadow-xl sm:max-w-4xl sm:w-full"
                        >
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="mt-3 text-center sm:mt-0 sm:text-left">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                                        Import Variables
                                    </h3>
                                    <div class="mt-3 rounded-md shadow-sm">
                                        <textarea wire:model.lazy="variables" rows="20"
                                                  placeholder="API_KEY=iRRMCOsMpNwpSWBi"
                                                  class="form-textarea block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5 font-mono"
                                        ></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                                    <button wire:click="import" @click="importOpen = false" type="button"
                                            wire:loading.attr="disabled" wire:loading.class="opacity-75 cursor-wait"
                                            class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-indigo-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo transition ease-in-out duration-150 sm:text-sm sm:leading-5"
                                    >
                                        Import
                                    </button>
                                </span>
                                <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                                    <button @click="importOpen = false" type="button"
                                            wire:loading.attr="disabled" wire:loading.class="opacity-75 cursor-wait"
                                            class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-indigo-300 focus:shadow-outline transition ease-in-out duration-150 sm:text-sm sm:leading-5"
                                    >
                                        Cancel
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </span>
            </div>
        </form>
    </div>
</div>
