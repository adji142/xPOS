@extends('parts.header')
	
@section('content')

<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">
					<a href="{{route('controller')}}">Master Controller</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Input Master Controller</li>
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
										@if (count($controller) > 0)
                                    		Edit Master Controller
	                                	@else
	                                    	Tambah Master Controller
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
								@if (count($controller) > 0)
                            		<form action="{{route('controller-edit')}}" method="post">
                            	@else
                                	<form action="{{route('controller-store')}}" method="post">
                            	@endif
                            		@csrf
	                            	<div class="form-group row">
	                            		<div class="col-md-6">
	                            			<label  class="text-body">Nama Controller</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="text" class="form-control" id="NamaController" name="NamaController" placeholder="Masukan Nama Controller" value="{{ count($controller) > 0 ? $controller[0]['NamaController'] : '' }}" required="">
                                                <input type="hidden" class="form-control" id="id" name="id" value="{{ count($controller) > 0 ? $controller[0]['id'] : '' }}">
	                            			</fieldset>
	                            			
	                            		</div>

                                        <div class="col-md-6">
	                            			<label  class="text-body">Serial Number</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="text" class="form-control" id="SN" name="SN" placeholder="Masukan SN" value="{{ count($controller) > 0 ? $controller[0]['SN'] : '' }}" required="">
	                            			</fieldset>
	                            			
	                            		</div>

                                        <div class="col-md-6">
	                            			<label  class="text-body">Port</label>
	                            			<fieldset class="form-group mb-3">
                                                <select name="Port" id="Port" class="js-example-basic-single js-states form-control bg-transparent">
                                                    <option value="">Pilih Port</option>
                                                    <option value="COM1" {{ "COM1" == (count($controller) > 0 ? $controller[0]['Port'] : '') ? 'selected' : '' }}>COM1</option>
                                                    <option value="COM2" {{ "COM2" == (count($controller) > 0 ? $controller[0]['Port'] : '') ? 'selected' : '' }}>COM2</option>
                                                    <option value="COM3" {{ "COM3" == (count($controller) > 0 ? $controller[0]['Port'] : '') ? 'selected' : '' }}>COM3</option>
                                                    <option value="COM4" {{ "COM4" == (count($controller) > 0 ? $controller[0]['Port'] : '') ? 'selected' : '' }}>COM4</option>
                                                    <option value="COM5" {{ "COM5" == (count($controller) > 0 ? $controller[0]['Port'] : '') ? 'selected' : '' }}>COM5</option>
                                                    <option value="COM6" {{ "COM6" == (count($controller) > 0 ? $controller[0]['Port'] : '') ? 'selected' : '' }}>COM6</option>
                                                </select>
	                            			</fieldset>
	                            			
	                            		</div>

                                        <div class="col-md-6">
	                            			<label  class="text-body">Baud Rate</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="text" class="form-control" id="BaudRate" name="BaudRate" placeholder="Masukan BaudRate" value="{{ count($controller) > 0 ? $controller[0]['BaudRate'] : '' }}" required="">
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