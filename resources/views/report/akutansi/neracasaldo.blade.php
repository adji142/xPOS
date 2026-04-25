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
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 px-4">

				<div class="row">
					<div class="col-lg-12 col-xl-12 px-4">
						<div class="card card-custom gutter-b bg-transparent shadow-none border-0">
							<div class="card-header align-items-center border-bottom-dark px-0">
								<div class="card-title mb-0">
									<h3 class="card-label mb-0 font-weight-bold text-body">Neraca Saldo</h3>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-12 px-4">
						<div class="card card-custom gutter-b bg-white border-0">
							<div class="card-header">Filter Data</div>
							<div class="card-body">
								<form action="{{ route('report-neracasaldo') }}" method="GET">
									<div class="row">
										<div class="col-md-3">
											<label class="text-body">Bulan</label>
											<select name="Bulan" id="Bulan" class="js-example-basic-single form-control bg-transparent">
												<option value="">Pilih Bulan</option>
												@foreach([
													'01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April',
													'05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus',
													'09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'
												] as $val => $label)
													<option value="{{ $val }}" {{ $OldBulan == $val ? 'selected' : '' }}>
														{{ $label }}
													</option>
												@endforeach
											</select>
										</div>

										<div class="col-md-3">
											<label class="text-body">Tahun</label>
											<select name="Tahun" id="Tahun" class="js-example-basic-single form-control bg-transparent">
												<option value="">Pilih Tahun</option>
												@foreach($year as $y)
													<option value="{{ $y['Year'] }}" {{ $y['Year'] == $OldTahun ? 'selected' : '' }}>
														{{ $y['Year'] }}
													</option>
												@endforeach
											</select>
										</div>

										<div class="col-md-2">
											<label class="text-body">Level</label>
											<select name="Level" id="Level" class="js-example-basic-single form-control bg-transparent">
												@foreach([1,2,3,4,5] as $lv)
													<option value="{{ $lv }}" {{ $OldLevel == $lv ? 'selected' : '' }}>{{ $lv }}</option>
												@endforeach
											</select>
										</div>

										<div class="col-md-2 d-flex align-items-end">
											<button type="submit" class="btn btn-outline-primary rounded-pill font-weight-bold">
												Cari Data
											</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>

					<div class="col-12 px-4">
						<div class="card card-custom gutter-b bg-white border-0">
							<div class="card-body">
								<div class="dx-viewport">
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

@endsection

@push('scripts')
<script type="text/javascript">
    window.jsPDF = window.jspdf.jsPDF;

	jQuery(document).ready(function () {
		var oData = <?php echo json_encode($neracasaldo) ?>;
		bindGrid(oData);
	});

	function bindGrid(data) {
		jQuery("#gridContainer").dxDataGrid({
			dataSource: data,
			keyExpr: "KodeRekening",
			showBorders: true,
			allowColumnResizing: true,
			allowColumnReordering: true,
			columnAutoWidth: true,
			paging: { enabled: true, pageSize: 50 },
			searchPanel: { visible: true, width: 240, placeholder: "Search..." },
			export: { enabled: true, formats: ['pdf', 'xlsx'] },
			columns: [
				{
					dataField: "NamaKelompok",
					caption: "Kelompok",
					allowEditing: false,
					groupIndex: 0,
				},
				{
					dataField: "KodeRekening",
					caption: "Kode Rekening",
					allowEditing: false,
					width: 130,
				},
				{
					dataField: "NamaRekening",
					caption: "Nama Rekening",
					allowEditing: false,
				},
				{
					dataField: "Level",
					caption: "Lvl",
					allowEditing: false,
					width: 50,
					alignment: "center",
				},
				{
					caption: "Saldo Awal",
					alignment: "center",
					columns: [
						{
							dataField: "SaldoAwalDebet",
							caption: "Debet",
							allowEditing: false,
							format: { type: 'fixedPoint', precision: 2 },
							calculateCellValue: function (row) {
								return row.Posisi == 1 && row.SaldoAwal > 0 ? row.SaldoAwal : 0;
							},
						},
						{
							dataField: "SaldoAwalKredit",
							caption: "Kredit",
							allowEditing: false,
							format: { type: 'fixedPoint', precision: 2 },
							calculateCellValue: function (row) {
								return row.Posisi == 2 && row.SaldoAwal > 0 ? row.SaldoAwal : 0;
							},
						},
					],
				},
				{
					caption: "Mutasi",
					alignment: "center",
					columns: [
						{
							dataField: "MutasiDebet",
							caption: "Debet",
							allowEditing: false,
							format: { type: 'fixedPoint', precision: 2 },
						},
						{
							dataField: "MutasiKredit",
							caption: "Kredit",
							allowEditing: false,
							format: { type: 'fixedPoint', precision: 2 },
						},
					],
				},
				{
					caption: "Saldo Akhir",
					alignment: "center",
					columns: [
						{
							dataField: "SaldoAkhirDebet",
							caption: "Debet",
							allowEditing: false,
							format: { type: 'fixedPoint', precision: 2 },
							calculateCellValue: function (row) {
								return row.Posisi == 1 && row.SaldoAkhir > 0 ? row.SaldoAkhir : 0;
							},
						},
						{
							dataField: "SaldoAkhirKredit",
							caption: "Kredit",
							allowEditing: false,
							format: { type: 'fixedPoint', precision: 2 },
							calculateCellValue: function (row) {
								return row.Posisi == 2 && row.SaldoAkhir > 0 ? row.SaldoAkhir : 0;
							},
						},
					],
				},
			],
			summary: {
				groupItems: [
					{ column: "SaldoAwalDebet",  summaryType: "sum", alignByColumn: true, showInGroupFooter: false, displayFormat: "{0}", valueFormat: { type: "fixedPoint", precision: 2 } },
					{ column: "SaldoAwalKredit", summaryType: "sum", alignByColumn: true, showInGroupFooter: false, displayFormat: "{0}", valueFormat: { type: "fixedPoint", precision: 2 } },
					{ column: "MutasiDebet",     summaryType: "sum", alignByColumn: true, showInGroupFooter: false, displayFormat: "{0}", valueFormat: { type: "fixedPoint", precision: 2 } },
					{ column: "MutasiKredit",    summaryType: "sum", alignByColumn: true, showInGroupFooter: false, displayFormat: "{0}", valueFormat: { type: "fixedPoint", precision: 2 } },
					{ column: "SaldoAkhirDebet", summaryType: "sum", alignByColumn: true, showInGroupFooter: false, displayFormat: "{0}", valueFormat: { type: "fixedPoint", precision: 2 } },
					{ column: "SaldoAkhirKredit",summaryType: "sum", alignByColumn: true, showInGroupFooter: false, displayFormat: "{0}", valueFormat: { type: "fixedPoint", precision: 2 } },
				],
				totalItems: [
					{ column: "SaldoAwalDebet",   summaryType: "sum", displayFormat: "{0}", valueFormat: { type: "fixedPoint", precision: 2 } },
					{ column: "SaldoAwalKredit",  summaryType: "sum", displayFormat: "{0}", valueFormat: { type: "fixedPoint", precision: 2 } },
					{ column: "MutasiDebet",      summaryType: "sum", displayFormat: "{0}", valueFormat: { type: "fixedPoint", precision: 2 } },
					{ column: "MutasiKredit",     summaryType: "sum", displayFormat: "{0}", valueFormat: { type: "fixedPoint", precision: 2 } },
					{ column: "SaldoAkhirDebet",  summaryType: "sum", displayFormat: "{0}", valueFormat: { type: "fixedPoint", precision: 2 } },
					{ column: "SaldoAkhirKredit", summaryType: "sum", displayFormat: "{0}", valueFormat: { type: "fixedPoint", precision: 2 } },
				],
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
								saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'Neraca Saldo.xlsx');
							});
						});
						break;
					case "pdf":
						const doc = new jsPDF({ orientation: 'landscape', unit: 'pt', format: [1200, 612] });
						DevExpress.pdfExporter.exportDataGrid({
							jsPDFDocument: doc,
							component: e.component,
						}).then(() => {
							const header = 'Neraca Saldo';
							const pageWidth = doc.internal.pageSize.getWidth();
							doc.setFontSize(15);
							doc.text(header, (pageWidth - doc.getTextDimensions(header).w) / 2, 20);
							doc.save('Neraca Saldo.pdf');
						});
						break;
				}
			},
		}).dxDataGrid('instance');
	}
</script>
@endpush
