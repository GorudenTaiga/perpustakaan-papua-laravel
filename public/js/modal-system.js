/**
 * Modal System for Perpustakaan Papua
 * Dynamic modal creation and management
 */

class ModalSystem {
    constructor() {
        this.activeModal = null;
    }

    /**
     * Show a modal
     * @param {string} id - Modal ID
     */
    show(id) {
        const modal = document.getElementById(id);
        if (!modal) return;

        this.activeModal = modal;
        modal.classList.remove('hidden');
        
        // Trigger animation
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            const content = modal.querySelector('.modal-content');
            if (content) {
                content.classList.remove('scale-95');
                content.classList.add('scale-100');
            }
        }, 10);

        // Prevent body scroll
        document.body.style.overflow = 'hidden';

        // Setup close handlers
        this.setupCloseHandlers(modal);
    }

    /**
     * Close a modal
     * @param {string} id - Modal ID
     */
    close(id) {
        const modal = document.getElementById(id);
        if (!modal) return;

        modal.classList.add('opacity-0');
        const content = modal.querySelector('.modal-content');
        if (content) {
            content.classList.remove('scale-100');
            content.classList.add('scale-95');
        }

        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
            this.activeModal = null;
        }, 300);
    }

    /**
     * Setup close handlers for modal
     * @param {HTMLElement} modal
     */
    setupCloseHandlers(modal) {
        // Close button
        modal.querySelectorAll('.modal-close').forEach(btn => {
            btn.onclick = () => this.close(modal.id);
        });

        // Overlay click
        modal.querySelector('.modal-overlay').onclick = (e) => {
            if (e.target.classList.contains('modal-overlay')) {
                this.close(modal.id);
            }
        };

        // ESC key
        const escHandler = (e) => {
            if (e.key === 'Escape' && this.activeModal === modal) {
                this.close(modal.id);
                document.removeEventListener('keydown', escHandler);
            }
        };
        document.addEventListener('keydown', escHandler);
    }

    /**
     * Create and show a dynamic modal
     * @param {Object} options - Modal configuration
     */
    showAlert(options) {
        const {
            type = 'info', // info, warning, danger
            title = 'Alert',
            message = '',
            details = null,
            buttons = []
        } = options;

        const modalId = 'modal-' + Date.now();
        
        // Create modal HTML
        const modalHTML = this.createModalHTML(modalId, type, title, message, details, buttons);
        
        // Append to body
        document.body.insertAdjacentHTML('beforeend', modalHTML);
        
        // Show modal
        setTimeout(() => this.show(modalId), 10);

        // Auto-remove from DOM after close
        const modal = document.getElementById(modalId);
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (modal.classList.contains('hidden')) {
                    setTimeout(() => {
                        modal.remove();
                        observer.disconnect();
                    }, 500);
                }
            });
        });
        observer.observe(modal, { attributes: true, attributeFilter: ['class'] });
    }

    /**
     * Create modal HTML
     */
    createModalHTML(id, type, title, message, details, buttons) {
        const typeConfig = {
            info: {
                bg: 'from-blue-50 to-indigo-50',
                iconBg: 'bg-blue-100',
                iconColor: 'text-blue-600',
                titleColor: 'text-blue-900',
                icon: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>'
            },
            warning: {
                bg: 'from-yellow-50 to-orange-50',
                iconBg: 'bg-yellow-100',
                iconColor: 'text-yellow-600',
                titleColor: 'text-yellow-900',
                icon: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>'
            },
            danger: {
                bg: 'from-red-50 to-pink-50',
                iconBg: 'bg-red-100',
                iconColor: 'text-red-600',
                titleColor: 'text-red-900',
                icon: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>'
            }
        };

        const config = typeConfig[type] || typeConfig.info;

        return `
        <div id="${id}" class="modal-overlay fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden opacity-0 transition-opacity duration-300">
            <div class="modal-container flex items-center justify-center min-h-screen p-4">
                <div class="modal-content bg-white rounded-3xl shadow-2xl max-w-md w-full transform scale-95 transition-transform duration-300 overflow-hidden">
                    <div class="modal-header p-6 pb-4 bg-gradient-to-r ${config.bg}">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 w-12 h-12 rounded-full flex items-center justify-center ${config.iconBg}">
                                <svg class="w-6 h-6 ${config.iconColor}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    ${config.icon}
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-xl font-bold ${config.titleColor}">${title}</h3>
                            </div>
                            <button type="button" class="modal-close flex-shrink-0 text-gray-400 hover:text-gray-600 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="modal-body p-6">
                        <p class="text-gray-700 leading-relaxed">${message}</p>
                        ${details ? `<div class="mt-4 p-4 bg-gray-50 rounded-xl"><p class="text-sm text-gray-600">${details}</p></div>` : ''}
                    </div>
                    ${buttons.length > 0 ? `
                    <div class="modal-footer p-6 pt-0 flex gap-3 justify-end">
                        ${buttons.map(btn => this.createButtonHTML(btn, id)).join('')}
                    </div>
                    ` : ''}
                </div>
            </div>
        </div>
        `;
    }

    /**
     * Create button HTML
     */
    createButtonHTML(button, modalId) {
        const classes = {
            primary: 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white hover:from-indigo-700 hover:to-purple-700 shadow-lg hover:shadow-xl hover:-translate-y-0.5',
            danger: 'bg-gradient-to-r from-red-600 to-pink-600 text-white hover:from-red-700 hover:to-pink-700 shadow-lg hover:shadow-xl hover:-translate-y-0.5',
            secondary: 'bg-gray-100 text-gray-700 hover:bg-gray-200'
        };

        const btnClass = classes[button.class] || classes.secondary;

        if (button.dismiss) {
            return `<button type="button" class="modal-close px-6 py-3 rounded-xl font-semibold transition-all duration-300 ${btnClass}">${button.text}</button>`;
        } else if (button.href) {
            return `<a href="${button.href}" class="px-6 py-3 rounded-xl font-semibold transition-all duration-300 ${btnClass}">${button.text}</a>`;
        } else if (button.onclick) {
            return `<button type="button" onclick="${button.onclick}" class="px-6 py-3 rounded-xl font-semibold transition-all duration-300 ${btnClass}">${button.text}</button>`;
        }
        return '';
    }

    /**
     * Preset modals
     */
    showLoginRequired() {
        this.showAlert({
            type: 'warning',
            title: 'Login Required',
            message: 'You need to login first to access this feature.',
            details: 'Please login or create a new account to continue.',
            buttons: [
                { text: 'Login Now', href: '/login', class: 'primary' },
                { text: 'Cancel', dismiss: true, class: 'secondary' }
            ]
        });
    }

    showMemberOnly() {
        this.showAlert({
            type: 'danger',
            title: 'Members Only',
            message: 'This feature is only available for library members.',
            details: 'Please register as a member to access this feature.',
            buttons: [
                { text: 'Register', href: '/register', class: 'primary' },
                { text: 'Close', dismiss: true, class: 'secondary' }
            ]
        });
    }

    showSuccess(message, details = null) {
        this.showAlert({
            type: 'info',
            title: 'Success',
            message: message,
            details: details,
            buttons: [
                { text: 'OK', dismiss: true, class: 'primary' }
            ]
        });
    }

    showError(message, details = null) {
        this.showAlert({
            type: 'danger',
            title: 'Error',
            message: message,
            details: details,
            buttons: [
                { text: 'Close', dismiss: true, class: 'secondary' }
            ]
        });
    }

    showWarning(message, details = null) {
        this.showAlert({
            type: 'warning',
            title: 'Warning',
            message: message,
            details: details,
            buttons: [
                { text: 'OK', dismiss: true, class: 'primary' }
            ]
        });
    }
}

// Initialize global modal system
window.modalSystem = new ModalSystem();

// Setup existing modals on page load
document.addEventListener('DOMContentLoaded', () => {
    // Setup close handlers for static modals
    document.querySelectorAll('[id^="modal-"]').forEach(modal => {
        window.modalSystem.setupCloseHandlers(modal);
    });
});
