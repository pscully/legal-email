<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            Campaign Control
        </x-slot>

        <div class="grid gap-6">
            {{-- Campaign Information Grid --}}
            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                {{-- Last Campaign Run --}}
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0">
                        <x-filament::icon
                            icon="heroicon-o-clock"
                            class="h-6 w-6 text-gray-400 dark:text-gray-500"
                        />
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Last Campaign Run
                        </p>
                        <p class="mt-1 text-sm font-semibold text-gray-900 dark:text-gray-100">
                            {{ $this->getLastCampaignRun() }}
                        </p>
                    </div>
                </div>

                {{-- Pending Invitees --}}
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0">
                        <x-filament::icon
                            icon="heroicon-o-users"
                            class="h-6 w-6 text-gray-400 dark:text-gray-500"
                        />
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Pending Invitees
                        </p>
                        <p class="mt-1 text-sm font-semibold text-gray-900 dark:text-gray-100">
                            {{ number_format($this->getPendingCount()) }}
                        </p>
                    </div>
                </div>

                {{-- Estimated Completion --}}
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0">
                        <x-filament::icon
                            icon="heroicon-o-calendar"
                            class="h-6 w-6 text-gray-400 dark:text-gray-500"
                        />
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Estimated Completion
                        </p>
                        <p class="mt-1 text-sm font-semibold text-gray-900 dark:text-gray-100">
                            {{ $this->getEstimatedCompletionTime() }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Next Batch Info --}}
            <div class="flex items-center gap-2 rounded-lg bg-gray-50 px-4 py-3 dark:bg-gray-800">
                <x-filament::icon
                    icon="heroicon-o-information-circle"
                    class="h-5 w-5 text-primary-500"
                />
                <p class="text-sm text-gray-700 dark:text-gray-300">
                    {{ $this->getNextBatchInfo() }}
                </p>
            </div>

            {{-- Actions --}}
            <div class="flex justify-start border-t border-gray-200 pt-4 dark:border-gray-700">
                {{ $this->startCampaignAction }}
            </div>

            <x-filament-actions::modals />
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
