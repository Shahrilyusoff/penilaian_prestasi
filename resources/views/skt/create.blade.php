@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2 class="fw-bold">Tambah SKT Baharu</h2>
            <p class="text-muted">Admin hanya perlu menetapkan tempoh penilaian, PYD dan PPP. PYD akan mengisi aktiviti dan petunjuk prestasi kemudian.</p>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('skt.store') }}" method="POST">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="evaluation_period_id" class="form-label">Tempoh Penilaian *</label>
                            <select class="form-select @error('evaluation_period_id') is-invalid @enderror" 
                                    id="evaluation_period_id" 
                                    name="evaluation_period_id" required>
                                <option value="">-- Pilih Tempoh Penilaian --</option>
                                @foreach($periods as $period)
                                    <option value="{{ $period->id }}" {{ old('evaluation_period_id') == $period->id ? 'selected' : '' }}>
                                        {{ $period->tahun }} 
                                        ({{ $period->tarikh_mula?->format('d/m/Y') ?? 'Tarikh mula tiada' }} 
                                        - 
                                        {{ $period->tarikh_tamat?->format('d/m/Y') ?? 'Tarikh tamat tiada' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('evaluation_period_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="pyd_id" class="form-label">Pegawai Yang Dinilai (PYD) *</label>
                            <select class="form-select @error('pyd_id') is-invalid @enderror" 
                                    id="pyd_id" 
                                    name="pyd_id" required>
                                <option value="">-- Pilih PYD --</option>
                                @foreach($pyds as $pyd)
                                    <option value="{{ $pyd->id }}" {{ old('pyd_id') == $pyd->id ? 'selected' : '' }}>
                                        {{ $pyd->name }} ({{ $pyd->jawatan }} - {{ $pyd->gred }})
                                    </option>
                                @endforeach
                            </select>
                            @error('pyd_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ppp_id" class="form-label">Pegawai Penilai Pertama (PPP) *</label>
                            <select class="form-select @error('ppp_id') is-invalid @enderror" 
                                    id="ppp_id" 
                                    name="ppp_id" required>
                                <option value="">-- Pilih PPP --</option>
                                @foreach($ppps as $ppp)
                                    <option value="{{ $ppp->id }}" {{ old('ppp_id') == $ppp->id ? 'selected' : '' }}>
                                        {{ $ppp->name }} ({{ $ppp->jawatan }})
                                    </option>
                                @endforeach
                            </select>
                            @error('ppp_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Aktiviti/Projek dan Petunjuk Prestasi akan diisi oleh Pegawai Yang Dinilai (PYD) selepas SKT ini dibuat.
                </div>

                <div class="row mt-4">
                    <div class="col-md-12 text-end">
                        <a href="{{ route('skt.index') }}" class="btn btn-secondary me-2">
                            <i class="fas fa-times me-1"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Simpan SKT
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection