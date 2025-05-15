@extends('parts.header')
	
@section('content')

<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">Retur Pembelian</li>
			</ol>
		</nav>
	</div>
</div>
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
									<h3 class="card-label mb-0 font-weight-bold text-body">Retur Pembelian 
									</h3>
								</div>
							    <div class="icons d-flex">
									<a href="{{ url('returpembelian/form/-') }}" class="btn btn-outline-primary rounded-pill font-weight-bold me-1 mb-1">Tambah Data</a>
								
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
								<div class="row">
									<div class="col-md-3">
										<label  class="text-body">Tanggal Awal</label>
										<input type="date" name="TglAwal" id="TglAwal" class="form-control">
									</div>
									<div class="col-md-3">
										<label  class="text-body">Tanggal Akhir</label>
										<input type="date" name="TglAkhir" id="TglAkhir" class="form-control">
									</div>
									<div class="col-md-3">
										<!-- <?php echo json_encode($supplier); ?> -->
										<label  class="text-body">Supplier</label>
										<select name="KodeVendor" id="KodeVendor" class="js-example-basic-single js-states form-control bg-transparent" >
											<option value="">Pilih Supplier</option>
											@foreach($supplier as $ko)
												<option value="{{ $ko->KodeSupplier }}" >
		                                            {{ $ko->NamaSupplier }}
		                                        </option>
											@endforeach
											
										</select>
									</div>
									<div class="col-md-3">
										<br>
										<button class="btn btn-outline-primary rounded-pill font-weight-bold me-1 mb-1">Cari Data</button>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-12  px-4">
						<div class="card card-custom gutter-b bg-white border-0" >
							<div class="card-body" >
								<div class="dx-viewport demo-container">
				                	<div id="data-grid-demo">
				                  		<div id="gridContainerHeader"></div>
				                	</div>
				              	</div>
							</div>

							<div class="card-body" >
								<div class="dx-viewport demo-container">
				                	<div id="data-grid-demo">
				                  		<div id="gridContainerDetail"></div>
				                	</div>
				              	</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
		</div>
	</div>
	
</div>

<div class="modal fade" id="webViewModal" tabindex="-1" aria-labelledby="webViewModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="webViewModalLabel">Web View</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" style="height: 500px;">
        <iframe src="" width="100%" height="100%" frameborder="0"></iframe>
      </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id='btnPrint' >Cetak</button>
            <button type="button" class="btn btn-success" id='btnEmail'>Kirim Email</button>
            <button type="button" class="btn btn-warning" id='btnWhatsApp'>Kirim Pesan WhatsApp</button>
        </div>

    </div>
  </div>
</div>

@endsection

@push('scripts')
<script type="text/javascript">
    const documentBaseUrl = "{{ route('document') }}";
	jQuery(document).ready(function() {
		var now = new Date();
    	var day = ("0" + now.getDate()).slice(-2);
    	var month = ("0" + (now.getMonth() + 1)).slice(-2);
    	var firstDay = now.getFullYear()+"-"+month+"-01";
    	var NowDay = now.getFullYear()+"-"+month+"-"+day;

    	jQuery('#TglAwal').val(firstDay);
    	jQuery('#TglAkhir').val(NowDay);

		// bindGridHeader([]);
        GetHeader();
		bindGridDetail([]);
	});

    jQuery('#btnPrint').on('click', function () {
        const iframeSrc = $('#webViewModal iframe').attr('src');
        if (iframeSrc) {
            window.open(iframeSrc, '_blank');
        }
    });

    jQuery('#btnEmail').on('click', function () {
        const btn = $(this);
        const originalHtml = btn.html(); // Simpan isi tombol awal
        btn.html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Sedang proses...');
        btn.prop('disabled', true); // Nonaktifkan tombol sementara

        const iframeSrc = $('#webViewModal iframe').attr('src');
        const url = new URL(iframeSrc, window.location.origin);
        const nomor = url.searchParams.get('NomorTransaksi');
        const tipe = url.searchParams.get('TipeTransaksi');

        if (!nomor || !tipe) {
            alert("Data transaksi tidak lengkap.");
            btn.html(originalHtml);
            btn.prop('disabled', false);
            return;
        }

        $.ajax({
            type: 'POST',
            url: "{{ route('sendemail') }}",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
            },
            data: {
                NomorTransaksi: nomor,
                TipeTransaksi: tipe
            },
            success: function(response) {
                // alert("Email berhasil dikirim.");
                Swal.fire({
                    html: "Email berhasil dikirim!",
                    icon: "success",
                    title: "Horray...",
                    // text: "Data berhasil disimpan! <br> " + response.Kembalian,
                }).then((result)=>{
                    btn.html(originalHtml);
                    btn.prop('disabled', false); // Aktifkan kembali tombol
                });
            },
            error: function(xhr, status, error) {
                // alert("Gagal mengirim email.");
                Swal.fire({
                    icon: "error",
                    title: "Opps...",
                    text: response.message,
                }).then((result)=>{
                    btn.html(originalHtml);
                    btn.prop('disabled', false); // Aktifkan kembali tombol
                });
            }
        });

    });

    jQuery('#btnWhatsApp').on('click', function () {
        const btn = $(this);
        const originalHtml = btn.html(); // Simpan isi tombol awal
        btn.html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Sedang proses...');
        btn.prop('disabled', true); // Nonaktifkan tombol sementara

        const iframeSrc = $('#webViewModal iframe').attr('src');
        const url = new URL(iframeSrc, window.location.origin);
        const nomor = url.searchParams.get('NomorTransaksi');
        const tipe = url.searchParams.get('TipeTransaksi');

        if (!nomor || !tipe) {
            alert("Data transaksi tidak lengkap.");
            btn.html(originalHtml);
            btn.prop('disabled', false);
            return;
        }

        $.ajax({
            type: 'POST',
            url: "{{ route('sendwa') }}",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
            },
            data: {
                NomorTransaksi: nomor,
                TipeTransaksi: tipe
            },
            success: function(response) {
                if (response.whatsappurl != "") {
                    window.open(response.whatsappurl, '_blank');
                } else {
                    // alert("Gagal mengirim pesan WhatsApp.");
                    Swal.fire({
                        icon: "error",
                        title: "Opps...",
                        text: "Gagal mengirim pesan WhatsApp.",
                    })
                }
                btn.html(originalHtml);
                btn.prop('disabled', false); // Aktifkan kembali tombol
            },
            error: function(xhr, status, error) {
                // alert("Gagal mengirim WA.");
                Swal.fire({
                    icon: "error",
                    title: "Opps...",
                    text: "Gagal mengirim pesan WhatsApp. " + error,
                })
                btn.html(originalHtml);
                btn.prop('disabled', false); // Aktifkan kembali tombol
            }
        });

    });

    function showCetakModal(noTransaksi) {
        var url = documentBaseUrl + "?NomorTransaksi=" + encodeURIComponent(noTransaksi) + "&TipeTransaksi=returpembelian";
        jQuery('#webViewModal iframe').attr('src', url);
        jQuery('#webViewModal').modal({backdrop: 'static', keyboard: false})
        jQuery('#webViewModal').modal('show');
    }

    function GetHeader() {
        $.ajax({
            async:false,
            type: 'post',
            url: "{{route('returpembelian-readheader')}}",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
            },
            data: {
                'TglAwal' : jQuery('#TglAwal').val(),
                'TglAkhir' : jQuery('#TglAkhir').val(),
                'KodeVendor' :jQuery('#KodeVendor').val()
            },
            dataType: 'json',
            success: function(response) {
                bindGridHeader(response.data)
            }
        })
    }

    function GetDetail(NoTransaksi) {
        $.ajax({
            async:false,
            type: 'post',
            url: "{{route('returpembelian-readdetail')}}",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
            },
            data: {
                'NoTransaksi' : NoTransaksi
            },
            dataType: 'json',
            success: function(response) {
                bindGridDetail(response.data)
            }
        })
    }

	function bindGridHeader(data) {
		var dataGridInstance = jQuery("#gridContainerHeader").dxDataGrid({
			allowColumnResizing: true,
			dataSource: data,
			keyExpr: "NoTransaksi",
			showBorders: true,
            allowColumnReordering: true,
            allowColumnResizing: true,
            columnAutoWidth: true,
            showBorders: true,
            paging: {
                enabled: true,
                pageSize: 30
            },
            editing: {
                mode: "row",
                // allowAdding:true,
                // allowUpdating: true,
                // allowDeleting: true,
                texts: {
                    confirmDeleteMessage: ''  
                }
            },
            searchPanel: {
	            visible: true,
	            width: 240,
	            placeholder: "Search..."
	        },
            selection: {
                mode: "single" // Enable single selection mode
            },
            columns: [
                {
                    dataField: "NoTransaksi",
                    caption: "Nomor Retur",
                    allowEditing:false
                },
                {
                    dataField: "StatusDocument",
                    caption: "Status",
                    allowEditing:false
                },
                {
                    dataField: "TglTransaksi",
                    caption: "Tanggal Retur",
                    allowEditing:false
                },
                {
                    dataField: "NoFaktur",
                    caption: "Nomor Faktur",
                    allowEditing:false
                },
                {
                    dataField: "NamaSupplier",
                    caption: "Supplier",
                    allowEditing:false
                },
                {
                    dataField: "TotalTransaksi",
                    caption: "Total",
                    allowEditing:false,
                    format: { type: 'fixedPoint', precision: 2 }
                },
                {
                    dataField: "Posted",
                    caption: "Posted",
                    allowEditing:false,
                    visible:false
                },
                {
                    caption: "Action",
                    fixed: true,
                    cellTemplate: function(cellElement, cellInfo) {
                        var link = "returpembelian/form/"+cellInfo.data.NoTransaksi;
                        var LinkAccess = "";

                        LinkAccess = "<a href = "+link+" class='btn btn-outline-primary font-weight-bold me-1 mb-1' id = 'btEdit' >Edit</a>";
                        LinkAccess += "<button class='btn btn-outline-success font-weight-bold me-1 mb-1' onclick=\"showCetakModal('" + cellInfo.data.NoTransaksi + "')\">Cetak</button>";

                        cellElement.append(LinkAccess);
                    }
                },
            ],
            onRowClick: function(e) {
                const rowElement = e.component.getRowElement(e.rowIndex);
                rowElement.addClass('row-highlight');
                // console.log('Row entered:', e.data);
                GetDetail(e.data.NoTransaksi)
            }
		}).dxDataGrid('instance');


	}

	function bindGridDetail(data) {
		var dataGridInstance = jQuery("#gridContainerDetail").dxDataGrid({
			allowColumnResizing: true,
			dataSource: data,
			keyExpr: "NoUrut",
			showBorders: true,
            allowColumnReordering: true,
            allowColumnResizing: true,
            columnAutoWidth: true,
            showBorders: true,
            paging: {
                enabled: true,
                pageSize: 30
            },
            editing: {
                mode: "row",
                texts: {
                    confirmDeleteMessage: ''  
                }
            },
            columns: [
                {
                    dataField: "NoUrut",
                    caption: "#",
                    allowEditing:false
                },
                {
                    dataField: "KodeItem",
                    caption: "Item",
                    allowEditing:false
                },
                {
                    dataField: "NamaItem",
                    caption: "Nama Item",
                    allowEditing:false
                },
                {
                    dataField: "QtyFaktur",
                    caption: "Qty Faktur",
                    allowEditing:false,
                    format: { type: 'fixedPoint', precision: 2 }
                },
                {
                    dataField: "Qty",
                    caption: "Qty Retur",
                    allowEditing:false,
                    format: { type: 'fixedPoint', precision: 2 }
                },
                {
                    dataField: "Harga",
                    caption: "Harga",
                    allowEditing:false,
                    format: { type: 'fixedPoint', precision: 2 }
                },
                {
                    dataField: "HargaNet",
                    caption: "Total Retur",
                    allowEditing:false,
                    format: { type: 'fixedPoint', precision: 2 }
                },
            ]
		});
	}
</script>
@endpush