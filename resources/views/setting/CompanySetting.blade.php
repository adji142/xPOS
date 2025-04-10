@extends('parts.header')
	
@section('content')
<style type="text/css">
	.xContainer{
	  display: flex;
	  flex-wrap: wrap;
	  justify-content: center;
	  align-items: center;
	  vertical-align: middle;
	}
	.image_result{
	  display: flex;
	  justify-content: center;
	  align-items: center;
	  border: 1px solid black;
	  /*flex-grow: 1;*/
	  vertical-align: middle;
	  align-content: center;
	  flex-basis: 200;
	  width: 150px;
	  height: 200px;
	}
	.image_result img {
	  max-width: 100%; /* Fit the image to the container width */
	  height: 100%; /* Maintain the aspect ratio */
	}

	.image_result_sample{
	  display: flex;
	  justify-content: center;
	  align-items: center;
	  border: 1px solid black;
	  /*flex-grow: 1;*/
	  vertical-align: middle;
	  align-content: center;
	  flex-basis: 200;
	  width: 100%;
	  height: 150px;
	}
	.image_result_sample img {
	  max-width: 100%; /* Fit the image to the container width */
	  height: 100%; /* Maintain the aspect ratio */
	}
	.enableFileControl{
		display: inline!important;
	}
	#isPostingAkutansi[readonly] {
		pointer-events: none;
		touch-action: none;
		background-color: #e9ecef;
		color: #495057;
	}
	.disabled {
		pointer-events: none;
		color: gray;
		cursor: default;
		text-decoration: none;
	}
  </style>
<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">
					<a href="{{route('companysetting')}}">Setting Data Perusahaan</a>
				</li>
			</ol>
		</nav>
	</div>
</div>
<!--end::Subheader-->
<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
	<!--begin::Container-->
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 px-4">
				<div class="row">
					<div class="col-lg-12 col-xl-12 px-4">
						<div class="card card-custom gutter-b bg-transparent shadow-none border-0" >
							<div class="card-header align-items-center  border-bottom-dark px-0">
								<div class="card-title mb-0">
									<h3 class="card-label mb-0 font-weight-bold text-body">
										Setting Data perusahaan
									</h3>
								</div>
							</div>
						
						</div>


					</div>
				</div>

				<div class="row">
					<div class="col-12  px-4">
						<div class="card card-custom gutter-b bg-white border-0" >
							<div class="card-body" >
								<form action="{{route('companysetting-edit')}}" method="post" id="formCompanySetting">	
									@csrf
									<div class="row">
										<div class="col-md-3">
											<ul class="nav flex-column nav-pills mb-3" id="v-pills-tab1" role="tablist" aria-orientation="vertical">
												@if ($company[0]['isActive'] == 0)
													<li class="nav-item" >
														<a class="nav-link active" id="general-tab2" data-bs-toggle="pill" href="#general" role="tab" aria-controls="general" aria-selected="true">General</a>
													</li>
													<li class="nav-item" >
														<a class="nav-link disabled" id="inv-tab" data-bs-toggle="pill" href="#inv" role="tab" aria-controls="inv" aria-selected="false">Inventory</a>
													</li>
													<li class="nav-item" >
														<a class="nav-link disabled" id="printer-tab" data-bs-toggle="pill" href="#printer" role="tab" aria-controls="printer" aria-selected="false">Printer</a>
													</li>
													<li class="nav-item" >
														<a class="nav-link disabled" id="ecatalog-tab" data-bs-toggle="pill" href="#ecatalog" role="tab" aria-controls="ecatalog" aria-selected="false">E-Catalog</a>
													</li>
													<li class="nav-item" >
														<a class="nav-link disabled" id="bulkaction-tab" data-bs-toggle="pill" href="#bulkaction" role="tab" aria-controls="bulkaction" aria-selected="false">Import Data</a>
													</li>
													<li class="nav-item" >
														<a class="nav-link" id="invoice-tab" data-bs-toggle="pill" href="#invoice" role="tab" aria-controls="invoice" aria-selected="false">Tagihan</a>
													</li>
													<li class="nav-item" >
														<a class="nav-link disabled" id="custdisplay-tab" data-bs-toggle="pill" href="#custdisplay" role="tab" aria-controls="custdisplay" aria-selected="false">Customer Display</a>
													</li>
													
													@if ($company[0]['JenisUsaha'] == "Hiburan")
													<li class="nav-item" >
														<a class="nav-link disabled" id="hiburan-tab" data-bs-toggle="pill" href="#hiburan" role="tab" aria-controls="hiburan" aria-selected="false">Hiburan</a>
													</li>
													@endif
													@if ($company[0]['JenisUsaha'] == "Hiburan")
													<li class="nav-item" >
														<a class="nav-link" id="booking-tab" data-bs-toggle="pill" href="#booking" role="tab" aria-controls="booking" aria-selected="false">Booking Online</a>
													</li>
													@endif
												@else
													<li class="nav-item" >
														<a class="nav-link active" id="general-tab2" data-bs-toggle="pill" href=" #general" role="tab" aria-controls="general" aria-selected="true">General</a>
													</li>
													<li class="nav-item" >
														<a class="nav-link" id="inv-tab" data-bs-toggle="pill" href="#inv" role="tab" aria-controls="inv" aria-selected="false">Inventory</a>
													</li>
													<li class="nav-item" >
														<a class="nav-link" id="printer-tab" data-bs-toggle="pill" href="#printer" role="tab" aria-controls="printer" aria-selected="false">Printer</a>
													</li>
													<li class="nav-item" >
														<a class="nav-link" id="ecatalog-tab" data-bs-toggle="pill" href="#ecatalog" role="tab" aria-controls="ecatalog" aria-selected="false">E-Catalog</a>
													</li>
													<li class="nav-item" >
														<a class="nav-link" id="bulkaction-tab" data-bs-toggle="pill" href="#bulkaction" role="tab" aria-controls="bulkaction" aria-selected="false">Import Data</a>
													</li>
													<li class="nav-item" >
														<a class="nav-link" id="invoice-tab" data-bs-toggle="pill" href="#invoice" role="tab" aria-controls="invoice" aria-selected="false">Tagihan</a>
													</li>
													<li class="nav-item" >
														<a class="nav-link" id="custdisplay-tab" data-bs-toggle="pill" href="#custdisplay" role="tab" aria-controls="custdisplay" aria-selected="false">Customer Display</a>
													</li>
													@if ($company[0]['JenisUsaha'] == "Hiburan")
													<li class="nav-item" >
														<a class="nav-link" id="hiburan-tab" data-bs-toggle="pill" href="#hiburan" role="tab" aria-controls="hiburan" aria-selected="false">Hiburan</a>
													</li>
													@endif
													@if ($company[0]['JenisUsaha'] == "Hiburan")
													<li class="nav-item" >
														<a class="nav-link" id="booking-tab" data-bs-toggle="pill" href="#booking" role="tab" aria-controls="booking" aria-selected="false">Booking Online</a>
													</li>
													@endif
												@endif
											</ul>
										</div>
										<div class="col-md-9">
											<div class="tab-content" id="v-pills-tabContent1">
												<div class="tab-pane fade show active" id="general" role="tabpanel" >
													<div class="form-group row">

														<div class="col-md-12"> 
															<fieldset class="form-group mb-3">
																<textarea id = "image_base64" name = "image_base64" style="display: none;"> {{ count($company) > 0 ? $company[0]['icon'] : '' }} </textarea>
																
																<input type="file" id="Attachment" name="Attachment" accept=".jpg" class="btn btn-warning" style="display: none;"/>
																<div class="xContainer">
																	<div id="image_result" class="image_result">
																		@if (count($company) > 0)
																			<img src=" {{$company[0]['icon']}} ">
																		@else
																			<img src="https://www.generationsforpeace.org/wp-content/uploads/2018/03/empty.jpg">
																		@endif
																	</div>
																</div>
															</fieldset>
															
														</div>

														<div class="col-md-3">
					                            			<label  class="text-body">Kode Perusahaan</label>
					                            			<fieldset class="form-group mb-3">
					                            				<input type="text" class="form-control" id="KodePartner" name="KodePartner" placeholder="Masukan Kode KelompokRekening" value="{{ count($company) > 0 ? $company[0]['KodePartner'] : '' }}"  readonly="" >
					                            			</fieldset>
					                            			
					                            		</div>

					                            		<div class="col-md-9">
					                            			<label  class="text-body">Nama Perusahaan</label>
					                            			<fieldset class="form-group mb-3">
					                            				<input type="text" class="form-control" id="NamaPartner" name="NamaPartner" placeholder="Masukan Nama Perusahaan" value="{{ count($company) > 0 ? $company[0]['NamaPartner'] : '' }}"  >
					                            			</fieldset>
					                            			
					                            		</div>

					                            		<div class="col-md-12">
					                            			<label  class="text-body">Jenis Usaha</label>
					                            			<fieldset class="form-group mb-3">
					                            				<select name="JenisUsaha" id="JenisUsaha" class="js-example-basic-single js-states form-control bg-transparent">
					                            					<option value="" {{ count($company) > 0 ? $company[0]['JenisUsaha'] == '' ? 'selected' : '' : '' }}>Pilih Jenis Usaha</option>
					                            					<option value="Retail" {{ count($company) > 0 ? $company[0]['JenisUsaha'] == 'Retail' ? 'selected' : '' : '' }}>Retail</option>
					                            					<option value="FnB" {{ count($company) > 0 ? $company[0]['JenisUsaha'] == 'FnB' ? 'selected' : '' : '' }}>Food and Beverage</option>
					                            					<option value="Hiburan" {{ count($company) > 0 ? $company[0]['JenisUsaha'] == 'Hiburan' ? 'selected' : '' : '' }}>Hiburan</option>
					                            				</select>
					                            			</fieldset>
					                            			
					                            		</div>

					                            		<div class="col-md-12">
					                            			<label  class="text-body">Alamat</label>
					                            			<fieldset class="form-group mb-12">
					                            				<textarea class="form-control" id="AlamatTagihan" name="AlamatTagihan" rows="3" placeholder="Masukan Alamat">{{ count($company) > 0 ? $company[0]['AlamatTagihan'] : '' }}</textarea>
					                            			</fieldset>
					                            		</div>

					                            		<div class="col-md-6">
					                            			<label  class="text-body">Telepon</label>
					                            			<fieldset class="form-group mb-3">
					                            				<input type="text" class="form-control" id="NoTlp" name="NoTlp" placeholder="Masukan Nomor Telephone" value="{{ count($company) > 0 ? $company[0]['NoTlp'] : '' }}"  >
					                            			</fieldset>
					                            			
					                            		</div>

					                            		<div class="col-md-6">
					                            			<label  class="text-body">No. HP</label>
					                            			<fieldset class="form-group mb-3">
					                            				<input type="text" class="form-control" id="NoHP" name="NoHP" placeholder="Masukan Nomor Handphone" value="{{ count($company) > 0 ? $company[0]['NoHP'] : '' }}"  >
					                            			</fieldset>
					                            			
					                            		</div>

					                            		<div class="col-md-6">
					                            			<label  class="text-body">Tgl. Mulai Berlangganan</label>
					                            			<fieldset class="form-group mb-3">
					                            				<input type="date" class="form-control" id="StartSubs" name="StartSubs" placeholder="Masukan Nomor Handphone" value="{{ count($company) > 0 ? $company[0]['StartSubs'] : '' }}" readonly="" >
					                            			</fieldset>
					                            			
					                            		</div>

					                            		<div class="col-md-6">
					                            			<label  class="text-body">Tgl. Selesai Berlangganan</label>
					                            			<fieldset class="form-group mb-3">
					                            				<input type="date" class="form-control" id="EndSubs" name="EndSubs" placeholder="Masukan Nomor Handphone" value="{{ count($company) > 0 ? $company[0]['EndSubs'] : '' }}" readonly="" >
					                            			</fieldset>
					                            			
					                            		</div>

					                            		<div class="col-md-6">
					                            			<label  class="text-body">NPWP</label>
					                            			<fieldset class="form-group mb-3">
					                            				<input type="text" class="form-control" id="NPWP" name="NPWP" placeholder="Masukan Nomor NPWP" value="{{ count($company) > 0 ? $company[0]['NPWP'] : '' }}">
					                            			</fieldset>
					                            			
					                            		</div>

					                            		<div class="col-md-6">
					                            			<label  class="text-body">Tanggal PKP</label>
					                            			<?php echo $company[0]['TglPKP']; ?>
					                            			<fieldset class="form-group mb-3">
					                            				<input type="date" class="form-control" id="TglPKP" name="TglPKP" placeholder="Masukan Nomor Handphone" value="{{ count($company) > 0 ? $company[0]['TglPKP'] : '2000-01-01' }}" >
					                            			</fieldset>
					                            			
					                            		</div>

					                            		<div class="col-md-6">
					                            			<label  class="text-body">PPN</label>
					                            			<fieldset class="form-group mb-3">
					                            				<input type="number" class="form-control" id="PPN" name="PPN" placeholder="Masukan Nomor Handphone" value="{{ count($company) > 0 ? $company[0]['PPN'] : 0 }}" >
					                            			</fieldset>
					                            			<label for="isHargaJualIncludePPN">Harga Jual Sudah Termasuk PPN</label>
					                            			<input type="checkbox" class="checkbox-input" id="isHargaJualIncludePPN" {{ count($company) > 0 ? $company[0]['isHargaJualIncludePPN'] == 1 ? 'checked' : '' : '' }}>
					                            			
					                            		</div>

					                            		<div class="col-md-6">
					                            			<label  class="text-body">Posting Akutansi ?</label>
					                            			<fieldset class="form-group mb-3">
					                            				<select name="isPostingAkutansi" id="isPostingAkutansi" class="js-states form-control bg-transparent" readonly>
					                            					<option value="0" {{ count($company) > 0 ? $company[0]['isPostingAkutansi'] == 0 ? 'selected' : '' : '' }} >Tidak</option>
					                            					<option value="1" {{ count($company) > 0 ? $company[0]['isPostingAkutansi'] == 1 ? 'selected' : '' : '' }}>Ya</option>
					                            				</select>
					                            			</fieldset>
					                            			
					                            		</div>
													</div>
												</div>

												<div class="tab-pane fade " id="inv" role="tabpanel" aria-labelledby="inv-tab">
													<div class="form-group row">
														<div class="col-md-12">
					                            			<label  class="text-body">Default Gudang Penjualan PoS</label>
					                            			<fieldset class="form-group mb-3">
					                            				<select name="GudangPoS" id="GudangPoS" class="js-example-basic-single js-states form-control bg-transparent">
																	<option value="">Pilih Gudang</option>
																	@foreach($gudang as $ko)
																		<option value="{{ $ko->KodeGudang }}" {{ $ko->KodeGudang == (count($company) > 0 ? $company[0]['GudangPoS'] : '') ? 'selected' : '' }}>
								                                            {{ $ko->NamaGudang }}
								                                        </option>
																	@endforeach
																</select>
					                            			</fieldset>
					                            		</div>

					                            		<div class="col-md-12">
					                            			<label  class="text-body">Default Termin PoS</label>
					                            			<fieldset class="form-group mb-3">
					                            				<select name="TerminBayarPoS" id="TerminBayarPoS" class="js-example-basic-single js-states form-control bg-transparent">
																	<option value="">Pilih Termin</option>
																	@foreach($temin as $ko)
																		<option value="{{ $ko->id }}" {{ $ko->id == (count($company) > 0 ? $company[0]['TerminBayarPoS'] : '') ? 'selected' : '' }}>
								                                            {{ $ko->NamaTermin }}
								                                        </option>
																	@endforeach
																</select>
					                            			</fieldset>
					                            		</div>

					                            		<div class="col-md-12">
					                            			<label  class="text-body">Izinkan Inventory Menjadi Negative (-) ?</label>
					                            			<fieldset class="form-group mb-3">
					                            				<select name="AllowNegativeInventory" id="AllowNegativeInventory" class="js-example-basic-single js-states form-control bg-transparent">
																	<option value="N" {{ count($company) > 0 ? $company[0]['AllowNegativeInventory'] == 'N' ? 'selected' : '' : '' }}>TIDAK</option>
																	<option value="Y" {{ count($company) > 0 ? $company[0]['AllowNegativeInventory'] == 'Y' ? 'selected' : '' : '' }}>YA</option>
																</select>
					                            			</fieldset>
					                            		</div>

													</div>
												</div>

												<div class="tab-pane fade " id="printer" role="tabpanel" aria-labelledby="printer-tab">
													<div class="form-group row">
														<div class="col-md-4">
					                            			<label  class="text-body">Printer Register</label>
					                            			<fieldset class="form-group mb-4">
					                            				<select name="NamaPosPrinter" id="NamaPosPrinter" class="js-example-basic-single js-states form-control bg-transparent">
					                            					<option value="-1">Pilih Printer</option>
																	@foreach($printer as $ko)
																		<option {{ count($company) > 0 ? $company[0]['NamaPosPrinter'] == $ko->DeviceAddress ? "selected" : '' :""}} value="{{ $ko->DeviceAddress }}">
					                                                        {{ $ko->NamaPrinter. ' > '. $ko->PrinterInterface }}
					                                                    </option>
																	@endforeach
					                            				</select>
					                            			</fieldset>
					                            			
					                            		</div>

					                            		<div class="col-md-3">
					                            			<label  class="text-body">Lebar Kertas</label>
					                            			<fieldset class="form-group mb-3">
					                            				<select name="LebarKertas" id="LebarKertas" class="js-example-basic-single js-states form-control bg-transparent">
					                            					<option value="48">48</option>
					                            					<option value="58">58</option>
					                            					<option value="80">80</option>
					                            				</select>
					                            			</fieldset>
					                            		</div>
														<!--
					                            		<div class="col-md-3">
					                            			<fieldset class="form-group mb-3">
					                            				<button type="button" class="btn btn-warning">Test Print</button>
					                            			</fieldset>
					                            		</div>
					                            		<div class="col-md-3">
					                            			<fieldset class="form-group mb-3">
					                            				<button type="button" class="btn btn-warning" id="testPrintUSB">Test Print Usb</button>
					                            			</fieldset>
					                            		</div> -->

					                            		<!-- <a href="{{ url('companysetting/testprint') }}">Test Print</a> -->
					                            		<div class="col-md-12">
					                            			<label  class="text-body">Keterangan Footer</label>
					                            			<fieldset class="form-group mb-12">
					                            				<textarea class="form-control" id="FooterNota" name="FooterNota" rows="3" placeholder="Masukan Alamat">{{ count($company) > 0 ? $company[0]['FooterNota'] : '' }}</textarea>
					                            			</fieldset>
					                            		</div>

														<div class="col-md-4">
					                            			<label  class="text-body">Format Faktur</label>
					                            			<fieldset class="form-group mb-3">
					                            				<select name="DefaultSlip" id="DefaultSlip" class="js-example-basic-single js-states form-control bg-transparent">
					                            					<option value="slip1" {{ count($company) > 0 ? $company[0]['DefaultSlip'] == "slip1"? "selected" : '' :""}} >Slip 1</option>
					                            					<option value="slip2" {{ count($company) > 0 ? $company[0]['DefaultSlip'] == "slip2"? "selected" : '' :""}} >Slip 2</option>
					                            					<option value="slip3" {{ count($company) > 0 ? $company[0]['DefaultSlip'] == "slip3"? "selected" : '' :""}} >Slip 3</option>
					                            				</select>
					                            			</fieldset>
					                            		</div>

														<div class="col-md-8">
															<label  class="text-body">Preview</label>
															<fieldset class="form-group mb-3">
																<img src="#" id="PreviewImageSlip" width="100%">
															</fieldset>
														</div>

													</div>
												</div>

												<div class="tab-pane fade " id="ecatalog" role="tabpanel" aria-labelledby="ecatalog-tab">
													<div class="form-group row">
														<div class="accordion" id="accordionExample">
															<div class="accordion-item">
																<h2 class="accordion-header" id="headingOne">
																	<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
																		Banner #1
																	</button>
																</h2>
																<div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
																	<div class="accordion-body">
																		<div class="col-sm-12">
																			<label  class="text-body">Sample Banner Pertama</label>
																			<fieldset class="form-group mb-3">
																				<img src="{{asset('images/sample/Page1.png')}}" width="100%">
																			</fieldset>
																		</div>
																		<div class="col-sm-12">
																			<label  class="text-body">Banner Header</label>
																			<fieldset class="form-group mb-3">
																				<div id="BannerHeader1">
																					{!! count($company) > 0 ? $company[0]['BannerHeader1'] : '' !!}
																				</div>
																			</fieldset>
																		</div>
				
																		<div class="col-sm-12">
																			<label  class="text-body">Banner Text</label>
																			<fieldset class="form-group mb-3">
																				{{-- <input type="text" class="form-control" id="BannerText1" name="BannerText1" placeholder="Masukan Banner Text" value="{{ count($company) > 0 ? $company[0]['BannerText1'] : '' }}"  > --}}
																				<div id="BannerText1">
																					{!! count($company) > 0 ? $company[0]['BannerText1'] : '' !!}
																				</div>
																			</fieldset>
																		</div>
				
																		<div class="col-sm-12">
																			<label  class="text-body">Banner Image</label>
																			<fieldset class="form-group mb-3">
																				<textarea id = "Banner1Base64" name = "Banner1Base64" style="display: none;"> {{ count($company) > 0 ? $company[0]['Banner1'] : '' }} </textarea>
																				
																				<input type="file" id="fileBanner1" name="fileBanner1" accept=".jpg, .png" class="btn btn-warning" style="display: none;"/>
																				<div class="xContainer">
																					<div id="Banner1" class="image_result_sample">
																						@if (count($company) > 0)
																							<img src=" {{$company[0]['Banner1']}} ">
																						@else
																							<img src="https://www.generationsforpeace.org/wp-content/uploads/2018/03/empty.jpg">
																						@endif
																					</div>
																				</div>
																			</fieldset>
																		</div>
																	</div>
																</div>
															</div>

															<div class="accordion-item">
																<h2 class="accordion-header" id="headingTwo">
																	<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
																		Banner #2
																	</button>
																</h2>
																<div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
																	<div class="accordion-body">
																		<div class="col-sm-12">
																			<label  class="text-body">Sample Banner</label>
																			<fieldset class="form-group mb-3">
																				<img src="{{asset('images/sample/Page2.png')}}" width="100%">
																			</fieldset>
																		</div>
																		<div class="col-sm-12">
																			<label  class="text-body">Banner Header</label>
																			<fieldset class="form-group mb-3">
																				<div id="BannerHeader2">
																					{!! count($company) > 0 ? $company[0]['BannerHeader2'] : '' !!}
																				</div>
																			</fieldset>
																		</div>
				
																		<div class="col-sm-12">
																			<label  class="text-body">Banner Text</label>
																			<fieldset class="form-group mb-3">
																				<div id="BannerText2">
																					{!! count($company) > 0 ? $company[0]['BannerText2'] : '' !!}
																				</div>
																			</fieldset>
																		</div>
				
																		<div class="col-sm-12">
																			<label  class="text-body">Banner Image</label>
																			<fieldset class="form-group mb-3">
																				<textarea id = "Banner2Base64" name = "Banner2Base64" style="display: none;"> {{ count($company) > 0 ? $company[0]['Banner2'] : '' }} </textarea>
																				
																				<input type="file" id="fileBanner2" name="fileBanner2" accept=".jpg, .png" class="btn btn-warning" style="display: none;"/>
																				<div class="xContainer">
																					<div id="Banner2" class="image_result_sample">
																						@if (count($company) > 0)
																							<img src=" {{$company[0]['Banner2']}} ">
																						@else
																							<img src="https://www.generationsforpeace.org/wp-content/uploads/2018/03/empty.jpg">
																						@endif
																					</div>
																				</div>
																			</fieldset>
																		</div>

																	</div>
																</div>

																<div class="accordion-item">
																	<h2 class="accordion-header" id="headingThree">
																		<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
																			Banner #3
																		</button>
																	</h2>
																	<div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
																		<div class="accordion-body">
																			<div class="col-sm-12">
																				<label  class="text-body">Sample Banner</label>
																				<fieldset class="form-group mb-3">
																					<img src="{{asset('images/sample/Page2.png')}}" width="100%">
																				</fieldset>
																			</div>
																			<div class="col-sm-12">
																				<label  class="text-body">Banner Header</label>
																				<fieldset class="form-group mb-3">
																					<div id="BannerHeader3">
																						{!! count($company) > 0 ? $company[0]['BannerHeader3'] : '' !!}
																					</div>
																				</fieldset>
																			</div>
					
																			<div class="col-sm-12">
																				<label  class="text-body">Banner Text</label>
																				<fieldset class="form-group mb-3">
																					<div id="BannerText3">
																						{!! count($company) > 0 ? $company[0]['BannerText3'] : '' !!}
																					</div>
																				</fieldset>
																			</div>
					
																			<div class="col-sm-12">
																				<label  class="text-body">Banner Image</label>
																				<fieldset class="form-group mb-3">
																					<textarea id = "Banner3Base64" name = "Banner3Base64" style="display: none;"> {{ count($company) > 0 ? $company[0]['Banner3'] : '' }} </textarea>
																					
																					<input type="file" id="fileBanner3" name="fileBanner3" accept=".jpg, .png" class="btn btn-warning" style="display: none;"/>
																					<div class="xContainer">
																						<div id="Banner3" class="image_result_sample">
																							@if (count($company) > 0)
																								<img src=" {{$company[0]['Banner3']}} ">
																							@else
																								<img src="https://www.generationsforpeace.org/wp-content/uploads/2018/03/empty.jpg">
																							@endif
																						</div>
																					</div>
																				</fieldset>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<div class="col-md-12">
															<label  class="text-body">Tampilkan Link URL Di Struk Transaksi</label>
					                            			<fieldset class="form-group mb-3">
					                            				<select name="ShowLinkInReciept" id="ShowLinkInReciept" class="js-example-basic-single js-states form-control bg-transparent">
					                            					<option value="0" {{ count($company) > 0 ? $company[0]['ShowLinkInReciept'] == '0' ? 'selected' : '' : '' }}>Tidak</option>
					                            					<option value="1" {{ count($company) > 0 ? $company[0]['ShowLinkInReciept'] == '1' ? 'selected' : '' : '' }}>Ya</option>
					                            				</select>
					                            			</fieldset>
														</div>
														<div class="col-md-12">
															@if ($company[0]['JenisUsaha'] == "Retail")
															<a href="{{ url('cat/').'/'.$company[0]['KodePartner'].'#home-basic' }}" target="_blank" class="btn btn-warning text-white font-weight-bold me-1 mb-1">Lihat Website</a>
															@else
															<a href="http://dspos.digimenu.dstechsmart.com" target="_blank" class="btn btn-warning text-white font-weight-bold me-1 mb-1">Lihat Website</a>
															@endif
														</div>
														{{-- E-Catalog --}}
													</div>
												</div>

												<div class="tab-pane fade " id="bulkaction" role="tabpanel" aria-labelledby="printer-tab">
													<div class="form-group row">
														<div class="col-md-10">
					                            			<label  class="text-body">Daftar Barang <a href="{{ asset('sample/BulkItemMaster.xlsx')}}">Download Sample</a></label>
					                            			<fieldset class="form-group mb-4">
					                            				<input type="file" class="form-control enableFileControl" id="BulkItemMaster" name="BulkItemMaster" accept=".xls, .xlsx" />
					                            			</fieldset>
					                            			
					                            		</div>
														<div class="col-md-2">
															<label  class="text-body">.</label>
															<fieldset class="form-group mb-4">
																<button type="button" class="btn btn-success text-white font-weight-bold me-1 mb-1" id="btInportItem">Proses</button>
															</fieldset>
														</div>

														<div class="col-md-10">
					                            			<label  class="text-body">Harga Jual <a href="{{ asset('sample/BulkHargaJual.xlsx')}}">Download Sample</a></label>
					                            			<fieldset class="form-group mb-4">
					                            				<input type="file" class="form-control enableFileControl" id="BulkHargaJual" name="BulkHargaJual" accept=".xls, .xlsx" />
					                            			</fieldset>
					                            			
					                            		</div>
														<div class="col-md-2">
															<label  class="text-body">.</label>
															<fieldset class="form-group mb-4">
																<button type="button" class="btn btn-success text-white font-weight-bold me-1 mb-1" id="btInportHargaJual">Proses</button>
															</fieldset>
														</div>

														<div class="col-md-10">
					                            			<label  class="text-body">Pelanggan <a href="{{ asset('sample/BulkPelanggan.xlsx')}}">Download Sample</a></label>
					                            			<fieldset class="form-group mb-4">
					                            				<input type="file" class="form-control enableFileControl" id="BulkPelanggan" name="BulkPelanggan" accept=".xls, .xlsx" />
					                            			</fieldset>
					                            			
					                            		</div>
														<div class="col-md-2">
															<label  class="text-body">.</label>
															<fieldset class="form-group mb-4">
																<button type="button" class="btn btn-success text-white font-weight-bold me-1 mb-1" id="btInportPelanggan">Proses</button>
															</fieldset>
														</div>

														<div class="col-md-10">
					                            			<label  class="text-body">Supplier <a href="{{ asset('sample/BulkSupplier.xlsx')}}">Download Sample</a></label>
					                            			<fieldset class="form-group mb-4">
					                            				<input type="file" class="form-control enableFileControl" id="BulkSupplier" name="BulkSupplier" accept=".xls, .xlsx" />
					                            			</fieldset>
					                            			
					                            		</div>
														<div class="col-md-2">
															<label  class="text-body">.</label>
															<fieldset class="form-group mb-4">
																<button type="button" class="btn btn-success text-white font-weight-bold me-1 mb-1" id="btInportSupplier">Proses</button>
															</fieldset>
														</div>
													</div>
												</div>

												<div class="tab-pane fade " id="invoice" role="tabpanel" aria-labelledby="printer-tab">
													<div class="row">
														<div class="col-md-3">
															<label  class="text-body">Tanggal Awal</label>
															<input type="date" name="TglAwal" id="TglAwal" class="form-control">
														</div>
														<div class="col-md-3">
															<label  class="text-body">Tanggal Akhir</label>
															<input type="date" name="TglAkhir" id="TglAkhir" class="form-control">
														</div>
													</div>
													<hr>
													<div class="form-group row">
														<div class="col-md-12">
					                            			<div class="table-responsive" id="printableTable">
																<table id="invoiceTable" class="display" style="width:100%">
																	<thead>
																		<tr>
																			<th>Nomor Invoice</th>
																			<th>Tgl Invoice</th>
																			<th>Nama Paket</th>
																			<th>Total</th>
																			<th>Tgl Jatuh Tempo</th>
																			<th>Status</th>
																			<th>Action</th>
																		</tr>
																	</thead>
																</table>
															</div>

					                            		</div>
													</div>
												</div>

												<div class="tab-pane fade " id="custdisplay" role="tabpanel" aria-labelledby="custdisplay-tab">
													<div class="row">
														<div class="col-sm-12">
															<label  class="text-body">Promo tampil customer display</label>
															<fieldset class="form-group mb-3">
																<div id="PromoDsiplay">
																	{!! count($company) > 0 ? $company[0]['PromoDsiplay'] : '' !!}
																</div>
															</fieldset>
														</div>
														<div class="col-md-10">
					                            			<label  class="text-body">Running Text</label>
					                            			<fieldset class="form-group mb-4">
					                            				<input type="text" class="form-control" id="RunningText" name="RunningText" placeholder="Masukan Running Text" value="{{ count($company) > 0 ? $company[0]['RunningText'] : 0 }}" >
					                            			</fieldset>
					                            		</div>
														<div class="row">
															<label  class="text-body">Gambar Customer Display</label>
															<div class="col-sm-3">
																<fieldset class="form-group mb-3">
																	<textarea id = "ImageCustDisplay1Base64" name = "ImageCustDisplay1Base64" style="display: none;"> {{ count($company) > 0 ? $company[0]['ImageCustDisplay1'] : '' }} </textarea>
																	
																	<input type="file" id="fileImageCustDisplay1" name="fileImageCustDisplay1" accept=".jpg, .png" class="btn btn-warning" style="display: none;"/>
																	<div class="xContainer">
																		<div id="ImageCustDisplay1" class="image_result_sample">
																			@if ($company[0]['ImageCustDisplay1'] != '')
																				<img src=" {{$company[0]['ImageCustDisplay1']}} ">
																			@else
																				<img src="https://png.pngtree.com/png-vector/20221125/ourmid/pngtree-no-image-available-icon-flatvector-illustration-blank-avatar-modern-vector-png-image_40962406.jpg">
																			@endif
																		</div>
																	</div>
																</fieldset>
															</div>

															<div class="col-sm-3">
																<fieldset class="form-group mb-3">
																	<textarea id = "ImageCustDisplay2Base64" name = "ImageCustDisplay2Base64" style="display: none;"> {{ count($company) > 0 ? $company[0]['ImageCustDisplay2'] : '' }} </textarea>
																	
																	<input type="file" id="fileImageCustDisplay2" name="fileImageCustDisplay2" accept=".jpg, .png" class="btn btn-warning" style="display: none;"/>
																	<div class="xContainer">
																		<div id="ImageCustDisplay2" class="image_result_sample">
																			@if ($company[0]['ImageCustDisplay2'] != '')
																				<img src=" {{$company[0]['ImageCustDisplay2']}} ">
																			@else
																				<img src="https://png.pngtree.com/png-vector/20221125/ourmid/pngtree-no-image-available-icon-flatvector-illustration-blank-avatar-modern-vector-png-image_40962406.jpg">
																			@endif
																		</div>
																	</div>
																</fieldset>
															</div>

															<div class="col-sm-3">
																<fieldset class="form-group mb-3">
																	<textarea id = "ImageCustDisplay3Base64" name = "ImageCustDisplay3Base64" style="display: none;"> {{ count($company) > 0 ? $company[0]['ImageCustDisplay3'] : '' }} </textarea>
																	
																	<input type="file" id="fileImageCustDisplay3" name="fileImageCustDisplay3" accept=".jpg, .png" class="btn btn-warning" style="display: none;"/>
																	<div class="xContainer">
																		<div id="ImageCustDisplay3" class="image_result_sample">
																			@if ($company[0]['ImageCustDisplay3'] != '')
																				<img src=" {{$company[0]['ImageCustDisplay3']}} ">
																			@else
																				<img src="https://png.pngtree.com/png-vector/20221125/ourmid/pngtree-no-image-available-icon-flatvector-illustration-blank-avatar-modern-vector-png-image_40962406.jpg">
																			@endif
																		</div>
																	</div>
																</fieldset>
															</div>

															<div class="col-sm-3">
																<fieldset class="form-group mb-3">
																	<textarea id = "ImageCustDisplay4Base64" name = "ImageCustDisplay4Base64" style="display: none;"> {{ count($company) > 0 ? $company[0]['ImageCustDisplay4'] : '' }} </textarea>
																	
																	<input type="file" id="fileImageCustDisplay4" name="fileImageCustDisplay4" accept=".jpg, .png" class="btn btn-warning" style="display: none;"/>
																	<div class="xContainer">
																		<div id="ImageCustDisplay4" class="image_result_sample">
																			@if ($company[0]['ImageCustDisplay4'] != '')
																				<img src=" {{$company[0]['ImageCustDisplay4']}} ">
																			@else
																				<img src="https://png.pngtree.com/png-vector/20221125/ourmid/pngtree-no-image-available-icon-flatvector-illustration-blank-avatar-modern-vector-png-image_40962406.jpg">
																			@endif
																		</div>
																	</div>
																</fieldset>
															</div>

														</div>
													</div>
												</div>

												<div class="tab-pane fade " id="printer" role="tabpanel" aria-labelledby="printer-tab">
													<div class="form-group row">
														<div class="col-md-4">
					                            			<label  class="text-body">Printer Register</label>
					                            			<fieldset class="form-group mb-4">
					                            				<select name="NamaPosPrinter" id="NamaPosPrinter" class="js-example-basic-single js-states form-control bg-transparent">
					                            					<option value="-1">Pilih Printer</option>
																	@foreach($printer as $ko)
																		<option {{ count($company) > 0 ? $company[0]['NamaPosPrinter'] == $ko->DeviceAddress ? "selected" : '' :""}} value="{{ $ko->DeviceAddress }}">
					                                                        {{ $ko->NamaPrinter. ' > '. $ko->PrinterInterface }}
					                                                    </option>
																	@endforeach
					                            				</select>
					                            			</fieldset>
					                            			
					                            		</div>

					                            		<div class="col-md-3">
					                            			<label  class="text-body">Lebar Kertas</label>
					                            			<fieldset class="form-group mb-3">
					                            				<select name="LebarKertas" id="LebarKertas" class="js-example-basic-single js-states form-control bg-transparent">
					                            					<option value="48">48</option>
					                            					<option value="58">58</option>
					                            					<option value="80">80</option>
					                            				</select>
					                            			</fieldset>
					                            		</div>
														<!--
					                            		<div class="col-md-3">
					                            			<fieldset class="form-group mb-3">
					                            				<button type="button" class="btn btn-warning">Test Print</button>
					                            			</fieldset>
					                            		</div>
					                            		<div class="col-md-3">
					                            			<fieldset class="form-group mb-3">
					                            				<button type="button" class="btn btn-warning" id="testPrintUSB">Test Print Usb</button>
					                            			</fieldset>
					                            		</div> -->

					                            		<!-- <a href="{{ url('companysetting/testprint') }}">Test Print</a> -->
					                            		<div class="col-md-12">
					                            			<label  class="text-body">Keterangan Footer</label>
					                            			<fieldset class="form-group mb-12">
					                            				<textarea class="form-control" id="FooterNota" name="FooterNota" rows="3" placeholder="Masukan Alamat">{{ count($company) > 0 ? $company[0]['FooterNota'] : '' }}</textarea>
					                            			</fieldset>
					                            		</div>

														<div class="col-md-4">
					                            			<label  class="text-body">Format Faktur</label>
					                            			<fieldset class="form-group mb-3">
					                            				<select name="DefaultSlip" id="DefaultSlip" class="js-example-basic-single js-states form-control bg-transparent">
					                            					<option value="slip1" {{ count($company) > 0 ? $company[0]['DefaultSlip'] == "slip1"? "selected" : '' :""}} >Slip 1</option>
					                            					<option value="slip2" {{ count($company) > 0 ? $company[0]['DefaultSlip'] == "slip2"? "selected" : '' :""}} >Slip 2</option>
					                            					<option value="slip3" {{ count($company) > 0 ? $company[0]['DefaultSlip'] == "slip3"? "selected" : '' :""}} >Slip 3</option>
					                            				</select>
					                            			</fieldset>
					                            		</div>

														<div class="col-md-8">
															<label  class="text-body">Preview</label>
															<fieldset class="form-group mb-3">
																<img src="#" id="PreviewImageSlip" width="100%">
															</fieldset>
														</div>

													</div>
												</div>



												<div class="tab-pane fade " id="hiburan" role="tabpanel" aria-labelledby="hiburan-tab">
													<div class="form-group row">
														<div class="col-md-12">
					                            			<label  class="text-body">Pajak Hiburan (%)</label>
					                            			<fieldset class="form-group mb-4">
					                            				<input type="number" class="form-control" step="0.01" id="PajakHiburan" name="PajakHiburan" placeholder="Masukan Pajak Hiburan" value="{{ count($company) > 0 ? $company[0]['PajakHiburan'] : 0 }}" >
					                            			</fieldset>
					                            			
					                            		</div>

														<div class="col-md-12">
					                            			<label  class="text-body">Warning Waktu Hampir Habis</label>
					                            			<fieldset class="form-group mb-4">
					                            				<input type="number" class="form-control" step="1" id="WarningTimer" name="WarningTimer" placeholder="Masukan Warning Hampir Habis" value="{{ count($company) > 0 ? $company[0]['WarningTimer'] : 0 }}" >
					                            			</fieldset>
					                            			
					                            		</div>

														<div class="col-md-12">
					                            			<label  class="text-body">Item Jasa Sewa</label>
					                            			<fieldset class="form-group mb-4">
					                            				<select name="ItemHiburan" id="ItemHiburan" class="js-example-basic-single js-states form-control bg-transparent">
					                            					<option value="" {{ count($company) > 0 ? $company[0]['ItemHiburan'] == ""? "selected" : '' :""}} >Pilih Item</option>
																	@foreach($itemjasa as $js)
																		<option value="{{ $js->KodeItem }}" {{ $js->KodeItem == (count($company) > 0 ? $company[0]['ItemHiburan'] : '') ? 'selected' : '' }}>
								                                            {{ $js->NamaItem }}
								                                        </option>
																	@endforeach
					                            				</select>

																<small>Setting ini digunakan untuk generate faktur penjualan</small>
					                            			</fieldset>
					                            			
					                            		</div>

													</div>
												</div>


												<div class="tab-pane fade" id="booking" role="tabpanel" aria-labelledby="booking-tab">
													<div class="form-group row">
														
														<div class="col-md-12">
															<label class="text-body">Upload Image Banner Booking</label>
															<fieldset class="form-group mb-3">
																<textarea id = "BannerBookingBase64" name = "BannerBookingBase64" style="display: none;"> {{ count($company) > 0 ? $company[0]['BannerBooking'] : '' }} </textarea>
																				
																				<input type="file" id="fileBannerBooking" name="fileBannerBooking" accept=".jpg, .png" class="btn btn-warning" style="display: none;"/>
																				<div class="xContainer">
																					<div id="BannerBooking" class="image_result_sample">
																						@if (count($company) > 0)
																							<img src=" {{$company[0]['BannerBooking']}} ">
																						@else
																							<img src="https://www.generationsforpeace.org/wp-content/uploads/2018/03/empty.jpg">
																						@endif
																					</div>
																				</div>
															</fieldset>
														</div>

														<div class="col-md-12">
					                            			<label  class="text-body">Headline</label>
					                            			<fieldset class="form-group mb-12">
																<div id="HeadlineBanner">
																	{!! count($company) > 0 ? $company[0]['HeadlineBanner'] : '' !!}
																</div>
															</fieldset>
					                            		</div>

														<div class="col-md-12">
					                            			<label  class="text-body">Sub Headline</label>
					                            			<fieldset class="form-group mb-12">
																<div id="SubHeadlineBanner">
																	{!! count($company) > 0 ? $company[0]['SubHeadlineBanner'] : '' !!}
																</div>
					                            			</fieldset>
					                            		</div>

														
														<div class="col-md-12">
															<label class="text-body">Daftar Meja yang Bisa Dipesan</label>
															<div class="table-responsive">
																<table id="bookingTable" class="table table-bordered">
																	<thead class="bg-primary text-white">
																		<tr>
																			<th style = 'display:none;'>No</th>
																			<th>Meja</th>
																			<th>Bisa Di Booking ?</th>
																		</tr>
																	</thead>
																	<tbody id="tableBookingList">
																		<!-- Data akan di-load dari database -->
																	</tbody>
																</table>
															</div>
														</div>

														
														<div class="col-md-6">
															<label class="text-body">Jam Awal Booking</label>
															<fieldset class="form-group mb-3">
																<input type="time" class="form-control" id="JamAwalBooking" name="JamAwalBooking" step="60"
																	value="{{ count($company) > 0 ? date('H:i', strtotime($company[0]['JamAwalBooking'])) : '' }}">
															</fieldset>
														</div>
														
														<div class="col-md-6">
															<label class="text-body">Jam Akhir Booking</label>
															<fieldset class="form-group mb-3">
																<input type="time" class="form-control" id="JamAkhirBooking" name="JamAkhirBooking" step="60"
																	value="{{ count($company) > 0 ? date('H:i', strtotime($company[0]['JamAkhirBooking'])) : '' }}">
															</fieldset>
														</div>
														
														<div class="col-md-12">
					                            			<label  class="text-body">Term and Condition</label>
					                            			<fieldset class="form-group mb-12">
																<div id="TermAndCondition">
																	{!! count($company) > 0 ? $company[0]['TermAndCondition'] : '' !!}
																</div>
					                            			</fieldset>
					                            		</div>

														<div class="col-md-12">
					                            			<label  class="text-body">About US</label>
					                            			<fieldset class="form-group mb-12">
																<div id="AboutUs">
																	{!! count($company) > 0 ? $company[0]['AboutUs'] : '' !!}
																</div>
					                            			</fieldset>
					                            		</div>

														<div class="row">
															<label  class="text-body">Image Gallery</label>
															<div class="col-sm-3">
																<fieldset class="form-group mb-3">
																	<textarea id = "ImageGallery1Base64" name = "ImageGallery1Base64" style="display: none;"> {{ count($company) > 0 ? $company[0]['ImageGallery1'] : '' }} </textarea>
																	
																	<input type="file" id="fileImageGallery1" name="fileImageGallery1" accept=".jpg, .png" class="btn btn-warning" style="display: none;"/>
																	<div class="xContainer">
																		<div id="ImageGallery1" class="image_result_sample">
																			@if ($company[0]['ImageGallery1'] != '')
																				<img src=" {{$company[0]['ImageGallery1']}} ">
																			@else
																				<img src="https://png.pngtree.com/png-vector/20221125/ourmid/pngtree-no-image-available-icon-flatvector-illustration-blank-avatar-modern-vector-png-image_40962406.jpg">
																			@endif
																		</div>
																	</div>
																</fieldset>
															</div>

															<div class="col-sm-3">
																<fieldset class="form-group mb-3">
																	<textarea id = "ImageGallery2Base64" name = "ImageGallery2Base64" style="display: none;"> {{ count($company) > 0 ? $company[0]['ImageGallery2'] : '' }} </textarea>
																	
																	<input type="file" id="fileImageGallery2" name="fileImageGallery2" accept=".jpg, .png" class="btn btn-warning" style="display: none;"/>
																	<div class="xContainer">
																		<div id="ImageGallery2" class="image_result_sample">
																			@if ($company[0]['ImageGallery2'] != '')
																				<img src=" {{$company[0]['ImageGallery2']}} ">
																			@else
																				<img src="https://png.pngtree.com/png-vector/20221125/ourmid/pngtree-no-image-available-icon-flatvector-illustration-blank-avatar-modern-vector-png-image_40962406.jpg">
																			@endif
																		</div>
																	</div>
																</fieldset>
															</div>

															<div class="col-sm-3">
																<fieldset class="form-group mb-3">
																	<textarea id = "ImageGallery3Base64" name = "ImageGallery3Base64" style="display: none;"> {{ count($company) > 0 ? $company[0]['ImageGallery3'] : '' }} </textarea>
																	
																	<input type="file" id="fileImageGallery3" name="fileImageGallery3" accept=".jpg, .png" class="btn btn-warning" style="display: none;"/>
																	<div class="xContainer">
																		<div id="ImageGallery3" class="image_result_sample">
																			@if ($company[0]['ImageGallery3'] != '')
																				<img src=" {{$company[0]['ImageGallery3']}} ">
																			@else
																				<img src="https://png.pngtree.com/png-vector/20221125/ourmid/pngtree-no-image-available-icon-flatvector-illustration-blank-avatar-modern-vector-png-image_40962406.jpg">
																			@endif
																		</div>
																	</div>
																</fieldset>
															</div>

															<div class="col-sm-3">
																<fieldset class="form-group mb-3">
																	<textarea id = "ImageGallery4Base64" name = "ImageGallery4Base64" style="display: none;"> {{ count($company) > 0 ? $company[0]['ImageGallery4'] : '' }} </textarea>
																	
																	<input type="file" id="fileImageGallery4" name="fileImageGallery4" accept=".jpg, .png" class="btn btn-warning" style="display: none;"/>
																	<div class="xContainer">
																		<div id="ImageGallery4" class="image_result_sample">
																			@if ($company[0]['ImageGallery4'] != '')
																				<img src=" {{$company[0]['ImageGallery4']}} ">
																			@else
																				<img src="https://png.pngtree.com/png-vector/20221125/ourmid/pngtree-no-image-available-icon-flatvector-illustration-blank-avatar-modern-vector-png-image_40962406.jpg">
																			@endif
																		</div>
																	</div>
																</fieldset>
															</div>

															<div class="col-sm-3">
																<fieldset class="form-group mb-3">
																	<textarea id = "ImageGallery5Base64" name = "ImageGallery5Base64" style="display: none;"> {{ count($company) > 0 ? $company[0]['ImageGallery5'] : '' }} </textarea>
																	
																	<input type="file" id="fileImageGallery5" name="fileImageGallery5" accept=".jpg, .png" class="btn btn-warning" style="display: none;"/>
																	<div class="xContainer">
																		<div id="ImageGallery5" class="image_result_sample">
																			@if ($company[0]['ImageGallery5'] != '')
																				<img src=" {{$company[0]['ImageGallery5']}} ">
																			@else
																				<img src="https://png.pngtree.com/png-vector/20221125/ourmid/pngtree-no-image-available-icon-flatvector-illustration-blank-avatar-modern-vector-png-image_40962406.jpg">
																			@endif
																		</div>
																	</div>
																</fieldset>
															</div>

															<div class="col-sm-3">
																<fieldset class="form-group mb-3">
																	<textarea id = "ImageGallery6Base64" name = "ImageGallery6Base64" style="display: none;"> {{ count($company) > 0 ? $company[0]['ImageGallery6'] : '' }} </textarea>
																	
																	<input type="file" id="fileImageGallery6" name="fileImageGallery6" accept=".jpg, .png" class="btn btn-warning" style="display: none;"/>
																	<div class="xContainer">
																		<div id="ImageGallery6" class="image_result_sample">
																			@if ($company[0]['ImageGallery6'] != '')
																				<img src=" {{$company[0]['ImageGallery6']}} ">
																			@else
																				<img src="https://png.pngtree.com/png-vector/20221125/ourmid/pngtree-no-image-available-icon-flatvector-illustration-blank-avatar-modern-vector-png-image_40962406.jpg">
																			@endif
																		</div>
																	</div>
																</fieldset>
															</div>

															<div class="col-sm-3">
																<fieldset class="form-group mb-3">
																	<textarea id = "ImageGallery7Base64" name = "ImageGallery7Base64" style="display: none;"> {{ count($company) > 0 ? $company[0]['ImageGallery7'] : '' }} </textarea>
																	
																	<input type="file" id="fileImageGallery7" name="fileImageGallery7" accept=".jpg, .png" class="btn btn-warning" style="display: none;"/>
																	<div class="xContainer">
																		<div id="ImageGallery7" class="image_result_sample">
																			@if ($company[0]['ImageGallery7'] != '')
																				<img src=" {{$company[0]['ImageGallery7']}} ">
																			@else
																				<img src="https://png.pngtree.com/png-vector/20221125/ourmid/pngtree-no-image-available-icon-flatvector-illustration-blank-avatar-modern-vector-png-image_40962406.jpg">
																			@endif
																		</div>
																	</div>
																</fieldset>
															</div>

															<div class="col-sm-3">
																<fieldset class="form-group mb-3">
																	<textarea id = "ImageGallery8Base64" name = "ImageGallery8Base64" style="display: none;"> {{ count($company) > 0 ? $company[0]['ImageGallery8'] : '' }} </textarea>
																	
																	<input type="file" id="fileImageGallery8" name="fileImageGallery8" accept=".jpg, .png" class="btn btn-warning" style="display: none;"/>
																	<div class="xContainer">
																		<div id="ImageGallery8" class="image_result_sample">
																			@if ($company[0]['ImageGallery8'] != '')
																				<img src=" {{$company[0]['ImageGallery8']}} ">
																			@else
																				<img src="https://png.pngtree.com/png-vector/20221125/ourmid/pngtree-no-image-available-icon-flatvector-illustration-blank-avatar-modern-vector-png-image_40962406.jpg">
																			@endif
																		</div>
																	</div>
																</fieldset>
															</div>


															<div class="col-sm-3">
																<fieldset class="form-group mb-3">
																	<textarea id = "ImageGallery9Base64" name = "ImageGallery9Base64" style="display: none;"> {{ count($company) > 0 ? $company[0]['ImageGallery9'] : '' }} </textarea>
																	
																	<input type="file" id="fileImageGallery9" name="fileImageGallery9" accept=".jpg, .png" class="btn btn-warning" style="display: none;"/>
																	<div class="xContainer">
																		<div id="ImageGallery9" class="image_result_sample">
																			@if ($company[0]['ImageGallery9'] != '')
																				<img src=" {{$company[0]['ImageGallery9']}} ">
																			@else
																				<img src="https://png.pngtree.com/png-vector/20221125/ourmid/pngtree-no-image-available-icon-flatvector-illustration-blank-avatar-modern-vector-png-image_40962406.jpg">
																			@endif
																		</div>
																	</div>
																</fieldset>
															</div>

															<div class="col-sm-3">
																<fieldset class="form-group mb-3">
																	<textarea id = "ImageGallery10Base64" name = "ImageGallery10Base64" style="display: none;"> {{ count($company) > 0 ? $company[0]['ImageGallery10'] : '' }} </textarea>
																	
																	<input type="file" id="fileImageGallery10" name="fileImageGallery10" accept=".jpg, .png" class="btn btn-warning" style="display: none;"/>
																	<div class="xContainer">
																		<div id="ImageGallery10" class="image_result_sample">
																			@if ($company[0]['ImageGallery10'] != '')
																				<img src=" {{$company[0]['ImageGallery10']}} ">
																			@else
																				<img src="https://png.pngtree.com/png-vector/20221125/ourmid/pngtree-no-image-available-icon-flatvector-illustration-blank-avatar-modern-vector-png-image_40962406.jpg">
																			@endif
																		</div>
																	</div>
																</fieldset>
															</div>

															<div class="col-sm-3">
																<fieldset class="form-group mb-3">
																	<textarea id = "ImageGallery11Base64" name = "ImageGallery11Base64" style="display: none;"> {{ count($company) > 0 ? $company[0]['ImageGallery11'] : '' }} </textarea>
																	
																	<input type="file" id="fileImageGallery11" name="fileImageGallery11" accept=".jpg, .png" class="btn btn-warning" style="display: none;"/>
																	<div class="xContainer">
																		<div id="ImageGallery11" class="image_result_sample">
																			@if ($company[0]['ImageGallery11'] != '')
																				<img src=" {{$company[0]['ImageGallery11']}} ">
																			@else
																				<img src="https://png.pngtree.com/png-vector/20221125/ourmid/pngtree-no-image-available-icon-flatvector-illustration-blank-avatar-modern-vector-png-image_40962406.jpg">
																			@endif
																		</div>
																	</div>
																</fieldset>
															</div>

															<div class="col-sm-3">
																<fieldset class="form-group mb-3">
																	<textarea id = "ImageGallery12Base64" name = "ImageGallery12Base64" style="display: none;"> {{ count($company) > 0 ? $company[0]['ImageGallery12'] : '' }} </textarea>
																	
																	<input type="file" id="fileImageGallery12" name="fileImageGallery12" accept=".jpg, .png" class="btn btn-warning" style="display: none;"/>
																	<div class="xContainer">
																		<div id="ImageGallery12" class="image_result_sample">
																			@if ($company[0]['ImageGallery12'] != '')
																				<img src=" {{$company[0]['ImageGallery12']}} ">
																			@else
																				<img src="https://png.pngtree.com/png-vector/20221125/ourmid/pngtree-no-image-available-icon-flatvector-illustration-blank-avatar-modern-vector-png-image_40962406.jpg">
																			@endif
																		</div>
																	</div>
																</fieldset>
															</div>


														</div>

													</div>
												</div>

											</div>
										</div>
									</div>
									<div class="form-group row">
	                            		<div class="col-md-12">
	                            			<button type="submit" class="btn btn-success text-white font-weight-bold me-1 mb-1">Simpan</button>
	                            		</div>

									</div>
								</form>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>

@endsection

@push('scripts')

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script type="text/javascript">
var _URL = window.URL || window.webkitURL;
var _URLePub = window.URL || window.webkitURL;
var oCompany;
	$(function () {
		const quill_BannerHeader1 = new Quill('#BannerHeader1', {
			theme: 'snow'
		});
		const quill_BannerHeader2 = new Quill('#BannerHeader2', {
			theme: 'snow'
		});
		const quill_BannerHeader3 = new Quill('#BannerHeader3', {
			theme: 'snow'
		});

		const quill_BannerText1 = new Quill('#BannerText1', {
			theme: 'snow'
		});
		const quill_BannerText2 = new Quill('#BannerText2', {
			theme: 'snow'
		});
		const quill_BannerText3 = new Quill('#BannerText3', {
			theme: 'snow'
		});

		const quill_PromoDsiplay = new Quill('#PromoDsiplay', {
			theme: 'snow'
		});

		const quill_HeadlineBanner = new Quill('#HeadlineBanner', {
			theme: 'snow'
		});
		const quill_SubHeadlineBanner = new Quill('#SubHeadlineBanner', {
			theme: 'snow'
		});

		const quill_TermAndCondition = new Quill('#TermAndCondition', {
			theme: 'snow'
		});
		const quill_AboutUs = new Quill('#AboutUs', {
			theme: 'snow'
		});
		jQuery(document).ready(function () {
			var now = new Date();
			var day = ("0" + now.getDate()).slice(-2);
			var month = ("0" + (now.getMonth() + 1)).slice(-2);
			var firstDay = now.getFullYear()+"-"+month+"-01";
			var NowDay = now.getFullYear()+"-"+month+"-"+day;

			jQuery('#TglAwal').val(firstDay);
			jQuery('#TglAkhir').val(NowDay);

			var slip = "{{ count($company) > 0 ? $company[0]['DefaultSlip'] : 'slip1' }}"
			jQuery('#LevelHarga').select2();
			jQuery('#DefaultSlip').val(slip).trigger('change');

			oCompany = <?php echo $company ?>;
			console.log(oCompany)
			jQuery('#isPostingAkutansi').val(oCompany[0]['AllowAccounting']);

			if (oCompany[0]['AllowKatalogOnline'] == 0) {
				jQuery('#ecatalog-tab').hide();
			}

			// Generate Table
			// invoiceTable
			jQuery('#invoiceTable').DataTable({
				"ajax": {
					"url": "{{route('invpengguna-viewpercom')}}",
					"type": "POST",
					"contentType": "application/json",
					headers: {
						'X-CSRF-TOKEN': '{{ csrf_token() }}'
					},
					"data": function(d) {
						d.TglAwal = jQuery('#TglAwal').val();
						d.TglAkhir = jQuery('#TglAkhir').val();
						d.Status = "";
						return JSON.stringify(d);
					},
					"dataSrc": ""
				},
				"columns": [
					{ "data": "NoTransaksi" },
					{ 
						"data": "TglTransaksi",
						"render": function(data, type, row) {
							if (!data) return '';
							let date = new Date(data);
							let day = String(date.getDate()).padStart(2, '0');
							let month = String(date.getMonth() + 1).padStart(2, '0');
							let year = date.getFullYear();
							return `${day}-${month}-${year}`;
						}
					},
					{ "data": "NamaSubscription" },
					{ 
						"data": "TotalTagihan",
						"render": function(data, type, row) {
							return parseFloat(data).toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
						}
					},
					{ 
						"data": "TglJatuhTempo",
						"render": function(data, type, row) {
							if (!data) return '';
							let date = new Date(data);
							let day = String(date.getDate()).padStart(2, '0');
							let month = String(date.getMonth() + 1).padStart(2, '0');
							let year = date.getFullYear();
							return `${day}-${month}-${year}`;
						}
					},
					{ "data": "StatusPembayaran" },
					{
						"data": null,
						"orderable": false,
						"render": function(data, type, row) {
							let disabled = row.StatusPembayaran == "LUNAS" ? "disabled" : "";
							return `<button type="button" class="btn btn-warning btn-bayar" data-id="${row.NoTransaksi}" data-TotalBayar="${row.TotalTagihan}" ${disabled}>Bayar</button>`;
						}
					}
				]
			});

		});

		jQuery('form').submit(function(e) {

			e.preventDefault(); // Prevent default form submission

			var form = $(this);
			var formData = form.serializeArray();
			var actionUrl = form.attr('action');
			var submitButton = form.find("button[type='submit']");
			submitButton.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Processing...');

			var BannerHeader1 = quill_BannerHeader1.root.innerHTML;
			var BannerHeader2 = quill_BannerHeader2.root.innerHTML;
			var BannerHeader3 = quill_BannerHeader3.root.innerHTML;
			var BannerText1 = quill_BannerText1.root.innerHTML;
			var BannerText2 = quill_BannerText2.root.innerHTML;
			var BannerText3 = quill_BannerText3.root.innerHTML;
			var PromoDsiplay = quill_PromoDsiplay.root.innerHTML;
			var HeadlineBanner = quill_HeadlineBanner.root.innerHTML;
			var SubHeadlineBanner = quill_SubHeadlineBanner.root.innerHTML;
			var TermAndCondition = quill_TermAndCondition.root.innerHTML;
			var AboutUs = quill_AboutUs.root.innerHTML;
			

			formData.push({ name: "BannerHeader1", value: BannerHeader1 });
			formData.push({ name: "BannerHeader2", value: BannerHeader2 });
			formData.push({ name: "BannerHeader3", value: BannerHeader3 });
			formData.push({ name: "BannerText1", value: BannerText1 });
			formData.push({ name: "BannerText2", value: BannerText2 });
			formData.push({ name: "BannerText3", value: BannerText3 });
			formData.push({ name: "PromoDsiplay", value: PromoDsiplay });
			formData.push({ name: "HeadlineBanner", value: HeadlineBanner });
			formData.push({ name: "SubHeadlineBanner", value: SubHeadlineBanner });
			formData.push({ name: "TermAndCondition", value: TermAndCondition });
			formData.push({ name: "AboutUs", value: AboutUs });

			$.ajax({
				url: actionUrl,
				type: 'POST',
				data: formData,
				dataType: 'json',
				success: function(response) {
					if(response.success == true){
						swal.fire({
							title: 'Success',
							text: response.message,
							icon: 'success',
							confirmButtonText: 'OK'
						}).then(function() {
							window.location.href = "{{ route('companysetting') }}";
						});
					} else {
						swal.fire({
							title: 'Error',
							text: response.message,
							icon: 'error',
							confirmButtonText: 'OK'
						}).then(function() {
							submitButton.prop('disabled', false).html('Save');
						});
					}
				},
			});
		});

		jQuery('#invoiceTable').on('click', '.btn-bayar', function() {
			var NoTransaksi = jQuery(this).data('id');
			var TotalPembayaran = jQuery(this).data('totalbayar');
			// console.log(TotalPembayaran)
			PaymentGateWay(jQuery(".btn-bayar"), "Bayar", NoTransaksi, TotalPembayaran)
		});
		jQuery('#isPostingAkutansi').on('mousedown', function(event) {
			if (jQuery(this).attr('readonly')) {
				event.preventDefault();
			}
		});

		jQuery('#btTestPrint').click(function () {
			// alert('asd')
			$.ajax({
	            async:false,
	            type: 'post',
	            url: "{{route('print-test')}}",
	            headers: {
	                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
	            },
	            data: {
	                'NoTransaksi' : 'asdasda'
	            },
	            dataType: 'json',
	            success: function(response) {
	                // bindGridDetail(response.data)
	                console.log('response');
	            }
	        })
		});

		jQuery('#testPrintUSB').click(function () {
			// window.print();
			let url = new URL("{{ route('print-testusb48') }}");
            // url.searchParams.append('Orientasi', jQuery('#Orientasi').val());
			var currentUrl  = window.location.href = url.toString();
		});

		jQuery('#DefaultSlip').change(function () {
			var BaseURL = "{{ asset('') }}";
			var url = BaseURL+"images/slip/"+jQuery('#DefaultSlip').val()+".png";
			console.log();
			// var URL = "{{ asset("+FileName+")}}";
			jQuery("#PreviewImageSlip").attr("src", url);
		});


		jQuery('#image_result').click(function(){
			$('#Attachment').click();
		});

		jQuery('#BannerBooking').click(function(){
			$('#fileBannerBooking').click();
		});

		jQuery('#Banner1').click(function(){
			$('#fileBanner1').click();
		});

		jQuery('#Banner2').click(function(){
			$('#fileBanner2').click();
		});

		jQuery('#Banner3').click(function(){
			$('#fileBanner3').click();
		});

		jQuery('#ImageCustDisplay1').click(function(){
			$('#fileImageCustDisplay1').click();
		});
		jQuery('#ImageCustDisplay2').click(function(){
			$('#fileImageCustDisplay2').click();
		});
		jQuery('#ImageCustDisplay3').click(function(){
			$('#fileImageCustDisplay3').click();
		});
		jQuery('#ImageCustDisplay4').click(function(){
			$('#fileImageCustDisplay4').click();
		});

		jQuery('#ImageGallery1').click(function(){
			$('#fileImageGallery1').click();
		});
		jQuery('#ImageGallery2').click(function(){
			$('#fileImageGallery2').click();
		});
		jQuery('#ImageGallery3').click(function(){
			$('#fileImageGallery3').click();
		});
		jQuery('#ImageGallery4').click(function(){
			$('#fileImageGallery4').click();
		});

		jQuery('#ImageGallery5').click(function(){
			$('#fileImageGallery5').click();
		});
		jQuery('#ImageGallery6').click(function(){
			$('#fileImageGallery6').click();
		});
		jQuery('#ImageGallery7').click(function(){
			$('#fileImageGallery7').click();
		});
		jQuery('#ImageGallery8').click(function(){
			$('#fileImageGallery8').click();
		});
		jQuery('#ImageGallery9').click(function(){
			$('#fileImageGallery9').click();
		});
		jQuery('#ImageGallery10').click(function(){
			$('#fileImageGallery10').click();
		});
		jQuery('#ImageGallery11').click(function(){
			$('#fileImageGallery11').click();
		});
		jQuery('#ImageGallery12').click(function(){
			$('#fileImageGallery12').click();
		});

		jQuery("#fileBannerBooking").change(function(){
			var file = $(this)[0].files[0];
			img = new Image();
			img.src = _URL.createObjectURL(file);
			var imgwidth = 0;
			var imgheight = 0;
			img.onload = function () {
				imgwidth = this.width;
				imgheight = this.height;
				$('#width').val(imgwidth);
				$('#height').val(imgheight);
			}
			readURL(this, "BannerBooking");
			encodeImagetoBase64(this, "BannerBookingBase64");
			// alert("Current width=" + imgwidth + ", " + "Original height=" + imgheight);
		});

		jQuery("#fileBanner1").change(function(){
			var file = $(this)[0].files[0];
			img = new Image();
			img.src = _URL.createObjectURL(file);
			var imgwidth = 0;
			var imgheight = 0;
			img.onload = function () {
				imgwidth = this.width;
				imgheight = this.height;
				$('#width').val(imgwidth);
				$('#height').val(imgheight);
			}
			readURL(this, "Banner1");
			encodeImagetoBase64(this, "Banner1Base64");
			// alert("Current width=" + imgwidth + ", " + "Original height=" + imgheight);
		});

		jQuery("#fileBanner2").change(function(){
			var file = $(this)[0].files[0];
			img = new Image();
			img.src = _URL.createObjectURL(file);
			var imgwidth = 0;
			var imgheight = 0;
			img.onload = function () {
				imgwidth = this.width;
				imgheight = this.height;
				$('#width').val(imgwidth);
				$('#height').val(imgheight);
			}
			readURL(this, "Banner2");
			encodeImagetoBase64(this, "Banner2Base64");
			// alert("Current width=" + imgwidth + ", " + "Original height=" + imgheight);
		});

		jQuery("#fileBanner3").change(function(){
			var file = $(this)[0].files[0];
			img = new Image();
			img.src = _URL.createObjectURL(file);
			var imgwidth = 0;
			var imgheight = 0;
			img.onload = function () {
				imgwidth = this.width;
				imgheight = this.height;
				$('#width').val(imgwidth);
				$('#height').val(imgheight);
			}
			readURL(this, "Banner3");
			encodeImagetoBase64(this, "Banner3Base64");
			// alert("Current width=" + imgwidth + ", " + "Original height=" + imgheight);
		});

		jQuery("#fileImageCustDisplay1").change(function(){
			var file = $(this)[0].files[0];
			img = new Image();
			img.src = _URL.createObjectURL(file);
			var imgwidth = 0;
			var imgheight = 0;
			img.onload = function () {
				imgwidth = this.width;
				imgheight = this.height;
				$('#width').val(imgwidth);
				$('#height').val(imgheight);
			}
			readURL(this, "ImageCustDisplay1");
			encodeImagetoBase64(this, "ImageCustDisplay1Base64");
			// alert("Current width=" + imgwidth + ", " + "Original height=" + imgheight);
		});

		jQuery("#fileImageCustDisplay2").change(function(){
			var file = $(this)[0].files[0];
			img = new Image();
			img.src = _URL.createObjectURL(file);
			var imgwidth = 0;
			var imgheight = 0;
			img.onload = function () {
				imgwidth = this.width;
				imgheight = this.height;
				$('#width').val(imgwidth);
				$('#height').val(imgheight);
			}
			readURL(this, "ImageCustDisplay2");
			encodeImagetoBase64(this, "ImageCustDisplay2Base64");
			// alert("Current width=" + imgwidth + ", " + "Original height=" + imgheight);
		});

		jQuery("#fileImageCustDisplay3").change(function(){
			var file = $(this)[0].files[0];
			img = new Image();
			img.src = _URL.createObjectURL(file);
			var imgwidth = 0;
			var imgheight = 0;
			img.onload = function () {
				imgwidth = this.width;
				imgheight = this.height;
				$('#width').val(imgwidth);
				$('#height').val(imgheight);
			}
			readURL(this, "ImageCustDisplay3");
			encodeImagetoBase64(this, "ImageCustDisplay3Base64");
			// alert("Current width=" + imgwidth + ", " + "Original height=" + imgheight);
		});

		jQuery("#fileImageCustDisplay4").change(function(){
			var file = $(this)[0].files[0];
			img = new Image();
			img.src = _URL.createObjectURL(file);
			var imgwidth = 0;
			var imgheight = 0;
			img.onload = function () {
				imgwidth = this.width;
				imgheight = this.height;
				$('#width').val(imgwidth);
				$('#height').val(imgheight);
			}
			readURL(this, "ImageCustDisplay4");
			encodeImagetoBase64(this, "ImageCustDisplay4Base64");
			// alert("Current width=" + imgwidth + ", " + "Original height=" + imgheight);
		});

		jQuery("#fileImageGallery1").change(function(){
			var file = $(this)[0].files[0];
			img = new Image();
			img.src = _URL.createObjectURL(file);
			var imgwidth = 0;
			var imgheight = 0;
			img.onload = function () {
				imgwidth = this.width;
				imgheight = this.height;
				$('#width').val(imgwidth);
				$('#height').val(imgheight);
			}
			readURL(this, "ImageGallery1");
			encodeImagetoBase64(this, "ImageGallery1Base64");
			// alert("Current width=" + imgwidth + ", " + "Original height=" + imgheight);
		});

		jQuery("#fileImageGallery2").change(function(){
			var file = $(this)[0].files[0];
			img = new Image();
			img.src = _URL.createObjectURL(file);
			var imgwidth = 0;
			var imgheight = 0;
			img.onload = function () {
				imgwidth = this.width;
				imgheight = this.height;
				$('#width').val(imgwidth);
				$('#height').val(imgheight);
			}
			readURL(this, "ImageGallery2");
			encodeImagetoBase64(this, "ImageGallery2Base64");
			// alert("Current width=" + imgwidth + ", " + "Original height=" + imgheight);
		});

		jQuery("#fileImageGallery3").change(function(){
			var file = $(this)[0].files[0];
			img = new Image();
			img.src = _URL.createObjectURL(file);
			var imgwidth = 0;
			var imgheight = 0;
			img.onload = function () {
				imgwidth = this.width;
				imgheight = this.height;
				$('#width').val(imgwidth);
				$('#height').val(imgheight);
			}
			readURL(this, "ImageGallery3");
			encodeImagetoBase64(this, "ImageGallery3Base64");
			// alert("Current width=" + imgwidth + ", " + "Original height=" + imgheight);
		});

		jQuery("#fileImageGallery4").change(function(){
			var file = $(this)[0].files[0];
			img = new Image();
			img.src = _URL.createObjectURL(file);
			var imgwidth = 0;
			var imgheight = 0;
			img.onload = function () {
				imgwidth = this.width;
				imgheight = this.height;
				$('#width').val(imgwidth);
				$('#height').val(imgheight);
			}
			readURL(this, "ImageGallery4");
			encodeImagetoBase64(this, "ImageGallery4Base64");
			// alert("Current width=" + imgwidth + ", " + "Original height=" + imgheight);
		});


		jQuery("#fileImageGallery5").change(function(){
			var file = $(this)[0].files[0];
			img = new Image();
			img.src = _URL.createObjectURL(file);
			var imgwidth = 0;
			var imgheight = 0;
			img.onload = function () {
				imgwidth = this.width;
				imgheight = this.height;
				$('#width').val(imgwidth);
				$('#height').val(imgheight);
			}
			readURL(this, "ImageGallery5");
			encodeImagetoBase64(this, "ImageGallery5Base64");
			// alert("Current width=" + imgwidth + ", " + "Original height=" + imgheight);
		});

		jQuery("#fileImageGallery6").change(function(){
			var file = $(this)[0].files[0];
			img = new Image();
			img.src = _URL.createObjectURL(file);
			var imgwidth = 0;
			var imgheight = 0;
			img.onload = function () {
				imgwidth = this.width;
				imgheight = this.height;
				$('#width').val(imgwidth);
				$('#height').val(imgheight);
			}
			readURL(this, "ImageGallery6");
			encodeImagetoBase64(this, "ImageGallery6Base64");
			// alert("Current width=" + imgwidth + ", " + "Original height=" + imgheight);
		});

		jQuery("#fileImageGallery7").change(function(){
			var file = $(this)[0].files[0];
			img = new Image();
			img.src = _URL.createObjectURL(file);
			var imgwidth = 0;
			var imgheight = 0;
			img.onload = function () {
				imgwidth = this.width;
				imgheight = this.height;
				$('#width').val(imgwidth);
				$('#height').val(imgheight);
			}
			readURL(this, "ImageGallery7");
			encodeImagetoBase64(this, "ImageGallery7Base64");
			// alert("Current width=" + imgwidth + ", " + "Original height=" + imgheight);
		});

		jQuery("#fileImageGallery8").change(function(){
			var file = $(this)[0].files[0];
			img = new Image();
			img.src = _URL.createObjectURL(file);
			var imgwidth = 0;
			var imgheight = 0;
			img.onload = function () {
				imgwidth = this.width;
				imgheight = this.height;
				$('#width').val(imgwidth);
				$('#height').val(imgheight);
			}
			readURL(this, "ImageGallery8");
			encodeImagetoBase64(this, "ImageGallery8Base64");
			// alert("Current width=" + imgwidth + ", " + "Original height=" + imgheight);
		});

		jQuery("#fileImageGallery9").change(function(){
			var file = $(this)[0].files[0];
			img = new Image();
			img.src = _URL.createObjectURL(file);
			var imgwidth = 0;
			var imgheight = 0;
			img.onload = function () {
				imgwidth = this.width;
				imgheight = this.height;
				$('#width').val(imgwidth);
				$('#height').val(imgheight);
			}
			readURL(this, "ImageGallery9");
			encodeImagetoBase64(this, "ImageGallery9Base64");
			// alert("Current width=" + imgwidth + ", " + "Original height=" + imgheight);
		});

		jQuery("#fileImageGallery10").change(function(){
			var file = $(this)[0].files[0];
			img = new Image();
			img.src = _URL.createObjectURL(file);
			var imgwidth = 0;
			var imgheight = 0;
			img.onload = function () {
				imgwidth = this.width;
				imgheight = this.height;
				$('#width').val(imgwidth);
				$('#height').val(imgheight);
			}
			readURL(this, "ImageGallery10");
			encodeImagetoBase64(this, "ImageGallery10Base64");
			// alert("Current width=" + imgwidth + ", " + "Original height=" + imgheight);
		});

		jQuery("#fileImageGallery11").change(function(){
			var file = $(this)[0].files[0];
			img = new Image();
			img.src = _URL.createObjectURL(file);
			var imgwidth = 0;
			var imgheight = 0;
			img.onload = function () {
				imgwidth = this.width;
				imgheight = this.height;
				$('#width').val(imgwidth);
				$('#height').val(imgheight);
			}
			readURL(this, "ImageGallery11");
			encodeImagetoBase64(this, "ImageGallery11Base64");
			// alert("Current width=" + imgwidth + ", " + "Original height=" + imgheight);
		});

		jQuery("#fileImageGallery12").change(function(){
			var file = $(this)[0].files[0];
			img = new Image();
			img.src = _URL.createObjectURL(file);
			var imgwidth = 0;
			var imgheight = 0;
			img.onload = function () {
				imgwidth = this.width;
				imgheight = this.height;
				$('#width').val(imgwidth);
				$('#height').val(imgheight);
			}
			readURL(this, "ImageGallery12");
			encodeImagetoBase64(this, "ImageGallery12Base64");
			// alert("Current width=" + imgwidth + ", " + "Original height=" + imgheight);
		});



		$("#Attachment").change(function(){
			var file = $(this)[0].files[0];
			img = new Image();
			img.src = _URL.createObjectURL(file);
			var imgwidth = 0;
			var imgheight = 0;
			img.onload = function () {
				imgwidth = this.width;
				imgheight = this.height;
				$('#width').val(imgwidth);
				$('#height').val(imgheight);
			}
			readURL(this,"image_result");
			encodeImagetoBase64(this,"image_base64");
			// alert("Current width=" + imgwidth + ", " + "Original height=" + imgheight);
		});

		jQuery('#btInportItem').click(function () {
			var formData = new FormData();
			formData.append('BulkItemMaster', jQuery('#BulkItemMaster')[0].files[0]);

			$.ajax({
	            async:false,
	            type: 'post',
	            url: "{{route('companysetting-importitem')}}",
	            headers: {
	                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
	            },
	            data: formData,
	            processData: false,
                contentType: false,
	            success: function(response) {
	                // bindGridDetail(response.data)
	                // console.log(response);
					if (response.success) {
						Swal.fire({
							icon: "success",
							title: 'Horay',
							text: 'Data Berhasil Disimpan',
							// footer: '<a href>Why do I have this issue?</a>'
						}).then((result)=>{
							location.reload();
						});
					}
					else{
						Swal.fire({
							icon: "error",
							title: 'Error',
							text: response.message,
							// footer: '<a href>Why do I have this issue?</a>'
						});
					}
	            }
	        });
		});


		jQuery('#btInportHargaJual').click(function () {
			var formData = new FormData();
			formData.append('BulkHargaJual', jQuery('#BulkHargaJual')[0].files[0]);

			$.ajax({
	            async:false,
	            type: 'post',
	            url: "{{route('companysetting-importharga')}}",
	            headers: {
	                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
	            },
	            data: formData,
	            processData: false,
                contentType: false,
	            success: function(response) {
	                // bindGridDetail(response.data)
	                // console.log(response);
					if (response.success) {
						Swal.fire({
							icon: "success",
							title: 'Horay',
							text: 'Data Berhasil Disimpan',
							// footer: '<a href>Why do I have this issue?</a>'
						}).then((result)=>{
							location.reload();
						});
					}
					else{
						Swal.fire({
							icon: "error",
							title: 'Error',
							text: response.message,
							// footer: '<a href>Why do I have this issue?</a>'
						});
					}
	            }
	        });
		});

		jQuery('#btInportPelanggan').click(function () {
			var formData = new FormData();
			formData.append('BulkPelanggan', jQuery('#BulkPelanggan')[0].files[0]);

			$.ajax({
	            async:false,
	            type: 'post',
	            url: "{{route('companysetting-importpelanggan')}}",
	            headers: {
	                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
	            },
	            data: formData,
	            processData: false,
                contentType: false,
	            success: function(response) {
	                // bindGridDetail(response.data)
	                // console.log(response);
					if (response.success) {
						Swal.fire({
							icon: "success",
							title: 'Horay',
							text: 'Data Berhasil Disimpan',
							// footer: '<a href>Why do I have this issue?</a>'
						}).then((result)=>{
							location.reload();
						});
					}
					else{
						Swal.fire({
							icon: "error",
							title: 'Error',
							text: response.message,
							// footer: '<a href>Why do I have this issue?</a>'
						});
					}
	            }
	        });
		});

		jQuery('#btInportSupplier').click(function () {
			var formData = new FormData();
			formData.append('BulkSupplier', jQuery('#BulkSupplier')[0].files[0]);

			$.ajax({
	            async:false,
	            type: 'post',
	            url: "{{route('companysetting-importsupplier')}}",
	            headers: {
	                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
	            },
	            data: formData,
	            processData: false,
                contentType: false,
	            success: function(response) {
	                // bindGridDetail(response.data)
	                // console.log(response);
					if (response.success) {
						Swal.fire({
							icon: "success",
							title: 'Horay',
							text: 'Data Berhasil Disimpan',
							// footer: '<a href>Why do I have this issue?</a>'
						}).then((result)=>{
							location.reload();
						});
					}
					else{
						Swal.fire({
							icon: "error",
							title: 'Error',
							text: response.message,
							// footer: '<a href>Why do I have this issue?</a>'
						});
					}
	            }
	        });
		});

		function readURL(input, outputElement) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();
				
				reader.onload = function (e) {
				// console.log(e.target.result);
				$('#'+outputElement).html("<img src ='"+e.target.result+"'> ");
				}
				reader.readAsDataURL(input.files[0]);
			}
		}
		function encodeImagetoBase64(element, textOutput) {
			$('#'+textOutput).val('');
			var file = element.files[0];
			var reader = new FileReader();
			reader.onloadend = function() {
				// $(".link").attr("href",reader.result);
				// $(".link").text(reader.result);
				$('#'+textOutput).val(reader.result);
			}
			reader.readAsDataURL(file);
		}

		function PaymentGateWay(ButtonObject, ButtonDefaultText, NoTransaksi, TotalPembelian) {
			ButtonObject.text('Tunggu Sebentar.....');
			ButtonObject.attr('disabled',true);

			var oData = {
				'NoTransaksi' : NoTransaksi,
				'TotalPembelian' : TotalPembelian,
			}

			fetch( "{{route('invpengguna-create-gateway')}}", {
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
							// console.log(result);
							if(result.transaction_status == "cancel"){
								ButtonObject.text('Bayar');
  								ButtonObject.attr('disabled',false);

								Swal.fire({
									icon: "error",
									title: "Opps...",
									text: "Pembayaran Dibatalkan",
								});
							}
							else{
								// order_id
								// $('#NomorRefrensiPembayaran').val(result.order_id)
								console.log(result);
								var xData = {
									"BaseReff" : NoTransaksi,
									"MetodePembayaran" : result.payment_type+"#"+result.va_numbers[0]["bank"]+"#"+result.va_numbers[0]["va_number"],
									"NoReff" : result.order_id,
									"Keterangan" : result.transaction_id,
									"TotalBayar" : TotalPembelian
								}
								// SaveData(Status, ButonObject, ButtonDefaultText)
								$.ajax({
									async:false,
									type: 'post',
									url: "{{route('invpengguna-pay-gateway')}}",
									headers: {
										'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
									},
									data: JSON.stringify(xData),
									processData: false,
									contentType: false,
									success: function(response) {
										// bindGridDetail(response.data)
										// console.log(response);
										if (response.success) {
											Swal.fire({
												icon: "success",
												title: 'Horay',
												text: 'Data Berhasil Disimpan',
												// footer: '<a href>Why do I have this issue?</a>'
											}).then((result)=>{
												location.reload();
											});
										}
										else{
											ButtonObject.text('Bayar');
  											ButtonObject.attr('disabled',false);
											Swal.fire({
												icon: "error",
												title: 'Error',
												text: response.message,
												// footer: '<a href>Why do I have this issue?</a>'
											});
										}
									}
								});
							}
							// Proses pembayaran sukses
						},
						onPending: function(result){
							// console.log(result);
							// Pembayaran tertunda
						},
						onError: function(result){
							// console.log(result);
							ButtonObject.text('Bayar');
  							ButtonObject.attr('disabled',false);
							Swal.fire({
								icon: "error",
								title: "Opps...",
								text: result,
							})
							// Pembayaran gagal
						},
						onClose: function(){
							ButtonObject.text('Bayar');
  							ButtonObject.attr('disabled',false);
							console.log('customer closed the popup without finishing the payment');
						}
					});
				} else {
					ButtonObject.text('Bayar');
  					ButtonObject.attr('disabled',false);
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
	})

	document.addEventListener("DOMContentLoaded", function () {
    fetch('/get-meja')
        .then(response => response.json())
        .then(data => {
            let tableBody = document.getElementById("tableBookingList");
            if (!tableBody) {
                console.error("Element tableBookingList tidak ditemukan!");
                return;
            }
            tableBody.innerHTML = "";

            data.forEach((meja) => {
                let checked = meja.BisaDipesan == 1 ? "checked" : "";
                let row = `<tr>
                    <td style = 'display:none;'>${meja.id}</td>
                    <td>${meja.NamaTitikLampu}</td>
                    <td>
                        <input type="checkbox" class="meja-checkbox" data-id="${meja.id}" ${checked} />
                    </td>
                </tr>`;
                tableBody.innerHTML += row;
            });
        })
        .catch(error => console.error('Error fetching meja:', error));
});

document.addEventListener("change", function (event) {
    if (event.target.classList.contains('meja-checkbox')) {
        let mejaId = event.target.getAttribute('data-id');
        let bisaDipesan = event.target.checked ? 1 : 0;

        let xData = {
            "id": mejaId,
            "BisaDipesan": bisaDipesan,
        };

        $.ajax({
            type: 'POST',
            url: "/titiklampu/updateStatusMeja", 
            headers: {
										'X-CSRF-TOKEN': '{{ csrf_token() }}' 
									},
            data: JSON.stringify(xData),
            contentType: "application/json", 
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: "success",
                        title: 'Horay',
                        text: 'Data Meja Berhasil Diupdate',
                    }).then(() => {
                        //location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: 'Error',
                        text: response.message,
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", xhr.responseText);
                Swal.fire({
                    icon: "error",
                    title: 'Error',
                    text: 'Terjadi kesalahan saat memperbarui data.',
                });
            }
        });
    }
});


</script>
@endpush