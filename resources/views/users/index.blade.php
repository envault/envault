@section('title', 'Users')

<div>
    <header class="py-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl leading-9 font-bold text-white">
                Users
            </h1>
        </div>
    </header>

    <div class="max-w-4xl mx-auto pb-12 px-4 sm:px-6">
        @can('create', App\User::class)
            @livewire('users.create')
        @endcan
        @can('viewAny', App\User::class)
            <div class="@can('create', App\User::class) mt-6 @endcan bg-white shadow overflow-hidden rounded-md">
                <ul>
                    @forelse ($users as $user)
                        <li x-data="{ context: null }" x-cloak wire:key="user.{{ $user->id }}"
                            class="@if (!$loop->last) border-b border-gray-200 @endif"
                        >
                            <div @click="context = 'show';"
                                 class="hover:bg-gray-50 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out cursor-pointer"
                            >
                                <div class="px-4 py-4 sm:px-6">
                                    <div class="flex items-center justify-between">
                                        <div class="text-sm leading-5 text-indigo-600 font-medium truncate">
                                            {{ $user->full_name }}
                                        </div>
                                        <div>
                                            @if ($user->isAdminOrOwner())
                                                <div class="ml-2 flex-shrink-0 flex">
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800"
                                                    >
                                                        {{ $user->isOwner() ? 'Owner' : 'Admin' }}
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <div>
                                            <div class=" mr-6 flex items-center text-sm leading-5 text-gray-500">
                                                <x-heroicon-s-mail class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" />

                                                {{ $user->email }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div x-show.transition.opacity="context"
                                 class="fixed bottom-0 inset-x-0 px-4 pb-4 sm:inset-0 sm:flex sm:items-center sm:justify-center"
                            >
                                <div class="fixed inset-0">
                                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                                </div>

                                <div @click.away="context = null" @keydown.escape.window="context = null"
                                     class="relative z-10 sm:max-w-xl w-full"
                                >
                                    <div x-show="context == 'delete'" class="w-full sm:max-w-lg">
                                        @can('delete', $user)
                                            @livewire('users.delete', ['user' => $user],
                                            key('user.'.$user->id.'.delete'))
                                        @endcan
                                    </div>
                                    <div x-show="context == 'edit'" class="w-full">
                                        @can('update', $user)
                                            @livewire('users.edit', ['user' => $user], key('user.'.$user->id.'.edit'))
                                        @endcan
                                    </div>
                                    <div x-show="context == 'show'" class="w-full">
                                        @can('view', $user)
                                            @include('users.show', ['user' => $user])
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
                                        No users here yet!
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforelse
                </ul>
            </div>
        @endcan
    </div>
</div>
