{{--
Tailwind safelist (do not remove — ensures dynamic color classes are generated):
bg-primary-500 bg-success-500 bg-warning-500 bg-danger-500 bg-info-500 bg-gray-500
text-primary-600 text-success-600 text-warning-600 text-danger-600 text-info-600 text-gray-600
dark:text-primary-400 dark:text-success-400 dark:text-warning-400 dark:text-danger-400 dark:text-info-400 dark:text-gray-400
--}}
@php
    $statItems = (isset($stats) && is_array($stats)) ? $stats : [];
@endphp

<div class="grid gap-6" style="grid-template-columns: repeat(auto-fill, minmax(min(100%, 240px), 1fr));">
    @foreach($statItems as $stat)
        @php
            $statColor = $stat['color'] ?? 'gray';
            $statValue = $stat['value'] ?? '-';
            $statLabel = $stat['label'] ?? '';
            $statDesc = $stat['description'] ?? null;
        @endphp
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white px-7 py-6 shadow-sm dark:border-white/10 dark:bg-gray-900">
            <div class="flex items-center gap-2.5">
                <div class="h-2.5 w-2.5 shrink-0 rounded-full bg-{{ $statColor }}-500"></div>
                <p class="truncate text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">{{ $statLabel }}</p>
            </div>
            <p class="mt-4 truncate text-3xl font-extrabold text-gray-950 dark:text-white">{{ $statValue }}</p>
            @if($statDesc)
                <p class="mt-2 truncate text-sm text-{{ $statColor }}-600 dark:text-{{ $statColor }}-400">{{ $statDesc }}</p>
            @endif
        </div>
    @endforeach
</div>
