@section('title', 'My Account')

<div>
    <header class="py-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl leading-9 font-bold text-white">
                My Account
            </h1>
        </div>
    </header>

    <div class="max-w-4xl mx-auto pb-12 px-4 sm:px-6">
        <form wire:submit.prevent="update" spellcheck="false" class="bg-white shadow overflow-hidden rounded-md">
            <div class="bg-white px-4 py-5 sm:p-6 border-b border-gray-200">
                <div class="flex items-center justify-between flex-wrap sm:flex-no-wrap">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Details
                        </h3>
                    </div>

                    <x-flash-message event="account.updated" message="Saved!" />
                </div>
            </div>
            <div class="px-4 py-5 sm:p-6">
                <x-inputs.text label="First name" name="firstName" />

                <x-inputs.text label="Last name" name="lastName" class="mt-6 sm:border-t sm:border-gray-200 sm:pt-5" />

                <x-inputs.text label="Email address" name="email" type="email" maxWidth="max-w-lg"
                               class="mt-6 sm:border-t sm:border-gray-200 sm:pt-5"
                />
            </div>
            <div class="bg-gray-50 px-4 py-5 sm:p-6 flex justify-end">
                <span class="inline-flex">
                    <button type="submit" wire:loading.class="opacity-75 cursor-wait"
                            class="inline-flex shadow-sm justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out"
                    >
                        Save
                        <x-heroicon-s-check class="ml-1.5 -mr-1 h-5 w-5" />
                    </button>
                </span>
            </div>
        </form>
    </div>
</div>
