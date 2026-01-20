<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Queue System - PT. XYS</title>
  <!-- Google Fonts: Poppins -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://code.responsivevoice.org/responsivevoice.js?key=jn7RFIYJ"></script>
  <style>
    :root {
      --bg-color: #1e1e2f;
      --card-bg: #27293d;
      --text-main: #ffffff;
      --text-muted: #9a9a9a;
      --accent-active: linear-gradient(45deg, #1d8cf8, #3358f4);
      --accent-warning: linear-gradient(45deg, #fd5d93, #ec250d);
      --accent-success: linear-gradient(45deg, #00f2c3, #0098f0);
      --header-bg: #27293d;
      --border-radius: 12px;
    }

    html, body {
      height: 100%;
      margin: 0;
      overflow: hidden;
      background-color: var(--bg-color);
      font-family: 'Poppins', sans-serif;
      color: var(--text-main);
      display: flex;
      flex-direction: column;
    }

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

    /* === GRID CONTAINER === */
    .main-grid {
      display: grid;
      grid-template-columns: 1fr 1fr 1fr;
      grid-template-rows: 30% 30% 1fr;
      gap: 15px;
      padding: 15px;
      flex: 1;
      overflow: hidden;
    }

    /* === CARD STYLES === */
    .grid-box {
      background: var(--card-bg);
      border-radius: var(--border-radius);
      display: flex;
      flex-direction: column;
      overflow: hidden;
      box-shadow: 0 1px 20px 0px rgba(0,0,0,0.1);
      position: relative;
    }

    .box-header {
      padding: 15px;
      font-weight: 600;
      text-align: center;
      font-size: 1.3rem;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .box-content {
      flex: 1;
      overflow-y: auto;
      padding: 0;
    }
    
    /* Custom Scrollbar */
    .box-content::-webkit-scrollbar {
      width: 6px;
    }
    .box-content::-webkit-scrollbar-track {
      background: rgba(255, 255, 255, 0.05);
    }
    .box-content::-webkit-scrollbar-thumb {
      background: rgba(255, 255, 255, 0.1);
      border-radius: 3px;
    }
    .box-content::-webkit-scrollbar-thumb:hover {
      background: rgba(255, 255, 255, 0.2);
    }


    /* === SECTION COLORS === */
    .area-active .box-header {
      background: var(--accent-active);
      color: white;
    }
    
    .area-booking .box-header {
      background: #344675; /* Neural dark blue */
      color: white;
    }

    .area-hampir-habis .box-header {
      background: var(--accent-warning);
      color: white;
    }

    .area-available .box-header {
      background: var(--accent-success);
      color: white;
    }

    /* === GRID PLACEMENT === */
    .area-active { grid-column: 1 / 2; grid-row: 1 / 3; }
    .area-booking { grid-column: 2 / 3; grid-row: 1 / 3; }
    .area-promo {
      grid-column: 3 / 4;
      grid-row: 1 / 2;
      background: #000;
    }
    .area-hampir-habis { grid-column: 1 / 3; grid-row: 3 / 4; }
    .area-available { grid-column: 3 / 4; grid-row: 2 / 4; }

    /* === TABLE STYLES === */
    .custom-table {
      width: 100%;
      border-collapse: collapse;
      color: var(--text-muted);
    }
    .custom-table th, .custom-table td {
      padding: 12px 15px;
      text-align: left;
      border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }
    .custom-table th {
      color: var(--text-main);
      font-weight: 600;
      text-transform: uppercase;
      font-size: 0.85rem;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }
    .custom-table tbody tr {
      transition: background 0.3s;
    }
    .custom-table tbody tr:hover {
      background: rgba(255, 255, 255, 0.03);
    }

    /* === HELPERS === */
    .text-highlight { color: #fff; font-weight: 500; }
    .time-badge {
      font-family: 'Courier New', monospace;
      font-weight: bold;
      letter-spacing: -0.5px;
    }

    /* === SLIDER === */
    .slider-area img, .slider-area iframe {
      width: 100%; height: 100%; object-fit: contain;
    }
    .video-banner, .image-banner {
      width: 100%; height: 100%; display: none;
      position: absolute; top: 0; left: 0;
    }
    .video-banner.active, .image-banner.active { display: block; }

    /* === ANIMATION === */
    .fade-in {
      animation: fadeIn 0.5s ease-in;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    .spoken-indicator {
      color: #ff8d72;
      font-weight: bold;
      animation: pulse 1.5s infinite;
    }
    @keyframes pulse { 0% { opacity: 0.5; } 50% { opacity: 1; scale: 1.2; } 100% { opacity: 0.5; } }

    /* === NEW ADDITIONS === */
    .company-logo {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 15px;
    }
    .header-left {
        display: flex;
        align-items: center;
    }
    
    .running-text-strip {
        margin: 5px 15px 0 15px;
        padding: 5px 15px;
        background: rgba(39, 41, 61, 0.8);
        border-radius: var(--border-radius);
        color: lime; /* High contrast on dark */
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        display: flex;
        align-items: center;
        overflow: hidden;
    }

    .blinking-text {
        width: 100%;
        text-align: center;
        font-weight: bold;
        font-size: 1.1rem;
        animation: blink 1.5s infinite;
    }
    @keyframes blink { 
        0% { opacity: 1; }
        50% { opacity: 0; }
        100% { opacity: 1; }
    }
  </style>
</head>
<body>

  <!-- HEADER -->
  <header>
    <div class="header-left">
        @if(!empty($company->icon))
            <img src="{{ $company->icon }}" alt="Logo" class="company-logo">
        @else
            <img src="https://via.placeholder.com/50" alt="Logo" class="company-logo">
        @endif
        <div id="company-name">
           {{ $company->NamaPartner ?? 'Company Name' }}
        </div>
    </div>
    <div class="d-flex align-items-center gap-3">
        <div id="clock">--:--:--</div>
        <button onclick="toggleFullscreen()" class="btn btn-sm btn-outline-light" title="Fullscreen">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"></path>
            </svg>
        </button>
    </div>
  </header>

  <div class="running-text-strip">
     <div class="blinking-text">
        <marquee>{{ $company->RunningTextSelfServices ?? 'Selamat Datang' }}</marquee>
     </div>
  </div>

  <!-- MAIN GRID -->
  <div class="main-grid">
    
    <!-- MEJA AKTIF -->
    <div class="grid-box area-active">
      <div class="box-header">Layanan Aktif</div>
      <div class="box-content" id="table-used"></div>
    </div>

    <!-- BOOKING LIST -->
    <div class="grid-box area-booking">
      <div class="box-header">Booking List</div>
      <div class="box-content" id="table-booking">
         <div class="d-flex justify-content-center align-items-center h-100">
             <i>Belum ada booking</i>
         </div>
      </div>
    </div>

    <!-- PROMOSI -->
    <div class="grid-box area-promo slider-area" id="slides">
      @if(isset($oImageData) && count($oImageData) > 0)
        @foreach ($oImageData as $image)
          @if ($image['type'] === 'image')
            <div class="image-banner{{ $loop->first ? ' active' : '' }}">
              <img src="{{ $image['url'] }}" alt="Promo">
            </div>
          @endif
           @if ($image['type'] === 'video')
            <div class="video-banner{{ $loop->first ? ' active' : '' }}">
              <iframe id="ytplayer-{{ $loop->index }}" class="youtube-frame"
                src="{{ $image['url'] }}?enablejsapi=1&mute=1"
                frameborder="0" allow="autoplay" allowfullscreen></iframe>
            </div>
          @endif 
        @endforeach
      @else
        <div class="d-flex justify-content-center align-items-center h-100 text-muted">PROMOSI</div>
      @endif
    </div>

    <!-- MEJA HAMPIR HABIS -->
    <div class="grid-box area-hampir-habis">
      <div class="box-header">Layanan Hampir Habis</div>
      <div class="box-content" id="table-hampirHabis"></div>
    </div>

    <!-- MEJA AVAILABLE -->
    <div class="grid-box area-available">
      <div class="box-header">Layanan Available Hari ini</div>
      <div class="box-content" id="table-available"></div>
    </div>

  </div>

  <script src="https://www.youtube.com/iframe_api"></script>
  <script>
    // === JAM ===
    function updateClock(){
      const n=new Date();
      document.getElementById('clock').innerText =
        `${String(n.getDate()).padStart(2,'0')}-${String(n.getMonth()+1).padStart(2,'0')}-${n.getFullYear()} `
        +`${String(n.getHours()).padStart(2,'0')}:${String(n.getMinutes()).padStart(2,'0')}:${String(n.getSeconds()).padStart(2,'0')}`;
    }
    setInterval(updateClock,1000);updateClock();

    // === SLIDER ===
    const banners = document.querySelectorAll('.slider-area > div');
    let index = 0;
    let autoSlideInterval;
    const ytPlayers = [];

    function activateSlide(i) {
        if (!banners.length || i === undefined) return;
        
        const oldBanner = banners[index];
        if (oldBanner && oldBanner.classList.contains('video-banner')) {
            const oldIframe = oldBanner.querySelector('iframe');
            const player = ytPlayers.find(p => p.getIframe() === oldIframe);
            if (player && typeof player.stopVideo === 'function') {
                player.stopVideo();
            }
        }

        index = i;
        banners.forEach((b, j) => b.classList.toggle('active', j === i));
        
        const activeBanner = banners[index];
        if (!activeBanner) return;

        const isVideo = activeBanner.classList.contains('video-banner');
        clearInterval(autoSlideInterval);

        if (isVideo) {
            const iframe = activeBanner.querySelector('iframe');
            const player = ytPlayers.find(p => p.getIframe() === iframe);
            if (player && typeof player.playVideo === 'function') {
                player.mute();
                player.playVideo();
            }
        } else {
            autoSlideInterval = setInterval(nextSlide, 8000);
        }
    }

    function nextSlide() {
        if (!banners.length) return;
        let nextIndex = (index + 1) % banners.length;
        activateSlide(nextIndex);
    }

    function onYouTubeIframeAPIReady() {
        document.querySelectorAll('.youtube-frame').forEach((iframe) => {
            const player = new YT.Player(iframe, {
                events: {
                    'onStateChange': (e) => {
                        if (e.data === YT.PlayerState.ENDED) {
                            nextSlide();
                        }
                    }
                }
            });
            ytPlayers.push(player);
        });

        if (banners.length > 0) activateSlide(0);
    }
    
    // Fallback if API ready trigger is missed or not needed immediately
    if (document.querySelectorAll('.youtube-frame').length === 0 && banners.length > 0) {
        activateSlide(0);
    }


    // === QUEUE DATA ===
    const lastSpokenMap={}, SPEAK_INTERVAL_MS=5*60*1000;
    
    const formatDate = (dateStr) => {
      if (!dateStr) return '-';
      const d = new Date(dateStr);
      if (isNaN(d.getTime())) return dateStr; // Fallback if invalid
      const day = String(d.getDate()).padStart(2, '0');
      const month = String(d.getMonth() + 1).padStart(2, '0');
      const year = String(d.getFullYear()).slice(-2);
      return `${day}-${month}-${year}`;
    };
    
    const getSisaWaktu=(jamSelesai)=>{
      const n=new Date(),e=new Date(),[h,m]=jamSelesai.split(':').map(Number);
      e.setHours(h,m,0,0);const d=(e-n)/1000;if(d<0)return"00:00";
      const mm=Math.floor(d/60),ss=Math.floor(d%60);
      return `${mm.toString().padStart(2,'0')}:${ss.toString().padStart(2,'0')}`;
    };
    
    const getSisaMenit=(jamSelesai)=>{
      const n=new Date(),e=new Date(),[h,m]=jamSelesai.split(':').map(Number);
      e.setHours(h,m,0,0);
      return Math.floor((e-n)/60000);
    };

    const speakWithResponsiveVoice=(t,cb)=>{
      if(window.responsiveVoice) {
         responsiveVoice.speak(t,"Indonesian Female",{onend:cb});
      } else {
         if(cb) cb();
      }
    };
    
    const speakQueueInIndonesian=(list)=>{
      const now=Date.now();
      const f=list.filter(r=>{
        const menit=getSisaMenit(r.JamSelesai);
        const last=lastSpokenMap[r.NamaTitikLampu]||0;
        return menit<10&&menit>=0&&(now-last>SPEAK_INTERVAL_MS);
      });
      if(!f.length)return;
      let i=0;function speakNext(){
        if(i>=f.length)return;
        const r=f[i];
        const pesan=`Perhatian. Layanan ${r.NamaTitikLampu}, akan selesai pada jam ${r.JamSelesai}. Harap segera bersiap.`;
        lastSpokenMap[r.NamaTitikLampu]=now;
        speakWithResponsiveVoice(pesan,()=>{i++;speakNext();});
      }
      speakNext();
    };

    function updateTables(data){
        // Modern Table Markup
        const createTable = (rows, type) => {
             if(!rows || rows.length === 0) return `<div class="d-flex justify-content-center align-items-center h-100"><i>${type === 'booking' ? 'Tidak ada booking' : 'Tidak ada data'}</i></div>`;
             
             let headers = '';
             if(type === 'active') headers = `<tr><th>Layanan</th><th>Nama Pelanggan</th><th>Selesai</th><th>Sisa</th></tr>`;
             if(type === 'warn') headers = `<tr><th>Layanan</th><th>Nama Pelanggan</th><th>Mulai</th><th>Selesai</th><th>Sisa</th></tr>`;
             if(type === 'avail') headers = `<tr><th>Layanan Available</th></tr>`;
             if(type === 'booking') headers = `<tr><th>No Transaksi</th><th>Nama Pelanggan</th><th>Layanan</th><th>Mulai</th><th>Selesai</th></tr>`;
             
             const body = rows.map(row => {
                 const sisa = row.JamSelesai ? getSisaWaktu(row.JamSelesai) : '';
                 let content = '';
                 
                 if(type === 'active') {
                     content = `<td><span class="text-highlight">${row.NamaTitikLampu}</span></td>
                                <td>${row.NamaPelanggan || '-'}</td>
                                <td>${row.JamSelesai}</td>
                                <td><span class="time-badge">${sisa}</span></td>`;
                 } else if(type === 'warn') {
                     const icon = lastSpokenMap[row.NamaTitikLampu] ? ` <span class="spoken-indicator">🔊</span>` : '';
                     content = `<td><span class="text-highlight">${row.NamaTitikLampu}</span></td>
                                <td>${row.NamaPelanggan || '-'}</td>
                                <td>${row.JamMulai}</td>
                                <td>${row.JamSelesai}</td>
                                <td><span class="time-badge text-warning">${sisa}${icon}</span></td>`;
                 } else if(type === 'avail') {
                     content = `<td><span class="text-highlight">${row.NamaTitikLampu}</span></td>`;
                 } else if(type === 'booking') {
                     content = `<td>${formatDate(row.TglTransaksi)}</td>
                                <td>${row.NamaPelanggan}</td>
                                <td>${row.NamaTitikLampu}</td>
                                <td>${row.JamMulai}</td>
                                <td>${row.JamSelesai}</td>`;
                 }
                 
                 return `<tr class="fade-in">${content}</tr>`;
             }).join('');
             
             return `<table class="custom-table"><thead>${headers}</thead><tbody>${body}</tbody></table>`;
        };

        document.getElementById('table-hampirHabis').innerHTML = createTable(data.hampirHabisTable, 'warn');
        document.getElementById('table-used').innerHTML = createTable(data.usedTable, 'active');
        document.getElementById('table-available').innerHTML = createTable(data.availableTable, 'avail');
        document.getElementById('table-booking').innerHTML = createTable(data.bookingTable, 'booking');
        
        // Voice trigger
        if(data.hampirHabisTable) speakQueueInIndonesian(data.hampirHabisTable);
    }

    function fetchQueueData(){
      const RecordOwnerID="<?php echo $idE; ?>"; 
      $.ajax({
        url:"{{ route('queue-getData') }}",
        method:"POST",
        headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'},
        data:{RecordOwnerID},
        success:updateTables,
        error:e=>console.error("Fetch error:",e)
      });
    }
    
    
    function toggleFullscreen() {
      if (!document.fullscreenElement) {
        document.documentElement.requestFullscreen();
      } else {
        if (document.exitFullscreen) {
          document.exitFullscreen();
        }
      }
    }

    fetchQueueData();
    setInterval(fetchQueueData,10000);

  </script>
</body>
</html>
