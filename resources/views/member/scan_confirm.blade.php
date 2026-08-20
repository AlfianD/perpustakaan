@extends('layouts.member')

@section('title', 'Konfirmasi Peminjaman')

@section('content')
    <div class="container py-5 d-flex justify-content-center">
        <div class="card border-0 shadow-sm rounded-4" style="max-width: 450px; width: 100%;">
            <div class="card-header bg-white border-0 text-center pt-4 pb-0">
                <h5 class="fw-bold mb-0">Konfirmasi Pinjam Buku</h5>
                <p class="text-muted small mt-1">Anda memindai QR Code buku berikut:</p>
            </div>

            <div class="card-body text-center pb-4">
                <!-- Cover Buku -->
                <div class="bg-light rounded-3 p-3 mb-3 d-inline-block w-100"
                    style="height: 200px; display: flex; align-items: center; justify-content: center;">
                    @if ($buku->cover)
                        <img src="{{ asset('storage/' . $buku->cover) }}" alt="Cover"
                            style="max-height: 100%; max-width: 100%; object-fit: contain;">
                    @else
                        <i class="bi bi-book text-secondary" style="font-size: 5rem;"></i>
                    @endif
                </div>

                <!-- Detail Buku -->
                <h5 class="fw-bold text-dark mb-1">{{ $buku->judul }}</h5>
                <p class="text-muted small mb-4">{{ $buku->penulis }}</p>

                <!-- Status Buku -->
                <div class="d-flex justify-content-between align-items-center border-top border-bottom py-3 mb-4">
                    <span class="text-muted fw-medium">Status Ketersediaan:</span>
                    @if ($isHabis)
                        <span class="badge bg-danger px-3 py-2 rounded-pill">Stok Habis</span>
                    @elseif($isDipinjamUser)
                        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">Sedang Anda Pinjam</span>
                    @else
                        <span class="badge bg-success px-3 py-2 rounded-pill">Tersedia ({{ $buku->jumlah }})</span>
                    @endif
                </div>

                <!-- Tombol Aksi -->
                @if ($isHabis || $isDipinjamUser)
                    <a href="{{ route('member.index') }}" class="btn btn-secondary w-100 rounded-pill py-2">Kembali ke
                        Beranda</a>
                @else
                    <button type="button" class="btn btn-primary w-100 rounded-pill py-2 action-pinjam mb-2"
                        data-id="{{ $buku->id }}">
                        <i class="bi bi-check-circle me-1"></i> Ya, Pinjam Buku Ini
                    </button>
                    <a href="{{ route('member.index') }}" class="btn btn-link text-muted text-decoration-none w-100">Batal &
                        Kembali</a>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('click', async function(e) {
            let btnPinjam = e.target.closest('.action-pinjam');

            if (btnPinjam) {
                let bukuId = btnPinjam.dataset.id;

                // Ubah tombol jadi loading agar user tidak klik 2x
                let originalText = btnPinjam.innerHTML;
                btnPinjam.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memproses...';
                btnPinjam.disabled = true;

                try {
                    let response = await fetch("{{ route('member.pinjam') }}", {
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
                        alert('Berhasil! Buku berhasil dipinjam.');
                        // Jika sukses, langsung arahkan ke halaman riwayat
                        window.location.href = "{{ route('member.riwayat') }}";
                    } else {
                        alert(result.message);
                        // Kembalikan tombol ke semula jika gagal (misal: tiba-tiba kehabisan stok)
                        btnPinjam.innerHTML = originalText;
                        btnPinjam.disabled = false;
                    }
                } catch (err) {
                    alert('Terjadi kesalahan jaringan atau server.');
                    btnPinjam.innerHTML = originalText;
                    btnPinjam.disabled = false;
                }
            }
        });
    </script>
@endpush
