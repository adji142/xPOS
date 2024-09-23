@extends('parts.header')
	
@section('content')

<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">Kelompok Akses</li>
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
									<h3 class="card-label mb-0 font-weight-bold text-body">User 
									</h3>
								</div>
							    <div class="icons d-flex">
									<a href="{{ url('user/form/0') }}" class="btn btn-outline-primary rounded-pill font-weight-bold me-1 mb-1">Tambah Data</a>
									<div class="icons d-flex">
									<!-- <a href="{{ url('user/export') }}" class="btn btn-outline-success rounded-pill font-weight-bold me-1 mb-1">Download Excel</a> -->
								</div>
								</div>
							</div>
						
						</div>


					</div>
				</div>

				<div class="row">
					<div class="col-12  px-4">
						<div class="card card-custom gutter-b bg-white border-0" >
							<div class="card-header" >
								Filter Data
							</div>
							<div class="card-body" >
								<form action="{{ route('user') }}">
									<div class="row">
										<div class="col-md-3">
											<label  class="text-body">Kelompok Akses</label>
											<select name="KelompokAkses" id="KelompokAkses" class="js-example-basic-single js-states form-control bg-transparent" >
												<option value="">Pilih Kelompok Akses</option>
												@foreach($rolesdata as $ko)
													<option value="{{ $ko->id }}" {{ $ko->id == $oldKelompokAkses ? 'selected' : '' }}>
			                                            {{ $ko->RoleName }}
			                                        </option>
												@endforeach
												
											</select>
										</div>
										<div class="col-md-3">
											<label  class="text-body">Status User</label>
											<select name="StatusUser" id="StatusUser" class="js-example-basic-single js-states form-control bg-transparent">
												<option value="" {{ ($oldStatusUser) == '' ? 'selected' : '' }}>Pilih Status</option>
												<option value="Y" {{ ($oldStatusUser) == 'Y' ? 'selected' : '' }}>Aktif</option>
												<option value="N" {{ ($oldStatusUser) == 'N' ? 'selected' : '' }}>Tidak Aktif</option>
												
											</select>
										</div>
										<div class="col-md-3">
											<!-- <label  class="text-body">Status User</label> -->
											<br>
											<button type="submit" class="btn btn-danger text-white font-weight-bold me-1 mb-1">Cari Data</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="col-12  px-4">
						<div class="card card-custom gutter-b bg-white border-0" >
							<div class="card-body" >
								<div class="table-responsive" id="printableTable">
									<table id="orderTable" class="display" style="width:100%">
										<thead>
											<tr>
												<!-- <th>Kode User</th> -->
												<th>Email</th>
												<th>Nama User</th>
												<th>Level Akses</th>
												<th>Status User</th>
												<th class=" no-sort text-end">Action</th>
											</tr>
										</thead>
										<tbody>
											@if (count($users) > 0)
												@foreach($users as $v)
												<tr>
													<!-- <td>{{ $v['id'] }}</td> -->
													<td>{{ $v['email'] }}</td>
													<td>{{ $v['name'] }}</td>
													<td>{{ $v['RoleName'] }}</td>
													<td> <div class="{{ $v['StatusUser'] == 'Aktif' ? 'mr-0 text-success' : 'mr-0 text-danger' }} ">{{ $v['StatusUser'] }}</div> </td>
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
																<a class="dropdown-item" href="{{ url('user/form/' . $v['id']) }}">Edit</a>
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
</script>
@endpush