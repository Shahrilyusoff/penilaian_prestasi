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

    <div class="card shadow">
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5>Maklumat Asas</h5>
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">PYD</th>
                            <td>{{ $skt->pyd->name }}</td>
                        </tr>
                        <tr>
                            <th>PPP</th>
                            <td>{{ $skt->ppp->name }}</td>
                        </tr>
                        <tr>
                            <th>Tahun</th>
                            <td>{{ $skt->evaluationPeriod->tahun }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($skt->status === 'draf')
                                    <span class="badge bg-secondary">Draf</span>
                                @elseif($skt->status === 'diserahkan')
                                    <span class="badge bg-warning">Diserahkan</span>
                                @else
                                    <span class="badge bg-success">Disahkan</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-12">
                    <h5>Bahagian I - Penetapan Sasaran Kerja Tahunan</h5>
                    @if($skt->aktiviti_projek)
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th width="50%">Aktiviti/Projek</th>
                                <th>Petunjuk Prestasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $aktiviti = json_decode($skt->aktiviti_projek, true);
                                $petunjuk = json_decode($skt->petunjuk_prestasi, true);
                            @endphp
                            
                            @for($i = 0; $i < count($aktiviti); $i++)
                                <tr>
                                    <td>{{ $aktiviti[$i] }}</td>
                                    <td>{{ $petunjuk[$i] }}</td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                    @else
                    <div class="alert alert-info">Tiada maklumat SKT awal tahun.</div>
                    @endif
                </div>
            </div>

            @if($skt->tambahan_pertengahan_tahun || $skt->guguran_pertengahan_tahun)
            <div class="row mb-4">
                <div class="col-md-12">
                    <h5>Bahagian II - Kajian Semula Pertengahan Tahun</h5>
                    
                    @if($skt->tambahan_pertengahan_tahun)
                    <div class="mb-3">
                        <h6>Aktiviti/Projek Yang Ditambah</h6>
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th width="50%">Aktiviti/Projek</th>
                                    <th>Petunjuk Prestasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $tambahan = json_decode($skt->tambahan_pertengahan_tahun, true);
                                @endphp
                                
                                @foreach($tambahan as $item)
                                    <tr>
                                        <td>{{ $item['aktiviti'] }}</td>
                                        <td>{{ $item['petunjuk'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                    
                    @if($skt->guguran_pertengahan_tahun)
                    <div class="mb-3">
                        <h6>Aktiviti/Projek Yang Digugurkan</h6>
                        <ul>
                            @php
                                $guguran = json_decode($skt->guguran_pertengahan_tahun, true);
                            @endphp
                            
                            @foreach($guguran as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <div class="row mb-4">
                <div class="col-md-12">
                    <h5>Bahagian III - Laporan dan Ulasan Akhir Tahun</h5>
                    
                    @if($skt->laporan_akhir_pyd)
                    <div class="mb-3">
                        <h6>Laporan/Ulasan Oleh PYD</h6>
                        <div class="p-3 bg-light rounded">
                            {!! nl2br(e($skt->laporan_akhir_pyd)) !!}
                        </div>
                    </div>
                    @endif
                    
                    @if($skt->ulasan_akhir_ppp)
                    <div class="mb-3">
                        <h6>Laporan/Ulasan Oleh PPP</h6>
                        <div class="p-3 bg-light rounded">
                            {!! nl2br(e($skt->ulasan_akhir_ppp)) !!}
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            @if(auth()->user()->isPYD() && $skt->status === 'draf')
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="{{ route('skt.edit', $skt) }}" class="btn btn-warning me-md-2">
                    <i class="fas fa-edit me-1"></i> Kemaskini
                </a>
                <form action="{{ route('skt.submit', $skt) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary" onclick="return confirm('Adakah anda pasti untuk serahkan SKT ini?')">
                        <i class="fas fa-paper-plane me-1"></i> Serahkan
                    </button>
                </form>
            </div>
            @endif

            @if(auth()->user()->isPPP() && $skt->status === 'diserahkan')
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <form action="{{ route('skt.approve', $skt) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success" onclick="return confirm('Adakah anda pasti untuk sahkan SKT ini?')">
                        <i class="fas fa-check me-1"></i> Sahkan
                    </button>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection