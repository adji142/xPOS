@extends('parts.header')
	
@section('content')

<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">Pengakuan Stock Barang</li>
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
									<h3 class="card-label mb-0 font-weight-bold text-body">Pengakuan Stock Barang 
									</h3>
								</div>
							    <div class="icons d-flex">
									<a href="{{ url('gr/form/-') }}" class="btn btn-outline-primary rounded-pill font-weight-bold me-1 mb-1">Tambah Data</a>
								
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

    function GetHeader() {
        $.ajax({
            async:false,
            type: 'post',
            url: "{{route('gr-readheader')}}",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
            },
            data: {
                'TglAwal' : jQuery('#TglAwal').val(),
                'TglAkhir' : jQuery('#TglAkhir').val(),
                'Status' : ''
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
            url: "{{route('gr-readdetail')}}",
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
                    dataField: "Status",
                    caption: "Status",
                    allowEditing:false
                },
                {
                    dataField: "TglTransaksi",
                    caption: "Tanggal Retur",
                    allowEditing:false
                },
                {
                    dataField: "NoReff",
                    caption: "NoReff",
                    allowEditing:false
                },
                {
                    dataField: "Keterangan",
                    caption: "Keterangan",
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
                        var link = "gr/form/"+cellInfo.data.NoTransaksi;
                        var LinkAccess = "";

                        LinkAccess = "<a href = "+link+" class='btn btn-outline-primary font-weight-bold me-1 mb-1' id = 'btEdit' >Edit</a>";

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
                    dataField: "Qty",
                    caption: "Qty Faktur",
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
                    dataField: "TotalTransaksi",
                    caption: "Total Retur",
                    allowEditing:false,
                    format: { type: 'fixedPoint', precision: 2 }
                },
            ]
		});
	}
</script>
@endpush