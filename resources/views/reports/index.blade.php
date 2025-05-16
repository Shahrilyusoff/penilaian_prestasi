@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="fw-bold">Laporan</h2>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="mb-0">Laporan Penilaian</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('reports.evaluation') }}" method="GET">
                                <div class="mb-3">
                                    <label for="period" class="form-label">Pilih Tempoh Penilaian</label>
                                    <select class="form-select" id="period" name="period" required>
                                        <option value="">-- Pilih Tempoh --</option>
                                        @foreach($periods as $period)
                                            <option value="{{ $period->id }}">{{ $period->tahun }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-file-pdf me-1"></i> Jana Laporan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="mb-0">Laporan SKT</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('reports.skt') }}" method="GET">
                                <div class="mb-3">
                                    <label for="period" class="form-label">Pilih Tempoh Penilaian</label>
                                    <select class="form-select" id="period" name="period" required>
                                        <option value="">-- Pilih Tempoh --</option>
                                        @foreach($periods as $period)
                                            <option value="{{ $period->id }}">{{ $period->tahun }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-file-pdf me-1"></i> Jana Laporan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Laporan Individu</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('reports.individual') }}" method="GET">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="evaluation" class="form-label">Pilih Penilaian</label>
                                            <select class="form-select" id="evaluation" name="evaluation" required>
                                                <option value="">-- Pilih Penilaian --</option>
                                                @foreach($evaluations as $evaluation)
                                                    <option value="{{ $evaluation->id }}">
                                                        {{ $evaluation->pyd->name }} - {{ $evaluation->evaluationPeriod->tahun }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-file-pdf me-1"></i> Jana Laporan
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection