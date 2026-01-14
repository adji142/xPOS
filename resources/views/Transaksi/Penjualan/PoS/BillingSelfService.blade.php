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
	<title>Self Service System</title>
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
            color: rgb(7, 7, 7);
            width: auto; /* Adjust width for colons */
            font-size: 3.2rem; /* Slightly larger than digits */
        }
		.disabled-link {
			pointer-events: none; /* Disable clicks */
			color: gray; /* Optional: visually indicate it is disabled */
			text-decoration: none; /* Optional: remove underline */
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
            animation: scrollText 40s linear infinite, blink 1s step-start infinite;
            font-size: 24px;
            color: #fff;
        }
        @keyframes scrollText {
            from {
                transform: translateX(100%);
            }
            to {
                transform: translateX(-100%);
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
        
        /* Time Slot Styles */
        .time-slot-card {
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .time-slot-card .card {
            border: 2px solid #e4e6ef;
        }
        .time-slot-card:hover .card {
            border-color: #FFA800; /* Warning Color */
            background-color: #FFF4DE;
        }
        .time-slot-card.selected .card {
            background-color: #FFA800;
            border-color: #FFA800;
            color: #ffffff;
        }
        .time-slot-card.disabled {
            opacity: 0.6;
            cursor: not-allowed;
            pointer-events: none;
        }
        .time-slot-card.disabled .card {
            background-color: #F3F6F9;
            border-color: #EBEDF3;
			color: #B5B5C3;
        }
	</style>
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="tc_body" class="header-fixed header-mobile-fixed subheader-enabled aside-enabled aside-fixed" style="
    @if(isset($company) && $company[0]['TypeBackgraund'] == 'Color')
        background-color: {{ $company[0]['Backgraund'] }};
    @elseif(isset($company) && $company[0]['TypeBackgraund'] == 'Image')
        background-image: url('{{ $company[0]['Backgraund'] }}');
        background-size: auto;
        background-repeat: repeat;
        background-position: center;
    @endif
">
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
					<div class="topbar-item folder-data" style="display:none;">
						<div id="btOpenListBooking" class="btn btn-icon  w-auto h-auto btn-clean d-flex align-items-center py-0 me-3">
							<span class="symbol symbol-35  symbol-light-success">
								<a href="{{ route('bookinglist') }}" target="_blank" class="btn btn-warning">Booking Online List</a>
							</span>
						</div>
				 
					</div>

					<div class="topbar-item folder-data" style="display:none;">
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
						<!-- <div class="topbar-item" data-bs-toggle="dropdown" data-display="static">
							<div class="btn btn-icon w-auto h-auto btn-clean d-flex align-items-center py-0">
							
								<span class="symbol symbol-35 symbol-light-success">
									<span class="symbol-label font-size-h5 ">
										<svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-person-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
											<path fill-rule="evenodd" d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"></path>
										</svg>
									</span>
								</span>
							</div>
						</div> -->
	
						<!-- <div class="dropdown-menu dropdown-menu-right" style="min-width: 150px;">
							<a href="{{ route('logout') }}" class="dropdown-item">
								<span class="svg-icon svg-icon-xl svg-icon-primary me-2">
									<svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-power">
										<path d="M18.36 6.64a9 9 0 1 1-12.73 0"></path>
										<line x1="12" y1="2" x2="12" y2="12"></line>
									</svg>
								</span>
								Logout
							</a>
						</div> -->
	
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
						@if ($company[0]['RunningTextSelfServices'] != null && $company[0]['RunningTextSelfServices'] != "")
							<div class="marquee-container">
								<div class="marquee">{{ $company[0]['RunningTextSelfServices'] }}</div>
							</div>
						@endif
					</div>
				</div>
			</div>
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

                                                    @if ($item->KelompokLampu == $tl->KodeKelompok )
                                                        <div class="col-xl-3 col-lg-8 col-md-8">
                                                            <div class="card card-custom gutter-b bg-white border-0 table-contentpos">
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
                                                                                <span class="list-title text-body">Layanan</span>
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
                                                                            <div class ="row">
                                                                                <div class="col-xl-12 col-lg-12 col-md-12 ">
                                                                                    <button disabled class="btn btn-warning text-white font-weight-bold w-100 py-3 item-dropdown btPilihPaket_{{ $item->id }}" data-namatitiklampu="{{ $item->NamaTitikLampu }}" data-notransaksi="{{ $item->NoTransaksi }}" data-jenispaket="{{ $item->JenisPaket }}">PILIH LAYANAN</button>
                                                                                </div>
                                                                            </div>
                                                                        @endif

                                                                        @if ($item->Status == 0)
                                                                            <div class ="row">
                                                                                <div class="col-xl-12 col-lg-12 col-md-12 ">
                                                                                    <button class="btn btn-warning text-white font-weight-bold w-100 py-3 item-dropdown btPilihPaket_{{ $item->id }}" data-namatitiklampu="{{ $item->NamaTitikLampu }}" data-notransaksi="{{ $item->NoTransaksi }}" data-jenispaket="{{ $item->JenisPaket }}">PILIH LAYANAN</button>
                                                                                </div>
                                                                            </div>
                                                                        @endif

                                                                        @if ($item->Status == 1 || $item->Status == 99)
                                                                            <div class ="row">
                                                                                <div class="col-xl-12 col-lg-12 col-md-12 ">
                                                                                    <button disabled class="btn btn-warning text-white font-weight-bold w-100 py-3 item-dropdown btPilihPaket_{{ $item->id }}" data-namatitiklampu="{{ $item->NamaTitikLampu }}" data-notransaksi="{{ $item->NoTransaksi }}" data-jenispaket="{{ $item->JenisPaket }}">PILIH LAYANAN</button>
                                                                                </div>
                                                                            </div>
                                                                        @endif

                                                                        @if ($item->NoTransaksi != "" && $item->JenisPaket == "JAM")
                                                                            <br>
                                                                            <div class="row">
                                                                                <div class="col-xl-12 col-lg-12 col-md-12">
                                                                                    <button class="btn btn-warning text-white font-weight-bold w-100 py-3 item-dropdown btTambahJam_{{ $item->id }}" data-namatitiklampu="{{ $item->NamaTitikLampu }}" data-notransaksi="{{ $item->NoTransaksi }}" data-jenispaket="{{ $item->JenisPaket }}">TAMBAH WAKTU</button>
                                                                                </div>
                                                                            </div>
                                                                        @else
                                                                            <br>
                                                                            <div class="row">
                                                                                <div class="col-xl-12 col-lg-12 col-md-12">
                                                                                    <button disabled class="btn btn-success text-white font-weight-bold w-100 py-3 item-dropdown btTambahJam_{{ $item->id }}" data-namatitiklampu="{{ $item->NamaTitikLampu }}" data-notransaksi="{{ $item->NoTransaksi }}" data-jenispaket="{{ $item->JenisPaket }}">TAMBAH WAKTU</button>
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
				  	<h3 class="modal-title" id="myModalLabel11">Lookup Pilih Layanan</h3>
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
												<h3 class="card-label mb-0 font-weight-bold text-body ">Pilih Layanan</h3>
											</div>
										</div>
										<div class="card-body">
											<div class="form-group row">
												<div class="col-md-12">
													<h3>
														<div id="lblNamaTitikLampu"></div>
													</h3>
												</div>
	
												<div class="col-md-6">
													<label  class="text-body">Jenis Layanan</label>
													<fieldset class="form-group mb-12">
														<select name="JenisPaket" id="JenisPaket" class="js-example-basic-single js-states form-control bg-transparent" >
															<option value="">Pilih Jenis Layanan</option>
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
													<label  class="text-body">Layanan</label>
													<fieldset class="form-group mb-12">
														<select name="paketid" id="paketid" class="js-example-basic-single js-states form-control bg-transparent" >
															<option value="">Pilih Layanan</option>
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
														<select name="tableid" id="tableid" class="js-example-basic-single js-states form-control bg-transparent" disabled>
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
																<option value="{{ $sls->KodeSales }}" {{ $sls->KodeSales == $oKodeSales ? 'selected disabled' : '' }}>{{ $sls->NamaSales }}</option>
															@endforeach
														</select>
													</fieldset>
												</div>
												<div class="col-md-4">
													<label  class="text-body" id= "lblDurasiPaket">Durasi (Jam)</label>
													<div class="checkbox-inline mb-2">
														<label class="checkbox checkbox-outline checkbox-success">
															<input type="checkbox" id="chkFlexibleTime" name="FlexibleTime"/>
															<span></span>
															Waktu Flexible
														</label>
													</div>
													</fieldset>
												</div>

												{{-- Daily Packet Section --}}
												<div class="form-group row" id="divDailyPacket" style="display:none;">
													<div class="col-md-6">
														<label class="text-body font-weight-bold">Jam Checkin</label>
														<fieldset class="form-group mb-12">
															<input type="time" class="form-control" id="JamCheckin_Daily" name="JamCheckin_Daily" readonly>
															<div class="checkbox-inline mt-2">
																<label class="checkbox checkbox-outline checkbox-success">
																	<input type="checkbox" id="chkCheckinNow" name="chkCheckinNow"/>
																	<span></span>
																	Check in sekarang
																</label>
															</div>
														</fieldset>
													</div>
													<div class="col-md-6">
														<label class="text-body font-weight-bold">Jam Checkout</label>
														<fieldset class="form-group mb-12">
															<input type="time" class="form-control" id="JamCheckout_Daily" name="JamCheckout_Daily" readonly>
														</fieldset>
													</div>
													<div class="col-md-6">
														<label class="text-body font-weight-bold">Extra Cost</label>
														<fieldset class="form-group mb-12">
															<input type="number" class="form-control" id="ExtraCost" name="ExtraCost" value="0" disabled>
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

												<div class="col-md-12">
													<label  class="text-body">Member</label>
													<fieldset class="form-group mb-9">
														<input type="text" class="form-control" id="SearchMember" name="SearchMember" placeholder="Search Nama, ID, NoTlp atau Email">
														<ul id="suggestionList" style="border: 1px solid #ccc; display: none; position: absolute; background: white; z-index: 999;"></ul>
													</fieldset>
													<fieldset class="form-group mb-12">
														<select name="KodePelanggan" id="KodePelanggan" class="js-example-basic-single js-states form-control bg-transparent" >
															<option value="">Pilih Member</option>
															@foreach ($pelanggan as $plg)
																<option value="{{ $plg->KodePelanggan }}" data-ispaid="{{ $plg->isPaidMembership }}">{{ $plg->NamaPelanggan }}</option>
															@endforeach
														</select>
													</fieldset>
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
											</div>

											{{-- Time Slot Section - Only shown when JenisPaket = JAM --}}
											<div class="form-group row" id="timeSlotSection" style="display:none;">
												<div class="col-md-12">
													<label class="text-body font-weight-bold">Pilih Jam</label>
													<div class="card">
														<div class="card-body">
															<div class="row" id="timeSlotContainer">
																{{-- Slots will be loaded here via AJAX --}}
															</div>
															<input type="hidden" id="selectedTimeSlot" name="selectedTimeSlot">
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
												<h3 class="card-label mb-0 font-weight-bold text-body ">Pilih Layanan</h3>
											</div>
										</div>
										<div class="card-body">
											<div class="form-group row">
												<div class="col-md-12">
													<label  class="text-body">Nomor Order</label>
													<fieldset class="form-group mb-12">
														<input type="text" class="form-control" id="txtNoTransaksi_RubahDurasi" name="txtNoTransaksi_RubahDurasi" readonly>
													</fieldset>
												</div>
												<div class="col-md-12">
													<label  class="text-body">Durasi (Jam)</label>
													<fieldset class="form-group mb-12">
														<input type="number" class="form-control" id="txtDurasiPaket_RubahDurasi" name="txtDurasiPaket_RubahDurasi" min="1" value="1">
													</fieldset>
												</div>
												<div class="col-md-6">
													<label  class="text-body">Harga / Jam</label>
													<fieldset class="form-group mb-12">
														<input type="text" class="form-control" id="txtHargaPerJam_TambahJam" name="txtHargaPerJam_TambahJam" readonly>
													</fieldset>
												</div>
												<div class="col-md-6">
													<label  class="text-body">Total Transaksi</label>
													<fieldset class="form-group mb-12">
														<input type="text" class="form-control" id="txtTotalTransaksi_TambahJam" name="txtTotalTransaksi_TambahJam" readonly>
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
																<option value="{{ $mtd->id }}">{{ $mtd->NamaMetodePembayaran }}</option>
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
					<button class="btn btn-primary ms-1" id="btRubahDurasiPaket" data-bs-dismiss="modal">
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
																<th>Total</th>

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
															<td style="text-align: right">Diskon Service</td>
															<td>:</td>
															<td style="text-align: right">
																<fieldset class="form-group mb-3 d-flex">
																	<input type="text" name="text" class="form-control bg-white" id="txtDiscountTable_Detail"  name="txtDiscountTable_Detail" readonly>
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

														<tr>
															<td style="text-align: right">Uang Muka / Titip </td>
															<td>:</td>
															<td style="text-align: right">
																<input type="text" class="form-control" id="txtTotalUangMuka_Detail" name="txtTotalUangMuka_Detail" readonly>
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
															<td style="text-align: right">Total Bayar </td>
															<td>:</td>
															<td style="text-align: right">
																<input type="text" class="form-control" id="txtTotalBayar_Detail" name="txtTotalBayar_Detail" readonly>
															</td>
														</tr>
													</table>
												</div>
											</div>
										</div>

										<div class="form-group row">
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
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-primary ms-1" id="btTambahMakanan" data-bs-dismiss="modal">
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
	var tglBerlangganan;

    jQuery(function () {
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
		let displayWindow = null;

		function closedWindow(){
			
			// _custdisplayopened = localStorage.getItem("closedwindows");
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
			// if (localStorage.getItem('displayOpen') === 'true') {
			// 	// Window tidak bisa diakses ulang langsung, tapi akan dapat postMessage dari display
			// 	console.log('Menunggu say-hello dari display...');
			// }
		};
		// window.addEventListener("closedwindows", closedWindow);
		jQuery(document).ready(function() {
			_billing = <?php echo $titiklampu ?>;
			console.log(_billing);
			jQuery('.js-example-basic-single').select2({
				dropdownParent: $('#LookupPilihPaket')
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
			// localStorage.setItem('PoSData', JSON.stringify([]));
		});
		$('#LookupDetailOrder').on('shown.bs.modal', function () {
			$('#cboMetodePembayaran_Detail').select2({
				dropdownParent: $(this) // Attach to the opened modal
			});
		});

		jQuery(document).on('click', '.item-dropdown', function(e) {
			e.preventDefault();
			const clickedClass = $(this).attr('class');
			const itemId = clickedClass.match(/_(\d+)/)[1];
			var NamaTitikLampu = $(this).data('namatitiklampu');
			var NoTransaksi = $(this).data('notransaksi');
			var JenisPaket = $(this).data('jenispaket');
			
			if (clickedClass.includes('btPilihPaket')) {
				// console.log(`Pilih Paket clicked for item ID: ${itemId}`);
				// LookupPilihPaket
				// tableid
				jQuery('#lblNamaTitikLampu').text(NamaTitikLampu);
				jQuery('#tableid').val(itemId).change();
				jQuery('#LookupPilihPaket').modal({backdrop: 'static', keyboard: false})
		    	jQuery('#LookupPilihPaket').modal('show');

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

				console.log(`Tambah Makanan clicked for item ID: ${itemId}`);
			} else if (clickedClass.includes('btDetail')) {
				// LookupDetailOrder
				const table = jQuery('#TablePenjualan').DataTable({
					columnDefs: [
						{ targets: 5, visible: false },
						{ targets: 6, visible: false },
						{ targets: 7, visible: false },
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
									`<span data-raw="${item.LineTotal}">${formatNumber(item.LineTotal)}</span>`,
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

				jQuery('#LookupDetailOrder').modal({backdrop: 'static', keyboard: false})
		    	jQuery('#LookupDetailOrder').modal('show');
				console.log(`Detail clicked for item ID: ${itemId}`);
			} else if (clickedClass.includes('btTambahJam')) {
				// console.log(`Detail clicked for item ID: ${itemId}`);
				// jQuery('#txtNoTransaksi_RubahDurasi').val(NoTransaksi);
				
				console.log(`Detail clicked for item ID: ${itemId}`);
				jQuery('#txtNoTransaksi_RubahDurasi').val(NoTransaksi);

				const filteredBilling = _billing.filter(item => item.NoTransaksi == NoTransaksi);
				const DataPaket = <?php echo $paket ?>;
				const filteredPaket = DataPaket.filter(item => item.id == filteredBilling[0]['paketid']);

				// console.log(filteredPaket)
				jQuery('#txtHargaPerJam_TambahJam').val(formatNumber(filteredPaket[0]['HargaNormal']));
				jQuery('#txtHargaPerJam_TambahJam').attr('originalvalue', filteredPaket[0]['HargaNormal']);
				calculateTotalTambahJam();

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

						if (!tglBerlangganan) {
							Swal.fire("Informasi", "Tgl Berlangganan Paket Bulanan harus diisi di Master Pelanggan!", "warning");
							jQuery('#divProrataInfo').hide();
							return;
						}

						jQuery('#divProrataInfo').show();
						
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

			if (jQuery('#JenisPaket').val() == "PAKET") {
                jQuery('#lblDurasiPaket').text('Durasi (Hari / Bulan / Tahun)');
                jQuery('#DurasiPaket').attr('readonly', true);
				jQuery('#timeSlotSection').slideUp();
				jQuery('#chkFlexibleTime').prop('checked', false).trigger('change');
            } else if (jQuery('#JenisPaket').val() == "PAKETMEMBER") {
                jQuery('#lblDurasiPaket').text('Durasi (Jam)');
                // jQuery('#DurasiPaket').attr('readonly', false);
                jQuery('#SearchMember').attr('disabled', false);
                jQuery('#KodePelanggan').attr('disabled', false);
                jQuery('#btTambahMember').attr('disabled', false);

				// PAKETMEMBER: Disable Duration & Flex, Hide Slots initially (wait for member select)
				jQuery('#DurasiPaket').attr('readonly', true);
				jQuery('#chkFlexibleTime').attr('disabled', true).prop('checked', false);
				jQuery('#timeSlotSection').slideDown();
				loadTimeSlots(); // Load slots, but user might not have selected member yet so constraints apply later
            }
            else if (jQuery('#JenisPaket').val() == "JAM") {
                jQuery('#lblDurasiPaket').text('Durasi (Jam)');
                jQuery('#DurasiPaket').attr('readonly', false);
				
				// Show Flexible Checkbox
				jQuery('#chkFlexibleTime').removeAttr('disabled');
				
				// Handle Slot Visibility based on Checkbox
				if (jQuery('#chkFlexibleTime').is(':checked')) {
					jQuery('#timeSlotSection').slideUp();
					jQuery('#DurasiPaket').attr('readonly', false);
				} else {
					jQuery('#timeSlotSection').slideDown();
					jQuery('#DurasiPaket').attr('readonly', true);
					loadTimeSlots();
				}
            } else if (jQuery('#JenisPaket').val() == "DAILY") {
				jQuery('#lblDurasiPaket').text('Durasi (Hari)');
				jQuery('#DurasiPaket').val(1).attr('readonly', true);
				jQuery('#timeSlotSection').slideUp();
				jQuery('#chkFlexibleTime').prop('checked', false).trigger('change');
				jQuery('#divDailyPacket').slideDown();
			} else if (jQuery('#JenisPaket').val() == "MENIT") {
                jQuery('#timeSlotSection').slideUp();
                jQuery('#selectedTimeSlot').val('');
				jQuery('#lblDurasiPaket').text('Durasi (Menit)');
                jQuery('#paketid').attr('disabled', false);
                jQuery('#SearchMember').attr('disabled', false);
                jQuery('#KodePelanggan').attr('disabled', false);
                jQuery('#btTambahMember').attr('disabled', false);
                jQuery('#DurasiPaket').attr('readonly', false);

				var now = new Date();
				var formattedNow = now.getFullYear() + '-' +
					String(now.getMonth() + 1).padStart(2, '0') + '-' +
					String(now.getDate()).padStart(2, '0') + ' ' +
					String(now.getHours()).padStart(2, '0') + ':' +
					String(now.getMinutes()).padStart(2, '0') + ':' +
					String(now.getSeconds()).padStart(2, '0');
				
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
            } else {
                jQuery('#lblDurasiPaket').text('Durasi (Jam)');
                jQuery('#DurasiPaket').attr('readonly', false);
				jQuery('#timeSlotSection').slideUp();
				jQuery('#chkFlexibleTime').prop('checked', false).trigger('change');
				jQuery('#divDailyPacket').slideUp();
            }

			if (jQuery('#JenisPaket').val() == "MONTHLY" || jQuery('#JenisPaket').val() == "YEARLY") {
				jQuery('#lblDurasiPaket').text(jQuery('#JenisPaket').val() == "MONTHLY" ? 'Durasi (Bulan)' : 'Durasi (Tahun)');
				jQuery('#DurasiPaket').val(1).attr('readonly', true);
				CalculateProrata();
			} else {
				jQuery('#divProrataInfo').hide();
			}

			jQuery('#PembayaranSection').show();
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
					let checkin = filteredData[0]["JamCheckin"] || "";
					let checkout = filteredData[0]["JamCheckout"] || "";
					if(checkin.length >= 5) checkin = checkin.substring(0, 5);
					if(checkout.length >= 5) checkout = checkout.substring(0, 5);

					jQuery('#JamCheckin_Daily').val(checkin);
					jQuery('#JamCheckin_Daily').data('original-value', checkin); // Store original value
					jQuery('#JamCheckout_Daily').val(checkout);
				}
			}

			if (jQuery('#JenisPaket').val() == "MONTHLY" || jQuery('#JenisPaket').val() == "YEARLY") {
				CalculateProrata();
			}

			// if (jQuery('#JenisPaket').val() != "MENIT") {
			// 	// GenerateTotal();
			// 	jQuery('#btMulaiBermain').text('Next >>');
			// }
			jQuery('#btMulaiBermain').text('Next >>');
		});

		jQuery('#DurasiPaket').change(function () {
			// console.log(jQuery('#DurasiPaket').val());
			GenerateTotal();
		});

		// Checkin Now Toggle
		jQuery('#chkCheckinNow').change(function() {
			if(jQuery(this).is(':checked')) {
				jQuery('#ExtraCost').prop('disabled', false);

				// Set to Current Time
				const now = new Date();
				const hours = String(now.getHours()).padStart(2, '0');
				const minutes = String(now.getMinutes()).padStart(2, '0');
				jQuery('#JamCheckin_Daily').val(`${hours}:${minutes}`);
			} else {
				jQuery('#ExtraCost').prop('disabled', true);
				jQuery('#ExtraCost').val(0);

				// Revert to original
				const original = jQuery('#JamCheckin_Daily').data('original-value');
				if(original) {
					jQuery('#JamCheckin_Daily').val(original);
				}
			}
		});

		jQuery('#frmPilihPaket').on('submit', function(e) {
			jQuery('#btMulaiBermain').text('Tunggu Sebentar');
			jQuery('#btMulaiBermain').attr('disabled', true);

			e.preventDefault();
			jQuery('#frmPilihPaket').find(':disabled').prop('disabled', false);
			const formData = new FormData(this);

			// Append Time Slot Data for JAM and PAKETMEMBER
            if (jQuery('#JenisPaket').val() == "JAM" || jQuery('#JenisPaket').val() == "PAKETMEMBER") {
                 const timeSlot = jQuery('#selectedTimeSlot').val();
                 if (timeSlot) {
                     const parts = timeSlot.split('-');
                     if (parts.length >= 1) {
                         formData.append('JamMulai', parts[0]);
						 if(parts.length > 1) {
							formData.append('JamSelesai', parts[1]);
						 }
						 // Use Local Date for TglBooking
						 var bookingNow = new Date();
						 var localDate = bookingNow.getFullYear() + '-' + String(bookingNow.getMonth() + 1).padStart(2, '0') + '-' + String(bookingNow.getDate()).padStart(2, '0');
                         formData.append('TglBooking', localDate);
                     }
                 }
            }else if (jQuery('#JenisPaket').val() == "DAILY") {
				const now = new Date();
				const dateString = now.getFullYear() + '-' + String(now.getMonth() + 1).padStart(2, '0') + '-' + String(now.getDate()).padStart(2, '0');
				
				formData.append('JamMulai', jQuery('#JamCheckin_Daily').val());
				formData.append('JamSelesai', jQuery('#JamCheckout_Daily').val());
				formData.append('TglBooking', dateString);

				// Extra Cost
				const extraCost = jQuery('#ExtraCost').val() || 0;
				formData.append('BiayaLain', extraCost);
			} else if (jQuery('#JenisPaket').val() == "MONTHLY" || jQuery('#JenisPaket').val() == "YEARLY") {
				const now = new Date();
				const tglIn = now.getFullYear() + '-' + String(now.getMonth() + 1).padStart(2, '0') + '-' + String(now.getDate()).padStart(2, '0');
				const jamIn = jQuery('#JamCheckin_Prorata').val();
				
				const targetDate = jQuery('#divProrataInfo').data('target-date');
				const tglOut = targetDate.getFullYear() + '-' + String(targetDate.getMonth() + 1).padStart(2, '0') + '-' + String(targetDate.getDate()).padStart(2, '0');
				const jamOut = jQuery('#JamCheckout_Prorata').val();

				formData.append('JamMulaiMonth', tglIn + ' ' + jamIn);
				formData.append('JamSelesaiMonth', tglOut + ' ' + jamOut);
				formData.append('TglBooking', tglIn);
			}

			// Align Status Logic
			if(jQuery('#JenisPaket').val() == "PAKETMEMBER"){
				formData.append('Status', '0');
			}
			else{
				formData.append('Status', '0');
			}

			// ⏳ Show loading
			Swal.fire({
				icon: 'info',
				title: 'Memproses...',
				text: 'Mohon tunggu sebentar',
				allowOutsideClick: false,
				showConfirmButton: false,
				didOpen: () => {
					Swal.showLoading();
				}
			});

			$.ajax({
				url: "{{route('billing-store')}}",
				type: 'post',
				data: formData,
				processData: false,
				contentType: false,
				headers: {
					'X-CSRF-TOKEN': '{{ csrf_token() }}'
				},
				success: function(response) {
					if (response.success) {
						$.ajax({
							url: "{{route('billing-repopulate')}}",
							type: 'post',
							data: formData,
							processData: false,
							contentType: false,
							headers: {
								'X-CSRF-TOKEN': '{{ csrf_token() }}'
							},
							success: function(oBilling) {
								Swal.close(); // ✅ CLOSE LOADING

								_billing = oBilling.data;
								jQuery('#btCloseModalDetails').css('display', 'none');
								jQuery('#LookupPilihPaket').modal('hide');

								// Align Response Logic: Reload for Member, Details for others
                                if (jQuery('#JenisPaket').val() == "PAKETMEMBER") {
                                    Swal.fire({
                                        icon: "success",
                                        title: "Sukses",
                                        text: "Data Berhasil disimpan, Selamat Bermain",
                                    }).then((result) => {
                                        location.reload();
                                    });
                                } else {
                                    fnDetails(response.NoTransaksi, []);
                                    jQuery('#LookupDetailOrder').modal({backdrop: 'static', keyboard: false});
                                    jQuery('#LookupDetailOrder').modal('show');
                                }
							},
							error: function(xhr) {
								Swal.close(); // ✅ CLOSE LOADING
								Swal.fire('Error', 'Gagal ambil data billing.', 'error');
							}
						});
					} else {
						Swal.close(); // ✅ CLOSE LOADING
						Swal.fire({
							icon: "error",
							title: "Oops...",
							text: response.message,
						}).then(() => {
							jQuery('#btMulaiBermain').text('Mulai Bermain');
							jQuery('#btMulaiBermain').attr('disabled', false);
							jQuery('#LookupPilihPaket').modal({backdrop: 'static', keyboard: false});
							jQuery('#LookupPilihPaket').modal('show');
						});
					}
				},
				error: function(xhr) {
					Swal.close(); // ✅ CLOSE LOADING
					Swal.fire({
						icon: "error",
						title: "Oops...",
						text: "Terjadi kesalahan pada server.",
					}).then(() => {
						jQuery('#btMulaiBermain').text('Mulai Bermain');
						jQuery('#btMulaiBermain').attr('disabled', false);
						jQuery('#LookupPilihPaket').modal({backdrop: 'static', keyboard: false});
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

		jQuery('#txtDurasiPaket_RubahDurasi').on('input', function() {
			calculateTotalTambahJam();
		});


		function calculateTotalTambahJam(){
			const durasi = parseFloat(jQuery('#txtDurasiPaket_RubahDurasi').val()) || 0;
			const harga = parseFloat(jQuery('#txtHargaPerJam_TambahJam').attr('originalvalue')) || 0;
			const total = durasi * harga;

			jQuery('#txtTotalTransaksi_TambahJam').val(formatNumber(total));
			jQuery('#txtTotalTransaksi_TambahJam').attr('originalvalue', total);
		}

		jQuery('#cboMetodePembayaran_TambahJam').change(function () {
			const metodepembayaran = <?php echo $metodepembayaran ?>;
			const filteredData = metodepembayaran.filter(item => item.id == jQuery('#cboMetodePembayaran_TambahJam').val());
			const midtransclientkey = "<?php echo $midtransclientkey ?>";

			if (filteredData[0]['MetodeVerifikasi'] == "AUTO") {
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

			if (filteredData[0]['TipePembayaran'] == "NON TUNAI") {
				formatCurrency(jQuery('#txtJumlahBayar_TambahJam'), jQuery('#txtTotalTransaksi_TambahJam').attr('originalvalue'));
				jQuery('#txtJumlahBayar_TambahJam').attr('readonly', true);
			}
			else{
				formatCurrency(jQuery('#txtJumlahBayar_TambahJam'), "0");
				jQuery('#txtJumlahBayar_TambahJam').attr('readonly', false);
			}

			SetEnableCommand();
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
					SaveTambahJam(jQuery('#btRubahDurasiPaket'),'Tambah Waktu');
				}
				
			}
			else{
				SaveTambahJam(jQuery('#btRubahDurasiPaket'),'Tambah Waktu');
			}
		});

		// jQuery('#frmUpdatePaket').on('submit', function(e) {
		// 	// 
		// 	jQuery('#btRubahDurasiPaket').text('Tunggu Sebentar');
		// 	jQuery('#btRubahDurasiPaket').attr('disabled',true);

		// 	e.preventDefault();
		// 	jQuery('#frmUpdatePaket').find(':disabled').prop('disabled', false);

		// 	const formData = new FormData(this);

		// 	$.ajax({
		// 		url: "{{route('billing-editdurasi')}}",
		// 		type: 'post',
		// 		data: formData,
		// 		processData: false, // Prevent jQuery from automatically processing the data
        // 		contentType: false,
		// 		headers: {
		// 			'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
		// 		},
		// 		success: function(response) {
		// 			// console.log('Form submitted successfully:', response);
		// 			if (response.success) {
		// 				Swal.fire({
	    //                   icon: "success",
	    //                   title: "Sukses",
	    //                   text: "Data Berhasil disimpan, Selamat Melanjukan Permainan",
	    //                 }).then((result) => {
		// 				  location.reload();
		// 				});
		// 			}
		// 			else{
		// 				Swal.fire({
		// 					icon: "error",
		// 					title: "Opps...",
		// 					text: response.message,
		// 				}).then((result) => {
		// 				//   location.reload();
		// 					jQuery('#btRubahDurasiPaket').text('Tambah Paket');
		// 					jQuery('#btRubahDurasiPaket').attr('disabled',false);

		// 					jQuery('#LookupTambahDurasiPaket').modal({backdrop: 'static', keyboard: false})
		//     				jQuery('#LookupTambahDurasiPaket').modal('show');
		// 				});
		// 			}
		// 		},
		// 		error: function(xhr) {
		// 			// console.error('An error occurred:', xhr.responseText);
		// 			Swal.fire({
		// 				icon: "error",
		// 				title: "Opps...",
		// 				text: response.message,
		// 			}).then((result) => {
		// 			//   location.reload();
		// 				jQuery('#btRubahDurasiPaket').text('Mulai Bermain');
		// 				jQuery('#btRubahDurasiPaket').attr('disabled',false);

		// 				jQuery('#LookupTambahDurasiPaket').modal({backdrop: 'static', keyboard: false})
		//     			jQuery('#LookupTambahDurasiPaket').modal('show');
		// 			});
		// 		}
		// 	});
		// });

		function PaymentGateWayTambahJam(ButonObject, ButtonDefaultText) {
			// _custdisplayopened
			const oCompany = <?php echo $company ?>;
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
				'Detail' : oDetail,
				'Source': 'TAMBAHJAM'
			}

			console.log("Status Cust Display : " + _custdisplayopened)
			if(_custdisplayopened){
				// console.log('Cust Display Oppened');
				// localStorage.setItem('paymentgatewaydata', JSON.stringify(oData));
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

			const oCompany = <?php echo $company ?>;
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

		jQuery('#frmTambahMakanan').on('submit', function(e) {
			// 
			jQuery('#btTambahMakanan').text('Tunggu Sebentar');
			jQuery('#btTambahMakanan').attr('disabled',true);

			e.preventDefault();
			jQuery('#frmTambahMakanan').find(':disabled').prop('disabled', false);

			const formData = new FormData(this);

			$.ajax({
				url: "{{route('billing-addfnb')}}",
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
						Swal.fire({
	                      icon: "success",
	                      title: "Sukses",
	                      text: "Data Berhasil disimpan, Selamat Melanjukan Permainan",
	                    }).then((result) => {
						  location.reload();
						});
					}
					else{
						Swal.fire({
							icon: "error",
							title: "Opps...",
							text: response.message,
						}).then((result) => {
						//   location.reload();
							jQuery('#btTambahMakanan').text('Tambah Makanan');
							jQuery('#btTambahMakanan').attr('disabled',false);

							jQuery('#LookupTambahMakanan').modal({backdrop: 'static', keyboard: false})
		    				jQuery('#LookupTambahMakanan').modal('show');
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
						jQuery('#btTambahMakanan').text('Tambah Makanan');
						jQuery('#btTambahMakanan').attr('disabled',false);

						jQuery('#LookupTambahMakanan').modal({backdrop: 'static', keyboard: false})
		    			jQuery('#LookupTambahMakanan').modal('show');
					});
				}
			});
		});

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
		});

		jQuery('#LookupTambahMakanan').on('hidden.bs.modal', function () {
			location.reload();
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

				var totalBayar = parseFloat(jQuery('#txtTotalBayar_Detail').attr("originalvalue")) || parseFloat(jQuery('#txtGrandTotal_Detail').attr("originalvalue"));
				var kembalian = $(this).attr("originalvalue") - totalBayar;
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
				console.log(kembalian);
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

			if (filteredData[0]['MetodeVerifikasi'] == "AUTO") {
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

			const GrandTotal = parseFloat(jQuery('#txtGrandTotal_Detail').attr('originalvalue')) || 0;
			let BiayaLayanan = 0;
			
			if (filteredData.length > 0) {
				const BiayaAdminPercent = parseFloat(filteredData[0]['BiayaAdminPercent']) || 0;
				const BiayaAdminRupiah = parseFloat(filteredData[0]['BiayaAdminRupiah']) || 0;

				if (BiayaAdminPercent > 0) {
					BiayaLayanan = (BiayaAdminPercent / 100) * GrandTotal;
				} else if (BiayaAdminRupiah > 0) {
					BiayaLayanan = BiayaAdminRupiah;
				}
			}

			const TotalBayar = GrandTotal + BiayaLayanan;

			jQuery('#txtBiayaAdmin_Detail').val(formatNumber(BiayaLayanan));
			jQuery('#txtBiayaAdmin_Detail').attr('originalvalue', BiayaLayanan);

			jQuery('#txtTotalBayar_Detail').val(formatNumber(TotalBayar));
			jQuery('#txtTotalBayar_Detail').attr('originalvalue', TotalBayar);


			if (filteredData[0]['TipePembayaran'] == "NON TUNAI") {
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
					const suggestions = response.data;
					let html = '';

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

		function SetTimer(tableid, TimerType ,EndTime, StartTime, NoTransaksi, JenisPaket, Status) {

			// clock_
			const oCompany = <?php echo $company ?>;
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
							jQuery("#hours_"+tableid).html("0");
							jQuery("#min_"+tableid).html("0");
							jQuery("#sec_"+tableid).html("0");
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
								console.log('Warning');
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

			console.log(`Formatted Date: ${formattedDate}`);
			console.log(`Formatted Time: ${formattedTime}`);
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
			console.log(filteredData);

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
			const oCompany = <?php echo $company ?>;
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
			// console.log(filteredPaket);

			jQuery('#txtNoTransaksi_Detail').val(NoTransaksi);
			jQuery('#dtJenisPaket_Detail').text(filteredData[0]["JenisPaket"]);
			jQuery('#dtNamaPaket_Detail').text(filteredData[0]["NamaPaket"]);
			jQuery('#dtJamMulai_Detail').text(genfnFormatingDate(filteredData[0]["JamMulai"]));
			jQuery('#lblNamaCustomer').text(filteredData[0]["NamaPelanggan"]);
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

			console.log(filteredData);
			console.log(filteredPaket);
			console.log(_maxPaketNormal);
			console.log(_maxPaketBaru);
			console.log(_JamSelesaiPaket);
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
					const subDateStr = filteredData[0]["TglBerlanggananPaketBulanan"];
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
					const subDateStr = filteredData[0]["TglBerlanggananPaketBulanan"];
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
					} else {
						_NewHargaNormal = filteredPaket[0]["HargaNormal"] * filteredData[0]["DurasiPaket"];
						_durasiPaket = filteredData[0]["DurasiPaket"];
						_TextTotalHargaNormal = _durasiPaket + " " + filteredPaket[0]["JenisPaket"] +" * " + _HargaNormal + " = ";
					}
				} else {
					_NewHargaNormal = filteredPaket[0]["HargaNormal"] * filteredData[0]["DurasiPaket"];
					_durasiPaket = filteredData[0]["DurasiPaket"];
					_TextTotalHargaNormal = _durasiPaket + " " + filteredPaket[0]["JenisPaket"] +" * " + _HargaNormal + " = ";
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
			for (let index = 0; index < oData.length; index++) {
				oCustomerDisplay["data"].push({
					KodeItem : 'Booking',
					NamaItem: oData[index]['NamaItem'],
					Qty: oData[index]['Qty'],
					Harga: oData[index]['HargaJual'],
				});
				_TotalMakanan += oData[index]["LineTotal"];
			}

			// Calculate Discount

			// Diskon Member : 
			if (filteredData[0]["DiskonPersen"] > 0) {
				jQuery('#lblNamaMember').text(filteredData[0]["NamaGrup"]);
				_DiscountMember = (_SubTotal + _TotalMakanan) * (filteredData[0]["DiskonPersen"] / 100)
			}

			if (filteredPaket[0]["DiskonTable"] != null || filteredPaket[0]["DiskonTable"] > 0) {
				_DiscountTable = (_SubTotal + _TotalMakanan+ - _Discount) * (filteredPaket[0]["DiskonTable"] / 100)
			}

			if (filteredPaket[0]["DiskonFnB"] != null || filteredPaket[0]["DiskonFnB"] > 0) {
				_DiscountFnB = (_SubTotal + _TotalMakanan+ - _Discount) * (filteredPaket[0]["DiskonFnB"] / 100)
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

			formatCurrency($('#txtSubTotal_Detail'), _NewHargaNormal + _NewHargaBaru);
			formatCurrency($('#txtTotalMakanan_Detail'), _TotalMakanan);
			formatCurrency($('#txtTotalPajak_Detail'), _PPnNormal + _PPnBaru + _PajakHiburanNormal + _PajakHiburanBaru);
			formatCurrency($('#txtDiscountMember_Detail'), Math.floor(_DiscountMember));
			formatCurrency($('#txtDiscountTable_Detail'), _DiscountTable);
			formatCurrency($('#txtDiscountFnB_Detail'), _DiscountFnB);
			formatCurrency($('#txtDiscount_Detail'), Math.floor(_Discount));
			formatCurrency($('#txtTotalUangMuka_Detail'), _TotalUangMuka);
			formatCurrency($('#txtGrandTotal_Detail'), _SubTotal + _TotalMakanan+ - Math.floor(_Discount) - _TotalUangMuka);
			console.log(_SubTotal);
			console.log(_TotalMakanan);
			console.log(_Discount);
			console.log(_PPnNormal);
			console.log(_PPnBaru);
			console.log(_PajakHiburanNormal);
			console.log(_PajakHiburanBaru);
			console.log(_TotalUangMuka);
			if(filteredData[0]["StatusBooking"] == 'BOOKING'){
				formatCurrency($('#txtJumlahBayar_Detail'), _SubTotal + _TotalMakanan+ - Math.floor(_Discount) + _PPnNormal + _PPnBaru + _PajakHiburanNormal + _PajakHiburanBaru - _TotalUangMuka);
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
			oCustomerDisplay['Tax'] = _PPnNormal + _PPnBaru + _PajakHiburanNormal + _PajakHiburanBaru;
			oCustomerDisplay['UangMuka'] = _TotalUangMuka;
			oCustomerDisplay['Discount'] = Math.floor(_Discount);
			oCustomerDisplay['Net'] = _SubTotal + _TotalMakanan+ - Math.floor(_Discount) + _PajakHiburanNormal + _PajakHiburanBaru - _TotalUangMuka

			console.log(JSON.stringify(oCustomerDisplay))
			
			// localStorage.setItem('PoSData', JSON.stringify(oCustomerDisplay));

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

			Swal.fire({
				icon: 'info',
				title: 'Memproses...',
				text: 'Mohon tunggu sebentar Menyimpan data pembayaran',
				allowOutsideClick: false,
				showConfirmButton: false,
				didOpen: () => {
					Swal.showLoading();
				}
			});

			ButonObject.text('Tunggu Sebentar.....');
  			ButonObject.attr('disabled',true);

			const oCompany = <?php echo $company ?>;
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
					oDetail.push(oItem);

					NoUrut += 1;
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
						Swal.close();
						let formattedAmount = parseFloat(response.Kembalian).toLocaleString('en-US', {
							style: 'decimal',
							minimumFractionDigits: 2,
							maximumFractionDigits: 2
						});
						// Swal.fire({
						// 	title: "KEMBALIAN "+formattedAmount,
						// 	text: "Cetak Struk ?",
						// 	icon: "warning",
						// 	showCancelButton: true,
						// 	confirmButtonColor: "#3085d6",
						// 	cancelButtonColor: "#d33",
						// 	confirmButtonText: "Cetak",
						// 	cancelButtonText: "Tidak Cetak"
						// }).then((result) => {
						// 	if (result.isConfirmed) {
						// 		PrintStruk(response.LastTRX);
						// 	}
						// 	else{
						// 		location.reload();
						// 	}
						// });
						PrintStruk(response.LastTRX);
					}
					else{
						Swal.close();
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
			const oCompany = <?php echo $company ?>;
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
			const oCompany = <?php echo $company ?>;
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

			Swal.fire({
				icon: 'info',
				title: 'Memproses...',
				text: 'Mohon tunggu sebentar Memanggil Pembayaran',
				allowOutsideClick: false,
				showConfirmButton: false,
				didOpen: () => {
					Swal.showLoading();
				}
			});

			// _custdisplayopened
			const oCompany = <?php echo $company ?>;
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

			const DurasiLama = parseFloat(tdElementNormal.getAttribute("raw-durasi")) || 0;
			const DurasiBaru = parseFloat(tdElementBaru.getAttribute("raw-durasi-baru")) || 0;
			const SatuanDurasiLama = tdElementNormal.getAttribute("raw-satuan-durasi");
			const SatuanDurasiBaru = tdElementBaru.getAttribute("raw-satuan-durasi-baru");
			const HargaNormal = parseFloat(tdElementNormal.getAttribute("raw-harga-normal")) || 0;
			const HargaBaru = parseFloat(tdElementBaru.getAttribute("raw-harga-baru")) || 0;
			const TotalHargaNormal = parseFloat(tdElementNormal.getAttribute("raw-totalharga-normal")) || 0;
			const TotalHargaBaru = parseFloat(tdElementBaru.getAttribute("raw-totalharga-baru")) || 0;
			const TotalPPN = parseFloat(tdElementPpn.getAttribute("raw-totalharga-ppn")) || 0;
			const TotalPajakHiburan = parseFloat(tdElementPajakHiburan.getAttribute("raw-totalharga-pajakhiburan")) || 0;

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
					'Pajak' : 0,
					'PajakHiburan' : 0,
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
					'Pajak' : 0,
					'PajakHiburan' : 0,
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
						'Pajak' : dataMakanan[i]["Pajak"] || 0,
						'PajakHiburan' : 0,
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
				'TotalTransaksi' : Math.floor(jQuery('#txtSubTotal_Detail').attr("originalvalue")),
				'Potongan' : jQuery('#txtDiscount_Detail').attr("originalvalue"),
				'Pajak' : TotalPPN,
				'PajakHiburan' : TotalPajakHiburan,
				'Pembulatan' : 0,
				'TotalPembelian' : Math.floor(jQuery('#txtGrandTotal_Detail').attr("originalvalue")),
				'TotalRetur' : 0,
				'TotalPembayaran' : Math.floor(jQuery('#txtJumlahBayar_Detail').attr("originalvalue")),
				'Status' : Status,
				'Keterangan' : '',
				'MetodeBayar' : jQuery('#cboMetodePembayaran_Detail').val(),
				'ReffPembayaran' : $('#txtRefrensi_Detail').val(),
				'Detail' : oDetail
			}

			// Append Slot Data
			if (jQuery('#JenisPaket').val() == "PAKETMEMBER" || jQuery('#JenisPaket').val() == "JAM") {
				const timeSlotParts = jQuery('#selectedTimeSlot').val().split('-');
				if (timeSlotParts.length >= 1 && jQuery('#selectedTimeSlot').val() !== "") {
					oData['JamMulai'] = timeSlotParts[0];
					if (timeSlotParts.length > 1) {
						oData['JamSelesai'] = timeSlotParts[1];
					}
					// Use Local Date
					var bookingNow = new Date();
					var localDate = bookingNow.getFullYear() + '-' + String(bookingNow.getMonth() + 1).padStart(2, '0') + '-' + String(bookingNow.getDate()).padStart(2, '0');
					oData['TglBooking'] = localDate;
				}
			}

			
			if(_custdisplayopened){
				// console.log('Cust Display Oppened');
				// localStorage.setItem('paymentgatewaydata', JSON.stringify(oData));
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
								Swal.close();
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
								location.reload();
							},
							onError: function(result){
								Swal.close();
								// console.log(result);
								Swal.fire({
									icon: "error",
									title: "Opps...",
									text: result,
								});
								location.reload();
								// Pembayaran gagal
							},
							onClose: function(){
								Swal.close();
								location.reload();
								console.log('customer closed the popup without finishing the payment');
							}
						});
					} else {
						Swal.close();
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

		function SaveData(Status, ButonObject, ButtonDefaultText) {
			ButonObject.text('Tunggu Sebentar.....');
			ButonObject.attr('disabled',true);

			const oCompany = <?php echo $company ?>;
			const filteredData = _billing.filter(item => item.NoTransaksi == jQuery('#txtNoTransaksi_Detail').val());

			const now = new Date();
	    	const day = ("0" + now.getDate()).slice(-2);
	    	const month = ("0" + (now.getMonth() + 1)).slice(-2);
	    	const hours = now.getHours().toString().padStart(2, '0');
			const minutes = now.getMinutes().toString().padStart(2, '0');
			const seconds = now.getSeconds().toString().padStart(2, '0');

	    	const FirstDay = now.getFullYear()+"-"+month+"-01";
	    	const NowDay = now.getFullYear()+"-"+month+"-"+day;

	    	const _Tanggal = NowDay;
	    	const _Jam = hours+":"+minutes+":"+seconds;

			var oDetail = [];
			const tdElementNormal = document.getElementById("dtTotalHargaNormal_Detail");
			const tdElementBaru = document.getElementById("dtTotalPerubahanHarga_Detail");
			const tdElementPpn = document.getElementById("dtTotalPPN_Detail");
			const tdElementPajakHiburan = document.getElementById("dtTotalPajakHiburan_Detail");

			const DurasiLama = parseFloat(tdElementNormal.getAttribute("raw-durasi")) || 0;
			const DurasiBaru = parseFloat(tdElementBaru.getAttribute("raw-durasi-baru")) || 0;
			const SatuanDurasiLama = tdElementNormal.getAttribute("raw-satuan-durasi");
			const SatuanDurasiBaru = tdElementBaru.getAttribute("raw-satuan-durasi-baru");
			const HargaNormal = parseFloat(tdElementNormal.getAttribute("raw-harga-normal")) || 0;
			const HargaBaru = parseFloat(tdElementBaru.getAttribute("raw-harga-baru")) || 0;
			const TotalHargaNormal = parseFloat(tdElementNormal.getAttribute("raw-totalharga-normal")) || 0;
			const TotalHargaBaru = parseFloat(tdElementBaru.getAttribute("raw-totalharga-baru")) || 0;
			const TotalPPN = parseFloat(tdElementPpn.getAttribute("raw-totalharga-ppn")) || 0;
			const TotalPajakHiburan = parseFloat(tdElementPajakHiburan.getAttribute("raw-totalharga-pajakhiburan")) || 0;

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
					'HargaNet' : (DurasiLama * HargaNormal),
					'BaseReff' : jQuery('#txtNoTransaksi_Detail').val(),
					'BaseLine' : -1,
					'KodeGudang' : oCompany[0]['GudangPoS'],
					'LineStatus': 'O',
					'VatPercent' : 0,
					'HargaPokokPenjualan' : HargaNormal,
					'Pajak' : 0,
					'PajakHiburan' : 0,
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
					'HargaNet' : (DurasiBaru * HargaBaru),
					'BaseReff' : jQuery('#txtNoTransaksi_Detail').val(),
					'BaseLine' : -1,
					'KodeGudang' : oCompany[0]['GudangPoS'],
					'LineStatus': 'O',
					'VatPercent' : 0,
					'HargaPokokPenjualan' : HargaBaru,
					'Pajak' : 0,
					'PajakHiburan' : 0,
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
						'Pajak' : dataMakanan[i]["Pajak"] || 0,
						'PajakHiburan' : 0,
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
				'TotalTransaksi' : Math.floor(jQuery('#txtSubTotal_Detail').attr("originalvalue")),
				'Potongan' : jQuery('#txtDiscount_Detail').attr("originalvalue"),
				'Pajak' : TotalPPN,
				'PajakHiburan' : TotalPajakHiburan,
				'BiayaLayanan' : jQuery('#txtBiayaAdmin_Detail').attr("originalvalue"),
				'Pembulatan' : 0,
				'TotalPembelian' : jQuery('#txtTotalBayar_Detail').attr("originalvalue"),
				'TotalRetur' : 0,
				'TotalPembayaran' : Math.floor(jQuery('#txtJumlahBayar_Detail').attr("originalvalue")),
				'Status' : Status,
				'Keterangan' : '',
				'MetodeBayar' : jQuery('#cboMetodePembayaran_Detail').val(),
				'ReffPembayaran' : $('#txtRefrensi_Detail').val(),
				'Detail' : oDetail
			}

			// Append Slot Data
			if (jQuery('#JenisPaket').val() == "PAKETMEMBER" || jQuery('#JenisPaket').val() == "JAM") {
				const timeSlotParts = jQuery('#selectedTimeSlot').val().split('-');
				if (timeSlotParts.length >= 1 && jQuery('#selectedTimeSlot').val() !== "") {
					oData['JamMulai'] = timeSlotParts[0];
					if (timeSlotParts.length > 1) {
						oData['JamSelesai'] = timeSlotParts[1];
					}
					// Use Local Date
					var bookingNow = new Date();
					var localDate = bookingNow.getFullYear() + '-' + String(bookingNow.getMonth() + 1).padStart(2, '0') + '-' + String(bookingNow.getDate()).padStart(2, '0');
					oData['TglBooking'] = localDate;
				}
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
							text: error,
						}).then((result) => {
							ButonObject.text(ButtonDefaultText);
							ButonObject.attr('disabled',false);
						});
                }
			});

			ButonObject.text(ButtonDefaultText);
			ButonObject.attr('disabled',false);
		}

		function PrintStruk(NoTransaksi) {
			let url = "{{ url('') }}";
			url += "/fpenjualan/printthermal/" + NoTransaksi;

			const win = window.open(url, '_blank', 'width=800,height=600');

			const checkClosedInterval = setInterval(function () {
				if (win.closed) {
					clearInterval(checkClosedInterval);
					location.reload(); // ✅ Reload saat window ditutup manual
				}
			}, 500);

			win.onload = function () {
				win.print();

				win.onafterprint = function () {
					clearInterval(checkClosedInterval); // ⛔ Jangan dobel reload
					win.close();
					location.reload(); // ✅ Reload saat selesai print
				};
			};
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
			// localStorage.setItem('displayOpen', 'true');

			const interval = setInterval(() => {
				if (displayWindow && displayWindow.closed) {
					clearInterval(interval);
				}
			}, 1000);
		}

		// ==========================================
        // TIME SLOT & FLEXIBLE TIME LOGIC
        // ==========================================

        function loadTimeSlots() {
            const container = jQuery('#timeSlotContainer');
            container.html('<div class="col-12 text-center"><p class="text-muted">Memuat slot waktu...</p></div>');
            
            $.ajax({
                url: "{{ route('fpenjualan-getTimeSlots') }}",
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    // Use Local Date
                    date: (new Date()).getFullYear() + '-' + String((new Date()).getMonth() + 1).padStart(2, '0') + '-' + String((new Date()).getDate()).padStart(2, '0'),
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
                    } else {
                        container.html('<div class="col-12 text-center"><p class="text-muted text-danger">Tidak ada slot waktu tersedia atau konfigurasi jam belum diatur.</p></div>');
                    }
                },
                error: function() {
                    container.html('<div class="col-12 text-center"><p class="text-danger">Gagal memuat slot waktu.</p></div>');
                }
            });
        }

        function updateTimeSlotData() {
            const selected = jQuery('.time-slot-card.selected');
            if (selected.length > 0) {
                const first = selected.first();
                const last = selected.last();
                
                // Set Range String
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

        jQuery(document).ready(function() {
            // Flexible Time Checkbox
            jQuery('#chkFlexibleTime').change(function() {
                if(jQuery(this).is(':checked')) {
                    jQuery('#timeSlotSection').slideUp();
                    jQuery('#DurasiPaket').attr('readonly', false);
                    jQuery('#selectedTimeSlot').val('');
                    jQuery('.time-slot-card').removeClass('selected');
                } else {
                    jQuery('#timeSlotSection').slideDown();
                    jQuery('#DurasiPaket').attr('readonly', true);
                    loadTimeSlots();
                }
            });

            // Handle Time Slot Click
            jQuery(document).on('click', '.time-slot-card', function(e) {
                e.preventDefault();
                
                const $this = jQuery(this);

                if ($this.hasClass('disabled')) {
                    return;
                }
                
                // Deselection Logic
                if ($this.hasClass('selected')) {
                    const selected = jQuery('.time-slot-card.selected');
                    
                    // Allow deselecting edges (First or Last)
                    if (selected.length > 0) {
                        const first = selected.first();
                        const last = selected.last();
                        
                        if ($this.data('start') == first.data('start') || $this.data('end') == last.data('end')) {
                            $this.removeClass('selected');
                        } else {
                            Swal.fire("Info", "Tidak boleh memutus urutan jam.", "warning");
                            return; 
                        }
                    }
                } else {
                    // Selection Logic
                    const selected = jQuery('.time-slot-card.selected');
                    
                    // CHECK: Limit for PAKETMEMBER
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
                        if ($this.data('start') == last.data('end')) {
                            $this.addClass('selected');
                        } else if ($this.data('end') == first.data('start')) {
                             // Prepend requires re-ordering DOM or logic handles visual. 
                             // Simplified: append only supported well by this logic unless logic extended.
                             // For now assuming user clicks sequentially.
                             Swal.fire("Info", "Silahkan pilih jam berurutan setelah jam terakhir.", "warning");
                             return;
                        } else {
                            Swal.fire("Info", "Slot waktu harus berurutan.", "warning");
                            return;
                        }
                    }
                }
                
                updateTimeSlotData();
            });

			// Handle Member Selection for PAKETMEMBER
			jQuery('#KodePelanggan').change(function() {
				if (jQuery('#JenisPaket').val() == "PAKETMEMBER") {
					var kodePelanggan = jQuery(this).val();
					if (kodePelanggan) {
						// jQuery('#DurasiPaket').val('Loading...');
						
						// Get Maximal Order
						$.ajax({
							url: "{{ route('billing-maxtime') }}",
							type: 'POST',
							data: {
								_token: '{{ csrf_token() }}',
								mejaID: jQuery('#tableid').val(),
								// JamRequest: new Date().toISOString() // Use Local Date if needed
								JamRequest: (new Date()).getFullYear() + '-' + String((new Date()).getMonth() + 1).padStart(2, '0') + '-' + String((new Date()).getDate()).padStart(2, '0') + ' ' + String((new Date()).getHours()).padStart(2, '0') + ':' + String((new Date()).getMinutes()).padStart(2, '0') + ':' + String((new Date()).getSeconds()).padStart(2, '0')
							},
							success: function(response) {
								if (response.success) {
									if(response.MaximalOrder > 0){
										jQuery('#DurasiPaket').val(response.MaximalOrder);
										jQuery("#DurasiPaket").attr("max", response.MaximalOrder);
										
										// Reveal slots
										jQuery('#timeSlotSection').slideDown();
										loadTimeSlots();
									} else {
										Swal.fire("Info", "Member ini tidak memiliki kuota bermain.", "warning");
									}
								} else {
									Swal.fire("Error", "Gagal mengambil data member.", "error");
								}
							},
							error: function(xhr) {
								console.error(xhr);
							}
						});
					}
				}
			});
			// Handle Search Member
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
        });
	});

	
</script>