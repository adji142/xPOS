<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Queue System - PT. XYS</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://code.responsivevoice.org/responsivevoice.js?key=jn7RFIYJ"></script>
  <style>
    html, body {
      height: 100%;
      margin: 0;
      overflow: hidden;
      background-color: #f8f9fa;
      font-family: "Segoe UI", sans-serif;
    }

    header {
      background: #85bb65;
      color: #000;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 8px 20px;
      font-weight: bold;
      height: 60px;
      font-size: 1.4rem;
    }
    #clock {
      font-size: 1rem;
    }

    .main-container {
      display: grid;
      grid-template-rows: 65% 35%;
      grid-template-columns: 70% 30%;
      gap: 8px;
      height: calc(100vh - 60px);
      padding: 8px;
    }

    /* === SLIDER === */
    .slider-area {
      grid-row: 1 / 2;
      grid-column: 1 / 2;
      background: #000;
      overflow: hidden;
      position: relative;
      border-radius: 10px;
    }
    .slider-area img, .slider-area iframe {
      width: 100%;
      height: 100%;
      object-fit: contain;
    }
    .video-banner, .image-banner {
      width: 100%;
      height: 100%;
      display: none;
    }
    .video-banner.active, .image-banner.active {
      display: block;
    }

    /* === RIGHT PANEL === */
    .right-panel {
      grid-row: 1 / 2;
      grid-column: 2 / 3;
      display: flex;
      flex-direction: column;
      gap: 8px;
    }
    .box {
      flex: 1;
      display: flex;
      flex-direction: column;
      border-radius: 8px;
      overflow: hidden;
      background: #fff;
      box-shadow: 0 0 4px rgba(0,0,0,0.1);
    }
    .box-header {
      background: #85bb65;
      text-align: center;
      padding: 6px;
      font-size: 1.1rem;
      font-weight: bold;
    }
    .box-content {
      flex: 1;
      overflow-y: auto;
      font-size: 0.9rem;
    }

    /* === BOTTOM SECTION === */
    .bottom {
      grid-row: 2 / 3;
      grid-column: 1 / 3;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 8px;
    }
    .bottom-box {
      display: flex;
      flex-direction: column;
      border-radius: 8px;
      overflow: hidden;
      background: #fff;
      box-shadow: 0 0 4px rgba(0,0,0,0.1);
    }
    .bottom-header {
      background: #85bb65;
      text-align: center;
      padding: 6px;
      font-size: 1.1rem;
      font-weight: bold;
    }
    .bottom-content {
      flex: 1;
      overflow-y: auto;
      font-size: 0.9rem;
    }

    table {
      margin-bottom: 0 !important;
      font-size: 0.85rem;
    }

    .spoken-indicator {
      color: red;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <header>
    <h3 class="mb-0">QUEUE SYSTEM - {{ $company->NamaPartner }}</h3>
    <div id="clock"></div>
  </header>

  <div class="main-container">
    <!-- SLIDER AREA -->
    <div class="slider-area" id ="slides">
      @if(isset($oImageData) && count($oImageData) > 0)
        @foreach ($oImageData as $image)
          @if ($image['type'] === 'image')
            <div class="image-banner{{ $loop->first ? ' active' : '' }}">
              <img src="{{ $image['url'] }}" alt="Promo Image">
            </div>
          @endif
          {{-- @if ($image['type'] === 'video')
            <div class="video-banner{{ $loop->first ? ' active' : '' }}">
              <iframe id="ytplayer-{{ $loop->index }}" class="youtube-frame"
                src="{{ $image['url'] }}?enablejsapi=1&mute=1"
                frameborder="0" allow="autoplay" allowfullscreen></iframe>
            </div>
          @endif --}}
        @endforeach
      @endif
    </div>

    <!-- RIGHT PANEL -->
    <div class="right-panel">
      <div class="box">
        <div class="box-header">MEJA AKTIF</div>
        <div class="box-content" id="table-used"></div>
      </div>
      <div class="box">
        <div class="box-header">MEJA AVAILABLE</div>
        <div class="box-content" id="table-available"></div>
      </div>
    </div>

    <!-- BOTTOM SECTION -->
    <div class="bottom">
      <div class="bottom-box">
        <div class="bottom-header">MEJA HAMPIR HABIS</div>
        <div class="bottom-content" id="table-hampirHabis"></div>
      </div>
      <div class="bottom-box">
        <div class="bottom-header">BOOKING LIST</div>
        <div class="bottom-content" id="table-booking"></div>
      </div>
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
        console.log(`Activating slide ${i}`);

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
            console.log("Active slide is a video. Iframe:", iframe);
            console.log("Available YT Players:", ytPlayers);

            const player = ytPlayers.find(p => {
                const playerIframe = p.getIframe();
                console.log(`Comparing active iframe with player's iframe:`, iframe, playerIframe, iframe === playerIframe);
                return playerIframe === iframe;
            });

            console.log("Found player:", player);

            if (player && typeof player.playVideo === 'function') {
                console.log("Player found, attempting to mute and play.");
                player.mute();
                player.playVideo();
            } else {
                console.error("Player not found or is not a valid YT Player object.");
            }
        } else {
            console.log("Active slide is an image, setting auto-slide interval.");
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

        if (banners.length > 0) {
            activateSlide(0);
        }
    }

    if (document.querySelectorAll('.youtube-frame').length === 0) {
        if (banners.length > 0) {
            activateSlide(0);
        }
    }

    // === QUEUE DATA ===
    const lastSpokenMap={}, SPEAK_INTERVAL_MS=5*60*1000;
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
      responsiveVoice.speak(t,"Indonesian Female",{onend:cb});
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
        const pesan=`Perhatian. Meja ${r.NamaTitikLampu}, akan selesai pada jam ${r.JamSelesai}. Harap segera bersiap.`;
        lastSpokenMap[r.NamaTitikLampu]=now;
        speakWithResponsiveVoice(pesan,()=>{i++;speakNext();});
      }
      speakNext();
    };

    function updateTables(data){
        const hampirHabisHTML = `<table class="table table-bordered text-center">
        <thead class="table-danger"><tr><th colspan="4">Hampir Habis</th></tr><tr><th>Nama Meja</th><th>Jam Mulai</th><th>Jam Selesai</th><th>Sisa Waktu</th></tr></thead>
        <tbody>${data.hampirHabisTable.map(row => {
            const sisa = getSisaWaktu(row.JamSelesai);
            const icon = lastSpokenMap[row.NamaTitikLampu] ? ` <span class="spoken-indicator">🔊</span>` : '';
            return `<tr><td>${row.NamaTitikLampu}</td><td>${row.JamMulai}</td><td>${row.JamSelesai}</td><td>${sisa}${icon}</td></tr>`;
        }).join('')}</tbody></table>`;

        const usedHTML = `<table class="table table-bordered text-center">
        <thead class="table-warning"><tr><th colspan="4">Sedang Digunakan</th></tr><tr><th>Nama Meja</th><th>Jam Mulai</th><th>Jam Selesai</th><th>Sisa Waktu</th></tr></thead>
        <tbody>${data.usedTable.map(row => {
            const sisa = getSisaWaktu(row.JamSelesai);
            return `<tr><td>${row.NamaTitikLampu}</td><td>${row.JamMulai}</td><td>${row.JamSelesai}</td><td>${sisa}</td></tr>`;
        }).join('')}</tbody></table>`;

        const availableHTML = `<table class="table table-bordered text-center">
        <thead class="table-success"><tr><th>Meja Tersedia</th></tr></thead>
        <tbody>${data.availableTable.map(row => `<tr><td>${row.NamaTitikLampu}</td></tr>`).join('')}</tbody></table>`;

        document.getElementById('table-hampirHabis').innerHTML = hampirHabisHTML;
        document.getElementById('table-used').innerHTML = usedHTML;
        document.getElementById('table-available').innerHTML = availableHTML;

        speakQueueInIndonesian(data.hampirHabisTable);
    }

    function fetchQueueData(){
      const RecordOwnerID="<?php echo $idE ?>";
      $.ajax({
        url:"{{ route('queue-getData') }}",
        method:"POST",
        headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'},
        data:{RecordOwnerID},
        success:updateTables,
        error:e=>console.error("Gagal ambil data antrian:",e)
      });
    }
    setInterval(fetchQueueData,10000);
    fetchQueueData();


  </script>
</body>
</html>
