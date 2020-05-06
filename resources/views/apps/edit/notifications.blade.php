<div class="bg-white shadow overflow-hidden rounded-md">
    <form wire:submit.prevent="update">
        <div class="bg-white px-4 py-5 border-b border-gray-200 sm:px-6">
            <div class="flex items-center justify-between flex-wrap sm:flex-no-wrap">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Slack Notifications
                    </h3>
                </div>
                <div>
                    <x-flash-message event="app.notifications.set-up" message="Set up!" />

                    <x-flash-message event="app.notifications.updated" message="Saved!" />
                </div>
            </div>
        </div>
        <div class="px-4 py-6 sm:px-6">
            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                <label for="webhookUrl"
                       class="block text-sm font-medium leading-5 text-gray-700 sm:mt-px sm:pt-2 hover:underline"
                >
                    <a href="https://slack.com/apps/A0F7XDUAZ-incoming-webhooks" target="blank">Webhook URL</a>
                </label>
                <div class="mt-1 sm:mt-0 sm:col-span-2">
                    <div class="rounded-md shadow-sm">
                        <input wire:model.lazy="slackNotificationWebhookUrl" id="webhookUrl"
                               placeholder="https://hooks.slack.com/services/..."
                               class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('slackNotificationWebhookUrl') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @enderror"
                        />
                    </div>
                    @error('slackNotificationWebhookUrl')
                    <p
                        class="mt-1 text-xs text-red-600"
                    >{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="mt-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                <label for="channel" class="block text-sm font-medium leading-5 text-gray-700 sm:mt-px sm:pt-2">
                    Channel
                </label>
                <div class="mt-1 sm:mt-0 sm:col-span-2">
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm sm:leading-5">
                                #
                            </span>
                        </div>
                        <input wire:model.lazy="slackNotificationChannel" id="channel" placeholder="general"
                               class="form-input block pl-7 w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('slackNotificationChannel') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @enderror"
                        />
                    </div>
                    @error('slackNotificationChannel')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-4 py-4 sm:px-6 flex">
            <div class="inline-flex flex-shrink-0 items-center">
                <p class="inline-flex text-sm leading-5 font-medium text-gray-700">
                    <x-heroicon-s-information-circle class="mr-1 h-5 w-5" />
                    Slack notifications {{ $this->app->slack_notification_channel && $this->app->slack_notification_webhook_url ? 'enabled.' : 'disabled.' }}
                </p>
            </div>
            <div class="flex w-full justify-end">
                <span class="inline-flex">
                    <button type="submit" wire:loading.class="opacity-75 cursor-wait"
                            class="inline-flex shadow-sm justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out"
                    >
                        Save
                        <x-heroicon-s-check class="ml-1.5 -mr-1 h-5 w-5" />
                    </button>
                </span>
            </div>
        </div>
    </form>
</div>
