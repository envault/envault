<div>
    @if (!$token)
        <form wire:submit.prevent="request" spellcheck="false">
            <div>
                <div class="rounded-md">
                    <input wire:model.lazy="email" value="{{ $email }}" type="email" placeholder="Your email address"
                           required autocomplete="email" autofocus
                           class="appearance-none bg-gray-700 block w-full px-3 py-2 border border-gray-600 rounded-md text-gray-200 placeholder-gray-400 focus:outline-none focus:shadow-outline-indigo focus:border-indigo-500 transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('email') border-red-500 placeholder-red-400 focus:border-red-500 focus:shadow-outline-red @enderror"
                    />
                </div>
                @error('email')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-6">
                <span class="block w-full rounded-md shadow-sm">
                    <button type="submit" wire:loading.attr="disabled" wire:loading.class="opacity-75 cursor-wait"
                            class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out"
                    >
                        Continue
                    </button>
                </span>
            </div>
        </form>
    @else
        <form wire:submit.prevent="confirm" spellcheck="false">
            <div x-data="{ visible: false }"
                 x-init="window.livewire.on('auth.request.resent', () => {
                    visible = true;
                    setTimeout(() => { visible = false }, 5000);
                })"
                 x-show.transition.out="visible"
                 x-cloak
                 role="alert"
            >
                <div class="mb-6 rounded-md bg-green-500 p-4 flex">
                    <div class="flex-shrink-0">
                        <x-heroicon-s-check-circle class="h-5 w-5 text-green-300" />
                    </div>
                    <div class="ml-3">
                        <p class="text-sm leading-5 font-medium text-white">
                            A fresh code has been sent to your email address.
                        </p>
                    </div>
                </div>
            </div>

            <div class="text-gray-100">
                We've shot an email into your inbox with a confirmation code. What code did we send?
            </div>

            <div class="mt-3">
                <div class="rounded-md">
                    <input wire:model.lazy="tokenAttempt" placeholder="The code we emailed you" required autofocus
                           class="appearance-none bg-gray-700 block w-full px-3 py-2 border border-gray-600 rounded-md text-gray-200 placeholder-gray-400 focus:outline-none focus:shadow-outline-indigo focus:border-indigo-500 transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('tokenAttempt') border-red-500 placeholder-red-400 focus:border-red-500 focus:shadow-outline-red @enderror"
                    />
                </div>
                @error('tokenAttempt')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-6 flex items-center justify-end">
                <div class="text-sm leading-5">
                    <a wire:click="sendRequest(true)" wire:loading.attr="disabled"
                       wire:loading.class="opacity-75 cursor-wait"
                       class="cursor-pointer font-medium text-indigo-500 hover:text-indigo-400 focus:outline-none focus:underline transition ease-in-out duration-150"
                    >
                        Resend code
                    </a>
                </div>
            </div>

            <div class="mt-6">
                <span class="block w-full rounded-md shadow-sm">
                    <button type="submit" wire:loading.attr="disabled" wire:loading.class="opacity-75 cursor-wait"
                            class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out"
                    >
                        Continue
                    </button>
                </span>
            </div>
        </form>
    @endif
</div>
