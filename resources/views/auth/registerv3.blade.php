<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar — xPOS Dstech Smart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('api/select2/select2.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --brand:       #4F46E5;
            --brand-dark:  #3730A3;
            --brand-light: #EEF2FF;
            --accent:      #7C3AED;
            --success:     #10B981;
            --danger:      #EF4444;
            --text-main:   #111827;
            --text-sub:    #6B7280;
            --border:      #E5E7EB;
            --radius:      14px;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: #F3F4F6;
            min-height: 100vh;
            margin: 0;
        }

        /* ── LAYOUT ────────────────────────────── */
        .reg-wrap {
            display: flex;
            min-height: 100vh;
        }

        /* ── LEFT PANEL ────────────────────────── */
        .left-panel {
            width: 420px;
            min-width: 420px;
            background: linear-gradient(155deg, #4F46E5 0%, #7C3AED 60%, #6D28D9 100%);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 48px 40px;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow: hidden;
        }

        .left-panel .blob {
            position: absolute;
            border-radius: 50%;
            background: rgba(255,255,255,0.07);
            filter: blur(60px);
        }
        .left-panel .blob-1 { width: 320px; height: 320px; top: -80px; left: -80px; }
        .left-panel .blob-2 { width: 280px; height: 280px; bottom: 40px; right: -60px; }

        .left-panel .brand-logo {
            position: relative;
            z-index: 1;
        }
        .left-panel .brand-logo img { height: 44px; }

        .left-panel .hero-text {
            position: relative;
            z-index: 1;
        }
        .left-panel .hero-text h2 {
            color: #fff;
            font-size: 2rem;
            font-weight: 800;
            line-height: 1.25;
            margin-bottom: 16px;
        }
        .left-panel .hero-text p {
            color: rgba(255,255,255,0.75);
            font-size: 0.95rem;
            line-height: 1.7;
        }

        .left-panel .feature-list {
            position: relative;
            z-index: 1;
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .left-panel .feature-list li {
            display: flex;
            align-items: center;
            gap: 12px;
            color: rgba(255,255,255,0.9);
            font-size: 0.9rem;
            margin-bottom: 14px;
        }
        .left-panel .feature-list li .icon-wrap {
            width: 32px; height: 32px;
            background: rgba(255,255,255,0.18);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .left-panel .feature-list li .icon-wrap i { color: #fff; font-size: 0.9rem; }

        .left-panel .login-cta {
            position: relative;
            z-index: 1;
            color: rgba(255,255,255,0.7);
            font-size: 0.875rem;
        }
        .left-panel .login-cta a {
            color: #fff;
            font-weight: 600;
            text-decoration: none;
        }
        .left-panel .login-cta a:hover { text-decoration: underline; }

        /* ── RIGHT PANEL ───────────────────────── */
        .right-panel {
            flex: 1;
            overflow-y: auto;
            padding: 48px 56px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .form-shell {
            width: 100%;
            max-width: 640px;
        }

        /* ── STEP INDICATOR ────────────────────── */
        .step-indicator {
            display: flex;
            align-items: center;
            margin-bottom: 40px;
        }
        .step-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1;
            position: relative;
        }
        .step-item:not(:last-child)::after {
            content: '';
            position: absolute;
            top: 18px;
            left: calc(50% + 18px);
            right: calc(-50% + 18px);
            height: 2px;
            background: var(--border);
            transition: background .4s;
        }
        .step-item.done:not(:last-child)::after,
        .step-item.active:not(:last-child)::after {
            background: var(--brand);
        }

        .step-circle {
            width: 36px; height: 36px;
            border-radius: 50%;
            border: 2px solid var(--border);
            background: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--text-sub);
            transition: all .3s;
            z-index: 1;
        }
        .step-item.active .step-circle {
            border-color: var(--brand);
            background: var(--brand);
            color: #fff;
            box-shadow: 0 0 0 5px rgba(79,70,229,.15);
        }
        .step-item.done .step-circle {
            border-color: var(--success);
            background: var(--success);
            color: #fff;
        }
        .step-label {
            font-size: 0.72rem;
            font-weight: 600;
            color: var(--text-sub);
            margin-top: 6px;
            text-align: center;
            white-space: nowrap;
        }
        .step-item.active .step-label { color: var(--brand); }
        .step-item.done  .step-label { color: var(--success); }

        /* ── SECTION TITLE ─────────────────────── */
        .section-title {
            margin-bottom: 28px;
        }
        .section-title h3 {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 4px;
        }
        .section-title p {
            font-size: 0.875rem;
            color: var(--text-sub);
        }

        /* ── FORM CONTROLS ─────────────────────── */
        .field-group { margin-bottom: 20px; }

        .field-group label {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-main);
            margin-bottom: 6px;
            display: block;
        }
        .field-group label span.req { color: var(--danger); }

        .form-input {
            width: 100%;
            height: 48px;
            padding: 0 16px;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-size: 0.9rem;
            color: var(--text-main);
            background: #fff;
            transition: border-color .2s, box-shadow .2s;
            outline: none;
            font-family: 'Inter', sans-serif;
        }
        .form-input:focus {
            border-color: var(--brand);
            box-shadow: 0 0 0 4px rgba(79,70,229,.12);
        }
        .form-input::placeholder { color: #9CA3AF; }

        textarea.form-input {
            height: auto;
            padding: 12px 16px;
            resize: vertical;
        }

        /* Select2 override */
        .select2-container .select2-selection--single {
            height: 48px !important;
            border: 1.5px solid var(--border) !important;
            border-radius: 10px !important;
            display: flex; align-items: center;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 48px !important;
            padding-left: 16px !important;
            color: var(--text-main) !important;
            font-size: 0.9rem !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 48px !important;
        }
        .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: var(--brand) !important;
            box-shadow: 0 0 0 4px rgba(79,70,229,.12) !important;
            outline: none !important;
        }
        .select2-dropdown { border-radius: 10px !important; border: 1.5px solid var(--border) !important; }

        /* Input icon wrapper */
        .input-icon-wrap { position: relative; }
        .input-icon-wrap .form-input { padding-left: 44px; }
        .input-icon-wrap .input-icon {
            position: absolute;
            left: 14px; top: 50%;
            transform: translateY(-50%);
            color: #9CA3AF;
            font-size: 1rem;
        }

        /* Password toggle */
        .input-icon-wrap .pw-toggle {
            position: absolute;
            right: 14px; top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #9CA3AF;
            font-size: 1rem;
            user-select: none;
        }
        .input-icon-wrap .pw-toggle:hover { color: var(--brand); }
        .input-icon-wrap .form-input.has-pw-toggle { padding-right: 44px; }

        /* ── PRODUCT CARDS ─────────────────────── */
        .product-scroll {
            display: flex;
            gap: 16px;
            overflow-x: auto;
            padding: 4px 2px 16px;
            scroll-behavior: smooth;
        }
        .product-scroll::-webkit-scrollbar { height: 6px; }
        .product-scroll::-webkit-scrollbar-track { background: #F3F4F6; border-radius: 10px; }
        .product-scroll::-webkit-scrollbar-thumb { background: #D1D5DB; border-radius: 10px; }

        .pkg-card {
            flex: 0 0 190px;
            border: 2px solid var(--border);
            border-radius: var(--radius);
            padding: 20px 16px;
            cursor: pointer;
            transition: all .25s;
            background: #fff;
            text-align: center;
        }
        .pkg-card:hover { border-color: var(--brand); transform: translateY(-3px); box-shadow: 0 8px 24px rgba(79,70,229,.1); }
        .pkg-card.selected {
            border-color: var(--brand);
            background: var(--brand-light);
            box-shadow: 0 8px 24px rgba(79,70,229,.15);
        }
        .pkg-card .pkg-icon {
            width: 48px; height: 48px;
            border-radius: 12px;
            background: var(--brand-light);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 12px;
        }
        .pkg-card .pkg-icon i { font-size: 1.4rem; color: var(--brand); }
        .pkg-card.selected .pkg-icon { background: rgba(79,70,229,.2); }
        .pkg-card h6 { font-size: 0.9rem; font-weight: 700; color: var(--text-main); margin-bottom: 4px; }
        .pkg-card .pkg-desc { font-size: 0.75rem; color: var(--text-sub); min-height: 36px; margin-bottom: 10px; }
        .pkg-card .pkg-price { font-size: 1.1rem; font-weight: 800; color: var(--brand); }
        .pkg-card .pkg-price-original { font-size: 0.8rem; color: var(--text-sub); text-decoration: line-through; }
        .pkg-card .pkg-price-disc { font-size: 1.1rem; font-weight: 800; color: var(--success); }
        .pkg-card .pkg-badge {
            display: inline-block;
            background: var(--brand);
            color: #fff;
            font-size: 0.65rem;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 20px;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: .5px;
        }
        .no-package-msg {
            color: var(--text-sub);
            font-size: 0.875rem;
            padding: 24px 0;
            text-align: center;
            width: 100%;
        }

        /* ── VOUCHER BOX ───────────────────────── */
        .voucher-box {
            border: 1.5px dashed var(--border);
            border-radius: var(--radius);
            padding: 18px;
            background: #FAFAFA;
            margin-bottom: 20px;
        }
        .voucher-box .voucher-row {
            display: flex;
            gap: 10px;
        }
        .voucher-box .form-input { flex: 1; }
        .btn-apply {
            height: 48px;
            padding: 0 20px;
            border-radius: 10px;
            background: var(--brand);
            color: #fff;
            border: none;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            transition: background .2s;
            white-space: nowrap;
        }
        .btn-apply:hover { background: var(--brand-dark); }
        .btn-apply:disabled { background: #9CA3AF; cursor: not-allowed; }
        .voucher-feedback {
            margin-top: 10px;
            font-size: 0.8rem;
            display: none;
        }
        .voucher-feedback.success { color: var(--success); display: block; }
        .voucher-feedback.error   { color: var(--danger);  display: block; }

        /* ── PRICE SUMMARY ─────────────────────── */
        .price-summary {
            background: var(--brand-light);
            border: 1.5px solid rgba(79,70,229,.2);
            border-radius: var(--radius);
            padding: 16px 20px;
            margin-bottom: 24px;
            display: none;
        }
        .price-summary .ps-row {
            display: flex;
            justify-content: space-between;
            font-size: 0.875rem;
            margin-bottom: 6px;
            color: var(--text-sub);
        }
        .price-summary .ps-row.total {
            font-size: 1rem;
            font-weight: 800;
            color: var(--text-main);
            border-top: 1.5px solid rgba(79,70,229,.2);
            padding-top: 10px;
            margin-top: 4px;
            margin-bottom: 0;
        }
        .price-summary .ps-row .disc { color: var(--success); font-weight: 600; }

        /* ── BUTTONS ───────────────────────────── */
        .btn-nav {
            height: 50px;
            border-radius: 12px;
            font-size: 0.9rem;
            font-weight: 700;
            padding: 0 28px;
            cursor: pointer;
            border: none;
            transition: all .2s;
            display: flex; align-items: center; gap: 8px;
        }
        .btn-next {
            background: var(--brand);
            color: #fff;
        }
        .btn-next:hover { background: var(--brand-dark); transform: translateY(-1px); box-shadow: 0 6px 20px rgba(79,70,229,.3); }
        .btn-back {
            background: transparent;
            color: var(--text-sub);
            border: 1.5px solid var(--border) !important;
        }
        .btn-back:hover { border-color: var(--brand) !important; color: var(--brand); }
        .btn-submit {
            background: linear-gradient(135deg, var(--brand), var(--accent));
            color: #fff;
        }
        .btn-submit:hover { opacity: .9; transform: translateY(-1px); box-shadow: 0 8px 24px rgba(79,70,229,.35); }
        .btn-submit:disabled { opacity: .6; cursor: not-allowed; transform: none; box-shadow: none; }

        /* ── T&C CHECKBOX ──────────────────────── */
        .tnc-check {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 24px;
        }
        .tnc-check input[type=checkbox] {
            width: 18px; height: 18px;
            accent-color: var(--brand);
            margin-top: 2px;
            flex-shrink: 0;
            cursor: pointer;
        }
        .tnc-check label {
            font-size: 0.85rem;
            color: var(--text-sub);
            cursor: pointer;
            line-height: 1.5;
        }
        .tnc-check label a { color: var(--brand); font-weight: 600; text-decoration: none; }
        .tnc-check label a:hover { text-decoration: underline; }

        /* ── VALIDATION HELPERS ────────────────── */
        .field-error { font-size: 0.75rem; color: var(--danger); margin-top: 4px; display: none; }
        .form-input.is-invalid, .select2-container.is-invalid .select2-selection--single {
            border-color: var(--danger) !important;
        }

        /* ── RESPONSIVE ────────────────────────── */
        @media (max-width: 900px) {
            .left-panel { display: none; }
            .right-panel { padding: 32px 24px; }
        }
        @media (max-width: 480px) {
            .right-panel { padding: 24px 16px; }
            .step-label { display: none; }
        }

        /* ── STEP PAGES ────────────────────────── */
        .step-page { display: none; }
        .step-page.active { display: block; }

        /* ── DIVIDER ───────────────────────────── */
        .field-divider {
            border: none;
            border-top: 1.5px solid var(--border);
            margin: 28px 0;
        }
    </style>
</head>
<body>

<div class="reg-wrap">

    {{-- ───── LEFT PANEL ───── --}}
    <div class="left-panel">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>

        <div class="brand-logo">
            <img src="{{ asset('images/misc/LogoFront.png') }}" alt="xPOS Logo">
        </div>

        <div class="hero-text">
            <h2>Mulai Perjalanan Bisnis Anda</h2>
            <p>Kelola penjualan, stok, dan laporan keuangan dalam satu platform yang mudah digunakan.</p>
        </div>

        <ul class="feature-list">
            <li>
                <span class="icon-wrap"><i class="bi bi-lightning-charge-fill"></i></span>
                Kasir Digital Super Cepat
            </li>
            <li>
                <span class="icon-wrap"><i class="bi bi-bar-chart-fill"></i></span>
                Laporan Real-time & Akutansi
            </li>
            <li>
                <span class="icon-wrap"><i class="bi bi-box-seam-fill"></i></span>
                Manajemen Stok Otomatis
            </li>
            <li>
                <span class="icon-wrap"><i class="bi bi-qr-code"></i></span>
                Pembayaran QRIS & Multi-metode
            </li>
            <li>
                <span class="icon-wrap"><i class="bi bi-headset"></i></span>
                Dukungan Teknis 24/7
            </li>
        </ul>

        <div class="login-cta">
            Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
        </div>
    </div>

    {{-- ───── RIGHT PANEL ───── --}}
    <div class="right-panel">
        <div class="form-shell">

            {{-- Step Indicator --}}
            <div class="step-indicator" id="stepIndicator">
                <div class="step-item active" data-step="1">
                    <div class="step-circle"><i class="bi bi-check-lg done-icon" style="display:none"></i><span class="step-num">1</span></div>
                    <span class="step-label">Informasi Bisnis</span>
                </div>
                <div class="step-item" data-step="2">
                    <div class="step-circle"><i class="bi bi-check-lg done-icon" style="display:none"></i><span class="step-num">2</span></div>
                    <span class="step-label">Lokasi Usaha</span>
                </div>
                <div class="step-item" data-step="3">
                    <div class="step-circle"><i class="bi bi-check-lg done-icon" style="display:none"></i><span class="step-num">3</span></div>
                    <span class="step-label">Paket & Akun</span>
                </div>
            </div>

            <form method="POST" action="{{ route('action-daftar') }}" id="DaftarLangganan">
                @csrf

                {{-- ═══ STEP 1 — Informasi Bisnis ═══ --}}
                <div class="step-page active" id="step1">
                    <div class="section-title">
                        <h3>Informasi Bisnis</h3>
                        <p>Isi data perusahaan dan penanggung jawab Anda.</p>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="field-group">
                                <label>Nama Perusahaan <span class="req">*</span></label>
                                <div class="input-icon-wrap">
                                    <i class="bi bi-building input-icon"></i>
                                    <input type="text" name="NamaPartner" id="NamaPartner" class="form-input"
                                           placeholder="PT. Contoh Bisnis" required>
                                </div>
                                <div class="field-error" id="err-NamaPartner">Nama perusahaan wajib diisi.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="field-group">
                                <label>Jenis Usaha <span class="req">*</span></label>
                                <select name="JenisUsaha" id="JenisUsaha" class="reg-select" required>
                                    <option value="" disabled selected>Pilih Jenis Usaha</option>
                                    <option value="Retail">Retail</option>
                                    <option value="FnB">Food and Beverage</option>
                                    <option value="Hiburan">Hiburan</option>
                                </select>
                                <div class="field-error" id="err-JenisUsaha">Jenis usaha wajib dipilih.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="field-group">
                                <label>Nama Penanggung Jawab <span class="req">*</span></label>
                                <div class="input-icon-wrap">
                                    <i class="bi bi-person input-icon"></i>
                                    <input type="text" name="NamaPIC" id="NamaPIC" class="form-input"
                                           placeholder="Nama lengkap PIC" required>
                                </div>
                                <div class="field-error" id="err-NamaPIC">Nama PIC wajib diisi.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="field-group">
                                <label>Nomor Ponsel <span class="req">*</span></label>
                                <div class="input-icon-wrap">
                                    <i class="bi bi-phone input-icon"></i>
                                    <input type="tel" name="NoHP" id="NoHP" class="form-input"
                                           placeholder="628xxxxxxxxxx" required>
                                </div>
                                <div class="field-error" id="err-NoHP">Nomor ponsel wajib diisi.</div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="field-group">
                                <label>Email <span class="req">*</span></label>
                                <div class="input-icon-wrap">
                                    <i class="bi bi-envelope input-icon"></i>
                                    <input type="email" name="email" id="email" class="form-input"
                                           placeholder="email@domain.com" required>
                                </div>
                                <div class="field-error" id="err-email">Email yang valid wajib diisi.</div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="button" class="btn-nav btn-next" id="btn12">
                            Selanjutnya <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </div>

                {{-- ═══ STEP 2 — Lokasi Usaha ═══ --}}
                <div class="step-page" id="step2">
                    <div class="section-title">
                        <h3>Lokasi Usaha</h3>
                        <p>Masukkan alamat tempat usaha Anda beroperasi.</p>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="field-group">
                                <label>Provinsi <span class="req">*</span></label>
                                <select name="ProvID" id="ProvID" class="reg-select" required>
                                    <option value="">Pilih Provinsi</option>
                                    @foreach($provinsi as $p)
                                        <option value="{{ $p->prov_id }}">{{ $p->prov_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="field-group">
                                <label>Kota <span class="req">*</span></label>
                                <select name="KotaID" id="KotaID" class="reg-select" required>
                                    <option value="">Pilih Kota</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="field-group">
                                <label>Kecamatan <span class="req">*</span></label>
                                <select name="KecID" id="KecID" class="reg-select" required>
                                    <option value="">Pilih Kecamatan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="field-group">
                                <label>Kelurahan <span class="req">*</span></label>
                                <select name="KelID" id="KelID" class="reg-select" required>
                                    <option value="">Pilih Kelurahan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="field-group">
                                <label>Alamat Lengkap <span class="req">*</span></label>
                                <textarea name="AlamatTagihan" id="AlamatTagihan" class="form-input"
                                          rows="3" placeholder="Jl. Contoh No. 1, RT/RW ..." required></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn-nav btn-back" id="btn21">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </button>
                        <button type="button" class="btn-nav btn-next" id="btn23">
                            Selanjutnya <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </div>

                {{-- ═══ STEP 3 — Paket & Akun ═══ --}}
                <div class="step-page" id="step3">
                    <div class="section-title">
                        <h3>Paket & Keamanan Akun</h3>
                        <p>Pilih paket berlangganan dan buat kata sandi Anda.</p>
                    </div>

                    {{-- Package selection --}}
                    <div class="field-group">
                        <label>Pilih Paket Berlangganan <span class="req">*</span></label>
                        <div class="product-scroll" id="productScroll">
                            <div class="no-package-msg">
                                <i class="bi bi-arrow-left-circle me-2"></i>
                                Pilih jenis usaha pada langkah pertama untuk melihat paket.
                            </div>
                        </div>
                        <div class="field-error" id="err-product" style="display:none">Paket berlangganan wajib dipilih.</div>
                    </div>

                    <hr class="field-divider">

                    {{-- Voucher --}}
                    <div class="field-group">
                        <label><i class="bi bi-ticket-perforated me-1" style="color:var(--brand)"></i>Kode Voucher</label>
                        <div class="voucher-box">
                            <div class="voucher-row">
                                <input type="text" id="voucherCode" class="form-input text-uppercase"
                                       placeholder="Masukkan kode voucher (opsional)"
                                       style="text-transform:uppercase">
                                <button type="button" class="btn-apply" id="btnApplyVoucher" disabled>
                                    <i class="bi bi-check2-circle me-1"></i>Gunakan
                                </button>
                            </div>
                            <div class="voucher-feedback" id="voucherFeedback"></div>
                        </div>
                    </div>

                    {{-- Price summary --}}
                    <div class="price-summary" id="priceSummary">
                        <div class="ps-row">
                            <span>Harga Paket</span>
                            <span id="psOriginal">Rp 0</span>
                        </div>
                        <div class="ps-row" id="psDiscRow" style="display:none">
                            <span>Diskon Voucher</span>
                            <span class="disc" id="psDiscount">- Rp 0</span>
                        </div>
                        <div class="ps-row total">
                            <span>Total Tagihan</span>
                            <span id="psTotal">Rp 0</span>
                        </div>
                    </div>

                    <hr class="field-divider">

                    {{-- Password --}}
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="field-group">
                                <label>Kata Sandi <span class="req">*</span></label>
                                <div class="input-icon-wrap">
                                    <i class="bi bi-lock input-icon"></i>
                                    <input type="password" name="password" id="password"
                                           class="form-input has-pw-toggle" placeholder="Min. 8 karakter" required>
                                    <span class="pw-toggle" data-target="password">
                                        <i class="bi bi-eye" id="pw-icon-password"></i>
                                    </span>
                                </div>
                                <div class="field-error" id="err-password">Kata sandi min. 8 karakter.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="field-group">
                                <label>Konfirmasi Kata Sandi <span class="req">*</span></label>
                                <div class="input-icon-wrap">
                                    <i class="bi bi-lock-fill input-icon"></i>
                                    <input type="password" name="ulangipassword" id="ulangipassword"
                                           class="form-input has-pw-toggle" placeholder="Ulangi kata sandi" required>
                                    <span class="pw-toggle" data-target="ulangipassword">
                                        <i class="bi bi-eye" id="pw-icon-ulangipassword"></i>
                                    </span>
                                </div>
                                <div class="field-error" id="err-ulangipassword">Kata sandi tidak cocok.</div>
                            </div>
                        </div>
                    </div>

                    {{-- T&C --}}
                    <div class="tnc-check">
                        <input type="checkbox" id="chkApprove">
                        <label for="chkApprove">
                            Saya telah membaca dan menyetujui
                            <a href="#" data-bs-toggle="modal" data-bs-target="#TnCModal">Syarat dan Ketentuan</a>
                            yang berlaku.
                        </label>
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn-nav btn-back" id="btn32">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </button>
                        <button type="submit" class="btn-nav btn-submit" id="btRegister" disabled>
                            <i class="bi bi-rocket-takeoff me-1"></i> Daftar Sekarang
                        </button>
                    </div>
                </div>

                {{-- Hidden fields --}}
                <input type="hidden" name="ProductSelected" id="ProductSelected">
                <input type="hidden" name="VoucherCode"     id="hdVoucherCode">
                <input type="hidden" name="DiscountAmount"  id="hdDiscountAmount" value="0">
                <input type="hidden" name="FinalPrice"      id="hdFinalPrice"     value="0">

            </form>
        </div>
    </div>
</div>

{{-- ═══ T&C Modal ═══ --}}
<div class="modal fade" id="TnCModal" tabindex="-1" aria-labelledby="TnCModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content" style="border-radius:var(--radius)">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="TnCModalLabel">Syarat dan Ketentuan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="font-size:.875rem;line-height:1.7;color:#374151">
                @if(isset($tnc) && $tnc)
                    {!! $tnc->Content ?? '' !!}
                @else
                    <p>Syarat dan ketentuan belum tersedia.</p>
                @endif
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-primary rounded-pill px-4"
                        data-bs-dismiss="modal">Saya Mengerti</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@include('sweetalert::alert')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('api/select2/select2.min.js') }}"></script>

<script>
$(function () {

    // ── Data from server ─────────────────────────────────
    var oKota       = {!! json_encode($kota) !!};
    var oProducts   = {!! json_encode($subscriptionheader) !!};

    var currentStep     = 1;
    var productSelected = '';
    var productPrice    = 0;
    var discountAmount  = 0;
    var voucherApplied  = false;

    // ── Select2 init ─────────────────────────────────────
    function initSelect2() {
        $('.reg-select').each(function () {
            if (!$(this).data('select2')) {
                $(this).select2({ width: '100%' });
            }
        });
    }
    initSelect2();

    // ── Step navigation ──────────────────────────────────
    function goToStep(next) {
        $('#step' + currentStep).removeClass('active');
        currentStep = next;
        $('#step' + currentStep).addClass('active');
        updateIndicator();
        $('.right-panel').scrollTop(0);
    }

    function updateIndicator() {
        $('#stepIndicator .step-item').each(function () {
            var s = parseInt($(this).data('step'));
            $(this).removeClass('active done');
            if (s < currentStep) {
                $(this).addClass('done');
                $(this).find('.done-icon').show();
                $(this).find('.step-num').hide();
            } else if (s === currentStep) {
                $(this).addClass('active');
                $(this).find('.done-icon').hide();
                $(this).find('.step-num').show();
            } else {
                $(this).find('.done-icon').hide();
                $(this).find('.step-num').show();
            }
        });
    }

    // ── Step 1 → 2 ──────────────────────────────────────
    $('#btn12').on('click', function () {
        var ok = true;
        ['NamaPartner','NamaPIC','NoHP','email'].forEach(function (id) {
            var el = $('#' + id);
            if (!el.val().trim()) {
                el.addClass('is-invalid');
                $('#err-' + id).show();
                ok = false;
            } else {
                el.removeClass('is-invalid');
                $('#err-' + id).hide();
            }
        });
        if ($('#JenisUsaha').val() === '' || !$('#JenisUsaha').val()) {
            $('#err-JenisUsaha').show();
            ok = false;
        } else {
            $('#err-JenisUsaha').hide();
        }
        if (!ok) return;
        goToStep(2);
    });

    // ── Step 2 → 1 ──────────────────────────────────────
    $('#btn21').on('click', function () { goToStep(1); });

    // ── Step 2 → 3 ──────────────────────────────────────
    $('#btn23').on('click', function () {
        var ok = true;
        ['ProvID','KotaID','KecID','KelID','AlamatTagihan'].forEach(function (id) {
            if (!$('#' + id).val() || !$('#' + id).val().trim()) { ok = false; }
        });
        if (!ok) {
            Swal.fire('Perhatian', 'Harap lengkapi semua data lokasi terlebih dahulu.', 'warning');
            return;
        }
        renderProducts($('#JenisUsaha').val());
        goToStep(3);
    });

    // ── Step 3 → 2 ──────────────────────────────────────
    $('#btn32').on('click', function () { goToStep(2); });

    // ── Province / City cascade ──────────────────────────
    $('#ProvID').on('change', function () {
        var pid = $(this).val();
        var filtered = oKota.filter(function (k) { return k.prov_id == pid; });
        var $kota = $('#KotaID');
        $kota.empty().append(new Option('Pilih Kota', ''));
        $.each(filtered, function (i, v) { $kota.append(new Option(v.city_name, v.city_id)); });
        $kota.trigger('change.select2');
        $('#KecID').empty().append(new Option('Pilih Kecamatan', '')).trigger('change.select2');
        $('#KelID').empty().append(new Option('Pilih Kelurahan', '')).trigger('change.select2');
    });

    $('#KotaID').on('change', function () {
        fetchDemografi('dem_kecamatan', 'kota_id', $(this).val(), '#KecID', 'Pilih Kecamatan', 'dis_id', 'dis_name');
        $('#KelID').empty().append(new Option('Pilih Kelurahan', '')).trigger('change.select2');
    });

    $('#KecID').on('change', function () {
        fetchDemografi('dem_kelurahan', 'kec_id', $(this).val(), '#KelID', 'Pilih Kelurahan', 'subdis_id', 'subdis_name');
    });

    function fetchDemografi(table, field, value, target, def, idF, nameF) {
        $.post('{{ route("demografipelanggan") }}',
            { _token: '{{ csrf_token() }}', Table: table, Field: field, Value: value },
            function (res) {
                var $t = $(target);
                $t.empty().append(new Option(def, ''));
                $.each(res.data, function (i, v) { $t.append(new Option(v[nameF], v[idF])); });
                $t.trigger('change.select2');
            }, 'json');
    }

    // ── Product cards ─────────────────────────────────────
    function renderProducts(jenisUsaha) {
        var filtered = oProducts.filter(function (p) { return p.JenisUsaha === jenisUsaha; });
        var $c = $('#productScroll').empty();

        if (!filtered.length) {
            $c.append('<div class="no-package-msg">Tidak ada paket tersedia untuk jenis usaha ini.</div>');
            return;
        }

        $.each(filtered, function (i, v) {
            var price   = v.Harga - (v.Potongan || 0);
            var priceHTML = (v.Potongan > 0)
                ? '<div class="pkg-price-original">Rp ' + Number(v.Harga).toLocaleString('id-ID') + '</div>'
                + '<div class="pkg-price-disc">Rp ' + price.toLocaleString('id-ID') + '</div>'
                : '<div class="pkg-price">Rp ' + Number(v.Harga).toLocaleString('id-ID') + '</div>';

            var badge = (i === 0) ? '<span class="pkg-badge">Populer</span>' : '';

            $c.append(
                '<div class="pkg-card" data-product="' + v.NoTransaksi + '" data-price="' + price + '">'
                + '<div class="pkg-icon"><i class="bi bi-grid-fill"></i></div>'
                + badge
                + '<h6>' + v.NamaSubscription + '</h6>'
                + '<div class="pkg-desc">' + (v.DeskripsiSubscription || '') + '</div>'
                + priceHTML
                + '</div>'
            );
        });

        // Reset selection
        productSelected = '';
        productPrice    = 0;
        resetVoucher();
        updatePriceSummary();
    }

    $('#productScroll').on('click', '.pkg-card', function () {
        $('.pkg-card').removeClass('selected');
        $(this).addClass('selected');
        productSelected = $(this).data('product');
        productPrice    = parseFloat($(this).data('price'));
        $('#ProductSelected').val(productSelected);
        resetVoucher();
        updatePriceSummary();
    });

    // ── Voucher ──────────────────────────────────────────
    $('#voucherCode').on('input', function () {
        if (voucherApplied) {
            resetVoucher();
            return;
        }
        $('#btnApplyVoucher').prop('disabled', $(this).val().trim().length < 3);
    });

    // Single permanent handler — checks voucherApplied state internally
    $('#btnApplyVoucher').on('click', function () {
        if (voucherApplied) {
            resetVoucher();
            return;
        }

        if (!productSelected) {
            showVoucherFeedback('Pilih paket berlangganan terlebih dahulu.', false);
            return;
        }

        var code = $('#voucherCode').val().trim().toUpperCase();
        if (!code) return;

        var $btn = $(this).prop('disabled', true)
            .html('<i class="bi bi-hourglass-split me-1"></i>Memeriksa...');

        $.post('{{ route("voucher-check") }}',
            { _token: '{{ csrf_token() }}', code: code, subtotal: productPrice },
            function (res) {
                if (res.valid) {
                    voucherApplied = true;
                    discountAmount = res.discount_amount;
                    $('#hdVoucherCode').val(code);
                    $('#hdDiscountAmount').val(discountAmount);
                    $('#hdFinalPrice').val(res.final_price);
                    showVoucherFeedback('✓ ' + res.message, true);
                    updatePriceSummary();
                    $btn.html('<i class="bi bi-x-circle me-1"></i>Hapus Voucher').prop('disabled', false);
                } else {
                    discountAmount = 0;
                    showVoucherFeedback(res.message, false);
                    $btn.html('<i class="bi bi-check2-circle me-1"></i>Gunakan').prop('disabled', false);
                }
            }, 'json')
        .fail(function () {
            showVoucherFeedback('Terjadi kesalahan, coba lagi.', false);
            $btn.html('<i class="bi bi-check2-circle me-1"></i>Gunakan').prop('disabled', false);
        });
    });

    function resetVoucher() {
        voucherApplied = false;
        discountAmount = 0;
        $('#voucherCode').val('');
        $('#hdVoucherCode').val('');
        $('#hdDiscountAmount').val(0);
        $('#hdFinalPrice').val(productPrice);
        $('#voucherFeedback').removeClass('success error').hide();
        $('#btnApplyVoucher')
            .html('<i class="bi bi-check2-circle me-1"></i>Gunakan')
            .prop('disabled', true);
        updatePriceSummary();
    }

    function showVoucherFeedback(msg, success) {
        $('#voucherFeedback')
            .removeClass('success error')
            .addClass(success ? 'success' : 'error')
            .text(msg);
    }

    function updatePriceSummary() {
        if (!productSelected) { $('#priceSummary').hide(); return; }

        var final = productPrice - discountAmount;
        $('#psOriginal').text('Rp ' + productPrice.toLocaleString('id-ID'));
        $('#hdFinalPrice').val(final);

        if (discountAmount > 0) {
            $('#psDiscRow').show();
            $('#psDiscount').text('- Rp ' + discountAmount.toLocaleString('id-ID'));
        } else {
            $('#psDiscRow').hide();
        }

        $('#psTotal').text('Rp ' + final.toLocaleString('id-ID'));
        $('#priceSummary').show();
    }

    // ── Password toggle ──────────────────────────────────
    $('.pw-toggle').on('click', function () {
        var target = $(this).data('target');
        var $inp   = $('#' + target);
        var $icon  = $('#pw-icon-' + target);
        if ($inp.attr('type') === 'password') {
            $inp.attr('type', 'text');
            $icon.removeClass('bi-eye').addClass('bi-eye-slash');
        } else {
            $inp.attr('type', 'password');
            $icon.removeClass('bi-eye-slash').addClass('bi-eye');
        }
    });

    // ── T&C checkbox → enable submit ─────────────────────
    $('#chkApprove').on('change', function () {
        $('#btRegister').prop('disabled', !this.checked);
    });

    // ── Form submit ───────────────────────────────────────
    $('#DaftarLangganan').on('submit', function (e) {
        e.preventDefault();

        // Validate step 3
        if (!productSelected) {
            $('#err-product').show();
            return;
        }

        var pw = $('#password').val();
        var pw2 = $('#ulangipassword').val();
        if (pw.length < 8) { $('#err-password').show(); return; }
        $('#err-password').hide();
        if (pw !== pw2) { $('#err-ulangipassword').show(); return; }
        $('#err-ulangipassword').hide();

        var $btn = $('#btRegister').prop('disabled', true)
            .html('<i class="bi bi-hourglass-split me-1"></i>Memproses...');

        var formData = $(this).serializeArray();

        $.post($(this).attr('action'), formData)
            .done(function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Pendaftaran Berhasil!',
                    html: 'Silakan periksa email Anda (termasuk folder <b>spam/junk</b>) untuk link konfirmasi.',
                    confirmButtonColor: '#4F46E5',
                    confirmButtonText: 'Mengerti'
                }).then(function () {
                    window.location.href = '{{ url("/") }}';
                });
            })
            .fail(function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Pendaftaran Gagal',
                    text: 'Terjadi kesalahan saat melakukan registrasi. Silakan coba lagi.',
                    confirmButtonColor: '#EF4444'
                }).then(function () {
                    $btn.prop('disabled', false)
                        .html('<i class="bi bi-rocket-takeoff me-1"></i>Daftar Sekarang');
                });
            });
    });

    // ── Jenis usaha watch (in case user goes back & changes) ──
    $('#JenisUsaha').on('change', function () {
        // Will re-render when entering step 3
    });

});
</script>
</body>
</html>
