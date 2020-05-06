@props(['event', 'message'])

<div x-data="{ visible: false }"
     x-init="window.livewire.on('{{ $event }}', () => {
            visible = true;
            setTimeout(() => { visible = false }, 5000);
        })"
     x-show.transition.out="visible"
     x-cloak
     role="alert"
>
    <div class="flex-shrink-0">
        <span class="inline-flex">
            <span
                class="relative inline-flex items-center text-xs leading-5 font-medium text-green-600"
            >
                {{ $message }}
                <x-heroicon-s-check-circle class="ml-1 -mr-0.5 h-4 w-4" />
            </span>
        </span>
    </div>
</div>
