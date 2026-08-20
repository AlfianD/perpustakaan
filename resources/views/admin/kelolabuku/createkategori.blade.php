@extends('layouts.admin')

@section('title', 'Tambah Kategori Buku')

@section('content')
    <div class="container-fluid px-3 px-lg-4 py-4">
        <div class="page-heading mb-4">
            <div class="page-heading-copy">
                <span class="page-icon"><i class="bi bi-bookmark-plus" aria-hidden="true"></i></span>
                <div>
                    <p class="eyebrow mb-1">Katalog</p>
                    <h1 class="h3 mb-1">Tambah Kategori Baru</h1>
                    <p class="text-muted mb-0">Buat kategori baru untuk mempermudah pengelompokan buku.</p>
                </div>
            </div>
            <div class="heading-actions">
                <a class="btn btn-outline-secondary btn-sm" href="{{ route('admin.kategori.index') }}">
                    <i class="bi bi-arrow-left" aria-hidden="true"></i> Kembali
                </a>
            </div>
        </div>

        <section class="row g-3">
            <div class="col-12 col-xl-8">
                <form class="panel" action="{{ route('admin.kategori.store') }}" method="POST">
                    @csrf
                    <div class="panel-header mb-3 border-bottom pb-3">
                        <h2 class="h5 mb-0 section-title"><i class="bi bi-plus-circle"></i> Form Tambah Kategori</h2>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="nama_kategori">Nama Kategori <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama_kategori') is-invalid @enderror"
                            id="nama_kategori" name="nama_kategori" value="{{ old('nama_kategori') }}"
                            placeholder="Contoh: Fiksi, Sains, Teknologi" required>
                        @error('nama_kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold" for="deskripsi">Deskripsi <span
                                class="text-muted fw-normal">(Opsional)</span></label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="4"
                            placeholder="Keterangan mengenai kategori ini...">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2 border-top pt-3">
                        <a href="{{ route('admin.kategori.index') }}" class="btn btn-light">Batal</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Simpan Kategori
                        </button>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection
