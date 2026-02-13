{{-- Modal Alert Component --}}
{{-- Usage:
    @include('components.modal-alert', [
        'id' => 'myModal',
        'type' => 'warning', // info, warning, danger
        'title' => 'Warning',
        'message' => 'This is a warning message',
        'buttons' => [
            ['text' => 'Confirm', 'href' => '/login', 'class' => 'primary'],
            ['text' => 'Cancel', 'dismiss' => true, 'class' => 'secondary']
        ]
    ])
--}}

<div id="{{ $id }}" class="modal-overlay fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden opacity-0 transition-opacity duration-300">
    <div class="modal-container flex items-center justify-center min-h-screen p-4">
        <div class="modal-content bg-white rounded-3xl shadow-2xl max-w-md w-full transform scale-95 transition-transform duration-300 overflow-hidden">
            {{-- Header with Icon --}}
            <div class="modal-header p-6 pb-4 {{ 
                $type === 'info' ? 'bg-gradient-to-r from-blue-50 to-indigo-50' : 
                ($type === 'warning' ? 'bg-gradient-to-r from-yellow-50 to-orange-50' : 
                'bg-gradient-to-r from-red-50 to-pink-50') 
            }}">
                <div class="flex items-start gap-4">
                    {{-- Icon --}}
                    <div class="flex-shrink-0 w-12 h-12 rounded-full flex items-center justify-center {{ 
                        $type === 'info' ? 'bg-blue-100' : 
                        ($type === 'warning' ? 'bg-yellow-100' : 'bg-red-100') 
                    }}">
                        @if($type === 'info')
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        @elseif($type === 'warning')
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        @else
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        @endif
                    </div>

                    {{-- Title --}}
                    <div class="flex-1">
                        <h3 class="text-xl font-bold {{ 
                            $type === 'info' ? 'text-blue-900' : 
                            ($type === 'warning' ? 'text-yellow-900' : 'text-red-900') 
                        }}">
                            {{ $title }}
                        </h3>
                    </div>

                    {{-- Close Button --}}
                    <button type="button" class="modal-close flex-shrink-0 text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Body --}}
            <div class="modal-body p-6">
                <p class="text-gray-700 leading-relaxed">
                    {{ $message }}
                </p>
                @if(isset($details))
                    <div class="mt-4 p-4 bg-gray-50 rounded-xl">
                        <p class="text-sm text-gray-600">{{ $details }}</p>
                    </div>
                @endif
            </div>

            {{-- Footer with Buttons --}}
            @if(isset($buttons) && count($buttons) > 0)
                <div class="modal-footer p-6 pt-0 flex gap-3 {{ count($buttons) === 1 ? 'justify-end' : 'justify-end' }}">
                    @foreach($buttons as $button)
                        @if(isset($button['dismiss']) && $button['dismiss'])
                            <button type="button" 
                                    class="modal-close px-6 py-3 rounded-xl font-semibold transition-all duration-300 {{ 
                                        $button['class'] === 'primary' ? 'bg-gray-600 text-white hover:bg-gray-700 shadow-lg hover:shadow-xl' : 
                                        'bg-gray-100 text-gray-700 hover:bg-gray-200' 
                                    }}">
                                {{ $button['text'] }}
                            </button>
                        @elseif(isset($button['href']))
                            <a href="{{ $button['href'] }}" 
                               class="px-6 py-3 rounded-xl font-semibold transition-all duration-300 {{ 
                                   $button['class'] === 'primary' ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white hover:from-indigo-700 hover:to-purple-700 shadow-lg hover:shadow-xl hover:-translate-y-0.5' : 
                                   ($button['class'] === 'danger' ? 'bg-gradient-to-r from-red-600 to-pink-600 text-white hover:from-red-700 hover:to-pink-700 shadow-lg hover:shadow-xl hover:-translate-y-0.5' :
                                   'bg-gray-100 text-gray-700 hover:bg-gray-200') 
                               }}">
                                {{ $button['text'] }}
                            </a>
                        @elseif(isset($button['onclick']))
                            <button type="button" 
                                    onclick="{{ $button['onclick'] }}"
                                    class="px-6 py-3 rounded-xl font-semibold transition-all duration-300 {{ 
                                        $button['class'] === 'primary' ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white hover:from-indigo-700 hover:to-purple-700 shadow-lg hover:shadow-xl hover:-translate-y-0.5' : 
                                        ($button['class'] === 'danger' ? 'bg-gradient-to-r from-red-600 to-pink-600 text-white hover:from-red-700 hover:to-pink-700 shadow-lg hover:shadow-xl hover:-translate-y-0.5' :
                                        'bg-gray-100 text-gray-700 hover:bg-gray-200') 
                                    }}">
                                {{ $button['text'] }}
                            </button>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
