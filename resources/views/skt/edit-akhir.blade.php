<!-- resources/views/skt/edit-akhir.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="fw-bold">
                @if(auth()->user()->isPYD())
                    Isi Laporan Akhir Tahun
                @else
                    Isi Ulasan Akhir Tahun
                @endif
            </h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('skt.show', $skt) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                BAHAGIAN III - Laporan dan Ulasan Keseluruhan Pencapaian SKT
            </h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('skt.update', $skt) }}">
                @csrf
                @method('PUT')
                
                @if(auth()->user()->isPYD())
                <div class="mb-3">
                    <label class="form-label">1. Laporan/Ulasan Oleh PYD</label>
                    <textarea name="laporan_akhir" class="form-control" rows="5" required>{{ $skt->laporan_akhir_pyd }}</textarea>
                </div>
                @else
                <div class="mb-3">
                    <label class="form-label">2. Laporan/Ulasan Oleh PPP</label>
                    <textarea name="laporan_akhir" class="form-control" rows="5" required>{{ $skt->ulasan_akhir_ppp }}</textarea>
                </div>
                @endif
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection