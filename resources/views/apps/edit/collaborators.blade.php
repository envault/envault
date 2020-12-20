<div class="bg-white shadow overflow-hidden rounded-md">
    <div class="bg-white px-4 py-5 border-b border-gray-200 sm:px-6">
        <div class="flex items-center justify-between flex-wrap sm:flex-no-wrap">
            <div>
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Collaborators
                </h3>
            </div>

            <div>
                <x-flash-message event="app.collaborator.added" message="Added!" />

                <x-flash-message event="app.collaborator.removed" message="Removed!" />

                <x-flash-message event="app.collaborator.updated" message="Saved!" />
            </div>
        </div>
    </div>
    <ul>
        @foreach ($globalAdmins as $admin)
            <li @if (!$loop->last) class="border-b border-gray-200" @endif>
                <div>
                    <div class="px-4 py-4 flex items-center sm:px-6">
                        <div class="min-w-0 flex-1 sm:flex sm:items-center sm:justify-between">
                            <div>
                                <div class="leading-5 font-medium text-gray-800 truncate">
                                    {{ $admin->first_name }} {{ $admin->last_name }}
                                </div>

                                <div class="mt-2 text-gray-500 text-sm flex items-center leading-5">
                                    <x-heroicon-s-user-group class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" />

                                    {{ $admin->isOwner() ? 'Owner' : 'Admin' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        @endforeach

        @foreach ($app->collaborators as $collaborator)
            <li class="border-t border-gray-200">
                <div>
                    <div class="px-4 py-4 flex items-center sm:px-6">
                        <div class="min-w-0 flex-1 sm:flex sm:items-center sm:justify-between">
                            <div>
                                <div class="leading-5 font-medium text-gray-800 truncate">
                                    {{ $collaborator->first_name }} {{ $collaborator->last_name }}
                                </div>

                                <div x-data="{ open: false }" x-cloak class="mt-2 text-gray-500 text-sm">
                                    @if ($collaborator->isAppAdmin($app))
                                        <div @click="open = true"
                                             class="flex items-center leading-5 @if ($collaborator->id != auth()->user()->id) cursor-pointer @endif"
                                        >
                                            <x-heroicon-s-user-group
                                                class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"
                                            />

                                            Administrator
                                        </div>

                                        <div>
                                            @if ($collaborator->id != auth()->user()->id)
                                                <div x-show.transition.opacity="open"
                                                     class="fixed bottom-0 inset-x-0 px-4 pb-4 sm:inset-0 sm:flex sm:items-center sm:justify-center"
                                                >
                                                    <div class="fixed inset-0">
                                                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                                                    </div>

                                                    <div @click.away="open = false"
                                                         @keydown.escape.window="open = false"
                                                         class="relative z-10 bg-white rounded-lg overflow-hidden shadow-xl sm:max-w-lg sm:w-full"
                                                    >
                                                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                            <div class="sm:flex sm:items-start">
                                                                <div
                                                                    class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10"
                                                                >
                                                                    <x-heroicon-o-exclamation
                                                                        class="h-6 w-6 text-red-600"
                                                                    />
                                                                </div>
                                                                <div
                                                                    class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left"
                                                                >
                                                                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                                                                        Revoke admin privileges
                                                                    </h3>
                                                                    <div class="mt-2">
                                                                        <p class="text-sm leading-5 text-gray-500">
                                                                            Are you sure you want to revoke the admin
                                                                            privileges
                                                                            for {{ $collaborator->first_name }} {{ $collaborator->last_name.'?' }}
                                                                            They will no longer be able to edit this
                                                                            app's variables.
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse"
                                                        >
                                                            <span
                                                                class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto"
                                                            >
                                                                <button
                                                                    wire:click="updateRole({{ $collaborator->id }}, null)"
                                                                    @click="open = false" type="button"

                                                                    wire:loading.class="opacity-75 cursor-wait"
                                                                    class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-red-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red transition ease-in-out duration-150 sm:text-sm sm:leading-5"
                                                                >
                                                                    Confirm
                                                                </button>
                                                            </span>
                                                            <span
                                                                class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto"
                                                            >
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
                                            @endif
                                        </div>
                                    @else
                                        <div @click="open = true"
                                             class="flex items-center leading-5 @if ($collaborator->id != auth()->user()->id) cursor-pointer @endif"
                                        >
                                            <x-heroicon-s-user class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" />

                                            Collaborator
                                        </div>

                                        <div>
                                            @if ($collaborator->id != auth()->user()->id)
                                                <div x-show.transition.opacity="open"
                                                     class="fixed bottom-0 inset-x-0 px-4 pb-4 sm:inset-0 sm:flex sm:items-center sm:justify-center"
                                                >
                                                    <div class="fixed inset-0">
                                                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                                                    </div>

                                                    <div @click.away="open = false"
                                                         @keydown.escape.window="open = false"
                                                         class="relative z-10 bg-white rounded-lg overflow-hidden shadow-xl sm:max-w-lg sm:w-full"
                                                    >
                                                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                            <div class="sm:flex sm:items-start">
                                                                <div
                                                                    class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10"
                                                                >
                                                                    <x-heroicon-o-exclamation
                                                                        class="h-6 w-6 text-red-600"
                                                                    />
                                                                </div>
                                                                <div
                                                                    class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left"
                                                                >
                                                                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                                                                        Grant admin privileges
                                                                    </h3>
                                                                    <div class="mt-2">
                                                                        <p class="text-sm leading-5 text-gray-500">
                                                                            Are you sure you want to
                                                                            grant {{ $collaborator->first_name }} {{ $collaborator->last_name }}
                                                                            admin privileges? They will be able to edit
                                                                            this app's variables.
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse"
                                                        >
                                                            <span
                                                                class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto"
                                                            >
                                                                <button
                                                                    wire:click="updateRole({{ $collaborator->id }}, 'admin')"
                                                                    @click="open = false" type="button"

                                                                    wire:loading.class="opacity-75 cursor-wait"
                                                                    class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-red-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red transition ease-in-out duration-150 sm:text-sm sm:leading-5"
                                                                >
                                                                    Confirm
                                                                </button>
                                                            </span>
                                                            <span
                                                                class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto"
                                                            >
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
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div>
                                @if ($collaborator->id != auth()->user()->id)
                                    <div class="inline-flex flex-shrink-0" x-data="{ open: false }" x-cloak>
                                        <button @click="open = true" type="button"
                                                class="justify-center p-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-red-600 hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red active:bg-red-700 transition duration-150 ease-in-out"
                                        >
                                            <x-heroicon-s-trash class="h-5 w-5" />
                                        </button>
                                        <div x-show.transition.opacity="open"
                                             class="fixed bottom-0 inset-x-0 px-4 pb-4 sm:inset-0 sm:flex sm:items-center sm:justify-center"
                                        >
                                            <div class="fixed inset-0">
                                                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                                            </div>

                                            <div @click.away="open = false" @keydown.escape.window="open = false"
                                                 class="relative z-10 bg-white rounded-lg overflow-hidden shadow-xl sm:max-w-lg sm:w-full"
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
                                                                Remove this collaborator
                                                            </h3>
                                                            <div class="mt-2">
                                                                <p class="text-sm leading-5 text-gray-500">
                                                                    Are you sure you want to
                                                                    remove {{ $collaborator->first_name }}
                                                                    {{ $collaborator->last_name }} from project
                                                                    collaborator? They may no longer be able to view
                                                                    this project.
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                                    <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                                                        <button wire:click="remove({{ $collaborator->id }})"
                                                                @click="open = false"
                                                                type="button"

                                                                wire:loading.class="opacity-75 cursor-wait"
                                                                class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-red-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red transition ease-in-out duration-150 sm:text-sm sm:leading-5"
                                                        >
                                                            Confirm
                                                        </button>
                                                    </span>
                                                    <span
                                                        class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto"
                                                    >
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
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
    @if (count($addableUsers))
        <div class="px-4 py-4 sm:px-6 bg-gray-50 border-t border-gray-200">
            <div class="sm:flex sm:items-center">
                <div class="w-full">
                    <div class="flex rounded-md shadow-sm">
                        <select wire:model="userToAddId"
                                class="block form-select w-full py-2 px-3 py-0 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:shadow-outline-indigo focus:border-indigo-300 transition duration-150 ease-in-out text-sm sm:leading-5"
                        >
                            @foreach ($addableUsers as $collaborator)
                                <option
                                    value="{{ $collaborator->id }}"
                                >{{ $collaborator->first_name }} {{ $collaborator->last_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <span class="mt-3 flex justify-end rounded-md sm:mt-0 sm:ml-3 sm:w-auto">
                    <button wire:click="add" type="button"
                            wire:loading.class="opacity-75 cursor-wait"
                            class="inline-flex shadow-sm items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition ease-in-out duration-150"
                    >
                        Add
                        <x-heroicon-s-user-add class="ml-1.5 -mr-1 h-4 w-4" />
                    </button>
                </span>
            </div>
        </div>
    @endif
</div>
