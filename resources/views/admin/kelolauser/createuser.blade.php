@extends('layouts.admin')

@section('title', 'Tambah User')

@section('content')
    <div class="container-fluid px-3 px-lg-4 py-4">
        <div class="page-heading">
            <div class="page-heading-copy">
                <span class="page-icon"><i class="bi bi-person-plus" aria-hidden="true"></i></span>
                <div>
                    <p class="eyebrow mb-1">Management</p>
                    <h1 class="h3 mb-1">Tambah User Karyawan</h1>
                    <p class="text-muted mb-0">Buat akun pengguna baru dengan hak akses dan divisi masing-masing.</p>
                </div>
            </div>
            <div class="heading-actions">
                <!-- Ubah link href untuk tombol kembali -->
                <a class="btn btn-outline-secondary btn-sm" href="{{ route('admin.user.index') }}">
                    <i class="bi bi-arrow-left" aria-hidden="true"></i> Kembali ke Daftar User
                </a>
            </div>
        </div>

        <section class="row g-3">
            <div class="col-12 col-xl-8">
                <!-- Tambahkan action, method, dan token CSRF -->
                <form class="panel" action="{{ route('admin.user.store') }}" method="POST">
                    @csrf

                    <div class="panel-header">
                        <div>
                            <h2 class="h5 mb-1 section-title"><i class="bi bi-person-plus"
                                    aria-hidden="true"></i><span>Informasi Karyawan</span></h2>
                            <p class="text-muted mb-0">Lengkapi data di bawah ini untuk membuat akun baru.</p>
                        </div>
                    </div>

                    <div class="row g-3">
                        <!-- Kolom Nama Lengkap -->
                        <div class="col-12">
                            <label class="form-label" for="name">Nama Lengkap</label>
                            <input class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                                type="text" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Kolom ID Karyawan -->
                        <div class="col-md-6">
                            <label class="form-label" for="idkaryawan">ID Karyawan</label>
                            <input class="form-control @error('idkaryawan') is-invalid @enderror" id="idkaryawan"
                                name="idkaryawan" type="text" value="{{ old('idkaryawan') }}"
                                placeholder="Contoh: 0704200001" required>
                            @error('idkaryawan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Kolom Divisi (Dropdown Otomatis dari Controller) -->
                        <div class="col-md-6">
                            <label class="form-label" for="divisi">Divisi</label>
                            <select class="form-select @error('divisi') is-invalid @enderror" id="divisi" name="divisi"
                                required>
                                <option value="" disabled {{ old('divisi') ? '' : 'selected' }}>-- Pilih Divisi --
                                </option>
                                @foreach ($divisi as $dvs)
                                    <option value="{{ $dvs }}" {{ old('divisi') == $dvs ? 'selected' : '' }}>
                                        {{ $dvs }}</option>
                                @endforeach
                            </select>
                            @error('divisi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Kolom Kata Sandi -->
                        <div class="col-12">
                            <label class="form-label" for="password">Kata Sandi</label>
                            <input class="form-control @error('password') is-invalid @enderror" id="password"
                                name="password" type="password" placeholder="Minimal 5 karakter" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Tombol Form -->
                    <div class="d-flex flex-wrap justify-content-end gap-2 mt-4">
                        <a class="btn btn-outline-secondary" href="{{ route('admin.user.index') }}">Batal</a>
                        <button class="btn btn-primary" type="submit">
                            <i class="bi bi-person-check" aria-hidden="true"></i> Simpan Karyawan
                        </button>
                    </div>
                </form>
            </div>

            <!-- Checklist (Tidak perlu diubah logic-nya, sekadar info visual) -->
            <div class="col-12 col-xl-4">
                <div class="panel h-100">
                    <h2 class="h5 mb-3 section-title"><i class="bi bi-list-check" aria-hidden="true"></i><span>Panduan
                            Akses</span></h2>
                    <div class="activity-list">
                        <div class="activity-item"><span class="activity-dot bg-success"></span>
                            <div>
                                <p class="mb-1 fw-semibold">ID Karyawan</p>
                                <p class="text-muted small mb-0">Pastikan ID Karyawan unik dan belum pernah digunakan.</p>
                            </div>
                        </div>
                        <div class="activity-item"><span class="activity-dot bg-primary"></span>
                            <div>
                                <p class="mb-1 fw-semibold">Data Divisi</p>
                                <p class="text-muted small mb-0">Pemilihan divisi yang tepat membantu pengelompokan anggota.
                                </p>
                            </div>
                        </div>
                        <div class="activity-item"><span class="activity-dot bg-warning"></span>
                            <div>
                                <p class="mb-1 fw-semibold">Kata Sandi</p>
                                <p class="text-muted small mb-0">Beritahu karyawan untuk menjaga kerahasiaan kata sandinya.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
