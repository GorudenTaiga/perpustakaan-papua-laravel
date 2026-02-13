<div class="login-form-head">
    <h4>{{ $title }}</h4>
    @if(isset($subtitle))
        <p>{{ $subtitle }}</p>
    @endif
</div>

<div class="login-form-body">
    {{ $slot }}
    
    @if(session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger mt-3">
            {{ session('error') }}
        </div>
    @endif
    
    @if(isset($footer))
        <div class="form-footer text-center mt-5">
            {{ $footer }}
        </div>
    @endif
</div>
