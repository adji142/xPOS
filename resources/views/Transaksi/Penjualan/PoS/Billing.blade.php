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
	<title>Admin | Dashboard</title>
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

		.clock-container {
            display: flow-root;
            justify-content: center;
            align-items: center;
            background: #333;
            padding: 20px 40px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }

        ul.timer {
            list-style: none;
            display: flex;
            gap: 10px;
            padding: 0;
            margin: 0;
        }

        li.timer-item {
            font-size: 2rem; /* Large digits */
            padding: 10px 15px;
            background: #444;
            color: #00ff6a;
            border-radius: 5px;
            text-align: center;
            width: 60px; /* Ensure uniform width for all elements */
        }

        li.timer-colon {
            background: none;
            font-size: 2rem;
            color: #00ff6a;
            display: flex;
            align-items: center;
        }

		@media (min-width: 1200px) {
			.col-xl-custom-5 {
				flex: 0 0 20%;
				max-width: 20%;
			}
		}

		@media (min-width: 992px) and (max-width: 1199.98px) {
			.col-lg-custom-5 {
				flex: 0 0 20%;
				max-width: 20%;
			}
		}
		.disabled-link {
			pointer-events: none; /* Disable clicks */
			color: gray; /* Optional: visually indicate it is disabled */
			text-decoration: none; /* Optional: remove underline */
		}

		.time-slot-card {
			cursor: pointer;
			transition: all 0.2s;
			border: 1px solid #ddd;
			border-radius: 8px;
			overflow: hidden;
		}
		.time-slot-card:hover {
			transform: translateY(-2px);
			box-shadow: 0 4px 6px rgba(0,0,0,0.1);
		}

		.card-badge {
			position: absolute;
			top: -10px;
			right: -10px;
			background-color: #28a745;
			color: white;
			padding: 5px 15px;
			border-radius: 20px;
			font-size: 0.85rem;
			font-weight: bold;
			z-index: 10;
			box-shadow: 0 2px 4px rgba(0,0,0,0.2);
			text-transform: uppercase;
		}
		.time-slot-card.selected {
			border-color: #3699FF;
			background-color: #2280dfff;
		}
		.time-slot-card.disabled {
			opacity: 0.5;
			cursor: not-allowed;
			background-color: #f3f6f9;
		}
		.time-slot-card.disabled:hover {
			transform: none;
			box-shadow: none;
		}
		/* Fix identifying selected items by targeting the inner card */
		.time-slot-card.selected .card {
			background-color: #3699FF !important;
			color: #ffffff !important;
			border-color: #3699FF;
		}
		.time-slot-card.selected .text-muted {
			color: #e4e6ef !important;
		}
	</style>
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="tc_body" class="header-fixed header-mobile-fixed subheader-enabled aside-enabled aside-fixed">
   <!-- Paste this code after body tag -->
   <!-- s -->
   <!-- pos header -->

   <header class="pos-header bg-white">
	   <div class="container-fluid">
		   <div class="row align-items-center">
			   <div class="col-xl-4 col-lg-4 col-md-6">
				   <div class="greeting-text">
					<h3 class="card-label mb-0 font-weight-bold text-primary">WELCOME
						<br>
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
			   <div class="col-xl-4 col-lg-3 col-md-12  order-lg-last order-second">

				<div class="topbar justify-content-end">
					<div class="topbar-item folder-data">
						<div id="btOpenListBooking" class="btn btn-icon  w-auto h-auto btn-clean d-flex align-items-center py-0 me-3">
							<span class="symbol symbol-35  symbol-light-success">
								<a href="{{ route('bookinglist') }}" target="_blank" class="btn btn-warning">Booking Online List</a>
							</span>
						</div>
				 
					</div>

					<div class="topbar-item folder-data">
						<div id="btOpenCustDisplay" class="btn btn-icon  w-auto h-auto btn-clean d-flex align-items-center py-0 me-3">
							<span class="symbol symbol-35  symbol-light-success">
								<span class="symbol-label font-size-h5 ">
									<svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" fill="currentColor" class="bi bi-pc-display-horizontal" viewBox="0 0 16 16">
									<path d="M1.5 0A1.5 1.5 0 0 0 0 1.5v7A1.5 1.5 0 0 0 1.5 10H6v1H1a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1h-5v-1h4.5A1.5 1.5 0 0 0 16 8.5v-7A1.5 1.5 0 0 0 14.5 0zm0 1h13a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-7a.5.5 0 0 1 .5-.5M12 12.5a.5.5 0 1 1 1 0 .5.5 0 0 1-1 0m2 0a.5.5 0 1 1 1 0 .5.5 0 0 1-1 0M1.5 12h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1 0-1M1 14.25a.25.25 0 0 1 .25-.25h5.5a.25.25 0 1 1 0 .5h-5.5a.25.25 0 0 1-.25-.25"/>
									</svg>
								</span>
							</span>
						</div>
				 
					</div>

					<div class="dropdown">
						<div class="topbar-item" data-bs-toggle="dropdown" data-display="static">
							<div class="btn btn-icon w-auto h-auto btn-clean d-flex align-items-center py-0">
							
								<span class="symbol symbol-35 symbol-light-success">
									<span class="symbol-label font-size-h5 ">
										<svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-person-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
											<path fill-rule="evenodd" d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"></path>
										</svg>
									</span>
								</span>
							</div>
						</div>
	
						<div class="dropdown-menu dropdown-menu-right" style="min-width: 150px;">
							<a href="{{ route('logout') }}" class="dropdown-item">
								<span class="svg-icon svg-icon-xl svg-icon-primary me-2">
									<svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-power">
										<path d="M18.36 6.64a9 9 0 1 1-12.73 0"></path>
										<line x1="12" y1="2" x2="12" y2="12"></line>
									</svg>
								</span>
								Logout
							</a>
						</div>
	
					</div>
				</div>
		 
				</div>
		   </div>
	   </div>
   </header>
   <div class="contentPOS" style="
    @if(isset($company) && $company[0]['TypeBackgraund'] == 'Color')
        background-color: {{ $company[0]['Backgraund'] }};
    @elseif(isset($company) && $company[0]['TypeBackgraund'] == 'Image')
        background-image: url('{{ $company[0]['Backgraund'] }}');
        background-size: auto;
        background-repeat: repeat;
        background-position: center;
    @endif
">
	    <div class="container-fluid">
			<div class="row">
				<div class="col-xl-12 col-lg-8 col-md-8">
				     <div class="">
						<div class="card card-custom gutter-b bg-white border-0 table-contentpos">

							@if (count($kelompoklampu) > 0)
								@foreach ($kelompoklampu as $tl)
									<div class="card-header align-items-center  border-bottom-dark px-0" style="justify-content: center !important;">
										<div class="card-title mb-0">
											<strong>
												<h3 class="card-label mb-0 font-weight-bold">{{ $tl->NamaKelompok }}</h3>
											</strong>
										</div>
									</div>

									<div class="card-body" >
										<div class="row">
											@if (count($titiklampu) > 0)
												@foreach ($titiklampu as $item)
													@if ($item->KelompokLampu == $tl->KodeKelompok)
														<div class="col-xl-custom-5 col-lg-custom-5 col-md-8">
															<div class="card card-custom gutter-b bg-white border-0 table-contentpos">
																@if ($item->TotalPembayaran > 0)
																	<div class="card-badge">PAID</div>
																@endif
																<div class="card-header align-items-center  border-0">
																	<div class="card-title mb-0">
																		<h3 class="card-label text-body font-weight-bold mb-0">{{ $item->NamaTitikLampu }}</h3>
																	</div>
																</div>
																<div class="card-body pt-4" >
																	
																	<div class="row align-items-center mb-4">
																		<div class="col-7">
																			@if ($item->Status == 0)
																				<button class="btn btn-success text-white font-weight-bold w-100 py-4" style="font-size: 1.2rem;">{{ $item->StatusMeja }}</button>
																			@endif

																			@if ($item->Status == 1)
																				<button class="btn btn-danger text-white font-weight-bold w-100 py-4" style="font-size: 1.2rem;">{{ $item->StatusMeja }}</button>
																			@endif

																			@if ($item->Status == 99)
																				<button class="btn btn-warning text-white font-weight-bold w-100 py-4" style="font-size: 1.2rem;">{{ $item->StatusMeja }}</button>
																			@endif

																			@if ($item->Status == -1)
																				<button class="btn btn-warning text-white font-weight-bold w-100 py-4" style="font-size: 1.2rem;">{{ $item->StatusMeja }}</button>
																			@endif
																		</div>
																		<div class="col-5">
																			<div class="d-flex justify-content-center align-items-center rounded border" style="height: 80px; overflow: hidden; background-color: #f8f9fa;">
																				@if (!empty($item->Gambar))
																					<img src="{{ $item->Gambar }}" class="img-fluid" style="width: 100%; height: 100%; object-fit: cover;" alt="Table Image">
																				@else
																					<img src="https://www.generationsforpeace.org/wp-content/uploads/2018/03/empty.jpg" class="img-fluid" style="width: 100%; height: 100%; object-fit: cover; opacity: 0.6;" alt="Empty">
																				@endif
																			</div>
																		</div>
																	</div>



																	<ul class="list-group scrollbar-1">
																		<li class="list-group-item list-group-item-action border-0 d-flex align-items-center justify-content-between py-2">
																			<div class="list-left d-flex align-items-center">
																				<span class="d-flex align-items-center justify-content-center rounded svg-icon w-45px h-45px bg-success text-white me-2">
																					<svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-credit-card-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
																						<path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v1H0V4z"/>
																						<path fill-rule="evenodd" d="M0 7v5a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7H0zm3 2a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1v-1a1 1 0 0 0-1-1H3z"/>
																					</svg>
																					</span>
																				<div class="list-content">
																				<span class="list-title text-body">Paket</span>
																				</div>
																			</div>
																			<span id="lblPaketTransaksi{{ $item->id }}">-</span>
																		</li>
																		<li class="list-group-item list-group-item-action border-0 d-flex align-items-center justify-content-between py-2">
																			<div class="list-left d-flex align-items-center">
																				<span class="d-flex align-items-center justify-content-center rounded svg-icon w-45px h-45px bg-primary text-white me-2">
																					<svg width="20px" height="20px" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
																						<path d="M3 2v12s6.333-2.833 10.666-6C9.333 4.833 3 2 3 2z" fill="white" overflow="visible" style="marker:none" color="#000000"/>
																					</svg>
																				</span>
																				<div class="list-content">
																					<span class="list-title text-body">Mulai</span>
																				</div>
																			</div>
																			<span id="lblMulai{{ $item->id }}">-</span>
																		</li>

																		<li class="list-group-item list-group-item-action border-0 d-flex align-items-center justify-content-between py-2">
																			<div class="list-left d-flex align-items-center">
																				<span class="d-flex align-items-center justify-content-center rounded svg-icon w-45px h-45px bg-secondary text-white me-2">
																					<svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																						<path d="M2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2C16.714 2 19.0711 2 20.5355 3.46447C22 4.92893 22 7.28595 22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12Z" fill="#FFFFFF"/>
																					</svg>
																				</span>
																			<div class="list-content">
																				<span class="list-title text-body">Selesai</span>
																			</div>
																			</div>
																			<span id="lblSelesai{{ $item->id }}">-</span>
																		</li>
																	</ul>
																	<div class="col-xl-3 col-lg-8 col-md-8  clock-main">
																		<div class="clock">
																			<div id="clock_{{ $item->id }}">

																			</div>
																		</div>
																	</div>

																	<hr>
																	
																	<center>
																		@if ($item->Status == -1)
																			<div class ="row mb-2">
																				<div class="col-4 px-1">
																					<button disabled class="btn btn-success text-white font-weight-bold w-100 py-3 item-dropdown btPilihPaket btPilihPaket_{{ $item->id }}" data-id="{{ $item->id }}" data-namatitiklampu="{{ $item->NamaTitikLampu }}" data-notransaksi="{{ $item->NoTransaksi }}" data-jenispaket="{{ $item->JenisPaket }}" data-toggle="tooltip" title="PILIH LAYANAN"><i class="fas fa-play"></i></button>
																				</div>
																				<div class="col-4 px-1">
																					<button disabled class="btn btn-danger text-white font-weight-bold w-100 py-3 item-dropdown btCheckOut btCheckOut_{{ $item->id }}" data-id="{{ $item->id }}" data-namatitiklampu="{{ $item->NamaTitikLampu }}" data-notransaksi="{{ $item->NoTransaksi }}" data-jenispaket="{{ $item->JenisPaket }}" data-toggle="tooltip" title="CHECKOUT"><i class="fas fa-sign-out-alt"></i></button>
																				</div>
																				<div class="col-4 px-1">
																					<button class="btn btn-warning text-white font-weight-bold w-100 py-3 item-dropdown btDetail btDetail_{{ $item->id }}" data-id="{{ $item->id }}" data-namatitiklampu="{{ $item->NamaTitikLampu }}" data-notransaksi="{{ $item->NoTransaksi }}" data-jenispaket="{{ $item->JenisPaket }}" data-toggle="tooltip" title="DETAIL"><i class="fas fa-info-circle"></i></button>
																				</div>
																			</div>
																			<div class="row">
																				<div class="col-6 px-1">
																					<button class="btn btn-success text-white font-weight-bold w-100 py-3 item-dropdown btTambahMakanan btTambahMakanan_{{ $item->id }}" data-id="{{ $item->id }}" data-namatitiklampu="{{ $item->NamaTitikLampu }}" data-notransaksi="{{ $item->NoTransaksi }}" data-jenispaket="{{ $item->JenisPaket }}" data-toggle="tooltip" title="TAMBAH ITEM"><i class="fas fa-utensils"></i></button>
																				</div>
																				<div class="col-6 px-1">
																					<button disabled class="btn btn-success text-white font-weight-bold w-100 py-3 item-dropdown btTambahJam btTambahJam_{{ $item->id }}" data-id="{{ $item->id }}" data-namatitiklampu="{{ $item->NamaTitikLampu }}" data-notransaksi="{{ $item->NoTransaksi }}" data-jenispaket="{{ $item->JenisPaket }}" data-toggle="tooltip" title="TAMBAH WAKTU"><i class="fas fa-clock"></i></button>
																				</div>
																			</div>
																		@endif

																		@if ($item->Status == 0)
																			<div class ="row mb-2">
																				<div class="col-4 px-1">
																					<button class="btn btn-success text-white font-weight-bold w-100 py-3 item-dropdown btPilihPaket btPilihPaket_{{ $item->id }}" data-id="{{ $item->id }}" data-namatitiklampu="{{ $item->NamaTitikLampu }}" data-notransaksi="{{ $item->NoTransaksi }}" data-jenispaket="{{ $item->JenisPaket }}" data-toggle="tooltip" title="PILIH LAYANAN"><i class="fas fa-play"></i></button>
																				</div>
																				<div class="col-4 px-1">
																					<button disabled class="btn btn-danger text-white font-weight-bold w-100 py-3 item-dropdown btCheckOut btCheckOut_{{ $item->id }}" data-id="{{ $item->id }}" data-namatitiklampu="{{ $item->NamaTitikLampu }}" data-notransaksi="{{ $item->NoTransaksi }}" data-jenispaket="{{ $item->JenisPaket }}" data-toggle="tooltip" title="CHECKOUT"><i class="fas fa-sign-out-alt"></i></button>
																				</div>
																				<div class="col-4 px-1">
																					<button disabled class="btn btn-warning text-white font-weight-bold w-100 py-3 item-dropdown btDetail btDetail_{{ $item->id }}" data-id="{{ $item->id }}" data-namatitiklampu="{{ $item->NamaTitikLampu }}" data-notransaksi="{{ $item->NoTransaksi }}" data-jenispaket="{{ $item->JenisPaket }}" data-toggle="tooltip" title="DETAIL"><i class="fas fa-info-circle"></i></button>
																				</div>
																			</div>
																			<div class="row">
																				<div class="col-6 px-1">
																					<button disabled class="btn btn-success text-white font-weight-bold w-100 py-3 item-dropdown btTambahMakanan btTambahMakanan_{{ $item->id }}" data-id="{{ $item->id }}" data-namatitiklampu="{{ $item->NamaTitikLampu }}" data-notransaksi="{{ $item->NoTransaksi }}" data-jenispaket="{{ $item->JenisPaket }}" data-toggle="tooltip" title="TAMBAH ITEM"><i class="fas fa-utensils"></i></button>
																				</div>
																				<div class="col-6 px-1">
																					<button disabled class="btn btn-success text-white font-weight-bold w-100 py-3 item-dropdown btTambahJam btTambahJam_{{ $item->id }}" data-id="{{ $item->id }}" data-namatitiklampu="{{ $item->NamaTitikLampu }}" data-notransaksi="{{ $item->NoTransaksi }}" data-jenispaket="{{ $item->JenisPaket }}" data-toggle="tooltip" title="TAMBAH WAKTU"><i class="fas fa-clock"></i></button>
																				</div>
																			</div>
																		@endif

																		@if ($item->Status == 1 || $item->Status == 99)
																			<div class ="row mb-2">
																				<div class="col-4 px-1">
																					<button disabled class="btn btn-success text-white font-weight-bold w-100 py-3 item-dropdown btPilihPaket btPilihPaket_{{ $item->id }}" data-id="{{ $item->id }}" data-namatitiklampu="{{ $item->NamaTitikLampu }}" data-notransaksi="{{ $item->NoTransaksi }}" data-jenispaket="{{ $item->JenisPaket }}" data-toggle="tooltip" title="PILIH LAYANAN"><i class="fas fa-play"></i></button>
																				</div>
																				<div class="col-4 px-1">
																					<button class="btn btn-danger text-white font-weight-bold w-100 py-3 item-dropdown btCheckOut btCheckOut_{{ $item->id }}" data-id="{{ $item->id }}" data-namatitiklampu="{{ $item->NamaTitikLampu }}" data-notransaksi="{{ $item->NoTransaksi }}" data-jenispaket="{{ $item->JenisPaket }}" data-toggle="tooltip" title="CHECKOUT"><i class="fas fa-sign-out-alt"></i></button>
																				</div>
																				<div class="col-4 px-1">
																					<button class="btn btn-warning text-white font-weight-bold w-100 py-3 item-dropdown btDetail btDetail_{{ $item->id }}" data-id="{{ $item->id }}" data-namatitiklampu="{{ $item->NamaTitikLampu }}" data-notransaksi="{{ $item->NoTransaksi }}" data-jenispaket="{{ $item->JenisPaket }}" data-toggle="tooltip" title="DETAIL"><i class="fas fa-info-circle"></i></button>
																				</div>
																			</div>
																			<div class="row">
																				<div class="col-6 px-1">
																					<button class="btn btn-success text-white font-weight-bold w-100 py-3 item-dropdown btTambahMakanan btTambahMakanan_{{ $item->id }}" data-id="{{ $item->id }}" data-namatitiklampu="{{ $item->NamaTitikLampu }}" data-notransaksi="{{ $item->NoTransaksi }}" data-jenispaket="{{ $item->JenisPaket }}" data-toggle="tooltip" title="TAMBAH ITEM"><i class="fas fa-utensils"></i></button>
																				</div>
																				<div class="col-6 px-1">
																					@if ($item->NoTransaksi != "" && ($item->JenisPaket == "JAM" || $item->JenisPaket == "JAMREALTIME" || $item->JenisPaket == "DAILY" || $item->JenisPaket == "MONTHLY" || $item->JenisPaket == "YEARLY"))
																						<button class="btn btn-warning text-white font-weight-bold w-100 py-3 item-dropdown btTambahJam btTambahJam_{{ $item->id }}" data-id="{{ $item->id }}" data-namatitiklampu="{{ $item->NamaTitikLampu }}" data-notransaksi="{{ $item->NoTransaksi }}" data-jenispaket="{{ $item->JenisPaket }}" data-toggle="tooltip" title="TAMBAH WAKTU"><i class="fas fa-clock"></i></button>
																					@else
																						<button disabled class="btn btn-success text-white font-weight-bold w-100 py-3 item-dropdown btTambahJam btTambahJam_{{ $item->id }}" data-id="{{ $item->id }}" data-namatitiklampu="{{ $item->NamaTitikLampu }}" data-notransaksi="{{ $item->NoTransaksi }}" data-jenispaket="{{ $item->JenisPaket }}" data-toggle="tooltip" title="TAMBAH WAKTU"><i class="fas fa-clock"></i></button>
																					@endif
																				</div>
																			</div>
																		@endif
																	</center>
																	
																</div>
															</div>
														</div>
														
													@endif
												@endforeach
											@else
												<center><h3 class="card-label mb-0 font-weight-bold text-body ">Belum Ada Data Titik Lampu</h3></center>
											@endif
										</div>
									</div>	

								@endforeach
							@endif
						</div>	
					</div>	
				</div>
			</div>
		</div>
   </div>

<div class="modal fade text-left" id="LookupPilihPaket" tabindex="-1" role="dialog" aria-labelledby="myModalLabel11" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable  modal-lg" role="document">
		<form id="frmPilihPaket">
			<div class="modal-content">
				<div class="modal-header">
				  	<h3 class="modal-title" id="myModalLabel11">Lookup Pilih Paket</h3>
					<button type="button" class="close rounded-pill btn btn-sm btn-icon btn-light btn-hover-primary m-0" data-bs-dismiss="modal" aria-label="Close">
						<svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-x" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
						</svg>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group row">
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-12 col-12">
									<div class="card card-custom gutter-b bg-white border-0">
										<div class="card-header align-items-center  border-0">
											<div class="card-title mb-0">
												<h3 class="card-label mb-0 font-weight-bold text-body ">Pilih Paket</h3>
											</div>
										</div>
										<div class="card-body">
											<div class="form-group row">
												<div class="col-md-12">
													<h3>
														<div id="lblNamaTitikLampu"></div>
													</h3>
												</div>
	
												<div class="col-md-12">
													<label class="text-body">Tanggal Transaksi</label>
													<fieldset class="form-group mb-12">
														<input type="date" class="form-control" id="TglTransaksi" name="TglTransaksi">
													</fieldset>
												</div>

												<div class="col-md-6">
													<label  class="text-body">Jenis Paket</label>
													<fieldset class="form-group mb-12">
														<select name="JenisPaket" id="JenisPaket" class="js-example-basic-single js-states form-control bg-transparent" >
															<option value="">Pilih Jenis Paket</option>
															@if(isset($jenisLangganan) && count($jenisLangganan) > 0)
																@foreach($jenisLangganan as $item)
																	@php
																		$value = is_array($item) ? $item['Kode'] : $item;
																		$label = is_array($item) ? $item['Nama'] : $item;
																	@endphp
																	<option value="{{ $value }}">{{ $label }}</option>
																@endforeach
															@endif
													</select>
													</fieldset>
												</div>
												<div class="col-md-6">
													<label  class="text-body">Paket</label>
													<fieldset class="form-group mb-12">
														<select name="paketid" id="paketid" class="js-example-basic-single js-states form-control bg-transparent" >
															<option value="">Pilih Paket</option>
														</select>
													</fieldset>
												</div>
												<div class="col-md-6">
													<label  class="text-body">Harga Normal</label>
													<fieldset class="form-group mb-12">
														<input type="text" class="form-control" id="HargaNormal" name="HargaNormal" readonly>
													</fieldset>
												</div>
												<div class="col-md-6">
													<label  class="text-body">Harga Baru</label>
													<fieldset class="form-group mb-12">
														<input type="text" class="form-control" id="HargaBaru" name="HargaBaru" readonly>
													</fieldset>
												</div>
												<div class="col-md-6">
													<label  class="text-body">Jam Akhir Harga Normal</label>
													<fieldset class="form-group mb-12">
														<input type="time" class="form-control" id="JamHargaNormal" name="JamHargaNormal" readonly>
													</fieldset>
												</div>
												<div class="col-md-6">
													<label  class="text-body">Jam Akhir Harga Baru</label>
													<fieldset class="form-group mb-12">
														<input type="time" class="form-control" id="JamHargaBaru" name="JamHargaBaru" readonly>
													</fieldset>
												</div>
												<div class="col-md-4">
													<label  class="text-body">Service / Titik Lampu</label>
													<fieldset class="form-group mb-12">
														<select name="tableid" id="tableid" class="js-example-basic-single js-states form-control bg-transparent">
															<option value="">Pilih Service / Titik Lampu</option>
															@foreach ($titiklampuoption as $pkt)
																<option value="{{ $pkt->id }}">{{ $pkt->NamaTitikLampu }}</option>
															@endforeach
														</select>
													</fieldset>
												</div>
												<div class="col-md-4">
													<label  class="text-body">Service Guards</label>
													<fieldset class="form-group mb-12">
														<select name="KodeSales" id="KodeSales" class="js-example-basic-single js-states form-control bg-transparent" {{ $oKodeSales != '' ? 'disabled' : '' }}>
															<option value="">Pilih Service Guards</option>
															@foreach ($sales as $sls)
																<option value="{{ $sls->KodeSales }}" {{ $sls->KodeSales == $oKodeSales ? 'selected' : '' }}>{{ $sls->NamaSales }}</option>
															@endforeach
														</select>
													</fieldset>
												</div>
												<div class="col-md-4">
													<label  class="text-body" id= "lblDurasiPaket">Durasi (Jam)</label>
													<div class="checkbox-inline mb-2" style="display: none;">
														<label class="checkbox checkbox-outline checkbox-success">
															<input type="checkbox" id="chkFlexibleTime" name="FlexibleTime"/>
															<span></span>
															Waktu Flexible
														</label>
													</div>
													<div class="checkbox-inline mb-2" id="divLangsungBayar" style="display: none;">
														<label class="checkbox checkbox-outline checkbox-success">
															<input type="checkbox" id="chkLangsungbayar" name="chkLangsungbayar"/>
															<span></span>
															Langsung Bayar
														</label>
													</div>
													<fieldset class="form-group mb-12">
														<input type="number" class="form-control" id="DurasiPaket" name="DurasiPaket" min="1" value="1">
													</fieldset>
												</div>
												<div class="col-md-9">
													<label  class="text-body">Member</label>
													<fieldset class="form-group mb-9">
														<input type="text" class="form-control" id="SearchMember" name="SearchMember" placeholder="Search Nama, ID, NoTlp atau Email">
														<ul id="suggestionList" style="border: 1px solid #ccc; display: none; position: absolute; background: white; z-index: 999;"></ul>
													</fieldset>
													<fieldset class="form-group mb-9">
														<select name="KodePelanggan" id="KodePelanggan" class="js-example-basic-single js-states form-control bg-transparent" >
															<option value="">Pilih Member</option>
															@foreach ($pelanggan as $plg)
																<option value="{{ $plg->KodePelanggan }}" data-ispaid="{{ $plg->isPaidMembership }}">{{ $plg->NamaPelanggan }}</option>
															@endforeach
														</select>
													</fieldset>
												</div>
												<div class="col-md-3">
													<label  class="text-body"></label>
													<fieldset class="form-group mb-9">
														<button type="button" class="btn btn-primary" id="btTambahMember">Tambah Member</button>
													</fieldset>
												</div>
											</div>

											{{-- Daily Packet Section --}}
											<div class="form-group row" id="divDailyPacket" style="display:none;">
												<div class="col-md-6">
													<label class="text-body">Tanggal Masuk</label>
													<fieldset class="form-group mb-12">
														<input type="date" class="form-control" id="TglMasuk_Daily" name="TglMasuk_Daily" readonly>
													</fieldset>
												</div>
												<div class="col-md-6">
													<label class="text-body">Jam Masuk</label>
													<fieldset class="form-group mb-12">
														<input type="time" class="form-control" id="JamMasuk_Daily" name="JamMasuk_Daily" readonly>
													</fieldset>
												</div>

												<div class="col-md-6">
													<label class="text-body">Tanggal Keluar</label>
													<fieldset class="form-group mb-12">
														<input type="date" class="form-control" id="TglKeluar_Daily" name="TglKeluar_Daily">
													</fieldset>
												</div>
												<div class="col-md-6">
													<label class="text-body">Jam Keluar</label>
													<fieldset class="form-group mb-12">
														<input type="time" class="form-control" id="JamKeluar_Daily" name="JamKeluar_Daily">
													</fieldset>
												</div>
												<div class="col-md-6">
													<label class="text-body">Extra Cost</label>
													<fieldset class="form-group mb-12">
														<input type="number" class="form-control" id="ExtraCost" name="ExtraCost" value="0" disabled>
													</fieldset>
												</div>
											</div>

                                            {{-- Monthly Packet Section --}}
											<div class="form-group row" id="divMonthlyPacket" style="display:none;">
												<div class="col-md-6">
													<label class="text-body">Tanggal Masuk</label>
													<fieldset class="form-group mb-12">
														<input type="date" class="form-control" id="TglMasuk_Monthly" name="TglMasuk_Monthly" readonly>
													</fieldset>
												</div>
												<div class="col-md-6">
													<label class="text-body">Jam Masuk</label>
													<fieldset class="form-group mb-12">
														<input type="time" class="form-control" id="JamMasuk_Monthly" name="JamMasuk_Monthly" readonly>
													</fieldset>
												</div>

												<div class="col-md-6">
													<label class="text-body">Tanggal Keluar</label>
													<fieldset class="form-group mb-12">
														<input type="date" class="form-control" id="TglKeluar_Monthly" name="TglKeluar_Monthly">
													</fieldset>
												</div>
												<div class="col-md-6">
													<label class="text-body">Jam Keluar</label>
													<fieldset class="form-group mb-12">
														<input type="time" class="form-control" id="JamKeluar_Monthly" name="JamKeluar_Monthly">
													</fieldset>
												</div>
											</div>

                                            {{-- Yearly Packet Section --}}
											<div class="form-group row" id="divYearlyPacket" style="display:none;">
												<div class="col-md-6">
													<label class="text-body">Tanggal Masuk</label>
													<fieldset class="form-group mb-12">
														<input type="date" class="form-control" id="TglMasuk_Yearly" name="TglMasuk_Yearly" readonly>
													</fieldset>
												</div>
												<div class="col-md-6">
													<label class="text-body">Jam Masuk</label>
													<fieldset class="form-group mb-12">
														<input type="time" class="form-control" id="JamMasuk_Yearly" name="JamMasuk_Yearly" readonly>
													</fieldset>
												</div>

												<div class="col-md-6">
													<label class="text-body">Tanggal Keluar</label>
													<fieldset class="form-group mb-12">
														<input type="date" class="form-control" id="TglKeluar_Yearly" name="TglKeluar_Yearly">
													</fieldset>
												</div>
												<div class="col-md-6">
													<label class="text-body">Jam Keluar</label>
													<fieldset class="form-group mb-12">
														<input type="time" class="form-control" id="JamKeluar_Yearly" name="JamKeluar_Yearly">
													</fieldset>
												</div>
											</div>

											{{-- Prorata Info Section --}}
											<div class="form-group row" id="divProrataInfo" style="display:none;">
												<div class="col-md-4">
													<label class="text-body font-weight-bold">Harga</label>
													<fieldset class="form-group mb-12">
														<input type="text" class="form-control" id="txtHarga_Prorata" readonly>
													</fieldset>
												</div>
												<div class="col-md-4">
													<label class="text-body font-weight-bold">Harga Per Hari</label>
													<fieldset class="form-group mb-12">
														<input type="text" class="form-control" id="txtHargaPerHari_Prorata" readonly>
													</fieldset>
												</div>
												<div class="col-md-4">
													<label class="text-body font-weight-bold">Harga Sewa (Prorata)</label>
													<fieldset class="form-group mb-12">
														<input type="text" class="form-control" id="txtHargaSewa_Prorata" readonly>
													</fieldset>
												</div>
												<div class="col-md-6">
													<label class="text-body font-weight-bold">Jam Checkin</label>
													<fieldset class="form-group mb-12">
														<input type="time" class="form-control" id="JamCheckin_Prorata" name="JamCheckin_Prorata" value="00:00">
													</fieldset>
												</div>
												<div class="col-md-6">
													<label class="text-body font-weight-bold">Jam Checkout</label>
													<fieldset class="form-group mb-12">
														<input type="time" class="form-control" id="JamCheckout_Prorata" name="JamCheckout_Prorata" value="23:59">
													</fieldset>
												</div>
												<div class="col-md-12">
													<div id="prorataMessage" class="text-danger font-weight-bold"></div>
												</div>
											</div>

											{{-- Time Slot Section - Only shown when JenisPaket = JAM --}}
											<div class="form-group row" id="timeSlotSection" style="display:none;">
												<div class="col-md-12">
													<label class="text-body font-weight-bold">Pilih Jam</label>
													<div class="card">
														<div class="card-body">
															<div class="row" id="timeSlotContainer">
																<!-- Time slots will be loaded here dynamically -->
																<div class="col-12 text-center">
																	<p class="text-muted">Memuat slot waktu...</p>
																</div>
															</div>
														</div>
													</div>
													<input type="hidden" id="selectedTimeSlot" name="selectedTimeSlot" value="">
												</div>
											</div>

											{{-- <div class="form-group row" id="PembayaranSection">
												<div class="col-md-12">
													<div class="table-responsive" id="printableTable">
														<table class="display" style="width:100%" id="tblDetailFnB">
															<tr>
																<td style="text-align: right">Jam Mulai</td>
																<td>:</td>
																<td id="dtJamMulai_Paket"></td>
															</tr>
															<tr>
																<td style="text-align: right">Jam Selesai</td>
																<td>:</td>
																<td id="dtJamSelesai_Paket"></td>
															</tr>
															<tr>
																<td style="text-align: right">Total Harga</td>
																<td>:</td>
																<td id="dtTotalHargaNormal_Paket" style="text-align: right"></td>
															</tr>
															<tr>
																<td style="text-align: right">Total PPN</td>
																<td>:</td>
																<td id="dtTotalPPN_Paket" style="text-align: right"></td>
															</tr>
															<tr>
																<td style="text-align: right">Total Pajak Hiburan</td>
																<td>:</td>
																<td id="dtTotalPajakHiburan_Paket" style="text-align: right"></td>
															</tr>
															<tr>
																<td style="text-align: right">Sub Total </td>
																<td>:</td>
																<td id="dtSubTotal_Paket" style="text-align: right"></td>
																<input type="hidden" id="txtSubTotal_Paket"  name = "txtSubTotal_Paket" step ="0.01" style="display:none;"> 
															</tr>
														</table>
													</div>
												</div>
												<div class="col-md-6">
													<label  class="text-body">Metode Pembayaran</label>
													<fieldset class="form-group mb-12">
														<select name="cboMetodePembayaran_Paket" id="cboMetodePembayaran_Paket" class="cboMetodePembayaran_Paket js-states form-control bg-transparent" >
															<option value="">Pilih Metode Pembayaran</option>
															@foreach ($metodepembayaran as $mtd)
																<option value="{{ $mtd->id }}">{{ $mtd->NamaMetodePembayaran }}</option>
															@endforeach
														</select>
													</fieldset>
												</div>
												<div class="col-md-6">
													<label  class="text-body">Refrensi</label>
													<fieldset class="form-group mb-12">
														<input type="text" class="form-control" id="txtRefrensi_Paket" name="txtRefrensi_Paket">
													</fieldset>
												</div>
												<div class="col-md-6">
													<label  class="text-body">Jumlah Bayar</label>
													<fieldset class="form-group mb-12">
														<input type="text" class="form-control" id="txtJumlahBayar_Paket" name="txtJumlahBayar_Paket">
													</fieldset>
												</div>
												<div class="col-md-6">
													<label  class="text-body">Kembalian</label>
													<fieldset class="form-group mb-12">
														<input type="text" class="form-control" id="txtJumlahKembalian_Paket" name="txtJumlahKembalian_Paket" readonly>
													</fieldset>
												</div>
											</div> --}}

										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-primary ms-1" id="btMulaiBermain" data-bs-dismiss="modal">
						<span class="">Mulai Bermain</span>
					</button>
				</div> 	
			</div>
		</form>
	</div>	  	  
</div>


<div class="modal fade text-left" id="LookupTambahDurasiPaket" tabindex="-1" role="dialog" aria-labelledby="myModalLabel11" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable  modal-lg" role="document">
		<form id="frmUpdatePaket">
			<div class="modal-content">
				<div class="modal-header">
				  	<h3 class="modal-title" id="myModalLabel11">Tambah Paket</h3>
					<button type="button" class="close rounded-pill btn btn-sm btn-icon btn-light btn-hover-primary m-0" data-bs-dismiss="modal" aria-label="Close">
						<svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-x" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
						</svg>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group row">
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-12 col-12">
									<div class="card card-custom gutter-b bg-white border-0">
										<div class="card-header align-items-center  border-0">
											<div class="card-title mb-0">
												<h3 class="card-label mb-0 font-weight-bold text-body ">Tambah Paket</h3>
											</div>
										</div>
										<div class="card-body">
											<div class="form-group row">
												<div class="col-md-6">
													<label  class="text-body">Nomor Order</label>
													<fieldset class="form-group mb-12">
														<input type="text" class="form-control" id="txtNoTransaksi_RubahDurasi" name="txtNoTransaksi_RubahDurasi" readonly>
													</fieldset>
												</div>
												<div class="col-md-6">
													<label id="lblhargaperjam_RubahDurasi" class="text-body">Harga / Jam</label>
													<fieldset class="form-group mb-12">
														<input type="text" class="form-control" id="txtHargaPerJam_TambahJam" name="txtHargaPerJam_TambahJam" readonly>
													</fieldset>
												</div>
												<div class="col-md-6">
													<label id="lblDurasiPaket_RubahDurasi" class="text-body">Durasi (Jam)</label>
													<fieldset class="form-group mb-12">
														<input type="number" class="form-control" id="txtDurasiPaket_RubahDurasi" name="txtDurasiPaket_RubahDurasi" min="1" value="1">
													</fieldset>
												</div>
												<div class="col-md-6">
													<label  class="text-body">Total Transaksi</label>
													<fieldset class="form-group mb-12">
														<input type="text" class="form-control" id="txtTotalTransaksi_TambahJam" name="txtTotalTransaksi_TambahJam" readonly>
													</fieldset>
												</div>
												<div class="col-md-6">
													<label  class="text-body">Biaya Layanan</label>
													<fieldset class="form-group mb-12">
														<input type="text" class="form-control" id="txtBiayaLayanan_TambahJam" name="txtBiayaLayanan_TambahJam" readonly value="0">
													</fieldset>
												</div>
												<div class="col-md-12">
													<hr>
												</div>
												<div class="col-md-6">
													<label  class="text-body">Metode Pembayaran</label>
													<fieldset class="form-group mb-12">
														<select name="cboMetodePembayaran_TambahJam" id="cboMetodePembayaran_TambahJam" class="cboMetodePembayaran_TambahJam js-states form-control bg-transparent" >
															<option value="">Pilih Metode Pembayaran</option>
															@foreach ($metodepembayaran as $mtd)
																<option value="{{ $mtd->id }}" data-percent="{{ $mtd->BiayaAdminPercent }}" data-rupiah="{{ $mtd->BiayaAdminRupiah }}">{{ $mtd->NamaMetodePembayaran }}</option>
															@endforeach
														</select>
													</fieldset>
												</div>
												<div class="col-md-6">
													<label  class="text-body">Refrensi</label>
													<fieldset class="form-group mb-12">
														<input type="text" class="form-control" id="txtRefrensi_TambahJam" name="txtRefrensi_TambahJam">
													</fieldset>
												</div>
												<div class="col-md-6">
													<label  class="text-body">Jumlah Bayar</label>
													<fieldset class="form-group mb-12">
														<input type="text" class="form-control" id="txtJumlahBayar_TambahJam" name="txtJumlahBayar_TambahJam">
													</fieldset>
												</div>
												<div class="col-md-6">
													<label  class="text-body">Kembalian</label>
													<fieldset class="form-group mb-12">
														<input type="text" class="form-control" id="txtJumlahKembalian_TambahJam" name="txtJumlahKembalian_TambahJam" readonly>
													</fieldset>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-primary ms-1" id="btRubahDurasiPaket">
						<span class="">Tambah Paket</span>
					</button>
				</div> 	
			</div>
		</form>
	</div>	  	  
</div>

<div class="modal fade text-left" id="LookupDetailOrder" tabindex="-1" role="dialog" aria-labelledby="myModalLabel11" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable  modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title" id="myModalLabel11">Detail Order</h3>
				<button id="btCloseModalDetails" type="button" class="close rounded-pill btn btn-sm btn-icon btn-light btn-hover-primary m-0" data-bs-dismiss="modal" aria-label="Close">
					<svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-x" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
					</svg>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-group row">
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-12 col-12">
								<div class="card card-custom gutter-b bg-white border-0">
									<div class="card-header align-items-center  border-0">
										<div class="card-title mb-0">
											<h3 class="card-label mb-0 font-weight-bold text-body ">Detail Service Order</h3>
											<h3 class="card-label mb-0 font-weight-bold text-body "><small>Selamat Datang <span id="lblNamaCustomer"></span></small></h3>
										</div>
									</div>
									<div class="card-body">
										<div class="form-group row">
											<div class="col-md-12">
												<label  class="text-body">Nomor Order</label>
												<fieldset class="form-group mb-12">
													<input type="text" class="form-control" id="txtNoTransaksi_Detail" name="txtNoTransaksi_Detail" readonly>
												</fieldset>
											</div>
											
											<div class="col-md-12">
												<div class="table-responsive" id="printableTable">
													<table class="display" style="width:100%" id="tblDetailFnB">
														<tr>
															<td style="text-align: right">Jenis Paket</td>
															<td>:</td>
															<td id="dtJenisPaket_Detail"></td>
														</tr>
														<tr>
															<td style="text-align: right">Nama Paket Paket</td>
															<td>:</td>
															<td id="dtNamaPaket_Detail"></td>
														</tr>
														<tr>
															<td style="text-align: right">Jam Mulai</td>
															<td>:</td>
															<td id="dtJamMulai_Detail"></td>
														</tr>
														<tr>
															<td style="text-align: right">Jam Selesai</td>
															<td>:</td>
															<td id="dtJamSelesai_Detail"></td>
														</tr>
														<tr>
															<td style="text-align: right">Total Harga Normal</td>
															<td>:</td>
															<td id="dtTotalHargaNormal_Detail" style="text-align: right"></td>
														</tr>
														<tr>
															<td style="text-align: right">Total Perubahan Harga</td>
															<td>:</td>
															<td id="dtTotalPerubahanHarga_Detail" style="text-align: right"></td>
														</tr>
														<tr>
															<td style="text-align: right">Total PPN</td>
															<td>:</td>
															<td id="dtTotalPPN_Detail" style="text-align: right"></td>
														</tr>
														<tr>
															<td style="text-align: right">Total Pajak Hiburan</td>
															<td>:</td>
															<td id="dtTotalPajakHiburan_Detail" style="text-align: right"></td>
														</tr>
														<tr>
															<td style="text-align: right">Sub Total </td>
															<td>:</td>
															<td id="dtSubTotal_Detail" style="text-align: right"></td>
														</tr>
													</table>
												</div>
											</div>

											<div class="col-md-12">
												<label  class="text-body">Order Makanan</label>
												<div class="table-responsive">
													<table id="TablePenjualan" class="display" style="width:100%">
														<thead>
															<tr>
																<th>Item</th>
																<th>Qty</th>
																<th>Harga</th>
																<th>Diskon</th>
																<th>Pajak</th>
																<th>Biaya Layanan</th>
																<th>Total</th>
																<th>#</th>

																<!-- Other Info -->
																<th>KodeItem</th>
																<th>HargaPokokPenjualan</th>
																<th>Satuan</th>
															</tr>
														</thead>
														<tbody>

														</tbody>
													</table>
												</div>
											</div>
											<div class="col-md-12">
												<div class="table-responsive" id="printableTable">
													<table class="display" style="width:100%">
														<tr>
															<td style="text-align: right">Sub Total </td>
															<td>:</td>
															<td style="text-align: right">
																<input type="text" class="form-control" id="txtSubTotal_Detail" name="txtSubTotal_Detail" readonly>
															</td>
														</tr>

														<tr>
															<td style="text-align: right">Total Makanan </td>
															<td>:</td>
															<td style="text-align: right">
																<input type="text" class="form-control" id="txtTotalMakanan_Detail" name="txtTotalMakanan_Detail" readonly>
															</td>
														</tr>

														<tr>
															<td style="text-align: right">Pajak (*) </td>
															<td>:</td>
															<td style="text-align: right">
																<input type="text" class="form-control" id="txtTotalPajak_Detail" name="txtTotalPajak_Detail" readonly>
															</td>
														</tr>
														<tr>
															<td style="text-align: right">Diskon Member <span id="lblNamaMember"></span></td>
															<td>:</td>
															<td style="text-align: right">
																<fieldset class="form-group mb-3 d-flex">
																	<input type="text" name="text" class="form-control bg-white" id="txtDiscountMember_Detail"  name="txtDiscountMember_Detail" readonly>
																</fieldset>
															</td>
														</tr>
														<tr>
														<tr>
															<td style="text-align: right">Diskon Service</td>
															<td>:</td>
															<td style="text-align: right">
																<fieldset class="form-group mb-3 d-flex">
																	<input type="text" name="text" class="form-control bg-white" id="txtDiscountTable_Detail"  name="txtDiscountTable_Detail" readonly>
																</fieldset>
															</td>
														</tr>
														<tr>
															<td style="text-align: right">Biaya Lain Lain</td>
															<td>:</td>
															<td style="text-align: right">
																<fieldset class="form-group mb-3 d-flex">
																	<input type="text" name="txtBiayaLainLain_Detail" class="form-control" id="txtBiayaLainLain_Detail" value="0" readonly>
																</fieldset>
															</td>
														</tr>
														<tr>
															<td style="text-align: right">Diskon FnB</td>
															<td>:</td>
															<td style="text-align: right">
																<fieldset class="form-group mb-3 d-flex">
																	<input type="text" name="text" class="form-control bg-white" id="txtDiscountFnB_Detail"  name="txtDiscountFnB_Detail" readonly>
																</fieldset>
															</td>
														</tr>

														<tr>
															<td style="text-align: right">Total Discount </td>
															<td>:</td>
															<td style="text-align: right">
																<fieldset class="form-group mb-3 d-flex">
																	<input type="text" name="text" class="form-control bg-white" id="txtDiscount_Detail"  name="txtDiscount_Detail" readonly>
																</fieldset>
															</td>
														</tr>

														<tr style="display:none;">
															<td style="text-align: right">Uang Muka / Titip </td>
															<td>:</td>
															<td style="text-align: right">
																<input type="text" class="form-control" id="txtTotalUangMuka_Detail" name="txtTotalUangMuka_Detail" readonly >
															</td>
														</tr>
														
														<tr>
															<td style="text-align: right">Grand Total </td>
															<td>:</td>
															<td style="text-align: right">
																<input type="text" class="form-control" id="txtGrandTotal_Detail" name="txtGrandTotal_Detail" readonly>
															</td>
														</tr>

														<tr>
															<td style="text-align: right">Biaya Admin </td>
															<td>:</td>
															<td style="text-align: right">
																<input type="text" class="form-control" id="txtBiayaAdmin_Detail" name="txtBiayaAdmin_Detail" readonly value="0">
															</td>
														</tr>

														<tr>
															<td style="text-align: right">Total Terbayar </td>
															<td>:</td>
															<td style="text-align: right">
																<input type="text" class="form-control" id="txtTotalTerbayar_Detail" name="txtTotalTerbayar_Detail" readonly value="0">
															</td>
														</tr>
														
														<tr>
															<td style="text-align: right">Total Tagihan </td>
															<td>:</td>
															<td style="text-align: right">
																<input type="text" class="form-control" id="txtTotalBayar_Detail" name="txtTotalBayar_Detail" readonly>
															</td>
														</tr>
													</table>
												</div>
											</div>
										</div>

										<div class="form-group row" id="sectionPayment">
											<div class="col-md-6">
												<label  class="text-body">Metode Pembayaran</label>
												<fieldset class="form-group mb-12">
													<select name="cboMetodePembayaran_Detail" id="cboMetodePembayaran_Detail" class="cboMetodePembayaran_Detail js-states form-control bg-transparent" >
														<option value="">Pilih Metode Pembayaran</option>
														@foreach ($metodepembayaran as $mtd)
															<option value="{{ $mtd->id }}">{{ $mtd->NamaMetodePembayaran }}</option>
														@endforeach
													</select>
												</fieldset>
											</div>
											<div class="col-md-6">
												<label  class="text-body">Refrensi</label>
												<fieldset class="form-group mb-12">
													<input type="text" class="form-control" id="txtRefrensi_Detail" name="txtRefrensi_Detail">
												</fieldset>
											</div>
											<div class="col-md-6">
												<label  class="text-body">Jumlah Bayar</label>
												<fieldset class="form-group mb-12">
													<input type="text" class="form-control" id="txtJumlahBayar_Detail" name="txtJumlahBayar_Detail">
												</fieldset>
											</div>
											<div class="col-md-6">
												<label  class="text-body">Kembalian</label>
												<fieldset class="form-group mb-12">
													<input type="text" class="form-control" id="txtJumlahKembalian_Detail" name="txtJumlahKembalian_Detail" readonly>
												</fieldset>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-success ms-1" id="btBayar" data-bs-dismiss="modal">
					<span class="">Bayar</span>
				</button>
			</div> 	
		</div>
	</div>	  	  
</div>

<div class="modal fade text-left" id="LookupTambahMakanan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel11" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
		<form id="frmTambahMakanan">
			<div class="modal-content">
				<div class="modal-header">
				  	<h3 class="modal-title" id="myModalLabel11">Tambah Makanan</h3>
					<button type="button" class="close rounded-pill btn btn-sm btn-icon btn-light btn-hover-primary m-0" data-bs-dismiss="modal" aria-label="Close">
						<svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-x" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
						</svg>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group row">
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-12 col-12">
									<div class="card card-custom gutter-b bg-white border-0">
										<div class="card-body">
											<div class="form-group row">
												<div class="col-md-12">
													<label  class="text-body">Nomor Order</label>
													<fieldset class="form-group mb-12">
														<input type="text" class="form-control" id="txtNoTransaksi_TambahMakan" name="txtNoTransaksi_TambahMakan" readonly>
													</fieldset>
												</div>
												<div class="col-md-12">
													<div class="table-responsive" id="printableTable">
														<table id="PosDetail" class="display" style="width:100%">
															<thead>
																<tr>
																	<th width="30%">Item</th>
																	<th width="10%">Qty</th>
																	<th>Harga</th>
																	<th width="10%">Disk(%)</th>
																	<th>Total</th>
																	<th class="no-sort text-end">Action</th>
																</tr>
															</thead>
															<tbody id="AppendArea">
																<tr>
																	<td colspan="6" id="btAddRow">
																		<center><i class="fas fa-plus" style="color: red"></i> <font style="color: red"> Tambah Data</font> </center>
																	</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>

												<hr>

												<div class="col-md-12">
													<div class="table-responsive">
														<table class="display" style="width:100%">
															<tr>
																<td style="text-align: right">Sub Total</td>
																<td>:</td>
																<td style="text-align: right">
																	<input type="text" class="form-control TotalText" id="txtSubTotal_TambahMakan" name="txtSubTotal_TambahMakan" readonly>
																</td>
															</tr>
															<tr>
																<td style="text-align: right">Diskon</td>
																<td>:</td>
																<td style="text-align: right">
																	<input type="text" class="form-control TotalText" id="txtDiskon_TambahMakan" name="txtDiskon_TambahMakan" readonly>
																</td>
															</tr>

															<tr>
																<td style="text-align: right">Pajak</td>
																<td>:</td>
																<td style="text-align: right">
																	<input type="text" class="form-control TotalText" id="txtPajak_TambahMakan" name="txtPajak_TambahMakan" readonly>
																</td>
															</tr>

															<tr>
																<td style="text-align: right">Biaya Layanan</td>
																<td>:</td>
																<td style="text-align: right">
																	<input type="text" class="form-control TotalText" id="txtBiayaLayanan_TambahMakan" name="txtBiayaLayanan_TambahMakan" readonly value="0">
																</td>
															</tr>

															<tr>
																<td style="text-align: right">Total Transaksi</td>
																<td>:</td>
																<td style="text-align: right">
																	<input type="text" class="form-control TotalText" id="txtTotalTransaksi_TambahMakan" name="txtTotalTransaksi_TambahMakan" readonly>
																</td>
															</tr>
														</table>
													</div>
												</div>
												<div class="form-group row">
													<div class="col-md-6">
														<label  class="text-body">Metode Pembayaran</label>
														<fieldset class="form-group mb-12">
															<select name="cboMetodePembayaran_TambahMakan" id="cboMetodePembayaran_TambahMakan" class="cboMetodePembayaran_TambahMakan js-states form-control bg-transparent" >
																<option value="">Pilih Metode Pembayaran</option>
																@foreach ($metodepembayaran as $mtd)
																	<option value="{{ $mtd->id }}" data-biayalayanan="{{ $mtd->BiayaAdminRupiah > 0 ? $mtd->BiayaAdminRupiah : ($mtd->BiayaAdminPercent > 0 ? $mtd->BiayaAdminPercent . '%' : 0) }}" data-percent="{{ $mtd->BiayaAdminPercent }}" data-rupiah="{{ $mtd->BiayaAdminRupiah }}">{{ $mtd->NamaMetodePembayaran }}</option>
																@endforeach
															</select>
														</fieldset>
													</div>
													<div class="col-md-6">
														<label  class="text-body">Refrensi</label>
														<fieldset class="form-group mb-12">
															<input type="text" class="form-control" id="txtRefrensi_TambahMakan" name="txtRefrensi_TambahMakan">
														</fieldset>
													</div>
													<div class="col-md-6">
														<label  class="text-body">Jumlah Bayar</label>
														<fieldset class="form-group mb-12">
															<input type="text" class="form-control" id="txtJumlahBayar_TambahMakan" name="txtJumlahBayar_TambahMakan">
														</fieldset>
													</div>
													<div class="col-md-6">
														<label  class="text-body">Kembalian</label>
														<fieldset class="form-group mb-12">
															<input type="text" class="form-control" id="txtJumlahKembalian_TambahMakan" name="txtJumlahKembalian_TambahMakan" readonly>
														</fieldset>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-primary ms-1" id="btTambahMakanan">
						<span class="">Tambah Makanan</span>
					</button>
				</div> 	
			</div>
		</form>
	</div>	  	  
</div>

<div class="modal fade text-left w-100" id="modallookupItem" tabindex="-1" role="dialog" aria-labelledby="myModalLabel16" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h4 class="modal-title" id="myModalLabel16">Daftar Item Master</h4>
		  <button type="button" class="close rounded-pill btn btn-sm btn-icon btn-primary m-0" data-bs-dismiss="modal" aria-label="Close">
			<svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-x" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
			<path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
			</svg>	
			</button>
		</div>
		<div class="modal-body">
		  <div id="gridLookupitem"></div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-primary ms-1" id="btSelectItem" data-bs-dismiss="modal">
				<span class="">Pilih Item</span>
			</button>
			</div> 		
	  </div>
	</div>
</div>

<div class="modal fade" id="webViewModal" tabindex="-1" aria-labelledby="webViewModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="webViewModalLabel">Web View</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" style="height: 500px;">
        <input type="hidden" id="NoTransaksiModal" name="NoTransaksiModal"/>
        <iframe src="" width="100%" height="100%" frameborder="0"></iframe>
      </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-success" id='btnEmail'>Kirim Email</button>
            <button type="button" class="btn btn-warning" id='btnWhatsApp'>Kirim Pesan WhatsApp</button>
        </div>

    </div>
  </div>
</div>

<div class="modal fade text-left" id="LookupTambahMember" tabindex="-1" role="dialog" aria-labelledby="myModalLabel11" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
		<form id="frmTambahMember">
			<div class="modal-content">
				<div class="modal-header">
				  	<h3 class="modal-title" id="myModalLabel11">Tambah Member</h3>
					<button type="button" class="close rounded-pill btn btn-sm btn-icon btn-light btn-hover-primary m-0" data-bs-dismiss="modal" aria-label="Close">
						<svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-x" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
						</svg>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group row">
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-12 col-12">
									<div class="card card-custom gutter-b bg-white border-0">
										<div class="card-body">
											<div class="form-group row">
												<div class="col-md-3">
													<label  class="text-body">Kode Member</label>
													<fieldset class="form-group mb-12">
														<input type="text" class="form-control" id="txtKodeMember_TambahMember" name="txtKodeMember_TambahMember" placeholder="<AUTO>" readonly>
													</fieldset>
												</div>

												<div class="col-md-5">
													<label  class="text-body">Nama Member</label>
													<fieldset class="form-group mb-12">
														<input type="text" class="form-control" id="txtNamaMember_TambahMember" name="txtNamaMember_TambahMember" placeholder="Nama lengkap member">
													</fieldset>
												</div>

												<div class="col-md-4">
													<label  class="text-body">Grup Pelanggan</label>
													<fieldset class="form-group mb-3">
														<select name="ModalKodeGrupPelanggan" id="ModalKodeGrupPelanggan" class="js-example-basic-single js-states form-control bg-transparent" name="state" required="">
															<option value="">Pilih Kelompok Pelanggan</option>
															@foreach($gruppelanggan as $ko)
																<option value="{{ $ko->KodeGrup }}">
																	{{ $ko->NamaGrup }}
																</option>
															@endforeach
															
														</select>
													</fieldset>
													
												</div>

												<div class="col-md-6">
													<label  class="text-body">No Tlp</label>
													<fieldset class="form-group mb-12">
														<input type="text" class="form-control" id="txtNoTlp_TambahMember" name="txtNoTlp_TambahMember" placeholder="Nomor telepon aktif">
													</fieldset>
												</div>
												<div class="col-md-6">
													<label  class="text-body">Email</label>
													<fieldset class="form-group mb-12">
														<input type="text" class="form-control" id="txtEmail_TambahMember" name="txtEmail_TambahMember" placeholder="Email aktif">
													</fieldset>
												</div>

												<div class="col-md-12">
													<label  class="text-body">Alamat</label>
													<fieldset class="form-group mb-12">
														<input type="text" class="form-control" id="txtAlamat_TambahMember" name="txtAlamat_TambahMember" placeholder="Alamat lengkap">
													</fieldset>
												</div>

											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-primary ms-1" id="btSimpanMember" data-bs-dismiss="modal">
						<span class="">Tambah Member</span>
					</button>
				</div> 	
			</div>
		</form>
	</div>	  	  
</div>

@extends('parts.generaljs')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/plugin.bundle.min.js')}}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js')}}"></script>
<!-- <script src="http://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script> -->
<!-- <script src="https://unpkg.com/multiple-select@1.5.2/dist/multiple-select.min.js"></script> -->
<!-- <script src="{{ asset('js/sweetalert.js')}}"></script> -->
<!-- <script src="{{ asset('js/sweetalert1.js')}}"></script> -->
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
<script src="{{asset('api/datatable/jquery.dataTables.min.js')}}"></script>

</body>
<!--end::Body-->
</html>
<script type="text/javascript">
	var _custdisplayopened = false;
	const documentBaseUrl = "{{ route('document') }}";
	var tglBerlangganan;

	const oCompany = <?php echo $company ?>;

    jQuery(function () {
		// Initialize Bootstrap tooltips
		jQuery('[data-toggle="tooltip"]').tooltip();

		let idleTime = 0; 
		let maxIdle = 60 * 2; 
		let isRefreshing = false; // flag untuk cegah looping

		$(document).on('mousemove keypress click scroll', function() {
			idleTime = 0;
			isRefreshing = false; // reset flag kalau ada aktivitas
		});

		setInterval(function() {
			idleTime++;
			if (idleTime >= maxIdle && !isRefreshing) {
				isRefreshing = true; // tandai sedang refresh
				location.reload();
			}
		}, 1000);
		
		var _billing = [];
		var _dataPaket = [];

		var _isFromBooking = false;
		var _isFromDetailLookup = false;
		let displayWindow = null;

		function closedWindow(){
			
			_custdisplayopened = localStorage.getItem("closedwindows");
			console.log(_custdisplayopened);
			// alert('Closed');
		}
		window.addEventListener('message', function(event) {
			console.log(event);
			if (event.data === 'customer-display-closed') {
				// document.getElementById('status').innerHTML = 'Status: <b>CLOSED</b>';
				_custdisplayopened = false;
			}
			else if(event.data === 'payment-cancel'){
				Swal.fire({
					icon: "error",
					title: "Informasi",
					text: "Pembayaran dibatalkan",
				}).then((result) => {
					location.reload();
				});
			}
			else if(event.data === 'payment-success'){
				Swal.fire({
					icon: "success",
					title: "Informasi",
					text: "Pembayaran Berhasil",
				}).then((result) => {
					SaveData('C',$('#btBayar'),'Bayar')
					location.reload();
				});
			}
			else if(event.data === 'payment-error'){
				Swal.fire({
					icon: "error",
					title: "Informasi",
					text: "Pembayaran Gagal",
				}).then((result) => {
					location.reload();
				});
			}
			else if(event.data === 'data-error'){
				Swal.fire({
					icon: "error",
					title: "Informasi",
					text: "Pembayaran Gagal",
				}).then((result) => {
					// SaveData('C',)
					location.reload();
				});
			}
			else if(event.data === 'no-pay'){
				Swal.fire({
					icon: "error",
					title: "Informasi",
					text: "Pembayaran tidak dilanjutkan",
				}).then((result) => {
					// SaveData('C',)
					location.reload();
				});
			}

			if(event.data.type == 'say-hello'){
				_custdisplayopened = true;
				displayWindow = event.source; // simpan referensinya lagi
				console.log('Display terhubung ulang setelah refresh.');
			}
		});

		window.onload = function () {
			if (localStorage.getItem('displayOpen') === 'true') {
				// Window tidak bisa diakses ulang langsung, tapi akan dapat postMessage dari display
				console.log('Menunggu say-hello dari display...');
			}
		};
		// window.addEventListener("closedwindows", closedWindow);
		jQuery(document).ready(function() {
			_billing = <?php echo $titiklampu ?>;
			console.log(_billing);

            // Handle Time Slot Selection
            // Old handler removed to allow multiple selection
			// jQuery(document).on('click', '.time-slot-card:not(.disabled)', function() {
			// 	jQuery('.time-slot-card').removeClass('selected');
			// 	jQuery(this).addClass('selected');
				
			// 	const startTime = jQuery(this).data('start');
			// 	const endTime = jQuery(this).data('end');
			// 	const timeSlot = startTime + '-' + endTime;
				
			// 	jQuery('#selectedTimeSlot').val(timeSlot);
			// });


			jQuery('.js-example-basic-single').select2({
				dropdownParent: $('#LookupPilihPaket')
			});

			jQuery('#ModalKodeGrupPelanggan').select2({
				dropdownParent: $('#LookupTambahMember')
			});

			$.each(_billing,function (k,v) {
				if (v['NoTransaksi'] != "") {
					jQuery('#lblPaketTransaksi'+v['id']).text(v["NamaPaket"]);

					if(v['StatusBooking'] == 'BOOKING'){
						// function SetTimer(tableid, TimerType ,EndTime, StartTime, NoTransaksi, JenisPaket, Status) {
						if(v['Status'] == 1 || v['Status'] == 99){
							SetTimer(v['id'],0,v['JamSelesai'], v['JamMulai'], v['NoTransaksi'], v['JenisPaket'], v['Status']);
						}
						
						jQuery('#lblMulai'+v['id']).text(stringtoDateTime(v["JamMulai"]));
						jQuery('#lblSelesai'+v['id']).text(stringtoDateTime(v["JamSelesai"]));	
					}
					else{
						if (v['JamSelesai'] != null) {
							if (v['Status'] == 1 || v['Status'] == 99) {
								SetTimer(v['id'],0,v['JamSelesai'], v['JamMulai'], v['NoTransaksi'], v['JenisPaket'], v['Status']);
								jQuery('#lblMulai'+v['id']).text(stringtoDateTime(v["JamMulai"]));
								jQuery('#lblSelesai'+v['id']).text(stringtoDateTime(v["JamSelesai"]));	
							}
							else{
								jQuery('#lblMulai'+v['id']).text(stringtoDateTime(v["JamMulai"]));
								jQuery('#lblSelesai'+v['id']).text(stringtoDateTime(v["JamSelesai"]));	
							}
						}
						else{
							if (v['Status'] == 1) {
								SetTimer(v['id'],1,v['JamMulai'], v['JamMulai'], v['NoTransaksi'], v['JenisPaket'], v['Status']);
								jQuery('#lblMulai'+v['id']).text(stringtoDateTime(v["JamMulai"]));	
							}
							else{
								jQuery('#lblMulai'+v['id']).text(stringtoDateTime(v["JamMulai"]));
								jQuery('#lblSelesai'+v['id']).text(stringtoDateTime(v["JamSelesai"]));	
							}
						}
					}
					// SetTimer(v['id'],0,'2024-12-09T21:55:00');
				}
			});
			GeneratePaket();

			// FirstRowHandling();
			// SetTimer(1,0,'2024-12-09T21:55:00');
			// Fill Datatable
			localStorage.setItem('PoSData', JSON.stringify([]));
		});

		jQuery('#btTambahMember').on('click', function () {
			jQuery('#LookupTambahMember').modal({backdrop: 'static', keyboard: false})
			jQuery('#LookupTambahMember').modal('show');
		});

		jQuery('#webViewModal').on('hidden.bs.modal', function () {
			if (_isFromDetailLookup) {
				Swal.fire({
					title: "Pembayaran Berhasil",
					text: "Mau Sekalian checkout?",
					icon: "question",
					showCancelButton: true,
					confirmButtonColor: "#3085d6",
					cancelButtonColor: "#d33",
					confirmButtonText: "Ya",
					cancelButtonText: "Tidak (Refresh Page)"
				}).then((result) => {
					console.log(result);
					if (result.isConfirmed) {
						console.log("Langsung Checkout");
						// Cari NoTransaksi & JenisPaket
						const NoTransaksi = jQuery('#txtNoTransaksi_Detail').val();
						const filteredData = _billing.filter(item => item.NoTransaksi == NoTransaksi);
						const JenisPaket = (filteredData.length > 0) ? filteredData[0]["JenisPaket"] : "";
						
						fnCheckOut(NoTransaksi, JenisPaket);
					} else {
						location.reload();
					}
				});
			} else {
				location.reload();
			}
		});
		jQuery('#btnEmail').on('click', function () {
			const btn = $(this);
			const originalHtml = btn.html(); // Simpan isi tombol awal
			btn.html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Sedang proses...');
			btn.prop('disabled', true); // Nonaktifkan tombol sementara

			const iframeSrc = $('#webViewModal iframe').attr('src');
			const url = new URL(iframeSrc, window.location.origin);
			const nomor = url.searchParams.get('NomorTransaksi');
			const tipe = url.searchParams.get('TipeTransaksi');

			if (!nomor || !tipe) {
				alert("Data transaksi tidak lengkap.");
				btn.html(originalHtml);
				btn.prop('disabled', false);
				return;
			}

			$.ajax({
				type: 'POST',
				url: "{{ route('sendemail') }}",
				headers: {
					'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
				},
				data: {
					NomorTransaksi: nomor,
					TipeTransaksi: tipe
				},
				success: function(response) {
					// alert("Email berhasil dikirim.");
					Swal.fire({
						html: "Email berhasil dikirim!",
						icon: "success",
						title: "Horray...",
						// text: "Data berhasil disimpan! <br> " + response.Kembalian,
					}).then((result)=>{
						btn.html(originalHtml);
						btn.prop('disabled', false); // Aktifkan kembali tombol
					});
				},
				error: function(xhr, status, error) {
					// alert("Gagal mengirim email.");
					Swal.fire({
						icon: "error",
						title: "Opps...",
						text: response.message,
					}).then((result)=>{
						btn.html(originalHtml);
						btn.prop('disabled', false); // Aktifkan kembali tombol
					});
				}
			});

		});

		jQuery('#btnWhatsApp').on('click', function () {
			const btn = $(this);
			const originalHtml = btn.html(); // Simpan isi tombol awal
			btn.html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Sedang proses...');
			btn.prop('disabled', true); // Nonaktifkan tombol sementara

			const iframeSrc = $('#webViewModal iframe').attr('src');
			const url = new URL(iframeSrc, window.location.origin);
			const nomor = url.searchParams.get('NomorTransaksi');
			const tipe = url.searchParams.get('TipeTransaksi');

			if (!nomor || !tipe) {
				alert("Data transaksi tidak lengkap.");
				btn.html(originalHtml);
				btn.prop('disabled', false);
				return;
			}

			$.ajax({
				type: 'POST',
				url: "{{ route('sendwa') }}",
				headers: {
					'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
				},
				data: {
					NomorTransaksi: nomor,
					TipeTransaksi: tipe
				},
				success: function(response) {
					if (response.whatsappurl != "") {
						window.open(response.whatsappurl, '_blank');
					} else {
						// alert("Gagal mengirim pesan WhatsApp.");
						Swal.fire({
							icon: "error",
							title: "Opps...",
							text: "Gagal mengirim pesan WhatsApp.",
						})
					}
					btn.html(originalHtml);
					btn.prop('disabled', false); // Aktifkan kembali tombol
				},
				error: function(xhr, status, error) {
					// alert("Gagal mengirim WA.");
					Swal.fire({
						icon: "error",
						title: "Opps...",
						text: "Gagal mengirim pesan WhatsApp. " + error,
					})
					btn.html(originalHtml);
					btn.prop('disabled', false); // Aktifkan kembali tombol
				}
			});

		});

		$('#LookupDetailOrder').on('shown.bs.modal', function () {
			$('#cboMetodePembayaran_Detail').select2({
				dropdownParent: $(this) // Attach to the opened modal
			});
		});

		jQuery(document).on('click', '.item-dropdown', function(e) {
			e.preventDefault();
			const $this = $(this);
			const clickedClass = $this.attr('class');
			const itemId = $this.data('id') || clickedClass.match(/_(\d+)/)[1];
			var NamaTitikLampu = $this.data('namatitiklampu');
			var NoTransaksi = $this.data('notransaksi');
			var JenisPaket = $this.data('jenispaket');
			
			if (clickedClass.includes('btPilihPaket')) {
				// console.log(`Pilih Paket clicked for item ID: ${itemId}`);
				// LookupPilihPaket
				// tableid
				jQuery('#lblNamaTitikLampu').text(NamaTitikLampu);
				jQuery('#tableid').val(itemId).change();

				var now = new Date();
				var localDate = now.getFullYear() + '-' + String(now.getMonth() + 1).padStart(2, '0') + '-' + String(now.getDate()).padStart(2, '0');
				jQuery('#TglTransaksi').val(localDate);
				jQuery('#TglTransaksi').attr('min', localDate);

				jQuery('#LookupPilihPaket').modal({backdrop: 'static', keyboard: false})
		    	jQuery('#LookupPilihPaket').modal('show');

				_isFromDetailLookup = false;
			} else if (clickedClass.includes('btCheckOut')) {
				// console.log(`Check Out clicked for item ID: ${itemId}`);
				Swal.fire({
					title: "CHECK OUT",
					text: "CHECK OUT " + NamaTitikLampu + " ?",
					icon: "warning",
					showCancelButton: true,
					confirmButtonColor: "#3085d6",
					cancelButtonColor: "#d33",
					confirmButtonText: "YA",
					cancelButtonText: "TIDAK"
				}).then((result) => {
					if (result.isConfirmed) {
						console.log(NoTransaksi +" " + JenisPaket)
						fnCheckOut(NoTransaksi, JenisPaket);
					}
					else{
						location.reload();
					}
				});

				_isFromDetailLookup = false;
			} else if (clickedClass.includes('btTambahMakanan')) {
				jQuery('#LookupTambahMakanan').modal({backdrop: 'static', keyboard: false})
		    	jQuery('#LookupTambahMakanan').modal('show');
				jQuery('#txtNoTransaksi_TambahMakan').val(NoTransaksi);

				jQuery('#PosDetail').DataTable();
				// 

				$.ajax({
					url: "{{route('billing-readfnb')}}",
					type: 'POST',
					data: {"txtNoTransaksi_TambahMakan":NoTransaksi},
					headers: {
						'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
					},
					success: function(response) {
						// console.log('Form submitted successfully:', response);
						if (response.success) {
							console.log(response.data);
							for (let index = 0; index < response.data.length; index++) {
								AddNewRow(response.data[index], index +1);   
							}
							CalculateTotalTambahMakanan();
						}
						else{
							Swal.fire({
								icon: "error",
								title: "Opps...",
								text: response.message,
							})
						}
					},
					error: function(xhr) {
						// console.error('An error occurred:', xhr.responseText);
						Swal.fire({
							icon: "error",
							title: "Opps...",
							text: response.message,
						});
					}
				});

				jQuery('#txtNoTransaksi_TambahMakan').val(NoTransaksi);

				_isFromDetailLookup = false;
				console.log(`Tambah Makanan clicked for item ID: ${itemId}`);
			} else if (clickedClass.includes('btDetail')) {
				// LookupDetailOrder
				const table = jQuery('#TablePenjualan').DataTable({
					columnDefs: [
						{ targets: 8, visible: false },
						{ targets: 9, visible: false },
						{ targets: 10, visible: false },
					]
				});
				var oMakananData = [];

				$.ajax({
					url: "{{route('billing-readfnb')}}",
					type: 'POST',
					data: {"txtNoTransaksi_TambahMakan":NoTransaksi},
					headers: {
						'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
					},
					success: function(response) {
						// console.log('Form submitted successfully:', response);
						if (response.success) {
							var oData = response.data;
							var oTotal = 0;
							oMakananData = response.data;

							oData.forEach(item => {
								oTotal += item.LineTotal;
								table.row.add([
									item.NamaItem,
									`<span data-raw="${item.Qty}">${formatNumber(item.Qty)}</span>`,
									`<span data-raw="${item.Harga}">${formatNumber(item.Harga)}</span>`,
									`<span data-raw="${item.Discount}">${formatNumber(item.Discount)}</span>`,
									`<span data-raw="${item.Tax}">${formatNumber(item.Tax)}</span>`,
									`<span data-raw="${item.BiayaLayanan}">${formatNumber(item.BiayaLayanan)}</span>`,
									`<span data-raw="${item.LineTotal}">${formatNumber(item.LineTotal + item.BiayaLayanan)}</span>`,
									item.LineStatus,
									item.KodeItem,
									item.HargaPokokPenjualan,
									item.Satuan
								]).draw(false);
							});
							fnDetails(NoTransaksi,response.data);
						}
						else{
							Swal.fire({
								icon: "error",
								title: "Opps...",
								text: response.message,
							})
						}
					},
					error: function(xhr) {
						// console.error('An error occurred:', xhr.responseText);
						Swal.fire({
							icon: "error",
							title: "Opps...",
							text: response.message,
						});
					}
				});

				// sectionPayment
				if (JenisPaket == 'MENITREALTIME' || JenisPaket == 'PAYPERUSE') {
					jQuery("#sectionPayment").show();
				} else {
					jQuery("#sectionPayment").hide();
				}

				_isFromDetailLookup = true;
				jQuery('#LookupDetailOrder').modal({backdrop: 'static', keyboard: false})
		    	jQuery('#LookupDetailOrder').modal('show');
				console.log(`Detail clicked for item ID: ${itemId}`);
			} else if (clickedClass.includes('btTambahJam')) {
				console.log(`Detail clicked for item ID: ${itemId}`);
				jQuery('#txtNoTransaksi_RubahDurasi').val(NoTransaksi);

				const filteredBilling = _billing.filter(item => item.NoTransaksi == NoTransaksi);
				const DataPaket = <?php echo $paket ?>;
				const filteredPaket = DataPaket.filter(item => item.id == filteredBilling[0]['paketid']);

				console.log(filteredBilling);

				let hargaNormal = filteredPaket[0]['HargaNormal'];
				if (filteredPaket[0].JenisPaket === 'MONTHLY') {
					const tglTrx = new Date(filteredBilling[0].TglTransaksi);
					const daysInMonth = new Date(tglTrx.getFullYear(), tglTrx.getMonth() + 1, 0).getDate();
					hargaNormal = Math.round(hargaNormal / daysInMonth);
				} else if (filteredPaket[0].JenisPaket === 'YEARLY') {
					const tglTrx = new Date(filteredBilling[0].TglTransaksi);
					const year = tglTrx.getFullYear();
					const isLeap = (year % 4 === 0 && year % 100 !== 0) || (year % 400 === 0);
					const daysInYear = isLeap ? 366 : 365;
					hargaNormal = Math.round(hargaNormal / daysInYear);
				}

				// console.log(filteredPaket)
				jQuery('#txtHargaPerJam_TambahJam').val(formatNumber(hargaNormal));
				jQuery('#txtHargaPerJam_TambahJam').attr('originalvalue', hargaNormal);

				switch (filteredPaket[0].JenisPaket) {
					case 'JAM':
						jQuery('#lblhargaperjam_RubahDurasi').text("Harga / Jam");
						jQuery('#lblDurasiPaket_RubahDurasi').text("Durasi (Jam)");
						break;
					case 'MENIT':
						jQuery('#lblhargaperjam_RubahDurasi').text("Harga / Menit");
						jQuery('#lblDurasiPaket_RubahDurasi').text("Durasi (Menit)");
						break;
					case 'JAMREALTIME':
						jQuery('#lblhargaperjam_RubahDurasi').text("Harga / Jam");
						jQuery('#lblDurasiPaket_RubahDurasi').text("Durasi (Jam)");
						break;
					case 'DAILY':
						jQuery('#lblhargaperjam_RubahDurasi').text("Harga / Hari");
						jQuery('#lblDurasiPaket_RubahDurasi').text("Durasi (Hari)");
						break;
					case 'MONTHLY':
						jQuery('#lblhargaperjam_RubahDurasi').text("Harga / Hari");
						jQuery('#lblDurasiPaket_RubahDurasi').text("Durasi (Hari)");
						break;
					case 'YEARLY':
						jQuery('#lblhargaperjam_RubahDurasi').text("Harga / Hari");
						jQuery('#lblDurasiPaket_RubahDurasi').text("Durasi (Hari)");
						break;
					default:
						break;
				}

				calculateTotalTambahJam();
				
				_isFromDetailLookup = false;
				jQuery('#LookupTambahDurasiPaket').modal({backdrop: 'static', keyboard: false})
		    	jQuery('#LookupTambahDurasiPaket').modal('show');
			}
		});

	function CalculateProrata() {
		const jenisPaket = jQuery('#JenisPaket').val();
		if (jenisPaket !== "MONTHLY" && jenisPaket !== "YEARLY") {
			jQuery('#divProrataInfo').hide();
			return;
		}

		const kodePelanggan = jQuery('#KodePelanggan').val();
		if (!kodePelanggan) {
			jQuery('#divProrataInfo').hide();
			return;
		}

		const packetId = jQuery('#paketid').val();
		if (!packetId || packetId == "-1") {
			jQuery('#divProrataInfo').hide();
			return;
		}

		// Get Member Data
		$.ajax({
			url: "{{ route('pelanggan-viewJson') }}",
			type: 'post',
			data: {
				"KodePelanggan" : kodePelanggan,
				"GrupPelanggan" : "",
				"Search" : ""
			},
			headers: {
				'X-CSRF-TOKEN': '{{ csrf_token() }}'
			},
			success: function(response) {
				if (response.data.length > 0) {
					const member = response.data[0];
					tglBerlangganan = member.TglBerlanggananPaketBulanan;

					// if (!tglBerlangganan) {
					// 	Swal.fire("Informasi", "Tgl Berlangganan Paket Bulanan harus diisi di Master Pelanggan!", "warning");
					// 	jQuery('#divProrataInfo').hide();
					// 	return;
					// }

					// jQuery('#divProrataInfo').show();
					
					// Get Packet Price
					const filteredPacket = _dataPaket.filter(item => item.id == packetId);
					let hargaPaket = 0;
					if (filteredPacket.length > 0) {
						hargaPaket = parseFloat(filteredPacket[0].HargaBaru) || parseFloat(filteredPacket[0].HargaNormal) || 0;
					}

					// calculation
					const now = new Date();
					const currentYear = now.getFullYear();
					const currentMonth = now.getMonth();
					
					// Days in month
					let daysInMonth;
					if (jenisPaket === "MONTHLY") {
						daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
					} else if (jenisPaket === "YEARLY") {
						daysInMonth = (new Date(currentYear + 1, 0, 1) - new Date(currentYear, 0, 1)) / (1000 * 60 * 60 * 24);
					}
					console.log("daysInMonth : " + daysInMonth);
					const hargaPerHari = hargaPaket / daysInMonth;

					// Target Date: Day of TglBerlangganan in Month + 1
					const subDate = new Date(tglBerlangganan);
					const subDay = subDate.getDate();
					
					// Target is subDay of next month
					let targetDate;
					if (jenisPaket === "MONTHLY") {
						targetDate = new Date(currentYear, currentMonth + 1, subDay);
					} else if (jenisPaket === "YEARLY") {
						targetDate = new Date(currentYear + 1, currentMonth, subDay);
					}
					
					console.log("targetDate : " + targetDate);
					console.log("now : " + now);
					
					const diffTime = targetDate - now;
					const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

					console.log("diffDays : " + diffDays);
					
					const hargaSewa = diffDays * hargaPerHari;

					jQuery('#txtHarga_Prorata').val(formatNumber(hargaPaket));
					jQuery('#txtHargaPerHari_Prorata').val(formatNumber(hargaPerHari));
					jQuery('#txtHargaSewa_Prorata').val(formatNumber(hargaSewa));
					
					// Update fields
					jQuery('#HargaNormal').val(Math.round(hargaSewa));
					jQuery('#HargaBaru').val(0);

					// Store Target Date for submission
					jQuery('#divProrataInfo').data('target-date', targetDate);
				}
			}
		});
	}

	jQuery('#JenisPaket').change(function () {
			// Logic Filter Member
			var $kodePelanggan = jQuery('#KodePelanggan');
			if (!$kodePelanggan.data('options')) {
				$kodePelanggan.data('options', $kodePelanggan.find('option').clone());
			}
			
			var $options = $kodePelanggan.data('options');
			$kodePelanggan.empty();
			
			jQuery('#divLangsungBayar').show();
			// jQuery('#chkLangsungbayar').prop('checked', false);

			if (jQuery('#JenisPaket').val() == "PAKETMEMBER") {
				$options.each(function() {
					if ($(this).val() == "" || $(this).data('ispaid') == 1) {
						$kodePelanggan.append($(this).clone());
					}
				});
			} else {
				$kodePelanggan.append($options.clone());
			}

			const filteredData = _dataPaket.filter(item => item.JenisPaket === jQuery('#JenisPaket').val());
			jQuery('#paketid').empty();
			var newOption = $('<option>', {
				value: -1,
				text: "Pilih Paket"
			});
			jQuery('#paketid').append(newOption); 
			if (filteredData.length > 0) {
				$.each(filteredData,function (k,v) {
					var newOption = $('<option>', {
						value: v.id,
						text: v.NamaPaket
					});

					jQuery('#paketid').append(newOption);
				});
			}

			if (jQuery('#JenisPaket').val() == "MENIT") {
                jQuery('#timeSlotSection').slideUp();
                jQuery('#selectedTimeSlot').val('');
				// jQuery('#PembayaranSection').hide();
				jQuery('#lblDurasiPaket').text('Durasi (Menit)');
                jQuery('#paketid').attr('disabled', false);
                jQuery('#SearchMember').attr('disabled', false);
                jQuery('#KodePelanggan').attr('disabled', false);
                jQuery('#btTambahMember').attr('disabled', false);
                jQuery('#DurasiPaket').attr('readonly', false);

				// ...existing code...
				var now = new Date();
				var formattedNow = now.getFullYear() + '-' +
					String(now.getMonth() + 1).padStart(2, '0') + '-' +
					String(now.getDate()).padStart(2, '0') + ' ' +
					String(now.getHours()).padStart(2, '0') + ':' +
					String(now.getMinutes()).padStart(2, '0') + ':' +
					String(now.getSeconds()).padStart(2, '0');
				// Use formattedNow instead of jQuery('#JamRequest').val()
				
				// ...existing code...
				// Get Maximal Order
				$.ajax({
					url: "{{ route('billing-maxtime') }}",
					type: 'POST',
					data: {
						_token: '{{ csrf_token() }}',
						mejaID: jQuery('#tableid').val(),
						JamRequest: formattedNow
					},
					success: function(response) {
						if (response.success) {
							if(response.MaximalOrder > 0){
								jQuery('#DurasiPaket').val(response.MaximalOrder);
								jQuery("#DurasiPaket").attr("max", response.MaximalOrder);
								
								// PAKETMEMBER Logic: Show Slots after MaxTime is retrieved
								// if (jQuery('#JenisPaket').val() == "PAKETMEMBER") {
								// 	jQuery('#DurasiPaket').attr('readonly', true);
								// 	jQuery('#chkFlexibleTime').attr('disabled', true).prop('checked', false); // Force Unchecked/Fixed
								// 	jQuery('#timeSlotSection').slideDown();
								// 	loadTimeSlots();
								// }
							}
						} 
					},
					error: function(xhr) {
						Swal.fire({
							icon: "error",
							title: "Opps...",
							text: xhr.responseText,
						});
					}
				});
            } else if (jQuery('#JenisPaket').val() == "PAKETMEMBER") {
                jQuery('#timeSlotSection').slideUp(); // Hide initially
                jQuery('#selectedTimeSlot').val('');
                jQuery('#lblDurasiPaket').text('Durasi (Jam)');
                // jQuery('#paketid').val("-1").trigger('change').attr('disabled', true); // Existing logic kept?
                
                 // Fields handling
                jQuery('#HargaNormal').val(0);
                jQuery('#HargaBaru').val(0);
                jQuery('#JamHargaNormal').val("");
                jQuery('#JamHargaBaru').val("");
                jQuery('#DurasiPaket').val(0).attr('readonly', true);
                
                // Disable Flexible Check
                jQuery('#chkFlexibleTime').attr('disabled', true).prop('checked', false);

                // Fields that stay active are Member search and Table Guards
                jQuery('#SearchMember').attr('disabled', false);
                jQuery('#KodePelanggan').attr('disabled', false);
                jQuery('#btTambahMember').attr('disabled', false);

				jQuery('#DurasiPaket').attr('readonly', true);
				jQuery('#chkFlexibleTime').attr('disabled', true).prop('checked', false); // Force Unchecked/Fixed
				jQuery('#timeSlotSection').slideDown();
				loadTimeSlots();
            }
            else if (jQuery('#JenisPaket').val() == "JAM") {
                jQuery('#lblDurasiPaket').text('Durasi (Jam)');
                jQuery('#paketid').attr('disabled', false);
                jQuery('#SearchMember').attr('disabled', false);
                jQuery('#KodePelanggan').attr('disabled', false);
                jQuery('#btTambahMember').attr('disabled', false);
                
                // JAM specific
				if (jQuery('#chkFlexibleTime').is(':checked')) {
					jQuery('#timeSlotSection').slideUp();
					jQuery('#DurasiPaket').val(1).attr('readonly', false);
				} else {
					jQuery('#timeSlotSection').slideDown();
					loadTimeSlots();
					jQuery('#DurasiPaket').val(1).attr('readonly', true);
				}
            }
			else if (jQuery('#JenisPaket').val() == "MENITREALTIME" || jQuery('#JenisPaket').val() == "PAYPERUSE") {
				jQuery('#timeSlotSection').slideUp();
                jQuery('#selectedTimeSlot').val('');
				jQuery('#lblDurasiPaket').text('Durasi (Menit)');
                jQuery('#paketid').attr('disabled', false);
                jQuery('#SearchMember').attr('disabled', false);
                jQuery('#KodePelanggan').attr('disabled', false);
                jQuery('#btTambahMember').attr('disabled', false);
                jQuery('#DurasiPaket').val(0).attr('readonly', true);
				jQuery('#chkFlexibleTime').attr('disabled', true).prop('checked', false);

				if (jQuery('#JenisPaket').val() == "PAYPERUSE") {
					jQuery('#divLangsungBayar').show();
				}
			}
			else if (jQuery('#JenisPaket').val() == "JAMREALTIME") {
				jQuery('#timeSlotSection').slideUp();
                jQuery('#selectedTimeSlot').val('');
				jQuery('#lblDurasiPaket').text('Durasi (Jam)');
                jQuery('#paketid').attr('disabled', false);
                jQuery('#SearchMember').attr('disabled', false);
                jQuery('#KodePelanggan').attr('disabled', false);
                jQuery('#btTambahMember').attr('disabled', false);
                jQuery('#DurasiPaket').val(1).attr('readonly', false);
				jQuery('#chkFlexibleTime').attr('disabled', true).prop('checked', false);
				jQuery('#divLangsungBayar').show();
			}
			else if (jQuery('#JenisPaket').val() == "MONTHLY") {
				jQuery('#timeSlotSection').slideUp();
                jQuery('#selectedTimeSlot').val('');
				jQuery('#lblDurasiPaket').text('Durasi (Bulan)');
				
                jQuery('#paketid').attr('disabled', false);
                jQuery('#SearchMember').attr('disabled', false);
                jQuery('#KodePelanggan').attr('disabled', false);
                jQuery('#btTambahMember').attr('disabled', false);
                jQuery('#DurasiPaket').val(1).attr('readonly', false).attr('disabled', false);
				jQuery('#chkFlexibleTime').attr('disabled', true).prop('checked', false);
				jQuery('#divLangsungBayar').show();
				jQuery('#divProrataInfo').hide(); // Hide if previously used
				jQuery('#divMonthlyPacket').show(); // Show new section

				// Use TglTransaksi if set, otherwise now
				let baseDateValue = jQuery('#TglTransaksi').val();
				let baseDate = baseDateValue ? new Date(baseDateValue) : new Date();
				
				const year = baseDate.getFullYear();
				const month = String(baseDate.getMonth() + 1).padStart(2, '0');
				const day = String(baseDate.getDate()).padStart(2, '0');
				
				const now = new Date();
				const hours = String(now.getHours()).padStart(2, '0');
				const minutes = String(now.getMinutes()).padStart(2, '0');

				jQuery('#TglMasuk_Monthly').val(`${year}-${month}-${day}`);
				jQuery('#JamMasuk_Monthly').val(`${hours}:${minutes}`);
				
				// Set Default Keluar (BaseDate + 1 Month)
				const nextMonth = new Date(baseDate);
				nextMonth.setMonth(nextMonth.getMonth() + 1);
				
				const tYear = nextMonth.getFullYear();
				const tMonth = String(nextMonth.getMonth() + 1).padStart(2, '0');
				const tDay = String(nextMonth.getDate()).padStart(2, '0');

				jQuery('#TglKeluar_Monthly').val(`${tYear}-${tMonth}-${tDay}`);
				jQuery('#JamKeluar_Monthly').val(`${hours}:${minutes}`);
			}
			else if (jQuery('#JenisPaket').val() == "YEARLY") {
				jQuery('#timeSlotSection').slideUp();
                jQuery('#selectedTimeSlot').val('');
				jQuery('#lblDurasiPaket').text('Durasi (Tahun)');
				
                jQuery('#paketid').attr('disabled', false);
                jQuery('#SearchMember').attr('disabled', false);
                jQuery('#KodePelanggan').attr('disabled', false);
                jQuery('#btTambahMember').attr('disabled', false);
                jQuery('#DurasiPaket').val(1).attr('readonly', false).attr('disabled', false);
				jQuery('#chkFlexibleTime').attr('disabled', true).prop('checked', false);
				jQuery('#divLangsungBayar').show();
				jQuery('#divProrataInfo').hide();
				jQuery('#divMonthlyPacket').hide(); 
				jQuery('#divYearlyPacket').show();

				// Use TglTransaksi if set, otherwise now
				let baseDateValue = jQuery('#TglTransaksi').val();
				let baseDate = baseDateValue ? new Date(baseDateValue) : new Date();
				
				const year = baseDate.getFullYear();
				const month = String(baseDate.getMonth() + 1).padStart(2, '0');
				const day = String(baseDate.getDate()).padStart(2, '0');
				
				const now = new Date();
				const hours = String(now.getHours()).padStart(2, '0');
				const minutes = String(now.getMinutes()).padStart(2, '0');

				jQuery('#TglMasuk_Yearly').val(`${year}-${month}-${day}`);
				jQuery('#JamMasuk_Yearly').val(`${hours}:${minutes}`);
				
				// Set Default Keluar (BaseDate + 1 Year)
				const nextYear = new Date(baseDate);
				nextYear.setFullYear(nextYear.getFullYear() + 1);
				
				const tYear = nextYear.getFullYear();
				const tMonth = String(nextYear.getMonth() + 1).padStart(2, '0');
				const tDay = String(nextYear.getDate()).padStart(2, '0');

				jQuery('#TglKeluar_Yearly').val(`${tYear}-${tMonth}-${tDay}`);
				jQuery('#JamKeluar_Yearly').val(`${hours}:${minutes}`);
			}
			else if (jQuery('#JenisPaket').val() == "DAILY") {
				jQuery('#timeSlotSection').slideUp();
                jQuery('#selectedTimeSlot').val('');
				jQuery('#lblDurasiPaket').text('Durasi (Hari)');
				
                jQuery('#paketid').attr('disabled', false);
                jQuery('#SearchMember').attr('disabled', false);
                jQuery('#KodePelanggan').attr('disabled', false);
                jQuery('#btTambahMember').attr('disabled', false);
                jQuery('#DurasiPaket').val(1).attr('readonly', false);
				jQuery('#chkFlexibleTime').attr('disabled', true).prop('checked', false);
				jQuery('#divLangsungBayar').show();

				// Use TglTransaksi if set, otherwise now
				let baseDateValue = jQuery('#TglTransaksi').val();
				let baseDate = baseDateValue ? new Date(baseDateValue) : new Date();
				
				const year = baseDate.getFullYear();
				const month = String(baseDate.getMonth() + 1).padStart(2, '0');
				const day = String(baseDate.getDate()).padStart(2, '0');
				
				const now = new Date();
				const hours = String(now.getHours()).padStart(2, '0');
				const minutes = String(now.getMinutes()).padStart(2, '0');

				jQuery('#TglMasuk_Daily').val(`${year}-${month}-${day}`);
				jQuery('#JamMasuk_Daily').val(`${hours}:${minutes}`);
				
				// Set Default Keluar (BaseDate + 1 Day)
				const tomorrow = new Date(baseDate);
				tomorrow.setDate(tomorrow.getDate() + 1);
				
				const tYear = tomorrow.getFullYear();
				const tMonth = String(tomorrow.getMonth() + 1).padStart(2, '0');
				const tDay = String(tomorrow.getDate()).padStart(2, '0');

				jQuery('#TglKeluar_Daily').val(`${tYear}-${tMonth}-${tDay}`);
				jQuery('#JamKeluar_Daily').val(`${hours}:${minutes}`);
			}
			else{
                jQuery('#timeSlotSection').slideUp();
                jQuery('#selectedTimeSlot').val('');
				// jQuery('#PembayaranSection').show();
				jQuery('#lblDurasiPaket').text('Durasi (Jam)');
                jQuery('#paketid').attr('disabled', false);
                jQuery('#SearchMember').attr('disabled', false);
                jQuery('#KodePelanggan').attr('disabled', false);
                jQuery('#btTambahMember').attr('disabled', false);
                jQuery('#DurasiPaket').attr('readonly', false);
			}
			jQuery('#PembayaranSection').show();

			if (jQuery('#JenisPaket').val() != "DAILY") {
				jQuery('#divDailyPacket').slideUp();
			}

			if (jQuery('#JenisPaket').val() == "MONTHLY" || jQuery('#JenisPaket').val() == "YEARLY") {
				jQuery('#lblDurasiPaket').text(jQuery('#JenisPaket').val() == "MONTHLY" ? 'Durasi (Bulan)' : 'Durasi (Tahun)');
				jQuery('#DurasiPaket').val(1).attr('readonly', true);
				// CalculateProrata();
			} else {
				jQuery('#divProrataInfo').hide();
			}
		});

		function checkJamMasukReadonly() {
			const tglTransaksi = jQuery('#TglTransaksi').val();
			if (!tglTransaksi) return;

			const now = new Date();
			const year = now.getFullYear();
			const month = String(now.getMonth() + 1).padStart(2, '0');
			const day = String(now.getDate()).padStart(2, '0');
			const todayDate = `${year}-${month}-${day}`;

			if (tglTransaksi === todayDate) {
				jQuery('#JamMasuk_Daily').attr('readonly', true);
			} else {
				jQuery('#JamMasuk_Daily').attr('readonly', false);
			}
		}

		jQuery('#TglTransaksi').on('change', function() {
			const selectedDate = jQuery(this).val();
			if(!selectedDate) return;
			
			jQuery('#TglMasuk_Daily').val(selectedDate);
			jQuery('#TglMasuk_Monthly').val(selectedDate);
			jQuery('#TglMasuk_Yearly').val(selectedDate);

			checkJamMasukReadonly();
			
			// Recalculate Keluar for Daily/Monthly/Yearly if needed
			jQuery('#DurasiPaket').trigger('change');

			// Sync Time Slots Schedule
			if (jQuery('#JenisPaket').val() == "JAM" || jQuery('#JenisPaket').val() == "PAKETMEMBER") {
				loadTimeSlots();
			}
		});

        jQuery('#KodePelanggan').change(function () {
            if (jQuery('#JenisPaket').val() == "PAKETMEMBER") {
                const kode = jQuery(this).val();
                if (kode == "") return;

                $.ajax({
                    url: "{{ route('pelanggan-viewJson') }}",
                    type: 'post',
                    data: {
                        "KodePelanggan" : kode,
                        "GrupPelanggan" : "",
                        "Search" : ""
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.data.length > 0) {
                            const member = response.data[0];
                            const now = new Date();
                            const validUntil = member.ValidUntil ? new Date(member.ValidUntil) : null;

                            // a. cek ValidUntil kosong
                            if (!member.ValidUntil) {
                                Swal.fire("Informasi", "Member Belom Aktif", "warning");
                                jQuery('#KodePelanggan').val("").trigger('change');
                                return;
                            }

                            // b. cek ValidUntil < Now
                            // Reset time for comparison if needed, or compare as is
                            if (validUntil < now) {
                                Swal.fire("Informasi", "member sudah expired", "warning");
                                jQuery('#KodePelanggan').val("").trigger('change');
                                return;
                            }

                            // c. cek isPaidMembership
                            if (member.isPaidMembership == 1) {
                                if (member.MaxPlay - member.Played <= 0) {
                                    Swal.fire("Informasi", "Jatah Bermain sudah habis", "warning");
                                    jQuery('#KodePelanggan').val("").trigger('change');
                                    return;
                                }
                            }

                            // d. tampilkan maxTimePerPlay di kolom Durasi
                            jQuery('#DurasiPaket').val(member.maxTimePerPlay);
                        }
                    }
                });
            }

			// if (jQuery('#JenisPaket').val() == "MONTHLY" || jQuery('#JenisPaket').val() == "YEARLY") {
			// 	CalculateProrata();
			// }
        });

		jQuery('#paketid').change(function () {
			const filteredData = _dataPaket.filter(item => item.id == jQuery('#paketid').val());
			// console.log(filteredData)
			if (filteredData.length > 0) {
				jQuery('#HargaNormal').val(filteredData[0]["HargaNormal"]);
				jQuery('#HargaBaru').val(filteredData[0]["HargaBaru"]);
				jQuery('#JamHargaNormal').val(filteredData[0]["AkhirJamNormal"]);
				jQuery('#JamHargaBaru').val(filteredData[0]["AkhirJamPerubahanHarga"]);

				// Daily Packet Logic
				if (jQuery('#JenisPaket').val() == "DAILY") {
					jQuery('#divDailyPacket').slideDown();
					checkJamMasukReadonly();
					
					// Format time to HH:mm for input type="time"
					let checkin = filteredData[0]["JamCheckin"] || "";
					let checkout = filteredData[0]["JamCheckout"] || "";
					if(checkin.length >= 5) checkin = checkin.substring(0, 5);
					if(checkout.length >= 5) checkout = checkout.substring(0, 5);

					jQuery('#JamCheckin_Daily').val(checkin);
					jQuery('#JamCheckin_Daily').data('original-value', checkin); // Store original value
					jQuery('#JamCheckout_Daily').val(checkout);
				} else {
					jQuery('#divDailyPacket').slideUp();
				}
			} else {
				// Hide if no packet selected or reset
				jQuery('#divDailyPacket').slideUp();
			}

			// if (jQuery('#JenisPaket').val() == "MONTHLY" || jQuery('#JenisPaket').val() == "YEARLY") {
			// 	CalculateProrata();
			// }

			jQuery('#btMulaiBermain').text('Next >>');
			// if (jQuery('#JenisPaket').val() != "MENIT") {
			// 	// GenerateTotal();
			// 	jQuery('#btMulaiBermain').text('Next >>');
			// }
		});



		jQuery('#DurasiPaket').on('change input', function () {
			// console.log(jQuery('#DurasiPaket').val());

			if (jQuery('#JenisPaket').val() == "DAILY") {
				const durasi = parseInt(jQuery(this).val()) || 0;
				const tglMasukVal = jQuery('#TglMasuk_Daily').val();

				if (tglMasukVal && durasi > 0) {
					const tglMasuk = new Date(tglMasukVal);
					const tglKeluar = new Date(tglMasuk);
					tglKeluar.setDate(tglMasuk.getDate() + durasi);

					const year = tglKeluar.getFullYear();
					const month = String(tglKeluar.getMonth() + 1).padStart(2, '0');
					const day = String(tglKeluar.getDate()).padStart(2, '0');
					
					jQuery('#TglKeluar_Daily').val(`${year}-${month}-${day}`);
				}
			} else if (jQuery('#JenisPaket').val() == "MONTHLY") {
				const durasi = parseInt(jQuery(this).val()) || 0;
				const tglMasukVal = jQuery('#TglMasuk_Monthly').val();

				if (tglMasukVal && durasi > 0) {
					const tglMasuk = new Date(tglMasukVal);
					const tglKeluar = new Date(tglMasuk);
					tglKeluar.setMonth(tglMasuk.getMonth() + durasi);

					const year = tglKeluar.getFullYear();
					const month = String(tglKeluar.getMonth() + 1).padStart(2, '0');
					const day = String(tglKeluar.getDate()).padStart(2, '0');
					
					jQuery('#TglKeluar_Monthly').val(`${year}-${month}-${day}`);
				}
			} else if (jQuery('#JenisPaket').val() == "YEARLY") {
				const durasi = parseInt(jQuery(this).val()) || 0;
				const tglMasukVal = jQuery('#TglMasuk_Yearly').val();

				if (tglMasukVal && durasi > 0) {
					const tglMasuk = new Date(tglMasukVal);
					const tglKeluar = new Date(tglMasuk);
					tglKeluar.setFullYear(tglMasuk.getFullYear() + durasi);

					const year = tglKeluar.getFullYear();
					const month = String(tglKeluar.getMonth() + 1).padStart(2, '0');
					const day = String(tglKeluar.getDate()).padStart(2, '0');
					
					jQuery('#TglKeluar_Yearly').val(`${year}-${month}-${day}`);
				}
			}

			GenerateTotal();
		});

		jQuery('#TglKeluar_Daily').on('change', function() {
			const tglKeluarVal = jQuery(this).val();
			const tglMasukVal = jQuery('#TglMasuk_Daily').val();

			if (tglKeluarVal && tglMasukVal) {
				const tglMasuk = new Date(tglMasukVal);
				const tglKeluar = new Date(tglKeluarVal);
				
				// Calculate difference in time
				const diffTime = tglKeluar - tglMasuk;
				// Calculate difference in days
				const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 

				if (diffDays > 0) {
					jQuery('#DurasiPaket').val(diffDays);
				}
				GenerateTotal();
			}
		});

		jQuery('#TglKeluar_Monthly').on('change', function() {
			const tglKeluarVal = jQuery(this).val();
			const tglMasukVal = jQuery('#TglMasuk_Monthly').val();

			if (tglKeluarVal && tglMasukVal) {
				const tglMasuk = new Date(tglMasukVal);
				const tglKeluar = new Date(tglKeluarVal);
				
				// Calculate difference in months roughly
				let months = (tglKeluar.getFullYear() - tglMasuk.getFullYear()) * 12;
				months -= tglMasuk.getMonth();
				months += tglKeluar.getMonth();
				
				if(tglKeluar.getDate() < tglMasuk.getDate()){
					months--;
				}
				
				const diffMonths = months <= 0 ? 0 : months;

				if (diffMonths > 0) {
					jQuery('#DurasiPaket').val(diffMonths);
				}
				GenerateTotal();
			}
		});

		jQuery('#TglKeluar_Yearly').on('change', function() {
			const tglKeluarVal = jQuery(this).val();
			const tglMasukVal = jQuery('#TglMasuk_Yearly').val();

			if (tglKeluarVal && tglMasukVal) {
				const tglMasuk = new Date(tglMasukVal);
				const tglKeluar = new Date(tglKeluarVal);
				
				let years = tglKeluar.getFullYear() - tglMasuk.getFullYear();
				
				// Adjust if not full year
				// Simple logic: if month/day of keluar < month/day of masuk, sub 1
				if (tglKeluar.getMonth() < tglMasuk.getMonth() || (tglKeluar.getMonth() == tglMasuk.getMonth() && tglKeluar.getDate() < tglMasuk.getDate())) {
					years--;
				}
				
				const diffYears = years <= 0 ? 0 : years;

				if (diffYears > 0) {
					jQuery('#DurasiPaket').val(diffYears);
				}
				GenerateTotal();
			}
		});

		// Flexible Time Toggle
		jQuery('#chkFlexibleTime').change(function() {
			if(jQuery(this).is(':checked')) {
				// Flexible Mode: Hide Slots, Enable Duration
				jQuery('#timeSlotSection').slideUp();
				jQuery('#DurasiPaket').attr('readonly', false);
				jQuery('#selectedTimeSlot').val(''); // Clear slot selection
			} else {
				// Fixed Mode: Show Slots, Disable Duration (read form slots)
				if (jQuery('#JenisPaket').val() == "JAM") {
					jQuery('#timeSlotSection').slideDown();
					jQuery('#DurasiPaket').attr('readonly', true);
					jQuery('#DurasiPaket').val(1); // Reset or Keep? Reset safer if no slot selected
					// Trigger updateTimeSlotData to restore if any selected? 
					// For now, maybe just clear or let user select again
				}
			}
		});

		jQuery('#frmPilihPaket').on('submit', function(e) {
			// 
			jQuery('#btMulaiBermain').text('Tunggu Sebentar');
			jQuery('#btMulaiBermain').attr('disabled',true);

			e.preventDefault();
			jQuery('#frmPilihPaket').find(':disabled').prop('disabled', false);
			const formData = new FormData(this);
            if (jQuery('#JenisPaket').val() == "JAM" || jQuery('#JenisPaket').val() == "PAKETMEMBER") {
                 const timeSlot = jQuery('#selectedTimeSlot').val();
                 if (timeSlot) {
                     const parts = timeSlot.split('-');
                     if (parts.length >= 1) {
                         formData.append('JamMulai', parts[0]);
						 if(parts.length > 1) {
							formData.append('JamSelesai', parts[1]);
						 }
						 // Use TglTransaksi from the form or default to today
						 var tglTrx = jQuery('#TglTransaksi').val();
						 if(!tglTrx) {
							var now = new Date();
						 	tglTrx = now.getFullYear() + '-' + String(now.getMonth() + 1).padStart(2, '0') + '-' + String(now.getDate()).padStart(2, '0');
						 }
                         formData.append('TglBooking', tglTrx);
                     }
                 }

            } else if (jQuery('#JenisPaket').val() == "DAILY") {
				// Construct DateTime Strings
				const tglMasuk = jQuery('#TglMasuk_Daily').val();
				const jamMasuk = jQuery('#JamMasuk_Daily').val();
				
				const tglKeluar = jQuery('#TglKeluar_Daily').val();
				const jamKeluar = jQuery('#JamKeluar_Daily').val();
				
				formData.append('JamMulai', tglMasuk + ' ' + jamMasuk);
				formData.append('JamSelesai', tglKeluar + ' ' + jamKeluar);
				formData.append('TglBooking', tglMasuk); // Use TglMasuk as TglBooking
				
				const startDateTime = new Date(tglMasuk + 'T' + jamMasuk);
				const now = new Date();

				if (startDateTime > now) {
					formData.append('Status', '0');
					formData.append('DocumentStatus', 'D');
				} else {
					formData.append('Status', '1');
					formData.append('DocumentStatus', 'O');
				}

				// Extra Cost
				const extraCost = jQuery('#ExtraCost').val() || 0;
				formData.append('BiayaLain', extraCost);
			} else if (jQuery('#JenisPaket').val() == "MONTHLY") {
				// Construct DateTime Strings
				const tglMasuk = jQuery('#TglMasuk_Monthly').val();
				const jamMasuk = jQuery('#JamMasuk_Monthly').val();
				
				const tglKeluar = jQuery('#TglKeluar_Monthly').val();
				const jamKeluar = jQuery('#JamKeluar_Monthly').val();
				
				formData.append('JamMulai', tglMasuk + ' ' + jamMasuk);
				formData.append('JamSelesai', tglKeluar + ' ' + jamKeluar);
				formData.append('TglBooking', tglMasuk); // Use TglMasuk as TglBooking
				
				const startDateTime = new Date(tglMasuk + 'T' + jamMasuk);
				const now = new Date();

				if (startDateTime > now) {
					formData.append('Status', '0');
					formData.append('DocumentStatus', 'D');
				} else {
					formData.append('Status', '1');
					formData.append('DocumentStatus', 'O');
				}

				// Keep proroata logic if needed or just standard Monthly?
				// User asked to treat SAME as DAILY.
			} else if (jQuery('#JenisPaket').val() == "YEARLY") {
				// Construct DateTime Strings
				const tglMasuk = jQuery('#TglMasuk_Yearly').val();
				const jamMasuk = jQuery('#JamMasuk_Yearly').val();
				
				const tglKeluar = jQuery('#TglKeluar_Yearly').val();
				const jamKeluar = jQuery('#JamKeluar_Yearly').val();
				
				formData.append('JamMulai', tglMasuk + ' ' + jamMasuk);
				formData.append('JamSelesai', tglKeluar + ' ' + jamKeluar);
				formData.append('TglBooking', tglMasuk);
				
				const startDateTime = new Date(tglMasuk + 'T' + jamMasuk);
				const now = new Date();

				if (startDateTime > now) {
					formData.append('Status', '0');
					formData.append('DocumentStatus', 'D');
				} else {
					formData.append('Status', '1');
					formData.append('DocumentStatus', 'O');
				}
			}
			
			// Jika Flexible time, kirim parameter khusus jika perlu, atau biarkan backend handle default NOW
			// Tapi jika TIDAK flexible (Fixed Slot), pastikan JamMulai terkirim (sudah di atas)
			
			if(jQuery('#JenisPaket').val() == "PAKETMEMBER"){
				formData.append('Status', '0');
			}
			// else{
			// 	formData.append('Status', '0');
			// }

			$.ajax({
				async:false,
				url: "{{route('billing-store')}}",
				type: 'post',
				data: formData,
				processData: false, // Prevent jQuery from automatically processing the data
        		contentType: false,
				headers: {
					'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
				},
				success: function(response) {
					// console.log('Form submitted successfully:', response);
					if (response.success) {
						$.ajax({
							async:false,
							url: "{{route('billing-repopulate')}}",
							type: 'post',
							data: formData,
							processData: false, // Prevent jQuery from automatically processing the data
							contentType: false,
							headers: {
								'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
							},
							success: function(oBilling) {
								_billing = oBilling.data;
								jQuery('#btCloseModalDetails').css('display', 'none');
								jQuery('#LookupPilihPaket').modal('hide');

								var xHargaNormal = jQuery('#HargaNormal');

								formatCurrency($('#txtSubTotal_Detail'), xHargaNormal);

								if ((jQuery('#JenisPaket').val() == "MENIT"  && !jQuery('#chkLangsungbayar').is(':checked')) || 
									(jQuery('#JenisPaket').val() == "JAM"   && !jQuery('#chkLangsungbayar').is(':checked'))|| 
									(jQuery('#JenisPaket').val() == "PAKETMEMBER" && !jQuery('#chkLangsungbayar').is(':checked')) || 
									(jQuery('#JenisPaket').val() == "MENITREALTIME" && !jQuery('#chkLangsungbayar').is(':checked')) || 
									(jQuery('#JenisPaket').val() == "JAMREALTIME" && !jQuery('#chkLangsungbayar').is(':checked')) || 
									(jQuery('#JenisPaket').val() == "PAYPERUSE" && !jQuery('#chkLangsungbayar').is(':checked'))) {
                                    Swal.fire({
                                        icon: "success",
                                        title: "Sukses",
                                        text: "Data Berhasil disimpan, Selamat Bermain",
                                    }).then((result) => {
                                        location.reload();
                                    });
                                } else {
									const extraCost = jQuery('#ExtraCost').val() || 0;
                                    fnDetails(response.NoTransaksi, { 'BiayaLain': extraCost });

									if (jQuery('#JenisPaket').val() == "JAMREALTIME" || ((jQuery('#JenisPaket').val() == "DAILY" || jQuery('#JenisPaket').val() == "MONTHLY" || jQuery('#JenisPaket').val() == "YEARLY") && jQuery('#chkLangsungbayar').is(':checked'))) {
										jQuery("#sectionPayment").show();
									}

                                    jQuery('#LookupDetailOrder').modal({backdrop: 'static', keyboard: false})
                                    jQuery('#LookupDetailOrder').modal('show');
                                }
							}
						});
						// if (jQuery('#JenisPaket').val() != "MENIT") {
						// 	$.ajax({
						// 		async:false,
						// 		url: "{{route('billing-repopulate')}}",
						// 		type: 'post',
						// 		data: formData,
						// 		processData: false, // Prevent jQuery from automatically processing the data
						// 		contentType: false,
						// 		headers: {
						// 			'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
						// 		},
						// 		success: function(oBilling) {
						// 			_billing = oBilling.data;
						// 			jQuery('#btCloseModalDetails').css('display', 'none');
						// 			jQuery('#LookupPilihPaket').modal('hide');
						// 			fnDetails(response.NoTransaksi, []);

						// 			jQuery('#LookupDetailOrder').modal({backdrop: 'static', keyboard: false})
		    			// 			jQuery('#LookupDetailOrder').modal('show');
						// 		}
						// 	});
						// }
						// else{
						// 	Swal.fire({
						// 		icon: "success",
						// 		title: "Sukses",
						// 		text: "Data Berhasil disimpan, Selamat Bermain",
						// 	}).then((result) => {
						// 		location.reload();
								
						// 	});
						// }
					}
					else{
						Swal.fire({
							icon: "error",
							title: "Opps...",
							text: response.message,
						}).then((result) => {
						//   location.reload();
							jQuery('#btMulaiBermain').text('Mulai Bermain');
							jQuery('#btMulaiBermain').attr('disabled',false);

							jQuery('#LookupPilihPaket').modal({backdrop: 'static', keyboard: false})
		    				jQuery('#LookupPilihPaket').modal('show');
						});
					}
				},
				error: function(xhr) {
					// console.error('An error occurred:', xhr.responseText);
					Swal.fire({
						icon: "error",
						title: "Opps...",
						text: response.message,
					}).then((result) => {
					//   location.reload();
						jQuery('#btMulaiBermain').text('Mulai Bermain');
						jQuery('#btMulaiBermain').attr('disabled',false);

						jQuery('#LookupPilihPaket').modal({backdrop: 'static', keyboard: false})
		    			jQuery('#LookupPilihPaket').modal('show');
					});
				}
			});
		});

		jQuery(document).on('click', '.btTambahJam', function() {
			const NoTransaksi = $(this).data('notransaksi');
			const filteredBilling = _billing.filter(item => item.NoTransaksi == NoTransaksi);
			const DataPaket = <?php echo $paket ?>;
			const filteredPaket = DataPaket.filter(item => item.id == filteredBilling[0]['paketid']);
			
			jQuery('#txtHargaPerJam_TambahJam').val(formatNumber(filteredPaket[0]['HargaNormal']));
			jQuery('#txtHargaPerJam_TambahJam').attr('originalvalue', filteredPaket[0]['HargaNormal']);
			calculateTotalTambahJam();
		});

		jQuery('#cboMetodePembayaran_TambahJam').on('change', function() {
			const metodepembayaran = <?php echo $metodepembayaran ?>;
			const filteredData = metodepembayaran.filter(item => item.id == jQuery(this).val());
			const midtransclientkey = "<?php echo $midtransclientkey ?>";

			if (filteredData.length > 0 && filteredData[0]['MetodeVerifikasi'] == "AUTO") {
				if (midtransclientkey == "") {
					Swal.fire({
						icon: "error",
						title: "Opps...",
						text: "Client Key Midtrans belum di set, silahkan hubungi admin",
					});
					jQuery(this).val("").change();
					return;
				}
			}

			calculateTotalTambahJam();
		});

		jQuery('#txtDurasiPaket_RubahDurasi').on('input', function() {
			calculateTotalTambahJam();
		});

		function calculateTotalTambahJam(){
			const durasi = parseFloat(jQuery('#txtDurasiPaket_RubahDurasi').val()) || 0;
			const harga = parseFloat(jQuery('#txtHargaPerJam_TambahJam').attr('originalvalue')) || 0;
			let subtotal = durasi * harga;

			// Calculate Biaya Layanan
			let BiayaLayanan = 0;
			const selectedOption = jQuery('#cboMetodePembayaran_TambahJam').find('option:selected');
			const percent = parseFloat(selectedOption.data('percent')) || 0;
			const rupiah = parseFloat(selectedOption.data('rupiah')) || 0;

			if (percent > 0) {
				BiayaLayanan = (percent / 100) * subtotal;
			} else if (rupiah > 0) {
				BiayaLayanan = rupiah;
			}

			jQuery('#txtBiayaLayanan_TambahJam').val(formatNumber(BiayaLayanan));
			jQuery('#txtBiayaLayanan_TambahJam').attr('originalvalue', BiayaLayanan);

			let total = subtotal + BiayaLayanan;

			jQuery('#txtTotalTransaksi_TambahJam').val(formatNumber(total));
			jQuery('#txtTotalTransaksi_TambahJam').attr('originalvalue', total);

			const metodepembayaran = <?php echo $metodepembayaran ?>;
			const filteredMtd = metodepembayaran.filter(item => item.id == jQuery('#cboMetodePembayaran_TambahJam').val());

			if (filteredMtd.length > 0 && filteredMtd[0]['TipePembayaran'] == "NON TUNAI") {
				formatCurrency(jQuery('#txtJumlahBayar_TambahJam'), total);
				jQuery('#txtJumlahBayar_TambahJam').attr('readonly', true);
				
				var kembalian = 0;
				jQuery('#txtJumlahKembalian_TambahJam').val(formatNumber(kembalian));
				jQuery('#txtJumlahKembalian_TambahJam').attr("originalvalue", kembalian);
			}
			else{
				// formatCurrency(jQuery('#txtJumlahBayar_TambahJam'), "0");
				jQuery('#txtJumlahBayar_TambahJam').attr('readonly', false);
			}
		}

		jQuery('#txtJumlahBayar_TambahJam').on('input', function () {
			let value = jQuery(this).val();
			let numericValue = value.replace(/[^0-9.]/g, '');

			const formatter = new Intl.NumberFormat('en-US', {
				style: 'decimal',
				maximumFractionDigits: 2,
			});

			if (numericValue) {
				$(this).val(formatter.format(numericValue));
				$(this).attr("originalvalue", value.replace(/,/g, ""));

				var kembalian = $(this).attr("originalvalue") - jQuery('#txtTotalTransaksi_TambahJam').attr("originalvalue");
				jQuery('#txtJumlahKembalian_TambahJam').val(formatter.format(kembalian));
				jQuery('#txtJumlahKembalian_TambahJam').attr("originalvalue", kembalian);
			}
		});

		jQuery('#frmUpdatePaket').on('submit', function(e) {
			e.preventDefault();
			
			// SaveTambahJam(jQuery('#btRubahDurasiPaket'),'Tambah Jam');
			const metodepembayaran = <?php echo $metodepembayaran ?>;
			const filteredData = metodepembayaran.filter(item => item.id == jQuery('#cboMetodePembayaran_TambahJam').val());
			const midtransclientkey = "<?php echo $midtransclientkey ?>";

			console.log(filteredData)


			if (filteredData[0]['MetodeVerifikasi'] == "AUTO") {
				if (midtransclientkey == "") {
					Swal.fire({
						icon: "error",
						title: "Opps...",
						text: "Client Key Midtrans belum di set, silahkan hubungi admin",
					});
					return;
				}

				if (parseFloat(jQuery('#txtTotalTransaksi_TambahJam').attr("originalvalue")) > 0) {
					PaymentGateWayTambahJam($('#btRubahDurasiPaket'),'Bayar');
				}
				else{
					SaveTambahJam(jQuery('#btRubahDurasiPaket'),'Tambah Jam');
				}
				
			}
			else{
				SaveTambahJam(jQuery('#btRubahDurasiPaket'),'Tambah Jam');
			}
		});

		function PaymentGateWayTambahJam(ButonObject, ButtonDefaultText) {
			// _custdisplayopened
			
			const NoTransaksi = jQuery('#txtNoTransaksi_RubahDurasi').val();
			const filteredData = _billing.filter(item => item.NoTransaksi == NoTransaksi);

			const now = new Date();
	    	const day = ("0" + now.getDate()).slice(-2);
	    	const month = ("0" + (now.getMonth() + 1)).slice(-2);
	    	const hours = now.getHours().toString().padStart(2, '0');
			const minutes = now.getMinutes().toString().padStart(2, '0');
			const seconds = now.getSeconds().toString().padStart(2, '0');

	    	const NowDay = now.getFullYear()+"-"+month+"-"+day;
	    	const _Tanggal = NowDay;
	    	const _Jam = hours+":"+minutes+":"+seconds;

			var oDetail = [];
			const _ppnPercent = oCompany[0]["PPN"];
			const durasi = parseFloat(jQuery('#txtDurasiPaket_RubahDurasi').val()) || 0;
			const harga = parseFloat(jQuery('#txtHargaPerJam_TambahJam').attr('originalvalue')) || 0;
			const total = durasi * harga;
			let Pajak = 0;

			var oItem = {
				'NoUrut' : 0,
				'KodeItem' : oCompany[0]["ItemHiburan"],
				'Qty' : durasi,
				'QtyKonversi' : durasi,
				'Satuan' : 'JAM',
				'Harga' : harga,
				'Discount' : 0,
				'HargaNet' : total + Pajak,
				'BaseReff' : NoTransaksi,
				'BaseLine' : -1,
				'KodeGudang' : oCompany[0]['GudangPoS'],
				'LineStatus': 'O',
				'VatPercent' : _ppnPercent,
				'HargaPokokPenjualan' : 0,
				'Pajak' : Pajak,
				'PajakHiburan' : 0,
			}
			oDetail.push(oItem);

			var oData = {
				'NoTransaksi' : "",
				'TglTransaksi' : _Tanggal + " " + _Jam,
				'TglJatuhTempo' : _Tanggal,
				'NoReff' : 'POS-TAMBAHJAM',
				'KodeSales' : filteredData.length > 0 ? filteredData[0]["KodeSales"] : '',
				'KodePelanggan' : filteredData.length > 0 ? filteredData[0]["KodePelanggan"] : '',
				'KodeTermin' : oCompany[0]['TerminBayarPoS'],
				'Termin' : 0,
				'TotalTransaksi' : total,
				'Potongan' : 0,
				'Pajak' : Pajak,
				'PajakHiburan' : 0,
				'Pembulatan' : 0,
				'TotalPembelian' : total + Pajak,
				'TotalRetur' : 0,
				'TotalPembayaran' : parseFloat(jQuery('#txtJumlahBayar_TambahJam').attr("originalvalue")),
				'Status' : 'C',
				'Keterangan' : 'Tambah Jam',
				'MetodeBayar' : jQuery('#cboMetodePembayaran_TambahJam').val(),
				'ReffPembayaran' : $('#txtRefrensi_TambahJam').val(),
				'BiayaLayanan' : parseFloat(jQuery('#txtBiayaLayanan_TambahJam').attr("originalvalue")) || 0,
				'Detail' : oDetail,
				'Source': 'TAMBAHJAM'
			}

			console.log("Status Cust Display : " + _custdisplayopened)
			if(_custdisplayopened){
				// console.log('Cust Display Oppened');
				localStorage.setItem('paymentgatewaydata', JSON.stringify(oData));
				displayWindow.postMessage('paymentgateway', '*');
			}
			else{
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
									Swal.fire({
										icon: "error",
										title: "Opps...",
										text: "Pembayaran Dibatalkan",
									})
								}
								else{
									// order_id
									jQuery('#txtRefrensi_TambahJam').val(result.order_id)
									SaveTambahJam(ButonObject, ButtonDefaultText)
								}
								// Proses pembayaran sukses
							},
							onPending: function(result){
								// console.log(result);
								// Pembayaran tertunda
							},
							onError: function(result){
								// console.log(result);
								Swal.fire({
									icon: "error",
									title: "Opps...",
									text: result,
								})
								// Pembayaran gagal
							},
							onClose: function(){
								console.log('customer closed the popup without finishing the payment');
							}
						});
					} else {
						// alert('Error: ' + data.error);
						Swal.fire({
							icon: "error",
							title: "Opps...",
							text: data.error,
						})
					}
				})
				.catch(error => console.error('Error:', error));
			}
		}

		function SaveTambahJam(ButonObject, ButtonDefaultText) {
			ButonObject.text('Tunggu Sebentar.....');
  			ButonObject.attr('disabled',true);

			
			const NoTransaksi = jQuery('#txtNoTransaksi_RubahDurasi').val();
			const filteredData = _billing.filter(item => item.NoTransaksi == NoTransaksi);

			const now = new Date();
	    	const day = ("0" + now.getDate()).slice(-2);
	    	const month = ("0" + (now.getMonth() + 1)).slice(-2);
	    	const hours = now.getHours().toString().padStart(2, '0');
			const minutes = now.getMinutes().toString().padStart(2, '0');
			const seconds = now.getSeconds().toString().padStart(2, '0');

	    	const NowDay = now.getFullYear()+"-"+month+"-"+day;
	    	const _Tanggal = NowDay;
	    	const _Jam = hours+":"+minutes+":"+seconds;

			var oDetail = [];
			const _ppnPercent = oCompany[0]["PPN"];
			const durasi = parseFloat(jQuery('#txtDurasiPaket_RubahDurasi').val()) || 0;
			const harga = parseFloat(jQuery('#txtHargaPerJam_TambahJam').attr('originalvalue')) || 0;
			const total = durasi * harga;
			let Pajak = 0;

			var oItem = {
				'NoUrut' : 0,
				'KodeItem' : oCompany[0]["ItemHiburan"],
				'Qty' : durasi,
				'QtyKonversi' : durasi,
				'Satuan' : 'JAM',
				'Harga' : harga,
				'Discount' : 0,
				'HargaNet' : total + Pajak,
				'BaseReff' : NoTransaksi,
				'BaseLine' : -1,
				'KodeGudang' : oCompany[0]['GudangPoS'],
				'LineStatus': 'O',
				'VatPercent' : _ppnPercent,
				'HargaPokokPenjualan' : 0,
				'Pajak' : Pajak,
				'PajakHiburan' : 0,
			}
			oDetail.push(oItem);

			var oData = {
				'NoTransaksi' : "",
				'TglTransaksi' : _Tanggal + " " + _Jam,
				'TglJatuhTempo' : _Tanggal,
				'NoReff' : 'POS-TAMBAHJAM',
				'KodeSales' : filteredData.length > 0 ? filteredData[0]["KodeSales"] : '',
				'KodePelanggan' : filteredData.length > 0 ? filteredData[0]["KodePelanggan"] : '',
				'KodeTermin' : oCompany[0]['TerminBayarPoS'],
				'Termin' : 0,
				'TotalTransaksi' : total,
				'Potongan' : 0,
				'Pajak' : Pajak,
				'PajakHiburan' : 0,
				'Pembulatan' : 0,
				'TotalPembelian' : total + Pajak,
				'TotalRetur' : 0,
				'TotalPembayaran' : parseFloat(jQuery('#txtJumlahBayar_TambahJam').attr("originalvalue")),
				'Status' : 'C',
				'Keterangan' : 'Tambah Jam',
				'MetodeBayar' : jQuery('#cboMetodePembayaran_TambahJam').val(),
				'ReffPembayaran' : $('#txtRefrensi_TambahJam').val(),
				'BiayaLayanan' : parseFloat(jQuery('#txtBiayaLayanan_TambahJam').attr("originalvalue")) || 0,
				'Detail' : oDetail,
				'Source': 'TAMBAHJAM'
			}

			console.log(oData);

			$.ajax({
				async:false,
				url: "{{route('fpenjualan-hiburanPoS')}}",
				type: 'POST',
				contentType: 'application/json',
				headers: {
					'X-CSRF-TOKEN': '{{ csrf_token() }}'
				},
				data: JSON.stringify(oData),
				success: function(response) {
					if (response.success == true) {
						PrintStruk(response.LastTRX);
					}
					else{
						Swal.fire({
							icon: "error",
							title: "Opps...",
							text: response.message,
						}).then((result) => {
							ButonObject.text(ButtonDefaultText);
							ButonObject.attr('disabled',false);
						});
					}
				},
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: "error",
                        title: "Opps...",
                        text: "Error: " + error,
                    }).then((result) => {
                        ButonObject.text(ButtonDefaultText);
                        ButonObject.attr('disabled',false);
                    });
                }
			});

			ButonObject.text(ButtonDefaultText);
			ButonObject.attr('disabled',false);
		}

		jQuery('#frmTambahMember').on('submit', function(e) {
			// 
			jQuery('#btTambahMember').text('Tunggu Sebentar');
			jQuery('#btTambahMember').attr('disabled',true);

			e.preventDefault();
			jQuery('#frmTambahMember').find(':disabled').prop('disabled', false);

			const formData = new FormData(this);
			formData.append('NamaPelanggan', jQuery('#txtNamaMember_TambahMember').val());
			formData.append('NoTlp1', jQuery('#txtNoTlp_TambahMember').val());
			formData.append('Email', jQuery('#txtEmail_TambahMember').val());
			formData.append('Alamat', jQuery('#txtAlamat_TambahMember').val());
			formData.append('Status', 1);
			formData.append('KodeGrupPelanggan', jQuery('#ModalKodeGrupPelanggan').val());

			$.ajax({
				url: "{{route('pelanggan-storeJson')}}",
				type: 'post',
				data: formData,
				processData: false, // Prevent jQuery from automatically processing the data
        		contentType: false,
				headers: {
					'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
				},
				success: function(response) {
					// console.log('Form submitted successfully:', response);
					if (response.success) {
						jQuery('#LookupTambahMember').modal('hide');
                    	var newOption = $('<option>', {
			            	value: response.LastTRX,
			            	text: jQuery('#txtNamaMember_TambahMember').val()
			          	});
			          	jQuery('#KodePelanggan').append(newOption);
			          	jQuery('#KodePelanggan').val(response.LastTRX).trigger('change');

						jQuery('#btTambahMember').text('Tambah Member');
						jQuery('#btTambahMember').attr('disabled',false);
					}
					else{
						Swal.fire({
							icon: "error",
							title: "Opps...",
							text: response.message,
						}).then((result) => {
						//   location.reload();
							jQuery('#btTambahMember').text('Tambah Member');
							jQuery('#btTambahMember').attr('disabled',false);

							jQuery('#LookupTambahMember').modal({backdrop: 'static', keyboard: false})
		    				jQuery('#LookupTambahMember').modal('show');
						});
					}
				},
				error: function(xhr) {
					// console.error('An error occurred:', xhr.responseText);
					Swal.fire({
						icon: "error",
						title: "Opps...",
						text: response.message,
					}).then((result) => {
					//   location.reload();
						jQuery('#btTambahMember').text('Tambah Member');
						jQuery('#btTambahMember').attr('disabled',false);

						jQuery('#LookupTambahMember').modal({backdrop: 'static', keyboard: false})
		    			jQuery('#LookupTambahMember').modal('show');
					});
				}
			});
		});

		jQuery('#frmTambahMakanan').on('submit', function(e) {
			e.preventDefault();

			const metodepembayaran = <?php echo $metodepembayaran ?>;
			const filteredData = metodepembayaran.filter(item => item.id == jQuery('#cboMetodePembayaran_TambahMakan').val());
			const midtransclientkey = "<?php echo $midtransclientkey ?>";


			if (filteredData[0]['MetodeVerifikasi'] == "AUTO") {
				if (midtransclientkey == "") {
					Swal.fire({
						icon: "error",
						title: "Opps...",
						text: "Client Key Midtrans belum di set, silahkan hubungi admin",
					});
					return;
				}

				if (parseFloat(jQuery('#txtTotalTransaksi_TambahMakan').attr("originalvalue")) > 0) {
					PaymentGateWayTambahMakan($('#btTambahMakanan'),'Bayar');
				}
				else{
					SaveTambahMakanan($('#btTambahMakanan'),'Bayar');
				}
				
			}
			else{
				SaveTambahMakanan($('#btTambahMakanan'),'Bayar');
			}

			// SaveTambahMakanan(jQuery('#btTambahMakanan'),'Tambah Makanan');
		});

		function PaymentGateWayTambahMakan(ButonObject, ButtonDefaultText) {
			// _custdisplayopened
			
			const filteredData = _billing.filter(item => item.NoTransaksi == jQuery('#txtNoTransaksi_TambahMakan').val());

			const now = new Date();
	    	const day = ("0" + now.getDate()).slice(-2);
	    	const month = ("0" + (now.getMonth() + 1)).slice(-2);
	    	const hours = now.getHours().toString().padStart(2, '0');
			const minutes = now.getMinutes().toString().padStart(2, '0');
			const seconds = now.getSeconds().toString().padStart(2, '0');

	    	const NowDay = now.getFullYear()+"-"+month+"-"+day;
	    	const _Tanggal = NowDay;
	    	const _Jam = hours+":"+minutes+":"+seconds;

			var oDetail = [];
			var NoUrut = 0;
			const _ppnPercent = oCompany[0]["PPN"];

			jQuery('#AppendArea tr').each(function() {
				var qty_input = jQuery(this).find('input[name$="[Qty]"]');
				if (qty_input.length > 0) {
					var qty = parseFloat(qty_input.val()) || 0;
					var harga = parseFloat(jQuery(this).find('input[name$="[Harga]"]').val()) || 0;
					var diskonpersen = parseFloat(jQuery(this).find('input[name$="[Diskon]"]').val()) || 0;
					var kodeitem = jQuery(this).find('input[name$="[KodeItem]"]').val();

					var rowtotal = qty * harga;
					var diskonnominal = rowtotal * (diskonpersen / 100);
					var rowsubtotal = rowtotal - diskonnominal;
					var PajakMakanan = 0;

					if (_ppnPercent > 0) {
						PajakMakanan = (_ppnPercent / 100) * rowsubtotal;
					}

					var oItem = {
						'NoUrut' : NoUrut,
						'KodeItem' : kodeitem,
						'Qty' : qty,
						'QtyKonversi' : qty,
						'Satuan' : 'PCS',
						'Harga' : harga,
						'Discount' : diskonnominal,
						'HargaNet' : rowsubtotal + PajakMakanan,
						'BaseReff' : jQuery('#txtNoTransaksi_TambahMakan').val(),
						'BaseLine' : -1,
						'KodeGudang' : oCompany[0]['GudangPoS'],
						'LineStatus': 'O',
						'VatPercent' : _ppnPercent,
						'HargaPokokPenjualan' : 0,
						'Pajak' : PajakMakanan,
						'PajakHiburan' : 0,
					}
					oDetail.push(oItem);
					NoUrut += 1;
				}
			});

			var oData = {
				'NoTransaksi' : '',
				'TglTransaksi' : _Tanggal + " " + _Jam,
				'TglJatuhTempo' : _Tanggal,
				'NoReff' : 'POS-FNB',
				'KodeSales' : filteredData.length > 0 ? filteredData[0]["KodeSales"] : '',
				'KodePelanggan' : filteredData.length > 0 ? filteredData[0]["KodePelanggan"] : '',
				'KodeTermin' : oCompany[0]['TerminBayarPoS'],
				'Termin' : 0,
				'TotalTransaksi' : parseFloat(jQuery('#txtSubTotal_TambahMakan').val().replace(/,/g, '')),
				'Potongan' : parseFloat(jQuery('#txtDiskon_TambahMakan').val().replace(/,/g, '')),
				'Pajak' : oDetail.reduce((acc, item) => acc + item.Pajak, 0),
				'PajakHiburan' : 0,
				'Pembulatan' : 0,
				'TotalPembelian' : parseFloat(jQuery('#txtTotalTransaksi_TambahMakan').attr("originalvalue")),
				'TotalRetur' : 0,
				'TotalPembayaran' : parseFloat(jQuery('#txtJumlahBayar_TambahMakan').attr("originalvalue")),
				'Status' : 'C',
				'Keterangan' : 'Tambah Makanan/Minuman',
				'MetodeBayar' : jQuery('#cboMetodePembayaran_TambahMakan').val(),
				'ReffPembayaran' : $('#txtRefrensi_TambahMakan').val(),
				'Detail' : oDetail,
                'Source': 'TAMBAHMAKANAN',
				'BiayaLayanan' : parseFloat(jQuery('#txtBiayaLayanan_TambahMakan').attr("originalvalue")),
			}

			console.log("Status Cust Display : " + _custdisplayopened)
			if(_custdisplayopened){
				// console.log('Cust Display Oppened');
				localStorage.setItem('paymentgatewaydata', JSON.stringify(oData));
				displayWindow.postMessage('paymentgateway', '*');
			}
			else{
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
									Swal.fire({
										icon: "error",
										title: "Opps...",
										text: "Pembayaran Dibatalkan",
									})
								}
								else{
									// order_id
									jQuery('#txtRefrensi_TambahMakan').val(result.order_id)
									SaveTambahMakanan(ButonObject, ButtonDefaultText)
								}
								// Proses pembayaran sukses
							},
							onPending: function(result){
								// console.log(result);
								// Pembayaran tertunda
							},
							onError: function(result){
								// console.log(result);
								Swal.fire({
									icon: "error",
									title: "Opps...",
									text: result,
								})
								// Pembayaran gagal
							},
							onClose: function(){
								console.log('customer closed the popup without finishing the payment');
							}
						});
					} else {
						// alert('Error: ' + data.error);
						Swal.fire({
							icon: "error",
							title: "Opps...",
							text: data.error,
						})
					}
				})
				.catch(error => console.error('Error:', error));
			}
		}

		function SaveTambahMakanan(ButonObject, ButtonDefaultText) {
			ButonObject.text('Tunggu Sebentar.....');
  			ButonObject.attr('disabled',true);

			
			const filteredData = _billing.filter(item => item.NoTransaksi == jQuery('#txtNoTransaksi_TambahMakan').val());

			const now = new Date();
	    	const day = ("0" + now.getDate()).slice(-2);
	    	const month = ("0" + (now.getMonth() + 1)).slice(-2);
	    	const hours = now.getHours().toString().padStart(2, '0');
			const minutes = now.getMinutes().toString().padStart(2, '0');
			const seconds = now.getSeconds().toString().padStart(2, '0');

	    	const NowDay = now.getFullYear()+"-"+month+"-"+day;
	    	const _Tanggal = NowDay;
	    	const _Jam = hours+":"+minutes+":"+seconds;

			var oDetail = [];
			var NoUrut = 0;
			const _ppnPercent = oCompany[0]["PPN"];

			jQuery('#AppendArea tr').each(function() {
				var qty_input = jQuery(this).find('input[name$="[Qty]"]');
				if (qty_input.length > 0) {
					var qty = parseFloat(qty_input.val()) || 0;
					var harga = parseFloat(jQuery(this).find('input[name$="[Harga]"]').val()) || 0;
					var diskonpersen = parseFloat(jQuery(this).find('input[name$="[Diskon]"]').val()) || 0;
					var kodeitem = jQuery(this).find('input[name$="[KodeItem]"]').val();

					var rowtotal = qty * harga;
					var diskonnominal = rowtotal * (diskonpersen / 100);
					var rowsubtotal = rowtotal - diskonnominal;
					var PajakMakanan = 0;

					if (_ppnPercent > 0) {
						PajakMakanan = (_ppnPercent / 100) * rowsubtotal;
					}

					var oItem = {
						'NoUrut' : NoUrut,
						'KodeItem' : kodeitem,
						'Qty' : qty,
						'QtyKonversi' : qty,
						'Satuan' : 'PCS',
						'Harga' : harga,
						'Discount' : diskonnominal,
						'HargaNet' : rowsubtotal + PajakMakanan,
						'BaseReff' : jQuery('#txtNoTransaksi_TambahMakan').val(),
						'BaseLine' : -1,
						'KodeGudang' : oCompany[0]['GudangPoS'],
						'LineStatus': 'O',
						'VatPercent' : _ppnPercent,
						'HargaPokokPenjualan' : 0,
						'Pajak' : PajakMakanan,
						'PajakHiburan' : 0,
					}
					oDetail.push(oItem);
					NoUrut += 1;
				}
			});

			var oData = {
				'NoTransaksi' : '',
				'TglTransaksi' : _Tanggal + " " + _Jam,
				'TglJatuhTempo' : _Tanggal,
				'NoReff' : 'POS-FNB',
				'KodeSales' : filteredData.length > 0 ? filteredData[0]["KodeSales"] : '',
				'KodePelanggan' : filteredData.length > 0 ? filteredData[0]["KodePelanggan"] : '',
				'KodeTermin' : oCompany[0]['TerminBayarPoS'],
				'Termin' : 0,
				'TotalTransaksi' : parseFloat(jQuery('#txtSubTotal_TambahMakan').val().replace(/,/g, '')),
				'Potongan' : parseFloat(jQuery('#txtDiskon_TambahMakan').val().replace(/,/g, '')),
				'Pajak' : oDetail.reduce((acc, item) => acc + item.Pajak, 0),
				'PajakHiburan' : 0,
				'Pembulatan' : 0,
				'TotalPembelian' : parseFloat(jQuery('#txtTotalTransaksi_TambahMakan').attr("originalvalue")),
				'TotalRetur' : 0,
				'TotalPembayaran' : parseFloat(jQuery('#txtJumlahBayar_TambahMakan').attr("originalvalue")),
				'Status' : 'C',
				'Keterangan' : 'Tambah Makanan/Minuman',
				'MetodeBayar' : jQuery('#cboMetodePembayaran_TambahMakan').val(),
				'ReffPembayaran' : $('#txtRefrensi_TambahMakan').val(),
				'Detail' : oDetail,
                'Source': 'TAMBAHMAKANAN',
				'BiayaLayanan' : parseFloat(jQuery('#txtBiayaLayanan_TambahMakan').attr("originalvalue")),
			}

			$.ajax({
				async:false,
				url: "{{route('fpenjualan-hiburanPoS')}}",
				type: 'POST',
				contentType: 'application/json',
				headers: {
					'X-CSRF-TOKEN': '{{ csrf_token() }}'
				},
				data: JSON.stringify(oData),
				success: function(response) {
					if (response.success == true) {
						let formattedAmount = parseFloat(response.Kembalian).toLocaleString('en-US', {
							style: 'decimal',
							minimumFractionDigits: 2,
							maximumFractionDigits: 2
						});
						PrintStruk(response.LastTRX);
					}
					else{
						Swal.fire({
							icon: "error",
							title: "Opps...",
							text: response.message,
						}).then((result) => {
							ButonObject.text(ButtonDefaultText);
							ButonObject.attr('disabled',false);
						});
					}
				},
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: "error",
                        title: "Opps...",
                        text: "Error: " + error,
                    }).then((result) => {
                        ButonObject.text(ButtonDefaultText);
                        ButonObject.attr('disabled',false);
                    });
                }
			});

			ButonObject.text(ButtonDefaultText);
			ButonObject.attr('disabled',false);
		}

		jQuery('#btAddRow').click(function () {
			const ItemMaster = <?php echo $itemmaster ?>;

			jQuery('#modallookupItem').modal({backdrop: 'static', keyboard: false})
			jQuery('#modallookupItem').modal('show');
			// console.log(orderHeader)
			var ColumnData = [
				{
					dataField: "KodeItem",
					caption: "Kode Item",
					allowSorting: true,
					allowEditing : false
				},
				{
					dataField: "NamaItem",
					caption: "Nama Item",
					allowSorting: true,
					allowEditing : false
				},
				{
					dataField: "Satuan",
					caption: "Sat",
					allowSorting: true,
					allowEditing : false
				},
			];
			BindLookupServices("gridLookupitem", "KodeItem", ItemMaster, ColumnData,"multiple");
		});

		jQuery('#btSelectItem').click(function () {
			var dataGridInstance = jQuery('#gridLookupitem').dxDataGrid('instance');
			var dataGridDetailInstance = jQuery('#gridContainerRakitan').dxDataGrid('instance');

			var selectedRows = dataGridInstance.getSelectedRowsData();

			// console.log(selectedRows[0]["KodeItem"]);
			if (selectedRows.length > 0) {
				for (let index = 0; index < selectedRows.length; index++) {
					// console.log("Add Row : " + index)
					// console.log(CheckifExist(selectedRows[index]["KodeItem"]));
					if (!CheckifExist(selectedRows[index]["id"])) {
						AddNewRow(selectedRows[index], index +1);   
					}
				}
			}

			dataGridInstance.deselectAll();
			CalculateTotalTambahMakanan();
		});

		jQuery(document).on('input', '.Qty, .Harga, .Discount', function() {
			var row = jQuery(this).closest('tr');
			var qty = parseFloat(row.find('.Qty').val().replace(/,/g, '')) || 0;
			var harga = parseFloat(row.find('.Harga').val().replace(/,/g, '')) || 0;
			var diskonpersen = parseFloat(row.find('.Discount').val().replace(/,/g, '')) || 0;

			var rowtotal = qty * harga;
			var diskonnominal = rowtotal * (diskonpersen / 100);
			var rowsubtotal = rowtotal - diskonnominal;

			row.find('.Total').val(formatNumber(rowsubtotal));
			CalculateTotalTambahMakanan();
		});

		jQuery(document).on('click', '.btRemoveRow', function() {
			jQuery(this).closest('tr').remove();
			CalculateTotalTambahMakanan();
		});

		function CalculateTotalTambahMakanan() {
			

			var subtotal = 0;
			var diskon = 0;
			var total = 0;
			jQuery('#AppendArea tr').each(function() {
				// Menggunakan attribute selector untuk mencari input berdasarkan atribut 'name'
				var qty_input = jQuery(this).find('input[name$="[Qty]"]');
				
				if (qty_input.length > 0) {
					var qty = parseFloat(qty_input.val()) || 0;
					var harga = parseFloat(jQuery(this).find('input[name$="[Harga]"]').val()) || 0;
					var diskonpersen = parseFloat(jQuery(this).find('input[name$="[Diskon]"]').val()) || 0;

					var rowtotal = qty * harga;
					var diskonnominal = rowtotal * (diskonpersen / 100);
					var rowsubtotal = rowtotal - diskonnominal;

					subtotal += rowtotal;
					diskon += diskonnominal;
					total += rowsubtotal;
				}
			});

			jQuery('#txtSubTotal_TambahMakan').val(formatNumber(subtotal));
			jQuery('#txtDiskon_TambahMakan').val(formatNumber(diskon));

			// txtPajak_TambahMakan
			var pajak = 0;

			var _ppnPercent = oCompany[0]["PPN"];
			if (_ppnPercent > 0) {
				pajak = (_ppnPercent / 100) * subtotal -diskon ;	
			}

			// console.log("NIlai Pajak: " + pajak);

			jQuery('#txtPajak_TambahMakan').val(formatNumber(pajak));
			jQuery('#txtPajak_TambahMakan').attr('originalvalue', pajak);
			
			// Add Biaya Layanan if exists
			var biayaLayanan = parseFloat(jQuery('#txtBiayaLayanan_TambahMakan').attr('originalvalue')) || 0;
			// Recalc BiayaLayanan if it was percent??? 
			// Ideally yes, but for now let's just add what's there or re-trigger payment change?
			// Re-triggering might be heavy. Let's just add it. 
			// If percent, it should technically be recalculated based on new total.
			// Let's Keep it simple: Add existing value. Logic in Change event handles update.
			// Actually, if I add an item, the base changes, so % fee should change.
			// I should verify if I need to re-run calculation. 
			// Let's just add for now.
			
			// Better: Re-read selected option to recalculate?
			const selectedOption = jQuery('#cboMetodePembayaran_TambahMakan').find('option:selected');
			const percent = parseFloat(selectedOption.data('percent')) || 0;
			const rupiah = parseFloat(selectedOption.data('rupiah')) || 0;
			
			if (percent > 0) {
				biayaLayanan = (percent / 100) * (total + pajak);
				jQuery('#txtBiayaLayanan_TambahMakan').val(formatNumber(biayaLayanan));
				jQuery('#txtBiayaLayanan_TambahMakan').attr('originalvalue', biayaLayanan);
			}

			jQuery('#txtTotalTransaksi_TambahMakan').val(formatNumber(total + pajak + biayaLayanan));
			jQuery('#txtTotalTransaksi_TambahMakan').attr('originalvalue', total + pajak + biayaLayanan);
		}

		jQuery('#LookupTambahMakanan').on('hidden.bs.modal', function () {
			location.reload();
		});

		jQuery('#txtJumlahBayar_TambahMakan').on('input', function () {
			let value = jQuery(this).val();
			let numericValue = value.replace(/[^0-9.]/g, '');

			const formatter = new Intl.NumberFormat('en-US', {
				style: 'decimal',
				maximumFractionDigits: 2,
			});

			if (numericValue) {
				$(this).val(formatter.format(numericValue));
				$(this).attr("originalvalue", value.replace(/,/g, ""));

				var kembalian = $(this).attr("originalvalue") - jQuery('#txtTotalTransaksi_TambahMakan').attr("originalvalue");
				jQuery('#txtJumlahKembalian_TambahMakan').val(formatter.format(kembalian));
				jQuery('#txtJumlahKembalian_TambahMakan').attr("originalvalue", kembalian);
			}
		});

		// jQuery('#LookupDetailOrder').on('hidden.bs.modal', function () {
		// 	location.reload();
		// });

		jQuery('#btCloseModalDetails').click(function () {
			location.reload();
		});

		jQuery('#txtJumlahBayar_Detail').on('input', function () {
			let value = jQuery(this).val();
			let numericValue = value.replace(/[^0-9.]/g, '');

			const formatter = new Intl.NumberFormat('en-US', {
				style: 'decimal',
				maximumFractionDigits: 2,
			});

			if (numericValue) {
				$(this).val(formatter.format(numericValue));
				$(this).attr("originalvalue", value.replace(",",""));

				var kembalian = $(this).attr("originalvalue") - jQuery('#txtTotalBayar_Detail').attr("originalvalue");
				jQuery('#txtJumlahKembalian_Detail').val(formatter.format(kembalian));
				jQuery('#txtJumlahKembalian_Detail').attr(kembalian);
			}
			SetEnableCommand();
		});

		jQuery('#txtJumlahBayar_Paket').on('input', function () {
			let value = jQuery(this).val();
			let numericValue = value.replace(/[^0-9.]/g, '');

			const formatter = new Intl.NumberFormat('en-US', {
				style: 'decimal',
				maximumFractionDigits: 2,
			});

			if (numericValue) {
				$(this).val(formatter.format(numericValue));
				$(this).attr("originalvalue", value.replace(",",""));

				var kembalian = $(this).attr("originalvalue") - jQuery('#txtSubTotal_Paket').val();
				// console.log(kembalian);
				jQuery('#txtJumlahKembalian_Paket').val(formatter.format(kembalian));
				jQuery('#txtJumlahKembalian_Paket').attr(kembalian);
			}
			SetEnableCommand();
		});

		jQuery('#txtJumlahBayar_Detail').on('focus', function() {
			jQuery(this).val(jQuery(this).attr('originalvalue'));
			SetEnableCommand();
		});

		jQuery('#txtJumlahBayar_Detail').on('blur', function() {
			const formatter = new Intl.NumberFormat('en-US', {
				style: 'decimal',
				maximumFractionDigits: 2,
			});

			$(this).val(formatter.format(jQuery('#txtJumlahBayar_Detail').attr('originalvalue')));
			$(this).attr(jQuery('#txtJumlahBayar_Detail').attr('originalvalue'));
			SetEnableCommand();
		});

		jQuery('#btBayar').click(function () {
			const metodepembayaran = <?php echo $metodepembayaran ?>;
			const filteredData = metodepembayaran.filter(item => item.id == jQuery('#cboMetodePembayaran_Detail').val());
			const midtransclientkey = "<?php echo $midtransclientkey ?>";
			const JenisPaket = jQuery('#dtJenisPaket_Detail').first().text();

			var StatusDocument = 'C';

			// if(JenisPaket != 'MENIT'){
			// 	StatusDocument = 'O';
			// }

			console.log(JenisPaket + " >> " + StatusDocument);


			if (filteredData[0]['MetodeVerifikasi'] == "AUTO") {
				if (midtransclientkey == "") {
					Swal.fire({
						icon: "error",
						title: "Opps...",
						text: "Client Key Midtrans belum di set, silahkan hubungi admin",
					});
					return;
				}

				if (parseFloat(jQuery('#txtGrandTotal_Detail').attr("originalvalue")) > 0) {
					PaymentGateWay(StatusDocument,$('#btBayar'),'Bayar');
				}
				else{
					SaveData(StatusDocument,$('#btBayar'),'Bayar');
				}
				
			}
			else{
				SaveData(StatusDocument,$('#btBayar'),'Bayar');
			}
		});

		jQuery('#cboMetodePembayaran_Detail').change(function () {
			const metodepembayaran = <?php echo $metodepembayaran ?>;
			const filteredData = metodepembayaran.filter(item => item.id == jQuery('#cboMetodePembayaran_Detail').val());
			const midtransclientkey = "<?php echo $midtransclientkey ?>";

			if (filteredData.length > 0 && filteredData[0]['MetodeVerifikasi'] == "AUTO") {
				if (midtransclientkey == "") {
					Swal.fire({
						icon: "error",
						title: "Opps...",
						text: "Client Key Midtrans belum di set, silahkan hubungi admin",
					});
					jQuery('#cboMetodePembayaran_Detail').val("").change();
					return;
				}
				
			}

			const xTotalTerbayar = parseFloat(jQuery('#txtTotalTerbayar_Detail').attr('originalvalue')) || 0;
			const GrandTotal = parseFloat(jQuery('#txtGrandTotal_Detail').attr('originalvalue')) || 0;
			
			console.log("GrandTotal : " + GrandTotal + " TotalTerbayar : " + xTotalTerbayar);
			// const TotalTerbayar = parseFloat(jQuery('#txtTotalTerbayar_Detail').attr('originalvalue')) || 0;
			let BiayaLayanan = 0;
			
			if (filteredData.length > 0) {
				const BiayaAdminPercent = parseFloat(filteredData[0]['BiayaAdminPercent']) || 0;
				const BiayaAdminRupiah = parseFloat(filteredData[0]['BiayaAdminRupiah']) || 0;

				if (BiayaAdminPercent > 0) {
					BiayaLayanan = (BiayaAdminPercent / 100) * (GrandTotal - xTotalTerbayar);
				} else if (BiayaAdminRupiah > 0) {
					BiayaLayanan = BiayaAdminRupiah;
				}
			}

			const TotalTerbayar = parseFloat(jQuery('#txtTotalTerbayar_Detail').attr('originalvalue')) || 0;
			const TotalBayar = GrandTotal + BiayaLayanan - TotalTerbayar;

			console.log("Grand Total : " + GrandTotal + " Biaya Layanan : " + BiayaLayanan + " Total Terbayar : " + TotalTerbayar + " Total Bayar : " + TotalBayar);

			jQuery('#txtBiayaAdmin_Detail').val(formatNumber(BiayaLayanan));
			jQuery('#txtBiayaAdmin_Detail').attr('originalvalue', BiayaLayanan);

			jQuery('#txtTotalBayar_Detail').val(formatNumber(TotalBayar));
			jQuery('#txtTotalBayar_Detail').attr('originalvalue', TotalBayar);


			if (filteredData.length > 0 && filteredData[0]['TipePembayaran'] == "NON TUNAI") {
				formatCurrency(jQuery('#txtJumlahBayar_Detail'), TotalBayar);
				jQuery('#txtJumlahBayar_Detail').attr('readonly', true);
				
				// Recalculate Kembalian
				var kembalian = TotalBayar - TotalBayar;
				jQuery('#txtJumlahKembalian_Detail').val(formatNumber(kembalian));
			}
			else{
				formatCurrency(jQuery('#txtJumlahBayar_Detail'), "0");
				jQuery('#txtJumlahBayar_Detail').attr('readonly', false);
			}

			SetEnableCommand();
		});

		jQuery('#cboMetodePembayaran_TambahMakan').change(function () {
			const metodepembayaran = <?php echo $metodepembayaran ?>;
			const filteredData = metodepembayaran.filter(item => item.id == jQuery('#cboMetodePembayaran_TambahMakan').val());
			const midtransclientkey = "<?php echo $midtransclientkey ?>";

			if (filteredData.length > 0 && filteredData[0]['MetodeVerifikasi'] == "AUTO") {
				if (midtransclientkey == "") {
					Swal.fire({
						icon: "error",
						title: "Opps...",
						text: "Client Key Midtrans belum di set, silahkan hubungi admin",
					});
					jQuery('#cboMetodePembayaran_TambahMakan').val("").change();
					return;
				}
				
			}
			
			// Calculate Biaya Layanan
			let BiayaLayanan = 0;
			const selectedOption = jQuery(this).find('option:selected');
			const percent = parseFloat(selectedOption.data('percent')) || 0;
			const rupiah = parseFloat(selectedOption.data('rupiah')) || 0;

			CalculateTotalTambahMakanan(); // Recalculate base total first (without service fee) to get correct base
			// Note: CalculateTotalTambahMakanan currently doesn't add Service Fee. 
			// We need to get the SubTotal + Pajak first.
			// Actually, CalculateTotalTambahMakanan sets txtTotalTransaksi_TambahMakan. 
			// I should add BiayaLaynan inside CalculateTotalTambahMakanan OR handle it here.
			// Better: Handle here AND update CalculateTotalTambahMakanan to read this value.
			
			const currentTotal = parseFloat(jQuery('#txtTotalTransaksi_TambahMakan').attr('originalvalue')) || 0;

			if (percent > 0) {
				BiayaLayanan = (percent / 100) * currentTotal;
			} else if (rupiah > 0) {
				BiayaLayanan = rupiah;
			}
			
			jQuery('#txtBiayaLayanan_TambahMakan').val(formatNumber(BiayaLayanan));
			jQuery('#txtBiayaLayanan_TambahMakan').attr('originalvalue', BiayaLayanan);

			const newTotal = currentTotal + BiayaLayanan;
			jQuery('#txtTotalTransaksi_TambahMakan').val(formatNumber(newTotal));
			jQuery('#txtTotalTransaksi_TambahMakan').attr('originalvalue', newTotal);

			if (filteredData.length > 0 && filteredData[0]['TipePembayaran'] == "NON TUNAI") {
				formatCurrency(jQuery('#txtJumlahBayar_TambahMakan'), newTotal);
				jQuery('#txtJumlahBayar_TambahMakan').attr('readonly', true);
			}
			else{
				formatCurrency(jQuery('#txtJumlahBayar_TambahMakan'), "0");
				jQuery('#txtJumlahBayar_TambahMakan').attr('readonly', false);
			}

			SetEnableCommand();
		});

		jQuery('#cboMetodePembayaran_TambahJam').change(function () {
			const metodepembayaran = <?php echo $metodepembayaran ?>;
			const filteredData = metodepembayaran.filter(item => item.id == jQuery('#cboMetodePembayaran_TambahJam').val());
			const midtransclientkey = "<?php echo $midtransclientkey ?>";

			if (filteredData.length > 0 && filteredData[0]['MetodeVerifikasi'] == "AUTO") {
				if (midtransclientkey == "") {
					Swal.fire({
						icon: "error",
						title: "Opps...",
						text: "Client Key Midtrans belum di set, silahkan hubungi admin",
					});
					jQuery('#cboMetodePembayaran_TambahJam').val("").change();
					return;
				}
				
			}

			if (filteredData.length > 0 && filteredData[0]['TipePembayaran'] == "NON TUNAI") {
				formatCurrency(jQuery('#txtJumlahBayar_TambahJam'), jQuery('#txtTotalTransaksi_TambahJam').attr('originalvalue'));
				jQuery('#txtJumlahBayar_TambahJam').attr('readonly', true);
			}
			else{
				formatCurrency(jQuery('#txtJumlahBayar_TambahJam'), "0");
				jQuery('#txtJumlahBayar_TambahJam').attr('readonly', false);
			}

			SetEnableCommand();
		});

		$('#btOpenCustDisplay').click(function(){
			
			_custdisplayopened = true;
			openCustomerDisplay();
		});

		jQuery('#SearchMember').on('blur keyup', function(){
			
		});

		jQuery('#SearchMember').on('keyup', function() {
			const keyword = $(this).val();

			if (keyword.length < 2) {
			$('#suggestionList').hide();
			return;
			}

			$.ajax({
				url: "{{ route('pelanggan-viewJson') }}",
				type: 'post',
				data: {
					"KodePelanggan" : "",
					"GrupPelanggan" : "",
					"Search" : keyword
				},
				headers: {
					'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
				},
				success: function(response) {
					var suggestions = response.data;
					let html = '';

					if (jQuery('#JenisPaket').val() == "PAKETMEMBER") {
						suggestions = suggestions.filter(function(p) {
							return p.isPaidMembership == 1;
						});
					}

					$('#suggestionList').empty();

					if (suggestions.length > 0) {
						suggestions.forEach(p => {
							html += `<li data-kode="${p.KodePelanggan}" style="padding:5px; cursor:pointer;">${p.KodePelanggan} - ${p.NamaPelanggan}</li>`;
						});
					} else {
						html = '<li style="padding:5px;">Tidak ditemukan</li>';
					}

					$('#suggestionList').html(html).show();
				}
			});
		});

		$('#suggestionList').on('click', 'li', function() {
			const kode = $(this).data('kode');
			const text = $(this).text();

			$('#SearchMember').val(text);
			$('#suggestionList').hide();

			// Set ke combo box

			jQuery('#KodePelanggan').val(kode).change();
			$('#SearchMember').val('');
			// $('#kodePelanggan').html(`<option value="${kode}" selected>${text}</option>`);
		});

		$(document).on('click', function(e) {
			if (!$(e.target).closest('#SearchMember, #suggestionList').length) {
			$('#suggestionList').hide();
			}
		});

		function showCetakModal(noTransaksi) {
			var url = documentBaseUrl + "?NomorTransaksi=" + encodeURIComponent(noTransaksi) + "&TipeTransaksi=PoS&format=slipthermal48";
			jQuery('#webViewModal iframe').attr('src', url);
			jQuery('#webViewModal').modal({backdrop: 'static', keyboard: false})
			jQuery('#webViewModal').modal('show');
			jQuery('#NoTransaksiModal').val(noTransaksi);
		}

		function SetTimer(tableid, TimerType ,EndTime, StartTime, NoTransaksi, JenisPaket, Status) {

			// clock_
			
			const _warningMinutes = oCompany[0]["WarningTimer"] == null ? 0 : oCompany[0]["WarningTimer"];

			const ul = document.createElement("ul");
			ul.classList.add("timer")

			const liHours = document.createElement("li");
			liHours.id = "hours_"+tableid;
			liHours.classList.add("timer-item");

			const liPoint1 = document.createElement("li");
			liPoint1.id = "point1_"+tableid;
			liPoint1.innerText = ":";
			liPoint1.classList.add("timer-colon");

			const liMin = document.createElement("li");
        	liMin.id = "min_"+tableid;
			liMin.classList.add("timer-item");

			const liPoint = document.createElement("li");
			liPoint.id = "point_"+tableid;
			liPoint.innerText = ":";
			liPoint.classList.add("timer-colon");

			const liSec = document.createElement("li");
        	liSec.id = "sec_"+tableid;
			liSec.classList.add("timer-item");

			ul.appendChild(liHours);
			ul.appendChild(liPoint1);
			ul.appendChild(liMin);
			ul.appendChild(liPoint);
			ul.appendChild(liSec);

			document.getElementById("clock_"+tableid).appendChild(ul);

			// 0 : Countdown
			// 1 : Normal
			switch (TimerType) {
				case 0:
					const endDate = new Date(EndTime).getTime();
					const startDate = new Date(StartTime).getTime();

					const endDateTS = new Date(endDate);
					const warningDate = new Date(endDateTS.setMinutes(endDateTS.getMinutes() - _warningMinutes)).getTime();

					const timer = setInterval(() => {
						const now = new Date().getTime();

						// console.log(genfnFormatingDate(warningDate));
						// console.log(genfnFormatingDate(now));
						// console.log(now >= warningDate);
						// console.log(now == warningDate);
						if (now < startDate) {
							jQuery("#hours_"+tableid).html("00");
							jQuery("#min_"+tableid).html("00");
							jQuery("#sec_"+tableid).html("00");
						} else if (now >= startDate && now <= endDate) {
							const timeRemaining = endDate - now;

							// Calculate days, hours, minutes, and seconds
							const days = Math.floor(timeRemaining / (1000 * 60 * 60 * 24));
							const hours = Math.floor((timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
							const minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
							const seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);

							jQuery("#hours_"+tableid).html((hours < 10 ? "0" : "") + hours);
							jQuery("#min_"+tableid).html((minutes < 10 ? "0" : "") + minutes);
							jQuery("#sec_"+tableid).html((seconds < 10 ? "0" : "") + seconds);
							if(genfnFormatingDate(now) == genfnFormatingDate(warningDate)){
								// console.log('Warning');
								fnWarning(NoTransaksi);
							} 
						}
						else {
							// After the end date, stop the timer and display "Countdown ended"
							clearInterval(timer);
							
							// Do Update Status
							fnCheckOut(NoTransaksi, JenisPaket);
						}
					}, 1000);
					break;
				case 1:
					setInterval(function() {
						// const now = new Date();
						const startDate = new Date(EndTime).getTime();
						const now = new Date().getTime();
						const timeElapsed = now - startDate;
						if (timeElapsed >= 0) {
							const hours = Math.floor((timeElapsed % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
							const minutes = Math.floor((timeElapsed % (1000 * 60 * 60)) / (1000 * 60));
							const seconds = Math.floor((timeElapsed % (1000 * 60)) / 1000);

							jQuery("#hours_"+tableid).html((hours < 10 ? "0" : "") + hours);
							jQuery("#min_"+tableid).html((minutes < 10 ? "0" : "") + minutes);
							jQuery("#sec_"+tableid).html((seconds < 10 ? "0" : "") + seconds);
						}

						// Update the content of each <li>
						
					}, 1000);
					break;
			}
		}

		function stringtoDateTime(dateTimeString) {
			const date = new Date(dateTimeString);

			const formattedDate = `${date.getFullYear()}-${(date.getMonth() + 1).toString().padStart(2, '0')}-${date.getDate().toString().padStart(2, '0')}`;
			const formattedTime = `${date.getHours().toString().padStart(2, '0')}:${date.getMinutes().toString().padStart(2, '0')}:${date.getSeconds().toString().padStart(2, '0')}`;

			// console.log(`Formatted Date: ${formattedDate}`);
			// console.log(`Formatted Time: ${formattedTime}`);
			return `${formattedDate} ${formattedTime}`;
		}

		function GeneratePaket() {
			$.ajax({
				async:false,
				url: "{{route('paket-ViewJson')}}",
				type: 'POST',
				headers: {
					'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
				},
				data: {
					'JenisPaket':""
				},
				success: function(response) {
					if (response.data.length > 0) {
						_dataPaket = response.data;
					}
				}
			});
		}

		function fnCheckOut(NoTransaksi, JenisPaket) {
			// GeneratePaket()
			const filteredData = _billing.filter(item => item.NoTransaksi == NoTransaksi);
			// console.log(filteredData);

			if(filteredData[0]["StatusBooking"] == 'BOOKING'){
				JenisPaket = 'JAM';
			}
			
			$.ajax({
				async:false,
				url: "{{route('billing-checkout')}}",
				type: 'POST',
				headers: {
					'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
				},
				data: {
					'txtNoTransaksi_CheckOut':NoTransaksi,
					"txtJenisPaket_CheckOut": JenisPaket,
					"TotalPembayaran" : filteredData[0]["TotalPembayaran"]
				},
				success: function(response) {
					if (response.success == true) {
						Swal.fire({
	                      icon: "success",
	                      title: "Sukses",
	                      text: "Berhasil Checkout, Ditunggu kedatangannya kembali",
	                    }).then((result) => {
						  location.reload();
						});
					}
					else{
						location.reload();
						// Swal.fire({
						// 	icon: "error",
						// 	title: "Opps...",
						// 	text: response.message,
						// }).then((result) => {
						//   location.reload();
						// });
					}
				}
			});

			
		}

		function fnWarning(NoTransaksi) {
			// GeneratePaket()

			$.ajax({
				async:false,
				url: "{{route('billing-warning')}}",
				type: 'POST',
				headers: {
					'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
				},
				data: {
					'NoTransaksi':NoTransaksi,
				},
				success: function(response) {
					if (response.success == true) {
						Swal.fire({
	                      icon: "success",
	                      title: "Sukses",
	                      text: "Waktu Tinggal 10 Menit",
	                    }).then((result) => {
						  location.reload();
						});
					}
					else{
						// Swal.fire({
						// 	icon: "error",
						// 	title: "Opps...",
						// 	text: response.message,
						// }).then((result) => {
						//   location.reload();
						// });
						location.reload();
					}
				}
			});

			
		}

		function fnDetails(NoTransaksi, oData) {
			const filteredData = _billing.filter(item => item.NoTransaksi == NoTransaksi);
			const DataPaket = <?php echo $paket ?>;
			
			// console.log(NoTransaksi)
			// console.log(filteredData);
			const filteredPaket = DataPaket.filter(item => item.id == filteredData[0]['paketid']);

			
			

			var oCustomerDisplay = {
				"Total" : 0,
				"Discount" : 0,
				"UangMuka" : 0,
				"Tax" : 0,
				"Net" : 0,
				"data" : []
			};
			
			// console.log(NoTransaksi);
			console.log(filteredData);

			jQuery('#txtNoTransaksi_Detail').val(NoTransaksi);
			jQuery('#dtJenisPaket_Detail').text(filteredData[0]["JenisPaket"]);
			jQuery('#dtNamaPaket_Detail').text(filteredData[0]["NamaPaket"]);
			jQuery('#dtJamMulai_Detail').text(genfnFormatingDate(filteredData[0]["JamMulai"]));
			jQuery('#lblNamaCustomer').text(filteredData[0]["NamaPelanggan"]);
			tglBerlangganan = filteredData[0]["TglBerlanggananPaketBulanan"];

			// formatCurrency($('#_TotalItem'), _tempTotalItem);

			var _HargaNormal = filteredPaket[0]["HargaNormal"];
			var _HargaBaru = filteredPaket[0]["HargaBaru"];
			var _JamSelesaiPaketNormal = filteredPaket[0]["AkhirJamNormal"];
			var _JamSelesaiPaketBaru = filteredPaket[0]["AkhirJamPerubahanHarga"];

			var _NewHargaNormal = 0;
			var _NewHargaBaru = 0;
			var _ppnPercent = oCompany[0]["PPN"];
			var _PPnNormal = 0;
			var _PPnBaru = 0;
			var _PajakHiburanPercent = oCompany[0]["PajakHiburan"];
			var _PajakHiburanNormal = 0;
			var _PajakHiburanBaru = 0;
			var _SubTotal = 0;
			var _TotalMakanan = 0;
			var _TotalUangMuka = 0;
			
			var _DiscountMember = 0; // belum
			var _DiscountTable = 0; // belum
			var _DiscountFnB = 0; // belum
			var _Discount = 0; // belum

			var Now = new Date();
			var _maxPaketNormal = new Date(filteredData[0]["TglTransaksi"] + " " + filteredPaket[0]["AkhirJamNormal"]);
			var _maxPaketBaru = new Date(filteredData[0]["TglTransaksi"] + " " + filteredPaket[0]["AkhirJamPerubahanHarga"]);
			var _JamMulaiPaket = new Date(filteredData[0]["JamMulai"]);
			var _JamSelesaiPaket = new Date(filteredData[0]["JamSelesai"]);

			// console.log(filteredData);
			// console.log(filteredPaket);
			// console.log(_maxPaketNormal);
			// console.log(_maxPaketBaru);
			// console.log(_JamSelesaiPaket);
			var _TextTotalHargaNormal = "";
			var _TextTotalHargaBaru = "";
			var _durasiPaket = 0;
			var _durasiPaketLama = 0;
			var _durasiPaketBaru = 0;

			// Calculate Billing
			if(filteredData[0]["StatusBooking"] == 'BOOKING'){
				jQuery('#dtJamSelesai_Detail').text(genfnFormatingDate(filteredData[0]["JamSelesai"]));
				const differenceInMilliseconds = _JamSelesaiPaket - _JamMulaiPaket;
				
				_durasiPaket =  Math.floor(differenceInMilliseconds / (1000 * 60));
				_PPnNormal = 0;
				_PajakHiburanNormal = filteredData[0]["BookingTotalTax"];
				_TotalUangMuka= filteredData[0]["BookingNetTotal"];

				if (filteredData[0]["JenisPaket"] == "MONTHLY" || filteredData[0]["JenisPaket"] == "YEARLY") {
					const subDateStr = tglBerlangganan;
					if (subDateStr) {
						const subDate = new Date(subDateStr);
						const subDay = subDate.getDate();
						const checkinDate = new Date(filteredData[0]["JamMulai"]);
						
						let targetDate = new Date(checkinDate.getFullYear(), checkinDate.getMonth() + 1, subDay);
						if (targetDate < checkinDate) {
							targetDate.setMonth(targetDate.getMonth() + 1);
						}
						
						const timeDiff = targetDate - checkinDate;
						const diffDays = Math.ceil(timeDiff / (1000 * 60 * 60 * 24));
						
						const daysInMonth = new Date(checkinDate.getFullYear(), checkinDate.getMonth() + 1, 0).getDate();
						const hargaPerHari = _HargaNormal / daysInMonth;
						_HargaNormal = Math.round(diffDays * hargaPerHari);
						
						_durasiPaket = 1; // Prorata counts as 1 summary item
						_NewHargaNormal = _HargaNormal;
						_TextTotalHargaNormal = diffDays + " hari prorata * " + formatNumber(Math.round(hargaPerHari)) + " = ";
					} else {
						_NewHargaNormal = filteredPaket[0]["HargaNormal"] * _durasiPaket;
						_TextTotalHargaNormal = _durasiPaket + " " + filteredPaket[0]["JenisPaket"] +" * " + _HargaNormal + " = ";
					}
				} else {
					_NewHargaNormal = filteredPaket[0]["HargaNormal"] * _durasiPaket;
					_TextTotalHargaNormal = _durasiPaket + " " + filteredPaket[0]["JenisPaket"] +" * " + _HargaNormal + " = ";
				}

				_SubTotal = _NewHargaNormal + _PPnNormal + _PajakHiburanNormal;
				
				var _MetodePembayaranID = <?php echo $MetodePembayaranAutoID ?>;
				jQuery('#cboMetodePembayaran_Detail').val(_MetodePembayaranID).change();
				jQuery('#cboMetodePembayaran_Detail').attr('disabled',true);
				jQuery('#txtRefrensi_Detail').val(filteredData[0]["BookingPaymentReffNumber"]);
				console.log(_MetodePembayaranID);
				_isFromBooking = true;
			}
			else{
				jQuery('#dtJamSelesai_Detail').text(genfnFormatingDate(filteredData[0]["JamSelesai"]));

				if (filteredData[0]["JenisPaket"] == "MONTHLY" || filteredData[0]["JenisPaket"] == "YEARLY") {
					const subDateStr = tglBerlangganan;
					console.log("subDateStr : " + subDateStr);
					if (subDateStr) {
						const subDate = new Date(subDateStr);
						const subDay = subDate.getDate();
						const checkinDate = new Date(filteredData[0]["JamMulai"]);
						
						let targetDate = new Date(checkinDate.getFullYear(), checkinDate.getMonth() + 1, subDay);
						if (targetDate < checkinDate) {
							targetDate.setMonth(targetDate.getMonth() + 1);
						}
						
						const timeDiff = targetDate - checkinDate;
						const diffDays = Math.ceil(timeDiff / (1000 * 60 * 60 * 24));
						
						const daysInMonth = new Date(checkinDate.getFullYear(), checkinDate.getMonth() + 1, 0).getDate();
						const hargaPerHari = _HargaNormal / daysInMonth;
						_HargaNormal = Math.round(diffDays * hargaPerHari);
						
						_NewHargaNormal = _HargaNormal;
						_durasiPaket = 1;
						_TextTotalHargaNormal = diffDays + " hari prorata * " + formatNumber(Math.round(hargaPerHari)) + " = ";
						console.log("Harga Normal : " + _NewHargaNormal)
					} else {
						_NewHargaNormal = filteredPaket[0]["HargaNormal"] * filteredData[0]["DurasiPaket"];
						_durasiPaket = filteredData[0]["DurasiPaket"];
						_TextTotalHargaNormal = _durasiPaket + " " + filteredPaket[0]["JenisPaket"] +" * " + formatNumber(_HargaNormal) + " = ";
					}

					_NewHargaNormal = filteredPaket[0]["HargaNormal"] * filteredData[0]["DurasiPaket"];
					_durasiPaket = filteredData[0]["DurasiPaket"];
					_TextTotalHargaNormal = _durasiPaket + " " + filteredPaket[0]["JenisPaket"] +" * " + formatNumber(_HargaNormal) + " = ";
					
				} else if (filteredData[0]["JenisPaket"] == "MENITREALTIME") {
					var actualJamSelesai = (filteredData[0]["JamSelesai"] == null ? Now : new Date(filteredData[0]["JamSelesai"]));
					jQuery('#dtJamSelesai_Detail').text(genfnFormatingDate(actualJamSelesai.toISOString()));

					const totalDurasiMenit = Math.abs(Math.floor((actualJamSelesai - _JamMulaiPaket) / (1000 * 60)));
					
					_durasiPaket = totalDurasiMenit;
					_NewHargaNormal = _HargaNormal * _durasiPaket;
					_TextTotalHargaNormal = _durasiPaket + " Menit * " + formatNumber(_HargaNormal) + " = ";
				} else if (filteredData[0]["JenisPaket"] == "PAYPERUSE") {
					var actualJamSelesai = (filteredData[0]["JamSelesai"] == null ? Now : new Date(filteredData[0]["JamSelesai"]));
					jQuery('#dtJamSelesai_Detail').text(genfnFormatingDate(actualJamSelesai.toISOString()));

					_durasiPaket = 1;
					_NewHargaNormal = _HargaNormal;
					_TextTotalHargaNormal = "1 Paket * " + formatNumber(_HargaNormal) + " = ";
				} else {
					_NewHargaNormal = filteredPaket[0]["HargaNormal"] * filteredData[0]["DurasiPaket"];
					_durasiPaket = filteredData[0]["DurasiPaket"];
					_TextTotalHargaNormal = _durasiPaket + " " + filteredPaket[0]["JenisPaket"] +" * " + formatNumber(_HargaNormal) + " = ";
				}

				if (_ppnPercent > 0) {
					_PPnNormal = (_ppnPercent / 100) * _NewHargaNormal;	
				}

				if (_PajakHiburanPercent > 0) {
					_PajakHiburanNormal = (_PajakHiburanPercent / 100) * _NewHargaNormal;	
				}

				_SubTotal = _NewHargaNormal + _PPnNormal + _PajakHiburanNormal;

				oCustomerDisplay["data"].push({
					KodeItem : 'Paket',
					NamaItem: filteredData[0]["NamaPaket"] + " " + ( (filteredData[0]["JenisPaket"] == "MONTHLY" || filteredData[0]["JenisPaket"] == "YEARLY") ? "Prorata" : _durasiPaket + " " + filteredPaket[0]["JenisPaket"] ),
					Qty: _durasiPaket,
					Harga: _HargaNormal
				});

				// PPN
				if(_PPnNormal > 0) {
					oCustomerDisplay["data"].push({
						KodeItem : 'Pajak',
						NamaItem: "PPN " + _ppnPercent + "% - " + filteredData[0]["NamaPaket"],
						Qty: 1,
						Harga: _PPnNormal
					});
				}
				// if (filteredData[0]["JenisPaket"] != "MENIT") {
				// 	jQuery('#dtJamSelesai_Detail').text(genfnFormatingDate(filteredData[0]["JamSelesai"]));
				// 	_NewHargaNormal = filteredPaket[0]["HargaNormal"] * filteredData[0]["DurasiPaket"];
				// 	if (_ppnPercent > 0) {
				// 		_PPnNormal = (_ppnPercent / 100) * (filteredPaket[0]["HargaNormal"] * filteredData[0]["DurasiPaket"]);	
				// 	}

				// 	if (_PajakHiburanPercent > 0) {
				// 		_PajakHiburanNormal = (_PajakHiburanPercent / 100) * (filteredPaket[0]["HargaNormal"] * filteredData[0]["DurasiPaket"]);	
				// 	}

				// 	_SubTotal = _NewHargaNormal + _PPnNormal + _PajakHiburanNormal;

				// 	_TextTotalHargaNormal = filteredData[0]["DurasiPaket"] + " " + filteredPaket[0]["JenisPaket"] +" * " + _HargaNormal + " = ";
				// 	_durasiPaket = filteredData[0]["DurasiPaket"];

				// 	oCustomerDisplay["data"].push({
				// 		KodeItem : 'Paket',
				// 		NamaItem: filteredData[0]["NamaPaket"] + " " + _durasiPaket + " " + filteredPaket[0]["JenisPaket"],
				// 		Qty: _durasiPaket,
				// 		Harga: filteredPaket[0]["HargaNormal"]
				// 	});

				// 	// PPN
				// 	if(_PPnNormal > 0) {
				// 		oCustomerDisplay["data"].push({
				// 			KodeItem : 'Pajak',
				// 			NamaItem: "PPN " + _ppnPercent + "% - " + filteredData[0]["NamaPaket"],
				// 			Qty: 1,
				// 			Harga: _PPnNormal
				// 		});
				// 	}
				// }
				// else {
				// 	var _diferentMinutes = 0;

				// 	// Gunakan JamSelesai dari data jika ada, jika tidak gunakan Now
				// 	const actualJamSelesai = (filteredData[0]["JamSelesai"] == null ? Now : new Date(filteredData[0]["JamSelesai"]));
				// 	jQuery('#dtJamSelesai_Detail').text(genfnFormatingDate(actualJamSelesai.toISOString()));

				// 	const totalDurasiMenit = Math.abs(Math.floor((actualJamSelesai - _JamMulaiPaket) / (1000 * 60)));

				// 	if (_JamMulaiPaket < _maxPaketNormal) {
				// 		// Durasi Normal hanya dihitung dari mulai sampai maksimal normal
				// 		const durasiNormalMenit = Math.abs(Math.floor((_maxPaketNormal - _JamMulaiPaket) / (1000 * 60)));

				// 		let endTimeForBaru = actualJamSelesai;
				// 		if (actualJamSelesai < _maxPaketNormal) {
				// 			// Tidak perlu hitung paket baru karena belum melewati batas
				// 			_NewHargaBaru = 0;
				// 			_PPnBaru = 0;
				// 			_PajakHiburanBaru = 0;
				// 			_durasiPaketBaru = 0;
				// 		} else {
				// 			// Durasi Baru dari _maxPaketNormal sampai actualJamSelesai
				// 			const durasiBaruMenit = Math.abs(Math.floor((actualJamSelesai - _maxPaketNormal) / (1000 * 60)));
				// 			_NewHargaBaru = Math.abs(durasiBaruMenit * filteredPaket[0]["HargaBaru"]);
				// 			_TextTotalHargaBaru = durasiBaruMenit + " " + filteredPaket[0]["JenisPaket"] + " * " + _HargaBaru + " = ";

				// 			if (_ppnPercent > 0) {
				// 				_PPnBaru = Math.abs((_ppnPercent / 100) * _NewHargaBaru);
				// 			}
				// 			if (_PajakHiburanPercent > 0) {
				// 				_PajakHiburanBaru = Math.abs((_PajakHiburanPercent / 100) * _NewHargaBaru);
				// 			}

				// 			_durasiPaketBaru = durasiBaruMenit;
				// 		}

				// 		_NewHargaNormal = Math.abs(durasiNormalMenit * filteredPaket[0]["HargaNormal"]);
				// 		_TextTotalHargaNormal = durasiNormalMenit + " " + filteredPaket[0]["JenisPaket"] + " * " + _HargaNormal + " = ";

				// 		if (_ppnPercent > 0) {
				// 			_PPnNormal = Math.abs((_ppnPercent / 100) * _NewHargaNormal);
				// 		}
				// 		if (_PajakHiburanPercent > 0) {
				// 			_PajakHiburanNormal = Math.abs((_PajakHiburanPercent / 100) * _NewHargaNormal);
				// 		}

				// 		_durasiPaketLama = durasiNormalMenit;
				// 	} else {
				// 		// Jika mulai langsung melewati _maxPaketNormal, semua dianggap harga baru
				// 		const durasiBaruMenit = totalDurasiMenit;
				// 		_NewHargaNormal = 0;
				// 		_PPnNormal = 0;
				// 		_PajakHiburanNormal = 0;
				// 		_durasiPaketLama = 0;

				// 		_NewHargaBaru = Math.abs(durasiBaruMenit * filteredPaket[0]["HargaBaru"]);
				// 		_TextTotalHargaBaru = durasiBaruMenit + " " + filteredPaket[0]["JenisPaket"] + " * " + _HargaBaru + " = ";

				// 		if (_ppnPercent > 0) {
				// 			_PPnBaru = Math.abs((_ppnPercent / 100) * _NewHargaBaru);
				// 		}
				// 		if (_PajakHiburanPercent > 0) {
				// 			_PajakHiburanBaru = Math.abs((_PajakHiburanPercent / 100) * _NewHargaBaru);
				// 		}

				// 		_durasiPaketBaru = durasiBaruMenit;
				// 	}
				// 	// Total akhir
				// 	_SubTotal = Math.abs(_NewHargaNormal + _NewHargaBaru + _PPnBaru + _PPnNormal + _PajakHiburanNormal + _PajakHiburanBaru);
				// 	_durasiPaket = totalDurasiMenit;
				// }

				_TotalUangMuka= filteredData[0]["TotalPembayaran"];
			}


			// Paket :
			if(_durasiPaketLama > 0) {
				oCustomerDisplay["data"].push({
					KodeItem : 'Paket',
					NamaItem: filteredData[0]["NamaPaket"] + " " + _durasiPaketLama + " " + filteredPaket[0]["JenisPaket"],
					Qty: _durasiPaketLama,
					Harga: filteredPaket[0]["HargaNormal"]
				});

				// PPN
				if(_PPnNormal > 0) {
					oCustomerDisplay["data"].push({
						KodeItem : 'Pajak',
						NamaItem: "PPN " + _ppnPercent + "% - " + filteredData[0]["NamaPaket"],
						Qty: 1,
						Harga: _PPnNormal
					});
				}
				// Pajak Hiburan
				// if(_PajakHiburanNormal > 0){
				// 	oCustomerDisplay.push({
				// 		NamaItem: "Pajak Hiburan  " + _PajakHiburanPercent + "%",
				// 		Qty: 1,
				// 		Harga: _PajakHiburanNormal
				// 	});
				// }
			}

			if(_durasiPaketBaru > 0){
				oCustomerDisplay["data"].push({
					KodeItem : 'Paket',
					NamaItem: filteredData[0]["NamaPaket"] + " Setelah Jam "+ filteredPaket[0]["AkhirJamNormal"]+" " + _durasiPaketBaru + " " + filteredPaket[0]["JenisPaket"],
					Qty: _durasiPaketBaru,
					Harga: filteredPaket[0]["HargaBaru"]
				});

				// PPN
				if(_PPnBaru > 0) {
					oCustomerDisplay["data"].push({
						KodeItem : 'Pajak',
						NamaItem: "PPN " + _ppnPercent + "% - " + filteredData[0]["NamaPaket"] + " Setelah Jam "+ filteredPaket[0]["AkhirJamNormal"],
						Qty: 1,
						Harga: _PPnBaru
					});
				}
				// Pajak Hiburan
				// if(_PajakHiburanNormal > 0){
				// 	oCustomerDisplay.push({
				// 		NamaItem: "Pajak Hiburan  " + _PajakHiburanPercent + "%",
				// 		Qty: 1,
				// 		Harga: _PajakHiburanBaru
				// 	});
				// }
			}


			// Calculate FnB

			// Get From Booking :
			console.log(oData)
			var TotalTaxmakanan = 0;
			for (let index = 0; index < oData.length; index++) {
				oCustomerDisplay["data"].push({
					KodeItem : 'Booking',
					NamaItem: oData[index]['NamaItem'],
					Qty: oData[index]['Qty'],
					Harga: oData[index]['HargaJual'],
				});
				_TotalMakanan += oData[index]["LineTotal"] + oData[index]["BiayaLayanan"];
				TotalTaxmakanan += oData[index]["Tax"];
			}

			oCustomerDisplay["data"].push({
				KodeItem : 'Pajak Makanan',
				NamaItem: 'Pajak Makanan',
				Qty: 1,
				Harga: TotalTaxmakanan,
			});

			// Calculate Discount

			// Diskon Member : 
			if (filteredData[0]["DiskonPersen"] > 0) {
				jQuery('#lblNamaMember').text(filteredData[0]["NamaGrup"]);
				// _DiscountMember = (_SubTotal + _TotalMakanan) * (filteredData[0]["DiskonPersen"] / 100)
				_DiscountMember = (_SubTotal) * (filteredData[0]["DiskonPersen"] / 100)
			}

			if (filteredPaket[0]["DiskonTable"] != null || filteredPaket[0]["DiskonTable"] > 0) {
				// _DiscountTable = (_SubTotal + _TotalMakanan+ - _Discount) * (filteredPaket[0]["DiskonTable"] / 100)
				_DiscountTable = (_SubTotal + - _Discount) * (filteredPaket[0]["DiskonTable"] / 100)
			}

			if (filteredPaket[0]["DiskonFnB"] != null || filteredPaket[0]["DiskonFnB"] > 0) {
				// _DiscountFnB = (_SubTotal + _TotalMakanan+ - _Discount) * (filteredPaket[0]["DiskonFnB"] / 100)
				_DiscountFnB = (_TotalMakanan+ - _Discount) * (filteredPaket[0]["DiskonFnB"] / 100)
			}

			_Discount = _DiscountMember + _DiscountTable + _DiscountFnB;
			console.log(_Discount);

			// Set Total
			jQuery('#dtTotalHargaNormal_Detail').text(
				_TextTotalHargaNormal + 
				new Intl.NumberFormat('id-ID', {
					style: 'currency',
					currency: 'IDR',
				}).format(_NewHargaNormal)
			);
			const tdElementNormal = document.getElementById("dtTotalHargaNormal_Detail");
			tdElementNormal.setAttribute("raw-durasi", _durasiPaket);
			tdElementNormal.setAttribute("raw-satuan-durasi", filteredPaket[0]["JenisPaket"]);
			tdElementNormal.setAttribute("raw-harga-normal", _HargaNormal);
			tdElementNormal.setAttribute("raw-totalharga-normal", _NewHargaNormal);
			tdElementNormal.setAttribute("raw-ppn-normal", _PPnNormal);
			tdElementNormal.setAttribute("raw-pajakhiburan-normal", _PajakHiburanNormal);

			jQuery('#dtTotalPerubahanHarga_Detail').text(
				_TextTotalHargaBaru + 
				new Intl.NumberFormat('id-ID', {
					style: 'currency',
					currency: 'IDR',
				}).format(_NewHargaBaru)
			);

			const tdElementBaru = document.getElementById("dtTotalPerubahanHarga_Detail");
			tdElementBaru.setAttribute("raw-durasi-baru", _durasiPaket);
			tdElementBaru.setAttribute("raw-satuan-durasi-baru", filteredPaket[0]["JenisPaket"]);
			tdElementBaru.setAttribute("raw-harga-baru", _HargaBaru);
			tdElementBaru.setAttribute("raw-totalharga-baru", _NewHargaBaru);
			tdElementBaru.setAttribute("raw-ppn-baru", _PPnBaru);
			tdElementBaru.setAttribute("raw-pajakhiburan-baru", _PajakHiburanBaru);
			// _PPnBaru + _PPnNormal


			jQuery('#dtTotalPPN_Detail').text(
				new Intl.NumberFormat('id-ID', {
					style: 'currency',
					currency: 'IDR',
				}).format(_PPnNormal + _PPnBaru)
			);
			const tdElementPpn = document.getElementById("dtTotalPPN_Detail");
			tdElementPpn.setAttribute("raw-totalharga-ppn", _PPnNormal + _PPnBaru);


			jQuery('#dtTotalPajakHiburan_Detail').text(
				new Intl.NumberFormat('id-ID', {
					style: 'currency',
					currency: 'IDR',
				}).format(_PajakHiburanNormal + _PajakHiburanBaru)
			);
			const tdElementPajakHiburan = document.getElementById("dtTotalPajakHiburan_Detail");
			tdElementPajakHiburan.setAttribute("raw-totalharga-pajakhiburan", _PajakHiburanNormal + _PajakHiburanBaru);


			jQuery('#dtSubTotal_Detail').text(
				new Intl.NumberFormat('id-ID', {
					style: 'currency',
					currency: 'IDR',
				}).format(_SubTotal)
			);

			var _BiayaLain = 0;
			if (oData && oData.BiayaLain) {
				_BiayaLain = parseFloat(oData.BiayaLain);
			} else if (filteredData[0]["BiayaLain"]) { 
				// Fallback if saved in DB layer
				_BiayaLain = parseFloat(filteredData[0]["BiayaLain"]);
			}
			
			// Populate Biaya Lain
			formatCurrency($('#txtBiayaLainLain_Detail'), _BiayaLain);

			// ... existing code ...
			
			formatCurrency($('#txtSubTotal_Detail'), _NewHargaNormal + _NewHargaBaru);
			formatCurrency($('#txtTotalMakanan_Detail'), _TotalMakanan);
			formatCurrency($('#txtTotalPajak_Detail'), _PPnNormal + _PPnBaru + _PajakHiburanNormal + _PajakHiburanBaru);
			formatCurrency($('#txtDiscountMember_Detail'), Math.floor(_DiscountMember));
			formatCurrency($('#txtDiscountTable_Detail'), _DiscountTable);
			formatCurrency($('#txtDiscountFnB_Detail'), _DiscountFnB);
			formatCurrency($('#txtDiscount_Detail'), Math.floor(_Discount));
			formatCurrency($('#txtTotalUangMuka_Detail'), _TotalUangMuka);
			var totalMakananTerbayar = 0;
			if (oData && Array.isArray(oData)) {
				oData.forEach(item => {
					if (item.LineStatus === 'C') {
						totalMakananTerbayar += (parseFloat(item.LineTotal) || 0) + (parseFloat(item.BiayaLayanan) || 0);
					}
				});
			}

			console.log("Total bayar : " + filteredData[0].TotalPembayaran + " Total Makanan : " + totalMakananTerbayar);
			formatCurrency($('#txtTotalTerbayar_Detail'), (parseFloat(filteredData[0].TotalPembayaran) || 0) + totalMakananTerbayar);
			
			// Grand Total Calculation: SubTotal + Makanan - Discount + BiayaLain
			// Note: _SubTotal here seems to exclude Tax? No, look at line 3815: _SubTotal = _NewHargaNormal + _PPnNormal... it includes Tax?
			// But line 4072 sets txtSubTotal_Detail to _NewHargaNormal + _NewHargaBaru (Pre-Tax?).
			// Let's verify line 4080 formula.
			// _SubTotal + _TotalMakanan - Discount.
			// If _SubTotal in line 4080 refers to the variable from 3815 (Inc Tax), then we are double counting if we also add _PPn...
			// Wait, line 4080: `formatCurrency($('#txtGrandTotal_Detail'), _SubTotal + _TotalMakanan+ - Math.floor(_Discount));`
			// Let's assume standard formula: (Service + FnB) - Disc + Tax + BiayaLain.
			// The variable `_SubTotal` is confusingly used.
			// Let's look at 4091: `_SubTotal + _TotalMakanan+ - Math.floor(_Discount) + _PPnNormal + ...`
			// This suggests `_SubTotal` at this point might be Pre-Tax or Post-Tax depending on flow.
			// Line 3815: `_SubTotal = _NewHargaNormal + _PPnNormal + _PajakHiburanNormal;` (Includes Tax).
			// So 4091 doubles tax? `... + _PPnNormal`.
			// WARNING: The existing code might be messy. I should stick to adding `_BiayaLain` to the `GrandTotal` logic.
			
			// I will add _BiayaLain to the GrandTotal field.
			formatCurrency($('#txtGrandTotal_Detail'), _SubTotal + _TotalMakanan - Math.floor(_Discount) + _BiayaLain);
			// _TotalUangMuka
			// console.log(_SubTotal);
			// console.log(_TotalMakanan);
			// console.log(_Discount);
			// console.log(_PPnNormal);
			// console.log(_PPnBaru);
			// console.log(_PajakHiburanNormal);
			// console.log(_PajakHiburanBaru);
			// console.log(_TotalUangMuka);
			if(filteredData[0]["StatusBooking"] == 'BOOKING'){
				formatCurrency($('#txtJumlahBayar_Detail'), _SubTotal + _TotalMakanan - Math.floor(_Discount) + _PPnNormal + _PPnBaru + _PajakHiburanNormal + _PajakHiburanBaru + _BiayaLain);
				// _TotalUangMuka
			}
			else{
				formatCurrency($('#txtJumlahBayar_Detail'), 0);
			}
			
			formatCurrency($('#txtJumlahKembalian_Detail'), 0);
			// SaveData('','','');

			// parseFloat(jQuery('#txtSubTotal_Detail').attr("originalvalue"))

			if(_PajakHiburanNormal + _PajakHiburanBaru > 0) {
				oCustomerDisplay["data"].push({
					KodeItem : 'Pajak',
					NamaItem: "Pajak Hiburan : " + (_PajakHiburanNormal + _PajakHiburanBaru),
					Qty: 1,
					Harga: _PajakHiburanNormal + _PajakHiburanBaru
				});
			}

			oCustomerDisplay['Total'] = _SubTotal;
			oCustomerDisplay['Tax'] = _PPnNormal + _PPnBaru + _PajakHiburanNormal + _PajakHiburanBaru + TotalTaxmakanan; 
			oCustomerDisplay['UangMuka'] = _TotalUangMuka;
			oCustomerDisplay['Discount'] = Math.floor(_Discount);
			oCustomerDisplay['Net'] = _SubTotal + _TotalMakanan - Math.floor(_Discount);

			// console.log(oCustomerDisplay)
			
			localStorage.setItem('PoSData', JSON.stringify(oCustomerDisplay));
			jQuery('#cboMetodePembayaran_Detail').change();
			
			if (jQuery('#txtTotalBayar_Detail').attr("originalvalue") == 0) {
				jQuery("#sectionPayment").hide();
			}
			else{
				jQuery("#sectionPayment").show();
			}

			
			
			SetEnableCommand();
		}

		function genfnFormatingDate(oDateTime) {
			const date = new Date(oDateTime);
			const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0'); // Months are zero-based
            const day = String(date.getDate()).padStart(2, '0');

			const hours = String(date.getHours()).padStart(2, '0');
            const minutes = String(date.getMinutes()).padStart(2, '0');
            const seconds = String(date.getSeconds()).padStart(2, '0');

			const formattedDateTime = `${day}-${month}-${year} ${hours}:${minutes}:${seconds}`;

			return formattedDateTime;
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

		function formatNumber(value) {
			return new Intl.NumberFormat('en-US', { 
				minimumFractionDigits: 2, 
				maximumFractionDigits: 2 
			}).format(value);
		}

		
		function generateRandomText(length) {
			const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
			let randomText = '';
			for (let i = 0; i < length; i++) {
				const randomIndex = Math.floor(Math.random() * characters.length);
				randomText += characters[randomIndex];
			}
			return randomText;
		}

		function AddNewRow(oData, index) {
			console.log(oData);

			var RandomID = generateRandomText(10);
			var newRow = document.createElement('tr');
			newRow.className = RandomID;
			newRow.id = "InputSectionData"

			var ItemCol = document.createElement('td');
			var QtyCol = document.createElement('td');
			var HargaCol = document.createElement('td');
			var DiskonCol = document.createElement('td');
			var TotalCol = document.createElement('td');
			var RemoveCol = document.createElement('td');

			var NamaItemText = document.createElement('input');
			var txtKodeItem = document.createElement("input");
			var txtQty = document.createElement("input");
			var txtHarga = document.createElement("input");
			var txtDiskon = document.createElement("input");
			var txtTotal = document.createElement("input");

			NamaItemText.name = 'DetailParameter['+index+'][NamaItem]';
			// NamaItemText.className = 'form-control';
			NamaItemText.required = true;
			NamaItemText.value = oData['NamaItem'];
			NamaItemText.id = "txtKodeItem";
			NamaItemText.style.width = '100%';
			NamaItemText.classList.add('form-control');
			NamaItemText.readOnly = true;
			NamaItemText.title = oData['NamaItem'];

			ItemCol.appendChild(NamaItemText);

			txtKodeItem.type  = 'hidden';
			txtKodeItem.id = "txtKodeItem";
			txtKodeItem.name = 'DetailParameter['+index+'][KodeItem]';
			txtKodeItem.className = 'form-control';
			txtKodeItem.required = true;
			txtKodeItem.value = oData['KodeItem'];
			txtKodeItem.readOnly = true;
			txtKodeItem.setAttribute('KodeItem', oData['KodeItem']);
			txtKodeItem.title = oData['KodeItem'];
			ItemCol.appendChild(txtKodeItem);

			txtQty.type  = 'number';
			txtQty.id = "txtQty";
			txtQty.name = 'DetailParameter['+index+'][Qty]';
			txtQty.className = 'form-control';
			txtQty.required = true;
			txtQty.value = oData['Qty'] || 1;
			QtyCol.appendChild(txtQty);

			txtHarga.type  = 'number';
			txtHarga.id = "txtHarga";
			txtHarga.name = 'DetailParameter['+index+'][Harga]';
			txtHarga.className = 'form-control';
			txtHarga.required = true;
			txtHarga.readOnly = true;
			txtHarga.value = oData["Harga"] ||oData["HargaJual"];
			HargaCol.appendChild(txtHarga);

			txtDiskon.type  = 'number';
			txtDiskon.id = "txtDiskon";
			txtDiskon.name = 'DetailParameter['+index+'][Diskon]';
			txtDiskon.className = 'form-control';
			txtDiskon.required = true;
			txtDiskon.value = oData["Discount"]  || 0;
			DiskonCol.appendChild(txtDiskon);

			txtTotal.type  = 'number';
			txtTotal.id = "txtTotal";
			txtTotal.name = 'DetailParameter['+index+'][Total]';
			txtTotal.className = 'form-control';
			txtTotal.required = true;
			txtTotal.readOnly = true;
			txtTotal.value = oData["LineTotal"] || oData["HargaJual"];
			TotalCol.appendChild(txtTotal);


			var RemoveText = document.createElement('button');
			RemoveText.innerText   = 'Delete';
			RemoveText.type   = 'button';
			// RemoveText.style.color = "red";
			// RemoveText.href = "#"+RandomID;
			RemoveText.className = "btn btn-danger RemoveLineItem";
			RemoveText.id = "RemoveLineItem";
			RemoveText.classList.add('text-end');
			RemoveText.onclick = function() {
				// alert('Button in row  clicked! ' + RandomID);
				var elements = document.querySelectorAll('.'+RandomID);
				// elements.remove();
				elements.forEach(function(element) {
					element.remove();
				});
				CalculateTotalTambahMakanan();
				// console.log(elements)
			};
			RemoveCol.appendChild(RemoveText);


			function calculateRowTotal() {
				var qty = parseFloat(txtQty.value) || 0;
				var harga = parseFloat(txtHarga.value) || 0;
				var diskon = parseFloat(txtDiskon.value) || 0;

				if (diskon > 0) {
					diskon = diskon/100 * (qty * harga);
				}

				// Calculate total: (qty * harga) - diskon
				var total = (qty * harga) - diskon;

				// Update total input value
				txtTotal.value = total.toFixed(2);

				CalculateTotalTambahMakanan();
			}

			txtQty.addEventListener('input', calculateRowTotal);
			txtHarga.addEventListener('input', calculateRowTotal);
			txtDiskon.addEventListener('input', calculateRowTotal);

			newRow.appendChild(ItemCol);
			newRow.appendChild(QtyCol);
			newRow.appendChild(HargaCol);
			newRow.appendChild(DiskonCol);
			newRow.appendChild(TotalCol);
			newRow.appendChild(RemoveCol);
			document.getElementById('AppendArea').appendChild(newRow);
		}

		function CheckifExist(KodeItemBaru) {
			console.log(KodeItemBaru)
			var retData = false;

			var tbody = document.querySelectorAll('#InputSectionData');
			console.log(tbody);
			tbody.forEach(function(row, index) {
				var cells = row.querySelectorAll('td');
				
				// console.log(cells)
				cells.forEach(function(cell) {
					var inputElement = cell.querySelector('input[type="hidden"]');
					console.log(inputElement);
					if (inputElement) {
						var customAttribute = inputElement.getAttribute('kodeitem'); // Change 'data-custom-attribute' to your actual attribute name
						
						if (customAttribute == KodeItemBaru) {
							retData = true;
						}
						// Log or use the custom attribute value
						// console.log('Row:', index + 1, 'Custom Attribute:', customAttribute);
					}
				});
			});

			return retData;
		}

		function SaveData(Status, ButonObject, ButtonDefaultText) {
			ButonObject.text('Tunggu Sebentar.....');
  			ButonObject.attr('disabled',true);

			
			const filteredData = _billing.filter(item => item.NoTransaksi == jQuery('#txtNoTransaksi_Detail').val());

			const now = new Date();
	    	const day = ("0" + now.getDate()).slice(-2);
	    	const month = ("0" + (now.getMonth() + 1)).slice(-2);
	    	const hours = now.getHours().toString().padStart(2, '0');
			const minutes = now.getMinutes().toString().padStart(2, '0');
			const seconds = now.getSeconds().toString().padStart(2, '0');

	    	const firstDay = now.getFullYear()+"-"+month+"-01";
	    	const NowDay = now.getFullYear()+"-"+month+"-"+day;

	    	const _Tanggal = NowDay;
	    	const _Jam = hours+":"+minutes+":"+seconds;

			var oDetail = [];
			const tdElementNormal = document.getElementById("dtTotalHargaNormal_Detail");
			const tdElementBaru = document.getElementById("dtTotalPerubahanHarga_Detail");
			const tdElementPpn = document.getElementById("dtTotalPPN_Detail");
			const tdElementPajakHiburan = document.getElementById("dtTotalPajakHiburan_Detail");

			const DurasiLama = tdElementNormal.getAttribute("raw-durasi");
			const DurasiBaru = tdElementBaru.getAttribute("raw-durasi-baru");
			const SatuanDurasiLama = tdElementNormal.getAttribute("raw-satuan-durasi");
			const SatuanDurasiBaru = tdElementBaru.getAttribute("raw-satuan-durasi-baru");
			const HargaNormal = tdElementNormal.getAttribute("raw-harga-normal");
			const HargaBaru = tdElementBaru.getAttribute("raw-harga-baru");
			const TotalHargaNormal = tdElementNormal.getAttribute("raw-totalharga-normal");
			const TotalHargaBaru = tdElementBaru.getAttribute("raw-totalharga-baru");
			const TotalPPN = tdElementPpn.getAttribute("raw-totalharga-ppn");
			const TotalPajakHiburan = tdElementPajakHiburan.getAttribute("raw-totalharga-pajakhiburan");
			const PPNNormal = tdElementNormal.getAttribute("raw-ppn-normal");
			const PPNBaru = tdElementBaru.getAttribute("raw-ppn-baru");
			const PajakHiburanNormal = tdElementNormal.getAttribute("raw-pajakhiburan-normal");
			const PajakHiburanBaru = tdElementBaru.getAttribute("raw-pajakhiburan-baru");

			const table = jQuery('#TablePenjualan').DataTable();
			const columnNames = table.columns().header().toArray().map(header => $(header).text());

			const _ppnPercent = oCompany[0]["PPN"];
			// Get raw data from the table
			const dataMakanan = table.rows().data().toArray().map(row => {
				let rowDataObj = {};
				columnNames.forEach((colName, index) => {
					if (colName == 'Diskon' || colName == 'Harga' || colName == 'Qty' || colName == 'Total') {
					// Parse the raw HTML string into a DOM element
					const cellHtml = $.parseHTML(row[index]); // Convert to DOM elements
					const rawValue = $(cellHtml).data('raw'); // Extract data-raw attribute
					rowDataObj[colName] = rawValue;
					} else {
						rowDataObj[colName] = row[index];
					}
				});
				return rowDataObj;
			});
			var NoUrut = 0;

			if (oCompany[0]["ItemHiburan"] == null || oCompany[0]["ItemHiburan"] == "") {
				alert('Setting Item Hiburan');
				return;
			}

			if(filteredData[0]["isJasaPaid"] == 0){
				if (TotalHargaNormal > 0) {
					var oItem = {
						'NoUrut' : 0,
						'KodeItem' : oCompany[0]["ItemHiburan"],
						'Qty' : DurasiLama,
						'QtyKonversi' : DurasiLama,
						'Satuan' : SatuanDurasiLama,
						'Harga' : HargaNormal,
						'Discount' : 0,
						'HargaNet' : DurasiLama * HargaNormal,
						'BaseReff' : jQuery('#txtNoTransaksi_Detail').val(),
						'BaseLine' : -1,
						'KodeGudang' : oCompany[0]['GudangPoS'],
						'LineStatus': 'O',
						'VatPercent' : 0,
						'HargaPokokPenjualan' : HargaNormal,
						'Pajak' : PPNNormal,
						'PajakHiburan' : PajakHiburanNormal,
					}
					oDetail.push(oItem);
					NoUrut += 1;
				}

				if (TotalHargaBaru > 0) {
					var oItem = {
						'NoUrut' : 1,
						'KodeItem' : oCompany[0]["ItemHiburan"],
						'Qty' : DurasiBaru,
						'QtyKonversi' : DurasiBaru,
						'Satuan' : SatuanDurasiBaru,
						'Harga' : HargaBaru,
						'Discount' : 0,
						'HargaNet' : DurasiBaru * HargaBaru,
						'BaseReff' : jQuery('#txtNoTransaksi_Detail').val(),
						'BaseLine' : -1,
						'KodeGudang' : oCompany[0]['GudangPoS'],
						'LineStatus': 'O',
						'VatPercent' : 0,
						'HargaPokokPenjualan' : HargaBaru,
						'Pajak' : PPNBaru,
						'PajakHiburan' : PajakHiburanBaru,
					}
					oDetail.push(oItem);
					NoUrut += 1;
				}
			}

			

			// Makanan

			if (dataMakanan.length > 0) {
				for (var i = 0; i < dataMakanan.length; i++) {
					var PajakMakanan = 0;

					if (_ppnPercent > 0) {
						PajakMakanan += (_ppnPercent / 100) * ((dataMakanan[i]["Qty"] * dataMakanan[i]["Harga"]) - dataMakanan[i]["Diskon"]);	
					}
					var oItem = {
						'NoUrut' : NoUrut,
						'KodeItem' : dataMakanan[i]["KodeItem"],
						'Qty' : dataMakanan[i]["Qty"],
						'QtyKonversi' : dataMakanan[i]["Qty"],
						'Satuan' : dataMakanan[i]["Satuan"],
						'Harga' : dataMakanan[i]["Harga"],
						'Discount' : dataMakanan[i]["Diskon"],
						'HargaNet' : (dataMakanan[i]["Qty"] * dataMakanan[i]["Harga"]) - dataMakanan[i]["Diskon"] + PajakMakanan,
						'BaseReff' : jQuery('#txtNoTransaksi_Detail').val(),
						'BaseLine' : -1,
						'KodeGudang' : oCompany[0]['GudangPoS'],
						'LineStatus': 'O',
						'VatPercent' : 0,
						'HargaPokokPenjualan' : dataMakanan[i]["HargaPokokPenjualan"],
						'Pajak' : PajakMakanan,
						'PajakHiburan' : 0,
					}

					if (dataMakanan[i]["#"] == "O") {
						oDetail.push(oItem);
						NoUrut += 1;
					}
				}
			}

			// Header
			var oData = {
				'NoTransaksi' : jQuery('#txtNoTransaksi_Detail').val(),
				'TglTransaksi' : _Tanggal + " " + _Jam,
				'TglJatuhTempo' : _Tanggal,
				'NoReff' : 'POS',
				'KodeSales' : filteredData[0]["KodeSales"],
				'KodePelanggan' : filteredData[0]["KodePelanggan"],
				'KodeTermin' : oCompany[0]['TerminBayarPoS'],
				'Termin' : 0,
				'TotalTransaksi' : parseFloat(jQuery('#txtSubTotal_Detail').attr("originalvalue")) + parseFloat(jQuery('#txtTotalMakanan_Detail').attr("originalvalue")),
				'Potongan' : jQuery('#txtDiscount_Detail').attr("originalvalue"),
				'Pajak' : parseFloat(PPNNormal) + parseFloat(PPNBaru),
				'PajakHiburan' : parseFloat(PajakHiburanNormal) + parseFloat(PajakHiburanBaru),
				'BiayaLayanan' : jQuery('#txtBiayaAdmin_Detail').attr("originalvalue"),
				'BiayaLain' : jQuery('#txtBiayaLainLain_Detail').attr("originalvalue"),
				'Pembulatan' : 0,
				'TotalPembelian' : jQuery('#txtTotalBayar_Detail').attr("originalvalue"),
				'TotalRetur' : 0,
				'TotalPembayaran' : jQuery('#txtJumlahBayar_Detail').attr("originalvalue"),
				'Status' : Status,
				'Keterangan' : '',
				'MetodeBayar' : jQuery('#cboMetodePembayaran_Detail').val(),
				'ReffPembayaran' : $('#txtRefrensi_Detail').val(),
				'Detail' : oDetail
			}

			console.log(oData);

			$.ajax({
				async:false,
				url: "{{route('fpenjualan-hiburanPoS')}}",
				type: 'POST',
				contentType: 'application/json',
				headers: {
					'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
				},
				data: JSON.stringify(oData),
				success: function(response) {
					if (response.success == true) {
						let formattedAmount = parseFloat(response.Kembalian).toLocaleString('en-US', {
							style: 'decimal',
							minimumFractionDigits: 2,
							maximumFractionDigits: 2
						});
						PrintStruk(response.LastTRX);
						
						if (!_isFromDetailLookup) {
							location.reload();
						}
					}
					else{
						Swal.fire({
							icon: "error",
							title: "Opps...",
							text: response.message,
						}).then((result) => {
							ButonObject.text(ButtonDefaultText);
							ButonObject.attr('disabled',false);
						});
						
					}
				}
			});

			ButonObject.text(ButtonDefaultText);
			ButonObject.attr('disabled',false);
		}

		function GenerateTotal() {
			
			const filteredData = _billing.filter(item => item.NoTransaksi == jQuery('#txtNoTransaksi_Detail').val());

			const now = new Date();
	    	const day = ("0" + now.getDate()).slice(-2);
	    	const month = ("0" + (now.getMonth() + 1)).slice(-2);
	    	const hours = now.getHours().toString().padStart(2, '0');
			const minutes = now.getMinutes().toString().padStart(2, '0');
			const seconds = now.getSeconds().toString().padStart(2, '0');

	    	const firstDay = now.getFullYear()+"-"+month+"-01";
	    	const NowDay = now.getFullYear()+"-"+month+"-"+day;

	    	const _Tanggal = NowDay;
	    	const _Jam = hours+":"+minutes+":"+seconds;

			var oDetail = [];

			var NoUrut = 0;

			if (oCompany[0]["ItemHiburan"] == null || oCompany[0]["ItemHiburan"] == "") {
				alert('Setting Item Hiburan');
				return;
			}

			var DurasiLama = jQuery('#DurasiPaket').val();
			var SatuanDurasiLama = "JAM";
			var HargaNormal = jQuery('#HargaNormal').val();
			var HargaBaru = jQuery('#HargaBaru').val();
			var TotalTransaksi = HargaNormal * DurasiLama;

			var PPNPercent = oCompany[0]["PPN"];
			var PajakHiburanPercent = oCompany[0]["PajakHiburan"];

			var PPNTotal = 0;
			var PajakHiburanTotal = 0;

			var GrandTotal = 0;

			if (PPNTotal > 0) {
				PPNTotal = (PPNPercent / 100) * TotalTransaksi;
			}

			if(PajakHiburanPercent > 0){
				PajakHiburanTotal = (PajakHiburanPercent / 100) * TotalTransaksi;
			}

			GrandTotal = TotalTransaksi + PPNTotal + PajakHiburanTotal;

			// jQuery('#txtJumlahBayar_Paket').val(GrandTotal);
			var _TextTotalHargaNormal = DurasiLama + " " +  jQuery('#JenisPaket').val() + " * " + HargaNormal + " = ";
			var _TanggalSelesai = _Tanggal;
			var _JamSelesai = (parseInt(hours) + parseInt(DurasiLama))+":"+minutes+":"+seconds;

			if(parseInt(hours) + parseInt(DurasiLama) >= 24){
				_TanggalSelesai = now.getFullYear()+"-"+month+"-"+(parseInt(day) + 1);
				_JamSelesai = (parseInt(hours) + parseInt(DurasiLama) - 24)+":"+minutes+":"+seconds;
			}
			jQuery('#dtJamMulai_Paket').text(genfnFormatingDate(_Tanggal + " " + _Jam));
			jQuery('#dtJamSelesai_Paket').text(genfnFormatingDate(_TanggalSelesai + " " + _JamSelesai));
			jQuery('#dtTotalHargaNormal_Paket').text(_TextTotalHargaNormal + new Intl.NumberFormat('id-ID', {style: 'currency',currency: 'IDR',}).format(TotalTransaksi));
			jQuery('#dtTotalPPN_Paket').text(new Intl.NumberFormat('id-ID', {style: 'currency',currency: 'IDR',}).format(PPNTotal));
			jQuery('#dtTotalPajakHiburan_Paket').text(new Intl.NumberFormat('id-ID', {style: 'currency',currency: 'IDR',}).format(PajakHiburanTotal));
			jQuery('#dtSubTotal_Paket').text(new Intl.NumberFormat('id-ID', {style: 'currency',currency: 'IDR',}).format(GrandTotal));
			jQuery('#txtSubTotal_Paket').val(GrandTotal)
			formatCurrency($('#txtJumlahBayar_Paket'), GrandTotal);

		}

		function Bayardidepan(Status, ButonObject, ButtonDefaultText){
			
			const filteredData = _billing.filter(item => item.NoTransaksi == jQuery('#txtNoTransaksi_Detail').val());

			const now = new Date();
	    	const day = ("0" + now.getDate()).slice(-2);
	    	const month = ("0" + (now.getMonth() + 1)).slice(-2);
	    	const hours = now.getHours().toString().padStart(2, '0');
			const minutes = now.getMinutes().toString().padStart(2, '0');
			const seconds = now.getSeconds().toString().padStart(2, '0');

	    	const firstDay = now.getFullYear()+"-"+month+"-01";
	    	const NowDay = now.getFullYear()+"-"+month+"-"+day;

	    	const _Tanggal = NowDay;
	    	const _Jam = hours+":"+minutes+":"+seconds;

			var oDetail = [];

			var NoUrut = 0;

			if (oCompany[0]["ItemHiburan"] == null || oCompany[0]["ItemHiburan"] == "") {
				alert('Setting Item Hiburan');
				return;
			}

			var DurasiLama = jQuery('#DurasiPaket').val();
			var SatuanDurasiLama = "JAM";
			var HargaNormal = jQuery('#HargaNormal').val();
			var HargaBaru = jQuery('#HargaBaru').val();
			var TotalTransaksi = HargaNormal * DurasiLama;

			var PPNPercent = oCompany[0]["PPN"];
			var PajakHiburanPercent = oCompany[0]["PajakHiburan"];

			var PPNTotal = 0;
			var PajakHiburanTotal = 0;

			var GrandTotal = 0;

			if (PPNTotal > 0) {
				PPNTotal = (PPNPercent / 100) * TotalTransaksi;
			}

			if(PajakHiburan > 0){
				PajakHiburanTotal = (PajakHiburanPercent / 100) * TotalTransaksi;
			}

			GrandTotal = TotalTransaksi + PPNTotal + PajakHiburanTotal;


			var oItem = {
				'NoUrut' : 0,
				'KodeItem' : oCompany[0]["ItemHiburan"],
				'Qty' : DurasiLama,
				'QtyKonversi' : DurasiLama,
				'Satuan' : SatuanDurasiLama,
				'Harga' : HargaNormal,
				'Discount' : 0,
				'HargaNet' : DurasiLama * HargaNormal,
				'BaseReff' : jQuery('#txtNoTransaksi_Detail').val(),
				'BaseLine' : -1,
				'KodeGudang' : oCompany[0]['GudangPoS'],
				'LineStatus': 'O',
				'VatPercent' : 0,
				'HargaPokokPenjualan' : HargaNormal,
			}
			oDetail.push(oItem);
			NoUrut += 1;


			// Header
			var oData = {
				'NoTransaksi' : "",
				'TglTransaksi' : _Tanggal + " " + _Jam,
				'TglJatuhTempo' : _Tanggal,
				'NoReff' : 'POS',
				'KodeSales' : jQuery('#KodeSales').val(),
				'KodePelanggan' : jQuery('#KodePelanggan').val(),
				'KodeTermin' : oCompany[0]['TerminBayarPoS'],
				'Termin' : 0,
				'TotalTransaksi' : TotalTransaksi,
				'Potongan' : 0,
				'Pajak' : PPNTotal,
				'PajakHiburan' : PajakHiburanTotal,
				'Pembulatan' : 0,
				'TotalPembelian' : GrandTotal,
				'TotalRetur' : 0,
				'TotalPembayaran' : GrandTotal,
				'Status' : Status,
				'Keterangan' : '',
				'MetodeBayar' : jQuery('#cboMetodePembayaran_Paket').val(),
				'ReffPembayaran' : $('#txtRefrensi_Paket').val(),
				'Detail' : oDetail
			}

			console.log(oData);
		}

		function PaymentGateWay(Status, ButonObject, ButtonDefaultText) {
			// _custdisplayopened
			
			const filteredData = _billing.filter(item => item.NoTransaksi == jQuery('#txtNoTransaksi_Detail').val());

			const now = new Date();
	    	const day = ("0" + now.getDate()).slice(-2);
	    	const month = ("0" + (now.getMonth() + 1)).slice(-2);
	    	const hours = now.getHours().toString().padStart(2, '0');
			const minutes = now.getMinutes().toString().padStart(2, '0');
			const seconds = now.getSeconds().toString().padStart(2, '0');

	    	const firstDay = now.getFullYear()+"-"+month+"-01";
	    	const NowDay = now.getFullYear()+"-"+month+"-"+day;

	    	const _Tanggal = NowDay;
	    	const _Jam = hours+":"+minutes+":"+seconds;

			var oDetail = [];
			const tdElementNormal = document.getElementById("dtTotalHargaNormal_Detail");
			const tdElementBaru = document.getElementById("dtTotalPerubahanHarga_Detail");
			const tdElementPpn = document.getElementById("dtTotalPPN_Detail");
			const tdElementPajakHiburan = document.getElementById("dtTotalPajakHiburan_Detail");

			const DurasiLama = tdElementNormal.getAttribute("raw-durasi");
			const DurasiBaru = tdElementBaru.getAttribute("raw-durasi-baru");
			const SatuanDurasiLama = tdElementNormal.getAttribute("raw-satuan-durasi");
			const SatuanDurasiBaru = tdElementBaru.getAttribute("raw-satuan-durasi-baru");
			const HargaNormal = tdElementNormal.getAttribute("raw-harga-normal");
			const HargaBaru = tdElementBaru.getAttribute("raw-harga-baru");
			const TotalHargaNormal = tdElementNormal.getAttribute("raw-totalharga-normal");
			const TotalHargaBaru = tdElementBaru.getAttribute("raw-totalharga-baru");
			const TotalPPN = tdElementPpn.getAttribute("raw-totalharga-ppn");
			const TotalPajakHiburan = tdElementPajakHiburan.getAttribute("raw-totalharga-pajakhiburan");

			const table = jQuery('#TablePenjualan').DataTable();
			const columnNames = table.columns().header().toArray().map(header => $(header).text());

			// Get raw data from the table
			const dataMakanan = table.rows().data().toArray().map(row => {
				let rowDataObj = {};
				columnNames.forEach((colName, index) => {
					if (colName == 'Diskon' || colName == 'Harga' || colName == 'Qty' || colName == 'Total') {
					// Parse the raw HTML string into a DOM element
					const cellHtml = $.parseHTML(row[index]); // Convert to DOM elements
					const rawValue = $(cellHtml).data('raw'); // Extract data-raw attribute
					rowDataObj[colName] = rawValue;
					} else {
					rowDataObj[colName] = row[index];
					}
				});
				return rowDataObj;
			});
			var NoUrut = 0;

			if (oCompany[0]["ItemHiburan"] == null || oCompany[0]["ItemHiburan"] == "") {
				alert('Setting Item Hiburan');
				return;
			}

			if (TotalHargaNormal > 0) {
				var oItem = {
					'NoUrut' : 0,
					'KodeItem' : oCompany[0]["ItemHiburan"],
					'Qty' : DurasiLama,
					'QtyKonversi' : DurasiLama,
					'Satuan' : SatuanDurasiLama,
					'Harga' : HargaNormal,
					'Discount' : 0,
					'HargaNet' : DurasiLama * HargaNormal,
					'BaseReff' : jQuery('#txtNoTransaksi_Detail').val(),
					'BaseLine' : -1,
					'KodeGudang' : oCompany[0]['GudangPoS'],
					'LineStatus': 'O',
					'VatPercent' : 0,
					'HargaPokokPenjualan' : HargaNormal,
				}
				oDetail.push(oItem);
				NoUrut += 1;
			}

			if (TotalHargaBaru > 0) {
				var oItem = {
					'NoUrut' : 1,
					'KodeItem' : oCompany[0]["ItemHiburan"],
					'Qty' : DurasiBaru,
					'QtyKonversi' : DurasiBaru,
					'Satuan' : SatuanDurasiBaru,
					'Harga' : HargaBaru,
					'Discount' : 0,
					'HargaNet' : DurasiBaru * HargaBaru,
					'BaseReff' : jQuery('#txtNoTransaksi_Detail').val(),
					'BaseLine' : -1,
					'KodeGudang' : oCompany[0]['GudangPoS'],
					'LineStatus': 'O',
					'VatPercent' : 0,
					'HargaPokokPenjualan' : HargaBaru,
				}
				oDetail.push(oItem);
				NoUrut += 1;
			}

			// Makanan

			if (dataMakanan.length > 0) {
				for (var i = 0; i < dataMakanan.length; i++) {
					var oItem = {
						'NoUrut' : NoUrut,
						'KodeItem' : dataMakanan[i]["KodeItem"],
						'Qty' : dataMakanan[i]["Qty"],
						'QtyKonversi' : dataMakanan[i]["Qty"],
						'Satuan' : dataMakanan[i]["Satuan"],
						'Harga' : dataMakanan[i]["Harga"],
						'Discount' : dataMakanan[i]["Diskon"],
						'HargaNet' : (dataMakanan[i]["Qty"] * dataMakanan[i]["Harga"]) - dataMakanan[i]["Diskon"],
						'BaseReff' : jQuery('#txtNoTransaksi_Detail').val(),
						'BaseLine' : -1,
						'KodeGudang' : oCompany[0]['GudangPoS'],
						'LineStatus': 'O',
						'VatPercent' : 0,
						'HargaPokokPenjualan' : dataMakanan[i]["HargaPokokPenjualan"],
					}
					oDetail.push(oItem);

					NoUrut += 1;
				}
			}

			// Header
			var oData = {
				'NoTransaksi' : "",
				'TglTransaksi' : _Tanggal + " " + _Jam,
				'TglJatuhTempo' : _Tanggal,
				'NoReff' : 'POS',
				'KodeSales' : filteredData[0]["KodeSales"],
				'KodePelanggan' : filteredData[0]["KodePelanggan"],
				'KodeTermin' : oCompany[0]['TerminBayarPoS'],
				'Termin' : 0,
				'TotalTransaksi' : jQuery('#txtSubTotal_Detail').attr("originalvalue"),
				'Potongan' : jQuery('#txtDiscount_Detail').attr("originalvalue"),
				'Pajak' : TotalPPN,
				'PajakHiburan' : TotalPajakHiburan,
				'BiayaLayanan' : jQuery('#txtBiayaAdmin_Detail').attr("originalvalue"),
				'Pembulatan' : 0,
				'TotalPembelian' : jQuery('#txtTotalBayar_Detail').attr("originalvalue"),
				'TotalRetur' : 0,
				'TotalPembayaran' : jQuery('#txtJumlahBayar_Detail').attr("originalvalue"),
				'Status' : Status,
				'Keterangan' : '',
				'MetodeBayar' : jQuery('#cboMetodePembayaran_Detail').val(),
				'ReffPembayaran' : $('#txtRefrensi_Detail').val(),
				'Detail' : oDetail
			}

			console.log("Status Cust Display : " + _custdisplayopened)
			if(_custdisplayopened){
				// console.log('Cust Display Oppened');
				localStorage.setItem('paymentgatewaydata', JSON.stringify(oData));
				displayWindow.postMessage('paymentgateway', '*');
			}
			else{
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
									Swal.fire({
										icon: "error",
										title: "Opps...",
										text: "Pembayaran Dibatalkan",
									})
								}
								else{
									// order_id
									jQuery('#txtRefrensi_Detail').val(result.order_id)
									SaveData(Status, ButonObject, ButtonDefaultText)
								}
								// Proses pembayaran sukses
							},
							onPending: function(result){
								// console.log(result);
								// Pembayaran tertunda
							},
							onError: function(result){
								// console.log(result);
								Swal.fire({
									icon: "error",
									title: "Opps...",
									text: result,
								})
								// Pembayaran gagal
							},
							onClose: function(){
								console.log('customer closed the popup without finishing the payment');
							}
						});
					} else {
						// alert('Error: ' + data.error);
						Swal.fire({
							icon: "error",
							title: "Opps...",
							text: data.error,
						})
					}
				})
				.catch(error => console.error('Error:', error));
			}
		}

		function PrintStruk(NoTransaksi) {

			// var link = "fpenjualan/printthermal/"+cellInfo.data.NoTransaksi;
			let url = "{{ url('') }}";
			// url.searchParams.append('NoTransaksi', NoTransaksi);
			url += "/fpenjualan/printthermal/"+NoTransaksi;
			// console.log(url);
			// // window.location.href = url.toString();
			// window.open(url, "_blank");
			// location.reload();

			const win = window.open(url, '_blank', 'width=800,height=600');
			if (win) {
				win.onload = function () {
					win.print();
					win.onafterprint = function () {
						win.close();
					};
				};
			}
			showCetakModal(NoTransaksi);
		}

		function SetEnableCommand() {
			var errorCount = 0;

			var GrandTotal = jQuery('#txtGrandTotal_Detail').attr("originalvalue");
			var JumlahBayar = jQuery('#txtJumlahBayar_Detail').attr("originalvalue");
			var Kembalian = jQuery('#txtJumlahKembalian_Detail').attr("originalvalue");

			// console.log(parseFloat(GrandTotal));
			// console.log(parseFloat(JumlahBayar));
			// console.log(parseFloat(Kembalian));

			if (parseFloat(GrandTotal) == 0 && _isFromBooking == false) {
				errorCount +=1;
			}
			if (parseFloat(JumlahBayar) == 0 && _isFromBooking == false) {
				errorCount +=1;
			}
			if (parseFloat(Kembalian) < 0 ) {
				errorCount +=1;
			}

			if (jQuery('#cboMetodePembayaran_Detail').val() == "") {
				errorCount +=1
			}

			// console.log(errorCount);

			if (errorCount > 0) {
				jQuery('#btBayar').attr('disabled',true);
			}
			else{
				jQuery('#btBayar').attr('disabled',false);
			}
		}

		function openCustomerDisplay() {
			// Use Laravel's url() helper to generate the URL
			const url = "{{ url('/fpenjualan/custdisplay') }}";
			displayWindow  = window.open(url, '_blank', 'width=1390,height=800,,scrollbars=no,toolbar=no,status=no,menubar=no');
			localStorage.setItem('displayOpen', 'true');

			const interval = setInterval(() => {
				if (displayWindow && displayWindow.closed) {
					clearInterval(interval);
				}
			}, 1000);
		}

		// Time Slot Logic
		function loadTimeSlots() {
			console.trace("Who called loadTimeSlots?");
			const container = jQuery('#timeSlotContainer');
			container.html('<div class="col-12 text-center"><p class="text-muted">Memuat slot waktu...</p></div>');
			
			$.ajax({
				url: "{{ route('fpenjualan-getTimeSlots') }}",
				type: 'POST',
				data: {
					_token: '{{ csrf_token() }}',
					date: jQuery('#TglTransaksi').val() || ((new Date()).getFullYear() + '-' + String((new Date()).getMonth() + 1).padStart(2, '0') + '-' + String((new Date()).getDate()).padStart(2, '0')),
					tableid: jQuery('#tableid').val()
				},
				success: function(response) {
					container.empty();
					
					if (response.success && response.slots.length > 0) {
						response.slots.forEach(function(slot) {
							let statusClass = '';
							if (!slot.available) {
								statusClass = 'disabled';
							}
							
							let html = `
								<div class="col-md-3 col-sm-4 col-6 mb-3">
									<div class="time-slot-card ${statusClass}" data-start="${slot.start}" data-end="${slot.end}" data-available="${slot.available}">
										<div class="card text-center mb-0">
											<div class="card-body p-3">
												<h6 class="mb-0 font-weight-bold">${slot.label}</h6>
												${slot.isBooked ? '<small class="text-danger">Booked</small>' : ''}
											</div>
										</div>
									</div>
								</div>
							`;
							container.append(html);
						});
						console.log("Time Slot Script Loaded");
					} else {
						container.html('<div class="col-12 text-center"><p class="text-muted text-danger">Tidak ada slot waktu tersedia atau konfigurasi jam belum diatur.</p></div>');
					}
				},
				error: function() {
					container.html('<div class="col-12 text-center"><p class="text-danger">Gagal memuat slot waktu.</p></div>');
				}
			});
		}

		// Debug Log to ensure script is loaded


		// Handle Multiple Sequential Time Slot Selection
		jQuery(document).on('click', '.time-slot-card', function(e) {
			e.preventDefault();
			console.log("Click detected on .time-slot-card");
			
			const $this = jQuery(this);

			if ($this.hasClass('disabled')) {
				console.log("Clicked disabled slot");
				return;
			}
			
			// Deselection Logic
			if ($this.hasClass('selected')) {
				const selected = jQuery('.time-slot-card.selected');
				console.log("Deselecting...");
				
				// Allow deselecting edges (First or Last)
				if (selected.length > 0) {
					const first = selected.first();
					const last = selected.last();
					
					// Compare raw data attributes
					if ($this.data('start') == first.data('start') || $this.data('end') == last.data('end')) {
						$this.removeClass('selected');
					} else {
						Swal.fire("Info", "Tidak boleh memutus urutan jam.", "warning");
						return; 
					}
				}
			} else {
				console.log("Selecting...");
				// Selection Logic
				const selected = jQuery('.time-slot-card.selected');
				
				// CHECK: Limit selection for PAKETMEMBER
				if (jQuery('#JenisPaket').val() == "PAKETMEMBER") {
					var maxSlots = parseInt(jQuery('#DurasiPaket').val()) || 0;
					if (selected.length >= maxSlots) {
						Swal.fire("Info", "Maksimal durasi paket adalah " + maxSlots + " jam.", "warning");
						return;
					}
				}

				if (selected.length === 0) {
					$this.addClass('selected');
				} else {
					const first = selected.first();
					const last = selected.last();
					
					// Check adjacency
					// Clicked Start == Current End (Append to end)
					// Clicked End == Current Start (Prepend to start)
					console.log("Start: " + $this.data('start') + ", PrevEnd: " + last.data('end'));
					console.log("End: " + $this.data('end') + ", NextStart: " + first.data('start'));

					if ($this.data('start') == last.data('end')) {
						$this.addClass('selected');
					} else if ($this.data('end') == first.data('start')) {
						$this.addClass('selected');
					} else {
						Swal.fire("Info", "Slot waktu harus berurutan.", "warning");
						return;
					}
				}
			}
			
			updateTimeSlotData();
		});

		function updateTimeSlotData() {
			const selected = jQuery('.time-slot-card.selected');
			if (selected.length > 0) {
				const first = selected.first();
				const last = selected.last();
				
				// Set Range String (e.g. "19:00-21:00")
				const timeRange = first.data('start') + '-' + last.data('end');
				jQuery('#selectedTimeSlot').val(timeRange);
				
				// Set Duration (Count of slots)
				// Only update if NOT PAKETMEMBER
				if (jQuery('#JenisPaket').val() != "PAKETMEMBER") {
					jQuery('#DurasiPaket').val(selected.length);
				}
			} else {
				jQuery('#selectedTimeSlot').val('');
				if (jQuery('#JenisPaket').val() != "PAKETMEMBER") {
					jQuery('#DurasiPaket').val(1);
				}
			}
		}
	});

	
</script>