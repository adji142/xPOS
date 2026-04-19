@extends('parts.header')
	
@section('content')

<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">Admin</li>
				<li class="breadcrumb-item active" aria-current="page">Serial Number</li>
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
									<h3 class="card-label mb-0 font-weight-bold text-body">Daftar Serial Number</h3>
								</div>
							    <div class="icons d-flex">
									<a href="{{ url('serialnumber/form/-') }}" class="btn btn-outline-primary rounded-pill font-weight-bold me-1 mb-1">Tambah Data</a>
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
												<th>No</th>
												<th>Serial Number</th>
												<th>Kode Partner</th>
												<th>Keterangan</th>
												<th>Jumlah Node Maximal</th>
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
													<td>{{ $v->SerialNumber }}</td>
													<td>{{ $v->KodePartner }}</td>
													<td>{{ $v->Keterangan }}</td>
													<td>{{ $v->MaximalNode }}</td>
													<td>
														<span class="badge {{ $v->Status == 'CLAIMED' ? 'bg-success' : ($v->Status == 'BLOCKED' ? 'bg-danger' : 'bg-secondary') }}">
															{{ $v->Status }}
														</span>
													</td>
													<td>
														<div class="card-toolbar text-end">
															<button class="btn p-0 shadow-none" type="button" id="dropdowneditButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
																<span class="svg-icon">
																	<svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-three-dots text-body" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
																		<path fill-rule="evenodd" d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"></path>
																	</svg>
																</span>
															</button>
															<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdowneditButton1">
																<a class="dropdown-item" href="{{ url('serialnumber/form/' . $v->id) }}">Edit</a>
                                                                <form action="{{ url('serialnumber/delete/' . $v->id) }}" method="POST" style="display:inline;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="dropdown-item" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">Delete</button>
                                                                </form>
                                                                @if ($v->Status == 'BLOCKED')
                                                                    <button class="dropdown-item" onclick="unblockSN('{{ $v->SerialNumber }}')">Unblock</button>
                                                                @else
                                                                    <button class="dropdown-item text-danger" onclick="openBlockModal('{{ $v->SerialNumber }}')">Block</button>
                                                                @endif
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

<!-- Block Modal -->
<div class="modal fade" id="blockModal" tabindex="-1" aria-labelledby="blockModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="blockModalLabel">Blokir Serial Number</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="blockSN">
        <div class="mb-3">
          <label for="blockReason" class="form-label">Alasan Blokir</label>
          <textarea class="form-control" id="blockReason" rows="3" placeholder="Masukkan alasan pemblokiran..."></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-danger" onclick="submitBlock()">Simpan Blokir</button>
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('#orderTable').DataTable({
			"pagingType": "simple_numbers",
            "columnDefs": [ {
                "targets"  : 'no-sort',
                "orderable": false,
            }]
		});
	});

    function openBlockModal(sn) {
        $('#blockSN').val(sn);
        $('#blockReason').val('');
        new bootstrap.Modal(document.getElementById('blockModal')).show();
    }

    function submitBlock() {
        const sn = $('#blockSN').val();
        const reason = $('#blockReason').val();

        if (!reason) {
            Swal.fire('Error', 'Alasan blokir harus diisi!', 'error');
            return;
        }

        $.ajax({
            url: "{{ route('serialnumber-block') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                SerialNumber: sn,
                BlockedReason: reason
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire('Success', response.message, 'success').then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            },
            error: function(err) {
                Swal.fire('Error', 'Terjadi kesalahan sistem.', 'error');
            }
        });
    }

    function unblockSN(sn) {
        Swal.fire({
            title: 'Konfirmasi Unblock',
            text: "Apakah Anda yakin ingin membuka blokir Serial Number " + sn + "?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Unblock!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('serialnumber-unblock') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        SerialNumber: sn
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Success', response.message, 'success').then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error', response.message, 'error');
                        }
                    },
                    error: function(err) {
                        Swal.fire('Error', 'Terjadi kesalahan sistem.', 'error');
                    }
                });
            }
        });
    }
</script>
@endpush
