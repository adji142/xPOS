@extends('parts.header')
	
@section('content')

<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">Saldo Stock</li>
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
									<h3 class="card-label mb-0 font-weight-bold text-body">Saldo Stock 
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
                                <form action="{{ route('report-saldostock') }}">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label  class="text-body">Gudang</label>
                                            <select name="KodeGudang" id="KodeGudang" class="js-example-basic-single js-states form-control bg-transparent" >
                                                <option value="">Pilih Gudang</option>
                                                @foreach($gudang as $ko)
                                                    <option value="{{ $ko->KodeGudang }}" {{ $ko->KodeGudang == $oldKodeGudang ? 'selected' : '' }}>
                                                        {{ $ko->NamaGudang }}
                                                    </option>
                                                @endforeach
                                                
                                            </select>
                                        </div>

                                        <div class="col-md-3">
                                            <label  class="text-body">Tampilkan Saldo (0)</label>
                                            <select name="ShowZero" id="ShowZero" class="js-example-basic-single js-states form-control bg-transparent" >
                                                <option value="1" {{$oldShowZero == "1" ? 'selected' : '' }}>Tampilkan</option>
                                                <option value="0" {{$oldShowZero == "0" ? 'selected' : '' }}>Sembunyikan</option>
                                                
                                            </select>
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
        var oData = <?php echo json_encode($sakdostock) ?>;
        bindGridSaldoStock(oData)
	});

    function bindGridSaldoStock(data) {

		var dataGridInstance = jQuery("#gridContainer").dxDataGrid({
			allowColumnResizing: true,
			dataSource: data,
			keyExpr: "KodeItem",
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
                    dataField: "NamaGudang",
                    caption: "Gudang",
                    allowEditing:false,
                    allowExporting: true,
                    groupIndex:0
                },
                {
                    dataField: "KodeItem",
                    caption: "Kode Item",
                    allowEditing:false,
                    allowExporting: true,
                },
                {
                    dataField: "NamaItem",
                    caption: "Nama Item",
                    allowEditing:false,
                    allowExporting: true
                },
                {
                    dataField: "NamaJenis",
                    caption: "Jenis Item",
                    allowEditing:false,
                    allowExporting: true
                },
                {
                    dataField: "Qty",
                    caption: "Saldo",
                    allowEditing:false,
                    allowExporting: true,
                    format: { type: 'fixedPoint', precision: 2 },
                },
                {
                    dataField: "HargaBeliTerakhir",
                    caption: "Harga Beli Terakhir",
                    allowEditing:false,
                    format: { type: 'fixedPoint', precision: 2 },
                    allowExporting: true
                },
                {
                    dataField: "HargaPokokPenjualan",
                    caption: "HPP",
                    allowEditing:false,
                    format: { type: 'fixedPoint', precision: 2 },
                    allowExporting: true
                },
                {
                    dataField: "NamaSatuan",
                    caption: "Satuan",
                    allowEditing:false,
                    allowExporting: true
                },
            ],
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
                        const worksheet = workbook.addWorksheet('Saldo Stock');

                        DevExpress.excelExporter.exportDataGrid({
                            component: e.component,
                            worksheet,
                            autoFilterEnabled: true,
                        }).then(() => {
                            workbook.xlsx.writeBuffer().then((buffer) => {
                            saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'Laporan Saldo Stock.xlsx');
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
                            const header = 'Laporan Saldo Stock';
                            const pageWidth = doc.internal.pageSize.getWidth();
                            const headerWidth = doc.getTextDimensions(header).w;

                            doc.setFontSize(15);
                            doc.text(header, (pageWidth - headerWidth) / 2, 20);
                            doc.save('Laporan Saldo Stock.pdf');
                        });
                        break;
                }
            },
		}).dxDataGrid('instance');


	}
    
</script>
@endpush