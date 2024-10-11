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
										<div class="col-md-12">
	                            			<button type="button" class="btn btn-success text-white font-weight-bold me-1 mb-1" id="btTestPrint">Test Print</button>
	                            		</div>
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
								<form action="{{route('companysetting-edit')}}" method="post">
									@csrf
									<div class="row">
										<div class="col-md-3">
											<ul class="nav flex-column nav-pills mb-3" id="v-pills-tab1" role="tablist" aria-orientation="vertical">
												<li class="nav-item" >
													<a class="nav-link active" id="general-tab2" data-bs-toggle="pill" href="#general" role="tab" aria-controls="general" aria-selected="true">General</a>
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
					                            					<option value="Services" {{ count($company) > 0 ? $company[0]['JenisUsaha'] == 'Services' ? 'selected' : '' : '' }}>Service</option>
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

					                            		<div class="col-md-3">
					                            			<!-- <label  class="text-body">Lebar Printer</label> -->
					                            			<fieldset class="form-group mb-3">
					                            				<button type="button" class="btn btn-warning">Test Print</button>
					                            			</fieldset>
					                            		</div>
					                            		<div class="col-md-3">
					                            			<!-- <label  class="text-body">Lebar Printer</label> -->
					                            			<fieldset class="form-group mb-3">
					                            				<button type="button" class="btn btn-warning" id="testPrintUSB">Test Print Usb</button>
					                            			</fieldset>
					                            		</div>

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
																				{{-- <input type="text" class="form-control" id="BannerHeader1" name="BannerHeader1" placeholder="Masukan Banner" value="{{ count($company) > 0 ? $company[0]['BannerHeader1'] : '' }}"  > --}}
																				<textarea id="BannerHeader1" name="BannerHeader1" class="bg-transparent text-dark">
																					{{ count($company) > 0 ? $company[0]['BannerHeader1'] : '' }}
																				</textarea>
																			</fieldset>
																		</div>
				
																		<div class="col-sm-12">
																			<label  class="text-body">Banner Text</label>
																			<fieldset class="form-group mb-3">
																				{{-- <input type="text" class="form-control" id="BannerText1" name="BannerText1" placeholder="Masukan Banner Text" value="{{ count($company) > 0 ? $company[0]['BannerText1'] : '' }}"  > --}}
																				<textarea id="BannerText1" name="BannerText1" class="bg-transparent text-dark">
																					{{ count($company) > 0 ? $company[0]['BannerText1'] : '' }}
																				</textarea>
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
																				{{-- <input type="text" class="form-control" id="BannerHeader2" name="BannerHeader2" placeholder="Masukan Banner" value="{{ count($company) > 0 ? $company[0]['BannerHeader2'] : '' }}"  > --}}
																				<textarea id="BannerHeader2" name="BannerHeader2" class="bg-transparent text-dark">
																					{{ count($company) > 0 ? $company[0]['BannerHeader2'] : '' }}
																				</textarea>
																			</fieldset>
																		</div>
				
																		<div class="col-sm-12">
																			<label  class="text-body">Banner Text</label>
																			<fieldset class="form-group mb-3">
																				{{-- <input type="text" class="form-control" id="BannerText2" name="BannerText2" placeholder="Masukan Banner Text" value="{{ count($company) > 0 ? $company[0]['BannerText2'] : '' }}"  > --}}
																				<textarea id="BannerText2" name="BannerText2" class="bg-transparent text-dark">
																					{{ count($company) > 0 ? $company[0]['BannerText2'] : '' }}
																				</textarea>
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
																					{{-- <input type="text" class="form-control" id="BannerHeader2" name="BannerHeader2" placeholder="Masukan Banner" value="{{ count($company) > 0 ? $company[0]['BannerHeader2'] : '' }}"  > --}}
																					<textarea id="BannerHeader3" name="BannerHeader3" class="bg-transparent text-dark">
																						{{ count($company) > 0 ? $company[0]['BannerHeader2'] : '' }}
																					</textarea>
																				</fieldset>
																			</div>
					
																			<div class="col-sm-12">
																				<label  class="text-body">Banner Text</label>
																				<fieldset class="form-group mb-3">
																					{{-- <input type="text" class="form-control" id="BannerText2" name="BannerText2" placeholder="Masukan Banner Text" value="{{ count($company) > 0 ? $company[0]['BannerText2'] : '' }}"  > --}}
																					<textarea id="BannerText3" name="BannerText3" class="bg-transparent text-dark">
																						{{ count($company) > 0 ? $company[0]['BannerText3'] : '' }}
																					</textarea>
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
																			<th>Nama Paket</th>
																			<th>Total</th>
																			<th>Tgl Jatuh Tempo</th>
																			<th>Status</th>
																		</tr>
																	</thead>
																</table>
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
<script type="text/javascript">
var _URL = window.URL || window.webkitURL;
var _URLePub = window.URL || window.webkitURL;
var oCompany;
	$(function () {
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

			ClassicEditor.create(document.querySelector('#BannerHeader1')).then( editor => {})
			.catch( error => {
					console.error( error );
			});
			ClassicEditor.create(document.querySelector('#BannerHeader2')).then( editor => {})
			.catch( error => {
					console.error( error );
			});
			ClassicEditor.create(document.querySelector('#BannerHeader3')).then( editor => {})
			.catch( error => {
					console.error( error );
			});

			ClassicEditor.create(document.querySelector('#BannerText1')).then( editor => {})
			.catch( error => {
					console.error( error );
			});
			ClassicEditor.create(document.querySelector('#BannerText2')).then( editor => {})
			.catch( error => {
					console.error( error );
			});
			ClassicEditor.create(document.querySelector('#BannerText3')).then( editor => {})
			.catch( error => {
					console.error( error );
			});

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
					"url": "{{route('invpengguna-viewpercom')}}", // Replace with your API endpoint
					"type": "POST",
					"contentType": "application/json",
					headers: {
						'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
					},
					"data": function(d) {
						d.TglAwal = jQuery('#TglAwal').val();
                		d.TglAkhir = jQuery('#TglAkhir').val();
						d.Status = "";
						return JSON.stringify(d); // Send as JSON if required by the API
					},
					"dataSrc": "" // Adjust based on your API response structure (e.g., "data" if your data is nested)
				},
				"columns": [
					{ "data": "NamaSubscription" },
					{ "data": "TotalTagihan" },
					{ "data": "TglJatuhTempo" },
					{ "data": "StatusPembayaran" }
				]
			});
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

		jQuery('#Banner1').click(function(){
			$('#fileBanner1').click();
		});

		jQuery('#Banner2').click(function(){
			$('#fileBanner2').click();
		});

		jQuery('#Banner3').click(function(){
			$('#fileBanner3').click();
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
	})
</script>
@endpush