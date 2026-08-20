@extends('layouts.admin')

@section('title', 'Kelola User')

@section('content')
    <div class="container-fluid px-3 px-lg-4 py-4">

        <!-- Notifikasi Sukses -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <section class="panel mt-3">
            <div class="panel-header">
                <div>
                    <h2 class="h5 mb-1 section-title"><i class="bi bi-table" aria-hidden="true"></i><span>User List</span>
                    </h2>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    <input class="form-control form-control-sm table-search" type="search" placeholder="Search users"
                        data-table-search="usersTable" aria-label="Search users">
                    <a class="btn btn-primary btn-sm" href="{{ route('admin.user.create') }}">
                        <i class="bi bi-person-plus" aria-hidden="true"></i> Add User
                    </a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table align-middle mb-0" id="usersTable">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">ID Karyawan</th>
                            <th scope="col">Divisi</th>
                            <th scope="col">Status</th>
                            <th scope="col" class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Looping data dari database -->
                        @forelse($karyawans as $karyawan)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <p class="fw-semibold mb-0">{{ $karyawan->name }}</p>
                                    </div>
                                </td>
                                <td>{{ $karyawan->idkaryawan }}</td>
                                <td>{{ $karyawan->divisi }}</td>
                                <td><span class="badge text-bg-success">Active</span></td>
                                <td class="text-end">
                                    <div class="d-flex gap-1 justify-content-end">
                                        <!-- Tombol Edit mengarah ke rute edit dengan ID Karyawan -->
                                        <a href="{{ route('admin.user.edit', $karyawan->id) }}"
                                            class="btn btn-warning btn-sm text-white" title="Edit">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <!-- Tombol Hapus mengarah ke rute destroy -->
                                        <form action="{{ route('admin.user.destroy', $karyawan->id) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Yakin ingin menghapus karyawan ini?');">
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
                                <td colspan="5" class="text-center text-muted py-3">Belum ada data karyawan yang
                                    terdaftar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endsection
