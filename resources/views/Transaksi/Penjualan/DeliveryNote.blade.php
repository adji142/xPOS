@extends('parts.header')
	
@section('content')
<style type="text/css">
    .disabled-link {
        pointer-events: none; /* Disables click events */
        color: gray; /* Changes the color to indicate the link is disabled */
        text-decoration: none; /* Optional: Remove underline */
        cursor: default; /* Changes the cursor to indicate it's not clickable */
    }
</style>
<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">Surat Jalan</li>
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
									<h3 class="card-label mb-0 font-weight-bold text-body">Surat Jalan 
									</h3>
								</div>
							    <div class="icons d-flex">
									<a href="{{ url('delivery/form/-') }}" class="btn btn-outline-primary rounded-pill font-weight-bold me-1 mb-1">Tambah Data</a>
								
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
										<!-- <?php echo json_encode($pelanggan); ?> -->
										<label  class="text-body">Pelanggan</label>
										<select name="KodePelanggan" id="KodePelanggan" class="js-example-basic-single js-states form-control bg-transparent" >
											<option value="">Pilih Pelanggan</option>
											@foreach($pelanggan as $ko)
												<option value="{{ $ko->KodePelanggan }}" >
		                                            {{ $ko->NamaPelanggan }}
		                                        </option>
											@endforeach
											
										</select>
									</div>
									<div class="col-md-3">
										<br>
										<button class="btn btn-outline-primary rounded-pill font-weight-bold me-1 mb-1" id="btSearch">Cari Data</button>
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


<div class="modal fade text-left w-100" id="modalStatusPengiriman" tabindex="-1" role="dialog" aria-labelledby="myModalLabel16" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel16">Update Delivery Status</h4>
          <button type="button" class="close rounded-pill btn btn-sm btn-icon btn-primary m-0" data-bs-dismiss="modal" aria-label="Close">
            <svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-x" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
            </svg>  
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <input type="hidden" name="ModalNoTransaksi" id="ModalNoTransaksi">
                <label for="exampleInputEmail1">Status Pengiriman</label>
                <select name="ModalDeliveryStatus" id="ModalDeliveryStatus" class="js-states form-control bg-transparent" >
                    <option value="Dokumen Dibuat">Dokumen Dibuat</option>
                    <option value="Barang Diserahkan Kurir">Barang Diserahkan Kurir</option>
                    <option value="Barang Dalam Perjalanan">Barang Dalam Perjalanan</option>
                    <option value="Barang Sampai Tujuan">Barang Sampai Tujuan</option>
                    <option value="Barang Diterima">Barang Diterima</option>
                </select>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Keterangan</label>
                <input type="text" name="ModalKeteranganPengiriman" class="form-control" id="ModalKeteranganPengiriman">
                <small>Informasi Seperti Resi dan keterangan lain bisa dimasukan pada kolomini</small>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary ms-1" id="btSimpanDeliveryStatus" data-bs-dismiss="modal">
                <span class="">Simpan</span>
            </button>
        </div>      
      </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
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

    jQuery('#btSearch').click(function () {
        GetHeader();
    });

    jQuery('#btSimpanDeliveryStatus').click(function () {
        jQuery('#btSimpanDeliveryStatus').text('Tunggu Sebentar ....');
        jQuery('#btSimpanDeliveryStatus').attr('disabled',true);

        $.ajax({
            async:false,
            type: 'post',
            url: "{{route('delivery-editdeliverystatus')}}",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
            },
            data: {
                'NoTransaksi' : jQuery('#ModalNoTransaksi').val(),
                'DeliveryStatus' : jQuery('#ModalDeliveryStatus').val(),
                'KeteranganPengiriman' :jQuery('#ModalKeteranganPengiriman').val()
            },
            dataType: 'json',
            success: function(response) {
                if (response.success == true) {
                    Swal.fire({
                        html: "Data berhasil disimpan!",
                        icon: "success",
                        title: "Horray...",
                        // text: "Data berhasil disimpan! <br> " + response.Kembalian,
                    }).then((result)=>{
                        jQuery('#btSimpanDeliveryStatus').text('Save');
                        jQuery('#btSimpanDeliveryStatus').attr('disabled',false);
                        // location.reload();
                        window.location.href = '{{url("delivery")}}';
                    });
                }
                else{
                    Swal.fire({
                      icon: "error",
                      title: "Opps...",
                      text: response.message,
                    })
                    jQuery('#btSimpanDeliveryStatus').text('Save');
                    jQuery('#btSimpanDeliveryStatus').attr('disabled',false);
                }
            }
        })
    })

    function GetHeader() {
        $.ajax({
            async:false,
            type: 'post',
            url: "{{route('delivery-readheader')}}",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
            },
            data: {
                'TglAwal' : jQuery('#TglAwal').val(),
                'TglAkhir' : jQuery('#TglAkhir').val(),
                'KodePelanggan' :jQuery('#KodePelanggan').val()
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
            url: "{{route('delivery-readdetail')}}",
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
                pageSize: 10
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
                    caption: "Nomor",
                    allowEditing:false
                },
                {
                    dataField: "Transaksi",
                    caption: "Sumber Data",
                    allowEditing:false
                },
                {
                    dataField: "StatusDocument",
                    caption: "Status",
                    allowEditing:false
                },
                {
                    dataField: "DeliveryStatus",
                    caption: "Status Pengiriman",
                    allowEditing:false
                },
                {
                    dataField: "TglTransaksi",
                    caption: "Tanggal",
                    allowEditing:false
                },
                {
                    dataField: "NamaPelanggan",
                    caption: "Pelanggan",
                    allowEditing:false
                },
                {
                    dataField: "TotalPembelian",
                    caption: "Total",
                    allowEditing:false,
                    format: { type: 'fixedPoint', precision: 2 }
                },
                {
                    caption: "Action",
                    fixed: true,
                    cellTemplate: function(cellElement, cellInfo) {
                        var link = "delivery/form/"+cellInfo.data.NoTransaksi;
                        var LinkAccess = "";
                        if (cellInfo.data.Transaksi == 'POS') {
                            LinkAccess = "<a href = "+link+" class='btn btn-outline-primary font-weight-bold me-1 mb-1 disabled-link' id = 'btEdit' disabled>Edit</a>";
                        }else{
                            LinkAccess = "<a href = "+link+" class='btn btn-outline-primary font-weight-bold me-1 mb-1' id = 'btEdit' disabled>Edit</a>";
                        }

                        var NoTransaksi = "'"+cellInfo.data.NoTransaksi+"'";
                        var Status = cellInfo.data.StatusDocument;

                        if (Status !=  "OPEN") {
                            LinkAccess += '<button class="btn btn-outline-danger font-weight-bold me-1 mb-1" disabled onClick="EditStatusDelivery('+NoTransaksi+')" >Edit Status Pengiriman</button>';
                        }else{
                            LinkAccess += '<button class="btn btn-outline-danger font-weight-bold me-1 mb-1" onClick="EditStatusDelivery('+NoTransaksi+')" >Edit Status Pengiriman</button>';
                        }

                        // LinkAccess += "<a href = '#' class='btn btn-outline-danger font-weight-bold me-1 mb-1' id = 'btBayar' >Bayar</a>";

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
                    allowEditing:false,
                    visible: false
                },
                {
                    caption: "#",
                    allowEditing:false,
                    cellTemplate: function(container, options) {
                        var index = options.rowIndex + 1; // Menghitung nomor urut (dimulai dari 1)
                        $("<div>").text(index).appendTo(container);
                    }
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
                    dataField: "Qty",
                    caption: "Qty",
                    allowEditing:false,
                    format: { type: 'fixedPoint', precision: 2 }
                },
                {
                    dataField: "QtyRetur",
                    caption: "Retur",
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
                    dataField: "Discount",
                    caption: "Discount",
                    allowEditing:false,
                    format: { type: 'fixedPoint', precision: 2 }
                },
                {
                    dataField: "HargaNet",
                    caption: "Harga Net",
                    allowEditing:false,
                    format: { type: 'fixedPoint', precision: 2 }
                },
            ]
		});
	}

    function EditStatusDelivery(NoTransaksi) {
        jQuery('#modalStatusPengiriman').modal({backdrop: 'static', keyboard: false})
        jQuery('#modalStatusPengiriman').modal('show');

        jQuery('#ModalNoTransaksi').val(NoTransaksi);
    }
</script>
@endpush