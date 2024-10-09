@extends('parts.header')
	
@section('content')

<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">Generate Harga Jual</li>
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
									<h3 class="card-label mb-0 font-weight-bold text-body">Harga Jual 
									</h3>
								</div>
								<div class="icons d-flex">
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
								<div class="row">
									<div class="col-md-3">
										<label  class="text-body">Jenis Item</label>
										<select name="KodeJenis" id="KodeJenis" class="js-example-basic-single js-states form-control bg-transparent" >
											<option value="">Pilih Jenis Item</option>
											@foreach($jenisitem as $ko)
												<option value="{{ $ko->KodeJenis }}">
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
												<option value="{{ $ko->KodeMerk }}">
		                                            {{ $ko->NamaMerk }}
		                                        </option>
											@endforeach
											
										</select>
									</div>
									<div class="col-md-3">
										<label  class="text-body">Status Item</label>
										<select name="Active" id="Active" class="js-example-basic-single js-states form-control bg-transparent">
											<option value="">Pilih Status</option>
											<option value="Y">Aktif</option>
											<option value="N">Tidak Aktif</option>
											
										</select>
									</div>
									<div class="col-md-3">
										<!-- <label  class="text-body">Status User</label> -->
										<br>
										<button type="submit" class="btn btn-danger text-white font-weight-bold me-1 mb-1" id="btFilter">Cari Data</button>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-12  px-4">
						<div class="card card-custom gutter-b bg-white border-0" >
							<div class="card-header" >
								Mark Up Harga Jual Berdasarkan
							</div>
							<div class="card-body" >
								<div class="row">
									<div class="col-md-3">
										<label  class="text-body">Prosentase</label>
										<input type="number" class="form-control" id="Prosentase" name="Prosentase" placeholder=" Prosentase" value="0.0" step="0.01">
									</div>
									<div class="col-md-3">
										<label  class="text-body">Nominal</label>
										<input type="number" class="form-control" id="Nominal" name="Nominal" placeholder=" Nominal" value="0.0" step="0.01">
									</div>
									<div class="col-md-3">
										<!-- <label  class="text-body">Status User</label> -->
										<br>
										<button type="button" class="btn btn-danger text-white font-weight-bold me-1 mb-1" id="kalkulasi">Hitung Simulasi</button>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-12  px-4">
						<div class="card card-custom gutter-b bg-white border-0" >
							<div class="card-body" >
								<div class="dx-viewport demo-container">
				                	<div id="data-grid-demo">
				                  		<div id="gridContainerItem"></div>
				                	</div>
				              	</div>
							</div>
						</div>
					</div>

					<div class="col-12  px-4">
						<button type="button" class="btn btn-success text-white font-weight-bold me-1 mb-1" id="btSaveHarga">Simpan</button>
					</div>
				</div>
			</div>
			
		</div>
	</div>
	
</div>

@endsection

@push('scripts')
<script type="text/javascript">
	var xData = [];
	jQuery(document).ready(function() {
		jQuery('#orderTable').DataTable({
			"pagingType": "simple_numbers",
	  
			"columnDefs": [ {
			  "targets"  : 'no-sort',
			  "orderable": false,
			}]
		});
		// bindGrid([])
		GenerateData()
	});

	jQuery('#kalkulasi').click(function () {

		var dataGridInstance = jQuery('#gridContainerItem').dxDataGrid('instance');
        var selectedRowsData = dataGridInstance.getSelectedRowsData();

        if (selectedRowsData.length == 0) {
        	Swal.fire({
        		icon: 'error',
            	type: 'error',
            	title: 'Woops...',
            	text: "Belum ada Data yang dipilih",
              // footer: '<a href>Why do I have this issue?</a>'
            });
            return;
        }

        var totalValidasi = parseFloat(jQuery('#Prosentase').val()) + parseFloat(jQuery('#Nominal').val());
        if (totalValidasi == 0) {
        	Swal.fire({
        		icon: 'error',
            	type: 'error',
            	title: 'Woops...',
            	text: "Dasar perhitungan Kosong",
              // footer: '<a href>Why do I have this issue?</a>'
            });
            return;
        }

        for (var x = 0; x < xData.length; x++) {
        	if (parseFloat(xData[x]['HargaBeliTerakhir']) == 0) {
        		xData[x]['HargaBeliTerakhir'] = 0;
	    		xData[x]['HargaJualBaru'] = 0;
	    		xData[x]['Margin'] = 0;
        	}
        }

        console.log(xData)
        selectedRowsData.forEach(rowData =>{
        	if (parseFloat(rowData.HargaBeliTerakhir) == 0 && parseFloat(jQuery('#Prosentase').val()) > 0) {
        		Swal.fire({
	        		icon: 'error',
	            	type: 'error',
	            	title: 'Woops...',
	            	text: "Harga Beli Kosong, Silahkan Isi Dasar Perhitungan Nominal",
	              // footer: '<a href>Why do I have this issue?</a>'
	            }).then((result)=>{
                    jQuery('#Prosentase').val("0.0")
	            	jQuery('#Nominal').focus()
	            	return;
                });
        	}

        	for (var i = 0; i < xData.length; i++) {

        		console.log(xData[i]['KodeItem'] + " >> " + rowData.KodeItem)

        		if (xData[i]['KodeItem'] == rowData.KodeItem) {

        			if (parseFloat(rowData.HargaBeliTerakhir) == 0) {
		        		xData[i]['HargaBeliTerakhir'] = parseFloat(jQuery('#Nominal').val());
		        		xData[i]['HargaJualBaru'] = parseFloat(jQuery('#Nominal').val());
		        		xData[i]['Margin'] = 0
		        		// dataGridInstance.cellValue(rowData,"HargaBeliTerakhir", jQuery('#Nominal').val())
		        		// dataGridInstance.saveEditData()
		        	}
		        	else{
		        		if (parseFloat(jQuery('#Prosentase').val()) > 0 ) {
		        			var Margin = parseFloat(jQuery('#Prosentase').val()) / 100 * parseFloat(xData[i]['HargaBeliTerakhir']);
		        			console.log(Margin)
			        		xData[i]['HargaJualBaru'] = parseFloat(xData[i]['HargaBeliTerakhir']) + Margin
			        		xData[i]['Margin'] = parseFloat(xData[i]['HargaBeliTerakhir']) + Margin - parseFloat(xData[i]['HargaBeliTerakhir'])
		        		}
		        		else if (parseFloat(jQuery('#Prosentase').val()) > 0) {
		        			xData[i]['HargaJualBaru'] = parseFloat(xData[i]['HargaBeliTerakhir']) + parseFloat(jQuery('#Nominal').val())
			        		xData[i]['Margin'] = parseFloat(xData[i]['HargaBeliTerakhir']) + parseFloat(jQuery('#Nominal').val()) - parseFloat(xData[i]['HargaBeliTerakhir'])
		        		}
		        	}
        		}
        	}
        });
        // dataGridInstance.refresh()
        // console.log(xData)
        bindGrid(xData)
	});

	jQuery('#btSaveHarga').click(function () {

		jQuery('#btSaveHarga').text('Tunggu Sebentar');
		jQuery('#btSaveHarga').attr('disabled',true);

		var oData = [];

		var dataGridInstance = jQuery('#gridContainerItem').dxDataGrid('instance');
        var allRowsData  = dataGridInstance.getDataSource().items();

        for (var i = 0; i < allRowsData.length; i++) {
        	if (parseFloat(allRowsData[i]['HargaJualBaru']) > 0) {
        		var temp = {
        			'KodeItem' : allRowsData[i]['KodeItem'],
        			'HargaJual' : allRowsData[i]['HargaJualBaru'],
        			'TipeMarkUp'  :''
        		}
        		oData.push(temp)
        	}
        }

		$.ajax({
      		async:false,
      		type: 'post',
			url: "{{route('hargajual-store')}}",
			contentType: 'application/json',
			headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
            },
            data: JSON.stringify(oData),
            success: function(response) {
            	if (response.success == true) {
            		Swal.fire({
                        html: "Data berhasil disimpan!",
                        icon: "success",
                        title: "Horray...",
                        // text: "Data berhasil disimpan! <br> " + response.Kembalian,
                    }).then((result)=>{
                        jQuery('#btSaveHarga').text('Save');
                        jQuery('#btSaveHarga').attr('disabled',false);
                        // location.reload();
                        window.location.href = '{{url("hargajual")}}';
                    });
            	}
            	else{
            		Swal.fire({
                      icon: "error",
                      title: "Opps...",
                      text: response.message,
                    })
                    jQuery('#btSaveHarga').text('Save');
                    jQuery('#btSaveHarga').attr('disabled',false);
            	}
            }
		})
	});

	jQuery('#btFilter').click(function () {
		GenerateData()
	})

	function GenerateData() {
		jQuery('#btFilter').text('Tunggu Sebentar');
		jQuery('#btFilter').attr('disabled',true);

		$.ajax({
      		async:false,
      		type: 'post',
			url: "{{route('itemmaster-ViewJson')}}",
			headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
            },
            data: {
            	'KodeJenis' : jQuery('#KodeJenis').val(),
            	'Merk' : jQuery('#Merk').val(),
            	'Active' :jQuery('#Active').val()
            },
            dataType: 'json',
            success: function(response) {
            	xData = response.data
            	bindGrid(xData)

            	jQuery('#btFilter').text('Cari Data');
				jQuery('#btFilter').attr('disabled',false);
            }
		})
	}

	function bindGrid(data) {
		// console.log(oItem)
		var dataGridInstance = jQuery("#gridContainerItem").dxDataGrid({
			allowColumnResizing: true,
			dataSource: data,
			keyExpr: "KodeItem",
			showBorders: true,
            allowColumnReordering: true,
            allowColumnResizing: true,
            columnAutoWidth: true,
            showBorders: true,
            paging: {
                enabled: true,
                pageSize: 30
            },
            editing: {
                mode: "row",
                texts: {
                    confirmDeleteMessage: ''  
                }
            },
            selection:{
            	mode:'multiple'
            },
            columns: [
                {
                    dataField: "KodeItem",
                    caption: "Kode Bahan",
                    allowEditing:false
                },
                {
                    dataField: "NamaItem",
                    caption: "Nama Bahan",
                    allowEditing:false
                },
                {
                    dataField: "HargaPokokPenjualan",
                    caption: "HPP",
                    allowEditing:false,
                    format: { type: 'fixedPoint', precision: 2 }
                },
                {
                    dataField: "HargaBeliTerakhir",
                    caption: "Harga Beli Terakhir",
                    allowEditing:false,
                    format: { type: 'fixedPoint', precision: 2 }
                },
                {
                    dataField: "HargaJual",
                    caption: "Harga Jual Lama",
                    allowEditing:false,
                    format: { type: 'fixedPoint', precision: 2 }
                },
                {
                    dataField: "Margin",
                    caption: "Margin",
                    allowEditing:false,
                    format: { type: 'fixedPoint', precision: 2 }
                },
                {
                    dataField: "HargaJualBaru",
                    caption: "Harga Jual Baru",
                    allowEditing:false,
                    format: { type: 'fixedPoint', precision: 2 }
                },
            ],
            onRowInserted(e) {
		    	e.component.navigateToRow(e.key);
		    },
			// onDataErrorOccurred(e){
			// 	console.log(e)
			// }
		}).dxDataGrid('instance');
	}
</script>
@endpush