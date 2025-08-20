<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Booking Online Table di {{ $company->NamaPartner }}</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css"/>
  @if (env('MIDTRANS_IS_PRODUCTION') == false)
<script src="{{ env('MIDTRANS_DEV_URL') }}" data-client-key="{{ $midtransclientkey }}"></script>
@else
<script src="{{ env('MIDTRANS_PROD_URL') }}" data-client-key="{{ $midtransclientkey }}"></script>
@endif
    @php
        $defaultColor = $company->DefaultLandingPageColor;
        $themeColor = (!empty($defaultColor) && preg_match('/^#([A-Fa-f0-9]{6})$/', $defaultColor)) ? $defaultColor : '#0d6efd';

        // Convert hex to RGB
        [$r, $g, $b] = sscanf($themeColor, "#%02x%02x%02x");
    @endphp
  <style>
    .banner-container { padding: 20px; }
    .carousel-item img { border-radius: 1rem; object-fit: cover; width: 100%; height: 400px; }
    .overlay { position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(var(--theme-color-rgb), 0.4); border-radius: 1rem; }
    .carousel-inner > .carousel-item { position: relative; }
    .highlight-title { font-size: 1.75rem; font-weight: 700; }
    .divider { border-top: 2px solid #ddd; margin: 1rem 0; }
    .card-custom { border-radius: 1rem; box-shadow: 0 0 10px rgba(0,0,0,0.05); }
    .scrolling-wrapper { overflow-x: auto; white-space: nowrap; padding-bottom: 1rem; }
    .scrolling-wrapper .col-md-3 { display: inline-block; float: none; width: 20%; padding: 0 0.75rem; }
    .slot-card { cursor: pointer; border: 2px solid transparent; transition: all 0.3s; border-radius: 0.5rem; }
    .slot-card:hover { background-color: #f8f9fa; }
    .slot-card.selected { border-color: #198754; background-color: #d1e7dd; }
    .date-btn { min-width: 80px; }
    .date-btn.active { background-color: #dc3545; color: white; }
    .cart-list { max-height: 300px; overflow-y: auto; margin-top: 2rem; }
    .video-card {position: relative; cursor: pointer; overflow: hidden; border-radius: 1rem;}
    .video-card iframe {width: 100%;border-radius: 1rem;}
    .video-card .hover-overlay {position: absolute;top: 0; left: 0; right: 0; bottom: 0;background: rgba(0,0,0,0.3);opacity: 0;transition: opacity 0.3s;border-radius: 1rem;}
    .video-card:hover .hover-overlay {opacity: 1;}
    .scrolling-wrapper {overflow-x: auto;white-space: nowrap;padding-bottom: 1rem;}
    .scrolling-wrapper .col-md-3 {display: inline-block;float: none;width: 20%;padding: 0 0.5rem;}
    .theme-dot {
      width: 24px;
      height: 24px;
      border-radius: 50%;
      cursor: pointer;
      border: 2px solid #fff;
      box-shadow: 0 0 3px rgba(0,0,0,0.2);
    }
    .theme-dot:hover {
      border-color: #000;
    }

    :root {
        --theme-color: {{ $themeColor }};
    }
    
    .btn-primary {
      background-color: var(--theme-color) !important;
      border-color: var(--theme-color) !important;
    }
    .btn-success {
      background-color: var(--theme-color) !important;
      border-color: var(--theme-color) !important;
    }
    .btn-warning {
      background-color: var(--theme-color) !important;
      border-color: var(--theme-color) !important;
    }
    .btn-danger {
      background-color: var(--theme-color) !important;
      border-color: var(--theme-color) !important;
    }
    .text-theme {
      color: var(--theme-color) !important;
    }
    .bg-theme {
      background-color: var(--theme-color) !important;
    }
    .border-theme {
      border-color: var(--theme-color) !important;
    }
    body.dark-mode {
      background-color: #121212;
      color: #f1f1f1;
    }

    body.dark-mode .card,
    body.dark-mode .card-custom {
      background-color: #1e1e1e !important;
      color: #f1f1f1;
      border-color: #333;
    }

    body.dark-mode .highlight-title {
      color: #ffffff;
    }

    body.dark-mode .text-muted {
      color: #bbbbbb !important;
    }

    body.dark-mode .btn {
      color: #f1f1f1;
    }

    body.dark-mode .btn-outline-secondary {
      color: #ccc;
      border-color: #555;
    }

    body.dark-mode .btn-outline-danger {
      color: #ff6b6b;
      border-color: #ff6b6b;
    }

    body.dark-mode .btn-primary {
      background-color: var(--theme-color) !important;
      border-color: var(--theme-color) !important;
      color: #fff !important;
    }

    body.dark-mode .date-btn {
      background-color: #2a2a2a;
      color: #eee;
      border-color: #444;
    }

    body.dark-mode .date-btn.active {
      background-color: var(--theme-color) !important;
      color: white !important;
    }

    body.dark-mode .slot-card {
      background-color: #2c2c2c;
      color: #f1f1f1;
      border-color: #555;
    }

    body.dark-mode .slot-card:hover {
      background-color: #3a3a3a;
    }

    body.dark-mode .slot-card.selected {
      background-color: #275d3a !important;
      border-color: #198754 !important;
      color: #ffffff;
    }

    body.dark-mode .modal-content {
      background-color: #1f1f1f;
      color: #f1f1f1;
    }

    body.dark-mode .bg-light {
      background-color: #2a2a2a !important;
      color: #eee !important;
    }

    body.dark-mode .overlay {
      background: rgba(var(--theme-color-rgb), 0.5);
    }

    body.dark-mode .list-group-item {
      background-color: #262626;
      color: #f1f1f1;
      border-color: #444;
    }

    body.dark-mode select,
    body.dark-mode input {
      background-color: #2a2a2a;
      color: #f1f1f1;
      border-color: #444;
    }

    body.dark-mode .form-control:focus,
    body.dark-mode .form-select:focus {
      border-color: var(--theme-color);
      box-shadow: 0 0 0 0.25rem rgba(var(--theme-color-rgb), 0.25);
    }
    body.dark-mode footer {
      background-color: #1e1e1e;
      color: #f1f1f1;
      border-top-color: #333;
    }
    body.dark-mode footer a {
      color: #ddd;
    }
  </style>
</head>
<body>
  <div class="position-fixed top-0 end-0 p-3 z-3">
    <button class="btn btn-sm btn-outline-dark" id="themeToggleBtn" title="Toggle Dark/Light Mode">
      <i class="bi bi-moon-fill"></i>
    </button>
  </div>
<div class="container banner-container">
  <!-- Banner Carousel -->
  <div id="bannerCarousel" class="carousel slide mb-4" data-bs-ride="carousel">
    <div class="carousel-inner">
        @foreach ($galleryImages as $images)
            @if ($images['slot'] == -1)
                <div class="carousel-item active">
                    <div class="position-relative">
                        <img src="{{ $images['url'] }}" alt="Billiard 1">
                        <div class="overlay"></div>
                    </div>
                </div>
            @else
                <div class="carousel-item">
                    <div class="position-relative">
                        <img src="{{ $images['url'] }}" alt="Billiard 1">
                        <div class="overlay"></div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>

  <!-- Info Section -->
  <div class="row g-4">
    <!-- Left Section -->
    <div class="col-lg-8">
      <div class="highlight-title text-theme">{{ $company->NamaPartner }}</div>
      <div class="text-muted">
        {{ $company->AlamatTagihan }} <i class="bi bi-geo-alt-fill"></i>
      </div>
      <div class="divider"></div>
      <div class="card card-custom mb-3 p-3">
        <h5 class="mb-2">Tentang Kami</h5>
        <p class="mb-0">
            {!! $company->AboutUs !!}
        </p>
      </div>
      <div class="card card-custom p-3">
        <h5 class="mb-2">Syarat & Ketentuan</h5>
        <ul class="mb-0">
          {!! $company->TermAndCondition !!}
        </ul>
      </div>
    </div>
    <!-- Right Section -->
    <div class="col-lg-4">
      <div class="card card-custom p-4 mb-3 text-center">
        <h5>Harga Mulai Dari</h5>
        <div class="display-6 fw-bold text-success">Rp {{ number_format($hargaMinimal) }} </div>
        <button class="btn btn-primary mt-3 w-100">Jelajahi Paket</button>
      </div>
      <div class="card card-custom p-3 text-center">
        <h6>Keranjang Anda</h6>
        <div class="mb-2">
          <button class="btn btn-outline-secondary position-relative" data-bs-toggle="modal" data-bs-target="#cartModal" onclick="updateCartUI()">
            <span class="badge bg-danger rounded-circle position-absolute top-0 start-100 translate-middle px-2 py-1" id="cartBadge">2</span>
            <i class="bi bi-cart3"></i> Lihat Keranjang
          </button>
        </div>
        <button class="btn btn-success w-100">
          <i class="bi bi-credit-card"></i> Checkout Sekarang
        </button>
      </div>
    </div>
  </div>

  <!-- Video Slider Section -->
  <div class="mt-5">
    <h5 class="mb-3">Galeri Video</h5>
    <div class="scrolling-wrapper d-flex">
        @foreach ($videoDisplay as $video)
            <div class="col-md-3">
                <div class="video-card" data-bs-toggle="modal" data-bs-target="#videoModal" data-video="https://www.youtube.com/embed/{{ $video }}">
                    <iframe src="https://www.youtube.com/embed/{{ $video }}?controls=0" frameborder="0" allowfullscreen></iframe>
                    <div class="hover-overlay"></div>
                </div>
            </div>
        @endforeach
    </div>
  </div>

  <!-- Pilih Jadwal Section -->
  <div class="mt-5">
    <h5 class="mb-3">Pilih Meja & Jadwal</h5>
    <div class="d-flex align-items-center gap-2 mb-3 overflow-auto" id="dateList"></div>
    <div class="mb-4">
      <label for="manualDate">Atau pilih tanggal manual:</label>
      <input type="text" id="manualDate" class="form-control" style="max-width: 250px;" placeholder="Pilih tanggal...">
    </div>

    <div class="mb-2">
      <label for="paketSelect" class="form-label">Pilih Paket Bermain:</label>
      <select id="paketSelect" class="form-select" onchange="onPaketChange()">
        @foreach ($paketTransaksi as $paket)
            <option value="{{ $paket->id }}" data-harga="{{ $paket->HargaNormal }}">{{ $paket->NamaPaket }} - Rp {{ number_format($paket->HargaNormal) }} </option>
        @endforeach
      </select>
    </div>


    <div id="mejaContainer" class="row g-4"></div>
  </div>
  
  <!-- Keranjang -->
  <div class="cart-list d-none" id="cartListWrapper">
    <h5>Keranjang Pemesanan</h5>
    <ul class="list-group" id="cartList"></ul>
  </div>

  <!-- Modal Keranjang -->
  <div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="cartModalLabel">Keranjang Pemesanan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <div class="mb-3">
            <label for="telpPelanggan" class="form-label">Nomor Telepon</label>
            <input type="tel" class="form-control" id="telpPelanggan" name="telpPelanggan" required>
          </div>

          <div class="mb-3">
            <label for="namaPelanggan" class="form-label">Nama Pelanggan</label>
            <input type="text" class="form-control" id="namaPelanggan" name="namaPelanggan" required>
          </div>
          <div class="mb-3">
            <label for="emailPelanggan" class="form-label">Email</label>
            <input type="email" class="form-control" id="emailPelanggan" name="emailPelanggan">
          </div>
          <div class="mb-3">
            <label for="extraRequest" class="form-label">Permintaan Tambahan (Extra Request)</label>
            <textarea class="form-control" id="extraRequest" name="extraRequest" rows="2" placeholder="Misal: meja dekat jendela..."></textarea>
          </div>

          <div class="mb-3">
            <label for="voucherCode" class="form-label">Kode Voucher</label>
            <div class="input-group">
              <input type="text" class="form-control" id="voucherCode" placeholder="Masukkan kode voucher">
              <button class="btn btn-outline-secondary" type="button" onclick="validateVoucher()" id="applyVoucherBtn">Gunakan</button>
            </div>
          </div>
          <hr class="my-3">

          <ul class="list-group" id="cartListModal"></ul>

          <div class="mt-4 p-3 border-top">
            <div class="d-flex justify-content-between fs-5 mb-2">
              <span>Subtotal</span>
              <span id="subtotalDisplay">Rp0</span>
            </div>
            <div class="d-flex justify-content-between fs-5 mb-2">
              <span>Diskon Voucher</span>
              <span id="voucherDisplay">- Rp0</span>
            </div>
            <div class="d-flex justify-content-between fs-5 mb-2">
              <span>PPN ({{ $company->PPN }}%)</span>
              <span id="ppnDisplay">Rp0</span>
            </div>
            <div class="d-flex justify-content-between fs-5 mb-3">
              <span>Pajak Hiburan ({{ $company->PajakHiburan }}%)</span>
              <span id="hiburanDisplay">Rp0</span>
            </div>
            <hr>
            <div class="d-flex justify-content-between fs-4 fw-bold text-success">
              <span>Total Bayar</span>
              <span id="netTotalDisplay">Rp0</span>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          <button class="btn btn-success" id="btModalCheckout">
            <i class="bi bi-credit-card"></i> Checkout Sekarang
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Video Player -->
  <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body p-0">
          <div class="ratio ratio-16x9">
            <iframe id="videoFrame" src="" title="Video" allowfullscreen allow="autoplay"></iframe>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/litepicker/dist/bundle.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  mejaData = [];
  const ppnPercent = {{ $company->PPN ?? 0 }};
  const hiburanPercent = {{ $company->PajakHiburan ?? 0 }};
  let voucherDiscount = 0; // Default diskon voucher

  let cart = JSON.parse(localStorage.getItem('booking_cart')) || [];
  let currentSelectedDate = new Date();

  function fetchJadwal(RecordOwnerID, PaketID, TglBooking) {
    const apiUrl = "{{ url('api/getjadwal') }}";
    $.ajax({
      url: apiUrl,
      method: 'POST',
      data: {
        _token: '{{ csrf_token() }}',
        RecordOwnerID: RecordOwnerID,
        PaketID: PaketID,
        TglBooking: TglBooking
      },
      beforeSend: function () {
        $('#mejaContainer').html('<div class="text-center py-5">Loading...</div>');
      },
      success: function (response) {
        mejaData = response; // asumsi response JSON punya field data
        console.log(mejaData)
        renderMeja();
      },
      error: function (xhr) {
        console.error(xhr.responseText);
        alert('Gagal memuat jadwal meja.');
      }
    });
  }

  function generateDateList(centerDate) {
    const $dateList = $('#dateList').empty();
    for (let i = -3; i <= 3; i++) {
      const d = new Date(centerDate);
      d.setDate(d.getDate() + i);
      const dateStr = d.toISOString().split('T')[0];
      const label = d.toLocaleDateString('id-ID', { weekday: 'short', day: '2-digit', month: 'short' });

      const $btn = $('<button>')
        .addClass('btn btn-outline-dark btn-sm rounded-pill date-btn')
        .text(label)
        .attr('data-date', dateStr)
        .toggleClass('active', i === 0)
        .on('click', function () {
          $('.date-btn').removeClass('active');
          $(this).addClass('active');

          currentSelectedDate = new Date();
          fetchJadwal("{{ $company->KodePartner }}",$('#paketSelect').val(), d.toISOString().split('T')[0]);
        });

      $dateList.append($btn);
    }
  }

  function updateCartUI() {
    const $cartList = $('#cartListModal').empty();
    const $cartBadge = $('#cartBadge');
    const $totalDisplay = $('#cartTotalDisplay');
    let subtotal = 0;

    cart.forEach((item, index) => {
      const $li = $(` <li class="list-group-item d-flex justify-content-between align-items-center">
          <div><strong>${item.meja}</strong><br><small>${item.jam}</small></div>
          <div class="text-end">
            <div>Rp${item.harga.toLocaleString()}</div>
            <button class="btn btn-sm btn-outline-danger mt-1">
              <i class="bi bi-trash"></i>
            </button>
          </div>
        </li>
      `);
      $li.find('button').on('click', () => removeCartItem(index));
      $cartList.append($li);
      subtotal += item.harga;
    });

    // Hitung pajak & net total
    const ppn = Math.round((subtotal - voucherDiscount) * (ppnPercent / 100));
    const hiburan = Math.round((subtotal - voucherDiscount) * (hiburanPercent / 100));
    const netTotal = subtotal - voucherDiscount + ppn + hiburan;

    // Tampilkan
    $('#subtotalDisplay').text(`Rp${subtotal.toLocaleString()}`);
    $('#voucherDiscountDisplay').text(`Rp${voucherDiscount.toLocaleString()}`);
    $('#ppnDisplay').text(`Rp${ppn.toLocaleString()}`);
    $('#hiburanDisplay').text(`Rp${hiburan.toLocaleString()}`);
    $('#netTotalDisplay').text(`Rp${netTotal.toLocaleString()}`);
    $totalDisplay.text(`Rp${netTotal.toLocaleString()}`);

    $cartBadge.text(cart.length);
    localStorage.setItem('booking_cart', JSON.stringify(cart));
  }

  function removeCartItem(index) {
    cart.splice(index, 1);
    updateCartUI();
  }

  function toggleCartList() {
    $('#cartListWrapper').toggleClass('d-none');
  }

  function renderMeja() {
    const $container = $('#mejaContainer').empty();

    // Group meja by KelompokMeja
    const groupedMeja = mejaData.reduce((acc, meja) => {
      const group = meja.KelompokMeja || 'Lainnya'; // Default group if not specified
      if (!acc[group]) {
        acc[group] = [];
      }
      acc[group].push(meja);
      return acc;
    }, {});

    // Render each group
    for (const groupName in groupedMeja) {
      // Add group title
      $container.append(`<div class="col-12"><h4 class="text-primary mt-4">${groupName}</h4><hr></div>`);

      const mejasInGroup = groupedMeja[groupName];
      mejasInGroup.forEach((meja, idx) => {
        const uniqueId = `${groupName.replace(/\s+/g, '-')}-${idx}`; // Create a unique ID for collapse
        const $col = $('<div>').addClass('col-lg-6');
        const $card = $('<div>').addClass('card card-custom');
        const $body = $('<div>').addClass('card-body');
        $body.append(`<h5>${meja.nama}</h5>`);
        $body.append(`<p class="text-muted">${meja.deskripsi}</p>`);

        const $fiturList = $('<ul class="list-unstyled">');
        if(meja.fitur) {
            meja.fitur.forEach(f => $fiturList.append(`<li><i class="bi bi-dot"></i> ${f}</li>`));
        }
        $body.append($fiturList);
        
        const availableCount = meja.jadwal.filter(j => j.status === 'available').length;

        const $toggleBtn = $('<button>')
          .addClass('btn btn-danger btn-sm mt-2')
          .attr('data-bs-toggle', 'collapse')
          .attr('data-bs-target', `#jadwal${uniqueId}`)
          .html(`${availableCount} Jadwal Tersedia <i class="bi bi-chevron-down"></i>`);
        $body.append($toggleBtn);

        const $jadwalDiv = $(`<div class="collapse mt-3" id="jadwal${uniqueId}">`);
        const $row = $('<div class="row g-2">');

        meja.jadwal.forEach(j => {
          const $slot = $('<div class="col-md-4">');
          const $slotCard = $(`
            <div class="border p-2 text-center slot-card">
              <small>60 Menit</small><br><strong>${j.jam}</strong><br>Rp${j.harga.toLocaleString()}
            </div>
          `);

          if (j.status === 'booked') {
            $slotCard.addClass('bg-light text-muted').append('<br><em>Booked</em>');
          } else {
            $slotCard.on('click', function () {
              const selectedDate = $('.date-btn.active').data('date');
              const newItem = { id:meja.id,meja: meja.nama, jam: j.jam, harga: j.harga, date: selectedDate, jammulai:j.jammulai, jamselesai:j.jamselesai };
              
              if (cart.length > 0 && !isJamValid(j.jam)) {
                alert('Anda hanya dapat memilih jadwal yang berurutan di hari yang sama.');
                return;
              }

              $(this).toggleClass('selected');
              // Simple add/remove from cart
              const existingItemIndex = cart.findIndex(item => item.id === newItem.id && item.jam === newItem.jam);
              if (existingItemIndex > -1) {
                cart.splice(existingItemIndex, 1); // Remove if already selected
              } else {
                cart.push(newItem); // Add if not selected
              }
              updateCartUI();
            });
          }

          $slot.append($slotCard);
          $row.append($slot);
        });

        $jadwalDiv.append($row);
        $body.append($jadwalDiv);
        $card.append($body);
        $col.append($card);
        $container.append($col);
      });
    }
  }

  function parseHour(jamStr) {
    const [start] = jamStr.split(' - ');
    const [hour, minute] = start.split(':').map(Number);
    return hour + minute / 60;
  }

  function isJamValid(newJam) {
    const selectedDate = $('.date-btn.active').data('date');
    const sameDate = cart.every(item => item.date === selectedDate);
    console.log(selectedDate);
    // const sameDate = cart.every(item => item.date === currentSelectedDate.toISOString().split('T')[0]);
    if (!sameDate) return false;
    const times = cart.map(i => parseHour(i.jam)).concat(parseHour(newJam)).sort((a, b) => a - b);
    for (let i = 1; i < times.length; i++) {
      if (Math.abs(times[i] - times[i - 1]) !== 1) return false;
    }
    return true;
  }

  function hexToRgb(hex) {
    hex = hex.replace('#', '');
    const bigint = parseInt(hex, 16);
    const r = (bigint >> 16) & 255;
    const g = (bigint >> 8) & 255;
    const b = bigint & 255;
    return `${r}, ${g}, ${b}`;
  }

  function applyThemeColor(color) {
    document.documentElement.style.setProperty('--theme-color', color);
    document.documentElement.style.setProperty('--theme-color-rgb', hexToRgb(color));
    localStorage.setItem('theme_color', color);
  }

  function setDarkMode(isDark) {
    $('body').toggleClass('dark-mode', isDark);
    localStorage.setItem('is_dark_mode', isDark);
    $('#themeToggleBtn i').attr('class', isDark ? 'bi bi-sun-fill' : 'bi bi-moon-fill');
  }
  function PaymentGateWay(ButtonObject, ButtonDefaultText, formData) {
    ButtonObject.text('Tunggu Sebentar.....');
    ButtonObject.attr('disabled', true);

    console.log("FormData:", formData);  // Debugging
        
    let oData = {
        'NoTransaksi': "",
        'TotalPembelian': formData.totalPembelian,
        "kodePartner": "{{ $company->KodePartner }}",
    };
    
    fetch("{{route('booking-create-gateway')}}", {
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
                onSuccess: function (result) {
                    if (result.transaction_status === "cancel") {
                        ButtonObject.text('Bayar');
                        ButtonObject.attr('disabled', false);
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Pembayaran Dibatalkan",
                        });
                    } else {
                        let xData = {
                            "NoTransaksi": "",
                            "TglBooking": formData.jamMulai,
                            "Keterangan": result.payment_type + "#" + (result.va_numbers?.[0]?.bank || "") + "#" + (result.va_numbers?.[0]?.va_number || ""),
                            "JamMulai": formData.jamMulai,
                            "JamSelesai": formData.jamAkhir,
                            "mejaID": cart[0]['id'],
                            "paketid": $('#paketSelect').val(),
                            "KodeSales": "-",
                            "KodePelanggan": "-",
                            "StatusTransaksi": 0,
                            "ExtraRequest": $('#ExtraRequest').val(),
                            "TotalTransaksi": formData.totalAsli,
                            "TotalTax": formData.totalTax + formData.totalPajakHiburan,
                            "TotalDiskon": formData.totalDiskon,
                            "TotalLainLain": 0,
                            "NetTotal": formData.totalPembelian,
                            "NamaPelanggan": formData.namaLengkap,
                            "Email": formData.email,
                            "NoTlp1": formData.noTelp,
                            "VoucherCode" : formData.voucherCode,
                            "kodePartner": {{ $company->KodePartner }},
                            "ExtraRequest" : formData.extraRequest
                        };
                        
                        fetch("{{route('booking-pay-gateway')}}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify(xData)
                        })
                        .then(response => response.json())
                        .then(response => {
                            if (response.success) {
                                Swal.fire({
                                    icon: "success",
                                    title: 'Berhasil',
                                    text: 'Pembayaran berhasil disimpan, Silahkan Cek Email Anda!',
                                }).then(() => {
                                    if (localStorage.getItem('booking_cart')) {
                                        localStorage.removeItem('booking_cart');
                                    }
                                    location.reload();
                                });
                            } else {
                                ButtonObject.text('Bayar');
                                ButtonObject.attr('disabled', false);
                                Swal.fire({
                                    icon: "error",
                                    title: 'Error',
                                    text: response.message,
                                });
                            }
                        });
                    }
                },
                onError: function (result) {
                    ButtonObject.text('Bayar');
                    ButtonObject.attr('disabled', false);
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Terjadi kesalahan saat pembayaran",
                    });
                },
                onClose: function () {
                    ButtonObject.text('Bayar');
                    ButtonObject.attr('disabled', false);
                    console.log('Pelanggan menutup popup pembayaran');
                }
            });
        } else {
            ButtonObject.text('Bayar');
            ButtonObject.attr('disabled', false);
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: data.error,
            });
        }
    })
    .catch(error => console.error('Error:', error));
}

  function validateVoucher() {
    const kode = $('#voucherCode').val().trim();
    const subtotal = cart.reduce((total, item) => total + item.harga, 0);

    if (!kode) {
      Swal.fire('Oops', 'Silakan masukkan kode voucher.', 'warning');
      return;
    }

    const apiVoucherUrl = "{{ url('api/discountvoucher/cekdiscount') }}";
    $.ajax({
      url: apiVoucherUrl,
      method: 'POST',
      data: {
        _token: '{{ csrf_token() }}',
        voucher: kode,
        subtotal: subtotal,
        RecordOwnerID: "{{ $company->KodePartner }}"
      },
      beforeSend: () => {
        Swal.fire({ title: 'Validasi Voucher...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
      },
      success: (res) => {
        Swal.close();

        if (res.valid) {
          const diskon = res.applied_discount;

          $('#voucherDisplay').text(`- Rp${diskon.toLocaleString()}`);
          $('#voucherDisplay').data('value', diskon); // simpan ke data attr
          recalculateTotal();
          Swal.fire('Berhasil', res.message, 'success');
        } else {
          Swal.fire('Gagal', res.message, 'error');
        }
      },
      error: (xhr) => {
        Swal.fire('Gagal', 'Terjadi kesalahan sistem.', 'error');
      }
    });
  }

  function recalculateTotal() {
    const subtotal = cart.reduce((total, item) => total + item.harga, 0);
    const voucher = parseInt($('#voucherDisplay').data('value')) || 0;

    const ppnPersen = {{ $company->PPN }};
    const hiburanPersen = {{ $company->PajakHiburan }};

    const ppn = Math.round((subtotal - voucher) * ppnPersen / 100);
    const hiburan = Math.round((subtotal - voucher) * hiburanPersen / 100);
    const totalNet = subtotal - voucher + ppn + hiburan;

    $('#subtotalDisplay').text(`Rp${subtotal.toLocaleString()}`);
    $('#ppnDisplay').text(`Rp${ppn.toLocaleString()}`);
    $('#hiburanDisplay').text(`Rp${hiburan.toLocaleString()}`);
    $('#netTotalDisplay').text(`Rp${totalNet.toLocaleString()}`);
  }

  function combineDateTime(tanggal, jam) {
    return new Date(`${tanggal}T${jam}:00`);
  }



  $(function () {
    currentSelectedDate = new Date();

    // Panggil API pertama kali
    fetchJadwal("{{ $company->KodePartner }}",$('#paketSelect').val(), currentSelectedDate.toISOString().split('T')[0]);

    renderMeja();
    generateDateList(currentSelectedDate);
    updateCartUI();

    const savedColor = localStorage.getItem('theme_color');
    if (savedColor) applyThemeColor(savedColor);

    const isDark = localStorage.getItem('is_dark_mode') === 'true';
    setDarkMode(isDark);

    $('#themeToggleBtn').on('click', function () {
      setDarkMode(!$('body').hasClass('dark-mode'));
    });

    // Contoh event tanggal berubah
    $('#manualDate').on('change', function () {
      const tgl = $(this).val(); // format 'YYYY-MM-DD'
      currentSelectedDate = new Date(tgl);
      generateDateList(currentSelectedDate);

      fetchJadwal("{{ $company->KodePartner }}",$('#paketSelect').val(), tgl); // ganti 1 & 1 sesuai PaketID & RecordOwnerID dari data kamu
    });

    $('#btModalCheckout').click(function () {
      const nama = $('#namaPelanggan').val().trim();
      const telp = $('#telpPelanggan').val().trim();
      const email = $('#emailPelanggan').val().trim();
      const extra = $('#extraRequest').val().trim();
      const voucherCode = $('#voucherCode').val().trim();
      const totalAsli = cart.reduce((sum, item) => sum + item.harga, 0);
      const diskon = parseInt($('#voucherDisplay').data('value')) || 0;

      if (!nama || !telp) {
        Swal.fire('Oops', 'Nama dan nomor telepon wajib diisi.', 'warning');
        return;
      }

      if (cart.length === 0) {
        Swal.fire('Keranjang Kosong', 'Silakan pilih jadwal terlebih dahulu.', 'warning');
        return;
      }

      // const jamMulai = cart
      //   .map(c => c.jammulai)
      //   .sort((a, b) => a.localeCompare(b))[0];

      // const jamSelesai = cart
      //   .map(c => c.jamselesai)
      //   .sort((a, b) => b.localeCompare(a))[0];

      const tanggal = cart[0].date;
      // const mulaiDateTime = new Date(`${tanggal}T${jamMulai}:00`);
      // const akhirDateTime = new Date(`${tanggal}T${jamSelesai}:00`);

      const jamMulaiTerdepan = cart.reduce((min, item) => {
        const current = combineDateTime(tanggal, item.jammulai);
        const minTime = combineDateTime(tanggal, min.jammulai);
        return current < minTime ? item : min;
      }, cart[0]);

      const jamSelesaiTerakhir = cart.reduce((max, item) => {
        const current = combineDateTime(tanggal, item.jamselesai);
        const maxTime = combineDateTime(tanggal, max.jamselesai);
        return current > maxTime ? item : max;
      }, cart[0]);

      const jamMulaiFull = `${tanggal} ${jamMulaiTerdepan.jammulai}:00`;
      const jamSelesaiFull = `${tanggal} ${jamSelesaiTerakhir.jamselesai}:00`;

      console.log(jamMulaiFull)

      const netTotal = totalAsli - diskon +
        Math.round((totalAsli - diskon) * (ppnPercent / 100)) +
        Math.round((totalAsli - diskon) * (hiburanPercent / 100));

      const totalTax = Math.round((totalAsli - diskon) * (ppnPercent / 100));
      const totalPajakHiburan = Math.round((totalAsli - diskon) * (hiburanPercent / 100));

      let formData = {
        namaLengkap: nama,
        noTelp: telp,
        email: email,
        extraRequest: extra,
        voucherCode: voucherCode,
        totalAsli: totalAsli,
        totalDiskon: diskon,
        totalPembelian: netTotal,
        totalTax : totalTax,
        totalPajakHiburan : totalPajakHiburan,
        kodePartner: "{{ $company->KodePartner }}",
        jamMulai: jamMulaiFull,
        jamAkhir: jamSelesaiFull,
        detail : cart
      };
      // console.log(formData);

      PaymentGateWay($(this), 'Bayar', formData);
    });

    $('.video-card').on('click', function () {
        const videoUrl = $(this).data('video') + '?autoplay=1';
        $('#videoFrame').attr('src', videoUrl);
    });

    // Bersihkan iframe saat modal ditutup agar video berhenti
    $('#videoModal').on('hidden.bs.modal', function () {
        $('#videoFrame').attr('src', '');
    });

    $('#telpPelanggan').on('blur', function(){
      // console.log($('#telpPelanggan').val());
      $.ajax({
        url: '/api/pelanggan/viewJson',
        method: 'POST',
        contentType: 'application/json; charset=UTF-8',
        dataType: 'json',
        headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        data: JSON.stringify({
        KodePelanggan: "",
        GrupPelanggan: "",
        Search: "",
        NoTlp1: $('#telpPelanggan').val(),
        Email: $('#emailPelanggan').val(),
        RecordOwnerID: "{{ $company->KodePartner }}"
        })
    })
    .done(function (resp) {
        // Lihat bentuk data sebenarnya
        console.log('resp:', resp);

        const rows = resp && resp.data ? resp.data : [];
        if (rows.length) {
          const row = rows[0];
          $('#namaPelanggan').val(row.NamaPelanggan || '');
          $('#emailPelanggan').val(row.Email || '');
        } else {
          console.log('Tidak ada data pelanggan untuk nomor ini');
        }
    })
    .fail(function (xhr) {
        console.error('AJAX error:', xhr.responseText || xhr.statusText);
        modal.find('#btn-success').prop('disabled', true);
    });
    })
  });
</script>

</body>
<footer class="mt-5 py-4 bg-light border-top text-center text-md-start px-3 px-md-5" id="mainFooter">
  <div class="container">
    <div class="row">
      <!-- Company Info -->
      <div class="col-md-4 mb-3">
        <h6 class="fw-bold">{{ $company->NamaPartner }}</h6>
        <p class="small mb-1">{{ $company->AlamatTagihan }}</p>
      </div>

      <!-- Contact Info -->
      <div class="col-md-4 mb-3">
        <h6 class="fw-bold">Kontak Kami</h6>
        <p class="small mb-1"><i class="bi bi-telephone-fill me-1"></i> {{ $company->NoTlp }}</p>
        <p class="small mb-1"><i class="bi bi-whatsapp me-1"></i> {{ $company->NoHP }}</p>
        <p class="small mb-1"><i class="bi bi-envelope me-1"></i> {{ $userdata->email }}</p>
      </div>

      <!-- Copyright -->
      <div class="col-md-4 mb-3 text-md-end text-center">
        <div class="small text-muted">&copy; <span id="footerYear"> {{ $Tahun }} </span> {{ $company->NamaPartner }}. All rights reserved.</div>
      </div>
    </div>
  </div>
</footer>

</html>
