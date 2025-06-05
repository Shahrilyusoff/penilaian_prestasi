@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2 class="fw-bold">Dashboard Pegawai Penilai Kedua (PPK)</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Penilaian Menunggu Tindakan</h6>
                </div>
                <div class="card-body">
                    @if($pendingEvaluations->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>PYD</th>
                                        <th>PPP</th>
                                        <th>Tahun</th>
                                        <th>Status</th>
                                        <th>Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pendingEvaluations as $evaluation)
                                        <tr>
                                            <td>{{ $evaluation->pyd->name }}</td>
                                            <td>{{ $evaluation->ppp->name }}</td>
                                            <td>{{ $evaluation->evaluationPeriod->tahun }}</td>
                                            <td>
                                                <span class="badge bg-info">Draf PPK</span>
                                            </td>
                                            <td>
                                                <a href="{{ route('evaluations.show', $evaluation) }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-eye"></i> Lihat
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
                        <div class="list-group">
                            @foreach($activePeriods as $period)
                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">{{ $period->tahun }} - {{ $period->jenis === 'skt' ? 'SKT' : 'Penilaian' }}</h6>
                                        <small>{{ ucfirst($period->active_period) }}</small>
                                    </div>
                                    <small class="text-muted">
                                        @if($period->jenis === 'skt')
                                            Awal: {{ $period->tarikh_mula_awal->format('d/m/Y') }} - {{ $period->tarikh_tamat_awal->format('d/m/Y') }}<br>
                                            Akhir: {{ $period->tarikh_mula_akhir->format('d/m/Y') }} - {{ $period->tarikh_tamat_akhir->format('d/m/Y') }}
                                        @else
                                            {{ $period->tarikh_mula_penilaian->format('d/m/Y') }} - {{ $period->tarikh_tamat_penilaian->format('d/m/Y') }}
                                        @endif
                                    </small>
                                </div>
                            @endforeach
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