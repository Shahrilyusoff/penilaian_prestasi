@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2 class="fw-bold">Dashboard Pegawai Penilai Pertama (PPP)</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">SKT Menunggu Pengesahan</h6>
                </div>
                <div class="card-body">
                    @if($pendingSkts->count() > 0)
                        <div class="list-group">
                            @foreach($pendingSkts as $skt)
                                <a href="{{ route('skt.show', $skt) }}" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">{{ $skt->pyd->name }}</h6>
                                        <small>{{ ucfirst($skt->current_phase) }}</small>
                                    </div>
                                    <small class="text-muted">
                                        {{ $skt->evaluationPeriod->tahun }} | 
                                        Status: 
                                        @if($skt->status === 'diserahkan_awal')
                                            <span class="badge bg-warning">Awal Tahun</span>
                                        @else
                                            <span class="badge bg-info">Pertengahan Tahun</span>
                                        @endif
                                    </small>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">Tiada SKT yang menunggu pengesahan.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Penilaian Menunggu Tindakan</h6>
                </div>
                <div class="card-body">
                    @if($pendingEvaluations->count() > 0)
                        <div class="list-group">
                            @foreach($pendingEvaluations as $evaluation)
                                <a href="{{ route('evaluations.show', $evaluation) }}" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">{{ $evaluation->pyd->name }}</h6>
                                        <small>Penilaian</small>
                                    </div>
                                    <small class="text-muted">
                                        {{ $evaluation->evaluationPeriod->tahun }} | 
                                        Status: <span class="badge bg-warning">Draf PPP</span>
                                    </small>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">Tiada penilaian yang menunggu tindakan.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tempoh Penilaian Aktif</h6>
                </div>
                <div class="card-body">
                    @if($activePeriods->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Tahun</th>
                                        <th>Jenis</th>
                                        <th>Tempoh Awal</th>
                                        <th>Tempoh Pertengahan</th>
                                        <th>Tempoh Akhir</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($activePeriods as $period)
                                        <tr>
                                            <td>{{ $period->tahun }}</td>
                                            <td>{{ $period->jenis === 'skt' ? 'SKT' : 'Penilaian' }}</td>
                                            <td>
                                                {{ $period->tarikh_mula_awal->format('d/m/Y') }} - 
                                                {{ $period->tarikh_tamat_awal->format('d/m/Y') }}
                                            </td>
                                            <td>
                                                {{ $period->tarikh_mula_pertengahan->format('d/m/Y') }} - 
                                                {{ $period->tarikh_tamat_pertengahan->format('d/m/Y') }}
                                            </td>
                                            <td>
                                                {{ $period->tarikh_mula_akhir->format('d/m/Y') }} - 
                                                {{ $period->tarikh_tamat_akhir->format('d/m/Y') }}
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