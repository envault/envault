<div class="bg-white shadow overflow-hidden rounded-md">
    <form wire:submit.prevent="store" spellcheck="false">
        <div class="bg-white px-4 py-5 sm:p-6 border-b border-gray-200">
            <div class="flex items-center justify-between flex-wrap sm:flex-no-wrap">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        New user
                    </h3>
                </div>

                <x-flash-message event="user.created" message="Created!" />
            </div>
        </div>
        <div class="px-4 py-5 sm:p-6">
            <x-inputs.text label="First name" name="firstName" placeholder="Tom" />

            <x-inputs.text label="Last name" name="lastName" placeholder="Cook"
                           class="mt-6 sm:border-t sm:border-gray-200 sm:pt-5"
            />

            <x-inputs.text label="Email address" name="email" placeholder="tom@example.com" type="email"
                           maxWidth="max-w-lg" class="mt-6 sm:border-t sm:border-gray-200 sm:pt-5"
            />
        </div>
        <div class="bg-gray-50 px-4 py-5 sm:p-6 flex justify-end">
            <span class="inline-flex">
                <button type="submit" wire:loading.class="opacity-75 cursor-wait"
                        class="inline-flex shadow-sm justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out"
                >
                    Create
                    <x-heroicon-s-check class="ml-1.5 -mr-1 h-5 w-5" />
                </button>
            </span>
        </div>
    </form>
</div>
