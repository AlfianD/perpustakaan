<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="professional admin dashboard template">
    <title>Dashboard | Admin</title>

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>

<body>
    <div class="admin-shell">
        <div class="sidebar-backdrop" data-sidebar-close></div>

        <aside class="admin-sidebar" id="adminSidebar" aria-label="Main navigation">
            <div class="sidebar-header">
                <!-- PERBAIKAN 1: Logo href diarahkan ke route dashboard admin -->
                <a class="brand-mark" href="{{ route('admin.index') }}" aria-label="SIPINTAR Admin Dashboard">
                    <span class="brand-icon"><i class="bi bi-grid-1x2-fill" aria-hidden="true"></i></span>
                    <span class="brand-copy">
                        <span class="brand-title">SIPINTAR</span>
                        <span class="brand-subtitle">Admin</span>
                    </span>
                </a>
            </div>

            <nav class="sidebar-nav">
                <!-- Menu Dashboard -->
                <a class="nav-link {{ request()->routeIs('admin.index') ? 'active' : '' }}"
                    href="{{ route('admin.index') }}">
                    <span class="nav-icon"><i class="bi bi-speedometer2" aria-hidden="true"></i></span>
                    <span class="nav-text">Dashboard</span>
                </a>

                <!-- === MENU KELOLA BUKU DENGAN SUB-MENU === -->
                <a class="nav-link {{ request()->routeIs('admin.kelolabuku.*', 'admin.kategori.*') ? '' : 'collapsed' }}"
                    data-bs-toggle="collapse" href="#menuKelolaBuku" role="button"
                    aria-expanded="{{ request()->routeIs('admin.kelolabuku.*', 'admin.kategori.*') ? 'true' : 'false' }}"
                    aria-controls="menuKelolaBuku">
                    <span class="nav-icon"><i class="bi bi-book" aria-hidden="true"></i></span>
                    <span class="nav-text">Kelola Buku</span>
                    <span class="ms-auto submenu-arrow"><i class="bi bi-chevron-down small"></i></span>
                </a>

                <!-- Sub-menu Container -->
                <div class="collapse {{ request()->routeIs('admin.kelolabuku.*', 'admin.kategori.*') ? 'show' : '' }}"
                    id="menuKelolaBuku">
                    <nav class="sidebar-subnav ps-3">
                        <a class="nav-link {{ request()->routeIs('admin.kelolabuku.*') ? 'active' : '' }}"
                            href="{{ route('admin.kelolabuku.index') }}">
                            <span class="nav-text">Katalog Buku</span>
                        </a>
                        <a class="nav-link {{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}"
                            href="{{ route('admin.kategori.index') }}">
                            <span class="nav-text">Kategori</span>
                        </a>
                    </nav>
                </div>
                <!-- ======================================= -->

                <!-- Menu Kelola Transaksi -->
                <a class="nav-link {{ request()->routeIs('admin.kelolatransaksi.*') ? 'active' : '' }}"
                    href="{{ route('admin.kelolatransaksi.index') }}">
                    <span class="nav-icon"><i class="bi bi-ui-checks-grid" aria-hidden="true"></i></span>
                    <span class="nav-text">Kelola Transaksi</span>
                </a>

                <!-- Menu Kelola User -->
                <a class="nav-link {{ request()->routeIs('admin.user.*') ? 'active' : '' }}"
                    href="{{ route('admin.user.index') }}">
                    <span class="nav-icon"><i class="bi bi-people" aria-hidden="true"></i></span>
                    <span class="nav-text">Kelola User</span>
                </a>
            </nav>
        </aside>

        <div class="admin-main">
            <nav class="navbar admin-navbar navbar-expand bg-white">
                <div class="container-fluid px-3 px-lg-4">
                    <button class="sidebar-toggle" type="button" data-sidebar-toggle aria-controls="adminSidebar"
                        aria-expanded="true" aria-label="Toggle sidebar">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>

                    <form class="d-none d-md-flex ms-3 flex" role="search">
                        <input class="form-control search-input" type="search"
                            placeholder="Cari data buku, transaksi, atau user..." aria-label="Search">
                    </form>

                    <div class="navbar-actions ms-auto">
                        <button class="icon-button theme-toggle" type="button" data-theme-toggle
                            aria-label="Switch color theme" title="Switch color theme">
                            <i class="bi bi-moon-stars" data-theme-icon aria-hidden="true"></i>
                        </button>

                        <!-- NOTifikasi DROPDOWN -->
                        <div class="dropdown">
                            <button class="icon-button" type="button" data-bs-toggle="dropdown" aria-expanded="false"
                                aria-label="Notifications">
                                <span class="notification-dot"></span>
                                <i class="bi bi-bell" aria-hidden="true"></i>
                            </button>
                            <!-- PERBAIKAN 2: Mengarahkan href notifikasi ke rute yang valid (misal ke index user/buku) -->
                            <div class="dropdown-menu dropdown-menu-end notification-menu">
                                <div class="dropdown-header fw-bold text-body">Notifikasi Sistem</div>
                                <a class="dropdown-item" href="{{ route('admin.user.index') }}">
                                    <span class="notification-title">Kelola data user terbaru</span>
                                    <span class="notification-time">Baru saja</span>
                                </a>
                                <a class="dropdown-item" href="{{ route('admin.kelolabuku.index') }}">
                                    <span class="notification-title">Periksa ketersediaan buku</span>
                                    <span class="notification-time">Hari ini</span>
                                </a>
                            </div>
                        </div>

                        <!-- PROFIL & LOGOUT DROPDOWN -->
                        <div class="dropdown">
                            <button class="profile-button dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <img class="avatar-img avatar-sm"
                                    src="{{ asset('assets/images/avatar/avatar.jpg') }}" alt="Profil Admin">

                                <!-- Menampilkan nama admin secara dinamis berdasarkan guard 'web' -->
                                <span class="profile-name d-none d-sm-inline">
                                    {{ Auth::guard('web')->user()->name ?? (Auth::user()->name ?? 'Administrator') }}
                                </span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <hr class="dropdown-divider">
                                </li>

                                <!-- Tombol Sign Out Menggunakan Form -->
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger"
                                            style="cursor: pointer;">
                                            <i class="bi bi-box-arrow-right me-2"></i> Sign out
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>



            <!-- KONTEN DINAMIS -->
            <main class="dashboard-content">

                <!-- PASTIKAN BARIS INI ADA DAN TIDAK TERHAPUS -->
                @yield('content')

            </main>




            <footer class="admin-footer">
                <div class="container-fluid px-3 px-lg-4">
                    <span>Copyright 2026. • Distributed by <a target="_blank" class="fw-bold text-success"
                            href="https://themewagon.com">ThemeWagon</a>
                    </span>
                    <span>Professional dashboard template.</span>
                </div>
            </footer>
        </div>
    </div>

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const table = document.getElementById('ordersTable');
            const headers = table.querySelectorAll('th.sortable');
            const tbody = table.querySelector('tbody');

            // Simpan status arah sorting masing-masing kolom
            const directions = Array.from(headers).map(() => '');

            headers.forEach((header, index) => {
                header.addEventListener('click', () => {
                    const rows = Array.from(tbody.querySelectorAll('tr'));

                    // Jangan lakukan sorting jika tabel kosong (terdapat colspan peringatan)
                    if (rows.length === 1 && rows[0].cells.length === 1) return;

                    // Tentukan arah urutan (Ascending / Descending)
                    const direction = directions[index] === 'asc' ? 'desc' : 'asc';
                    directions[index] = direction;

                    // Proses pengurutan baris
                    rows.sort((rowA, rowB) => {
                        const cellA = rowA.cells[index].innerText.trim().toLowerCase();
                        const cellB = rowB.cells[index].innerText.trim().toLowerCase();

                        // Fungsi untuk mengambil angka dari string (berguna untuk ID dan Jumlah)
                        const numA = parseFloat(cellA.replace(/[^0-9.-]+/g, ''));
                        const numB = parseFloat(cellB.replace(/[^0-9.-]+/g, ''));

                        // Logika: Jika isi sel mengandung angka (dan bukan murni teks/abjad)
                        if (!isNaN(numA) && !isNaN(numB) && cellA.match(/[0-9]/)) {
                            return direction === 'asc' ? numA - numB : numB - numA;
                        }

                        // Logika: Urutkan murni sebagai teks string alfabet
                        if (cellA < cellB) return direction === 'asc' ? -1 : 1;
                        if (cellA > cellB) return direction === 'asc' ? 1 : -1;
                        return 0;
                    });

                    // Hapus isi <tbody> lama dan masukkan baris yang sudah diurutkan
                    tbody.innerHTML = '';
                    rows.forEach(row => tbody.appendChild(row));
                });
            });
        });
    </script>
</body>

</html>
