<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk ke Perpustakaan Internal Kantor</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@600;700;800&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --navy: #0F2A47;
            --navy-deep: #081B30;
            --navy-2: #173C63;
            --green: #1FA971;
            --sky: #2E9CD1;
            --orange: #F2801E;
            --orange-dark: #D96A0E;
            --ink: #13233B;
            --muted: #6C7A8C;
            --bg-soft: #F4F7FA;
            --radius-lg: 22px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', system-ui, sans-serif;
            color: var(--ink);
            background: var(--bg-soft);
            min-height: 100vh;
        }

        .lp-shell {
            min-height: 100vh;
        }

        /* ===== BRAND PANEL ===== */
        .lp-brand {
            background: radial-gradient(1200px 600px at -10% -10%, var(--navy-2) 0%, var(--navy) 45%, var(--navy-deep) 100%);
            position: relative;
            overflow: hidden;
            padding: 3.5rem 3.25rem;
            color: #fff;
        }

        .lp-brand::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(255, 255, 255, .08) 1.4px, transparent 1.4px);
            background-size: 22px 22px;
            opacity: .5;
            pointer-events: none;
        }

        .lp-seal {
            position: absolute;
            width: 230px;
            height: 230px;
            border: 1.5px dashed rgba(46, 156, 209, .35);
            border-radius: 50%;
            right: -70px;
            bottom: -70px;
            pointer-events: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .lp-seal::after {
            content: "";
            position: absolute;
            inset: 18px;
            border: 1.5px solid rgba(255, 255, 255, .08);
            border-radius: 50%;
        }

        .lp-seal i {
            font-size: 2.1rem;
            color: rgba(255, 255, 255, .08);
        }

        .lp-logo-badge {
            width: 34px;
            height: 34px;
            border-radius: 9px;
            background: rgba(255, 255, 255, .1);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .lp-logo-text {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            letter-spacing: .02em;
        }

        .lp-eyebrow {
            font-family: 'Poppins', sans-serif;
            letter-spacing: .14em;
            font-size: .72rem;
            font-weight: 600;
            color: #7FC8EA;
            text-transform: uppercase;
        }

        .lp-headline {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: clamp(1.65rem, 2.4vw + 1rem, 2.35rem);
            line-height: 1.2;
            max-width: 480px;
        }

        .lp-sub {
            color: rgba(255, 255, 255, .78);
            max-width: 440px;
            font-size: .98rem;
        }

        /* signature accent bar — status koleksi buku */
        .lp-bar {
            height: 6px;
            border-radius: 6px;
            overflow: hidden;
            display: flex;
            width: 220px;
            background: rgba(255, 255, 255, .12);
        }

        .lp-bar span {
            display: block;
            height: 100%;
            transform-origin: left;
            animation: lp-grow .9s ease forwards;
        }

        .lp-bar .seg-1 {
            width: 45%;
            background: var(--green);
            animation-delay: .15s;
        }

        .lp-bar .seg-2 {
            width: 35%;
            background: var(--sky);
            animation-delay: .32s;
        }

        .lp-bar .seg-3 {
            width: 20%;
            background: var(--orange);
            animation-delay: .5s;
        }

        @keyframes lp-grow {
            from {
                transform: scaleX(0);
            }

            to {
                transform: scaleX(1);
            }
        }

        .lp-legend {
            font-size: .74rem;
            color: rgba(255, 255, 255, .55);
            gap: 1rem;
        }

        .lp-legend .dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            display: inline-block;
            margin-right: .4rem;
        }

        .lp-pillar {
            gap: .85rem;
        }

        .lp-pillar-icon {
            width: 38px;
            height: 38px;
            border-radius: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            flex: none;
        }

        .lp-pillar-title {
            font-weight: 600;
            font-size: .94rem;
            color: #fff;
        }

        .lp-pillar-desc {
            font-size: .82rem;
            color: rgba(255, 255, 255, .68);
        }

        .lp-foot {
            font-size: .78rem;
            color: rgba(255, 255, 255, .45);
        }

        /* ===== FORM PANEL ===== */
        .lp-form-wrap {
            padding: 2.5rem 1.25rem;
        }

        .lp-card {
            width: 100%;
            max-width: 400px;
            background: #fff;
            border-radius: var(--radius-lg);
            padding: 2.4rem 2.1rem;
            box-shadow: 0 30px 60px -20px rgba(15, 42, 71, .18), 0 2px 8px rgba(15, 42, 71, .05);
            animation: lp-rise .55s ease both;
        }

        @keyframes lp-rise {
            from {
                opacity: 0;
                transform: translateY(14px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .lp-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 1.4rem;
            color: var(--navy);
        }

        .lp-title-sub {
            color: var(--muted);
            font-size: .86rem;
            min-height: 2.4em;
        }

        /* Role segmented toggle */
        .lp-role-toggle {
            position: relative;
            display: flex;
            background: #EEF2F6;
            border-radius: 999px;
            padding: 4px;
            margin-bottom: 1.6rem;
        }

        .lp-role-btn {
            position: relative;
            z-index: 2;
            flex: 1;
            border: none;
            background: transparent;
            padding: .55rem .5rem;
            font-size: .84rem;
            font-weight: 600;
            color: var(--muted);
            border-radius: 999px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .35rem;
            transition: color .25s ease;
            cursor: pointer;
        }

        .lp-role-btn.active[data-role="anggota"] {
            color: var(--sky);
        }

        .lp-role-btn.active[data-role="admin"] {
            color: var(--navy);
        }

        .lp-role-indicator {
            position: absolute;
            top: 4px;
            left: 4px;
            width: calc(50% - 4px);
            height: calc(100% - 8px);
            background: #fff;
            border-radius: 999px;
            box-shadow: 0 2px 6px rgba(15, 42, 71, .12);
            transition: transform .25s ease;
            z-index: 1;
        }

        .lp-field {
            position: relative;
        }

        .form-floating>.form-control.lp-input {
            border-radius: 12px;
            border: 1.5px solid #E4E9EF;
            padding-left: 2.9rem;
            height: calc(3.3rem + 2px);
        }

        .form-floating>label.lp-label {
            padding-left: 2.9rem;
            color: var(--muted);
        }

        .form-floating>.form-control.lp-input:focus {
            border-color: var(--sky);
            box-shadow: 0 0 0 .2rem rgba(46, 156, 209, .18);
        }

        .lp-field-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
            font-size: 1rem;
            z-index: 5;
        }

        .lp-toggle-eye {
            position: absolute;
            right: .6rem;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: none;
            color: var(--muted);
            font-size: 1.05rem;
            padding: .4rem;
            z-index: 5;
            line-height: 1;
        }

        .lp-toggle-eye:hover {
            color: var(--navy);
        }

        .lp-check .form-check-input {
            accent-color: var(--green);
            cursor: pointer;
        }

        .lp-check-label {
            font-size: .86rem;
            color: var(--muted);
        }

        .lp-forgot {
            color: var(--sky);
            font-size: .86rem;
            font-weight: 500;
            text-decoration: none;
        }

        .lp-forgot:hover {
            color: var(--navy);
            text-decoration: underline;
        }

        .lp-btn {
            background: var(--orange);
            border: none;
            color: #fff;
            font-weight: 600;
            border-radius: 12px;
            padding: .75rem 1rem;
            letter-spacing: .01em;
            transition: transform .15s ease, background .15s ease, box-shadow .15s ease;
            box-shadow: 0 10px 20px -8px rgba(242, 128, 30, .55);
        }

        .lp-btn:hover {
            background: var(--orange-dark);
            transform: translateY(-1px);
            color: #fff;
        }

        .lp-btn:focus {
            box-shadow: 0 0 0 .2rem rgba(242, 128, 30, .3);
        }

        .lp-tip {
            background: #FFF4EA;
            border-left: 3px solid var(--orange);
            border-radius: 8px;
            padding: .6rem .8rem;
            font-size: .78rem;
            color: #8A5A22;
        }

        .lp-tip i {
            color: var(--orange-dark);
        }

        .lp-signup {
            font-size: .86rem;
            color: var(--muted);
        }

        .lp-signup a {
            color: var(--navy);
            font-weight: 600;
            text-decoration: none;
        }

        .lp-signup a:hover {
            text-decoration: underline;
        }

        @media (max-width:991.98px) {
            .lp-brand {
                padding: 2.5rem 1.75rem;
            }

            .lp-pillars {
                display: none;
            }

            .lp-seal {
                display: none;
            }
        }

        @media (prefers-reduced-motion:reduce) {
            .lp-bar span {
                animation: none !important;
                transform: scaleX(1) !important;
            }

            .lp-card {
                animation: none !important;
                opacity: 1;
                transform: none;
            }

            .lp-btn:hover {
                transform: none;
            }

            .lp-role-indicator {
                transition: none !important;
            }
        }
    </style>
</head>

<body>

    <div class="lp-shell d-flex flex-column flex-lg-row">

        <!-- BRAND PANEL -->
        <div class="lp-brand col-lg-6 d-flex flex-column justify-content-between">
            <div class="lp-seal"><i class="bi bi-book"></i></div>

            <div style="position:relative; z-index:2;">
                <div class="d-flex align-items-center gap-2 mb-4">
                    <div class="lp-logo-badge"><i class="bi bi-journal-bookmark-fill" style="color:#7FC8EA;"></i></div>
                    <span class="lp-logo-text">Pustaka Internal</span>
                </div>

                <div class="lp-eyebrow mb-2">Perpustakaan Internal Kantor</div>
                <h1 class="lp-headline mb-3">Satu Portal untuk Menjelajah Koleksi Pustaka Kantor</h1>
                <p class="lp-sub mb-4">Cari judul, pinjam buku, dan pantau riwayat baca Anda dalam satu sistem
                    perpustakaan internal yang terhubung.</p>

                <div class="lp-bar mb-2">
                    <span class="seg-1"></span><span class="seg-2"></span><span class="seg-3"></span>
                </div>
                <div class="d-flex lp-legend mb-5">
                    <span><i class="dot" style="background:var(--green);"></i>Tersedia</span>
                    <span><i class="dot" style="background:var(--sky);"></i>Dipinjam</span>
                    <span><i class="dot" style="background:var(--orange);"></i>Segera Kembali</span>
                </div>

                <div class="lp-pillars d-flex flex-column gap-3">
                    <div class="d-flex lp-pillar">
                        <div class="lp-pillar-icon" style="background:rgba(31,169,113,.16); color:var(--green);"><i
                                class="bi bi-journal-check"></i></div>
                        <div>
                            <div class="lp-pillar-title">Katalog Real-time</div>
                            <div class="lp-pillar-desc">Status ketersediaan buku selalu diperbarui.</div>
                        </div>
                    </div>
                    <div class="d-flex lp-pillar">
                        <div class="lp-pillar-icon" style="background:rgba(46,156,209,.16); color:var(--sky);"><i
                                class="bi bi-clock-history"></i></div>
                        <div>
                            <div class="lp-pillar-title">Riwayat Peminjaman</div>
                            <div class="lp-pillar-desc">Pantau buku yang sedang dan pernah Anda pinjam.</div>
                        </div>
                    </div>
                    <div class="d-flex lp-pillar">
                        <div class="lp-pillar-icon" style="background:rgba(242,128,30,.16); color:var(--orange);"><i
                                class="bi bi-bell-fill"></i></div>
                        <div>
                            <div class="lp-pillar-title">Pengingat Jatuh Tempo</div>
                            <div class="lp-pillar-desc">Notifikasi sebelum tenggat pengembalian buku.</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lp-foot" style="position:relative; z-index:2;">&copy; 2026 Perpustakaan Internal Kantor.</div>
        </div>

        <!-- FORM PANEL -->
        <div class="col-lg-6 d-flex align-items-center justify-content-center lp-form-wrap">
            <div class="lp-card">
                <div class="mb-3">
                    <div class="lp-title" id="lpCardTitle">Masuk sebagai Anggota</div>
                    <div class="lp-title-sub" id="lpCardSub">Gunakan ID anggota untuk meminjam dan mencari koleksi.
                    </div>
                </div>

                <!-- Notifikasi Error Global (Jika ada) -->
                @if (session('error'))
                    <div class="alert alert-danger py-2 px-3" style="font-size: 0.85rem;">
                        <i class="bi bi-exclamation-triangle-fill me-1"></i> {{ session('error') }}
                    </div>
                @endif

                <div class="lp-role-toggle" role="tablist" aria-label="Pilih jenis akun">
                    <button type="button" class="lp-role-btn active" data-role="anggota" role="tab"
                        aria-selected="true">
                        <i class="bi bi-person-fill"></i> Anggota
                    </button>
                    <button type="button" class="lp-role-btn" data-role="admin" role="tab" aria-selected="false">
                        <i class="bi bi-shield-lock-fill"></i> Admin
                    </button>
                    <span class="lp-role-indicator" id="roleIndicator"></span>
                </div>

                <!-- Form Login Dinamis -->
                <form id="loginForm" action="{{ route('login.karyawan') }}" method="POST">
                    @csrf <!-- Token CSRF wajib -->

                    <!-- Input ID / Email -->
                    <!-- Input ID / Username Admin -->
                    <div class="form-floating lp-field mb-3">
                        <i class="bi bi-person lp-field-icon" id="lpIdIcon"></i>

                        <input type="text" name="idkaryawan"
                            class="form-control lp-input @error('idkaryawan') is-invalid @enderror @error('login') is-invalid @enderror"
                            id="lpIdInput" placeholder="ID Anggota" value="{{ old('idkaryawan') ?? old('login') }}"
                            required>
                        <label for="lpIdInput" class="lp-label" id="lpIdLabel">ID Anggota</label>

                        @error('idkaryawan')
                            <div class="invalid-feedback d-block" style="margin-left: 2.5rem;">{{ $message }}</div>
                        @enderror
                        @error('login')
                            <div class="invalid-feedback d-block" style="margin-left: 2.5rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Input Password -->
                    <div class="form-floating lp-field mb-4">
                        <i class="bi bi-lock lp-field-icon"></i>
                        <input type="password" name="password"
                            class="form-control lp-input @error('password') is-invalid @enderror" id="lpPassword"
                            placeholder="Kata Sandi" required>
                        <label for="lpPassword" class="lp-label">Kata Sandi</label>
                        <button type="button" class="lp-toggle-eye" id="lpToggleEye"
                            aria-label="Tampilkan kata sandi">
                            <i class="bi bi-eye" id="lpEyeIcon"></i>
                        </button>

                        @error('password')
                            <div class="invalid-feedback" style="margin-left: 2.5rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn lp-btn w-100 mb-3" id="lpSubmitBtn">Masuk sebagai
                        Anggota</button>

                    <div class="lp-tip d-flex align-items-start gap-2 mb-4">
                        <i class="bi bi-exclamation-triangle-fill mt-1"></i>
                        <span id="lpTipText">Jangan pernah membagikan kata sandi akun Anda kepada siapa pun.</span>
                    </div>

                    <div class="text-center lp-signup" id="lpSignupRow">
                        Belum memiliki akun? <a href="https://wa.me/6285606310731">Hubungi admin</a>
                    </div>
                </form>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            const toggleBtn = document.getElementById('lpToggleEye');
            const pwdInput = document.getElementById('lpPassword');
            const eyeIcon = document.getElementById('lpEyeIcon');

            toggleBtn.addEventListener('click', () => {
                const isPassword = pwdInput.type === 'password';
                pwdInput.type = isPassword ? 'text' : 'password';
                eyeIcon.classList.toggle('bi-eye');
                eyeIcon.classList.toggle('bi-eye-slash');
                toggleBtn.setAttribute('aria-label', isPassword ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi');
            });

            // document.querySelector('form').addEventListener('submit', (e) => {
            //     e.preventDefault();
            // });

            /* ===== Role toggle: Anggota / Admin ===== */
            const roleButtons = document.querySelectorAll('.lp-role-btn');
            const indicator = document.getElementById('roleIndicator');
            const cardTitle = document.getElementById('lpCardTitle');
            const cardSub = document.getElementById('lpCardSub');
            const idIcon = document.getElementById('lpIdIcon');
            const idLabel = document.getElementById('lpIdLabel');
            const idInput = document.getElementById('lpIdInput');
            const submitBtn = document.getElementById('lpSubmitBtn');
            const tipText = document.getElementById('lpTipText');
            const signupRow = document.getElementById('lpSignupRow');
            const loginForm = document.getElementById('loginForm');

            const roleConfig = {
                anggota: {
                    title: 'Masuk sebagai Anggota',
                    sub: 'Gunakan ID anggota untuk meminjam dan mencari koleksi.',
                    icon: 'bi-person',
                    label: 'ID Anggota',
                    placeholder: 'ID Anggota',
                    button: 'Masuk sebagai Anggota',
                    tip: 'Jangan pernah membagikan kata sandi akun Anda kepada siapa pun.',
                    signup: true,
                    action: "{{ route('login.karyawan') }}",
                    inputName: "idkaryawan"
                },
                admin: {
                    title: 'Masuk sebagai Admin',
                    sub: 'Khusus untuk staf pengelola perpustakaan internal kantor.',
                    icon: 'bi-shield-lock',
                    label: 'Username Admin',
                    placeholder: 'Username Admin',
                    button: 'Masuk Dashboard Admin',
                    tip: 'Akses ini memiliki kewenangan mengelola data koleksi. Pastikan perangkat aman.',
                    signup: false,
                    action: "{{ route('login.admin') }}",
                    inputName: "login" // <--- INI DIPERBAIKI (sebelumnya "email")
                }
            };

            function setRole(role) {
                const cfg = roleConfig[role];

                // Update UI
                roleButtons.forEach(btn => {
                    const active = btn.dataset.role === role;
                    btn.classList.toggle('active', active);
                    btn.setAttribute('aria-selected', active ? 'true' : 'false');
                });

                indicator.style.transform = role === 'admin' ? 'translateX(100%)' : 'translateX(0)';
                cardTitle.textContent = cfg.title;
                cardSub.textContent = cfg.sub;
                idIcon.className = 'bi ' + cfg.icon + ' lp-field-icon';
                idLabel.textContent = cfg.label;
                idInput.placeholder = cfg.placeholder;
                idInput.name = cfg.inputName;
                submitBtn.textContent = cfg.button;
                tipText.textContent = cfg.tip;
                signupRow.style.display = cfg.signup ? '' : 'none';

                // Update Form Action
                loginForm.action = cfg.action;
            }

            roleButtons.forEach(btn => {
                btn.addEventListener('click', () => setRole(btn.dataset.role));
            });

            // ===== LOGIKA DEFAULT TAB =====
            // Jika sebelumnya user mencoba login sebagai admin (dan gagal), 
            // kembalikan layar ke form Admin, bukan Anggota.
            @if (old('login') || $errors->has('login'))
                setRole('admin');
            @else
                setRole('anggota');
            @endif
        </script>
</body>

</html>
