@extends('main_member')

@section('content')
<section class="py-12 bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            {{-- Header --}}
            <div class="bg-white rounded-3xl shadow-xl p-8 mb-8 border border-gray-200">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Modal System Demo</h1>
                <p class="text-gray-600">Click the buttons below to see different modal types in action.</p>
            </div>

            {{-- Modal Buttons Grid --}}
            <div class="grid md:grid-cols-2 gap-6">
                {{-- Info Modals --}}
                <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-200">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Info Modals</h3>
                    </div>
                    <div class="space-y-3">
                        <button onclick="window.modalSystem.showSuccess('Operation completed!', 'Everything went smoothly.')"
                                class="w-full px-4 py-3 bg-blue-50 text-blue-700 rounded-xl hover:bg-blue-100 transition-colors font-medium text-left">
                            Show Success Message
                        </button>
                        <button onclick="window.modalSystem.show('staticInfoModal')"
                                class="w-full px-4 py-3 bg-blue-50 text-blue-700 rounded-xl hover:bg-blue-100 transition-colors font-medium text-left">
                            Show Static Info Modal
                        </button>
                    </div>
                </div>

                {{-- Warning Modals --}}
                <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-200">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Warning Modals</h3>
                    </div>
                    <div class="space-y-3">
                        <button onclick="window.modalSystem.showLoginRequired()"
                                class="w-full px-4 py-3 bg-yellow-50 text-yellow-700 rounded-xl hover:bg-yellow-100 transition-colors font-medium text-left">
                            Show Login Required
                        </button>
                        <button onclick="window.modalSystem.showWarning('This is a warning', 'Please be careful.')"
                                class="w-full px-4 py-3 bg-yellow-50 text-yellow-700 rounded-xl hover:bg-yellow-100 transition-colors font-medium text-left">
                            Show Warning Message
                        </button>
                        <button onclick="window.modalSystem.show('deleteConfirmModal')"
                                class="w-full px-4 py-3 bg-yellow-50 text-yellow-700 rounded-xl hover:bg-yellow-100 transition-colors font-medium text-left">
                            Show Delete Confirmation
                        </button>
                    </div>
                </div>

                {{-- Danger Modals --}}
                <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-200">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Danger Modals</h3>
                    </div>
                    <div class="space-y-3">
                        <button onclick="window.modalSystem.showMemberOnly()"
                                class="w-full px-4 py-3 bg-red-50 text-red-700 rounded-xl hover:bg-red-100 transition-colors font-medium text-left">
                            Show Members Only
                        </button>
                        <button onclick="window.modalSystem.showError('An error occurred', 'Please try again later.')"
                                class="w-full px-4 py-3 bg-red-50 text-red-700 rounded-xl hover:bg-red-100 transition-colors font-medium text-left">
                            Show Error Message
                        </button>
                        <button onclick="window.modalSystem.show('accessDeniedModal')"
                                class="w-full px-4 py-3 bg-red-50 text-red-700 rounded-xl hover:bg-red-100 transition-colors font-medium text-left">
                            Show Access Denied
                        </button>
                    </div>
                </div>

                {{-- Custom Modals --}}
                <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-200">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Custom Modals</h3>
                    </div>
                    <div class="space-y-3">
                        <button onclick="showCustomModal()"
                                class="w-full px-4 py-3 bg-purple-50 text-purple-700 rounded-xl hover:bg-purple-100 transition-colors font-medium text-left">
                            Show Custom Dynamic Modal
                        </button>
                        <button onclick="window.modalSystem.show('customStaticModal')"
                                class="w-full px-4 py-3 bg-purple-50 text-purple-700 rounded-xl hover:bg-purple-100 transition-colors font-medium text-left">
                            Show Custom Static Modal
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Static Modals --}}
@include('components.modal-alert', [
    'id' => 'staticInfoModal',
    'type' => 'info',
    'title' => 'Information',
    'message' => 'This is a static info modal created using Blade component.',
    'details' => 'You can include this modal in your blade template and show it programmatically.',
    'buttons' => [
        ['text' => 'Got it!', 'dismiss' => true, 'class' => 'primary']
    ]
])

@include('components.modal-alert', [
    'id' => 'deleteConfirmModal',
    'type' => 'warning',
    'title' => 'Confirm Deletion',
    'message' => 'Are you sure you want to delete this item?',
    'details' => 'This action cannot be undone. All associated data will be permanently removed.',
    'buttons' => [
        ['text' => 'Delete', 'onclick' => 'alert("Item deleted!"); modalSystem.close("deleteConfirmModal");', 'class' => 'danger'],
        ['text' => 'Cancel', 'dismiss' => true, 'class' => 'secondary']
    ]
])

@include('components.modal-alert', [
    'id' => 'accessDeniedModal',
    'type' => 'danger',
    'title' => 'Access Denied',
    'message' => 'You do not have permission to access this resource.',
    'details' => 'This feature is restricted to administrators only. Please contact support if you need access.',
    'buttons' => [
        ['text' => 'Contact Support', 'href' => '#', 'class' => 'primary'],
        ['text' => 'Close', 'dismiss' => true, 'class' => 'secondary']
    ]
])

@include('components.modal-alert', [
    'id' => 'customStaticModal',
    'type' => 'info',
    'title' => 'Custom Configuration',
    'message' => 'This modal demonstrates all available configuration options.',
    'details' => 'You can customize type, title, message, details, and buttons.',
    'buttons' => [
        ['text' => 'Learn More', 'href' => '/modal-system-guide', 'class' => 'primary'],
        ['text' => 'Close', 'dismiss' => true, 'class' => 'secondary']
    ]
])
@endsection

@section('js')
<script>
    function showCustomModal() {
        window.modalSystem.showAlert({
            type: 'warning',
            title: 'Custom Dynamic Modal',
            message: 'This modal is created dynamically using JavaScript.',
            details: 'You can pass configuration options to create modals on-the-fly without pre-defining them in your Blade template.',
            buttons: [
                { text: 'Awesome!', dismiss: true, class: 'primary' },
                { text: 'Show Another', onclick: 'showCustomModal()', class: 'secondary' }
            ]
        });
    }
</script>
@endsection
