@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2 class="fw-bold">Dashboard Pegawai Yang Dinilai (PYD)</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">SKT Untuk Dilengkapkan</h6>
                </div>
                <div class="card-body">
                    @if($pendingSkts->count() > 0)
                        <ul class="list-group">
                            @foreach($pendingSkts as $skt)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $skt->evaluationPeriod->tahun }}</strong><br>
                                        <small class="text-muted">PPP: {{ $skt->ppp->name }}</small>
                                    </div>
                                    <div>
                                        <a href="{{ route('skt.show', $skt) }}" class="btn btn-sm btn-primary">
                                            @if($skt->status == 'draf')
                                                <i class="fas fa-edit"></i> Lengkapkan
                                            @else
                                                <i class="fas fa-eye"></i> Lihat
                                            @endif
                                        </a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">Tiada SKT yang perlu dilengkapkan.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Penilaian Untuk Dilengkapkan</h6>
                </div>
                <div class="card-body">
                    @if($pendingEvaluations->count() > 0)
                        <ul class="list-group">
                            @foreach($pendingEvaluations as $evaluation)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $evaluation->evaluationPeriod->tahun }}</strong><br>
                                        <small class="text-muted">PPP: {{ $evaluation->ppp->name }}</small>
                                    </div>
                                    <div>
                                        <a href="{{ route('evaluations.show', $evaluation) }}" class="btn btn-sm btn-primary">
                                            @if($evaluation->status == 'draf_pyd')
                                                <i class="fas fa-edit"></i> Lengkapkan
                                            @else
                                                <i class="fas fa-eye"></i> Lihat
                                            @endif
                                        </a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">Tiada penilaian yang perlu dilengkapkan.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Penilaian Terkini</h6>
                </div>
                <div class="card-body">
                    @if($recentEvaluations->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Tempoh</th>
                                        <th>PPP</th>
                                        <th>PPK</th>
                                        <th>Status</th>
                                        <th>Markah</th>
                                        <th>Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentEvaluations as $evaluation)
                                        <tr>
                                            <td>{{ $evaluation->evaluationPeriod->tahun }}</td>
                                            <td>{{ $evaluation->ppp->name }}</td>
                                            <td>{{ $evaluation->ppk->name }}</td>
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
                                                    <i class="fas fa-eye"></i> Lihat
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">Tiada penilaian terkini.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection