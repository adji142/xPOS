@extends('parts.header')
	
@section('content')

<!--begin::Subheader-->
<style>
/* Style for text alignment */
.aligned-textbox {
    text-align: right; /* Change 'center' to 'left' or 'right' for different alignments */
}
.dx-dropdowneditor-overlay {
    z-index: 10000!important ; /* Adjust the z-index value as needed */
}

</style>
<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">
					<a href="{{route('gr')}}">Daftar Penghapusan Stock Barang</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Penghapusan Stock Barang</li>
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
										@if (count($penghapusanheader) > 0)
											<input type="hidden" name="formtype" id="formtype" value="edit">
                                    		Edit Penghapusan Stock Barang
	                                	@else
	                                		<input type="hidden" name="formtype" id="formtype" value="add">
	                                    	Tambah Penghapusan Stock Barang
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
                            		<div class="col-md-4">
                            			<label  class="text-body">No Transaksi (*)</label>
                            			<fieldset class="form-group mb-3">
                            				<input type="text" class="form-control" id="NoTransaksi" name="NoTransaksi" placeholder="<Auto>" value="{{ count($penghapusanheader) > 0 ? $penghapusanheader[0]['NoTransaksi'] : '' }}" required="">
                            			</fieldset>
                            			
                            		</div>

                            		<div class="col-md-4">
                            			<label  class="text-body">Status</label>
                            			<fieldset class="form-group mb-3">
                            				<select name="Status" id="Status" class="js-example-basic-single js-states form-control bg-transparent" >
												<option value="O" {{ count($penghapusanheader) > 0 ? $penghapusanheader[0]['Status'] == 'O' ? "selected" : '' :""}} >OPEN</option>
												<option disabled="" value="C" {{ count($penghapusanheader) > 0 ? $penghapusanheader[0]['Status'] == 'C' ? "selected" : '' :""}} >CLOSE</option>
												<option value="D" {{ count($penghapusanheader) > 0 ? $penghapusanheader[0]['Status'] == 'D' ? "selected" : '' :""}}>CANCEL</option>
												
											</select>
                            			</fieldset>
                            		</div>

                            		<div class="col-md-4">
                            			<label  class="text-body">Tanggal Transaksi</label>
                            			<fieldset class="form-group mb-3">
                            				<input type="date" class="form-control" id="TglTransaksi" name="TglTransaksi" placeholder="<Auto>" value="{{ count($penghapusanheader) > 0 ? $penghapusanheader[0]['TglTransaksi'] : '' }}" required="">
                            			</fieldset>
                            		</div>

                            		<div class="col-md-6">
                            			<label  class="text-body">No Reff</label>
                            			<fieldset class="form-group mb-3">
                            				<input type="text" class="form-control" id="NoReff" name="NoReff" placeholder="Masukan No Reff" value="{{ count($penghapusanheader) > 0 ? $penghapusanheader[0]['NoReff'] : '' }}" >
                            			</fieldset>
                            		</div>

                            		<div class="col-md-6">
                            			<label  class="text-body">Keterangan</label>
                            			<fieldset class="form-group mb-3">
                            				<input type="text" class="form-control" id="Keterangan" name="Keterangan" placeholder="Masukan Keterangan" value="{{ count($penghapusanheader) > 0 ? $penghapusanheader[0]['Keterangan'] : '' }}" >
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
                            					<td>Total</td>
                            					<td>:</td>
                            					<td><input type="text" align="right" name="TotalTransaksi" id="TotalTransaksi" readonly="" class="form-control aligned-textbox" value="{{ count($penghapusanheader) > 0 ? $penghapusanheader[0]['TotalTransaksi'] : '0' }}"></td>
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

<div class="modal fade text-left w-100" id="modallookupItem" tabindex="-1" role="dialog" aria-labelledby="myModalLabel16" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h4 class="modal-title" id="myModalLabel16">Daftar Item Master</h4>
		  <button type="button" class="close rounded-pill btn btn-sm btn-icon btn-primary m-0" data-bs-dismiss="modal" aria-label="Close">
			<svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-x" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
			<path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
			</svg>	
			</button>
		</div>
		<div class="modal-body">
		  <div id="gridLookupitem"></div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-primary ms-1" id="btSelectItem" data-bs-dismiss="modal">
				<span class="">Pilih Item</span>
			</button>
			</div> 		
	  </div>
	</div>
</div>

@endsection

@push('scripts')
@extends('parts.generaljs')

<script type="text/javascript">
	// jQuery(document).ready(function() {
	// 	jQuery('.js-example-basic-multiple').select2();
	// });
	var TotalTermin = 0;
	var StatusTransaksi = "O";
	var penghapusanHeader = [];
	var penghapusanDetail = [];
	var filteredOrderDetail = [];
	var GetDate = '';
	var oItemMaster = [];
	var _selectedRow = -1;

	jQuery(function () {
		jQuery(document).ready(function() {
			var now = new Date();
	    	var day = ("0" + now.getDate()).slice(-2);
	    	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	    	var firstDay = now.getFullYear()+"-"+month+"-01";
	    	var NowDay = now.getFullYear()+"-"+month+"-"+day;
	    	GetDate = now.getFullYear()+"-"+month+"-"+day;

	    	jQuery('#TglTransaksi').val(NowDay);
	    	jQuery('#TglJatuhTempo').val(NowDay);
	    	// console.log(jQuery('#formtype').val())

	    	penghapusanHeader = <?php echo json_encode($penghapusanheader); ?>;
	    	penghapusanDetail = <?php echo json_encode($penghapusandetail); ?>;
	    	oItemMaster = <?php echo $item ?>;

	    	console.log(penghapusanHeader)
			if (jQuery('#formtype').val() == "edit") {
				formatCurrency(jQuery('#TotalTransaksi'), penghapusanHeader[0]["TotalTransaksi"]);
	      		StatusTransaksi = penghapusanHeader[0]["Status"];

	      		console.log(StatusTransaksi)
	      		if (StatusTransaksi != "O") {
	      			jQuery('#TglTransaksi').attr('disabled',true);
	      			jQuery('#NoReff').attr('disabled',true);
	      			jQuery('#Keterangan').attr('disabled',true);
	      			jQuery('#Status').attr('disabled',true);
	      			jQuery('#btSave').attr('disabled',true);
	      		}
	      		BindGridDetail(<?php echo json_encode($penghapusandetail) ?>);
			}
			else{
				BindGridDetail([])	
			}
		});

		jQuery('#btSave').click(function () {
			// formatCurrency(jQuery('#TotalTransaksi'));

			jQuery('#btSave').text('Tunggu Sebentar.....');
      		jQuery('#btSave').attr('disabled',true);

      		var dataGridInstance = jQuery('#gridContainerDetail').dxDataGrid('instance');
      		var allRowsData  = dataGridInstance.getDataSource().items();
      		
      		var oDetail = [];

      		for (var i = 0; i < allRowsData.length; i++) {
      			// Things[i]
      			if (allRowsData[i]['KodeItem'] != "") {

      				var oItem = {
						'KodeItem' : allRowsData[i]['KodeItem'],
						'NamaItem' : allRowsData[i]['NamaItem'],
						'Qty' : allRowsData[i]['Qty'],
						'Satuan' : allRowsData[i]['Satuan'],
						'Harga' : allRowsData[i]['Harga'],
						'KodeGudang' : allRowsData[i]['KodeGudang'],
						'KodeRekening' : allRowsData[i]['KodeRekening'],
      				}
      				
      				oDetail.push(oItem)
      			}
      		}

			var oData = {
				'NoTransaksi' : jQuery('#NoTransaksi').val(),
				'TglTransaksi' : jQuery('#TglTransaksi').val(),
				'NoReff' : jQuery('#NoReff').val(),
				'TotalTransaksi' : jQuery('#TotalTransaksi').attr("originalvalue"),
				'Status' : jQuery('#Status').val(),
				'Keterangan' : jQuery('#Keterangan').val(),
				'Detail' : oDetail
			}
			// var originalvalue = jQuery("#TotalTransaksi").attr("originalvalue");

			// console.log(oData)
			if (jQuery('#formtype').val() == "add") {
				$.ajax({
					url: "{{route('gi-storeJson')}}",
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
		                        window.location.href = '{{url("gi")}}';
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
					url: "{{route('gi-editJson')}}",
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
		                        window.location.href = '{{url("gi")}}';
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
		
		jQuery('#btSelectItem').click(function () {
			var dataGridInstance = jQuery('#gridLookupitem').dxDataGrid('instance');
			var dataGridDetailInstance = jQuery('#gridContainerDetail').dxDataGrid('instance');

			var selectedRows = dataGridInstance.getSelectedRowsData();

			console.log(selectedRows);
			if (selectedRows.length > 0) {

				dataGridDetailInstance.cellValue(_selectedRow, "KodeItem", selectedRows[0]["KodeItem"]);
		    	dataGridDetailInstance.cellValue(_selectedRow, "NamaItem", selectedRows[0]["NamaItem"]);
		    	dataGridDetailInstance.cellValue(_selectedRow, "Qty", 1);
		        dataGridDetailInstance.cellValue(_selectedRow, "Harga", selectedRows[0]["HargaPokokPenjualan"]);
		        dataGridDetailInstance.cellValue(_selectedRow, "Satuan", selectedRows[0]["Satuan"]);
				dataGridDetailInstance.cellValue(_selectedRow, "KodeRekening", <?php echo $rekeningDefault ?>);
		        dataGridDetailInstance.refresh();
		        dataGridDetailInstance.saveEditData();
				CalculateTotal();
			}
		});

		function CalculateTotal() {
			var dataGridInstance = jQuery('#gridContainerDetail').dxDataGrid('instance');
      		var allRowsData  = dataGridInstance.getDataSource().items();

      		var TotalTransaksi = 0;

      		console.log(allRowsData)
      		for (var i = 0; i < allRowsData.length; i++) {
      			// Things[i]

      			if (allRowsData[i]['KodeItem'] != "") {
      				var Qty = (typeof(allRowsData[i]['Qty'])) === "undefined" ? 0 : allRowsData[i]['Qty'];
	      			var Harga = (typeof(allRowsData[i]['Harga'])) == "undefined" ? 0 : allRowsData[i]['Harga'];

      				TotalTransaksi += Qty * Harga;
      			}
      		}

      		formatCurrency(jQuery('#TotalTransaksi'), TotalTransaksi);
		}

		function BindGridDetail(data) {
			var AllowManipulation = true;
			if (StatusTransaksi != "O") {
				AllowManipulation = false;
			}
			console.log(AllowManipulation)

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
	                    caption: "NoUrut",
	                    allowEditing:AllowManipulation,
	                    allowSorting: false 
	                },
	                {
	                    dataField: "KodeItem",
	                    caption: "Kode Item",
					    allowSorting: false,
					    allowEditing:AllowManipulation
	                },
	                {
	                    dataField: "NamaItem",
	                    caption: "Nama Item",
					    width: 250,
					    allowSorting: false,
					    allowEditing:AllowManipulation
	                },
	                {
	                    dataField: "KodeGudang",
	                    caption: "Gudang",
	                    lookup: {
						    dataSource: <?php echo $gudang ?>,
						    valueExpr: 'KodeGudang',
						    displayExpr: 'NamaGudang',
					    },
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
	                    allowEditing:false,
	                    format: { type: 'fixedPoint', precision: 2 },
	                    allowSorting: false 
	                },
					{
	                    dataField: "KodeRekening",
	                    caption: "Rekening Akutansi",
	                    // allowEditing:false,
	                    lookup: {
						    dataSource: <?php echo $rekening ?>,
						    valueExpr: 'KodeRekening',
						    displayExpr: 'NamaRekening',
					    },
					    allowSorting: false ,
					    allowEditing:AllowManipulation
	                },
	                {
	                    dataField: "TotalTransaksi",
	                    caption: "Total",
	                    allowEditing:false,
	                    format: { type: 'fixedPoint', precision: 2 },
	                    calculateCellValue:function (rowData) {
	                    	var HargaNet = 0;
	                    	var HargaGross = 0;

	                    	HargaNet = rowData.Qty * rowData.Harga;

	                    	return HargaNet
	                    },
	                    allowSorting: false 
	                },
	            ],
			    onContentReady: function(e) {
			    	CalculateTotal();
		        },
		        onCellClick:function (e) {
		        	var rowData = dataGridInstance.option("dataSource");
		            var columnIndex = e.columnIndex;
		            // console.log(e)
		        	if (columnIndex >= 1 && columnIndex <= 8) {
		                dataGridInstance.editRow(e.rowIndex)	
		            }
		            dataGridInstance.option("focusedColumnIndex", columnIndex);

		            var allRowsData  = dataGridInstance.option("dataSource");
		            var blankCount = 0;

	        		for (var i = 0; i < allRowsData.length; i++) {
	        			if (allRowsData[i]["KodeItem"] == "") {
	        				blankCount += 1;
	        			}
	        		}
	        		if (blankCount == 1) {
	        			var newData = { NoUrut: allRowsData.length+1,KodeItem:"",NamaItem:"",KodeGudang:"", Qty: 0, Satuan: "", Harga:0, TotalTransaksi:0 }
						dataGridInstance.option("dataSource", [...dataGridInstance.option("dataSource"), newData]);
						dataGridInstance.refresh();
	        		}
		        },
			}).dxDataGrid('instance');

			dataGridInstance.on('rowUpdated', function(e) {
        		var allRowsData  = dataGridInstance.option("dataSource");
        		var blankCount = 0;

        		for (var i = 0; i < allRowsData.length; i++) {
        			if (allRowsData[i]["KodeItem"] == "") {
        				blankCount += 1;
        			}
        		}

        		if (blankCount == 1) {
        			var newData = { NoUrut: allRowsData.length+1,KodeItem:"",NamaItem:"",KodeGudang:"", Qty: 0, Satuan: "", Harga:0, TotalTransaksi:0 }
					dataGridInstance.option("dataSource", [...dataGridInstance.option("dataSource"), newData]);
					dataGridInstance.refresh();
        		}

        		CalculateTotal();
        	})

        	dataGridInstance.on('editorPreparing',function (e) {
	        	if (e.parentType === "dataRow" && e.dataField == "KodeItem"){

	        		var dataField = e.dataField;
	        		var xItem = "";
	        		var rowIndex = dataGridInstance.getRowIndexByKey(e.row.key);
	        		_selectedRow = rowIndex;
	        		e.editorOptions.onValueChanged = function(args) {
                        xItem = args.value;
                        // Optionally, perform actions when value changes
                    };


                    e.editorElement.on("focusout", function () {
                    	console.log(xItem)
	                	var filteredItem = oItemMaster.filter(function (oData) {
                        	return oData.KodeItem.includes(xItem);
                        });
                        // console.log(filteredItem);
                        if (filteredItem.length == 0) {
                        	Swal.fire({
		                      icon: "error",
		                      title: "#Informasi",
		                      text: "Kode Item " + xItem+" Tidak ditemukan",
		                    }).then((result) => {
								dataGridInstance.refresh();
								dataGridInstance.cancelEditData();
							});
                        }
                        else if (filteredItem.length == 1) {
                        	dataGridInstance.cellValue(rowIndex, "KodeItem", xItem);
                        	dataGridInstance.cellValue(rowIndex, "NamaItem", filteredItem[0]["NamaItem"]);
                        	dataGridInstance.cellValue(rowIndex, "Qty", 1);
				            dataGridInstance.cellValue(rowIndex, "Harga", filteredItem[0]["HargaBeliTerakhir"]);
				            dataGridInstance.cellValue(rowIndex, "Discount", 0);
				            dataGridInstance.cellValue(rowIndex, "HargaNet", 0);
				            dataGridInstance.cellValue(rowIndex, "Satuan", filteredItem[0]["Satuan"]);
							dataGridInstance.cellValue(_selectedRow, "KodeRekening", <?php echo $rekeningDefault ?>);
				            dataGridInstance.refresh();
				            dataGridInstance.saveEditData();
                        }
                        else{
                        	jQuery('#modallookupItem').modal({backdrop: 'static', keyboard: false})
							jQuery('#modallookupItem').modal('show');
					    	// console.log(orderHeader)
					    	var ColumnData = [
					    		{
				                    dataField: "KodeItem",
				                    caption: "Kode Item",
				                    allowSorting: true,
				                    allowEditing : false
				                },
				                {
				                    dataField: "Barcode",
				                    caption: "Barcode",
				                    allowSorting: true,
				                    allowEditing : false
				                },
				                {
				                    dataField: "NamaItem",
				                    caption: "Nama Item",
				                    allowSorting: true,
				                    allowEditing : false
				                },
				                {
				                    dataField: "Stock",
				                    caption: "Stock",
				                    allowSorting: true,
				                    allowEditing : false,
				                    format: { type: 'fixedPoint', precision: 2 },
				                },
				                {
				                    dataField: "Satuan",
				                    caption: "Sat",
				                    allowSorting: true,
				                    allowEditing : false
				                },
					    	];
					    	BindLookupServices("gridLookupitem", "KodeItem", oItemMaster, ColumnData);
                        }
                    });
	        	}
	        	else if (e.parentType === "dataRow" && e.dataField == "NamaItem"){
	        		var dataField = e.dataField;
	        		var xItem = "";
	        		var rowIndex = dataGridInstance.getRowIndexByKey(e.row.key);
	        		_selectedRow = rowIndex;
	        		e.editorOptions.onValueChanged = function(args) {
                        xItem = args.value;
                        // Optionally, perform actions when value changes
                    };

                    e.editorElement.on("focusout", function () {
	                	var filteredItem = oItemMaster.filter(function (oData) {
                        	return oData.NamaItem.includes(xItem);
                        });
                        // console.log(filteredItem);
                        if (filteredItem.length == 0) {
                        	Swal.fire({
		                      icon: "error",
		                      title: "#Informasi",
		                      text: "Nama Item " + xItem+" Tidak ditemukan",
		                    }).then((result) => {
								dataGridInstance.refresh();
								dataGridInstance.cancelEditData();
							});
                        }
                        else if (filteredItem.length == 1) {
                        	dataGridInstance.cellValue(rowIndex, "KodeItem", xItem);
                        	dataGridInstance.cellValue(rowIndex, "NamaItem", filteredItem[0]["NamaItem"]);
                        	dataGridInstance.cellValue(rowIndex, "Qty", 1);
				            dataGridInstance.cellValue(rowIndex, "Harga", filteredItem[0]["HargaBeliTerakhir"]);
				            dataGridInstance.cellValue(rowIndex, "Discount", 0);
				            dataGridInstance.cellValue(rowIndex, "HargaNet", 0);
				            dataGridInstance.cellValue(rowIndex, "Satuan", filteredItem[0]["Satuan"]);
							dataGridInstance.cellValue(_selectedRow, "KodeRekening", <?php echo $rekeningDefault ?>);
				            dataGridInstance.refresh();
				            dataGridInstance.saveEditData();
                        }
                        else{
                        	jQuery('#modallookupItem').modal({backdrop: 'static', keyboard: false})
							jQuery('#modallookupItem').modal('show');
					    	// console.log(orderHeader)
					    	var ColumnData = [
					    		{
				                    dataField: "KodeItem",
				                    caption: "Kode Item",
				                    allowSorting: true,
				                    allowEditing : false
				                },
				                {
				                    dataField: "Barcode",
				                    caption: "Barcode",
				                    allowSorting: true,
				                    allowEditing : false
				                },
				                {
				                    dataField: "NamaItem",
				                    caption: "Nama Item",
				                    allowSorting: true,
				                    allowEditing : false
				                },
				                {
				                    dataField: "Stock",
				                    caption: "Stock",
				                    allowSorting: true,
				                    allowEditing : false,
				                    format: { type: 'fixedPoint', precision: 2 },
				                },
				                {
				                    dataField: "Satuan",
				                    caption: "Sat",
				                    allowSorting: true,
				                    allowEditing : false
				                },
					    	];
					    	BindLookupServices("gridLookupitem", "KodeItem", oItemMaster, ColumnData);
                        }
                    });
	        	}
	        	if (e.parentType === "dataRow" && e.dataField == "KodeGudang"){
	        		e.editorElement.on("focusout", function () {
	        			dataGridInstance.refresh();
				        dataGridInstance.saveEditData();
	        		});
	        	}

	        	CalculateTotal();
	        });

	        var allRowsData  = dataGridInstance.option("dataSource");
        	var newData = { NoUrut: allRowsData.length+1,KodeItem:"",NamaItem:"",KodeGudang:"", Qty: 0, Satuan: "", Harga:0, TotalTransaksi:0 }
        	dataGridInstance.option("dataSource", [...dataGridInstance.option("dataSource"), newData]);
        	dataGridInstance.refresh();
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