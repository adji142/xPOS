@extends('parts.header')
	
@section('content')

<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item">
					<a href="{{ url('discountvoucher') }}">Discount Voucher</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">
					@if (!empty($voucher))
						Edit Discount Voucher
					@else
						Tambah Discount Voucher
					@endif
				</li>
			</ol>
		</nav>
	</div>
</div>
<!--end::Subheader-->

<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 px-4">

				<!-- Judul Header Form -->
				<div class="row">
					<div class="col-lg-12 col-xl-12 px-4">
						<div class="card card-custom gutter-b bg-transparent shadow-none border-0">
							<div class="card-header align-items-center border-bottom-dark px-0">
								<div class="card-title mb-0">
									<h3 class="card-label mb-0 font-weight-bold text-body">
										@if (!empty($voucher))
											Edit Discount Voucher
										@else
											Tambah Discount Voucher
										@endif
									</h3>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Form Input -->
				<div class="row">
					<div class="col-12 px-4">
						<div class="card card-custom gutter-b bg-white border-0">
							<div class="card-body">

								@if (!empty($voucher))
									<form action="{{ url('discountvoucher/edit') }}" method="post">
								@else
									<form action="{{ url('discountvoucher/store') }}" method="post">
								@endif

									@csrf

									<!-- Hidden ID untuk keperluan edit -->
									@if (!empty($voucher))
										<input type="hidden" name="id" value="{{ $voucher->id }}">
									@endif

									<div class="form-group row">

										<!-- Kode Voucher -->
										<div class="col-md-4">
											<label class="text-body">Kode Voucher</label>
											<fieldset class="form-group mb-3">
												<input type="text" class="form-control" id="VoucherCode" name="VoucherCode" placeholder="Masukkan Kode Voucher" value="{{ $voucher->VoucherCode ?? '' }}" required {{ !empty($voucher) ? 'readonly' : '' }}>
											</fieldset>
										</div>

										<!-- Diskon % -->
										<div class="col-md-2">
											<label class="text-body">Diskon (%)</label>
											<fieldset class="form-group mb-3">
												<input type="number" step="0.01" class="form-control" name="DiscountPercent" placeholder="%" value="{{ $voucher->DiscountPercent ?? '' }}" required>
											</fieldset>
										</div>

										<!-- Max Diskon -->
										<div class="col-md-2">
											<label class="text-body">Max Diskon</label>
											<fieldset class="form-group mb-3">
												<input type="number" step="0.01" class="form-control" name="MaximalDiscount" placeholder="Rp" value="{{ $voucher->MaximalDiscount ?? '' }}" required>
											</fieldset>
										</div>

										<!-- Kuota Diskon -->
										<div class="col-md-2">
											<label class="text-body">Kuota</label>
											<fieldset class="form-group mb-3">
												<input type="number" class="form-control" name="DiscountQuota" placeholder="Kuota" value="{{ $voucher->DiscountQuota ?? '' }}" required>
											</fieldset>
										</div>

										<!-- Digunakan (readonly) -->
										<div class="col-md-2">
											<label class="text-body">Terpakai</label>
											<fieldset class="form-group mb-3">
												<input type="number" class="form-control" name="DiscountUsed" value="{{ $voucher->DiscountUsed ?? 0 }}" readonly>
											</fieldset>
										</div>

										<!-- Tanggal Mulai -->
										<div class="col-md-3">
											<label class="text-body">Tanggal Mulai</label>
											<fieldset class="form-group mb-3">
												<input type="date" class="form-control" name="StartDate" value="{{ $voucher->StartDate ?? '' }}" required>
											</fieldset>
										</div>

										<!-- Tanggal Selesai -->
										<div class="col-md-3">
											<label class="text-body">Tanggal Selesai</label>
											<fieldset class="form-group mb-3">
												<input type="date" class="form-control" name="EndDate" value="{{ $voucher->EndDate ?? '' }}" required>
											</fieldset>
										</div>

										<!-- Keterangan Voucher -->
										<div class="col-md-6">
											<label class="text-body">Keterangan</label>
											<fieldset class="form-group mb-3">
												<textarea class="form-control" name="DiscountDescription" rows="2" placeholder="Keterangan tambahan...">{{ $voucher->DiscountDescription ?? '' }}</textarea>
											</fieldset>
										</div>

										<!-- Tombol Simpan -->
										<div class="col-md-12">
											<button type="submit" class="btn btn-success text-white font-weight-bold me-1 mb-1">Simpan</button>
										</div>
									</div>

								</form>

							</div> <!-- end card body -->
						</div> <!-- end card -->
					</div> <!-- end col -->
				</div> <!-- end row -->
			</div> <!-- end col -->
		</div> <!-- end row -->
	</div> <!-- end container -->
</div> <!-- end content -->

@endsection

@push('scripts')
<script type="text/javascript">
	$(function () {
		// Tambahkan JS tambahan jika diperlukan
	})
</script>
@endpush
