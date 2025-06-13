@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h4 class="fw-bold">Senarai Penilaian Prestasi</h4>
        </div>
        <div class="col-md-6 text-end">
            <div class="dropdown d-inline-block me-2">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" 
                        id="yearDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    Tahun: {{ $year }}
                </button>
                <ul class="dropdown-menu" aria-labelledby="yearDropdown">
                    @foreach($availableYears as $availableYear)
                        <li>
                            <a class="dropdown-item" href="{{ route('evaluations.index', ['year' => $availableYear]) }}">
                                {{ $availableYear }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            
            @can('create', App\Models\Evaluation::class)
            <a href="{{ route('evaluations.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Tambah Penilaian
            </a>
            @endcan
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>PYD</th>
                            <th>Tahun</th>
                            <th>PPP</th>
                            <th>PPK</th>
                            <th>Status</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($evaluations as $evaluation)
                        <tr>
                            <td>{{ $evaluation->pyd->name }}</td>
                            <td>{{ $evaluation->evaluationPeriod->tahun }}</td>
                            <td>{{ $evaluation->ppp->name }}</td>
                            <td>{{ $evaluation->ppk->name }}</td>
                            <td>
                                @if($evaluation->status === 'draf_pyd')
                                    <span class="badge bg-secondary">Draf PYD</span>
                                @elseif($evaluation->status === 'draf_ppp')
                                    <span class="badge bg-warning">Draf PPP</span>
                                @elseif($evaluation->status === 'draf_ppk')
                                    <span class="badge bg-info">Draf PPK</span>
                                @else
                                    <span class="badge bg-success">Selesai</span>
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
                            <td colspan="6" class="text-center">Tiada penilaian dijumpai.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($evaluations->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $evaluations->appends(['year' => $year])->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection