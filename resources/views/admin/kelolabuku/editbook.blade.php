@extends('layouts.admin')

@section('title', 'Edit Data Buku')

@section('content')
    <div class="container-fluid px-3 px-lg-4 py-4">
        <div class="page-heading">
            <div class="page-heading-copy">
                <span class="page-icon"><i class="bi bi-pencil-square" aria-hidden="true"></i></span>
                <div>
                    <p class="eyebrow mb-1">Management</p>
                    <h1 class="h3 mb-1">Edit Buku</h1>
                    <p class="text-muted mb-0">Perbarui informasi dan cover buku perpustakaan.</p>
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
                <!-- PENTING: Wajib ada enctype="multipart/form-data" karena ada upload gambar -->
                <form class="panel" action="{{ route('admin.kelolabuku.update', $buku->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="panel-header mb-3">
                        <h2 class="h5 mb-0 section-title"><i class="bi bi-pencil"></i> Form Edit Buku</h2>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="judul">Judul Buku</label>
                        <input class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul"
                            type="text" value="{{ old('judul', $buku->judul) }}" required>
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="penulis">Penulis</label>
                        <input class="form-control @error('penulis') is-invalid @enderror" id="penulis" name="penulis"
                            type="text" value="{{ old('penulis', $buku->penulis) }}" required>
                        @error('penulis')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="kategori_id">Kategori</label>
                            <select class="form-select @error('kategori_id') is-invalid @enderror" id="kategori_id"
                                name="kategori_id" required>
                                <option value="" disabled>-- Pilih Kategori --</option>
                                @foreach ($kategoris as $kat)
                                    <option value="{{ $kat->id }}"
                                        {{ old('kategori_id', $buku->kategori_id) == $kat->id ? 'selected' : '' }}>
                                        {{ $kat->nama_kategori }}</option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="tahun_terbit">Tahun Terbit</label>
                            <input class="form-control @error('tahun_terbit') is-invalid @enderror" id="tahun_terbit"
                                name="tahun_terbit" type="number" value="{{ old('tahun_terbit', $buku->tahun_terbit) }}"
                                required>
                            @error('tahun_terbit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row align-items-center">
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="jumlah">Jumlah Stok</label>
                            <input class="form-control @error('jumlah') is-invalid @enderror" id="jumlah" name="jumlah"
                                type="number" min="0" value="{{ old('jumlah', $buku->jumlah) }}" required>
                            @error('jumlah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-8 mb-3">
                            <label class="form-label" for="cover">Ganti Cover Buku <span
                                    class="text-muted fw-normal">(Opsional)</span></label>
                            <input class="form-control @error('cover') is-invalid @enderror" id="cover" name="cover"
                                type="file" accept="image/*">
                            @error('cover')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Biarkan kosong jika tidak ingin mengganti cover saat ini.</small>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold" for="deskripsi">Sinopsis / Deskripsi Buku <span
                                class="text-muted fw-normal">(Opsional)</span></label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="4">{{ old('deskripsi', $buku->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('admin.kelolabuku.index') }}" class="btn btn-outline-secondary">Batal</a>
                        <button type="submit" class="btn btn-warning text-white"><i class="bi bi-save"></i> Perbarui
                            Buku</button>
                    </div>
                </form>
            </div>

            <div class="col-12 col-xl-4">
                <div class="panel h-100 text-center">
                    <h2 class="h5 mb-3 section-title"><i class="bi bi-image"></i> Cover Saat Ini</h2>
                    @if ($buku->cover)
                        <img src="{{ asset('storage/' . $buku->cover) }}" alt="Cover Buku"
                            class="img-fluid rounded shadow-sm" style="max-height: 300px; object-fit: cover;">
                    @else
                        <div class="alert alert-secondary mt-3">Buku ini belum memiliki gambar cover.</div>
                    @endif
                </div>
            </div>
        </section>
    </div>
@endsection
