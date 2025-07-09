<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Queue Display</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://code.responsivevoice.org/responsivevoice.js?key=jn7RFIYJ"></script>
  <style>
    html, body {
      height: 100%;
      margin: 0;
      overflow: hidden;
    }
    .left-panel {
      height: 100vh;
      overflow: hidden;
    }
    .scrolling-content {
      height: 100%;
      overflow-y: auto;
      scroll-behavior: smooth;
    }
    .right-panel {
      height: 100vh;
      padding: 0;
    }
    .video-banner iframe, .image-banner img {
      width: 100%;
      height: 100%;
      object-fit: contain;
    }
    .video-banner, .image-banner {
      display: none;
      height: 100%;
    }
    .video-banner.active, .image-banner.active {
      display: block;
    }
    .spoken-indicator {
      color: red;
      font-weight: bold;
    }
  </style>
</head>
<body>
<div class="container-fluid">
  <div class="row">
    <!-- LEFT PANEL -->
    <div class="col-md-5 bg-white left-panel">
      <div class="scrolling-content py-3" id="scrollArea">
        <div id="table-hampirHabis"></div>
        <div id="table-used"></div>
        <div id="table-available"></div>
      </div>
    </div>

    <!-- RIGHT PANEL -->
    <div class="col-md-7 p-0 right-panel">
      @if (isset($oImageData) && count($oImageData) > 0)
        @foreach ($oImageData as $image)
          @if ($image['type'] === 'image')
            <div class="image-banner{{ $loop->first ? ' active' : '' }}">
              <img src="{{ $image['url'] }}" alt="Promo Image">
            </div>
          @endif
          @if ($image['type'] === 'video')
            <div class="video-banner{{ $loop->first ? ' active' : '' }}">
              <iframe class="youtube-frame"
                      src="{{ $image['url'] }}?enablejsapi=1"
                      frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
            </div>
          @endif
        @endforeach
      @endif
    </div>
  </div>
</div>

<script src="https://www.youtube.com/iframe_api"></script>
<script>
  const scrollArea = document.getElementById('scrollArea');
  let pauseAtBottom = false;

  const banners = document.querySelectorAll('.right-panel > div');
  let index = 0;
  let autoSlideInterval = null;
  let ytPlayers = [];

  const lastSpokenMap = {}; // NamaTitikLampu => timestamp terakhir dibacakan
  const SPEAK_INTERVAL_MS = 5 * 60 * 1000; // 5 menit

  function scrollLoop() {
    if (pauseAtBottom) return;
    scrollArea.scrollTop += 1;
    const scrollBottom = Math.ceil(scrollArea.scrollTop + scrollArea.clientHeight);
    const scrollHeight = Math.ceil(scrollArea.scrollHeight);
    if (scrollBottom >= scrollHeight) {
      pauseAtBottom = true;
      setTimeout(() => {
        scrollArea.scrollTop = 0;
        pauseAtBottom = false;
      }, 50000);
    }
  }
  setInterval(scrollLoop, 50);

  function activateSlide(i) {
    banners.forEach((b, j) => b.classList.toggle('active', j === i));
    const iframe = banners[i].querySelector('iframe');
    if (iframe && ytPlayers[i]) ytPlayers[i].playVideo();
  }

  function nextSlide() {
    index = (index + 1) % banners.length;
    activateSlide(index);
  }

  function startAutoSlide() {
    clearInterval(autoSlideInterval);
    autoSlideInterval = setInterval(() => {
      const active = banners[index];
      if (!active.classList.contains('video-banner')) {
        nextSlide();
      }
    }, 5000);
  }

  function onYouTubeIframeAPIReady() {
    document.querySelectorAll('.youtube-frame').forEach((iframe, i) => {
      ytPlayers[i] = new YT.Player(iframe, {
        events: {
          'onReady': () => {
            if (i === 0) {
              activateSlide(index);
              startAutoSlide();
            }
          },
          'onStateChange': (event) => {
            if (event.data === YT.PlayerState.ENDED) {
              nextSlide();
            }
          }
        }
      });
    });
  }

  function getSisaWaktu(jamSelesai) {
    const now = new Date();
    const end = new Date();
    const [jam, menit] = jamSelesai.split(':').map(Number);
    end.setHours(jam, menit, 0, 0);
    const diff = (end - now) / 1000;
    if (diff < 0) return "00:00";
    const m = Math.floor(diff / 60);
    const s = Math.floor(diff % 60);
    return `${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
  }

  function getSisaMenit(jamSelesai) {
    const now = new Date();
    const end = new Date();
    const [jam, menit] = jamSelesai.split(':').map(Number);
    end.setHours(jam, menit, 0, 0);
    return Math.floor((end - now) / 60000);
  }

  function speakWithResponsiveVoice(text, callback) {
    responsiveVoice.speak(text, "Indonesian Female", { onend: callback });
  }

  function speakQueueInIndonesian(queueList) {
    const now = Date.now();
    const filtered = queueList.filter(row => {
      const menit = getSisaMenit(row.JamSelesai);
      const lastSpoken = lastSpokenMap[row.NamaTitikLampu] || 0;
      return menit < 10 && menit >= 0 && (now - lastSpoken > SPEAK_INTERVAL_MS);
    });

    if (filtered.length === 0) return;

    let index = 0;
    function speakNext() {
      if (index >= filtered.length) return;
      const row = filtered[index];
      const pesan = `Perhatian. Meja ${row.NamaTitikLampu}, akan selesai pada jam ${row.JamSelesai}. Harap segera bersiap.`;
      lastSpokenMap[row.NamaTitikLampu] = now;
      speakWithResponsiveVoice(pesan, () => {
        index++;
        speakNext();
      });
    }

    speakNext();
  }

  function updateTables(data) {
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

  function fetchQueueData() {
    const RecordOwnerID = "<?php echo $idE ?>";
    $.ajax({
      url: "{{ route('queue-getData') }}",
      method: 'POST',
      headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
      data: { RecordOwnerID },
      success: updateTables,
      error: function(xhr) {
        console.error("Gagal ambil data antrian:", xhr);
      }
    });
  }

  // Inisialisasi
  setInterval(fetchQueueData, 10000);
  fetchQueueData();
</script>
</body>
</html>
