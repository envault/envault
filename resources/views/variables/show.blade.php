<div class="bg-white rounded-lg overflow-hidden shadow-xl mx-auto">
    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
        <div class="flex items-center justify-between flex-wrap sm:flex-no-wrap">
            <div>
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    <span class="font-mono">{{ $variable->key }}</span>
                </h3>
            </div>
        </div>

        <x-inputs.text disabled label="Label" name="label" :value="$variable->label" :key="$variable->id" context="show" font="font-mono" maxWidth="max-w-lg" class="mt-6" />

        <x-inputs.text disabled label="Key" name="key" :value="$variable->key" :key="$variable->id" context="show" font="font-mono" maxWidth="max-w-lg" class="mt-6" class="mt-6 sm:border-t sm:border-gray-200 sm:pt-5" />

        <x-inputs.text disabled label="Value" name="value" :value="$variable->latest_version->value ?? ''" :key="$variable->id" context="show" font="font-mono" maxWidth="max-w-lg" class="mt-6 sm:border-t sm:border-gray-200 sm:pt-5" />
    </div>
    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse sm:justify-between">
        @can('update', $variable)
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
