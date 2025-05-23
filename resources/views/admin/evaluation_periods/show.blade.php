@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="fw-bold">Butiran Tempoh Penilaian</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('evaluation-periods.index') }}" class="btn btn-secondary">
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
                            <th width="30%">Jenis</th>
                            <td>{{ $evaluationPeriod->jenis === 'skt' ? 'SKT' : 'Penilaian Prestasi' }}</td>
                        </tr>
                        <tr>
                            <th>Tahun</th>
                            <td>{{ $evaluationPeriod->tahun }}</td>
                        </tr>
                        <tr>
                            <th>Status Semasa</th>
                            <td>
                                @if($evaluationPeriod->is_active)
                                    <span class="badge bg-success">Aktif ({{ $evaluationPeriod->active_period }})</span>
                                @else
                                    <span class="badge bg-secondary">Tidak Aktif</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            @if($evaluationPeriod->jenis === 'skt')
            <div class="row mb-4">
                <div class="col-md-12">
                    <h5>Tempoh SKT</h5>
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Fasa</th>
                                <th>Tarikh Mula</th>
                                <th>Tarikh Tamat</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Awal Tahun</td>
                                <td>{{ $evaluationPeriod->tarikh_mula_awal->format('d/m/Y') }}</td>
                                <td>{{ $evaluationPeriod->tarikh_tamat_awal->format('d/m/Y') }}</td>
                                <td>
                                    @if($evaluationPeriod->active_period === 'awal')
                                        <span class="badge bg-success">Aktif</span>
                                    @elseif($evaluationPeriod->tarikh_tamat_awal->isPast())
                                        <span class="badge bg-secondary">Tamat</span>
                                    @else
                                        <span class="badge bg-info">Akan Datang</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Pertengahan Tahun</td>
                                <td>{{ $evaluationPeriod->tarikh_mula_pertengahan->format('d/m/Y') }}</td>
                                <td>{{ $evaluationPeriod->tarikh_tamat_pertengahan->format('d/m/Y') }}</td>
                                <td>
                                    @if($evaluationPeriod->active_period === 'pertengahan')
                                        <span class="badge bg-success">Aktif</span>
                                    @elseif($evaluationPeriod->tarikh_tamat_pertengahan->isPast())
                                        <span class="badge bg-secondary">Tamat</span>
                                    @else
                                        <span class="badge bg-info">Akan Datang</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Akhir Tahun</td>
                                <td>{{ $evaluationPeriod->tarikh_mula_akhir->format('d/m/Y') }}</td>
                                <td>{{ $evaluationPeriod->tarikh_tamat_akhir->format('d/m/Y') }}</td>
                                <td>
                                    @if($evaluationPeriod->active_period === 'akhir')
                                        <span class="badge bg-success">Aktif</span>
                                    @elseif($evaluationPeriod->tarikh_tamat_akhir->isPast())
                                        <span class="badge bg-secondary">Tamat</span>
                                    @else
                                        <span class="badge bg-info">Akan Datang</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @else
            <div class="row mb-4">
                <div class="col-md-12">
                    <h5>Tempoh Penilaian Prestasi</h5>
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Tarikh Mula</th>
                            <td>{{ $evaluationPeriod->tarikh_mula_penilaian->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <th>Tarikh Tamat</th>
                            <td>{{ $evaluationPeriod->tarikh_tamat_penilaian->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($evaluationPeriod->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @elseif($evaluationPeriod->tarikh_tamat_penilaian->isPast())
                                    <span class="badge bg-secondary">Tamat</span>
                                @else
                                    <span class="badge bg-info">Akan Datang</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection