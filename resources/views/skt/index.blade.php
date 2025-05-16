@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="fw-bold">Senarai SKT</h2>
        </div>
        @can('create', App\Models\Skt::class)
        <div class="col-md-6 text-end">
            <a href="{{ route('skt.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Tambah SKT
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
                            <th>Tempoh</th>
                            <th>Status</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($skts as $skt)
                        <tr>
                            <td>{{ $skt->pyd->name }}</td>
                            <td>{{ $skt->ppp->name }}</td>
                            <td>{{ $skt->evaluationPeriod->tahun }}</td>
                            <td>
                                @if($skt->status == 'disahkan')
                                    <span class="badge bg-success">Disahkan</span>
                                @elseif($skt->status == 'diserahkan')
                                    <span class="badge bg-info">Diserahkan</span>
                                @else
                                    <span class="badge bg-warning text-dark">Draf</span>
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
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Tiada SKT dijumpai.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($skts->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $skts->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection