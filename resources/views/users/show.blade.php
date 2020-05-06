<div class="bg-white rounded-lg overflow-hidden shadow-xl mx-auto">
    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
        <div class="flex items-center justify-between flex-wrap sm:flex-no-wrap">
            <div>
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    {{ $user->full_name }}
                </h3>
            </div>
        </div>

        <x-inputs.text disabled label="First name" name="firstName" :value="$user->first_name" :key="$user->id" context="show" class="mt-6" />

        <x-inputs.text disabled label="Last name" name="lastName" :value="$user->last_name" :key="$user->id" context="show" class="mt-6 sm:border-t sm:border-gray-200 sm:pt-5" />

        <x-inputs.text disabled label="Email address" name="email" :value="$user->email" :key="$user->id" context="show" type="email" maxWidth="lg" class="mt-6 sm:border-t sm:border-gray-200 sm:pt-5" />

        <x-inputs.base disabled label="Role" name="role" :key="$user->id" context="show" class="mt-6 sm:border-t sm:border-gray-200 sm:pt-5">
            <div class="max-w-xs rounded-md shadow-sm">
                <select disabled id="roleShow{{ $user->id }}" class="bg-gray-50 cursor-not-allowed block form-select w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                    <option @if (!$user->role || $user->role == 'User') selected @endif>User</option>
                    <option @if ($user->role == 'admin') selected @endif>Admin</option>
                    <option @if ($user->role == 'owner') selected @endif>Owner</option>
                </select>
            </div>
        </x-inputs.base>
    </div>
    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse sm:justify-between">
        @can('update', $user)
            <span class="flex w-full rounded-md shadow-sm sm:w-auto">
                <button @click="context = 'edit'" type="button"
                        class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-indigo-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo transition ease-in-out duration-150 sm:text-sm sm:leading-5"
                >
                    <x-heroicon-s-pencil class="mr-1.5 -ml-1 h-5 w-5" />

                    Edit
                </button>
            </span>
        @endcan
        <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
            <button @click="context = null" type="button"
                    class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline transition ease-in-out duration-150 sm:text-sm sm:leading-5"
            >
                Close
            </button>
        </span>
    </div>
</div>
