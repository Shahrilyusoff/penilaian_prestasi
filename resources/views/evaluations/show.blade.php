@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="fw-bold">Butiran Penilaian Prestasi</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('evaluations.index') }}" class="btn btn-secondary">
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
                            <td>{{ $evaluation->evaluationPeriod->tahun }}</td>
                        </tr>
                        <tr>
                            <th>PYD</th>
                            <td>{{ $evaluation->pyd->name }}</td>
                        </tr>
                        <tr>
                            <th>PPP</th>
                            <td>{{ $evaluation->ppp->name }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">PPK</th>
                            <td>{{ $evaluation->ppk->name }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($evaluation->status == 'selesai')
                                    <span class="badge bg-success">Selesai</span>
                                @else
                                    <span class="badge bg-warning text-dark">{{ ucfirst(str_replace('_', ' ', $evaluation->status)) }}</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Markah Purata</th>
                            <td>
                                @if($evaluation->status == 'selesai')
                                    {{ $evaluation->calculateTotalScore()['purata'] }}%
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <ul class="nav nav-tabs mt-4" id="evaluationTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="bahagian1-tab" data-bs-toggle="tab" data-bs-target="#bahagian1" type="button" role="tab">
                        Bahagian II
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="bahagian2-tab" data-bs-toggle="tab" data-bs-target="#bahagian2" type="button" role="tab">
                        Penilaian PPP
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="bahagian3-tab" data-bs-toggle="tab" data-bs-target="#bahagian3" type="button" role="tab">
                        Penilaian PPK
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="bahagian4-tab" data-bs-toggle="tab" data-bs-target="#bahagian4" type="button" role="tab">
                        Markah Keseluruhan
                    </button>
                </li>
            </ul>

            <div class="tab-content p-3 border border-top-0 rounded-bottom" id="evaluationTabsContent">
                <!-- Bahagian II -->
                <div class="tab-pane fade show active" id="bahagian1" role="tabpanel">
                    <form action="{{ route('evaluations.submit-pyd', $evaluation) }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label">1. KEGIATAN DAN SUMBANGAN DI LUAR TUGAS RASMI</label>
                            <textarea class="form-control @error('kegiatan_sumbangan') is-invalid @enderror" 
                                      name="kegiatan_sumbangan" rows="5"
                                      {{ $evaluation->status != 'draf_pyd' ? 'readonly' : '' }}>{{ old('kegiatan_sumbangan', $evaluation->kegiatan_sumbangan) }}</textarea>
                            @error('kegiatan_sumbangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">2. LATIHAN</label>
                            <div class="mb-3">
                                <label class="form-label">i) Program latihan yang dihadiri</label>
                                <textarea class="form-control @error('latihan_dihadiri') is-invalid @enderror" 
                                          name="latihan_dihadiri" rows="5"
                                          {{ $evaluation->status != 'draf_pyd' ? 'readonly' : '' }}>{{ old('latihan_dihadiri', $evaluation->latihan_dihadiri) }}</textarea>
                                @error('latihan_dihadiri')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">ii) Latihan yang diperlukan</label>
                                <textarea class="form-control @error('latihan_diperlukan') is-invalid @enderror" 
                                          name="latihan_diperlukan" rows="5"
                                          {{ $evaluation->status != 'draf_pyd' ? 'readonly' : '' }}>{{ old('latihan_diperlukan', $evaluation->latihan_diperlukan) }}</textarea>
                                @error('latihan_diperlukan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        @if($evaluation->status == 'draf_pyd' && auth()->user()->isPYD())
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Serahkan</button>
                        </div>
                        @endif
                    </form>
                </div>

                <!-- Penilaian PPP -->
                <div class="tab-pane fade" id="bahagian2" role="tabpanel">
                    @if($evaluation->status != 'draf_pyd')
                    <form action="{{ route('evaluations.submit-ppp', $evaluation) }}" method="POST">
                        @csrf
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Tempoh PYD bertugas di bawah pengawasan</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control @error('tempoh_penilaian_ppp_mula') is-invalid @enderror"
                                            name="tempoh_penilaian_ppp_mula" placeholder="Tahun"
                                            value="{{ old('tempoh_penilaian_ppp_mula', $evaluation->tempoh_penilaian_ppp_mula) }}"
                                            {{ $evaluation->status != 'draf_ppp' ? 'readonly' : '' }}>
                                        @error('tempoh_penilaian_ppp_mula')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control @error('tempoh_penilaian_ppp_tamat') is-invalid @enderror"
                                            name="tempoh_penilaian_ppp_tamat" placeholder="Bulan"
                                            value="{{ old('tempoh_penilaian_ppp_tamat', $evaluation->tempoh_penilaian_ppp_tamat) }}"
                                            {{ $evaluation->status != 'draf_ppp' ? 'readonly' : '' }}>
                                        @error('tempoh_penilaian_ppp_tamat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h5>BAHAGIAN III - PENGHASILAN KERJA (Wajaran 50%)</h5>
                        <div class="table-responsive mb-4">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="60%">Kriteria</th>
                                        <th width="20%">Markah PPP (1-10)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($evaluation->scores->where('criteria.bahagian', 'III') as $score)
                                    <tr>
                                        <td>{{ $score->criteria->kriteria }}</td>
                                        <td>
                                            <input type="number" class="form-control @error('markah_ppp.' . $score->id) is-invalid @enderror" 
                                                   name="markah_ppp[{{ $score->id }}]" min="1" max="10" 
                                                   value="{{ old('markah_ppp.' . $score->id, $score->markah_ppp) }}"
                                                   {{ $evaluation->status != 'draf_ppp' ? 'readonly' : '' }}>
                                            @error('markah_ppp.' . $score->id)
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if($evaluation->pyd->pydGroup)
                            @php
                                $bahagianIV = $evaluation->scores->where('criteria.bahagian', 'IV')
                                    ->where('criteria.kumpulan_pyd', $evaluation->pyd->pydGroup->nama_kumpulan);
                                $bahagianV = $evaluation->scores->where('criteria.bahagian', 'V')
                                    ->where('criteria.kumpulan_pyd', $evaluation->pyd->pydGroup->nama_kumpulan);
                            @endphp

                            @if($bahagianIV->count() > 0)
                            <h5>BAHAGIAN IV - 
                                @if($evaluation->pyd->pydGroup->nama_kumpulan == 'Pegawai Kumpulan Pengurusan dan Professional')
                                    PENGETAHUAN DAN KEMAHIRAN (Wajaran 25%)
                                @else
                                    KUALITI PERIBADI (Wajaran 25%)
                                @endif
                            </h5>
                            <div class="table-responsive mb-4">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="60%">Kriteria</th>
                                            <th width="20%">Markah PPP (1-10)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($bahagianIV as $score)
                                        <tr>
                                            <td>{{ $score->criteria->kriteria }}</td>
                                            <td>
                                                <input type="number" class="form-control @error('markah_ppp.' . $score->id) is-invalid @enderror" 
                                                       name="markah_ppp[{{ $score->id }}]" min="1" max="10" 
                                                       value="{{ old('markah_ppp.' . $score->id, $score->markah_ppp) }}"
                                                       {{ $evaluation->status != 'draf_ppp' ? 'readonly' : '' }}>
                                                @error('markah_ppp.' . $score->id)
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @endif

                            @if($bahagianV->count() > 0)
                            <h5>BAHAGIAN V - 
                                @if($evaluation->pyd->pydGroup->nama_kumpulan == 'Pegawai Kumpulan Pengurusan dan Professional')
                                    KUALITI PERIBADI (Wajaran 20%)
                                @else
                                    PENGETAHUAN DAN KEMAHIRAN (Wajaran 20%)
                                @endif
                            </h5>
                            <div class="table-responsive mb-4">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="60%">Kriteria</th>
                                            <th width="20%">Markah PPP (1-10)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($bahagianV as $score)
                                        <tr>
                                            <td>{{ $score->criteria->kriteria }}</td>
                                            <td>
                                                <input type="number" class="form-control @error('markah_ppp.' . $score->id) is-invalid @enderror" 
                                                       name="markah_ppp[{{ $score->id }}]" min="1" max="10" 
                                                       value="{{ old('markah_ppp.' . $score->id, $score->markah_ppp) }}"
                                                       {{ $evaluation->status != 'draf_ppp' ? 'readonly' : '' }}>
                                                @error('markah_ppp.' . $score->id)
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @endif
                        @endif

                        <h5>BAHAGIAN VI - KEGIATAN DAN SUMBANGAN DI LUAR TUGAS RASMI (Wajaran 5%)</h5>
                        <div class="table-responsive mb-4">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="60%">Peringkat</th>
                                        <th width="20%">Markah PPP (1-10)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($evaluation->scores->where('criteria.bahagian', 'VI') as $score)
                                    <tr>
                                        <td>{{ $score->criteria->kriteria }}</td>
                                        <td>
                                            <input type="number" class="form-control @error('markah_ppp.' . $score->id) is-invalid @enderror" 
                                                   name="markah_ppp[{{ $score->id }}]" min="1" max="10" 
                                                   value="{{ old('markah_ppp.' . $score->id, $score->markah_ppp) }}"
                                                   {{ $evaluation->status != 'draf_ppp' ? 'readonly' : '' }}>
                                            @error('markah_ppp.' . $score->id)
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <h5>BAHAGIAN VIII - ULASAN KESELURUHAN DAN PENGESAHAN OLEH PEGAWAI PENILAI PERTAMA</h5>
                        <div class="mb-3">
                            <label class="form-label">i) Prestasi keseluruhan</label>
                            <textarea class="form-control @error('ulasan_keseluruhan_ppp') is-invalid @enderror" 
                                      name="ulasan_keseluruhan_ppp" rows="5"
                                      {{ $evaluation->status != 'draf_ppp' ? 'readonly' : '' }}>{{ old('ulasan_keseluruhan_ppp', $evaluation->ulasan_keseluruhan_ppp) }}</textarea>
                            @error('ulasan_keseluruhan_ppp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">ii) Kemajuan kerjaya</label>
                            <textarea class="form-control @error('kemajuan_kerjaya_ppp') is-invalid @enderror" 
                                      name="kemajuan_kerjaya_ppp" rows="5"
                                      {{ $evaluation->status != 'draf_ppp' ? 'readonly' : '' }}>{{ old('kemajuan_kerjaya_ppp', $evaluation->kemajuan_kerjaya_ppp) }}</textarea>
                            @error('kemajuan_kerjaya_ppp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @if($evaluation->status == 'draf_ppp' && auth()->user()->isPPP())
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Serahkan</button>
                        </div>
                        @endif
                    </form>
                    @else
                    <div class="alert alert-info">
                        Penilaian belum diserahkan oleh PYD.
                    </div>
                    @endif
                </div>

                <!-- Penilaian PPK -->
                <div class="tab-pane fade" id="bahagian3" role="tabpanel">
                    @if($evaluation->status == 'draf_ppk' || $evaluation->status == 'selesai')
                    <form action="{{ route('evaluations.submit-ppk', $evaluation) }}" method="POST">
                        @csrf
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Tempoh PYD bertugas di bawah pengawasan</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control @error('tempoh_penilaian_ppk_mula') is-invalid @enderror" 
                                            name="tempoh_penilaian_ppk_mula" placeholder="Tahun" 
                                            value="{{ old('tempoh_penilaian_ppk_mula', $evaluation->tempoh_penilaian_ppk_mula) }}"
                                            {{ $evaluation->status != 'draf_ppk' ? 'readonly' : '' }}>
                                        @error('tempoh_penilaian_ppk_mula')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control @error('tempoh_penilaian_ppk_tamat') is-invalid @enderror" 
                                            name="tempoh_penilaian_ppk_tamat" placeholder="Bulan" 
                                            value="{{ old('tempoh_penilaian_ppk_tamat', $evaluation->tempoh_penilaian_ppk_tamat) }}"
                                            {{ $evaluation->status != 'draf_ppk' ? 'readonly' : '' }}>
                                        @error('tempoh_penilaian_ppk_tamat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h5>BAHAGIAN III - PENGHASILAN KERJA (Wajaran 50%)</h5>
                        <div class="table-responsive mb-4">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="60%">Kriteria</th>
                                        <th width="20%">Markah PPK (1-10)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($evaluation->scores->where('criteria.bahagian', 'III') as $score)
                                    <tr>
                                        <td>{{ $score->criteria->kriteria }}</td>
                                        <td>
                                            <input type="number" class="form-control @error('markah_ppk.' . $score->id) is-invalid @enderror" 
                                                   name="markah_ppk[{{ $score->id }}]" min="1" max="10" 
                                                   value="{{ old('markah_ppk.' . $score->id, $score->markah_ppk) }}"
                                                   {{ $evaluation->status != 'draf_ppk' ? 'readonly' : '' }}>
                                            @error('markah_ppk.' . $score->id)
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if($evaluation->pyd->pydGroup)
                            @php
                                $bahagianIV = $evaluation->scores->where('criteria.bahagian', 'IV')
                                    ->where('criteria.kumpulan_pyd', $evaluation->pyd->pydGroup->nama_kumpulan);
                                $bahagianV = $evaluation->scores->where('criteria.bahagian', 'V')
                                    ->where('criteria.kumpulan_pyd', $evaluation->pyd->pydGroup->nama_kumpulan);
                            @endphp

                            @if($bahagianIV->count() > 0)
                            <h5>BAHAGIAN IV - 
                                @if($evaluation->pyd->pydGroup->nama_kumpulan == 'Pegawai Kumpulan Pengurusan dan Professional')
                                    PENGETAHUAN DAN KEMAHIRAN (Wajaran 25%)
                                @else
                                    KUALITI PERIBADI (Wajaran 25%)
                                @endif
                            </h5>
                            <div class="table-responsive mb-4">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="60%">Kriteria</th>
                                            <th width="20%">Markah PPK (1-10)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($bahagianIV as $score)
                                        <tr>
                                            <td>{{ $score->criteria->kriteria }}</td>
                                            <td>
                                                <input type="number" class="form-control @error('markah_ppk.' . $score->id) is-invalid @enderror" 
                                                       name="markah_ppk[{{ $score->id }}]" min="1" max="10" 
                                                       value="{{ old('markah_ppk.' . $score->id, $score->markah_ppk) }}"
                                                       {{ $evaluation->status != 'draf_ppk' ? 'readonly' : '' }}>
                                                @error('markah_ppk.' . $score->id)
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @endif

                            @if($bahagianV->count() > 0)
                            <h5>BAHAGIAN V - 
                                @if($evaluation->pyd->pydGroup->nama_kumpulan == 'Pegawai Kumpulan Pengurusan dan Professional')
                                    KUALITI PERIBADI (Wajaran 20%)
                                @else
                                    PENGETAHUAN DAN KEMAHIRAN (Wajaran 20%)
                                @endif
                            </h5>
                            <div class="table-responsive mb-4">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="60%">Kriteria</th>
                                            <th width="20%">Markah PPK (1-10)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($bahagianV as $score)
                                        <tr>
                                            <td>{{ $score->criteria->kriteria }}</td>
                                            <td>
                                                <input type="number" class="form-control @error('markah_ppk.' . $score->id) is-invalid @enderror" 
                                                       name="markah_ppk[{{ $score->id }}]" min="1" max="10" 
                                                       value="{{ old('markah_ppk.' . $score->id, $score->markah_ppk) }}"
                                                       {{ $evaluation->status != 'draf_ppk' ? 'readonly' : '' }}>
                                                @error('markah_ppk.' . $score->id)
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @endif
                        @endif

                        <h5>BAHAGIAN VI - KEGIATAN DAN SUMBANGAN DI LUAR TUGAS RASMI (Wajaran 5%)</h5>
                        <div class="table-responsive mb-4">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="60%">Peringkat</th>
                                        <th width="20%">Markah PPK (1-10)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($evaluation->scores->where('criteria.bahagian', 'VI') as $score)
                                    <tr>
                                        <td>{{ $score->criteria->kriteria }}</td>
                                        <td>
                                            <input type="number" class="form-control @error('markah_ppk.' . $score->id) is-invalid @enderror" 
                                                   name="markah_ppk[{{ $score->id }}]" min="1" max="10" 
                                                   value="{{ old('markah_ppk.' . $score->id, $score->markah_ppk) }}"
                                                   {{ $evaluation->status != 'draf_ppk' ? 'readonly' : '' }}>
                                            @error('markah_ppk.' . $score->id)
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <h5>BAHAGIAN IX - ULASAN KESELURUHAN DAN PENGESAHAN OLEH PEGAWAI PENILAI KEDUA</h5>
                        <div class="mb-3">
                            <label class="form-label">Ulasan keseluruhan pencapaian prestasi PYD berasaskan ulasan keseluruhan oleh PPP</label>
                            <textarea class="form-control @error('ulasan_keseluruhan_ppk') is-invalid @enderror" 
                                      name="ulasan_keseluruhan_ppk" rows="5"
                                      {{ $evaluation->status != 'draf_ppk' ? 'readonly' : '' }}>{{ old('ulasan_keseluruhan_ppk', $evaluation->ulasan_keseluruhan_ppk) }}</textarea>
                            @error('ulasan_keseluruhan_ppk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @if($evaluation->status == 'draf_ppk' && auth()->user()->isPPK())
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Selesai</button>
                        </div>
                        @endif
                    </form>
                    @else
                    <div class="alert alert-info">
                        @if($evaluation->status == 'draf_pyd')
                            Penilaian belum diserahkan oleh PYD.
                        @elseif($evaluation->status == 'draf_ppp')
                            Penilaian belum diserahkan oleh PPP.
                        @endif
                    </div>
                    @endif
                </div>

                <!-- Markah Keseluruhan -->
                <div class="tab-pane fade" id="bahagian4" role="tabpanel">
                    @if($evaluation->status == 'selesai')
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="60%">Bahagian</th>
                                    <th width="20%">Markah PPP</th>
                                    <th width="20%">Markah PPK</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>BAHAGIAN III - PENGHASILAN KERJA (50%)</td>
                                    <td>{{ $evaluation->calculateSectionScore('III')['ppp'] }}%</td>
                                    <td>{{ $evaluation->calculateSectionScore('III')['ppk'] }}%</td>
                                </tr>
                                
                                @if($evaluation->pyd->pydGroup)
                                    @php
                                        $sectionIV = $evaluation->calculateSectionScore('IV', $evaluation->pyd->pydGroup->nama_kumpulan);
                                        $sectionV = $evaluation->calculateSectionScore('V', $evaluation->pyd->pydGroup->nama_kumpulan);
                                    @endphp
                                    
                                    @if($sectionIV['total'] > 0)
                                    <tr>
                                        <td>BAHAGIAN IV - 
                                            @if($evaluation->pyd->pydGroup->nama_kumpulan == 'Pegawai Kumpulan Pengurusan dan Professional')
                                                PENGETAHUAN DAN KEMAHIRAN (25%)
                                            @else
                                                KUALITI PERIBADI (25%)
                                            @endif
                                        </td>
                                        <td>{{ $sectionIV['ppp'] }}%</td>
                                        <td>{{ $sectionIV['ppk'] }}%</td>
                                    </tr>
                                    @endif
                                    
                                    @if($sectionV['total'] > 0)
                                    <tr>
                                        <td>BAHAGIAN V - 
                                            @if($evaluation->pyd->pydGroup->nama_kumpulan == 'Pegawai Kumpulan Pengurusan dan Professional')
                                                KUALITI PERIBADI (20%)
                                            @else
                                                PENGETAHUAN DAN KEMAHIRAN (20%)
                                            @endif
                                        </td>
                                        <td>{{ $sectionV['ppp'] }}%</td>
                                        <td>{{ $sectionV['ppk'] }}%</td>
                                    </tr>
                                    @endif
                                @endif
                                
                                <tr>
                                    <td>BAHAGIAN VI - KEGIATAN DAN SUMBANGAN DI LUAR TUGAS RASMI (5%)</td>
                                    <td>{{ $evaluation->calculateSectionScore('VI')['ppp'] }}%</td>
                                    <td>{{ $evaluation->calculateSectionScore('VI')['ppk'] }}%</td>
                                </tr>
                                
                                <tr class="table-active">
                                    <th>JUMLAH KESELURUHAN</th>
                                    <th>{{ $evaluation->calculateTotalScore()['ppp'] }}%</th>
                                    <th>{{ $evaluation->calculateTotalScore()['ppk'] }}%</th>
                                </tr>
                                
                                <tr class="table-primary">
                                    <th>PURATA MARKAH KESELURUHAN</th>
                                    <th colspan="2" class="text-center">{{ $evaluation->calculateTotalScore()['purata'] }}%</th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="alert alert-info">
                        Penilaian belum selesai. Markah keseluruhan akan dipaparkan setelah penilaian selesai.
                    </div>
                    @endif
                </div>
            </div>

            <div class="d-flex justify-content-end mt-4">
                @can('update', $evaluation)
                <a href="{{ route('evaluations.edit', $evaluation) }}" class="btn btn-warning me-2">
                    <i class="fas fa-edit me-1"></i> Edit
                </a>
                @endcan

                @can('delete', $evaluation)
                <form action="{{ route('evaluations.destroy', $evaluation) }}" method="POST" style="display: inline-block;">
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
@endsection