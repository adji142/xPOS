@extends('parts.header')
	
@section('content')

<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">Pembayaran Pembelian 2</li>
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
									<h3 class="card-label mb-0 font-weight-bold text-body">Pembayaran Pembelian 
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
                                <form action="{{ route('report-pembayaranpembelian') }}">
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
                                            <button type="submit" class="btn btn-outline-primary rounded-pill font-weight-bold me-1 mb-1">Cari Data</button>
                                        </div>
                                    </div>
                                </form>
							</div>
						</div>
					</div>
					<div class="col-12  px-4">
						<div class="card card-custom gutter-b bg-white border-0" >
							<div class="card-body" >
								<div class="dx-viewport demo-container">
				                	<div id="data-grid-demo">
				                  		<div id="gridContainer"></div>
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
    window.jsPDF = window.jspdf.jsPDF;

	jQuery(document).ready(function() {
		var now = new Date();
    	var day = ("0" + now.getDate()).slice(-2);
    	var month = ("0" + (now.getMonth() + 1)).slice(-2);
    	var firstDay = now.getFullYear()+"-"+month+"-01";
    	var NowDay = now.getFullYear()+"-"+month+"-"+day;

    	jQuery('#TglAwal').val(firstDay);
    	jQuery('#TglAkhir').val(NowDay);


        var oData = <?php echo json_encode($pembelian) ?>;
        bindGridRekap(oData)
	});

	function bindGridRekap(data) {
        var oData = data.filter((value, index, self) =>
            index === self.findIndex((t) => (
                t.NoTransaksi === value.NoTransaksi
            ))
        );

		var dataGridInstance = jQuery("#gridContainer").dxDataGrid({
			allowColumnResizing: true,
			dataSource: oData,
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
            export: {
                enabled: true,
                formats: ['pdf','xlsx'],
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
                    dataField: "NamaMetodePembayaran",
                    caption: "Metode Pembayaran",
                    allowEditing:false,
                    allowExporting: true,
                    groupIndex:0
                },
                {
                    dataField: "NoTransaksi",
                    caption: "Nomor",
                    allowEditing:false,
                    allowExporting: true
                },
                {
                    dataField: "TglTransaksi",
                    caption: "Transaksi",
                    allowEditing:false,
                    allowExporting: true
                },
                {
                    dataField: "NamaSupplier",
                    caption: "Pelanggan",
                    allowEditing:false,
                    allowExporting: true
                },
                {
                    dataField: "NoReff",
                    caption: "Reffrensi",
                    allowEditing:false,
                    allowExporting: true
                },
                {
                    dataField: "BaseReff",
                    caption: "No. Penjualan",
                    allowEditing:false,
                    allowExporting: true
                },
                {
                    dataField: "CreatedBy",
                    caption: "User",
                    allowEditing:false,
                    allowExporting: true
                },
                {
                    dataField: "TotalPembayaran",
                    caption: "Total",
                    allowEditing:false,
                    format: { type: 'fixedPoint', precision: 2 },
                    allowExporting: true
                }
            ],
            summary: {
                groupItems: [
                    { 
                        column: "TotalPembayaran", 
                        summaryType: "sum" ,
                        alignByColumn: true, 
                        showInGroupFooter: true,
                        displayFormat: "{0}",
                        valueFormat: {
                            type: "fixedPoint",
                            precision: 2
                        }
                    }
                ],
                totalItems: [
                    {
                        column: "TotalPembayaran",
                        summaryType: "sum",
                        displayFormat: "{0}",
                        valueFormat: {
                            type: "fixedPoint",
                            precision: 2
                        }
                    },
                ]
            },
            onRowClick: function(e) {
                const rowElement = e.component.getRowElement(e.rowIndex);
                rowElement.addClass('row-highlight');
                // console.log('Row entered:', e.data);
                GetDetail(e.data.NoTransaksi)
            },
            onExporting(e) {

                switch (e.format) {
                    case "xlsx":
                        const workbook = new ExcelJS.Workbook();
                        const worksheet = workbook.addWorksheet('Employees');

                        DevExpress.excelExporter.exportDataGrid({
                            component: e.component,
                            worksheet,
                            autoFilterEnabled: true,
                        }).then(() => {
                            workbook.xlsx.writeBuffer().then((buffer) => {
                            saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'Laporan Pembayaran Pembelian.xlsx');
                            });
                        });
                        break;
                    case "pdf":
                        const doc = new jsPDF({
                            orientation: 'landscape',
                            unit: 'pt',
                            format: [1000, 612],
                        });

                        DevExpress.pdfExporter.exportDataGrid({
                            jsPDFDocument: doc,
                            component: e.component,
                        }).then(() => {
                            // header
                            var TglAwal = jQuery("#TglAwal").val().split("-");
                            var TglAkhir = jQuery("#TglAkhir").val().split("-");
                            const header = 'Laporan Rekap Pembayaran Pembelian Periode ' + TglAwal[2]+"/"+TglAwal[1]+"/"+TglAwal[0] + " s/d " + TglAkhir[2]+"/"+TglAkhir[1]+"/"+TglAkhir[0];
                            const pageWidth = doc.internal.pageSize.getWidth();
                            const headerWidth = doc.getTextDimensions(header).w;

                            doc.setFontSize(15);
                            doc.text(header, (pageWidth - headerWidth) / 2, 20);
                            doc.save('Laporan Rekap Pembayaran Pembelian.pdf');
                        });
                        break;
                }
            },
		}).dxDataGrid('instance');


	}
</script>
@endpush