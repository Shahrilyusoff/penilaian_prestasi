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
        <div class="card-header py-3">
            <div class="row">
                <div class="col-md-6">
                    <div class="btn-group" role="group">
                        <a href="{{ route('evaluation-periods.index', ['year' => $year]) }}" 
                           class="btn btn-outline-primary {{ empty($jenis) ? 'active' : '' }}">
                            Semua
                        </a>
                        <a href="{{ route('evaluation-periods.index', ['year' => $year, 'jenis' => 'skt']) }}" 
                           class="btn btn-outline-primary {{ $jenis === 'skt' ? 'active' : '' }}">
                            SKT
                        </a>
                        <a href="{{ route('evaluation-periods.index', ['year' => $year, 'jenis' => 'penilaian']) }}" 
                           class="btn btn-outline-primary {{ $jenis === 'penilaian' ? 'active' : '' }}">
                            Penilaian Prestasi
                        </a>
                    </div>
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
                                    <a class="dropdown-item" href="{{ route('evaluation-periods.index', ['year' => $availableYear, 'jenis' => $jenis]) }}">
                                        {{ $availableYear }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Tahun</th>
                            <th>Jenis</th>
                            <th>Tempoh</th>
                            <th>Status</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($periods as $period)
                        <tr>
                            <td>{{ $period->tahun }}</td>
                            <td>{{ $period->jenis === 'skt' ? 'SKT' : 'Penilaian Prestasi' }}</td>
                            <td>
                                @if($period->jenis === 'skt')
                                    Awal: {{ $period->tarikh_mula_awal->format('d/m/Y') }} - {{ $period->tarikh_tamat_awal->format('d/m/Y') }}<br>
                                    Pertengahan: {{ $period->tarikh_mula_pertengahan->format('d/m/Y') }} - {{ $period->tarikh_tamat_pertengahan->format('d/m/Y') }}<br>
                                    Akhir: {{ $period->tarikh_mula_akhir->format('d/m/Y') }} - {{ $period->tarikh_tamat_akhir->format('d/m/Y') }}
                                @else
                                    {{ $period->tarikh_mula_penilaian->format('d/m/Y') }} - {{ $period->tarikh_tamat_penilaian->format('d/m/Y') }}
                                @endif
                            </td>
                            <td>
                                @if($period->is_active)
                                    <span class="badge bg-success">Aktif ({{ $period->active_period }})</span>
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
                                <form action="{{ route('evaluation-periods.destroy', $period) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Adakah anda pasti?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
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
            
            @if($periods->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $periods->appends(['year' => $year, 'jenis' => $jenis])->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection