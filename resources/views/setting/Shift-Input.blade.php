@extends('parts.header')
	
@section('content')

<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">
					<a href="{{route('shift')}}">Shift</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Input Shift</li>
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
										@if (count($shift) > 0)
                                    		Edit Shift
	                                	@else
	                                    	Tambah Shift
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
								@if (count($shift) > 0)
                            		<form action="{{route('shift-edit')}}" method="post">
                            	@else
                                	<form action="{{route('shift-store')}}" method="post">
                            	@endif
                            		@csrf
	                            	<div class="form-group row">
	                            		<div class="col-md-3">
	                            			<label  class="text-body">Kode Shift</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="text" class="form-control" id="KodeShift" name="KodeShift" placeholder="Masukan Kode Shift" value="{{ count($shift) > 0 ? $shift[0]['KodeShift'] : '' }}" required="" {{ count($shift) > 0 ? 'readonly' : '' }} >
	                            			</fieldset>
	                            			
	                            		</div>
	                            		
	                            		<div class="col-md-9">
	                            			<label  class="text-body">Nama Shift</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="text" class="form-control" id="NamaShift" name="NamaShift" placeholder="Masukan Nama Shift" value="{{ count($shift) > 0 ? $shift[0]['NamaShift'] : '' }}" required="">
	                            			</fieldset>
	                            			
	                            		</div>

	                            		<div class="col-md-6">
	                            			<label  class="text-body">Jam Mulai Kerja</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="time" class="form-control" id="JamMulai" name="JamMulai" placeholder="Masukan No Rekening Shift" value="{{ count($shift) > 0 ? $shift[0]['JamMulai'] : '' }}" required="">
	                            			</fieldset>
	                            			
	                            		</div>

	                            		<div class="col-md-6">
	                            			<label  class="text-body">Jam Selesai Kerja</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="time" class="form-control" id="JamSelesai" name="JamSelesai" placeholder="Masukan Nama Pemilik" value="{{ count($shift) > 0 ? $shift[0]['JamSelesai'] : '' }}" required="">
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
	$(function () {
		$(document).ready(function () {
			$('#LevelHarga').select2();
		})
	})
</script>
@endpush