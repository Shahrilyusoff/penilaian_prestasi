@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="fw-bold">Senarai Tempoh Penilaian</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('evaluation-periods.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Tambah Tempoh
            </a>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Tahun</th>
                            <th>Tarikh Mula</th>
                            <th>Tarikh Tamat</th>
                            <th>Status</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($evaluationPeriods as $period)
                        <tr>
                            <td>{{ $period->tahun }}</td>
                            <td>{{ $period->tarikh_mula->format('d/m/Y') }}</td>
                            <td>{{ $period->tarikh_tamat->format('d/m/Y') }}</td>
                            <td>
                                @if($period->status)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Tidak Aktif</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('evaluation-periods.show', $period) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('evaluation-periods.edit', $period) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @can('delete', $period)
                                <form action="{{ route('evaluation-periods.destroy', $period) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Adakah anda pasti?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endcan
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Tiada tempoh penilaian dijumpai.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($evaluationPeriods->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $evaluationPeriods->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection