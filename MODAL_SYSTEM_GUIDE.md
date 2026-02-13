# 🎨 Modal System Documentation

## Overview
Sistem modal yang reusable dan flexible dengan 3 tipe template (Info, Warning, Danger) dan button yang dapat dikonfigurasi.

---

## 📦 Components

### 1. **Blade Component** (`components/modal-alert.blade.php`)
- Reusable blade component untuk static modals
- Support 3 tipe: `info`, `warning`, `danger`
- Configurable buttons

### 2. **JavaScript System** (`public/js/modal-system.js`)
- Dynamic modal creation
- Modal management (show/close)
- Preset modal functions
- Global `modalSystem` object

---

## 🎯 Usage Examples

### A. Static Modal (Blade Component)

#### Basic Info Modal
```blade
@include('components.modal-alert', [
    'id' => 'infoModal',
    'type' => 'info',
    'title' => 'Information',
    'message' => 'This is an informational message.',
    'buttons' => [
        ['text' => 'OK', 'dismiss' => true, 'class' => 'primary']
    ]
])
```

#### Warning Modal with 2 Buttons
```blade
@include('components.modal-alert', [
    'id' => 'deleteWarning',
    'type' => 'warning',
    'title' => 'Confirm Deletion',
    'message' => 'Are you sure you want to delete this item?',
    'details' => 'This action cannot be undone.',
    'buttons' => [
        ['text' => 'Delete', 'href' => '/delete/123', 'class' => 'danger'],
        ['text' => 'Cancel', 'dismiss' => true, 'class' => 'secondary']
    ]
])
```

#### Danger/Restriction Modal
```blade
@include('components.modal-alert', [
    'id' => 'accessDenied',
    'type' => 'danger',
    'title' => 'Access Denied',
    'message' => 'You do not have permission to access this feature.',
    'details' => 'Please contact the administrator for assistance.',
    'buttons' => [
        ['text' => 'Contact Admin', 'href' => '/contact', 'class' => 'primary'],
        ['text' => 'Close', 'dismiss' => true, 'class' => 'secondary']
    ]
])
```

#### Modal with onclick Handler
```blade
@include('components.modal-alert', [
    'id' => 'confirmAction',
    'type' => 'warning',
    'title' => 'Confirm Action',
    'message' => 'Do you want to proceed?',
    'buttons' => [
        [
            'text' => 'Confirm', 
            'onclick' => 'handleConfirm(); modalSystem.close("confirmAction");', 
            'class' => 'primary'
        ],
        ['text' => 'Cancel', 'dismiss' => true, 'class' => 'secondary']
    ]
])
```

### B. Dynamic Modal (JavaScript)

#### Show Login Required
```javascript
window.modalSystem.showLoginRequired();
// Preset modal dengan tombol Login dan Cancel
```

#### Show Member Only
```javascript
window.modalSystem.showMemberOnly();
// Preset modal untuk fitur khusus member
```

#### Show Success Message
```javascript
window.modalSystem.showSuccess(
    'Operation completed successfully!',
    'Your changes have been saved.'
);
```

#### Show Error Message
```javascript
window.modalSystem.showError(
    'An error occurred',
    'Please try again later.'
);
```

#### Show Warning Message
```javascript
window.modalSystem.showWarning(
    'This action requires confirmation',
    'Please review the details before proceeding.'
);
```

#### Custom Dynamic Modal
```javascript
window.modalSystem.showAlert({
    type: 'warning',  // info, warning, danger
    title: 'Custom Warning',
    message: 'This is a custom warning message',
    details: 'Additional details can be provided here',
    buttons: [
        { text: 'Proceed', href: '/proceed', class: 'primary' },
        { text: 'Go Back', href: '/back', class: 'secondary' },
        { text: 'Cancel', dismiss: true, class: 'secondary' }
    ]
});
```

---

## 🎨 Modal Types

### 1. Info Modal (`type: 'info'`)
**Color:** Blue/Indigo
**Use Cases:**
- General information
- Success messages
- Notifications
- Confirmations

**Example:**
```javascript
window.modalSystem.showSuccess(
    'Profile updated successfully!',
    'Your changes are now visible to others.'
);
```

### 2. Warning Modal (`type: 'warning'`)
**Color:** Yellow/Orange
**Use Cases:**
- Confirmation required
- Important notices
- Potentially destructive actions
- Login/authentication required

**Example:**
```javascript
window.modalSystem.showLoginRequired();
```

### 3. Danger Modal (`type: 'danger'`)
**Color:** Red/Pink
**Use Cases:**
- Access denied
- Error messages
- Critical warnings
- Restriction notices

**Example:**
```javascript
window.modalSystem.showMemberOnly();
```

---

## 🔘 Button Configuration

### Button Options

#### 1. Dismiss Button (Close Modal)
```javascript
{ text: 'Close', dismiss: true, class: 'secondary' }
```

#### 2. Link Button (Navigate)
```javascript
{ text: 'Go to Login', href: '/login', class: 'primary' }
```

#### 3. Action Button (Execute Function)
```javascript
{ 
    text: 'Confirm', 
    onclick: 'myFunction()', 
    class: 'primary' 
}
```

### Button Classes
- **`primary`**: Gradient indigo-purple (main action)
- **`danger`**: Gradient red-pink (destructive action)
- **`secondary`**: Gray (cancel/dismiss)

---

## 🎬 JavaScript API

### Show Modal
```javascript
modalSystem.show('modalId');
```

### Close Modal
```javascript
modalSystem.close('modalId');
```

### Create Dynamic Modal
```javascript
modalSystem.showAlert({
    type: 'info',
    title: 'Title',
    message: 'Message',
    details: 'Optional details',
    buttons: [...]
});
```

### Preset Functions
```javascript
modalSystem.showLoginRequired()
modalSystem.showMemberOnly()
modalSystem.showSuccess(message, details)
modalSystem.showError(message, details)
modalSystem.showWarning(message, details)
```

---

## 💡 Best Practices

### 1. Choose Appropriate Type
- Use **info** for neutral/positive messages
- Use **warning** for actions requiring confirmation
- Use **danger** for errors and restrictions

### 2. Button Configuration
- Maximum 2-3 buttons for clarity
- Primary action on the right
- Dismiss/Cancel on the left

### 3. Message Guidelines
- **Title**: Short and clear (2-5 words)
- **Message**: Brief explanation (1-2 sentences)
- **Details**: Additional context (optional)

### 4. Accessibility
- Modals support ESC key to close
- Overlay click to close
- Keyboard navigation ready

---

## 🔧 Integration Examples

### Example 1: Wishlist System
```javascript
@guest
    window.modalSystem.showLoginRequired();
    return;
@endguest

@auth
    @if(Auth::user()->role !== 'member')
        window.modalSystem.showMemberOnly();
        return;
    @endif
@endauth
```

### Example 2: Form Validation
```javascript
if (!validateForm()) {
    window.modalSystem.showAlert({
        type: 'warning',
        title: 'Form Incomplete',
        message: 'Please fill in all required fields.',
        details: 'Fields marked with * are mandatory.',
        buttons: [
            { text: 'OK', dismiss: true, class: 'primary' }
        ]
    });
    return;
}
```

### Example 3: Delete Confirmation
```javascript
function confirmDelete(id) {
    window.modalSystem.showAlert({
        type: 'danger',
        title: 'Confirm Deletion',
        message: 'Are you sure you want to delete this item?',
        details: 'This action cannot be undone.',
        buttons: [
            { 
                text: 'Delete', 
                onclick: `deleteItem(${id}); modalSystem.close('modal-${Date.now()}');`, 
                class: 'danger' 
            },
            { text: 'Cancel', dismiss: true, class: 'secondary' }
        ]
    });
}
```

### Example 4: Session Expired
```javascript
if (!contentType || !contentType.includes("application/json")) {
    window.modalSystem.showAlert({
        type: 'danger',
        title: 'Session Expired',
        message: 'Your session has expired. Please login again.',
        buttons: [
            { text: 'Login', href: '/login', class: 'primary' },
            { text: 'Cancel', dismiss: true, class: 'secondary' }
        ]
    });
    return;
}
```

---

## 🎨 Customization

### Modal Styling
All modals use Tailwind CSS classes and can be customized in:
- `components/modal-alert.blade.php` (Blade component)
- `public/js/modal-system.js` (JavaScript system)

### Animation
- Duration: 300ms
- Effects: Opacity + Scale transform
- Smooth transitions

### Colors
- **Info**: Blue (#3B82F6) → Indigo (#6366F1)
- **Warning**: Yellow (#F59E0B) → Orange (#F97316)
- **Danger**: Red (#EF4444) → Pink (#EC4899)

---

## 🚀 Quick Start

### 1. Include Modal System
In your main layout (`main_member.blade.php`):
```blade
<script src="{{ asset('js/modal-system.js') }}"></script>
```

### 2. Use in Your Page
```javascript
// Simple usage
window.modalSystem.showLoginRequired();

// Custom usage
window.modalSystem.showAlert({
    type: 'warning',
    title: 'My Title',
    message: 'My message',
    buttons: [
        { text: 'Confirm', href: '/url', class: 'primary' },
        { text: 'Cancel', dismiss: true, class: 'secondary' }
    ]
});
```

---

## 📝 Notes

- Modals are responsive (mobile-friendly)
- Auto-cleanup for dynamic modals
- Support multiple modals (stacked)
- Prevent body scroll when modal is open
- ESC key and overlay click to close
- Smooth animations

---

## 🎉 Features

✅ 3 pre-styled types (Info, Warning, Danger)
✅ Configurable buttons (0-3+)
✅ Link buttons (href)
✅ Action buttons (onclick)
✅ Dismiss buttons
✅ Optional details section
✅ Responsive design
✅ Smooth animations
✅ Keyboard support (ESC)
✅ Overlay click to close
✅ Auto-cleanup for dynamic modals
✅ Global modalSystem object
✅ Preset functions for common cases

---

**Happy Coding! 🚀**
