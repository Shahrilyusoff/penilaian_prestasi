@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="fw-bold">Butiran Pengguna</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Nama</th>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <th>Emel</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th>Peranan</th>
                            <td>
                                @switch($user->peranan)
                                    @case('super_admin')
                                        <span class="badge bg-danger">Super Admin</span>
                                        @break
                                    @case('admin')
                                        <span class="badge bg-primary">Admin</span>
                                        @break
                                    @case('ppp')
                                        <span class="badge bg-info">PPP</span>
                                        @break
                                    @case('ppk')
                                        <span class="badge bg-warning text-dark">PPK</span>
                                        @break
                                    @case('pyd')
                                        <span class="badge bg-success">PYD</span>
                                        @break
                                @endswitch
                            </td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($user->email_verified_at)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Tidak Aktif</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Jawatan</th>
                            <td>{{ $user->jawatan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Gred</th>
                            <td>{{ $user->gred ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Kementerian/Jabatan</th>
                            <td>{{ $user->kementerian_jabatan ?? '-' }}</td>
                        </tr>
                        @if($user->isPYD())
                        <tr>
                            <th>Kumpulan PYD</th>
                            <td>{{ $user->pydGroup->nama_kumpulan ?? '-' }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>

            <div class="d-flex justify-content-end mt-4">
                <a href="{{ route('users.edit', $user) }}" class="btn btn-warning me-2">
                    <i class="fas fa-edit me-1"></i> Edit
                </a>
                @can('delete', $user)
                <form action="{{ route('users.destroy', $user) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Adakah anda pasti?')">
                        <i class="fas fa-trash me-1"></i> Padam
                    </button>
                </form>
                @endcan
            </div>
        </div>
    </div>

    @if($user->isPYD())
    <div class="card shadow mt-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Penilai</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('users.assign-evaluators', $user) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="ppp_id" class="form-label">Pegawai Penilai Pertama (PPP)</label>
                            <select class="form-select @error('ppp_id') is-invalid @enderror" id="ppp_id" name="ppp_id" required>
                                <option value="">-- Pilih PPP --</option>
                                @foreach($ppps as $ppp)
                                    <option value="{{ $ppp->id }}" {{ old('ppp_id', $user->ppp_id) == $ppp->id ? 'selected' : '' }}>
                                        {{ $ppp->name }} ({{ $ppp->jawatan ?? '-' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('ppp_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="ppk_id" class="form-label">Pegawai Penilai Kedua (PPK)</label>
                            <select class="form-select @error('ppk_id') is-invalid @enderror" id="ppk_id" name="ppk_id" required>
                                <option value="">-- Pilih PPK --</option>
                                @foreach($ppks as $ppk)
                                    <option value="{{ $ppk->id }}" {{ old('ppk_id', $user->ppk_id) == $ppk->id ? 'selected' : '' }}>
                                        {{ $ppk->name }} ({{ $ppk->jawatan ?? '-' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('ppk_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Simpan Penilai</button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
@endsection