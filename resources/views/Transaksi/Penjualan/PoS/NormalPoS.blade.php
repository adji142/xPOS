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
	
	<link href="http://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
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
   <div class="contentPOS">
	    <div class="container-fluid">
			<div class="row">
				<div class="col-xl-4 order-xl-first order-last" style="display: none;">
					<div class="card card-custom gutter-b bg-white border-0">
						<div class="card-body">
							<div class="d-flex justify-content-between colorfull-select">
								<div class="selectmain">
									<select class="arabic-select w-150px bag-primary">
										<option value="1">Men's</option>
										<option value="2">Accessories</option>
									</select>
								</div>
							
							</div>
						</div>	
							<div class="product-items">
								<div class="row">
									<div class="col-xl-4 col-lg-2 col-md-3 col-sm-4 col-6">
										<div class="productCard">
											<div class="productThumb">
												<img class="img-fluid" src="{{ asset('images/carousel/element-banner2-right.jpg')}}" alt="ix">
											</div>
											<div class="productContent">
												<a href="#">
													Men Polo Shirt (M) -MPS[2545-P]
												</a>
											</div>
										</div>
									</div>

								</div>
							</div>
						
					
					</div>
				</div>
				<div class="col-xl-9 col-lg-8 col-md-8">
				     <div class="">
						<div class="card card-custom gutter-b bg-white border-0" >
							<div class="card-body">
								<div class="row">
									<div class="col-md-3">
										<label class="text-dark" >Pilih Pelanggan </label>
										<select class="js-example-basic-single js-states form-control bg-transparent" id="KodePelanggan" name="KodePelanggan">
											<option value="">Pilih Pelanggan</option>
											@foreach($pelanggan as $ko)
												<option value="{{ $ko->KodePelanggan }}">
                                                    {{ $ko->NamaPelanggan }}
                                                </option>
											@endforeach
										</select>
									</div>
									<div class="col-md-3">
										<label class="text-dark " >Pilih Sales </label>
										<select class="js-example-basic-single js-states form-control bg-transparent" id="KodeSales" name="KodeSales">
											<option value="">Pilih Sales</option>
											@foreach($sales as $ko)
												<option value="{{ $ko->KodeSales }}">
                                                    {{ $ko->NamaSales }}
                                                </option>
											@endforeach
										</select>
									</div>
									<div class="col-md-6" style="text-align: center;">
										<label class="text-dark" >Nomor Dokumen</label>
										<h2><div id="_NoTransaksi"></div></h2>
									</div>	
								</div>
								
							</div>	
						</div>
						<div class="card card-custom gutter-b bg-white border-0 table-contentpos">
							<div class="card-body" >
								<div class="form-group row mb-0">
									<div class="col-md-12">
										<label> <b>Hint</b> </label>
										<fieldset class="form-group mb-0 d-flex barcodeselection">
											<label> <font color="Red">F2</font> - Edit Qty Item Terakhir </label>
											<span style="margin: 0 10px;"> | </span>
											<label> <font color="Green">F3</font> - Tambah Diskon(%) Item Terakhir </label>
											<span style="margin: 0 10px;"> | </span>
											<label> <font color="blue">F4</font> - Tambah Diskon(Rp) Item Terakhir </label>
										</fieldset>
									</div>
									<div class="col-md-12">
										<fieldset class="form-group mb-0 d-flex barcodeselection">
											<label> <font color="#ae69f5">F5</font> - Bayar </label>
											<span style="margin: 0 10px;"> | </span>
											<label> <font color="#dc3545">DEL</font> - Batalkan Transaksi</label>
											<span style="margin: 0 10px;"> | </span>
											<label> <font color="#f49d2a">F6</font> - Simpan Sementara </label>
											<span style="margin: 0 10px;"> | </span>
											<label> <font color="red">F7</font> - Tambah Jasa </label>
										</fieldset>
									</div>
								</div>
							</div>
						</div>
						<div class="card card-custom gutter-b bg-white border-0 table-contentpos">
							<div class="card-body" >
								<div class="form-group row mb-0">
									<div class="col-md-8">
										<label >Select Product</label>
										<fieldset class="form-group mb-0 d-flex barcodeselection">
											<select class="form-control w-25" id="exampleFormControlSelect1">
												<option>Barcode / Nama / Kode</option>
											  </select>
											<input type="text" class="form-control border-dark" id="_Barcode" placeholder="Scan Barcode / Nama Item / Kode Item">
										</fieldset>
									</div>
									<div class="col-md-2">
										<label >Jumlah</label>
										<fieldset class="form-group mb-0 d-flex barcodeselection">
											<input type="number" class="form-control border-dark" id="_Qty" placeholder="" value="1">
										</fieldset>
									</div>
									<div class="col-md-2">
										<label >Diskon <span id="_TipeDiskon"></span></label>
										<fieldset class="form-group mb-0 d-flex barcodeselection">
											<input type="number" class="form-control border-dark" id="_Diskon" placeholder="" value="0">
										</fieldset>
									</div>
								</div>	
							</div>	
								<div class="table-datapos">
									<div class="dx-viewport demo-container">
					                	<div id="data-grid-demo">
					                  		<div id="gridContainerDetail"></div>
					                	</div>
					              	</div>
					              	<small style="color: red">Tekan Enter saat selesai edit data</small>
								</div>

						</div>	
					 </div>	
				 </div>
				 <div class="col-xl-3 col-lg-4 col-md-4">
					 <div class="card card-custom gutter-b bg-white border-0">
						<div class="card-body" >
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
							 <div class="d-flex justify-content-start align-items-center flex-column buttons-cash">
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
   </div>

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
						<h1>Total Bayar</h1>
					</th>
					<td class="border-0 justify-content-end d-flex text-primary font-size-lg font-size-bold px-0 font-size-lg mb-0 font-size-bold text-primary">
						<input type="hidden" name="_TotalTagihan" id="_TotalTagihan">
						<h1 id="_TotalTagihanFormated">Rp. </h1>
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
										<ul class="horizontal-list">

											@foreach($metodepembayaran as $ko)
												<li class="list-group-item list-group-item-action border-0 d-flex align-items-center justify-content-between py-2" StsPyment={{$ko->Active}} id={{ $ko->id }}>
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


<div class="modal fade text-left" id="LookupItem" tabindex="-1" role="dialog" aria-labelledby="LookupItem" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h3 class="modal-title" id="myModalLabel1444">Add Shipping Cost</h3>
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
                  		<div id="gridLookupItem"></div>
                	</div>
              	</div>
			</div>
			<hr>
			<div class="form-group row justify-content-end mb-0">
				<div class="col-md-6  text-end">
					<button type="button" class="btn btn-primary" id="btPilihLookupData">Pilih Data</button>
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
<!-- <script src="https://unpkg.com/multiple-select@1.5.2/dist/multiple-select.min.js"></script> -->
<!-- <script src="{{ asset('js/sweetalert.js')}}"></script> -->
<!-- <script src="{{ asset('js/sweetalert1.js')}}"></script> -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('js/script.bundle.js')}}"></script>
<link href="{{ asset('devexpress/dx.light.css')}}" rel="stylesheet" type="text/css" />
<script src="{{asset('devexpress/dx.all.js')}}"></script>
<script src="{{asset('api/select2/select2.min.js')}}"></script>
	
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
	var _KodeMetodePembayaran = -1;

	document.addEventListener('DOMContentLoaded', () => {
	    const listItems = document.querySelectorAll('.horizontal-list li');
	    console.log(listItems);
	    listItems.forEach(item => {
	        item.addEventListener('click', () => {
	            // Remove active class from all items
	            listItems.forEach(i => i.classList.remove('active'));

	            // Add active class to the clicked item
	            var Sts = $('#'+item.id).attr('stspyment');
	            if (Sts =='Y') {
	            	item.classList.add('active');
	            	_KodeMetodePembayaran = item.id;
	            	$('#JumlahBayar').val(0);
	            	$('#JumlahBayar').focus();
	            }
	        });
	    });
	    SetEnableCommand();
	});
	jQuery(function () {
		jQuery(document).ready(function() {
			$('#_Barcode').focus();
			bindGrid([]);

			var xdata = <?php echo $itemServices ?>;
			console.log(xdata);

			jQuery('.Select2-Selector').select2({
				dropdownParent: $('#shippingcost')
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

	    	LoadDraftOrderList();

	    	jQuery('#_NoTransaksi').text("<OTOMATIS>");
		});



		$('#_Barcode').on("keypress", function(e) {
			console.log(e)
	        if (e.keyCode == 13) {
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
		                'Scan'		: jQuery('#_Barcode').val(),
		                'TipeItemIN' : '1,3'
		            },
		            dataType: 'json',
		            success: function(response) {
		            	// console.log(response);
		            	var dataGridInstance = jQuery('#gridContainerDetail').dxDataGrid('instance');
      					var allRowsData  = dataGridInstance.getDataSource().items();

		            	if (response.data.length > 1) {
		            		bindGridLookup(response.data);
		            		jQuery('#LookupItem').modal({backdrop: 'static', keyboard: false})
		            		jQuery('#LookupItem').modal('show');


		            	}
		            	else{
		            		if (response.data.length > 0) {
		            			var objIndex = allRowsData.findIndex(obj => obj.KodeItem == response.data[0]['KodeItem']);

			            		// console.log(objIndex);
			            		// console.log(allRowsData)
			            		if (objIndex != -1) {
			            			var oDiskon = CalculateDiskon(response.data[0]['KodeItem'],1);

			            			allRowsData[objIndex].DiskonPersen = (oDiskon.DiskonType) == 'P' ? oDiskon.Diskon : 0;
			            			allRowsData[objIndex].DiskonRp = (oDiskon.DiskonType) == 'N' ? oDiskon.Diskon : 0;

			            			if (_DiskonGrupCustomer > 0) {
								    	allRowsData[objIndex].DiskonPersen += _DiskonGrupCustomer;
								    }

			            			allRowsData[objIndex].Qty = allRowsData[objIndex].Qty + 1;

			            			bindGrid(allRowsData);
			            			dataGridInstance.refresh();
			            		}
			            		else{
			            			var dataSource = dataGridInstance.getDataSource();
			            			var oDiskon = CalculateDiskon(response.data[0]['KodeItem'],1);
			            			var Diskoncust = 0;

			            			if (_DiskonGrupCustomer > 0) {
								    	Diskoncust = _DiskonGrupCustomer;
								    }
			            			var item = {
				            			'LineNumber' 	: allRowsData.length +1,
				            			'KodeItem' 	 	: response.data[0]['KodeItem'],
				            			'NamaItem'	 	: response.data[0]['NamaItem'],
				            			'Qty'	 	 	: 1,
				            			'QtyKonversi'	: response.data[0]['QtyKonversi'],
				            			'Satuan'		: response.data[0]['Satuan'],
				            			'Harga' 	 	: response.data[0]['HargaJual'],
				            			'DiskonPersen' 	: ((oDiskon.DiskonType) == 'P' ? oDiskon.Diskon : 0) + Diskoncust,
				            			'DiskonRp' 	 	: (oDiskon.DiskonType) == 'N' ? oDiskon.Diskon : 0,
				            			'Total' 	 	: 0
				            		}

				            		dataSource.store().insert(item).then(function() {
								        dataSource.reload();
								    })

				     //        		dataGridInstance.option("dataSource", [...dataGridInstance.option("dataSource"), item]);
									// dataGridInstance.refresh();
			            		}
			            		_LastInputed = response.data[0]['KodeItem'];
		            		}
		            		else{
		            			Swal.fire({
			                      icon: "error",
			                      title: "Error",
			                      text: "Data Tidak ditemukan",
			                    }).then((result) => {
								  // location.reload();
								  $('#_Barcode').val("")
								  // $('#_Barcode').focus()
								});	
		            		}

		            	}

		            	CalculateTotal();
		            }
		        });
	        }
		});

		$('#_Barcode').on("keydown", function(e) {
			if (e.keyCode == 113) { //Qty
				e.preventDefault();
	        	// console.log('F2')

	        	if (_LastInputed != "") {
	        		$('#_Qty').focus();
	        		$('#_Qty').select();
	        	}
	        }
	        else if (e.keyCode == 114) { // Diskon %
	        	e.preventDefault();
	        	// console.log('F3')
	        	if (_LastInputed != "") {
	        		$('#_Diskon').focus();
	        		$('#_Diskon').select();

	        		$('#_TipeDiskon').text(" (%)");
	        		_TipeDiskon = "%";
	        	}
	        }
	        else if (e.keyCode == 115) { // Diskon RP
	        	e.preventDefault();
	        	// console.log('F4')
	        	if (_LastInputed != "") {
	        		$('#_Diskon').focus();
	        		$('#_Diskon').select();

	        		$('#_TipeDiskon').text(" (Rp)");
	        		_TipeDiskon = "Rp";
	        	}
	        }

		});

		$('#_Qty').on("keypress", function(e) {
			var dataGridInstance = jQuery('#gridContainerDetail').dxDataGrid('instance');
      		var allRowsData  = dataGridInstance.getDataSource().items();

			if (e.keyCode == 13) {
				var objIndex = allRowsData.findIndex(obj => obj.KodeItem == _LastInputed);

        		// console.log(objIndex);
        		// console.log(allRowsData)
        		if (objIndex != -1) {
        			var oDiskon = CalculateDiskon(_LastInputed,$('#_Qty').val());
        			allRowsData[objIndex].DiskonPersen = (oDiskon.DiskonType) == 'P' ? oDiskon.Diskon : 0;
        			allRowsData[objIndex].DiskonRp = (oDiskon.DiskonType) == 'N' ? oDiskon.Diskon : 0;
        			console.log(_DiskonGrupCustomer);

        			if (_DiskonGrupCustomer > 0) {
				    	allRowsData[objIndex].DiskonPersen += _DiskonGrupCustomer;
				    }

        			allRowsData[objIndex].Qty = parseFloat($('#_Qty').val());

        			bindGrid(allRowsData);
        			dataGridInstance.refresh();

        			$('#_Qty').val(1);
        			$('#_Barcode').focus();
        		}

        		CalculateTotal();
			}
		});

		$('#_Diskon').on("keypress", function(e) {
			var dataGridInstance = jQuery('#gridContainerDetail').dxDataGrid('instance');
      		var allRowsData  = dataGridInstance.getDataSource().items();

			if (e.keyCode == 13) {
				var objIndex = allRowsData.findIndex(obj => obj.KodeItem == _LastInputed);

        		// console.log(objIndex);
        		// console.log(allRowsData)
        		if (objIndex != -1) {
        			if (_TipeDiskon == "%" && allRowsData[objIndex].DiskonRp == 0) {
        				allRowsData[objIndex].DiskonPersen = parseFloat($('#_Diskon').val());
        			}
        			else if (_TipeDiskon == "Rp" && allRowsData[objIndex].DiskonPersen == 0) {
        				allRowsData[objIndex].DiskonRp = parseFloat($('#_Diskon').val());
        			}

        			bindGrid(allRowsData);
        			dataGridInstance.refresh();

        			$('#_Diskon').val(0);
        			$('#_Diskon').focus();
        		}

        		CalculateTotal();
			}
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
		});

		$('#btSimpanPembayaran').click(function () {
			SaveData('C',$('#btSimpanPembayaran'),'Submit');
		});
	});

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
				'TipeItemIN' : '1,3'
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
	function bindGrid(data) {
		var dataGridInstance = jQuery("#gridContainerDetail").dxDataGrid({
			allowColumnResizing: true,
			dataSource: data,
			keyExpr: "LineNumber",
			showBorders: true,
            allowColumnResizing: true,
            columnAutoWidth: true,
            showBorders: true,
            paging: {
                enabled: false,
                pageSize: 30
            },
            editing: {
                mode: "row",
                // allowAdding:true,
                allowUpdating: true,
                allowDeleting: true,
                texts: {
                    confirmDeleteMessage: ''  
                }
            },
            columns: [
            	{
                    dataField: "LineNumber",
                    caption: "#",
                    allowSorting: false,
                    visible:false,
                },
                {
                    dataField: "KodeItem",
                    caption: "Item",
				    allowSorting: false,
				    allowEditing:false,
				    visible:false
                },
                {
                    dataField: "NamaItem",
                    caption: "Item",
				    allowSorting: false,
				    allowEditing:false,
                },
                {
                    dataField: "Qty",
                    caption: "Qty",
				    allowSorting: false,
				    allowEditing:true,
				    format: { type: 'fixedPoint', precision: 2 },
                },
                {
                    dataField: "QtyKonversi",
                    caption: "QtyKonversi",
				    allowSorting: false,
				    allowEditing:true,
				    format: { type: 'fixedPoint', precision: 2 },
				    visible:false
                },
                {
                    dataField: "Satuan",
                    caption: "#",
				    allowSorting: false,
				    allowEditing:false,
                },
                {
                    dataField: "Harga",
                    caption: "Harga",
				    allowSorting: false,
				    allowEditing:false,
				    format: { type: 'fixedPoint', precision: 2 },
                },
                {
                    dataField: "DiskonPersen",
                    caption: "Diskon(%)",
				    allowSorting: false,
				    allowEditing:true,
				    format: { type: 'fixedPoint', precision: 2 },
                },
                {
                    dataField: "DiskonRp",
                    caption: "Diskon(Rp)",
				    allowSorting: false,
				    allowEditing:true,
				    format: { type: 'fixedPoint', precision: 2 },
                },
                {
                    dataField: "Total",
                    caption: "Total",
				    allowSorting: false,
				    allowEditing:false,
				    format: { type: 'fixedPoint', precision: 2 },
				    calculateCellValue:function (rowData) {
                    	var HargaNet = 0;
                    	var HargaGross = 0;

                    	if (rowData.DiskonPersen > 0) {
                    		HargaGross = rowData.Qty * rowData.Harga;
                    		var diskon = HargaGross * rowData.DiskonPersen / 100;
                    		HargaNet = HargaGross - diskon;
                    	}
                    	else if (rowData.DiskonRp > 0) {
                    		HargaGross = rowData.Qty * rowData.Harga;
                    		HargaNet = HargaGross - rowData.DiskonRp;
                    	}
                    	else{
                    		HargaNet = rowData.Qty * rowData.Harga;
                    		HargaGross = rowData.Qty * rowData.Harga;
                    	}

                    	return HargaNet
                    },
                },
            ],
            onCellClick:function (e) {
	        	// console.log(dataGridInstance.option("dataSource"))
	            var rowData = dataGridInstance.option("dataSource");
	            var columnIndex = e.columnIndex;
	            // console.log(e)
	        	if (columnIndex >= 1 && columnIndex <= 5) {
	                dataGridInstance.editRow(e.rowIndex)	
	            }
	            dataGridInstance.option("focusedColumnIndex", columnIndex);	
	        },
	        onEditorPreparing: function(e) {
                if (e.parentType === 'dataRow' && e.dataField === 'DiskonRp') {
                    if (e.row.data.DiskonPersen > 0) {
                        e.editorOptions.disabled = true;
                    }
                    else if (e.row.data.DiskonRp > 0) {
                    	e.editorOptions.disabled = true;
                    }
                }
            },
            onRowRemoved: function(e) {
		        CalculateTotal();
		    }
		}).dxDataGrid('instance');

		dataGridInstance.on('rowUpdated', function(e) {
    		// console.log(e)
    		CalculateTotal();
    	})
	}
	
	function SaveData(Status, ButonObject, ButtonDefaultText) {
		ButonObject.text('Tunggu Sebentar.....');
  		ButonObject.attr('disabled',true);

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
  				var oItemMaster = GetItemInfo(allRowsData[i]['KodeItem']);
  				var oDisk = 0;

  				if (allRowsData[i]['DiskonPersen'] > 0) {
  					oDisk += (allRowsData[i]['Qty'] * allRowsData[i]['Harga']) * allRowsData[i]['DiskonPersen'] / 100;
  				}

  				if (allRowsData[i]['DiskonRp'] > 0) {
  					oDisk += allRowsData[i]['DiskonRp'];
  				}

  				console.log(oItemMaster[0].Satuan);

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
			'TotalPembelian' : jQuery('#_GrandTotal').attr("originalvalue"),
			'TotalRetur' : 0,
			'TotalPembayaran' : (Status) == 'T' ? 0 : jQuery('#JumlahBayar').attr("originalvalue"),
			'Status' : Status,
			'Keterangan' : '',
			'MetodeBayar' : _KodeMetodePembayaran,
			'ReffPembayaran' : $('#NomorRefrensiPembayaran').val(),
			'Detail' : oDetail
		}

		// Save Data

		$.ajax({
			async:false,
			url: (NoTransaksi) == "" ? "{{route('fpenjualan-retailPos')}}" : "{{route('fpenjualan-editJson')}}",
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
		var dataGridInstance = jQuery('#gridContainerDetail').dxDataGrid('instance');
  		var allRowsData  = dataGridInstance.getDataSource().items();
  		// console.log(allRowsData)

  		var _tempTotalItem = 0;
  		var _tempSubTotal = 0;
  		var _tempTotalDiskon = 0;
  		var _tempTotalTax = 0;
  		var _tempTotalServices = 0;
  		var _tempGrandTotal = 0;

  		dataGridInstance.getDataSource().store().load().done(function (data) {
  			_tempTotalItem = data.length;
	        for (var i = 0; i < data.length; i++) {
	        	console.log(data[i]['Diskon'])
	        	var _Total = data[i]['Qty'] * data[i]['Harga'];
      			_tempSubTotal += _Total;
      			if (data[i]['DiskonPersen'] > 0) {
      				_tempTotalDiskon += data[i]['Qty'] * data[i]['Harga'] * (data[i]['DiskonPersen'] / 100);
      				// console.log(_TotalDiskon)
      			}
      			else if (data[i]['DiskonRp'] > 0) {
      				_tempTotalDiskon += data[i]['DiskonRp'];
      			}
      		}
	    });

	    // Jasa
	    for (var i = 0; i < _ServicesData.length; i++) {
	    	_tempTotalServices += parseFloat(_ServicesData[i]['Jumlah']);
	    }

	    // Diskon Grup Customer

	    formatCurrency($('#_TotalItem'), _tempTotalItem);
	    formatCurrency($('#_SubTotal'), _tempSubTotal);
	    formatCurrency($('#_TotalDiskon'), _tempTotalDiskon);
	    formatCurrency($('#_TotalServices'), _tempTotalServices);
	    formatCurrency($('#_GrandTotal'), _tempSubTotal + _tempTotalServices - _tempTotalDiskon);

  		// $('#_TotalItem').text(_tempTotalItem);
  		// $('#_SubTotal').text(_tempSubTotal);
  		// $('#_GrandTotal').text(_tempSubTotal - _tempTotalDiskon);

  		$('#_Barcode').val('');
  		$('#_Barcode').focus();
	}


	function SetEnableCommand() {
    	var ErrorCount = 0;

    	if ($('#JumlahBayar').attr('originalvalue') == 0) {
    		ErrorCount +=1;
    	}

    	if (_KodeMetodePembayaran == -1) {
    		ErrorCount +=1;	
    	}

    	// if ($('#JumlahBayar').attr('originalvalue') < $('#_TotalTagihan').val()) {
    	// 	ErrorCount +=1;
    	// }

    	if (ErrorCount >0) {
    		$('#btSimpanPembayaran').attr('disabled',true);
    	}
    	else{
    		$('#btSimpanPembayaran').attr('disabled',false);
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