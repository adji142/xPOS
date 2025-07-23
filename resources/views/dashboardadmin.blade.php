@extends('parts.header')
@section('content')

<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">Dashboard</li>
			</ol>
		</nav>
	</div>
</div>
<!--end::Subheader-->
<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
	<!--begin::Container-->
	<div class="container-fluid">
		<div class="row">
			<div class="row">
				<div class="col-lg-6 col-xl-4">
					<div class="card card-custom gutter-b bg-white border-0 theme-circle theme-circle-primary">

						<div class="card-body">
							<h3 class="text-body font-weight-bold">Sales Day by Day</h3>
							<div class="mt-3">
								<div class="d-flex align-items-center">
									<span class="text-dark font-weight-bold font-size-h1 me-3">
										{{ number_format($daybyday) }}
									</span>

								</div>
								{{-- <div class="text-black-50 mt-3">Compare to last year (2019)</div> --}}
							</div>

						</div>

						
					</div>
				</div>

				<div class="col-lg-6 col-xl-4">
					<div class="card card-custom gutter-b bg-white border-0 theme-circle theme-circle theme-circle-secondary">

						<div class="card-body">
							<h3 class="text-body font-weight-bold">Sales Month to date</h3>
							<div class="mt-3">
								<div class="d-flex align-items-center">
									<span class="text-dark font-weight-bold font-size-h1 me-3">
										{{ number_format($mtd) }}
									</span>

								</div>
								{{-- <div class="text-black-50 mt-3">Compare to last year (2019)</div> --}}
							</div>

						</div>

						
					</div>
				</div>

				<div class="col-lg-6 col-xl-4">
					<div class="card card-custom gutter-b bg-white border-0 theme-circle theme-circle-success">

						<div class="card-body">
							<h3 class="text-body font-weight-bold">Sales year to date</h3>
							<div class="mt-3">
								<div class="d-flex align-items-center">
									<span class="text-dark font-weight-bold font-size-h1 me-3">
										{{ number_format($ytd) }}
									</span>

								</div>
								{{-- <div class="text-black-50 mt-3">Compare to last year (2019)</div> --}}
							</div>

						</div>

						
					</div>
				</div>
				
			</div>

			<div class="row">
				<div class="col-lg-6 col-xl-12">
					<div class="card card-custom gutter-b bg-white border-0" >
						<div class="card-header align-items-center  border-0">
							<div class="card-title mb-0">
								<h3 class="card-label mb-0 font-weight-bold text-body">Grafik Omzet
								</h3>
							</div>
						</div>
						<div class="card-body pt-3" >
							<div id="chart-4"></div>
						</div>
					</div>
					
				</div>
			</div>

			<div class="row">
				<div class="col-lg-4 col-xl-4">
					<div class="card card-custom gutter-b bg-white border-0" >
						<div class="card-header align-items-center  border-0">
							<div class="card-title mb-0">
								<h3 class="card-label mb-0 font-weight-bold text-body">Langganan Aktif
								</h3>
							</div>
						</div>
						<div class="card-body" >
							<div class="col-md-12">
								<div class="dx-viewport demo-container">
									<div id="data-grid-demo">
										<div id="gridHampirHabis"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-lg-4 col-xl-4">
					<div class="card card-custom gutter-b bg-white border-0" >
						<div class="card-header align-items-center  border-0">
							<div class="card-title mb-0">
								<h3 class="card-label mb-0 font-weight-bold text-body">Langganan Berakhir
								</h3>
							</div>
						</div>
						<div class="card-body" >
							<div class="col-md-12">
								<div class="dx-viewport demo-container">
									<div id="data-grid-demo">
										<div id="gridHabis"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-lg-4 col-xl-4">
					<div class="card card-custom gutter-b bg-white border-0" >
						<div class="card-header align-items-center  border-0">
							<div class="card-title mb-0">
								<h3 class="card-label mb-0 font-weight-bold text-body">Daftar Belum Bayar
								</h3>
							</div>
						</div>
						<div class="card-body" >
							<div class="col-md-12">
								<div class="dx-viewport demo-container">
									<div id="data-grid-demo">
										<div id="gridBelumBayar"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-lg-6 col-xl-6">
					<div class="card card-custom gutter-b bg-white border-0" >
						<div class="card-header align-items-center  border-0">
							<div class="card-title mb-0">
								<h3 class="card-label mb-0 font-weight-bold text-body">Pengguna Per Jenis Usaha
								</h3>
							</div>
						</div>
						<div class="card-body" >
							<div class="col-md-12">
								<div class="dx-viewport demo-container">
									<div id="data-grid-demo">
										<div id="gridPenggunaPerJenisUsaha"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-lg-6 col-xl-6">
					<div class="card card-custom gutter-b bg-white border-0" >
						<div class="card-header align-items-center  border-0">
							<div class="card-title mb-0">
								<h3 class="card-label mb-0 font-weight-bold text-body">Grafik Pengguna Per Jenis Usaha
								</h3>
							</div>
						</div>
						<div class="card-body pt-3" >
							<div id="grafikPenggunaPerJenisUsaha"></div>
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
		var DataGrafikPenjualan = <?php echo $grafikpenjualan; ?>;
		var grafikPJTanggal = [];
        var grafikPJData = [];

        for (let index = 0; index < DataGrafikPenjualan.length; index++) {
            grafikPJTanggal.push(DataGrafikPenjualan[index]["Tanggal"]);
            grafikPJData.push(DataGrafikPenjualan[index]["Total"]);
        }
		let chartData = @json($companyPerJenis);

        let labels = chartData.map(item => item.JenisUsaha);
        let series = chartData.map(item => item.jumlah);

		generateGraph(grafikPJTanggal, grafikPJData);
		bindGridHampirHabis(<?php echo $subshampirhabis; ?>);
		bindGridHabis(<?php echo $subshabis; ?>);
		bindGridBelumBayar(<?php echo $daftarbelumbayar; ?>);
		bindGridPerJenisUsaha(<?php echo $companyPerJenis; ?>);

		generatePenjualanPerUsaha(labels, series);
	});

	function bindGridHampirHabis(data) {
        jQuery("#gridHampirHabis").dxDataGrid({
            allowColumnResizing: true,
            dataSource: data,
            keyExpr: "NamaPartner",
            showBorders: true,
            allowColumnResizing: true,
            columnAutoWidth: true,
            showBorders: true,
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
                    dataField: "NamaPartner",
                    caption: "Partner",
                    allowEditing:false,
                },
                {
                    dataField: "NoTlp",
                    caption: "Phone",
                    allowEditing:false,
                },
                {
                    dataField: "email",
                    caption: "email",
                    allowEditing:false,
                },
				{
					dataField: "EndSubs",
					caption: "Tgl. Selesai",
					allowEditing: false
				}
            ]
        }).dxDataGrid('instance');
    }

	function bindGridHabis(data) {
        jQuery("#gridHabis").dxDataGrid({
            allowColumnResizing: true,
            dataSource: data,
            keyExpr: "NamaPartner",
            showBorders: true,
            allowColumnResizing: true,
            columnAutoWidth: true,
            showBorders: true,
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
                    dataField: "NamaPartner",
                    caption: "Partner",
                    allowEditing:false,
                },
                {
                    dataField: "NoTlp",
                    caption: "Phone",
                    allowEditing:false,
                },
                {
                    dataField: "email",
                    caption: "email",
                    allowEditing:false,
                },
            ]
        }).dxDataGrid('instance');
    }

	function bindGridBelumBayar(data) {
        jQuery("#gridBelumBayar").dxDataGrid({
            allowColumnResizing: true,
            dataSource: data,
            keyExpr: "NamaPartner",
            showBorders: true,
            allowColumnResizing: true,
            columnAutoWidth: true,
            showBorders: true,
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
                    dataField: "NamaPartner",
                    caption: "Partner",
                    allowEditing:false,
                },
                {
                    dataField: "NoTlp",
                    caption: "Phone",
                    allowEditing:false,
                },
                {
                    dataField: "email",
                    caption: "email",
                    allowEditing:false,
                },
            ]
        }).dxDataGrid('instance');
    }

	function bindGridPerJenisUsaha(data) {
        jQuery("#gridPenggunaPerJenisUsaha").dxDataGrid({
            allowColumnResizing: true,
            dataSource: data,
            keyExpr: "JenisUsaha",
            showBorders: true,
            allowColumnResizing: true,
            columnAutoWidth: true,
            showBorders: true,
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
                    dataField: "JenisUsaha",
                    caption: "Jenis Usaha",
                    allowEditing:false,
                },
                {
                    dataField: "jumlah",
                    caption: "Jumlah",
                    allowEditing:false,
					format: { type: 'fixedPoint', precision: 2 },
                }
            ]
        }).dxDataGrid('instance');
    }

	function generateGraph(label, value) {
        
        var options = {
			series: [{
				name: 'Omzet',
				data: value
			}],
			chart: {
				height: 350,
				type: 'line',
			},
			stroke: {
				width: 7,
				curve: 'smooth'
			},
			xaxis: {
				type: 'date',
				categories: label,
			},
			title: {
				text: 'Daily Sales',
				align: 'left',
				style: {
					fontSize: "16px",
					color: '#666'
				}
			},
			fill: {
				type: 'gradient',
				gradient: {
					shade: 'dark',
					gradientToColors: [ '#FDD835'],
					shadeIntensity: 1,
					type: 'horizontal',
					opacityFrom: 1,
					opacityTo: 1,
					stops: [0, 100, 100, 100]
				},
			},
			markers: {
				size: 4,
				colors: ["#FFA41B"],
				strokeColors: "#fff",
				strokeWidth: 2,
				hover: {
					size: 7,
				}
			},
			yaxis: {
				title: {
					text: 'Penjualan',
				},
			}
		};
		var chart = new ApexCharts(document.querySelector("#chart-4"), options);
		chart.render();
    }
	function generatePenjualanPerUsaha(label, value) {
		let options = {
            chart: {
                type: 'donut',
                height: 350
            },
            labels: label,
            series: value,
            legend: {
                position: 'bottom'
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 300
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };

        let chart = new ApexCharts(document.querySelector("#grafikPenggunaPerJenisUsaha"), options);
        chart.render();
	}
</script>
@endpush