<!-- resources/views/skt/edit.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="fw-bold">Kemaskini Penilai PPP</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('skt.show', $skt) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <form method="POST" action="{{ route('skt.update', $skt) }}">
                @csrf
                @method('PUT')
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">PYD</label>
                        <input type="text" class="form-control" value="{{ $skt->pyd->name }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tahun</label>
                        <input type="text" class="form-control" value="{{ $skt->evaluationPeriod->tahun }}" readonly>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Penilai PPP Semasa</label>
                        <input type="text" class="form-control" value="{{ $skt->ppp->name }}" readonly>
                        <input type="hidden" name="current_ppp_id" value="{{ $skt->ppp_id }}">
                    </div>
                    <div class="col-md-6">
                        <label for="ppp_id" class="form-label">Pilih Penilai PPP Baru</label>
                        <select class="form-select @error('ppp_id') is-invalid @enderror" id="ppp_id" name="ppp_id" required>
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
                
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i> 
                    <strong>Perhatian:</strong> Mengubah penilai PPP akan menetapkan semula status SKT kepada draf dan menghapuskan semua maklumat yang telah diisi.
                </div>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection