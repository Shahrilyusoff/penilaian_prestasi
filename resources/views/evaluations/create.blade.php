@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2 class="fw-bold">Tambah Penilaian Prestasi</h2>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <form method="POST" action="{{ route('evaluations.store') }}">
                @csrf
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="evaluation_period_id" class="form-label">Tempoh Penilaian</label>
                        <select class="form-select @error('evaluation_period_id') is-invalid @enderror" 
                                id="evaluation_period_id" name="evaluation_period_id" required>
                            <option value="">-- Pilih Tempoh --</option>
                            @foreach($evaluationPeriods as $period)
                                @if($period->jenis === 'penilaian')
                                    <option value="{{ $period->id }}" 
                                        {{ old('evaluation_period_id') == $period->id ? 'selected' : '' }}>
                                        {{ $period->tahun }} - 
                                        {{ $period->tarikh_mula_penilaian->format('d/m/Y') }} hingga 
                                        {{ $period->tarikh_tamat_penilaian->format('d/m/Y') }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                        @error('evaluation_period_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="pyd_id" class="form-label">Pegawai Yang Dinilai (PYD)</label>
                        <select class="form-select @error('pyd_id') is-invalid @enderror" 
                                id="pyd_id" name="pyd_id" required>
                            <option value="">-- Pilih PYD --</option>
                            @foreach($pyds as $pyd)
                                <option value="{{ $pyd->id }}" 
                                    {{ old('pyd_id') == $pyd->id ? 'selected' : '' }}>
                                    {{ $pyd->name }} - {{ $pyd->jawatan }}
                                </option>
                            @endforeach
                        </select>
                        @error('pyd_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="ppp_id" class="form-label">Pegawai Penilai Pertama (PPP)</label>
                        <select class="form-select @error('ppp_id') is-invalid @enderror" 
                                id="ppp_id" name="ppp_id" required>
                            <option value="">-- Pilih PPP --</option>
                            @foreach($ppps as $ppp)
                                <option value="{{ $ppp->id }}" 
                                    {{ old('ppp_id') == $ppp->id ? 'selected' : '' }}>
                                    {{ $ppp->name }} - {{ $ppp->jawatan }}
                                </option>
                            @endforeach
                        </select>
                        @error('ppp_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="ppk_id" class="form-label">Pegawai Penilai Kedua (PPK)</label>
                        <select class="form-select @error('ppk_id') is-invalid @enderror" 
                                id="ppk_id" name="ppk_id" required>
                            <option value="">-- Pilih PPK --</option>
                            @foreach($ppks as $ppk)
                                <option value="{{ $ppk->id }}" 
                                    {{ old('ppk_id') == $ppk->id ? 'selected' : '' }}>
                                    {{ $ppk->name }} - {{ $ppk->jawatan }}
                                </option>
                            @endforeach
                        </select>
                        @error('ppk_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('evaluations.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-fill PPP when PYD is selected
    document.getElementById('pyd_id').addEventListener('change', function() {
        const pydId = this.value;
        if (pydId) {
            // In a real implementation, you would fetch the PPP from the server
            // based on the selected PYD. This is just a placeholder.
            console.log('PYD selected:', pydId);
        }
    });
});
</script>
@endsection