@extends('layouts.auth')

@section('title', 'Log Masuk Sistem Penilaian Prestasi')

@section('content')
<div class="login-container">
    <div class="login-card">
        <div class="login-header">
            <div class="login-logo">
                <img src="{{ asset('images/logoikma.png') }}" alt="Institut Koperasi Malaysia">
            </div>
            <h2 class="login-title">SISTEM PENILAIAN PRESTASI</h2>
            <p class="login-subtitle">Institut Koperasi Malaysia</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="login-form">
            @csrf

            <div class="form-group">
                <label for="email" class="form-label">
                    <i class="fas fa-envelope"></i> Alamat Emel
                </label>
                <div class="input-group">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                           name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                           placeholder="cth: nama@ikmal.edu.my">
                </div>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">
                    <i class="fas fa-lock"></i> Kata Laluan
                </label>
                <div class="input-group">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                           name="password" required autocomplete="current-password" placeholder="Masukkan kata laluan">
                    <button type="button" class="password-toggle" onclick="togglePassword()">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-options">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">Ingat Saya</label>
                </div>
                @if (Route::has('password.request'))
                    <a class="forgot-password" href="{{ route('password.request') }}">
                        Lupa Kata Laluan?
                    </a>
                @endif
            </div>

            <div class="form-submit">
                <button type="submit" class="btn btn-login">
                    <i class="fas fa-sign-in-alt"></i> LOG MASUK
                </button>
            </div>
        </form>

        <div class="login-footer">
            <p>Versi Sistem: {{ config('app.version', '1.0.0') }}</p>
            <p>&copy; {{ date('Y') }} Institut Koperasi Malaysia. Hak Cipta Terpelihara.</p>
        </div>
    </div>
</div>

<script>
function togglePassword() {
    const password = document.getElementById('password');
    const toggle = document.querySelector('.password-toggle i');
    
    if (password.type === 'password') {
        password.type = 'text';
        toggle.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        password.type = 'password';
        toggle.classList.replace('fa-eye-slash', 'fa-eye');
    }
}
</script>
@endsection