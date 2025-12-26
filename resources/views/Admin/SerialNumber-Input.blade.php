@extends('parts.header')
	
@section('content')

<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">
					<a href="{{url('serialnumber')}}">Serial Number</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Input Serial Number</li>
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
										@if ($serialNumber)
                                    		Edit Serial Number
	                                	@else
	                                    	Tambah Serial Number
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
								@if ($serialNumber)
                            		<form action="{{url('serialnumber/edit')}}" method="post">
                                        <input type="hidden" name="id" value="{{ $serialNumber->id }}">
                            	@else
                                	<form action="{{url('serialnumber/store')}}" method="post">
                            	@endif
                            		@csrf
	                            	<div class="form-group row">
	                            		<div class="col-md-6">
	                            			<label class="text-body">Serial Number</label>
	                            			<div class="input-group mb-3">
	                            				<input type="text" class="form-control" id="SerialNumber" name="SerialNumber" placeholder="Generating..." value="{{ $serialNumber ? $serialNumber->SerialNumber : '' }}" required readonly>
                                                <button class="btn btn-primary" type="button" id="btnGenerate">Generate Ulang</button>
	                            			</div>
	                            		</div>

                                        <div class="col-md-6">
	                            			<label class="text-body">Kode Partner</label>
	                            			<fieldset class="form-group mb-3">
	                            				<select name="KodePartner" id="KodePartner" class="js-example-basic-single form-control bg-transparent" required>
													<option value="">Pilih Partner</option>
													@foreach($companies as $company)
														<option value="{{ $company->KodePartner }}" {{ $serialNumber && $serialNumber->KodePartner == $company->KodePartner ? 'selected' : '' }}>
                                                            {{ $company->NamaPartner }} ({{ $company->KodePartner }})
                                                        </option>
													@endforeach
												</select>
	                            			</fieldset>
	                            		</div>

	                            		<div class="col-md-12">
	                            			<label class="text-body">Keterangan</label>
	                            			<fieldset class="form-group mb-12">
	                            				<textarea class="form-control" id="Keterangan" name="Keterangan" rows="3" placeholder="Masukan Keterangan">{{ $serialNumber ? $serialNumber->Keterangan : '' }}</textarea>
	                            			</fieldset>
	                            		</div>

	                            		<div class="col-md-12 mt-4">
	                            			<button type="submit" class="btn btn-success text-white font-weight-bold me-1 mb-1">Simpan</button>
                                            <a href="{{ url('serialnumber') }}" class="btn btn-danger font-weight-bold me-1 mb-1">Batal</a>
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
	jQuery(document).ready(function() {
		jQuery('.js-example-basic-single').select2();

        @if (!$serialNumber)
            generateSerialNumber();
        @endif

        jQuery('#btnGenerate').on('click', function() {
            generateSerialNumber();
        });
	});

    function generateSerialNumber() {
        jQuery.ajax({
            url: "{{ url('serialnumber/generate') }}",
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    jQuery('#SerialNumber').val(response.serial_number);
                }
            }
        });
    }
</script>
@endpush
