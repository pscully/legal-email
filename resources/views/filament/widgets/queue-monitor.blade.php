<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            Queue Monitor
        </x-slot>

        <div class="grid gap-6">
            {{-- Queue Stats Grid --}}
            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                {{-- Jobs in Queue --}}
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0">
                        <x-filament::icon
                            icon="heroicon-o-queue-list"
                            class="h-6 w-6 text-gray-400 dark:text-gray-500"
                        />
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Jobs in Queue
                        </p>
                        <p class="mt-1 text-2xl font-bold text-gray-900 dark:text-gray-100">
                            {{ number_format($this->getQueuedJobsCount()) }}
                        </p>
                    </div>
                </div>

                {{-- Failed Jobs --}}
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0">
                        <x-filament::icon
                            icon="heroicon-o-exclamation-triangle"
                            @class([
                                'h-6 w-6',
                                'text-gray-400 dark:text-gray-500' => $this->getFailedJobsCount() === 0,
                                'text-danger-500' => $this->getFailedJobsCount() > 0,
                            ])
                        />
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Failed Jobs
                        </p>
                        <p @class([
                            'mt-1 text-2xl font-bold',
                            'text-gray-900 dark:text-gray-100' => $this->getFailedJobsCount() === 0,
                            'text-danger-600 dark:text-danger-400' => $this->getFailedJobsCount() > 0,
                        ])>
                            {{ number_format($this->getFailedJobsCount()) }}
                        </p>
                    </div>
                </div>

                {{-- Status --}}
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0">
                        <x-filament::icon
                            icon="heroicon-o-arrow-path"
                            @class([
                                'h-6 w-6',
                                'text-gray-400 dark:text-gray-500' => $this->getQueuedJobsCount() === 0,
                                'text-primary-500 animate-spin' => $this->getQueuedJobsCount() > 0,
                            ])
                        />
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Status
                        </p>
                        <p class="mt-1 text-sm font-semibold text-gray-900 dark:text-gray-100">
                            {{ $this->getProcessingInfo() }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Recent Failed Jobs (if any) --}}
            @if($this->getFailedJobsCount() > 0)
                <div class="rounded-lg border border-danger-200 bg-danger-50 p-4 dark:border-danger-800 dark:bg-danger-900/20">
                    <h4 class="mb-2 text-sm font-medium text-danger-800 dark:text-danger-200">
                        Recent Failed Jobs
                    </h4>
                    <ul class="space-y-1 text-xs text-danger-700 dark:text-danger-300">
                        @foreach($this->getRecentFailedJobs() as $job)
                            <li class="truncate">
                                {{ \Carbon\Carbon::parse($job->failed_at)->diffForHumans() }}: {{ \Illuminate\Support\Str::limit($job->short_exception, 80) }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Info Box --}}
            <div class="flex items-center gap-2 rounded-lg bg-gray-50 px-4 py-3 dark:bg-gray-800">
                <x-filament::icon
                    icon="heroicon-o-information-circle"
                    class="h-5 w-5 text-primary-500"
                />
                <p class="text-sm text-gray-700 dark:text-gray-300">
                    Rate limits: 2/sec (API) &bull; 400/hour (deliverability) &bull; 6am-8pm EST
                </p>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
