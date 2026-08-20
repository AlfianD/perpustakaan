@extends('layouts.member')

@section('title', 'Riwayat Peminjaman - SIPINTAR')

@section('content')
    <div class="container-fluid px-4 py-4">
        <div class="page-heading mb-4">
            <h4 class="fw-bold">Riwayat Peminjaman</h4>
            <p class="text-muted small">Pantau buku yang sedang dan pernah Anda pinjam di perpustakaan.</p>
        </div>

        <!-- Stat Ringkasan -->
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-3">
                    <span class="text-muted small">Sedang Dipinjam</span>
                    <h3 class="fw-bold text-primary mb-0">{{ $totalSedangDipinjam }} <span class="fs-6 text-muted">buku
                            aktif</span></h3>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-3">
                    <span class="text-muted small">Total Pernah Dipinjam</span>
                    <h3 class="fw-bold text-success mb-0">{{ $totalPernahDipinjam }} <span
                            class="fs-6 text-muted">buku</span></h3>
                </div>
            </div>
        </div>

        <!-- Buku Aktif -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="fw-bold mb-0">Sedang Dipinjam Aktif</h5>
            </div>
            <div class="card-body">
                @forelse($activeLoans as $loan)
                    <div
                        class="d-flex align-items-center justify-content-between p-3 border rounded-3 mb-2 flex-wrap gap-2">
                        <div>
                            <h6 class="fw-bold mb-1">{{ $loan->buku->judul ?? '-' }}</h6>
                            <span class="text-muted small">Dipinjam sejak:
                                {{ $loan->tgl_pinjam ? \Carbon\Carbon::parse($loan->tgl_pinjam)->translatedFormat('d M Y') : '-' }}
                            </span>
                        </div>
                        <button class="btn btn-warning btn-sm rounded-pill text-white action-kembalikan"
                            data-id="{{ $loan->buku_id }}">
                            <i class="bi bi-box-arrow-in-left me-1"></i> Kembalikan
                        </button>
                    </div>
                @empty
                    <p class="text-muted text-center py-3 mb-0">Anda belum meminjam buku aktif saat ini.</p>
                @endforelse
            </div>
        </div>

        <!-- Riwayat Lengkap -->
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="fw-bold mb-0">Riwayat Lengkap</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Durasi / Status Waktu</th>
                            <th class="text-end pe-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($historyLoans as $hist)
                            <tr>
                                <td class="ps-3 fw-medium">{{ $hist->buku->judul ?? '-' }}</td>
                                <td>{{ $hist->tgl_pinjam ? \Carbon\Carbon::parse($hist->tgl_pinjam)->translatedFormat('d M Y') : '-' }}
                                </td>

                                <!-- Tanggal Kembali aktual, jika belum ada tampilkan '—' -->
                                <td>{{ $hist->tgl_kembali ? \Carbon\Carbon::parse($hist->tgl_kembali)->translatedFormat('d M Y') : '—' }}
                                </td>

                                <!-- Durasi Live Peminjaman (Murni Hari) -->
                                <!-- Durasi Live Peminjaman (Bulat / Full 24 Jam) -->
                                <!-- Durasi Live Peminjaman (Bulat / Full 24 Jam menggunakan floor) -->
                                <td>
                                    @if ($hist->status === 'Dipinjam')
                                        <span class="badge bg-light text-primary border">
                                            Sedang dipinjam
                                            ({{ (int) floor(\Carbon\Carbon::parse($hist->tgl_pinjam)->diffInDays(\Carbon\Carbon::now())) }}
                                            hari)
                                        </span>
                                    @else
                                        <span class="text-muted small">
                                            Total pinjam:
                                            {{ (int) floor(\Carbon\Carbon::parse($hist->tgl_pinjam)->diffInDays(\Carbon\Carbon::parse($hist->tgl_kembali))) }}
                                            hari
                                        </span>
                                    @endif
                                </td>

                                <td class="text-end pe-3">
                                    @if ($hist->status === 'Dipinjam')
                                        <span class="badge bg-warning text-dark rounded-pill px-3">Dipinjam</span>
                                    @else
                                        <span class="badge bg-success rounded-pill px-3">Dikembalikan</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">Belum ada riwayat peminjaman buku.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('click', async function(e) {
            let btnKembali = e.target.closest('.action-kembalikan');
            if (btnKembali) {
                let bukuId = btnKembali.dataset.id;
                try {
                    let response = await fetch("{{ route('member.kembalikan') }}", {
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
                    alert('Terjadi kesalahan jaringan.');
                }
            }
        });
    </script>
@endpush
