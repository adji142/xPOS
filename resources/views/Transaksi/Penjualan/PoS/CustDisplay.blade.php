<!DOCTYPE html>
<!--
Template Name: Kundol Admin - Bootstrap 4 HTML Admin Dashboard Theme
Author: Themes-coder
Website: https://themes-coder.com/
Contact: sales@themes-coder.com
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<html lang="en">
<!--begin::Head-->

<head>
	
	<meta charset="utf-8" />
	<title>Admin | Penjualan FnB</title>
	<meta name="description" content="Updates and statistics" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<!--begin::Fonts-->
	<!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" /> -->
	<!--end::Fonts-->

	<!--begin::Global Theme Styles(used by all pages)-->
	<link href="{{ asset('css/style.css?v=1.0')}}" rel="stylesheet" type="text/css" />
	<!--end::Global Theme Styles-->

	<link href="{{ asset('api/pace/pace-theme-flat-top.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('api/mcustomscrollbar/jquery.mCustomScrollbar.css')}}" rel="stylesheet" type="text/css" />
	
	{{-- <link href="http://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" /> --}}
	<link href="{{asset('api/datatable/jquery.dataTables.min.css')}}" rel="stylesheet" type="text/css" />
	<link href="https://unpkg.com/multiple-select@1.5.2/dist/multiple-select.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
	<link href="{{asset('api/select2/select2.min.css')}}" rel="stylesheet" />

	<link rel="shortcut icon" href="{{ asset('media/logos/favicon.ico')}}" />
	{{-- <script src="https://www.youtube.com/iframe_api"></script> --}}
    {{-- Datatable --}}
    <link href="{{asset('api/datatable/jquery.dataTables.min.css')}}" rel="stylesheet" type="text/css" />
	<style type="text/css">
		.TotalText{
			text-align: right;
			pointer-events: none;
		}
		.CenterText{
			text-align: center;
		}

		.scroll-container {
		    width: 100%;
		    overflow-x: auto;
		    padding: 10px;
		}

		.horizontal-list {
		    display: grid; /* Uses CSS Grid */
		    grid-template-columns: repeat(2, 1fr); /* Each row will have 4 items */
		    gap: 10px; /* Adds space between items */
		    list-style: none; /* Removes default list styling */
		    padding: 0; /* Removes default padding */
		    margin: 0; /* Removes default margin */
		}

		.horizontal-list li {
		    background-color: #f0f0f0;
		    padding: 10px;
		    border: 1px solid #ccc;
		    text-align: center;
		}
		.horizontal-list li.active {
		    background-color: #ffcc00; /* Change to the desired color when clicked */
		}


		.horizontal-list-meja {
		    display: grid; /* Uses CSS Grid */
		    grid-template-columns: repeat(4, 1fr); /* Each row will have 4 items */
		    gap: 10px; /* Adds space between items */
		    list-style: none; /* Removes default list styling */
		    padding: 0; /* Removes default padding */
		    margin: 0; /* Removes default margin */
		}

		.horizontal-list-meja li {
		    background-color: #f0f0f0;
		    padding: 10px;
		    border: 1px solid #ccc;
		    text-align: center;
		}
		.horizontal-list-meja li.active {
		    background-color: #ffcc00; /* Change to the desired color when clicked */
		}

		.horizontal-list-meja {
		    display: grid; /* Uses CSS Grid */
		    grid-template-columns: repeat(4, 1fr); /* Each row will have 4 items */
		    gap: 10px; /* Adds space between items */
		    list-style: none; /* Removes default list styling */
		    padding: 0; /* Removes default padding */
		    margin: 0; /* Removes default margin */
		}

		.horizontal-list-meja li {
		    background-color: #f0f0f0;
		    padding: 10px;
		    border: 1px solid #ccc;
		    text-align: center;
		}
		.horizontal-list-meja li.active {
		    background-color: #ffcc00; /* Change to the desired color when clicked */
		}

		/*  */
		.horizontal-list-variant {
		    display: grid; /* Uses CSS Grid */
		    grid-template-columns: repeat(4, 1fr); /* Each row will have 4 items */
		    gap: 10px; /* Adds space between items */
		    list-style: none; /* Removes default list styling */
		    padding: 0; /* Removes default padding */
		    margin: 0; /* Removes default margin */
		}

		.horizontal-list-variant li {
		    background-color: #f0f0f0;
		    padding: 10px;
		    border: 1px solid #ccc;
		    text-align: center;
		}
		.horizontal-list-variant li.active {
		    background-color: #ffcc00; /* Change to the desired color when clicked */
		}
		/*  */
		/* Style for text alignment */
		.aligned-textbox {
		    text-align: right; /* Change 'center' to 'left' or 'right' for different alignments */
		}
		.dx-dropdowneditor-overlay {
		    z-index: 10000!important ; /* Adjust the z-index value as needed */
		}
		.dx-dropdowneditor-input-wrapper{
		    height: 50% !important;
		}

		.productCard:hover{
			cursor: pointer;
		}

		.slider {
            position: relative;
            width: 100%;
            margin: auto;
            overflow: hidden;
            border: 2px solid #ddd;
            border-radius: 10px;
        }
        .slides {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }
        .slide {
            min-width: 100%;
            box-sizing: border-box;
			display: flex;
			justify-content: center;
        }
        .slide img {
            max-width: 100%; /* Makes the image scale down if it's too large */
			height: auto;    /* Maintains the aspect ratio */
			display: block;  /* Ensures no unwanted gaps below the image */
			margin: auto;    /* Centers the image horizontally if needed */
			border-radius: 10px;
        }
        .dots {
            text-align: center;
            margin-top: 10px;
        }
        .dot {
            height: 10px;
            width: 10px;
            margin: 0 5px;
            background-color: #bbb;
            border-radius: 50%;
            display: inline-block;
            cursor: pointer;
        }
        .dot.active {
            background-color: #717171;
        }

		/* Running Text */

		.marquee-container {
            position: relative;
            width: 100%;
			height: 50px;
            overflow: hidden;
            background-color: #222;
            padding: 10px 0;
        }
        .marquee {
            display: inline-block;
            position: absolute;
            white-space: nowrap;
            animation: scrollText 10s linear infinite, blink 1s step-start infinite;
            font-size: 24px;
            color: #fff;
        }
        @keyframes scrollText {
            from {
                transform: translateX(-100%);
            }
            to {
                transform: translateX(100%);
            }
        }
        @keyframes blink {
            0%, 50% {
                color: yellow;
            }
            51%, 100% {
                color: red;
            }
		}

		table {
            width: 50%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: right;
        }
        th {
            background-color: #f4f4f4;
        }
	</style>
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="tc_body" class="header-fixed header-mobile-fixed subheader-enabled aside-enabled aside-fixed" style="
    @if(isset($company) && $company->TypeBackgraund == 'Color')
        background-color: {{ $company->Backgraund }};
    @elseif(isset($company) && $company->TypeBackgraund == 'Image')
        background-image: url('{{ $company->Backgraund }}');
        background-size: auto;
        background-repeat: repeat;
        background-position: center;
    @endif
">
    <header class="pos-header bg-white">
		<div class="container-fluid">
			<div class="row align-items-center">
				<div class="col-xl-4 col-lg-4 col-md-6">
					<div class="greeting-text">
						<h3 class="card-label mb-0 font-weight-bold text-primary">Hallo, Nama Saya 
						</h3>
						<h3 class="card-label mb-0 ">
							{{ Auth::user()->name }}
						</h3>
					</div>
				</div>
				<div class="col-xl-4 col-lg-5 col-md-6  clock-main">
					<div class="clock">
						<div class="datetime-content">
							<ul>
								<li id="hours"></li>
								<li id="point1">:</li>
								<li id="min"></li>
								<li id="point">:</li>
								<li id="sec"></li>
							</ul>
						</div>
						<div class="datetime-content">
							<div id="Date"  class=""></div>
						</div>
					  
					</div>
				</div>

			</div>
		</div>
	</header>
	<div class="contentPOS">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-12 col-lg-8 col-md-8">
					<div class="card card-custom gutter-b bg-white border-0" >
						@if ($company->RunningText != null && $company->RunningText != "")
							<div class="marquee-container">
								<div class="marquee">{{ $company->RunningText }}</div>
							</div>
						@endif
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xl-5 col-lg-8 col-md-8">
					<div class="card card-custom gutter-b bg-white border-0" >
						<div class="card-body">
							<div class="row">
								<div class="col-md-12" style="text-align: center;">
									<div class="slider">
										<div class="slides" id="slidesContainer"></div>
										<div class="dots" id="dotsContainer"></div>
									</div>
								</div>	
							</div>
						</div>	
					</div>
				</div>
				<div class="col-xl-5 col-lg-8 col-md-8" style ="display:none;">
					<div class="card card-custom gutter-b bg-white border-0" >
						<div class="card-body">
							<div class="row">
								<div class="col-md-12" style="text-align: center;">
									<div class="slider">
										<div class="slides">
											@if ($company->ImageCustDisplay1 == null)
											<div class="slide">
												<img src="https://www.pluxee.co.id/sites/g/files/jclxxe371/files/2023-11/Manfaat-Media-Promosi.jpg" alt="Slide 1">
											</div>
											@else
											<div class="slide">
												<img src={{ $company->ImageCustDisplay1 }} alt="Slide 1">
											</div>
											@endif
											@if ($company->ImageCustDisplay2 == null)
											<div class="slide">
												<img src="https://www.pluxee.co.id/sites/g/files/jclxxe371/files/2023-11/Manfaat-Media-Promosi.jpg" alt="Slide 2">
											</div>
											@else
											<div class="slide">
												<img src={{ $company->ImageCustDisplay2 }} alt="Slide 2">
											</div>
											@endif

											@if ($company->ImageCustDisplay3 == null)
											<div class="slide">
												<img src="https://www.pluxee.co.id/sites/g/files/jclxxe371/files/2023-11/Manfaat-Media-Promosi.jpg" alt="Slide 3">
											</div>
											@else
											<div class="slide">
												<img src={{ $company->ImageCustDisplay3 }} alt="Slide 13">
											</div>
											@endif

											@if ($company->ImageCustDisplay4 == null)
											<div class="slide">
												<img src="https://www.pluxee.co.id/sites/g/files/jclxxe371/files/2023-11/Manfaat-Media-Promosi.jpg" alt="Slide 4">
											</div>
											@else
											<div class="slide">
												<img src={{ $company->ImageCustDisplay4 }} alt="Slide 4">
											</div>
											@endif
										</div>
									</div>
									<div class="dots">
										<span class="dot" data-slide="0"></span>
										<span class="dot" data-slide="1"></span>
										<span class="dot" data-slide="2"></span>
										<span class="dot" data-slide="3"></span>
									</div>
								</div>	
							</div>
						</div>	
					</div>
				</div>
				<div class="col-xl-4 col-lg-8 col-md-8">
					<div class="card card-custom gutter-b bg-white border-0" >
						<div class="card-body">
							<div class="row">
								<div class="col-md-12" style="text-align: center;">
									<label class="text-dark" >Detail Transaksi</label>

									<div class="table-responsive" id="printableTable">
										<table id="orderTable" class="display" style="width:100%">
											<thead>
												<tr>
													<th>Nama Item</th>
													<th>Jumlah</th>
													<th>Harga</th>
												</tr>
											</thead>

											<tbody id="tableBody">

											</tbody>
										</table>
									</div>
								</div>	
							</div>
						</div>	
					</div>
				</div>
				<div class="col-xl-3 col-lg-4 col-md-4">
					<div class="card card-custom gutter-b bg-white border-0">
						<div class="card-body" >
							<div class="resulttable-pos">
								<table class="table right-table">

									<tbody>
										<tr class="d-flex align-items-center justify-content-between">
											<th class="border-0 font-size-h5 mb-0 font-size-bold text-dark">
												Total Items
											</th>
											<td class="border-0 justify-content-end d-flex text-dark font-size-base">
												<input type="text" name="_TotalItem" id="_TotalItem" value="0" class="form-control TotalText">
											</td>
											
										</tr>
										<tr class="d-flex align-items-center justify-content-between">
											<th class="border-0 font-size-h5 mb-0 font-size-bold text-dark">
												Subtotal
											</th>
											<td class="border-0 justify-content-end d-flex text-dark font-size-base">
												<input type="text" name="_SubTotal" id="_SubTotal" value="0" class="form-control TotalText">
											</td>
										
									  	</tr>
									  	<tr class="d-flex align-items-center justify-content-between">
											<th class="border-0 ">
												<div class="d-flex align-items-center font-size-h5 mb-0 font-size-bold text-dark">
													DISCOUNT
												</div>
											</th>
											<td class="border-0 justify-content-end d-flex text-dark font-size-base">
												<input type="text" name="_TotalDiskon" id="_TotalDiskon" value="0" class="form-control TotalText">
											</td>
										
										</tr>
										<tr class="d-flex align-items-center justify-content-between">
											<th class="border-0 font-size-h5 mb-0 font-size-bold text-dark">
													Tax
											</th>
											<td class="border-0 justify-content-end d-flex text-dark font-size-base">
												<input type="text" name="_TotalTax" id="_TotalTax" value="0" class="form-control TotalText">
											</td>
										
									  	</tr>
									  	<tr class="d-flex align-items-center justify-content-between item-price">
											<th class="border-0 font-size-h5 mb-0 font-size-bold text-primary">
												TOTAL
											</th>
											<td>:</td>
											<td class="border-0 justify-content-end d-flex text-primary font-size-base">
												<input type="text" name="_GrandTotal" id="_GrandTotal" value="0" class="form-control TotalText">
											</td>
										
									  	</tr>
								
									</tbody>
								</table>
							</div>
						</div>	
					 </div>
				</div>
			</div>
		</div>
	</div>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/plugin.bundle.min.js')}}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('js/script.bundle.js')}}"></script>
<link href="{{ asset('devexpress/dx.light.css')}}" rel="stylesheet" type="text/css" />
<script src="{{asset('devexpress/dx.all.js')}}"></script>
<script src="{{asset('api/select2/select2.min.js')}}"></script>
@if (env('MIDTRANS_IS_PRODUCTION') == false)
<script src="{{ env('MIDTRANS_DEV_URL') }}" data-client-key="{{ $midtransclientkey }}"></script>
@else
<script src="{{ env('MIDTRANS_PROD_URL') }}" data-client-key="{{ $midtransclientkey }}"></script>
@endif
<script>
	const itemsDiv = document.getElementById("items");
	const totalAmountSpan = document.getElementById("totalAmount");

	const slides = document.querySelector('.slides');
	const dots = document.querySelectorAll('.dot');
	let currentIndex = 0;
	const slideCount = document.querySelectorAll('.slide').length;

	// window.onload = function () {
    //     if (window.opener && !window.opener.closed) {
    //         window.opener.postMessage({ type: 'say-hello' }, '*');
    //     }
    // };
	let autoPlayTimeout = null;
	let mediaData = <?php echo json_encode($oImageData) ?>;
	let ytPlayers = {}
	let videoStarted = {};
	

	window.addEventListener('beforeunload', function (e) {
		// Lakukan sesuatu sebelum halaman ditutup
		if (window.opener && !window.opener.closed) {
            window.opener.postMessage('customer-display-closed', '*');
        }
	});
	window.addEventListener('message', function(event) {
		// console.log(event);
		if (event.data === 'paymentgateway') {
			// document.getElementById('status').innerHTML = 'Status: <b>CLOSED</b>';
			// _custdisplayopened = false;
			const oData = JSON.parse(localStorage.getItem("paymentgatewaydata"));
			PaymentGateWay(oData);
		}
	});
	function updateDisplay() {
		window.opener.postMessage({ type: 'say-hello' }, '*');

		const cart = JSON.parse(localStorage.getItem("PoSData"));
		console.log(cart)
		const tableBody = document.getElementById("tableBody");
		tableBody.innerHTML = '';
		formatCurrency($('#_TotalItem'), 0);
	    formatCurrency($('#_SubTotal'), 0);
	    formatCurrency($('#_TotalDiskon'), 0);
	    formatCurrency($('#_GrandTotal'), 0);
		formatCurrency($('#_TotalTax'), 0);
		console.log(cart.length);
		if(cart && Array.isArray(cart.data) && cart.data.length > 0){
			for (let index = 0; index < cart["data"].length; index++) {
				// const element = array[index];
				const newRow = document.createElement("tr");
				
				const cell1 = document.createElement("td");
				cell1.textContent = cart["data"][index]['NamaItem'];

				const cell2 = document.createElement("td");
				cell2.textContent = cart["data"][index]['Qty'];

				const cell3 = document.createElement("td");

				let formattedAmount = parseFloat(cart["data"][index]['Harga']).toLocaleString('en-US', {
					style: 'decimal',
					minimumFractionDigits: 2,
					maximumFractionDigits: 2
				});
				cell3.textContent = formattedAmount;
				
				newRow.appendChild(cell1);
				newRow.appendChild(cell2);
				newRow.appendChild(cell3);

				tableBody.appendChild(newRow);
				
			}
			CalculateTotal(cart);
		}
		
	}

	 // Auto-slide function
	function autoSlide() {
		currentIndex = (currentIndex + 1) % slideCount;
		updateSlidePosition();
	}

	// Update slide position
	function updateSlidePosition() {
		slides.style.transform = `translateX(-${currentIndex * 100}%)`;
		updateDots();
	}

	// Update active dot
	function updateDots() {
		dots.forEach((dot, index) => {
			dot.classList.toggle('active', index === currentIndex);
		});
	}

	dots.forEach(dot => {
		dot.addEventListener('click', () => {
			currentIndex = parseInt(dot.getAttribute('data-slide'));
			updateSlidePosition();
		});
	});

	function CalculateTotal(data) {
  		var _tempTotalItem = 0;
  		var _tempSubTotal = 0;
  		var _tempTotalDiskon = 0;
  		var _tempTotalTax = 0;
  		var _tempTotalServices = 0;
  		var _tempGrandTotal = 0;

  		_tempTotalItem = data["data"].length;

	    // Diskon Grup Customer

		console.log(_tempTotalTax)

	    formatCurrency($('#_TotalItem'), _tempTotalItem);
	    formatCurrency($('#_SubTotal'), data["Total"]);
	    formatCurrency($('#_TotalDiskon'), data["Discount"]);
	    // formatCurrency($('#_TotalServices'), _tempTotalServices);
	    formatCurrency($('#_GrandTotal'), data["Net"]);
		formatCurrency($('#_TotalTax'), data["Tax"]);
	}

	function formatCurrency(input, amount) {
		input.attr("originalvalue", amount);
        let formattedAmount = parseFloat(amount).toLocaleString('en-US', {
            style: 'decimal',
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });

        // Set the formatted value to the input field
        input.val(formattedAmount);
    }

	function PaymentGateWay(oData){
		console.log(oData);
		fetch( "{{route('pembayaranpenjualan-createpayment')}}", {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json',
				'X-CSRF-TOKEN': '{{ csrf_token() }}'
			},
			body: JSON.stringify(oData)
		})
		.then(response => response.json())
		.then(data => {
			console.log(data);
			if (data.snap_token) {
				snap.pay(data.snap_token, {
					onSuccess: function(result){
						// console.log(result);
						if(result.transaction_status == "cancel"){
							// Swal.fire({
							// 	icon: "error",
							// 	title: "Opps...",
							// 	text: "Pembayaran Dibatalkan",
							// });
							window.opener.postMessage('payment-cancel', '*');
						}
						else{
							window.opener.postMessage('payment-success', '*');
							// order_id
							// jQuery('#txtRefrensi_Detail').val(result.order_id)
							// SaveData(Status, ButonObject, ButtonDefaultText)
						}
						// Proses pembayaran sukses
					},
					onPending: function(result){
						// console.log(result);
						// Pembayaran tertunda
					},
					onError: function(result){
						// console.log(result);
						// Swal.fire({
						// 	icon: "error",
						// 	title: "Opps...",
						// 	text: result,
						// })
						window.opener.postMessage('payment-error', '*');
						localStorage.setItem('errorresult', result);
						// Pembayaran gagal
					},
					onClose: function(){
						console.log('customer closed the popup without finishing the payment');
						window.opener.postMessage('no-pay', '*');
					}
				});
			} else {
				// alert('Error: ' + data.error);
				// Swal.fire({
				// 	icon: "error",
				// 	title: "Opps...",
				// 	text: data.error,
				// })
				window.opener.postMessage('data-error', data.error);
				localStorage.setItem('errorresult', data.error);
			}
		})
		.catch(error => console.error('Error:', error));
	}

	function extractYouTubeID(url) {
		const regExp = /^.*(youtu\.be\/|v\/|u\/\w\/|embed\/|watch\?v=)([^#&?]*).*/;
		const match = url.match(regExp);
		return (match && match[2].length === 11) ? match[2] : null;
	}

	function renderSlides() {
		console.log("3. render Slide")
		const slidesContainer = document.getElementById('slidesContainer');
		const dotsContainer = document.getElementById('dotsContainer');

		slidesContainer.innerHTML = '';
		dotsContainer.innerHTML = '';
		ytPlayers = {}; // Reset player cache

		mediaData.forEach((item, index) => {
			const slide = document.createElement('div');
			slide.className = 'slide';

			if (item.type === 'image') {
				const img = document.createElement('img');
				img.src = item.url;
				slide.appendChild(img);
			} else if (item.type === 'video') {
				const videoId = extractYouTubeID(item.url);
				const iframeContainer = document.createElement('div');
				iframeContainer.id = `ytplayer-${index}`;
				slide.appendChild(iframeContainer);
				// Tunda sedikit agar DOM ter-render dulu
				setTimeout(() => createYouTubePlayer(videoId, index), 0);
			}

				slidesContainer.appendChild(slide);

				const dot = document.createElement('span');
				dot.className = 'dot';
				dot.dataset.index = index;
				dot.addEventListener('click', () => {
				currentIndex = index;
				playMedia(index);
			});
			dotsContainer.appendChild(dot);
		});

		// Style container
		slidesContainer.style.display = 'flex';
		slidesContainer.style.transition = 'transform 0.7s ease-in-out';
		document.querySelectorAll('.slide').forEach(slide => {
			slide.style.flex = '0 0 100%';
		});
	}


	function playMedia(index) {
		clearTimeout(autoPlayTimeout);

		const slidesContainer = document.getElementById('slidesContainer');
		const slides = document.querySelectorAll('.slide');
		const dots = document.querySelectorAll('.dot');

		slidesContainer.style.transform = `translateX(-${index * 100}%)`;

		dots.forEach((dot, i) => {
			dot.classList.toggle('active', i === index);
		});

		// Stop semua video lain
		Object.entries(ytPlayers).forEach(([i, player]) => {
			i = parseInt(i);
			if (player && player.stopVideo && i !== index) {
			player.stopVideo();
			}
		});

		const media = mediaData[index];

		if (media.type === 'image') {
			autoPlayTimeout = setTimeout(nextMedia, 5000);
		} else if (media.type === 'video') {
			const player = ytPlayers[index];
			if (player && player.seekTo && player.playVideo) {
			// Pastikan video mulai dari awal
			player.seekTo(0);
			player.playVideo();
			}
		}
	}


	function createYouTubePlayer(videoId, index) {
		ytPlayers[index] = new YT.Player(`ytplayer-${index}`, {
			height: '360',
			width: '640',
			videoId: videoId,
			playerVars: {
				autoplay: 0,
				mute: 1,
				controls: 0,
				modestbranding: 1,
				rel: 0,
				enablejsapi: 1
			},
			events: {
				onReady: (event) => {
					if (index === currentIndex) {
						event.target.playVideo();
					}
				},
				onStateChange: (event) => {
					const player = event.target;

					const currentTime = player.getCurrentTime();
					const duration = player.getDuration();

					console.log(event.data + " >> " + currentTime + " >> " + duration)

					if (event.data === YT.PlayerState.PLAYING) {
						// Tandai bahwa video benar-benar mulai diputar
						videoStarted[index] = true;
					}

					if (event.data === YT.PlayerState.ENDED) {
						// Pastikan video benar-benar sudah mulai sebelumnya
						if (videoStarted[index]) {
							
							if (Math.abs(currentTime - duration) <= 1) {
								event.target.stopVideo();
								nextMedia();
							}
						}
					}
				}
			}
		});
	}


	function nextMedia() {
		currentIndex = (currentIndex + 1) % mediaData.length;
		playMedia(currentIndex);
	}

	function loadYouTubeAPI() {
		console.log("1. Load Youtube API")
		if (!window.YT || !YT.Player) {
			const tag = document.createElement('script');
			tag.src = "https://www.youtube.com/iframe_api";
			document.body.appendChild(tag);
		}
	}

	window.onYouTubeIframeAPIReady = function () {
		console.log("2. Youtube API Ready")
		renderSlides();
		playMedia(0);
	};
	
	// Update display whenever localStorage changes
	window.addEventListener("storage", updateDisplay);

	// Initial load
	updateDisplay();
	loadYouTubeAPI();
	// renderSlides();

	// setInterval(autoSlide, 3000);
	updateSlidePosition();
</script>
</html>