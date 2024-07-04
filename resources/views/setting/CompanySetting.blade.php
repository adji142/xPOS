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
					                            				<select name="isPostingAkutansi" id="isPostingAkutansi" class="js-example-basic-single js-states form-control bg-transparent">
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
	$(function () {
		jQuery(document).ready(function () {
			var slip = "{{ count($company) > 0 ? $company[0]['DefaultSlip'] : 'slip1' }}"
			jQuery('#LevelHarga').select2();
			jQuery('#DefaultSlip').val(slip).trigger('change');
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
			window.print();
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
	})
</script>
@endpush