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
					 <div class="btn btn-icon  w-auto h-auto btn-clean d-flex align-items-center py-0 me-3"  data-bs-toggle="modal" data-bs-target="#folderpop"
					 >
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
 
 
						 <a href="#" class="dropdown-item">
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
	<form id="PoSSubmit">
		<div class="contentPOS">
			<div class="container-fluid">
				<div class="row">
					<div class="col-xl-4 order-xl-first">
						<div class="card card-custom gutter-b bg-white border-0">
							<div class="card-body">
								<div class="d-flex justify-content-between colorfull-select">
									<div class="selectmain">
										<select class="arabic-select w-200px bag-primary" id="cboJenisItem">
											<option value="">Semua Kelompok Item</option>
											@foreach ($jenisitem as $item)
												<option value="{{ $item->KodeJenis }}">{{ $item->NamaJenis }}</option>
											@endforeach
										</select>
									</div>
								</div>
								<hr>
								<div class="product-items">
									<div class="row" id="lsvProductList">
										@if (count($itemmenu) > 0)
											@foreach ($itemmenu as $item)
											<div class="col-xl-4 col-lg-2 col-md-3 col-sm-4 col-6" >
												<div class="productCard ProductSelected" data-KodeItem= "{{ $item->KodeItem }}" >
													<div class="productThumb">
														<img class="img-fluid" src="{{ $item->Gambar }}" alt="ix">
													</div>
													<div class="productContent">
														<center>
															{{ $item->NamaItem }}
														</center>
													</div>
												</div>
											</div>
											@endforeach
										@endif
									</div>
								</div>
								
							</div>	
						
						</div>
					</div>
					<div class="col-xl-8 order-xl-first">
						<div class="row">
							<div class="col-md-12">
								<div class="">
									<div class="card card-custom gutter-b bg-white border-0" >
										<div class="card-body">
											<div class="row">
												<div class="col-md-12" style="text-align: center;">
													<label class="text-dark" >Nomor Dokumen</label>
													<h2><div id="_NoTransaksi"></div></h2>
												</div>
												<hr>
												<div class="col-md-6">
													<div class="row">
														<div  class="col-md-12">
															<div class="shop-profile">
																<div class="media">
																	<div class="bg-primary w-100px h-100px d-flex justify-content-center align-items-center">
																		<h2 class="mb-0 white">K</h2>
																	</div>
																	<div class="media-body ms-3">
																		<h3 class="title font-weight-bold">
																			{{ $company[0]['NamaPartner'] }}
																		</h3>
																		<p class="phoonenumber">
																			{{ $company[0]['NoTlp'] }}
																		</p>
																		<p class="adddress">
																			{{ $company[0]['AlamatTagihan'] }}
																		</p>
																		<p class="countryname">Indonesia</p>
																	</div>
																</div>
															</div>
														</div>
														<div  class="col-md-12">
															<div class="btn btn-secondary text-white font-weight-bold me-1 mb-1 " id="btTipeOrder">
																<div id="txtTipeOrder">
																	<center>
																		<h4 class="mb-0 white">Tipe Order</h4>
																	</center>
																</div>
															</div>
															<div class="btn btn-success text-white font-weight-bold me-1 mb-1 " id="btNomorMeja">
																<div id="txtNomorMeja">
																	<center>
																		<h4 class="mb-0 white">Nomor Meja</h4>
																	</center>
																</div>
															</div>
														</div>
														
													</div>
												</div>
												<div class="col-md-6">
													<div class="row">
														<div class="col-md-12">
															<div class="form-group row mb-0">
																<label> <b>Bussiness Partner Area</b> </label>
																<div class="col-md-12">
																	<label class="text-dark" >Pilih Pelanggan </label>
																	<fieldset class="form-group mb-3 d-flex">
																		<select class="js-example-basic-single js-states form-control bg-transparent" id="KodePelanggan" name="KodePelanggan">
																			<option value="">Pilih Pelanggan</option>
																			@foreach($pelanggan as $ko)
																				<option value="{{ $ko->KodePelanggan }}">
																					{{ $ko->NamaPelanggan }}
																				</option>
																			@endforeach
																		</select>
																		<button class="btn-success btn ms-1 white pt-1 pb-1 d-flex align-items-center justify-content-center" id="btSearchCustomer">Cari</button>
																		<button class="btn-secondary btn ms-1 white pt-1 pb-1 d-flex align-items-center justify-content-center" id="btAddCustomer">Add</button>
																	</fieldset>
																</div>
															</div>
														</div>
														<div class="col-md-12">
															<label class="text-dark" >Nomor Refrensi </label>
															<fieldset class="form-group mb-3 d-flex">
																<input type="text" class="form-control" id="NoReff" name="NoReff" placeholder="Masukan No Reff" >
															</fieldset>
														</div>
														<div class="col-md-12">
															<div> 
																<button type="button" class="btn btn-primary white mb-2"  data-bs-toggle="modal" id="btBayar">
																	<i class="fas fa-money-bill-wave me-2"></i>
																	Bayar
																</button>
																<button type="button" class="btn btn-danger white mb-2" title="Delete" id="btBatal">
																	<i class="fas fa-trash-alt me-2"></i>
																	Batal
																</button>
							
																<button type="button" class="btn btn-secondary white mb-2" id="btDraft">
																	Simpan Sementara
																</button>
															</div>
														</div>
													</div>
												</div>
											</div>
											
										</div>	
									</div>
									<div class="card card-custom gutter-b bg-white border-0 table-contentpos">
										<div class="card-body" >
											<div class="form-group row mb-0">
												<div class="table-responsive" id="printableTable">
													<table id="PosDetail" class="display" style="width:100%">
														<thead>
															<tr>
																<th width="2%">#</th>
																<th width="20%">Item</th>
																<th width="12%">Qty</th>
																<th>Harga</th>
																<th width="12%">Disk</th>
																<th>Total</th>
																<th class=" no-sort text-end">Action</th>
															</tr>
														</thead>
														<tbody id="AppendArea">
			
														</tbody>
													</table>
												</div>
											</div>	
										</div>
									</div>	
								</div>	
							</div>
							<div class="col-md-12">
								<div class="card card-custom gutter-b bg-white border-0" >
									<div class="card-body">
										<div class="row">
											<div class="col-md-5">
												
											</div>
											<div class="col-md-6">
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
															<tr class="d-flex align-items-center justify-content-between">
																<th class="border-0">
																	<div class="d-flex align-items-center font-size-h5 mb-0 font-size-bold text-dark">
																	Services
																		<span class="badge badge-secondary white rounded-circle ms-2" id="btshippingcost">
																		<svg xmlns="http://www.w3.org/2000/svg" class="svg-sm" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_11" x="0px" y="0px" width="512px" height="512px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve">
																			<g>
																			<rect x="234.362" y="128" width="43.263" height="256"></rect>
																			<rect x="128" y="234.375" width="256" height="43.25"></rect>
																			</g>
																			</svg>
																		</span>
																
																	</div>
																</th>
																<td class="border-0 justify-content-end d-flex text-dark font-size-base" >
																	<input type="text" name="_TotalServices" id="_TotalServices" value="0" class="form-control TotalText">
																	<span style="margin: 0 5px;"> </span>
																	<div class="d-flex align-items-center font-size-h5 mb-0 font-size-bold text-dark">
																		<a href="#" id="btResetServices"> Reset</a>
																	</div>
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
					</div>
				</div>
			</div>
		</div>
	</form>
   <div class="modal fade text-left" id="payment-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel11" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable  modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h3 class="modal-title" id="myModalLabel11">Payment</h3>
			<button type="button" class="close rounded-pill btn btn-sm btn-icon btn-light btn-hover-primary m-0" data-bs-dismiss="modal" aria-label="Close">
			  <svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-x" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
				  <path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
			  </svg>
			</button>
		  </div>
		  <div class="modal-body">
			<table class="table right-table">
				<tbody>
				  <tr class="d-flex align-items-center justify-content-between">
					<th class="border-0 px-0 font-size-lg mb-0 font-size-bold text-primary">
						<h1>Total Transaksi</h1>
					</th>
					<td class="border-0 justify-content-end d-flex text-primary font-size-lg font-size-bold px-0 font-size-lg mb-0 font-size-bold text-primary">
						<input type="hidden" name="_TotalTagihan" id="_TotalTagihan">
						<h1 id="_TotalTagihanFormated">Rp. </h1>
					</td>
				  </tr>

				  <tr class="d-flex align-items-center justify-content-between">
					<th class="border-0 px-0 font-size-lg mb-0 font-size-bold text-primary">
						<h1>Pembulatan</h1>
					</th>
					<td class="border-0 justify-content-end d-flex text-primary font-size-lg font-size-bold px-0 font-size-lg mb-0 font-size-bold text-primary">
						<input type="hidden" name="_Pembulatan" id="_Pembulatan">
						<h1 id="_PembulatanFormated">Rp. </h1>
					</td>
				  </tr>

				  <tr class="d-flex align-items-center justify-content-between">
					<th class="border-0 px-0 font-size-lg mb-0 font-size-bold text-primary">
						<h1>Total Bayar</h1>
					</th>
					<td class="border-0 justify-content-end d-flex text-primary font-size-lg font-size-bold px-0 font-size-lg mb-0 font-size-bold text-primary">
						<input type="hidden" name="_TotalNetBayar" id="_TotalNetBayar">
						<h1 id="_TotalNetBayarFormated">Rp. </h1>
					</td>
				  </tr>
				</tbody>
			</table>	  
				<div class="form-group row">
					<div class="col-md-12">
						<div class="col-lg-12">
							<div class="card card-custom gutter-b bg-white border-0">
								<div class="card-header align-items-center  border-0">
									<div class="card-title mb-0">
										<h3 class="card-label text-body font-weight-bold mb-0">Pilih Metode Pembayaran
										</h3>
									</div>
								</div>

								<div class="card-body px-0">
									<div class="scroll-container list-group scrollbar-1">
										<ul class="horizontal-list payment">

											@foreach($metodepembayaran as $ko)
												<li class="list-group-item list-group-item-action border-0 d-flex align-items-center justify-content-between py-2" StsPyment={{$ko->Active}} id={{ $ko->id }} CaraVerifikasi={{$ko->MetodeVerifikasi}} TipePembayaran={{$ko->TipePembayaran}}>
													<div class="list-left d-flex align-items-center">
														<span class="d-flex align-items-center justify-content-center rounded svg-icon w-45px h-45px bg-light-dark text-white me-2">
															<img src="{{ $ko->Image }}" class="bi bi-lightning-fill" width="80%">
														</span>
													  <div class="list-content">
														<span class="list-title text-body">{{ $ko->NamaMetodePembayaran}}</span>
													  </div>
													</div>
												</li>
											@endforeach
								        </ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-md-12">
						<label  class="text-body">Jumlah Bayar</label>
						<fieldset class="form-label-group ">
							<input type="text" name="JumlahBayar" id="JumlahBayar" class="form-control CenterText" size="300" style="height: : 50px; font-size: 50px">
						</fieldset>
					</div>
					<div class="col-md-12">
						<label  class="text-body">Nomor Refrensi</label>
						<fieldset class="form-label-group ">
							<input type="text" name="NomorRefrensiPembayaran" id="NomorRefrensiPembayaran" class="form-control CenterText">
						</fieldset>
					</div>
				</div>
				<div class="form-group row justify-content-end mb-0">
					<div class="col-md-6  text-end">
						<button class="btn btn-primary" id="btSimpanPembayaran">Submit</button>
					</div>
				</div>
		  </div>
		</div>
	</div>	  	  
	</div>
   <div class="modal fade text-left" id="folderpop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel14" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg " role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h3 class="modal-title" id="myModalLabel14">Draft Orders</h3>
			<button type="button" class="close rounded-pill btn btn-sm btn-icon btn-light btn-hover-primary m-0" data-bs-dismiss="modal" aria-label="Close">
			  <svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-x" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
				  <path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
			  </svg>
			</button>
		  </div>
		  <div class="modal-body pos-ordermain">
				<div id="_draftOrderList">
			  		
				</div>
		  </div>
		</div>
	</div>	  	  
</div>

<div class="modal fade text-left" id="shippingcost" tabindex="1" role="dialog" aria-labelledby="shippingcost" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable  modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h3 class="modal-title" id="myModalLabel1444">Tambah Biaya Tambhan</h3>
			<button type="button" class="close rounded-pill btn btn-sm btn-icon btn-light btn-hover-primary m-0" data-bs-dismiss="modal" aria-label="Close">
			  <svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-x" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
				  <path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
			  </svg>
			</button>
		  </div>
		  <div class="modal-body">
			<div class="form-group row">
				<div class="col-md-12">
					<label  class="text-body">Item Jasa</label>
					<fieldset class="form-group mb-12">
						<select class="arabic-select select-down Select2-Selector" id="KodeItemJasa" name="KodeItemJasa" tabindex="-1">
							<option value="">Pilih Jasa</option>
							@foreach($itemServices as $ko)
								<option value="{{ $ko->KodeItem }}">
	                                {{ $ko->NamaItem }}
	                            </option>
							@endforeach
						</select>
					</fieldset>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-md-12">
					<label  class="text-body">Jumlah</label>
					<fieldset class="form-group mb-3">
						<input type="text" class="form-control" name="JumlahJasa" id="JumlahJasa" value="0">
					</fieldset>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-md-12">
					<label  class="text-body">Keterangan</label>
					<fieldset class="form-group mb-3">
						<input type="text" class="form-control" name="KeteranganJasa" id="KeteranganJasa">
					</fieldset>
				</div>
			</div>
			<div class="form-group row justify-content-end mb-0">
				<div class="col-md-6  text-end">
					<button id="btLookupBiaya" class="btn btn-primary">Update Order</button>
				</div>
			</div>
		  </div>
		</div>
	</div>	  	  
</div>

<div class="modal fade text-left" id="LookupCustomer" tabindex="-1" role="dialog" aria-labelledby="LookupCustomer" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h3 class="modal-title" id="myModalLabel1444">Cari Member / Pelanggan</h3>
			<button type="button" class="close rounded-pill btn btn-sm btn-icon btn-light btn-hover-primary m-0" data-bs-dismiss="modal" aria-label="Close">
			  <svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-x" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
				  <path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
			  </svg>
			</button>
		  </div>
		  <div class="modal-body">
			<div class="col-md-12">
				<div class="dx-viewport demo-container">
                	<div id="data-grid-demo">
                  		<div id="gridLookupCustomer"></div>
                	</div>
              	</div>
			</div>
			<hr>
			<div class="form-group row justify-content-end mb-0">
				<div class="col-md-6  text-end">
					<button type="button" class="btn btn-primary" id="btPilihCustomer">Pilih Data</button>
				</div>
			</div>
		  </div>
		</div>
	</div>	  	  
</div>


<div class="modal fade text-left" id="LookupAddCustomer" tabindex="-1" role="dialog" aria-labelledby="LookupAddCustomer" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h3 class="modal-title" id="myModalLabel1444">Tambah Member / Pelanggan</h3>
			<button type="button" class="close rounded-pill btn btn-sm btn-icon btn-light btn-hover-primary m-0" data-bs-dismiss="modal" aria-label="Close">
			  <svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-x" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
				  <path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
			  </svg>
			</button>
		  </div>
		  <div class="modal-body">
			<div class="col-md-12">
				<div class="form-group row">
					<div class="col-md-12">
            			<label  class="text-body">Kode Pelanggan</label>
            			<fieldset class="form-group mb-3">
            				<input type="text" class="form-control" id="ModalKodePelanggan" name="ModalKodePelanggan" placeholder="<AUTO>" readonly="" >
            			</fieldset>
            			
            		</div>
            		
            		<div class="col-md-12">
            			<label  class="text-body">Nama Pelanggan</label>
            			<fieldset class="form-group mb-3">
            				<input type="text" class="form-control" id="ModalNamaPelanggan" name="ModalNamaPelanggan" placeholder="Masukan Nama Pelanggan" required="">
            			</fieldset>
            			
            		</div>

            		<div class="col-md-6">
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
            			<label  class="text-body">Limit Piutang</label>
            			<fieldset class="form-group mb-3">
            				<input type="number" class="form-control" id="ModalLimitPiutang" name="ModalLimitPiutang" placeholder="Masukan Limit Piutang" value="0">
            			</fieldset>
            			
            		</div>

            		<div class="col-md-3">
            			<label  class="text-body">Provinsi</label>
            			<fieldset class="form-group mb-3">
            				<select name="ModalProvID" id="ModalProvID" class="js-example-basic-single js-states form-control bg-transparent" name="state" >
								<option value="-1">Pilih Provinsi</option>
								@foreach($provinsi as $ko)
									<option value="{{ $ko->prov_id }}">
                                        {{ $ko->prov_name }}
                                    </option>
								@endforeach
								
							</select>
            			</fieldset>
            		</div>

            		<div class="col-md-3">
            			<label  class="text-body">Kota</label>
            			<fieldset class="form-group mb-3">
            				<select name="ModalKotaID" id="ModalKotaID" class="js-example-basic-single js-states form-control bg-transparent" name="state" >
								<option value="-1">Pilih Kota</option>
							</select>
            			</fieldset>
            		</div>

            		<div class="col-md-3">
            			<label  class="text-body">Kecamatan</label>
            			<fieldset class="form-group mb-3">
            				<select name="ModalKecID" id="ModalKecID" class="js-example-basic-single js-states form-control bg-transparent" name="state" >
								<option value="-1">Pilih Kecamatan</option>
							</select>
            			</fieldset>
            		</div>

            		<div class="col-md-3">
            			<label  class="text-body">Kelurahan</label>
            			<fieldset class="form-group mb-3">
            				<select name="ModalKelID" id="ModalKelID" class="js-example-basic-single js-states form-control bg-transparent" name="state" >
								<option value="-1">Pilih Kelurahan</option>
							</select>
            			</fieldset>
            		</div>

            		<div class="col-md-12">
            			<label  class="text-body">Alamat</label>
            			<fieldset class="form-group mb-12">
            				<textarea class="form-control" id="ModalAlamat" name="ModalAlamat" rows="3" placeholder="Masukan Alamat"></textarea>
            			</fieldset>
            		</div>

            		<div class="col-md-6">
            			<label  class="text-body">Email</label>
            			<fieldset class="form-group mb-3">
            				<input type="mail" class="form-control" id="ModalEmail" name="ModalEmail" placeholder="Masukan Email" >
            			</fieldset>
            		</div>

            		<div class="col-md-3">
            			<label  class="text-body">NoTlp</label>
            			<fieldset class="form-group mb-3">
            				<input type="number" class="form-control" id="ModalNoTlp1" name="ModalNoTlp1" placeholder="621325058258" required="">
            			</fieldset>
            		</div>

            		<div class="col-md-3">
            			<label  class="text-body">Kontak Lain</label>
            			<fieldset class="form-group mb-3">
            				<input type="number" class="form-control" id="ModalNoTlp2" name="ModalNoTlp2" placeholder="621325058258" >
            			</fieldset>
            		</div>

            		<div class="col-md-12">
            			<label  class="text-body">Keterangan Lain</label>
            			<fieldset class="form-group mb-12">
            				<textarea class="form-control" id="ModalKeterangan" name="ModalKeterangan" rows="3" placeholder="Masukan Keterangan"></textarea>
            			</fieldset>
            		</div>

            		<div class="col-md-12">
            			<label  class="text-body">Status</label>
            			<fieldset class="form-group mb-3">
            				<select name="ModalStatus" id="ModalStatus" class="js-example-basic-single js-states form-control bg-transparent" name="state" >
								<option value="1">Active</option>
								<option value="0">Inactive</option>
							</select>
            			</fieldset>
            			
            		</div>
				</div>
			</div>
			<hr>
			<div class="form-group row justify-content-end mb-0">
				<div class="col-md-6  text-end">
					<button type="button" class="btn btn-primary" id="btSaveAddCustomer">Simpan Data</button>
				</div>
			</div>
		  </div>
		</div>
	</div>	  	  
</div>

<div class="modal fade text-left" id="LookupTipeOrder" tabindex="-1" role="dialog" aria-labelledby="myModalLabel11" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable  modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h3 class="modal-title" id="myModalLabel11">Tipe Order</h3>
			<button type="button" class="close rounded-pill btn btn-sm btn-icon btn-light btn-hover-primary m-0" data-bs-dismiss="modal" aria-label="Close">
			  <svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-x" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
				  <path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
			  </svg>
			</button>
		  </div>
		  <div class="modal-body">
				<div class="form-group row">
					<div class="col-md-12">
						<div class="col-lg-12">
							<div class="card card-custom gutter-b bg-white border-0">
								<div class="card-header align-items-center  border-0">
									<div class="card-title mb-0">
										<h3 class="card-label text-body font-weight-bold mb-0">Pilih Metode Pembayaran
										</h3>
									</div>
								</div>

								<div class="card-body px-0">
									<div class="scroll-container list-group scrollbar-1">
										<ul class="horizontal-list tipeorder">

											@foreach($tipeorder as $ko)
												<li class="list-group-item list-group-item-action border-0 d-flex align-items-center justify-content-between py-2" id={{ $ko->id }} NamaJenisOrder="{{ $ko->NamaJenisOrder }}" DineIn= "{{ $ko->DineIn }}">
													<div class="list-left d-flex align-items-center">
														<span class="d-flex align-items-center justify-content-center rounded svg-icon w-45px h-45px bg-light-dark text-white me-2">
															<img src="{{ $ko->Icon }}" class="bi bi-lightning-fill" width="80%">
														</span>
													  <div class="list-content">
														<span class="list-title text-body">{{ $ko->NamaJenisOrder}}</span>
													  </div>
													</div>
												</li>
											@endforeach
								        </ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group row justify-content-end mb-0">
					<div class="col-md-6  text-end">
						<button class="btn btn-primary" id="btPilihTipeOrder">Submit</button>
					</div>
				</div>
		  	</div>
		</div>
	</div>	  	  
</div>

<div class="modal fade text-left" id="LookupNomorMeja" tabindex="-1" role="dialog" aria-labelledby="myModalLabel11" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable  modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h3 class="modal-title" id="myModalLabel11">Nomor Meja</h3>
			<button type="button" class="close rounded-pill btn btn-sm btn-icon btn-light btn-hover-primary m-0" data-bs-dismiss="modal" aria-label="Close">
			  <svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-x" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
				  <path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
			  </svg>
			</button>
		  </div>
		  <div class="modal-body">
				<div class="form-group row">
					<div class="col-md-12">
						<div class="col-lg-12">
							<div class="card card-custom gutter-b bg-white border-0">
								<div class="card-header align-items-center  border-0">
									<div class="card-title mb-0">
										<h3 class="card-label text-body font-weight-bold mb-0">Pilih Nomor Meja										</h3>
									</div>
								</div>

								<div class="card-body px-0">
									<div class="scroll-container list-group scrollbar-1">
										<ul class="horizontal-list-meja nomormeja">

											@foreach($meja as $ko)
												<li class="list-group-item list-group-item-action border-0 d-flex align-items-center justify-content-between py-2" id={{ $ko->KodeMeja }} NamaMeja="{{ $ko->NamaMeja }}" >
													<div class="list-left d-flex align-items-center">
														<span class="d-flex align-items-center justify-content-center rounded svg-icon w-45px h-45px bg-light-dark text-white me-2">
															<img src="{{ url('images/default/dining-table.png') }}" class="bi bi-lightning-fill" width="80%">
														</span>
														<div class="list-content">
															<span class="list-title text-body">{{ $ko->NamaMeja}}</span>
														</div>
													</div>
												</li>
											@endforeach
								        </ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group row justify-content-end mb-0">
					<div class="col-md-6  text-end">
						<button class="btn btn-primary" id="btPilihNomorMeja">Submit</button>
					</div>
				</div>
		  	</div>
		</div>
	</div>	  	  
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/plugin.bundle.min.js')}}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js')}}"></script>
<!-- <script src="http://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script> -->
<script src="https://unpkg.com/multiple-select@1.5.2/dist/multiple-select.min.js"></script>
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
	var _LastInputed = '';
	var _TipeDiskon = '';
	var _ServicesData = [];
	var _DiskonGrupCustomer = 0;
	var _TerminPelanggan = '';

	var _Tanggal = '';
	var _Jam = '';
	var _Company = [];
	var _Printer = [];
	var _Pelanggan = [];
	var _KodeMetodePembayaran = -1;
	var _MetodeVerifikasiPembayaran = '';
	var _TipePembayaran = '';

	var _JenisOrder = '';
	var _idJenisOrder = -1;
	var _DineIn = 'N';

	var _KodeMeja = '';
	var _NamaMeja = '';

	var _oItemMenu = [];
	var _gridKodeItem = [];

	var _oTxtKodeItem = [];

	document.addEventListener('DOMContentLoaded', () => {
	    const listItems = document.querySelectorAll('.horizontal-list.payment li');
		const listTipeOrder = document.querySelectorAll('.horizontal-list.tipeorder li');
		const listNomorMeja = document.querySelectorAll('.horizontal-list-meja.nomormeja li');
	    console.log(listTipeOrder);

		if (listItems.length > 0) {
			listItems.forEach(item => {
				item.addEventListener('click', () => {
					// Remove active class from all items
					listItems.forEach(i => i.classList.remove('active'));

					// Add active class to the clicked item
					var Sts = $('#'+item.id).attr('stspyment');
					_MetodeVerifikasiPembayaran = $('#'+item.id).attr('CaraVerifikasi');
					_TipePembayaran = $('#'+item.id).attr('TipePembayaran');
					console.log(_TipePembayaran);
					if (Sts =='Y') {
						item.classList.add('active');
						_KodeMetodePembayaran = item.id;
						if (_TipePembayaran == "NON") {
							$('#JumlahBayar').val(jQuery('#_TotalNetBayar').attr("originalvalue"));	
						}
						else{
							$('#JumlahBayar').val(0);
						}
						$('#JumlahBayar').focus();
					}
					SetEnableCommand();
				});
			});	
		}

		if (listTipeOrder.length > 0) {
			listTipeOrder.forEach(item => {
				item.addEventListener('click', () => {
					// Remove active class from all items
					listTipeOrder.forEach(i => i.classList.remove('active'));
					item.classList.add('active');
					_idJenisOrder = item.id;
					_JenisOrder = $('#'+item.id).attr('NamaJenisOrder');
					_DineIn = $('#'+item.id).attr('DineIn');
					SetEnableCommand();
				});
			});	
		}

		if (listNomorMeja.length > 0) {
			listNomorMeja.forEach(item => {
				item.addEventListener('click', () => {
					// Remove active class from all items
					listNomorMeja.forEach(i => i.classList.remove('active'));
					item.classList.add('active');
					_KodeMeja = item.id;
					_NamaMeja = $('#'+item.id).attr('NamaMeja');
					SetEnableCommand();
				});
			});	
		}
	});
	jQuery(function () {
		jQuery(document).ready(function() {
            jQuery('#PosDetail').DataTable();
			$('#_Barcode').focus();
			jQuery('.arabic-select').multipleSelect({filter: true,filterAcceptOnEnter: true});
			$("#btNomorMeja").css("pointer-events", "none");

			_oItemMenu = <?php echo $itemmenu ?>;
			var xdata = <?php echo $itemServices ?>;

			jQuery('.Select2-Selector').select2({
				dropdownParent: $('#shippingcost')
			});

			jQuery('.js-example-basic-single').select2({
				dropdownParent: $('#LookupAddCustomer')
			});

			jQuery('#KodePelanggan').select2();
			jQuery('#KodeSales').select2();

			var now = new Date();
	    	var day = ("0" + now.getDate()).slice(-2);
	    	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	    	var hours = now.getHours().toString().padStart(2, '0');
			var minutes = now.getMinutes().toString().padStart(2, '0');
			var seconds = now.getSeconds().toString().padStart(2, '0');

	    	var firstDay = now.getFullYear()+"-"+month+"-01";
	    	var NowDay = now.getFullYear()+"-"+month+"-"+day;

	    	_Tanggal = NowDay;
	    	_Jam = hours+":"+minutes+":"+seconds;

	    	_Company = <?php echo $company ?>;
	    	_Pelanggan = <?php echo $pelanggan ?>;
			_Printer = <?php echo $printer ?>;

	    	LoadDraftOrderList();
	    	bindGridLookupCustomer(_Pelanggan);

	    	jQuery('#_NoTransaksi').text("<OTOMATIS>");
			SetEnableCommand();
		});

		jQuery('#cboJenisItem').change(function () {
			// console.log(jQuery('#cboJenisItem').val());
			// lsvProductList
			$.ajax({
	            async:false,
	            type: 'post',
	            url: "{{route('menu-ViewJson')}}",
	            headers: {
	                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
	            },
	            data: {
	                'KodeJenis' : jQuery('#cboJenisItem').val(),
	            },
	            dataType: 'json',
	            success: function(response) {
	            	// console.log(response);
					var xHTML = "";
					$.each(response.data,function (k,v) {
						xHTML += '<div class="col-xl-4 col-lg-2 col-md-3 col-sm-4 col-6">';
						xHTML += '	<div class="productCard">';
						xHTML += '		<div class="productThumb">';
						xHTML += '			<img class="img-fluid" src="'+v['Gambar']+'" alt="ix">';
						xHTML += '		</div>';
						xHTML += '		<div class="productContent">';
						xHTML += '			<a href="#">'+v['NamaItem']+'</a>';
						xHTML += '		</div>';
						xHTML += '	</div>';
						xHTML += '</div>';
					});

					jQuery('#lsvProductList').html(xHTML);
	            }
	        });
		});

		jQuery('#btTipeOrder').click(function () {
			jQuery('#LookupTipeOrder').modal({backdrop: 'static', keyboard: false})
			jQuery('#LookupTipeOrder').modal('show');
		});

		jQuery('#btNomorMeja').click(function () {
			jQuery('#LookupNomorMeja').modal({backdrop: 'static', keyboard: false})
			jQuery('#LookupNomorMeja').modal('show');
		});

		jQuery('#btPilihTipeOrder').click(function () {
			jQuery('#LookupTipeOrder').modal('hide');

			var xHTML = "";

			if (_idJenisOrder > -1) {
				xHTML += '<center>';
				xHTML += '	<p class="white">Tipe Order</p>';
				xHTML += '	<h4 class="mb-0 white">'+ _JenisOrder +'</h4>';
				xHTML += '</center>';
			}

			if (_DineIn == "Y") {
				$("#btNomorMeja").css("pointer-events", "auto");
			}
			else{
				$("#btNomorMeja").css("pointer-events", "none");
			}
			jQuery('#txtTipeOrder').html(xHTML);
			SetEnableCommand();
		});

		jQuery('#btPilihNomorMeja').click(function () {
			jQuery('#LookupNomorMeja').modal('hide');

			var xHTML = "";

			if (_idJenisOrder > -1) {
				xHTML += '<center>';
				xHTML += '	<p class="white">Nomor Meja</p>';
				xHTML += '	<h4 class="mb-0 white">'+ _NamaMeja +'</h4>';
				xHTML += '</center>';
			}
			jQuery('#txtNomorMeja').html(xHTML);
			SetEnableCommand();
		});

		$('.ProductSelected').on('click', function() {
			var kodeItem = $(this).data('kodeitem'); // Retrieve the custom attribute
			AddNewRow(kodeItem)
			AsignRowNumber();
			FirstRowHandling();
			CalculateTotal();
		});

		$('#btPilihLookupData').click(function () {
			var dataGridInstance = jQuery('#gridLookupItem').dxDataGrid('instance');
			var selectedRows = dataGridInstance.getSelectedRowsData();

			if (selectedRows.length > 0) {
				jQuery('#LookupItem').modal('hide');
				$('#_Barcode').val(selectedRows[0]['KodeItem']);
				$('#_Barcode').focus();

				var e = $.Event('keypress');
				e.keyCode = 13;
				$('#_Barcode').trigger(e);
			}

		});

		$('#btBatal').click(function () {
			location.reload()
		});

		$('#btshippingcost').click(function () {
			// bindGridLookupServices(_ServicesData);
			$('#KodeItemJasa').val('').trigger('change');
			$('#JumlahJasa').val('0');
			$('#KeteranganJasa').val('');
			jQuery('#shippingcost').modal({backdrop: 'static', keyboard: false})
		    jQuery('#shippingcost').modal('show');
		})

		$('#btLookupBiaya').click(function () {
			jQuery('#shippingcost').modal('hide');

			var item ={
				'KodeItem'  : $('#KodeItemJasa').val(),
				'Jumlah'	: $('#JumlahJasa').attr("originalvalue"),
				'Keterangan': $('#KeteranganJasa').val()
			}

			_ServicesData.push(item);

			CalculateTotal();
		});

		$('#JumlahJasa').focusout(function(){
			formatCurrency($("#JumlahJasa"), $("#JumlahJasa").val());
		});

		$('#JumlahBayar').focusout(function(){
			formatCurrency($("#JumlahBayar"), $("#JumlahBayar").val());
			SetEnableCommand();
		});

		jQuery('#KodePelanggan').change(function () {
			$.ajax({
	            async:false,
	            type: 'post',
	            url: "{{route('pelanggan-viewJson')}}",
	            headers: {
	                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
	            },
	            data: {
	                'KodePelanggan' : $('#KodePelanggan').val(),
	                'GrupPelanggan' : ''
	            },
	            dataType: 'json',
	            success: function(response) {
	            	var dataGridInstance = jQuery('#gridContainerDetail').dxDataGrid('instance');
      				var allRowsData  = dataGridInstance.getDataSource().items();

	            	if (response.data.length > 0) {
	            		_DiskonGrupCustomer = response.data[0]['DiskonPersen'];
	            		_TerminPelanggan = response.data[0]['DiskonPersen'];
	            		// console.log(response.data[0]);

	            		if (allRowsData.length > 0) {
	            			for (var i = 0; i < allRowsData.length; i++) {
	            				allRowsData[i]["DiskonPersen"] = _DiskonGrupCustomer;
	            			}

	            			bindGrid(allRowsData);
	            			CalculateTotal();
	            		}
	            	}
	            }
	        });
		});

		$('#btDraft').click(function () {
			SaveData('T',$('#btDraft'),'Simpan Sementara');
		});

		$('#btBayar').click(function () {
			// payment-popup
			jQuery('#payment-popup').modal({backdrop: 'static', keyboard: false})
		    jQuery('#payment-popup').modal('show');

		    $('#_TotalTagihan').val($('#_GrandTotal').attr('originalvalue'));
		    $('#_TotalTagihanFormated').text($('#_GrandTotal').val())

			// Pembulatan
			var TotalPenjualan = $('#_GrandTotal').attr('originalvalue');
			var TotalPembulatan = Math.ceil(TotalPenjualan);
			var NilaiPembulatan = TotalPembulatan - TotalPenjualan;
			console.log(NilaiPembulatan)
			// formatCurrency($('#_TotalServices'), _tempTotalServices);
			// $('#_Pembulatan').val();
			formatCurrency($('#_Pembulatan'), NilaiPembulatan)
		    $('#_PembulatanFormated').text($('#_Pembulatan').val())

			// Total Penjualan
			// $('#_TotalNetBayar').val();
			formatCurrency($('#_TotalNetBayar'), TotalPembulatan)
		    $('#_TotalNetBayarFormated').text($('#_TotalNetBayar').val())
		});

		$('#btSimpanPembayaran').click(function () {
			// PaymentGateWay();

			if (_MetodeVerifikasiPembayaran == "AUTO") {
				PaymentGateWay('C',$('#btSimpanPembayaran'),'Submit');
			}
			else{
				SaveData('C',$('#btSimpanPembayaran'),'Submit');
			}
		});

		$('#btSearchCustomer').click(function () {
			jQuery('#LookupCustomer').modal({backdrop: 'static', keyboard: false})
			jQuery('#LookupCustomer').modal('show');
		});

		$('#btPilihCustomer').click(function () {
			var dataGridInstance = jQuery('#gridLookupCustomer').dxDataGrid('instance');
			var selectedRows = dataGridInstance.getSelectedRowsData();

			console.log(selectedRows);
			if (selectedRows.length > 0) {
				jQuery('#LookupCustomer').modal('hide');
				jQuery('#KodePelanggan').val(selectedRows[0]['KodePelanggan']).trigger('change');
			}
		});

		jQuery('#btAddCustomer').click(function () {
			jQuery('#LookupAddCustomer').modal({backdrop: 'static', keyboard: false})
			jQuery('#LookupAddCustomer').modal('show');
		})

		jQuery('#ModalProvID').change(function () {
			$.ajax({
                async   : false,
                type    : "post",
                url     : "{{route('demografipelanggan')}}",
                data    : {
                            'Table' : 'dem_kota',
                            'Field' : 'prov_id',
                            'Value' : jQuery('#ModalProvID').val(),
                            '_token': '{{ csrf_token() }}',
                        },
                dataType: "json",
                success: function (response) {
                    // console.log(response);
                    if (response.data.length > 0) {
                    	$('#ModalKotaID').empty();
                    	var newOption = $('<option>', {
			            	value: -1,
			            	text: "Pilih Kota"
			          	});
			          	$('#ModalKotaID').append(newOption); 
			          	$.each(response.data,function (k,v) {
				            var newOption = $('<option>', {
				            	value: v.city_id,
				            	text: v.city_name
				        	});

				        	$('#ModalKotaID').append(newOption);
				        });
                    }
                }
            });
		});


		jQuery('#ModalKotaID').change(function () {
			console.log('Test masuk')
			$.ajax({
                async   : false,
                type    : "post",
                url     : "{{route('demografipelanggan')}}",
                data    : {
                            'Table' : 'dem_kecamatan',
                            'Field' : 'kota_id',
                            'Value' : $('#ModalKotaID').val(),
                            '_token': '{{ csrf_token() }}',
                        },
                dataType: "json",
                success: function (response) {
                    // console.log(response);
                    if (response.data.length > 0) {
                    	$('#ModalKecID').empty();
                    	var newOption = $('<option>', {
			            	value: -1,
			            	text: "Pilih Kecamatan"
			          	});
			          	$('#ModalKecID').append(newOption); 
			          	$.each(response.data,function (k,v) {
				            var newOption = $('<option>', {
				            	value: v.dis_id,
				            	text: v.dis_name
				        	});

				        	$('#ModalKecID').append(newOption);
				        });
                    }
                }
            });
		});


		jQuery('#ModalKecID').change(function () {
			console.log('Test masuk')
			$.ajax({
                async   : false,
                type    : "post",
                url     : "{{route('demografipelanggan')}}",
                data    : {
                            'Table' : 'dem_kelurahan',
                            'Field' : 'kec_id',
                            'Value' : $('#ModalKecID').val(),
                            '_token': '{{ csrf_token() }}',
                        },
                dataType: "json",
                success: function (response) {
                    // console.log(response);
                    if (response.data.length > 0) {
                    	$('#ModalKelID').empty();
                    	var newOption = $('<option>', {
			            	value: -1,
			            	text: "Pilih Kelurahan"
			          	});
			          	$('#ModalKelID').append(newOption); 
			          	$.each(response.data,function (k,v) {
				            var newOption = $('<option>', {
				            	value: v.subdis_id,
				            	text: v.subdis_name
				        	});

				        	$('#ModalKelID').append(newOption);
				        });
                    }
                }
            });
		});

		jQuery('#btSaveAddCustomer').click(function () {
			$.ajax({
                async   : false,
                type    : "post",
                url     : "{{route('pelanggan-storeJson')}}",
                headers: {
	                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
	            },
                data    : {
                	'NamaPelanggan' : jQuery('#ModalNamaPelanggan').val(),
                	'KodeGrupPelanggan' : jQuery('#ModalKodeGrupPelanggan').val(),
                	'LimitPiutang' : jQuery('#ModalLimitPiutang').val(),
                	'ProvID' : jQuery('#ModalProvID').val(),
                	'KotaID' : jQuery('#ModalKotaID').val(),
                	'KelID' : jQuery('#ModalKelID').val(),
                	'KecID' : jQuery('#ModalKecID').val(),
                	'Email' : jQuery('#ModalEmail').val(),
                	'NoTlp1' : jQuery('#ModalNoTlp1').val(),
                	'NoTlp2' : jQuery('#ModalNoTlp2').val(),
                	'Alamat' : jQuery('#ModalAlamat').val(),
                	'Keterangan' : jQuery('#ModalKeterangan').val(),
                	'Status' : jQuery('#ModalStatus').val()
                },
                dataType: "json",
                success: function (response) {
                    // console.log(response);
                    if (response.success == true) {
                    	jQuery('#LookupAddCustomer').modal('hide');
                    	var newOption = $('<option>', {
			            	value: response.LastTRX,
			            	text: jQuery('#ModalNamaPelanggan').val()
			          	});
			          	jQuery('#KodePelanggan').append(newOption);
			          	jQuery('#KodePelanggan').val(response.LastTRX).trigger('change');
                    }
                    else{
                    	Swal.fire({
	                      icon: "error",
	                      title: "Opps...",
	                      text: response.message,
	                    });
                    }
                }
            });
		});

	});

	function AddNewRow(KodeItem) {
		var RandomID = generateRandomText(10);
        var newRow = document.createElement('tr');
        newRow.className = RandomID;
        newRow.id = "InputSectionData"

		var tbody = document.querySelectorAll('#InputSectionData');
		// console.log(tbody);
        var index = 0;

		if (tbody.length > 0) {
			index = tbody.length + 1;
		}

		// Check if Exists
		var existingRow = Array.from(document.querySelectorAll('input[id="txtKodeItem"]')).find(function(input) {
			return input.value === KodeItem;
		});

		if (existingRow) {
        // If the row exists, update QtyText
			var row = existingRow.closest('tr');
			var qtyText = row.querySelector('input[id="txtQty"]');
			console.log(qtyText)
			qtyText.value = parseInt(qtyText.value) + 1; // Or set to any value you want
			updateTotal(row); // Update Total based on new Qty
			return;
		}

		// Filter Item
		let filteredItem = _oItemMenu.filter(function(item) {
            return item.KodeItem == KodeItem;
        });

		var nomorCol = document.createElement('td');
        var ItemCol = document.createElement('td');
        var QtyCol = document.createElement('td');
        var HargaCol = document.createElement('td');
		var TotalCol = document.createElement('td');
		var DiskonCol = document.createElement('td');
        var RemoveCol = document.createElement('td');

		var NamaItemText = document.createElement('input');
		var KodeItemText = document.createElement('input');
		var QtyText = document.createElement('input');
		var HargaText = document.createElement('input');
		var TotalText = document.createElement('input');
		var DiskonText = document.createElement('input');
		
		// Item
		NamaItemText.type  = 'text';
		NamaItemText.id = "txtNamaItem";
        NamaItemText.name = 'DetailParameter['+index+'][NamaItem]';
        NamaItemText.placeholder = "Tambah Nama Item";
        NamaItemText.className = 'form-control';
        NamaItemText.required = true;
        NamaItemText.value = filteredItem[0]["NamaItem"];
        NamaItemText.readOnly = true;
		NamaItemText.title = filteredItem[0]["NamaItem"];
        ItemCol.appendChild(NamaItemText);

        KodeItemText.type = "hidden";
		KodeItemText.id = "txtKodeItem";
        KodeItemText.name = 'DetailParameter['+index+'][KodeItem]';
        KodeItemText.value = KodeItem;
        ItemCol.appendChild(KodeItemText);
		// End Item

		// Jumlah
        QtyText.type  = 'number';
		QtyText.id = "txtQty";
        QtyText.name = 'DetailParameter['+index+'][Qty]';
        QtyText.placeholder = "Quantity";
        QtyText.className = 'form-control';
        QtyText.value = 1;
        QtyText.required = true;
        QtyText.addEventListener('input', function() {
			updateTotal(newRow);
			CalculateTotal();
            // let value = QtyText.value;
            // console.log('Current Value: ' + value);
            // PemakaianText.value = value;
            // QtyText.setAttribute('Qty', value);
			// TotalText.value = value * HargaText.value;
        });
        QtyCol.appendChild(QtyText);
		// End Jumlah

		// Harga
        HargaText.type  = 'number';
		HargaText.id = "txtHarga";
        HargaText.name = 'DetailParameter['+index+'][HargaJual]';
        HargaText.placeholder = "Harga";
        HargaText.className = 'form-control';
        HargaText.value = filteredItem[0]["HargaJual"];
        HargaText.required = true;
		HargaText.readOnly = true;
        HargaCol.appendChild(HargaText);
		// End Harga

		// Diskon
		DiskonText.type  = 'number';
		DiskonText.id = "txtDiskon";
        DiskonText.name = 'DetailParameter['+index+'][Diskon]';
        DiskonText.placeholder = "Diskon (%)";
        DiskonText.className = 'form-control';
        DiskonText.value = 0;
        DiskonText.required = true;
		DiskonText.addEventListener('input', function() {
			updateTotal(newRow);
			CalculateTotal();
            // let value = DiskonText.value;
            // console.log('Current Value: ' + value);
            // PemakaianText.value = value;
            // DiskonText.setAttribute('HargaJual', value);
        });
        DiskonCol.appendChild(DiskonText);
		// End Diskon

		// Total
		TotalText.type  = 'number';
		TotalText.id = "txtTotal";
        TotalText.name = 'DetailParameter['+index+'][Total]';
        TotalText.placeholder = "Total";
        TotalText.className = 'form-control';
        TotalText.value = (QtyText.value * HargaText.value) - ((DiskonText.value / 100) * (QtyText.value * HargaText.value));
        TotalText.required = true;
		TotalText.readOnly = true;
        TotalCol.appendChild(TotalText);
		// End Total
		console.log(QtyText.value + " * " + HargaText.value)

		var RemoveText = document.createElement('button');
        RemoveText.innerText   = 'Delete Data';
        RemoveText.type   = 'button';
        // RemoveText.style.color = "red";
        // RemoveText.href = "#"+RandomID;
        RemoveText.className = "btn btn-danger RemoveLineItem";
        RemoveText.id = "RemoveLineItem";
        RemoveText.onclick = function() {
            // alert('Button in row  clicked! ' + RandomID);
            var elements = document.querySelectorAll('.'+RandomID);
            // elements.remove();
            elements.forEach(function(element) {
                element.remove();
            });
            AsignRowNumber();
			FirstRowHandling();
			CalculateTotal();
            // console.log(elements)
        };
        RemoveCol.appendChild(RemoveText);
		newRow.appendChild(nomorCol);
        newRow.appendChild(ItemCol);
        newRow.appendChild(QtyCol);
        newRow.appendChild(HargaCol);
		newRow.appendChild(DiskonCol);
		newRow.appendChild(TotalCol);
		newRow.appendChild(RemoveCol);
        document.getElementById('AppendArea').appendChild(newRow);

		_oTxtKodeItem = document.querySelectorAll('#txtKodeItem');
	}

	function CalculateRowTotal(qty, harga, diskon) {
		return (qty * harga) - ((diskon / 100) * (qty * harga));
		CalculateTotal();
	}

	function updateTotal(row) {
		var qty = row.querySelector('input[id="txtQty"]').value;
		var harga = row.querySelector('input[id="txtHarga"]').value;
		var diskon = row.querySelector('input[id="txtDiskon"]').value;
		var totalText = row.querySelector('input[id="txtTotal"]');
		totalText.value = CalculateRowTotal(qty, harga, diskon);
	}

	function AsignRowNumber() {
        var tbody = document.querySelectorAll('#InputSectionData');
        tbody.forEach(function(row, index) {
            var firstCell = row.querySelector('td:first-child');
            if (firstCell) {
                firstCell.textContent = index + 1;
            }
        });
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

	function FirstRowHandling() {
		var tbody = document.querySelectorAll('#InputSectionData');
		if (tbody.length == 1) {
			// Find and remove the empty message element if it exists
			// $('td.dataTables_empty').remove();
			var emptyMessage = document.querySelector('td.dataTables_empty');
			console.log(emptyMessage)
			if (emptyMessage) {
				emptyMessage.remove();
			}
		}
		else if (tbody.length == 0) {
			var newEmptyMessage = document.createElement('tr');
			var emptyCell = document.createElement('td');
			emptyCell.colSpan = 7; // Adjust colspan as needed
			emptyCell.className = 'dataTables_empty';
			emptyCell.textContent = 'No data available in table';
			newEmptyMessage.appendChild(emptyCell);

			document.getElementById('AppendArea').appendChild(newEmptyMessage);
		}
		
	}

	


	function LoadDraftOrderList() {
		$.ajax({
			async:false,
			url: "{{route('fpenjualan-readheader')}}",
			type: 'POST',
			headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
            },
            data: {
            	'TglAwal':'1999-01-01',
            	'TglAkhir' : _Tanggal,
            	'KodePelanggan' : '',
            	'Status' : 'T'
           	},
            success: function(response) {
            	// console.log(response);
            	jQuery('#_draftCount').text(response.data.length);

            	if (response.data.length > 0) {
            		jQuery('#_draftOrderList').empty();
            		var xHTML = '<div class="row">';
            		$.each(response.data,function (k,v) {
            			var xNoTransaksi = "'"+v.NoTransaksi+"'";
            			xHTML += '<div class="col-lg-4">';
            			xHTML += '	<div class="pos-order">';
            			xHTML += '		<center><h4 class="pos-order-title" >'+v.NoTransaksi+'</h4></center>';
            			xHTML += '			<div class="orderdetail-pos">';
            			xHTML += '				<p><strong>Customer Name</strong> '+v.NamaPelanggan+'</p>';
            			xHTML += '				<p><strong>Payment Status</strong> Pending</p>';
            			xHTML += '				<p><strong>Total Item</strong> '+v.TotalItems+' Items</p>';
            			xHTML += '				<p><strong>Total Transaksi</strong> '+v.TotalHutang.toLocaleString('en-US')+'</p>';
            			xHTML += '			</div>';
            			xHTML += '			<div class="d-flex justify-content-end">';
            			xHTML += '				<a class="confirm-delete ms-3" title="Edit" onClick = "editDraft('+xNoTransaksi+')"><i class="fas fa-edit"></i></a>';
            			xHTML += '				<a class="confirm-delete ms-3" title="Delete" onClick = "deleteDraft('+xNoTransaksi+')"><i class="fas fa-trash-alt"></i></a>';
            			xHTML += '			</div>';
            			xHTML += '	</div>';
            			xHTML += '</div>';
            			
            		});

            		xHTML += '</div>';

            		console.log(xHTML);

            			jQuery('#_draftOrderList').html(xHTML);
            	}
            }
		});
	}

	function PrintStruk(NoTransaksi) {

		if(_Company[0]["NamaPosPrinter"] == ""){
			Swal.fire({
				icon: "error",
				title: "Opps...",
				text: "Printer Belum ditentukan, Silahkan melakukan setting di menu Master -> Pengaturan Toko -> Perusahaan",
			}).then((result) => {
				return;
			});
		}

		if(_Company[0]["LebarKertas"] == ""){
			Swal.fire({
				icon: "error",
				title: "Opps...",
				text: "Lebar Kertas Belum ditentukan, Silahkan melakukan setting di menu Master -> Pengaturan Toko -> Perusahaan",
			}).then((result) => {
				return;
			});
		}

		if(_Printer["PrinterInterface"] == "Bluetooth"){
			$.ajax({
				async:false,
				url: "{{route('print-retail')}}",
				type: 'POST',
				headers: {
					'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
				},
				data: {'NoTransaksi':NoTransaksi},
				success: function(response) {
					if (response.success == true) {
						Swal.fire({
						icon: "success",
						title: "Sukses",
						text: "Data Penjualan Berhasil Disimpan",
						}).then((result) => {
							location.reload();
						});
					}
					else{
						Swal.fire({
							icon: "error",
							title: "Opps...",
							text: response.message,
						});
					}
				}
			});
		}
		else if(_Printer["PrinterInterface"] == "USB"){
			// var link = "fpenjualan/printthermal/"+cellInfo.data.NoTransaksi;
			let url = "{{ url('') }}";
            // url.searchParams.append('NoTransaksi', NoTransaksi);
			url += "/fpenjualan/printthermal/"+NoTransaksi;
			console.log(url);
			// // window.location.href = url.toString();
			window.open(url, "_blank");
			location.reload();
		}
		else{
			Swal.fire({
				icon: "error",
				title: "Opps...",
				text: "Interface belum tersedia",
			});
		}
	}

	function GetItemInfo(KodeItem) {
		var oReturnData = {};

		$.ajax({
            async:false,
            type: 'post',
            url: "{{route('itemmaster-ViewJson')}}",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
            },
            data: {
                'KodeJenis' : '',
			    'Merk' 		: '',
			    'TipeItem' 	: '',
				'Active' 	: 'Y',
				'Scan'		: KodeItem,
				'TipeItemIN' : '1,3,5'
            },
            dataType: 'json',
            success: function(response) {
            	if (response.data.length > 0) {
            		oReturnData = response.data;
            	}
            }
        });

        return oReturnData;
	}

	function CalculateDiskon(KodeItem, Qty) {
		var DiskReturn = {};

		$.ajax({
            async:false,
            type: 'post',
            url: "{{route('fpenjualan-getDiskon')}}",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
            },
            data: {
                'KodeItem' : KodeItem,
                'Qty' 		: Qty
            },
            dataType: 'json',
            success: function(response) {
            	DiskReturn ={
            		Diskon : response.Diskon,
            		DiskonType : response.TipeDiskon
            	}
            }
        });

		return DiskReturn;
	}

	

	function bindGridLookupServices(data) {
		var dataGridInstance = jQuery("#gridLookupServices").dxDataGrid({
			allowColumnResizing: true,
			dataSource: data,
			keyExpr: "NoUrut",
			showBorders: true,
            allowColumnResizing: true,
            columnAutoWidth: true,
            showBorders: true,
            paging: {
                enabled: true,
                pageSize: 30
            },
            editing: {
                mode: "row",
                allowUpdating: true,
                allowDeleting: true,
                texts: {
                    confirmDeleteMessage: ''  
                }
            },
            columns: [
            	{
                    dataField: "NoUrut",
                    caption: "#",
                    allowEditing:false,
                    allowSorting: false 
                },
                {
                    dataField: "KodeItem",
                    caption: "Jasa",
                    lookup: {
					    dataSource: <?php echo $itemServices ?>,
					    valueExpr: 'KodeItem',
					    displayExpr: 'NamaItem',
				    },
				    allowSorting: false,
				    allowEditing:true
                },
                {
                    dataField: "Jumlah",
                    caption: "Jumlah",
                    allowEditing:true,
                    format: { type: 'fixedPoint', precision: 2 },
                    allowSorting: false 
                },
                {
                    dataField: "Keterangan",
                    caption: "Keterangan",
                    allowEditing:true,
                    allowSorting: false 
                },
            ],
            onContentReady: function(e) {
	            var rowData = dataGridInstance.option("dataSource");
	            if (rowData.length == 1) {
	            	dataGridInstance.editRow(0)	
	            }
	        },
	        onCellClick:function (e) {
	            var rowData = dataGridInstance.option("dataSource");
	            var columnIndex = e.columnIndex;
	            console.log(e)
	        	if (columnIndex >= 1 && columnIndex <= 5) {
	                dataGridInstance.editRow(e.rowIndex)	
	            }
	            dataGridInstance.option("focusedColumnIndex", columnIndex);	
	        },
		}).dxDataGrid('instance');

		var allRowsData  = dataGridInstance.option("dataSource");
    	var newData = { NoUrut: allRowsData.length + 1,KodeItem:"", Jumlah: 0, Keterangan:'' }
    	dataGridInstance.option("dataSource", [...dataGridInstance.option("dataSource"), newData]);
    	dataGridInstance.refresh();

    	dataGridInstance.on('rowUpdated', function(e) {
    		// console.log(e)
    		CalculateTotal();
    	});

    	dataGridInstance.on('editorPreparing',function (e) {
    		if (e.parentType === "dataRow" && e.dataField === "KodeItem") {
    			e.editorOptions.onFocusOut = (x) => {
    				var rowIndex = dataGridInstance.getRowIndexByKey(e.row.key);

    				dataGridInstance.cellValue(rowIndex, "Jumlah", 0);
		            dataGridInstance.cellValue(rowIndex, "Keterangan", '');
		            // dataGridInstance.cellValue(rowIndex, "Qty", 1);

		            dataGridInstance.refresh();

		            dataGridInstance.saveEditData();

		            var allRowsData  = dataGridInstance.option("dataSource");
                    var newData = { NoUrut: allRowsData.length + 1,KodeItem:"", Jumlah: 0, Keterangan:'' }
    				dataGridInstance.option("dataSource", [...dataGridInstance.option("dataSource"), newData]);
    				dataGridInstance.refresh();
    			}
    		}
    		else if (e.parentType === "dataRow" && e.dataField === "Jumlah") {
		    	e.editorOptions.onFocusOut = (x) => {
		    		dataGridInstance.saveEditData();
		    		CalculateTotal();
		    	}
		    }
		    else if (e.parentType === "dataRow" && e.dataField === "Keterangan") {
		    	e.editorOptions.onFocusOut = (x) => {
		    		dataGridInstance.saveEditData();
		    	}
		    }
    	})
	}

	function bindGridLookup(data) {
		// gridLookupItem
		var dataGridInstance = jQuery("#gridLookupItem").dxDataGrid({
			allowColumnResizing: true,
			dataSource: data,
			keyExpr: "KodeItem",
			showBorders: true,
            allowColumnResizing: true,
            columnAutoWidth: true,
            showBorders: true,
            paging: {
                enabled: true,
                pageSize: 30
            },
            editing: {
                mode: "row",
                texts: {
                    confirmDeleteMessage: ''  
                }
            },
            selection: {
                mode: "single" // Enable single selection mode
            },
            searchPanel: {
	            visible: true,
	            width: 240,
	            placeholder: "Search..."
	        },
            columns: [
            	{
                    dataField: "KodeItem",
                    caption: "Kode Item",
                    allowSorting: true,
                    allowEditing : false
                },
                {
                    dataField: "Barcode",
                    caption: "Barcode",
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
                    dataField: "Stock",
                    caption: "Stock",
                    allowSorting: true,
                    allowEditing : false,
                    format: { type: 'fixedPoint', precision: 2 },
                },
                {
                    dataField: "Satuan",
                    caption: "Sat",
                    allowSorting: true,
                    allowEditing : false
                },
            ]
		}).dxDataGrid('instance');
	}

	function bindGridLookupCustomer(data) {
		// gridLookupItem
		var dataGridInstance = jQuery("#gridLookupCustomer").dxDataGrid({
			allowColumnResizing: true,
			dataSource: data,
			keyExpr: "KodePelanggan",
			showBorders: true,
            allowColumnResizing: true,
            columnAutoWidth: true,
            showBorders: true,
            paging: {
                enabled: true,
                pageSize: 30
            },
            editing: {
                mode: "row",
                texts: {
                    confirmDeleteMessage: ''  
                }
            },
            selection: {
                mode: "single" // Enable single selection mode
            },
            searchPanel: {
	            visible: true,
	            width: 240,
	            placeholder: "Search..."
	        },
            columns: [
            	{
                    dataField: "KodePelanggan",
                    caption: "Kode Pelanggan",
                    allowSorting: true,
                    allowEditing : false
                },
                {
                    dataField: "NamaPelanggan",
                    caption: "Nama Pelanggan",
                    allowSorting: true,
                    allowEditing : false
                },
                {
                    dataField: "NoTlpConcat",
                    caption: "No. HP",
                    allowSorting: true,
                    allowEditing : false
                },
            ]
		}).dxDataGrid('instance');
	}
	
	function SaveData(Status, ButonObject, ButtonDefaultText) {
		ButonObject.text('Tunggu Sebentar.....');
  		ButonObject.attr('disabled',true);

  		var NoTransaksi = "";
  		if (jQuery('#_NoTransaksi').text() != "<OTOMATIS>") {
  			NoTransaksi = jQuery('#_NoTransaksi').text();
  		}
  		// console.log(allRowsData)
  		var oDetail = [];

		var rows = document.querySelectorAll('#AppendArea tr');
		var NoUrut = 0;
		rows.forEach(function(row) {
			var totalInput = row.querySelector('input[id="txtTotal"]');
			var RowKodeItem = row.querySelector('input[id="txtKodeItem"]');
			var RowQty = row.querySelector('input[id="txtQty"]');
			var RowHarga = row.querySelector('input[id="txtHarga"]');
			var RowDiskon = row.querySelector('input[id="txtDiskon"]');

			if (totalInput) {
				var oDisk = parseFloat(RowQty.value) * parseFloat(RowHarga.value) * (parseFloat(RowDiskon.value)/ 100);
				
				var oItem = {
  					'NoUrut' : NoUrut,
					'KodeItem' : RowKodeItem.value,
					'Qty' : RowQty.value,
					'QtyKonversi' : RowQty.value,
					'Satuan' : '',
					'Harga' : RowHarga.value,
					'Discount' : oDisk,
					'HargaNet' : (RowQty.value * RowHarga.value) - oDisk,
					'BaseReff' : 'POS',
					'BaseLine' : -1,
					'KodeGudang' : _Company[0]['GudangPoS'],
					'LineStatus': Status,
					'VatPercent' : 0,
					'HargaPokokPenjualan' : 0,
  				}
  				
  				oDetail.push(oItem)

				NoUrut+=1
			}
		});

  		if (_ServicesData.length > 0) {
  			for (var i = 0; i < _ServicesData.length; i++) {
  				var oItem = {
  					'NoUrut' : oDetail.length + 1,
					'KodeItem' : _ServicesData[i]['KodeItem'],
					'Qty' : 1,
					'Satuan' : '',
					'Harga' : _ServicesData[i]['Jumlah'],
					'Discount' : 0,
					'HargaNet' : _ServicesData[i]['Jumlah'],
					'BaseReff' : '',
					'BaseLine' : -1,
					'KodeGudang' : 'UMM',
					'LineStatus': Status,
  				}
  				
  				oDetail.push(oItem)
  			}
  		}

  		// jQuery('#_NoTransaksi').text()
  		var oData = {
			'NoTransaksi' : NoTransaksi,
			'TglTransaksi' : _Tanggal + " " + _Jam,
			'TglJatuhTempo' : _Tanggal,
			'NoReff' : 'POS',
			'KodeSales' : '',
			'KodePelanggan' : jQuery('#KodePelanggan').val(),
			'KodeTermin' : _Company[0]['TerminBayarPoS'],
			'Termin' : 0,
			'TotalTransaksi' : jQuery('#_SubTotal').attr("originalvalue"),
			'Potongan' : jQuery('#_TotalDiskon').attr("originalvalue"),
			'Pajak' : 0,
			'Pembulatan' : jQuery('#_Pembulatan').attr("originalvalue"),
			'TotalPembelian' : jQuery('#_TotalNetBayar').attr("originalvalue"),
			'TotalRetur' : 0,
			'TotalPembayaran' : (Status) == 'T' ? 0 : jQuery('#JumlahBayar').attr("originalvalue"),
			'Status' : Status,
			'Keterangan' : '',
			'MetodeBayar' : _KodeMetodePembayaran,
			'ReffPembayaran' : $('#NomorRefrensiPembayaran').val(),
			'JenisOrder' : _idJenisOrder,
			'KodeMeja' : _KodeMeja,
			'Detail' : oDetail
		}

		console.log(oData);

		// Save Data

		$.ajax({
			async:false,
			url: (NoTransaksi) == "" ? "{{route('fpenjualan-retailPosFnB')}}" : "{{route('fpenjualan-editJsonPosFnB')}}",
			type: 'POST',
			contentType: 'application/json',
			headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
            },
            data: JSON.stringify(oData),
            success: function(response) {
            	if (response.success == true) {
            		if(Status == 'T'){
            			Swal.fire({
	                      icon: "success",
	                      title: "Sukses",
	                      text: "Data Berhasil disimpan",
	                    }).then((result) => {
						  location.reload();
						});
            		}else{
            			let formattedAmount = parseFloat(response.Kembalian).toLocaleString('en-US', {
				            style: 'decimal',
				            minimumFractionDigits: 2,
				            maximumFractionDigits: 2
				        });
	            		Swal.fire({
						  title: "KEMBALIAN "+formattedAmount,
						  text: "Cetak Struk ?",
						  icon: "warning",
						  showCancelButton: true,
						  confirmButtonColor: "#3085d6",
						  cancelButtonColor: "#d33",
						  confirmButtonText: "Cetak",
						  cancelButtonText: "Tidak Cetak"
						}).then((result) => {
						  if (result.isConfirmed) {
						    PrintStruk(response.LastTRX);
						  }
						  else{
						  	location.reload();
						  }
						});
            		}
            	}
            	else{
            		Swal.fire({
                      icon: "error",
                      title: "Opps...",
                      text: response.message,
                    })
                    ButonObject.text(ButtonDefaultText);
  					ButonObject.attr('disabled',false);
            	}
            }
		});

		ButonObject.text(ButtonDefaultText);
  		ButonObject.attr('disabled',false);
	}

	function PaymentGateWay(Status, ButonObject, ButtonDefaultText) {

		var dataGridInstance = jQuery('#gridContainerDetail').dxDataGrid('instance');
  		var allRowsData  = dataGridInstance.getDataSource().items();

  		var NoTransaksi = "";
  		if (jQuery('#_NoTransaksi').text() != "<OTOMATIS>") {
  			NoTransaksi = jQuery('#_NoTransaksi').text();
  		}
  		// console.log(allRowsData)
  		var oDetail = [];

  		for (var i = 0; i < allRowsData.length; i++) {
  			// Things[i]
  			if (allRowsData[i]['KodeItem'] != "") {
  				// var oItemMaster = GetItemInfo(allRowsData[i]['KodeItem']);
  				var oDisk = 0;

  				if (allRowsData[i]['DiskonPersen'] > 0) {
  					oDisk += (allRowsData[i]['Qty'] * allRowsData[i]['Harga']) * allRowsData[i]['DiskonPersen'] / 100;
  				}

  				if (allRowsData[i]['DiskonRp'] > 0) {
  					oDisk += allRowsData[i]['DiskonRp'];
  				}

  				// console.log(oItemMaster[0].Satuan);

  				var oItem = {
  					'NoUrut' : allRowsData[i]['LineNumber'],
					'KodeItem' : allRowsData[i]['KodeItem'],
					'Qty' : allRowsData[i]['Qty'] * allRowsData[i]['QtyKonversi'],
					'QtyKonversi' : allRowsData[i]['QtyKonversi'],
					'Satuan' : allRowsData[i]['Satuan'],
					'Harga' : allRowsData[i]['Harga'],
					'Discount' : oDisk,
					'HargaNet' : (allRowsData[i]['Qty'] * allRowsData[i]['Total']) - oDisk,
					'BaseReff' : 'POS',
					'BaseLine' : -1,
					'KodeGudang' : _Company[0]['GudangPoS'],
					'LineStatus': Status,
					'VatPercent' : allRowsData[i]['VatPercent'],
					'HargaPokokPenjualan' : allRowsData[i]['HargaPokokPenjualan'],
  				}
  				
  				oDetail.push(oItem)
  			}
  		}

  		if (_ServicesData.length > 0) {
  			for (var i = 0; i < _ServicesData.length; i++) {
  				var oItem = {
  					'NoUrut' : oDetail.length + 1,
					'KodeItem' : _ServicesData[i]['KodeItem'],
					'Qty' : 1,
					'Satuan' : '',
					'Harga' : _ServicesData[i]['Jumlah'],
					'Discount' : 0,
					'HargaNet' : _ServicesData[i]['Jumlah'],
					'BaseReff' : '',
					'BaseLine' : -1,
					'KodeGudang' : 'UMM',
					'LineStatus': Status,
  				}
  				
  				oDetail.push(oItem)
  			}
  		}

  		// jQuery('#_NoTransaksi').text()
  		var oData = {
			'NoTransaksi' : NoTransaksi,
			'TglTransaksi' : _Tanggal + " " + _Jam,
			'TglJatuhTempo' : _Tanggal,
			'NoReff' : 'POS',
			'KodeSales' : jQuery('#KodeSales').val(),
			'KodePelanggan' : jQuery('#KodePelanggan').val(),
			'KodeTermin' : _Company[0]['TerminBayarPoS'],
			'Termin' : 0,
			'TotalTransaksi' : jQuery('#_SubTotal').attr("originalvalue"),
			'Potongan' : jQuery('#_TotalDiskon').attr("originalvalue"),
			'Pajak' : 0,
			'Pembulatan' : jQuery('#_Pembulatan').attr("originalvalue"),
			'TotalPembelian' : jQuery('#_TotalNetBayar').attr("originalvalue"),
			'TotalRetur' : 0,
			'TotalPembayaran' : (Status) == 'T' ? 0 : jQuery('#JumlahBayar').attr("originalvalue"),
			'Status' : Status,
			'Keterangan' : '',
			'MetodeBayar' : _KodeMetodePembayaran,
			'ReffPembayaran' : $('#NomorRefrensiPembayaran').val(),
			'Detail' : oDetail
		}
		
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
			if (data.snap_token) {
				snap.pay(data.snap_token, {
					onSuccess: function(result){
						console.log(result);
						if(result.transaction_status == "cancel"){
							Swal.fire({
								icon: "error",
								title: "Opps...",
								text: "Pembayaran Dibatalkan",
							})
						}
						else{
							// order_id
							$('#NomorRefrensiPembayaran').val(result.order_id)
							SaveData(Status, ButonObject, ButtonDefaultText)
						}
						// Proses pembayaran sukses
					},
					onPending: function(result){
						console.log(result);
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

	function CalculateTotal() {
		var rows = document.querySelectorAll('#AppendArea tr'); // Select all rows within the AppendArea
		var grandTotal = 0;
  		// console.log(allRowsData)

  		var _tempTotalItem = rows.length - 1;
  		var _tempSubTotal = 0;
  		var _tempTotalDiskon = 0;
  		var _tempTotalTax = 0;
  		var _tempTotalServices = 0;
  		var _tempGrandTotal = 0;

		rows.forEach(function(row) {
			var totalInput = row.querySelector('input[id="txtTotal"]');
			var RowQty = row.querySelector('input[id="txtQty"]');
			var RowHarga = row.querySelector('input[id="txtHarga"]');
			var RowDiskon = row.querySelector('input[id="txtDiskon"]');

			if (totalInput) {
				_tempSubTotal += parseFloat(totalInput.value) || 0;
				_tempTotalDiskon += parseFloat(RowQty.value) * parseFloat(RowHarga.value) * (parseFloat(RowDiskon.value)/ 100);
			}
		});

	    // Jasa
	    for (var i = 0; i < _ServicesData.length; i++) {
	    	_tempTotalServices += parseFloat(_ServicesData[i]['Jumlah']);
	    }

	    // Diskon Grup Customer

		// console.log(_tempTotalTax)

	    formatCurrency($('#_TotalItem'), _tempTotalItem);
	    formatCurrency($('#_SubTotal'), _tempSubTotal);
	    formatCurrency($('#_TotalDiskon'), _tempTotalDiskon);
	    formatCurrency($('#_TotalServices'), _tempTotalServices);
	    formatCurrency($('#_GrandTotal'), _tempSubTotal + _tempTotalServices - _tempTotalDiskon + _tempTotalTax);
		formatCurrency($('#_TotalTax'), _tempTotalTax);

		SetEnableCommand();
	}


	function SetEnableCommand() {
    	var ErrorCount = 0;

		// Set Tipe Order
		var xTipeOrderHTML = "";
		// Set Tipe Order
    	

    	// if ($('#JumlahBayar').attr('originalvalue') < $('#_TotalTagihan').val()) {
    	// 	ErrorCount +=1;
    	// }

		// console.log(_idJenisOrder +" > " + _DineIn + " > " + _KodeMeja);
		if (_idJenisOrder == -1) {
			ErrorCount +=1;
		}

		if (_DineIn == 'Y' && _KodeMeja == "" ) {
			ErrorCount +1;
		}

		if ($('#KodePelanggan').val() == "") {
			ErrorCount +1;
		}

    	if (ErrorCount >0) {
			var xBayarError = 0;
			if ($('#JumlahBayar').attr('originalvalue') == 0) {
				// $('#btSimpanPembayaran').attr('disabled',true);
				xBayarError +=1 ;
			}

			if (_KodeMetodePembayaran == -1) {
				// $('#btSimpanPembayaran').attr('disabled',true);
				xBayarError +=1
			}

			if (xBayarError > 0) {
				$('#btSimpanPembayaran').attr('disabled',true);
			}
			else{
				$('#btSimpanPembayaran').attr('disabled',false);
			}
    		
			// $('#btBayar').attr('disabled',true);
			$('#btDraft').attr('disabled',true);
    	}
    	else{
    		$('#btSimpanPembayaran').attr('disabled',false);
			$('#btDraft').attr('disabled',false);
			// $('#btBayar').attr('disabled',false);
    	}

    }
    function editDraft(NoTransaksi) {
    	jQuery('#_NoTransaksi').text(NoTransaksi)
    	var dataGridInstance = jQuery('#gridContainerDetail').dxDataGrid('instance');
        var dataSource = dataGridInstance.getDataSource();
        dataGridInstance.option("dataSource", []);
    	// Load Header
    	$.ajax({
			async:false,
			url: "{{route('fpenjualan-findheader')}}",
			type: 'POST',
			headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
            },
            data: {
            	'NoTransaksi':NoTransaksi
           	},
            success: function(response) {
            	if (response.data.length > 0) {
            		jQuery('#KodePelanggan').val(response.data[0]['KodePelanggan']).trigger('change');
            		jQuery('#KodeSales').val(response.data[0]['KodeSales']).trigger('change');
            	}
            	else{

            	}
            }
		});

		// Load Detail
		$.ajax({
			async:false,
			url: "{{route('fpenjualan-readdetail')}}",
			type: 'POST',
			headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
            },
            data: {
            	'NoTransaksi':NoTransaksi
           	},
            success: function(response) {
            	// console.log(response)
            	

            	var xLine = 0;
            	$.each(response.data,function (k,v) {
            		var item = {
	        			'LineNumber' 	: xLine,
	        			'KodeItem' 	 	: v.KodeItem,
	        			'NamaItem'	 	: v.NamaItem,
	        			'Qty'	 	 	: v.Qty,
	        			'QtyKonversi'	: v.QtyKonversi,
	        			'Satuan'		: v.Satuan,
	        			'Harga' 	 	: v.Harga,
	        			'DiskonPersen' 	: 0,
	        			'DiskonRp' 	 	: 0,
	        			'Total' 	 	: 0
	        		}

	        		dataSource.store().insert(item).then(function() {
				        dataSource.reload();
				    })
				    xLine +=1;
            	});
            	CalculateTotal()

            	jQuery('#folderpop').modal('hide');
            }
		});
    }

    function editDataTransaksi(NoTransaksi, Status) {
    	$.ajax({
			async:false,
			url: "{{route('fpenjualan-editStatus')}}",
			type: 'POST',
			headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
            },
            data: {
            	'NoTransaksi':NoTransaksi,
            	'Status' : Status
           	},
            success: function(response) {
            	if (response.success == true) {
            		Swal.fire({
                      icon: "success",
                      title: "Horray..",
                      text: "Data Berhasil Dihapus",
                    }).then((result) => {
					  location.reload();
					});
            	}
            	else{
            		Swal.fire({
                      icon: "error",
                      title: "wooopss..",
                      text: response.message,
                    });
            	}
            }
		});
    }

    function deleteDraft(NoTransaksi) {
    	jQuery('#_NoTransaksi').text(NoTransaksi)
    	// editDraft(NoTransaksi);
    	Swal.fire({
		  title: "Hapus Data Draff Penjualan",
		  text: "Hapus Draft penjualan ini ?",
		  icon: "warning",
		  showCancelButton: true,
		  confirmButtonColor: "#3085d6",
		  cancelButtonColor: "#d33",
		  confirmButtonText: "Hapus",
		  cancelButtonText: "Jangan Hapus"
		}).then((result) => {
		  if (result.isConfirmed) {
		    editDataTransaksi(NoTransaksi, 'D')
		  }
		  else{
		  	location.reload();
		  }
		});
    }


    
</script>