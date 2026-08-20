<div class="modal fade" id="modalDetail{{ $book->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Detail Buku</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-4 align-items-center">
                    <div class="col-md-4 text-center">
                        <div class="bg-light rounded-4 p-3" style="height: 220px;">
                            @if ($book->cover)
                                <img src="{{ asset('storage/' . $book->cover) }}" alt="Cover"
                                    class="h-100 object-fit-contain">
                            @else
                                <div class="h-100 d-flex align-items-center justify-content-center text-secondary fs-1">
                                    <i class="bi bi-book"></i>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-8">
                        <span
                            class="badge bg-light text-primary border mb-2">{{ $book->kategori->nama_kategori ?? 'Umum' }}</span>
                        <h4 class="fw-bold mb-1">{{ $book->judul }}</h4>
                        <p class="text-muted small mb-3">Penulis: {{ $book->penulis }}</p>

                        <div class="row g-2 small text-secondary mb-3">
                            <div class="col-6"><i class="bi bi-building me-1"></i>Penerbit: <b
                                    class="text-dark">{{ $book->penerbit ?? '-' }}</b></div>
                            <div class="col-6"><i class="bi bi-calendar3 me-1"></i>Tahun: <b
                                    class="text-dark">{{ $book->tahun_terbit ?? '-' }}</b></div>
                            <div class="col-12"><i class="bi bi-stack me-1"></i>Stok Tersedia: <b
                                    class="text-dark">{{ $book->jumlah }} eksemplar</b></div>
                        </div>
                        <p class="text-muted small mb-0">
                            {{ $book->deskripsi ?? 'Tidak ada deskripsi tersedia untuk buku ini.' }}</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
                @if ($isDipinjamUser)
                    <button type="button" class="btn btn-warning rounded-pill px-4 text-white action-kembalikan"
                        data-id="{{ $book->id }}" data-bs-dismiss="modal">Kembalikan Buku</button>
                @elseif(!$isHabis)
                    <button type="button" class="btn btn-primary rounded-pill px-4 action-pinjam"
                        data-id="{{ $book->id }}" data-bs-dismiss="modal">Pinjam Buku Ini</button>
                @endif
            </div>
        </div>
    </div>
</div>
