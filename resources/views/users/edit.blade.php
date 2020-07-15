<div class="bg-white rounded-lg overflow-hidden shadow-xl mx-auto">
    <form wire:submit.prevent="update" spellcheck="false">
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="flex items-center justify-between flex-wrap sm:flex-no-wrap">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Edit {{ $user->full_name }}
                    </h3>
                </div>

                <x-flash-message event="user.updated" message="Saved!" />
            </div>

            <x-inputs.text label="First name" name="firstName" :key="$user->id" context="edit" class="mt-6" />

            <x-inputs.text label="Last name" name="lastName" :key="$user->id" context="edit"
                           class="mt-6 sm:border-t sm:border-gray-200 sm:pt-5"
            />

            <x-inputs.text label="Email address" name="email" :key="$user->id" context="edit" type="email"
                           maxWidth="max-w-lg" class="mt-6 sm:border-t sm:border-gray-200 sm:pt-5"
            />

            <x-inputs.select :disabled="user()->cannot('updateRole', $user)" label="Role" name="role"
                             :value="$user->role" :options="['User', 'admin' => 'Admin', 'owner' => 'Owner']"
                             :key="$user->id" context="edit" class="mt-6 sm:border-t sm:border-gray-200 sm:pt-5"
            />

            @can('updateRole', $user)
                <div class="mt-1 sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                    <div></div>

                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                        <div class="text-xs max-w-xs text-gray-700">
                            @if ($role == 'owner')
                                <p>
                                    Owners have no restrictions and can manage anything on your server.
                                </p>
                            @elseif ($role == 'admin')
                                <p>
                                    Admins can manage every app on your server, and can create new users.
                                </p>
                            @else
                                <p>
                                    Users can’t access any apps by default, instead being added as a “collaborator” to
                                    their apps.
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            @endcan
        </div>
        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse sm:justify-between">
            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                <button type="submit" wire:loading.class="opacity-75 cursor-wait"
                        class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-indigo-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo transition ease-in-out duration-150 sm:text-sm sm:leading-5"
                >
                    Save
                    <x-heroicon-s-check class="ml-1.5 -mr-1 h-5 w-5" />
                </button>
            </span>
            <div class="sm:flex sm:flex-row-reverse">
                @can('delete', $user)
                    <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:ml-3 sm:w-auto">
                        <button @click="context = 'delete'" type="button"
                                class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-red-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red transition ease-in-out duration-150 sm:text-sm sm:leading-5"
                        >
                            <x-heroicon-s-trash class="h-5 w-5" />
                        </button>
                    </span>
                @endcan
                <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                    <button @click="context = 'show'" type="button"
                            class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline transition ease-in-out duration-150 sm:text-sm sm:leading-5"
                    >
                        <x-heroicon-s-chevron-left class="-ml-1 mr-1.5 h-5 w-5" />
                        Back
                    </button>
                </span>
            </div>
        </div>
    </form>
</div>
