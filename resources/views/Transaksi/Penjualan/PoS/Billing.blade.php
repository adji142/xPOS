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
														<div class="dropdown-menu dropdown-menu-right"
															aria-labelledby="dropdownMenuButton1">
															@if ($item->NoTransaksi != "")
															<a class="disabled-link dropdown-item btPilihPaket_{{ $item->id }}" href="#" data-namatitiklampu="{{ $item->NamaTitikLampu }}">Pilih Paket</a>
															@else
															<a class="dropdown-item btPilihPaket_{{ $item->id }}" href="#" data-namatitiklampu="{{ $item->NamaTitikLampu }}">Pilih Paket</a>
															@endif
															<a class="dropdown-item btCheckOut_{{ $item->id }}" href="#" data-namatitiklampu="{{ $item->NamaTitikLampu }}">Check Out</a>
															<a class="dropdown-item btTambahMakanan_{{ $item->id }}" href="#" data-namatitiklampu="{{ $item->NamaTitikLampu }}">Tambah Makanan</a>
                                                            <a class="dropdown-item btDetail_{{ $item->id }}" href="#" data-namatitiklampu="{{ $item->NamaTitikLampu }}">Detail</a>
														</div>
													</div>
												</div>
                                                <div class="card-body" >
													@if ($item->NoTransaksi != "")
													<button class="btn btn-danger text-white font-weight-bold w-100 py-3">{{ $item->StatusMeja }}</button>
													@else
													<button class="btn btn-success text-white font-weight-bold w-100 py-3">{{ $item->StatusMeja }}</button>
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
	<div class="modal-dialog modal-dialog-scrollable  modal-dialog-centered modal-lg" role="document">
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
					jQuery('#lblMulai'+v['id']).text(stringtoDateTime(v["TglPencatatan"]));
					if (v['JamSelesai'] != null) {
						SetTimer(v['id'],0,v['JamSelesai']);
					}
					else{
						SetTimer(v['id'],1,v['JamMulai'])
					}
					// SetTimer(v['id'],0,'2024-12-09T21:55:00');
				}
			});
			GeneratePaket();
			// SetTimer(1,0,'2024-12-09T21:55:00');
			console.log(_billing);

		});

		jQuery(document).on('click', '.dropdown-item', function(e) {
			e.preventDefault();
			const clickedClass = $(this).attr('class');
			const itemId = clickedClass.match(/_(\d+)/)[1];
			var NamaTitikLampu = $(this).data('namatitiklampu');
			
			if (clickedClass.includes('btPilihPaket')) {
				// console.log(`Pilih Paket clicked for item ID: ${itemId}`);
				// LookupPilihPaket
				// tableid
				jQuery('#lblNamaTitikLampu').text(NamaTitikLampu);
				jQuery('#tableid').val(itemId).change();
				jQuery('#LookupPilihPaket').modal({backdrop: 'static', keyboard: false})
		    	jQuery('#LookupPilihPaket').modal('show');

			} else if (clickedClass.includes('btCheckOut')) {
				console.log(`Check Out clicked for item ID: ${itemId}`);
			} else if (clickedClass.includes('btTambahMakanan')) {
				console.log(`Tambah Makanan clicked for item ID: ${itemId}`);
			} else if (clickedClass.includes('btDetail')) {
				console.log(`Detail clicked for item ID: ${itemId}`);
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
			console.log(filteredData)
			if (filteredData.length > 0) {
				jQuery('#HargaNormal').val(_dataPaket[0]["HargaNormal"]);
				jQuery('#HargaBaru').val(_dataPaket[0]["HargaBaru"]);
				jQuery('#JamHargaNormal').val(_dataPaket[0]["AkhirJamNormal"]);
				jQuery('#JamHargaBaru').val(_dataPaket[0]["AkhirJamPerubahanHarga"]);
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

		function SetTimer(tableid, TimerType ,EndTime) {

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
					const timer = setInterval(() => {
						const now = new Date().getTime();
						const timeLeft = endDate - now;

						const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
						const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
						const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

						// Display the result
						jQuery("#hours_"+tableid).html((hours < 10 ? "0" : "") + hours);
						jQuery("#min_"+tableid).html((minutes < 10 ? "0" : "") + minutes);
						jQuery("#sec_"+tableid).html((seconds < 10 ? "0" : "") + seconds);

						// If the countdown is over, stop the timer
						if (timeLeft < 0) {
							clearInterval(timer);
							console.log('Countdown Ended!');
							// document.getElementById("countdown").innerHTML = "Countdown Ended!";
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
	});
</script>