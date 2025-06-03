<!-- resources/views/skt/edit-pertengahan.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="fw-bold">Kajian Semula SKT Pertengahan Tahun</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('skt.show', $skt) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">BAHAGIAN II - Kajian Semula Sasaran Kerja Tahunan Pertengahan Tahun</h6>
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
                        </tbody>
                    </table>
                </div>
                
                <div class="mb-3">
                    <button type="button" id="add-row" class="btn btn-success btn-sm">
                        <i class="fas fa-plus me-1"></i> Tambah Baris
                    </button>
                </div>
                
                <div class="alert alert-info mt-4">
                    <i class="fas fa-info-circle me-2"></i>
                    Anda boleh membuat perubahan atau terus simpan tanpa perubahan. 
                    Jika ada perubahan, PPP perlu mengesahkannya.
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