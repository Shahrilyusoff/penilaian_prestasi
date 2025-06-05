<!-- resources/views/skt/show.blade.php -->
@extends('layouts.app')
@php
    use App\Models\Skt;
@endphp
@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="fw-bold">Maklumat SKT</h2>
        </div>
        <div class="col-md-6 text-end">
            @can('reopen', $skt)
                <form action="{{ route('skt.reopen', $skt) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-lock-open"></i> Buka Semula
                    </button>
                </form>
            @endcan
            <a href="{{ route('skt.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    @can('update', $skt)
        <div class="mb-3">
            <a href="{{ route('skt.edit', $skt) }}" class="btn btn-sm btn-warning">
                <i class="fas fa-user-edit"></i> Ubah PPP
            </a>
        </div>
    @endcan

    <div class="card shadow">
        <div class="card-header py-3">
            <h5 class="m-0 font-weight-bold text-primary">
                Tahun: {{ $skt->evaluationPeriod->tahun }} | 
                PYD: {{ $skt->pyd->name }} | 
                PPP: {{ $skt->ppp->name }}
            </h5>
        </div>
        
        <div class="card-body">
            <ul class="nav nav-tabs" id="sktTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $skt->current_phase === 'awal' ? 'active' : '' }}" 
                            id="awal-tab" data-bs-toggle="tab" data-bs-target="#awal" 
                            type="button" role="tab">
                        Awal Tahun
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $skt->current_phase === 'pertengahan' ? 'active' : '' }}" 
                            id="pertengahan-tab" data-bs-toggle="tab" data-bs-target="#pertengahan" 
                            type="button" role="tab">
                        Pertengahan Tahun
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $skt->current_phase === 'akhir' ? 'active' : '' }}" 
                            id="akhir-tab" data-bs-toggle="tab" data-bs-target="#akhir" 
                            type="button" role="tab">
                        Akhir Tahun
                    </button>
                </li>
            </ul>
            
            <div class="tab-content p-3 border border-top-0" id="sktTabsContent">
                <!-- Awal Tahun Tab -->
                <div class="tab-pane fade {{ $skt->current_phase === 'awal' ? 'show active' : '' }}" 
                     id="awal" role="tabpanel">
                     
                    @if($skt->status === Skt::STATUS_DRAFT && $skt->current_phase === 'awal' && auth()->user()->id === $skt->pyd_id)
                        <form method="POST" action="{{ route('skt.submit-awal', $skt) }}">
                            @csrf
                            <div class="mb-4">
                                <h5>BAHAGIAN I – Penetapan Sasaran Kerja Tahunan</h5>
                                <p class="text-muted">(PYD dan PPP hendaklah berbincang bersama sebelum menetapkan SKT dan petunjuk prestasinya)</p>
                            </div>
                            
                            <div id="skt-awal-container">
                                @if(old('skt_awal', $skt->skt_awal))
                                    @foreach(old('skt_awal', $skt->skt_awal) as $index => $item)
                                        <div class="row mb-3 skt-awal-item">
                                            <div class="col-md-6">
                                                <input type="text" name="skt_awal[{{ $index }}][aktiviti]" 
                                                       class="form-control" placeholder="Aktiviti/Projek" 
                                                       value="{{ $item['aktiviti'] }}" required>
                                            </div>
                                            <div class="col-md-5">
                                                <input type="text" name="skt_awal[{{ $index }}][petunjuk]" 
                                                       class="form-control" placeholder="Petunjuk Prestasi" 
                                                       value="{{ $item['petunjuk'] }}" required>
                                            </div>
                                            <div class="col-md-1">
                                                <button type="button" class="btn btn-danger remove-awal-item">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="row mb-3 skt-awal-item">
                                        <div class="col-md-6">
                                            <input type="text" name="skt_awal[0][aktiviti]" 
                                                   class="form-control" placeholder="Aktiviti/Projek" required>
                                        </div>
                                        <div class="col-md-5">
                                            <input type="text" name="skt_awal[0][petunjuk]" 
                                                   class="form-control" placeholder="Petunjuk Prestasi" required>
                                        </div>
                                        <div class="col-md-1">
                                            <button type="button" class="btn btn-danger remove-awal-item">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="mb-3">
                                <button type="button" id="add-awal-item" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-plus"></i> Tambah Aktiviti
                                </button>
                            </div>
                            
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="submit" class="btn btn-primary">Serahkan</button>
                            </div>
                        </form>
                    @else
                        <div class="mb-4">
                            <h5>BAHAGIAN I – Penetapan Sasaran Kerja Tahunan</h5>
                            <p class="text-muted">(PYD dan PPP hendaklah berbincang bersama sebelum menetapkan SKT dan petunjuk prestasinya)</p>
                        </div>
                        
                        @if($skt->skt_awal)
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="50%">Aktiviti/Projek</th>
                                            <th width="50%">Petunjuk Prestasi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($skt->skt_awal as $item)
                                            <tr>
                                                <td>{{ $item['aktiviti'] }}</td>
                                                <td>{{ $item['petunjuk'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            @if($skt->status === Skt::STATUS_SUBMITTED_AWAL && auth()->user()->id === $skt->ppp_id)
                                <form method="POST" action="{{ route('skt.approve-awal', $skt) }}" class="text-end">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Sahkan</button>
                                </form>
                            @endif
                            
                            @if($skt->skt_awal_approved_at)
                                <div class="alert alert-success mt-3">
                                    <i class="fas fa-check-circle"></i> Disahkan pada: {{ $skt->skt_awal_approved_at->format('d/m/Y H:i') }}
                                </div>
                            @endif
                        @else
                            <div class="alert alert-warning">
                                @if($skt->current_phase === 'awal')
                                    <i class="fas fa-exclamation-circle"></i> PYD belum menyerahkan SKT Awal Tahun
                                @else
                                    <i class="fas fa-exclamation-circle"></i> SKT Awal Tahun tidak diserahkan
                                @endif
                            </div>
                        @endif
                    @endif
                </div>
                
                <!-- Pertengahan Tahun Tab -->
                <div class="tab-pane fade {{ $skt->current_phase === 'pertengahan' ? 'show active' : '' }}" 
                    id="pertengahan" role="tabpanel">
                    
                    @if($skt->canEditPertengahan())
                        <form method="POST" action="{{ route('skt.submit-pertengahan', $skt) }}">
                            @csrf
                            <div class="mb-4">
                                <h5>BAHAGIAN II – Kajian Semula Sasaran Kerja Tahunan Pertengahan Tahun</h5>
                                <p class="text-muted">(PYD boleh mengemaskini SKT yang telah ditetapkan di awal tahun)</p>
                            </div>
                            
                            <div id="skt-pertengahan-container">
                                @foreach(old('skt_pertengahan', $skt->skt_awal ?? []) as $index => $item)
                                    <div class="row mb-3 skt-pertengahan-item">
                                        <div class="col-md-6">
                                            <input type="text" name="skt_pertengahan[{{ $index }}][aktiviti]" 
                                                class="form-control" placeholder="Aktiviti/Projek" 
                                                value="{{ $item['aktiviti'] }}" required>
                                        </div>
                                        <div class="col-md-5">
                                            <input type="text" name="skt_pertengahan[{{ $index }}][petunjuk]" 
                                                class="form-control" placeholder="Petunjuk Prestasi" 
                                                value="{{ $item['petunjuk'] }}" required>
                                        </div>
                                        <div class="col-md-1">
                                            <button type="button" class="btn btn-danger remove-pertengahan-item">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <div class="mb-3">
                                <button type="button" id="add-pertengahan-item" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-plus"></i> Tambah Aktiviti
                                </button>
                            </div>
                            
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="submit" class="btn btn-primary">Serahkan</button>
                            </div>
                        </form>
                    @else
                        <div class="mb-4">
                            <h5>BAHAGIAN II – Kajian Semula Sasaran Kerja Tahunan Pertengahan Tahun</h5>
                        </div>
                        
                        @if($skt->skt_pertengahan)
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="50%">Aktiviti/Projek</th>
                                            <th width="50%">Petunjuk Prestasi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($skt->skt_pertengahan as $item)
                                            <tr>
                                                <td>{{ $item['aktiviti'] }}</td>
                                                <td>{{ $item['petunjuk'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            @if($skt->canApprovePertengahan())
                                <form method="POST" action="{{ route('skt.approve-pertengahan', $skt) }}" class="text-end">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Sahkan</button>
                                </form>
                            @endif
                            
                            @if($skt->skt_pertengahan_approved_at)
                                <div class="alert alert-success mt-3">
                                    <i class="fas fa-check-circle"></i> Disahkan pada: {{ $skt->skt_pertengahan_approved_at->format('d/m/Y H:i') }}
                                </div>
                            @endif
                        @else
                            @if($skt->current_phase === 'pertengahan')
                                @if($skt->status === Skt::STATUS_APPROVED_AWAL)
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle"></i> PYD belum membuat penyesuaian SKT Pertengahan Tahun
                                    </div>
                                @else
                                    <div class="alert alert-warning">
                                        <i class="fas fa-exclamation-circle"></i> SKT Pertengahan Tahun tidak diserahkan
                                    </div>
                                @endif
                            @else
                                <div class="alert alert-secondary">
                                    <i class="fas fa-info-circle"></i> Tiada penyesuaian dibuat untuk pertengahan tahun
                                </div>
                            @endif
                        @endif
                    @endif
                </div>
                
                <!-- Akhir Tahun Tab -->
                <div class="tab-pane fade {{ $skt->current_phase === 'akhir' ? 'show active' : '' }}" 
                     id="akhir" role="tabpanel">
                     
                    <div class="mb-4">
                        <h5>BAHAGIAN III – Laporan dan Ulasan Keseluruhan Pencapaian Sasaran Kerja Tahunan Pada akhir Tahun Oleh PYD dan PPP</h5>
                    </div>
                    
                    @if($skt->current_phase === 'akhir')
                        @if(auth()->user()->id === $skt->pyd_id && !$skt->skt_akhir_pyd)
                            <form method="POST" action="{{ route('skt.submit-akhir', $skt) }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">1. Laporan/Ulasan Oleh PYD</label>
                                    <textarea name="skt_akhir" class="form-control" rows="5" required></textarea>
                                </div>
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="submit" class="btn btn-primary">Serahkan</button>
                                </div>
                            </form>
                        @elseif(auth()->user()->id === $skt->ppp_id && !$skt->skt_akhir_ppp)
                            <form method="POST" action="{{ route('skt.submit-akhir', $skt) }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">2. Laporan/Ulasan Oleh PPP</label>
                                    <textarea name="skt_akhir" class="form-control" rows="5" required></textarea>
                                </div>
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="submit" class="btn btn-primary">Serahkan</button>
                                </div>
                            </form>
                        @endif
                    @endif
                    
                    @if($skt->skt_akhir_pyd)
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <strong>1. Laporan/Ulasan Oleh PYD</strong>
                            </div>
                            <div class="card-body">
                                {!! nl2br(e($skt->skt_akhir_pyd)) !!}
                            </div>
                        </div>
                    @endif
                    
                    @if($skt->skt_akhir_ppp)
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <strong>2. Laporan/Ulasan Oleh PPP</strong>
                            </div>
                            <div class="card-body">
                                {!! nl2br(e($skt->skt_akhir_ppp)) !!}
                            </div>
                        </div>
                    @endif
                    
                    @if($skt->status === Skt::STATUS_COMPLETED)
                        <div class="alert alert-success mt-3">
                            <i class="fas fa-check-circle"></i> SKT Tahun {{ $skt->evaluationPeriod->tahun }} telah selesai
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Dynamic form for Awal Tahun
    let awalIndex = {{ $skt->skt_awal ? count($skt->skt_awal) : 1 }};
    
    document.getElementById('add-awal-item').addEventListener('click', function() {
        const container = document.getElementById('skt-awal-container');
        const newItem = document.createElement('div');
        newItem.className = 'row mb-3 skt-awal-item';
        newItem.innerHTML = `
            <div class="col-md-6">
                <input type="text" name="skt_awal[${awalIndex}][aktiviti]" 
                       class="form-control" placeholder="Aktiviti/Projek" required>
            </div>
            <div class="col-md-5">
                <input type="text" name="skt_awal[${awalIndex}][petunjuk]" 
                       class="form-control" placeholder="Petunjuk Prestasi" required>
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-danger remove-awal-item">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;
        container.appendChild(newItem);
        awalIndex++;
    });
    
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-awal-item')) {
            e.target.closest('.skt-awal-item').remove();
        }
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Dynamic form for Awal Tahun
    let awalIndex = {{ $skt->skt_awal ? count($skt->skt_awal) : 1 }};
    let pertengahanIndex = {{ $skt->skt_awal ? count($skt->skt_awal) : 1 }};
    
    // Awal Tahun
    document.getElementById('add-awal-item')?.addEventListener('click', function() {
        const container = document.getElementById('skt-awal-container');
        const newItem = document.createElement('div');
        newItem.className = 'row mb-3 skt-awal-item';
        newItem.innerHTML = `
            <div class="col-md-6">
                <input type="text" name="skt_awal[${awalIndex}][aktiviti]" 
                       class="form-control" placeholder="Aktiviti/Projek" required>
            </div>
            <div class="col-md-5">
                <input type="text" name="skt_awal[${awalIndex}][petunjuk]" 
                       class="form-control" placeholder="Petunjuk Prestasi" required>
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-danger remove-awal-item">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;
        container.appendChild(newItem);
        awalIndex++;
    });
    
    // Pertengahan Tahun
    document.getElementById('add-pertengahan-item')?.addEventListener('click', function() {
        const container = document.getElementById('skt-pertengahan-container');
        const newItem = document.createElement('div');
        newItem.className = 'row mb-3 skt-pertengahan-item';
        newItem.innerHTML = `
            <div class="col-md-6">
                <input type="text" name="skt_pertengahan[${pertengahanIndex}][aktiviti]" 
                       class="form-control" placeholder="Aktiviti/Projek" required>
            </div>
            <div class="col-md-5">
                <input type="text" name="skt_pertengahan[${pertengahanIndex}][petunjuk]" 
                       class="form-control" placeholder="Petunjuk Prestasi" required>
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-danger remove-pertengahan-item">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;
        container.appendChild(newItem);
        pertengahanIndex++;
    });
    
    // Remove buttons
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-awal-item')) {
            e.target.closest('.skt-awal-item').remove();
        }
        if (e.target.classList.contains('remove-pertengahan-item')) {
            e.target.closest('.skt-pertengahan-item').remove();
        }
    });
});
</script>
@endsection