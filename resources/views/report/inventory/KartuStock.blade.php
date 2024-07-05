@extends('parts.header')
	
@section('content')

<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">Kartu Stock</li>
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
			<div class="col-12 px-4">
				<div class="row">
					<div class="col-lg-12 col-xl-12 px-4">
						<div class="card card-custom gutter-b bg-transparent shadow-none border-0" >
							<div class="card-header align-items-center  border-bottom-dark px-0">
								<div class="card-title mb-0">
									<h3 class="card-label mb-0 font-weight-bold text-body">Kartu Stock 
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
                                <form action="{{ route('report-kartustock') }}">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label  class="text-body">Tanggal Awal</label>
                                            <input type="date" name="TglAwal" id="TglAwal" class="form-control">
                                        </div>
                                        <div class="col-md-3">
                                            <label  class="text-body">Tanggal Akhir</label>
                                            <input type="date" name="TglAkhir" id="TglAkhir" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label  class="text-body">Barang</label>
											<select name="KodeItem" id="KodeItem" class="js-example-basic-single js-states form-control bg-transparent" >
												<option value="">Pilih barang</option>
												@foreach($itemmaster as $ko)
													<option value="{{ $ko->KodeItem }}" {{ $ko->KodeItem == $oldKodeItem ? 'selected' : '' }}>
			                                            {{ $ko->KodeItem ." - ".$ko->NamaItem }}
			                                        </option>
												@endforeach
												
											</select>
                                        </div>
                                        <div class="col-md-12">
											<!-- <label  class="text-body">Status User</label> -->
											<br>
											<button type="submit" class="btn btn-danger text-white font-weight-bold me-1 mb-1">Cari Data</button>
										</div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
				<div class="row">

					<div class="col-12  px-4">
						<div class="card card-custom gutter-b bg-white border-0" >
							<div class="card-body" >
								<div class="table-responsive" id="printableTable">
									<table id="orderTable" class="display" style="width:100%">
										<thead>
											<tr>
                                                <th>Order</th>
												<th>Nomor</th>
                                                <th>Tanggal</th>
                                                <th>Nama Item</th>
                                                <th>Keterangan</th>
                                                <th>IN</th>
                                                <th>OUT</th>
                                                <th>Saldo Akhir</th>
											</tr>
										</thead>
										<tbody>
											@php
                                                $SaldoAkhir = 0;
                                            @endphp

                                            @foreach ($kartustock as $item)
                                                @if ($item->KodeItem == "SALDO AWAL")
                                                    <tr>
                                                        <th>{{ $item->LineNum }}</th>
                                                        <td>{{ $item->KodeItem }}</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td >{{ number_format($item->QtyIN) }}</td>
                                                    </tr>
                                                    @php
                                                        $SaldoAkhir += $item->QtyIN;
                                                    @endphp
                                                @else
                                                    @php
                                                        $SaldoAkhir += $item->QtyIN - $item->QtyOut;
                                                    @endphp
                                                    <tr>
                                                        <th>{{ $item->LineNum }}</th>
                                                        <td>{{$item->NoTransaksi}}</td>
                                                        <td>{{$item->Tanggal}}</td>
                                                        <td>{{$item->NamaItem}}</td>
                                                        <td>{{$item->Keterangan}}</td>
                                                        <td>{{ number_format($item->QtyIN) }}</td>
                                                        <td>{{ number_format($item->QtyOut) }}</td>
                                                        <td>{{ number_format($SaldoAkhir) }}</td>
                                                    </tr>
                                                @endif
                                            @endforeach
										</tbody>
									</table>
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
<script src="{{asset('api/datatable/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('api/datatable/buttons.html5.min.js')}}"></script>
<script src="{{asset('api/datatable/jszip.min.js')}}"></script>
<script src="{{asset('api/datatable/pdfmake.min.js')}}"></script>
<script src="{{asset('api/datatable/vfs_fonts.js')}}"></script>

<script type="text/javascript">
	jQuery(document).ready(function() {
        var now = new Date();
    	var day = ("0" + now.getDate()).slice(-2);
    	var month = ("0" + (now.getMonth() + 1)).slice(-2);
    	var firstDay = now.getFullYear()+"-"+month+"-01";
    	var NowDay = now.getFullYear()+"-"+month+"-"+day;

    	jQuery('#TglAwal').val(firstDay);
    	jQuery('#TglAkhir').val(NowDay);

		var table = jQuery('#orderTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fas fa-file-pdf"></i> Export to PDF',
                    className: 'btn btn-primary',
                    title: 'Laporan Kartu Stock',
                    messageTop: 'Laporan kartu Stock Periode ' + jQuery('#TglAwal').val() + " s/d "+ jQuery('#TglAkhir').val(),
                    exportOptions: {
                        columns: ':visible'
                    },
                }
            ],
			"pagingType": "simple_numbers",
            "columnDefs": [{
                "targets"  : 'no-sort',
                "orderable": false,
            }],

		});
        table.column(0).visible(false);
	} );
</script>
@endpush