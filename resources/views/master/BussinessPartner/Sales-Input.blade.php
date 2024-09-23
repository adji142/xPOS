@extends('parts.header')
	
@section('content')

<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">
					<a href="{{route('sales')}}">Sales</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Input Sales</li>
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
										@if (count($sales) > 0)
                                    		Edit Sales
	                                	@else
	                                    	Tambah Sales
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
								@if (count($sales) > 0)
                            		<form action="{{route('sales-edit')}}" method="post">
                            	@else
                                	<form action="{{route('sales-store')}}" method="post">
                            	@endif
                            		@csrf
	                            	<div class="form-group row">
	                            		<div class="col-md-12">
	                            			<label  class="text-body">Kode Sales (*)</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="text" class="form-control" id="KodeSales" name="KodeSales" placeholder="<AUTO>" value="{{ count($sales) > 0 ? $sales[0]['KodeSales'] : '' }}" readonly="" >
	                            			</fieldset>
	                            			
	                            		</div>
	                            		
	                            		<div class="col-md-12">
	                            			<label  class="text-body">Nama Sales (*)</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="text" class="form-control" id="NamaSales" name="NamaSales" placeholder="Masukan Nama Sales" value="{{ count($sales) > 0 ? $sales[0]['NamaSales'] : '' }}" required="">
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
                                                            {{ count($sales) > 0 ? $sales[0]['ProvID'] == 4 ? "selected" : '' :""}}
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
	                            				<input type="mail" class="form-control" id="Email" name="Email" placeholder="Masukan Email" value="{{ count($sales) > 0 ? $sales[0]['Email'] : '' }}" >
	                            			</fieldset>
	                            		</div>

	                            		<div class="col-md-3">
	                            			<label  class="text-body">NoTlp (*)</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="number" class="form-control" id="NoTlp1" name="NoTlp1" placeholder="621325058258" value="{{ count($sales) > 0 ? $sales[0]['NoTlp1'] : '' }}" required="">
	                            			</fieldset>
	                            		</div>

	                            		<div class="col-md-3">
	                            			<label  class="text-body">Kontak Lain</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="number" class="form-control" id="NoTlp2" name="NoTlp2" placeholder="621325058258" value="{{ count($sales) > 0 ? $sales[0]['NoTlp2'] : '' }}" >
	                            			</fieldset>
	                            		</div>

	                            		<div class="col-md-12">
	                            			<label  class="text-body">Keterangan Lain</label>
	                            			<fieldset class="form-group mb-12">
	                            				<textarea class="form-control" id="Keterangan" name="Keterangan" rows="3" placeholder="Masukan Keterangan"></textarea>
	                            			</fieldset>
	                            		</div>
	                            		<div class="col-md-12">
	                            			<label  class="text-body">Status</label>
	                            			<fieldset class="form-group mb-3">
	                            				<select name="Status" id="Status" class="js-example-basic-single js-states form-control bg-transparent" name="state" >
													<option value="1" {{ count($sales) > 0 ? $sales[0]['Status'] == 1 ? "selected" : '' :""}}>Active</option>
													<option value="0" {{ count($sales) > 0 ? $sales[0]['Status'] == 0 ? "selected" : '' :""}}>Inactive</option>
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
	jQuery(function () {
		jQuery(document).ready(function() {
			jQuery('.js-example-basic-single').select2();

			// Append Data Select 2
			var xTemData = '<?php echo json_encode($sales); ?>'
			var xData = JSON.parse(xTemData)
			$('#ProvID').val(xData[0]['ProvID']).trigger('change');
			$('#KotaID').val(xData[0]['KotaID']).trigger('change');
			$('#KecID').val(xData[0]['KecID']).trigger('change');
			$('#KelID').val(xData[0]['KelID']).trigger('change');
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
		})

	})
</script>
@endpush