@extends('parts.header')
	
@section('content')

<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">
					<a href="{{route('titiklampu')}}">Titik Lampu</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Input Titik Lampu</li>
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
										@if (count($titiklampu) > 0)
                                    		Edit Titik Lampu
	                                	@else
	                                    	Tambah Titik Lampu
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
								@if (count($titiklampu) > 0)
                            		<form action="{{route('titiklampu-edit')}}" method="post">
                            	@else
                                	<form action="{{route('titiklampu-store')}}" method="post">
                            	@endif
                            		@csrf
	                            	<div class="form-group row">
	                            		<div class="col-md-12">
	                            			<label  class="text-body">Nama Titik Lampu</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="text" class="form-control" id="NamaTitikLampu" name="NamaTitikLampu" placeholder="Masukan Nama Titik Lampu" value="{{ count($titiklampu) > 0 ? $titiklampu[0]['NamaTitikLampu'] : '' }}" required="">
                                                <input type="hidden" class="form-control" id="id" name="id" value="{{ count($titiklampu) > 0 ? $titiklampu[0]['id'] : '' }}">
	                            			</fieldset>
	                            			
	                            		</div>

                                        <div class="col-md-6">
	                            			<label  class="text-body">Controller</label>
	                            			<fieldset class="form-group mb-3">
                                                <select name="ControllerID" id="ControllerID" class="js-example-basic-single js-states form-control bg-transparent">
                                                    <option value="">Pilih Kelompok Meja</option>
                                                    @foreach($controller as $ko)
                                                        <option value="{{ $ko->id }}" {{ $ko->id == (count($titiklampu) > 0 ? $titiklampu[0]['ControllerID'] : '') ? 'selected' : '' }}>
                                                            {{ $ko->NamaController }}
                                                        </option>
                                                    @endforeach
                                                </select>
	                            			</fieldset>
	                            			
	                            		</div>

                                        <div class="col-md-6">
	                            			<label  class="text-body">Digital Input Port</label>
	                            			<fieldset class="form-group mb-3">
                                                <select name="DigitalInput" id="DigitalInput" class="js-example-basic-single js-states form-control bg-transparent">
                                                    <option value="-1">Digital Input Port</option>
                                                    @for ($i = 1; $i < 11; $i++)
                                                    <option value="{{ $i }}" {{ $i == (count($titiklampu) > 0 ? $titiklampu[0]['DigitalInput'] : '') ? 'selected' : '' }}>{{ $i }}</option>
                                                    @endfor
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