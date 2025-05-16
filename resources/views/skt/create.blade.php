@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="fw-bold">Tambah SKT</h2>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('skt.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="evaluation_period_id" class="form-label">Tempoh Penilaian</label>
                            <select class="form-select @error('evaluation_period_id') is-invalid @enderror" 
                                    id="evaluation_period_id" name="evaluation_period_id" required>
                                <option value="">-- Pilih Tempoh --</option>
                                @foreach($activePeriods as $period)
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

                <div class="mb-3">
                    <label class="form-label">Aktiviti/Projek & Petunjuk Prestasi</label>
                    <div id="activity-container">
                        @if(old('aktiviti_projek') && old('petunjuk_prestasi'))
                            @foreach(old('aktiviti_projek') as $index => $aktiviti)
                                <div class="row mb-3 activity-row">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="aktiviti_projek[]" 
                                               placeholder="Aktiviti/Projek" value="{{ $aktiviti }}" required>
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" name="petunjuk_prestasi[]" 
                                               placeholder="Petunjuk Prestasi" value="{{ old('petunjuk_prestasi')[$index] }}" required>
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-danger remove-activity">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="row mb-3 activity-row">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="aktiviti_projek[]" 
                                           placeholder="Aktiviti/Projek" required>
                                </div>
                                <div class="col-md-5">
                                    <input type="text" class="form-control" name="petunjuk_prestasi[]" 
                                           placeholder="Petunjuk Prestasi" required>
                                </div>
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-danger remove-activity">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                    <button type="button" id="add-activity" class="btn btn-sm btn-secondary mt-2">
                        <i class="fas fa-plus me-1"></i> Tambah Aktiviti
                    </button>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary me-2">Simpan</button>
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