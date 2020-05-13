<div>
    <div class="rounded-md shadow overflow-hidden">
        <div class="bg-white px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Set up this app
            </h3>
        </div>
        <div class="flex">
            <div class="relative flex-grow focus-within:z-10">
                <input id="setupCommand"
                       value="npx envault {{ parse_url(config('app.url'))['host'] ?? null }} {{ $app->id }} {{ $token }}"
                       class="form-input px-4 sm:px-6 rounded-none border-0 block w-full transition ease-in-out duration-150 font-mono py-5 text-white bg-gray-900 sm:leading-5"
                       readonly
                />
            </div>
            <button id="copySetupCommand" type="button"
                    class="-ml-px relative inline-flex items-center px-4 py-2 text-sm leading-5 font-medium text-gray-100 bg-gray-900 border-l border-gray-200 hover:text-white hover:bg-gray-800 focus:outline-none focus:shadow-outline-indigo active:bg-gray-900 active:text-white transition ease-in-out duration-150"
            >
                <x-heroicon-s-clipboard-copy class="h-5 w-5 text-gray-400" />
                <span class="ml-2">Copy</span>
            </button>
        </div>
    </div>
</div>

<script>
    document.getElementById('copySetupCommand').addEventListener('click', function () {
        var input = document.getElementById('setupCommand');
        input.select();
        input.setSelectionRange(0, 100);
        document.execCommand('copy');
    });

    setInterval(function () {
        window.livewire.emit('app.setup-command.generate');
    }, 300000);

</script>
