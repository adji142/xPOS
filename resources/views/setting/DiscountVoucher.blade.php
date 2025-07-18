@extends('parts.header')
	
@section('content')

<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">Discount Voucher</li>
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
				<div class="row">
					<div class="col-lg-12 col-xl-12 px-4">
						<div class="card card-custom gutter-b bg-transparent shadow-none border-0">
							<div class="card-header align-items-center border-bottom-dark px-0">
								<div class="card-title mb-0">
									<h3 class="card-label mb-0 font-weight-bold text-body">Daftar Discount Voucher</h3>
								</div>
								<div class="icons d-flex">
									<a href="{{ url('discountvoucher/form/-') }}" class="btn btn-outline-primary rounded-pill font-weight-bold me-1 mb-1">Tambah Data</a>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Table Section -->
				<div class="row">
					<div class="col-12 px-4">
						<div class="card card-custom gutter-b bg-white border-0">
							<div class="card-body">
								<div class="table-responsive" id="printableTable">
									<table id="voucherTable" class="display" style="width:100%">
										<thead>
											<tr>
												<th>Kode</th>
												<th>Diskon %</th>
												<th>Max Diskon</th>
												<th>Kuota</th>
												<th>Terpakai</th>
												<th>Tanggal Mulai</th>
												<th>Tanggal Selesai</th>
												<th>Keterangan</th>
												<th class="no-sort text-end">Action</th>
											</tr>
										</thead>
										<tbody>
											@if (count($discountvouchers) > 0)
												@foreach ($discountvouchers as $v)
													<tr>
														<td>{{ $v['VoucherCode'] }}</td>
														<td>{{ number_format($v['DiscountPercent'], 2) }}%</td>
														<td>Rp {{ number_format($v['MaximalDiscount'], 0, ',', '.') }}</td>
														<td>{{ $v['DiscountQuota'] }}</td>
														<td>{{ $v['DiscountUsed'] }}</td>
														<td>{{ \Carbon\Carbon::parse($v['StartDate'])->format('d-m-Y') }}</td>
														<td>{{ \Carbon\Carbon::parse($v['EndDate'])->format('d-m-Y') }}</td>
														<td>{{ $v['DiscountDescription'] }}</td>
														<td>
															<div class="card-toolbar text-end">
																<button class="btn p-0 shadow-none" type="button" id="dropdowneditButton{{ $v['id'] }}" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
																	<span class="svg-icon">
																		<svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-three-dots text-body" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
																			<path fill-rule="evenodd" d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"></path>
																		</svg>
																	</span>
																</button>
																<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdowneditButton{{ $v['id'] }}">
																	<a class="dropdown-item" href="{{ url('discountvoucher/form/' . $v['id']) }}">Edit</a>
																	<a class="dropdown-item" href="{{ route('discountvoucher-delete', $v['id']) }}" data-confirm-delete="true">Delete</a>
																</div>
															</div>
														</td>
													</tr>
												@endforeach
											@endif
										</tbody>
									</table>
								</div> <!-- end table responsive -->
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
	jQuery(document).ready(function() {
		jQuery('#voucherTable').DataTable({
			"pagingType": "simple_numbers",
			"columnDefs": [{
				"targets": 'no-sort',
				"orderable": false,
			}]
		});
	});
</script>
@endpush
