@extends('layouts.member')

@section('title', 'Beranda - SIPINTAR')

@section('content')
    <div class="container-fluid px-4 py-4">
        <!-- Greet Card -->
        <div class="card bg-primary text-white shadow-sm mb-4 border-0 rounded-4 p-4">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <div class="small opacity-75">Selamat datang 👋</div>
                    <h3 class="fw-bold mb-1">Halo, {{ auth()->guard('karyawan')->user()->name ?? 'Karyawan' }}</h3>
                    <p class="mb-0 opacity-85 small">Yuk jelajahi katalog dan pinjam langsung buku yang Anda mau dengan
                        mudah.</p>
                </div>
                <div class="col-lg-5 mt-3 mt-lg-0 text-lg-end d-flex gap-2 justify-content-lg-end flex-wrap">
                    <span class="badge bg-light text-dark px-3 py-2 rounded-pill shadow-sm">
                        <i class="bi bi-check2-circle text-success me-1"></i> {{ $totalBukuTersedia }} buku tersedia
                    </span>
                    <span class="badge bg-light text-dark px-3 py-2 rounded-pill shadow-sm">
                        <i class="bi bi-journal-check text-primary me-1"></i> {{ $totalPernahDipinjam }} pernah dipinjam
                    </span>
                </div>
            </div>
        </div>

        <!-- Stat Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary text-white p-3 rounded-4 me-3 fs-4"><i
                                class="bi bi-journal-bookmark-fill"></i></div>
                        <div>
                            <h3 class="fw-bold mb-0">{{ $totalSedangDipinjam }}</h3>
                            <span class="text-muted small">Sedang Dipinjam</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
                    <div class="d-flex align-items-center">
                        <div class="bg-success text-white p-3 rounded-4 me-3 fs-4"><i class="bi bi-check-circle-fill"></i>
                        </div>
                        <div>
                            <h3 class="fw-bold mb-0">{{ $totalBukuTersedia }}</h3>
                            <span class="text-muted small">Buku Tersedia</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
                    <div class="d-flex align-items-center">
                        <div class="bg-info text-white p-3 rounded-4 me-3 fs-4"><i class="bi bi-collection-fill"></i></div>
                        <div>
                            <h3 class="fw-bold mb-0">{{ $totalPernahDipinjam }}</h3>
                            <span class="text-muted small">Total Pernah Dipinjam</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Toolbar Pencarian & Filter (Form Get Native) -->
        <div class="card border-0 shadow-sm rounded-4 p-3 mb-4">
            <form action="{{ route('member.index') }}" method="GET" class="row g-2 align-items-center">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 rounded-start-pill ps-3"><i
                                class="bi bi-search text-muted"></i></span>
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="form-control border-start-0 rounded-end-pill" placeholder="Cari judul atau penulis...">
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <select name="kategori" class="form-select rounded-pill" onchange="this.form.submit()">
                        <option value="all">Semua Kategori</option>
                        @foreach ($kategoris as $kat)
                            <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>
                                {{ $kat }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6 col-md-2">
                    <select name="status" class="form-select rounded-pill" onchange="this.form.submit()">
                        <option value="all">Semua Status</option>
                        <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="habis" {{ request('status') == 'habis' ? 'selected' : '' }}>Habis</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="sort" class="form-select rounded-pill" onchange="this.form.submit()">
                        <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                        <option value="judul" {{ request('sort') == 'judul' ? 'selected' : '' }}>Judul A–Z</option>
                    </select>
                </div>
            </form>
        </div>

        <!-- Katalog Grid -->
        <div class="row g-4">
            @forelse($books as $book)
                @php
                    $isHabis = $book->jumlah <= 0;
                    $isDipinjamUser = $activeLoans->contains('buku_id', $book->id);
                @endphp
                <div class="col-6 col-md-4 col-xl-3">
                    <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden d-flex flex-column">
                        <div class="position-relative bg-light text-center py-4" style="height: 180px;">
                            @if ($book->cover)
                                <img src="{{ asset('storage/' . $book->cover) }}" alt="Cover"
                                    class="h-100 object-fit-contain">
                            @else
                                <div class="h-100 d-flex align-items-center justify-content-center text-secondary fs-1">
                                    <i class="bi bi-book"></i>
                                </div>
                            @endif
                            @if ($isHabis)
                                <span class="position-absolute top-0 end-0 badge bg-danger m-2">HABIS</span>
                            @endif
                        </div>
                        <div class="card-body d-flex flex-column">
                            <span
                                class="badge bg-light text-primary border mb-2 w-fit">{{ $book->kategori->nama_kategori ?? 'Umum' }}</span>
                            <h6 class="fw-bold text-dark text-truncate mb-1">{{ $book->judul }}</h6>
                            <p class="text-muted small mb-2 text-truncate">{{ $book->penulis }}</p>
                            <p class="text-secondary small mb-3">Tersedia: <b>{{ $book->jumlah }}</b> eksemplar</p>

                            <div class="mt-auto d-flex gap-2">
                                <button type="button" class="btn btn-outline-primary btn-sm flex-fill rounded-pill"
                                    data-bs-toggle="modal" data-bs-target="#modalDetail{{ $book->id }}">
                                    Detail
                                </button>

                                @if ($isDipinjamUser)
                                    <button type="button"
                                        class="btn btn-warning btn-sm flex-fill rounded-pill text-white action-kembalikan"
                                        data-id="{{ $book->id }}">Kembalikan</button>
                                @elseif($isHabis)
                                    <button type="button" class="btn btn-secondary btn-sm flex-fill rounded-pill"
                                        disabled>Habis</button>
                                @else
                                    <button type="button"
                                        class="btn btn-primary btn-sm flex-fill rounded-pill action-pinjam"
                                        data-id="{{ $book->id }}">Pinjam</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Include Modal Detail Per Buku (Standar Bootstrap 5) -->
                @include('member.modal_detail', [
                    'book' => $book,
                    'isDipinjamUser' => $isDipinjamUser,
                    'isHabis' => $isHabis,
                ])
            @empty
                <div class="col-12 text-center py-5">
                    <i class="bi bi-search fs-1 text-muted d-block mb-2"></i>
                    <p class="text-muted">Tidak ada buku yang cocok dengan pencarian Anda.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // AJAX Sederhana Tanpa Library Berat untuk Pinjam & Kembalikan
        document.addEventListener('click', async function(e) {
            let btnPinjam = e.target.closest('.action-pinjam');
            let btnKembali = e.target.closest('.action-kembalikan');

            if (btnPinjam) {
                let bukuId = btnPinjam.dataset.id;
                await prosesTransaksi("{{ route('member.pinjam') }}", bukuId);
            }

            if (btnKembali) {
                let bukuId = btnKembali.dataset.id;
                await prosesTransaksi("{{ route('member.kembalikan') }}", bukuId);
            }
        });

        async function prosesTransaksi(url, bukuId) {
            try {
                let response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        buku_id: bukuId
                    })
                });

                let result = await response.json();
                if (result.success) {
                    location.reload();
                } else {
                    alert(result.message);
                }
            } catch (err) {
                alert('Terjadi kesalahan jaringan atau server.');
            }
        }
    </script>
@endpush
