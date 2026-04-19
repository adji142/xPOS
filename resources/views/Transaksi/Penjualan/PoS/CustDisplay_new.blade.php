<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Customer Display | {{ $company->NamaPartner }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="{{ asset('css/style.css?v=1.0')}}" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    
    <!-- Midtrans Snap -->
    @if(env('MIDTRANS_IS_PRODUCTION', false))
        <script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY', '') }}"></script>
    @else
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY', '') }}"></script>
    @endif
    <style>
        :root {
            --primary-color: #5867dd;
            --bg-color: #f4f7f6;
            --card-bg: #ffffff;
            --text-main: #333333;
            --text-muted: #777777;
        }

        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-color);
            overflow: hidden;
        }

        .display-wrapper {
            display: flex;
            height: 100vh;
            width: 100vw;
        }

        /* Left Side: Promotional Slider */
        .promo-side {
            flex: 1.2;
            background: #000;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Right Side: Billing Details */
        .billing-side {
            flex: 0.8;
            background: var(--card-bg);
            display: flex;
            flex-direction: column;
            box-shadow: -5px 0 15px rgba(0,0,0,0.05);
            z-index: 10;
        }

        .billing-header {
            padding: 30px;
            border-bottom: 1px solid #eee;
            text-align: center;
        }

        .billing-header .logo img {
            max-height: 60px;
            margin-bottom: 10px;
        }

        .billing-header h2 {
            margin: 0;
            font-weight: 700;
            color: var(--primary-color);
            letter-spacing: -0.5px;
        }

        .billing-content {
            flex-grow: 1;
            padding: 20px;
            overflow-y: auto;
        }

        .billing-footer {
            padding: 30px;
            background: #fdfdfd;
            border-top: 1px solid #eee;
        }

        /* Slider Styles */
        .slider-container {
            width: 100%;
            height: 100%;
            display: flex;
            transition: transform 0.8s cubic-bezier(0.645, 0.045, 0.355, 1);
        }

        .slide {
            min-width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .slide img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .yt-player-container {
            width: 100%;
            height: 100%;
        }

        /* Table Styles */
        .order-table {
            width: 100%;
            border-collapse: collapse;
        }

        .order-table th {
            text-align: left;
            padding: 12px 10px;
            color: var(--text-muted);
            border-bottom: 2px solid #f0f0f0;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .order-table td {
            padding: 15px 10px;
            border-bottom: 1px solid #f9f9f9;
            color: var(--text-main);
            font-weight: 500;
        }

        .order-table .qty {
            width: 50px;
            text-align: center;
        }

        .order-table .total {
            text-align: right;
            font-weight: 600;
        }

        /* Summary Styles */
        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            color: var(--text-muted);
            font-weight: 500;
        }

        .summary-row.grand-total {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 2px solid var(--primary-color);
            color: var(--text-main);
            font-size: 1.8rem;
            font-weight: 800;
        }

        .summary-row.grand-total span:last-child {
            color: var(--primary-color);
        }

        /* Running Text Overlay */
        .marquee-overlay {
            position: absolute;
            bottom: 0;
            width: 100%;
            background: rgba(0,0,0,0.6);
            color: #fff;
            padding: 12px 0;
            z-index: 100;
        }

        .marquee-text {
            display: inline-block;
            white-space: nowrap;
            animation: marquee 30s linear infinite;
            font-size: 1.2rem;
            font-weight: 600;
        }

        @keyframes marquee {
            0% { transform: translateX(100%); }
            100% { transform: translateX(-100%); }
        }

        /* Greeting Overlay */
        .greeting-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0.8);
            background: rgba(255, 255, 255, 0.95);
            padding: 40px 60px;
            border-radius: 30px;
            text-align: center;
            box-shadow: 0 30px 60px rgba(0,0,0,0.2);
            z-index: 2000;
            display: none;
            backdrop-filter: blur(10px);
            border: 2px solid var(--primary-color);
            transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .greeting-overlay.show {
            display: block;
            transform: translate(-50%, -50%) scale(1);
        }

        .greeting-overlay h1 {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin: 0;
            font-weight: 800;
            letter-spacing: -1px;
        }

        .greeting-overlay p {
            font-size: 1.5rem;
            color: var(--text-main);
            margin-top: 10px;
            font-weight: 600;
        }

        .greeting-icon {
            font-size: 4rem;
            color: #ffc107;
            margin-bottom: 20px;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {transform: translateY(0);}
            40% {transform: translateY(-20px);}
            60% {transform: translateY(-10px);}
        }
    </style>
</head>
<body>
    <div class="display-wrapper">
        <!-- Promo Side -->
        <div class="promo-side">
            <div class="slider-container" id="sliderContainer">
                @foreach($oImageData as $index => $item)
                    <div class="slide" data-type="{{ $item['type'] }}" data-index="{{ $index }}">
                        @if($item['type'] == 'image')
                            <img src="{{ $item['url'] }}" alt="Promotion {{ $index + 1 }}">
                        @else
                            <div id="yt-player-{{ $index }}" class="yt-player-container"></div>
                        @endif
                    </div>
                @endforeach
            </div>

            @if(!empty($company->RunningText) && $company->RunningText != "0")
                <div class="marquee-overlay">
                    <div class="marquee-text">{{ $company->RunningText }}</div>
                </div>
            @endif
        </div>

        <!-- Billing Side -->
        <div class="billing-side">
            <div class="billing-header">
                <div class="logo">
                    @if(!empty($company->icon))
                        <img src="{{ $company->icon }}" alt="Logo">
                    @endif
                </div>
                <h2>{{ $company->NamaPartner }}</h2>
            </div>

            <div class="billing-content" id="cartContainer">
                <!-- Cart items will be rendered here -->
                <div class="empty-cart">
                    <p>Selamat Datang!</p>
                </div>
            </div>

            <div class="billing-footer">
                <div class="summary-row">
                    <span>Subtotal</span>
                    <span id="subtotal">Rp 0</span>
                </div>
                <div class="summary-row">
                    <span>Pajak & Layanan</span>
                    <span id="tax">Rp 0</span>
                </div>
                <div class="summary-row">
                    <span>Diskon</span>
                    <span id="discount">Rp 0</span>
                </div>
                <div class="summary-row grand-total">
                    <span>TOTAL</span>
                    <span id="grandTotal">Rp 0</span>
                </div>
            </div>
        </div>

        <!-- Greeting Overlay -->
        <div id="greetingOverlay" class="greeting-overlay">
            <div class="greeting-icon">👋</div>
            <h1>Halo!</h1>
            <p id="greetingName">-</p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://www.youtube.com/iframe_api"></script>
    <script>
        let mediaData = @json($oImageData);
        let players = {};
        let currentIndex = 0;
        let slideInterval;
        let isVideoPlaying = false;

        // YouTube IFrame API initialization
        function onYouTubeIframeAPIReady() {
            mediaData.forEach((item, index) => {
                if (item.type === 'video') {
                    players[index] = new YT.Player(`yt-player-${index}`, {
                        videoId: item.id,
                        playerVars: {
                            'autoplay': 0,
                            'controls': 0,
                            'showinfo': 0,
                            'rel': 0,
                            'mute': 1,
                            'loop': 1,
                            'playlist': item.id // Needed for loop
                        },
                        events: {
                            'onStateChange': (event) => onPlayerStateChange(event, index),
                            'onReady': (event) => {
                                if (index === 0) startSlider();
                            }
                        }
                    });
                }
            });

            // If the first slide is an image, start slider immediately
            if (mediaData.length > 0 && mediaData[0].type === 'image') {
                startSlider();
            }
        }

        function onPlayerStateChange(event, index) {
            if (event.data === YT.PlayerState.ENDED) {
                isVideoPlaying = false;
                nextSlide();
            } else if (event.data === YT.PlayerState.PLAYING) {
                isVideoPlaying = true;
                clearInterval(slideInterval);
            }
        }

        function startSlider() {
            if (mediaData.length <= 1) return;
            showSlide(0);
        }

        function showSlide(index) {
            currentIndex = index;
            const offset = -index * 100;
            $('#sliderContainer').css('transform', `translateX(${offset}%)`);

            // Stop all videos
            Object.values(players).forEach(p => {
                if (p && p.stopVideo) p.stopVideo();
            });

            const currentItem = mediaData[index];
            if (currentItem.type === 'image') {
                clearInterval(slideInterval);
                slideInterval = setInterval(nextSlide, 5000); // 5 seconds for images
            } else {
                clearInterval(slideInterval);
                if (players[index] && players[index].playVideo) {
                    players[index].playVideo();
                }
            }
        }

        function nextSlide() {
            let nextIndex = (currentIndex + 1) % mediaData.length;
            showSlide(nextIndex);
        }

        // Cart Synchronization Details
        function updateCart() {
            const posData = JSON.parse(localStorage.getItem('PoSData')) || { data: [], Total: 0, Discount: 0, Tax: 0, Net: 0 };
            const container = $('#cartContainer');
            
            if (!posData.data || posData.data.length === 0) {
                container.html('<div class="empty-cart"><p>Silakan lakukan pemesanan</p></div>');
                $('#subtotal').text('Rp 0');
                $('#tax').text('Rp 0');
                $('#discount').text('Rp 0');
                $('#grandTotal').text('Rp 0');
                return;
            }

            let html = '<table class="order-table"><thead><tr><th>Item</th><th class="qty">Qty</th><th class="total">Total</th></tr></thead><tbody>';
            posData.data.forEach(item => {
                html += `<tr>
                    <td>${item.NamaItem}</td>
                    <td class="qty">${item.Qty}</td>
                    <td class="total">${formatCurrency(item.Harga * item.Qty)}</td>
                </tr>`;
            });
            html += '</tbody></table>';
            container.html(html);

            $('#subtotal').text(formatCurrency(posData.Total));
            $('#tax').text(formatCurrency(posData.Tax));
            $('#discount').text(formatCurrency(posData.Discount));
            $('#grandTotal').text(formatCurrency(posData.Net));
        }

        function formatCurrency(amount) {
            return 'Rp ' + parseFloat(amount).toLocaleString('id-ID', { minimumFractionDigits: 0 });
        }

        $(window).on('storage', function(e) {
            if (e.originalEvent.key === 'PoSData') {
                updateCart();
            }
            if (e.originalEvent.key === 'PoSGreeting') {
                const data = JSON.parse(e.originalEvent.newValue);
                if (data && data.name) {
                    showGreeting(data.name);
                }
            }
        });

        function showGreeting(name) {
            $('#greetingName').text(name);
            $('#greetingOverlay').addClass('show').fadeIn();
            
            setTimeout(() => {
                $('#greetingOverlay').removeClass('show').fadeOut();
                localStorage.removeItem('PoSGreeting');
            }, 5000); // 5 seconds greeting
        }

        $(document).ready(function() {
            updateCart();
            // Say hello to opener
            if (window.opener) {
                window.opener.postMessage({ type: 'say-hello' }, '*');
            }
        });

        // Notify closer
        $(window).on('beforeunload', function() {
            if (window.opener) {
                window.opener.postMessage('customer-display-closed', '*');
            }
        });
    </script>
</body>
</html>
