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
					<a href="{{route('biaya')}}">Daftar Transaksi Biaya</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Biaya</li>
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
										@if (count($biayaheader) > 0)
											<input type="hidden" name="formtype" id="formtype" value="edit">
                                    		Edit Transaksi Biaya
	                                	@else
	                                		<input type="hidden" name="formtype" id="formtype" value="add">
	                                    	Tambah Transaksi Biaya
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
                            				<input type="text" class="form-control" id="NoTransaksi" name="NoTransaksi" placeholder="<Auto>" value="{{ count($biayaheader) > 0 ? $biayaheader[0]['NoTransaksi'] : '' }}" required="">
                            			</fieldset>
                            			
                            		</div>

                            		<div class="col-md-4">
                            			<label  class="text-body">Tanggal Transaksi</label>
                            			<fieldset class="form-group mb-3">
                            				<input type="date" class="form-control" id="TglTransaksi" name="TglTransaksi" placeholder="<Auto>" value="{{ count($biayaheader) > 0 ? $biayaheader[0]['TglTransaksi'] : '' }}" required="">
                            			</fieldset>
                            		</div>

                            		<div class="col-md-4">
                            			<label  class="text-body">Status</label>
                            			<fieldset class="form-group mb-3">
                            				<select name="Status" id="Status" class="js-example-basic-single js-states form-control bg-transparent" >
												<option value="O" {{ count($biayaheader) > 0 ? $biayaheader[0]['Status'] == 'O' ? "selected" : '' :""}} >OPEN</option>
												<option value="C" {{ count($biayaheader) > 0 ? $biayaheader[0]['Status'] == 'C' ? "selected" : '' :""}} >CLOSE</option>
												<option value="D" {{ count($biayaheader) > 0 ? $biayaheader[0]['Status'] == 'D' ? "selected" : '' :""}}>CANCEL</option>
												
											</select>
                            			</fieldset>
                            		</div>

                            		<div class="col-md-12">
                            			<label  class="text-body">Akun Kas / Bank</label>
                            			<fieldset class="form-group mb-3">
                            				<select name="KodeRekening" id="KodeRekening" class="js-example-basic-single js-states form-control bg-transparent" >
												<option value="-1">Pilih Akun Kas / Bank</option>
												@foreach($rekeningasset as $ko)
													<option value="{{ $ko->KodeRekening }}">
                                                        {{ $ko->NamaRekening }}
                                                    </option>
												@endforeach
												
											</select>
                            			</fieldset>
                            		</div>

                            		<div class="col-md-6">
                            			<label  class="text-body">No Reff</label>
                            			<fieldset class="form-group mb-3">
                            				<input type="text" class="form-control" id="NoReff" name="NoReff" placeholder="Masukan No Reff" value="{{ count($biayaheader) > 0 ? $biayaheader[0]['NoReff'] : '' }}" >
                            			</fieldset>
                            		</div>

                            		<div class="col-md-6">
                            			<label  class="text-body">Keterangan</label>
                            			<fieldset class="form-group mb-3">
                            				<input type="text" class="form-control" id="Keterangan" name="Keterangan" placeholder="Masukan Keterangan" value="{{ count($biayaheader) > 0 ? $biayaheader[0]['Keterangan'] : '' }}" >
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
                            					<td><input type="text" align="right" name="TotalTransaksi" id="TotalTransaksi" readonly="" class="form-control aligned-textbox" value="{{ count($biayaheader) > 0 ? $biayaheader[0]['TotalTransaksi'] : '0' }}"></td>
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
	var biayaHeader = [];
	var biayaDetail = [];
	var filteredOrderDetail = [];
	var GetDate = '';
	var NoOrderPembelian = '';
	jQuery(function () {
		jQuery(document).ready(function() {
			var now = new Date();
	    	var day = ("0" + now.getDate()).slice(-2);
	    	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	    	var firstDay = now.getFullYear()+"-"+month+"-01";
	    	var NowDay = now.getFullYear()+"-"+month+"-"+day;
	    	GetDate = now.getFullYear()+"-"+month+"-"+day;

	    	jQuery('#TglTransaksi').val(NowDay);
	    	// console.log(jQuery('#formtype').val())

	    	biayaHeader = <?php echo json_encode($biayaheader); ?>;
	    	biayaDetail = <?php echo json_encode($biayadetail); ?>;
			if (jQuery('#formtype').val() == "edit") {
				formatCurrency(jQuery('#TotalTransaksi'), biayaHeader[0]["TotalTransaksi"]);
	      		
	      		StatusTransaksi = biayaHeader[0]["Status"];
	      		var KodeRekening = biayaHeader[0]["KodeRekening"];
	      		// console.log(StatusTransaksi)
	      		if (StatusTransaksi != "O") {
	      			jQuery('#TglTransaksi').attr('disabled',true);
	      			jQuery('#KodeRekening').attr('disabled',true);
	      			jQuery('#NoReff').attr('disabled',true);
	      			jQuery('#Keterangan').attr('disabled',true);
	      			jQuery('#Status').attr('disabled',true);
	      			jQuery('#btSave').attr('disabled',true);
	      		}
	      		BindGridDetail(<?php echo json_encode($biayadetail) ?>);
	      		// CreateCombobox([])
	      		jQuery('#KodeRekening').val(KodeRekening).trigger('change');
	      		// valueExpr: "NoTransaksi",
			}
			else{
				BindGridDetail([])	
				CreateCombobox([])
			}
		});

		jQuery('#btSave').click(function () {
			// formatCurrency(jQuery('#TotalTransaksi'));

			jQuery('#btSave').text('Tunggu Sebentar.....');
      		jQuery('#btSave').attr('disabled',true);

      		var dataGridInstance = jQuery('#gridContainerDetail').dxDataGrid('instance');
      		var allRowsData  = dataGridInstance.getDataSource().items();
      		console.log(allRowsData)
      		var oDetail = [];

      		for (var i = 0; i < allRowsData.length; i++) {
      			// Things[i]
      			if (allRowsData[i]['KodeItem'] != "") {

      				var oItem = {
      					'NoUrut' : allRowsData[i]['NoUrut'],
						'KodeRekening' : allRowsData[i]['KodeRekening'],
						'TotalTransaksi' : allRowsData[i]['TotalTransaksi'],
						'NoReff' : allRowsData[i]['NoReff'],
						'Keterangan' : allRowsData[i]['Keterangan'],
						'LineStatus' : allRowsData[i]['LineStatus'],
      				}
      				
      				oDetail.push(oItem)
      			}
      		}

			var oData = {
				'NoTransaksi' : jQuery('#NoTransaksi').val(),
				'TglTransaksi' : jQuery('#TglTransaksi').val(),
				'NoReff' : jQuery('#NoReff').val(),
				'Keterangan' : jQuery('#Keterangan').val(),
				'TotalTransaksi' : jQuery("#TotalTransaksi").attr("originalvalue"),
				'KodeRekening' : jQuery('#KodeRekening').val(),
				'Status' : jQuery('#Status').val(),
				'Detail' : oDetail
			}
			// var originalvalue = jQuery("#TotalTransaksi").attr("originalvalue");

			// console.log(oData)
			if (jQuery('#formtype').val() == "add") {
				$.ajax({
					url: "{{route('biaya-storeJson')}}",
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
		                        window.location.href = '{{url("biaya")}}';
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
					url: "{{route('biaya-editJson')}}",
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
		                        window.location.href = '{{url("biaya")}}';
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

      		console.log(allRowsData)
      		for (var i = 0; i < allRowsData.length; i++) {
      			// Things[i]

      			if (allRowsData[i]['KodeRekening'] != "") {
	      			TotalTransaksi += (typeof(allRowsData[i]['TotalTransaksi'])) == "undefined" ? 0 : allRowsData[i]['TotalTransaksi'];
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
	                    caption: "#",
	                    allowEditing:false,
	                    allowSorting: false 
	                },
	                {
	                    dataField: "KodeRekening",
	                    caption: "Akun",
	                    lookup: {
						    dataSource: <?php echo $rekeningbiaya ?>,
						    valueExpr: 'KodeRekening',
						    displayExpr: 'NamaRekening',
					    },
					    width: 350,
					    allowSorting: false,
					    allowEditing:AllowManipulation
	                },
	                {
	                    dataField: "TotalTransaksi",
	                    caption: "Total",
	                    allowEditing:AllowManipulation,
	                    format: { type: 'fixedPoint', precision: 2 },
	                    allowSorting: false 
	                },
	                {
	                    dataField: "NoReff",
	                    caption: "Reff",
	                    allowEditing:AllowManipulation,
	                    allowSorting: false 
	                },
	                {
	                    dataField: "Keterangan",
	                    caption: "Keterangan",
	                    allowEditing:AllowManipulation,
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
		            	dataGridInstance.editRow(0)	
		            }
		            // dataGridInstance.editRow(0)
		            // dataGridInstance.editRow(0);
		        },
		        onCellClick:function (e) {
		        	// console.log(dataGridInstance.option("dataSource"))
		            var rowData = dataGridInstance.option("dataSource");
		            var columnIndex = e.columnIndex;
		            console.log(e)
		        	if (columnIndex >= 1 && columnIndex <= 5) {
		                dataGridInstance.editRow(e.rowIndex)	
		            }
		            dataGridInstance.option("focusedColumnIndex", columnIndex);	
		        },
			}).dxDataGrid('instance');

			// console.log(dataGridInstance)
			var allRowsData  = dataGridInstance.option("dataSource");
        	var newData = { NoUrut: allRowsData.length + 1,KodeRekening:"", TotalTransaksi: 0, NoReff: "",Keterangan: "",LineStatus:'' }
        	dataGridInstance.option("dataSource", [...dataGridInstance.option("dataSource"), newData]);
        	dataGridInstance.refresh();

        	dataGridInstance.on('rowUpdated', function(e) {
        		// console.log(e)
        		CalculateTotal();
        	});
        	// Validasi duplicate Row
        	dataGridInstance.on('dataErrorOccurred',function (e) {
			console.log(e)
				alert("Data Sudah terpakai di baris lain");
				e.error.message = "Data Sudah terpakai di baris lain";
				e.error.url = "";
				dataGridInstance.refresh();
				dataGridInstance.cancelEditData();
				// SetEnableCommand();
			});

        	dataGridInstance.on('editorPreparing',function (e) {
				if (e.parentType === "dataRow" && e.dataField === "KodeRekening") {
			        e.editorOptions.onFocusOut = (x) => {
			            // same here
			            var rowIndex = dataGridInstance.getRowIndexByKey(e.row.key);

			            // x.component.option("value", "Test2");
			            // console.log(e.row.cells[0].value)
			            // console.log(selectedItem)
			            dataGridInstance.cellValue(rowIndex, "TotalTransaksi", 0);
			            dataGridInstance.cellValue(rowIndex, "NoReff", jQuery('#NoReff').val());
			            dataGridInstance.cellValue(rowIndex, "Keterangan", jQuery('#Keterangan').val());
			            dataGridInstance.cellValue(rowIndex, "LineStatus", "O");
			            // dataGridInstance.cellValue(rowIndex, "Qty", 1);

			            dataGridInstance.refresh()
	                    dataGridInstance.saveEditData();
	                    

	                    var allRowsData  = dataGridInstance.option("dataSource");
	                    var newData = { NoUrut: allRowsData.length + 1,KodeRekening:"", TotalTransaksi: 0, NoReff: "",Keterangan: "",LineStatus:'' }

        				dataGridInstance.option("dataSource", [...dataGridInstance.option("dataSource"), newData]);
        				dataGridInstance.refresh();
			        }
			        e.editorOptions.onFocusIn = (x) => {
			        	console.log(x)
			        }
			    }
			    else if (e.parentType === "dataRow" && e.dataField === "TotalTransaksi") {
			    	e.editorOptions.onFocusOut = (x) => {
			    		dataGridInstance.saveEditData();
			    	}
			    }

			    else if (e.parentType === "dataRow" && e.dataField === "NoReff") {
			    	e.editorOptions.onFocusOut = (x) => {
			    		dataGridInstance.saveEditData();
			    	}
			    }

			    else if (e.parentType === "dataRow" && e.dataField === "Keterangan") {
			    	e.editorOptions.onFocusOut = (x) => {
			    		dataGridInstance.saveEditData();
			    	}
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