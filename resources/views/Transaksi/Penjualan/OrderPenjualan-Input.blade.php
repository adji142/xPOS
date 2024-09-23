@extends('parts.header')
	
@section('content')

<!--begin::Subheader-->
<style>
/* Style for text alignment */
.aligned-textbox {
    text-align: right; /* Change 'center' to 'left' or 'right' for different alignments */
}
</style>
<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">
					<a href="{{route('openjualan')}}">Daftar Order Penjualan</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Order Penjualan</li>
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
									<h3 class="card-label mb-0 font-weight-bold text-body">
										@if (count($orderheader) > 0)
											<input type="hidden" name="formtype" id="formtype" value="edit">
                                    		Edit Order Penjualan
	                                	@else
	                                		<input type="hidden" name="formtype" id="formtype" value="add">
	                                    	Tambah Order Penjualan
	                                	@endif
									</h3>
								</div>
							</div>
						
						</div>


					</div>
				</div>

				<div class="row">
					<div class="col-12  px-4">
						<div class="card card-custom gutter-b bg-white border-0" >
							<div class="card-body" >
                            	<div class="form-group row">
                            		<div class="col-md-2">
                            			<label  class="text-body">No Transaksi (*)</label>
                            			<fieldset class="form-group mb-3">
                            				<input type="text" class="form-control" id="NoTransaksi" name="NoTransaksi" placeholder="<Auto>" value="{{ count($orderheader) > 0 ? $orderheader[0]['NoTransaksi'] : '' }}" required="">
                            			</fieldset>
                            			
                            		</div>

                            		<div class="col-md-3">
                            			<label  class="text-body">Status</label>
                            			<fieldset class="form-group mb-3">
                            				<select name="Status" id="Status" class="js-example-basic-single js-states form-control bg-transparent" >
												<option value="O" {{ count($orderheader) > 0 ? $orderheader[0]['Status'] == 'O' ? "selected" : '' :""}} >OPEN</option>
												<option value="C" {{ count($orderheader) > 0 ? $orderheader[0]['Status'] == 'C' ? "selected" : '' :""}} >CLOSE</option>
												<option value="D" {{ count($orderheader) > 0 ? $orderheader[0]['Status'] == 'D' ? "selected" : '' :""}}>CANCEL</option>
												
											</select>
                            			</fieldset>
                            		</div>

                            		<div class="col-md-3">
                            			<label  class="text-body">Pelanggan</label>
                            			<fieldset class="form-group mb-3">
                            				<select name="KodePelanggan" id="KodePelanggan" class="js-example-basic-single js-states form-control bg-transparent" >
												<option value="-1">Pilih Pelanggan</option>
												@foreach($pelanggan as $ko)
													<option 
                                                        value="{{ $ko->KodePelanggan }}"
                                                        {{ count($orderheader) > 0 ? $orderheader[0]['KodePelanggan'] == $ko->KodePelanggan ? "selected" : '' :""}}
                                                    >
                                                        {{ $ko->NamaPelanggan }}
                                                    </option>
												@endforeach
												
											</select>
                            			</fieldset>
                            		</div>

                            		<div class="col-md-3">
                            			<label  class="text-body">Termin</label>
                            			<fieldset class="form-group mb-3">
                            				<select name="KodeTermin" id="KodeTermin" class="js-example-basic-single js-states form-control bg-transparent" >
												<option value="-1">Pilih Termin</option>
												@foreach($termin as $ko)
													<option 
                                                        value="{{ $ko->id }}"
                                                        {{ count($orderheader) > 0 ? $orderheader[0]['KodeTermin'] == $ko->id ? "selected" : '' :""}}
                                                    >
                                                        {{ $ko->NamaTermin }}
                                                    </option>
												@endforeach
												
											</select>
                            			</fieldset>
                            		</div>

                            		<div class="col-md-3">
                            			<label  class="text-body">Tanggal Transaksi</label>
                            			<fieldset class="form-group mb-3">
                            				<input type="date" class="form-control" id="TglTransaksi" name="TglTransaksi" placeholder="<Auto>" value="{{ count($orderheader) > 0 ? $orderheader[0]['TglTransaksi'] : '' }}" required="">
                            			</fieldset>
                            		</div>

                            		<div class="col-md-3">
                            			<label  class="text-body">Tanggal Jatuh Tempo</label>
                            			<fieldset class="form-group mb-3">
                            				<input type="date" class="form-control" id="TglJatuhTempo" name="TglJatuhTempo" placeholder="<Auto>" value="{{ count($orderheader) > 0 ? $orderheader[0]['TglJatuhTempo'] : '' }}" required="">
                            			</fieldset>
                            		</div>

                            		<div class="col-md-6">
                            			<label  class="text-body">No Reff</label>
                            			<fieldset class="form-group mb-3">
                            				<input type="text" class="form-control" id="NoReff" name="NoReff" placeholder="Masukan No Reff" value="{{ count($orderheader) > 0 ? $orderheader[0]['NoReff'] : '' }}" >
                            			</fieldset>
                            		</div>

                            		<div class="col-md-12">
                            			<label  class="text-body">Keterangan</label>
                            			<fieldset class="form-group mb-3">
                            				<input type="text" class="form-control" id="Keterangan" name="Keterangan" placeholder="Masukan Keterangan" value="{{ count($orderheader) > 0 ? $orderheader[0]['Keterangan'] : '' }}" >
                            			</fieldset>
                            		</div>

                            		<div class="col-md-12">
                            			<div class="dx-viewport demo-container">
						                	<div id="data-grid-demo">
						                  		<div id="gridContainerDetail"></div>
						                	</div>
						              	</div>
						              	<small style="color: red">Tekan Enter saat selesai edit data</small>
                            		</div>

                            		<div class="col-md-7">
                            			
                            		</div>

                            		<div class="col-md-5">
                            			<table>
                            				<tr>
                            					<td>Sub Total</td>
                            					<td>:</td>
                            					<td><input type="text" align="right" name="TotalTransaksi" id="TotalTransaksi" class="form-control aligned-textbox" value="{{ count($orderheader) > 0 ? $orderheader[0]['TotalTransaksi'] : '0' }}" readonly=""></td>
                            				</tr>
                            				<tr>
                            					<td>Diskon</td>
                            					<td>:</td>
                            					<td><input type="text" align="right" name="Potongan" id="Potongan" readonly="" class="form-control aligned-textbox" value="{{ count($orderheader) > 0 ? $orderheader[0]['Potongan'] : '0' }}"></td>
                            				</tr>
                            				<tr>
                            					<td>PPN</td>
                            					<td>:</td>
                            					<td><input type="text" align="right" name="Pajak" id="Pajak" readonly="" class="form-control aligned-textbox" value="{{ count($orderheader) > 0 ? $orderheader[0]['Pajak'] : '0' }}"></td>
                            				</tr>
                            				<tr>
                            					<td>Total</td>
                            					<td>:</td>
                            					<td><input type="text" align="right" name="TotalPenjualan" id="TotalPenjualan" readonly="" class="form-control aligned-textbox" value="{{ count($orderheader) > 0 ? $orderheader[0]['TotalPenjualan'] : '0' }}"></td>
                            				</tr>
                            			</table>
                            		</div>

                            		<div class="col-md-12">
                            			<button type="button" id="btSave" class="btn btn-success text-white font-weight-bold me-1 mb-1">Simpan</button>
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
	// jQuery(document).ready(function() {
	// 	jQuery('.js-example-basic-multiple').select2();
	// });
	var TotalTermin = 0;
	var StatusTransaksi = "O";
	var orderHeader = [];
	jQuery(function () {
		jQuery(document).ready(function() {
			var now = new Date();
	    	var day = ("0" + now.getDate()).slice(-2);
	    	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	    	var firstDay = now.getFullYear()+"-"+month+"-01";
	    	var NowDay = now.getFullYear()+"-"+month+"-"+day;

	    	jQuery('#TglTransaksi').val(NowDay);
	    	jQuery('#TglJatuhTempo').val(NowDay);
	    	// console.log(jQuery('#formtype').val())

	    	orderHeader = <?php echo json_encode($orderheader); ?>;
	    	// console.log(orderHeader)
			if (jQuery('#formtype').val() == "edit") {
				formatCurrency(jQuery('#TotalTransaksi'), orderHeader[0]["TotalTransaksi"]);
	      		formatCurrency(jQuery('#Potongan'), orderHeader[0]["Potongan"]);
	      		formatCurrency(jQuery('#TotalPenjualan'), orderHeader[0]["TotalPenjualan"]);
	      		StatusTransaksi = orderHeader[0]["Status"];

	      		// console.log(StatusTransaksi)
	      		if (StatusTransaksi != "O") {
	      			jQuery('#KodePelanggan').attr('disabled',true);
	      			jQuery('#Status').attr('disabled',true);
	      			jQuery('#KodeTermin').attr('disabled',true);
	      			jQuery('#TglTransaksi').attr('disabled',true);
	      			jQuery('#TglJatuhTempo').attr('disabled',true);
	      			jQuery('#NoReff').attr('disabled',true);
	      			jQuery('#Keterangan').attr('disabled',true);
	      			jQuery('#btSave').attr('disabled',true);
	      		}
	      		BindGridDetail(<?php echo json_encode($orderdetail) ?>);
			}
			else{
				BindGridDetail([])	
			}

		});

		jQuery('#KodeTermin').change(function () {
			var oTermin = <?php echo $termin ?>;

			for (var i = 0; i < oTermin.length; i++) {
				// Things[i]
				if (oTermin[i]["id"] == jQuery('#KodeTermin').val()) {
					TotalTermin = parseFloat(oTermin[i]["JumlahHari"]) + parseFloat(oTermin[i]["ExtraDays"])
					break;
				}
			}

			const dateString = jQuery('#TglTransaksi').val();
			const dateObject = new Date(dateString);

			dateObject.setDate(dateObject.getDate() + TotalTermin);
			var day = ("0" + dateObject.getDate()).slice(-2);
	    	var month = ("0" + (dateObject.getMonth() + 1)).slice(-2);
	    	var NowDay = dateObject.getFullYear()+"-"+month+"-"+day;

			jQuery('#TglJatuhTempo').val(NowDay)

		});

		jQuery('#TglTransaksi').change(function () {
			const dateString = jQuery('#TglTransaksi').val();
			const dateObject = new Date(dateString);

			dateObject.setDate(dateObject.getDate() + TotalTermin);
			var day = ("0" + dateObject.getDate()).slice(-2);
	    	var month = ("0" + (dateObject.getMonth() + 1)).slice(-2);
	    	var NowDay = dateObject.getFullYear()+"-"+month+"-"+day;

			jQuery('#TglJatuhTempo').val(NowDay)
		})

		jQuery('#btSave').click(function () {
			// formatCurrency(jQuery('#TotalTransaksi'));

			jQuery('#btSave').text('Tunggu Sebentar.....');
      		jQuery('#btSave').attr('disabled',true);

      		var dataGridInstance = jQuery('#gridContainerDetail').dxDataGrid('instance');
      		var allRowsData  = dataGridInstance.getDataSource().items();
      		// console.log(allRowsData)
      		var oDetail = [];

      		for (var i = 0; i < allRowsData.length; i++) {
      			// Things[i]
      			if (allRowsData[i]['KodeItem'] != "") {

      				var oItem = {
      					'NoUrut' : allRowsData[i]['NoUrut'],
						'KodeItem' : allRowsData[i]['KodeItem'],
						'Qty' : allRowsData[i]['Qty'],
						'Satuan' : allRowsData[i]['Satuan'],
						'Harga' : allRowsData[i]['Harga'],
						'Discount' : allRowsData[i]['Discount'],
						'HargaNet' : allRowsData[i]['HargaNet'],
						'LineStatus':allRowsData[i]['LineStatus'],
      				}
      				
      				oDetail.push(oItem)
      			}
      		}

			var oData = {
				'NoTransaksi' : jQuery('#NoTransaksi').val(),
				'TglTransaksi' : jQuery('#TglTransaksi').val(),
				'TglJatuhTempo' : jQuery('#TglJatuhTempo').val(),
				'NoReff' : jQuery('#NoReff').val(),
				'KodePelanggan' : jQuery('#KodePelanggan').val(),
				'KodeTermin' : jQuery('#KodeTermin').val(),
				'Termin' : TotalTermin,
				'TotalTransaksi' : jQuery('#TotalTransaksi').attr("originalvalue"),
				'Potongan' : jQuery('#Potongan').attr("originalvalue"),
				'Pajak' : 0,
				'TotalPenjualan' : jQuery('#TotalPenjualan').attr("originalvalue"),
				'TotalRetur' : 0,
				'TotalPembayaran' : 0,
				'Status' : jQuery('#Status').val(),
				'Keterangan' : jQuery('#Keterangan').val(),
				'Detail' : oDetail
			}
			// var originalvalue = jQuery("#TotalTransaksi").attr("originalvalue");

			// console.log(oData)
			if (jQuery('#formtype').val() == "add") {
				$.ajax({
					url: "{{route('openjualan-storeJson')}}",
					type: 'POST',
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
		                        jQuery('#btSave').text('Save');
		                        jQuery('#btSave').attr('disabled',false);
		                        // location.reload();
		                        window.location.href = '{{url("openjualan")}}';
		                    });
		            	}
		            	else{
		            		Swal.fire({
		                      icon: "error",
		                      title: "Opps...",
		                      text: response.message,
		                    })
		                    jQuery('#btSave').text('Save');
		                    jQuery('#btSave').attr('disabled',false);
		            	}
		            }
				})
			}
			else if (jQuery('#formtype').val() == "edit") {
				$.ajax({
					url: "{{route('openjualan-editJson')}}",
					type: 'POST',
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
		                        jQuery('#btSave').text('Save');
		                        jQuery('#btSave').attr('disabled',false);
		                        // location.reload();
		                        window.location.href = '{{url("openjualan")}}';
		                    });
		            	}
		            	else{
		            		Swal.fire({
		                      icon: "error",
		                      title: "Opps...",
		                      text: response.message,
		                    })
		                    jQuery('#btSave').text('Save');
		                    jQuery('#btSave').attr('disabled',false);
		            	}
		            }
				})
			}
			else{
				Swal.fire({
	              icon: "error",
	              title: "Opps...",
	              text: "Invalid Form Type",
	            })
	            jQuery('#btSave').text('Save');
	            jQuery('#btSave').attr('disabled',false);
			}
		})

		function CalculateTotal() {
			var dataGridInstance = jQuery('#gridContainerDetail').dxDataGrid('instance');
      		var allRowsData  = dataGridInstance.getDataSource().items();

      		var TotalTransaksi = 0;
      		var TotalPotongan = 0;
      		var TotalPajak = 0;
      		var TotalNet = 0;
      		for (var i = 0; i < allRowsData.length; i++) {
      			// Things[i]
      			if (allRowsData[i]['KodeItem'] != "") {
      				TotalTransaksi += parseFloat(allRowsData[i]['Qty']) * parseFloat(allRowsData[i]['Harga']);
	      			if (allRowsData[i]['Discount'] > 0) {

	      				var diskon = TotalTransaksi * allRowsData[i]['Discount'] / 100
	      				TotalPotongan += parseFloat(diskon);
	      			}
      			}
      		}

      		formatCurrency(jQuery('#TotalTransaksi'), TotalTransaksi);
      		formatCurrency(jQuery('#Potongan'), TotalPotongan);
      		formatCurrency(jQuery('#TotalPenjualan'), TotalTransaksi - TotalPotongan);
		}

		function isRowEditable(rowData) {
			console.log(rowData);
			var isEditable = true;

			if (rowData.LineStatus == "C") {
				isEditable = false;
			}

		    return isEditable;
		}

		function BindGridDetail(data) {
			var AllowManipulation = true;
			if (StatusTransaksi != "O") {
				AllowManipulation = false;
			}
			// console.log(AllowManipulation)
			var dataGridInstance = jQuery("#gridContainerDetail").dxDataGrid({
				allowColumnResizing: true,
				dataSource: data,
				keyExpr: "NoUrut",
				showBorders: true,
	            allowColumnResizing: true,
	            columnAutoWidth: true,
	            showBorders: true,
	            paging: {
	                enabled: true,
	                pageSize: 30
	            },
	            editing: {
	                mode: "row",
	                // allowAdding:true,
	                allowUpdating: AllowManipulation,
	                allowDeleting: AllowManipulation,
	                texts: {
	                    confirmDeleteMessage: ''  
	                }
	            },
	            columns: [
	            	{
	                    type: "buttons",
	                    buttons: ["edit","delete"],
	                    visible: true,
	                    fixed: true,
	                },
	                {
	                    dataField: "NoUrut",
	                    caption: "#",
	                    allowEditing:false,
	                    allowSorting: false 
	                },
	                {
	                    dataField: "KodeItem",
	                    caption: "Item",
	                    lookup: {
						    dataSource: <?php echo $item ?>,
						    valueExpr: 'KodeItem',
						    displayExpr: 'NamaItem',
					    },
					    width: 350,
					    allowSorting: false,
					    allowEditing:AllowManipulation
	                },
	                {
	                    dataField: "Qty",
	                    caption: "Qty",
	                    allowEditing:AllowManipulation,
	                    format: { type: 'fixedPoint', precision: 2 },
	                    allowSorting: false 
	                },
	                {
	                    dataField: "Satuan",
	                    caption: "Satuan",
	                    // allowEditing:false,
	                    lookup: {
						    dataSource: <?php echo $satuan ?>,
						    valueExpr: 'KodeSatuan',
						    displayExpr: 'NamaSatuan',
					    },
					    allowSorting: false ,
					    allowEditing:AllowManipulation
	                },
	                {
	                    dataField: "Harga",
	                    caption: "Harga",
	                    allowEditing:AllowManipulation,
	                    format: { type: 'fixedPoint', precision: 2 },
	                    allowSorting: false 
	                },
	                {
	                    dataField: "Discount",
	                    caption: "Discount",
	                    allowEditing:AllowManipulation,
	                    format: { type: 'fixedPoint', precision: 2 },
	                    allowSorting: false 
	                },
	                {
	                    dataField: "HargaNet",
	                    caption: "HargaNet",
	                    allowEditing:AllowManipulation,
	                    format: { type: 'fixedPoint', precision: 2 },
	                    calculateCellValue:function (rowData) {
	                    	var HargaNet = 0;
	                    	var HargaGross = 0;
	                    	if (rowData.Discount == 0) {
	                    		HargaNet = rowData.Qty * rowData.Harga;
	                    		HargaGross = rowData.Qty * rowData.Harga;
	                    	}
	                    	else{
	                    		// console.log("HargaGross = " + HargaGross)
	                    		HargaGross = rowData.Qty * rowData.Harga;

	                    		var diskon = HargaGross * rowData.Discount / 100
	                    		// console.log("Diskon = " + diskon)
	                    		HargaNet = HargaGross - diskon;
	                    	}

	                    	return HargaNet
	                    },
	                    allowSorting: false 
	                },
	                {
	                    dataField: "LineStatus",
	                    caption: "LineStatus",
	                    allowEditing:false,
	                    allowSorting: false,
	                    visible:false
	                },
	            ],
			    onContentReady: function(e) {
		            // Trigger edit mode for the first row (index 0) when the grid content is ready
		            // console.log(dataGridInstance.option("dataSource"))
		            var rowData = dataGridInstance.option("dataSource");
		            if (rowData.length == 1) {
		            	// dataGridInstance.editRow(0)	
		            }
		            // dataGridInstance.editRow(0)
		            // dataGridInstance.editRow(0);
		        },
		        onCellClick:function (e) {
		        	// console.log(dataGridInstance.option("dataSource"))
		            var rowData = dataGridInstance.option("dataSource");
		            var columnIndex = e.columnIndex;
		            // console.log(e)
		        	if (columnIndex >= 1 && columnIndex <= 5) {
		                dataGridInstance.editRow(e.rowIndex)	
		            }
		            dataGridInstance.option("focusedColumnIndex", columnIndex);	
		        },
			}).dxDataGrid('instance');

			// console.log(dataGridInstance)

			var xItem = '<?php echo json_encode($item); ?>'
			var oItem = JSON.parse(xItem);

			// dx-link dx-link-edit


			// console.log(dataGridInstance)
			var allRowsData  = dataGridInstance.option("dataSource");
        	var newData = { NoUrut: allRowsData.length + 1,KodeItem:"", Qty: 0, Satuan: "", Harga:0, Discount:0, HargaNet:0 ,LineStatus:"O"}
        	dataGridInstance.option("dataSource", [...dataGridInstance.option("dataSource"), newData]);
        	dataGridInstance.refresh();

        	// Set Editable / Not
        	// console.log(dataGridInstance)
        // 	for (var i = 0; i < allRowsData.length; i++) {
        // 		if (allRowsData[i]['LineStatus'] == "C") {
        // 			var column = dataGridInstance.columns.find(c => c.dataField === "KodeItem");
				    // if (column) {
				    //     column.allowEditing = isEditable;
				    //     $('#gridContainerDetail').dxDataGrid('instance').refresh();
				    // }
        // 		}
        // 	}

        	dataGridInstance.on('rowUpdated', function(e) {
        		var allRowsData  = dataGridInstance.option("dataSource");
        		var blankCount = 0;

        		for (var i = 0; i < allRowsData.length; i++) {
        			if (allRowsData[i]["KodeItem"] == "") {
        				blankCount += 1;
        			}
        		}

        		if (blankCount == 1) {
        			var newData = { NoUrut: allRowsData.length+1,KodeItem:"", Qty: 0, Satuan: "", Harga:0, Discount:0, HargaNet:0,LineStatus:"O" }
					dataGridInstance.option("dataSource", [...dataGridInstance.option("dataSource"), newData]);
					dataGridInstance.refresh();
        		}

        		CalculateTotal();
        	})
        	// Validasi duplicate Row
        	dataGridInstance.on('dataErrorOccurred',function (e) {
			// console.log(e)
				alert("Data Sudah terpakai di baris lain");
				e.error.message = "Data Sudah terpakai di baris lain";
				e.error.url = "";
				dataGridInstance.refresh();
				dataGridInstance.cancelEditData();
				// SetEnableCommand();
			});

        	dataGridInstance.on('editorPreparing',function (e) {

				if (e.parentType === "dataRow" && e.dataField === "KodeItem") {
					var isEditable = isRowEditable(e.row.data);
    				e.editorOptions.disabled = !isEditable;

			        e.editorOptions.onFocusOut = (x) => {
			            // same here
			            var rowIndex = dataGridInstance.getRowIndexByKey(e.row.key);
			            var allRowsData  = dataGridInstance.getDataSource().items();

			            var Satuan = "";
			            var HargaJual = 0;
			            for (var i = 0; i < oItem.length; i++) {
			            	// console.log(oItem[i].KodeItem + " == " +e.row.cells[1].value);
			            	// console.log(e.row.values)
			            	if (oItem[i].KodeItem == e.row.cells[1].value) {
			            		Satuan = oItem[i].Satuan;
			            		HargaJual = oItem[i].HargaJual;
			            		break;
			            	}
			            }

			            // x.component.option("value", "Test2");
			            // console.log(e.row.cells[0].value)
			            // console.log(selectedItem)
			            if (jQuery("#formtype").val() == "add") {
			            	dataGridInstance.cellValue(rowIndex, "Qty", 1);
				            dataGridInstance.cellValue(rowIndex, "Harga", HargaJual);
				            dataGridInstance.cellValue(rowIndex, "Discount", 0);
				            dataGridInstance.cellValue(rowIndex, "HargaNet", 0);
				            dataGridInstance.cellValue(rowIndex, "Satuan", Satuan);
				            // dataGridInstance.cellValue(rowIndex, "Qty", 1);

				            dataGridInstance.refresh()
			            }

	                    dataGridInstance.saveEditData();
	                    
	                    var newData = { NoUrut: allRowsData.length+1,KodeItem:"", Qty: 0, Satuan: "", Harga:0, Discount:0, HargaNet:0,LineStatus:"O" }
						dataGridInstance.option("dataSource", [...dataGridInstance.option("dataSource"), newData]);
						dataGridInstance.refresh();
			        }
			        e.editorOptions.onFocusIn = (x) => {


			        }
			    }
			    else if (e.parentType === "dataRow" && e.dataField === "Qty") {
			    	var isEditable = isRowEditable(e.row.data);
    				e.editorOptions.disabled = !isEditable;
			    	e.editorOptions.onFocusOut = (x) => {
			    		var $focusedRow = jQuery(e.component._$focusedRowElement);
	                    var $saveButton = $focusedRow.find(".dx-link dx-link-save");
	                    // console.log($focusedRow);
	                    if ($saveButton.length) {
	                        $saveButton.trigger("click");
	                    }
			    	}
			    }

			    else if (e.parentType === "dataRow" && e.dataField === "Satuan") {
			    	var isEditable = isRowEditable(e.row.data);
    				e.editorOptions.disabled = !isEditable;
			    	e.editorOptions.onFocusIn = (x) => {
			    		var $focusedRow = jQuery(e.component._$focusedRowElement);
	                    var $saveButton = $focusedRow.find(".dx-link dx-link-save");
	                    // console.log($focusedRow);
	                    if ($saveButton.length) {
	                        $saveButton.trigger("click");
	                    }
			    	}
			    }
			    else if (e.parentType === "dataRow" && e.dataField === "Harga") {
			    	var isEditable = isRowEditable(e.row.data);
    				e.editorOptions.disabled = !isEditable;

    			}
    			else if (e.parentType === "dataRow" && e.dataField === "Discount") {
			    	var isEditable = isRowEditable(e.row.data);
    				e.editorOptions.disabled = !isEditable;

    			}

    			else if (e.parentType === "dataRow" && e.dataField === "HargaNet") {
			    	var isEditable = isRowEditable(e.row.data);
    				e.editorOptions.disabled = !isEditable;

    			}
			    // SetEnableCommand();
			})
		}

	})

	function formatCurrency(input, amount) {
		input.attr("originalvalue", amount);
        let formattedAmount = parseFloat(amount).toLocaleString('en-US', {
            style: 'decimal',
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });

        // Set the formatted value to the input field
        input.val(formattedAmount);
    }
</script>
@endpush