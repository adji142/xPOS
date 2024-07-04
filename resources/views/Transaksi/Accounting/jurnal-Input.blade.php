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
					<a href="{{route('journal')}}">Daftar Transaksi Jurnal Entry</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Jurnal Entry</li>
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
										@if (count($jurnalheader) > 0)
											<input type="hidden" name="formtype" id="formtype" value="edit">
                                    		Edit Transaksi Jurnal Entry
	                                	@else
	                                		<input type="hidden" name="formtype" id="formtype" value="add">
	                                    	Tambah Transaksi Jurnal Entry
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
                            				<input type="text" class="form-control" id="NoTransaksi" name="NoTransaksi" placeholder="<Auto>" value="{{ count($jurnalheader) > 0 ? $jurnalheader[0]['NoTransaksi'] : '' }}" required="">
                            			</fieldset>
                            			
                            		</div>

                            		<div class="col-md-4">
                            			<label  class="text-body">Tanggal Transaksi</label>
                            			<fieldset class="form-group mb-3">
                            				<input type="date" class="form-control" id="TglTransaksi" name="TglTransaksi" placeholder="<Auto>" value="{{ count($jurnalheader) > 0 ? $jurnalheader[0]['TglTransaksi'] : '' }}" required="">
                            			</fieldset>
                            		</div>

                            		<div class="col-md-4">
                            			<label  class="text-body">Status</label>
                            			<fieldset class="form-group mb-3">
                            				<select name="Status" id="Status" class="js-example-basic-single js-states form-control bg-transparent" >
												<option value="O" {{ count($jurnalheader) > 0 ? $jurnalheader[0]['Status'] == 'O' ? "selected" : '' :""}} >OPEN</option>
												<option value="C" {{ count($jurnalheader) > 0 ? $jurnalheader[0]['Status'] == 'C' ? "selected" : '' :""}} >CLOSE</option>
												<option value="D" {{ count($jurnalheader) > 0 ? $jurnalheader[0]['Status'] == 'D' ? "selected" : '' :""}}>CANCEL</option>
												
											</select>
                            			</fieldset>
                            		</div>

                            		<div class="col-md-12">
                            			<label  class="text-body">Jenis Transaksi</label>
                            			<fieldset class="form-group mb-3">
                            				<select name="KodeTransaksi" id="KodeTransaksi" class="js-example-basic-single js-states form-control bg-transparent" >
												<option value="">Pilih Jenis Transaksi</option>
												@foreach($doctype as $ko)
                                                    <option value="{{ $ko->KodeDokumen }}">
                                                        {{ $ko->NamaDokumen }}
                                                    </option>
                                                @endforeach
												
											</select>
                            			</fieldset>
                            		</div>

                            		<div class="col-md-6">
                            			<label  class="text-body">No Reff</label>
                            			<fieldset class="form-group mb-3">
                            				<input type="text" class="form-control" id="NoReff" name="NoReff" placeholder="Masukan No Reff" value="{{ count($jurnalheader) > 0 ? $jurnalheader[0]['NoReff'] : '' }}" >
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
	var jurnalHeader = [];
	var jurnalDetail = [];
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

	    	jurnalHeader = <?php echo json_encode($jurnalheader); ?>;
	    	jurnalDetail = <?php echo $jurnaldetail; ?>;
			if (jQuery('#formtype').val() == "edit") {

	      		StatusTransaksi = jurnalHeader[0]["StatusTransaksi"];
	      		var KodeTransaksi = jurnalHeader[0]["KodeTransaksi"];
	      		console.log(jurnalHeader)
	      		if (StatusTransaksi != "O") {
	      			jQuery('#TglTransaksi').attr('disabled',true);
	      			jQuery('#KodeTransaksi').attr('disabled',true);
	      			jQuery('#NoReff').attr('disabled',true);
	      			jQuery('#Status').attr('disabled',true);
	      			jQuery('#btSave').attr('disabled',true);
	      		}
	      		BindGridDetail(<?php echo json_encode($jurnaldetail) ?>);
	      		// CreateCombobox([])
	      		jQuery('#KodeTransaksi').val(KodeTransaksi).trigger('change');
	      		// valueExpr: "NoTransaksi",
			}
			else{
				BindGridDetail([])	
			}

			SetEnableCommand();
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
      					'KodeTransaksi' : allRowsData[i]['KodeTransaksi'],
						'KodeRekening' : allRowsData[i]['KodeRekening'],
						'Debit' : allRowsData[i]['Debit'],
						'Kredit' : allRowsData[i]['Kredit'],
						'Keterangan' : allRowsData[i]['Keterangan'],
      				}
      				
      				oDetail.push(oItem)
      			}
      		}

			var oData = {
				'NoTransaksi' : jQuery('#NoTransaksi').val(),
				'TglTransaksi' : jQuery('#TglTransaksi').val(),
                'KodeTransaksi' : jQuery('#KodeTransaksi').val(),
				'NoReff' : jQuery('#NoReff').val(),
				'Status' : jQuery('#Status').val(),
				'Detail' : oDetail
			}
			// var originalvalue = jQuery("#TotalTransaksi").attr("originalvalue");

			// console.log(oData)
			if (jQuery('#formtype').val() == "add") {
				$.ajax({
					url: "{{route('journal-storeJson')}}",
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
		                        window.location.href = '{{url("journal")}}';
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
					url: "{{route('journal-editJson')}}",
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
		                        window.location.href = '{{url("journal")}}';
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
		});

		jQuery('#KodeTransaksi').change(function () {
			SetEnableCommand();
		})

		function BindGridDetail(data) {
			console.log(data);
			var AllowManipulation = true;
            var Fieldname = "";
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
						    dataSource: <?php echo $rekening ?>,
						    valueExpr: 'KodeRekening',
						    displayExpr: 'NamaRekening',
					    },
					    width: 350,
					    allowSorting: false,
					    allowEditing:AllowManipulation
	                },
	                {
	                    dataField: "Debit",
	                    caption: "Debit",
	                    allowEditing:AllowManipulation,
	                    format: { type: 'fixedPoint', precision: 2 },
	                    allowSorting: false 
	                },
                    {
	                    dataField: "Kredit",
	                    caption: "Kredit",
	                    allowEditing:AllowManipulation,
	                    format: { type: 'fixedPoint', precision: 2 },
	                    allowSorting: false 
	                },
	                {
	                    dataField: "Keterangan",
	                    caption: "Keterangan",
	                    allowEditing:AllowManipulation,
	                    allowSorting: false 
	                },
	            ],
				summary: {
                    totalItems: [
                        {
                            column: "Debit",
                            summaryType: "sum",
                            displayFormat: "{0}",
							valueFormat: {
                                type: "fixedPoint",
                                precision: 0
                            }
                        },
						{
                            column: "Kredit",
                            summaryType: "sum",
                            displayFormat: "{0}",
							valueFormat: {
                                type: "fixedPoint",
                                precision: 0
                            }
                        }
                    ]
                },
			    onContentReady: function(e) {
		            // Trigger edit mode for the first row (index 0) when the grid content is ready
		            // console.log(dataGridInstance.option("dataSource"))
		            var rowData = dataGridInstance.option("dataSource");
		            if (rowData.length == 1) {
		            	dataGridInstance.editRow(0)	
		            }
					SetEnableCommand();
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
					SetEnableCommand();
		        },
			}).dxDataGrid('instance');

			// console.log(dataGridInstance)
			var allRowsData  = dataGridInstance.option("dataSource");
        	var newData = { NoUrut: allRowsData.length + 1,KodeRekening:"", Debit: 0, Kredit:0, Keterangan: "" }
        	dataGridInstance.option("dataSource", [...dataGridInstance.option("dataSource"), newData]);
        	dataGridInstance.refresh();

        	dataGridInstance.on('rowUpdated', function(e) {
        		// CalculateTotal();
                var rowIndex = dataGridInstance.getRowIndexByKey(e.key);
			    //         dataGridInstance.cellValue(rowIndex, "Kredit", 0);
                console.log(Fieldname);
                if(Fieldname == "Debit" && e.data.Debit > 0){
                    dataGridInstance.cellValue(rowIndex, "Kredit", 0);
                }
				SetEnableCommand();
        	});

        	dataGridInstance.on('editorPreparing',function (e) {
				if (e.parentType === "dataRow" && e.dataField === "KodeRekening") {
                    Fieldname = "KodeRekening";
			        e.editorOptions.onFocusOut = (x) => {
			            // same here
			            var rowIndex = dataGridInstance.getRowIndexByKey(e.row.key);

			            dataGridInstance.cellValue(rowIndex, "Debit", 0);
                        dataGridInstance.cellValue(rowIndex, "Kredit", 0);
			            dataGridInstance.cellValue(rowIndex, "Keterangan", jQuery('#Keterangan').val());

			            dataGridInstance.refresh()
	                    dataGridInstance.saveEditData();
	                    

	                    var allRowsData  = dataGridInstance.option("dataSource");
	                    var newData = { NoUrut: allRowsData.length + 1,KodeRekening:"", Debit: 0, Kredit:0, Keterangan: "" }

        				dataGridInstance.option("dataSource", [...dataGridInstance.option("dataSource"), newData]);
        				dataGridInstance.refresh();
			        }
			        e.editorOptions.onFocusIn = (x) => {
			        	console.log(x)
			        }
			    }
			    else if (e.parentType === "dataRow" && e.dataField === "Debit") {
                    Fieldname = "Debit";
			    	e.editorOptions.onFocusOut = (x) => {
			    		dataGridInstance.saveEditData();
			    	}
					e.editorOptions.onFocusIn = (x) => {
			    		if(e.row.data.Kredit > 0){
							var rowIndex = dataGridInstance.getRowIndexByKey(e.row.key);
			            	dataGridInstance.cellValue(rowIndex, "Kredit", 0);
						}
			    	}
			    }
                else if (e.parentType === "dataRow" && e.dataField === "Kredit") {
                    Fieldname = "Kredit";
			    	e.editorOptions.onFocusOut = (x) => {
			    		dataGridInstance.saveEditData();
			    	}
					e.editorOptions.onFocusIn = (x) => {
			    		// console.log(e.row.data.Debit);
						if(e.row.data.Debit > 0){
							var rowIndex = dataGridInstance.getRowIndexByKey(e.row.key);
			            	dataGridInstance.cellValue(rowIndex, "Debit", 0);
						}
			    	}
			    }

			    else if (e.parentType === "dataRow" && e.dataField === "Keterangan") {
			    	e.editorOptions.onFocusOut = (x) => {
			    		dataGridInstance.saveEditData();
			    	}
			    }
			    SetEnableCommand();
			})
		}

		function SetEnableCommand() {
			var dataGridInstance = jQuery('#gridContainerDetail').dxDataGrid('instance');
      		var allRowsData  = dataGridInstance.getDataSource().items();

			var TotalDebit = 0;
			var TotalKredit = 0;

			var nError = 0;
			if(jQuery('#KodeTransaksi').val() == ""){
				nError +=1;
			}

			for (let index = 0; index < allRowsData.length; index++) {
				// const element = array[index];
				TotalDebit += allRowsData[index]["Debit"];
				TotalKredit += allRowsData[index]["Kredit"];
			}

			if(TotalDebit != TotalKredit){
				nError +=1;
			}

			if (allRowsData.length == 0) {
				nError +=1;
			}

			console.log(allRowsData);

			if(nError > 0){
				jQuery('#btSave').attr("disabled", true);
			}
			else{
				jQuery('#btSave').attr("disabled", false);
			}
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