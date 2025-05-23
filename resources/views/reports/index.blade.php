@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2 class="fw-bold">Laporan Sistem</h2>
        </div>
    </div>

    <div class="row">
        <!-- SKT Reports Card -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Laporan SKT</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                Hasil Sasaran Kerja Tahunan
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tasks fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <hr>
                    <form method="GET" action="{{ route('reports.skt') }}" target="_blank">
                        <div class="mb-3">
                            <label for="skt_year" class="form-label">Tahun</label>
                            <select class="form-select" id="skt_year" name="year" required>
                                @foreach($availableYears as $year)
                                    <option value="{{ $year }}" {{ $year == date('Y') ? 'selected' : '' }}>{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-file-pdf me-1"></i> Jana Laporan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Evaluation Reports Card -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Laporan Penilaian</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                Hasil Penilaian Prestasi
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <hr>
                    <form method="GET" action="{{ route('reports.evaluation') }}" target="_blank">
                        <div class="mb-3">
                            <label for="eval_year" class="form-label">Tahun</label>
                            <select class="form-select" id="eval_year" name="year" required>
                                @foreach($availableYears as $year)
                                    <option value="{{ $year }}" {{ $year == date('Y') ? 'selected' : '' }}>{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-file-pdf me-1"></i> Jana Laporan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Individual Reports Card -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Laporan Individu</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                Laporan Prestasi Individu
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <hr>
                    <form method="GET" action="{{ route('reports.individual') }}" target="_blank">
                        <div class="mb-3">
                            <label for="staff_id" class="form-label">Kakitangan</label>
                            <select class="form-select" id="staff_id" name="staff_id" required>
                                <option value="">-- Pilih Kakitangan --</option>
                                @foreach($staff as $s)
                                    <option value="{{ $s->id }}">{{ $s->name }} ({{ $s->jawatan }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="ind_year" class="form-label">Tahun</label>
                            <select class="form-select" id="ind_year" name="year" required>
                                @foreach($availableYears as $year)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-info">
                                <i class="fas fa-file-pdf me-1"></i> Jana Laporan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection