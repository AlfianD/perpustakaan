@extends('layouts.admin')

@section('title', 'Tambah Buku Baru')

@section('content')
    <div class="container-fluid px-3 px-lg-4 py-4">
        <div class="page-heading">
            <div class="page-heading-copy">
                <span class="page-icon"><i class="bi bi-book" aria-hidden="true"></i></span>
                <div>
                    <p class="eyebrow mb-1">Katalog</p>
                    <h1 class="h3 mb-1">Tambah Buku Baru</h1>
                    <p class="text-muted mb-0">Lengkapi form di bawah ini untuk menambah koleksi buku perpustakaan.</p>
                </div>
            </div>
            <div class="heading-actions">
                <a class="btn btn-outline-secondary btn-sm" href="{{ route('admin.kelolabuku.index') }}">
                    <i class="bi bi-arrow-left" aria-hidden="true"></i> Kembali
                </a>
            </div>
        </div>

        <section class="row g-3">
            <div class="col-12 col-xl-8">
                <!-- PENTING: enctype wajib untuk upload gambar -->
                <form class="panel" action="{{ route('admin.kelolabuku.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="panel-header mb-3 border-bottom pb-3">
                        <h2 class="h5 mb-0 section-title"><i class="bi bi-plus-circle"></i> Form Tambah Buku</h2>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="judul">Judul Buku <span
                                class="text-danger">*</span></label>
                        <input class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul"
                            type="text" value="{{ old('judul') }}" placeholder="Contoh: Laskar Pelangi" required>
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="penulis">Penulis <span
                                class="text-danger">*</span></label>
                        <input class="form-control @error('penulis') is-invalid @enderror" id="penulis" name="penulis"
                            type="text" value="{{ old('penulis') }}" placeholder="Contoh: Andrea Hirata" required>
                        @error('penulis')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <!-- Dropdown Kategori -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold" for="kategori_id">Kategori <span
                                    class="text-danger">*</span></label>
                            <select class="form-select @error('kategori_id') is-invalid @enderror" id="kategori_id"
                                name="kategori_id" required>
                                <option value="" disabled selected>-- Pilih Kategori --</option>
                                @foreach ($kategoris as $kat)
                                    <option value="{{ $kat->id }}"
                                        {{ old('kategori_id') == $kat->id ? 'selected' : '' }}>{{ $kat->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tahun Terbit -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold" for="tahun_terbit">Tahun Terbit <span
                                    class="text-danger">*</span></label>
                            <input class="form-control @error('tahun_terbit') is-invalid @enderror" id="tahun_terbit"
                                name="tahun_terbit" type="number" min="1900" max="{{ date('Y') }}"
                                value="{{ old('tahun_terbit') }}" placeholder="Contoh: 2005" required>
                            @error('tahun_terbit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <!-- Jumlah Buku -->
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-semibold" for="jumlah">Jumlah Stok <span
                                    class="text-danger">*</span></label>
                            <input class="form-control @error('jumlah') is-invalid @enderror" id="jumlah" name="jumlah"
                                type="number" min="0" value="{{ old('jumlah') }}" placeholder="0" required>
                            @error('jumlah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Input Gambar Cover -->
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-semibold" for="cover">Cover Buku <span
                                    class="text-muted fw-normal">(Opsional)</span></label>
                            <input class="form-control @error('cover') is-invalid @enderror" id="cover" name="cover"
                                type="file" accept="image/png, image/jpeg, image/jpg, image/webp">
                            @error('cover')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Format: JPG/PNG/WEBP. Max: 2MB.</small>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold" for="deskripsi">Sinopsis / Deskripsi Buku <span
                                class="text-muted fw-normal">(Opsional)</span></label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="4"
                            placeholder="Tuliskan sinopsis atau deskripsi buku...">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2 border-top pt-3">
                        <a href="{{ route('admin.kelolabuku.index') }}" class="btn btn-light">Batal</a>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan Data
                            Buku</button>
                    </div>
                </form>
            </div>

            <!-- Panel Informasi Samping -->
            <div class="col-12 col-xl-4">
                <div class="panel h-100">
                    <h2 class="h5 mb-3 section-title"><i class="bi bi-info-circle"></i> Petunjuk</h2>
                    <div class="activity-list">
                        <div class="activity-item"><span class="activity-dot bg-primary"></span>
                            <div>
                                <p class="mb-1 fw-semibold">Kategori Kosong?</p>
                                <p class="text-muted small mb-0">Pastikan Anda sudah membuat kategori di menu Kategori Buku
                                    sebelum menambahkan buku baru.</p>
                            </div>
                        </div>
                        <div class="activity-item"><span class="activity-dot bg-success"></span>
                            <div>
                                <p class="mb-1 fw-semibold">Resolusi Gambar</p>
                                <p class="text-muted small mb-0">Gunakan gambar cover dengan rasio potret (berdiri) agar
                                    terlihat rapi di katalog.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
