@extends('parts.header')
	
@section('content')

<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">
					<a href="{{route('jenisitem')}}">Jenis Item</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Input Jenis Item</li>
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
										@if (count($jenisitem) > 0)
                                    		Edit Jenis Item
	                                	@else
	                                    	Tambah Jenis Item
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
								@if (count($jenisitem) > 0)
                            		<form action="{{route('jenisitem-edit')}}" method="post">
                            	@else
                                	<form action="{{route('jenisitem-store')}}" method="post">
                            	@endif
                            		@csrf
	                            	<div class="form-group row">
	                            		<div class="col-md-12">
	                            			<label  class="text-body">Kode Jenis</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="text" class="form-control" id="KodeJenis" name="KodeJenis" placeholder="Masukan Kode Jenis" value="{{ count($jenisitem) > 0 ? $jenisitem[0]['KodeJenis'] : '' }}" required="" {{ count($jenisitem) > 0 ? 'readonly' : '' }} >
	                            			</fieldset>
	                            			
	                            		</div>
	                            		
	                            		<div class="col-md-12">
	                            			<label  class="text-body">Nama Jenis</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="text" class="form-control" id="NamaJenis" name="NamaJenis" placeholder="Masukan Nama Jenis" value="{{ count($jenisitem) > 0 ? $jenisitem[0]['NamaJenis'] : '' }}" required="">
	                            			</fieldset>
	                            			
	                            		</div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="checkbox-inline">
                                                    <label class="checkbox checkbox-lg">
                                                        <input type="checkbox" name="TampilkanEMenu" {{ count($jenisitem) > 0 && $jenisitem[0]['TampilkanEMenu'] == 1 ? 'checked' : '' }}>
                                                        <span></span>
                                                        Tampilkan di EMenu
                                                    </label>
                                                </div>
                                            </div>
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