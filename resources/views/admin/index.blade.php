@extends('layouts.admin')

@section('title', 'Dashboard Utama Admin')

@section('content')
    <div class="container-fluid px-3 px-lg-4 py-4">
        <div class="page-heading">
            <div class="page-heading-copy">
                <span class="page-icon"><i class="bi bi-speedometer2" aria-hidden="true"></i></span>
                <div>
                    <p class="eyebrow mb-1">Overview</p>
                    <h1 class="h3 mb-1">Dashboard Perpustakaan</h1>
                    <p class="text-muted mb-0">Pantau koleksi buku, pengguna aktif, dan aktivitas sirkulasi dari satu tempat.
                    </p>
                </div>
            </div>
        </div>

        <!-- ============================================== -->
        <!-- KARTU INDIKATOR (METRICS) -->
        <!-- ============================================== -->
        <section class="row g-3 mt-1" aria-label="Dashboard metrics">

            <!-- Kartu 1: Total Judul Buku -->
            <div class="col-12 col-sm-6 col-xl-3">
                <article class="metric-card metric-primary">
                    <div class="metric-top">
                        <span class="metric-label">Total Judul Buku</span>
                        <span class="metric-icon"><i class="bi bi-journal-richtext" aria-hidden="true"></i></span>
                    </div>
                    <div class="metric-value">{{ number_format($totalJudulBuku) }}</div>
                    <div class="metric-meta">
                        <span class="text-muted">Koleksi variasi buku</span>
                    </div>
                </article>
            </div>

            <!-- Kartu 2: Total Fisik Buku -->
            <div class="col-12 col-sm-6 col-xl-3">
                <article class="metric-card metric-success">
                    <div class="metric-top">
                        <span class="metric-label">Total Fisik Buku</span>
                        <span class="metric-icon"><i class="bi bi-book" aria-hidden="true"></i></span>
                    </div>
                    <div class="metric-value">{{ number_format($totalFisikBuku) }}</div>
                    <div class="metric-meta">
                        <span class="text-success">Tersedia di rak</span>
                    </div>
                </article>
            </div>

            <!-- Kartu 3: Total Karyawan (Pengguna) -->
            <div class="col-12 col-sm-6 col-xl-3">
                <article class="metric-card metric-warning">
                    <div class="metric-top">
                        <span class="metric-label">Karyawan Aktif</span>
                        <span class="metric-icon"><i class="bi bi-people" aria-hidden="true"></i></span>
                    </div>
                    <div class="metric-value">{{ number_format($totalKaryawan) }}</div>
                    <div class="metric-meta">
                        <span class="text-muted">Terdaftar di sistem</span>
                    </div>
                </article>
            </div>

            <!-- Kartu 4: Buku Sedang Dipinjam -->
            <div class="col-12 col-sm-6 col-xl-3">
                <article class="metric-card metric-danger">
                    <div class="metric-top">
                        <span class="metric-label">Sedang Dipinjam</span>
                        <span class="metric-icon"><i class="bi bi-arrow-left-right" aria-hidden="true"></i></span>
                    </div>
                    <div class="metric-value">{{ number_format($bukuDipinjam) }}</div>
                    <div class="metric-meta">
                        <span class="text-danger">Belum dikembalikan</span>
                    </div>
                </article>
            </div>
        </section>

        <!-- ============================================== -->
        <!-- TABEL AKTIVITAS PEMINJAMAN TERBARU -->
        <!-- ============================================== -->
        <section class="panel mt-4">
            <div class="panel-header">
                <div>
                    <h2 class="h5 mb-1 section-title"><i class="bi bi-activity" aria-hidden="true"></i><span>Aktivitas
                            Peminjaman Terbaru</span></h2>
                    <p class="text-muted mb-0">Riwayat sirkulasi perpustakaan terkini.</p>
                </div>
                <a class="btn btn-outline-secondary btn-sm" href="{{ route('admin.kelolatransaksi.index') }}">Lihat Semua
                    Transaksi</a>
            </div>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th scope="col">Nama Peminjam</th>
                            <th scope="col">Buku</th>
                            <th scope="col">Tgl. Pinjam</th>
                            <th scope="col">Tanggal Kembali</th> <!-- Diubah teksnya dari Tenggat Kembali -->
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaksiTerbaru as $trx)
                            <tr>
                                <td>
                                    <p class="fw-semibold mb-0">{{ $trx->karyawan->name ?? 'Unknown' }}</p>
                                    <p class="text-muted small mb-0">{{ $trx->karyawan->divisi ?? '-' }}</p>
                                </td>
                                <td class="fw-medium">{{ $trx->buku->judul ?? 'Buku Dihapus' }}</td>

                                <!-- Format Tgl Pinjam (Aman karena wajib diisi saat pinjam) -->
                                <td>{{ $trx->tgl_pinjam ? $trx->tgl_pinjam->format('d M Y') : '-' }}</td>

                                <!-- Pengecekan Aman untuk Tgl Kembali (Bisa null jika belum dikembalikan) -->
                                <td>
                                    @if ($trx->tgl_kembali)
                                        {{ $trx->tgl_kembali->format('d M Y') }}
                                    @else
                                        <span class="text-muted fst-italic">Masih Dipinjam</span>
                                    @endif
                                </td>

                                <td>
                                    @if ($trx->status == 'Dipinjam')
                                        <span class="badge text-bg-warning">Dipinjam</span>
                                    @elseif($trx->status == 'Dikembalikan')
                                        <span class="badge text-bg-success">Dikembalikan</span>
                                    @else
                                        <span class="badge text-bg-danger">Terlambat</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">Belum ada riwayat transaksi
                                    peminjaman.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endsection
