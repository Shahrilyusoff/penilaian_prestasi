@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="fw-bold">Kemaskini SKT</h2>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('skt.update', $skt) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="evaluation_period_id" class="form-label">Tempoh Penilaian</label>
                            <select class="form-select @error('evaluation_period_id') is-invalid @enderror" 
                                    id="evaluation_period_id" name="evaluation_period_id" required disabled>
                                <option value="{{ $skt->evaluationPeriod->id }}" selected>
                                    {{ $skt->evaluationPeriod->tahun }} ({{ $skt->evaluationPeriod->tarikh_mula->format('d/m/Y') }} - {{ $skt->evaluationPeriod->tarikh_tamat->format('d/m/Y') }})
                                </option>
                            </select>
                            <input type="hidden" name="evaluation_period_id" value="{{ $skt->evaluation_period_id }}">
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
                                <option value="{{ $skt->pyd->id }}" selected>
                                    {{ $skt->pyd->name }} ({{ $skt->pyd->jawatan ?? '-' }})
                                </option>
                            </select>
                            <input type="hidden" name="pyd_id" value="{{ $skt->pyd_id }}">
                            @error('pyd_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="ppp_id" class="form-label">Pegawai Penilai Pertama (PPP)</label>
                    <select class="form-select @error('ppp_id') is-invalid @enderror" 
                            id="ppp_id" name="ppp_id" required disabled>
                        <option value="{{ $skt->ppp->id }}" selected>
                            {{ $skt->ppp->name }} ({{ $skt->ppp->jawatan ?? '-' }})
                        </option>
                    </select>
                    <input type="hidden" name="ppp_id" value="{{ $skt->ppp_id }}">
                    @error('ppp_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Aktiviti/Projek & Petunjuk Prestasi</label>
                    <div id="activity-container">
                        @php
                            $activities = json_decode($skt->aktiviti_projek, true) ?? [];
                            $indicators = json_decode($skt->petunjuk_prestasi, true) ?? [];
                        @endphp

                        @foreach($activities as $index => $activity)
                            <div class="row mb-3 activity-row">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="aktiviti_projek[]" 
                                           placeholder="Aktiviti/Projek" value="{{ $activity }}" required>
                                </div>
                                <div class="col-md-5">
                                    <input type="text" class="form-control" name="petunjuk_prestasi[]" 
                                           placeholder="Petunjuk Prestasi" value="{{ $indicators[$index] ?? '' }}" required>
                                </div>
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-danger remove-activity">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" id="add-activity" class="btn btn-sm btn-secondary mt-2">
                        <i class="fas fa-plus me-1"></i> Tambah Aktiviti
                    </button>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary me-2">Kemaskini</button>
                    <a href="{{ route('skt.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add new activity row
        document.getElementById('add-activity').addEventListener('click', function() {
            const container = document.getElementById('activity-container');
            const newRow = document.createElement('div');
            newRow.className = 'row mb-3 activity-row';
            newRow.innerHTML = `
                <div class="col-md-6">
                    <input type="text" class="form-control" name="aktiviti_projek[]" placeholder="Aktiviti/Projek" required>
                </div>
                <div class="col-md-5">
                    <input type="text" class="form-control" name="petunjuk_prestasi[]" placeholder="Petunjuk Prestasi" required>
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger remove-activity">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
            container.appendChild(newRow);
        });

        // Remove activity row
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-activity')) {
                const row = e.target.closest('.activity-row');
                if (document.querySelectorAll('.activity-row').length > 1) {
                    row.remove();
                } else {
                    alert('Sekurang-kurangnya satu aktiviti diperlukan.');
                }
            }
        });
    });
</script>
@endsection