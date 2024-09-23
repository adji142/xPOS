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
</style>
<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">
					<a href="{{route('itemmaster')}}">Item Master</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Input Item Master</li>
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
										@if (count($itemmaster) > 0)
                                    		Edit Item Master
                                    		<input type="hidden" name="formtype" id="formtype" value="edit">
	                                	@else
	                                    	Tambah Item Master
	                                    	<input type="hidden" name="formtype" id="formtype" value="add">
	                                	@endif
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

                            	<div class="form-group row">
                            		<div class="col-md-12"> 
                            			<fieldset class="form-group mb-3">
                            				<textarea id = "image_base64" name = "image_base64" style="display: none;"> {{ count($itemmaster) > 0 ? $itemmaster[0]['Gambar'] : '' }} </textarea>
                            				
                            				<input type="file" id="Attachment" name="Attachment" accept=".jpg" class="btn btn-warning" style="display: none;"/>
                            				<div class="xContainer">
								                <div id="image_result" class="image_result">
								                	@if (count($itemmaster) > 0)
			                                    		<img src=" {{$itemmaster[0]['Gambar']}} ">
			                                    	@else
			                                    		<img src="https://www.generationsforpeace.org/wp-content/uploads/2018/03/empty.jpg">
				                                	@endif
								                </div>
								            </div>
                            			</fieldset>
                            			
                            		</div>
                            		

                            		<div class="col-md-3"> 
                            			<div class="checkbox">
                            				<label for="chkAutoNumbering">Kode Item</label>
                            				<!-- <input type="checkbox" class="checkbox-input" id="chkAutoNumbering" {{ count($itemmaster) > 0 ? 'disabled' : '' }}> -->
                            			</div>
                            			<fieldset class="form-group mb-3">
                            				<input type="text" class="form-control" id="KodeItem" name="KodeItem" placeholder="Masukan Kode Item" value="{{ count($itemmaster) > 0 ? $itemmaster[0]['KodeItem'] : '' }}" required="" {{ count($itemmaster) > 0 ? 'readonly' : '' }} >
                            			</fieldset>
                            			
                            		</div>
                            		
                            		<div class="col-md-9">
                            			<label  class="text-body">Nama Item</label>
                            			<fieldset class="form-group mb-3">
                            				<input type="text" class="form-control" id="NamaItem" name="NamaItem" placeholder="Masukan Nama Item" value="{{ count($itemmaster) > 0 ? $itemmaster[0]['NamaItem'] : '' }}" required="" onchange="SetEnableCommand();">
                            			</fieldset>
                            			
                            		</div>

                            		<div class="col-md-4">
                            			<label  class="text-body">Tipe Item</label>
                            			<fieldset class="form-group mb-3">
                            				<select name="TypeItem" id="TypeItem" class="js-example-basic-single js-states form-control bg-transparent">
												<option value="" {{ count($itemmaster) > 0 && $itemmaster[0]['TypeItem'] == '' ? 'selected' : '' }}>Pilih Type Item</option>
												<option value="1" {{ count($itemmaster) > 0 && $itemmaster[0]['TypeItem'] == '1' ? 'selected' : '' }}>Inventory</option>
												<option value="2" {{ count($itemmaster) > 0 && $itemmaster[0]['TypeItem'] == '2' ? 'selected' : '' }}>Non Inventory</option>
												<option value="3" {{ count($itemmaster) > 0 && $itemmaster[0]['TypeItem'] == '3' ? 'selected' : '' }}>Rakitan</option>
												<option value="4" {{ count($itemmaster) > 0 && $itemmaster[0]['TypeItem'] == '4' ? 'selected' : '' }}>Jasa</option>
												<option value="5" {{ count($itemmaster) > 0 && $itemmaster[0]['TypeItem'] == '5' ? 'selected' : '' }}>Konsinyasi</option>
												@if ($oCompany[0]["JenisUsaha"] == "FnB")
												<option value="6" {{ count($itemmaster) > 0 && $itemmaster[0]['TypeItem'] == '6' ? 'selected' : '' }}>Bahan Baku</option>
												@endif
											</select>
                            			</fieldset>
                            			
                            		</div>

                            		<div class="col-md-4">
                            			<label  class="text-body">Jenis Item</label>
                            			<fieldset class="form-group mb-3">
                            				<select name="KodeJenisItem" id="KodeJenisItem" class="js-example-basic-single js-states form-control bg-transparent">
												<option value="">Pilih Jenis Item</option>
												@foreach($jenisitem as $ko)
													<option value="{{ $ko->KodeJenis }}" {{ $ko->KodeJenis == (count($itemmaster) > 0 ? $itemmaster[0]['KodeJenisItem'] : '') ? 'selected' : '' }}>
			                                            {{ $ko->NamaJenis }}
			                                        </option>
												@endforeach
												
												<option value="-99" style="color: blue;">
													+ Tambah Baru
												</option>
											</select>
                            			</fieldset>
                            		</div>

                            		<div class="col-md-4">
                            			<label  class="text-body">Merk</label>
                            			<fieldset class="form-group mb-3">
                            				<select name="KodeMerk" id="KodeMerk" class="js-example-basic-single js-states form-control bg-transparent">
												<option value="">Pilih Merk</option>
												@foreach($merk as $ko)
													<option value="{{ $ko->KodeMerk }}" {{ $ko->KodeMerk == (count($itemmaster) > 0 ? $itemmaster[0]['KodeMerk'] : '') ? 'selected' : '' }}>
			                                            {{ $ko->NamaMerk }}
			                                        </option>
												@endforeach
												
												<option value="-99" style="color: blue;">
													+ Tambah Baru
												</option>
											</select>
                            			</fieldset>
                            		</div>

                            		<div class="col-md-6">
                            			<label  class="text-body">Supplier Utama</label>
                            			<fieldset class="form-group mb-3">
                            				<select name="KodeSupplier" id="KodeSupplier" class="js-example-basic-single js-states form-control bg-transparent">
												<option value="">Pilih Supplier</option>
												@foreach($supplier as $ko)
													<option value="{{ $ko->KodeSupplier }}" {{ $ko->KodeSupplier == (count($itemmaster) > 0 ? $itemmaster[0]['KodeSupplier'] : '') ? 'selected' : '' }}>
			                                            {{ $ko->NamaSupplier }}
			                                        </option>
												@endforeach
												
												<!-- <option value="-99" style="color: blue;">
													+ Tambah Baru
												</option> -->
											</select>
                            			</fieldset>
                            		</div>

                            		<div class="col-md-6">
                            			<label  class="text-body">Status</label>
                            			<fieldset class="form-group mb-3">
                            				<select name="Active" id="Active" class="js-example-basic-single js-states form-control bg-transparent" name="state" >
												<option value="Y" {{ count($supplier) > 0 ? $supplier[0]['Active'] == 'Y' ? "selected" : '' :""}}>Active</option>
												<option value="N" {{ count($supplier) > 0 ? $supplier[0]['Active'] == 'Y' ? "selected" : '' :""}}>Inactive</option>
											</select>
                            			</fieldset>
                            			
                            		</div>

                            		<hr>

                            		<ul class="nav nav-pills justify-content-center mb-3" id="pills-tab2" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="home-tab-center" data-bs-toggle="pill" href="#home-center" role="tab" aria-controls="home-center" aria-selected="true"> Inventory</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="service-tab" data-bs-toggle="pill" href="#service" role="tab" aria-controls="service" aria-selected="false">Accounting</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="account-tab" data-bs-toggle="pill" href="#account" role="tab" aria-controls="account" aria-selected="false">Rakitan</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="diskon-tab" data-bs-toggle="pill" href="#diskon" role="tab" aria-controls="diskon" aria-selected="false">Diskon</a>
                                        </li>
                                    </ul>
                                    <div class="row">

                                        <div class="col-12 px-4">
                                            <div class="tab-content" id="v-pills-tabContent2">
                                                <div class="tab-pane fade show active" id="home-center" role="tabpanel" aria-labelledby="home-tab-center">
                                                	<div class="row">
                                                		<div class="col-md-12">
					                            			<label  class="text-body">Barcode</label>
					                            			<fieldset class="form-group mb-3">
					                            				<input type="text" class="form-control" id="Barcode" name="Barcode" placeholder="Masukan Barcode" value="{{ count($itemmaster) > 0 ? $itemmaster[0]['Barcode'] : '' }}" required="">
					                            			</fieldset>
					                            			
					                            		</div>

					                            		<div class="col-md-4">
					                            			<label  class="text-body">Satuan</label>
					                            			<fieldset class="form-group mb-3">
					                            				<select name="Satuan" id="Satuan" class="js-example-basic-single js-states form-control bg-transparent">
																	<option value="">Pilih Satuan</option>
																	@foreach($satuan as $ko)
																		<option value="{{ $ko->KodeSatuan }}" {{ $ko->KodeSatuan == (count($itemmaster) > 0 ? $itemmaster[0]['Satuan'] : '') ? 'selected' : '' }}>
								                                            {{ $ko->NamaSatuan }}
								                                        </option>
																	@endforeach
																	
																	<option value="-99" style="color: blue;">
																		+ Tambah Baru
																	</option>
																</select>
					                            			</fieldset>
					                            		</div>

					                            		<div class="col-md-4">
					                            			<label  class="text-body">Gudang</label>
					                            			<fieldset class="form-group mb-3">
					                            				<select name="KodeGudang" id="KodeGudang" class="js-example-basic-single js-states form-control bg-transparent">
																	<option value="">Pilih Gudang</option>
																	@foreach($gudang as $ko)
																		<option value="{{ $ko->KodeGudang }}" {{ $ko->KodeGudang == (count($itemmaster) > 0 ? $itemmaster[0]['KodeGudang'] : '') ? 'selected' : '' }}>
								                                            {{ $ko->NamaGudang }}
								                                        </option>
																	@endforeach
																	
																	<option value="-99" style="color: blue;">
																		+ Tambah Baru
																	</option>
																</select>
					                            			</fieldset>
					                            		</div>

					                            		<div class="col-md-4">
					                            			<label  class="text-body">Rak</label>
					                            			<fieldset class="form-group mb-3">
					                            				<input type="text" class="form-control" id="Rak" name="Rak" placeholder="Masukan Rak" value="{{ count($itemmaster) > 0 ? $itemmaster[0]['Rak'] : '' }}" required="">
					                            			</fieldset>
					                            		</div>
					                            		<div class="col-md-6">
					                            			<label  class="text-body">Stock On Hand</label>
					                            			<fieldset class="form-group mb-3">
					                            				<input type="text" class="form-control" id="Stock" name="Stock" value="{{ count($itemmaster) > 0 ? $itemmaster[0]['Stock'] : '0' }}" readonly="">
					                            			</fieldset>
					                            		</div>
					                            		<div class="col-md-6">
					                            			<label  class="text-body">Qty Minimum</label>
					                            			<fieldset class="form-group mb-3">
					                            				<input type="text" class="form-control" id="StockMinimum" name="StockMinimum" value="{{ count($itemmaster) > 0 ? $itemmaster[0]['StockMinimum'] : '0' }}">
					                            			</fieldset>
					                            		</div>

					                            		<div class="col-md-4">
					                            			<label  class="text-body">Harga Pokok</label>
					                            			<fieldset class="form-group mb-3">
					                            				<input type="text" class="form-control" id="HargaPokokPenjualan" name="HargaPokokPenjualan" value="{{ count($itemmaster) > 0 ? $itemmaster[0]['HargaPokokPenjualan'] : '0' }}" {{ count($itemmaster) > 0 ? $itemmaster[0]['HargaPokokPenjualan'] > 0 ? "readonly" : "" : "" }}>
					                            			</fieldset>
					                            		</div>

					                            		<div class="col-md-4">
					                            			<label  class="text-body">Harga Jual</label>
					                            			<fieldset class="form-group mb-3">
					                            				<input type="text" class="form-control" id="HargaJual" name="HargaJual" value="{{ count($itemmaster) > 0 ? $itemmaster[0]['HargaJual'] : '0' }}">
					                            			</fieldset>
					                            		</div>

					                            		<div class="col-md-4">
					                            			<label  class="text-body">Harga Beli Terakhir</label>
					                            			<fieldset class="form-group mb-3">
					                            				<input type="text" class="form-control" id="HargaBeliTerakhir" name="HargaBeliTerakhir" value="{{ count($itemmaster) > 0 ? $itemmaster[0]['HargaBeliTerakhir'] : '0' }}" {{ count($itemmaster) > 0 ? $itemmaster[0]['HargaBeliTerakhir'] > 0 ? "readonly" : "" : "" }}>
					                            			</fieldset>
					                            		</div>
					                            		<center><b>Konversi Satuan</b></center>
					                            		<hr>
					                            		<div class="col-md-12">
                                                    		<div id="gridContainerKonversi">
                                                    				
                                                    		</div>
											              	<small style="color: red">Tekan Enter saat selesai edit data</small>
                                                    	</div>
                                                	</div>
                                                </div>
                                                <div class="tab-pane fade" id="service" role="tabpanel" aria-labelledby="service-tab">
                                                    <div class="row">
                                                    	<div class="col-md-12">
					                            			<label  class="text-body">PPN</label>
					                            			<fieldset class="form-group mb-3">
					                            				@if(count($itemmaster) > 0 && $itemmaster[0]['VatPercent'] > 0)
					                            					<input type="number" name="VatPercent" id="VatPercent" class="form-control" value="{{$itemmaster[0]['VatPercent']}}">
					                            				@elseif($oCompany[0]['PPN'] > 0)
					                            					<input type="number" name="VatPercent" id="VatPercent" class="form-control" value="{{ $oCompany[0]['PPN'] }}">
					                            				@else
					                            					<input type="number" name="VatPercent" id="VatPercent" class="form-control" value="0">
					                            				@endif
					                            			</fieldset>
					                            		</div>
                                                    	<div class="col-md-12">
					                            			<label  class="text-body">Harga Pokok Penjualan</label>
					                            			<fieldset class="form-group mb-3">
					                            				<select name="AcctHPP" id="AcctHPP" class="js-example-basic-single js-states form-control bg-transparent">
																	<option value="">Pilih Akun</option>
																	@foreach($rekeninghpp as $ko)
																		<option value="{{ $ko->KodeRekening }}" {{ $ko->KodeRekening == (count($itemmaster) > 0 ? $itemmaster[0]['AcctHPP'] : '') ? 'selected' : '' }}>
								                                            {{ $ko->NamaRekening }}
								                                        </option>
																	@endforeach
																</select>
					                            			</fieldset>
					                            		</div>

					                            		<div class="col-md-12">
					                            			<label  class="text-body">Pendapatan Penjualan Barang</label>
					                            			<fieldset class="form-group mb-3">
					                            				<select name="AcctPenjualan" id="AcctPenjualan" class="js-example-basic-single js-states form-control bg-transparent">
																	<option value="">Pilih Akun</option>
																	@foreach($rekeningpenjualan as $ko)
																		<option value="{{ $ko->KodeRekening }}" {{ $ko->KodeRekening == (count($itemmaster) > 0 ? $itemmaster[0]['AcctPenjualan'] : '') ? 'selected' : '' }}>
								                                            {{ $ko->NamaRekening }}
								                                        </option>
																	@endforeach
																</select>
					                            			</fieldset>
					                            		</div>

					                            		<div class="col-md-12">
					                            			<label  class="text-body">Pendapatan Penjualan Jasa</label>
					                            			<fieldset class="form-group mb-3">
					                            				<select name="AcctPenjualanJasa" id="AcctPenjualanJasa" class="js-example-basic-single js-states form-control bg-transparent">
																	<option value="">Pilih Akun</option>
																	@foreach($rekeningpenjualan as $ko)
																		<option value="{{ $ko->KodeRekening }}" {{ $ko->KodeRekening == (count($itemmaster) > 0 ? $itemmaster[0]['AcctPenjualanJasa'] : '') ? 'selected' : '' }}>
								                                            {{ $ko->NamaRekening }}
								                                        </option>
																	@endforeach
																</select>
					                            			</fieldset>
					                            		</div>

					                            		<div class="col-md-12">
					                            			<label  class="text-body">Persediaan Barang</label>
					                            			<fieldset class="form-group mb-3">
					                            				<select name="AcctPersediaan" id="AcctPersediaan" class="js-example-basic-single js-states form-control bg-transparent">
																	<option value="">Pilih Akun</option>
																	@foreach($rekeninginventory as $ko)
																		<option value="{{ $ko->KodeRekening }}" {{ $ko->KodeRekening == (count($itemmaster) > 0 ? $itemmaster[0]['AcctPersediaan'] : '') ? 'selected' : '' }}>
								                                            {{ $ko->NamaRekening }}
								                                        </option>
																	@endforeach
																</select>
					                            			</fieldset>
					                            		</div>

                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="account" role="tabpanel" aria-labelledby="account-tab">
                                                    <div class="row">
                                                    	<div class="col-md-12">
											              	<div id="gridContainerRakitan"></div>
											              	<small style="color: red">Tekan Enter saat selesai edit data</small>
                                                    	</div>
                                                    </div>
                                                </div>

                                                <div class="tab-pane fade" id="diskon" role="tabpanel" aria-labelledby="diskon-tab">
                                                    <div class="row">
                                                    	<div class="col-md-12">
                                                    		<div id="gridContainerDiskon"></div>
											              	<small style="color: red">Tekan Enter saat selesai edit data</small>

                                                    	</div>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                    	<div class="col-md-12">
	                            			<button type="button" class="btn btn-success text-white font-weight-bold me-1 mb-1" id="btSaveItem">Simpan</button>
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


<div class="modal fade" id="AddJenisItem" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-dialog-scrollable" role="document">
		<div class="modal-content">
			<div class="modal-header">
			  <h5 class="modal-title" id="exampleModalScrollableTitle">Tambah Jenis Item</h5>
			  <button type="button" class="close rounded-pill btn btn-sm btn-icon btn-light btn-hover-primary m-0" data-bs-dismiss="modal" aria-label="Close">
				<svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-x" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
					<path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
				</svg>
			  </button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label for="exampleInputEmail1">Kode Jenis Item</label>
					<input type="text" name="ModalKodeJenis" class="form-control" id="ModalKodeJenis" aria-describedby="emailHelp">
				</div>
				<div class="form-group">
					<label for="exampleInputEmail1">Nama Jenis Item</label>
					<input type="text" name="ModalNamaJenis" class="form-control" id="ModalNamaJenis" aria-describedby="emailHelp">
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-light" data-bs-dismiss="modal"> 
					<span class="">Batal</span>
				</button>
				<button type="button" class="btn btn-primary ms-1" id="btSaveJenisItem">
					<span class="">Simpan</span>
				</button>
			</div> 		
		</div>
	</div>
</div>


<div class="modal fade" id="AddMerk" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable" role="document">
		<div class="modal-content">
			<div class="modal-header">
			  <h5 class="modal-title" id="exampleModalScrollableTitle">Tambah Merk</h5>
			  <button type="button" class="close rounded-pill btn btn-sm btn-icon btn-light btn-hover-primary m-0" data-bs-dismiss="modal" aria-label="Close">
				<svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-x" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
					<path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
				</svg>
			  </button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label for="exampleInputEmail1">Kode Merk</label>
					<input type="text" name="ModalKodeMerk" class="form-control" id="ModalKodeMerk" aria-describedby="emailHelp">
				</div>
				<div class="form-group">
					<label for="exampleInputEmail1">Nama Merk</label>
					<input type="text" name="ModalNamaMerk" class="form-control" id="ModalNamaMerk" aria-describedby="emailHelp">
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-light" data-bs-dismiss="modal"> 
					<span class="">Batal</span>
				</button>
				<button type="button" class="btn btn-primary ms-1" id="btSaveMerk">
					<span class="">Simpan</span>
				</button>
			</div> 		
		</div>
	</div>
</div>


<div class="modal fade" id="AddSatuan" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable" role="document">
		<div class="modal-content">
			<div class="modal-header">
			  <h5 class="modal-title" id="exampleModalScrollableTitle">Tambah Satuan</h5>
			  <button type="button" class="close rounded-pill btn btn-sm btn-icon btn-light btn-hover-primary m-0" data-bs-dismiss="modal" aria-label="Close">
				<svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-x" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
					<path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
				</svg>
			  </button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label for="exampleInputEmail1">Kode Satuan</label>
					<input type="text" name="ModalKodeSatuan" class="form-control" id="ModalKodeSatuan" aria-describedby="emailHelp">
				</div>
				<div class="form-group">
					<label for="exampleInputEmail1">Nama Satuan</label>
					<input type="text" name="ModalNamaSatuan" class="form-control" id="ModalNamaSatuan" aria-describedby="emailHelp">
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-light" data-bs-dismiss="modal"> 
					<span class="">Batal</span>
				</button>
				<button type="button" class="btn btn-primary ms-1" id="btSaveSatuan">
					<span class="">Simpan</span>
				</button>
			</div> 		
		</div>
	</div>
</div>

<div class="modal fade" id="AddGudang" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable" role="document">
		<div class="modal-content">
			<div class="modal-header">
			  <h5 class="modal-title" id="exampleModalScrollableTitle">Tambah Gudang</h5>
			  <button type="button" class="close rounded-pill btn btn-sm btn-icon btn-light btn-hover-primary m-0" data-bs-dismiss="modal" aria-label="Close">
				<svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-x" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
					<path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
				</svg>
			  </button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label for="exampleInputEmail1">Kode Gudang</label>
					<input type="text" name="ModalKodeGudang" class="form-control" id="ModalKodeGudang" aria-describedby="emailHelp">
				</div>
				<div class="form-group">
					<label for="exampleInputEmail1">Nama Gudang</label>
					<input type="text" name="ModalNamaGudang" class="form-control" id="ModalNamaGudang" aria-describedby="emailHelp">
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-light" data-bs-dismiss="modal"> 
					<span class="">Batal</span>
				</button>
				<button type="button" class="btn btn-primary ms-1" id="btSaveGudang">
					<span class="">Simpan</span>
				</button>
			</div> 		
		</div>
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

@endsection

@push('scripts')
@extends('parts.generaljs')
<script type="text/javascript">
	var _URL = window.URL || window.webkitURL;
    var _URLePub = window.URL || window.webkitURL;

	var oItem = <?php echo $itembahanrakitan; ?> ;
	var oJenisDiskon = [];
	var oErrorList = [];
	var oItemMaster = [];
	var _selectedRow = -1;

	jQuery(document).ready(function() {

		var otempItem = {
			"KodeJenisDiskon" : "P",
			"NamaJenisDiskon" : "Prosentase"
		};
		oJenisDiskon.push(otempItem);

		var otempItem = {
			"KodeJenisDiskon" : "N",
			"NamaJenisDiskon" : "Nominal"
		};
		oJenisDiskon.push(otempItem);

		var dataSetting = <?php echo $settingaccount; ?>
		// console.log(dataSetting);

		var ItemMasterDataEdited = <?php echo $itemmaster ?>;
		var bahanrakitan = <?php echo $bahanrakitan ?>;
		var diskon = <?php echo $diskon ?>;
		var itemkonversi = <?php echo $itemkonversi ?>;
		oItemMaster = <?php echo $itembahanrakitan ?>;

		// console.log(ItemMasterDataEdited)
		if (ItemMasterDataEdited.length > 0) {
			if(ItemMasterDataEdited[0]['AcctHPP'] == ""){
				jQuery('#AcctHPP').val(dataSetting[0]['InvAcctHargaPokokPenjualan']).trigger('change');
			}
			if(ItemMasterDataEdited[0]['AcctPenjualan'] == ""){
				jQuery('#AcctPenjualan').val(dataSetting[0]['InvAcctPendapatanJual']).trigger('change');
			}
			if(ItemMasterDataEdited[0]['AcctPenjualanJasa'] == ""){
				jQuery('#AcctPenjualanJasa').val(dataSetting[0]['InvAcctPendapatanJasa']).trigger('change');
			}
			if(ItemMasterDataEdited[0]['AcctPersediaan'] == ""){
				jQuery('#AcctPersediaan').val(dataSetting[0]['InvAcctPersediaan']).trigger('change');
			}	
		}

		if (bahanrakitan.length > 0) {
			bindGrid(bahanrakitan)
		}
		else{
			bindGrid([])
		}
		if (diskon.length > 0) {
			var oDiskon = [];

			var oIndex = 0;
			$.each(diskon,function (k,v) {
				var oItem = {Nomor:oIndex +1, QtyMinimum: v.Minimal, TipeDiskon:v.TipeDiskon, Diskon: v.Diskon}

				// console.log(oItem)
				oDiskon.push(oItem);
				oIndex +=1;
			})

			bindDiskon(oDiskon)
		}
		else{
			bindDiskon([])
		}

		if (itemkonversi.length > 0) {
			var oKonversi = [];

			var oIndex = 0;
			$.each(itemkonversi,function (k,v) {
				var newData = {Nomor : oIndex +1,Satuan: v.Satuan, QtyKonversi: v.QtyKonversi, HargaPokok:v.HargaPokok, HargaJual: v.HargaJual,Barcode:v.Barcode}

				// console.log(newData)
				oKonversi.push(newData);
				oIndex +=1;
			})

			bindKonversi(oKonversi)
		}
		else{
			bindKonversi([])	
		}
		// jQuery('#image_result').html("<img src ='https://www.generationsforpeace.org/wp-content/uploads/2018/03/empty.jpg' width = '400'> ");
		SetEnableCommand();
	});

	jQuery('#KodeJenisItem').change(function () {
		if (jQuery('#KodeJenisItem').val() == -99) {
			jQuery('#AddJenisItem').modal({backdrop: 'static', keyboard: false})
			jQuery('#AddJenisItem').modal('show');
		}
		SetEnableCommand();
	});

	jQuery('#KodeMerk').change(function () {
		if (jQuery('#KodeMerk').val() == -99 ) {
			jQuery('#AddMerk').modal({backdrop: 'static', keyboard: false})
			jQuery('#AddMerk').modal('show');
		}
		SetEnableCommand();
	})

	jQuery('#Satuan').change(function () {
		if (jQuery('#Satuan').val() == -99) {
			jQuery('#AddSatuan').modal({backdrop: 'static', keyboard: false})
			jQuery('#AddSatuan').modal('show');
		}
		SetEnableCommand();
	})

	jQuery('#KodeGudang').change(function () {
		if (jQuery('#KodeGudang').val() == -99) {
			jQuery('#AddGudang').modal({backdrop: 'static', keyboard: false})
			jQuery('#AddGudang').modal('show');
		}
		SetEnableCommand();
	});

	jQuery('#btSaveJenisItem').click(function () {
		jQuery('#btSaveJenisItem').text('Tunggu Sebentar.....');
      	jQuery('#btSaveJenisItem').attr('disabled',true);

      	var ModalKodeJenis = jQuery('#ModalKodeJenis').val();
      	var ModalNamaJenis = jQuery('#ModalNamaJenis').val();

      	$.ajax({
      		async:false,
      		type: 'post',
			url: "{{route('jenisitem-storeJson')}}",
			headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
            },
            data: {
            	'KodeJenis' : ModalKodeJenis,
            	'NamaJenis' : ModalNamaJenis
            },
            dataType: 'json',
            success: function(response) {
            	// console.log(response);
            	if (response.success == true) {

            		jQuery('#AddJenisItem').modal('toggle');
		            Swal.fire({
		              type: 'success',
		              title: 'Horay',
		              text: 'Data Berhasil Disimpan',
		              // footer: '<a href>Why do I have this issue?</a>'
		            }).then((result)=>{
	      				// jQuery('#KodeJenisItem').val(ModalKodeJenis).trigger('change');
	      				FillComboJenis(ModalKodeJenis)
		            });
            	}
            	else{
            		jQuery('#AddJenisItem').modal('toggle');
		            Swal.fire({
		              type: 'error',
		              title: 'Woops...',
		              text: response.message,
		              // footer: '<a href>Why do I have this issue?</a>'
		            }).then((result)=>{
		            	jQuery('#AddJenisItem').modal({backdrop: 'static', keyboard: false})
		            	jQuery('#AddJenisItem').modal('show');
		            	jQuery('#btSaveJenisItem').text('Simpan');
      					jQuery('#btSaveJenisItem').attr('disabled',false);
		            });
					
            	}
            }
		})
	});

	jQuery('#btSaveMerk').click(function () {
		jQuery('#btSaveMerk').text('Tunggu Sebentar.....');
      	jQuery('#btSaveMerk').attr('disabled',true);

      	var ModalKodeMerk = jQuery('#ModalKodeMerk').val();
      	var ModalNamaMerk = jQuery('#ModalNamaMerk').val();

      	$.ajax({
      		async:false,
      		type: 'post',
			url: "{{route('merk-storeJson')}}",
			headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
            },
            data: {
            	'KodeMerk' : ModalKodeMerk,
            	'NamaMerk' : ModalNamaMerk
            },
            dataType: 'json',
            success: function(response) {
            	// console.log(response);
            	if (response.success == true) {

            		jQuery('#AddMerk').modal('toggle');
		            Swal.fire({
		              type: 'success',
		              title: 'Horay',
		              text: 'Data Berhasil Disimpan',
		              // footer: '<a href>Why do I have this issue?</a>'
		            }).then((result)=>{
	      				// jQuery('#KodeJenisItem').val(ModalKodeJenis).trigger('change');
	      				FillComboMerk(ModalKodeMerk)
		            });
            	}
            	else{
            		jQuery('#AddMerk').modal('toggle');
		            Swal.fire({
		              type: 'error',
		              title: 'Woops...',
		              text: response.message,
		              // footer: '<a href>Why do I have this issue?</a>'
		            }).then((result)=>{
		            	jQuery('#AddMerk').modal({backdrop: 'static', keyboard: false})
		            	jQuery('#AddMerk').modal('show');
		            	jQuery('#btSaveMerk').text('Simpan');
      					jQuery('#btSaveMerk').attr('disabled',false);
		            });
					
            	}
            }
		})
	});

	jQuery('#btSaveSatuan').click(function () {
		jQuery('#btSaveSatuan').text('Tunggu Sebentar.....');
      	jQuery('#btSaveSatuan').attr('disabled',true);

      	var ModalKodeSatuan = jQuery('#ModalKodeSatuan').val();
      	var ModalNamaSatuan = jQuery('#ModalNamaSatuan').val();

      	$.ajax({
      		async:false,
      		type: 'post',
			url: "{{route('satuan-storeJson')}}",
			headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
            },
            data: {
            	'KodeSatuan' : ModalKodeSatuan,
            	'NamaSatuan' : ModalNamaSatuan
            },
            dataType: 'json',
            success: function(response) {
            	// console.log(response);
            	if (response.success == true) {

            		jQuery('#AddSatuan').modal('toggle');
		            Swal.fire({
		              type: 'success',
		              title: 'Horay',
		              text: 'Data Berhasil Disimpan',
		              // footer: '<a href>Why do I have this issue?</a>'
		            }).then((result)=>{
	      				// jQuery('#KodeJenisItem').val(ModalKodeJenis).trigger('change');
	      				FillComboSatuan(ModalKodeSatuan)
		            });
            	}
            	else{
            		jQuery('#AddSatuan').modal('toggle');
		            Swal.fire({
		              type: 'error',
		              title: 'Woops...',
		              text: response.message,
		              // footer: '<a href>Why do I have this issue?</a>'
		            }).then((result)=>{
		            	jQuery('#AddSatuan').modal({backdrop: 'static', keyboard: false})
		            	jQuery('#AddSatuan').modal('show');
		            	jQuery('#btSaveSatuan').text('Simpan');
      					jQuery('#btSaveSatuan').attr('disabled',false);
		            });
					
            	}
            }
		})
	});

	jQuery('#btSaveGudang').click(function () {
		jQuery('#btSaveGudang').text('Tunggu Sebentar.....');
      	jQuery('#btSaveGudang').attr('disabled',true);

      	var ModalKodeGudang = jQuery('#ModalKodeGudang').val();
      	var ModalNamaGudang = jQuery('#ModalNamaGudang').val();

      	$.ajax({
      		async:false,
      		type: 'post',
			url: "{{route('gudang-storeJson')}}",
			headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
            },
            data: {
            	'KodeGudang' : ModalKodeGudang,
            	'NamaGudang' : ModalNamaGudang
            },
            dataType: 'json',
            success: function(response) {
            	// console.log(response);
            	if (response.success == true) {

            		jQuery('#AddGudang').modal('toggle');
		            Swal.fire({
		              type: 'success',
		              title: 'Horay',
		              text: 'Data Berhasil Disimpan',
		              // footer: '<a href>Why do I have this issue?</a>'
		            }).then((result)=>{
	      				// jQuery('#KodeJenisItem').val(ModalKodeJenis).trigger('change');
	      				FillComboGudang(ModalKodeGudang)
		            });
            	}
            	else{
            		jQuery('#AddGudang').modal('toggle');
		            Swal.fire({
		              type: 'error',
		              title: 'Woops...',
		              text: response.message,
		              // footer: '<a href>Why do I have this issue?</a>'
		            }).then((result)=>{
		            	jQuery('#AddGudang').modal({backdrop: 'static', keyboard: false})
		            	jQuery('#AddGudang').modal('show');
		            	jQuery('#btSaveGudang').text('Simpan');
      					jQuery('#btSaveGudang').attr('disabled',false);
		            });
					
            	}
            }
		})
	});

	jQuery('#btSaveItem').click(function () {
		jQuery('#btSaveItem').text('Tunggu Sebentar');
		jQuery('#btSaveItem').attr('disabled',true);

		var oItemBahan = [];
		var oDiskon = [];
		var oKonversi = [];

		var dataGridInstance = jQuery('#gridContainerRakitan').dxDataGrid('instance');
        var allRowsData  = dataGridInstance.getDataSource().items();

        var GridDiskon = jQuery('#gridContainerDiskon').dxDataGrid('instance');
        var RowDataDiskon  = GridDiskon.getDataSource().items();

        var GridKonversi = jQuery('#gridContainerKonversi').dxDataGrid('instance');
        var RowDataKonversi  = GridKonversi.getDataSource().items();

        console.log(RowDataKonversi);


        if (allRowsData.length > 0) {
        	for (var i = 0; i < allRowsData.length; i++) {
        		if (allRowsData[i]['KodeItemBahan'] != "") {
        			var item = {
	        			'KodeItemHasil' : jQuery('#KodeItem').val(),
	        			'QtyHasil' 		: 1,
						'KodeItemBahan' : allRowsData[i]['KodeItemBahan'],
						'QtyBahan' : allRowsData[i]['QtyBahan'],
						'Satuan' : allRowsData[i]['Satuan'],
					}
					oItemBahan.push(item)
        		}
        	}
        }

        if (RowDataDiskon.length > 0) {
        	for (var i = 0; i < RowDataDiskon.length; i++) {
        		if (RowDataDiskon[i]['QtyMinimum'] > 0) {
        			var item = {
	        			'QtyMinimum' 	: RowDataDiskon[i]['QtyMinimum'],
	        			'TipeDiskon' 	: RowDataDiskon[i]['TipeDiskon'],
						'Diskon' 		: RowDataDiskon[i]['Diskon']
					}
					oDiskon.push(item)
        		}
        	}
        }

        if (RowDataKonversi.length > 0) {
        	for (var i = 0; i < RowDataKonversi.length; i++) {
        		if (RowDataKonversi[i]['Satuan'] != "") {
        			var item = {
	        			'Satuan' : RowDataKonversi[i]['Satuan'],
						'QtyKonversi' : RowDataKonversi[i]['QtyKonversi'],
						'HargaPokok' : RowDataKonversi[i]['HargaPokok'],
						'HargaJual' : RowDataKonversi[i]['HargaJual'],
						'Barcode' : RowDataKonversi[i]['Barcode'],
					}
					oKonversi.push(item)
        		}
        	}
        }

        var oData = {
        	'KodeItem' : jQuery('#KodeItem').val(),
			'NamaItem' : jQuery('#NamaItem').val(),
			'KodeJenisItem' : jQuery('#KodeJenisItem').val(),
			'KodeMerk' : jQuery('#KodeMerk').val(),
			'TypeItem' : jQuery('#TypeItem').val(),
			'Rak' : jQuery('#Rak').val(),
			'KodeGudang' : jQuery('#KodeGudang').val(),
			'KodeSupplier' : jQuery('#KodeSupplier').val(),
			'Satuan' : jQuery('#Satuan').val(),
			'Barcode' : jQuery('#Barcode').val(),
			'Gambar' : jQuery('#Gambar').val(),
			'HargaPokokPenjualan' : jQuery('#HargaPokokPenjualan').val(),
			'HargaJual' : jQuery('#HargaJual').val(),
			'HargaBeliTerakhir' : jQuery('#HargaBeliTerakhir').val(),
			'Stock' : jQuery('#Stock').val(),
			'StockMinimum' : jQuery('#StockMinimum').val(),
			'isKonsinyasi' : jQuery('#isKonsinyasi').val(),
			'Active' : jQuery('#Active').val(),
			'AcctHPP' : jQuery('#AcctHPP').val(),
			'AcctPenjualan' : jQuery('#AcctPenjualan').val(),
			'AcctPenjualanJasa' : jQuery('#AcctPenjualanJasa').val(),
			'AcctPersediaan' : jQuery('#AcctPersediaan').val(),
			'Gambar' : jQuery('#image_base64').val(),
			'VatPercent' :jQuery('#VatPercent').val(),
			'BahanRakitan' : oItemBahan,
			'DiskonSetting' : oDiskon,
			'ItemKonversi' : oKonversi
        }

        var formtype = jQuery('#formtype').val();

        console.log(allRowsData)
        if (formtype == "add") {
        	$.ajax({
				url: "{{route('itemmaster-store')}}",
				type: 'POST',
				contentType: 'application/json',
				headers: {
	                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
	            },
	            data: JSON.stringify(oData),
	            success: function(response) {
	            	if (response.success == true) {
	            		Swal.fire({
	                        html: "Data berhasil disimpan!",
	                        icon: "success",
	                        title: "Horray...",
	                        // text: "Data berhasil disimpan! <br> " + response.Kembalian,
	                    }).then((result)=>{
	                        jQuery('#btSaveItem').text('Save');
	                        jQuery('#btSaveItem').attr('disabled',false);
	                        // location.reload();
	                        window.location.href = '{{url("itemmaster")}}';
	                    });
	            	}
	            	else{
	            		Swal.fire({
	                      icon: "error",
	                      title: "Opps...",
	                      text: response.message,
	                    })
	                    jQuery('#btSaveItem').text('Save');
	                    jQuery('#btSaveItem').attr('disabled',false);
	            	}
	            }
			})
        }
        else if (formtype == "edit") {
        	$.ajax({
				url: "{{route('itemmaster-edit')}}",
				type: 'POST',
				contentType: 'application/json',
				headers: {
	                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
	            },
	            data: JSON.stringify(oData),
	            success: function(response) {
	            	if (response.success == true) {
	            		Swal.fire({
	                        html: "Data berhasil disimpan!",
	                        icon: "success",
	                        title: "Horray...",
	                        // text: "Data berhasil disimpan! <br> " + response.Kembalian,
	                    }).then((result)=>{
	                        jQuery('#btSaveItem').text('Save');
	                        jQuery('#btSaveItem').attr('disabled',false);
	                        // location.reload();
	                        window.location.href = '{{url("itemmaster")}}';
	                    });
	            	}
	            	else{
	            		Swal.fire({
	                      icon: "error",
	                      title: "Opps...",
	                      text: response.message,
	                    })
	                    jQuery('#btSaveItem').text('Save');
	                    jQuery('#btSaveItem').attr('disabled',false);
	            	}
	            }
			})
        }

	})

	jQuery('#btSelectItem').click(function () {
		var dataGridInstance = jQuery('#gridLookupitem').dxDataGrid('instance');
		var dataGridDetailInstance = jQuery('#gridContainerRakitan').dxDataGrid('instance');

		var selectedRows = dataGridInstance.getSelectedRowsData();

		console.log(selectedRows[0]["KodeItem"]);
		if (selectedRows.length > 0) {

			dataGridDetailInstance.cellValue(_selectedRow, "KodeItemBahan", selectedRows[0]["KodeItem"]);
			dataGridDetailInstance.cellValue(_selectedRow, "QtyBahan", 1);
		    dataGridDetailInstance.cellValue(_selectedRow, "Satuan", selectedRows[0]["Satuan"]);
		    dataGridDetailInstance.cellValue(_selectedRow, "NamaItem", selectedRows[0]["NamaItem"]);

	        dataGridDetailInstance.refresh();
	        dataGridDetailInstance.saveEditData();
			// CalculateTotal();
		}
	});

	jQuery('#image_result').click(function(){
        $('#Attachment').click();
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
      readURL(this);
      encodeImagetoBase64(this);
      // alert("Current width=" + imgwidth + ", " + "Original height=" + imgheight);
    });

    function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
          
        reader.onload = function (e) {
          // console.log(e.target.result);
          $('#image_result').html("<img src ='"+e.target.result+"'> ");
        }
        reader.readAsDataURL(input.files[0]);
      }
    }
    function encodeImagetoBase64(element) {
      $('#image_base64').val('');
        var file = element.files[0];
        var reader = new FileReader();
        reader.onloadend = function() {
          // $(".link").attr("href",reader.result);
          // $(".link").text(reader.result);
          $('#image_base64').val(reader.result);
        }
        reader.readAsDataURL(file);
    }

	// Repopulate
	function FillComboJenis(KodeJenis) {
		$.ajax({
      		async:false,
      		type: 'post',
			url: "{{route('jenisitem-ViewJson')}}",
			headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
            },
            data: {},
            dataType: 'json',
            success: function(response) {
            	jQuery('#KodeJenisItem').empty();
            	var newOption = jQuery('<option>', {
		        	value: "",
		        	text: "Pilih Jenis Item"
		        });
		        jQuery('#KodeJenisItem').append(newOption);

		        $.each(response.data,function (k,v) {
		        	var newOption = jQuery('<option>', {
			        	value: v.KodeJenis,
			        	text: v.NamaJenis
			        });

			        jQuery('#KodeJenisItem').append(newOption);
		        });

		        var newOption = jQuery('<option>', {
		        	value: -99,
		        	text: "+ Tambah Baru"
		        });
		        jQuery('#KodeJenisItem').append(newOption);

		        jQuery('#KodeJenisItem').val(KodeJenis).trigger('change');
            }
		})
	}

	function FillComboMerk(KodeMerk) {
		$.ajax({
      		async:false,
      		type: 'post',
			url: "{{route('merk-ViewJson')}}",
			headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
            },
            data: {},
            dataType: 'json',
            success: function(response) {
            	jQuery('#KodeMerk').empty();
            	var newOption = jQuery('<option>', {
		        	value: "",
		        	text: "Pilih Merk"
		        });
		        jQuery('#KodeMerk').append(newOption);

		        $.each(response.data,function (k,v) {
		        	var newOption = jQuery('<option>', {
			        	value: v.KodeMerk,
			        	text: v.NamaMerk
			        });

			        jQuery('#KodeMerk').append(newOption);
		        });

		        var newOption = jQuery('<option>', {
		        	value: -99,
		        	text: "+ Tambah Baru"
		        });
		        jQuery('#KodeMerk').append(newOption);

		        jQuery('#KodeMerk').val(KodeMerk).trigger('change');
            }
		})
	}

	function FillComboSatuan(KodeSatuan) {
		$.ajax({
      		async:false,
      		type: 'post',
			url: "{{route('satuan-ViewJson')}}",
			headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
            },
            data: {},
            dataType: 'json',
            success: function(response) {
            	jQuery('#Satuan').empty();
            	var newOption = jQuery('<option>', {
		        	value: "",
		        	text: "Pilih Satuan"
		        });
		        jQuery('#Satuan').append(newOption);

		        $.each(response.data,function (k,v) {
		        	var newOption = jQuery('<option>', {
			        	value: v.Satuan,
			        	text: v.NamaSatuan
			        });

			        jQuery('#Satuan').append(newOption);
		        });

		        var newOption = jQuery('<option>', {
		        	value: -99,
		        	text: "+ Tambah Baru"
		        });
		        jQuery('#Satuan').append(newOption);

		        jQuery('#Satuan').val(KodeSatuan).trigger('change');
            }
		})
	}

	function FillComboGudang(KodeGudang) {
		$.ajax({
      		async:false,
      		type: 'post',
			url: "{{route('gudang-ViewJson')}}",
			headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
            },
            data: {},
            dataType: 'json',
            success: function(response) {
            	jQuery('#KodeGudang').empty();
            	var newOption = jQuery('<option>', {
		        	value: "",
		        	text: "Pilih Merk"
		        });
		        jQuery('#KodeGudang').append(newOption);

		        $.each(response.data,function (k,v) {
		        	var newOption = jQuery('<option>', {
			        	value: v.KodeGudang,
			        	text: v.NamaGudang
			        });

			        jQuery('#KodeGudang').append(newOption);
		        });

		        var newOption = jQuery('<option>', {
		        	value: -99,
		        	text: "+ Tambah Baru"
		        });
		        jQuery('#KodeGudang').append(newOption);

		        jQuery('#KodeGudang').val(KodeGudang).trigger('change');
            }
		})
	}

	function bindKonversi(data) {
		var datagridKonversi = jQuery("#gridContainerKonversi").dxDataGrid({
			allowColumnResizing: true,
			dataSource: data,
			keyExpr: "Nomor",
			showBorders: true,
            allowColumnReordering: true,
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
            columns:[
            	{
                    type: "buttons",
                    buttons: ["edit", "delete"],
                    visible: true,
                    fixed: true,
                },
                {
                    dataField: "Nomor",
                    caption: "#",
                    allowEditing:false,
                },
                {
                	// oJenisDiskon
                    dataField: "Satuan",
                    caption: "Satuan",
                    allowEditing:true,
                    lookup: {
					    dataSource: <?php echo $satuan; ?>,
					    valueExpr: 'KodeSatuan',
					    displayExpr: 'NamaSatuan',
				    },
				     editorType: "dxSelectBox"
                },
                {
                    dataField: "QtyKonversi",
                    caption: "Qty Konversi",
                    allowEditing:true,
                },
                {
                    dataField: "HargaPokok",
                    caption: "Harga Pokok Konversi",
                    allowEditing:true,
                    format: { type: 'fixedPoint', precision: 2 },
                },
                {
                    dataField: "HargaJual",
                    caption: "Harga Jual Konversi",
                    allowEditing:true,
                    format: { type: 'fixedPoint', precision: 2 },
                },
                {
                    dataField: "Barcode",
                    caption: "Barcode Konversi",
                    allowEditing:true,
                },
            ],
	        onCellClick:function (e) {
	        	// console.log(dataGridInstance.option("dataSource"))
	            var rowData = datagridKonversi.option("dataSource");
	            var columnIndex = e.columnIndex;
	            // console.log(e)
	        	if (columnIndex >= 1 && columnIndex <= 5) {
	                datagridKonversi.editRow(e.rowIndex)	
	            }
	            datagridKonversi.option("focusedColumnIndex", columnIndex);	
	            // dataGridInstance.addRow();

	            var allRowsData  = datagridKonversi.option("dataSource");
	            var blankCount = 0;
	            for (var i = 0; i < allRowsData.length; i++) {
	    			if (allRowsData[i]["Satuan"] == "") {
	    				blankCount += 1;
	    			}
	    		}

	    		if (blankCount == 1) {
	    			var newData = {Nomor: allRowsData.length +1, Satuan: "", QtyKonversi: 0, HargaPokok:0, HargaJual: 0,Barcode:""}
					datagridKonversi.option("dataSource", [...datagridKonversi.option("dataSource"), newData]);
					datagridKonversi.refresh();
	    		}
	        },
		}).dxDataGrid('instance');

		var allRowsData  = datagridKonversi.option("dataSource");
		var newData = {Nomor: allRowsData.length +1,Satuan: "", QtyKonversi: 0, HargaPokok:0, HargaJual: 0,Barcode:""}
    	datagridKonversi.option("dataSource", [...datagridKonversi.option("dataSource"), newData]);
    	datagridKonversi.refresh();	

    	datagridKonversi.on('rowUpdated', function(e) {
    		var allRowsData  = datagridKonversi.option("dataSource");
    		var blankCount = 0;

    		for (var i = 0; i < allRowsData.length; i++) {
    			if (allRowsData[i]["Satuan"] == "") {
    				blankCount += 1;
    			}
    		}

    		if (blankCount == 1) {
    			var newData = {Nomor: allRowsData.length +1,Satuan: "", QtyKonversi: 0, HargaPokok:0, HargaJual: 0,Barcode:""}
				datagridKonversi.option("dataSource", [...datagridKonversi.option("dataSource"), newData]);
				datagridKonversi.refresh();
    		}
    	});

    	datagridKonversi.on('rowUpdated', function(e) {
    		console.log(e)
    		// CalculateTotal();
    		var rowIndex = datagridKonversi.getRowIndexByKey(e.key);
			console.log(e.data.QtyKonversi)

			var HargaPokokKonversi = parseFloat(e.data.QtyKonversi) * parseFloat(jQuery('#HargaPokokPenjualan').val());
			var JualKonversi = parseFloat(e.data.QtyKonversi) * parseFloat(jQuery('#HargaJual').val());
			datagridKonversi.cellValue(rowIndex, "HargaPokok", HargaPokokKonversi);
			datagridKonversi.cellValue(rowIndex, "HargaJual", JualKonversi);
    	});

    	datagridKonversi.on('editorPreparing',function (e) {
    		if (e.parentType === "dataRow" && e.dataField === "Satuan") {
    			e.editorOptions.onFocusOut = (x) => {
    				if (jQuery('#HargaPokokPenjualan').val() == 0) {
    					Swal.fire({
	                      icon: "error",
	                      title: "Opps...",
	                      text: "Harga Pokok Item Harus di isi terlebih dahulu",
	                    }).then((result)=>{
		      				bindKonversi([]);
			            });
    				}

    				if (jQuery('#HargaJual').val() == 0) {
    					Swal.fire({
	                      icon: "error",
	                      title: "Opps...",
	                      text: "Harga Jual Item Harus di isi terlebih dahulu",
	                    }).then((result)=>{
		      				bindKonversi([]);
			            });
    				}

		    		datagridKonversi.saveEditData();
		    	}
    		}
    		else if (e.parentType === "dataRow" && e.dataField === "QtyKonversi") {
    			e.editorOptions.onFocusOut = (x) => {
    				var rowIndex = datagridKonversi.getRowIndexByKey(e.row.key);
    				console.log(e.row.data.QtyKonversi)

    				var HargaPokokKonversi = parseFloat(e.row.data.QtyKonversi) * parseFloat(jQuery('#HargaPokokPenjualan').val());
    				var JualKonversi = parseFloat(e.row.data.QtyKonversi) * parseFloat(jQuery('#HargaJual').val());
    				datagridKonversi.cellValue(rowIndex, "HargaPokok", HargaPokokKonversi);
    				datagridKonversi.cellValue(rowIndex, "HargaJual", JualKonversi);
		    		datagridKonversi.saveEditData();
		    	}
    		}
    		else if (e.parentType === "dataRow" && e.dataField === "HargaPokok") {
    			e.editorOptions.onFocusOut = (x) => {
		    		datagridKonversi.saveEditData();
		    	}
    		}
    		else if (e.parentType === "dataRow" && e.dataField === "HargaJual") {
    			e.editorOptions.onFocusOut = (x) => {
		    		datagridKonversi.saveEditData();
		    	}
    		}
    		else if (e.parentType === "dataRow" && e.dataField === "Barcode") {
    			e.editorOptions.onFocusOut = (x) => {
		    		datagridKonversi.saveEditData();
		    	}
    		}
    	});
	}
	
	function bindDiskon(data) {
		var dataGridInstance = jQuery("#gridContainerDiskon").dxDataGrid({
			allowColumnResizing: true,
			dataSource: data,
			keyExpr: "Nomor",
			showBorders: true,
            allowColumnReordering: true,
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
            columns:[
            	{
                    type: "buttons",
                    buttons: ["edit", "delete"],
                    visible: true,
                    fixed: true,
                },
                {
                    dataField: "Nomor",
                    caption: "#",
                    allowEditing:false
                },
                {
                    dataField: "QtyMinimum",
                    caption: "Qty Minimum",
                    allowEditing:true
                },
                {
                	// oJenisDiskon
                    dataField: "TipeDiskon",
                    caption: "Tipe Diskon",
                    allowEditing:true,
                    lookup: {
					    dataSource: oJenisDiskon,
					    valueExpr: 'KodeJenisDiskon',
					    displayExpr: 'NamaJenisDiskon',
				    },
                },
                {
                    dataField: "Diskon",
                    caption: "Diskon",
                    allowEditing:true
                },
            ],
            onContentReady: function(e) {
	            var rowData = dataGridInstance.option("dataSource");
	            if (rowData.length == 1) {
	            	dataGridInstance.editRow(0)	
	            }
	        },
	        onCellClick:function (e) {
	        	// console.log(dataGridInstance.option("dataSource"))
	            var rowData = dataGridInstance.option("dataSource");
	            var columnIndex = e.columnIndex;
	            // console.log(e)
	        	if (columnIndex >= 1 && columnIndex <= 5) {
	                dataGridInstance.editRow(e.rowIndex)	
	            }
	            dataGridInstance.option("focusedColumnIndex", columnIndex);	
	            // dataGridInstance.addRow();

	            var allRowsData  = dataGridInstance.option("dataSource");
	            var blankCount = 0;
	            for (var i = 0; i < allRowsData.length; i++) {
	    			if (allRowsData[i]["QtyMinimum"] == 0) {
	    				blankCount += 1;
	    			}
	    		}

	    		if (blankCount == 1) {
	    			var newData = {Nomor:allRowsData.length +1, QtyMinimum: 0, TipeDiskon:"", Diskon: 0}
					dataGridInstance.option("dataSource", [...dataGridInstance.option("dataSource"), newData]);
					dataGridInstance.refresh();
	    		}
	        },
		}).dxDataGrid('instance');

		var allRowsData  = dataGridInstance.option("dataSource");
		var newData = {Nomor:allRowsData.length +1, QtyMinimum: 0, TipeDiskon:"", Diskon: 0}
    	dataGridInstance.option("dataSource", [...dataGridInstance.option("dataSource"), newData]);
    	dataGridInstance.refresh();	

    	dataGridInstance.on('rowUpdated', function(e) {
    		var allRowsData  = dataGridInstance.option("dataSource");
    		var blankCount = 0;

    		for (var i = 0; i < allRowsData.length; i++) {
    			if (allRowsData[i]["QtyMinimum"] == 0) {
    				blankCount += 1;
    			}
    		}

    		if (blankCount == 1) {
    			var newData = {Nomor:allRowsData.length +1, QtyMinimum: 0, TipeDiskon:"", Diskon: 0}
				dataGridInstance.option("dataSource", [...dataGridInstance.option("dataSource"), newData]);
				dataGridInstance.refresh();
    		}
    	});

    	dataGridInstance.on('editorPreparing',function (e) {
    		if (e.parentType === "dataRow" && e.dataField === "QtyMinimum") {
    			e.editorOptions.onFocusOut = (x) => {
    				dataGridInstance.saveEditData();
    			}
    		}
    		// else if (e.parentType === "dataRow" && e.dataField === "TipeDiskon") {
    		// 	e.editorOptions.onFocusOut = (x) => {
		    // 		dataGridInstance.saveEditData();
		    // 	}
    		// }
    		else if (e.parentType === "dataRow" && e.dataField === "Diskon") {
    			e.editorOptions.onFocusOut = (x) => {
		    		dataGridInstance.saveEditData();
		    	}
    		}
    	});
	}
	function bindGrid(data) {
		// console.log(oItem)
		var dataGridInstance = jQuery("#gridContainerRakitan").dxDataGrid({
			allowColumnResizing: true,
			dataSource: data,
			keyExpr: "NoUrut",
			showBorders: true,
            allowColumnReordering: true,
            allowColumnResizing: true,
            columnAutoWidth: true,
            showBorders: true,
            paging: {
                enabled: true,
                pageSize: 30
            },
            editing: {
                mode: "row",
                allowAdding:true,
                allowUpdating: true,
                allowDeleting: true,
                texts: {
                    confirmDeleteMessage: ''  
                }
            },
            columns: [
            	{
                    type: "buttons",
                    buttons: ["edit", "delete"],
                    visible: true,
                    fixed: true,
                },
                {
                    dataField: "NoUrut",
                    caption: "#",
				    allowSorting: false,
				    allowEditing:false,
				    cellTemplate: function(container, options) {
                        container.text(options.rowIndex + 1);
                    }
                },
                {
                    dataField: "KodeItemBahan",
                    caption: "Kode Item",
				    allowSorting: false,
				    allowEditing:true
                },
                {
                    dataField: "NamaItem",
                    caption: "Nama Item",
				    width: 250,
				    allowSorting: false,
				    allowEditing:true
                },
                {
                    dataField: "QtyBahan",
                    caption: "Qty",
                    allowEditing:true
                },
                {
                    dataField: "Satuan",
                    caption: "Satuan",
                    // allowEditing:false,
                    lookup: {
					    dataSource: <?php echo $satuan ?>,
					    valueExpr: 'KodeSatuan',
					    displayExpr: 'NamaSatuan',
				    },
                },
            ],
            onRowInserted(e) {
		    	e.component.navigateToRow(e.key);
		    },
			// onDataErrorOccurred(e){
			// 	console.log(e)
			// }
		}).dxDataGrid('instance');

		// dataGridInstance.on('dataErrorOccurred',function (e) {
		// 	// console.log(e)
		// 	alert("Data Sudah terpakai di baris lain");
		// 	e.error.message = "Data Sudah terpakai di baris lain";
		// 	e.error.url = "";
		// 	dataGridInstance.refresh();
		// 	dataGridInstance.cancelEditData();
		// 	SetEnableCommand();
		// });

		dataGridInstance.on('editorPreparing',function (e) {
			if (e.parentType === "dataRow" && e.dataField === "KodeItemBahan") {
				var dataField = e.dataField;
        		var xItem = "";
        		var rowIndex = dataGridInstance.getRowIndexByKey(e.row.key);
        		_selectedRow = rowIndex;
        		e.editorOptions.onValueChanged = function(args) {
                    xItem = args.value;
                    // Optionally, perform actions when value changes
                };
                e.editorElement.on("focusout", function () {
                	console.log(xItem)
                	var filteredItem = oItemMaster.filter(function (oData) {
                    	return oData.KodeItem.includes(xItem);
                    });
                    // console.log(filteredItem);
                    if (filteredItem.length == 0) {
                    	Swal.fire({
	                      icon: "error",
	                      title: "#Informasi",
	                      text: "Kode Item " + xItem+" Tidak ditemukan",
	                    }).then((result) => {
							dataGridInstance.refresh();
							dataGridInstance.cancelEditData();
						});
                    }
                    else if (filteredItem.length == 1) {
                    	dataGridInstance.cellValue(rowIndex, "QtyBahan", 1);
		            	dataGridInstance.cellValue(rowIndex, "Satuan", filteredItem[0]["Satuan"]);
			            dataGridInstance.refresh();
			            dataGridInstance.saveEditData();
                    }
                    else{
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
				    	];
				    	BindLookupServices("gridLookupitem", "KodeItem", oItemMaster, ColumnData);
                    }
                });
		    }
		    else if (e.parentType === "dataRow" && e.dataField == "NamaItem"){
        		var dataField = e.dataField;
        		var xItem = "";
        		var rowIndex = dataGridInstance.getRowIndexByKey(e.row.key);
        		_selectedRow = rowIndex;
        		e.editorOptions.onValueChanged = function(args) {
                    xItem = args.value;
                    // Optionally, perform actions when value changes
                };

                e.editorElement.on("focusout", function () {
                	var filteredItem = oItemMaster.filter(function (oData) {
                    	return oData.NamaItem.includes(xItem);
                    });
                    // console.log(filteredItem);
                    if (filteredItem.length == 0) {
                    	Swal.fire({
	                      icon: "error",
	                      title: "#Informasi",
	                      text: "Nama Item " + xItem+" Tidak ditemukan",
	                    }).then((result) => {
							dataGridInstance.refresh();
							dataGridInstance.cancelEditData();
						});
                    }
                    else if (filteredItem.length == 1) {
                    	dataGridInstance.cellValue(rowIndex, "QtyBahan", 1);
		            	dataGridInstance.cellValue(rowIndex, "Satuan", filteredItem[0]["Satuan"]);
			            dataGridInstance.refresh();
			            dataGridInstance.saveEditData();
                    }
                    else{
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
				    	];
				    	BindLookupServices("gridLookupitem", "KodeItem", oItemMaster, ColumnData);
                    }
                });
        	}
		    else if (e.parentType === "dataRow" && e.dataField === "QtyBahan") {
		    	e.editorOptions.onFocusOut = (x) => {
		    		var $focusedRow = jQuery(e.component._$focusedRowElement);
                    var $saveButton = $focusedRow.find(".dx-link dx-link-save");
                    // console.log($focusedRow);
                    if ($saveButton.length) {
                        $saveButton.trigger("click");
                    }
		    	}
		    }

		    else if (e.parentType === "dataRow" && e.dataField === "Satuan") {
		    	e.editorOptions.onFocusIn = (x) => {
		    		var $focusedRow = jQuery(e.component._$focusedRowElement);
                    var $saveButton = $focusedRow.find(".dx-link dx-link-save");
                    // console.log($focusedRow);
                    if ($saveButton.length) {
                        $saveButton.trigger("click");
                    }
		    	}
		    }
		    SetEnableCommand();
		})
	}

	function SetEnableCommand() {
		var errorCount = 0;

		if (jQuery('#NamaItem').val() == "") {
			errorCount += 1;
			oErrorList.push("Nama Item Harus diisi");
		}
		if (jQuery('#TypeItem').val() == "" || jQuery('#TypeItem').val() == -99) {
			errorCount += 1;
			oErrorList.push("Type Item Harus diisi");
		}
		if (jQuery('#KodeJenisItem').val() == "" || jQuery('#KodeJenisItem').val() == -99) {
			errorCount += 1;
			oErrorList.push("Jenis Item Harus diisi");
		}
		if (jQuery('#KodeMerk').val() == "" || jQuery('#KodeMerk').val() == -99) {
			errorCount += 1;
			oErrorList.push("Merk Harus diisi");
		}
		if (jQuery('#Satuan').val() == "" || jQuery('#Satuan').val() == -99) {
			errorCount += 1;
			oErrorList.push("Satuan Harus diisi");
		}
		if (jQuery('#KodeGudang').val() == "" || jQuery('#KodeGudang').val() == -99) {
			errorCount += 1;
			oErrorList.push("Gudang Harus diisi");
		}

		if (jQuery('#TypeItem').val() == 3 ) {
			var dataGridInstance = jQuery('#gridContainerRakitan').dxDataGrid('instance');
        	var allRowsData  = dataGridInstance.getDataSource().items();

        	// console.log(allRowsData)

        	if (allRowsData.length == 0) {
        		errorCount +=1;
        		oErrorList.push("Item Rakitan harus isi bahan di tab rakitan");
        	}
		}

		console.log(oErrorList);

		if (errorCount > 0) {
			jQuery('#btSaveItem').attr('disabled',true);
		}
		else{
			jQuery('#btSaveItem').attr('disabled',false);
		}
	}

	function dropDownBoxEditorTemplate(cellElement, cellInfo) {
		console.log(cellInfo)
	    return jQuery('<div>').dxDropDownBox({
	    	dropDownOptions: { width: 500 },
	    	dataSource: oItem,
	    	value: cellInfo.value,
	    	valueExpr: 'KodeItem',
	    	displayExpr: 'NamaItem',
	    	inputAttr: { 'aria-label': 'Owner' },
	    	contentTemplate(e) {
	    		return jQuery('<div>').dxDataGrid({
	    			dataSource: oItem,
	    			remoteOperations: true,
	    			columns: ['KodeItem', 'NamaItem'],
	    			hoverStateEnabled: true,
	    			scrolling: { mode: 'virtual' },
	    			height: 250,
	    			selection: { mode: 'single' },
	    			selectedRowKeys: [cellInfo.value],
	    			focusedRowEnabled: true,
	    			focusedRowKey: cellInfo.value,
    				onSelectionChanged(selectionChangedArgs) {
    					console.log(cellInfo)
	    		  		e.component.option('value', selectionChangedArgs.currentSelectedRowKeys[0]);
	    		  		cellInfo.setValue(selectionChangedArgs.currentSelectedRowKeys[0]['KodeItem']);
	    		  		if (selectionChangedArgs.currentSelectedRowKeys.length > 0) {
	    		  			e.component.close();
	    		  		}
	    		  	},
	        	});
	      	},
	    });
	}
</script>
@endpush