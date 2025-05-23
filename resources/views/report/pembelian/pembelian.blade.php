@extends('parts.header')
	
@section('content')

<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">Pembelian</li>
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
									<h3 class="card-label mb-0 font-weight-bold text-body">Pembelian 
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
                                <form action="{{ route('report-pembelian') }}">
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
                                            <label  class="text-body">Supplier</label>
                                            <select name="Supplier" id="Supplier" class="js-example-basic-single js-states form-control bg-transparent" >
                                                <option value="">Pilih Supplier</option>
                                                @foreach($supplier as $ko)
                                                    <option value="{{ $ko->KodeSupplier }}" {{ $ko->KodeSupplier == $oldSupplier ? 'selected' : '' }}>
                                                        {{ $ko->NamaSupplier }}
                                                    </option>
                                                @endforeach
                                                
                                            </select>
                                        </div>

                                        <div class="col-md-3">
                                            <label  class="text-body">Status</label>
                                            <select name="StatusTransaksi" id="StatusTransaksi" class="js-example-basic-single js-states form-control bg-transparent" >
                                                <option value="" {{$oldStatus == "" ? 'selected' : '' }}>Pilih Status</option>
                                                <option value="O" {{$oldStatus == "O" ? 'selected' : '' }}>Open</option>
                                                <option value="C" {{$oldStatus == "C" ? 'selected' : '' }}>Close</option>
                                                <option value="D" {{$oldStatus == "D" ? 'selected' : '' }}>Cancel</option>
                                                <option value="T" {{$oldStatus == "T" ? 'selected' : '' }}>Draft</option>
                                                
                                            </select>
                                        </div>

                                        <div class="col-md-3">
                                            <label  class="text-body">Tipe Laporan</label>
                                            <select name="TipeLaporan" id="TipeLaporan" class="js-example-basic-single js-states form-control bg-transparent" >
                                                <option value="1" {{$oldTipeLaporan == "1" ? 'selected' : '' }}>Rekap Pembelian</option>
                                                <option value="2" {{$oldTipeLaporan == "2" ? 'selected' : '' }}>Detail Pembelian</option>
                                                <option value="3" {{$oldTipeLaporan == "3" ? 'selected' : '' }}>Pembelian Per Item</option>
                                                <option value="4" {{$oldTipeLaporan == "4" ? 'selected' : '' }}>Pembelian Per Supplier</option>
                                                
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
		var now = new Date();
    	var day = ("0" + now.getDate()).slice(-2);
    	var month = ("0" + (now.getMonth() + 1)).slice(-2);
    	var firstDay = now.getFullYear()+"-"+month+"-01";
    	var NowDay = now.getFullYear()+"-"+month+"-"+day;

    	jQuery('#TglAwal').val(firstDay);
    	jQuery('#TglAkhir').val(NowDay);


        var oData = <?php echo json_encode($pembelian) ?>;

        switch (jQuery('#TipeLaporan').val()) {
            case "1":
                bindGridRekap(oData)       
                break;
            case "2" :
                bindGridDetail(oData)
                break;
            case "3" :
                bindGridPerItem(oData)
                break;
            case "4" :
                bindGridPerSupplier(oData)
                break;
            default:
                break;
        }
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
                    dataField: "NoTransaksi",
                    caption: "Nomor",
                    allowEditing:false,
                    allowExporting: true
                },
                {
                    dataField: "NamaSupplier",
                    caption: "Supplier",
                    allowEditing:false,
                    allowExporting: true
                },
                {
                    dataField: "StatusDocument",
                    caption: "Status",
                    allowEditing:false,
                    allowExporting: true
                },
                {
                    dataField: "TglTransaksi",
                    caption: "Tanggal Transaksi",
                    allowEditing:false,
                    allowExporting: true
                },
                {
                    dataField: "TotalTransaksi",
                    caption: "Total Transaksi",
                    allowEditing:false,
                    format: { type: 'fixedPoint', precision: 2 },
                    allowExporting: true
                },
                {
                    dataField: "Potongan",
                    caption: "Diskon",
                    allowEditing:false,
                    format: { type: 'fixedPoint', precision: 2 },
                    allowExporting: true
                },
                {
                    dataField: "Pajak",
                    caption: "Tax",
                    allowEditing:false,
                    format: { type: 'fixedPoint', precision: 2 },
                    allowExporting: true
                },
                {
                    dataField: "TotalPembelian",
                    caption: "Net",
                    allowEditing:false,
                    format: { type: 'fixedPoint', precision: 2 },
                    allowExporting: true
                },
            ],
            summary: {
                totalItems: [
                    {
                        column: "TotalTransaksi",
                        summaryType: "sum",
                        displayFormat: "{0}",
                        valueFormat: {
                            type: "fixedPoint",
                            precision: 2
                        }
                    },
                    {
                        column: "Potongan",
                        summaryType: "sum",
                        displayFormat: "{0}",
                        valueFormat: {
                            type: "fixedPoint",
                            precision: 2
                        }
                    },
                    {
                        column: "Pajak",
                        summaryType: "sum",
                        displayFormat: "{0}",
                        valueFormat: {
                            type: "fixedPoint",
                            precision: 2
                        }
                    },
                    {
                        column: "TotalPembelian",
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
                            saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'Laporan Rekap Pembelian.xlsx');
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
                            const header = 'Laporan Rekap Pembelian Periode ' + TglAwal[2]+"/"+TglAwal[1]+"/"+TglAwal[0] + " s/d " + TglAkhir[2]+"/"+TglAkhir[1]+"/"+TglAkhir[0];
                            const pageWidth = doc.internal.pageSize.getWidth();
                            const headerWidth = doc.getTextDimensions(header).w;

                            doc.setFontSize(15);
                            doc.text(header, (pageWidth - headerWidth) / 2, 20);
                            doc.save('Laporan Rekap Pembelian.pdf');
                        });
                        break;
                }
            },
		}).dxDataGrid('instance');


	}


    function bindGridDetail(data) {

		var dataGridInstance = jQuery("#gridContainer").dxDataGrid({
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
                    dataField: "NoTransaksi",
                    caption: "Nomor",
                    allowEditing:false,
                    allowExporting: true,
                    groupIndex:0
                },
                {
                    dataField: "NamaSupplier",
                    caption: "Supplier",
                    allowEditing:false,
                    allowExporting: true,
                },
                {
                    dataField: "StatusDocument",
                    caption: "Status",
                    allowEditing:false,
                    allowExporting: true
                },
                {
                    dataField: "TglTransaksi",
                    caption: "Tanggal Transaksi",
                    allowEditing:false,
                    allowExporting: true
                },
                {
                    dataField: "NamaItem",
                    caption: "Item",
                    allowEditing:false,
                    allowExporting: true
                },
                {
                    dataField: "Qty",
                    caption: "Jumlah",
                    allowEditing:false,
                    format: { type: 'fixedPoint', precision: 2 },
                    allowExporting: true
                },
                {
                    dataField: "Harga",
                    caption: "Harga",
                    allowEditing:false,
                    format: { type: 'fixedPoint', precision: 2 },
                    allowExporting: true
                },
                {
                    dataField: "Discount",
                    caption: "Diskon",
                    allowEditing:false,
                    format: { type: 'fixedPoint', precision: 2 },
                    allowExporting: true
                },
                {
                    dataField: "VatPercent",
                    caption: "Tax",
                    allowEditing:false,
                    format: { type: 'fixedPoint', precision: 2 },
                    allowExporting: true,
                    calculateCellValue:function (rowData) {
                        var HargaNet = 0;
                        var HargaGross = 0;
                        var NilaiTax = 0;
                        if (rowData.Discount == 0) {
                            HargaNet = rowData.Qty * rowData.Harga;
                            HargaGross = rowData.Qty * rowData.Harga;
                        }
                        else{
                            // console.log("HargaGross = " + HargaGross)
                            HargaGross = rowData.Qty * rowData.Harga;

                            var diskon = HargaGross * rowData.Discount / 100
                            // console.log("Diskon = " + diskon)
                            HargaNet = HargaGross - diskon;
                        }
                        if (rowData.VatPercent > 0) {
                            NilaiTax = (rowData.VatPercent / 100) * HargaNet;
                        }

                        return NilaiTax
                    },
                },
                {
                    dataField: "HargaNet",
                    caption: "Net",
                    allowEditing:false,
                    format: { type: 'fixedPoint', precision: 2 },
                    allowExporting: true,
                    calculateCellValue:function (rowData) {
                        var HargaNet = 0;
                        var HargaGross = 0;
                        if (rowData.Discount == 0) {
                            HargaNet = rowData.Qty * rowData.Harga;
                            HargaGross = rowData.Qty * rowData.Harga;
                        }
                        else{
                            // console.log("HargaGross = " + HargaGross)
                            HargaGross = rowData.Qty * rowData.Harga;

                            var diskon = HargaGross * rowData.Discount / 100
                            // console.log("Diskon = " + diskon)
                            HargaNet = HargaGross - diskon;
                        }
                        if (rowData.VatPercent > 0) {
                            var NilaiTax = (100 + rowData.VatPercent) / 100;
                            
                            HargaNet = HargaNet * NilaiTax;
                        }

                        return HargaNet
                    },
                }
            ],
            summary: {
                groupItems: [
                    { 
                        column: "Qty", 
                        summaryType: "sum" ,
                        alignByColumn: true, 
                        showInGroupFooter: true,
                        displayFormat: "{0}",
                        valueFormat: {
                            type: "fixedPoint",
                            precision: 2
                        }
                    },
                    { 
                        column: "Discount", 
                        summaryType: "sum" ,
                        alignByColumn: true, 
                        showInGroupFooter: true,
                        displayFormat: "{0}",
                        valueFormat: {
                            type: "fixedPoint",
                            precision: 2
                        }
                    },
                    { 
                        column: "VatPercent", 
                        summaryType: "sum" ,
                        alignByColumn: true, 
                        showInGroupFooter: true,
                        displayFormat: "{0}",
                        valueFormat: {
                            type: "fixedPoint",
                            precision: 2
                        }
                    },
                    { 
                        column: "HargaNet", 
                        summaryType: "sum" ,
                        alignByColumn: true, 
                        showInGroupFooter: true,
                        displayFormat: "{0}",
                        valueFormat: {
                            type: "fixedPoint",
                            precision: 2
                        }
                    },
                ],
                totalItems: [
                    {
                        column: "TotalTransaksi",
                        summaryType: "sum",
                        displayFormat: "{0}",
                        valueFormat: {
                            type: "fixedPoint",
                            precision: 2
                        }
                    },
                    {
                        column: "Potongan",
                        summaryType: "sum",
                        displayFormat: "{0}",
                        valueFormat: {
                            type: "fixedPoint",
                            precision: 2
                        }
                    },
                    {
                        column: "Pajak",
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
                            saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'Laporan Detail Pembelian.xlsx');
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
                            const header = 'Laporan Rekap Pembelian Periode ' + TglAwal[2]+"/"+TglAwal[1]+"/"+TglAwal[0] + " s/d " + TglAkhir[2]+"/"+TglAkhir[1]+"/"+TglAkhir[0];
                            const pageWidth = doc.internal.pageSize.getWidth();
                            const headerWidth = doc.getTextDimensions(header).w;

                            doc.setFontSize(15);
                            doc.text(header, (pageWidth - headerWidth) / 2, 20);
                            doc.save('Laporan Detail Pembelian.pdf');
                        });
                        break;
                }
            },
		}).dxDataGrid('instance');


	}
    function bindGridPerItem(data) {

        var dataGridInstance = jQuery("#gridContainer").dxDataGrid({
            allowColumnResizing: true,
            dataSource: data,
            keyExpr: "NamaItem",
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
                    dataField: "NamaItem",
                    caption: "Item",
                    allowEditing:false,
                    allowExporting: true,
                    groupIndex:0
                },
                {
                    dataField: "NoTransaksi",
                    caption: "Nomor",
                    allowEditing:false,
                    allowExporting: true,
                },
                {
                    dataField: "NamaSupplier",
                    caption: "Supplier",
                    allowEditing:false,
                    allowExporting: true,
                },
                {
                    dataField: "StatusDocument",
                    caption: "Status",
                    allowEditing:false,
                    allowExporting: true
                },
                {
                    dataField: "TglTransaksi",
                    caption: "Tanggal Transaksi",
                    allowEditing:false,
                    allowExporting: true
                },
                {
                    dataField: "Qty",
                    caption: "Jumlah",
                    allowEditing:false,
                    format: { type: 'fixedPoint', precision: 2 },
                    allowExporting: true
                },
                {
                    dataField: "Harga",
                    caption: "Harga",
                    allowEditing:false,
                    format: { type: 'fixedPoint', precision: 2 },
                    allowExporting: true
                },
                {
                    dataField: "Discount",
                    caption: "Diskon",
                    allowEditing:false,
                    format: { type: 'fixedPoint', precision: 2 },
                    allowExporting: true
                },
                {
                    dataField: "VatPercent",
                    caption: "Tax",
                    allowEditing:false,
                    format: { type: 'fixedPoint', precision: 2 },
                    allowExporting: true,
                    calculateCellValue:function (rowData) {
                        var HargaNet = 0;
                        var HargaGross = 0;
                        var NilaiTax = 0;
                        if (rowData.Discount == 0) {
                            HargaNet = rowData.Qty * rowData.Harga;
                            HargaGross = rowData.Qty * rowData.Harga;
                        }
                        else{
                            // console.log("HargaGross = " + HargaGross)
                            HargaGross = rowData.Qty * rowData.Harga;

                            var diskon = HargaGross * rowData.Discount / 100
                            // console.log("Diskon = " + diskon)
                            HargaNet = HargaGross - diskon;
                        }
                        if (rowData.VatPercent > 0) {
                            NilaiTax = (rowData.VatPercent / 100) * HargaNet;
                        }

                        return NilaiTax
                    },
                },
                {
                    dataField: "HargaNet",
                    caption: "Net",
                    allowEditing:false,
                    format: { type: 'fixedPoint', precision: 2 },
                    allowExporting: true,
                    calculateCellValue:function (rowData) {
                        var HargaNet = 0;
                        var HargaGross = 0;
                        if (rowData.Discount == 0) {
                            HargaNet = rowData.Qty * rowData.Harga;
                            HargaGross = rowData.Qty * rowData.Harga;
                        }
                        else{
                            // console.log("HargaGross = " + HargaGross)
                            HargaGross = rowData.Qty * rowData.Harga;

                            var diskon = HargaGross * rowData.Discount / 100
                            // console.log("Diskon = " + diskon)
                            HargaNet = HargaGross - diskon;
                        }
                        if (rowData.VatPercent > 0) {
                            var NilaiTax = (100 + rowData.VatPercent) / 100;
                            
                            HargaNet = HargaNet * NilaiTax;
                        }

                        return HargaNet
                    },
                }
            ],
            summary: {
                groupItems: [
                    { 
                        column: "Qty", 
                        summaryType: "sum" ,
                        alignByColumn: true, 
                        showInGroupFooter: true,
                        displayFormat: "{0}",
                        valueFormat: {
                            type: "fixedPoint",
                            precision: 2
                        }
                    },
                    { 
                        column: "Discount", 
                        summaryType: "sum" ,
                        alignByColumn: true, 
                        showInGroupFooter: true,
                        displayFormat: "{0}",
                        valueFormat: {
                            type: "fixedPoint",
                            precision: 2
                        }
                    },
                    { 
                        column: "VatPercent", 
                        summaryType: "sum" ,
                        alignByColumn: true, 
                        showInGroupFooter: true,
                        displayFormat: "{0}",
                        valueFormat: {
                            type: "fixedPoint",
                            precision: 2
                        }
                    },
                    { 
                        column: "HargaNet", 
                        summaryType: "sum" ,
                        alignByColumn: true, 
                        showInGroupFooter: true,
                        displayFormat: "{0}",
                        valueFormat: {
                            type: "fixedPoint",
                            precision: 2
                        }
                    },
                ],
                totalItems: [
                    {
                        column: "TotalTransaksi",
                        summaryType: "sum",
                        displayFormat: "{0}",
                        valueFormat: {
                            type: "fixedPoint",
                            precision: 2
                        }
                    },
                    {
                        column: "Potongan",
                        summaryType: "sum",
                        displayFormat: "{0}",
                        valueFormat: {
                            type: "fixedPoint",
                            precision: 2
                        }
                    },
                    {
                        column: "Pajak",
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
                            saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'Laporan Pembelian Per Item.xlsx');
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
                            const header = 'Laporan Rekap Pembelian Periode ' + TglAwal[2]+"/"+TglAwal[1]+"/"+TglAwal[0] + " s/d " + TglAkhir[2]+"/"+TglAkhir[1]+"/"+TglAkhir[0];
                            const pageWidth = doc.internal.pageSize.getWidth();
                            const headerWidth = doc.getTextDimensions(header).w;

                            doc.setFontSize(15);
                            doc.text(header, (pageWidth - headerWidth) / 2, 20);
                            doc.save('Laporan Pembelian Per Item.pdf');
                        });
                        break;
                }
            },
        }).dxDataGrid('instance');


    }
    function bindGridPerSupplier(data) {

        var dataGridInstance = jQuery("#gridContainer").dxDataGrid({
            allowColumnResizing: true,
            dataSource: data,
            keyExpr: "ConcatSupplier",
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
                    dataField: "ConcatSupplier",
                    caption: "Supplier",
                    allowEditing:false,
                    allowExporting: true,
                    groupIndex:0
                },
                {
                    dataField: "NoTransaksi",
                    caption: "Nomor",
                    allowEditing:false,
                    allowExporting: true,
                },
                {
                    dataField: "StatusDocument",
                    caption: "Status",
                    allowEditing:false,
                    allowExporting: true
                },
                {
                    dataField: "TglTransaksi",
                    caption: "Tanggal Transaksi",
                    allowEditing:false,
                    allowExporting: true
                },
                {
                    dataField: "NamaItem",
                    caption: "Item",
                    allowEditing:false,
                    allowExporting: true,
                },
                {
                    dataField: "Qty",
                    caption: "Jumlah",
                    allowEditing:false,
                    format: { type: 'fixedPoint', precision: 2 },
                    allowExporting: true
                },
                {
                    dataField: "Harga",
                    caption: "Harga",
                    allowEditing:false,
                    format: { type: 'fixedPoint', precision: 2 },
                    allowExporting: true
                },
                {
                    dataField: "Discount",
                    caption: "Diskon",
                    allowEditing:false,
                    format: { type: 'fixedPoint', precision: 2 },
                    allowExporting: true
                },
                {
                    dataField: "VatPercent",
                    caption: "Tax",
                    allowEditing:false,
                    format: { type: 'fixedPoint', precision: 2 },
                    allowExporting: true,
                    calculateCellValue:function (rowData) {
                        var HargaNet = 0;
                        var HargaGross = 0;
                        var NilaiTax = 0;
                        if (rowData.Discount == 0) {
                            HargaNet = rowData.Qty * rowData.Harga;
                            HargaGross = rowData.Qty * rowData.Harga;
                        }
                        else{
                            // console.log("HargaGross = " + HargaGross)
                            HargaGross = rowData.Qty * rowData.Harga;

                            var diskon = HargaGross * rowData.Discount / 100
                            // console.log("Diskon = " + diskon)
                            HargaNet = HargaGross - diskon;
                        }
                        if (rowData.VatPercent > 0) {
                            NilaiTax = (rowData.VatPercent / 100) * HargaNet;
                        }

                        return NilaiTax
                    },
                },
                {
                    dataField: "HargaNet",
                    caption: "Net",
                    allowEditing:false,
                    format: { type: 'fixedPoint', precision: 2 },
                    allowExporting: true,
                    calculateCellValue:function (rowData) {
                        var HargaNet = 0;
                        var HargaGross = 0;
                        if (rowData.Discount == 0) {
                            HargaNet = rowData.Qty * rowData.Harga;
                            HargaGross = rowData.Qty * rowData.Harga;
                        }
                        else{
                            // console.log("HargaGross = " + HargaGross)
                            HargaGross = rowData.Qty * rowData.Harga;

                            var diskon = HargaGross * rowData.Discount / 100
                            // console.log("Diskon = " + diskon)
                            HargaNet = HargaGross - diskon;
                        }
                        if (rowData.VatPercent > 0) {
                            var NilaiTax = (100 + rowData.VatPercent) / 100;
                            
                            HargaNet = HargaNet * NilaiTax;
                        }

                        return HargaNet
                    },
                }
            ],
            summary: {
                groupItems: [
                    { 
                        column: "Qty", 
                        summaryType: "sum" ,
                        alignByColumn: true, 
                        showInGroupFooter: true,
                        displayFormat: "{0}",
                        valueFormat: {
                            type: "fixedPoint",
                            precision: 2
                        }
                    },
                    { 
                        column: "Discount", 
                        summaryType: "sum" ,
                        alignByColumn: true, 
                        showInGroupFooter: true,
                        displayFormat: "{0}",
                        valueFormat: {
                            type: "fixedPoint",
                            precision: 2
                        }
                    },
                    { 
                        column: "VatPercent", 
                        summaryType: "sum" ,
                        alignByColumn: true, 
                        showInGroupFooter: true,
                        displayFormat: "{0}",
                        valueFormat: {
                            type: "fixedPoint",
                            precision: 2
                        }
                    },
                    { 
                        column: "HargaNet", 
                        summaryType: "sum" ,
                        alignByColumn: true, 
                        showInGroupFooter: true,
                        displayFormat: "{0}",
                        valueFormat: {
                            type: "fixedPoint",
                            precision: 2
                        }
                    },
                ],
                totalItems: [
                    {
                        column: "TotalTransaksi",
                        summaryType: "sum",
                        displayFormat: "{0}",
                        valueFormat: {
                            type: "fixedPoint",
                            precision: 2
                        }
                    },
                    {
                        column: "Potongan",
                        summaryType: "sum",
                        displayFormat: "{0}",
                        valueFormat: {
                            type: "fixedPoint",
                            precision: 2
                        }
                    },
                    {
                        column: "Pajak",
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
                            saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'Laporan Pembelian Per Supplier.xlsx');
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
                            const header = 'Laporan Rekap Pembelian Periode ' + TglAwal[2]+"/"+TglAwal[1]+"/"+TglAwal[0] + " s/d " + TglAkhir[2]+"/"+TglAkhir[1]+"/"+TglAkhir[0];
                            const pageWidth = doc.internal.pageSize.getWidth();
                            const headerWidth = doc.getTextDimensions(header).w;

                            doc.setFontSize(15);
                            doc.text(header, (pageWidth - headerWidth) / 2, 20);
                            doc.save('Laporan Pembelian Per Supplier.pdf');
                        });
                        break;
                }
            },
        }).dxDataGrid('instance');


    }
</script>
@endpush