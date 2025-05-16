@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
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
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                <option value="1" {{ old('status', $evaluationPeriod->status) ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ !old('status', $evaluationPeriod->status) ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                            @error('status')
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

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="boleh_ubah_selepas_tamat" 
                           name="boleh_ubah_selepas_tamat" {{ old('boleh_ubah_selepas_tamat', $evaluationPeriod->boleh_ubah_selepas_tamat) ? 'checked' : '' }}>
                    <label class="form-check-label" for="boleh_ubah_selepas_tamat">Benarkan pengubahsuaian selepas tarikh tamat</label>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary me-2">Kemaskini</button>
                    <a href="{{ route('evaluation-periods.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection