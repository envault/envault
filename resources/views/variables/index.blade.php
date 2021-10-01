<div>
    <div class="bg-white shadow overflow-hidden rounded-md">
        <ul wire:sortable="updateVariableOrder">
            <div class="bg-white px-4 py-5 sm:p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex-1 min-w-0">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Variables
                        </h3>
                    </div>
                    @if (count($variables))
                        <div>
                            <button wire:click="export" wire:loading.class="opacity-75 cursor-wait" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline transition duration-150 ease-in-out shadow-sm sm:text-sm sm:leading-5">
                                Export
                            </button>
                        </div>
                    @endif
                </div>
            </div>
            @forelse ($variables as $variable)
                <li x-data="{ context: null }" x-cloak wire:key="variable.{{ $variable->id }}"
                    wire:sortable.item="{{ $variable->id }}"
                    wire:sortable.handle
                    class="@if (!$loop->last) border-b border-gray-200 @endif"
                >
                    <div @click="context = 'show';"
                         class="hover:bg-gray-50 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out cursor-pointer"
                    >
                        <div class="px-4 py-4 sm:px-6">
                            <div class="flex items-center" style="min-width: 40%; display: inline-block">
                                <div class="text-sm leading-5 text-indigo-600 font-medium truncate font-mono">
                                    {{ $variable->key }}
                                </div>
                            </div>

                            <div class="flex items-center" style="display: inline-block">
                                <div class="text-sm leading-5 text-indigo-600 font-medium truncate font-mono">
                                    {{ $variable->label }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div x-show.transition.opacity="context"
                         class="fixed z-10 bottom-0 inset-x-0 px-4 pb-4 sm:inset-0 sm:flex sm:items-center sm:justify-center"
                    >
                        <div class="fixed inset-0">
                            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                        </div>

                        <div @click.away="context = null" @keydown.escape.window="context = null"
                             class="relative z-10 sm:max-w-xl w-full"
                        >
                            <div x-show="context == 'delete'" class="w-full sm:max-w-lg">
                                @can('delete', $variable)
                                    @livewire('variables.delete', ['variable' => $variable],
                                    key('variable.'.$variable->id.'.delete'))
                                @endcan
                            </div>
                            <div x-show="context == 'edit'" class="w-full">
                                @can('update', $variable)
                                    @livewire('variables.edit', ['variable' => $variable],
                                    key('variable.'.$variable->id.'.edit'))
                                @endcan
                            </div>
                            <div x-show="context == 'show'" class="w-full">
                                @can('view', $variable)
                                    @include('variables.show', ['variable' => $variable])
                                @endcan
                            </div>
                        </div>
                    </div>
                </li>
            @empty
                <li class="px-4 py-4 flex items-center sm:px-6">
                    <div class="min-w-0 flex-1 sm:flex sm:items-center sm:justify-between">
                        <div>
                            <div class="leading-5 font-medium text-sm text-gray-800 truncate">
                                No variables here yet!
                            </div>
                        </div>
                    </div>
                </li>
            @endforelse
        </ul>
    </div>
</div>
