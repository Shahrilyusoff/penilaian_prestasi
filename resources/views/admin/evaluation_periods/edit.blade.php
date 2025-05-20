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
            <form action="{{ route('evaluation-periods.update', $evaluationPeriod) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tahun" class="form-label">Tahun</label>
                            <input type="text" class="form-control @error('tahun') is-invalid @enderror" 
                                   id="tahun" name="tahun" value="{{ old('tahun', $evaluationPeriod->tahun) }}" required>
                            @error('tahun')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tarikh_mula" class="form-label">Tarikh Mula</label>
                            <input type="date" class="form-control @error('tarikh_mula') is-invalid @enderror" 
                                   id="tarikh_mula" name="tarikh_mula" 
                                   value="{{ old('tarikh_mula', $evaluationPeriod->tarikh_mula->format('Y-m-d')) }}" required>
                            @error('tarikh_mula')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tarikh_tamat" class="form-label">Tarikh Tamat</label>
                            <input type="date" class="form-control @error('tarikh_tamat') is-invalid @enderror" 
                                   id="tarikh_tamat" name="tarikh_tamat" 
                                   value="{{ old('tarikh_tamat', $evaluationPeriod->tarikh_tamat->format('Y-m-d')) }}" required>
                            @error('tarikh_tamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <input type="hidden" name="boleh_ubah_selepas_tamat" value="1">

                <div class="d-flex justify-content-end">
                    <a href="{{ route('evaluation-periods.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Kemaskini</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection