@extends('parts.header')
	
@section('content')

<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">
					<a href="{{route('rekening')}}">Rekening</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Input Rekening</li>
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
										@if (count($rekening) > 0)
                                    		Edit Rekening
	                                	@else
	                                    	Tambah Rekening
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
								@if (count($rekening) > 0)
                            		<form action="{{route('rekening-edit')}}" method="post">
                            	@else
                                	<form action="{{route('rekening-store')}}" method="post">
                            	@endif
                            		@csrf
	                            	<div class="form-group row">
	                            		<div class="col-md-3">
	                            			<label  class="text-body">Kode Rekening</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="text" class="form-control" id="KodeRekening" name="KodeRekening" placeholder="Masukan Kode Rekening" value="{{ count($rekening) > 0 ? $rekening[0]['KodeRekening'] : '' }}" required="" {{ count($rekening) > 0 ? 'readonly' : '' }} >
	                            			</fieldset>
	                            			
	                            		</div>

	                            		<div class="col-md-9">
	                            			<label  class="text-body">Nama Rekening</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="text" class="form-control" id="NamaRekening" name="NamaRekening" placeholder="Masukan Nama Rekening" value="{{ count($rekening) > 0 ? $rekening[0]['NamaRekening'] : '' }}" required="" >
	                            			</fieldset>
	                            			
	                            		</div>

	                            		<div class="col-md-12">
	                            			<label  class="text-body">Kelompok Rekening</label>
	                            			<fieldset class="form-group mb-3">
	                            				<select name="KodeKelompok" id="KodeKelompok" class="js-example-basic-single js-states form-control bg-transparent" name="state" required="">
													<option value="">Pilih Kelompok Rekening</option>
													@foreach($kelompokrekening as $ko)
														<option 
                                                            value="{{ $ko->id }}"
                                                            {{ count($rekening) > 0 ? $rekening[0]['KodeKelompok'] == $ko->id ? "selected" : '' :""}}
                                                        >
                                                            {{ $ko->NamaKelompok }}
                                                        </option>
													@endforeach
													
												</select>
	                            			</fieldset>
	                            			
	                            		</div>

	                            		<div class="col-md-3">
	                            			<label  class="text-body">Level</label>
	                            			<fieldset class="form-group mb-3">
	                            				<select name="Level" id="Level" class="js-example-basic-single js-states form-control bg-transparent" name="state" >
	                            					<option value="1">1</option>
	                            					<option value="2">2</option>
	                            					<option value="3">3</option>
	                            					<option value="4">4</option>
	                            					<option value="5">5</option>
	                            				</select>
	                            			</fieldset>
	                            			
	                            		</div>

	                            		<div class="col-md-9">
	                            			<label  class="text-body">Jenis Rekening</label>
	                            			<fieldset class="form-group mb-3">
	                            				<select name="Jenis" id="Jenis" class="js-example-basic-single js-states form-control bg-transparent" name="state" >
	                            					<option value="1">Rekening Induk</option>
	                            					<option value="2">Buku Besar</option>
	                            				</select>
	                            			</fieldset>
	                            			
	                            		</div>

	                            		<div class="col-md-12">
	                            			<label  class="text-body">Rekening Induk</label>
	                            			<fieldset class="form-group mb-3">
	                            				<select name="RekeningInduk" id="RekeningInduk" class="js-example-basic-single js-states form-control bg-transparent" name="state" >
	                            					
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
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<script type="text/javascript">
	jQuery(function () {
		var dataRekening;
		jQuery(document).ready(function () {
			dataRekening = <?php echo json_encode($rekening); ?>

			jQuery('#Level').val(dataRekening[0]['Level']).trigger('change');
			jQuery('#Jenis').val(dataRekening[0]['Jenis']).trigger('change');
			// jQuery('#RekeningInduk').val(dataRekening[0]['KodeRekeningInduk']).trigger('change');
			// console.log(dataRekening)
			// jQuery('#RekeningInduk').select2();
			// jQuery('#Kelompok').select2();
		});

		jQuery('#Level').change(function () {
			// alert('test')
			if (jQuery('#Level').val() == 1) {
				jQuery('#RekeningInduk').prop('disabled', true);
			}
			else{
				jQuery('#RekeningInduk').prop('disabled', false);
				// 
				$.ajax({
					// async:false,
					url: "{{route('rekening-json')}}",
					type: 'POST',
					headers: {
		                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
		            },
		            data: {'KelompokRekening': '', 'Level' : parseInt(jQuery('#Level').val()) - 1},
		            success: function(response) {
		            	$('#RekeningInduk').empty();
				        var newOption = $('<option>', {
				        	value: -1,
				        	text: "Pilih Rekening Induk"
				        });

				        $('#RekeningInduk').append(newOption); 
				        $.each(response.data,function (k,v) {
				        	var newOption = $('<option>', {
				        		value: v.KodeRekening,
				        		text: v.NamaRekening
				        	});

				        	$('#RekeningInduk').append(newOption);
				        });

				        if (dataRekening.length > 0) {
				        	jQuery('#RekeningInduk').val(dataRekening[0]['KodeRekeningInduk']).trigger('change');

				        	if (dataRekening[0]['SaldoBase'] > 0) {
				        		jQuery('#RekeningInduk').prop('disabled', true);
					        	jQuery('#Level').prop('disabled', true);
					        	jQuery('#Jenis').prop('disabled', true);
					        	jQuery('#KodeKelompok').prop('disabled', true);
				        	}
				        }
		            }
				})
			}
		})
	})
</script>
@endpush