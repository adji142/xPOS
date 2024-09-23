@extends('parts.header')
	
@section('content')

<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">
					<a href="{{route('kelompokrekening')}}">Kelompok Rekening</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Input Kelompok Rekening</li>
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
										@if (count($kelompokrekening) > 0)
                                    		Edit Kelompok Rekening
	                                	@else
	                                    	Tambah Kelompok Rekening
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
								@if (count($kelompokrekening) > 0)
                            		<form action="{{route('kelompokrekening-edit')}}" method="post">
                            	@else
                                	<form action="{{route('kelompokrekening-store')}}" method="post">
                            	@endif
                            		@csrf
	                            	<div class="form-group row">
	                            		<div class="col-md-12">
	                            			<!-- <label  class="text-body">Kode KelompokRekening</label> -->
	                            			<fieldset class="form-group mb-3">
	                            				<input type="hidden" class="form-control" id="id" name="id" placeholder="Masukan Kode KelompokRekening" value="{{ count($kelompokrekening) > 0 ? $kelompokrekening[0]['id'] : '' }}" required="" {{ count($kelompokrekening) > 0 ? 'readonly' : '' }} >
	                            			</fieldset>
	                            			
	                            		</div>
	                            		
	                            		<div class="col-md-12">
	                            			<label  class="text-body">Nama Kelompok Rekening</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="text" class="form-control" id="NamaKelompokRekening" name="NamaKelompokRekening" placeholder="Masukan Nama KelompokRekening" value="{{ count($kelompokrekening) > 0 ? $kelompokrekening[0]['NamaKelompok'] : '' }}" required="">
	                            			</fieldset>
	                            			
	                            		</div>

	                            		<div class="col-md-6">
	                            			<label  class="text-body">Kelompok</label>
	                            			<fieldset class="form-group mb-3">
	                            				<select name="Kelompok" id="Kelompok" class="js-example-basic-single js-states form-control bg-transparent" name="state" >
	                            					<option value="1" {{ count($kelompokrekening) > 0 ? $kelompokrekening[0]['Kelompok'] == 1 ? "selected" : '' :""}}>Neraca</option>
	                            					<option value="2" {{ count($kelompokrekening) > 0 ? $kelompokrekening[0]['Kelompok'] == 2 ? "selected" : '' :""}}>Laba Rugi</option>
	                            				</select>
	                            			</fieldset>
	                            			
	                            		</div>

	                            		<div class="col-md-6">
	                            			<label  class="text-body">Posisi</label>
	                            			<fieldset class="form-group mb-3">
	                            				<select name="Posisi" id="Posisi" class="js-example-basic-single js-states form-control bg-transparent" name="state" >
	                            					<option value="1" {{ count($kelompokrekening) > 0 ? $kelompokrekening[0]['Posisi'] == 1 ? "selected" : '' :""}}>Debet</option>
	                            					<option value="2" {{ count($kelompokrekening) > 0 ? $kelompokrekening[0]['Posisi'] == 2 ? "selected" : '' :""}}>Kredit</option>
	                            				</select>
	                            			</fieldset>
	                            			
	                            		</div>

	                            		<div class="col-md-12">
	                            			<label  class="text-body">Footer Laporan Keuangan</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="text" class="form-control" id="FooterLaporanLabaRugi" name="FooterLaporanLabaRugi" placeholder="Masukan Kode KelompokRekening" value="{{ count($kelompokrekening) > 0 ? $kelompokrekening[0]['FooterLaporanLabaRugi'] : '' }}" {{ count($kelompokrekening) > 0 ? 'readonly' : '' }} >
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
		jQuery(document).ready(function () {
			jQuery('#Posisi').select2();
			jQuery('#Kelompok').select2();
		})
	})
</script>
@endpush