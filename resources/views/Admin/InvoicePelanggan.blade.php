@extends('partadmin.headeradmin')
	
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
				<li class="breadcrumb-item active" aria-current="page">Tagihan Pelanggan</li>
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
									<h3 class="card-label mb-0 font-weight-bold text-body">Tagihan Pelanggan 
									</h3>
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
						</div>
					</div>
				</div>
			</div>
			
		</div>
	</div>
	
</div>

<div class="modal fade text-left" id="LookupBayarTagihan" tabindex="-1" role="dialog" aria-labelledby="LookupBuatTagihan" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h3 class="modal-title" id="myModalLabel1444">Tagihan Pelanggan</h3>
			<button type="button" class="close rounded-pill btn btn-sm btn-icon btn-light btn-hover-primary m-0" data-bs-dismiss="modal" aria-label="Close">
			  <svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-x" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
				  <path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
			  </svg>
			</button>
		  </div>
		  <div class="modal-body">
			<div class="col-md-12">
                <form action="{{route('invpengguna-bayar')}}" method="post">
                    @csrf
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label  class="text-body">No Invoice</label>
                            <fieldset class="form-group mb-3">
                                <input readonly type="text" class="form-control" id="ModalNoInv" name="BaseReff" placeholder="Masukan Refrensi">
                            </fieldset>
                        </div>
    
                        <div class="col-md-4">
                            <label  class="text-body">Total Bayar</label>
                            <fieldset class="form-group mb-3">
                                <input type="number" class="form-control" id="ModalBayar" name="TotalBayar" placeholder="Masukan Harga">
                            </fieldset>
                        </div>
                        <div class="col-md-4">
                            <label  class="text-body">Metode Pembayaran</label>
                            <fieldset class="form-group mb-3">
                                <select name="MetodePembayaran" id="ModalMetodePembayaran" class="js-example-basic-single js-states form-control bg-transparent" required="">
                                    <option value="">Pilih Metode Pembayaran</option>
                                    <option value="TRANSFER">TRANSFER</option>
                                    <option value="CASH">CASH</option>
                                </select>
                            </fieldset>
                        </div>
                        <div class="col-md-6">
                            <label  class="text-body">Tanggal Bayar</label>
                            <fieldset class="form-group mb-3">
                                <input type="date" class="form-control" id="ModalTglBayar" name="TglTransaksi" placeholder="Masukan Refrensi">
                            </fieldset>
                        </div>
                        <div class="col-md-6">
                            <label  class="text-body">No Reff</label>
                            <fieldset class="form-group mb-3">
                                <input type="text" class="form-control" id="ModalNoReff" name="NoReff" placeholder="Masukan Refrensi">
                            </fieldset>
                        </div>
                        <div class="col-md-12">
                            <label  class="text-body">Keterangan</label>
                            <fieldset class="form-group mb-3">
                                <input type="text" id="ModalCatatan" name="Keterangan" class="form-control">
                            </fieldset>
                        </div>
    
                        <div class="col-md-6">
                            <label  class="text-body">Mulai Berlanggnan</label>
                            <fieldset class="form-group mb-3">
                                <input readonly type="date" class="form-control" id="ModalStartSubs" name="ModalStartSubs" placeholder="Masukan Harga">
                            </fieldset>
                        </div>
    
                        <div class="col-md-6">
                            <label  class="text-body">Selesai Berlanggnan</label>
                            <fieldset class="form-group mb-3">
                                <input readonly type="date" class="form-control" id="ModalEndSubs" name="ModalEndSubs" placeholder="Masukan Harga">
                            </fieldset>
                        </div>
    
                    </div>
                    <hr>
                    <div class="form-group row justify-content-end mb-0">
                        <div class="col-md-6  text-end">
                            <button type="submit" class="btn btn-primary" id="btSaveTagihan">Simpan Data</button>
                        </div>
                    </div>
                </form>
			</div>
		  </div>
		</div>
	</div>	  	  
</div>

@endsection

@push('scripts')
<script type="text/javascript">
    let DeskripsiSubscriptionInstance;
    var oDataTagihan;
	jQuery(document).ready(function() {
		var now = new Date();
    	var day = ("0" + now.getDate()).slice(-2);
    	var month = ("0" + (now.getMonth() + 1)).slice(-2);
    	var firstDay = now.getFullYear()+"-"+month+"-01";
    	var NowDay = now.getFullYear()+"-"+month+"-"+day;

    	jQuery('#TglAwal').val(firstDay);
    	jQuery('#TglAkhir').val(NowDay);
        jQuery('#ModalTglBayar').val(NowDay);

        jQuery('.js-example-basic-single').select2({
            dropdownParent: $('#LookupBayarTagihan')
        });

		// bindGridHeader([]);
        GetHeader();
	});

    jQuery('#btSearch').click(function () {
        GetHeader();
    });

    function GetHeader() {
        $.ajax({
            async:false,
            type: 'post',
            url: "{{route('invpengguna-viewheader')}}",
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

	function bindGridHeader(data) {
        oDataTagihan = data;
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
                    dataField: "TglTransaksi",
                    caption: "Tanggal",
                    allowEditing:false
                },
                {
                    dataField: "TglJatuhTempo",
                    caption: "Jatuh Tempo",
                    allowEditing:false
                },
                {
                    dataField: "KodePartner",
                    caption: "Kode Partner",
                    allowEditing:false
                },
                {
                    dataField: "NamaPartner",
                    caption: "Nama Partner",
                    allowEditing:false
                },
                {
                    dataField: "NamaSubscription",
                    caption: "Paket Langganan",
                    allowEditing:false
                },
                {
                    dataField: "TotalTagihan",
                    caption: "Tagihan",
                    allowEditing:false,
                    format: { type: 'fixedPoint', precision: 2 }
                },
                {
                    dataField: "TotalBayar",
                    caption: "Dibayar",
                    allowEditing:false,
                    format: { type: 'fixedPoint', precision: 2 }
                },
                {
                    caption: "Action",
                    fixed: true,
                    freze: true,
                    cellTemplate: function(cellElement, cellInfo) {
                        var LinkAccess = "";
                        var NoTransaksi = "'"+cellInfo.data.NoTransaksi+"'";

                        if (cellInfo.data.TotalBayar < cellInfo.data.TotalTagihan) {
                            console.log("A");
                            LinkAccess += '<button class="btn btn-outline-danger font-weight-bold me-1 mb-1" onClick="BayarLanggnan('+NoTransaksi+')" >Bayar</button>';
                        }else{
                            console.log("b");
                            LinkAccess += '<button class="btn btn-outline-danger font-weight-bold me-1 mb-1" disabled onClick="BayarLanggnan('+NoTransaksi+')" >Bayar</button>';
                        }

                        // LinkAccess += "<a href = '#' class='btn btn-outline-danger font-weight-bold me-1 mb-1' id = 'btBayar' >Bayar</a>";

                        cellElement.append(LinkAccess);
                    }
                },
            ],
		}).dxDataGrid('instance');


	}
    function BayarLanggnan(NoTransaksi) {
        // alert(NoTransaksi);
        // console.log(oDataTagihan);
        const filterData = oDataTagihan.filter(comp => comp.NoTransaksi === NoTransaksi);

        jQuery('#ModalNoInv').val(filterData[0]['NoTransaksi']);
        jQuery('#ModalBayar').val(filterData[0]['TotalTagihan']);
        jQuery('#ModalStartSubs').val(filterData[0]['StartSubs']);
        jQuery('#ModalEndSubs').val(filterData[0]['EndSubs']);

        jQuery('#LookupBayarTagihan').modal({backdrop: 'static', keyboard: false})
		jQuery('#LookupBayarTagihan').modal('show');
    }
</script>
@endpush