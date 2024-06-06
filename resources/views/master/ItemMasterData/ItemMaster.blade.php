@extends('parts.header')
	
@section('content')

<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">Item Master</li>
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
									<h3 class="card-label mb-0 font-weight-bold text-body">Item Master 
									</h3>
								</div>
							    <div class="icons d-flex">
									<a href="{{ url('itemmaster/form/-') }}" class="btn btn-outline-primary rounded-pill font-weight-bold me-1 mb-1">Tambah Data</a>
								
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
								<form action="{{ route('itemmaster') }}">
									<div class="row">
										<div class="col-md-3">
											<label  class="text-body">Jenis Item</label>
											<select name="KodeJenis" id="KodeJenis" class="js-example-basic-single js-states form-control bg-transparent" >
												<option value="">Pilih Jenis Item</option>
												@foreach($jenisitem as $ko)
													<option value="{{ $ko->KodeJenis }}" {{ $ko->id == $oldKodeJenis ? 'selected' : '' }}>
			                                            {{ $ko->NamaJenis }}
			                                        </option>
												@endforeach
												
											</select>
										</div>
										<div class="col-md-3">
											<label  class="text-body">Merk</label>
											<select name="merk" id="merk" class="js-example-basic-single js-states form-control bg-transparent" >
												<option value="">Pilih Merk</option>
												@foreach($merk as $ko)
													<option value="{{ $ko->KodeMerk }}" {{ $ko->id == $oldMerk ? 'selected' : '' }}>
			                                            {{ $ko->NamaMerk }}
			                                        </option>
												@endforeach
												
											</select>
										</div>
										<div class="col-md-3">
											<label  class="text-body">Status Item</label>
											<select name="Active" id="Active" class="js-example-basic-single js-states form-control bg-transparent">
												<option value="" {{ ($oldActive) == '' ? 'selected' : '' }}>Pilih Status</option>
												<option value="Y" {{ ($oldActive) == 'Y' ? 'selected' : '' }}>Aktif</option>
												<option value="N" {{ ($oldActive) == 'N' ? 'selected' : '' }}>Tidak Aktif</option>
												
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
												<th>Kode Item</th>
												<th>Nama Item</th>
												<th>Barcode</th>
												<th>Harga Jual</th>
												<th>Harga Pokok</th>
												<th>Harga Pembelian</th>
												<th>Stock</th>
												<th>Min. Stock</th>
												<th>Jenis Item</th>
												<th>Merk</th>
												<th>Rak</th>
												<th>Tipe Item</th>
												<th class=" no-sort text-end">Action</th>
											</tr>
										</thead>
										<tbody>
											@if (count($itemmaster) > 0)
												@foreach($itemmaster as $v)
												<tr>
													<td>{{ $v['KodeItem'] }}</td>
													<td>{{ $v['NamaItem'] }}</td>
													<td>{{ $v['Barcode'] }}</td>
													<td>{{ number_format($v['HargaJual']) }}</td>
													<td>{{ number_format($v['HargaPokokPenjualan']) }}</td>
													<td>{{ number_format($v['HargaBeliTerakhir']) }}</td>
													<td>{{ number_format($v['Stock']) }}</td>
													<td>{{ number_format($v['StockMinimum']) }}</td>
													<td>{{ $v['NamaJenis'] }}</td>
													<td>{{ $v['NamaMerk'] }}</td>
													<td>{{ $v['Rak'] }}</td>
													<td>{{ $v['ItemType'] }}</td>
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
																<a class="dropdown-item" href="{{ url('itemmaster/form/' . $v['KodeItem']) }}">Edit</a>
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