@extends('parts.header')
	
@section('content')

<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">
					<a href="{{route('termin')}}">Termin</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Input Termin</li>
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
										@if (count($termin) > 0)
                                    		Edit Metode Pembayaran
	                                	@else
	                                    	Tambah Metode Pembayaran
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
								@if (count($termin) > 0)
                            		<form action="{{route('termin-edit')}}" method="post">
                            	@else
                                	<form action="{{route('termin-store')}}" method="post">
                            	@endif
                            		@csrf
	                            	<div class="form-group row">
	                            		<div class="col-md-3">
	                            			<!-- <label  class="text-body">Kode Termin</label> -->
	                            			<fieldset class="form-group mb-3">
	                            				<input type="hidden" class="form-control" id="id" name="id" placeholder="Masukan Kode Termin" value="{{ count($termin) > 0 ? $termin[0]['id'] : '' }}" required="" {{ count($termin) > 0 ? 'readonly' : '' }} >
	                            			</fieldset>
	                            			
	                            		</div>
	                            		
	                            		<div class="col-md-12">
	                            			<label  class="text-body">Nama Metode Pembayaran</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="text" class="form-control" id="NamaTermin" name="NamaTermin" placeholder="Masukan Nama Termin" value="{{ count($termin) > 0 ? $termin[0]['NamaTermin'] : '' }}" required="">
	                            			</fieldset>
	                            			
	                            		</div>

	                            		<div class="col-md-6">
	                            			<label  class="text-body">Jumlah Hari</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="number" class="form-control" id="JumlahHari" name="JumlahHari" placeholder="Masukan Jumlah Hari" value="{{ count($termin) > 0 ? $termin[0]['JumlahHari'] : '0' }}" required="">
	                            			</fieldset>
	                            			
	                            		</div>

	                            		<div class="col-md-6">
	                            			<label  class="text-body">Toleransi (Hari)</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="number" class="form-control" id="ExtraDays" name="ExtraDays" placeholder="Masukan Toleransi" value="{{ count($termin) > 0 ? $termin[0]['ExtraDays'] : '0' }}" >
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