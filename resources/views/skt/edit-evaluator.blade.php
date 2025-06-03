@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="fw-bold">Kemaskini Penilai SKT</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('skt.show', $skt) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <form method="POST" action="{{ route('skt.update-evaluator', $skt) }}">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label class="form-label">PYD</label>
                    <input type="text" class="form-control" value="{{ $skt->pyd->name }}" readonly>
                </div>
                
                <div class="mb-3">
                    <label for="ppp_id" class="form-label">PPP</label>
                    <select class="form-select" id="ppp_id" name="ppp_id" required>
                        @foreach($ppps as $ppp)
                            <option value="{{ $ppp->id }}" {{ $skt->ppp_id == $ppp->id ? 'selected' : '' }}>
                                {{ $ppp->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
