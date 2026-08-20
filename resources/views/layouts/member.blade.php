<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIPINTAR — Portal Peminjam')</title>

    <!-- Fonts & Icons -->
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Inter:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        /* ===== 1. ROOT & BASE ===== */
        :root {
            --navy: #0B2545;
            --navy-dk: #071A33;
            --navy-lt: #12386B;
            --sky: #1B98E0;
            --green: #1F9D55;
            --red: #E5484D;
            --orange: #F0872F;
            --black: #12151C;
            --bg: #F2F5F9;
            --card-bd: #E6EAF0;
            --muted: #7C8798;
        }

        * {
            box-sizing: border-box;
        }

        body {
            background: var(--bg);
            font-family: 'Inter', sans-serif;
            color: var(--black);
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        .brand,
        .stat-num {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .text-muted-sm {
            color: var(--muted);
            font-size: .8rem;
        }

        /* ===== 2. NAVBAR ===== */
        .navbar-sipintar {
            background: linear-gradient(90deg, var(--navy), var(--navy-dk));
            padding: .7rem 0;
            position: sticky;
            top: 0;
            z-index: 1030;
            box-shadow: 0 2px 10px rgba(7, 26, 51, .15);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: .6rem;
            color: #fff;
            font-weight: 800;
            font-size: 1.1rem;
            text-decoration: none;
        }

        .brand-badge {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: var(--sky);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            color: #fff;
        }

        .nav-pill {
            color: rgba(255, 255, 255, .7) !important;
            font-weight: 600;
            font-size: .9rem;
            padding: .5rem 1rem !important;
            border-radius: 10px;
            margin: 0 .15rem;
        }

        .nav-pill i {
            margin-right: .4rem;
        }

        .nav-pill:hover {
            color: #fff !important;
            background: rgba(255, 255, 255, .06);
        }

        .nav-pill.active {
            color: #fff !important;
            background: rgba(27, 152, 224, .22);
        }

        .icon-btn {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: rgba(255, 255, 255, .08);
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            position: relative;
        }

        .icon-btn .dot {
            position: absolute;
            top: 6px;
            right: 7px;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--orange);
            border: 2px solid var(--navy);
        }

        .avatar {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: var(--sky);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: .85rem;
            flex-shrink: 0;
        }

        .profile-chip {
            display: flex;
            align-items: center;
            gap: .6rem;
            cursor: pointer;
            color: #fff;
        }

        /* ===== 3. LAYOUT & CARDS ===== */
        .content {
            padding: 1.75rem 0 3rem;
        }

        .view {
            display: none;
        }

        .view.active {
            display: block;
            animation: fadein .2s ease;
        }

        @keyframes fadein {
            from {
                opacity: 0;
                transform: translateY(4px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .page-head {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            flex-wrap: wrap;
            gap: .75rem;
            margin-bottom: 1.25rem;
        }

        .page-head h4 {
            font-weight: 800;
            margin: 0;
        }

        .page-head .sub {
            color: var(--muted);
            font-size: .85rem;
        }

        .card {
            border: 1px solid var(--card-bd);
            border-radius: 14px;
            box-shadow: 0 1px 2px rgba(15, 23, 42, .04);
        }

        .greet-card {
            background: linear-gradient(135deg, var(--navy), var(--navy-lt));
            color: #fff;
            border: none;
            border-radius: 16px;
            padding: 1.5rem 1.75rem;
            position: relative;
            overflow: hidden;
        }

        .greet-card::after {
            content: "";
            position: absolute;
            right: -40px;
            top: -40px;
            width: 180px;
            height: 180px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(27, 152, 224, .35), transparent 70%);
        }

        .stat-card {
            padding: 1.1rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: #fff;
            flex-shrink: 0;
        }

        .stat-num {
            font-size: 1.4rem;
            font-weight: 800;
            line-height: 1;
        }

        .stat-label {
            color: var(--muted);
            font-size: .78rem;
            margin-top: .15rem;
        }

        .card-header-plain {
            background: #fff;
            border-bottom: 1px solid var(--card-bd);
            border-radius: 14px 14px 0 0 !important;
            padding: 1rem 1.25rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: .5rem;
        }

        .card-header-plain h6 {
            margin: 0;
            font-weight: 700;
        }

        /* ===== 4. BADGES & BUTTONS ===== */
        .badge-soft {
            font-weight: 600;
            font-size: .72rem;
            padding: .38em .7em;
            border-radius: 20px;
        }

        .b-green {
            background: rgba(31, 157, 85, .12);
            color: var(--green);
        }

        .b-red {
            background: rgba(229, 72, 77, .12);
            color: var(--red);
        }

        .b-orange {
            background: rgba(240, 135, 47, .12);
            color: var(--orange);
        }

        .b-navy {
            background: rgba(11, 37, 69, .10);
            color: var(--navy);
        }

        .b-sky {
            background: rgba(27, 152, 224, .12);
            color: var(--sky);
        }

        .btn-navy {
            background: var(--navy);
            border-color: var(--navy);
            color: #fff;
        }

        .btn-navy:hover {
            background: var(--navy-lt);
            border-color: var(--navy-lt);
            color: #fff;
        }

        .btn-outline-navy {
            border-color: var(--navy);
            color: var(--navy);
        }

        .btn-outline-navy:hover {
            background: var(--navy);
            color: #fff;
        }

        .btn-sky {
            background: var(--sky);
            border-color: var(--sky);
            color: #fff;
        }

        .btn-sky:hover {
            background: #1685c7;
            border-color: #1685c7;
            color: #fff;
        }

        /* ===== 5. BOOK CATALOG & TABLES ===== */
        /* ===== Perbaikan untuk Cover Buku ===== */
        .book-cover {
            height: 170px;
            border-radius: 12px 12px 0 0;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255, 255, 255, .85);
            font-size: 2.2rem;
            background-color: #f8f9fa;
            /* Memberi latar belakang terang jika gambar tidak memenuhi kotak */
            background-size: contain !important;
            /* Memastikan gambar utuh tidak ter-crop */
            background-position: center !important;
            background-repeat: no-repeat !important;
        }



        .book-cover .ribbon {
            position: absolute;
            top: 10px;
            right: -32px;
            background: var(--red);
            color: #fff;
            font-size: .68rem;
            font-weight: 700;
            padding: .25rem 2.2rem;
            transform: rotate(40deg);
            box-shadow: 0 2px 6px rgba(0, 0, 0, .2);
        }

        .book-card {
            border-radius: 14px;
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
            transition: box-shadow .15s, transform .15s;
        }

        .book-card:hover {
            box-shadow: 0 8px 22px rgba(11, 37, 69, .12);
            transform: translateY(-2px);
        }

        .book-card .body {
            padding: 1rem 1rem 1.1rem;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .book-title {
            font-weight: 700;
            font-size: .94rem;
            line-height: 1.3;
            margin-bottom: .15rem;
        }

        .book-author {
            color: var(--muted);
            font-size: .78rem;
            margin-bottom: .55rem;
        }

        .book-avail {
            font-size: .76rem;
            color: var(--muted);
            margin-bottom: .7rem;
            min-height: 2.1em;
        }

        .book-avail b {
            color: var(--black);
        }

        .toolbar {
            background: #fff;
            border: 1px solid var(--card-bd);
            border-radius: 14px;
            padding: .9rem 1.1rem;
        }

        .loan-card {
            display: flex;
            gap: 1rem;
            padding: 1rem;
            align-items: center;
        }

        .loan-cover {
            width: 52px;
            height: 70px;
            border-radius: 8px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.3rem;
        }

        .subtab .nav-link {
            border: none;
            border-radius: 10px;
            color: var(--muted);
            font-weight: 600;
            font-size: .85rem;
            padding: .5rem 1rem;
            margin-right: .4rem;
            cursor: pointer;
        }

        .subtab .nav-link.active {
            background: var(--navy);
            color: #fff;
        }

        .table-modern thead th {
            background: var(--bg);
            color: var(--muted);
            font-size: .72rem;
            text-transform: uppercase;
            letter-spacing: .6px;
            font-weight: 700;
            border-bottom: none;
            padding: .75rem 1rem;
            white-space: nowrap;
        }

        .table-modern tbody td {
            padding: .75rem 1rem;
            vertical-align: middle;
            font-size: .86rem;
            border-bottom: 1px solid var(--card-bd);
        }

        .table-modern tbody tr:last-child td {
            border-bottom: none;
        }

        .table-modern tbody tr:hover {
            background: #FAFBFD;
        }

        /* ===== 6. MODALS & UTILITIES ===== */
        .modal-content {
            border-radius: 16px;
            border: none;
        }

        .detail-cover {
            height: 250px;
            /* Ditinggikan sedikit agar detail modal lebih luas */
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 3rem;
            background-color: #f8f9fa;
            /* Latar belakang untuk modal detail */
            background-size: contain !important;
            /* Memastikan gambar tampil utuh */
            background-position: center !important;
            background-repeat: no-repeat !important;
        }

        .toast {
            border-radius: 12px;
        }

        .empty-state {
            text-align: center;
            color: var(--muted);
            font-size: .85rem;
            padding: 2.5rem 1rem;
        }

        /* Perbaikan agar teks menu Beranda & Riwayat lebih jelas dan kontras */
        .navbar-sipintar .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            /* Dibuat lebih terang */
            font-weight: 600;
            font-size: .95rem;
            padding: .5rem 1rem !important;
            border-radius: 10px;
            margin: 0 .15rem;
            transition: all 0.2s ease;
        }

        .navbar-sipintar .nav-link:hover {
            color: #ffffff !important;
            background: rgba(255, 255, 255, 0.15);
        }

        .navbar-sipintar .nav-link.active {
            color: #ffffff !important;
            background: var(--sky);
            /* Warna biru terang agar sangat kontras saat aktif */
            font-weight: 700;
        }

        /* Styling tambahan untuk Dropdown Notifikasi */
        .notification-dropdown {
            width: 320px;
            max-height: 380px;
            overflow-y: auto;
            border-radius: 14px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            border: 1px solid var(--card-bd);
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-sipintar">
        <div class="container">
            <a class="brand" href="{{ route('member.index') }}">
                <span class="brand-badge"><i class="bi bi-book-half"></i></span>
                SIPINTAR
            </a>
            <button class="navbar-toggler border-0 text-white" type="button" data-bs-toggle="collapse"
                data-bs-target="#navMain">
                <i class="bi bi-list text-white fs-3"></i>
            </button>
            <div class="collapse navbar-collapse" id="navMain">
                <ul class="navbar-nav mx-lg-4">
                    <!-- Menu Beranda -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('member.index') ? 'active' : '' }}"
                            href="{{ route('member.index') }}">
                            <i class="bi bi-house-fill me-1"></i> Beranda
                        </a>
                    </li>
                    <!-- Menu Riwayat (Diperbaiki menggunakan URL route Laravel) -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('member.riwayat') ? 'active' : '' }}"
                            href="{{ route('member.riwayat') }}">
                            <i class="bi bi-clock-history me-1"></i> Riwayat
                        </a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-2 ms-lg-auto mt-3 mt-lg-0">
                    <!-- Dropdown Notifikasi Buku Baru -->
                    <div class="dropdown">
                        <button class="icon-btn position-relative" data-bs-toggle="dropdown" aria-expanded="false"
                            id="notifDropdownBtn">
                            <i class="bi bi-bell-fill"></i>
                            @php
                                // Ambil waktu batas pembanding (prioritas dari session 'notif_read_at', jika belum ada pakai 'last_login_at')
                                $batasWaktu =
                                    session('notif_read_at') ?? (session('last_login_at') ?? \Carbon\Carbon::now());

                                // Ambil buku yang ditambahkan SETELAH waktu login/dibaca
                                $bukuBaruNotif = \App\Models\Buku::where('created_at', '>', $batasWaktu)
                                    ->latest()
                                    ->get();
                                $jumlahBukuBaru = $bukuBaruNotif->count();
                            @endphp

                            @if ($jumlahBukuBaru > 0)
                                <span class="dot" id="notifDot"></span>
                            @endif
                        </button>

                        <ul class="dropdown-menu dropdown-menu-end notification-dropdown p-2 mt-2">
                            <li class="px-3 py-2 border-bottom d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-dark" style="font-size: 0.85rem;">Notifikasi Buku Baru</span>
                                <span class="badge bg-primary rounded-pill" id="notifBadgeCount"
                                    style="font-size: 0.7rem;">{{ $jumlahBukuBaru }} Baru</span>
                            </li>

                            <div style="max-height: 280px; overflow-y: auto;" id="notifListContainer">
                                @forelse($bukuBaruNotif as $bukuBaru)
                                    <li>
                                        <a class="dropdown-item py-2 px-3 border-bottom rounded-3 my-1 text-wrap"
                                            href="{{ route('member.index') }}">
                                            <div class="d-flex align-items-start gap-2">
                                                <i class="bi bi-journal-plus text-primary fs-5 mt-1"></i>
                                                <div>
                                                    <div class="fw-semibold text-dark"
                                                        style="font-size: 0.82rem; line-height: 1.2;">
                                                        {{ $bukuBaru->judul }}
                                                    </div>
                                                    <small class="text-muted" style="font-size: 0.73rem;">
                                                        Ditambahkan {{ $bukuBaru->created_at->diffForHumans() }}
                                                    </small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                @empty
                                    <li class="text-center py-4 text-muted" style="font-size: 0.82rem;"
                                        id="emptyNotifText">
                                        <i class="bi bi-bell-slash fs-4 d-block mb-1 text-secondary"></i>
                                        Tidak ada buku baru saat ini.
                                    </li>
                                @endforelse
                            </div>
                        </ul>
                    </div>

                    <!-- Dropdown Profil Karyawan (Tetap seperti sebelumnya) -->
                    <div class="dropdown">
                        <div class="profile-chip" data-bs-toggle="dropdown" role="button">
                            <div class="avatar">
                                {{ strtoupper(substr(auth()->guard('karyawan')->user()->name ?? 'U', 0, 2)) }}
                            </div>
                            <div class="d-none d-sm-block">
                                <div style="font-size:.85rem;font-weight:700;line-height:1.1;">
                                    {{ auth()->guard('karyawan')->user()->name ?? 'Karyawan' }}
                                </div>
                                <div class="text-muted-sm" style="line-height:1;color:rgba(255,255,255,.55);">
                                    {{ auth()->guard('karyawan')->user()->divisi ?? 'Member' }}
                                </div>
                            </div>
                            <i class="bi bi-chevron-down ms-1" style="font-size:.7rem;color:rgba(255,255,255,.6);"></i>
                        </div>
                        <ul class="dropdown-menu dropdown-menu-end mt-2">
                            <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profil Saya</a>
                            </li>
                            <li><a class="dropdown-item" href="{{ route('member.riwayat') }}"><i
                                        class="bi bi-clock-history me-2"></i>Riwayat Peminjaman</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger"><i
                                            class="bi bi-box-arrow-right me-2"></i>Keluar</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- KONTEN UTAMA -->
    <div class="content">
        <div class="container">
            @yield('content')
        </div>
    </div>

    <!-- FOOTER -->
    <footer class="text-center text-muted-sm py-4">
        SIPINTAR — Portal Peminjam &copy; {{ date('Y') }} PT Cipta Progresa Usaha
    </footer>

    <!-- AREA UNTUK GLOBAL MODAL / TOAST (Opsional, diletakkan di dalam index.blade.php juga bisa) -->
    @stack('modals')

    <!-- SCRIPT BOOTSTRAP -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- STACK SCRIPT KHUSUS HALAMAN -->
    @stack('scripts')
    <!-- Tambahkan Skrip JavaScript untuk Menghilangkan Titik Merah saat Diklik -->
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const notifBtn = document.getElementById('notifDropdownBtn');
                if (notifBtn) {
                    notifBtn.addEventListener('click', async function() {
                        let dot = document.getElementById('notifDot');
                        let badge = document.getElementById('notifBadgeCount');

                        // Jika titik merah masih ada, kirim sinyal ke server bahwa notifikasi sudah dibuka
                        if (dot) {
                            try {
                                let response = await fetch("{{ route('member.baca.notifikasi') }}", {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'Accept': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    }
                                });

                                let result = await response.json();
                                if (result.success) {
                                    // Hilangkan titik merah dan ubah badge jadi 0 secara visual
                                    dot.remove();
                                    if (badge) badge.innerText = '0 Baru';
                                }
                            } catch (err) {
                                console.error('Gagal memperbarui status notifikasi');
                            }
                        }
                    });
                }
            });
        </script>
    @endpush
</body>

</html>
