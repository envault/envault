@section('title', "{$app->name} | Apps")

<div>
    <header class="py-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h2 class="text-2xl font-bold leading-7 text-white sm:text-3xl sm:leading-9 sm:truncate">
                        {{ $app->name }}
                    </h2>
                </div>
                @can('update', $app)
                    <div class="mt-4 flex md:mt-0 md:ml-4">
                        <span class="shadow-sm rounded-md">
                            <a href="{{ route('apps.edit', ['app' => $app->id]) }}"
                               class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:shadow-outline-indigo focus:border-indigo-700 active:bg-indigo-700 transition duration-150 ease-in-out"
                            >
                                <x-heroicon-s-pencil class="-ml-1 mr-1.5 h-5 w-5" />
                                Manage App
                            </a>
                        </span>
                    </div>
                @endcan
            </div>
        </div>
    </header>

    <div class="max-w-4xl mx-auto pb-12 px-4 sm:px-6">
        @livewire('apps.show.setup-command', ['app' => $app])

        <div class="mt-6">
            @livewire('variables.index', ['app' => $app])
        </div>

        @can('createVariable', $app)
            <div class="mt-6">
                @livewire('variables.create', ['app' => $app])
            </div>
        @endcan
    </div>
</div>
