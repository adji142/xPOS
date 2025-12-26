@extends('parts.header')
	
@section('content')

<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">
					<a href="{{route('pelanggan')}}">Pelanggan</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Input Pelanggan</li>
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
										@if (count($pelanggan) > 0)
                                    		Edit Pelanggan
	                                	@else
	                                    	Tambah Pelanggan
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
								@if (count($pelanggan) > 0)
                            		<form action="{{route('pelanggan-edit')}}" method="post">
                            	@else
                                	<form action="{{route('pelanggan-store')}}" method="post">
                            	@endif
                            		@csrf
	                            	<div class="form-group row">
	                            		<div class="col-md-3">
	                            			<label  class="text-body">Kode Pelanggan</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="text" class="form-control" id="KodePelanggan" name="KodePelanggan" placeholder="<AUTO>" value="{{ count($pelanggan) > 0 ? $pelanggan[0]['KodePelanggan'] : '' }}" readonly="" >
	                            			</fieldset>
	                            			
	                            		</div>

										<div class="col-md-9">
	                            			<label  class="text-body">Pelanggan ID</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="text" class="form-control" id="PelangganID" name="PelangganID" placeholder="Masukan ID Pelanggan" value="{{ count($pelanggan) > 0 ? $pelanggan[0]['PelangganID'] : '' }}" >
	                            			</fieldset>
	                            			
	                            		</div>

										<div class="col-md-12">
	                            			<fieldset class="form-group mb-3">
	                            				<center>
													<div class="row">
														<div class="col-md-4">
														</div>
														<div class="col-md-4">
															<svg id="barcode"></svg>	
														</div>

														<div class="col-md-4">
															<div id="qrcode"></div>
														</div>

													</div>
												</center>
	                            			</fieldset>
	                            			
	                            		</div>


	                            		
	                            		<div class="col-md-12">
	                            			<label  class="text-body">Nama Pelanggan</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="text" class="form-control" id="NamaPelanggan" name="NamaPelanggan" placeholder="Masukan Nama Pelanggan" value="{{ count($pelanggan) > 0 ? $pelanggan[0]['NamaPelanggan'] : '' }}" required="">
	                            			</fieldset>
	                            			
	                            		</div>

	                            		<div class="col-md-6">
	                            			<label  class="text-body">Grup Pelanggan</label>
	                            			<fieldset class="form-group mb-3">
	                            				<select name="KodeGrupPelanggan" id="KodeGrupPelanggan" class="js-example-basic-single js-states form-control bg-transparent" name="state" required="">
													<option value="">Pilih Kelompok Pelanggan</option>
													@foreach($gruppelanggan as $ko)
														<option 
                                                            value="{{ $ko->KodeGrup }}"
                                                            {{ count($pelanggan) > 0 ? $pelanggan[0]['KodeGrupPelanggan'] == $ko->KodeGrup ? "selected" : '' :""}}
                                                        >
                                                            {{ $ko->NamaGrup }}
                                                        </option>
													@endforeach
													
												</select>
	                            			</fieldset>
	                            			
	                            		</div>

	                            		<div class="col-md-6">
	                            			<label  class="text-body">Limit Piutang</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="number" class="form-control" id="LimitPiutang" name="LimitPiutang" placeholder="Masukan Limit Piutang" value="{{ count($pelanggan) > 0 ? $pelanggan[0]['LimitPiutang'] : 0 }}" >
	                            			</fieldset>
	                            			
	                            		</div>

	                            		<div class="col-md-3">
	                            			<label  class="text-body">Provinsi</label>
	                            			<fieldset class="form-group mb-3">
	                            				<select name="ProvID" id="ProvID" class="js-example-basic-single js-states form-control bg-transparent" name="state" >
													<option value="-1">Pilih Provinsi</option>
													@foreach($provinsi as $ko)
														<option 
                                                            value="{{ $ko->prov_id }}"
                                                            {{ count($pelanggan) > 0 ? $pelanggan[0]['ProvID'] == 4 ? "selected" : '' :""}}
                                                        >
                                                            {{ $ko->prov_name }}
                                                        </option>
													@endforeach
													
												</select>
	                            			</fieldset>
	                            		</div>

	                            		<div class="col-md-3">
	                            			<label  class="text-body">Kota</label>
	                            			<fieldset class="form-group mb-3">
	                            				<select name="KotaID" id="KotaID" class="js-example-basic-single js-states form-control bg-transparent" name="state" >
													<option value="-1">Pilih Kota</option>
												</select>
	                            			</fieldset>
	                            		</div>

	                            		<div class="col-md-3">
	                            			<label  class="text-body">Kecamatan</label>
	                            			<fieldset class="form-group mb-3">
	                            				<select name="KecID" id="KecID" class="js-example-basic-single js-states form-control bg-transparent" name="state" >
													<option value="-1">Pilih Kecamatan</option>
												</select>
	                            			</fieldset>
	                            		</div>

	                            		<div class="col-md-3">
	                            			<label  class="text-body">Kelurahan</label>
	                            			<fieldset class="form-group mb-3">
	                            				<select name="KelID" id="KelID" class="js-example-basic-single js-states form-control bg-transparent" name="state" >
													<option value="-1">Pilih Kelurahan</option>
												</select>
	                            			</fieldset>
	                            		</div>

	                            		<div class="col-md-12">
	                            			<label  class="text-body">Alamat</label>
	                            			<fieldset class="form-group mb-12">
	                            				<textarea class="form-control" id="Alamat" name="Alamat" rows="3" placeholder="Masukan Alamat"></textarea>
	                            			</fieldset>
	                            		</div>

	                            		<div class="col-md-6">
	                            			<label  class="text-body">Email</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="mail" class="form-control" id="Email" name="Email" placeholder="Masukan Email" value="{{ count($pelanggan) > 0 ? $pelanggan[0]['Email'] : '' }}" >
	                            			</fieldset>
	                            		</div>

	                            		<div class="col-md-3">
	                            			<label  class="text-body">NoTlp</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="number" class="form-control" id="NoTlp1" name="NoTlp1" placeholder="621325058258" value="{{ count($pelanggan) > 0 ? $pelanggan[0]['NoTlp1'] : '' }}" >
	                            			</fieldset>
	                            		</div>

	                            		<div class="col-md-3">
	                            			<label  class="text-body">Kontak Lain</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="number" class="form-control" id="NoTlp2" name="NoTlp2" placeholder="621325058258" value="{{ count($pelanggan) > 0 ? $pelanggan[0]['NoTlp2'] : '' }}" >
	                            			</fieldset>
	                            		</div>

	                            		<div class="col-md-12">
	                            			<label  class="text-body">Keterangan Lain</label>
	                            			<fieldset class="form-group mb-12">
	                            				<textarea class="form-control" id="Keterangan" name="Keterangan" rows="3" placeholder="Masukan Keterangan"></textarea>
	                            			</fieldset>
																<select name="AllowedDay[]" id="AllowedDay" class="js-example-basic-single js-states form-control bg-transparent" multiple="multiple">
													@php
														$allowedDays = [];
														if (count($pelanggan) > 0 && !empty($pelanggan[0]['AllowedDay'])) {
															$allowedDays = explode(',', $pelanggan[0]['AllowedDay']);
														}
													@endphp
													<option value="Monday" {{ in_array('Monday', $allowedDays) ? 'selected' : '' }}>Senin</option>
													<option value="Tuesday" {{ in_array('Tuesday', $allowedDays) ? 'selected' : '' }}>Selasa</option>
													<option value="Wednesday" {{ in_array('Wednesday', $allowedDays) ? 'selected' : '' }}>Rabu</option>
													<option value="Thursday" {{ in_array('Thursday', $allowedDays) ? 'selected' : '' }}>Kamis</option>
													<option value="Friday" {{ in_array('Friday', $allowedDays) ? 'selected' : '' }}>Jumat</option>
													<option value="Saturday" {{ in_array('Saturday', $allowedDays) ? 'selected' : '' }}>Sabtu</option>
													<option value="Sunday" {{ in_array('Sunday', $allowedDays) ? 'selected' : '' }}>Minggu</option>
												</select>
	</select>
	                            			</fieldset>
	                            		</div>

										<div class="col-md-4">
	                            			<label  class="text-body">Berlaku Sampai</label>
	                            			<fieldset class="form-group mb-3">
												@if (count($pelanggan) > 0)
	                            					<input type="date" class="form-control" id="ValidUntil" name="ValidUntil" value="{{ old('ValidUntil', \Carbon\Carbon::parse($pelanggan[0]['ValidUntil'])->format('Y-m-d')) }}" readonly disabled>
												@else
	                            					<input type="date" class="form-control" id="ValidUntil" name="ValidUntil" readonly disabled>
												@endif
											</fieldset>
	                            		</div>

	                            		<div class="col-md-4">
	                            			<label  class="text-body">Membership Berbayar</label>
	                            			<fieldset class="form-group mb-3">
	                            				<select name="isPaidMembership" id="isPaidMembership" class="js-example-basic-single js-states form-control bg-transparent" name="state" >
													<option value="1" {{ count($pelanggan) > 0 ? $pelanggan[0]['isPaidMembership'] == 1 ? "selected" : '' :""}}>Ya</option>
													<option value="0" {{ count($pelanggan) > 0 ? $pelanggan[0]['isPaidMembership'] == 0 ? "selected" : '' :"selected"}}>Tidak</option>
												</select>
	                            			</fieldset>
	                            		</div>

	                                        <div class="col-md-6">
                                            <label  class="text-body">Maksimal Bermain Dalam 1 Periode</label>
                                            <fieldset class="form-group mb-3">
                                                <input type="number" class="form-control" id="MaxPlay" name="MaxPlay" placeholder="0" value="{{ count($pelanggan) > 0 ? $pelanggan[0]['MaxPlay'] : 0 }}">
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <label  class="text-body">Sudah Bermain</label>
                                            <fieldset class="form-group mb-3">
                                                <input type="number" class="form-control" id="Played" name="Played" placeholder="0" value="{{ count($pelanggan) > 0 ? $pelanggan[0]['Played'] : 0 }}">
                                            </fieldset>
                                        </div>

	                            		<div class="col-md-4">
	                            			<label  class="text-body">Harga Member</label>
	                            			<fieldset class="form-group mb-3">
	                            			<input type="number" class="form-control" id="MemberPrice" name="MemberPrice" placeholder="0" value="{{ count($pelanggan) > 0 ? $pelanggan[0]['MemberPrice'] : 0 }}" >
	                            			</fieldset>
	                            		</div>

	                            		<div class="col-md-4">
	                            			<label  class="text-body">Lama Bermain Per Permainan (Jam)</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="number" class="form-control" id="maxTimePerPlay" name="maxTimePerPlay" placeholder="0" value="{{ count($pelanggan) > 0 ? $pelanggan[0]['maxTimePerPlay'] : 0 }}" >
	                            			</fieldset>
	                            		</div>

	                            		<div class="col-md-4">
	                            			<label  class="text-body">Status</label>
	                            			<fieldset class="form-group mb-3">
	                            				<select name="Status" id="Status" class="js-example-basic-single js-states form-control bg-transparent" name="state" >
													<option value="1" {{ count($pelanggan) > 0 ? $pelanggan[0]['Status'] == 1 ? "selected" : '' :""}}>Active</option>
													<option value="0" {{ count($pelanggan) > 0 ? $pelanggan[0]['Status'] == 0 ? "selected" : '' :""}}>Inactive</option>
												</select>
	                            			</fieldset>
	                            			
	                            		</div>

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
	// jQuery(document).ready(function() {
	// 	jQuery('.js-example-basic-multiple').select2();
	// });
	let qr;
	jQuery(function () {
		jQuery(document).ready(function() {
			jQuery('.js-example-basic-single').select2();

			// Append Data Select 2
			var xTemData = '<?php echo json_encode($pelanggan); ?>'
			var xData = JSON.parse(xTemData)
			$('#ProvID').val(xData[0]['ProvID']).trigger('change');
			$('#KotaID').val(xData[0]['KotaID']).trigger('change');
			$('#KecID').val(xData[0]['KecID']).trigger('change');
			$('#KelID').val(xData[0]['KelID']).trigger('change');
			qr = new QRCode(document.getElementById("qrcode"), {
				width: 128,
				height: 128
			});

			Generatebarcode()
		});
		jQuery('#PelangganID').on('input', function () {
			Generatebarcode()
		});
		jQuery('#ProvID').change(function () {
			console.log('Test masuk')
			$.ajax({
                async   : false,
                type    : "post",
                url     : "{{route('demografipelanggan')}}",
                data    : {
                            'Table' : 'dem_kota',
                            'Field' : 'prov_id',
                            'Value' : $('#ProvID').val(),
                            '_token': '{{ csrf_token() }}',
                        },
                dataType: "json",
                success: function (response) {
                    // console.log(response);
                    if (response.data.length > 0) {
                    	$('#KotaID').empty();
                    	var newOption = $('<option>', {
			            	value: -1,
			            	text: "Pilih Kota"
			          	});
			          	$('#KotaID').append(newOption); 
			          	$.each(response.data,function (k,v) {
				            var newOption = $('<option>', {
				            	value: v.city_id,
				            	text: v.city_name
				        	});

				        	$('#KotaID').append(newOption);
				        });
                    }
                }
            });
		});


		jQuery('#KotaID').change(function () {
			console.log('Test masuk')
			$.ajax({
                async   : false,
                type    : "post",
                url     : "{{route('demografipelanggan')}}",
                data    : {
                            'Table' : 'dem_kecamatan',
                            'Field' : 'kota_id',
                            'Value' : $('#KotaID').val(),
                            '_token': '{{ csrf_token() }}',
                        },
                dataType: "json",
                success: function (response) {
                    // console.log(response);
                    if (response.data.length > 0) {
                    	$('#KecID').empty();
                    	var newOption = $('<option>', {
			            	value: -1,
			            	text: "Pilih Kecamatan"
			          	});
			          	$('#KecID').append(newOption); 
			          	$.each(response.data,function (k,v) {
				            var newOption = $('<option>', {
				            	value: v.dis_id,
				            	text: v.dis_name
				        	});

				        	$('#KecID').append(newOption);
				        });
                    }
                }
            });
		});


		jQuery('#KecID').change(function () {
			console.log('Test masuk')
			$.ajax({
                async   : false,
                type    : "post",
                url     : "{{route('demografipelanggan')}}",
                data    : {
                            'Table' : 'dem_kelurahan',
                            'Field' : 'kec_id',
                            'Value' : $('#KecID').val(),
                            '_token': '{{ csrf_token() }}',
                        },
                dataType: "json",
                success: function (response) {
                    // console.log(response);
                    if (response.data.length > 0) {
                    	$('#KelID').empty();
                    	var newOption = $('<option>', {
			            	value: -1,
			            	text: "Pilih Kelurahan"
			          	});
			          	$('#KelID').append(newOption); 
			          	$.each(response.data,function (k,v) {
				            var newOption = $('<option>', {
				            	value: v.subdis_id,
				            	text: v.subdis_name
				        	});

				        	$('#KelID').append(newOption);
				        });
                    }
                }
            });
		});

		function Generatebarcode() {
			const value = jQuery('#PelangganID').val();
			JsBarcode('#barcode', value, {
				format: 'CODE128',
				displayValue: true,
				fontSize: 16
			});

			console.log(qr);

			qr.clear();
      		qr.makeCode(value);
		}

	})
</script>
@endpush