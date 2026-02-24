@extends('main_member')
@section('content')
    {{-- Hero Section --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-600 py-20 lg:py-28 pb-32">
        <div class="absolute bottom-0 left-0 right-0 h-48 bg-gradient-to-b from-transparent to-white pointer-events-none z-10"></div>
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-white/10 rounded-full blur-3xl"></div>
        </div>
        <div class="container relative mx-auto px-4">
            <div class="flex items-center justify-between">
                <div class="text-white space-y-6">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/20 backdrop-blur-sm border border-white/30">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path>
                        </svg>
                        <span class="text-sm font-semibold">Notifikasi</span>
                    </div>
                    <h1 class="text-5xl lg:text-7xl font-bold leading-tight">
                        <span class="text-yellow-300">Notifikasi</span>
                    </h1>
                    <p class="text-lg lg:text-xl text-white/90 max-w-2xl leading-relaxed">
                        Semua pemberitahuan dan update untuk Anda.
                    </p>
                </div>
                @if($notifications->where('read_at', null)->count() > 0)
                <form action="{{ route('notifications.readAll') }}" method="POST">
                    @csrf
                    <button type="submit" class="px-6 py-3 bg-white/20 backdrop-blur-sm text-white rounded-xl font-semibold hover:bg-white/30 transition-all border border-white/30">
                        Tandai Semua Dibaca
                    </button>
                </form>
                @endif
            </div>
        </div>
    </section>

    {{-- Content --}}
    <section class="py-12 bg-white -mt-20 relative z-20">
        <div class="container mx-auto px-4 max-w-4xl">
            @if($notifications->count() > 0)
                <div class="space-y-4">
                    @foreach($notifications as $n)
                    <div class="flex gap-4 p-6 rounded-2xl border {{ $n->read_at ? 'bg-white border-gray-100' : 'bg-blue-50 border-blue-200' }} transition-all hover:shadow-md">
                        <div class="flex-shrink-0">
                            @php
                                $iconColors = [
                                    'reservation' => 'bg-amber-100 text-amber-600',
                                    'loan_approved' => 'bg-green-100 text-green-600',
                                    'loan_rejected' => 'bg-red-100 text-red-600',
                                    'loan_extended' => 'bg-blue-100 text-blue-600',
                                    'due_reminder' => 'bg-yellow-100 text-yellow-600',
                                ];
                                $iconClass = $iconColors[$n->type] ?? 'bg-indigo-100 text-indigo-600';
                            @endphp
                            <div class="w-12 h-12 rounded-full {{ $iconClass }} flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <h3 class="font-bold text-gray-900 {{ $n->read_at ? '' : 'text-blue-900' }}">{{ $n->title }}</h3>
                                    <p class="text-sm text-gray-600 mt-1 leading-relaxed">{{ $n->message }}</p>
                                    <p class="text-xs text-gray-400 mt-2">{{ $n->created_at->diffForHumans() }}</p>
                                </div>
                                @if(!$n->read_at)
                                <form action="{{ route('notifications.read', $n->id) }}" method="POST" class="flex-shrink-0">
                                    @csrf
                                    <button type="submit" class="p-2 rounded-lg hover:bg-blue-100 transition-colors" title="Tandai dibaca">
                                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $notifications->links() }}
                </div>
            @else
                <div class="text-center py-16">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gradient-to-br from-indigo-50 to-purple-50 mb-6">
                        <svg class="w-10 h-10 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Tidak Ada Notifikasi</h3>
                    <p class="text-gray-600">Anda belum memiliki notifikasi apapun.</p>
                </div>
            @endif
        </div>
    </section>
@endsection
