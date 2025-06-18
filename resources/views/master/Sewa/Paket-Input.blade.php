@extends('parts.header')
	
@section('content')

<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">
					<a href="{{route('paket')}}">Paket</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Input Paket</li>
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
										@if (count($paket) > 0)
                                    		Edit Paket
	                                	@else
	                                    	Tambah Paket
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
								@if (count($paket) > 0)
                            		<form action="{{route('paket-edit')}}" method="post">
                            	@else
                                	<form action="{{route('paket-store')}}" method="post">
                            	@endif
                            		@csrf
	                            	<div class="form-group row">
	                            		<div class="col-md-12">
	                            			<label  class="text-body">Jenis Paket</label>
	                            			<fieldset class="form-group mb-3">
	                            				<select name="JenisPaket" id="JenisPaket" class="js-example-basic-single js-states form-control bg-transparent" >
                                                    <option value="">Pilih Jenis Paket</option>
                                                    <option value="MENIT" {{ 'MENIT' == (count($paket) > 0 ? $paket[0]['JenisPaket'] : '') ? 'selected' : '' }}>Paket Menit</option>
                                                    <option value="JAM" {{ 'JAM' == (count($paket) > 0 ? $paket[0]['JenisPaket'] : '') ? 'selected' : '' }}>Paket Jam</option>
                                                    <option value="PAKET" {{ 'PAKET' == (count($paket) > 0 ? $paket[0]['JenisPaket'] : '') ? 'selected' : '' }}>Paket Berlangganan</option>
                                                </select>
                                                <input type="hidden" class="form-control" id="id" name="id" value="{{ count($paket) > 0 ? $paket[0]['id'] : '' }}">
	                            			</fieldset>
	                            		</div>

                                        <div class="col-md-12">
	                            			<label  class="text-body">Nama Paket</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="text" class="form-control" id="NamaPaket" name="NamaPaket" placeholder="Masukan Nama Paket" value="{{ count($paket) > 0 ? $paket[0]['NamaPaket'] : '' }}" required="">
	                            			</fieldset>
	                            		</div>

                                        <div class="col-md-6" id="divHargaNormal">
	                            			<label  class="text-body">Harga Normal</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="number" class="form-control" id="HargaNormal" name="HargaNormal" placeholder="Masukan Harga Normal" value="{{ count($paket) > 0 ? $paket[0]['HargaNormal'] : '' }}" required="">
	                            			</fieldset>
	                            		</div>

                                        <div class="col-md-6" id="divAkhirJamNormal">
	                            			<label  class="text-body">Akhir Jam Harga Normal</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="time" class="form-control" id="AkhirJamNormal" name="AkhirJamNormal" value="{{ count($paket) > 0 ? $paket[0]['AkhirJamNormal'] : '' }}">
	                            			</fieldset>
	                            		</div>

                                        <div class="col-md-12" id="divPerubahanHarga">
	                            			<label  class="text-body">Perubahan Harga</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="checkbox" id="chkPerubahanJam" name="chkPerubahanJam" >
	                            			</fieldset>
	                            		</div>

                                        <div class="col-md-6" id="divHargaBaru">
	                            			<label  class="text-body">Harga Baru</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="number" class="form-control" id="HargaBaru" name="HargaBaru" placeholder="Masukan Harga Baru" value="{{ count($paket) > 0 ? $paket[0]['HargaBaru'] : '' }}" >
	                            			</fieldset>
	                            		</div>

                                        <div class="col-md-6" id="divJamHargaBaru">
	                            			<label  class="text-body">Akhir Jam Harga Baru</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="time" class="form-control" id="AkhirJamPerubahanHarga" name="AkhirJamPerubahanHarga" value="{{ count($paket) > 0 ? $paket[0]['AkhirJamPerubahanHarga'] : '' }}" >
	                            			</fieldset>
	                            		</div>

                                        <div class="col-md-3">
	                            			<label  class="text-body">Diskon Table</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="number" class="form-control" id="DiskonTable" name="DiskonTable" placeholder="Masukan Diskon Table" value="{{ count($paket) > 0 ? $paket[0]['DiskonTable'] : '' }}" >
	                            			</fieldset>
	                            		</div>

                                        <div class="col-md-3">
	                            			<label  class="text-body">Diskon FnB</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="number" class="form-control" id="DiskonFnB" name="DiskonFnB" placeholder="Masukan Diskon FnB" value="{{ count($paket) > 0 ? $paket[0]['DiskonFnB'] : '' }}" >
	                            			</fieldset>
	                            		</div>

                                        <div class="col-md-3">
	                            			<label  class="text-body">Durasi Paket</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="number" class="form-control" id="DurasiPaket" name="DurasiPaket" value="{{ count($paket) > 0 ? $paket[0]['DurasiPaket'] : '1' }}" readonly>
                                                <p><small class="text-muted" id="SatuanDurasi">Menit.</small></p>
	                            			</fieldset>
	                            		</div>

										<div class="col-md-3">
	                            			<label  class="text-body">Bisa Pesan Online ? </label>
	                            			<fieldset class="form-group mb-3">
												<select name="BisaDipesan" id="BisaDipesan" class="js-example-basic-single js-states form-control bg-transparent" >
                                                    <option value="">Bisa Pesan Online ? </option>
                                                    <option value="Y" {{ 'Y' == (count($paket) > 0 ? $paket[0]['BisaDipesan'] : '') ? 'selected' : '' }}>YA</option>
                                                    <option value="N" {{ 'N' == (count($paket) > 0 ? $paket[0]['BisaDipesan'] : '') ? 'selected' : '' }}>TIDAK</option>
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
			
		});

        jQuery('#JenisPaket').change(function () {
            // console.log(jQuery('#JenisPaket').val());
            var JenisPaket = jQuery('#JenisPaket').val();
            if (JenisPaket == "PAKET") {
                jQuery('#SatuanDurasi').text('JAM');
                jQuery('#DurasiPaket').attr('readonly',false);

                jQuery('#divHargaBaru').hide();
                jQuery('#divJamHargaBaru').hide();
                jQuery('#divPerubahanHarga').hide();
                jQuery('#divAkhirJamNormal').hide();
            }
            else{
                jQuery('#SatuanDurasi').text(JenisPaket);
                jQuery('#DurasiPaket').attr('readonly',true);

                jQuery('#divHargaBaru').show();
                jQuery('#divJamHargaBaru').show();
                jQuery('#divPerubahanHarga').show();
                jQuery('#divAkhirJamNormal').show();
            }
        });
	});
</script>
@endpush