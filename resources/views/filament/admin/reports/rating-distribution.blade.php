@php
    $rdTitle = (isset($title) && is_string($title)) ? $title : '';
    $rdDistribution = (isset($distribution) && is_array($distribution)) ? $distribution : [];
@endphp

@php
    $sorted = collect($rdDistribution)->sortKeysDesc()->all();
    $maxCount = !empty($sorted) ? max($sorted) : 1;
    $totalReviews = array_sum($sorted);
@endphp

<div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-white/10 dark:bg-gray-900">
    @if($rdTitle)
        <div class="border-b border-gray-200 bg-gray-50 px-6 py-4 dark:border-white/10 dark:bg-white/5">
            <h4 class="text-sm font-semibold text-gray-950 dark:text-white">{{ $rdTitle }}</h4>
        </div>
    @endif

    @if(empty($sorted))
        <div class="p-8 text-center">
            <x-heroicon-o-star class="mx-auto mb-2 h-8 w-8 text-gray-300 dark:text-gray-600" />
            <p class="text-sm italic text-gray-400 dark:text-gray-500">Tidak ada data untuk periode ini</p>
        </div>
    @else
        <div class="space-y-5 p-6">
            @foreach($sorted as $rating => $count)
                @php
                    $percentage = $totalReviews > 0 ? round(($count / $totalReviews) * 100) : 0;
                    $barWidth = $maxCount > 0 ? round(($count / $maxCount) * 100) : 0;
                    $stars = str_repeat('★', (int)$rating) . str_repeat('☆', 5 - (int)$rating);
                    $barColor = match((int)$rating) {
                        5 => 'bg-success-500',
                        4 => 'bg-success-400',
                        3 => 'bg-warning-400',
                        2 => 'bg-warning-500',
                        1 => 'bg-danger-500',
                        default => 'bg-gray-400',
                    };
                @endphp
                <div class="flex items-center gap-4">
                    <span class="min-w-[100px] text-sm tracking-wider text-warning-500">{{ $stars }}</span>
                    <div class="h-6 flex-1 overflow-hidden rounded-full bg-gray-100 dark:bg-white/5">
                        <div class="{{ $barColor }} h-full rounded-full transition-all duration-300" style="width: {{ $barWidth }}%; min-width: 2px;"></div>
                    </div>
                    <span class="min-w-[110px] text-end text-sm font-semibold text-gray-700 dark:text-gray-300">
                        {{ number_format($count) }}
                        <span class="font-normal text-gray-400 dark:text-gray-500">({{ $percentage }}%)</span>
                    </span>
                </div>
            @endforeach
        </div>
    @endif
</div>
