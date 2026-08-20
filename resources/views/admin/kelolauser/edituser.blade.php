@extends('layouts.admin')

@section('title', 'Edit Data Karyawan')

@section('content')
    <div class="container-fluid px-3 px-lg-4 py-4">
        <div class="page-heading">
            <div class="page-heading-copy">
                <span class="page-icon"><i class="bi bi-pencil-square" aria-hidden="true"></i></span>
                <div>
                    <p class="eyebrow mb-1">Management</p>
                    <h1 class="h3 mb-1">Edit User Karyawan</h1>
                    <p class="text-muted mb-0">Perbarui informasi profil dan hak akses karyawan.</p>
                </div>
            </div>
            <div class="heading-actions">
                <a class="btn btn-outline-secondary btn-sm" href="{{ route('admin.user.index') }}">
                    <i class="bi bi-arrow-left" aria-hidden="true"></i> Kembali ke Daftar User
                </a>
            </div>
        </div>

        <section class="row g-3">
            <div class="col-12 col-xl-8">
                <!-- ACTION mengarah ke update dengan mengirimkan ID Karyawan -->
                <form class="panel" action="{{ route('admin.user.update', $karyawan->id) }}" method="POST">
                    @csrf
                    <!-- Wajib tambahkan @method('PUT') untuk proses update di Laravel -->
                    @method('PUT')

                    <div class="panel-header">
                        <div>
                            <h2 class="h5 mb-1 section-title"><i class="bi bi-pencil" aria-hidden="true"></i><span>Form Edit
                                    Karyawan</span></h2>
                            <p class="text-muted mb-0">Ubah data yang diperlukan pada kolom di bawah ini.</p>
                        </div>
                    </div>

                    <div class="row g-3">
                        <!-- Kolom Nama Lengkap -->
                        <div class="col-12">
                            <label class="form-label" for="name">Nama Lengkap</label>
                            <!-- Value mengambil dari data lama ($karyawan->name) -->
                            <input class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                                type="text" value="{{ old('name', $karyawan->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Kolom ID Karyawan -->
                        <div class="col-md-6">
                            <label class="form-label" for="idkaryawan">ID Karyawan</label>
                            <input class="form-control @error('idkaryawan') is-invalid @enderror" id="idkaryawan"
                                name="idkaryawan" type="text" value="{{ old('idkaryawan', $karyawan->idkaryawan) }}"
                                required>
                            @error('idkaryawan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Kolom Divisi -->
                        <div class="col-md-6">
                            <label class="form-label" for="divisi">Divisi</label>
                            <select class="form-select @error('divisi') is-invalid @enderror" id="divisi" name="divisi"
                                required>
                                <option value="" disabled>-- Pilih Divisi --</option>
                                @foreach ($divisi as $dvs)
                                    <!-- Logika untuk memilih divisi yang tersimpan di database -->
                                    <option value="{{ $dvs }}"
                                        {{ old('divisi', $karyawan->divisi) == $dvs ? 'selected' : '' }}>{{ $dvs }}
                                    </option>
                                @endforeach
                            </select>
                            @error('divisi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Kolom Kata Sandi (Opsional) -->
                        <div class="col-12">
                            <label class="form-label" for="password">Kata Sandi Baru <span
                                    class="text-muted fw-normal">(Opsional)</span></label>
                            <!-- Hapus atribut required agar admin bisa menyimpan tanpa harus mengganti password -->
                            <input class="form-control @error('password') is-invalid @enderror" id="password"
                                name="password" type="password"
                                placeholder="Biarkan kosong jika tidak ingin mengubah kata sandi">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Tombol Form -->
                    <div class="d-flex flex-wrap justify-content-end gap-2 mt-4">
                        <a class="btn btn-outline-secondary" href="{{ route('admin.user.index') }}">Batal</a>
                        <button class="btn btn-warning text-white" type="submit">
                            <i class="bi bi-save" aria-hidden="true"></i> Perbarui Data
                        </button>
                    </div>
                </form>
            </div>

            <div class="col-12 col-xl-4">
                <div class="panel h-100">
                    <h2 class="h5 mb-3 section-title"><i class="bi bi-info-circle" aria-hidden="true"></i><span>Informasi
                            Edit</span></h2>
                    <div class="activity-list">
                        <div class="activity-item"><span class="activity-dot bg-warning"></span>
                            <div>
                                <p class="mb-1 fw-semibold">Data Tersimpan</p>
                                <p class="text-muted small mb-0">Semua perubahan akan langsung menimpa data lama di
                                    database.</p>
                            </div>
                        </div>
                        <div class="activity-item"><span class="activity-dot bg-success"></span>
                            <div>
                                <p class="mb-1 fw-semibold">Ubah Kata Sandi</p>
                                <p class="text-muted small mb-0">Jika kolom kata sandi dibiarkan kosong, sistem akan
                                    menggunakan kata sandi yang lama.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
