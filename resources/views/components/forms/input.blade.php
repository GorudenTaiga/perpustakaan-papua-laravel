<div class="form-gp">
    <label for="{{ $id }}">{{ $label }}</label>
    
    @if($type === 'select')
        <select 
            name="{{ $name }}" 
            id="{{ $id }}"
            {{ $attributes->merge(['class' => 'form-control']) }}
        >
            @foreach($options as $value => $text)
                <option value="{{ $value }}" {{ old($name) == $value ? 'selected' : '' }}>
                    {{ $text }}
                </option>
            @endforeach
        </select>
    @elseif($type === 'file')
        @if(isset($helperText))
            <small class="form-text text-muted d-block mb-2">{{ $helperText }}</small>
        @endif
        <input 
            type="file" 
            name="{{ $name }}" 
            id="{{ $id }}"
            {{ $attributes->merge(['class' => 'form-control']) }}
        >
    @else
        <input 
            type="{{ $type }}" 
            name="{{ $name }}" 
            id="{{ $id }}"
            value="{{ old($name, $value ?? '') }}"
            {{ $attributes->merge(['class' => 'form-control']) }}
        >
    @endif
    
    @if(isset($icon))
        <i class="{{ $icon }}"></i>
    @endif
    
    @error($name)
        <div class="text-danger mt-1">{{ $message }}</div>
    @enderror
</div>
