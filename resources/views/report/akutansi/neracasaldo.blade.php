@extends('parts.header')
	
@section('content')

<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">Neraca Saldo</li>
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
									<h3 class="card-label mb-0 font-weight-bold text-body">Neraca Saldo 
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
                                <form action="{{ route('report-neracasaldo') }}">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label  class="text-body">Bulan</label>
                                            <select name="Bulan" id="Bulan" class="js-example-basic-single js-states form-control bg-transparent" >
                                                <option value="">Pilih Bulan</option>
                                                <option value="01" {{ $OldBulan == '01' ? 'selected' : '' }}> Januari </option>
                                                <option value="02" {{ $OldBulan == '02' ? 'selected' : '' }}> Februari </option>
                                                <option value="03" {{ $OldBulan == '03' ? 'selected' : '' }}> Maret </option>
                                                <option value="04" {{ $OldBulan == '04' ? 'selected' : '' }}> April </option>
                                                <option value="05" {{ $OldBulan == '05' ? 'selected' : '' }}> Mei </option>
                                                <option value="06" {{ $OldBulan == '06' ? 'selected' : '' }}> Juni </option>
                                                <option value="07" {{ $OldBulan == '07' ? 'selected' : '' }}> Juli </option>
                                                <option value="08" {{ $OldBulan == '8' ? 'selected' : '' }}> Agustus </option>
                                                <option value="09" {{ $OldBulan == '09' ? 'selected' : '' }}> September </option>
                                                <option value="10" {{ $OldBulan == '10' ? 'selected' : '' }}> Oktober </option>
                                                <option value="11" {{ $OldBulan == '11' ? 'selected' : '' }}> November </option>
                                                <option value="12" {{ $OldBulan == '12' ? 'selected' : '' }}> Desember </option>
                                                
                                            </select>
                                        </div>

                                        <div class="col-md-3">
                                            <label  class="text-body">Tahun</label>
                                            <select name="Tahun" id="Tahun" class="js-example-basic-single js-states form-control bg-transparent" >
                                                <option value="">Pilih Tahun</option>
                                                @foreach($year as $ko)
                                                    <option value="{{ $ko['Year'] }}" {{ $ko['Year'] == $OldTahun ? 'selected' : '' }}>
                                                        {{ $ko['Year'] }}
                                                    </option>
                                                @endforeach
                                                
                                            </select>
                                        </div>

                                        <div class="col-md-3">
                                            <label  class="text-body">Level</label>
                                            <select name="Level" id="Level" class="js-example-basic-single js-states form-control bg-transparent" >
                                                <option value="1" {{ $OldLevel == 1 ? 'selected' : '' }}> 1 </option>
                                                <option value="2" {{ $OldLevel == 2 ? 'selected' : '' }}> 2 </option>
                                                <option value="3" {{ $OldLevel == 3 ? 'selected' : '' }}> 3 </option>
                                                <option value="4" {{ $OldLevel == 4 ? 'selected' : '' }}> 4 </option>
                                                <option value="5" {{ $OldLevel == 5 ? 'selected' : '' }}> 5 </option>
                                                
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
        var oData = <?php echo json_encode($neracasaldo) ?>;
        bindGridSaldoStock(oData);
	});

    function bindGridSaldoStock(data) {

		var dataGridInstance = jQuery("#gridContainer").dxDataGrid({
			allowColumnResizing: true,
			dataSource: data,
			keyExpr: "KodeRekening",
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
                    dataField: "NamaKelompok",
                    caption: "Kelompok",
                    allowEditing:false,
                    allowExporting: true,
                    groupIndex:0
                },
                {
                    dataField: "NamaRekening",
                    caption: "Nama Rekening",
                    allowEditing:false,
                    allowExporting: true,
                },
                {
                    dataField: "Posisi",
                    caption: "Posisi",
                    allowEditing:false,
                    allowExporting: true,
                    visible:false
                },
                {
                    dataField: "SaldoAwal",
                    caption: "Saldo Awal",
                    allowEditing:false,
                    allowExporting: true,
                    format: { type: 'fixedPoint', precision: 2 },
                },
                {
                    dataField: "MutasiDebet",
                    caption: "Debit",
                    allowEditing:false,
                    allowExporting: true,
                    format: { type: 'fixedPoint', precision: 2 },
                },
                {
                    dataField: "MutasiKredit",
                    caption: "Kredit",
                    allowEditing:false,
                    allowExporting: true,
                    format: { type: 'fixedPoint', precision: 2 },
                },
                {
                    dataField: "SaldoAkhir",
                    caption: "Saldo Akhir",
                    allowEditing:false,
                    allowExporting: true,
                    format: { type: 'fixedPoint', precision: 2 },
                    calculateCellValue:function (rowData) {
                        if (rowData.Posisi == 1) {
                            return rowData.SaldoAwal + rowData.MutasiDebet - rowData.MutasiKredit
                        }
                        else{
                            return rowData.SaldoAwal - rowData.MutasiDebet + rowData.MutasiKredit
                        }
                    },
                },
            ],
            summary: {
                groupItems: [
                    { 
                        column: "SaldoAwal", 
                        summaryType: "sum" ,
                        alignByColumn: true, 
                        showInGroupFooter: false,
                        displayFormat: "{0}",
                        valueFormat: {
                            type: "fixedPoint",
                            precision: 2
                        }
                    },
                    { 
                        column: "MutasiDebet", 
                        summaryType: "sum" ,
                        alignByColumn: true, 
                        showInGroupFooter: false,
                        displayFormat: "{0}",
                        valueFormat: {
                            type: "fixedPoint",
                            precision: 2
                        }
                    },
                    { 
                        column: "MutasiKredit", 
                        summaryType: "sum" ,
                        alignByColumn: true, 
                        showInGroupFooter: false,
                        displayFormat: "{0}",
                        valueFormat: {
                            type: "fixedPoint",
                            precision: 2
                        }
                    },
                    { 
                        column: "SaldoAkhir", 
                        summaryType: "sum" ,
                        alignByColumn: true, 
                        showInGroupFooter: false,
                        displayFormat: "{0}",
                        valueFormat: {
                            type: "fixedPoint",
                            precision: 2
                        }
                    },
                ],
                totalItems: [
                    {
                        column: "SaldoAwal",
                        summaryType: "sum",
                        displayFormat: "{0}",
                        valueFormat: {
                            type: "fixedPoint",
                            precision: 2
                        }
                    },
                    {
                        column: "MutasiDebet",
                        summaryType: "sum",
                        displayFormat: "{0}",
                        valueFormat: {
                            type: "fixedPoint",
                            precision: 2
                        }
                    },
                    {
                        column: "MutasiKredit",
                        summaryType: "sum",
                        displayFormat: "{0}",
                        valueFormat: {
                            type: "fixedPoint",
                            precision: 2
                        }
                    },
                    {
                        column: "SaldoAkhir",
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
                        const worksheet = workbook.addWorksheet('Neraca Saldo');

                        DevExpress.excelExporter.exportDataGrid({
                            component: e.component,
                            worksheet,
                            autoFilterEnabled: true,
                        }).then(() => {
                            workbook.xlsx.writeBuffer().then((buffer) => {
                            saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'Laporan Neraca Saldo.xlsx');
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
                            const header = 'Laporan Neraca Saldo';
                            const pageWidth = doc.internal.pageSize.getWidth();
                            const headerWidth = doc.getTextDimensions(header).w;

                            doc.setFontSize(15);
                            doc.text(header, (pageWidth - headerWidth) / 2, 20);
                            doc.save('Laporan Neraca Saldo.pdf');
                        });
                        break;
                }
            },
		}).dxDataGrid('instance');


	}
    
</script>
@endpush