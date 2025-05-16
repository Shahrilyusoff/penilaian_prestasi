@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="fw-bold">Senarai Penilaian Prestasi</h2>
        </div>
        @can('create', App\Models\Evaluation::class)
        <div class="col-md-6 text-end">
            <a href="{{ route('evaluations.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Tambah Penilaian
            </a>
        </div>
        @endcan
    </div>

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>PYD</th>
                            <th>PPP</th>
                            <th>PPK</th>
                            <th>Tempoh</th>
                            <th>Status</th>
                            <th>Markah</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($evaluations as $evaluation)
                        <tr>
                            <td>{{ $evaluation->pyd->name }}</td>
                            <td>{{ $evaluation->ppp->name }}</td>
                            <td>{{ $evaluation->ppk->name }}</td>
                            <td>{{ $evaluation->evaluationPeriod->tahun }}</td>
                            <td>
                                @if($evaluation->status == 'selesai')
                                    <span class="badge bg-success">Selesai</span>
                                @else
                                    <span class="badge bg-warning text-dark">{{ ucfirst(str_replace('_', ' ', $evaluation->status)) }}</span>
                                @endif
                            </td>
                            <td>
                                @if($evaluation->status == 'selesai')
                                    {{ $evaluation->calculateTotalScore()['purata'] }}%
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('evaluations.show', $evaluation) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @can('update', $evaluation)
                                <a href="{{ route('evaluations.edit', $evaluation) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endcan
                                @can('delete', $evaluation)
                                <form action="{{ route('evaluations.destroy', $evaluation) }}" method="POST" style="display: inline-block;">
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
                            <td colspan="7" class="text-center">Tiada penilaian dijumpai.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($evaluations->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $evaluations->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection