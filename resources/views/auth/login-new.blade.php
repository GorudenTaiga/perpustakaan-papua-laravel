@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<form method="POST" action="{{ route('postLogin') }}">
    @csrf
    
    <x-auth.card 
        title="Login" 
        subtitle="Selamat datang di Perpustakaan Daerah"
    >
        {{-- Email --}}
        <x-forms.input
            type="email"
            name="email"
            id="exampleInputEmail1"
            label="Email"
            icon="ti-email"
            required
        />

        {{-- Password --}}
        <x-forms.input
            type="password"
            name="password"
            id="exampleInputPassword1"
            label="Password"
            icon="ti-lock"
            required
        />

        {{-- Submit Button --}}
        <div class="submit-btn-area">
            <button id="form_submit" type="submit" class="btn btn-primary btn-block">
                Login <i class="ti-arrow-right"></i>
            </button>
        </div>

        {{-- Footer Slot --}}
        <x-slot name="footer">
            <p class="text-muted">
                Belum memiliki akun? 
                <a href="{{ route('register') }}">Daftar</a>
            </p>
        </x-slot>
    </x-auth.card>
</form>
@endsection

@push('scripts')
<script>
    // Toggle password visibility
    document.addEventListener('DOMContentLoaded', function() {
        const passwordInput = document.getElementById('exampleInputPassword1');
        const passwordIcon = passwordInput?.nextElementSibling;
        
        if (passwordIcon) {
            passwordIcon.style.cursor = 'pointer';
            passwordIcon.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                if (this.classList.contains('ti-lock')) {
                    this.classList.remove('ti-lock');
                    this.classList.add('ti-unlock');
                } else {
                    this.classList.remove('ti-unlock');
                    this.classList.add('ti-lock');
                }
            });
        }
    });
</script>
@endpush
