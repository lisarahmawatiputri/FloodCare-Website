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
       ACTIVE NAV LINK
    ---------------------------------------------------------- */
    var currentPath = window.location.pathname;
    document.querySelectorAll('.fc-nav-link').forEach(function (link) {
        if (link.getAttribute('href') && currentPath.startsWith(link.getAttribute('href'))) {
            link.classList.add('active');
        }
    });


    /* ----------------------------------------------------------
       TAB SWITCHING — halaman show user (Laporan / Konfirmasi)
    ---------------------------------------------------------- */
    document.querySelectorAll('.user-tab-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.user-tab-btn').forEach(function (b) {
                b.classList.remove('active');
            });
            document.querySelectorAll('.user-tab-pane').forEach(function (p) {
                p.classList.remove('active');
            });
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
       SEARCH — filter live tabel user
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


    /* ----------------------------------------------------------
       MODAL LAPORAN — helpers
    ---------------------------------------------------------- */
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.flp-modal-overlay').forEach(function (overlay) {
            overlay.addEventListener('click', function (e) {
                if (e.target === overlay) overlay.classList.remove('open');
            });
        });
    });


    /* ----------------------------------------------------------
       DURASI VIDEO — format MM:SS
    ---------------------------------------------------------- */
    var durasiEl = document.getElementById('durasi_detik');
    if (durasiEl) {
        durasiEl.addEventListener('input', function () {
            updateDurasiFormat(parseInt(this.value));
        });
    }


    /* ----------------------------------------------------------
       RADIO CARD HIGHLIGHT
    ---------------------------------------------------------- */
    document.querySelectorAll('.fc-radio-card input').forEach(function (r) {
        r.addEventListener('change', function () {
            document.querySelectorAll('.fc-radio-card').forEach(function (card) {
                var radio = card.querySelector('input[type="radio"]');
                card.classList.toggle('fc-radio-card-active', radio.checked);
            });
        });
    });

})();


/* ============================================================
   THUMBNAIL — Preview & Upload
   (global function, dipanggil dari blade via onchange)
   ============================================================ */

function previewThumb(input) {
    if (!input.files || !input.files[0]) return;
    var file = input.files[0];
    if (file.size > 2 * 1024 * 1024) {
        alert('Ukuran gambar melebihi 2MB.');
        input.value = '';
        return;
    }
    var reader = new FileReader();
    reader.onload = function (e) {
        var preview = document.getElementById('thumb-preview');
        var placeholder = document.getElementById('thumb-placeholder');
        if (preview) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
        if (placeholder) placeholder.style.display = 'none';
    };
    reader.readAsDataURL(file);
}

function clearThumb() {
    var input = document.getElementById('thumbnail');
    var preview = document.getElementById('thumb-preview');
    var placeholder = document.getElementById('thumb-placeholder');
    if (input) input.value = '';
    if (preview) { preview.src = ''; preview.style.display = 'none'; }
    if (placeholder) placeholder.style.display = 'flex';
}

function handleThumbDrop(e) {
    e.preventDefault();
    var drop = document.getElementById('thumbDrop');
    if (drop) drop.classList.remove('fc-thumb-drop-hover');
    var file = e.dataTransfer.files[0];
    if (!file || !file.type.startsWith('image/')) return;
    var dt = new DataTransfer();
    dt.items.add(file);
    var input = document.getElementById('thumbnail');
    if (input) {
        input.files = dt.files;
        previewThumb(input);
    }
}


/* ============================================================
   STATUS ARTIKEL — radio highlight
   (global function, dipanggil dari blade via onchange)
   ============================================================ */

function setStatus(radio) {
    document.querySelectorAll('.fc-status-opt').forEach(function (el) {
        el.classList.remove('active');
    });
    radio.closest('.fc-status-opt').classList.add('active');
}


/* ============================================================
   VIDEO — Preview & Upload
   ============================================================ */

function previewVideo(input) {
    if (!input.files || !input.files[0]) return;
    var file = input.files[0];
    var maxSize = 500 * 1024 * 1024;
    if (file.size > maxSize) {
        alert('Ukuran video melebihi 500MB.');
        input.value = '';
        return;
    }

    var url = URL.createObjectURL(file);
    var videoEl = document.getElementById('video-preview');
    if (videoEl) {
        videoEl.src = url;
        videoEl.onloadedmetadata = function () {
            var secs = Math.round(videoEl.duration);
            var durasiInput = document.getElementById('durasi_detik');
            if (durasiInput) durasiInput.value = secs;
            updateDurasiFormat(secs);
        };
    }

    var sizeMB = (file.size / (1024 * 1024)).toFixed(1);
    var videoInfo = document.getElementById('videoInfo');
    if (videoInfo) {
        videoInfo.innerHTML = '<i class="mdi mdi-file-video-outline"></i> ' + file.name + ' &bull; ' + sizeMB + ' MB';
    }

    var placeholder = document.getElementById('video-placeholder');
    var selected = document.getElementById('video-selected');
    var actions = document.getElementById('videoActions');
    if (placeholder) placeholder.style.display = 'none';
    if (selected) selected.style.display = 'block';
    if (actions) actions.style.display = 'flex';
}

function clearVideo() {
    var input = document.getElementById('file_video');
    var videoEl = document.getElementById('video-preview');
    var placeholder = document.getElementById('video-placeholder');
    var selected = document.getElementById('video-selected');
    var actions = document.getElementById('videoActions');
    var durasiInput = document.getElementById('durasi_detik');
    var durasiFormatted = document.getElementById('durasiFormatted');

    if (input) input.value = '';
    if (videoEl) videoEl.src = '';
    if (placeholder) placeholder.style.display = 'flex';
    if (selected) selected.style.display = 'none';
    if (actions) actions.style.display = 'none';
    if (durasiInput) durasiInput.value = '';
    if (durasiFormatted) durasiFormatted.textContent = '';
}

function handleVideoDrop(e) {
    e.preventDefault();
    var drop = document.getElementById('videoDrop');
    if (drop) drop.classList.remove('fc-video-drop-hover');
    var file = e.dataTransfer.files[0];
    if (!file || !file.type.startsWith('video/')) {
        alert('File harus berupa video (MP4, MOV, AVI, dll).');
        return;
    }
    var dt = new DataTransfer();
    dt.items.add(file);
    var input = document.getElementById('file_video');
    if (input) {
        input.files = dt.files;
        previewVideo(input);
    }
}

function updateDurasiFormat(secs) {
    var el = document.getElementById('durasiFormatted');
    if (!el) return;
    if (!isNaN(secs) && secs >= 0) {
        var m = Math.floor(secs / 60);
        var s = secs % 60;
        el.textContent = '= ' + m + ':' + String(s).padStart(2, '0') + ' menit';
    } else {
        el.textContent = '';
    }
}


/* ============================================================
   LAPORAN — Modal helpers
   ============================================================ */

var _deleteTarget = null;

function openModal(id) {
    var el = document.getElementById(id);
    if (el) el.classList.add('open');
}

function closeModal(id) {
    var el = document.getElementById(id);
    if (el) el.classList.remove('open');
}

function confirmDelete(id) {
    _deleteTarget = id;
    openModal('deleteModal');
}

function doDelete() {
    if (!_deleteTarget) return;
    console.log('Hapus laporan ID:', _deleteTarget);
    closeModal('deleteModal');
    _deleteTarget = null;
}

function confirmInvalid() {
    openModal('invalidModal');
}

function doInvalid() {
    console.log('Tandai tidak valid');
    closeModal('invalidModal');
}

function exportLaporan() {
    alert('Fitur export belum terhubung ke controller.');
}

/* ============================================================
   ARTIKEL — Debounce Search
   ============================================================ */

let _searchTimer;
function debounceSearch() {
    clearTimeout(_searchTimer);
    _searchTimer = setTimeout(function () {
        document.getElementById('filter-form').submit();
    }, 500);
}