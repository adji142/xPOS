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
            color: rgb(7, 7, 7);
            width: auto; /* Adjust width for colons */
            font-size: 3.2rem; /* Slightly larger than digits */
        }
		.disabled-link {
			pointer-events: none; /* Disable clicks */
			color: gray; /* Optional: visually indicate it is disabled */
			text-decoration: none; /* Optional: remove underline */
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
						<div class="btn btn-icon  w-auto h-auto btn-clean d-flex align-items-center py-0 me-3"  data-bs-toggle="modal" data-bs-target="#folderpop">
							<span class="badge badge-pill badge-primary" id="_draftCount">5</span>
							<span class="symbol symbol-35  symbol-light-success">
								<span class="symbol-label bg-warning font-size-h5 ">
									<svg width="20px" height="20px" xmlns="http://www.w3.org/2000/svg" fill="#ffff"  viewBox="0 0 16 16">
										<path d="M9.828 3h3.982a2 2 0 0 1 1.992 2.181l-.637 7A2 2 0 0 1 13.174 14H2.826a2 2 0 0 1-1.991-1.819l-.637-7a1.99 1.99 0 0 1 .342-1.31L.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3zm-8.322.12C1.72 3.042 1.95 3 2.19 3h5.396l-.707-.707A1 1 0 0 0 6.172 2H2.5a1 1 0 0 0-1 .981l.006.139z"></path>
									</svg>
								</span>
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
   <div class="contentPOS">
	    <div class="container-fluid">
			<div class="row">
				<div class="col-xl-12 col-lg-8 col-md-8">
				     <div class="">
						<div class="card card-custom gutter-b bg-white border-0 table-contentpos">
							<div class="card-body" >
                                <div class="row">
                                    @foreach ($titiklampu as $item)
                                        <div class="col-xl-3 col-lg-8 col-md-8">
                                            <div class="card card-custom gutter-b bg-white border-0 table-contentpos">
                                                <div class="card-header align-items-center  border-0">
													<div class="card-title mb-0">
														<h3 class="card-label text-body font-weight-bold mb-0">{{ $item->NamaTitikLampu }}</h3>
													</div>
													<div class="card-toolbar">
														<button class="btn p-0" type="button" id="dropdownMenuButton1"
															data-bs-toggle="dropdown" aria-haspopup="true"
															aria-expanded="false">
															<span class="svg-icon">
																<svg width="20px" height="20px" viewBox="0 0 16 16"
																	class="bi bi-three-dots text-body" fill="currentColor"
																	xmlns="http://www.w3.org/2000/svg">
																	<path fill-rule="evenodd"
																		d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z" />
																</svg>
															</span>
														</button>
														<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton1">
															@if ($item->Status == -1)
																<a class="disabled-link dropdown-item btPilihPaket_{{ $item->id }}" href="#" data-namatitiklampu="{{ $item->NamaTitikLampu }}" data-notransaksi="{{ $item->NoTransaksi }}" data-jenispaket="{{ $item->JenisPaket }}">Pilih Paket</a>
																<a class="disabled-link dropdown-item btCheckOut_{{ $item->id }}" href="#" data-namatitiklampu="{{ $item->NamaTitikLampu }}" data-notransaksi="{{ $item->NoTransaksi }}" data-jenispaket="{{ $item->JenisPaket }}">Check Out</a>
																<a class="dropdown-item btTambahMakanan_{{ $item->id }}" href="#" data-namatitiklampu="{{ $item->NamaTitikLampu }}" data-notransaksi="{{ $item->NoTransaksi }}" data-jenispaket="{{ $item->JenisPaket }}">Tambah Makanan</a>
																<a class="dropdown-item btDetail_{{ $item->id }}" href="#" data-namatitiklampu="{{ $item->NamaTitikLampu }}" data-notransaksi="{{ $item->NoTransaksi }}" data-jenispaket="{{ $item->JenisPaket }}">Detail</a>
															@endif

															@if ($item->Status == 0)
																<a class="dropdown-item btPilihPaket_{{ $item->id }}" href="#" data-namatitiklampu="{{ $item->NamaTitikLampu }}" data-notransaksi="{{ $item->NoTransaksi }}" data-jenispaket="{{ $item->JenisPaket }}">Pilih Paket</a>
																<a class="disabled-link dropdown-item btCheckOut_{{ $item->id }}" href="#" data-namatitiklampu="{{ $item->NamaTitikLampu }}" data-notransaksi="{{ $item->NoTransaksi }}" data-jenispaket="{{ $item->JenisPaket }}">Check Out</a>
																<a class="disabled-link dropdown-item btTambahMakanan_{{ $item->id }}" href="#" data-namatitiklampu="{{ $item->NamaTitikLampu }}" data-notransaksi="{{ $item->NoTransaksi }}" data-jenispaket="{{ $item->JenisPaket }}">Tambah Makanan</a>
																<a class="disabled-link dropdown-item btDetail_{{ $item->id }}" href="#" data-namatitiklampu="{{ $item->NamaTitikLampu }}" data-notransaksi="{{ $item->NoTransaksi }}" data-jenispaket="{{ $item->JenisPaket }}">Detail</a>
															@endif

															@if ($item->Status == 1)
																<a class="disabled-link dropdown-item btPilihPaket_{{ $item->id }}" href="#" data-namatitiklampu="{{ $item->NamaTitikLampu }}" data-notransaksi="{{ $item->NoTransaksi }}" data-jenispaket="{{ $item->JenisPaket }}">Pilih Paket</a>
																<a class="dropdown-item btCheckOut_{{ $item->id }}" href="#" data-namatitiklampu="{{ $item->NamaTitikLampu }}" data-notransaksi="{{ $item->NoTransaksi }}" data-jenispaket="{{ $item->JenisPaket }}">Check Out</a>
																<a class="dropdown-item btTambahMakanan_{{ $item->id }}" href="#" data-namatitiklampu="{{ $item->NamaTitikLampu }}" data-notransaksi="{{ $item->NoTransaksi }}" data-jenispaket="{{ $item->JenisPaket }}">Tambah Makanan</a>
																<a class="dropdown-item btDetail_{{ $item->id }}" href="#" data-namatitiklampu="{{ $item->NamaTitikLampu }}" data-notransaksi="{{ $item->NoTransaksi }}" data-jenispaket="{{ $item->JenisPaket }}">Detail</a>
															@endif

															@if ($item->NoTransaksi != "" && $item->JenisPaket == "JAM")
																<a class="dropdown-item btTambahJam_{{ $item->id }}" href="#" data-namatitiklampu="{{ $item->NamaTitikLampu }}" data-notransaksi="{{ $item->NoTransaksi }}" data-jenispaket="{{ $item->JenisPaket }}">Tambah Jam</a>
															@else
																<a class="disabled-link dropdown-item btTambahJam_{{ $item->id }}" href="#" data-namatitiklampu="{{ $item->NamaTitikLampu }}" data-notransaksi="{{ $item->NoTransaksi }}" data-jenispaket="{{ $item->JenisPaket }}">Tambah Jam</a>
															@endif
														</div>
													</div>
												</div>
                                                <div class="card-body" >

													@if ($item->Status == 0)
														<button class="btn btn-success text-white font-weight-bold w-100 py-3">{{ $item->StatusMeja }}</button>
													@endif

													@if ($item->Status == 1)
														<button class="btn btn-danger text-white font-weight-bold w-100 py-3">{{ $item->StatusMeja }}</button>
													@endif

													@if ($item->Status == -1)
														<button class="btn btn-warning text-white font-weight-bold w-100 py-3">{{ $item->StatusMeja }}</button>
													@endif

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
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
							</div>
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
	
												<div class="col-md-6">
													<label  class="text-body">Jenis Paket</label>
													<fieldset class="form-group mb-12">
														<select name="JenisPaket" id="JenisPaket" class="js-example-basic-single js-states form-control bg-transparent" >
															<option value="">Pilih Jenis Paket</option>
															<option value="MENIT">Paket Menit</option>
															<option value="JAM">Paket Jam</option>
															<option value="PAKET">Paket Berlangganan</option>
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
													<label  class="text-body">Table</label>
													<fieldset class="form-group mb-12">
														<select name="tableid" id="tableid" class="js-example-basic-single js-states form-control bg-transparent" disabled>
															<option value="">Pilih Table</option>
															@foreach ($titiklampuoption as $pkt)
																<option value="{{ $pkt->id }}">{{ $pkt->NamaTitikLampu }}</option>
															@endforeach
														</select>
													</fieldset>
												</div>
												<div class="col-md-4">
													<label  class="text-body">Table Guards</label>
													<fieldset class="form-group mb-12">
														<select name="KodeSales" id="KodeSales" class="js-example-basic-single js-states form-control bg-transparent" >
															<option value="">Pilih Table Guards</option>
															@foreach ($sales as $sls)
																<option value="{{ $sls->KodeSales }}">{{ $sls->NamaSales }}</option>
															@endforeach
														</select>
													</fieldset>
												</div>
												<div class="col-md-4">
													<label  class="text-body">Durasi (Jam)</label>
													<fieldset class="form-group mb-12">
														<input type="number" class="form-control" id="DurasiPaket" name="DurasiPaket" min="1" value="1">
													</fieldset>
												</div>
												<div class="col-md-12">
													<label  class="text-body">Member</label>
													<fieldset class="form-group mb-12">
														<select name="KodePelanggan" id="KodePelanggan" class="js-example-basic-single js-states form-control bg-transparent" >
															<option value="">Pilih Member</option>
															@foreach ($pelanggan as $plg)
																<option value="{{ $plg->KodePelanggan }}">{{ $plg->NamaPelanggan }}</option>
															@endforeach
														</select>
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
												<h3 class="card-label mb-0 font-weight-bold text-body ">Pilih Paket</h3>
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
		<form id="frmUpdatePaket">
			<div class="modal-content">
				<div class="modal-header">
				  	<h3 class="modal-title" id="myModalLabel11">Detail Order</h3>
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
												<h3 class="card-label mb-0 font-weight-bold text-body ">Detail Table Order</h3>
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
																<td style="text-align: right">Discount </td>
																<td>:</td>
																<td style="text-align: right">
																	<fieldset class="form-group mb-3 d-flex">
																		<input type="text" name="text" class="form-control bg-white" id="txtDiscount_Detail"  name="txtDiscount_Detail" readonly>
																		<a href="javascript:void(0)" class="btn-secondary btn ms-2 white pt-1 pb-1 d-flex align-items-center justify-content-center">Tambah</a>
																	</fieldset>
																</td>
															</tr>

															<tr>
																<td style="text-align: right">Grand Total </td>
																<td>:</td>
																<td style="text-align: right">
																	<input type="text" class="form-control" id="txtGrandTotal_Detail" name="txtGrandTotal_Detail" readonly>
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
				</div>
				<div class="modal-footer">
					<button class="btn btn-success ms-1" id="btBayar" data-bs-dismiss="modal">
						<span class="">Bayar</span>
					</button>
				</div> 	
			</div>
		</form>
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
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script src="{{asset('api/datatable/jquery.dataTables.min.js')}}"></script>

</body>
<!--end::Body-->
</html>
<script type="text/javascript">
    jQuery(function () {
		var _billing = [];
		var _dataPaket = [];

		jQuery(document).ready(function() {
			_billing = <?php echo $titiklampu ?>;
			
			jQuery('.js-example-basic-single').select2({
				dropdownParent: $('#LookupPilihPaket')
			});
			$.each(_billing,function (k,v) {
				if (v['NoTransaksi'] != "") {
					jQuery('#lblPaketTransaksi'+v['id']).text(v["NamaPaket"]);

					if (v['JamSelesai'] != null) {
						if (v['Status'] == 1) {
							SetTimer(v['id'],0,v['JamSelesai'], v['JamMulai'], v['NoTransaksi'], v['JenisPaket']);
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
							SetTimer(v['id'],1,v['JamMulai'], v['JamMulai'], v['NoTransaksi'], v['JenisPaket']);
							jQuery('#lblMulai'+v['id']).text(stringtoDateTime(v["JamMulai"]));	
						}
						else{
							jQuery('#lblMulai'+v['id']).text(stringtoDateTime(v["JamMulai"]));
							jQuery('#lblSelesai'+v['id']).text(stringtoDateTime(v["JamSelesai"]));	
						}
					}
					// SetTimer(v['id'],0,'2024-12-09T21:55:00');
				}
			});
			GeneratePaket();
			jQuery('#PosDetail').DataTable();

			FirstRowHandling();
			// SetTimer(1,0,'2024-12-09T21:55:00');
			// console.log(_billing);
			// Fill Datatable

		});
		$('#LookupDetailOrder').on('shown.bs.modal', function () {
			$('#cboMetodePembayaran_Detail').select2({
				dropdownParent: $(this) // Attach to the opened modal
			});
		});

		jQuery(document).on('click', '.dropdown-item', function(e) {
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
				const table = jQuery('#TablePenjualan').DataTable();
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
									formatNumber(item.Qty),
									formatNumber(item.Harga),
									formatNumber(item.Discount),
									formatNumber(item.LineTotal)
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
				jQuery('#txtNoTransaksi_RubahDurasi').val(NoTransaksi);
				
				jQuery('#LookupTambahDurasiPaket').modal({backdrop: 'static', keyboard: false})
		    	jQuery('#LookupTambahDurasiPaket').modal('show');
			}
		});

		jQuery('#JenisPaket').change(function () {
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
		});

		jQuery('#paketid').change(function () {
			const filteredData = _dataPaket.filter(item => item.id == jQuery('#paketid').val());
			// console.log(filteredData)
			if (filteredData.length > 0) {
				jQuery('#HargaNormal').val(filteredData[0]["HargaNormal"]);
				jQuery('#HargaBaru').val(filteredData[0]["HargaBaru"]);
				jQuery('#JamHargaNormal').val(filteredData[0]["AkhirJamNormal"]);
				jQuery('#JamHargaBaru').val(filteredData[0]["AkhirJamPerubahanHarga"]);
			}
		});

		jQuery('#frmPilihPaket').on('submit', function(e) {
			// 
			jQuery('#btMulaiBermain').text('Tunggu Sebentar');
			jQuery('#btMulaiBermain').attr('disabled',true);

			e.preventDefault();
			jQuery('#frmPilihPaket').find(':disabled').prop('disabled', false);

			const formData = new FormData(this);
			formData.append('Status', '1');

			$.ajax({
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
						Swal.fire({
	                      icon: "success",
	                      title: "Sukses",
	                      text: "Data Berhasil disimpan, Selamat Bermain",
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

		jQuery('#frmUpdatePaket').on('submit', function(e) {
			// 
			jQuery('#btRubahDurasiPaket').text('Tunggu Sebentar');
			jQuery('#btRubahDurasiPaket').attr('disabled',true);

			e.preventDefault();
			jQuery('#frmUpdatePaket').find(':disabled').prop('disabled', false);

			const formData = new FormData(this);

			$.ajax({
				url: "{{route('billing-editdurasi')}}",
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
							jQuery('#btRubahDurasiPaket').text('Tambah Paket');
							jQuery('#btRubahDurasiPaket').attr('disabled',false);

							jQuery('#LookupTambahDurasiPaket').modal({backdrop: 'static', keyboard: false})
		    				jQuery('#LookupTambahDurasiPaket').modal('show');
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
						jQuery('#btRubahDurasiPaket').text('Mulai Bermain');
						jQuery('#btRubahDurasiPaket').attr('disabled',false);

						jQuery('#LookupTambahDurasiPaket').modal({backdrop: 'static', keyboard: false})
		    			jQuery('#LookupTambahDurasiPaket').modal('show');
					});
				}
			});
		});

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

		jQuery('#LookupDetailOrder').on('hidden.bs.modal', function () {
			location.reload();
		});

		function SetTimer(tableid, TimerType ,EndTime, StartTime, NoTransaksi, JenisPaket) {

			// clock_
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
					const timer = setInterval(() => {
						const now = new Date().getTime();

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

						} else {
							// After the end date, stop the timer and display "Countdown ended"
							clearInterval(timer);
							
							// Do Update Status
							jQuery("#hours_"+tableid).html("0");
							jQuery("#min_"+tableid).html("0");
							jQuery("#sec_"+tableid).html("0");
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

			$.ajax({
				async:false,
				url: "{{route('billing-checkout')}}",
				type: 'POST',
				headers: {
					'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
				},
				data: {
					'txtNoTransaksi_CheckOut':NoTransaksi,
					"txtJenisPaket_CheckOut": JenisPaket
				},
				success: function(response) {
					if (response.success == true) {
						Swal.fire({
	                      icon: "success",
	                      title: "Sukses",
	                      text: "Berhasil Checkout, Silahkan Melakukan Pembayaran",
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
						  location.reload();
						});
					}
				}
			});

			
		}

		function fnDetails(NoTransaksi, oData) {
			const filteredData = _billing.filter(item => item.NoTransaksi == NoTransaksi);
			const DataPaket = <?php echo $paket ?>;
			const oCompany = <?php echo $company ?>;
			const filteredPaket = DataPaket.filter(item => item.id == filteredData[0]['paketid']);
			// console.log(NoTransaksi);
			console.log(oData);

			jQuery('#txtNoTransaksi_Detail').val(NoTransaksi);
			jQuery('#dtJenisPaket_Detail').text(filteredData[0]["JenisPaket"]);
			jQuery('#dtNamaPaket_Detail').text(filteredData[0]["NamaPaket"]);
			jQuery('#dtJamMulai_Detail').text(genfnFormatingDate(filteredData[0]["JamMulai"]));
			jQuery('#dtJamSelesai_Detail').text(genfnFormatingDate(filteredData[0]["JamSelesai"]));
			// formatCurrency($('#_TotalItem'), _tempTotalItem);

			var _HargaNormal = filteredPaket[0]["HargaNormal"];
			var _HargaBaru = filteredPaket[0]["HargaBaru"];
			var _JamSelesaiPaketNormal = filteredPaket[0]["AkhirJamNormal"];
			var _JamSelesaiPaketBaru = filteredPaket[0]["AkhirJamPerubahanHarga"];

			var _NewHargaNormal = 0;
			var _NewHargaBaru = 0;
			var _ppnPercent = oCompany[0]["PPN"];
			var _PPn = 0;
			var _PajakHiburanPercent = oCompany[0]["PajakHiburan"];
			var _PajakHiburan = 0;
			var _SubTotal = 0;
			var _TotalMakanan = 0;// belum
			var _Discount = 0; // belum

			var Now = new Date();
			var _maxPaketNormal = new Date(filteredData[0]["TglTransaksi"] + " " + filteredPaket[0]["AkhirJamNormal"]);
			var _maxPaketBaru = new Date(filteredData[0]["TglTransaksi"] + " " + filteredPaket[0]["AkhirJamPerubahanHarga"]);

			console.log(_maxPaketNormal);
			console.log(_maxPaketBaru);
			var _TextTotalHargaNormal = "";
			var _TextTotalHargaBaru = "";

			// Calculate Billing
			if (filteredData[0]["JenisPaket"] != "MENIT") {
				_NewHargaNormal = filteredPaket[0]["HargaNormal"] * filteredData[0]["DurasiPaket"];
				if (_ppnPercent > 0) {
					_PPn = (_ppnPercent / 100) * (filteredPaket[0]["HargaNormal"] * filteredData[0]["DurasiPaket"]);	
				}

				if (_PajakHiburanPercent > 0) {
					_PajakHiburan = (_PajakHiburanPercent / 100) * (filteredPaket[0]["HargaNormal"] * filteredData[0]["DurasiPaket"]);	
				}

				_SubTotal = _NewHargaNormal + _PPn + _PajakHiburan;

				_TextTotalHargaNormal = filteredData[0]["DurasiPaket"] + " " + filteredPaket[0]["JenisPaket"] +" * " + _HargaNormal + " = ";
			}
			else{

			}
			// Calculate FnB

			for (let index = 0; index < oData.length; index++) {
				_TotalMakanan += oData[index]["LineTotal"];
			}

			// Set Total
			jQuery('#dtTotalHargaNormal_Detail').text(
				_TextTotalHargaNormal + 
				new Intl.NumberFormat('id-ID', {
					style: 'currency',
					currency: 'IDR',
				}).format(_NewHargaNormal)
			);

			jQuery('#dtTotalPerubahanHarga_Detail').text(
				_TextTotalHargaBaru + 
				new Intl.NumberFormat('id-ID', {
					style: 'currency',
					currency: 'IDR',
				}).format(_NewHargaBaru)
			);

			jQuery('#dtTotalPPN_Detail').text(
				new Intl.NumberFormat('id-ID', {
					style: 'currency',
					currency: 'IDR',
				}).format(_PPn)
			);

			jQuery('#dtTotalPajakHiburan_Detail').text(
				new Intl.NumberFormat('id-ID', {
					style: 'currency',
					currency: 'IDR',
				}).format(_PajakHiburan)
			);

			jQuery('#dtSubTotal_Detail').text(
				new Intl.NumberFormat('id-ID', {
					style: 'currency',
					currency: 'IDR',
				}).format(_SubTotal)
			);

			formatCurrency($('#txtSubTotal_Detail'), _SubTotal);
			formatCurrency($('#txtTotalMakanan_Detail'), _TotalMakanan);
			formatCurrency($('#txtTotalPajak_Detail'), _PPn + _PajakHiburan);
			formatCurrency($('#txtDiscount_Detail'), _Discount);
			formatCurrency($('#txtGrandTotal_Detail'), _SubTotal + _TotalMakanan+ - _Discount);
			
		}

		function genfnFormatingDate(oDateTime) {
			const date = new Date(oDateTime);
			const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0'); // Months are zero-based
            const day = String(date.getDate()).padStart(2, '0');

			const hours = String(date.getHours()).padStart(2, '0');
            const minutes = String(date.getMinutes()).padStart(2, '0');
            const seconds = String(date.getSeconds()).padStart(2, '0');

			const formattedDateTime = `${day}-${month}-${year} ${hours}:${minutes}`;

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


	});
</script>