@extends('parts.header')
	
@section('content')

<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">
					<a href="{{route('companysetting')}}">Setting Data Perusahaan</a>
				</li>
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
										Setting Data perusahaan
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
								<form action="{{route('companysetting-edit')}}" method="post">
									@csrf
									<div class="form-group row">
										<div class="col-md-3">
	                            			<label  class="text-body">Kode Perusahaan</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="text" class="form-control" id="KodePartner" name="KodePartner" placeholder="Masukan Kode KelompokRekening" value="{{ count($company) > 0 ? $company[0]['KodePartner'] : '' }}"  readonly="" >
	                            			</fieldset>
	                            			
	                            		</div>

	                            		<div class="col-md-9">
	                            			<label  class="text-body">Nama Perusahaan</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="text" class="form-control" id="NamaPartner" name="NamaPartner" placeholder="Masukan Nama Perusahaan" value="{{ count($company) > 0 ? $company[0]['NamaPartner'] : '' }}"  >
	                            			</fieldset>
	                            			
	                            		</div>

	                            		<div class="col-md-12">
	                            			<label  class="text-body">Alamat</label>
	                            			<fieldset class="form-group mb-12">
	                            				<textarea class="form-control" id="AlamatTagihan" name="AlamatTagihan" rows="3" placeholder="Masukan Alamat">{{ count($company) > 0 ? $company[0]['AlamatTagihan'] : '' }}</textarea>
	                            			</fieldset>
	                            		</div>

	                            		<div class="col-md-6">
	                            			<label  class="text-body">Telepon</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="text" class="form-control" id="NoTlp" name="NoTlp" placeholder="Masukan Nomor Telephone" value="{{ count($company) > 0 ? $company[0]['NoTlp'] : '' }}"  >
	                            			</fieldset>
	                            			
	                            		</div>

	                            		<div class="col-md-6">
	                            			<label  class="text-body">No. HP</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="text" class="form-control" id="NoHP" name="NoHP" placeholder="Masukan Nomor Handphone" value="{{ count($company) > 0 ? $company[0]['NoHP'] : '' }}"  >
	                            			</fieldset>
	                            			
	                            		</div>

	                            		<div class="col-md-6">
	                            			<label  class="text-body">Tgl. Mulai Berlangganan</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="date" class="form-control" id="StartSubs" name="StartSubs" placeholder="Masukan Nomor Handphone" value="{{ count($company) > 0 ? $company[0]['StartSubs'] : '' }}" readonly="" >
	                            			</fieldset>
	                            			
	                            		</div>

	                            		<div class="col-md-6">
	                            			<label  class="text-body">Tgl. Selesai Berlangganan</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="date" class="form-control" id="EndSubs" name="EndSubs" placeholder="Masukan Nomor Handphone" value="{{ count($company) > 0 ? $company[0]['EndSubs'] : '' }}" readonly="" >
	                            			</fieldset>
	                            			
	                            		</div>

	                            		<div class="col-md-6">
	                            			<label  class="text-body">NPWP</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="text" class="form-control" id="NPWP" name="NPWP" placeholder="Masukan Nomor NPWP" value="{{ count($company) > 0 ? $company[0]['NPWP'] : '' }}">
	                            			</fieldset>
	                            			
	                            		</div>

	                            		<div class="col-md-6">
	                            			<label  class="text-body">Tanggal PKP</label>
	                            			<?php echo $company[0]['TglPKP']; ?>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="date" class="form-control" id="TglPKP" name="TglPKP" placeholder="Masukan Nomor Handphone" value="{{ count($company) > 0 ? $company[0]['TglPKP'] : '2000-01-01' }}" >
	                            			</fieldset>
	                            			
	                            		</div>

	                            		<div class="col-md-12">
	                            			<label  class="text-body">PPN</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="number" class="form-control" id="PPN" name="PPN" placeholder="Masukan Nomor Handphone" value="{{ count($company) > 0 ? $company[0]['PPN'] : 0 }}" >
	                            			</fieldset>
	                            			<label for="isHargaJualIncludePPN">Harga Jual Sudah Termasuk PPN</label>
	                            			<input type="checkbox" class="checkbox-input" id="isHargaJualIncludePPN" {{ count($company) > 0 ? $company[0]['isHargaJualIncludePPN'] == 1 ? 'checked' : '' : '' }}>
	                            			
	                            		</div>

	                            		<div class="col-md-12">
	                            			<label  class="text-body">Printer Register</label>
	                            			<fieldset class="form-group mb-3">
	                            				<select name="NamaPosPrinter" id="NamaPosPrinter" class="js-example-basic-single js-states form-control bg-transparent">
	                            					
	                            				</select>
	                            			</fieldset>
	                            			
	                            		</div>

	                            		<!-- <a href="{{ url('companysetting/testprint') }}">Test Print</a> -->
	                            		<div class="col-md-12">
	                            			<label  class="text-body">Keterangan Footer</label>
	                            			<fieldset class="form-group mb-12">
	                            				<textarea class="form-control" id="FooterNota" name="FooterNota" rows="3" placeholder="Masukan Alamat">{{ count($company) > 0 ? $company[0]['FooterNota'] : '' }}</textarea>
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