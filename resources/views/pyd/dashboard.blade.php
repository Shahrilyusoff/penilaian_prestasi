@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2 class="fw-bold">Dashboard Pegawai Yang Dinilai (PYD)</h2>
            @if($overdueSkts > 0)
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle"></i> Anda mempunyai {{ $overdueSkts }} SKT yang belum diserahkan melebihi tempoh!
                </div>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">SKT Semasa</h6>
                </div>
                <div class="card-body">
                    @if($currentSkts->count() > 0)
                        <div class="list-group">
                            @foreach($currentSkts as $skt)
                                <a href="{{ route('skt.show', $skt) }}" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">Tahun {{ $skt->evaluationPeriod->tahun }}</h6>
                                        <small>{{ ucfirst($skt->current_phase) }}</small>
                                    </div>
                                    <small class="text-muted">
                                        PPP: {{ $skt->ppp->name }} | 
                                        Status: 
                                        @if($skt->status === 'draf')
                                            <span class="badge bg-secondary">Draf</span>
                                        @elseif($skt->status === 'diserahkan_awal')
                                            <span class="badge bg-warning">Menunggu Pengesahan Awal</span>
                                        @elseif($skt->status === 'disahkan_awal')
                                            <span class="badge bg-success">Disahkan Awal</span>
                                        @elseif($skt->status === 'diserahkan_pertengahan')
                                            <span class="badge bg-warning">Menunggu Pengesahan Pertengahan</span>
                                        @elseif($skt->status === 'disahkan_pertengahan')
                                            <span class="badge bg-success">Disahkan Pertengahan</span>
                                        @elseif($skt->status === 'selesai')
                                            <span class="badge bg-primary">Selesai</span>
                                        @endif
                                    </small>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">Tiada SKT untuk tahun semasa.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Penilaian Semasa</h6>
                </div>
                <div class="card-body">
                    @if($pendingEvaluations->count() > 0)
                        <div class="list-group">
                            @foreach($pendingEvaluations as $evaluation)
                                <a href="{{ route('evaluations.show', $evaluation) }}" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">Tahun {{ $evaluation->evaluationPeriod->tahun }}</h6>
                                        <small>Penilaian</small>
                                    </div>
                                    <small class="text-muted">
                                        PPP: {{ $evaluation->ppp->name }} | 
                                        PPK: {{ $evaluation->ppk->name }} | 
                                        Status: <span class="badge bg-secondary">Draf PYD</span>
                                    </small>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">Tiada penilaian yang menunggu pengisian.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tempoh Aktif</h6>
                </div>
                <div class="card-body">
                    @if($activePeriods->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Fasa</th>
                                        <th>Tarikh Mula</th>
                                        <th>Tarikh Tamat</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($activePeriods as $period)
                                        <tr>
                                            <td>Awal Tahun</td>
                                            <td>{{ $period->tarikh_mula_awal->format('d/m/Y') }}</td>
                                            <td>{{ $period->tarikh_tamat_awal->format('d/m/Y') }}</td>
                                            <td>
                                                @if(now()->between($period->tarikh_mula_awal, $period->tarikh_tamat_awal))
                                                    <span class="badge bg-success">Aktif</span>
                                                @else
                                                    <span class="badge bg-secondary">Tidak Aktif</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Pertengahan Tahun</td>
                                            <td>{{ $period->tarikh_mula_pertengahan->format('d/m/Y') }}</td>
                                            <td>{{ $period->tarikh_tamat_pertengahan->format('d/m/Y') }}</td>
                                            <td>
                                                @if(now()->between($period->tarikh_mula_pertengahan, $period->tarikh_tamat_pertengahan))
                                                    <span class="badge bg-success">Aktif</span>
                                                @else
                                                    <span class="badge bg-secondary">Tidak Aktif</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Akhir Tahun</td>
                                            <td>{{ $period->tarikh_mula_akhir->format('d/m/Y') }}</td>
                                            <td>{{ $period->tarikh_tamat_akhir->format('d/m/Y') }}</td>
                                            <td>
                                                @if(now()->between($period->tarikh_mula_akhir, $period->tarikh_tamat_akhir))
                                                    <span class="badge bg-success">Aktif</span>
                                                @else
                                                    <span class="badge bg-secondary">Tidak Aktif</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">Tiada tempoh penilaian aktif.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection