@extends('parts.header')
	
@section('content')

<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">Item Master</li>
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
									<h3 class="card-label mb-0 font-weight-bold text-body">Item Master 
									</h3>
								</div>
							    <div class="icons d-flex">
									<a href="{{ url('itemmaster/form/-') }}" class="btn btn-outline-primary rounded-pill font-weight-bold me-1 mb-1">Tambah Data</a>
									<a href="{{ url('companysetting#bulkaction') }}" class="btn btn-outline-warning rounded-pill font-weight-bold me-1 mb-1">Import Data</a>
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
								<form action="{{ route('itemmaster') }}">
									<div class="row">
										<div class="col-md-3">
											<label  class="text-body">Jenis Item</label>
											<select name="KodeJenis" id="KodeJenis" class="js-example-basic-single js-states form-control bg-transparent" >
												<option value="">Pilih Jenis Item</option>
												@foreach($jenisitem as $ko)
													<option value="{{ $ko->KodeJenis }}" {{ $ko->id == $oldKodeJenis ? 'selected' : '' }}>
			                                            {{ $ko->NamaJenis }}
			                                        </option>
												@endforeach
												
											</select>
										</div>
										<div class="col-md-3">
											<label  class="text-body">Merk</label>
											<select name="merk" id="merk" class="js-example-basic-single js-states form-control bg-transparent" >
												<option value="">Pilih Merk</option>
												@foreach($merk as $ko)
													<option value="{{ $ko->KodeMerk }}" {{ $ko->id == $oldMerk ? 'selected' : '' }}>
			                                            {{ $ko->NamaMerk }}
			                                        </option>
												@endforeach
												
											</select>
										</div>
										<div class="col-md-3">
											<label  class="text-body">Status Item</label>
											<select name="Active" id="Active" class="js-example-basic-single js-states form-control bg-transparent">
												<option value="" {{ ($oldActive) == '' ? 'selected' : '' }}>Pilih Status</option>
												<option value="Y" {{ ($oldActive) == 'Y' ? 'selected' : '' }}>Aktif</option>
												<option value="N" {{ ($oldActive) == 'N' ? 'selected' : '' }}>Tidak Aktif</option>
												
											</select>
										</div>
										<div class="col-md-12">
											<!-- <label  class="text-body">Status User</label> -->
											<br>
											<button type="submit" class="btn btn-danger text-white font-weight-bold me-1 mb-1">Cari Data</button>
											<a href="{{ route('report-generatebarcode') }}" class="btn btn-success text-white font-weight-bold me-1 mb-1">Cetak Barcode</a>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>

					<div class="col-12  px-4">
						<div class="card card-custom gutter-b bg-white border-0" >
							<div class="card-body" >
								<div id="GridItemMaster"></div>
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
	var KodeItem = "";
	jQuery(function () {
		jQuery(document).ready(function() {
			var oItem = <?php echo $itemmaster ?>;
			BindGrid(oItem);
		});

		jQuery('#btKartuStock').click(function () {
			var now = new Date();
			var day = ("0" + now.getDate()).slice(-2);
			var month = ("0" + (now.getMonth() + 1)).slice(-2);
			var firstDay = now.getFullYear()+"-"+month+"-01";
			var NowDay = now.getFullYear()+"-"+month+"-"+day;

			if(KodeItem != ""){
				var link = "report/kartustock/"+firstDay+"/"+NowDay+"/"+KodeItem;
				var LinkAccess = "";
			}
			else{
				Swal.fire({
					icon: "error",
					title: "Opps...",
					text: "Silahkan Pilih item terlebih dahulu",
				})
			}
		});

		function BindGrid(data) {
			var dataGridInstance = jQuery("#GridItemMaster").dxDataGrid({
				allowColumnResizing: true,
				dataSource: data,
				keyExpr: "KodeItem",
				showBorders: true,
	            allowColumnResizing: true,
	            columnAutoWidth: true,
	            showBorders: true,
	            paging: {
	                enabled: true,
	                pageSize: 20
	            },
	            editing: {
	                mode: "row",
	                allowUpdating: true,
	                texts: {
	                    confirmDeleteMessage: ''  
	                }
	            },
	            searchPanel: {
	                visible: true,
	                width: 240,
	                placeholder: "Search..."
	            },
	            export: {
	                enabled: true,
	                fileName: "Daftar Item Master"
	            },
	            selection:{
		            mode: "single"
		        },
	            columns: [
	            	{
	                    type: "buttons",
	                    buttons: ["edit", "delete"],
	                    visible: true,
	                    fixed: true,
	                },
	            	{
	                    dataField: "KodeItem",
	                    caption: "Kode Item",
	                    allowEditing:false, 
	                },
	                {
	                    dataField: "NamaItem",
	                    caption: "Nama Item",
	                    allowEditing:false, 
	                },
	                {
	                    dataField: "Barcode",
	                    caption: "Barcode",
	                    allowEditing:false, 
	                },
	                {
	                    dataField: "HargaJual",
	                    caption: "Harga Jual",
	                    allowEditing:false, 
	                    format: { type: 'fixedPoint', precision: 2 },
	                },
	                {
	                    dataField: "HargaPokokPenjualan",
	                    caption: "HPP",
	                    allowEditing:false, 
	                    format: { type: 'fixedPoint', precision: 2 },
	                },
	                {
	                    dataField: "HargaBeliTerakhir",
	                    caption: "Harga Beli Terakhir",
	                    allowEditing:false, 
	                    format: { type: 'fixedPoint', precision: 2 },
	                },
	                {
	                    dataField: "Stock",
	                    caption: "Stock",
	                    allowEditing:false, 
	                    format: { type: 'fixedPoint', precision: 2 },
	                },
	                {
	                    dataField: "StockMinimum",
	                    caption: "Min Stock",
	                    allowEditing:false, 
	                    format: { type: 'fixedPoint', precision: 2 },
	                },
	                {
	                    dataField: "NamaJenis",
	                    caption: "Jenis Item",
	                    allowEditing:false, 
	                },
	                {
	                    dataField: "NamaMerk",
	                    caption: "Merk",
	                    allowEditing:false, 
	                },
                    {
	                    dataField: "TampilkanEMenu",
	                    caption: "E-Menu",
	                    allowEditing:false,
                        cellTemplate: function(container, options) {
                            if (options.value == "1") {
                                container.text("YES");
                            } else {
                                container.text("NO");
                            }
                        }
	                },
	                {
	                    dataField: "Rak",
	                    caption: "Rak",
	                    allowEditing:false, 
	                },
	                {
	                    dataField: "ItemType",
	                    caption: "Item Type",
	                    allowEditing:false, 
	                },
	            ],
	            onEditingStart: function(e) {
	                var baseUrl = "{{ url('/') }}";

	                location.replace(baseUrl + '/itemmaster/form/'+e.data.KodeItem);
	            },
				onRowClick: function(e) {
					const rowElement = e.component.getRowElement(e.rowIndex);
					rowElement.addClass('row-highlight');

					KodeItem = e.data.KodeItem;
				}
			})
		}
	})
</script>
@endpush