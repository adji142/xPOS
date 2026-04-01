<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Kitchen Information - xPOS</title>
  <!-- Google Fonts: Poppins -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <style>
    :root {
      --bg-color: {{ ($company && $company->TypeKitchenBackgraund == 'Color') ? ($company->KitchenBackgraund ?? '#1e1e2f') : '#1e1e2f' }};
      --card-bg: #27293d;
      --text-main: #ffffff;
      --text-muted: #9a9a9a;
      --accent-active: linear-gradient(45deg, #1d8cf8, #3358f4);
      --accent-success: linear-gradient(45deg, #00f2c3, #0098f0);
      --header-bg: #27293d;
      --border-radius: 12px;
    }

    html, body {
      height: 100%;
      margin: 0;
      background-color: var(--bg-color);
      @if($company && $company->TypeKitchenBackgraund == 'Image' && !empty($company->KitchenBackgraund))
      background-image: url('{{ $company->KitchenBackgraund }}');
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
      background-repeat: no-repeat;
      @endif
      font-family: 'Poppins', sans-serif;
      color: var(--text-main);
      display: flex;
      flex-direction: column;
      position: relative;
    }

    @if($company && $company->TypeKitchenBackgraund == 'Image' && !empty($company->KitchenBackgraund))
    body::before {
        content: "";
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.4);
        z-index: 0;
    }
    header, .filter-section, .content-area {
        position: relative;
        z-index: 1;
    }
    @endif

    /* === HEADER === */
    header {
      background: var(--header-bg);
      margin: 15px 15px 0 15px;
      padding: 15px 25px;
      border-radius: var(--border-radius);
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-shrink: 0;
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    
    #company-name {
      font-size: 1.8rem;
      font-weight: 700;
      letter-spacing: 0.5px;
    }
    
    #clock {
      font-size: 1.2rem;
      font-weight: 400;
      color: var(--text-muted);
    }

    .filter-section {
        margin: 10px 15px;
        display: flex;
        gap: 15px;
        align-items: center;
    }

    .form-select {
        background-color: var(--card-bg);
        color: white;
        border: 1px solid #444;
        border-radius: 8px;
        width: 300px;
    }

    .form-select:focus {
        background-color: var(--card-bg);
        color: white;
        border-color: #1d8cf8;
        box-shadow: 0 0 0 0.25rem rgba(29, 140, 248, 0.25);
    }

    /* === MAIN CONTENT === */
    .content-area {
        flex: 1;
        padding: 15px;
        overflow-y: auto;
    }

    .kitchen-card {
        background: var(--card-bg);
        border-radius: var(--border-radius);
        padding: 15px;
        margin-bottom: 15px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        border-left: 5px solid #1d8cf8;
        transition: transform 0.2s;
    }

    .kitchen-card:hover {
        transform: scale(1.01);
    }

    .item-name {
        font-size: 1.4rem;
        font-weight: 600;
        color: #00f2c3;
    }

    .item-detail {
        font-size: 1rem;
        color: var(--text-muted);
    }

    .item-qty {
        font-size: 1.5rem;
        font-weight: 700;
        color: #fff;
        background: rgba(29, 140, 248, 0.2);
        padding: 5px 15px;
        border-radius: 20px;
    }

    .table-name {
        font-size: 1.1rem;
        font-weight: 600;
        color: #fd5d93;
    }

    .btn-print {
        background: linear-gradient(45deg, #f3a641, #ef8157);
        border: none;
        color: white;
        padding: 5px 12px;
        border-radius: 8px;
        font-size: 0.9rem;
        transition: all 0.3s;
    }

    .btn-print:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(239, 129, 87, 0.4);
        color: white;
    }

    .btn-print:disabled {
        opacity: 0.7;
        transform: none;
    }

    /* === HELPERS === */
    .fade-in {
      animation: fadeIn 0.5s ease-in;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .empty-state {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        height: 60vh;
        color: var(--text-muted);
    }

    .item-row {
        padding: 8px 0;
        border-bottom: 1px solid #333;
    }

    .item-row:last-child {
        border-bottom: none;
    }
  </style>
</head>
<body>

  <!-- HEADER -->
  <header>
    <div id="company-name">INFO KITCHEN</div>
    <div class="d-flex align-items-center gap-3">
        <div id="clock">--:--:--</div>
    </div>
  </header>

  <div class="filter-section flex-wrap">
      <div class="d-flex align-items-center gap-2">
          <label for="categoryFilter" class="form-label mb-0">Kelompok Item:</label>
          <select id="categoryFilter" class="form-select" style="width: 200px;">
              <option value="">Semua Kategori</option>
              @foreach($jenisItems as $jenis)
                <option value="{{ $jenis->KodeJenis }}">{{ $jenis->NamaJenis }}</option>
              @endforeach
          </select>
      </div>
      <div class="d-flex align-items-center gap-2">
          <label for="tableFilter" class="form-label mb-0">Meja:</label>
          <select id="tableFilter" class="form-select" style="width: 200px;">
              <option value="">Semua Meja</option>
              @foreach($tables as $table)
                <option value="{{ $table->id }}">{{ $table->NamaTitikLampu }}</option>
              @endforeach
          </select>
      </div>
      <div class="d-flex align-items-center gap-2">
          <label for="dateFilter" class="form-label mb-0">Tanggal:</label>
          <input type="date" id="dateFilter" class="form-select" style="width: 160px;" value="{{ date('Y-m-d') }}">
      </div>
      <div class="ms-md-auto">
          <div class="input-group">
              <span class="input-group-text bg-dark border-secondary text-light"><i class="bi bi-search"></i></span>
              <input type="text" id="searchInput" class="form-control bg-dark border-secondary text-light" placeholder="Cari No. Trx, Nama Item, Kode Item..." style="border-radius: 0 8px 8px 0; width: 250px;">
          </div>
      </div>
  </div>

  <div class="content-area" id="kitchenContent">
      <div class="empty-state">
          <div class="spinner-border text-primary mb-3" role="status"></div>
          <p>Memuat data pesanan...</p>
      </div>
  </div>

  <script>
    // === JAM ===
    function updateClock(){
      const n=new Date();
      document.getElementById('clock').innerText =
        `${String(n.getDate()).padStart(2,'0')}-${String(n.getMonth()+1).padStart(2,'0')}-${n.getFullYear()} `
        +`${String(n.getHours()).padStart(2,'0')}:${String(n.getMinutes()).padStart(2,'0')}:${String(n.getSeconds()).padStart(2,'0')}`;
    }
    setInterval(updateClock,1000);updateClock();

    let currentFilter = '';
    let currentTable = '';
    let currentSearch = '';
    let currentDate = $('#dateFilter').val();

    $('#categoryFilter').on('change', function() {
        currentFilter = $(this).val();
        fetchKitchenData();
    });

    $('#tableFilter').on('change', function() {
        currentTable = $(this).val();
        fetchKitchenData();
    });

    $('#searchInput').on('keyup', function() {
        currentSearch = $(this).val();
        fetchKitchenData();
    });

    $('#dateFilter').on('change', function() {
        currentDate = $(this).val();
        fetchKitchenData();
    });

    function fetchKitchenData() {
        $.ajax({
            url: "{{ route('infokitchen-data') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                RecordOwnerID: "{{ Auth::user()->RecordOwnerID }}",
                KodeJenisItem: currentFilter,
                tableid: currentTable,
                searchTerm: currentSearch,
                tgl: currentDate
            },
            success: function(data) {
                renderKitchenData(data);
            },
            error: function(err) {
                console.error("Error fetching kitchen data:", err);
            }
        });
    }

    function renderKitchenData(items) {
        const container = $('#kitchenContent');
        if (items.length === 0) {
            container.html(`
                <div class="empty-state">
                    <p>Tidak ada pesanan aktif saat ini.</p>
                </div>
            `);
            return;
        }

        // Group items by NoTransaksi
        const groupedItems = {};
        items.forEach(item => {
            if (!groupedItems[item.NoTransaksi]) {
                groupedItems[item.NoTransaksi] = {
                    NoTransaksi: item.NoTransaksi,
                    NamaTitikLampu: item.NamaTitikLampu || 'Take Away',
                    TglTransaksi: item.TglTransaksi,
                    created_at: item.created_at,
                    details: []
                };
            }
            groupedItems[item.NoTransaksi].details.push(item);
        });

        let html = '<div class="row">';
        Object.values(groupedItems).forEach(group => {
            html += `
                <div class="col-md-6 col-lg-4">
                    <div class="kitchen-card fade-in">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                             <div class="table-name">TABLE: ${group.NamaTitikLampu}</div>
                             <div class="d-flex align-items-center gap-2">
                                <button class="btn btn-print btn-sm" onclick="printOrder('${group.NoTransaksi}', this)">
                                    <i class="bi bi-printer"></i> Print
                                </button>
                                <div class="item-detail">${group.NoTransaksi}</div>
                             </div>
                        </div>
                        <hr style="border-color: #444; margin-top: 5px; margin-bottom: 10px;">
                        <div class="order-items">
                            ${group.details.map(item => `
                                <div class="item-row d-flex justify-content-between align-items-center">
                                    <div style="flex: 1;">
                                        <div class="item-name" style="font-size: 1.1rem;">${item.NamaItem}</div>
                                        <div class="brand-text text-info" style="font-size: 0.8rem;">${item.NamaJenis || ''}</div>
                                    </div>
                                    <div class="item-qty me-3" style="font-size: 1.1rem; padding: 2px 10px;">x${item.Qty}</div>
                                    <button class="btn btn-success btn-sm px-3" onclick="markItemDone('${item.NoTransaksi}', '${item.LineNumber}')">
                                        <i class="bi bi-check2"></i>
                                    </button>
                                </div>
                            `).join('')}
                        </div>
                        <div class="item-detail text-end mt-2" style="font-size: 0.75rem">
                            Ordered at: ${group.created_at}
                        </div>
                    </div>
                </div>
            `;
        });
        html += '</div>';
        container.html(html);
    }

    function markItemDone(noTrx, lineNo) {
        if(!confirm('Tandai pesanan ini sudah selesai?')) return;

        $.ajax({
            url: "{{ route('infokitchen-markdone') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                RecordOwnerID: "{{ Auth::user()->RecordOwnerID }}",
                NoTransaksi: noTrx,
                LineNumber: lineNo
            },
            success: function(response) {
                if (response.success) {
                    fetchKitchenData();
                } else {
                    alert('Gagal: ' + response.message);
                }
            },
            error: function(err) {
                console.error("Error marking as done:", err);
            }
        });
    }

    function printOrder(noTrx, btn) {
        const url = "{{ route('infokitchen-print') }}?NoTransaksi=" + noTrx;
        window.open(url, '_blank', 'width=400,height=600');
    }

    // Initial fetch
    fetchKitchenData();

    // Auto refresh every 10 seconds
    setInterval(fetchKitchenData, 10000);

  </script>
</body>
</html>
