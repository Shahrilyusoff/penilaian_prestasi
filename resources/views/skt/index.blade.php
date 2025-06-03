@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="fw-bold">Senarai SKT</h2>
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
                            <a class="dropdown-item" href="{{ route('skt.index', ['year' => $availableYear]) }}">
                                {{ $availableYear }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            
            @can('create', App\Models\Skt::class)
            <a href="{{ route('skt.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Tambah SKT
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
                            <th>Fasa</th>
                            <th>Status</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($skts as $skt)
                        <tr>
                            <td>{{ $skt->pyd->name }}</td>
                            <td>{{ $skt->evaluationPeriod->tahun }}</td>
                            <td>{{ $skt->ppp->name }}</td>
                            <td>
                                @if($skt->evaluationPeriod->active_period === 'awal')
                                    Awal Tahun
                                @elseif($skt->evaluationPeriod->active_period === 'pertengahan')
                                    Pertengahan Tahun
                                @elseif($skt->evaluationPeriod->active_period === 'akhir')
                                    Akhir Tahun
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if($skt->status === 'draf')
                                    <span class="badge bg-secondary">Draf</span>
                                @elseif($skt->status === 'diserahkan')
                                    <span class="badge bg-warning">Diserahkan</span>
                                @elseif($skt->status === 'disahkan')
                                    <span class="badge bg-success">Disahkan</span>
                                @else
                                    <span class="badge bg-primary">Selesai</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('skt.show', $skt) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>

                                @can('update', $skt)
                                <a href="{{ route('skt.edit', $skt) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endcan

                                @can('delete', $skt)
                                <form action="{{ route('skt.destroy', $skt) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Adakah anda pasti?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endcan

                                @can('updateEvaluator', $skt)
                                <a href="{{ route('skt.edit-evaluator', $skt) }}" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-user-edit"></i> Kemaskini Penilai
                                </a>
                                @endcan
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Tiada SKT dijumpai.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($skts->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $skts->appends(['year' => $year])->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
