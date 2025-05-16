<div class="mb-3">
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    <select class="form-select @error($name) is-invalid @enderror" 
            id="{{ $name }}" 
            name="{{ $name }}"
            {{ $required ?? false ? 'required' : '' }}>
        <option value="">-- Sila Pilih --</option>
        @foreach($options as $key => $option)
            <option value="{{ $key }}" {{ old($name, $value ?? '') == $key ? 'selected' : '' }}>
                {{ $option }}
            </option>
        @endforeach
    </select>
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>