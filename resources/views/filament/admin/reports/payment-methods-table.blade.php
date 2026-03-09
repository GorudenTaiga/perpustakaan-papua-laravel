@php
    $pmTitle = (isset($title) && is_string($title)) ? $title : '';
    $pmItems = (isset($items) && is_array($items)) ? $items : [];
@endphp

<div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-white/10 dark:bg-gray-900">
    @if($pmTitle)
        <div class="border-b border-gray-200 bg-gray-50 px-6 py-4 dark:border-white/10 dark:bg-white/5">
            <h4 class="text-sm font-semibold text-gray-950 dark:text-white">{{ $pmTitle }}</h4>
        </div>
    @endif

    @if(empty($pmItems))
        <div class="p-8 text-center">
            <x-heroicon-o-banknotes class="mx-auto mb-2 h-8 w-8 text-gray-300 dark:text-gray-600" />
            <p class="text-sm italic text-gray-400 dark:text-gray-500">Tidak ada data untuk periode ini</p>
        </div>
    @else
        <div class="divide-y divide-gray-100 dark:divide-white/5">
            @foreach($pmItems as $i => $item)
                @php
                    $method = is_object($item) ? ($item->payment_method ?? '-') : ($item['payment_method'] ?? '-');
                    $totalTrx = is_object($item) ? ($item->total_transaksi ?? 0) : ($item['total_transaksi'] ?? 0);
                    $totalAmt = is_object($item) ? ($item->total_amount ?? 0) : ($item['total_amount'] ?? 0);
                @endphp
                <div class="flex items-center justify-between gap-5 px-6 py-5">
                    <div class="flex items-center gap-4">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-gray-100 dark:bg-white/10">
                            <x-heroicon-o-credit-card class="h-5 w-5 text-gray-500 dark:text-gray-400" />
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-950 dark:text-white">{{ ucfirst($method) }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ number_format($totalTrx) }} transaksi</p>
                        </div>
                    </div>
                    <span class="shrink-0 rounded-lg bg-success-50 px-4 py-2 text-sm font-bold text-success-700 ring-1 ring-inset ring-success-600/20 dark:bg-success-400/10 dark:text-success-400 dark:ring-success-400/20">
                        Rp {{ number_format($totalAmt, 0, ',', '.') }}
                    </span>
                </div>
            @endforeach
        </div>
    @endif
</div>
