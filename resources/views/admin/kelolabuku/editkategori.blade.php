@extends('layouts.admin')

@section('title', 'Edit Kategori Buku')

@section('content')
    <div class="container-fluid px-3 px-lg-4 py-4">
        <div class="page-heading mb-4">
            <div class="page-heading-copy">
                <span class="page-icon"><i class="bi bi-pencil-square" aria-hidden="true"></i></span>
                <div>
                    <p class="eyebrow mb-1">Katalog</p>
                    <h1 class="h3 mb-1">Edit Kategori</h1>
                    <p class="text-muted mb-0">Perbarui informasi nama dan deskripsi kategori.</p>
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
                <form class="panel" action="{{ route('admin.kategori.update', $kategori->id) }}" method="POST">
                    @csrf
                    @method('PUT') <!-- Wajib untuk edit data -->

                    <div class="panel-header mb-3 border-bottom pb-3">
                        <h2 class="h5 mb-0 section-title"><i class="bi bi-pencil"></i> Form Edit Kategori</h2>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="nama_kategori">Nama Kategori <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama_kategori') is-invalid @enderror"
                            id="nama_kategori" name="nama_kategori"
                            value="{{ old('nama_kategori', $kategori->nama_kategori) }}" required>
                        @error('nama_kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold" for="deskripsi">Deskripsi <span
                                class="text-muted fw-normal">(Opsional)</span></label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="4">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2 border-top pt-3">
                        <a href="{{ route('admin.kategori.index') }}" class="btn btn-light">Batal</a>
                        <button type="submit" class="btn btn-warning text-white">
                            <i class="bi bi-save"></i> Perbarui Kategori
                        </button>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection
