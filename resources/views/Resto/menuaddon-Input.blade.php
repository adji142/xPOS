@extends('parts.header')
	
@section('content')

<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">
					<a href="{{route('menuaddon')}}">Menu Addon</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Input Menu Addon</li>
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
										@if (count($menuaddon) > 0)
                                    		Edit Menu Addon
	                                	@else
	                                    	Tambah Menu Addon
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
								@if (count($menuaddon) > 0)
                            		<form action="{{route('menuaddon-edit')}}" method="post">
                            	@else
                                	<form action="{{route('menuaddon-store')}}" method="post">
                            	@endif
                            		@csrf
	                            	<div class="form-group row">
	                            		<div class="col-md-6">
	                            			<label  class="text-body">Nama Menu Addon</label>
	                            			<fieldset class="form-group mb-3">
                                                <input type="hidden" class="form-control" id="id" name="id" value="{{ count($menuaddon) > 0 ? $menuaddon[0]['id'] : '' }}" required="">
	                            				<input type="text" class="form-control" id="NamaAddon" name="NamaAddon" placeholder="Masukan Nama Menu Addon" value="{{ count($menuaddon) > 0 ? $menuaddon[0]['NamaAddon'] : '' }}" required="">
	                            			</fieldset>
	                            			
	                            		</div>

                                        <div class="col-md-6">
	                            			<label  class="text-body">Harga Addon</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="number" class="form-control" id="HargaAddon" name="HargaAddon" placeholder="Masukan Harga Addon" value="{{ count($menuaddon) > 0 ? $menuaddon[0]['HargaAddon'] : '0' }}" required="">
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