@section('title', 'Apps')

<div>
    <header class="py-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl leading-9 font-bold text-white">
                Apps
            </h1>
        </div>
    </header>

    <div class="max-w-4xl mx-auto pb-12 px-4 sm:px-6">
        @if (count($apps) || $search)
            <div class="bg-white shadow overflow-hidden rounded-md">
                <div class="bg-white px-4 py-5 border-b border-gray-200 sm:px-6">
                    <div class="flex items-center justify-end flex-wrap sm:flex-no-wrap">
                        <div class="flex-shrink-0">
                            <div class="inline-flex relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <x-heroicon-s-search class="h-5 w-5 text-gray-400" />
                                </div>
                                <input wire:model.debounce.500ms="search"
                                       class="form-input block w-full pl-10 sm:text-sm sm:leading-5"
                                       placeholder="Search..."
                                />
                            </div>
                        </div>
                    </div>
                </div>
                <ul>
                    @forelse ($apps as $app)
                        <li @if (!$loop->first) class="border-t border-gray-200" @endif>
                            <a href="{{ route('apps.show', ['app' => $app->id]) }}"
                               class="block hover:bg-gray-50 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                            >
                                <div class="flex items-center py-4 px-4 sm:px-6">
                                    <div class="min-w-0 flex-1 flex items-center">
                                        <div>
                                            <div
                                                class="text-sm leading-5 font-medium text-indigo-600 truncate"
                                            >{{ $app->name }}</div>
                                            <div class="mt-2 flex items-center text-sm leading-5 text-gray-500">
                                                <x-heroicon-s-collection
                                                    class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"
                                                />
                                                <span
                                                    class="truncate"
                                                >{{ count($app->variables) }} {{ count($app->variables) == 1 ? 'variable' : 'variables' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <x-heroicon-s-chevron-right class="h-5 w-5 text-gray-400" />
                                    </div>
                                </div>
                            </a>
                        </li>
                    @empty
                        <div class="flex items-center py-4 px-4 sm:px-6">
                            <div class="min-w-0 flex-1 sm:flex sm:items-center sm:justify-between">
                                <div>
                                    <div class="leading-5 font-medium text-sm text-gray-800 truncate">
                                        No results match this query.
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </ul>

                {{ $apps->links() }}
            </div>
        @endif

        @can('create', App\Models\App::class)
            <div @if (count($apps) || $search) class="mt-6" @endif>
                @livewire('apps.create')
            </div>
        @endcan

        <div>
            @if (!count($apps) && !$search)
                @cannot('create', App\Models\App::class)
                    <div class="shadow rounded-md bg-yellow-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <x-heroicon-s-information-circle class="h-5 w-5 text-yellow-400" />
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm leading-5 font-medium text-yellow-800">
                                    No apps
                                </h3>
                                <div class="mt-2 text-sm leading-5 text-yellow-700">
                                    <p>
                                        There are currently no apps here. Please ask an administrator to create one for
                                        you.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan
            @endif
        </div>
    </div>
</div>
