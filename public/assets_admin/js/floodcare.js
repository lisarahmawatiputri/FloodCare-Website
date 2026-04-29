/* ============================================================
   FloodCare Admin — Custom JavaScript
   ============================================================ */

(function () {
    'use strict';

    /* ----------------------------------------------------------
       DROPDOWN TOGGLE (navbar profile & notifikasi)
    ---------------------------------------------------------- */
    document.querySelectorAll('.fc-dropdown').forEach(function (dropdown) {
        var trigger = dropdown.querySelector('.fc-nav-btn, .fc-profile-btn');
        if (!trigger) return;

        trigger.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            // Tutup semua dropdown lain
            document.querySelectorAll('.fc-dropdown.open').forEach(function (d) {
                if (d !== dropdown) d.classList.remove('open');
            });
            dropdown.classList.toggle('open');
        });
    });

    document.addEventListener('click', function () {
        document.querySelectorAll('.fc-dropdown.open').forEach(function (d) {
            d.classList.remove('open');
        });
    });


    /* ----------------------------------------------------------
       AUTO-SLUG dari judul (form artikel)
    ---------------------------------------------------------- */
    var judulInput = document.getElementById('fc-judul');
    var slugInput  = document.getElementById('fc-slug');
    var slugPreview = document.getElementById('fc-slug-preview');

    if (judulInput && slugInput) {
        judulInput.addEventListener('input', function () {
            var slug = this.value
                .toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim();
            slugInput.value = slug;
            if (slugPreview) slugPreview.textContent = slug || 'slug-artikel';
        });
    }


    /* ----------------------------------------------------------
       PREVIEW THUMBNAIL (form artikel/video)
    ---------------------------------------------------------- */
    var thumbInput   = document.getElementById('fc-thumb-input');
    var thumbPreview = document.getElementById('fc-thumb-preview');
    var thumbImg     = document.getElementById('fc-thumb-img');
    var thumbArea    = document.getElementById('fc-upload-area');
    var thumbClear   = document.getElementById('fc-thumb-clear');

    if (thumbInput) {
        thumbInput.addEventListener('change', function (e) {
            var file = e.target.files[0];
            if (!file) return;
            var reader = new FileReader();
            reader.onload = function (ev) {
                if (thumbImg)     thumbImg.src = ev.target.result;
                if (thumbPreview) thumbPreview.style.display = 'block';
                if (thumbArea)    thumbArea.style.display = 'none';
            };
            reader.readAsDataURL(file);
        });
    }

    if (thumbClear) {
        thumbClear.addEventListener('click', function () {
            if (thumbPreview) thumbPreview.style.display = 'none';
            if (thumbArea)    thumbArea.style.display = 'block';
            if (thumbInput)   thumbInput.value = '';
        });
    }


    /* ----------------------------------------------------------
       STATUS BADGE PREVIEW (form artikel)
    ---------------------------------------------------------- */
    var statusSelect = document.getElementById('fc-status-select');
    var statusBadge  = document.getElementById('fc-status-badge');

    if (statusSelect && statusBadge) {
        statusSelect.addEventListener('change', function () {
            updateStatusBadge(this.value);
        });

        function updateStatusBadge(val) {
            statusBadge.className = 'fc-pub-badge';
            if (val === 'published') {
                statusBadge.classList.add('published');
                statusBadge.textContent = 'Published — aktif';
            } else {
                statusBadge.classList.add('draft');
                statusBadge.textContent = 'Draft — belum dipublikasi';
            }
        }

        // Inisialisasi saat load
        updateStatusBadge(statusSelect.value);
    }


    /* ----------------------------------------------------------
       ALERT AUTO-DISMISS
    ---------------------------------------------------------- */
    document.querySelectorAll('.fc-alert[data-dismiss]').forEach(function (alert) {
        var delay = parseInt(alert.getAttribute('data-dismiss')) || 4000;
        setTimeout(function () {
            alert.style.transition = 'opacity .4s';
            alert.style.opacity = '0';
            setTimeout(function () { alert.remove(); }, 400);
        }, delay);
    });


    /* ----------------------------------------------------------
       CONFIRM DELETE (tombol hapus tabel)
    ---------------------------------------------------------- */
    document.querySelectorAll('[data-confirm]').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            var msg = this.getAttribute('data-confirm') || 'Yakin ingin menghapus data ini?';
            if (!confirm(msg)) {
                e.preventDefault();
            }
        });
    });


    /* ----------------------------------------------------------
       ACTIVE NAV LINK (fallback jika Blade class tidak jalan)
    ---------------------------------------------------------- */
    var currentPath = window.location.pathname;
    document.querySelectorAll('.fc-nav-link').forEach(function (link) {
        if (link.getAttribute('href') && currentPath.startsWith(link.getAttribute('href'))) {
            link.classList.add('active');
        }
    });

    // ——— Preview & handle thumbnail ———
function previewThumb(input) {
    if (!input.files || !input.files[0]) return;
    const file = input.files[0];
    if (file.size > 2 * 1024 * 1024) {
        alert('Ukuran gambar melebihi 2MB.');
        input.value = '';
        return;
    }
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('thumb-preview').src = e.target.result;
        document.getElementById('thumb-preview').style.display = 'block';
        document.getElementById('thumb-placeholder').style.display = 'none';
        const actions = document.getElementById('thumbActions');
        actions.style.display = 'flex';
    };
    reader.readAsDataURL(file);
}

function clearThumb() {
    document.getElementById('thumbnail').value = '';
    document.getElementById('thumb-preview').src = '';
    document.getElementById('thumb-preview').style.display = 'none';
    document.getElementById('thumb-placeholder').style.display = 'flex';
    document.getElementById('thumbActions').style.display = 'none';
}

function handleThumbDrop(e) {
    e.preventDefault();
    document.getElementById('thumbDrop').classList.remove('fc-thumb-drop-hover');
    const file = e.dataTransfer.files[0];
    if (!file || !file.type.startsWith('image/')) return;
    const dt = new DataTransfer();
    dt.items.add(file);
    const input = document.getElementById('thumbnail');
    input.files = dt.files;
    previewThumb(input);
}

// ——— Preview & handle video ———
function previewVideo(input) {
    if (!input.files || !input.files[0]) return;
    const file = input.files[0];
    const maxSize = 500 * 1024 * 1024; // 500MB
    if (file.size > maxSize) {
        alert('Ukuran video melebihi 500MB.');
        input.value = '';
        return;
    }

    const url = URL.createObjectURL(file);
    const videoEl = document.getElementById('video-preview');
    videoEl.src = url;

    // Auto-detect durasi saat metadata video tersedia
    videoEl.onloadedmetadata = function() {
        const secs = Math.round(videoEl.duration);
        document.getElementById('durasi_detik').value = secs;
        updateDurasiFormat(secs);
    };

    // Tampilkan info nama & ukuran file
    const sizeMB = (file.size / (1024 * 1024)).toFixed(1);
    document.getElementById('videoInfo').innerHTML =
        `<i class="mdi mdi-file-video-outline"></i> ${file.name} &bull; ${sizeMB} MB`;

    document.getElementById('video-placeholder').style.display = 'none';
    document.getElementById('video-selected').style.display = 'block';
    document.getElementById('videoActions').style.display = 'flex';
}

function clearVideo() {
    document.getElementById('file_video').value = '';
    const videoEl = document.getElementById('video-preview');
    videoEl.src = '';
    document.getElementById('video-placeholder').style.display = 'flex';
    document.getElementById('video-selected').style.display = 'none';
    document.getElementById('videoActions').style.display = 'none';
    document.getElementById('durasi_detik').value = '';
    document.getElementById('durasiFormatted').textContent = '';
}

function handleVideoDrop(e) {
    e.preventDefault();
    document.getElementById('videoDrop').classList.remove('fc-video-drop-hover');
    const file = e.dataTransfer.files[0];
    if (!file || !file.type.startsWith('video/')) {
        alert('File harus berupa video (MP4, MOV, AVI, dll).');
        return;
    }
    const dt = new DataTransfer();
    dt.items.add(file);
    const input = document.getElementById('file_video');
    input.files = dt.files;
    previewVideo(input);
}

// ——— Format durasi MM:SS ———
function updateDurasiFormat(secs) {
    const el = document.getElementById('durasiFormatted');
    if (!isNaN(secs) && secs >= 0) {
        const m = Math.floor(secs / 60);
        const s = secs % 60;
        el.textContent = `= ${m}:${String(s).padStart(2,'0')} menit`;
    } else {
        el.textContent = '';
    }
}

document.getElementById('durasi_detik').addEventListener('input', function() {
    updateDurasiFormat(parseInt(this.value));
});

// ——— Char counter judul ———
document.getElementById('judul').addEventListener('input', function() {
    document.getElementById('judulCount').textContent = this.value.length + '/50';
});

// ——— Radio card highlight ———
function updateStatusCard() {
    document.querySelectorAll('.fc-radio-card').forEach(card => {
        const radio = card.querySelector('input[type="radio"]');
        card.classList.toggle('fc-radio-card-active', radio.checked);
    });
}
document.querySelectorAll('.fc-radio-card input').forEach(r => {
    r.addEventListener('change', updateStatusCard);
});


// Tab switching
document.querySelectorAll('.user-tab-btn').forEach(function(btn) {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.user-tab-btn').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.user-tab-pane').forEach(p => p.classList.remove('active'));
        this.classList.add('active');
        document.getElementById('tab-' + this.dataset.tab).classList.add('active');
    });
});

// Tutup modal klik backdrop
var modalRole = document.getElementById('modal-role');
if (modalRole) {
    modalRole.addEventListener('click', function(e) {
        if (e.target === this) this.style.display = 'none';
    });
}

/* ============================================================
   FloodCare Admin — Kelola User JavaScript
   Covers: index (list) + show (detail) pages
   ============================================================ */

(function () {
    'use strict';

    /* ----------------------------------------------------------
       TAB SWITCHING — halaman show (Laporan / Konfirmasi)
    ---------------------------------------------------------- */
    document.querySelectorAll('.user-tab-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            // Nonaktifkan semua tab
            document.querySelectorAll('.user-tab-btn').forEach(function (b) {
                b.classList.remove('active');
            });
            document.querySelectorAll('.user-tab-pane').forEach(function (p) {
                p.classList.remove('active');
            });

            // Aktifkan tab yang diklik
            this.classList.add('active');
            var target = document.getElementById('tab-' + this.dataset.tab);
            if (target) target.classList.add('active');
        });
    });


    /* ----------------------------------------------------------
       MODAL UBAH ROLE — tutup saat klik backdrop
    ---------------------------------------------------------- */
    var modalRole = document.getElementById('modal-role');
    if (modalRole) {
        modalRole.addEventListener('click', function (e) {
            if (e.target === this) this.style.display = 'none';
        });
    }


    /* ----------------------------------------------------------
       CONFIRM — tombol aksi berbahaya (blokir, nonaktifkan, dll)
       Sudah ada di admin.js global, tapi disertakan di sini
       sebagai fallback jika halaman user load mandiri.
    ---------------------------------------------------------- */
    document.querySelectorAll('[data-confirm]').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            var msg = this.getAttribute('data-confirm') || 'Yakin ingin melakukan aksi ini?';
            if (!confirm(msg)) {
                e.preventDefault();
            }
        });
    });


    /* ----------------------------------------------------------
       SEARCH — filter live sederhana (opsional, tanpa AJAX)
       Memfilter baris tabel berdasarkan input pencarian.
    ---------------------------------------------------------- */
    var searchInput = document.querySelector('.user-search-input');
    var tableBody   = document.querySelector('.fc-table tbody');

    if (searchInput && tableBody) {
        searchInput.addEventListener('input', function () {
            var q = this.value.toLowerCase().trim();
            tableBody.querySelectorAll('tr').forEach(function (row) {
                var text = row.textContent.toLowerCase();
                row.style.display = q === '' || text.includes(q) ? '' : 'none';
            });
        });
    }

})();

/* ============================================================
   FloodCare — laporan.js
   Taruh di public/js/laporan.js
   Load di blade: @push('scripts') <script src="{{ asset('js/laporan.js') }}"></script> @endpush
   ============================================================ */

let _deleteTarget = null;

/* ── Modal helpers ── */
function openModal(id) {
    document.getElementById(id).classList.add('open');
}

function closeModal(id) {
    document.getElementById(id).classList.remove('open');
}

/* Tutup modal kalau klik overlay */
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.flp-modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', e => {
            if (e.target === overlay) overlay.classList.remove('open');
        });
    });
});

/* ── Index page: konfirmasi hapus ── */
function confirmDelete(id) {
    _deleteTarget = id;
    openModal('deleteModal');
}

function doDelete() {
    if (!_deleteTarget) return;
    // TODO: ganti dengan form submit atau fetch ke route delete
    // Contoh:
    // fetch(`/admin/laporan/${_deleteTarget}`, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content } })
    //   .then(() => location.reload());
    console.log('Hapus laporan ID:', _deleteTarget);
    closeModal('deleteModal');
    _deleteTarget = null;
}

/* ── Show page: konfirmasi tidak valid ── */
function confirmInvalid() {
    openModal('invalidModal');
}

function doInvalid() {
    // TODO: set status ke tidak_valid lalu submit
    console.log('Tandai tidak valid');
    closeModal('invalidModal');
}

/* ── Export ── */
function exportLaporan() {
    // TODO: arahkan ke route export
    // window.location.href = '/admin/laporan/export';
    alert('Fitur export belum terhubung ke controller.');
}

})();
