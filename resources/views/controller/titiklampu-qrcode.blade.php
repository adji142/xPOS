@extends('parts.header')

@section('content')
<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">
                    <a href="{{ route('titiklampu') }}">Titik Lampu</a>
                </li>
				<li class="breadcrumb-item active" aria-current="page">QR Codes</li>
			</ol>
		</nav>
	</div>
</div>

<div class="d-flex flex-column-fluid">
	<div class="container-fluid">
		<div class="card card-custom gutter-b bg-white border-0">
			<div class="card-header align-items-center border-bottom-dark px-4">
				<div class="card-title mb-0">
					<h3 class="card-label mb-0 font-weight-bold text-body">Download QR Codes</h3>
				</div>
                <div class="icons d-flex">
                    <button onclick="window.print()" class="btn btn-primary rounded-pill font-weight-bold">Print QR Codes</button>
                </div>
			</div>
			<div class="card-body">
				<div class="row">
                    @foreach($titiklampu as $v)
                    <div class="col-md-3 mb-5 text-center p-5 border">
                        <h4 class="font-weight-bold">{{ $v->NamaTitikLampu }}</h4>
                        <div class="d-flex justify-content-center my-3">
                            {!! QrCode::size(200)->generate(url('/emenu/' . base64_encode($v->id) . '/' . base64_encode($v->RecordOwnerID))) !!}
                        </div>
                        <p class="text-muted small">Scan to Order</p>
                    </div>
                    @endforeach
                </div>
			</div>
		</div>
	</div>
</div>

<style type="text/css">
    @media print {
        .subheader, .card-header, .btn, .footer, .aside {
            display: none !important;
        }
        .card {
            border: none !important;
            box-shadow: none !important;
        }
        .container-fluid {
            padding: 0 !important;
        }
        .col-md-3 {
            width: 50% !important;
            float: left !important;
            page-break-inside: avoid !important;
        }
    }
</style>
@endsection
