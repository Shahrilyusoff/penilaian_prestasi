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
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($evaluationPeriod->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Tidak Aktif</span>
                                @endif
                            </td>
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
</div>
@endsection