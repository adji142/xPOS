@extends('parts.header')

@section('content')

<div class="subheader py-2 py-lg-6 subheader-solid">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white mb-0 px-0 py-2">
                <li class="breadcrumb-item active" aria-current="page">Laporan Buku Besar</li>
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
                                    <h3 class="card-label mb-0 font-weight-bold text-body">Laporan Buku Besar</h3>
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
                                <form action="{{ route('report-bukubesar') }}" method="GET">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="text-body">Tanggal Awal</label>
                                            <input type="date" name="TglAwal" class="form-control"
                                                value="{{ $oldTglAwal }}">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="text-body">Tanggal Akhir</label>
                                            <input type="date" name="TglAkhir" class="form-control"
                                                value="{{ $oldTglAkhir }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="text-body">Rekening (Opsional)</label>
                                            <select name="KodeRekening" class="js-example-basic-single form-control bg-transparent">
                                                <option value="">-- Semua Rekening --</option>
                                                @foreach($rekening as $rek)
                                                    <option value="{{ $rek->KodeRekening }}"
                                                        {{ $oldKodeRekening == $rek->KodeRekening ? 'selected' : '' }}>
                                                        {{ $rek->KodeRekening }} - {{ $rek->NamaRekening }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <br>
                                            <button type="submit" class="btn btn-outline-primary rounded-pill font-weight-bold me-1 mb-1">
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

    jQuery(document).ready(function () {
        var oData = <?php echo json_encode($bukubesar) ?>;
        bindGrid(oData);
    });

    function bindGrid(data) {
        var dataGridInstance = jQuery("#gridContainer").dxDataGrid({
            allowColumnResizing: true,
            dataSource: data,
            showBorders: true,
            allowColumnReordering: true,
            columnAutoWidth: true,
            paging: {
                enabled: false,
            },
            export: {
                enabled: true,
                formats: ['pdf', 'xlsx'],
            },
            searchPanel: {
                visible: true,
                width: 240,
                placeholder: "Search..."
            },
            grouping: {
                autoExpandAll: true,
            },
            groupPanel: {
                visible: false,
            },
            columns: [
                {
                    dataField: "NamaRekening",
                    caption: "Rekening",
                    groupIndex: 0,
                    calculateGroupValue: function (rowData) {
                        return rowData.KodeRekening + ' - ' + rowData.NamaRekening;
                    },
                    autoExpandGroup: true,
                },
                {
                    dataField: "TglTransaksi",
                    caption: "Tanggal",
                    dataType: "date",
                    format: "dd/MM/yyyy",
                    allowEditing: false,
                    allowExporting: true,
                    width: 110,
                },
                {
                    dataField: "NoTransaksi",
                    caption: "No. Transaksi",
                    allowEditing: false,
                    allowExporting: true,
                    width: 160,
                },
                {
                    dataField: "NoReff",
                    caption: "No. Referensi",
                    allowEditing: false,
                    allowExporting: true,
                    width: 160,
                },
                {
                    dataField: "Keterangan",
                    caption: "Keterangan",
                    allowEditing: false,
                    allowExporting: true,
                },
                {
                    dataField: "Debet",
                    caption: "Debet",
                    allowEditing: false,
                    allowExporting: true,
                    format: { type: 'fixedPoint', precision: 2 },
                    width: 150,
                },
                {
                    dataField: "Kredit",
                    caption: "Kredit",
                    allowEditing: false,
                    allowExporting: true,
                    format: { type: 'fixedPoint', precision: 2 },
                    width: 150,
                },
                {
                    dataField: "Saldo",
                    caption: "Saldo",
                    allowEditing: false,
                    allowExporting: true,
                    format: { type: 'fixedPoint', precision: 2 },
                    width: 150,
                },
            ],
            summary: {
                groupItems: [
                    {
                        column: "Debet",
                        summaryType: "sum",
                        alignByColumn: true,
                        showInGroupFooter: true,
                        displayFormat: "{0}",
                        valueFormat: { type: "fixedPoint", precision: 2 }
                    },
                    {
                        column: "Kredit",
                        summaryType: "sum",
                        alignByColumn: true,
                        showInGroupFooter: true,
                        displayFormat: "{0}",
                        valueFormat: { type: "fixedPoint", precision: 2 }
                    },
                ],
            },
            onExporting: function (e) {
                var tglAwal = "{{ $oldTglAwal }}";
                var tglAkhir = "{{ $oldTglAkhir }}";
                var title = 'Laporan Buku Besar ' + tglAwal + ' s/d ' + tglAkhir;

                switch (e.format) {
                    case "xlsx":
                        const workbook = new ExcelJS.Workbook();
                        const worksheet = workbook.addWorksheet('Buku Besar');
                        DevExpress.excelExporter.exportDataGrid({
                            component: e.component,
                            worksheet,
                            autoFilterEnabled: true,
                        }).then(() => {
                            workbook.xlsx.writeBuffer().then((buffer) => {
                                saveAs(new Blob([buffer], { type: 'application/octet-stream' }), title + '.xlsx');
                            });
                        });
                        break;
                    case "pdf":
                        const doc = new jsPDF({
                            orientation: 'landscape',
                            unit: 'pt',
                            format: [1200, 612],
                        });
                        DevExpress.pdfExporter.exportDataGrid({
                            jsPDFDocument: doc,
                            component: e.component,
                        }).then(() => {
                            const pageWidth = doc.internal.pageSize.getWidth();
                            const headerWidth = doc.getTextDimensions(title).w;
                            doc.setFontSize(14);
                            doc.text(title, (pageWidth - headerWidth) / 2, 20);
                            doc.save(title + '.pdf');
                        });
                        break;
                }
            },
        }).dxDataGrid('instance');
    }
</script>
@endpush
