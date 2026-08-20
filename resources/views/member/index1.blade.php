@extends('layouts.member')

@section('title', 'Beranda - SIPINTAR')

@section('content')
    <!-- ===================== BERANDA ===================== -->
    <section class="view active" id="view-beranda">

        <!-- Greet Card -->
        <div class="greet-card mb-4">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <div class="text-muted-sm" style="color:rgba(255,255,255,.6);">Selamat datang 👋</div>
                    <h4 class="mb-1">Halo, {{ auth()->guard('karyawan')->user()->name ?? 'Karyawan' }}</h4>
                    <p class="mb-0" id="greetText" style="color:rgba(255,255,255,.75); font-size:.88rem;">
                        Yuk jelajahi katalog dan pinjam langsung buku yang Anda mau.
                    </p>
                </div>
                <div class="col-lg-5 mt-3 mt-lg-0 text-lg-end d-flex gap-2 justify-content-lg-end flex-wrap">
                    <span class="badge-soft b-sky" id="badgeSisaKuota">
                        <i class="bi bi-check2-circle me-1"></i>
                        {{ $totalBukuTersedia }} buku tersedia
                    </span>
                    <span class="badge-soft b-navy" id="badgeTotalPinjam">
                        <i class="bi bi-journal-check me-1"></i>
                        {{ $totalPernahDipinjam }} buku pernah dipinjam
                    </span>
                </div>
            </div>
        </div>

        <!-- Stat Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card stat-card">
                    <div class="stat-icon" style="background:var(--navy);"><i class="bi bi-journal-bookmark-fill"></i></div>
                    <div>
                        <div class="stat-num" id="statSedang">{{ $totalSedangDipinjam }}</div>
                        <div class="stat-label">Sedang Dipinjam</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stat-card">
                    <div class="stat-icon" style="background:var(--green);"><i class="bi bi-check-circle-fill"></i></div>
                    <div>
                        <div class="stat-num" id="statSisa">{{ $totalBukuTersedia }}</div>
                        <div class="stat-label">Buku Tersedia</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stat-card">
                    <div class="stat-icon" style="background:var(--sky);"><i class="bi bi-collection-fill"></i></div>
                    <div>
                        <div class="stat-num" id="statTotal">{{ $totalPernahDipinjam }}</div>
                        <div class="stat-label">Total Pernah Dipinjam</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="page-head">
            <div>
                <h4>Katalog Buku</h4>
                <div class="sub">
                    {{ $totalJudulBuku }} judul tersedia di perpustakaan kantor.
                    Klik <b>Pinjam</b> untuk langsung membawa pulang buku.
                </div>
            </div>
        </div>

        <!-- Toolbar Pencarian -->
        <div class="toolbar mb-3">
            <div class="row g-2 align-items-center">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" id="searchBuku" class="form-control border-start-0"
                            placeholder="Cari judul atau penulis...">
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <select id="filterKategori" class="form-select">
                        <option value="all">Semua Kategori</option>
                        @foreach ($books->pluck('kategori.nama_kategori')->filter()->unique()->sort() as $kategori)
                            <option value="{{ $kategori }}">{{ $kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6 col-md-2">
                    <select id="filterStatus" class="form-select">
                        <option value="all">Semua Status</option>
                        <option value="tersedia">Tersedia</option>
                        <option value="habis">Habis</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select id="sortBuku" class="form-select">
                        <option value="terbaru">Terbaru</option>
                        <option value="judul">Judul A–Z</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row g-3" id="catalogGrid"></div>
        <div id="emptyState" class="empty-state" style="display:none;">
            <i class="bi bi-search fs-2 d-block mb-2"></i> Tidak ada buku yang cocok dengan pencarian Anda.
        </div>
    </section>

    <!-- ===================== RIWAYAT ===================== -->
    <section class="view" id="view-riwayat">
        <div class="page-head">
            <div>
                <h4>Riwayat Peminjaman</h4>
                <div class="sub">Pantau buku yang sedang dan pernah Anda pinjam.</div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card p-3">
                    <div class="text-muted-sm">Sedang Dipinjam</div>
                    <div class="stat-num" style="color:var(--navy);"><span
                            id="statSedang2">{{ $totalSedangDipinjam }}</span></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3">
                    <div class="text-muted-sm">Total Pernah Dipinjam</div>
                    <div class="stat-num" style="color:var(--sky);"><span id="statTotal2">{{ $totalPernahDipinjam }}</span>
                        buku</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3">
                    <div class="text-muted-sm">Rata-rata Durasi Peminjaman</div>
                    <div class="stat-num" style="color:var(--green);"><span id="statRataRata">7</span> hari</div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header-plain">
                <h6>Sedang Dipinjam</h6><span class="text-muted-sm" id="activeCountLabel">0 buku aktif</span>
            </div>
            <div class="p-2" id="activeLoansContainer"></div>
        </div>

        <div class="card">
            <div class="card-header-plain">
                <h6>Riwayat Lengkap</h6>
                <ul class="nav subtab" id="riwayatTabs">
                    <li class="nav-item"><a class="nav-link active" data-history-filter="all" href="#">Semua</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" data-history-filter="dipinjam" href="#">Sedang
                            Dipinjam</a></li>
                    <li class="nav-item"><a class="nav-link" data-history-filter="dikembalikan"
                            href="#">Selesai</a></li>
                </ul>
            </div>
            <div class="table-responsive">
                <table class="table table-modern mb-0">
                    <thead>
                        <tr>
                            <th>Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Durasi</th>
                            <th>Dikembalikan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="riwayatBody"></tbody>
                </table>
            </div>
        </div>
    </section>
@endsection


<!-- ===================== MODALS & TOASTS ===================== -->
@push('modals')
    <div class="modal fade" id="modalDetail" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Detail Buku</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="detail-cover" id="mdCover"><i class="bi bi-book"></i></div>
                        </div>
                        <div class="col-md-8">
                            <span class="badge-soft b-sky mb-2" id="mdCategory"
                                style="width:fit-content;">Kategori</span>
                            <h5 class="fw-bold mb-1" id="mdTitle">Judul Buku</h5>
                            <div class="text-muted-sm mb-3" id="mdAuthor">Penulis</div>
                            <div class="row g-2 text-muted-sm mb-3">
                                <div class="col-6"><i class="bi bi-building me-1"></i>Penerbit: <b id="mdPublisher"
                                        style="color:var(--black);">-</b></div>
                                <div class="col-6"><i class="bi bi-calendar3 me-1"></i>Tahun: <b id="mdYear"
                                        style="color:var(--black);">-</b></div>
                                <div class="col-12"><i class="bi bi-stack me-1"></i>Ketersediaan: <b id="mdStok"
                                        style="color:var(--black);">-</b></div>
                            </div>
                            <p class="text-muted-sm" id="mdDesc">Deskripsi buku.</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                    <button class="btn btn-navy px-4" id="mdBtnAction">Pinjam Buku Ini</button>
                </div>
            </div>
        </div>
    </div>

    <!-- TOASTS -->
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index:1080;">
        <div id="toastPinjam" class="toast align-items-center border-0 text-white" style="background:var(--green);"
            role="alert">
            <div class="d-flex">
                <div class="toast-body"><i class="bi bi-check-circle-fill me-2"></i>Buku berhasil dicatat.</div>
                <button class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
        <div id="toastKembali" class="toast align-items-center border-0 text-white mt-2" style="background:var(--sky);"
            role="alert">
            <div class="d-flex">
                <div class="toast-body"><i class="bi bi-box-arrow-in-left me-2"></i>Buku berhasil dikembalikan.</div>
                <button class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>
@endpush


@push('scripts')
    <script>
        const TODAY = new Date();
        const BULAN = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        // Data dari Controller
        const bukuDatabase = @json($books);
        let activeLoans = @json($activeLoansData);
        let historyLoans = @json($historyLoansData);

        // Mapping data buku dari Database ke format JavaScript
        const books = bukuDatabase.map(function(buku) {
            return {
                id: buku.id,
                title: buku.judul || '-',
                author: buku.penulis || '-',
                category: buku.kategori ? buku.kategori.nama_kategori : 'Tanpa Kategori',
                publisher: buku.penerbit || 'Penerbit Umum',
                year: buku.tahun_terbit || '-',
                stok: Number(buku.jumlah || 0),
                tersedia: Number(buku.jumlah || 0),
                icon: 'bi-book',
                grad: 'linear-gradient(135deg,var(--sky),var(--navy))',
                desc: buku.deskripsi || 'Tidak ada deskripsi tersedia untuk buku ini.',
                cover: buku.cover || null
            };
        });

        // =========================================================
        // FUNGSI UTILITY (Waktu & Helper)
        // =========================================================
        function fmtDate(d) {
            if (!d) return '-';
            const date = new Date(d);
            if (isNaN(date.getTime())) return '-';
            return String(date.getDate()).padStart(2, '0') + ' ' + BULAN[date.getMonth()] + ' ' + date.getFullYear();
        }

        function daysBetween(a, b) {
            const start = new Date(a);
            const end = new Date(b);
            if (isNaN(start.getTime()) || isNaN(end.getTime())) return 0;
            return Math.max(1, Math.round((end - start) / 86400000));
        }

        function showToast(id) {
            const element = document.getElementById(id);
            if (!element) return;
            const toast = bootstrap.Toast.getOrCreateInstance(element);
            toast.show();
        }

        function getCoverUrl(coverPath) {
            if (!coverPath) return null;
            if (coverPath.startsWith('http://') || coverPath.startsWith('https://')) return coverPath;
            return "{{ asset('storage') }}/" + coverPath;
        }


        async function borrowBook(id) {
            const book = books.find(b => String(b.id) === String(id));
            if (!book || book.tersedia <= 0) return;

            const alreadyBorrowed = activeLoans.some(loan => String(loan.bookId) === String(id));
            if (alreadyBorrowed) {
                alert('Anda sudah meminjam buku ini.');
                return;
            }

            try {
                let response = await fetch("{{ route('member.pinjam') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Token pengaman Laravel
                    },
                    body: JSON.stringify({
                        buku_id: id
                    })
                });

                // Jika server merespons selain sukses (misal 419 atau 500)
                let textResult = await response.text();
                let result;
                try {
                    result = JSON.parse(textResult);
                } catch (e) {
                    console.error("Respon Server (Bukan JSON):", textResult);
                    throw new Error("Sesi kedaluwarsa atau terjadi gangguan server. Silakan refresh halaman.");
                }

                if (result.success) {
                    book.tersedia -= 1;
                    activeLoans.push({
                        bookId: id,
                        borrowDate: result.borrowDate
                    });
                    renderAll();
                    showToast('toastPinjam');
                } else {
                    alert(result.message);
                }
            } catch (error) {
                alert('Gagal meminjam: ' + error.message);
                console.error('Error detail:', error);
            }
        }

        // =========================================================
        // RENDER TAMPILAN
        // =========================================================
        function renderCatalog() {
            const searchElement = document.getElementById('searchBuku');
            const kategoriElement = document.getElementById('filterKategori');
            const statusElement = document.getElementById('filterStatus');
            const sortElement = document.getElementById('sortBuku');
            const grid = document.getElementById('catalogGrid');
            const emptyState = document.getElementById('emptyState');

            if (!grid) return;
            grid.innerHTML = '';

            const q = (searchElement?.value || '').trim().toLowerCase();
            const kat = kategoriElement?.value || 'all';
            const stat = statusElement?.value || 'all';
            const sort = sortElement?.value || 'terbaru';

            let filteredBooks = [...books];

            // Filter & Sort
            filteredBooks = filteredBooks.filter(book => (String(book.title).toLowerCase().includes(q) || String(book
                .author).toLowerCase().includes(q)));
            if (kat !== 'all') filteredBooks = filteredBooks.filter(b => String(b.category) === String(kat));
            if (stat !== 'all') filteredBooks = filteredBooks.filter(b => stat === 'tersedia' ? Number(b.tersedia) > 0 :
                Number(b.tersedia) <= 0);

            if (sort === 'judul') filteredBooks.sort((a, b) => String(a.title).localeCompare(String(b.title), 'id', {
                sensitivity: 'base'
            }));
            else filteredBooks.sort((a, b) => Number(b.year || 0) - Number(a.year || 0));

            let visible = 0;
            filteredBooks.forEach(book => {
                visible++;
                const isHabis = Number(book.tersedia) <= 0;
                const mine = activeLoans.some(loan => String(loan.bookId) === String(book.id));

                // Set Tombol Berdasarkan Status
                let actionHtml = '';
                if (mine) {
                    actionHtml =
                        `<button class="btn btn-outline-navy btn-sm flex-fill" data-action="kembalikan" data-id="${book.id}"><i class="bi bi-box-arrow-in-left me-1"></i>Kembalikan</button>`;
                } else if (isHabis) {
                    actionHtml = `<button class="btn btn-light btn-sm flex-fill" disabled>Stok Habis</button>`;
                } else {
                    actionHtml =
                        `<button class="btn btn-navy btn-sm flex-fill" data-action="pinjam" data-id="${book.id}"><i class="bi bi-journal-plus me-1"></i>Pinjam</button>`;
                }

                const badgeClass = book.category === 'Manajemen & Bisnis' ? 'b-navy' : book.category ===
                    'Pengembangan Diri' ? 'b-sky' : 'b-green';
                const ribbon = isHabis ? '<span class="ribbon">HABIS</span>' : '';
                const mineNote = mine ?
                    ' · <span style="color:var(--sky);font-weight:600;">Sedang Anda pinjam</span>' : '';

                // Render Cover
                const validCoverUrl = getCoverUrl(book.cover);
                let coverHtml = validCoverUrl ?
                    `<div class="book-cover" style="background-image:url('${validCoverUrl}'); background-size:contain; background-position:center; background-repeat:no-repeat; background-color:#f8f9fa;">${ribbon}</div>` :
                    `<div class="book-cover" style="background:${book.grad};"><i class="bi ${book.icon}"></i>${ribbon}</div>`;

                grid.insertAdjacentHTML('beforeend', `
                    <div class="col-6 col-md-4 col-xl-3">
                        <div class="card book-card">
                            ${coverHtml}
                            <div class="body">
                                <div class="book-title">${book.title}</div>
                                <div class="book-author">${book.author}</div>
                                <span class="badge-soft ${badgeClass} mb-2" style="width:fit-content;">${book.category}</span>
                                <div class="book-avail">Tersedia <b>${book.tersedia}</b> dari ${book.stok}${mineNote}</div>
                                <div class="d-flex gap-2 mt-auto">
                                    <button class="btn btn-outline-navy btn-sm flex-fill" data-bs-toggle="modal" data-bs-target="#modalDetail" data-id="${book.id}">Detail</button>
                                    ${actionHtml}
                                </div>
                            </div>
                        </div>
                    </div>
                `);
            });

            if (emptyState) emptyState.style.display = visible === 0 ? '' : 'none';
        }

        function renderActiveLoans() {
            const container = document.getElementById('activeLoansContainer');
            const activeCountLabel = document.getElementById('activeCountLabel');
            if (!container) return;

            if (activeCountLabel) activeCountLabel.textContent = activeLoans.length + ' buku aktif';

            if (activeLoans.length === 0) {
                container.innerHTML =
                    `<div class="empty-state"><i class="bi bi-journal-x fs-2 d-block mb-2"></i>Anda belum meminjam buku apa pun. Yuk jelajahi katalog di menu Beranda.</div>`;
                return;
            }

            container.innerHTML = activeLoans.map(loan => {
                const book = books.find(b => String(b.id) === String(loan.bookId));
                if (!book) return '';
                const durasi = daysBetween(loan.borrowDate, TODAY);
                return `
                <div class="loan-card">
                    <div class="loan-cover" style="background:${book.grad};"><i class="bi ${book.icon}"></i></div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between flex-wrap gap-2 align-items-center">
                            <div>
                                <div style="font-weight:700;font-size:.92rem;">${book.title}</div>
                                <div class="text-muted-sm">Dipinjam sejak ${fmtDate(loan.borrowDate)} · sudah ${durasi} hari berjalan</div>
                            </div>
                            <button class="btn btn-sm btn-navy" data-action="kembalikan" data-id="${book.id}">
                                <i class="bi bi-box-arrow-in-left me-1"></i>Kembalikan
                            </button>
                        </div>
                    </div>
                </div>`;
            }).join('');
        }

        let currentFilter = 'all';

        function renderHistoryTable() {
            const tbody = document.getElementById('riwayatBody');
            if (!tbody) return;

            let rows = [];
            activeLoans.forEach(loan => {
                const book = books.find(b => String(b.id) === String(loan.bookId));
                if (book) {
                    rows.push({
                        title: book.title,
                        borrow: new Date(loan.borrowDate),
                        ret: null,
                        duration: daysBetween(loan.borrowDate, TODAY),
                        status: 'dipinjam'
                    });
                }
            });

            historyLoans.forEach(h => {
                const borrow = new Date(h.borrowDate);
                const ret = h.returnDate ? new Date(h.returnDate) : null;
                rows.push({
                    title: h.title,
                    borrow: borrow,
                    ret: ret,
                    duration: ret ? daysBetween(borrow, ret) : 0,
                    status: 'dikembalikan'
                });
            });

            rows.sort((a, b) => b.borrow - a.borrow);
            const filtered = rows.filter(r => currentFilter === 'all' || r.status === currentFilter);

            if (filtered.length === 0) {
                tbody.innerHTML = `<tr><td colspan="5" class="empty-state">Belum ada data peminjaman.</td></tr>`;
                return;
            }

            tbody.innerHTML = filtered.map(r => `
                <tr>
                    <td>${r.title}</td>
                    <td>${fmtDate(r.borrow)}</td>
                    <td>${r.status === 'dipinjam' ? r.duration + ' hari berjalan' : r.duration + ' hari'}</td>
                    <td>${r.ret ? fmtDate(r.ret) : '—'}</td>
                    <td>${r.status === 'dipinjam' ? '<span class="badge-soft b-orange">Dipinjam</span>' : '<span class="badge-soft b-green">Dikembalikan</span>'}</td>
                </tr>
            `).join('');
        }

        // Memperbarui badge & statistik teks (Agar merespons ketika data berubah)
        function updateStats() {
            const sedangDipinjam = activeLoans.length;
            const sisaTersedia = books.reduce((sum, b) => sum + b.tersedia, 0);

            document.querySelectorAll('#statSedang, #statSedang2').forEach(el => el.textContent = sedangDipinjam);
            document.querySelectorAll('#statSisa').forEach(el => el.textContent = sisaTersedia);

            const badgeSisa = document.getElementById('badgeSisaKuota');
            if (badgeSisa) badgeSisa.innerHTML = `<i class="bi bi-check2-circle me-1"></i>${sisaTersedia} buku tersedia`;
        }

        function renderAll() {
            renderCatalog();
            renderActiveLoans();
            renderHistoryTable();
            updateStats();
        }

        // =========================================================
        // EVENT LISTENERS GLOBAL
        // =========================================================

        // Event Listener Pencarikan & Filter
        ['searchBuku', 'filterKategori', 'filterStatus', 'sortBuku'].forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                el.addEventListener('input', renderCatalog);
                el.addEventListener('change', renderCatalog);
            }
        });

        // Event listener Filter Riwayat
        document.querySelectorAll('[data-history-filter]').forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                document.querySelectorAll('[data-history-filter]').forEach(b => b.classList.remove(
                    'active'));
                button.classList.add('active');
                currentFilter = button.dataset.historyFilter || 'all';
                renderHistoryTable();
            });
        });

        // =========================================================
        // TANGKAP KLIK TOMBOL PINJAM / KEMBALIKAN (Event Delegation)
        // =========================================================
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('[data-action]');
            if (!btn) return;

            const action = btn.dataset.action;
            const id = btn.dataset.id;

            if (action === 'pinjam') {
                borrowBook(id);
                // Tutup modal jika aksi pinjam dilakukan di dalam modal
                const mdElement = document.getElementById('modalDetail');
                if (mdElement) {
                    const mdInstance = bootstrap.Modal.getInstance(mdElement);
                    if (mdInstance) mdInstance.hide();
                }
            } else if (action === 'kembalikan') {
                returnBook(id);
                const mdElement = document.getElementById('modalDetail');
                if (mdElement) {
                    const mdInstance = bootstrap.Modal.getInstance(mdElement);
                    if (mdInstance) mdInstance.hide();
                }
            }
        });


        // Event Listener untuk Modal Detail Buku
        const modalDetail = document.getElementById('modalDetail');
        if (modalDetail) {
            modalDetail.addEventListener('show.bs.modal', e => {
                const trigger = e.relatedTarget;
                if (!trigger) return;
                const bookId = trigger.dataset.id;
                const book = books.find(b => String(b.id) === String(bookId));
                if (!book) return;

                // Tampilkan Cover
                const mdCover = document.getElementById('mdCover');
                const validCoverUrl = getCoverUrl(book.cover);
                if (validCoverUrl) {
                    mdCover.style.background = `url('${validCoverUrl}') center/contain no-repeat #f8f9fa`;
                    mdCover.innerHTML = '';
                } else {
                    mdCover.style.background = book.grad;
                    mdCover.innerHTML = `<i class="bi ${book.icon}"></i>`;
                }

                // Isi Text Deskripsi
                document.getElementById('mdTitle').textContent = book.title;
                document.getElementById('mdAuthor').textContent = book.author;
                document.getElementById('mdCategory').textContent = book.category;
                document.getElementById('mdPublisher').textContent = book.publisher;
                document.getElementById('mdYear').textContent = book.year;
                document.getElementById('mdStok').textContent = book.tersedia + ' dari ' + book.stok +
                    ' eksemplar tersedia';
                document.getElementById('mdDesc').textContent = book.desc;

                // Atur Status Tombol Modal (Dinamis: Berubah jadi pinjam/kembalikan)
                const btnAction = document.getElementById('mdBtnAction');
                const isBorrowed = activeLoans.some(loan => String(loan.bookId) === String(book.id));
                const isHabis = book.tersedia <= 0;

                if (isBorrowed) {
                    btnAction.textContent = 'Kembalikan Buku';
                    btnAction.className = 'btn btn-outline-navy px-4';
                    btnAction.dataset.action = 'kembalikan';
                    btnAction.dataset.id = book.id;
                } else if (isHabis) {
                    btnAction.textContent = 'Stok Sedang Kosong';
                    btnAction.className = 'btn btn-secondary px-4';
                    btnAction.removeAttribute('data-action');
                } else {
                    btnAction.textContent = 'Pinjam Buku Ini';
                    btnAction.className = 'btn btn-navy px-4';
                    btnAction.dataset.action = 'pinjam';
                    btnAction.dataset.id = book.id;
                }
            });
        }

        // =========================================================
        // NAVIGASI MENU (BERANDA & RIWAYAT)
        // =========================================================
        document.querySelectorAll('[data-view]').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const targetViewName = this.dataset.view;

                // Sembunyikan semua & Tampilkan yang diklik
                document.querySelectorAll('section.view').forEach(view => view.classList.remove('active'));
                const targetView = document.getElementById('view-' + targetViewName);
                if (targetView) targetView.classList.add('active');

                // Sorot Menu Navbar
                document.querySelectorAll('.nav-link.nav-pill').forEach(nav => {
                    nav.classList.remove('active');
                    if (nav.dataset.view === targetViewName) nav.classList.add('active');
                });
            });
        });

        // Mulai jalankan render saat halaman selesai dimuat
        document.addEventListener('DOMContentLoaded', renderAll);

        /* =========================================================
           NAVIGASI MENU (BERANDA & RIWAYAT)
           ========================================================= */
        document.querySelectorAll('[data-view]').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault(); // Mencegah reload halaman

                const targetViewName = this.dataset.view; // Mengambil nilai "beranda" atau "riwayat"

                // 1. Sembunyikan semua section yang punya class "view"
                document.querySelectorAll('section.view').forEach(view => {
                    view.classList.remove('active');
                });

                // 2. Tampilkan section yang sesuai dengan data-view yang diklik
                const targetView = document.getElementById('view-' + targetViewName);
                if (targetView) {
                    targetView.classList.add('active');
                }

                // 3. Update status warna menu (nav-pill) di navbar agar menyorot menu yang aktif
                document.querySelectorAll('.nav-link.nav-pill').forEach(nav => {
                    nav.classList.remove('active');
                    // Jika data-view pada menu sama dengan target yang diklik, aktifkan
                    if (nav.dataset.view === targetViewName) {
                        nav.classList.add('active');
                    }
                });
            });
        });
    </script>
@endpush
