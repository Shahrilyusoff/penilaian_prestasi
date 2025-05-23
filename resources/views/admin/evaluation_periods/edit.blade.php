@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2 class="fw-bold">Kemaskini Tempoh Penilaian</h2>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <form method="POST" action="{{ route('evaluation-periods.update', $evaluationPeriod) }}">
                @csrf
                @method('PUT')
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="jenis" class="form-label">Jenis Penilaian</label>
                        <select class="form-select @error('jenis') is-invalid @enderror" id="jenis" name="jenis" required disabled>
                            <option value="skt" {{ $evaluationPeriod->jenis === 'skt' ? 'selected' : '' }}>SKT</option>
                            <option value="penilaian" {{ $evaluationPeriod->jenis === 'penilaian' ? 'selected' : '' }}>Penilaian Prestasi</option>
                        </select>
                        @error('jenis')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="tahun" class="form-label">Tahun</label>
                        <input type="number" class="form-control @error('tahun') is-invalid @enderror" 
                               id="tahun" name="tahun" value="{{ old('tahun', $evaluationPeriod->tahun) }}" 
                               min="{{ date('Y') }}" required readonly>
                        @error('tahun')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <!-- SKT Fields -->
                @if($evaluationPeriod->jenis === 'skt')
                <div id="skt-fields">
                    <h5 class="mb-3">Tempoh SKT</h5>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="tarikh_mula_awal" class="form-label">Tarikh Mula Awal Tahun</label>
                            <input type="date" class="form-control @error('tarikh_mula_awal') is-invalid @enderror" 
                                   id="tarikh_mula_awal" name="tarikh_mula_awal" 
                                   value="{{ old('tarikh_mula_awal', $evaluationPeriod->tarikh_mula_awal->format('Y-m-d')) }}">
                            @error('tarikh_mula_awal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="tarikh_tamat_awal" class="form-label">Tarikh Tamat Awal Tahun</label>
                            <input type="date" class="form-control @error('tarikh_tamat_awal') is-invalid @enderror" 
                                   id="tarikh_tamat_awal" name="tarikh_tamat_awal" 
                                   value="{{ old('tarikh_tamat_awal', $evaluationPeriod->tarikh_tamat_awal->format('Y-m-d')) }}">
                            @error('tarikh_tamat_awal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="tarikh_mula_pertengahan" class="form-label">Tarikh Mula Pertengahan Tahun</label>
                            <input type="date" class="form-control @error('tarikh_mula_pertengahan') is-invalid @enderror" 
                                   id="tarikh_mula_pertengahan" name="tarikh_mula_pertengahan" 
                                   value="{{ old('tarikh_mula_pertengahan', $evaluationPeriod->tarikh_mula_pertengahan->format('Y-m-d')) }}">
                            @error('tarikh_mula_pertengahan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="tarikh_tamat_pertengahan" class="form-label">Tarikh Tamat Pertengahan Tahun</label>
                            <input type="date" class="form-control @error('tarikh_tamat_pertengahan') is-invalid @enderror" 
                                   id="tarikh_tamat_pertengahan" name="tarikh_tamat_pertengahan" 
                                   value="{{ old('tarikh_tamat_pertengahan', $evaluationPeriod->tarikh_tamat_pertengahan->format('Y-m-d')) }}">
                            @error('tarikh_tamat_pertengahan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="tarikh_mula_akhir" class="form-label">Tarikh Mula Akhir Tahun</label>
                            <input type="date" class="form-control @error('tarikh_mula_akhir') is-invalid @enderror" 
                                   id="tarikh_mula_akhir" name="tarikh_mula_akhir" 
                                   value="{{ old('tarikh_mula_akhir', $evaluationPeriod->tarikh_mula_akhir->format('Y-m-d')) }}">
                            @error('tarikh_mula_akhir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="tarikh_tamat_akhir" class="form-label">Tarikh Tamat Akhir Tahun</label>
                            <input type="date" class="form-control @error('tarikh_tamat_akhir') is-invalid @enderror" 
                                   id="tarikh_tamat_akhir" name="tarikh_tamat_akhir" 
                                   value="{{ old('tarikh_tamat_akhir', $evaluationPeriod->tarikh_tamat_akhir->format('Y-m-d')) }}">
                            @error('tarikh_tamat_akhir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                @endif
                
                <!-- Penilaian Fields -->
                @if($evaluationPeriod->jenis === 'penilaian')
                <div id="penilaian-fields">
                    <h5 class="mb-3">Tempoh Penilaian Prestasi</h5>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="tarikh_mula_penilaian" class="form-label">Tarikh Mula</label>
                            <input type="date" class="form-control @error('tarikh_mula_penilaian') is-invalid @enderror" 
                                   id="tarikh_mula_penilaian" name="tarikh_mula_penilaian" 
                                   value="{{ old('tarikh_mula_penilaian', $evaluationPeriod->tarikh_mula_penilaian->format('Y-m-d')) }}">
                            @error('tarikh_mula_penilaian')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="tarikh_tamat_penilaian" class="form-label">Tarikh Tamat</label>
                            <input type="date" class="form-control @error('tarikh_tamat_penilaian') is-invalid @enderror" 
                                   id="tarikh_tamat_penilaian" name="tarikh_tamat_penilaian" 
                                   value="{{ old('tarikh_tamat_penilaian', $evaluationPeriod->tarikh_tamat_penilaian->format('Y-m-d')) }}">
                            @error('tarikh_tamat_penilaian')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                @endif
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary">Kemaskini</button>
                    <a href="{{ route('evaluation-periods.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection