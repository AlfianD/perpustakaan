@extends('layouts.admin')

@section('title', 'Kelola Buku')

@section('content')
    <div class="container-fluid px-3 px-lg-4 py-4">

        <!-- Pesan Sukses (Cukup dipanggil satu kali saja) -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="page-heading">
            <div class="page-heading-copy">
                <span class="page-icon"><i class="bi bi-table" aria-hidden="true"></i></span>
                <div>
                    <p class="eyebrow mb-1">Data</p>
                    <h1 class="h3 mb-1">Katalog Buku</h1>
                </div>
            </div>
        </div>

        <section class="panel">
            <div class="panel-header">
                <div class="d-flex flex-wrap gap-1">
                    <h2 class="h5 mb-1 section-title"><i class="bi bi-book" aria-hidden="true"></i><span>Katalog Buku</span>
                    </h2>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    <input class="form-control form-control-sm table-search" type="search" placeholder="Search books..."
                        data-table-search="ordersTable" aria-label="Search books">
                    <a class="btn btn-primary btn-sm" href="{{ route('admin.kelolabuku.create') }}">
                        <i class="bi bi-plus-lg" aria-hidden="true"></i> Tambah Buku
                    </a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table align-middle mb-0" id="ordersTable" data-searchable-table>
                    <thead>
                        <tr>
                            <!-- Tambahkan class "sortable" dan ikon indikator -->
                            <th class="sortable" style="cursor: pointer;" title="Klik untuk mengurutkan">
                                ID Buku <i class="bi bi-arrow-down-up ms-1 text-muted" style="font-size: 0.75rem;"></i>
                            </th>
                            <th class="sortable" style="cursor: pointer;" title="Klik untuk mengurutkan">
                                Buku <i class="bi bi-arrow-down-up ms-1 text-muted" style="font-size: 0.75rem;"></i>
                            </th>
                            <th class="sortable" style="cursor: pointer;" title="Klik untuk mengurutkan">
                                Penulis <i class="bi bi-arrow-down-up ms-1 text-muted" style="font-size: 0.75rem;"></i>
                            </th>
                            <th class="sortable" style="cursor: pointer;" title="Klik untuk mengurutkan">
                                Kategori <i class="bi bi-arrow-down-up ms-1 text-muted" style="font-size: 0.75rem;"></i>
                            </th>
                            <th class="sortable" style="cursor: pointer;" title="Klik untuk mengurutkan">
                                Jumlah <i class="bi bi-arrow-down-up ms-1 text-muted" style="font-size: 0.75rem;"></i>
                            </th>
                            <th class="text-end">Action</th> <!-- Kolom action tidak perlu sort -->
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bukus as $buku)
                            <tr>
                                <td class="fw-semibold">#BK-{{ str_pad($buku->id, 4, '0', STR_PAD_LEFT) }}</td>
                                <td>
                                    <div class="table-media d-flex align-items-center gap-2">
                                        @if ($buku->cover)
                                            <img class="product-thumb rounded" src="{{ asset('storage/' . $buku->cover) }}"
                                                alt="{{ $buku->judul }}"
                                                style="width: 40px; height: 50px; object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded d-flex justify-content-center align-items-center text-muted"
                                                style="width: 40px; height: 50px;">
                                                <i class="bi bi-image"></i>
                                            </div>
                                        @endif
                                        <span class="fw-semibold">{{ $buku->judul }}</span>
                                    </div>
                                </td>
                                <td>{{ $buku->penulis }}</td>
                                <td>{{ $buku->kategori->nama_kategori ?? '-' }}</td>
                                <td>
                                    <span class="badge {{ $buku->jumlah > 0 ? 'text-bg-success' : 'text-bg-danger' }}">
                                        {{ $buku->jumlah > 0 ? $buku->jumlah : 'Kosong' }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <div class="d-flex gap-1 justify-content-end">
                                        <button type="button" class="btn btn-info btn-sm text-white" title="Detail"
                                            data-bs-toggle="modal" data-bs-target="#detailModalBuku{{ $buku->id }}">
                                            <i class="bi bi-eye"></i> Detail
                                        </button>
                                        <a href="{{ route('admin.kelolabuku.edit', $buku->id) }}"
                                            class="btn btn-warning btn-sm text-white" title="Edit">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <a href="{{ route('admin.kelolabuku.cetak_qr', $buku->id) }}" target="_blank"
                                            class="btn btn-sm btn-outline-dark" title="Cetak QR">
                                            <i class="bi bi-qr-code"></i> Cetak
                                        </a>
                                        <form action="{{ route('admin.kelolabuku.destroy', $buku->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Yakin ingin menghapus buku ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">Belum ada data buku yang tersedia.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- ===================================== -->
            <!-- TAMBAHKAN BAGIAN PAGINATION DI SINI -->
            <!-- ===================================== -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4">
                <div class="text-muted small mb-3 mb-md-0">
                    Menampilkan
                    <span class="fw-semibold text-dark">{{ $bukus->firstItem() ?? 0 }}</span>
                    sampai
                    <span class="fw-semibold text-dark">{{ $bukus->lastItem() ?? 0 }}</span>
                    dari total
                    <span class="fw-semibold text-dark">{{ $bukus->total() }}</span> buku.
                </div>

                <div>
                    <!-- Menampilkan link halaman dengan style Bootstrap 5 -->
                    {{ $bukus->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </section>

    </div>

    <!-- ========================================================= -->
    <!-- DAFTAR MODAL DETAIL BUKU (Diletakkan di luar struktur Table) -->
    <!-- ========================================================= -->
    @foreach ($bukus as $buku)
        <div class="modal fade" id="detailModalBuku{{ $buku->id }}" tabindex="-1"
            aria-labelledby="detailModalBukuLabel{{ $buku->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title h5" id="detailModalBukuLabel{{ $buku->id }}">
                            <i class="bi bi-book"></i> Detail Informasi Buku
                        </h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-4 align-items-start">

                            <!-- Sisi Kiri: Gambar Cover Dinamis -->
                            <div class="col-md-4 text-center">
                                @if ($buku->cover)
                                    <img src="{{ asset('storage/' . $buku->cover) }}" class="img-fluid rounded shadow-sm"
                                        alt="Sampul Buku" style="max-height: 280px; object-fit: cover;">
                                @else
                                    <div class="bg-light p-5 rounded text-muted">
                                        <i class="bi bi-image" style="font-size: 3rem;"></i>
                                        <p>No Cover</p>
                                    </div>
                                @endif
                            </div>

                            <!-- Sisi Kanan: Info Detail Dinamis -->
                            <div class="col-md-8">
                                <table class="table table-borderless mb-0">
                                    <tbody>
                                        <tr>
                                            <th class="ps-0 text-muted" style="width: 30%;">Judul Buku</th>
                                            <td class="fw-bold">: {{ $buku->judul }}</td>
                                        </tr>
                                        <tr>
                                            <th class="ps-0 text-muted">Penulis</th>
                                            <td>: {{ $buku->penulis }}</td>
                                        </tr>
                                        <tr>
                                            <th class="ps-0 text-muted">Kategori</th>
                                            <td>: {{ $buku->kategori->nama_kategori ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="ps-0 text-muted">Tahun Terbit</th>
                                            <td>: {{ $buku->tahun_terbit }}</td>
                                        </tr>
                                        <tr>
                                            <th class="ps-0 text-muted">Jumlah Stok</th>
                                            <td>: <span class="badge text-bg-success fs-6">{{ $buku->jumlah }} Buku</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <!-- Bagian Deskripsi Dinamis -->
                                <hr class="my-3 text-secondary" style="opacity: 0.15;">
                                <h6 class="fw-bold mb-2">Deskripsi / Sinopsis:</h6>
                                <p class="text-muted" style="text-align: justify; font-size: 0.9rem; line-height: 1.6;">
                                    {{ $buku->deskripsi ?: 'Buku ini belum memiliki deskripsi atau sinopsis.' }}
                                </p>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

@endsection
