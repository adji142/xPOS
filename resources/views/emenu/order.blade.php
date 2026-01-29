<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>E-Menu - {{ $titikLampu->NamaTitikLampu }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('css/style.css?v=1.0')}}" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
            padding-bottom: 80px; /* Space for bottom bar */
        }
        .header-bar {
            background: white;
            padding: 15px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            /* Removed sticky header to give more space/focus to menu and avoid overlap */
            position: relative; 
            z-index: 1000;
        }
        .item-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            overflow: hidden;
            height: 100%;
            transition: transform 0.2s;
            background: white;
        }
        /* .item-card:hover {
            transform: translateY(-5px);
        } */
        .item-image {
            height: 150px;
            background-size: cover;
            background-position: center;
        }
        .item-details {
            padding: 15px;
        }
        .item-title {
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 5px;
            color: #333;
        }
        .item-price {
            color: #28a745;
            font-weight: 700;
            font-size: 1rem;
        }
        .item-desc {
            font-size: 0.85rem;
            color: #777;
            margin-bottom: 15px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .qty-control {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #f8f9fa;
            border-radius: 8px;
            padding: 5px;
        }
        .btn-qty {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            color: #333;
            font-weight: bold;
            cursor: pointer;
        }
        .btn-qty:active {
            background: #e9ecef;
        }
        .qty-val {
            font-weight: 600;
            margin: 0 10px;
        }
        .bottom-bar {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            padding: 15px;
            box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
            z-index: 1001;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .total-info {
            display: flex;
            flex-direction: column;
        }
        .total-qty {
            font-size: 0.8rem;
            color: #777;
        }
        .total-price {
            font-size: 1.2rem;
            font-weight: 800;
            color: #333;
        }
        .btn-checkout {
            background: #28a745;
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 25px;
            font-weight: 600;
            box-shadow: 0 4px 6px rgba(40, 167, 69, 0.3);
        }
        .btn-checkout:disabled {
            background: #ccc;
            box-shadow: none;
        }
        .modal-content {
            border-radius: 15px;
        }
        .qris-container {
            text-align: center;
            padding: 20px;
        }
        .qris-img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .payment-option {
            border: 2px solid #f1f3f5;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
        }
        .payment-option.active {
            border-color: #28a745;
            background-color: #f8fff9;
        }
        .payment-option.disabled {
            opacity: 0.6;
            cursor: not-allowed;
            background-color: #f8f9fa;
        }
        .payment-option i {
            font-size: 1.5rem;
            margin-right: 15px;
            width: 30px;
            text-align: center;
        }
        .payment-info {
            flex-grow: 1;
        }
        .payment-title {
            font-weight: 600;
            display: block;
        }
        .payment-desc {
            font-size: 0.8rem;
            color: #777;
        }
        
        /* Sticky Wrapper */
        .sticky-header-container {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: white;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }

        .header-bar {
            background: white;
            padding: 15px;
            /* Remove positioning/shadow from individual items as container handles sticky */
        }
        
        /* Category Filter Styles */
        .category-scroll {
            display: flex;
            overflow-x: auto;
            padding: 15px 15px 15px 15px; /* Adjust padding */
            background: white;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none; /* Firefox */
            gap: 10px;
            /* Remove sticky from here */
        }
        .category-scroll::-webkit-scrollbar {
            display: none; /* Chrome, Safari */
        }
        .category-pill {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            background: #f1f3f5;
            color: #555;
            font-size: 0.9rem;
            font-weight: 600;
            border: 1px solid transparent;
            cursor: pointer;
            transition: all 0.2s;
        }
        .category-pill.active {
            background: #343a40; /* Dark premium color */
            color: white;
            box-shadow: 0 4px 6px rgba(0,0,0,0.2);
        }
        .section-header {
            scroll-margin-top: 150px; /* Increased offset */
        }
    </style>
</head>
<body>

    <div class="sticky-header-container">
        <div class="header-bar d-flex justify-content-between align-items-center">
        <div>
            <h5 class="m-0 font-weight-bold">
                @if($company && $company->NamaPartner)
                    {{ $company->NamaPartner }}
                @else
                    Menu Restoran
                @endif
            </h5>
            <small class="text-muted"><i class="fas fa-map-marker-alt mr-1"></i> {{ $titikLampu->NamaTitikLampu }}</small>
        </div>
        <div>
            @if($company && $company->icon)
                 <img src="{{ $company->icon }}" alt="Logo" style="height: 40px; border-radius: 5px;">
            @else
                 <i class="fas fa-utensils fa-2x text-muted"></i>
            @endif
        </div>
    </div>

        @php
            $groupedMenus = collect($menus)->groupBy('category');
        @endphp

        @if($groupedMenus->isNotEmpty())
        <div class="category-scroll">
            <div class="category-pill active" onclick="filterCategory('all', this)">All</div>
            @foreach($groupedMenus as $category => $items)
            <div class="category-pill" onclick="filterCategory('{{ Str::slug($category) }}', this)">{{ $category }}</div>
            @endforeach
        </div>
        @endif
    </div>

    <div class="container mt-3">

        @if($groupedMenus->isEmpty())
            <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 50vh;">
                <i class="fas fa-utensils fa-3x text-muted mb-3" style="opacity: 0.5;"></i>
                <h5 class="text-muted font-weight-bold">Belum ada menu</h5>
                <p class="text-muted small">Silakan hubungi pelayan untuk bantuan.</p>
            </div>
        @else
            @foreach($groupedMenus as $category => $items)
            <div class="category-section" id="cat-{{ Str::slug($category) }}">
                <h6 class="font-weight-bold text-muted mb-3 mt-4 text-uppercase section-header">{{ $category }}</h6>
                <div class="row">
                    @foreach($items as $item)
                    <div class="col-6 col-md-4 col-lg-3 mb-4">
                        <div class="item-card d-flex flex-column">
                            <div class="item-image" style="background-image: url('{{ $item['image'] }}');"></div>
                            <div class="item-details flex-grow-1 d-flex flex-column">
                                <div class="item-title">{{ $item['name'] }}</div>
                                <div class="item-desc">{{ $item['description'] }}</div>
                                <div class="mt-auto">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="item-price">Rp {{ number_format($item['price'], 0, ',', '.') }}</span>
                                    </div>
                                    <div class="qty-control" data-id="{{ $item['id'] }}" data-price="{{ $item['price'] }}" data-name="{{ $item['name'] }}">
                                        <button class="btn-qty minus" onclick="updateQty(this, -1)"><i class="fas fa-minus small"></i></button>
                                        <span class="qty-val">0</span>
                                        <button class="btn-qty plus" onclick="updateQty(this, 1)"><i class="fas fa-plus small"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        @endif
    </div>

    <div class="bottom-bar">
        <div class="total-info">
            <span class="total-qty">0 Items</span>
            <span class="total-price">Rp 0</span>
        </div>
        <button class="btn-checkout" onclick="openCheckout()" disabled>Checkout</button>
    </div>

    <!-- Checkout Modal -->
    <div class="modal fade" id="checkoutModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold">Konfirmasi Pesanan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-0">
                    <div class="p-3">
                        <small class="font-weight-bold text-muted text-uppercase mb-2 d-block">Daftar Pesanan</small>
                        <div id="cartItemsList" class="mb-3"></div>
                        
                        <div class="d-flex justify-content-between align-items-center mb-1 pt-2 border-top">
                            <span class="small text-muted">Subtotal</span>
                            <span class="small subtotal-modal-price">Rp 0</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="small text-muted">Biaya Layanan</span>
                            <span class="small service-fee-modal-price">Rp 0</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                            <span class="font-weight-bold">Total Pembayaran</span>
                            <span class="font-weight-bold text-success h5 mb-0 total-modal-price">Rp 0</span>
                        </div>
                    </div>

                    @if(!$isTableActive)
                    <div class="bg-white p-3 border-top">
                        <small class="font-weight-bold text-muted text-uppercase mb-3 d-block">Aktivasi Meja / Paket</small>
                        <div class="form-group mb-2">
                            <label class="small font-weight-bold text-muted">Jenis Paket</label>
                            <select class="form-control" id="JenisPaket" onchange="updatePaketDropdown()" style="border-radius: 8px;">
                                <option value="">-- Pilih Jenis Paket --</option>
                                @foreach($jenisLangganan as $jl)
                                <option value="{{ $jl['Kode'] }}">{{ $jl['Nama'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <label class="small font-weight-bold text-muted">Paket</label>
                            <select class="form-control" id="paketid" style="border-radius: 8px;" onchange="updateTableBookingSummary()">
                                <option value="">-- Pilih Paket --</option>
                            </select>
                        </div>
                        <div class="form-group mb-3 d-none" id="durationContainer">
                            <label class="small font-weight-bold text-muted">Jumlah Durasi (Jam)</label>
                            <input type="number" class="form-control" id="bookingDuration" value="1" min="1" onchange="updateTableBookingSummary()" onkeyup="updateTableBookingSummary()" style="border-radius: 8px;">
                        </div>

                        <div class="form-group mb-2">
                            <label class="small font-weight-bold text-muted">No. Telepon</label>
                            <input type="text" class="form-control" id="txtNoTlp_EMenu" placeholder="Masukkan nomor telepon..." style="border-radius: 8px;" autocomplete="off">
                            <input type="hidden" id="txtKodePelanggan_EMenu">
                        </div>
                        <div class="form-group mb-2">
                            <label class="small font-weight-bold text-muted">Nama Pelanggan</label>
                            <input type="text" class="form-control" id="txtNamaPelanggan_EMenu" placeholder="Nama Pelanggan" style="border-radius: 8px;">
                        </div>

                        <!-- Table Booking Cost Summary -->
                        <div id="tableBookingSummary" class="bg-light p-2 rounded d-none" style="border: 1px dashed #dee2e6;">
                            <div class="d-flex justify-content-between small mb-1">
                                <span class="text-muted">Harga Paket</span>
                                <span id="summaryTablePrice">Rp 0</span>
                            </div>
                            <div class="d-flex justify-content-between small mb-1">
                                <span class="text-muted">PPN ({{ $company->PPN }}%)</span>
                                <span id="summaryTablePPN">Rp 0</span>
                            </div>
                            <div class="d-flex justify-content-between small mb-1">
                                <span class="text-muted">Pajak Hiburan ({{ $company->PajakHiburan }}%)</span>
                                <span id="summaryTablePajakHiburan">Rp 0</span>
                            </div>
                            <div class="d-flex justify-content-between font-weight-bold pt-1 border-top mt-1">
                                <span>Subtotal Meja</span>
                                <span id="summaryTableSubtotal" class="text-primary">Rp 0</span>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="bg-light p-3">
                        <small class="font-weight-bold text-muted text-uppercase mb-3 d-block">Metode Pembayaran</small>
                        
                        <div class="payment-option {{ $canUseCash ? 'active' : 'disabled' }}" onclick="selectPayment('CASH', this, null, {{ $canUseCash ? 'false' : 'true' }})">
                            <i class="fas fa-money-bill-wave text-success"></i>
                            <div class="payment-info">
                                <span class="payment-title">Bayar di Kasir</span>
                                <span class="payment-desc">Selesaikan pembayaran saat selesai makan</span>
                            </div>
                            <i class="fas fa-check-circle text-success check-icon {{ $canUseCash ? '' : 'd-none' }}"></i>
                        </div>

                        @foreach($paymentMethods as $pm)
                            @if($pm->MetodeVerifikasi == 'AUTO')
                            <div class="payment-option {{ $canUseQRIS ? '' : 'disabled' }}" onclick="selectPayment('{{ $pm->id }}', this, {{ json_encode($pm) }}, {{ $canUseQRIS ? 'false' : 'true' }})">
                                <i class="fas fa-qrcode text-primary"></i>
                                <div class="payment-info">
                                    <span class="payment-title">{{ $pm->NamaMetodePembayaran }}</span>
                                    <span class="payment-desc">Pembayaran otomatis via QRIS/Lainnya</span>
                                </div>
                                <i class="fas fa-check-circle text-success check-icon d-none"></i>
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-block btn-success btn-lg font-weight-bold py-3" style="border-radius: 12px; box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);" onclick="finishOrder()" id="btnSubmitOrder">
                        PESAN SEKARANG
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    @if(env('MIDTRANS_IS_PRODUCTION', false))
    <script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ $midtransclientkey ?? '' }}"></script>
    @else
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ $midtransclientkey ?? '' }}"></script>
    @endif

    <script>
        let cart = JSON.parse(localStorage.getItem('emenu_cart_{{ $titikLampu->id }}')) || {};
        let selectedPayment = 'CASH';
        let selectedPaymentData = null;

        @if(!$canUseCash && $canUseQRIS)
            @php
                $firstQRIS = collect($paymentMethods)->where('MetodeVerifikasi', 'AUTO')->first();
            @endphp
            @if($firstQRIS)
                selectedPayment = '{{ $firstQRIS->id }}';
                selectedPaymentData = {!! json_encode($firstQRIS) !!};
                
                $(document).ready(function() {
                    const firstQRISBase = document.querySelector(`.payment-option[onclick*="'{{ $firstQRIS->id }}'"]`);
                    if (firstQRISBase) {
                        firstQRISBase.classList.add('active');
                        if(firstQRISBase.querySelector('.check-icon')) firstQRISBase.querySelector('.check-icon').classList.remove('d-none');
                    }
                });
            @endif
        @endif

        const allPackages = {!! json_encode($paket) !!};
        const companyPPN = {{ $company->PPN ?? 0 }};
        const companyPajakHiburan = {{ $company->PajakHiburan ?? 0 }};

        function updatePaketDropdown() {
            const jenis = $('#JenisPaket').val();
            const paketDropdown = $('#paketid');
            paketDropdown.empty();
            paketDropdown.append('<option value="">-- Pilih Paket --</option>');

            if (jenis === 'JAMREALTIME') {
                $('#durationContainer').removeClass('d-none');
            } else {
                $('#durationContainer').addClass('d-none');
                $('#bookingDuration').val(1);
            }

            if (jenis) {
                const filtered = allPackages.filter(p => p.JenisPaket === jenis);
                filtered.forEach(p => {
                    // Using HargaNormal from pakettransaksi table
                    const price = p.HargaNormal ? p.HargaNormal.toLocaleString('id-ID') : '0';
                    paketDropdown.append(`<option value="${p.id}">${p.NamaPaket} (Rp ${price})</option>`);
                });
            }
            updateTableBookingSummary();
        }

        function updateTableBookingSummary() {
            const paketId = $('#paketid').val();
            const duration = parseFloat($('#bookingDuration').val()) || 1;
            const summaryDiv = $('#tableBookingSummary');

            if (!paketId) {
                summaryDiv.addClass('d-none');
                updateTotal();
                return;
            }

            const paket = allPackages.find(p => p.id == paketId);
            if (!paket) {
                summaryDiv.addClass('d-none');
                updateTotal();
                return;
            }

            summaryDiv.removeClass('d-none');

            let basePrice = parseFloat(paket.HargaNormal) || 0;
            // If JAMREALTIME, multiply by duration
            if ($('#JenisPaket').val() === 'JAMREALTIME') {
                basePrice = basePrice * duration;
            }

            const ppn = (companyPPN / 100) * basePrice;
            const pajakHiburan = (companyPajakHiburan / 100) * basePrice;
            const subtotalMeja = basePrice + ppn + pajakHiburan;

            $('#summaryTablePrice').text('Rp ' + basePrice.toLocaleString('id-ID'));
            $('#summaryTablePPN').text('Rp ' + ppn.toLocaleString('id-ID'));
            $('#summaryTablePajakHiburan').text('Rp ' + pajakHiburan.toLocaleString('id-ID'));
            $('#summaryTableSubtotal').text('Rp ' + subtotalMeja.toLocaleString('id-ID'));

            updateTotal();
        }

        // Initialize cart from localStorage
        $(document).ready(function() {
            for (const id in cart) {
                const item = cart[id];
                const qtyControl = document.querySelector(`.qty-control[data-id="${id}"]`);
                if (qtyControl) {
                    qtyControl.querySelector('.qty-val').innerText = item.qty;
                }
            }
            updateTotal();

            // Phone Number Lookup Logic
            $('#txtNoTlp_EMenu').on('blur', function() {
                const noTlp = $(this).val();
                if (noTlp == "") return;
                $('#txtNamaPelanggan_EMenu').val('Sedang mengecek data...').attr('disabled', true);
                $.ajax({
                    url: "{{ route('pelanggan-viewJson') }}",
                    type: 'post',
                    data: {
                        "KodePelanggan" : "",
                        "GrupPelanggan" : "",
                        "NoTlp1" : noTlp,
                        "_token": "{{ csrf_token() }}"
                    },
                    beforeSend: function() {
                        $('#txtNamaPelanggan_EMenu').val('Sedang mengecek data...').attr('disabled', true);
                    },
                    success: function(response) {
                        $('#txtNamaPelanggan_EMenu').attr('disabled', false);
                        if (response.success && response.data.length > 0) {
                            const p = response.data[0];
                            $('#txtNamaPelanggan_EMenu').val(p.NamaPelanggan).attr('readonly', true);
                            $('#txtKodePelanggan_EMenu').val(p.KodePelanggan);
                        } else {
                            $('#txtNamaPelanggan_EMenu').val('').attr('readonly', false).attr('placeholder', 'Pelanggan Baru (Silakan isi nama)');
                            $('#txtKodePelanggan_EMenu').val('');
                        }
                    },
                    error: function() {
                        $('#txtNamaPelanggan_EMenu').attr('disabled', false).val('').attr('readonly', false);
                    }
                });
            });
        });

        function filterCategory(catSlug, btn) {
            // Update Active State
            document.querySelectorAll('.category-pill').forEach(el => el.classList.remove('active'));
            btn.classList.add('active');

            // Filter logic
            if (catSlug === 'all') {
                document.querySelectorAll('.category-section').forEach(el => el.style.display = 'block');
            } else {
                document.querySelectorAll('.category-section').forEach(el => {
                    if (el.id === 'cat-' + catSlug) {
                        el.style.display = 'block';
                    } else {
                        el.style.display = 'none';
                    }
                });
            }
            
            // Scroll to top of content
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function updateQty(btn, change) {
            const container = btn.closest('.qty-control');
            const id = container.dataset.id;
            const price = parseInt(container.dataset.price);
            const name = container.dataset.name;
            const qtySpan = container.querySelector('.qty-val');

            let currentQty = parseInt(qtySpan.innerText);
            let newQty = currentQty + change;

            if (newQty < 0) newQty = 0;

            qtySpan.innerText = newQty;

            if (newQty > 0) {
                cart[id] = { id, name, price, qty: newQty };
            } else {
                delete cart[id];
            }

            // Save to LocalStorage (Memory)
            localStorage.setItem('emenu_cart_{{ $titikLampu->id }}', JSON.stringify(cart));

            updateTotal();
        }

        function updateTotal() {
            let totalQty = 0;
            let subtotal = 0;

            for (const key in cart) {
                totalQty += cart[key].qty;
                subtotal += cart[key].qty * cart[key].price;
            }

            let serviceFee = 0;
            if (selectedPaymentData) {
                const percent = parseFloat(selectedPaymentData.BiayaAdminPercent) || 0;
                const rupiah = parseFloat(selectedPaymentData.BiayaAdminRupiah) || 0;
                
                if (percent > 0) {
                    serviceFee = (percent / 100) * subtotal;
                } else if (rupiah > 0) {
                    serviceFee = rupiah;
                }
            }

            // Calculate Table Subtotal
            let tableSubtotal = 0;
            if (!$('#tableBookingSummary').hasClass('d-none')) {
                const subtotalText = $('#summaryTableSubtotal').text().replace('Rp ', '').replace(/\./g, '');
                tableSubtotal = parseFloat(subtotalText) || 0;
            }

            const grandTotal = subtotal + serviceFee + tableSubtotal;

            document.querySelector('.total-qty').innerText = totalQty + ' Items';
            document.querySelector('.total-price').innerText = 'Rp ' + grandTotal.toLocaleString('id-ID');
            
            if (document.querySelector('.subtotal-modal-price')) {
                document.querySelector('.subtotal-modal-price').innerText = 'Rp ' + subtotal.toLocaleString('id-ID');
            }
            if (document.querySelector('.service-fee-modal-price')) {
                document.querySelector('.service-fee-modal-price').innerText = 'Rp ' + serviceFee.toLocaleString('id-ID');
            }
            document.querySelector('.total-modal-price').innerText = 'Rp ' + grandTotal.toLocaleString('id-ID');

            const btnCheckout = document.querySelector('.btn-checkout');
            if (totalQty > 0) {
                btnCheckout.disabled = false;
            } else {
                btnCheckout.disabled = true;
            }
        }

        function selectPayment(method, element, data, isDisabled) {
            if (isDisabled || element.classList.contains('disabled')) return;
            
            selectedPayment = method;
            selectedPaymentData = data;
            document.querySelectorAll('.payment-option').forEach(el => {
                el.classList.remove('active');
                if(el.querySelector('.check-icon')) el.querySelector('.check-icon').classList.add('d-none');
            });
            element.classList.add('active');
            if(element.querySelector('.check-icon')) element.querySelector('.check-icon').classList.remove('d-none');
            
            updateTotal();
        }

        function openCheckout() {
            const cartList = document.getElementById('cartItemsList');
            cartList.innerHTML = '';
            
            for (const key in cart) {
                const item = cart[key];
                const div = document.createElement('div');
                div.className = 'd-flex justify-content-between small mb-1';
                div.innerHTML = `<span>${item.qty}x ${item.name}</span> <span>Rp ${(item.qty * item.price).toLocaleString('id-ID')}</span>`;
                cartList.appendChild(div);
            }

            $('#checkoutModal').modal('show');
        }

        function finishOrder() {
            const btn = document.getElementById('btnSubmitOrder');
            
            @if(!$isTableActive)
            const jenisPaket = $('#JenisPaket').val();
            const paketid = $('#paketid').val();
            if (!jenisPaket || !paketid) {
                Swal.fire('Peringatan', 'Silakan pilih Jenis Paket dan Paket terlebih dahulu.', 'warning');
                return;
            }
            @endif

            let subtotal = 0;
            for (const key in cart) {
                subtotal += cart[key].qty * cart[key].price;
            }

            let serviceFee = 0;
            if (selectedPaymentData) {
                const percent = parseFloat(selectedPaymentData.BiayaAdminPercent) || 0;
                const rupiah = parseFloat(selectedPaymentData.BiayaAdminRupiah) || 0;
                
                if (percent > 0) {
                    serviceFee = (percent / 100) * subtotal;
                } else if (rupiah > 0) {
                    serviceFee = rupiah;
                }
            }

            let tableSubtotal = 0;
            if (!$('#tableBookingSummary').hasClass('d-none')) {
                const subtotalText = $('#summaryTableSubtotal').text().replace('Rp ', '').replace(/\./g, '');
                tableSubtotal = parseFloat(subtotalText) || 0;
            }

            const grandTotal = subtotal + serviceFee + tableSubtotal;

            if (selectedPayment === 'CASH') {
                submitOrderToBackend(null);
            } else {
                // QRIS Logic
                if (!selectedPaymentData || selectedPaymentData.MetodeVerifikasi !== 'AUTO') {
                    Swal.fire('Error', 'Metode pembayaran ini tidak mendukung verifikasi otomatis.', 'error');
                    return;
                }
                if (!selectedPaymentData.ClientKey) {
                    Swal.fire('Error', 'Konfigurasi pembayaran (Client Key) belum diatur.', 'error');
                    return;
                }

                btn.disabled = true;
                btn.innerText = 'MENYIAPKAN PEMBAYARAN...';

                // Call createpayment
                const oData = {
                    'MetodeBayar': selectedPaymentData.id,
                    'TotalPembelian': grandTotal,
                    'roid': "{{ $roid }}",
                    'table_id': "{{ $titikLampu->id }}"
                };

                fetch("{{route('emenu.create-payment')}}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(oData)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.snap_token) {
                        snap.pay(data.snap_token, {
                            onSuccess: function(result){
                                submitQrisOrderToBackend(result.order_id);
                            },
                            onPending: function(result){
                                Swal.fire('Info', 'Menunggu pembayaran selesai.', 'info');
                                btn.disabled = false;
                                btn.innerText = 'PESAN SEKARANG';
                            },
                            onError: function(result){
                                Swal.fire('Error', 'Pembayaran gagal.', 'error');
                                btn.disabled = false;
                                btn.innerText = 'PESAN SEKARANG';
                            },
                            onClose: function(){
                                btn.disabled = false;
                                btn.innerText = 'PESAN SEKARANG';
                            }
                        });
                    } else {
                        Swal.fire('Error', data.error || 'Gagal menyiapkan pembayaran.', 'error');
                        btn.disabled = false;
                        btn.innerText = 'PESAN SEKARANG';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    btn.disabled = false;
                    btn.innerText = 'PESAN SEKARANG';
                    Swal.fire('Error', 'Terjadi kesalahan jaringan.', 'error');
                });
            }
        }

        function submitQrisOrderToBackend(reffPembayaran) {
            const btn = document.getElementById('btnSubmitOrder');
            const tableId = "{{ $titikLampu->id }}";
            const roid = "{{ $roid }}";
            
            let subtotal = 0;
            for (const key in cart) {
                subtotal += cart[key].qty * cart[key].price;
            }

            let serviceFee = 0;
            if (selectedPaymentData) {
                const percent = parseFloat(selectedPaymentData.BiayaAdminPercent) || 0;
                const rupiah = parseFloat(selectedPaymentData.BiayaAdminRupiah) || 0;
                if (percent > 0) serviceFee = (percent / 100) * subtotal;
                else if (rupiah > 0) serviceFee = rupiah;
            }
            
            let tableSubtotal = 0;
            if (!$('#tableBookingSummary').hasClass('d-none')) {
                const subtotalText = $('#summaryTableSubtotal').text().replace('Rp ', '').replace(/\./g, '');
                tableSubtotal = parseFloat(subtotalText) || 0;
            }

            const grandTotal = subtotal + serviceFee + tableSubtotal;

            btn.disabled = true;
            btn.innerText = 'MENYIMPAN PESANAN...';

            fetch("{{ route('emenu.store-qris') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    table_id: tableId,
                    roid: roid,
                    cart: cart,
                    payment_method: selectedPaymentData.id,
                    total: grandTotal,
                    service_fee: serviceFee,
                    reff_pembayaran: reffPembayaran,
                    JenisPaket: $('#JenisPaket').val(),
                    paketid: $('#paketid').val(),
                    bookingDuration: $('#bookingDuration').val(),
                    NoTlp1: $('#txtNoTlp_EMenu').val(),
                    NamaPelanggan: $('#txtNamaPelanggan_EMenu').val(),
                    KodePelanggan: $('#txtKodePelanggan_EMenu').val()
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    localStorage.removeItem('emenu_cart_' + tableId);
                    cart = {};
                    updateTotal();
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Pesanan Anda telah diterima dan dibayar.',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Error', 'Gagal menyimpan pesanan: ' + data.message, 'error');
                    btn.disabled = false;
                    btn.innerText = 'PESAN SEKARANG';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'Terjadi kesalahan saat menyimpan pesanan.', 'error');
                btn.disabled = false;
                btn.innerText = 'PESAN SEKARANG';
            });
        }

        function submitOrderToBackend(reffPembayaran) {
            const btn = document.getElementById('btnSubmitOrder');
            btn.disabled = true;
            btn.innerText = 'MENYIMPAN PESANAN...';

            let subtotal = 0;
            for (const key in cart) {
                subtotal += cart[key].qty * cart[key].price;
            }

            let serviceFee = 0;
            if (selectedPaymentData) {
                const percent = parseFloat(selectedPaymentData.BiayaAdminPercent) || 0;
                const rupiah = parseFloat(selectedPaymentData.BiayaAdminRupiah) || 0;
                
                if (percent > 0) {
                    serviceFee = (percent / 100) * subtotal;
                } else if (rupiah > 0) {
                    serviceFee = rupiah;
                }
            }

            let tableSubtotal = 0;
            if (!$('#tableBookingSummary').hasClass('d-none')) {
                const subtotalText = $('#summaryTableSubtotal').text().replace('Rp ', '').replace(/\./g, '');
                tableSubtotal = parseFloat(subtotalText) || 0;
            }

            const grandTotal = subtotal + serviceFee + tableSubtotal;

            fetch('{{ route("emenu.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    cart: cart,
                    roid: '{{ $roid }}',
                    table_id: '{{ $titikLampu->id }}',
                    payment_method: selectedPayment,
                    reff_pembayaran: reffPembayaran,
                    total: grandTotal,
                    service_fee: serviceFee,
                    JenisPaket: $('#JenisPaket').val(),
                    paketid: $('#paketid').val(),
                    bookingDuration: $('#bookingDuration').val(),
                    NoTlp1: $('#txtNoTlp_EMenu').val(),
                    NamaPelanggan: $('#txtNamaPelanggan_EMenu').val(),
                    KodePelanggan: $('#txtKodePelanggan_EMenu').val()
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    localStorage.removeItem('emenu_cart_{{ $titikLampu->id }}');
                    cart = {};
                    updateTotal();
                    Swal.fire({
                        icon: 'success',
                        title: 'Pesanan Berhasil!',
                        text: 'Terima kasih atas pesanan Anda. Kami akan segera menyajikannya.',
                        confirmButtonColor: '#28a745'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: data.message || 'Terjadi kesalahan saat memproses pesanan.',
                    });
                    btn.disabled = false;
                    btn.innerText = 'PESAN SEKARANG';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Terjadi kesalahan jaringan.',
                });
                btn.disabled = false;
                btn.innerText = 'PESAN SEKARANG';
            });
        }
    </script>
</body>
</html>
