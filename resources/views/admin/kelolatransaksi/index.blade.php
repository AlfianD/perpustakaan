@extends('layouts.admin')

@section('title', 'Manajemen Peminjaman')

@section('content')
    <div class="container-fluid px-3 px-lg-4 py-4">

        <!-- Header Halaman -->
        <div class="page-heading mb-4">
            <div class="page-heading-copy">
                <span class="page-icon"><i class="bi bi-arrow-left-right" aria-hidden="true"></i></span>
                <div>
                    <p class="eyebrow mb-1">Management Loan</p>
                    <h1 class="h3 mb-1">Peminjaman & Sirkulasi</h1>
                    <p class="text-muted mb-0">Pantau transaksi peminjaman, pengembalian buku, dan data anggota.</p>
                </div>
            </div>
            <div class="heading-actions">
                <button class="btn btn-primary btn-sm px-3" data-bs-toggle="modal" data-bs-target="#modalPinjam">
                    <i class="bi bi-plus-lg me-1"></i> Catat Peminjaman
                </button>
            </div>
        </div>

        <!-- Notifikasi Pesan Sukses / Error -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Statistik Metrics -->
        <section class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <article class="metric-card metric-warning">
                    <div class="metric-top">
                        <span class="metric-label">Sedang Dipinjam</span>
                        <span class="metric-icon"><i class="bi bi-book-half"></i></span>
                    </div>
                    <div class="metric-value">{{ $statDipinjam }}</div>
                </article>
            </div>
            <div class="col-6 col-md-3">
                <article class="metric-card metric-danger">
                    <div class="metric-top">
                        <span class="metric-label">Terlambat</span>
                        <span class="metric-icon"><i class="bi bi-exclamation-triangle"></i></span>
                    </div>
                    <div class="metric-value">{{ $statTerlambat }}</div>
                </article>
            </div>
            <div class="col-6 col-md-3">
                <article class="metric-card metric-primary">
                    <div class="metric-top">
                        <span class="metric-label">Jatuh Tempo Hari Ini</span>
                        <span class="metric-icon"><i class="bi bi-calendar-event"></i></span>
                    </div>
                    <div class="metric-value">{{ $statJatuhTempo }}</div>
                </article>
            </div>
            <div class="col-6 col-md-3">
                <article class="metric-card metric-success">
                    <div class="metric-top">
                        <span class="metric-label">Dikembalikan Bulan Ini</span>
                        <span class="metric-icon"><i class="bi bi-check-circle"></i></span>
                    </div>
                    <div class="metric-value">{{ $statDikembalikan }}</div>
                </article>
            </div>
        </section>

        <!-- TAB NAVIGATION -->
        <ul class="nav nav-tabs mb-4" id="loanTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active fw-semibold" data-bs-toggle="tab" data-bs-target="#peminjaman-tab-pane"
                    type="button" role="tab">
                    <i class="bi bi-list-task me-1"></i> Peminjaman Aktif
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-semibold" data-bs-toggle="tab" data-bs-target="#anggota-tab-pane" type="button"
                    role="tab">
                    <i class="bi bi-people me-1"></i> Data Anggota
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-semibold" data-bs-toggle="tab" data-bs-target="#denda-tab-pane" type="button"
                    role="tab">
                    <i class="bi bi-cash-coin me-1"></i> Masa Pinjam & Denda
                </button>
            </li>
        </ul>

        <!-- TAB CONTENT -->
        <div class="tab-content" id="loanTabsContent">

            <!-- TAB 1: DAFTAR TRANSAKSI PEMINJAMAN -->
            <div class="tab-pane fade show active" id="peminjaman-tab-pane" role="tabpanel" tabindex="0">
                <section class="panel">
                    <div class="panel-header">
                        <div>
                            <h2 class="h5 mb-1 section-title"><i class="bi bi-arrow-left-right"></i> Daftar Transaksi</h2>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-middle mb-0" id="transaksiTable">
                            <thead>
                                <tr>
                                    <th>No. Transaksi</th>
                                    <th>Anggota</th>
                                    <th>Buku</th>
                                    <th>Tgl Pinjam</th>
                                    <th>Tanggal Kembali</th> <!-- Diubah dari Jatuh Tempo -->
                                    <th>Durasi Pinjam</th> <!-- Kolom baru durasi live -->
                                    <th>Status</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transaksis as $trx)
                                    <tr>
                                        <td class="fw-semibold text-primary">
                                            #TRX-{{ str_pad($trx->id, 4, '0', STR_PAD_LEFT) }}</td>
                                        <td>{{ $trx->karyawan->name ?? 'User Dihapus' }}</td>
                                        <td>
                                            <span class="d-inline-block text-truncate" style="max-width: 150px;"
                                                title="{{ $trx->buku->judul ?? 'Buku Dihapus' }}">
                                                {{ $trx->buku->judul ?? 'Buku Dihapus' }}
                                            </span>
                                        </td>
                                        <td>{{ $trx->tgl_pinjam ? $trx->tgl_pinjam->format('d M Y') : '-' }}</td>

                                        <!-- Tanggal Kembali (Aktif jika sudah dikembalikan, jika belum '-' atau '-') -->
                                        <td>{{ $trx->tgl_kembali ? $trx->tgl_kembali->format('d M Y') . ' (Selesai)' : 'Masih Dipinjam' }}
                                        </td>

                                        <!-- Durasi Live (Menghitung berapa lama dipinjam secara otomatis) -->
                                        <!-- Durasi Live Peminjaman (Bulat / Full 24 Jam menggunakan floor) -->
                                        <td>
                                            @if ($trx->status == 'Dipinjam')
                                                <span class="text-info fw-semibold">
                                                    {{ $trx->tgl_pinjam ? (int) floor(\Carbon\Carbon::parse($trx->tgl_pinjam)->diffInDays(\Carbon\Carbon::now())) : 0 }}
                                                    hari
                                                </span>
                                            @else
                                                <span class="text-muted">
                                                    Selesai
                                                    ({{ $trx->tgl_pinjam && $trx->tgl_kembali ? (int) floor(\Carbon\Carbon::parse($trx->tgl_pinjam)->diffInDays(\Carbon\Carbon::parse($trx->tgl_kembali))) : 0 }}
                                                    hari)
                                                </span>
                                            @endif
                                        </td>

                                        <td>
                                            @if ($trx->status == 'Dikembalikan')
                                                <span class="badge text-bg-success">Dikembalikan</span>
                                            @else
                                                <span class="badge text-bg-warning">Dipinjam</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            @if ($trx->status == 'Dipinjam')
                                                <form action="{{ route('admin.kelolatransaksi.kembalikan', $trx->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-sm btn-outline-primary"
                                                        onclick="return confirm('Yakin buku ini sudah dikembalikan secara fisik?')">
                                                        <i class="bi bi-box-arrow-in-down"></i> Kembalikan
                                                    </button>
                                                </form>
                                            @else
                                                <button class="btn btn-sm btn-light text-muted" disabled><i
                                                        class="bi bi-check2-all"></i> Selesai</button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-4">Belum ada transaksi
                                            peminjaman.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>

            <!-- TAB 2: DATA ANGGOTA (KARYAWAN) -->
            <div class="tab-pane fade" id="anggota-tab-pane" role="tabpanel" tabindex="0">
                <section class="panel">
                    <div class="panel-header">
                        <div>
                            <h2 class="h5 mb-1 section-title"><i class="bi bi-people"></i> Anggota Perpustakaan</h2>
                            <p class="text-muted mb-0 small">Karyawan yang terdaftar sebagai anggota peminjam.</p>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Nama / ID</th>
                                    <th>Divisi</th>
                                    <th>Sedang Dipinjam</th>
                                    <th>Status Akun</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($anggotas as $anggota)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center"
                                                    style="width: 35px; height: 35px; font-weight: bold; font-size: 0.85rem;">
                                                    {{ strtoupper(substr($anggota->name, 0, 2)) }}
                                                </div>
                                                <div>
                                                    <p class="fw-semibold mb-0">{{ $anggota->name }}</p>
                                                    <p class="text-muted small mb-0">{{ $anggota->idkaryawan }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $anggota->divisi }}</td>
                                        <td>
                                            @if ($anggota->sedang_dipinjam_count > 0)
                                                <span class="badge text-bg-warning">{{ $anggota->sedang_dipinjam_count }}
                                                    Buku</span>
                                            @else
                                                <span class="badge text-bg-light text-secondary">0 Buku</span>
                                            @endif
                                        </td>
                                        <td><span class="badge text-bg-success">Aktif</span></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">Belum ada anggota
                                            terdaftar.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>

            <!-- TAB 3: MASA PINJAM & DENDA -->
            <div class="tab-pane fade" id="denda-tab-pane" role="tabpanel" tabindex="0">
                <section class="panel text-center py-5">
                    <i class="bi bi-tools text-muted mb-3 d-block" style="font-size: 3rem;"></i>
                    <h3 class="h5">Fitur Denda Segera Hadir</h3>
                    <p class="text-muted">Modul pengaturan denda keterlambatan sedang dalam tahap pengembangan.</p>
                </section>
            </div>
        </div>
    </div>
@endsection

@push('modals')
    <!-- MODAL CATAT PEMINJAMAN (ADMIN) -->
    <div class="modal fade" id="modalPinjam" tabindex="-1" aria-labelledby="modalPinjamLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('admin.kelolatransaksi.store') }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="modalPinjamLabel"><i class="bi bi-journal-plus me-2"></i>Catat
                        Peminjaman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Dropdown Anggota -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Pilih Anggota (Peminjam) <span
                                class="text-danger">*</span></label>
                        <select name="karyawan_id" class="form-select" required>
                            <option value="">-- Pilih Anggota --</option>
                            @foreach ($karyawans as $karyawan)
                                <option value="{{ $karyawan->id }}">{{ $karyawan->name }} ({{ $karyawan->divisi }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Dropdown Buku -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Pilih Buku <span class="text-danger">*</span></label>
                        <select name="buku_id" class="form-select" required>
                            <option value="">-- Pilih Buku --</option>
                            @foreach ($bukus as $buku)
                                <option value="{{ $buku->id }}">{{ $buku->judul }} - Stok: {{ $buku->jumlah }}
                                </option>
                            @endforeach
                        </select>
                        <div class="form-text text-muted">Buku dengan stok 0 tidak akan ditampilkan di sini.</div>
                    </div>

                    <!-- Jatuh Tempo -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tanggal Jatuh Tempo <span
                                class="text-danger">*</span></label>
                        <input type="date" name="tgl_kembali" class="form-control" required
                            min="{{ \Carbon\Carbon::today()->toDateString() }}">
                        <div class="form-text text-muted">Tenggat maksimal pengembalian buku.</div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-1"></i> Simpan
                        Transaksi</button>
                </div>
            </form>
        </div>
    </div>
@endpush
