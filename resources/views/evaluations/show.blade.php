@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2 class="fw-bold">Penilaian Prestasi</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('evaluations.index') }}">Penilaian</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Lihat</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Maklumat Penilaian</h6>
            @can('update', $evaluation)
            <a href="{{ route('evaluations.edit', $evaluation) }}" class="btn btn-sm btn-primary">
                <i class="fas fa-edit"></i> Kemaskini
            </a>
            @endcan
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <p><strong>Tempoh Penilaian:</strong> {{ $evaluation->evaluationPeriod->tahun }}</p>
                </div>
                <div class="col-md-4">
                    <p><strong>PYD:</strong> {{ $evaluation->pyd->name }}</p>
                </div>
                <div class="col-md-4">
                    <p><strong>Status:</strong> 
                        @if($evaluation->status === 'draf_pyd')
                            <span class="badge bg-secondary">Draf (PYD)</span>
                        @elseif($evaluation->status === 'draf_ppp')
                            <span class="badge bg-info">Draf (PPP)</span>
                        @elseif($evaluation->status === 'draf_ppk')
                            <span class="badge bg-warning">Draf (PPK)</span>
                        @else
                            <span class="badge bg-success">Selesai</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stepper Navigation -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link @if(request()->get('bahagian') === 'I' || !request()->has('bahagian')) active @endif" 
                            id="pills-bahagianI-tab" 
                            data-bs-toggle="pill" 
                            data-bs-target="#pills-bahagianI" 
                            type="button" 
                            role="tab">
                        Bahagian I
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link @if(request()->get('bahagian') === 'II') active @endif" 
                            id="pills-bahagianII-tab" 
                            data-bs-toggle="pill" 
                            data-bs-target="#pills-bahagianII" 
                            type="button" 
                            role="tab">
                        Bahagian II
                        @if($evaluation->canEditBahagian('II', auth()->user()))
                            <span class="text-danger">*</span>
                        @elseif($evaluation->kegiatan_sumbangan && $evaluation->latihan_dihadiri && $evaluation->latihan_diperlukan)
                            <i class="fas fa-check text-success ms-1"></i>
                        @endif
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link @if(request()->get('bahagian') === 'III') active @endif" 
                            id="pills-bahagianIII-tab" 
                            data-bs-toggle="pill" 
                            data-bs-target="#pills-bahagianIII" 
                            type="button" 
                            role="tab">
                        Bahagian III
                        @if($evaluation->canEditBahagian('III', auth()->user()))
                            <span class="text-danger">*</span>
                        @elseif($evaluation->scores->where('markah_ppp', '!=', null)->where('markah_ppk', '!=', null)->count() === $evaluation->scores->where('criteria.bahagian', 'III')->count())
                            <i class="fas fa-check text-success ms-1"></i>
                        @endif
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link @if(request()->get('bahagian') === 'IV') active @endif" 
                            id="pills-bahagianIV-tab" 
                            data-bs-toggle="pill" 
                            data-bs-target="#pills-bahagianIV" 
                            type="button" 
                            role="tab">
                        Bahagian IV
                        @if($evaluation->canEditBahagian('IV', auth()->user()))
                            <span class="text-danger">*</span>
                        @elseif($evaluation->scores->where('markah_ppp', '!=', null)->where('markah_ppk', '!=', null)->count() === $evaluation->scores->where('criteria.bahagian', 'IV')->count())
                            <i class="fas fa-check text-success ms-1"></i>
                        @endif
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link @if(request()->get('bahagian') === 'V') active @endif" 
                            id="pills-bahagianV-tab" 
                            data-bs-toggle="pill" 
                            data-bs-target="#pills-bahagianV" 
                            type="button" 
                            role="tab">
                        Bahagian V
                        @if($evaluation->canEditBahagian('V', auth()->user()))
                            <span class="text-danger">*</span>
                        @elseif($evaluation->scores->where('markah_ppp', '!=', null)->where('markah_ppk', '!=', null)->count() === $evaluation->scores->where('criteria.bahagian', 'V')->count())
                            <i class="fas fa-check text-success ms-1"></i>
                        @endif
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link @if(request()->get('bahagian') === 'VI') active @endif" 
                            id="pills-bahagianVI-tab" 
                            data-bs-toggle="pill" 
                            data-bs-target="#pills-bahagianVI" 
                            type="button" 
                            role="tab">
                        Bahagian VI
                        @if($evaluation->canEditBahagian('VI', auth()->user()))
                            <span class="text-danger">*</span>
                        @elseif($evaluation->scores->where('markah_ppp', '!=', null)->where('markah_ppk', '!=', null)->count() === $evaluation->scores->where('criteria.bahagian', 'VI')->count())
                            <i class="fas fa-check text-success ms-1"></i>
                        @endif
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link @if(request()->get('bahagian') === 'VII') active @endif" 
                            id="pills-bahagianVII-tab" 
                            data-bs-toggle="pill" 
                            data-bs-target="#pills-bahagianVII" 
                            type="button" 
                            role="tab">
                        Bahagian VII
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link @if(request()->get('bahagian') === 'VIII') active @endif" 
                            id="pills-bahagianVIII-tab" 
                            data-bs-toggle="pill" 
                            data-bs-target="#pills-bahagianVIII" 
                            type="button" 
                            role="tab">
                        Bahagian VIII
                        @if($evaluation->canEditBahagian('VIII', auth()->user()))
                            <span class="text-danger">*</span>
                        @elseif($evaluation->ulasan_keseluruhan_ppp)
                            <i class="fas fa-check text-success ms-1"></i>
                        @endif
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link @if(request()->get('bahagian') === 'IX') active @endif" 
                            id="pills-bahagianIX-tab" 
                            data-bs-toggle="pill" 
                            data-bs-target="#pills-bahagianIX" 
                            type="button" 
                            role="tab">
                        Bahagian IX
                        @if($evaluation->canEditBahagian('IX', auth()->user()))
                            <span class="text-danger">*</span>
                        @elseif($evaluation->ulasan_keseluruhan_ppk)
                            <i class="fas fa-check text-success ms-1"></i>
                        @endif
                    </button>
                </li>
            </ul>
        </div>
    </div>

    <!-- Tab Content -->
    <div class="tab-content" id="pills-tabContent">
        <!-- Bahagian I -->
        <div class="tab-pane fade @if(request()->get('bahagian') === 'I' || !request()->has('bahagian')) show active @endif" 
             id="pills-bahagianI" 
             role="tabpanel" 
             aria-labelledby="pills-bahagianI-tab">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Bahagian I - Maklumat Pegawai</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th width="30%">Nama</th>
                                    <td>{{ $evaluation->pyd->name }}</td>
                                </tr>
                                <tr>
                                    <th>Jawatan dan Gred</th>
                                    <td>{{ $evaluation->pyd->jawatan }} ({{ $evaluation->pyd->gred }})</td>
                                </tr>
                                <tr>
                                    <th>Kementerian/Jabatan</th>
                                    <td>{{ $evaluation->pyd->kementerian_jabatan }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bahagian II -->
        <div class="tab-pane fade @if(request()->get('bahagian') === 'II') show active @endif" 
             id="pills-bahagianII" 
             role="tabpanel" 
             aria-labelledby="pills-bahagianII-tab">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Bahagian II - Kegiatan dan Sumbangan di Luar Tugas Rasmi/Latihan</h6>
                    @if($evaluation->canEditBahagian('II', auth()->user()))
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editBahagianIIModal">
                        <i class="fas fa-edit"></i> Kemaskini
                    </button>
                    @endif
                </div>
                <div class="card-body">
                    <h5>1. Kegiatan dan Sumbangan di Luar Tugas Rasmi</h5>
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="50%">Kegiatan/Aktiviti/Sumbangan</th>
                                    <th>Peringkat (Jawatan/Pencapaian)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($evaluation->kegiatan_sumbangan)
                                    @foreach(json_decode($evaluation->kegiatan_sumbangan, true) as $activity)
                                        <tr>
                                            <td>{{ $activity['kegiatan'] }}</td>
                                            <td>{{ $activity['peringkat'] }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="2" class="text-center">Tiada maklumat</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <h5>2. Latihan</h5>
                    <h6>i) Latihan Dihadiri</h6>
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="40%">Nama Latihan (Sijil jika ada)</th>
                                    <th width="30%">Tarikh/Tempoh</th>
                                    <th>Tempat</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($evaluation->latihan_dihadiri)
                                    @foreach(json_decode($evaluation->latihan_dihadiri, true) as $training)
                                        <tr>
                                            <td>{{ $training['nama'] }}</td>
                                            <td>{{ $training['tarikh'] }}</td>
                                            <td>{{ $training['tempat'] }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3" class="text-center">Tiada maklumat</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <h6>ii) Latihan Diperlukan</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="50%">Nama/Bidang Latihan</th>
                                    <th>Sebab Diperlukan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($evaluation->latihan_diperlukan)
                                    @foreach(json_decode($evaluation->latihan_diperlukan, true) as $required)
                                        <tr>
                                            <td>{{ $required['nama'] }}</td>
                                            <td>{{ $required['sebab'] }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="2" class="text-center">Tiada maklumat</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bahagian III -->
        <div class="tab-pane fade @if(request()->get('bahagian') === 'III') show active @endif" 
             id="pills-bahagianIII" 
             role="tabpanel" 
             aria-labelledby="pills-bahagianIII-tab">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Bahagian III - Penghasilan Kerja (Wajaran 50%)</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('evaluations.update-bahagian', [$evaluation, 'III']) }}">
                        @csrf
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="60%">Kriteria (Dinilai berasaskan SKT)</th>
                                        <th width="20%">PPP</th>
                                        <th width="20%">PPK</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($evaluation->scores->where('criteria.bahagian', 'III') as $score)
                                        <tr>
                                            <td>
                                                <strong>{{ $score->criteria->kriteria }}</strong><br>
                                                <small class="text-muted">{{ $score->criteria->description }}</small>
                                            </td>
                                            <td>
                                                @if($evaluation->canEditBahagian('III', auth()->user()) && auth()->user()->isPPP())
                                                    <select name="markah[{{ $score->id }}]" class="form-select" required>
                                                        <option value="">Pilih</option>
                                                        @for($i = 1; $i <= 10; $i++)
                                                            <option value="{{ $i }}" {{ $score->markah_ppp == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                        @endfor
                                                    </select>
                                                @else
                                                    {{ $score->markah_ppp ?? '-' }}
                                                @endif
                                            </td>
                                            <td>
                                                @if($evaluation->canEditBahagian('III', auth()->user()) && auth()->user()->isPPK())
                                                    <select name="markah[{{ $score->id }}]" class="form-select" required>
                                                        <option value="">Pilih</option>
                                                        @for($i = 1; $i <= 10; $i++)
                                                            <option value="{{ $i }}" {{ $score->markah_ppk == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                        @endfor
                                                    </select>
                                                @else
                                                    {{ $score->markah_ppk ?? '-' }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <th>Jumlah markah mengikut wajaran</th>
                                        <th>{{ $scores['ppp']['III'] ?? 0 }}/50</th>
                                        <th>{{ $scores['ppk']['III'] ?? 0 }}/50</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        @if($evaluation->canEditBahagian('III', auth()->user()))
                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        <!-- Bahagian IV -->
        <div class="tab-pane fade @if(request()->get('bahagian') === 'IV') show active @endif" 
             id="pills-bahagianIV" 
             role="tabpanel" 
             aria-labelledby="pills-bahagianIV-tab">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Bahagian IV - Kualiti Peribadi (Wajaran 25%)</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('evaluations.update-bahagian', [$evaluation, 'IV']) }}">
                        @csrf
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="60%">Kriteria</th>
                                        <th width="20%">PPP</th>
                                        <th width="20%">PPK</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($evaluation->scores->where('criteria.bahagian', 'IV') as $score)
                                        <tr>
                                            <td>
                                                <strong>{{ $score->criteria->kriteria }}</strong><br>
                                                <small class="text-muted">{{ $score->criteria->description }}</small>
                                            </td>
                                            <td>
                                                @if($evaluation->canEditBahagian('IV', auth()->user()) && auth()->user()->isPPP())
                                                    <select name="markah[{{ $score->id }}]" class="form-select" required>
                                                        <option value="">Pilih</option>
                                                        @for($i = 1; $i <= 10; $i++)
                                                            <option value="{{ $i }}" {{ $score->markah_ppp == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                        @endfor
                                                    </select>
                                                @else
                                                    {{ $score->markah_ppp ?? '-' }}
                                                @endif
                                            </td>
                                            <td>
                                                @if($evaluation->canEditBahagian('IV', auth()->user()) && auth()->user()->isPPK())
                                                    <select name="markah[{{ $score->id }}]" class="form-select" required>
                                                        <option value="">Pilih</option>
                                                        @for($i = 1; $i <= 10; $i++)
                                                            <option value="{{ $i }}" {{ $score->markah_ppk == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                        @endfor
                                                    </select>
                                                @else
                                                    {{ $score->markah_ppk ?? '-' }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <th>Jumlah markah mengikut wajaran</th>
                                        <th>{{ $scores['ppp']['IV'] ?? 0 }}/25</th>
                                        <th>{{ $scores['ppk']['IV'] ?? 0 }}/25</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        @if($evaluation->canEditBahagian('IV', auth()->user()))
                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        <!-- Bahagian V -->
        <div class="tab-pane fade @if(request()->get('bahagian') === 'V') show active @endif" 
             id="pills-bahagianV" 
             role="tabpanel" 
             aria-labelledby="pills-bahagianV-tab">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Bahagian V - Pengetahuan dan Kemahiran (Wajaran 20%)</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('evaluations.update-bahagian', [$evaluation, 'V']) }}">
                        @csrf
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="60%">Kriteria</th>
                                        <th width="20%">PPP</th>
                                        <th width="20%">PPK</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($evaluation->scores->where('criteria.bahagian', 'V') as $score)
                                        <tr>
                                            <td>
                                                <strong>{{ $score->criteria->kriteria }}</strong><br>
                                                <small class="text-muted">{{ $score->criteria->description }}</small>
                                            </td>
                                            <td>
                                                @if($evaluation->canEditBahagian('V', auth()->user()) && auth()->user()->isPPP())
                                                    <select name="markah[{{ $score->id }}]" class="form-select" required>
                                                        <option value="">Pilih</option>
                                                        @for($i = 1; $i <= 10; $i++)
                                                            <option value="{{ $i }}" {{ $score->markah_ppp == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                        @endfor
                                                    </select>
                                                @else
                                                    {{ $score->markah_ppp ?? '-' }}
                                                @endif
                                            </td>
                                            <td>
                                                @if($evaluation->canEditBahagian('V', auth()->user()) && auth()->user()->isPPK())
                                                    <select name="markah[{{ $score->id }}]" class="form-select" required>
                                                        <option value="">Pilih</option>
                                                        @for($i = 1; $i <= 10; $i++)
                                                            <option value="{{ $i }}" {{ $score->markah_ppk == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                        @endfor
                                                    </select>
                                                @else
                                                    {{ $score->markah_ppk ?? '-' }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <th>Jumlah markah mengikut wajaran</th>
                                        <th>{{ $scores['ppp']['V'] ?? 0 }}/20</th>
                                        <th>{{ $scores['ppk']['V'] ?? 0 }}/20</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        @if($evaluation->canEditBahagian('V', auth()->user()))
                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        <!-- Bahagian VI -->
        <div class="tab-pane fade @if(request()->get('bahagian') === 'VI') show active @endif" 
             id="pills-bahagianVI" 
             role="tabpanel" 
             aria-labelledby="pills-bahagianVI-tab">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Bahagian VI - Kegiatan dan Sumbangan di Luar Tugas Rasmi (Wajaran 5%)</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('evaluations.update-bahagian', [$evaluation, 'VI']) }}">
                        @csrf
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="60%">Peringkat</th>
                                        <th width="20%">PPP</th>
                                        <th width="20%">PPK</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($evaluation->scores->where('criteria.bahagian', 'VI') as $score)
                                        <tr>
                                            <td>
                                                <strong>{{ $score->criteria->kriteria }}</strong><br>
                                                <small class="text-muted">{{ $score->criteria->description }}</small>
                                            </td>
                                            <td>
                                                @if($evaluation->canEditBahagian('VI', auth()->user()) && auth()->user()->isPPP())
                                                    <select name="markah[{{ $score->id }}]" class="form-select" required>
                                                        <option value="">Pilih</option>
                                                        @for($i = 1; $i <= 10; $i++)
                                                            <option value="{{ $i }}" {{ $score->markah_ppp == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                        @endfor
                                                    </select>
                                                @else
                                                    {{ $score->markah_ppp ?? '-' }}
                                                @endif
                                            </td>
                                            <td>
                                                @if($evaluation->canEditBahagian('VI', auth()->user()) && auth()->user()->isPPK())
                                                    <select name="markah[{{ $score->id }}]" class="form-select" required>
                                                        <option value="">Pilih</option>
                                                        @for($i = 1; $i <= 10; $i++)
                                                            <option value="{{ $i }}" {{ $score->markah_ppk == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                        @endfor
                                                    </select>
                                                @else
                                                    {{ $score->markah_ppk ?? '-' }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <th>Jumlah markah mengikut wajaran</th>
                                        <th>{{ $scores['ppp']['VI'] ?? 0 }}/5</th>
                                        <th>{{ $scores['ppk']['VI'] ?? 0 }}/5</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        @if($evaluation->canEditBahagian('VI', auth()->user()))
                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        <!-- Bahagian VII -->
        <div class="tab-pane fade @if(request()->get('bahagian') === 'VII') show active @endif" 
             id="pills-bahagianVII" 
             role="tabpanel" 
             aria-labelledby="pills-bahagianVII-tab">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Bahagian VII - Jumlah Markah Keseluruhan</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="60%">Bahagian</th>
                                    <th width="20%">PPP (%)</th>
                                    <th width="20%">PPK (%)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>III - Penghasilan Kerja (50%)</td>
                                    <td>{{ number_format($scores['ppp']['III'] ?? 0, 2) }}</td>
                                    <td>{{ number_format($scores['ppk']['III'] ?? 0, 2) }}</td>
                                </tr>
                                <tr>
                                    <td>IV - Kualiti Peribadi (25%)</td>
                                    <td>{{ number_format($scores['ppp']['IV'] ?? 0, 2) }}</td>
                                    <td>{{ number_format($scores['ppk']['IV'] ?? 0, 2) }}</td>
                                </tr>
                                <tr>
                                    <td>V - Pengetahuan dan Kemahiran (20%)</td>
                                    <td>{{ number_format($scores['ppp']['V'] ?? 0, 2) }}</td>
                                    <td>{{ number_format($scores['ppk']['V'] ?? 0, 2) }}</td>
                                </tr>
                                <tr>
                                    <td>VI - Kegiatan dan Sumbangan (5%)</td>
                                    <td>{{ number_format($scores['ppp']['VI'] ?? 0, 2) }}</td>
                                    <td>{{ number_format($scores['ppk']['VI'] ?? 0, 2) }}</td>
                                </tr>
                                <tr class="table-active">
                                    <th>Jumlah</th>
                                    <th>{{ number_format($scores['ppp']['total'] ?? 0, 2) }}</th>
                                    <th>{{ number_format($scores['ppk']['total'] ?? 0, 2) }}</th>
                                </tr>
                                <tr class="table-success">
                                    <th>Markah Purata</th>
                                    <th colspan="2">{{ number_format($scores['average'] ?? 0, 2) }}</th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bahagian VIII -->
        <div class="tab-pane fade @if(request()->get('bahagian') === 'VIII') show active @endif" 
             id="pills-bahagianVIII" 
             role="tabpanel" 
             aria-labelledby="pills-bahagianVIII-tab">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Bahagian VIII - Ulasan Keseluruhan dan Pengesahan oleh PPP</h6>
                    @if($evaluation->canEditBahagian('VIII', auth()->user()))
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editBahagianVIIIModal">
                        <i class="fas fa-edit"></i> Kemaskini
                    </button>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th width="30%">1. Tempoh PYD bertugas di bawah pengawasan</th>
                                    <td>
                                        Tahun: {{ $evaluation->tempoh_penilaian_ppp_mula ? $evaluation->tempoh_penilaian_ppp_mula->format('Y') : '-' }}<br>
                                        Bulan: {{ $evaluation->tempoh_penilaian_ppp_mula ? $evaluation->tempoh_penilaian_ppp_mula->diffInMonths($evaluation->tempoh_penilaian_ppp_tamat) : '-' }} bulan
                                    </td>
                                </tr>
                                <tr>
                                    <th>2. Ulasan Keseluruhan</th>
                                    <td>
                                        <strong>i) Prestasi Keseluruhan:</strong><br>
                                        {{ $evaluation->ulasan_keseluruhan_ppp ?? '-' }}<br><br>
                                        
                                        <strong>ii) Kemajuan Kerjaya:</strong><br>
                                        {{ $evaluation->kemajuan_kerjaya_ppp ?? '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>3. Pengesahan</th>
                                    <td>
                                        <strong>Nama PPP:</strong> {{ $evaluation->ppp->name ?? '-' }}<br>
                                        <strong>Jawatan:</strong> {{ $evaluation->ppp->jawatan ?? '-' }}<br>
                                        <strong>Kementerian/Jabatan:</strong> {{ $evaluation->ppp->kementerian_jabatan ?? '-' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bahagian IX -->
        <div class="tab-pane fade @if(request()->get('bahagian') === 'IX') show active @endif" 
             id="pills-bahagianIX" 
             role="tabpanel" 
             aria-labelledby="pills-bahagianIX-tab">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Bahagian IX - Ulasan Keseluruhan dan Pengesahan oleh PPK</h6>
                    @if($evaluation->canEditBahagian('IX', auth()->user()))
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editBahagianIXModal">
                        <i class="fas fa-edit"></i> Kemaskini
                    </button>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th width="30%">1. Tempoh PYD bertugas di bawah pengawasan</th>
                                    <td>
                                        Tahun: {{ $evaluation->tempoh_penilaian_ppk_mula ? $evaluation->tempoh_penilaian_ppk_mula->format('Y') : '-' }}<br>
                                        Bulan: {{ $evaluation->tempoh_penilaian_ppk_mula ? $evaluation->tempoh_penilaian_ppk_mula->diffInMonths($evaluation->tempoh_penilaian_ppk_tamat) : '-' }} bulan
                                    </td>
                                </tr>
                                <tr>
                                    <th>2. Ulasan Keseluruhan</th>
                                    <td>
                                        {{ $evaluation->ulasan_keseluruhan_ppk ?? '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>3. Pengesahan</th>
                                    <td>
                                        <strong>Nama PPK:</strong> {{ $evaluation->ppk->name ?? '-' }}<br>
                                        <strong>Jawatan:</strong> {{ $evaluation->ppk->jawatan ?? '-' }}<br>
                                        <strong>Kementerian/Jabatan:</strong> {{ $evaluation->ppk->kementerian_jabatan ?? '-' }}<br>
                                        <strong>No. K.P.:</strong> {{ $evaluation->ppk->no_kp ?? '-' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Submit Button -->
    @if($evaluation->canSubmit(auth()->user()))
    <div class="card shadow mb-4">
        <div class="card-body text-center">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#submitEvaluationModal">
                <i class="fas fa-paper-plane me-1"></i> Hantar Penilaian
            </button>
        </div>
    </div>
    @endif

    <!-- Admin Actions -->
    @can('admin')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tindakan Pentadbir</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('evaluations.reopen', $evaluation) }}" class="mb-3">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">Buka Semula Status</label>
                        <select name="new_status" class="form-select" required>
                            <option value="">Pilih Status</option>
                            <option value="draf_pyd">Draf (PYD)</option>
                            <option value="draf_ppp">Draf (PPP)</option>
                            <option value="draf_ppk">Draf (PPK)</option>
                        </select>
                    </div>
                    <div class="col-md-6 d-flex align-items-end">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-unlock me-1"></i> Buka Semula
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endcan
</div>

<!-- Edit Bahagian II Modal -->
<div class="modal fade" id="editBahagianIIModal" tabindex="-1" aria-labelledby="editBahagianIIModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="{{ route('evaluations.update-bahagian', [$evaluation, 'II']) }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="editBahagianIIModalLabel">Kemaskini Bahagian II</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5>1. Kegiatan dan Sumbangan di Luar Tugas Rasmi</h5>
                    <div id="kegiatan-container">
                        @if($evaluation->kegiatan_sumbangan)
                            @foreach(json_decode($evaluation->kegiatan_sumbangan, true) as $index => $activity)
                                <div class="row mb-3 kegiatan-row">
                                    <div class="col-md-6">
                                        <input type="text" name="kegiatan[{{ $index }}][kegiatan]" class="form-control" placeholder="Kegiatan/Aktiviti/Sumbangan" value="{{ $activity['kegiatan'] }}" required>
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" name="kegiatan[{{ $index }}][peringkat]" class="form-control" placeholder="Peringkat (Jawatan/Pencapaian)" value="{{ $activity['peringkat'] }}" required>
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-danger btn-sm remove-kegiatan"><i class="fas fa-times"></i></button>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="row mb-3 kegiatan-row">
                                <div class="col-md-6">
                                    <input type="text" name="kegiatan[0][kegiatan]" class="form-control" placeholder="Kegiatan/Aktiviti/Sumbangan" required>
                                </div>
                                <div class="col-md-5">
                                    <input type="text" name="kegiatan[0][peringkat]" class="form-control" placeholder="Peringkat (Jawatan/Pencapaian)" required>
                                </div>
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-danger btn-sm remove-kegiatan"><i class="fas fa-times"></i></button>
                                </div>
                            </div>
                        @endif
                    </div>
                    <button type="button" id="add-kegiatan" class="btn btn-sm btn-primary mb-4">
                        <i class="fas fa-plus me-1"></i> Tambah Kegiatan
                    </button>

                    <h5>2. Latihan</h5>
                    <h6>i) Latihan Dihadiri</h6>
                    <div id="latihan-container">
                        @if($evaluation->latihan_dihadiri)
                            @foreach(json_decode($evaluation->latihan_dihadiri, true) as $index => $training)
                                <div class="row mb-3 latihan-row">
                                    <div class="col-md-4">
                                        <input type="text" name="latihan[{{ $index }}][nama]" class="form-control" placeholder="Nama Latihan (Sijil jika ada)" value="{{ $training['nama'] }}" required>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" name="latihan[{{ $index }}][tarikh]" class="form-control" placeholder="Tarikh/Tempoh" value="{{ $training['tarikh'] }}" required>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" name="latihan[{{ $index }}][tempat]" class="form-control" placeholder="Tempat" value="{{ $training['tempat'] }}" required>
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-danger btn-sm remove-latihan"><i class="fas fa-times"></i></button>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="row mb-3 latihan-row">
                                <div class="col-md-4">
                                    <input type="text" name="latihan[0][nama]" class="form-control" placeholder="Nama Latihan (Sijil jika ada)" required>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" name="latihan[0][tarikh]" class="form-control" placeholder="Tarikh/Tempoh" required>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="latihan[0][tempat]" class="form-control" placeholder="Tempat" required>
                                </div>
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-danger btn-sm remove-latihan"><i class="fas fa-times"></i></button>
                                </div>
                            </div>
                        @endif
                    </div>
                    <button type="button" id="add-latihan" class="btn btn-sm btn-primary mb-4">
                        <i class="fas fa-plus me-1"></i> Tambah Latihan
                    </button>

                    <h6>ii) Latihan Diperlukan</h6>
                    <div id="latihan-diperlukan-container">
                        @if($evaluation->latihan_diperlukan)
                            @foreach(json_decode($evaluation->latihan_diperlukan, true) as $index => $required)
                                <div class="row mb-3 latihan-diperlukan-row">
                                    <div class="col-md-6">
                                        <input type="text" name="diperlukan[{{ $index }}][nama]" class="form-control" placeholder="Nama/Bidang Latihan" value="{{ $required['nama'] }}" required>
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" name="diperlukan[{{ $index }}][sebab]" class="form-control" placeholder="Sebab Diperlukan" value="{{ $required['sebab'] }}" required>
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-danger btn-sm remove-diperlukan"><i class="fas fa-times"></i></button>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="row mb-3 latihan-diperlukan-row">
                                <div class="col-md-6">
                                    <input type="text" name="diperlukan[0][nama]" class="form-control" placeholder="Nama/Bidang Latihan" required>
                                </div>
                                <div class="col-md-5">
                                    <input type="text" name="diperlukan[0][sebab]" class="form-control" placeholder="Sebab Diperlukan" required>
                                </div>
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-danger btn-sm remove-diperlukan"><i class="fas fa-times"></i></button>
                                </div>
                            </div>
                        @endif
                    </div>
                    <button type="button" id="add-diperlukan" class="btn btn-sm btn-primary mb-4">
                        <i class="fas fa-plus me-1"></i> Tambah Latihan Diperlukan
                    </button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Bahagian VIII Modal -->
<div class="modal fade" id="editBahagianVIIIModal" tabindex="-1" aria-labelledby="editBahagianVIIIModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('evaluations.update-bahagian', [$evaluation, 'VIII']) }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="editBahagianVIIIModalLabel">Kemaskini Bahagian VIII</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">1. Tempoh PYD bertugas di bawah pengawasan</label>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Tahun Mula</label>
                                <input type="date" name="tempoh_penilaian_mula" class="form-control" 
                                       value="{{ $evaluation->tempoh_penilaian_ppp_mula ? $evaluation->tempoh_penilaian_ppp_mula->format('Y-m-d') : '' }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tahun Tamat</label>
                                <input type="date" name="tempoh_penilaian_tamat" class="form-control" 
                                       value="{{ $evaluation->tempoh_penilaian_ppp_tamat ? $evaluation->tempoh_penilaian_ppp_tamat->format('Y-m-d') : '' }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">2. Ulasan Keseluruhan</label>
                        <div class="mb-3">
                            <label class="form-label">i) Prestasi Keseluruhan</label>
                            <textarea name="ulasan_keseluruhan" class="form-control" rows="3" required>{{ $evaluation->ulasan_keseluruhan_ppp }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">ii) Kemajuan Kerjaya</label>
                            <textarea name="kemajuan_kerjaya" class="form-control" rows="3" required>{{ $evaluation->kemajuan_kerjaya_ppp }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Bahagian IX Modal -->
<div class="modal fade" id="editBahagianIXModal" tabindex="-1" aria-labelledby="editBahagianIXModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('evaluations.update-bahagian', [$evaluation, 'IX']) }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="editBahagianIXModalLabel">Kemaskini Bahagian IX</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">1. Tempoh PYD bertugas di bawah pengawasan</label>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Tahun Mula</label>
                                <input type="date" name="tempoh_penilaian_mula" class="form-control" 
                                       value="{{ $evaluation->tempoh_penilaian_ppk_mula ? $evaluation->tempoh_penilaian_ppk_mula->format('Y-m-d') : '' }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tahun Tamat</label>
                                <input type="date" name="tempoh_penilaian_tamat" class="form-control" 
                                       value="{{ $evaluation->tempoh_penilaian_ppk_tamat ? $evaluation->tempoh_penilaian_ppk_tamat->format('Y-m-d') : '' }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">2. Ulasan Keseluruhan</label>
                        <textarea name="ulasan_keseluruhan" class="form-control" rows="5" required>{{ $evaluation->ulasan_keseluruhan_ppk }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Submit Evaluation Modal -->
<div class="modal fade" id="submitEvaluationModal" tabindex="-1" aria-labelledby="submitEvaluationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('evaluations.submit', $evaluation) }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="submitEvaluationModalLabel">Hantar Penilaian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Adakah anda pasti ingin menghantar penilaian ini?</p>
                    <p>Setelah dihantar, anda tidak akan dapat mengubah bahagian yang telah diisi.</p>
                    <p class="fw-bold">Pastikan semua maklumat adalah tepat sebelum menghantar.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Ya, Hantar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
