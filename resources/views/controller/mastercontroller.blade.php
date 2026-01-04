@extends('parts.header')
	
@section('content')

<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">Master Controller</li>
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
									<h3 class="card-label mb-0 font-weight-bold text-body">Master Controller 
									</h3>
								</div>
							    <div class="icons d-flex">
									<a href="{{ url('controller/form/-') }}" class="btn btn-outline-primary rounded-pill font-weight-bold me-1 mb-1">Tambah Data</a>
								</div>
							</div>
						
						</div>


					</div>
				</div>

				<div class="row">
					<div class="col-12  px-4">
						<div class="card card-custom gutter-b bg-white border-0" >
							<div class="card-body" >
								<div class="table-responsive" id="printableTable">
									<table id="orderTable" class="display" style="width:100%">
										<thead>
											<tr>
												<th>Nama Controller</th>
                                                <th>SN</th>
                                                <th>Port</th>
                                                <th>BaudRate</th>
												<th>Maximal Node</th>
												<th>Node Terpakai</th>
												<th class=" no-sort text-end">Action</th>
											</tr>
										</thead>
										<tbody>
											@if (count($controller) > 0)
												@foreach($controller as $v)
												<tr>
													<td>{{ $v['NamaController'] }}</td>
													<td>{{ $v['SN'] }}</td>
                                                    <td>{{ $v['Port'] }}</td>
                                                    <td>{{ $v['BaudRate'] }}</td>
													<td>{{ $v['MaximalNode'] }}</td>
													<td>{{ $v['JumlahTitikLampu'] }}</td>
													<td>
														<div class="card-toolbar text-end">
															<button class="btn p-0 shadow-none" type="button" id="dropdowneditButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
																<span class="svg-icon">
																	<svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-three-dots text-body" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
																		<path fill-rule="evenodd" d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"></path>
																	</svg>
																</span>
															</button>
															<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdowneditButton1"  style="position: absolute; transform: translate3d(1001px, 111px, 0px); top: 0px; left: 0px; will-change: transform;">
																<a class="dropdown-item" href="{{ url('controller/form/' . $v['id']) }}">Edit</a>
																<a class="dropdown-item" title="Delete" href="{{ route('controller-delete', $v['id']) }}" data-confirm-delete="true">Delete</a>
																<a class="dropdown-item" title="Restart" id="btRestart" data-serialnumber="{{ $v['SN'] }}">Restart Device</a>
																<a class="dropdown-item" title="Reset" id="btReset" data-serialnumber="{{ $v['SN'] }}">Reset Device Setting</a>
															</div>
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
		}]
		});
	} );

	jQuery('#btRestart').click(function (e) {
		e.preventDefault();
		const SN = jQuery(this).data('serialnumber');

		swal.fire({
			title: "Are you sure?",
			text: "Restart Device",
			icon: "warning",
			showCancelButton: true,
			confirmButtonText: 'Yes',
			cancelButtonText: 'No',
			dangerMode: true,
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					async:false,
					url: "{{route('controller-editcommand')}}",
					type: 'POST',
					headers: {
						'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
					},
					data: {
						'SN':SN,
						'Command': 1
					},
					success: function (data) {
						if(data.success == true){
							Swal.fire({
								icon: "success",
								title: "Horray..",
								text: "Request Restart Device Berhasil dikirim ke Device",
							}).then((result) => {
								location.reload();
							});
						}
						else{
							Swal.fire({
								icon: "error",
								title: "Oops..",
								text: "Data Gagal Diproses " + data.message,
							});
						}
					},
					error: function (data) {
						Swal.fire({
							icon: "error",
							title: "Oops..",
							text: "Data Gagal Diproses " + data,
						});
					}
				});
				// swal.fire("Restart Device", {
				// 	icon: "success",
				// });
			}
		});

	});


	jQuery('#btReset').click(function (e) {
		e.preventDefault();
		const SN = jQuery(this).data('serialnumber');

		swal.fire({
			title: "Are you sure?",
			text: "Reset Device Setting",
			icon: "warning",
			showCancelButton: true,
			confirmButtonText: 'Yes',
			cancelButtonText: 'No',
			dangerMode: true,
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					async:false,
					url: "{{route('controller-editcommand')}}",
					type: 'POST',
					headers: {
						'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
					},
					data: {
						'SN':SN,
						'Command': 2
					},
					success: function (data) {
						if(data.success == true){
							Swal.fire({
								icon: "success",
								title: "Horray..",
								text: "Request Reset Setting Device Berhasil dikirim ke Device",
							}).then((result) => {
								location.reload();
							});
						}
						else{
							Swal.fire({
								icon: "error",
								title: "Oops..",
								text: "Data Gagal Diproses " + data.message,
							});
						}
					},
					error: function (data) {
						Swal.fire({
							icon: "error",
							title: "Oops..",
							text: "Data Gagal Diproses " + data,
						});
					}
				});
				// swal.fire("Restart Device", {
				// 	icon: "success",
				// });
			}
		});

	});
</script>
@endpush