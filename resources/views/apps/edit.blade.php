@section('title', "{$app->name} | Apps")

<div>
    <header class="py-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h2 class="text-2xl font-bold leading-7 text-white sm:text-3xl sm:leading-9 sm:truncate">
                        Edit {{ $app->name }}
                    </h2>
                </div>
                @can('view', $app)
                    <div class="mt-4 flex md:mt-0 md:ml-4">
                        <span class="shadow-sm rounded-md">
                            <a href="{{ route('apps.show', ['app' => $app->id]) }}"
                               class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:text-gray-800 active:bg-gray-50 transition duration-150 ease-in-out"
                            >
                                <x-heroicon-s-cheveron-left class="-ml-1 mr-1.5 h-5 w-5" />
                                Back
                            </a>
                        </span>
                    </div>
                @endcan
            </div>
        </div>
    </header>

    <div class="max-w-4xl mx-auto pb-12 px-4 sm:px-6">
        @livewire('apps.edit.details', ['app' => $app])

        <div class="mt-6">
            @livewire('apps.edit.collaborators', ['app' => $app])
        </div>

        <div class="mt-6">
            @livewire('apps.edit.notifications', ['app' => $app])
        </div>
    </div>
</div>
