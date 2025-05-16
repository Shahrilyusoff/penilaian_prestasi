@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="fw-bold">Kemaskini Pengguna</h2>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email" class="form-label">Emel</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="password" class="form-label">Kata Laluan (Biarkan kosong jika tidak mahu ubah)</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Sahkan Kata Laluan</label>
                            <input type="password" class="form-control" 
                                   id="password_confirmation" name="password_confirmation">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="peranan" class="form-label">Peranan</label>
                            <select class="form-select @error('peranan') is-invalid @enderror" id="peranan" name="peranan" required>
                                <option value="">-- Pilih Peranan --</option>
                                <option value="super_admin" {{ old('peranan', $user->peranan) == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                                <option value="admin" {{ old('peranan', $user->peranan) == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="ppp" {{ old('peranan', $user->peranan) == 'ppp' ? 'selected' : '' }}>PPP</option>
                                <option value="ppk" {{ old('peranan', $user->peranan) == 'ppk' ? 'selected' : '' }}>PPK</option>
                                <option value="pyd" {{ old('peranan', $user->peranan) == 'pyd' ? 'selected' : '' }}>PYD</option>
                            </select>
                            @error('peranan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3" id="pyd-group-container">
                            <label for="pyd_group_id" class="form-label">Kumpulan PYD</label>
                            <select class="form-select @error('pyd_group_id') is-invalid @enderror" id="pyd_group_id" name="pyd_group_id">
                                <option value="">-- Pilih Kumpulan --</option>
                                @foreach($groups as $group)
                                    <option value="{{ $group->id }}" {{ old('pyd_group_id', $user->pyd_group_id) == $group->id ? 'selected' : '' }}>
                                        {{ $group->nama_kumpulan }}
                                    </option>
                                @endforeach
                            </select>
                            @error('pyd_group_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="jawatan" class="form-label">Jawatan</label>
                            <input type="text" class="form-control @error('jawatan') is-invalid @enderror" 
                                   id="jawatan" name="jawatan" value="{{ old('jawatan', $user->jawatan) }}">
                            @error('jawatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="gred" class="form-label">Gred</label>
                            <input type="text" class="form-control @error('gred') is-invalid @enderror" 
                                   id="gred" name="gred" value="{{ old('gred', $user->gred) }}">
                            @error('gred')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="kementerian_jabatan" class="form-label">Kementerian/Jabatan</label>
                    <input type="text" class="form-control @error('kementerian_jabatan') is-invalid @enderror" 
                           id="kementerian_jabatan" name="kementerian_jabatan" value="{{ old('kementerian_jabatan', $user->kementerian_jabatan) }}">
                    @error('kementerian_jabatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary me-2">Kemaskini</button>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('peranan').addEventListener('change', function() {
        const pydGroupContainer = document.getElementById('pyd-group-container');
        if (this.value === 'pyd') {
            pydGroupContainer.style.display = 'block';
        } else {
            pydGroupContainer.style.display = 'none';
        }
    });

    // Initialize visibility on page load
    document.addEventListener('DOMContentLoaded', function() {
        const peranan = document.getElementById('peranan').value;
        const pydGroupContainer = document.getElementById('pyd-group-container');
        if (peranan !== 'pyd') {
            pydGroupContainer.style.display = 'none';
        }
    });
</script>
@endsection