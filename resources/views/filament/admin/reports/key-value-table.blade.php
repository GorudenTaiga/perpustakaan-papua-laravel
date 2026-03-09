@php
    $kvTitle = (isset($title) && is_string($title)) ? $title : '';
    $kvItems = (isset($items) && is_array($items)) ? $items : [];
    $kvKeyHeader = (isset($keyHeader) && is_string($keyHeader)) ? $keyHeader : 'Kategori';
    $kvValueHeader = (isset($valueHeader) && is_string($valueHeader)) ? $valueHeader : 'Jumlah';
    $kvValueSuffix = (isset($valueSuffix) && is_string($valueSuffix)) ? $valueSuffix : '';
@endphp

@php
    $kvMaxValue = !empty($kvItems) ? max($kvItems) : 1;
@endphp

<div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-white/10 dark:bg-gray-900">
    @if($kvTitle)
        <div class="border-b border-gray-200 bg-gray-50 px-6 py-4 dark:border-white/10 dark:bg-white/5">
            <h4 class="text-sm font-semibold text-gray-950 dark:text-white">{{ $kvTitle }}</h4>
        </div>
    @endif

    @if(empty($kvItems))
        <div class="p-8 text-center">
            <x-heroicon-o-chart-bar class="mx-auto mb-2 h-8 w-8 text-gray-300 dark:text-gray-600" />
            <p class="text-sm italic text-gray-400 dark:text-gray-500">Tidak ada data untuk periode ini</p>
        </div>
    @else
        <div class="divide-y divide-gray-100 dark:divide-white/5">
            @foreach($kvItems as $kvKey => $kvValue)
                @php
                    $barWidth = $kvMaxValue > 0 ? round(($kvValue / $kvMaxValue) * 100) : 0;
                @endphp
                <div class="flex items-center gap-5 px-6 py-5">
                    <div class="min-w-0 flex-1">
                        <div class="flex items-baseline justify-between gap-4">
                            <span class="text-sm font-medium text-gray-950 dark:text-white">{{ ucfirst($kvKey) }}</span>
                            <span class="shrink-0 rounded-full bg-primary-50 px-2.5 py-0.5 text-xs font-bold text-primary-700 ring-1 ring-inset ring-primary-600/20 dark:bg-primary-400/10 dark:text-primary-400 dark:ring-primary-400/20">
                                {{ number_format($kvValue) }}{{ $kvValueSuffix }}
                            </span>
                        </div>
                        <div class="mt-2 h-2 w-full overflow-hidden rounded-full bg-gray-100 dark:bg-white/10">
                            <div class="h-full rounded-full bg-primary-500 transition-all duration-500" style="width: {{ $barWidth }}%"></div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
