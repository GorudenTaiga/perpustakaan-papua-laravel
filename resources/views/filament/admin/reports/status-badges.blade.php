@php
    $sbTitle = (isset($title) && is_string($title)) ? $title : '';
    $sbItems = (isset($items) && is_array($items)) ? $items : [];
    $sbLabels = (isset($labels) && is_array($labels)) ? $labels : [];
@endphp

<div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-white/10 dark:bg-gray-900">
    @if($sbTitle)
        <div class="border-b border-gray-200 bg-gray-50 px-6 py-4 dark:border-white/10 dark:bg-white/5">
            <h4 class="text-sm font-semibold text-gray-950 dark:text-white">{{ $sbTitle }}</h4>
        </div>
    @endif

    @if(empty($sbItems))
        <div class="p-8 text-center">
            <x-heroicon-o-calendar class="mx-auto mb-2 h-8 w-8 text-gray-300 dark:text-gray-600" />
            <p class="text-sm italic text-gray-400 dark:text-gray-500">Tidak ada data untuk periode ini</p>
        </div>
    @else
        <div class="flex flex-wrap gap-5 p-6">
            @foreach($sbItems as $status => $total)
                @php
                    $sbLabel = $sbLabels[$status] ?? ucfirst($status);
                    $colorClass = match($status) {
                        'waiting' => 'bg-warning-50 text-warning-600 ring-warning-600/20 dark:bg-warning-400/10 dark:text-warning-400 dark:ring-warning-400/20',
                        'available' => 'bg-info-50 text-info-600 ring-info-600/20 dark:bg-info-400/10 dark:text-info-400 dark:ring-info-400/20',
                        'fulfilled' => 'bg-success-50 text-success-600 ring-success-600/20 dark:bg-success-400/10 dark:text-success-400 dark:ring-success-400/20',
                        'cancelled' => 'bg-danger-50 text-danger-600 ring-danger-600/20 dark:bg-danger-400/10 dark:text-danger-400 dark:ring-danger-400/20',
                        default => 'bg-gray-50 text-gray-600 ring-gray-600/20 dark:bg-gray-400/10 dark:text-gray-400 dark:ring-gray-400/20',
                    };
                @endphp
                <div class="flex flex-col items-center rounded-xl px-7 py-4 ring-1 ring-inset {{ $colorClass }}">
                    <span class="text-2xl font-bold">{{ number_format($total) }}</span>
                    <span class="mt-1 text-xs font-medium">{{ $sbLabel }}</span>
                </div>
            @endforeach
        </div>
    @endif
</div>
