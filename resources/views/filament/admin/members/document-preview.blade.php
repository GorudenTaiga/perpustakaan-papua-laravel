@php
    $docUrl = isset($url) && is_string($url) ? $url : '';
    $docName = isset($name) && is_string($name) ? $name : 'Dokumen';
    $docExt = strtolower(pathinfo($docName, PATHINFO_EXTENSION));
    $isImage = in_array($docExt, ['jpg', 'jpeg', 'png', 'webp', 'gif']);
    $isPdf = $docExt === 'pdf';
@endphp

<div class="space-y-4">
    {{-- Document viewer --}}
    <div class="rounded-xl border border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-white/5 overflow-hidden">
        @if ($isImage)
            {{-- Zoomable image using Alpine.js (already bundled by Filament) --}}
            <div x-data="{
                scale: 1,
                posX: 0,
                posY: 0,
                dragging: false,
                startX: 0,
                startY: 0,
                zoomIn() { this.scale = Math.min(this.scale + 0.4, 5); },
                zoomOut() { this.scale = Math.max(this.scale - 0.4, 1); if (this.scale === 1) { this.posX = 0;
                        this.posY = 0; } },
                reset() { this.scale = 1;
                    this.posX = 0;
                    this.posY = 0; },
                wheel(e) { e.preventDefault();
                    e.deltaY < 0 ? this.zoomIn() : this.zoomOut(); },
                startDrag(e) { if (this.scale > 1) { this.dragging = true;
                        this.startX = e.clientX - this.posX;
                        this.startY = e.clientY - this.posY; } },
                onDrag(e) { if (this.dragging) { this.posX = e.clientX - this.startX;
                        this.posY = e.clientY - this.startY; } },
                stopDrag() { this.dragging = false; }
            }" class="relative flex flex-col" @wheel.prevent="wheel($event)">
                {{-- Zoom toolbar --}}
                <div
                    class="flex items-center justify-between px-4 py-2.5 border-b border-gray-200 dark:border-white/10 bg-white dark:bg-white/5">
                    <span class="text-xs text-gray-400 dark:text-gray-500 select-none">
                        Scroll atau gunakan tombol untuk zoom
                    </span>
                    <div class="flex items-center gap-1">
                        <button type="button" @click="zoomOut()" :disabled="scale <= 1"
                            class="inline-flex items-center justify-center w-7 h-7 rounded-md text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-white/10 disabled:opacity-30 disabled:cursor-not-allowed transition-colors">
                            <x-heroicon-o-minus class="w-4 h-4" />
                        </button>
                        <span class="w-12 text-center text-xs font-mono text-gray-600 dark:text-gray-300 select-none"
                            x-text="Math.round(scale * 100) + '%'"></span>
                        <button type="button" @click="zoomIn()" :disabled="scale >= 5"
                            class="inline-flex items-center justify-center w-7 h-7 rounded-md text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-white/10 disabled:opacity-30 disabled:cursor-not-allowed transition-colors">
                            <x-heroicon-o-plus class="w-4 h-4" />
                        </button>
                        <button type="button" @click="reset()" x-show="scale !== 1"
                            class="inline-flex items-center justify-center w-7 h-7 rounded-md text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-white/10 transition-colors ml-1"
                            title="Reset">
                            <x-heroicon-o-arrow-path class="w-3.5 h-3.5" />
                        </button>
                    </div>
                </div>

                {{-- Image container --}}
                <div class="flex items-center justify-center overflow-hidden" style="height: 60vh; min-height: 360px;"
                    @mousedown="startDrag($event)" @mousemove="onDrag($event)" @mouseup="stopDrag()"
                    @mouseleave="stopDrag()" :style="scale > 1 ? 'cursor: grab' : 'cursor: zoom-in'"
                    :class="dragging ? '!cursor-grabbing' : ''" @dblclick="scale === 1 ? zoomIn() : reset()">
                    <img src="{{ $docUrl }}" alt="{{ $docName }}"
                        class="rounded shadow-sm object-contain select-none transition-transform duration-150"
                        style="max-width: 100%; max-height: 100%;"
                        :style="`transform: scale(${scale}) translate(${posX / scale}px, ${posY / scale}px)`"
                        draggable="false" loading="lazy" />
                </div>
            </div>
        @elseif ($isPdf)
            <iframe src="{{ $docUrl }}#toolbar=1&navpanes=0" class="w-full border-0"
                style="height: 70vh; min-height: 500px;" title="{{ $docName }}"></iframe>
        @else
            <div class="flex flex-col items-center justify-center p-10 text-gray-400 dark:text-gray-500 min-h-[300px]">
                <x-heroicon-o-document class="w-16 h-16 mb-4 opacity-40" />
                <p class="text-sm font-medium">Preview tidak tersedia untuk tipe file ini</p>
                <p class="text-xs mt-1">{{ $docExt ? strtoupper($docExt) : 'Unknown' }} file</p>
            </div>
        @endif
    </div>

    {{-- File info + download --}}
    <div class="flex items-center justify-between px-1">
        <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
            @if ($isImage)
                <x-heroicon-o-photo class="w-4 h-4" />
            @elseif ($isPdf)
                <x-heroicon-o-document-text class="w-4 h-4" />
            @else
                <x-heroicon-o-document class="w-4 h-4" />
            @endif
            <span class="truncate max-w-[250px] font-mono text-xs">{{ $docName }}</span>
        </div>

        <a href="{{ $docUrl }}" target="_blank" download
            class="inline-flex items-center gap-1.5 rounded-lg bg-primary-50 dark:bg-primary-500/10 px-3 py-1.5 text-xs font-medium text-primary-600 dark:text-primary-400 hover:bg-primary-100 dark:hover:bg-primary-500/20 transition-colors">
            <x-heroicon-o-arrow-down-tray class="w-3.5 h-3.5" />
            Download
        </a>
    </div>
</div>
