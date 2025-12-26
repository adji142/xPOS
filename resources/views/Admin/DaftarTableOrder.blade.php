@extends('parts.header')
	
@section('content')

<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">Admin</li>
				<li class="breadcrumb-item active" aria-current="page">Daftar Table Order</li>
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
									<h3 class="card-label mb-0 font-weight-bold text-body">Daftar Table Order</h3>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-12 px-4">
						<div class="card card-custom gutter-b bg-white border-0" >
							<div class="card-body" >
								<form action="{{ url('daftartableorder') }}" method="GET">
									<div class="row align-items-end">
										<div class="col-md-3">
											<div class="form-group mb-0">
												<label class="text-body">Tanggal Awal</label>
												<input type="date" name="TglAwal" class="form-control" value="{{ $tglAwal }}">
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group mb-0">
												<label class="text-body">Tanggal Akhir</label>
												<input type="date" name="TglAkhir" class="form-control" value="{{ $tglAkhir }}">
											</div>
										</div>
										<div class="col-md-2">
											<button type="submit" class="btn btn-primary">Filter</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-12 px-4">
						<div class="card card-custom gutter-b bg-white border-0" >
							<div class="card-body" >
								<div class="table-responsive" id="printableTable">
									<table id="orderTable" class="display" style="width:100%">
										<thead>
											<tr>
												<th>No</th>
												<th>No Transaksi</th>
												<th>Tgl Transaksi</th>
												<th>Jenis Paket</th>
												<th>Nama Table</th>
												<th>Durasi</th>
												<th>Status</th>
												<th class=" no-sort text-end">Action</th>
											</tr>
										</thead>
										<tbody>
											@if (count($data) > 0)
                                                @php $no = 1; @endphp
												@foreach($data as $v)
												<tr>
													<td>{{ $no++ }}</td>
													<td>{{ $v->NoTransaksi }}</td>
													<td>{{ $v->TglTransaksi }}</td>
													<td>{{ $v->JenisPaket }}</td>
													<td>{{ $v->NamaTable }}</td>
													<td>{{ $v->Durasi }}</td>
													<td>
                                                        @php
                                                            $statusLabel = '';
                                                            $statusClass = '';
                                                            switch($v->Status) {
                                                                case 1: $statusLabel = 'Aktif'; $statusClass = 'bg-success'; break;
                                                                case 0: $statusLabel = 'Inactive'; $statusClass = 'bg-secondary'; break;
                                                                case 99: $statusLabel = 'Hampir Habis'; $statusClass = 'bg-warning'; break;
                                                                case -1: $statusLabel = 'Checkout'; $statusClass = 'bg-danger'; break;
                                                                default: $statusLabel = 'Unknown'; $statusClass = 'bg-light';
                                                            }
                                                        @endphp
														<span class="badge {{ $statusClass }}">
															{{ $statusLabel }}
														</span>
													</td>
													<td>
														<div class="card-toolbar text-end">
                                                            @if($v->Status == 1)
                                                                <form action="{{ url('daftartableorder/reset') }}" method="POST" style="display:inline;">
                                                                    @csrf
                                                                    <input type="hidden" name="NoTransaksi" value="{{ $v->NoTransaksi }}">
                                                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Apakah anda yakin ingin mereset controller untuk transaksi ini?')">Reset Controller</button>
                                                                </form>
                                                            @else
                                                                <button class="btn btn-sm btn-outline-secondary" disabled>Reset Controller</button>
                                                            @endif
														</div>
													</td>
												</tr>
												@endforeach
											@endif
										</tbody>
									</table>
								</div>
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
	jQuery(document).ready(function() {
		jQuery('#orderTable').DataTable({
			"pagingType": "simple_numbers",
            "columnDefs": [ {
                "targets"  : 'no-sort',
                "orderable": false,
            }],
            "order": [[2, "desc"]]
		});
	});
</script>
@endpush
