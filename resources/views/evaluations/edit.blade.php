@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="fw-bold">Kemaskini Penilaian Prestasi</h2>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('evaluations.update', $evaluation) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="evaluation_period_id" class="form-label">Tempoh Penilaian</label>
                            <select class="form-select @error('evaluation_period_id') is-invalid @enderror" 
                                    id="evaluation_period_id" name="evaluation_period_id" required disabled>
                                <option value="{{ $evaluation->evaluationPeriod->id }}" selected>
                                    {{ $evaluation->evaluationPeriod->tahun }} (
                                    {{ optional($evaluation->evaluationPeriod->tarikh_mula_penilaian)->format('d/m/Y') ?? 'N/A' }} - 
                                    {{ optional($evaluation->evaluationPeriod->tarikh_tamat_penilaian)->format('d/m/Y') ?? 'N/A' }})
                                </option>
                            </select>
                            <input type="hidden" name="evaluation_period_id" value="{{ $evaluation->evaluation_period_id }}">
                            @error('evaluation_period_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="pyd_id" class="form-label">Pegawai Yang Dinilai (PYD)</label>
                            <select class="form-select @error('pyd_id') is-invalid @enderror" 
                                    id="pyd_id" name="pyd_id" required disabled>
                                <option value="{{ $evaluation->pyd->id }}" selected>
                                    {{ $evaluation->pyd->name }} ({{ $evaluation->pyd->jawatan ?? '-' }})
                                </option>
                            </select>
                            <input type="hidden" name="pyd_id" value="{{ $evaluation->pyd_id }}">
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
                                    id="ppp_id" name="ppp_id" required disabled>
                                <option value="{{ $evaluation->ppp->id }}" selected>
                                    {{ $evaluation->ppp->name }} ({{ $evaluation->ppp->jawatan ?? '-' }})
                                </option>
                            </select>
                            <input type="hidden" name="ppp_id" value="{{ $evaluation->ppp_id }}">
                            @error('ppp_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="ppk_id" class="form-label">Pegawai Penilai Kedua (PPK)</label>
                            <select class="form-select @error('ppk_id') is-invalid @enderror" 
                                    id="ppk_id" name="ppk_id" required disabled>
                                <option value="{{ $evaluation->ppk->id }}" selected>
                                    {{ $evaluation->ppk->name }} ({{ $evaluation->ppk->jawatan ?? '-' }})
                                </option>
                            </select>
                            <input type="hidden" name="ppk_id" value="{{ $evaluation->ppk_id }}">
                            @error('ppk_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary me-2">Kemaskini</button>
                    <a href="{{ route('evaluations.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection