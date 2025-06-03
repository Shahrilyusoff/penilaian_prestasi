<!-- resources/views/skt/show.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="fw-bold">Butiran SKT</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('skt.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Maklumat Asas</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <p><strong>PYD:</strong> {{ $skt->pyd->name }}</p>
                </div>
                <div class="col-md-4">
                    <p><strong>PPP:</strong> {{ $skt->ppp->name }}</p>
                </div>
                <div class="col-md-4">
                    <p><strong>Tahun:</strong> {{ $skt->evaluationPeriod->tahun }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <p><strong>Fasa Semasa:</strong> 
                        @if($skt->evaluationPeriod->active_period === 'awal')
                            Awal Tahun
                        @elseif($skt->evaluationPeriod->active_period === 'pertengahan')
                            Pertengahan Tahun
                        @elseif($skt->evaluationPeriod->active_period === 'akhir')
                            Akhir Tahun
                        @else
                            -
                        @endif
                    </p>
                </div>
                <div class="col-md-4">
                    <p><strong>Status:</strong> 
                        @if($skt->status === 'draf')
                            <span class="badge bg-secondary">Draf</span>
                        @elseif($skt->status === 'diserahkan')
                            <span class="badge bg-warning">Diserahkan</span>
                        @elseif($skt->status === 'disahkan')
                            <span class="badge bg-success">Disahkan</span>
                        @else
                            <span class="badge bg-primary">Selesai</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    @if($skt->isAwalTahunActive() || $skt->isPertengahanTahunActive())
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                @if($skt->isAwalTahunActive())
                    BAHAGIAN I - Penetapan Sasaran Kerja Tahunan
                @else
                    BAHAGIAN II - Kajian Semula Sasaran Kerja Tahunan Pertengahan Tahun
                @endif
            </h6>
        </div>
        <div class="card-body">
            @if($skt->aktiviti_projek)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="50%">Ringkasan Aktiviti/Projek</th>
                                <th width="50%">Petunjuk Prestasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(json_decode($skt->aktiviti_projek, true) as $item)
                            <tr>
                                <td>{{ $item['aktiviti'] }}</td>
                                <td>{{ $item['petunjuk'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted">Tiada maklumat SKT.</p>
            @endif
            
            @can('update', $skt)
                @if($skt->status === 'draf' || ($skt->status === 'diserahkan' && auth()->user()->isPPP()))
                <div class="mt-4">
                    <a href="{{ route('skt.edit', $skt) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-1"></i> 
                        @if($skt->isAwalTahunActive())
                            Isi/Maklumat SKT Awal Tahun
                        @else
                            Kajian Semula SKT Pertengahan Tahun
                        @endif
                    </a>
                    
                    @if($skt->status === 'diserahkan' && auth()->user()->isPPP())
                    <form action="{{ route('skt.approve', $skt) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check me-1"></i> Sahkan
                        </button>
                    </form>
                    @endif
                </div>
                @endif
            @endcan
        </div>
    </div>
    @endif

    @if($skt->isAkhirTahunActive())
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    Penetapan Sasaran Kerja Tahunan (Versi Akhir)
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="50%">Ringkasan Aktiviti/Projek</th>
                                <th width="50%">Petunjuk Prestasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(json_decode($skt->getFinalAktivitiProjek(), true) as $item)
                            <tr>
                                <td>{{ $item['aktiviti'] }}</td>
                                <td>{{ $item['petunjuk'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    BAHAGIAN III - Laporan dan Ulasan Keseluruhan Pencapaian SKT
                </h6>
            </div>
            <div class="card-body">
                <h5>1. Laporan/Ulasan Oleh PYD</h5>
                <div class="p-3 mb-4 bg-light rounded">
                    {!! $skt->laporan_akhir_pyd ? nl2br(e($skt->laporan_akhir_pyd)) : '<span class="text-muted">Belum diisi</span>' !!}
                </div>
                
                <h5>2. Laporan/Ulasan Oleh PPP</h5>
                <div class="p-3 mb-4 bg-light rounded">
                    {!! $skt->ulasan_akhir_ppp ? nl2br(e($skt->ulasan_akhir_ppp)) : '<span class="text-muted">Belum diisi</span>' !!}
                </div>
                
                @can('update', $skt)
                    @if(!$skt->laporan_akhir_pyd || !$skt->ulasan_akhir_ppp)
                    <div class="mt-4">
                        <a href="{{ route('skt.edit', $skt) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-1"></i> 
                            @if(auth()->user()->isPYD() && !$skt->laporan_akhir_pyd)
                                Isi Laporan Akhir
                            @elseif(auth()->user()->isPPP() && !$skt->ulasan_akhir_ppp)
                                Isi Ulasan Akhir
                            @endif
                        </a>
                    </div>
                    @endif
                @endcan
            </div>
        </div>
    @endif
</div>
@endsection