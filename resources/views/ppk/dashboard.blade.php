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
                    <h6 class="m-0 font-weight-bold text-primary">Penilaian Untuk Dilengkapkan</h6>
                </div>
                <div class="card-body">
                    @if($pendingEvaluations->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>PYD</th>
                                        <th>PPP</th>
                                        <th>Tempoh</th>
                                        <th>Markah PPP</th>
                                        <th>Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pendingEvaluations as $evaluation)
                                        <tr>
                                            <td>{{ $evaluation->pyd->name }}</td>
                                            <td>{{ $evaluation->ppp->name }}</td>
                                            <td>{{ $evaluation->evaluationPeriod->tahun }}</td>
                                            <td>{{ $evaluation->calculateTotalScore()['ppp'] }}%</td>
                                            <td>
                                                <a href="{{ route('evaluations.show', $evaluation) }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-edit"></i> Lengkapkan
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">Tiada penilaian yang memerlukan tindakan anda.</p>
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
                                        <th>PYD</th>
                                        <th>Tempoh</th>
                                        <th>Status</th>
                                        <th>Markah PPP</th>
                                        <th>Markah PPK</th>
                                        <th>Purata</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentEvaluations as $evaluation)
                                        <tr>
                                            <td>{{ $evaluation->pyd->name }}</td>
                                            <td>{{ $evaluation->evaluationPeriod->tahun }}</td>
                                            <td>
                                                @if($evaluation->status == 'selesai')
                                                    <span class="badge bg-success">Selesai</span>
                                                @else
                                                    <span class="badge bg-warning text-dark">{{ ucfirst(str_replace('_', ' ', $evaluation->status)) }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $evaluation->calculateTotalScore()['ppp'] }}%</td>
                                            <td>
                                                @if($evaluation->status == 'selesai')
                                                    {{ $evaluation->calculateTotalScore()['ppk'] }}%
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @if($evaluation->status == 'selesai')
                                                    {{ $evaluation->calculateTotalScore()['purata'] }}%
                                                @else
                                                    -
                                                @endif
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