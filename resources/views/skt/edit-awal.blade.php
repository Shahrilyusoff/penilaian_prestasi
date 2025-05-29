<!-- resources/views/skt/edit-awal.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="fw-bold">Isi SKT Awal Tahun</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('skt.show', $skt) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">BAHAGIAN I - Penetapan Sasaran Kerja Tahunan</h6>
            <p class="mb-0"><small>(PYD dan PPP hendaklah berbincang bersama sebelum menetapkan SKT dan petunjuk prestasinya)</small></p>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('skt.update', $skt) }}">
                @csrf
                @method('PUT')
                
                <div class="table-responsive">
                    <table class="table table-bordered" id="skt-table">
                        <thead>
                            <tr>
                                <th width="50%">Ringkasan Aktiviti/Projek<br><small>(Senaraikan aktiviti/projek)</small></th>
                                <th width="50%">Petunjuk Prestasi<br><small>(Kuantiti/Kualiti/Masa/Kos)</small></th>
                                <th width="40px">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($skt->aktiviti_projek)
                                @foreach(json_decode($skt->aktiviti_projek, true) as $index => $item)
                                <tr>
                                    <td>
                                        <input type="text" name="aktiviti_projek[]" class="form-control" 
                                               value="{{ $item['aktiviti'] }}" required>
                                    </td>
                                    <td>
                                        <input type="text" name="petunjuk_prestasi[]" class="form-control" 
                                               value="{{ $item['petunjuk'] }}" required>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-danger btn-sm remove-row">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td>
                                        <input type="text" name="aktiviti_projek[]" class="form-control" required>
                                    </td>
                                    <td>
                                        <input type="text" name="petunjuk_prestasi[]" class="form-control" required>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-danger btn-sm remove-row">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                
                <div class="mb-3">
                    <button type="button" id="add-row" class="btn btn-success btn-sm">
                        <i class="fas fa-plus me-1"></i> Tambah Baris
                    </button>
                </div>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add new row
    document.getElementById('add-row').addEventListener('click', function() {
        const tbody = document.querySelector('#skt-table tbody');
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td>
                <input type="text" name="aktiviti_projek[]" class="form-control" required>
            </td>
            <td>
                <input type="text" name="petunjuk_prestasi[]" class="form-control" required>
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-danger btn-sm remove-row">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        `;
        tbody.appendChild(newRow);
    });
    
    // Remove row
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-row')) {
            const row = e.target.closest('tr');
            if (document.querySelectorAll('#skt-table tbody tr').length > 1) {
                row.remove();
            } else {
                // Clear inputs if it's the last row
                const inputs = row.querySelectorAll('input');
                inputs.forEach(input => input.value = '');
            }
        }
    });
});
</script>
@endsection