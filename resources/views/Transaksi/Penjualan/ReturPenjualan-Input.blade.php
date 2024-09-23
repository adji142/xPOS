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
					<a href="{{route('returpenjualan')}}">Daftar Retur Penjualan</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Retur Penjualan</li>
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
										@if (count($returheader) > 0)
											<input type="hidden" name="formtype" id="formtype" value="edit">
                                    		Edit Retur Penjualan
	                                	@else
	                                		<input type="hidden" name="formtype" id="formtype" value="add">
	                                    	Tambah Retur Penjualan
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
                            		<div class="col-md-3">
                            			<label  class="text-body">No Transaksi (*)</label>
                            			<fieldset class="form-group mb-3">
                            				<input type="text" class="form-control" id="NoTransaksi" name="NoTransaksi" placeholder="<Auto>" value="{{ count($returheader) > 0 ? $returheader[0]['NoTransaksi'] : '' }}" required="">
                            			</fieldset>
                            			
                            		</div>

                            		<div class="col-md-2">
                            			<label  class="text-body">Status</label>
                            			<fieldset class="form-group mb-3">
                            				<select name="Status" id="Status" class="js-example-basic-single js-states form-control bg-transparent" >
												<option value="O" {{ count($returheader) > 0 ? $returheader[0]['Status'] == 'O' ? "selected" : '' :""}} >OPEN</option>
												<option disabled="" value="C" {{ count($returheader) > 0 ? $returheader[0]['Status'] == 'C' ? "selected" : '' :""}} >CLOSE</option>
												<option value="D" {{ count($returheader) > 0 ? $returheader[0]['Status'] == 'D' ? "selected" : '' :""}}>CANCEL</option>
												
											</select>
                            			</fieldset>
                            		</div>

                            		<div class="col-md-4">
                            			<label  class="text-body">Pelanggan</label>
                            			<fieldset class="form-group mb-3">
                            				<select name="KodePelanggan" id="KodePelanggan" class="js-example-basic-single js-states form-control bg-transparent" >
												<option value="-1">Pilih Pelanggan</option>
												@foreach($pelanggan as $ko)
													<option value="{{ $ko->KodePelanggan }}">
                                                        {{ $ko->NamaPelanggan }}
                                                    </option>
												@endforeach
												
											</select>
                            			</fieldset>
                            		</div>

                            		<div class="col-md-3">
                            			<label  class="text-body">Refrensi Dokumen</label>
                            			<fieldset class="form-group mb-3">
                            				<select name="BaseType" id="BaseType" class="js-example-basic-single js-states form-control bg-transparent" >
                            					<option value="">Pilih Refrensi Dokumen</option>
                            					<option value="ODLN">Surat Jalan</option>
                            					<option value="OINV">Faktur Penjualan</option>
                            				</select>
                            			</fieldset>
                            		</div>
                            		<div class="col-md-3">
                            			<label  class="text-body">Tanggal Transaksi</label>
                            			<fieldset class="form-group">
                            				<input type="date" class="form-control" id="TglTransaksi" name="TglTransaksi" placeholder="<Auto>" value="{{ count($returheader) > 0 ? $returheader[0]['TglTransaksi'] : '' }}" required="">
                            			</fieldset>
                            		</div>

                            		<div class="col-md-8">
                            			<label  class="text-body"><div id="lblRefrensi">Isi Nomor Faktur Pembelian</div></label>
                            			<fieldset class="form-group mb-3">
                            				<div id="gridBox"></div>
                            			</fieldset>
                            		</div>

                            		

                            		<div class="col-md-6">
                            			<label  class="text-body">No Reff</label>
                            			<fieldset class="form-group mb-3">
                            				<input type="text" class="form-control" id="NoReff" name="NoReff" placeholder="Masukan No Reff" value="{{ count($returheader) > 0 ? $returheader[0]['NoReff'] : '' }}" >
                            			</fieldset>
                            		</div>

                            		<div class="col-md-6">
                            			<label  class="text-body">Keterangan</label>
                            			<fieldset class="form-group mb-3">
                            				<input type="text" class="form-control" id="Keterangan" name="Keterangan" placeholder="Masukan Keterangan" value="{{ count($returheader) > 0 ? $returheader[0]['Keterangan'] : '' }}" >
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
                            					<td><input type="text" align="right" name="TotalTransaksi" id="TotalTransaksi" readonly="" class="form-control aligned-textbox" value="{{ count($returheader) > 0 ? $returheader[0]['TotalTransaksi'] : '0' }}"></td>
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
	var returHeader = [];
	var returDetail = [];
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
	    	jQuery('#TglJatuhTempo').val(NowDay);
	    	// console.log(jQuery('#formtype').val())

	    	returHeader = <?php echo json_encode($returheader); ?>;
	    	returDetail = <?php echo json_encode($returdetail); ?>;
	    	console.log(returDetail)
			if (jQuery('#formtype').val() == "edit") {
				formatCurrency(jQuery('#TotalTransaksi'), returHeader[0]["TotalTransaksi"]);
	      		formatCurrency(jQuery('#Potongan'), returHeader[0]["Potongan"]);
	      		formatCurrency(jQuery('#TotalPembelian'), returHeader[0]["TotalPembelian"]);
	      		StatusTransaksi = returHeader[0]["Status"];
	      		var KodePelanggan = returHeader[0]["KodePelanggan"];
	      		NoOrderPembelian = returDetail[0]["BaseReff"];
				jQuery('#KodePelanggan').val(KodePelanggan).trigger('change');
				jQuery('#BaseType').val(returDetail[0]["BaseType"]).trigger('change');

	      		// console.log(StatusTransaksi)
	      		if (StatusTransaksi != "O") {
	      			jQuery('#KodePelanggan').attr('disabled',true);
	      			jQuery('#TglTransaksi').attr('disabled',true);
	      			jQuery('#NoReff').attr('disabled',true);
	      			jQuery('#Keterangan').attr('disabled',true);
	      			jQuery('#Status').attr('disabled',true);
	      			jQuery('#btSave').attr('disabled',true);
	      		}
	      		BindGridDetail(<?php echo json_encode($returdetail) ?>);
	      		// CreateCombobox([])
	      		var combo = jQuery("#gridBox").dxDropDownBox("instance");
	      		// combo.option("dataSource", NoOrderPembelian);
	      		combo.option("valueExpr", "NoTransaksi");
	      		combo.option("value", NoOrderPembelian);
				console.log(NoOrderPembelian)
				combo.option("disabled", true);
	      		// valueExpr: "NoTransaksi",
			}
			else{
				BindGridDetail([])	
				CreateCombobox([])
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
						'HargaNet' : allRowsData[i]['HargaNet'],
						'BaseReff' : NoOrderPembelian,
						'BaseLine' : allRowsData[i]['BaseLine'],
						'BaseType' : jQuery('#BaseType').val(),
						'KodeGudang' : allRowsData[i]['KodeGudang'],
						'LineStatus':allRowsData[i]['LineStatus'],
						'VatPercent':allRowsData[i]['VatPercent'],
						'HargaPokokPenjualan':allRowsData[i]['HargaPokokPenjualan'],
      				}
      				
      				oDetail.push(oItem)
      			}
      		}

			var oData = {
				'NoTransaksi' : jQuery('#NoTransaksi').val(),
				'TglTransaksi' : jQuery('#TglTransaksi').val(),
				'NoReff' : jQuery('#NoReff').val(),
				'KodePelanggan' : jQuery('#KodePelanggan').val(),
				'TotalTransaksi' : jQuery('#TotalTransaksi').attr("originalvalue"),
				'Status' : jQuery('#Status').val(),
				'Keterangan' : jQuery('#Keterangan').val(),
				'Detail' : oDetail
			}
			// var originalvalue = jQuery("#TotalTransaksi").attr("originalvalue");

			// console.log(oData)
			if (jQuery('#formtype').val() == "add") {
				$.ajax({
					url: "{{route('returpenjualan-storeJson')}}",
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
		                        window.location.href = '{{url("returpenjualan")}}';
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
					url: "{{route('returpenjualan-editJson')}}",
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
		                        window.location.href = '{{url("returpenjualan")}}';
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
		
		jQuery('#BaseType').change(function () {
			var labelText = "";

			console.log("asdasd");

			if (jQuery('#BaseType').val() == "ODLN") {
				labelText = "Pilih Nomor Surat Jalan";

				$.ajax({
		            async:false,
		            type: 'post',
		            url: "{{route('delivery-readheader')}}",
		            headers: {
		                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
		            },
		            data: {
		                'TglAwal' : '1999-01-01',
		                'TglAkhir' : GetDate,
		                'KodePelanggan' :jQuery('#KodePelanggan').val(),
		                'Status' :  (returHeader.length > 0) ? '' : 'O'
		            },
		            dataType: 'json',
		            success: function(response) {
		            	filteredOrderDetail = response.data;
		                CreateCombobox(response.data)
		            }
		        });
			}
			else if (jQuery('#BaseType').val() == "OINV") {
				labelText = "Pilih Nomor Faktur Penjualan";

				$.ajax({
		            async:false,
		            type: 'post',
		            url: "{{route('fpenjualan-readheader')}}",
		            headers: {
		                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
		            },
		            data: {
		                'TglAwal' : '1999-01-01',
		                'TglAkhir' : GetDate,
		                'KodePelanggan' :jQuery('#KodePelanggan').val(),
		                'Status' : (returHeader.length > 0) ? '' : 'O'
		            },
		            dataType: 'json',
		            success: function(response) {
		            	filteredOrderDetail = response.data;
		                CreateCombobox(response.data)
		            }
		        });
			}
			else{
				labelText = "Pilih Refrensi";	
			}

			jQuery('#lblRefrensi').text(labelText);
		});

		function CopyFromOrder(Data) {
			var oData = [];
			if (typeof Data != "undefined" ) {

				if (jQuery('#BaseType').val() == "ODLN") {
					$.ajax({
			            async:false,
			            type: 'post',
			            url: "{{route('delivery-readdetail')}}",
			            headers: {
			                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
			            },
			            data: {
			                'NoTransaksi' : Data.NoTransaksi,
			            },
			            dataType: 'json',
			            success: function(response) {
			                // BindGridOrder(response.data)
			                var index = 1;
			                $.each(response.data,function (k,v) {
			                	var temp = {
			                		'NoUrut' : index,
			                		'BaseLine' : v.NoUrut,
			                		'KodeItem' : v.KodeItem,
			                		'NamaItem' : v.NamaItem,
			                		'KodeGudang' : v.KodeGudang,
			                		'Qty' : parseFloat(v.Qty),
			                		'Satuan' : v.Satuan,
			                		'Harga' : parseFloat(v.Harga),
			                		'VatPercent' : parseFloat(v.VatPercent),
			                		'HargaPokokPenjualan' : parseFloat(v.HargaPokokPenjualan),
			                		'LineStatus' : 'O'
			                	}

			                	oData.push(temp)

			                	index +=1;
			                });
			                
			                BindGridDetail(oData)
			            }
			        });
				}
				else if (jQuery('#BaseType').val() == "OINV") {
					$.ajax({
			            async:false,
			            type: 'post',
			            url: "{{route('fpenjualan-readdetail')}}",
			            headers: {
			                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
			            },
			            data: {
			                'NoTransaksi' : Data.NoTransaksi,
			            },
			            dataType: 'json',
			            success: function(response) {
			                // BindGridOrder(response.data)
			                var index = 1;
			                $.each(response.data,function (k,v) {
			                	var temp = {
			                		'NoUrut' : index,
			                		'BaseLine' : v.NoUrut,
			                		'KodeItem' : v.KodeItem,
			                		'NamaItem' : v.NamaItem,
			                		'KodeGudang' : v.KodeGudang,
			                		'Qty' : parseFloat(v.Qty),
			                		'Satuan' : v.Satuan,
			                		'Harga' : parseFloat(v.Harga),
			                		'VatPercent' : parseFloat(v.VatPercent),
			                		'HargaPokokPenjualan' : parseFloat(v.HargaPokokPenjualan),
			                		'LineStatus' : 'O'
			                	}

			                	oData.push(temp)

			                	index +=1;
			                });
			                
			                BindGridDetail(oData)
			            }
			        });
				}
				else{
					TipeRefrensi = "Pilih Refrensi";	
				}
			}
			CalculateTotal();
		}
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
	      			var Discount = (typeof(allRowsData[i]['Discount'])) == "undefined" ? 0 : allRowsData[i]['Discount'];

      				TotalTransaksi += Qty * Harga;
      			}
      		}

      		formatCurrency(jQuery('#TotalTransaksi'), TotalTransaksi);
		}

		function CreateCombobox(data) {
			var TipeRefrensi = "";

			if (jQuery('#BaseType').val() == "ODLN") {
				TipeRefrensi = "Pilih Nomor Surat Jalan";
			}
			else if (jQuery('#BaseType').val() == "OINV") {
				TipeRefrensi = "Pilih Nomor Faktur Penjualan";
			}
			else{
				TipeRefrensi = "Pilih Refrensi";	
			}
			jQuery('#gridBox').dxDropDownBox({
                displayExpr(item) {
                	if (jQuery('#formtype').val() == "add") {
                		CopyFromOrder(item);
                	}

                	if (typeof item != "undefined") {
	                    NoOrderPembelian = item.NoTransaksi;
			    		return `${item.NoTransaksi}`;
	                }
			    },
			    placeholder: TipeRefrensi,
                dataSource:data,
                // showClearButton: true,
                contentTemplate: function(e) {
                	const value = e.component.option('value');
                	const $dataGrid = jQuery('<div>').dxDataGrid({
				        dataSource: e.component.getDataSource(),
				        columns: ['NoTransaksi', 'TglTransaksi', 'TglJatuhTempo'],
				        hoverStateEnabled: true,
				        paging: { enabled: true, pageSize: 10 },
				        filterRow: { visible: true },
				        scrolling: { mode: 'virtual' },
				        selection: { mode: 'single' },
				        selectedRowKeys: [value],
				        height: '100%',
				        showBorders: true,
				        errorRowEnabled: false,
				        onSelectionChanged(selectedItems) {
				          const keys = selectedItems.selectedRowKeys;
				          const hasSelection = keys.length;

				          e.component.option('value', hasSelection ? keys[0] : "");
				        },
				      });

                	dataGrid = $dataGrid.dxDataGrid('instance');
                	e.component.on('valueChanged', (args) => {
				        dataGrid.selectRows(args.value, false);
				        e.component.close();
				      });
                	return $dataGrid;
                },
			})

			// jQuery("#gridBox").append(customDropDown);
		}

		function BindGridDetail(data) {
			var AllowManipulation = true;
			if (StatusTransaksi != "O") {
				AllowManipulation = false;
			}

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
	                    dataField: "BaseLine",
	                    caption: "#",
	                    allowEditing:false,
	                    allowSorting: false,
	                    visible:false,
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
	                    caption: "Gudang Penerima",
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
	                    caption: "Qty Retur",
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
					    allowEditing:false
	                },
	                {
	                    dataField: "Harga",
	                    caption: "Harga",
	                    allowEditing:false,
	                    format: { type: 'fixedPoint', precision: 2 },
	                    allowSorting: false 
	                },
	                {
	                    dataField: "VatPercent",
	                    caption: "PPN (%)",
	                    allowEditing:false,
	                    format: { type: 'fixedPoint', precision: 2 },
	                    allowSorting: false 
	                },
	                {
	                    dataField: "HargaPokokPenjualan",
	                    caption: "HPP",
	                    allowEditing:false,
	                    format: { type: 'fixedPoint', precision: 2 },
	                    allowSorting: false 
	                },
	                {
	                    dataField: "HargaNet",
	                    caption: "HargaNet",
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
	                {
	                    dataField: "LineStatus",
	                    caption: "LineStatus",
	                    allowEditing:false,
	                    allowSorting: false,
	                    visible:false 
	                },
	            ],
			    onContentReady: function(e) {
			    	CalculateTotal();
		        },
		        onCellClick:function (e) {
		        	// console.log(dataGridInstance.option("dataSource"))
		            var rowData = dataGridInstance.option("dataSource");
		            var columnIndex = e.columnIndex;
		            
		        	if (columnIndex >= 1 && columnIndex <= 5) {
		                dataGridInstance.editRow(e.rowIndex)	
		            }
		            dataGridInstance.option("focusedColumnIndex", columnIndex);	
		        },
			}).dxDataGrid('instance');

			var xItem = '<?php echo json_encode($item); ?>'
			var oItem = JSON.parse(xItem);

			// dx-link dx-link-edit


			// console.log(dataGridInstance)
			var allRowsData  = dataGridInstance.option("dataSource");
        	var newData = { NoUrut: allRowsData.length + 1,BaseLine:-1,KodeItem:"",KodeGudang:"", Qty: 0, Satuan: "", Harga:0, HargaNet:0,LineStatus:'' }
        	dataGridInstance.option("dataSource", [...dataGridInstance.option("dataSource"), newData]);
        	dataGridInstance.refresh();


        	dataGridInstance.on('rowUpdated', function(e) {
        		// console.log(e)
        		CalculateTotal();
        	})
        	// Validasi duplicate Row
        	dataGridInstance.on('dataErrorOccurred',function (e) {
			
				alert("Data Sudah terpakai di baris lain");
				e.error.message = "Data Sudah terpakai di baris lain";
				e.error.url = "";
				dataGridInstance.refresh();
				dataGridInstance.cancelEditData();
				// SetEnableCommand();
			});

        	dataGridInstance.on('editorPreparing',function (e) {
				if (e.parentType === "dataRow" && e.dataField === "KodeItem") {
			        e.editorOptions.onFocusOut = (x) => {
			            // same here
			            var rowIndex = dataGridInstance.getRowIndexByKey(e.row.key);
			            var allRowsData  = dataGridInstance.getDataSource().items();

			            var Satuan = "";
			            for (var i = 0; i < oItem.length; i++) {
			            	// console.log(e.row.values)
			            	if (oItem[i].KodeItem == e.row.cells[1].value) {
			            		Satuan = oItem[i].Satuan;
			            		break;
			            	}
			            }

			            // x.component.option("value", "Test2");
			            // console.log(e.row.cells[0].value)
			            // console.log(selectedItem)
			            dataGridInstance.cellValue(rowIndex, "Qty", 1);
			            dataGridInstance.cellValue(rowIndex, "Harga", 0);
			            dataGridInstance.cellValue(rowIndex, "Discount", 0);
			            dataGridInstance.cellValue(rowIndex, "HargaNet", 0);
			            dataGridInstance.cellValue(rowIndex, "Satuan", Satuan);
			            // dataGridInstance.cellValue(rowIndex, "Qty", 1);

			            dataGridInstance.refresh()

			            var $focusedRow = jQuery(e.component._$focusedRowElement);
	                    var $saveButton = $focusedRow.find(".dx-link dx-link-save");
	                    
	                    if ($saveButton.length) {
	                        $saveButton.trigger("click");
	                    }

	                    dataGridInstance.saveEditData();
	                    

	                    var allRowsData  = dataGridInstance.option("dataSource");
	                    var newData = { NoUrut: allRowsData.length + 1,BaseLine:-1,KodeItem:"",KodeGudang:"", Qty: 0, Satuan: "", Harga:0, HargaNet:0,LineStatus:'' }
        				dataGridInstance.option("dataSource", [...dataGridInstance.option("dataSource"), newData]);
        				dataGridInstance.refresh();
			        }
			        e.editorOptions.onFocusIn = (x) => {
			        	console.log(x)
			        }
			    }
			    else if (e.parentType === "dataRow" && e.dataField === "Qty") {
			    	e.editorOptions.onFocusOut = (x) => {
			    		dataGridInstance.saveEditData();
			    	}
			    }

			    else if (e.parentType === "dataRow" && e.dataField === "Satuan") {
			    	e.editorOptions.onFocusOut = (x) => {
			    		dataGridInstance.saveEditData();
			    	}
			    }

			    else if (e.parentType === "dataRow" && e.dataField === "KodeGudang") {
			    	e.editorOptions.onFocusOut = (x) => {
			    		dataGridInstance.saveEditData();
			    	}
			    }
			    // SetEnableCommand();
			})
		}

	});

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