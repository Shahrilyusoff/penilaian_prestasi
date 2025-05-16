@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="fw-bold">Butiran Tempoh Penilaian</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('evaluation-periods.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Tahun</th>
                            <td>{{ $evaluationPeriod->tahun }}</td>
                        </tr>
                        <tr>
                            <th>Tarikh Mula</th>
                            <td>{{ $evaluationPeriod->tarikh_mula->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <th>Tarikh Tamat</th>
                            <td>{{ $evaluationPeriod->tarikh_tamat->format('d/m/Y') }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Status</th>
                            <td>
                                @if($evaluationPeriod->status)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Tidak Aktif</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Boleh Ubah Selepas Tamat</th>
                            <td>{{ $evaluationPeriod->boleh_ubah_selepas_tamat ? 'Ya' : 'Tidak' }}</td>
                        </tr>
                        <tr>
                            <th>Dicipta Pada</th>
                            <td>{{ $evaluationPeriod->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="d-flex justify-content-end mt-4">
                <a href="{{ route('evaluation-periods.edit', $evaluationPeriod) }}" class="btn btn-warning me-2">
                    <i class="fas fa-edit me-1"></i> Edit
                </a>
                @can('delete', $evaluationPeriod)
                <form action="{{ route('evaluation-periods.destroy', $evaluationPeriod) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Adakah anda pasti?')">
                        <i class="fas fa-trash me-1"></i> Padam
                    </button>
                </form>
                @endcan
            </div>
        </div>
    </div>

    <div class="card shadow mt-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Statistik</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Jumlah SKT</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $evaluationPeriod->skts->count() }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-tasks fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Jumlah Penilaian</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $evaluationPeriod->evaluations->count() }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-clipboard-check fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Penilaian Selesai</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $evaluationPeriod->evaluations->where('status', 'selesai')->count() }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection