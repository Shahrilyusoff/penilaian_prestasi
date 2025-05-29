@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2 class="fw-bold">Tambah SKT Baru</h2>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <form method="POST" action="{{ route('skt.store') }}" id="skt-form">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="evaluation_period_id" class="form-label">Tempoh Penilaian</label>
                        <select class="form-select @error('evaluation_period_id') is-invalid @enderror"
                                id="evaluation_period_id" name="evaluation_period_id" required>
                            <option value="">-- Pilih Tempoh --</option>
                            @foreach($evaluationPeriods as $period)
                                @if($period->jenis === 'skt')
                                    <option value="{{ $period->id }}"
                                        {{ old('evaluation_period_id') == $period->id ? 'selected' : '' }}>
                                        {{ $period->tahun }} (SKT)
                                    </option>
                                @endif
                            @endforeach
                        </select>
                        @error('evaluation_period_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div id="assignments-container">
                    <!-- Dynamic assignment fields will be added here -->
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <button type="button" id="add-assignment" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i> Tambah PYD
                        </button>
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('skt.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Template for new assignment (hidden) -->
<div id="assignment-template" style="display: none;">
    <div class="assignment-group card mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-5">
                    <label class="form-label">PYD</label>
                    <select class="form-select pyd-select" name="pyd_ids[]" required>
                        <option value="">-- Pilih PYD --</option>
                        @foreach($pyds as $pyd)
                            <option value="{{ $pyd->id }}" data-name="{{ $pyd->name }}">
                                {{ $pyd->name }} ({{ $pyd->jawatan }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-5">
                    <label class="form-label">PPP</label>
                    <select class="form-select ppp-select" name="ppp_ids[]" required>
                        <option value="">-- Pilih PPP --</option>
                        @foreach($ppps as $ppp)
                            <option value="{{ $ppp->id }}">
                                {{ $ppp->name }} ({{ $ppp->jawatan }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-danger remove-assignment">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Pass old values from Laravel to JS -->
<script>
    const oldSelectedPYDs = @json(old('pyd_ids', []));
    const oldSelectedPPPs = @json(old('ppp_ids', []));
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('assignments-container');
    const addButton = document.getElementById('add-assignment');
    const template = document.getElementById('assignment-template');
    const usedPYDs = new Set();

    // Initialize with old data if exists
    if (Array.isArray(oldSelectedPYDs)) {
        oldSelectedPYDs.forEach(id => usedPYDs.add(id));
    }

    // Rebuild old assignments or one default
    if (Array.isArray(oldSelectedPYDs) && oldSelectedPYDs.length > 0) {
        oldSelectedPYDs.forEach((pydId, index) => {
            const newAssignment = template.cloneNode(true);
            newAssignment.style.display = 'block';
            newAssignment.classList.remove('d-none');
            newAssignment.removeAttribute('id');

            const pydSelect = newAssignment.querySelector('.pyd-select');
            const pppSelect = newAssignment.querySelector('.ppp-select');

            if (pydSelect) {
                pydSelect.value = pydId;
                pydSelect.dataset.previousValue = pydId;
            }

            if (pppSelect && oldSelectedPPPs && oldSelectedPPPs[index]) {
                pppSelect.value = oldSelectedPPPs[index];
            }

            container.appendChild(newAssignment);
        });

        updatePydOptions();
    } else {
        addAssignment(); // Default one
    }

    // Add new assignment
    addButton.addEventListener('click', addAssignment);

    // Remove assignment
    container.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-assignment') ||
            e.target.closest('.remove-assignment')) {
            const assignment = e.target.closest('.assignment-group');
            const pydSelect = assignment.querySelector('.pyd-select');

            if (pydSelect && pydSelect.value) {
                usedPYDs.delete(pydSelect.value);
                updatePydOptions();
            }

            assignment.remove();

            if (container.querySelectorAll('.assignment-group').length === 0) {
                addAssignment();
            }
        }
    });

    // Handle PYD selection
    container.addEventListener('change', function(e) {
        if (e.target.classList.contains('pyd-select')) {
            const select = e.target;
            const prev = select.dataset.previousValue;

            if (prev) {
                usedPYDs.delete(prev);
            }

            if (select.value) {
                usedPYDs.add(select.value);
            }

            select.dataset.previousValue = select.value;
            updatePydOptions();
        }
    });

    function addAssignment() {
        const newAssignment = template.cloneNode(true);
        newAssignment.style.display = 'block';
        newAssignment.classList.remove('d-none');
        newAssignment.removeAttribute('id');
        container.appendChild(newAssignment);
        updatePydOptions();
    }

    function updatePydOptions() {
        const allPydSelects = document.querySelectorAll('.pyd-select');

        allPydSelects.forEach(select => {
            const currentValue = select.value;
            const options = select.querySelectorAll('option');

            options.forEach(option => {
                if (option.value === '' || option.value === currentValue) {
                    option.style.display = '';
                } else {
                    option.style.display = usedPYDs.has(option.value) ? 'none' : '';
                }
            });
        });
    }
});
</script>
@endsection
