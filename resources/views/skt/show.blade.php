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
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Tempoh Penilaian</th>
                            <td>{{ $skt->evaluationPeriod->tahun }}</td>
                        </tr>
                        <tr>
                            <th>PYD</th>
                            <td>{{ $skt->pyd->name }}</td>
                        </tr>
                        <tr>
                            <th>PPP</th>
                            <td>{{ $skt->ppp->name }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($skt->status == 'disahkan')
                                    <span class="badge bg-success">Disahkan</span>
                                @elseif($skt->status == 'diserahkan')
                                    <span class="badge bg-info">Diserahkan</span>
                                @else
                                    <span class="badge bg-warning text-dark">Draf</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Dicipta Pada</th>
                            <td>{{ $skt->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Dikemaskini Pada</th>
                            <td>{{ $skt->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        @if($skt->status == 'diserahkan' || $skt->status == 'disahkan')
                        <tr>
                            <th>Diserahkan Pada</th>
                            <td>{{ $skt->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Bahagian I - Penetapan Sasaran Kerja Tahunan</h5>
                </div>
                <div class="card-body">
                    @php
                        $activities = json_decode($skt->aktiviti_projek, true) ?? [];
                        $indicators = json_decode($skt->petunjuk_prestasi, true) ?? [];
                    @endphp

                    @if(count($activities) > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="45%">Aktiviti/Projek</th>
                                        <th width="45%">Petunjuk Prestasi</th>
                                        <th width="5%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($activities as $index => $activity)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $activity }}</td>
                                            <td>{{ $indicators[$index] ?? '-' }}</td>
                                            <td></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">Tiada aktiviti/projek direkodkan.</p>
                    @endif
                </div>
            </div>

            @if($skt->tambahan_pertengahan_tahun || $skt->guguran_pertengahan_tahun)
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Bahagian II - Kajian Semula Sasaran Kerja Tahunan Pertengahan Tahun</h5>
                </div>
                <div class="card-body">
                    @if($skt->tambahan_pertengahan_tahun)
                        <h6>Aktiviti/Projek Yang Ditambah</h6>
                        @php
                            $addedActivities = json_decode($skt->tambahan_pertengahan_tahun, true);
                        @endphp
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="45%">Aktiviti/Projek</th>
                                        <th width="45%">Petunjuk Prestasi</th>
                                        <th width="5%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($addedActivities as $index => $activity)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $activity['aktiviti'] }}</td>
                                            <td>{{ $activity['petunjuk'] }}</td>
                                            <td></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    @if($skt->guguran_pertengahan_tahun)
                        <h6 class="mt-3">Aktiviti/Projek Yang Digugurkan</h6>
                        @php
                            $removedActivities = json_decode($skt->guguran_pertengahan_tahun, true);
                        @endphp
                        <ul>
                            @foreach($removedActivities as $activity)
                                <li>{{ $activity }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
            @endif

            @if($skt->laporan_akhir_pyd || $skt->ulasan_akhir_ppp)
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Bahagian III - Laporan dan Ulasan Keseluruhan Pencapaian Sasaran Kerja Tahunan Pada akhir Tahun</h5>
                </div>
                <div class="card-body">
                    @if($skt->laporan_akhir_pyd)
                        <h6>Laporan/Ulasan Oleh PYD</h6>
                        <div class="p-3 bg-light rounded">
                            {!! nl2br(e($skt->laporan_akhir_pyd)) !!}
                        </div>
                    @endif

                    @if($skt->ulasan_akhir_ppp)
                        <h6 class="mt-3">Laporan/Ulasan Oleh PPP</h6>
                        <div class="p-3 bg-light rounded">
                            {!! nl2br(e($skt->ulasan_akhir_ppp)) !!}
                        </div>
                    @endif
                </div>
            </div>
            @endif

            <div class="d-flex justify-content-between mt-4">
                <div>
                    @if(auth()->user()->isPYD() && $skt->status == 'draf')
                        <form action="{{ route('skt.submit', $skt) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-paper-plane me-1"></i> Serahkan
                            </button>
                        </form>
                    @endif

                    @if(auth()->user()->isPPP() && $skt->status == 'diserahkan')
                        <form action="{{ route('skt.approve', $skt) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check me-1"></i> Sahkan
                            </button>
                        </form>
                    @endif
                </div>

                <div>
                    @can('update', $skt)
                    <a href="{{ route('skt.edit', $skt) }}" class="btn btn-warning me-2">
                        <i class="fas fa-edit me-1"></i> Edit
                    </a>
                    @endcan

                    @can('delete', $skt)
                    <form action="{{ route('skt.destroy', $skt) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Adakah anda pasti?')">
                            <i class="fas fa-trash me-1"></i> Padam
                        </button>
                    </form>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>
@endsection