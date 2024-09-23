@extends('parts.header')
	
@section('content')

<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">
					<a href="{{route('diskonperiodik')}}">Diskon Periodik</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Input Diskon Periodik</li>
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
										@if (count($diskonperiodik) > 0)
                                    		Edit Diskon Periodik
	                                	@else
	                                    	Tambah Diskon Periodik
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
								@if (count($diskonperiodik) > 0)
                            		<form action="{{route('diskonperiodik-edit')}}" method="post">
                            	@else
                                	<form action="{{route('diskonperiodik-store')}}" method="post">
                            	@endif
                            		@csrf
	                            	<div class="form-group row">
                                        <div class="col-md-6">
	                            			<label  class="text-body">Tanggal Mulai</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="date" class="form-control" id="TanggalMulai" name="TanggalMulai" placeholder="Masukan Kode DiskonPeriodik" value="{{ count($diskonperiodik) > 0 ? $diskonperiodik[0]['TanggalMulai'] : '' }}" required="" {{ count($diskonperiodik) > 0 ? 'readonly' : '' }} >
                                                <input type="hidden" class="form-control" id="id" name="id" value="{{ count($diskonperiodik) > 0 ? $diskonperiodik[0]['id'] : '' }}" >
	                            			</fieldset>
	                            			
	                            		</div>

                                        <div class="col-md-6">
	                            			<label  class="text-body">Tanggal Selesai</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="date" class="form-control" id="TanggalSelesai" name="TanggalSelesai" placeholder="Masukan Kode DiskonPeriodik" value="{{ count($diskonperiodik) > 0 ? $diskonperiodik[0]['TanggalSelesai'] : '' }}" required="" {{ count($diskonperiodik) > 0 ? 'readonly' : '' }} >
	                            			</fieldset>
	                            			
	                            		</div>

	                            		<div class="col-12 px-4">
                                            <label  class="text-body">Deskripsi</label>
                                            <fieldset class="form-group mb-3">
                                                <textarea id="Deskripsi" name="Deskripsi" class="bg-transparent text-dark">
                                                    {{ count($diskonperiodik) > 0 ? $diskonperiodik[0]['Deskripsi'] : '' }}
                                                </textarea>
                                            </fieldset>
                                        </div>

                                        <div class="col-md-12">
	                            			<label  class="text-body">Keterangan</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="text" class="form-control" id="Keterangan" name="Keterangan" placeholder="Masukan Keterangan" value="{{ count($diskonperiodik) > 0 ? $diskonperiodik[0]['Keterangan'] : '' }}" required="" {{ count($diskonperiodik) > 0 ? 'readonly' : '' }} >
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
            var now = new Date();
            var day = ("0" + now.getDate()).slice(-2);
            var month = ("0" + (now.getMonth() + 1)).slice(-2);
            var firstDay = now.getFullYear()+"-"+month+"-01";
            var NowDay = now.getFullYear()+"-"+month+"-"+day;

            jQuery('#TanggalMulai').val(firstDay);
            jQuery('#TanggalSelesai').val(NowDay);

            ClassicEditor
			.create( document.querySelector( '#Deskripsi' ) )
			.then( editor => {
					console.log( editor );
			} )
			.catch( error => {
					console.error( error );
			} );
		})
	})
</script>
@endpush