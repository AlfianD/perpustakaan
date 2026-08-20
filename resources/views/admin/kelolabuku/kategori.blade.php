@extends('layouts.admin')

@section('title', 'Kelola Kategori Buku')

@section('content')
    <div class="container-fluid px-3 px-lg-4 py-4">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="panel">
            <div class="panel-header mb-3 d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="h5 mb-1 section-title"><i class="bi bi-table"></i><span>Daftar Kategori Buku</span></h2>
                    <p class="text-muted mb-0">Kelola kategori pengelompokan buku perpustakaan.</p>
                </div>
                <div>
                    <!-- Tombol menuju halaman createkategori -->
                    <a href="{{ route('admin.kategori.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-lg"></i> Tambah Kategori
                    </a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th style="width: 5%;">#</th>
                            <th style="width: 25%;">Nama Kategori</th>
                            <th style="width: 50%;">Deskripsi</th>
                            <th style="width: 20%;" class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kategoris as $index => $kat)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td class="fw-semibold">{{ $kat->nama_kategori }}</td>
                                <td>{{ $kat->deskripsi ?? '-' }}</td>
                                <td class="text-end">
                                    <div class="d-flex gap-1 justify-content-end">
                                        <!-- Tombol Edit -->
                                        <a href="{{ route('admin.kategori.edit', $kat->id) }}"
                                            class="btn btn-warning btn-sm text-white" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <!-- Tombol Hapus -->
                                        <form action="{{ route('admin.kategori.destroy', $kat->id) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Yakin ingin menghapus kategori ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">Belum ada kategori yang ditambahkan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
