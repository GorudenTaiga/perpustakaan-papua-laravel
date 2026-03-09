@php
    $rankTitle = (isset($title) && is_string($title)) ? $title : '';
    $rankItems = (isset($items) && is_array($items)) ? $items : [];
    $rankNameKey = (isset($nameKey) && is_string($nameKey)) ? $nameKey : 'nama';
    $rankValueKey = (isset($valueKey) && is_string($valueKey)) ? $valueKey : 'total';
    $rankNameHeader = (isset($nameHeader) && is_string($nameHeader)) ? $nameHeader : 'Nama';
    $rankValueHeader = (isset($valueHeader) && is_string($valueHeader)) ? $valueHeader : 'Jumlah';
    $rankValueSuffix = (isset($valueSuffix) && is_string($valueSuffix)) ? $valueSuffix : '';
@endphp

@php
    $maxValue = collect($rankItems)->max(fn ($item) => is_object($item) ? ($item->{$rankValueKey} ?? 0) : ($item[$rankValueKey] ?? 0)) ?: 1;
@endphp

<div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-white/10 dark:bg-gray-900">
    @if($rankTitle)
        <div class="border-b border-gray-200 bg-gray-50 px-6 py-4 dark:border-white/10 dark:bg-white/5">
            <h4 class="text-sm font-semibold text-gray-950 dark:text-white">{{ $rankTitle }}</h4>
        </div>
    @endif

    @if(empty($rankItems))
        <div class="p-8 text-center">
            <x-heroicon-o-chart-bar class="mx-auto mb-2 h-8 w-8 text-gray-300 dark:text-gray-600" />
            <p class="text-sm italic text-gray-400 dark:text-gray-500">Tidak ada data untuk periode ini</p>
        </div>
    @else
        <div class="divide-y divide-gray-100 dark:divide-white/5">
            @foreach($rankItems as $i => $item)
                @php
                    $itemName = is_object($item) ? ($item->{$rankNameKey} ?? '-') : ($item[$rankNameKey] ?? '-');
                    $itemValue = is_object($item) ? ($item->{$rankValueKey} ?? 0) : ($item[$rankValueKey] ?? 0);
                    $barWidth = $maxValue > 0 ? round(($itemValue / $maxValue) * 100) : 0;

                    $rankStyle = match($i) {
                        0 => 'bg-amber-100 text-amber-700 ring-amber-500/30 dark:bg-amber-500/20 dark:text-amber-400 dark:ring-amber-400/30',
                        1 => 'bg-gray-100 text-gray-600 ring-gray-400/30 dark:bg-gray-500/20 dark:text-gray-300 dark:ring-gray-400/30',
                        2 => 'bg-orange-100 text-orange-700 ring-orange-500/30 dark:bg-orange-500/20 dark:text-orange-400 dark:ring-orange-400/30',
                        default => 'bg-gray-50 text-gray-500 ring-gray-300/30 dark:bg-white/5 dark:text-gray-400 dark:ring-gray-500/30',
                    };

                    $barColor = match($i) {
                        0 => 'bg-primary-500',
                        1 => 'bg-primary-400',
                        2 => 'bg-primary-300',
                        default => 'bg-gray-300 dark:bg-gray-600',
                    };
                @endphp
                <div class="flex items-center gap-5 px-6 py-5">
                    {{-- Rank Badge --}}
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full text-sm font-bold ring-1 ring-inset {{ $rankStyle }}">
                        {{ $i + 1 }}
                    </div>

                    {{-- Name + Bar --}}
                    <div class="min-w-0 flex-1">
                        <div class="flex items-baseline justify-between gap-4">
                            <span class="truncate text-sm font-medium text-gray-950 dark:text-white">{{ $itemName }}</span>
                            <span class="shrink-0 rounded-full bg-primary-50 px-2.5 py-0.5 text-sm font-bold text-primary-700 ring-1 ring-inset ring-primary-600/20 dark:bg-primary-400/10 dark:text-primary-400 dark:ring-primary-400/20">
                                {{ number_format($itemValue) }}{{ $rankValueSuffix }}
                            </span>
                        </div>
                        <div class="mt-2 h-2 w-full overflow-hidden rounded-full bg-gray-100 dark:bg-white/10">
                            <div class="{{ $barColor }} h-full rounded-full transition-all duration-500" style="width: {{ $barWidth }}%"></div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
