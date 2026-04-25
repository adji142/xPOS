@extends('parts.header')

@section('content')

<div class="subheader py-2 py-lg-6 subheader-solid">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white mb-0 px-0 py-2">
                <li class="breadcrumb-item active" aria-current="page">Laporan Arus Kas</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container-fluid py-4">

    {{-- Filter --}}
    <div class="card card-custom gutter-b bg-white border-0 mb-4" style="height:auto;">
        <div class="card-header" style="min-height:auto;padding:1rem 1.5rem;">
            <span class="font-weight-bold">Filter Data</span>
        </div>
        <div class="card-body py-3" style="height:auto;flex:none;">
            <form action="{{ route('report-cashflow') }}" method="GET">
                <div class="row align-items-end">
                    <div class="col-md-3">
                        <label class="text-body">Bulan</label>
                        <select name="Bulan" class="js-example-basic-single form-control bg-transparent">
                            <option value="">Pilih Bulan</option>
                            @foreach(['01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'] as $val => $label)
                                <option value="{{ $val }}" {{ str_pad($OldBulan,2,'0',STR_PAD_LEFT) == $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="text-body">Tahun</label>
                        <select name="Tahun" class="js-example-basic-single form-control bg-transparent">
                            <option value="">Pilih Tahun</option>
                            @foreach($year as $y)
                                <option value="{{ $y['Year'] }}" {{ $y['Year'] == $OldTahun ? 'selected' : '' }}>{{ $y['Year'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-outline-primary rounded-pill font-weight-bold">
                            Cari Data
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if($cashflow !== null)
    @php
        $bulanLabels = ['01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'];
        $bulanLabel  = $bulanLabels[str_pad($OldBulan,2,'0',STR_PAD_LEFT)] ?? $OldBulan;

        function cfFmt($val) {
            if ($val < 0) return '(' . number_format(abs($val), 2, '.', ',') . ')';
            return number_format($val, 2, '.', ',');
        }
    @endphp

    {{-- Report card --}}
    <div class="card card-custom gutter-b bg-white border-0" style="height:auto;">
        <div class="card-body p-0" style="height:auto;flex:none;">

            {{-- Toolbar --}}
            <div class="d-flex justify-content-between align-items-center px-5 pt-4 pb-2">
                <div>
                    <h5 class="mb-0 font-weight-bold">Laporan Arus Kas</h5>
                    <small class="text-muted">{{ $ocompany->NamaPerusahaan ?? '' }} &mdash; Periode: {{ $bulanLabel }} {{ $OldTahun }}</small>
                </div>
                <div>
                    <button class="btn btn-sm btn-outline-secondary rounded-pill mr-2" onclick="window.print()">
                        <i class="fas fa-print mr-1"></i> Print
                    </button>
                    <button class="btn btn-sm btn-outline-danger rounded-pill" id="btn-export-pdf">
                        <i class="fas fa-file-pdf mr-1"></i> Export PDF
                    </button>
                </div>
            </div>

            {{-- Report Table --}}
            <div class="px-5 pb-5">
                <table id="table-cashflow" class="cf-table w-100">
                    <colgroup>
                        <col style="width:60%">
                        <col style="width:40%; text-align:right;">
                    </colgroup>
                    <thead>
                        <tr class="cf-thead">
                            <th>Keterangan</th>
                            <th class="text-right">Jumlah (Rp)</th>
                        </tr>
                    </thead>
                    <tbody>

                        {{-- ═══ SECTION A: OPERASI ═══ --}}
                        <tr class="cf-section-header">
                            <td colspan="2">A. ARUS KAS DARI AKTIVITAS OPERASI</td>
                        </tr>

                        <tr class="cf-item">
                            <td class="pl-4">Laba Bersih</td>
                            <td class="text-right {{ $cashflow['labaBersih'] < 0 ? 'text-danger' : '' }}">
                                {{ cfFmt($cashflow['labaBersih']) }}
                            </td>
                        </tr>

                        @if($cashflow['penyusutan'] != 0)
                        <tr class="cf-sub-header">
                            <td class="pl-4" colspan="2">Penyesuaian Non-Kas:</td>
                        </tr>
                        <tr class="cf-item">
                            <td class="pl-5">Penyusutan &amp; Amortisasi</td>
                            <td class="text-right {{ $cashflow['penyusutan'] < 0 ? 'text-danger' : '' }}">
                                {{ cfFmt($cashflow['penyusutan']) }}
                            </td>
                        </tr>
                        @endif

                        @if(count($cashflow['workingCapital']) > 0)
                        <tr class="cf-sub-header">
                            <td class="pl-4" colspan="2">Perubahan Modal Kerja:</td>
                        </tr>
                        @foreach($cashflow['workingCapital'] as $wc)
                        <tr class="cf-item">
                            <td class="pl-5">
                                @if($wc['Nilai'] < 0)
                                    Kenaikan {{ $wc['NamaRekening'] }}
                                @else
                                    Penurunan {{ $wc['NamaRekening'] }}
                                @endif
                            </td>
                            <td class="text-right {{ $wc['Nilai'] < 0 ? 'text-danger' : '' }}">
                                {{ cfFmt($wc['Nilai']) }}
                            </td>
                        </tr>
                        @endforeach
                        @endif

                        <tr class="cf-subtotal">
                            <td>Kas Bersih dari Aktivitas Operasi</td>
                            <td class="text-right {{ $cashflow['kasOperasi'] < 0 ? 'text-danger' : '' }}">
                                {{ cfFmt($cashflow['kasOperasi']) }}
                            </td>
                        </tr>

                        <tr class="cf-spacer"><td colspan="2"></td></tr>

                        {{-- ═══ SECTION B: INVESTASI ═══ --}}
                        <tr class="cf-section-header">
                            <td colspan="2">B. ARUS KAS DARI AKTIVITAS INVESTASI</td>
                        </tr>

                        @if(count($cashflow['investing']) > 0)
                            @foreach($cashflow['investing'] as $inv)
                            <tr class="cf-item">
                                <td class="pl-5">{{ $inv['NamaRekening'] }}</td>
                                <td class="text-right {{ $inv['Nilai'] < 0 ? 'text-danger' : '' }}">
                                    {{ cfFmt($inv['Nilai']) }}
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr class="cf-item">
                                <td class="pl-5 text-muted">Tidak ada aktivitas investasi</td>
                                <td class="text-right">-</td>
                            </tr>
                        @endif

                        <tr class="cf-subtotal">
                            <td>Kas Bersih dari Aktivitas Investasi</td>
                            <td class="text-right {{ $cashflow['kasInvestasi'] < 0 ? 'text-danger' : '' }}">
                                {{ cfFmt($cashflow['kasInvestasi']) }}
                            </td>
                        </tr>

                        <tr class="cf-spacer"><td colspan="2"></td></tr>

                        {{-- ═══ SECTION C: PENDANAAN ═══ --}}
                        <tr class="cf-section-header">
                            <td colspan="2">C. ARUS KAS DARI AKTIVITAS PENDANAAN</td>
                        </tr>

                        @if(count($cashflow['financing']) > 0)
                            @foreach($cashflow['financing'] as $fin)
                            <tr class="cf-item">
                                <td class="pl-5">{{ $fin['NamaRekening'] }}</td>
                                <td class="text-right {{ $fin['Nilai'] < 0 ? 'text-danger' : '' }}">
                                    {{ cfFmt($fin['Nilai']) }}
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr class="cf-item">
                                <td class="pl-5 text-muted">Tidak ada aktivitas pendanaan</td>
                                <td class="text-right">-</td>
                            </tr>
                        @endif

                        <tr class="cf-subtotal">
                            <td>Kas Bersih dari Aktivitas Pendanaan</td>
                            <td class="text-right {{ $cashflow['kasPendanaan'] < 0 ? 'text-danger' : '' }}">
                                {{ cfFmt($cashflow['kasPendanaan']) }}
                            </td>
                        </tr>

                        <tr class="cf-spacer"><td colspan="2"></td></tr>

                        {{-- ═══ GRAND TOTAL ═══ --}}
                        <tr class="cf-net">
                            <td>KENAIKAN / (PENURUNAN) KAS BERSIH</td>
                            <td class="text-right {{ $cashflow['kenaikanKas'] < 0 ? 'text-danger' : '' }}">
                                {{ cfFmt($cashflow['kenaikanKas']) }}
                            </td>
                        </tr>
                        <tr class="cf-kas-awal">
                            <td>Saldo Kas Awal Periode</td>
                            <td class="text-right">{{ cfFmt($cashflow['kasAwal']) }}</td>
                        </tr>
                        <tr class="cf-kas-akhir">
                            <td>SALDO KAS AKHIR PERIODE</td>
                            <td class="text-right {{ $cashflow['kasAkhir'] < 0 ? 'text-danger' : '' }}">
                                {{ cfFmt($cashflow['kasAkhir']) }}
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>

        </div>
    </div>
    @endif

</div>

<style>
.cf-table {
    border-collapse: collapse;
    font-size: 0.92rem;
}
.cf-table th, .cf-table td {
    padding: 7px 12px;
    border: none;
}
.cf-thead th {
    background: #1e3a5f;
    color: #fff;
    font-weight: 600;
    font-size: 0.85rem;
    letter-spacing: 0.03em;
    padding: 10px 12px;
}
.cf-section-header td {
    background: #2d5fa0;
    color: #fff;
    font-weight: 700;
    font-size: 0.9rem;
    padding: 9px 12px;
}
.cf-sub-header td {
    background: #eef3fb;
    color: #34495e;
    font-weight: 600;
    font-style: italic;
    font-size: 0.85rem;
}
.cf-item td {
    background: #fff;
    color: #2c3e50;
    border-bottom: 1px solid #f0f0f0;
}
.cf-item:hover td {
    background: #f7f9ff;
}
.cf-subtotal td {
    background: #d8e8f8;
    color: #1a3c6e;
    font-weight: 700;
    border-top: 2px solid #2d5fa0;
    padding: 9px 12px;
}
.cf-spacer td {
    height: 10px;
    background: #f8f8f8;
}
.cf-net td {
    background: #1e3a5f;
    color: #fff;
    font-weight: 700;
    font-size: 0.95rem;
    padding: 10px 12px;
    border-top: 3px solid #f0a500;
}
.cf-kas-awal td {
    background: #fff;
    color: #2c3e50;
    padding: 8px 12px;
    border-bottom: 1px solid #e0e0e0;
}
.cf-kas-akhir td {
    background: #0d6e3a;
    color: #fff;
    font-weight: 700;
    font-size: 1rem;
    padding: 12px 12px;
    border-top: 3px double #fff;
}
.text-danger { color: #c0392b !important; }

@media print {
    .subheader, .card-header, button, .btn { display: none !important; }
    .container-fluid { padding: 0 !important; }
    .card { box-shadow: none !important; border: none !important; }
    .cf-table { font-size: 10pt; }
    .cf-section-header td { background: #2d5fa0 !important; color: #fff !important; -webkit-print-color-adjust: exact; }
    .cf-subtotal td { background: #d8e8f8 !important; -webkit-print-color-adjust: exact; }
    .cf-net td { background: #1e3a5f !important; color: #fff !important; -webkit-print-color-adjust: exact; }
    .cf-kas-akhir td { background: #0d6e3a !important; color: #fff !important; -webkit-print-color-adjust: exact; }
}
</style>

@endsection

@push('scripts')
<script>
    window.jsPDF = window.jspdf.jsPDF;

    @if($cashflow !== null)
    var cfData = @json($cashflow);
    var cfPeriode = "{{ $bulanLabel }} {{ $OldTahun }}";
    var cfCompany = "{{ $ocompany->NamaPerusahaan ?? '' }}";

    function fmtNum(val) {
        val = parseFloat(val) || 0;
        if (val < 0) return '(' + Math.abs(val).toLocaleString('en-US', {minimumFractionDigits:2, maximumFractionDigits:2}) + ')';
        return val.toLocaleString('en-US', {minimumFractionDigits:2, maximumFractionDigits:2});
    }

    document.getElementById('btn-export-pdf').addEventListener('click', function () {
        var doc = new jsPDF({ orientation: 'portrait', unit: 'pt', format: 'a4' });
        var pageW = doc.internal.pageSize.getWidth();
        var margin = 40;
        var colRight = pageW - margin;
        var y = margin;

        // Header
        doc.setFont('helvetica', 'bold');
        doc.setFontSize(14);
        doc.text('LAPORAN ARUS KAS', pageW / 2, y, { align: 'center' }); y += 18;
        doc.setFontSize(10);
        doc.setFont('helvetica', 'normal');
        doc.text(cfCompany, pageW / 2, y, { align: 'center' }); y += 14;
        doc.text('Periode: ' + cfPeriode, pageW / 2, y, { align: 'center' }); y += 20;

        // Column header
        doc.setFillColor(30, 58, 95);
        doc.rect(margin, y, pageW - margin*2, 18, 'F');
        doc.setTextColor(255,255,255);
        doc.setFont('helvetica', 'bold');
        doc.setFontSize(9);
        doc.text('Keterangan', margin + 5, y + 12);
        doc.text('Jumlah (Rp)', colRight - 5, y + 12, { align: 'right' });
        doc.setTextColor(0,0,0);
        y += 22;

        function drawSection(label) {
            doc.setFillColor(45, 95, 160);
            doc.rect(margin, y, pageW - margin*2, 16, 'F');
            doc.setTextColor(255,255,255);
            doc.setFont('helvetica', 'bold');
            doc.setFontSize(9);
            doc.text(label, margin + 5, y + 11);
            doc.setTextColor(0,0,0);
            y += 18;
        }

        function drawItem(label, val, indent) {
            indent = indent || 0;
            doc.setFont('helvetica', 'normal');
            doc.setFontSize(9);
            var isNeg = parseFloat(val) < 0;
            if (isNeg) doc.setTextColor(192, 57, 43);
            doc.text(label, margin + 5 + indent, y + 11);
            doc.text(fmtNum(val), colRight - 5, y + 11, { align: 'right' });
            doc.setTextColor(0,0,0);
            doc.setDrawColor(230,230,230);
            doc.line(margin, y + 16, colRight, y + 16);
            y += 18;
        }

        function drawSubHeader(label) {
            doc.setFillColor(238, 243, 251);
            doc.rect(margin, y, pageW - margin*2, 15, 'F');
            doc.setFont('helvetica', 'bolditalic');
            doc.setFontSize(8.5);
            doc.text(label, margin + 15, y + 11);
            y += 16;
        }

        function drawSubtotal(label, val) {
            doc.setFillColor(216, 232, 248);
            doc.rect(margin, y, pageW - margin*2, 18, 'F');
            doc.setFont('helvetica', 'bold');
            doc.setFontSize(9);
            var isNeg = parseFloat(val) < 0;
            if (isNeg) doc.setTextColor(192,57,43);
            doc.text(label, margin + 5, y + 13);
            doc.text(fmtNum(val), colRight - 5, y + 13, { align: 'right' });
            doc.setTextColor(0,0,0);
            y += 22;
        }

        function drawSpacer() { y += 8; }

        // ── A. OPERASI ──
        drawSection('A. ARUS KAS DARI AKTIVITAS OPERASI');
        drawItem('Laba Bersih', cfData.labaBersih, 10);
        if (cfData.penyusutan != 0) {
            drawSubHeader('Penyesuaian Non-Kas:');
            drawItem('Penyusutan & Amortisasi', cfData.penyusutan, 20);
        }
        if (cfData.workingCapital.length > 0) {
            drawSubHeader('Perubahan Modal Kerja:');
            cfData.workingCapital.forEach(function(wc) {
                var lbl = (parseFloat(wc.Nilai) < 0 ? 'Kenaikan ' : 'Penurunan ') + wc.NamaRekening;
                drawItem(lbl, wc.Nilai, 20);
            });
        }
        drawSubtotal('Kas Bersih dari Aktivitas Operasi', cfData.kasOperasi);
        drawSpacer();

        // ── B. INVESTASI ──
        drawSection('B. ARUS KAS DARI AKTIVITAS INVESTASI');
        if (cfData.investing.length > 0) {
            cfData.investing.forEach(function(inv) { drawItem(inv.NamaRekening, inv.Nilai, 20); });
        } else {
            drawItem('Tidak ada aktivitas investasi', 0, 20);
        }
        drawSubtotal('Kas Bersih dari Aktivitas Investasi', cfData.kasInvestasi);
        drawSpacer();

        // ── C. PENDANAAN ──
        drawSection('C. ARUS KAS DARI AKTIVITAS PENDANAAN');
        if (cfData.financing.length > 0) {
            cfData.financing.forEach(function(fin) { drawItem(fin.NamaRekening, fin.Nilai, 20); });
        } else {
            drawItem('Tidak ada aktivitas pendanaan', 0, 20);
        }
        drawSubtotal('Kas Bersih dari Aktivitas Pendanaan', cfData.kasPendanaan);
        drawSpacer();

        // ── Grand total ──
        doc.setFillColor(30, 58, 95);
        doc.rect(margin, y, pageW - margin*2, 20, 'F');
        doc.setTextColor(255,255,255);
        doc.setFont('helvetica', 'bold');
        doc.setFontSize(10);
        var isNeg = parseFloat(cfData.kenaikanKas) < 0;
        if (isNeg) doc.setTextColor(255, 150, 130);
        doc.text('KENAIKAN / (PENURUNAN) KAS BERSIH', margin + 5, y + 14);
        doc.text(fmtNum(cfData.kenaikanKas), colRight - 5, y + 14, { align: 'right' });
        doc.setTextColor(0,0,0);
        y += 24;

        // Saldo Awal
        doc.setFont('helvetica', 'normal');
        doc.setFontSize(9);
        doc.text('Saldo Kas Awal Periode', margin + 5, y + 11);
        doc.text(fmtNum(cfData.kasAwal), colRight - 5, y + 11, { align: 'right' });
        doc.setDrawColor(200,200,200);
        doc.line(margin, y + 16, colRight, y + 16);
        y += 20;

        // Saldo Akhir
        doc.setFillColor(13, 110, 58);
        doc.rect(margin, y, pageW - margin*2, 22, 'F');
        doc.setTextColor(255,255,255);
        doc.setFont('helvetica', 'bold');
        doc.setFontSize(10);
        doc.text('SALDO KAS AKHIR PERIODE', margin + 5, y + 15);
        doc.text(fmtNum(cfData.kasAkhir), colRight - 5, y + 15, { align: 'right' });

        doc.save('Laporan Arus Kas - ' + cfPeriode + '.pdf');
    });
    @endif
</script>
@endpush
