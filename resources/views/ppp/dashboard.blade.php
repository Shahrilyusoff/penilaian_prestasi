@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2 class="fw-bold">Dashboard PPP</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">SKT Untuk Penilaian</h6>
                </div>
                <div class="card-body">
                    @if($pendingSkts->count() > 0)
                        <ul class="list-group">
                            @foreach($pendingSkts as $skt)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $skt->pyd->name }}
                                    <a href="{{ route('skt.show', $skt) }}" class="btn btn-sm btn-primary">Lihat</a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">Tiada SKT yang memerlukan penilaian anda.</p>
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
                                    {{ $evaluation->pyd->name }}
                                    <a href="{{ route('evaluations.show', $evaluation) }}" class="btn btn-sm btn-primary">Lihat</a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">Tiada penilaian yang memerlukan tindakan anda.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection