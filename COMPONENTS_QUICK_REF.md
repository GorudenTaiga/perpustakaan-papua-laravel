# 🎨 BLADE COMPONENTS - QUICK REFERENCE

## 📚 Available Components

### 1. Layout: Auth
```blade
@extends('layouts.auth')
@section('title', 'Page Title')
@section('content')
    <!-- Your content -->
@endsection
```

### 2. Auth Card
```blade
<x-auth.card title="Card Title" subtitle="Optional subtitle">
    <!-- Form content -->
    
    <x-slot name="footer">
        <!-- Footer links -->
    </x-slot>
</x-auth.card>
```

### 3. Form Input - Text
```blade
<x-forms.input
    type="text"
    name="username"
    label="Username"
    icon="ti-user"
    required
/>
```

### 4. Form Input - Email
```blade
<x-forms.input
    type="email"
    name="email"
    label="Email Address"
    icon="ti-email"
    required
/>
```

### 5. Form Input - Password
```blade
<x-forms.input
    type="password"
    name="password"
    label="Password"
    icon="ti-lock"
    required
/>
```

### 6. Form Input - File
```blade
<x-forms.input
    type="file"
    name="document"
    label="Upload Document"
    helperText="Max 2MB, PDF/JPG/PNG only"
    accept=".pdf,.jpg,.jpeg,.png"
    icon="ti-file"
/>
```

### 7. Form Input - Select
```blade
<x-forms.input
    type="select"
    name="role"
    label="Select Role"
    icon="ti-user"
    :options="[
        'admin' => 'Administrator',
        'user' => 'User',
        'guest' => 'Guest'
    ]"
    required
/>
```

---

## 🎯 Complete Example - Register Form

```blade
@extends('layouts.auth')

@section('title', 'Register')

@section('content')
<form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
    @csrf
    
    <x-auth.card 
        title="Create Account" 
        subtitle="Join our library today"
    >
        {{-- Name --}}
        <x-forms.input
            type="text"
            name="name"
            label="Full Name"
            icon="ti-user"
            required
        />

        {{-- Email --}}
        <x-forms.input
            type="email"
            name="email"
            label="Email"
            icon="ti-email"
            required
        />

        {{-- Password --}}
        <x-forms.input
            type="password"
            name="password"
            label="Password"
            icon="ti-lock"
            required
        />

        {{-- User Type --}}
        <x-forms.input
            type="select"
            name="user_type"
            label="I am a..."
            icon="ti-id-badge"
            :options="[
                'student' => 'Student',
                'teacher' => 'Teacher',
                'public' => 'General Public'
            ]"
            required
        />

        {{-- Document --}}
        <x-forms.input
            type="file"
            name="document"
            label="Supporting Document"
            helperText="Upload ID or student card (Max 2MB)"
            accept=".pdf,.jpg,.jpeg,.png"
            icon="ti-file"
        />

        {{-- Submit --}}
        <div class="submit-btn-area">
            <button type="submit" class="btn btn-primary btn-block">
                Register <i class="ti-arrow-right"></i>
            </button>
        </div>

        {{-- Footer --}}
        <x-slot name="footer">
            <p class="text-muted">
                Already have an account? 
                <a href="{{ route('login') }}">Login</a>
            </p>
        </x-slot>
    </x-auth.card>
</form>
@endsection

@push('scripts')
<script>
    // Custom JavaScript here
    console.log('Register page loaded');
</script>
@endpush
```

---

## ✨ Features

- ✅ Auto validation error display
- ✅ Old input persistence
- ✅ Icon support
- ✅ Helper text
- ✅ Consistent styling
- ✅ Responsive
- ✅ Accessible

---

## 📖 Props Reference

### Input Component Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `type` | string | 'text' | Input type: text, email, password, file, select |
| `name` | string | required | Input name attribute |
| `id` | string | auto | Input id (auto from name if not provided) |
| `label` | string | required | Field label |
| `icon` | string | null | Icon class (ti-user, ti-email, etc) |
| `helperText` | string | null | Helper text below field |
| `value` | mixed | null | Default value |
| `options` | array | [] | Options for select type |

### Auth Card Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `title` | string | required | Card title |
| `subtitle` | string | null | Card subtitle |

---

## 🎨 Styling

Components use existing CSS classes. To customize:

```blade
<x-forms.input
    type="text"
    name="username"
    label="Username"
    class="custom-class"
    placeholder="Enter username"
    data-custom="value"
/>
```

---

**Quick Access:** Just copy-paste the examples above! 🚀
