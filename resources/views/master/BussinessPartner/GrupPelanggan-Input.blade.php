@extends('parts.header')
	
@section('content')

<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">
					<a href="{{route('gruppelanggan')}}">Grup Customer</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Input Grup Customer</li>
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
										@if (count($gruppelanggan) > 0)
                                    		Edit Grup Pelanggan
	                                	@else
	                                    	Tambah Grup Pelanggan
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
								@if (count($gruppelanggan) > 0)
                            		<form action="{{route('gruppelanggan-edit')}}" method="post">
                            	@else
                                	<form action="{{route('gruppelanggan-store')}}" method="post">
                            	@endif
                            		@csrf
	                            	<div class="form-group row">
	                            		<div class="col-md-12">
	                            			<label  class="text-body">Kode Grup</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="text" class="form-control" id="KodeGrup" name="KodeGrup" placeholder="Masukan Kode Grup" value="{{ count($gruppelanggan) > 0 ? $gruppelanggan[0]['KodeGrup'] : '' }}" required="" {{ count($gruppelanggan) > 0 ? 'readonly' : '' }} >
	                            			</fieldset>
	                            			
	                            		</div>
	                            		
	                            		<div class="col-md-12">
	                            			<label  class="text-body">Nama Grup</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="text" class="form-control" id="NamaGrup" name="NamaGrup" placeholder="Masukan Nama Grup" value="{{ count($gruppelanggan) > 0 ? $gruppelanggan[0]['NamaGrup'] : '' }}" required="">
	                            			</fieldset>
	                            			
	                            		</div>

	                            		<div class="col-md-12">
	                            			<label  class="text-body">Level Harga</label>
	                            			<fieldset class="form-group mb-3">
	                            				<select name="LevelHarga" id="LevelHarga" class="js-example-basic-single js-states form-control bg-transparent" name="state" >
													<option value="-1">Pilih Level Harga</option>
													  
													<option value="1" {{ count($gruppelanggan) > 0 ? $gruppelanggan[0]['LevelHarga'] == 1 ? "selected" : '' :""}}>1</option>
													<option value="2" {{ count($gruppelanggan) > 0 ? $gruppelanggan[0]['LevelHarga'] == 2 ? "selected" : '' :""}}>2</option>
													<option value="3" {{ count($gruppelanggan) > 0 ? $gruppelanggan[0]['LevelHarga'] == 3 ? "selected" : '' :""}}>3</option>
													<option value="4" {{ count($gruppelanggan) > 0 ? $gruppelanggan[0]['LevelHarga'] == 4 ? "selected" : '' :""}}>4</option>
												</select>
	                            			</fieldset>
	                            			
	                            		</div>

	                            		<div class="col-md-12">
	                            			<label  class="text-body">Diskon (%)</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="number" class="form-control" id="DiskonPersen" name="DiskonPersen" placeholder="Masukan Diskon (%)" value="{{ count($gruppelanggan) > 0 ? $gruppelanggan[0]['DiskonPersen'] : '0' }}">
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