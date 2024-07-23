@extends('parts.header')
	
@section('content')

<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">
					<a href="{{route('meja')}}">Meja</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Input Meja</li>
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
										@if (count($meja) > 0)
                                    		Edit Meja
	                                	@else
	                                    	Tambah Meja
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
								@if (count($meja) > 0)
                            		<form action="{{route('meja-edit')}}" method="post">
                            	@else
                                	<form action="{{route('meja-store')}}" method="post">
                            	@endif
                            		@csrf
	                            	<div class="form-group row">
	                            		<div class="col-md-3">
	                            			<label  class="text-body">Kode Meja</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="text" class="form-control" id="KodeMeja" name="KodeMeja" placeholder="Masukan Kode Meja" value="{{ count($meja) > 0 ? $meja[0]['KodeMeja'] : '' }}" required="" {{ count($meja) > 0 ? 'readonly' : '' }} >
	                            			</fieldset>
	                            			
	                            		</div>
	                            		
	                            		<div class="col-md-5">
	                            			<label  class="text-body">Nama Meja</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="text" class="form-control" id="NamaMeja" name="NamaMeja" placeholder="Masukan Nama Meja" value="{{ count($meja) > 0 ? $meja[0]['NamaMeja'] : '' }}" required="">
	                            			</fieldset>
	                            			
	                            		</div>

                                        <div class="col-md-4">
	                            			<label  class="text-body">Kelompok Meja</label>
	                            			<fieldset class="form-group mb-3">
                                                <select name="KelompokMeja" id="KelompokMeja" class="js-example-basic-single js-states form-control bg-transparent">
                                                    <option value="">Pilih Kelompok Meja</option>
                                                    @foreach($kelompokmeja as $ko)
                                                        <option value="{{ $ko->KodeKelompokMeja }}" {{ $ko->KodeKelompokMeja == (count($meja) > 0 ? $meja[0]['KelompokMeja'] : '') ? 'selected' : '' }}>
                                                            {{ $ko->NamaKelompokMeja }}
                                                        </option>
                                                    @endforeach
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
	$(function () {
		$(document).ready(function () {
			$('#LevelHarga').select2();
		})
	})
</script>
@endpush