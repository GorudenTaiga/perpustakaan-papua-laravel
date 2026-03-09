@php
    $headerTitle = (isset($title) && is_string($title)) ? $title : '';
    $headerPeriodType = (isset($periodType) && is_string($periodType)) ? $periodType : '';
    $headerPeriodStart = (isset($periodStart) && is_string($periodStart)) ? $periodStart : '';
    $headerPeriodEnd = (isset($periodEnd) && is_string($periodEnd)) ? $periodEnd : '';
    $headerGeneratedBy = (isset($generatedBy) && is_string($generatedBy)) ? $generatedBy : '';
    $headerCreatedAt = (isset($createdAt) && is_string($createdAt)) ? $createdAt : '';
@endphp

<div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-white/10 dark:bg-gray-900">
    <div class="p-8">
        <div class="flex items-start justify-between gap-6">
            <div class="min-w-0 flex-1">
                <p class="text-xs font-semibold uppercase tracking-wider text-primary-600 dark:text-primary-400">
                    Laporan Perpustakaan
                </p>
                <h2 class="mt-2 text-2xl font-bold text-gray-950 dark:text-white">{{ $headerTitle }}</h2>
            </div>
            <span class="shrink-0 rounded-full bg-primary-50 px-5 py-2 text-sm font-semibold text-primary-700 ring-1 ring-inset ring-primary-600/20 dark:bg-primary-400/10 dark:text-primary-400 dark:ring-primary-400/20">
                {{ $headerPeriodType }}
            </span>
        </div>

        <div class="mt-6 flex flex-wrap items-center gap-x-8 gap-y-3 border-t border-gray-100 pt-5 dark:border-white/5">
            <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <x-heroicon-o-calendar class="h-4 w-4 shrink-0" />
                <span>{{ $headerPeriodStart }} — {{ $headerPeriodEnd }}</span>
            </div>
            @if($headerGeneratedBy)
                <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                    <x-heroicon-o-user class="h-4 w-4 shrink-0" />
                    <span>{{ $headerGeneratedBy }}</span>
                </div>
            @endif
            @if($headerCreatedAt)
                <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                    <x-heroicon-o-clock class="h-4 w-4 shrink-0" />
                    <span>{{ $headerCreatedAt }}</span>
                </div>
            @endif
        </div>
    </div>
</div>
