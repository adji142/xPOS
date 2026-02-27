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
									<h3 class="card-label mb-0 font-weight-bold text-body">Laporan Laba Rugi 
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
                                <form action="{{ route('report-labarugi') }}">
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
                                                <option value="08" {{ $OldBulan == '08' ? 'selected' : '' }}> Agustus </option>
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
                                            <label  class="text-body">Jenis Laporan</label>
                                            <select name="TipeLaporan" id="TipeLaporan" class="js-example-basic-single js-states form-control bg-transparent" >
                                                <option value="" {{ $OldTipeLaporan == 1 ? 'selected' : '' }}> Pilih Jenis Laporan </option>
                                                <option value="1" {{ $OldTipeLaporan == 1 ? 'selected' : '' }} {{ $AksesAccounting == 0 ? 'disabled' : '' }} > Laba Rugi Akutansi </option>
                                                <option value="2" {{ $OldTipeLaporan == 2 ? 'selected' : '' }}> Laba Rugi Per Item </option>
                                                
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
                        <div class="card card-custom gutter-b bg-white border-0" >
							<div class="card-body" >
                                <div class="d-flex justify-content-end mb-3 no-print">
                                    <button onclick="exportToExcel()" class="btn btn-sm btn-success rounded-pill font-weight-bold me-1">
                                        <i class="fas fa-file-excel"></i> Export Excel
                                    </button>
                                    <button onclick="exportToPDF()" class="btn btn-sm btn-danger rounded-pill font-weight-bold">
                                        <i class="fas fa-file-pdf"></i> Export PDF
                                    </button>
                                </div>
								<div id="report-container" class="bg-white p-5 border shadow-sm rounded">
                                    @if($OldTipeLaporan == 2)
                                        <div id="gridContainer"></div>
                                    @else
                                        <!-- Document Header -->
                                        <div class="text-center mb-5 mt-3">
                                            <h1 class="font-weight-bold mb-0" style="font-size: 2.5rem; letter-spacing: -1px; font-family: 'Poppins', sans-serif;">
                                                Laporan <span style="color: #3498db;">Laba & Rugi</span>
                                            </h1>
                                            <h3 class="font-weight-normal mb-1">{{ $ocompany->NamaPartner ?? 'PT. Sukses Kemilau' }}</h3>
                                            <div class="badge badge-light-primary px-4 py-2" style="font-size: 0.9rem;">
                                                Periode: {{ $OldBulan }}-{{ $OldTahun }}
                                            </div>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-borderless" id="table-labarugi" style="color: #333; font-family: 'Inter', sans-serif;">
                                                <thead>
                                                    <tr class="border-top border-bottom" style="border-width: 2px !important; border-color: #333 !important;">
                                                        <th class="text-left font-weight-bolder py-3" style="font-size: 0.95rem;">DESKRIPSI</th>
                                                        <th class="text-right font-weight-bolder py-3" style="width: 250px; font-size: 0.95rem;">NILAI (IDR)</th>
                                                        <th class="text-right font-weight-bolder py-3" style="width: 250px; font-size: 0.95rem;">YTD (IDR)</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $lastKelompok = "";
                                                        $count = count($labarugi);
                                                    @endphp
                                                    @foreach($labarugi as $index => $item)
                                                        @if($item->NamaKelompok != $lastKelompok)
                                                            @php $lastKelompok = $item->NamaKelompok; @endphp
                                                        @endif

                                                        @php
                                                            $isInduk = ($item->Level <= 2);
                                                            $padding = ($item->Level - 1) * 30;
                                                        @endphp
                                                        
                                                        <tr class="border-bottom-0">
                                                            <td class="{{ $isInduk ? 'font-weight-bold text-dark' : 'text-muted' }}" style="padding-left: {{ $padding }}px; py-2;">
                                                                {{ $item->NamaRekening }}
                                                            </td>
                                                            <td class="text-right py-2 {{ $isInduk ? 'font-weight-bold' : '' }}">
                                                                @if($item->Nilai < 0)
                                                                    <span>({{ number_format(abs($item->Nilai), 2) }})</span>
                                                                @else
                                                                    {{ number_format($item->Nilai, 2) }}
                                                                @endif
                                                            </td>
                                                            <td class="text-right py-2 {{ $isInduk ? 'font-weight-bold' : '' }}">
                                                                @if($item->YTD < 0)
                                                                    <span>({{ number_format(abs($item->YTD), 2) }})</span>
                                                                @else
                                                                    {{ number_format($item->YTD, 2) }}
                                                                @endif
                                                            </td>
                                                        </tr>

                                                        @if(!empty($item->FooterLaporan))
                                                            @php
                                                                $footerLabel = strtoupper($item->FooterLaporan);
                                                                $isLabaMilestone = str_contains($footerLabel, 'LABA') || str_contains($footerLabel, 'RUGI');
                                                                $nextItem = ($index + 1 < $count) ? $labarugi[$index + 1] : null;
                                                                $isLastInGroup = ($nextItem == null || $nextItem->NamaKelompok != $item->NamaKelompok);
                                                                
                                                                // Show footer ONLY if it's a milestone OR the last item in the group
                                                                $shouldShowFooter = $isLastInGroup;
                                                            @endphp

                                                            @if($shouldShowFooter)
                                                                @php
                                                                    $footerStyle = "background-color: #f8f9fa; border-top: 1px solid #dee2e6; border-bottom: 2px solid #dee2e6;";
                                                                    if ($isLabaMilestone) {
                                                                        $footerStyle = "background-color: #f1f8ff; border-top: 2px solid #3498db; border-bottom: 3px double #333;";
                                                                    }
                                                                @endphp
                                                                <tr class="font-weight-bolder text-dark footer-row" style="{{ $footerStyle }}">
                                                                    <td class="text-left py-3" style="font-size: 1.05rem;">
                                                                        {{ $footerLabel}}
                                                                    </td>
                                                                    <td class="text-right py-3">
                                                                        @if($item->Nilai < 0)
                                                                            <span>({{ number_format(abs($item->Nilai), 2) }})</span>
                                                                        @else
                                                                            {{ number_format($item->Nilai, 2) }}
                                                                        @endif
                                                                    </td>
                                                                    <td class="text-right py-3">
                                                                        @if($item->YTD < 0)
                                                                            <span>({{ number_format(abs($item->YTD), 2) }})</span>
                                                                        @else
                                                                            {{ number_format($item->YTD, 2) }}
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                <tr style="height: 20px;" class="no-border"><td colspan="3"></td></tr>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif
				              	</div>
							</div>

						</div>
					</div>
				</div>
			</div>
			
		</div>
	</div>
	
</div>

<style>
    @media print {
        .no-print { display: none !important; }
        body { background: white !important; }
        .card { border: 0 !important; box-shadow: none !important; }
    }
    #table-labarugi {
        border-collapse: collapse !important;
    }
    #table-labarugi td, #table-labarugi th {
        border-color: #eee;
    }
</style>

@endsection

@push('scripts')
{{-- Include Libraries for Export --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>

<script type="text/javascript">
    window.jsPDF = window.jspdf.jsPDF;

	jQuery(document).ready(function() {
        var oData = <?php echo json_encode($labarugi) ?>;

        if ("{{ $OldTipeLaporan }}" == "2") {
            bindGridLRItem(oData);
        }
	});

    function exportToExcel() {
        var elt = document.getElementById('table-labarugi').cloneNode(true);
        var wb = XLSX.utils.table_to_book(elt, { sheet: "Laba Rugi" });
        return XLSX.writeFile(wb, 'Laporan_Laba_Rugi_{{ $OldTahun }}{{ $OldBulan }}.xlsx');
    }

    function exportToPDF() {
        const doc = new jsPDF({
            orientation: 'p',
            unit: 'mm',
            format: 'a4'
        });

        const company = "{{ $ocompany->NamaPartner ?? 'PT. Sukses Kemilau' }}";
        const period = "Periode: {{ $OldBulan }}-{{ $OldTahun }}";
        
        doc.setFontSize(24);
        doc.setTextColor(51, 51, 51);
        doc.text("Laporan ", 105, 20, { align: 'right' });
        doc.setTextColor(52, 152, 219);
        doc.text("Laba & Rugi", 105, 20, { align: 'left' });
        
        doc.setFontSize(14);
        doc.setTextColor(51, 51, 51);
        doc.text(company, 105, 30, { align: 'center' });
        doc.setFontSize(10);
        doc.setTextColor(100, 100, 100);
        doc.text(period, 105, 36, { align: 'center' });
        
        doc.setDrawColor(200, 200, 200);
        doc.line(20, 42, 190, 42);

        doc.autoTable({ 
            html: '#table-labarugi',
            startY: 48,
            theme: 'plain',
            styles: { 
                fontSize: 9, 
                cellPadding: 2,
                textColor: [51, 51, 51]
            },
            headStyles: { 
                fontStyle: 'bold',
                borderBottom: { width: 1, color: [51, 51, 51] }
            },
            columnStyles: {
                1: { halign: 'right' },
                2: { halign: 'right' }
            },
            didParseCell: function (data) {
                const row = data.row.raw;
                if (row.classList.contains('footer-row')) {
                    data.cell.styles.fontStyle = 'bold';
                    data.cell.styles.fillColor = [248, 249, 250];
                    if (data.cell.text[0] && (data.cell.text[0].includes('LABA') || data.cell.text[0].includes('RUGI'))) {
                        data.cell.styles.fillColor = [241, 248, 255]; // Soft blue for milestones
                    }
                }
                
                // Indentation in PDF
                if (data.column.index === 0 && !row.classList.contains('footer-row')) {
                    const cellNode = row.cells[0];
                    if (cellNode && cellNode.style.paddingLeft) {
                        const padding = parseInt(cellNode.style.paddingLeft) || 0;
                        if (padding > 0) {
                            data.cell.styles.cellPadding = { left: 5 + (padding/5) };
                        }
                    }
                }
            }
        });

        doc.save('Laporan_Laba_Rugi_{{ $OldTahun }}{{ $OldBulan }}.pdf');
    }

    function bindGridLRItem(data) {
        var dataGridInstance = jQuery("#gridContainer").dxDataGrid({
            allowColumnResizing: true,
            dataSource: data,
            keyExpr: "KodeItem",
            showBorders: true,
            columnAutoWidth: true,
            paging: { enabled: false },
            export: { enabled: true, formats: ['pdf','xlsx'] },
            searchPanel: { visible: true, width: 240, placeholder: "Search..." },
            columns: [
                { dataField: "Transaksi", caption: "Transaksi", groupIndex:0 },
                { dataField: "NamaJenis", caption: "Jenis Item", groupIndex:1 },
                { dataField: "Item", caption: "Item" },
                { dataField: "Terjual", caption: "Jumlah Terjual", format: { type: 'fixedPoint', precision: 2 } },
                { dataField: "HargaJual", caption: "Harga Jual", format: { type: 'fixedPoint', precision: 2 } },
                { dataField: "NilaiInventory", caption: "Nilai", format: { type: 'fixedPoint', precision: 2 } },
                { dataField: "NilaiPenjualan", caption: "Nilai Pernjualan", format: { type: 'fixedPoint', precision: 2 } },
                { 
                    dataField: "LabaKotor", caption: "Laba Kotor", 
                    format: { type: 'fixedPoint', precision: 2 },
                    calculateCellValue: function(rowData) {
                        return rowData.Transaksi == "2. Biaya" ? rowData.NilaiInventory - rowData.NilaiPenjualan : rowData.NilaiPenjualan - rowData.NilaiInventory;
                    }
                },
            ],
            summary: {
                groupItems: [
                    { column: "NilaiInventory", summaryType: "sum" , alignByColumn: true, valueFormat: { type: "fixedPoint", precision: 2 } },
                    { column: "NilaiPenjualan", summaryType: "sum" , alignByColumn: true, valueFormat: { type: "fixedPoint", precision: 2 } },
                    { column: "LabaKotor", summaryType: "sum" , alignByColumn: true, valueFormat: { type: "fixedPoint", precision: 2 } },
                ],
                totalItems: [
                    { column: "LabaKotor", summaryType: "sum", displayFormat: "Laba Bersih : {0}", valueFormat: { type: "fixedPoint", precision: 2 } },
                ]
            }
        }).dxDataGrid('instance');
    }
    
</script>
@endpush