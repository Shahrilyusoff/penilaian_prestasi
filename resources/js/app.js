import './bootstrap';
import 'bootstrap';

document.addEventListener('DOMContentLoaded', function () {
    // === Sidebar Toggle ===
    const sidebarToggle = document.querySelector('.sidebar-toggle');
    const sidebar = document.querySelector('.sidebar');
    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function () {
            sidebar.classList.toggle('active');
        });
    }

    // === Active Sidebar Menu Highlighting ===
    const currentPath = window.location.pathname;
    const menuItems = document.querySelectorAll('.sidebar-menu a');
    menuItems.forEach(item => {
        if (item.getAttribute('href') === currentPath) {
            item.parentElement.classList.add('active');
        }
    });

    // === Tab Switching with URL Sync ===
    const tabEls = document.querySelectorAll('button[data-bs-toggle="pill"]');
    tabEls.forEach(tabEl => {
        tabEl.addEventListener('shown.bs.tab', function (event) {
            const tabId = event.target.getAttribute('data-bs-target').replace('#pills-bahagian', '');
            const url = new URL(window.location);
            url.searchParams.set('bahagian', tabId);
            window.history.pushState({}, '', url);
        });
    });

    // === Confirm on Admin Reopen ===
    const reopenForm = document.querySelector('form[action*="reopen"]');
    if (reopenForm) {
        reopenForm.addEventListener('submit', function (e) {
            if (!confirm('Adakah anda pasti ingin membuka semula penilaian ini?')) {
                e.preventDefault();
            }
        });
    }

    // === Dynamic Form Fields (Bahagian II) ===
    let kegiatanIndex = window.kegiatanCount || 1;
    let latihanIndex = window.latihanCount || 1;
    let diperlukanIndex = window.diperlukanCount || 1;

    const addRow = (buttonId, containerId, template, counterName, rowClass) => {
        const btn = document.getElementById(buttonId);
        const container = document.getElementById(containerId);
        if (btn && container) {
            btn.addEventListener('click', () => {
                const newRow = document.createElement('div');
                newRow.className = `row mb-3 ${rowClass}`;
                newRow.innerHTML = template(window[counterName]);
                container.appendChild(newRow);
                window[counterName]++;
            });
        }
    };

    // Templates
    const kegiatanTemplate = i => `
        <div class="col-md-6">
            <input type="text" name="kegiatan[${i}][kegiatan]" class="form-control" placeholder="Kegiatan/Aktiviti/Sumbangan" required>
        </div>
        <div class="col-md-5">
            <input type="text" name="kegiatan[${i}][peringkat]" class="form-control" placeholder="Peringkat (Jawatan/Pencapaian)" required>
        </div>
        <div class="col-md-1">
            <button type="button" class="btn btn-danger btn-sm remove-kegiatan"><i class="fas fa-times"></i></button>
        </div>
    `;

    const latihanTemplate = i => `
        <div class="col-md-4">
            <input type="text" name="latihan[${i}][nama]" class="form-control" placeholder="Nama Latihan (Sijil jika ada)" required>
        </div>
        <div class="col-md-3">
            <input type="text" name="latihan[${i}][tarikh]" class="form-control" placeholder="Tarikh/Tempoh" required>
        </div>
        <div class="col-md-4">
            <input type="text" name="latihan[${i}][tempat]" class="form-control" placeholder="Tempat" required>
        </div>
        <div class="col-md-1">
            <button type="button" class="btn btn-danger btn-sm remove-latihan"><i class="fas fa-times"></i></button>
        </div>
    `;

    const diperlukanTemplate = i => `
        <div class="col-md-6">
            <input type="text" name="diperlukan[${i}][nama]" class="form-control" placeholder="Nama/Bidang Latihan" required>
        </div>
        <div class="col-md-5">
            <input type="text" name="diperlukan[${i}][sebab]" class="form-control" placeholder="Sebab Diperlukan" required>
        </div>
        <div class="col-md-1">
            <button type="button" class="btn btn-danger btn-sm remove-diperlukan"><i class="fas fa-times"></i></button>
        </div>
    `;

    // Register Add Buttons
    addRow('add-kegiatan', 'kegiatan-container', kegiatanTemplate, 'kegiatanIndex', 'kegiatan-row');
    addRow('add-latihan', 'latihan-container', latihanTemplate, 'latihanIndex', 'latihan-row');
    addRow('add-diperlukan', 'latihan-diperlukan-container', diperlukanTemplate, 'diperlukanIndex', 'latihan-diperlukan-row');

    // === Remove Rows ===
    document.addEventListener('click', function (e) {
        if (e.target.closest('.remove-kegiatan')) {
            e.target.closest('.kegiatan-row')?.remove();
        }
        if (e.target.closest('.remove-latihan')) {
            e.target.closest('.latihan-row')?.remove();
        }
        if (e.target.closest('.remove-diperlukan')) {
            e.target.closest('.latihan-diperlukan-row')?.remove();
        }
    });

    // === Tab Restore From URL Param ===
    const urlParams = new URLSearchParams(window.location.search);
    const bahagian = urlParams.get('bahagian');
    if (bahagian) {
        const tab = document.querySelector(`.nav-link[data-bs-target="#pills-bahagian${bahagian}"]`);
        if (tab) {
            new bootstrap.Tab(tab).show();
        }
    }
});

// Handle form submission and modal closing
document.addEventListener('DOMContentLoaded', function() {
    const editBahagianIIModal = document.getElementById('editBahagianIIModal');
    if (editBahagianIIModal) {
        editBahagianIIModal.addEventListener('hidden.bs.modal', function () {
            // Refresh the page or specific content after modal closes
            window.location.reload();
        });
    }
});