@extends('parts.header')
	
@section('content')

<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">Grup Customer</li>
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
									<h3 class="card-label mb-0 font-weight-bold text-body">Pelanggan 
									</h3>
								</div>
							    <div class="icons d-flex">
									<a href="{{ url('pelanggan/form/-') }}" class="btn btn-outline-primary rounded-pill font-weight-bold me-1 mb-1">Tambah Data</a>
									<a href="{{ url('pelanggan/export') }}" class="btn btn-outline-success rounded-pill font-weight-bold me-1 mb-1">Download Excel</a>
									<a href="{{ url('companysetting#bulkaction') }}" class="btn btn-outline-warning rounded-pill font-weight-bold me-1 mb-1">Import Data</a>
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
												<th>Kode Pelanggan</th>
												<th>Nama Pelanggan</th>
												<th>Grup Pelanggan</th>
												<th>Limit Piutang</th>
												<th>Status</th>
												<th>Membership</th>
												<th>Sisa Jatah (x)</th>
												<th>Harga Member</th>
												<th>Lama Bermain</th>
												<th>Email</th>
												<th>No. HP</th>
												<th>Alamat</th>
												<th>Provinsi</th>
												<th>Kota</th>
												<th>Kelurahan</th>
												<th>Kecamatan</th>
												<th>Tgl Paket bulanan</th>
												<th class=" no-sort text-end">Action</th>
											</tr>
										</thead>
										<tbody>
											@if (count($pelanggan) > 0)
												@foreach($pelanggan as $v)
												<tr>
													<td>{{ $v['KodePelanggan'] }}</td>
													<td>{{ $v['NamaPelanggan'] }}</td>
													<td>{{ $v['NamaGrup'] }}</td>
													<td>{{ $v['LimitPiutang'] }}</td>
													<td> <div class="{{ $v['StatusRecord'] == 'ACTIVE' ? 'mr-0 text-success' : 'mr-0 text-danger' }} ">{{ $v['StatusRecord'] }}</div> </td>
													<td>{{ $v['isPaidMembership'] == 1 ? 'Ya' : 'Tidak' }}</td>
                                            <td>{{ $v['MaxPlay'] - $v['Played'] }}</td>
                                            <td style="text-align: right">{{ number_format($v['MemberPrice'], 0, ',', '.') }}</td>
													<td>{{ $v['maxTimePerPlay'] }}</td>
													<td>{{ $v['Email'] }}</td>
													<td>{{ $v['NoTlp1'] }}</td>
													<td>{{ $v['Alamat'] }}</td>
													<td>{{ $v['prov_name'] }}</td>
													<td>{{ $v['city_name'] }}</td>
													<td>{{ $v['subdis_name'] }}</td>
													<td>{{ $v['dis_name'] }}</td>
													<td>{{ $v['TglBerlanggananPaketBulanan'] }}</td>
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
																<a class="dropdown-item" href="{{ url('pelanggan/form/' . $v['KodePelanggan']) }}">Edit</a>
																@if($v['isPaidMembership'] == 1)
																	<a class="dropdown-item btn-aktivasi-member" href="#" 
																		data-kode="{{ $v['KodePelanggan'] }}"
																		data-nama="{{ $v['NamaPelanggan'] }}"
																		data-harga="{{ $v['MemberPrice'] }}"
																		data-maxplay="{{ $v['MaxPlay'] }}"
																		data-playtime="{{ $v['maxTimePerPlay'] }}"
																		data-validuntil="{{ $v['ValidUntil'] }}">
																		Aktivasi Member
																	</a>
																	<a class="dropdown-item btn-perpanjang-member" href="#" 
																		data-kode="{{ $v['KodePelanggan'] }}"
																		data-nama="{{ $v['NamaPelanggan'] }}"
																		data-harga="{{ $v['MemberPrice'] }}"
																		data-maxplay="{{ $v['MaxPlay'] }}"
																		data-playtime="{{ $v['maxTimePerPlay'] }}"
																		data-validuntil="{{ $v['ValidUntil'] }}">
																		Perpanjang Member
																	</a>
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

	
{{-- Modal Aktivasi Member --}}
<div class="modal fade" id="modalAktivasiMember" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Aktivasi Member</h5>
				<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="frmAktivasiMember">
				<div class="modal-body">
					<input type="hidden" id="aktivasi_kode" name="kode_member">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group mb-3">
								<label>Kode Member</label>
								<input type="text" class="form-control" id="aktivasi_kode_display" readonly>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group mb-3">
								<label>Nama Member</label>
								<input type="text" class="form-control" id="aktivasi_nama" readonly>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group mb-3">
								<label>Harga Member</label>
								<input type="text" class="form-control" id="aktivasi_harga" readonly>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group mb-3">
								<label>Maksimal Bermain</label>
								<input type="text" class="form-control" id="aktivasi_maxplay" readonly>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group mb-3">
								<label>Lama Bermain Per Jam</label>
								<input type="text" class="form-control" id="aktivasi_playtime" readonly>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group mb-3">
								<label>Total Harga</label>
								<input type="text" class="form-control" id="aktivasi_total" readonly>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group mb-3">
								<label>Metode Pembayaran</label>
								<select class="form-control" id="aktivasi_metode" name="metode_pembayaran" required>
									<option value="">Pilih Metode Pembayaran</option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
					<button type="submit" class="btn btn-primary" id="btnAktivasiMember">Aktivasi</button>
				</div>
			</form>
		</div>
	</div>
</div>

{{-- Modal Perpanjang Member --}}
<div class="modal fade" id="modalPerpanjangMember" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Perpanjang Member</h5>
				<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="frmPerpanjangMember">
				<div class="modal-body">
					<input type="hidden" id="perpanjang_kode" name="kode_member">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group mb-3">
								<label>Kode Member</label>
								<input type="text" class="form-control" id="perpanjang_kode_display" readonly>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group mb-3">
								<label>Nama Member</label>
								<input type="text" class="form-control" id="perpanjang_nama" readonly>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group mb-3">
								<label>Harga Member</label>
								<input type="text" class="form-control" id="perpanjang_harga" readonly>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group mb-3">
								<label>Maksimal Bermain</label>
								<input type="text" class="form-control" id="perpanjang_maxplay" readonly>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group mb-3">
								<label>Lama Bermain Per Jam</label>
								<input type="text" class="form-control" id="perpanjang_playtime" readonly>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group mb-3">
								<label>Total Harga</label>
								<input type="text" class="form-control" id="perpanjang_total" readonly>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group mb-3">
								<label>Valid Until</label>
								<input type="date" class="form-control" id="perpanjang_validuntil" name="valid_until" required>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group mb-3">
								<label>Metode Pembayaran</label>
								<select class="form-control" id="perpanjang_metode" name="metode_pembayaran" required>
									<option value="">Pilih Metode Pembayaran</option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
					<button type="submit" class="btn btn-primary" id="btnPerpanjangMember">Perpanjang</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection

{{-- Midtrans Snap Script --}}
@if(env('MIDTRANS_IS_PRODUCTION', false))
<script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ $midtransclientkey ?? '' }}"></script>
@else
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ $midtransclientkey ?? '' }}"></script>
@endif

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

		// Load payment methods
		loadPaymentMethods();

		// Aktivasi Member Button Click
		jQuery(document).on('click', '.btn-aktivasi-member', function(e) {
			e.preventDefault();
			const kode = jQuery(this).data('kode');
			const nama = jQuery(this).data('nama');
			const harga = jQuery(this).data('harga');
			const maxplay = jQuery(this).data('maxplay');
			const playtime = jQuery(this).data('playtime');

			jQuery('#aktivasi_kode').val(kode);
			jQuery('#aktivasi_kode_display').val(kode);
			jQuery('#aktivasi_nama').val(nama);
			jQuery('#aktivasi_harga').val(formatNumber(harga));
			jQuery('#aktivasi_maxplay').val(maxplay);
			jQuery('#aktivasi_playtime').val(playtime + ' Jam');
			jQuery('#aktivasi_total').val(formatNumber(harga));

			jQuery('#modalAktivasiMember').modal('show');
		});

		// Perpanjang Member Button Click
		jQuery(document).on('click', '.btn-perpanjang-member', function(e) {
			e.preventDefault();
			const kode = jQuery(this).data('kode');
			const nama = jQuery(this).data('nama');
			const harga = jQuery(this).data('harga');
			const maxplay = jQuery(this).data('maxplay');
			const playtime = jQuery(this).data('playtime');
			const validuntil = jQuery(this).data('validuntil');

			jQuery('#perpanjang_kode').val(kode);
			jQuery('#perpanjang_kode_display').val(kode);
			jQuery('#perpanjang_nama').val(nama);
			jQuery('#perpanjang_harga').val(formatNumber(harga));
			jQuery('#perpanjang_maxplay').val(maxplay);
			jQuery('#perpanjang_playtime').val(playtime + ' Jam');
			jQuery('#perpanjang_total').val(formatNumber(harga));
			
			// Set current valid until if exists
			if (validuntil && validuntil !== 'null') {
				jQuery('#perpanjang_validuntil').val(validuntil.split(' ')[0]);
			}

			jQuery('#modalPerpanjangMember').modal('show');
		});

		// Form Aktivasi Submit
		jQuery('#frmAktivasiMember').on('submit', function(e) {
			e.preventDefault();
			
			const metode = jQuery('#aktivasi_metode').val();
			const verifikasi = jQuery('#aktivasi_metode option:selected').data('verifikasi');
			
			if (!metode) {
				Swal.fire('Error', 'Pilih metode pembayaran terlebih dahulu', 'error');
				return;
			}

			if (verifikasi === 'AUTO') {
				// Payment Gateway
				processPaymentGateway('aktivasi');
			} else {
				// Manual Payment
				processManualActivation();
			}
		});

		// Form Perpanjang Submit
		jQuery('#frmPerpanjangMember').on('submit', function(e) {
			e.preventDefault();
			
			const metode = jQuery('#perpanjang_metode').val();
			const verifikasi = jQuery('#perpanjang_metode option:selected').data('verifikasi');
			const validUntil = jQuery('#perpanjang_validuntil').val();
			
			if (!metode) {
				Swal.fire('Error', 'Pilih metode pembayaran terlebih dahulu', 'error');
				return;
			}

			if (!validUntil) {
				Swal.fire('Error', 'Tentukan tanggal berlaku terlebih dahulu', 'error');
				return;
			}

			if (verifikasi === 'AUTO') {
				// Payment Gateway
				processPaymentGateway('perpanjang');
			} else {
				// Manual Payment
				processManualExtension();
			}
		});

	});

	function loadPaymentMethods() {
		jQuery.ajax({
			url: "{{ route('metodepembayaran-viewJson') }}",
			type: 'POST',
			data: {
				_token: '{{ csrf_token() }}'
			},
			success: function(response) {
				if (response.success && response.data) {
					let options = '<option value="">Pilih Metode Pembayaran</option>';
					response.data.forEach(function(item) {
						options += `<option value="${item.id}" data-verifikasi="${item.MetodeVerifikasi}">${item.NamaMetodePembayaran}</option>`;
					});
					jQuery('#aktivasi_metode').html(options);
					jQuery('#perpanjang_metode').html(options);
				}
			}
		});
	}

	function processManualActivation() {
		const formData = {
			kode_member: jQuery('#aktivasi_kode').val(),
			metode_pembayaran: jQuery('#aktivasi_metode').val(),
			_token: '{{ csrf_token() }}'
		};

		jQuery('#btnAktivasiMember').prop('disabled', true).text('Processing...');

		jQuery.ajax({
			url: "{{ url('pelanggan/activate') }}",
			type: 'POST',
			data: formData,
			success: function(response) {
				jQuery('#btnAktivasiMember').prop('disabled', false).text('Aktivasi');
				
				if (response.success) {
					Swal.fire({
						icon: 'success',
						title: 'Berhasil',
						text: 'Member berhasil diaktivasi',
					}).then(() => {
						jQuery('#modalAktivasiMember').modal('hide');
						location.reload();
					});
				} else {
					Swal.fire('Error', response.message || 'Gagal mengaktivasi member', 'error');
				}
			},
			error: function(xhr) {
				jQuery('#btnAktivasiMember').prop('disabled', false).text('Aktivasi');
				Swal.fire('Error', 'Terjadi kesalahan sistem', 'error');
			}
		});
	}

	function processManualExtension() {
		const formData = {
			kode_member: jQuery('#perpanjang_kode').val(),
			valid_until: jQuery('#perpanjang_validuntil').val(),
			metode_pembayaran: jQuery('#perpanjang_metode').val(),
			_token: '{{ csrf_token() }}'
		};

		jQuery('#btnPerpanjangMember').prop('disabled', true).text('Processing...');

		jQuery.ajax({
			url: "{{ url('pelanggan/extend') }}",
			type: 'POST',
			data: formData,
			success: function(response) {
				jQuery('#btnPerpanjangMember').prop('disabled', false).text('Perpanjang');
				
				if (response.success) {
					Swal.fire({
						icon: 'success',
						title: 'Berhasil',
						text: 'Member berhasil diperpanjang',
					}).then(() => {
						jQuery('#modalPerpanjangMember').modal('hide');
						location.reload();
					});
				} else {
					Swal.fire('Error', response.message || 'Gagal memperpanjang member', 'error');
				}
			},
			error: function(xhr) {
				jQuery('#btnPerpanjangMember').prop('disabled', false).text('Perpanjang');
				Swal.fire('Error', 'Terjadi kesalahan sistem', 'error');
			}
		});
	}

	function processPaymentGateway(type) {
		const formData = type === 'aktivasi' ? {
			kode_member: jQuery('#aktivasi_kode').val(),
			metode_pembayaran: jQuery('#aktivasi_metode').val(),
			type: 'aktivasi',
			_token: '{{ csrf_token() }}'
		} : {
			kode_member: jQuery('#perpanjang_kode').val(),
			valid_until: jQuery('#perpanjang_validuntil').val(),
			metode_pembayaran: jQuery('#perpanjang_metode').val(),
			type: 'perpanjang',
			_token: '{{ csrf_token() }}'
		};

		const btnId = type === 'aktivasi' ? '#btnAktivasiMember' : '#btnPerpanjangMember';
		const btnText = type === 'aktivasi' ? 'Aktivasi' : 'Perpanjang';

		jQuery(btnId).prop('disabled', true).text('Processing...');

		jQuery.ajax({
			url: "{{ url('pelanggan/payment-gateway') }}",
			type: 'POST',
			data: formData,
			success: function(response) {
				jQuery(btnId).prop('disabled', false).text(btnText);
				
				if (response.success && response.snap_token) {
					// Close modal
					if (type === 'aktivasi') {
						jQuery('#modalAktivasiMember').modal('hide');
					} else {
						jQuery('#modalPerpanjangMember').modal('hide');
					}

					// Open payment gateway in new window or show QR
					window.snap.pay(response.snap_token, {
						onSuccess: function(result) {
							// Call backend to process payment and create invoice
							jQuery.ajax({
								url: "{{ url('pelanggan/payment-callback') }}",
								type: 'POST',
								data: {
									order_id: response.order_id,
									status_code: result.status_code,
									transaction_status: result.transaction_status,
									metadata: formData.type === 'aktivasi' ? 
										JSON.stringify({
											kode_member: formData.kode_member,
											type: formData.type,
											valid_until: '',
											metode_id: formData.metode_pembayaran,
											user_id: {{ Auth::user()->id }},
											record_owner_id: '{{ Auth::user()->RecordOwnerID }}'
										}) :
										JSON.stringify({
											kode_member: formData.kode_member,
											type: formData.type,
											valid_until: formData.valid_until,
											metode_id: formData.metode_pembayaran,
											user_id: {{ Auth::user()->id }},
											record_owner_id: '{{ Auth::user()->RecordOwnerID }}'
										}),
									_token: '{{ csrf_token() }}'
								},
								success: function(callbackResponse) {
									if (callbackResponse.success) {
										Swal.fire({
											icon: 'success',
											title: 'Pembayaran Berhasil',
											text: 'Member berhasil ' + (type === 'aktivasi' ? 'diaktivasi' : 'diperpanjang'),
										}).then(() => {
											location.reload();
										});
									} else {
										Swal.fire('Error', callbackResponse.message || 'Gagal memproses pembayaran', 'error');
									}
								},
								error: function() {
									Swal.fire('Error', 'Terjadi kesalahan saat memproses pembayaran', 'error');
								}
							});
						},
						onPending: function(result) {
							Swal.fire('Info', 'Menunggu pembayaran...', 'info');
						},
						onError: function(result) {
							Swal.fire('Error', 'Pembayaran gagal', 'error');
						},
						onClose: function() {
							console.log('Payment popup closed');
						}
					});
				} else {
					Swal.fire('Error', response.message || 'Gagal membuat transaksi', 'error');
				}
			},
			error: function(xhr) {
				jQuery(btnId).prop('disabled', false).text(btnText);
				Swal.fire('Error', 'Terjadi kesalahan sistem', 'error');
			}
		});
	}

	function formatNumber(num) {
		return new Intl.NumberFormat('id-ID').format(num);
	}
</script>
@endpush