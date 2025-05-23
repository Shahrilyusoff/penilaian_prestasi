@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="fw-bold">Kemaskini SKT</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('skt.show', $skt) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <form method="POST" action="{{ route('skt.update', $skt) }}">
                @csrf
                @method('PUT')
                
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
                        </table>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-12">
                        <h5>Bahagian I - Penetapan Sasaran Kerja Tahunan</h5>
                        
                        <div id="skt-items">
                            @php
                                $aktiviti = $skt->aktiviti_projek ? json_decode($skt->aktiviti_projek, true) : [''];
                                $petunjuk = $skt->petunjuk_prestasi ? json_decode($skt->petunjuk_prestasi, true) : [''];
                            @endphp
                            
                            @for($i = 0; $i < count($aktiviti); $i++)
                            <div class="row mb-3 skt-item">
                                <div class="col-md-5">
                                    <label class="form-label">Aktiviti/Projek</label>
                                    <textarea name="aktiviti_projek[]" class="form-control" rows="2" required>{{ old('aktiviti_projek.'.$i, $aktiviti[$i]) }}</textarea>
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label">Petunjuk Prestasi (Kuantiti/Kualiti/Masa/Kos)</label>
                                    <textarea name="petunjuk_prestasi[]" class="form-control" rows="2" required>{{ old('petunjuk_prestasi.'.$i, $petunjuk[$i]) }}</textarea>
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    @if($i === 0)
                                        <button type="button" class="btn btn-success add-skt-item">
                                            <i class="fas fa-plus"></i> Tambah
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-danger remove-skt-item">
                                            <i class="fas fa-minus"></i> Padam
                                        </button>
                                    @endif
                                </div>
                            </div>
                            @endfor
                        </div>
                    </div>
                </div>

                @if($skt->evaluationPeriod->active_period === 'pertengahan')
                <div class="row mb-4">
                    <div class="col-md-12">
                        <h5>Bahagian II - Kajian Semula Pertengahan Tahun</h5>
                        
                        <div id="tambahan-items">
                            <h6>Aktiviti/Projek Yang Ditambah</h6>
                            
                            @php
                                $tambahan = $skt->tambahan_pertengahan_tahun ? json_decode($skt->tambahan_pertengahan_tahun, true) : [['aktiviti' => '', 'petunjuk' => '']];
                            @endphp
                            
                            @for($i = 0; $i < count($tambahan); $i++)
                            <div class="row mb-3 tambahan-item">
                                <div class="col-md-5">
                                    <label class="form-label">Aktiviti/Projek</label>
                                    <textarea name="tambahan_aktiviti[]" class="form-control" rows="2">{{ old('tambahan_aktiviti.'.$i, $tambahan[$i]['aktiviti'] ?? '') }}</textarea>
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label">Petunjuk Prestasi</label>
                                    <textarea name="tambahan_petunjuk[]" class="form-control" rows="2">{{ old('tambahan_petunjuk.'.$i, $tambahan[$i]['petunjuk'] ?? '') }}</textarea>
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    @if($i === 0)
                                        <button type="button" class="btn btn-success add-tambahan-item">
                                            <i class="fas fa-plus"></i> Tambah
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-danger remove-tambahan-item">
                                            <i class="fas fa-minus"></i> Padam
                                        </button>
                                    @endif
                                </div>
                            </div>
                            @endfor
                        </div>
                        
                        <div id="guguran-items">
                            <h6>Aktiviti/Projek Yang Digugurkan</h6>
                            
                            @php
                                $guguran = $skt->guguran_pertengahan_tahun ? json_decode($skt->guguran_pertengahan_tahun, true) : [''];
                            @endphp
                            
                            @for($i = 0; $i < count($guguran); $i++)
                            <div class="row mb-3 guguran-item">
                                <div class="col-md-10">
                                    <label class="form-label">Aktiviti/Projek</label>
                                    <input type="text" name="guguran[]" class="form-control" value="{{ old('guguran.'.$i, $guguran[$i]) }}">
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    @if($i === 0)
                                        <button type="button" class="btn btn-success add-guguran-item">
                                            <i class="fas fa-plus"></i> Tambah
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-danger remove-guguran-item">
                                            <i class="fas fa-minus"></i> Padam
                                        </button>
                                    @endif
                                </div>
                            </div>
                            @endfor
                        </div>
                    </div>
                </div>
                @endif

                @if($skt->evaluationPeriod->active_period === 'akhir')
                <div class="row mb-4">
                    <div class="col-md-12">
                        <h5>Bahagian III - Laporan dan Ulasan Akhir Tahun</h5>
                        
                        <div class="mb-3">
                            <label class="form-label">Laporan/Ulasan Oleh PYD</label>
                            <textarea name="laporan_akhir_pyd" class="form-control" rows="5">{{ old('laporan_akhir_pyd', $skt->laporan_akhir_pyd) }}</textarea>
                        </div>
                    </div>
                </div>
                @endif

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary me-md-2">
                        <i class="fas fa-save me-1"></i> Simpan
                    </button>
                    <a href="{{ route('skt.show', $skt) }}" class="btn btn-secondary">
                        <i class="fas fa-times me-1"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add SKT Item
    document.querySelector('.add-skt-item')?.addEventListener('click', function() {
        const newItem = document.querySelector('.skt-item').cloneNode(true);
        const textareas = newItem.querySelectorAll('textarea');
        textareas.forEach(textarea => textarea.value = '');
        
        const button = newItem.querySelector('.add-skt-item');
        button.classList.replace('btn-success', 'btn-danger');
        button.classList.replace('add-skt-item', 'remove-skt-item');
        button.innerHTML = '<i class="fas fa-minus"></i> Padam';
        
        button.addEventListener('click', function() {
            this.closest('.skt-item').remove();
        });
        
        document.getElementById('skt-items').appendChild(newItem);
    });
    
    // Remove SKT Item
    document.querySelectorAll('.remove-skt-item').forEach(button => {
        button.addEventListener('click', function() {
            this.closest('.skt-item').remove();
        });
    });
    
    // Add Tambahan Item
    document.querySelector('.add-tambahan-item')?.addEventListener('click', function() {
        const newItem = document.querySelector('.tambahan-item').cloneNode(true);
        const inputs = newItem.querySelectorAll('textarea, input');
        inputs.forEach(input => input.value = '');
        
        const button = newItem.querySelector('.add-tambahan-item');
        button.classList.replace('btn-success', 'btn-danger');
        button.classList.replace('add-tambahan-item', 'remove-tambahan-item');
        button.innerHTML = '<i class="fas fa-minus"></i> Padam';
        
        button.addEventListener('click', function() {
            this.closest('.tambahan-item').remove();
        });
        
        document.getElementById('tambahan-items').appendChild(newItem);
    });
    
    // Remove Tambahan Item
    document.querySelectorAll('.remove-tambahan-item').forEach(button => {
        button.addEventListener('click', function() {
            this.closest('.tambahan-item').remove();
        });
    });
    
    // Add Guguran Item
    document.querySelector('.add-guguran-item')?.addEventListener('click', function() {
        const newItem = document.querySelector('.guguran-item').cloneNode(true);
        const input = newItem.querySelector('input');
        input.value = '';
        
        const button = newItem.querySelector('.add-guguran-item');
        button.classList.replace('btn-success', 'btn-danger');
        button.classList.replace('add-guguran-item', 'remove-guguran-item');
        button.innerHTML = '<i class="fas fa-minus"></i> Padam';
        
        button.addEventListener('click', function() {
            this.closest('.guguran-item').remove();
        });
        
        document.getElementById('guguran-items').appendChild(newItem);
    });
    
    // Remove Guguran Item
    document.querySelectorAll('.remove-guguran-item').forEach(button => {
        button.addEventListener('click', function() {
            this.closest('.guguran-item').remove();
        });
    });
});
</script>
@endsection