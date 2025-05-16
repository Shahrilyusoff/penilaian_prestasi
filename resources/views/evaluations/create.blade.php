@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="fw-bold">Tambah Penilaian Prestasi</h2>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('evaluations.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="evaluation_period_id" class="form-label">Tempoh Penilaian</label>
                            <select class="form-select @error('evaluation_period_id') is-invalid @enderror" 
                                    id="evaluation_period_id" name="evaluation_period_id" required>
                                <option value="">-- Pilih Tempoh --</option>
                                @foreach($periods as $period)
                                    <option value="{{ $period->id }}" {{ old('evaluation_period_id') == $period->id ? 'selected' : '' }}>
                                        {{ $period->tahun }} ({{ $period->tarikh_mula->format('d/m/Y') }} - {{ $period->tarikh_tamat->format('d/m/Y') }})
                                    </option>
                                @endforeach
                            </select>
                            @error('evaluation_period_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="pyd_id" class="form-label">Pegawai Yang Dinilai (PYD)</label>
                            <select class="form-select @error('pyd_id') is-invalid @enderror" 
                                    id="pyd_id" name="pyd_id" required>
                                <option value="">-- Pilih PYD --</option>
                                @foreach($pyds as $pyd)
                                    <option value="{{ $pyd->id }}" {{ old('pyd_id') == $pyd->id ? 'selected' : '' }}>
                                        {{ $pyd->name }} ({{ $pyd->jawatan ?? '-' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('pyd_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="ppp_id" class="form-label">Pegawai Penilai Pertama (PPP)</label>
                            <select class="form-select @error('ppp_id') is-invalid @enderror" 
                                    id="ppp_id" name="ppp_id" required>
                                <option value="">-- Pilih PPP --</option>
                                @foreach($ppps as $ppp)
                                    <option value="{{ $ppp->id }}" {{ old('ppp_id') == $ppp->id ? 'selected' : '' }}>
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
                            <select class="form-select @error('ppk_id') is-invalid @enderror" 
                                    id="ppk_id" name="ppk_id" required>
                                <option value="">-- Pilih PPK --</option>
                                @foreach($ppks as $ppk)
                                    <option value="{{ $ppk->id }}" {{ old('ppk_id') == $ppk->id ? 'selected' : '' }}>
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
                    <button type="submit" class="btn btn-primary me-2">Simpan</button>
                    <a href="{{ route('evaluations.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection