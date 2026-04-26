@extends('parts.header')

@section('content')

<div class="subheader py-2 py-lg-6 subheader-solid">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white mb-0 px-0 py-2">
                <li class="breadcrumb-item active" aria-current="page">Laporan Laba Rugi</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12 px-4">

                {{-- Filter Card --}}
                <div class="card card-custom gutter-b bg-white border-0" style="height:auto;">
                    <div class="card-header font-weight-bold">Filter Data</div>
                    <div class="card-body py-4" style="height:auto;flex:none;">
                        <form action="{{ route('report-labarugi') }}" method="GET">
                            <div class="row align-items-end">
                                <div class="col-md-3">
                                    <label class="text-body font-weight-bold mb-1">Bulan</label>
                                    <select name="Bulan" class="js-example-basic-single form-control bg-transparent">
                                        <option value="">Pilih Bulan</option>
                                        @foreach([
                                            '01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April',
                                            '05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus',
                                            '09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'
                                        ] as $val => $label)
                                            <option value="{{ $val }}" {{ $OldBulan == $val ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="text-body font-weight-bold mb-1">Tahun</label>
                                    <select name="Tahun" class="js-example-basic-single form-control bg-transparent">
                                        <option value="">Pilih Tahun</option>
                                        @foreach($year as $y)
                                            <option value="{{ $y['Year'] }}" {{ $y['Year'] == $OldTahun ? 'selected' : '' }}>{{ $y['Year'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="text-body font-weight-bold mb-1">Jenis Laporan</label>
                                    <select name="TipeLaporan" class="js-example-basic-single form-control bg-transparent">
                                        <option value="1" {{ $OldTipeLaporan == '1' ? 'selected' : '' }} {{ ($AksesAccounting == 0) ? 'disabled' : '' }}>
                                            Laba Rugi Akuntansi
                                        </option>
                                        <option value="2" {{ $OldTipeLaporan == '2' ? 'selected' : '' }}>
                                            Laba Rugi Per Item
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary rounded-pill font-weight-bold px-6">
                                        <i class="fas fa-search mr-1"></i> Tampilkan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Report Card: hanya tampil jika ada data atau tipe per item --}}
                @if(count($labarugi) > 0 || $OldTipeLaporan == '2')
                <div class="card card-custom gutter-b bg-white border-0">
                    <div class="card-body">

                        @if($OldTipeLaporan == '2')
                            {{-- ===== TIPE 2: Per Item (DevExtreme Grid) ===== --}}
                            <div id="gridContainer"></div>

                        @elseif(count($labarugi) > 0)
                            {{-- ===== TIPE 1: Akuntansi ===== --}}

                            {{-- Toolbar export --}}
                            <div class="d-flex justify-content-between align-items-center mb-4 no-print">
                                <div>
                                    <h5 class="font-weight-bold mb-0 text-dark">
                                        {{ $ocompany->NamaPartner ?? '' }}
                                        <span class="text-muted font-weight-normal font-size-sm ml-2">
                                            Periode {{ $OldBulan }}/{{ $OldTahun }}
                                        </span>
                                    </h5>
                                </div>
                                <div>
                                    <button onclick="exportToExcel()" class="btn btn-sm btn-light-success rounded font-weight-bold mr-2">
                                        <i class="fas fa-file-excel mr-1"></i>Excel
                                    </button>
                                    <button onclick="exportToPDF()" class="btn btn-sm btn-light-danger rounded font-weight-bold mr-2">
                                        <i class="fas fa-file-pdf mr-1"></i>PDF
                                    </button>
                                    <button onclick="window.print()" class="btn btn-sm btn-light-primary rounded font-weight-bold">
                                        <i class="fas fa-print mr-1"></i>Print
                                    </button>
                                </div>
                            </div>

                            <div id="report-container">
                                {{-- Report Header (print only or visible always) --}}
                                <div class="text-center mb-5 report-header">
                                    <div class="font-weight-bolder text-dark" style="font-size:1.6rem;letter-spacing:0.5px;">
                                        LAPORAN LABA RUGI
                                    </div>
                                    <div class="text-muted mt-1" style="font-size:1rem;">{{ $ocompany->NamaPartner ?? '' }}</div>
                                    <div class="mt-1">
                                        <span class="badge badge-secondary px-4 py-2" style="font-size:0.85rem;">
                                            Periode: {{ $OldBulan }} / {{ $OldTahun }}
                                        </span>
                                    </div>
                                </div>

                                <table class="lr-table" id="table-labarugi">
                                    <thead>
                                        <tr class="lr-head">
                                            <th style="width:50px;" class="text-center">Kode</th>
                                            <th>Deskripsi</th>
                                            <th class="text-right" style="width:200px;">
                                                {{ $OldBulan }}/{{ $OldTahun }}
                                            </th>
                                            <th class="text-right" style="width:200px;">
                                                YTD {{ $OldTahun }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    @php
                                        $count      = count($labarugi);
                                        $accumNilai = 0;   // akumulasi kumulatif (tidak pernah direset)
                                        $accumYTD   = 0;
                                        $groupNilai = 0;   // nilai Level=1 kelompok saat ini
                                        $groupYTD   = 0;
                                        $lastKelompok = null;
                                    @endphp

                                    @foreach($labarugi as $index => $item)
                                        @php
                                            $item     = (object) $item;
                                            $nextItem = ($index + 1 < $count) ? (object)$labarugi[$index + 1] : null;
                                            $isLastInGroup = ($nextItem === null || $nextItem->NamaKelompok !== $item->NamaKelompok);

                                            // Simpan nilai Level=1 sebagai total grup
                                            if ($item->Level == 1) {
                                                $groupNilai = $item->Nilai;
                                                $groupYTD   = $item->YTD;
                                            }

                                            $indent   = ($item->Level - 1) * 20;
                                            $isHeader = ($item->Level <= 1);
                                            $isSub    = ($item->Level == 2);
                                        @endphp

                                        {{-- Separator antar kelompok --}}
                                        @if($lastKelompok !== null && $item->NamaKelompok !== $lastKelompok)
                                            <tr><td colspan="4" style="padding:4px 0;"></td></tr>
                                        @endif
                                        @php $lastKelompok = $item->NamaKelompok; @endphp

                                        <tr class="lr-row {{ $isHeader ? 'lr-group-header' : ($isSub ? 'lr-sub-header' : 'lr-detail') }}">
                                            <td class="text-center lr-kode">
                                                @if($item->Level >= 3)
                                                    <span class="text-muted" style="font-size:0.78rem;">{{ $item->KodeRekening }}</span>
                                                @endif
                                            </td>
                                            <td style="padding-left: {{ $indent + 12 }}px;">
                                                {{ $item->NamaRekening }}
                                            </td>
                                            <td class="text-right lr-nilai">
                                                @if($isHeader)
                                                    @if($item->Nilai < 0)
                                                        <span class="text-danger">({{ number_format(abs($item->Nilai), 0, ',', '.') }})</span>
                                                    @elseif($item->Nilai != 0)
                                                        {{ number_format($item->Nilai, 0, ',', '.') }}
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                @elseif($item->Nilai != 0)
                                                    @if($item->Nilai < 0)
                                                        <span class="text-danger">({{ number_format(abs($item->Nilai), 0, ',', '.') }})</span>
                                                    @else
                                                        {{ number_format($item->Nilai, 0, ',', '.') }}
                                                    @endif
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td class="text-right lr-nilai">
                                                @if($isHeader)
                                                    @if($item->YTD < 0)
                                                        <span class="text-danger">({{ number_format(abs($item->YTD), 0, ',', '.') }})</span>
                                                    @elseif($item->YTD != 0)
                                                        {{ number_format($item->YTD, 0, ',', '.') }}
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                @elseif($item->YTD != 0)
                                                    @if($item->YTD < 0)
                                                        <span class="text-danger">({{ number_format(abs($item->YTD), 0, ',', '.') }})</span>
                                                    @else
                                                        {{ number_format($item->YTD, 0, ',', '.') }}
                                                    @endif
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>

                                        {{-- Akumulasikan setiap kali grup selesai, lalu tampilkan footer jika ada --}}
                                        @if($isLastInGroup)
                                            @php
                                                $accumNilai += $groupNilai;
                                                $accumYTD   += $groupYTD;
                                            @endphp

                                            @if(!empty($item->FooterLaporan))
                                                @php
                                                    $label       = strtoupper(trim($item->FooterLaporan));
                                                    $isMilestone = str_contains($label, 'LABA') || str_contains($label, 'RUGI');
                                                @endphp
                                                <tr class="lr-footer {{ $isMilestone ? 'lr-milestone' : '' }}">
                                                    <td></td>
                                                    <td class="font-weight-bolder">{{ $label }}</td>
                                                    <td class="text-right font-weight-bolder lr-nilai">
                                                        @if($accumNilai < 0)
                                                            <span class="text-danger">({{ number_format(abs($accumNilai), 0, ',', '.') }})</span>
                                                        @else
                                                            {{ number_format($accumNilai, 0, ',', '.') }}
                                                        @endif
                                                    </td>
                                                    <td class="text-right font-weight-bolder lr-nilai">
                                                        @if($accumYTD < 0)
                                                            <span class="text-danger">({{ number_format(abs($accumYTD), 0, ',', '.') }})</span>
                                                        @else
                                                            {{ number_format($accumYTD, 0, ',', '.') }}
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr><td colspan="4" style="height:12px;"></td></tr>
                                            @endif
                                        @endif

                                    @endforeach

                                    </tbody>
                                </table>
                            </div>

                        @endif

                    </div>
                </div>
                @endif

        </div>
    </div>
</div>

<style>
/* ===== Tabel Laba Rugi ===== */
.lr-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.88rem;
    font-family: 'Inter', sans-serif;
}
.lr-head th {
    border-top: 2px solid #333;
    border-bottom: 2px solid #333;
    padding: 10px 12px;
    background: #fff;
    font-size: 0.82rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #555;
}
.lr-row td {
    padding: 4px 12px;
}
.lr-group-header td {
    font-weight: 700;
    font-size: 0.9rem;
    color: #1a1a2e;
    padding-top: 8px;
    padding-bottom: 4px;
    border-top: 1px solid #e0e0e0;
}
.lr-sub-header td {
    font-weight: 600;
    color: #2c3e50;
}
.lr-detail td {
    color: #555;
}
.lr-detail:hover td { background: #fafafa; }
.lr-kode { color: #aaa !important; }
.lr-nilai { font-variant-numeric: tabular-nums; }
.lr-footer td {
    padding: 8px 12px;
    background: #f4f6f9;
    border-top: 1px solid #ccc;
    border-bottom: 2px solid #999;
    font-size: 0.88rem;
}
.lr-milestone td {
    background: #eef5ff;
    border-top: 2px solid #3b82f6;
    border-bottom: 3px double #1e3a8a;
    font-size: 0.92rem;
    color: #1e3a8a;
}

/* ===== Print ===== */
@media print {
    .no-print, .subheader, nav { display: none !important; }
    body { background: #fff !important; font-size: 11pt; }
    .card { box-shadow: none !important; border: 0 !important; }
    .report-header { margin-bottom: 20px !important; }
    .lr-table { font-size: 9pt; }
    .lr-milestone td { border-bottom: 2px solid #000 !important; }
}
</style>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>

<script>
    window.jsPDF = window.jspdf.jsPDF;

    // Outer scope agar bisa diakses exportToPDF & exportToExcel
    var oData = <?php echo json_encode($labarugi) ?>;

    jQuery(document).ready(function () {
        if ("{{ $OldTipeLaporan }}" === "2") {
            bindGridLRItem(oData);
        }
    });

    function fmtNilai(val) {
        if (val === 0 || val === null || val === undefined) return '-';
        var abs = Math.abs(val).toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        return val < 0 ? '(' + abs + ')' : abs;
    }

    // Bangun baris PDF dengan logika akumulasi yang sama seperti Blade
    function buildPdfRows() {
        var rows = [];
        var accumNilai = 0, accumYTD = 0, groupNilai = 0, groupYTD = 0;

        for (var i = 0; i < oData.length; i++) {
            var item      = oData[i];
            var nextItem  = i + 1 < oData.length ? oData[i + 1] : null;
            var isLast    = !nextItem || nextItem.NamaKelompok !== item.NamaKelompok;

            if (item.Level == 1) { groupNilai = item.Nilai; groupYTD = item.YTD; }

            var indent = '';
            for (var l = 1; l < item.Level; l++) indent += '   ';

            var rowType = item.Level <= 1 ? 'header' : item.Level == 2 ? 'sub' : 'detail';
            rows.push({
                type: rowType,
                cols: [
                    item.Level >= 3 ? item.KodeRekening : '',
                    indent + item.NamaRekening,
                    fmtNilai(item.Nilai),
                    fmtNilai(item.YTD)
                ]
            });

            if (isLast) {
                accumNilai += groupNilai;
                accumYTD   += groupYTD;

                if (item.FooterLaporan) {
                    var label = item.FooterLaporan.toUpperCase().trim();
                    var isMilestone = label.includes('LABA') || label.includes('RUGI');
                    rows.push({
                        type: isMilestone ? 'milestone' : 'footer',
                        cols: ['', label, fmtNilai(accumNilai), fmtNilai(accumYTD)]
                    });
                    rows.push({ type: 'spacer', cols: ['', '', '', ''] });
                }
            }
        }
        return rows;
    }

    function exportToExcel() {
        var tbl = document.getElementById('table-labarugi');
        if (!tbl) return;
        var wb = XLSX.utils.table_to_book(tbl.cloneNode(true), { sheet: "Laba Rugi" });
        XLSX.writeFile(wb, 'Laba_Rugi_{{ $OldTahun }}{{ $OldBulan }}.xlsx');
    }

    function exportToPDF() {
        const doc    = new jsPDF({ orientation: 'p', unit: 'mm', format: 'a4' });
        const title  = "LAPORAN LABA RUGI";
        const company= "{{ $ocompany->NamaPartner ?? '' }}";
        const period = "Periode: {{ $OldBulan }} / {{ $OldTahun }}";

        // Header dokumen
        doc.setFontSize(14); doc.setFont(undefined, 'bold');
        doc.text(title, 105, 18, { align: 'center' });
        doc.setFontSize(10); doc.setFont(undefined, 'normal');
        doc.text(company, 105, 26, { align: 'center' });
        doc.setFontSize(9); doc.setTextColor(120, 120, 120);
        doc.text(period, 105, 32, { align: 'center' });
        doc.setTextColor(0); doc.setDrawColor(180);
        doc.line(15, 36, 195, 36);

        var pdfRows  = buildPdfRows();
        var bodyData = pdfRows.map(function(r) { return r.cols; });

        doc.autoTable({
            head: [['Kode', 'Deskripsi', '{{ $OldBulan }}/{{ $OldTahun }}', 'YTD {{ $OldTahun }}']],
            body: bodyData,
            startY: 40,
            theme: 'plain',
            styles: { fontSize: 8, cellPadding: { top: 2, bottom: 2, left: 3, right: 3 } },
            headStyles: {
                fontStyle: 'bold',
                fillColor: [255, 255, 255],
                textColor: [80, 80, 80],
                lineWidth: { bottom: 0.5 },
                lineColor: [180, 180, 180],
            },
            columnStyles: {
                0: { cellWidth: 22 },
                2: { halign: 'right', cellWidth: 38 },
                3: { halign: 'right', cellWidth: 38 },
            },
            didParseCell: function (data) {
                if (data.section !== 'body') return;
                var meta = pdfRows[data.row.index];
                if (!meta) return;

                switch (meta.type) {
                    case 'header':
                        data.cell.styles.fontStyle = 'bold';
                        data.cell.styles.fontSize  = 8.5;
                        data.cell.styles.textColor = [26, 26, 46];
                        break;
                    case 'sub':
                        data.cell.styles.fontStyle = 'bold';
                        data.cell.styles.textColor = [44, 62, 80];
                        break;
                    case 'detail':
                        data.cell.styles.textColor = [100, 100, 100];
                        break;
                    case 'milestone':
                        data.cell.styles.fontStyle  = 'bold';
                        data.cell.styles.fontSize   = 9;
                        data.cell.styles.fillColor  = [238, 245, 255];
                        data.cell.styles.textColor  = [30, 58, 138];
                        data.cell.styles.lineWidth  = { top: 0.5, bottom: 1 };
                        data.cell.styles.lineColor  = [30, 58, 138];
                        break;
                    case 'footer':
                        data.cell.styles.fontStyle = 'bold';
                        data.cell.styles.fillColor = [244, 246, 249];
                        data.cell.styles.lineWidth = { top: 0.3, bottom: 0.5 };
                        data.cell.styles.lineColor = [180, 180, 180];
                        break;
                    case 'spacer':
                        data.cell.styles.minCellHeight = 3;
                        break;
                }

                // Nilai negatif → merah
                if ((meta.type !== 'spacer') && data.column.index >= 2) {
                    var v = data.cell.raw ? data.cell.raw.toString() : '';
                    if (v.startsWith('(')) {
                        data.cell.styles.textColor = meta.type === 'milestone'
                            ? [180, 0, 0] : [180, 0, 0];
                    }
                }
            }
        });

        doc.save('Laba_Rugi_{{ $OldTahun }}{{ $OldBulan }}.pdf');
    }

    function bindGridLRItem(data) {
        jQuery("#gridContainer").dxDataGrid({
            dataSource: data,
            keyExpr: "KodeItem",
            showBorders: true,
            columnAutoWidth: true,
            paging: { enabled: false },
            export: { enabled: true, formats: ['pdf', 'xlsx'] },
            searchPanel: { visible: true, width: 240, placeholder: "Search..." },
            columns: [
                { dataField: "Transaksi",      caption: "Transaksi",       groupIndex: 0 },
                { dataField: "NamaJenis",      caption: "Jenis Item",      groupIndex: 1 },
                { dataField: "Item",           caption: "Item" },
                { dataField: "Terjual",        caption: "Jumlah Terjual",  format: { type: 'fixedPoint', precision: 2 } },
                { dataField: "HargaJual",      caption: "Harga Jual",      format: { type: 'fixedPoint', precision: 2 } },
                { dataField: "NilaiInventory", caption: "Nilai",           format: { type: 'fixedPoint', precision: 2 } },
                { dataField: "NilaiPenjualan", caption: "Nilai Penjualan", format: { type: 'fixedPoint', precision: 2 } },
                {
                    dataField: "LabaKotor", caption: "Laba Kotor",
                    format: { type: 'fixedPoint', precision: 2 },
                    calculateCellValue: function (row) {
                        return row.Transaksi === "2. Biaya"
                            ? row.NilaiInventory - row.NilaiPenjualan
                            : row.NilaiPenjualan - row.NilaiInventory;
                    }
                },
            ],
            summary: {
                groupItems: [
                    { column: "NilaiInventory", summaryType: "sum", alignByColumn: true, valueFormat: { type: "fixedPoint", precision: 2 } },
                    { column: "NilaiPenjualan", summaryType: "sum", alignByColumn: true, valueFormat: { type: "fixedPoint", precision: 2 } },
                    { column: "LabaKotor",      summaryType: "sum", alignByColumn: true, valueFormat: { type: "fixedPoint", precision: 2 } },
                ],
                totalItems: [
                    { column: "LabaKotor", summaryType: "sum", displayFormat: "Laba Bersih : {0}", valueFormat: { type: "fixedPoint", precision: 2 } },
                ]
            }
        }).dxDataGrid('instance');
    }
</script>
@endpush
