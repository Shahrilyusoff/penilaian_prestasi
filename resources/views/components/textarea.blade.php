<div class="mb-3">
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    <textarea class="form-control @error($name) is-invalid @enderror" 
              id="{{ $name }}" 
              name="{{ $name }}" 
              rows="{{ $rows ?? 3 }}"
              {{ $required ?? false ? 'required' : '' }}>{{ old($name, $value ?? '') }}</textarea>
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>