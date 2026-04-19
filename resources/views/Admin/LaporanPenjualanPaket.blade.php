@extends('parts.header')

@section('content')
<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">Laporan Penjualan Paket</li>
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
						<div class="card card-custom gutter-b bg-transparent shadow-none border-0" >
							<div class="card-header align-items-center  border-bottom-dark px-0">
								<div class="card-title mb-0">
									<h3 class="card-label mb-0 font-weight-bold text-body">Laporan Penjualan Paket</h3>
								</div>
                                <div class="icons d-flex">
									<button type="button" id="btDownloadExel" class="btn btn-outline-success rounded-pill font-weight-bold me-1 mb-1">Download Excel</button>
                                    <button type="button" id="btDownloadPdf" class="btn btn-outline-danger rounded-pill font-weight-bold me-1 mb-1">Download PDF</button>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-12 px-4">
						<div class="card card-custom gutter-b bg-white border-0" >
							<div class="card-header" >
								Filter Data
							</div>
							<div class="card-body" >
								<div class="row">
									<div class="col-md-3">
										<label class="text-body">Tanggal Awal</label>
										<input type="date" name="TglAwal" id="TglAwal" class="form-control">
									</div>
									<div class="col-md-3">
										<label class="text-body">Tanggal Akhir</label>
										<input type="date" name="TglAkhir" id="TglAkhir" class="form-control">
									</div>
									<div class="col-md-3">
										<br>
										<button class="btn btn-outline-primary rounded-pill font-weight-bold me-1 mb-1" id="btSearch">Cari Data</button>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-12 px-4">
						<div class="card card-custom gutter-b bg-white border-0" >
							<div class="card-body" >
								<div class="dx-viewport demo-container">
				                	<div id="data-grid-demo">
				                  		<div id="gridContainerHeader"></div>
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

        GetHeader();
	});

    jQuery('#btSearch').click(function () {
        GetHeader();
    });

    jQuery('#btDownloadExel').click(function () {
        var baseUrl = "{{ url('/laporanpenjualanpaket/export/excel') }}";
        var url = `${baseUrl}/${jQuery('#TglAwal').val()}/${jQuery('#TglAkhir').val()}`;
        window.location.href = url;
    });

    jQuery('#btDownloadPdf').click(function () {
        var baseUrl = "{{ url('/laporanpenjualanpaket/export/pdf') }}";
        var url = `${baseUrl}/${jQuery('#TglAwal').val()}/${jQuery('#TglAkhir').val()}`;
        window.location.href = url;
    });

    function GetHeader() {
        $.ajax({
            type: 'post',
            url: "{{route('laporanpenjualanpaket-viewheader')}}",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: {
                'TglAwal' : jQuery('#TglAwal').val(),
                'TglAkhir' : jQuery('#TglAkhir').val()
            },
            dataType: 'json',
            success: function(response) {
                bindGridHeader(response.data)
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
            columnAutoWidth: true,
            paging: {
                enabled: true,
                pageSize: 10
            },
            searchPanel: {
	            visible: true,
	            width: 240,
	            placeholder: "Search..."
	        },
            columns: [
                {
                    dataField: "NoTransaksi",
                    caption: "No. Transaksi",
                },
                {
                    dataField: "TglTransaksi",
                    caption: "Tgl. Transaksi",
                },
                {
                    dataField: "TglJatuhTempo",
                    caption: "Jatuh Tempo",
                },
                {
                    dataField: "KodePelanggan",
                    caption: "Kode Partner",
                },
                {
                    dataField: "NamaPartner",
                    caption: "Nama Partner",
                },
                {
                    dataField: "NamaSubscription",
                    caption: "Paket",
                },
                {
                    dataField: "TotalTagihan",
                    caption: "Total Tagihan",
                    format: { type: 'fixedPoint', precision: 2 }
                },
                {
                    dataField: "TotalBayar",
                    caption: "Total Bayar",
                    format: { type: 'fixedPoint', precision: 2 }
                },
                {
                    dataField: "TglBayar",
                    caption: "Tgl. Bayar",
                }
            ],
		}).dxDataGrid('instance');
	}
</script>
@endpush
