@extends('partadmin.headeradmin')
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

		generateGraph(grafikPJTanggal, grafikPJData);
	});

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
</script>
@endpush