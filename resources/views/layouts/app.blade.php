<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }}</title>
    <meta name="description" content="">

    <link href="{{ asset('images/favicon.png') }}" rel="icon" type="image/png">

    <link href="{{ asset(mix('css/app.css')) }}" rel="stylesheet">
    @livewireStyles

    <script src="{{ asset(mix('js/app.js')) }}" defer></script>
    @livewireScripts
</head>

<body class="flex flex-col min-h-screen bg-gray-100 select-none">
<div class="pb-56 bg-gray-800">
    <nav x-data="{ open: false }" x-cloak @keydown.window.escape="open = false" class="bg-gray-800">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="border-b border-gray-700">
                <div class="flex items-center justify-between h-16 px-4 sm:px-0">
                    <div class="flex items-center">
                        <div class="flex items-center flex-shrink-0">
                            <a href="/">
                                <img class="w-8 h-8" src="{{ asset('images/icon-white.svg') }}" alt="Envault logo" />
                            </a>
                        </div>
                        @can('administrate')
                            <div class="hidden ml-10 md:block">
                                <div class="flex items-baseline">
                                    <a href="{{ route('apps.index') }}"
                                       class="px-3 py-2 rounded-md text-sm font-medium @if (request()->is('apps*')) text-white bg-gray-900 @else text-gray-300 hover:text-white hover:bg-gray-700 @endif focus:outline-none focus:text-white focus:bg-gray-700"
                                    >Apps
                                    </a>
                                    <a href="{{ route('log') }}"
                                       class="ml-4 px-3 py-2 rounded-md text-sm font-medium @if (request()->route()->named('log')) text-white bg-gray-900 @else text-gray-300 hover:text-white hover:bg-gray-700 @endif focus:outline-none focus:text-white focus:bg-gray-700"
                                    >Audit
                                        Log
                                    </a>
                                    <a href="{{ route('users.index') }}"
                                       class="ml-4 px-3 py-2 rounded-md text-sm font-medium @if (request()->route()->named('users.index')) text-white bg-gray-900 @else text-gray-300 hover:text-white hover:bg-gray-700 @endif focus:outline-none focus:text-white focus:bg-gray-700"
                                    >Users
                                    </a>
                                </div>
                            </div>
                        @endcan
                    </div>
                    <div class="hidden md:block">
                        <div class="flex items-center ml-4 md:ml-6">
                            <div @click.away="open = false" class="relative" x-data="{ open: false }" x-cloak>
                                <div>
                                    <button @click="open = !open" type="button"
                                            class="flex items-center max-w-xs text-sm text-white rounded-full focus:outline-none focus:shadow-solid"
                                            id="user-menu" aria-label="User menu" aria-haspopup="true"
                                            x-bind:aria-expanded="open"
                                    >
                                        <x-heroicon-s-user-circle class="w-8 h-8" />
                                    </button>
                                </div>
                                <div x-show="open" x-transition:enter="transition ease-out duration-100"
                                     x-transition:enter-start="transform opacity-0 scale-95"
                                     x-transition:enter-end="transform opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-75"
                                     x-transition:leave-start="transform opacity-100 scale-100"
                                     x-transition:leave-end="transform opacity-0 scale-95"
                                     class="absolute right-0 w-48 mt-2 origin-top-right rounded-md shadow-lg"
                                >
                                    <div class="py-1 bg-white rounded-md shadow-xs">
                                        <a href="{{ route('account') }}"
                                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                        >My
                                            Account
                                        </a>
                                        <a href="{{ route('auth.logout') }}"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                        >Sign out
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center -mr-2 md:hidden">
                        <button @click="open = !open" type="button"
                                class="inline-flex items-center justify-center p-2 text-gray-400 rounded-md hover:text-white hover:bg-gray-700 focus:outline-none focus:bg-gray-700 focus:text-white"
                                x-bind:aria-label="open ? 'Close main menu' : 'Main menu'" x-bind:aria-expanded="open"
                        >
                            <span x-show="!open">
                                <x-heroicon-s-menu class="w-6 h-6" />
                            </span>

                            <span x-show="open">
                                <x-heroicon-s-x class="w-6 h-6" />
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div :class="{'block': open, 'hidden': !open}" class="hidden border-b border-gray-700 md:hidden">
            @can('administrate')
                <div class="px-2 py-3 sm:px-3">
                    <a href="{{ route('apps.index') }}"
                       class="block px-3 py-2 rounded-md text-base font-medium @if (request()->is('apps*')) text-white bg-gray-900 @else text-gray-300 hover:text-white hover:bg-gray-700 @endif focus:outline-none focus:text-white focus:bg-gray-700"
                    >Apps
                    </a>
                    <a href="{{ route('log') }}"
                       class="mt-1 block px-3 py-2 rounded-md text-base font-medium @if (request()->route()->named('log')) text-white bg-gray-900 @else text-gray-300 hover:text-white hover:bg-gray-700 @endif focus:outline-none focus:text-white focus:bg-gray-700"
                    >Audit
                        Log
                    </a>
                    <a href="{{ route('users.index') }}"
                       class="mt-1 block px-3 py-2 rounded-md text-base font-medium @if (request()->route()->named('users.index')) text-white bg-gray-900 @else text-gray-300 hover:text-white hover:bg-gray-700 @endif focus:outline-none focus:text-white focus:bg-gray-700"
                    >Users
                    </a>
                </div>
            @endcan
            <div class="pt-4 pb-3 border-t border-gray-700">
                <div class="px-5">
                    <div>
                        <div class="text-base font-medium leading-none text-white">{{ auth()->user()->full_name }}</div>
                        <div class="mt-1 text-sm font-medium leading-none text-gray-400">{{ auth()->user()->email }}</div>
                    </div>
                </div>
                <div class="px-2 mt-3" role="menu" aria-orientation="vertical" aria-labelledby="user-menu">
                    <a href="{{ route('account') }}"
                       class="block px-3 py-2 rounded-md text-base font-medium @if (request()->route()->named('account')) text-white bg-gray-900 @else text-gray-300 hover:text-white hover:bg-gray-700 @endif focus:outline-none focus:text-white focus:bg-gray-700"
                       role="menuitem"
                    >My Account
                    </a>
                    <a href="{{ route('auth.logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                       class="block px-3 py-2 mt-1 text-base font-medium text-gray-400 rounded-md hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700"
                       role="menuitem"
                    >Sign out
                    </a>
                </div>
            </div>
        </div>
        <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </nav>
</div>

<main class="flex-grow -mt-56">
    @if (parse_url(strtolower(config('app.url')))['scheme'] != 'https')
        @include('components.alert', ['title' => 'Warning!', 'message' => 'Your application URL protocol is not secured.', 'type' => 'yellow'])
    @endif
    {{ $slot }}
</main>

<footer>
    <div class="max-w-4xl px-4 py-6 mx-auto sm:px-6 lg:px-8">
        <p class="text-sm text-gray-800">
            &copy; {{ config('app.name') }} {{ now()->year }}
        </p>
    </div>
</footer>
</body>

</html>
