<div>
    <header class="py-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl leading-9 font-bold text-white">
                Audit Log
            </h1>
        </div>
    </header>

    <div class="max-w-4xl mx-auto pb-12 sm:px-6">
        <div class="flex flex-col">
            <div class="-my-2 py-2 sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
                <div class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg">
                    <div class="bg-white px-4 py-5 border-b border-gray-200 sm:px-6 sm:flex sm:items-center">
                        <div class="flex relative rounded-md shadow-sm sm:w-1/3">
                            <select wire:model="action"
                                    class="border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-md block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                            >
                                <option value="">Select action...</option>

                                @foreach ($actions as $groupLabel => $subActions)
                                    <optgroup label="{{ $groupLabel }}">
                                        @foreach ($subActions as $actionKey => $actionLabel)
                                            <option value="{{ $actionKey }}">{{ $actionLabel }}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex mt-2 sm:mt-0 sm:mx-2 relative rounded-md shadow-sm sm:w-1/3">
                            <select wire:model="appId" @if (Str::before($this->action, '.') == 'user') disabled
                                    @endif class="@if (Str::before($this->action, '.') == 'user') bg-gray-50 opacity-50 cursor-not-allowed @endif border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-md block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                            >
                                <option value="">Select app...</option>

                                @foreach (App\Models\App::orderBy('name')->get() as $app)
                                    <option value="{{ $app->id }}">{{ $app->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex mt-2 sm:mt-0 relative rounded-md shadow-sm sm:w-1/3">
                            <select wire:model="userId"
                                    class="border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-md block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                            >
                                <option value="">Select user responsible...</option>

                                @foreach (App\Models\User::orderBy('first_name')->get() as $user)
                                    <option value="{{ $user->id }}">{{ $user->full_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <table class="min-w-full">
                        <thead>
                            <tr>
                                <th class="hidden sm:table-cell px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    User
                                </th>

                                <th class="table-cell px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    Action
                                </th>

                                <th class="hidden sm:table-cell px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    Date
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($entries as $entry)
                                <tr class="{{ $loop->odd ? 'bg-white' : 'bg-gray-50' }}">
                                    <td class="hidden sm:block px-6 py-4 whitespace-nowrap text-sm leading-5 font-medium text-gray-900">
                                        {{ $entry->user->full_name ?? null }}
                                    </td>

                                    <td class="px-6 py-4 text-sm leading-5 text-gray-500">
                                        {{ $entry->description }}
                                    </td>

                                    <td class="hidden sm:block px-6 py-4 whitespace-nowrap text-sm leading-5 text-gray-500">
                                        {{ $entry->created_at->toFormattedDateTimeString() }}
                                    </td>
                                </tr>
                            @empty
                                <tr class="bg-white">
                                    <td colspan="3">
                                        <div class="flex items-center py-4 px-4 sm:px-6">
                                            <div class="min-w-0 flex-1 sm:flex sm:items-center sm:justify-between">
                                                <div>
                                                    <div class="leading-5 font-medium text-sm text-gray-800 truncate">
                                                        No results match this query.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{ $entries->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
