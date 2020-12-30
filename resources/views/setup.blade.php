<div>
    <form wire:submit.prevent="setup" spellcheck="false" class="space-y-6">
        <div class="space-y-1">
            <div class="text-gray-100">
                You're nearly ready to use Envault!
            </div>

            <div class="text-gray-400 text-sm">
                Get started by providing details for the owner's account. Owners have no restrictions and can manage anything on your server.
            </div>
        </div>

        <div>
            <div class="rounded-md">
                <input wire:model.defer="firstName" type="text" placeholder="Your first name"
                       required autofocus
                       class="appearance-none bg-gray-700 block w-full px-3 py-2 border border-gray-600 rounded-md text-gray-200 placeholder-gray-400 focus:outline-none focus:shadow-outline-indigo focus:border-indigo-500 transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('firstName') border-red-500 placeholder-red-400 focus:border-red-500 focus:shadow-outline-red @enderror"
                />
            </div>
            @error('firstName')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <div class="rounded-md">
                <input wire:model.defer="lastName" type="text" placeholder="Your last name"
                       required
                       class="appearance-none bg-gray-700 block w-full px-3 py-2 border border-gray-600 rounded-md text-gray-200 placeholder-gray-400 focus:outline-none focus:shadow-outline-indigo focus:border-indigo-500 transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('lastName') border-red-500 placeholder-red-400 focus:border-red-500 focus:shadow-outline-red @enderror"
                />
            </div>
            @error('lastName')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <div class="rounded-md">
                <input wire:model.defer="email" type="email" placeholder="Your email address"
                       required autocomplete="email"
                       class="appearance-none bg-gray-700 block w-full px-3 py-2 border border-gray-600 rounded-md text-gray-200 placeholder-gray-400 focus:outline-none focus:shadow-outline-indigo focus:border-indigo-500 transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('email') border-red-500 placeholder-red-400 focus:border-red-500 focus:shadow-outline-red @enderror"
                />
            </div>
            @error('email')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <span class="block w-full rounded-md shadow-sm">
                <button type="submit" wire:loading.class="opacity-75 cursor-wait"
                        class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out"
                >
                    Complete Setup
                </button>
            </span>
        </div>

        <div>
            <span class="block w-full rounded-md shadow-sm animate-glow">
                <a href="https://github.com/envault/envault" target="_blank"
                        class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-gray-800 bg-yellow-300 hover:bg-yellow-400 focus:outline-none focus:border-yellow-300 focus:shadow-outline-yellow active:bg-yellow-400 transition duration-150 ease-in-out"
                >
                    <x-heroicon-s-star class="-ml-1 mr-2 h-5 w-5" />

                    <span>Star Envault on GitHub</span>
                </a>
            </span>
        </div>
    </form>
</div>
