@extends('layouts.auth')

@section('title', 'Log Masuk Sistem Penilaian Prestasi')

@section('content')
<div class="container-fluid vh-100">
    <div class="row h-100">
        <!-- Left Side with Image -->
        <div class="col-md-6 d-none d-md-block p-0">
            <div class="login-image h-100" style="background-image: url('{{ asset('images/backikma.jpg') }}');">
                <div class="login-overlay d-flex align-items-center justify-content-center">
                    <div class="text-center text-white px-5">
                        <h1 class="display-4 fw-bold mb-4">Institut Koperasi Malaysia</h1>
                        <p class="lead">Sistem Penilaian Prestasi</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side with Login Form -->
        <div class="col-md-6 d-flex align-items-center justify-content-center">
            <div class="w-100 px-4 py-5" style="max-width: 500px;">
                <div class="text-center mb-5">
                    <img src="{{ asset('images/logoikma.png') }}" alt="Logo" class="mb-4" style="height: 80px;">
                    <h2 class="h4 text-gray-900 mb-4">Log Masuk ke Akaun Anda</h2>
                </div>

                <form method="POST" action="{{ route('login') }}" class="user">
                    @csrf

                    <div class="mb-4">
                        <input type="email" class="form-control form-control-user @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email') }}" 
                               placeholder="Masukkan Alamat Emel" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <input type="password" class="form-control form-control-user @error('password') is-invalid @enderror" 
                               id="password" name="password" placeholder="Kata Laluan" required autocomplete="current-password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                Ingat Saya
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-user btn-block">
                        Log Masuk
                    </button>
                </form>

                <hr>

                <div class="text-center">
                    @if (Route::has('password.request'))
                        <a class="small" href="{{ route('password.request') }}">Lupa Kata Laluan?</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection