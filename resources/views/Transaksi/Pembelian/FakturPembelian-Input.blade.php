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
					<a href="{{route('fpembelian')}}">Daftar Faktur Pembelian</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Faktur Pembelian</li>
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
										@if (count($fakturheader) > 0)
											<input type="hidden" name="formtype" id="formtype" value="edit">
                                    		Edit Faktur Pembelian
	                                	@else
	                                		<input type="hidden" name="formtype" id="formtype" value="add">
	                                    	Tambah Faktur Pembelian
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
                            				<input type="text" class="form-control" id="NoTransaksi" name="NoTransaksi" placeholder="<Auto>" value="{{ count($fakturheader) > 0 ? $fakturheader[0]['NoTransaksi'] : '' }}" required="">
                            			</fieldset>
                            			
                            		</div>

                            		<div class="col-md-3">
                            			<label  class="text-body">Status</label>
                            			<fieldset class="form-group mb-3">
                            				<select name="Status" id="Status" class="js-example-basic-single js-states form-control bg-transparent" >
												<option value="O" {{ count($fakturheader) > 0 ? $fakturheader[0]['Status'] == 'O' ? "selected" : '' :""}} >OPEN</option>
												<option value="C" {{ count($fakturheader) > 0 ? $fakturheader[0]['Status'] == 'C' ? "selected" : '' :""}} >CLOSE</option>
												<option value="D" {{ count($fakturheader) > 0 ? $fakturheader[0]['Status'] == 'D' ? "selected" : '' :""}}>CANCEL</option>
												
											</select>
                            			</fieldset>
                            		</div>

                            		<div class="col-md-6">
                            			<label  class="text-body">Supplier</label>
                            			<fieldset class="form-group mb-3">
                            				<select name="KodeSupplier" id="KodeSupplier" class="js-example-basic-single js-states form-control bg-transparent" >
												<option value="-1">Pilih Supplier</option>
												@foreach($supplier as $ko)
													<option 
                                                        value="{{ $ko->KodeSupplier }}"
                                                        {{ count($fakturheader) > 0 ? $fakturheader[0]['KodeSupplier'] == $ko->KodeSupplier ? "selected" : '' :""}}
                                                    >
                                                        {{ $ko->NamaSupplier }}
                                                    </option>
												@endforeach
												
											</select>
                            			</fieldset>
                            		</div>

                            		<div class="col-md-12">
                            			<label  class="text-body">Isi Nomor Order</label>
                            			<fieldset class="form-group mb-3">
                            				<div id="gridBox"></div>
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
                                                        {{ count($fakturheader) > 0 ? $fakturheader[0]['KodeTermin'] == $ko->id ? "selected" : '' :""}}
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
                            				<input type="date" class="form-control" id="TglTransaksi" name="TglTransaksi" placeholder="<Auto>" value="{{ count($fakturheader) > 0 ? $fakturheader[0]['TglTransaksi'] : '' }}" required="">
                            			</fieldset>
                            		</div>

                            		<div class="col-md-3">
                            			<label  class="text-body">Tanggal Jatuh Tempo</label>
                            			<fieldset class="form-group mb-3">
                            				<input type="date" class="form-control" id="TglJatuhTempo" name="TglJatuhTempo" placeholder="<Auto>" value="{{ count($fakturheader) > 0 ? $fakturheader[0]['TglJatuhTempo'] : '' }}" required="">
                            			</fieldset>
                            		</div>

                            		<div class="col-md-6">
                            			<label  class="text-body">No Reff</label>
                            			<fieldset class="form-group mb-3">
                            				<input type="text" class="form-control" id="NoReff" name="NoReff" placeholder="Masukan No Reff" value="{{ count($fakturheader) > 0 ? $fakturheader[0]['NoReff'] : '' }}" >
                            			</fieldset>
                            		</div>

                            		<div class="col-md-12">
                            			<label  class="text-body">Keterangan</label>
                            			<fieldset class="form-group mb-3">
                            				<input type="text" class="form-control" id="Keterangan" name="Keterangan" placeholder="Masukan Keterangan" value="{{ count($fakturheader) > 0 ? $fakturheader[0]['Keterangan'] : '' }}" >
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
                            					<td><input type="text" align="right" name="TotalTransaksi" id="TotalTransaksi" class="form-control aligned-textbox" value="{{ count($fakturheader) > 0 ? $fakturheader[0]['TotalTransaksi'] : '0' }}" readonly=""></td>
                            				</tr>
                            				<tr>
                            					<td>Diskon</td>
                            					<td>:</td>
                            					<td><input type="text" align="right" name="Potongan" id="Potongan" readonly="" class="form-control aligned-textbox" value="{{ count($fakturheader) > 0 ? $fakturheader[0]['Potongan'] : '0' }}"></td>
                            				</tr>
                            				<tr>
                            					<td>PPN</td>
                            					<td>:</td>
                            					<td><input type="text" align="right" name="Pajak" id="Pajak" readonly="" class="form-control aligned-textbox" value="{{ count($fakturheader) > 0 ? $fakturheader[0]['Pajak'] : '0' }}"></td>
                            				</tr>
                            				<tr>
                            					<td>Total</td>
                            					<td>:</td>
                            					<td><input type="text" align="right" name="TotalPembelian" id="TotalPembelian" readonly="" class="form-control aligned-textbox" value="{{ count($fakturheader) > 0 ? $fakturheader[0]['TotalPembelian'] : '0' }}"></td>
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

	    	orderHeader = <?php echo json_encode($fakturheader); ?>;
	    	console.log(orderHeader)
			if (jQuery('#formtype').val() == "edit") {
				formatCurrency(jQuery('#TotalTransaksi'), orderHeader[0]["TotalTransaksi"]);
	      		formatCurrency(jQuery('#Potongan'), orderHeader[0]["Potongan"]);
	      		formatCurrency(jQuery('#TotalPembelian'), orderHeader[0]["TotalPembelian"]);
	      		StatusTransaksi = orderHeader[0]["Status"];

	      		// console.log(StatusTransaksi)
	      		if (StatusTransaksi != "O") {
	      			jQuery('#KodeSupplier').attr('disabled',true);
	      			jQuery('#KodeTermin').attr('disabled',true);
	      			jQuery('#TglTransaksi').attr('disabled',true);
	      			jQuery('#TglJatuhTempo').attr('disabled',true);
	      			jQuery('#NoReff').attr('disabled',true);
	      			jQuery('#Keterangan').attr('disabled',true);
	      		}
	      		BindGridDetail(<?php echo json_encode($orderdetail) ?>);
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

		jQuery('#KodeSupplier').change(function () {
			$.ajax({
	            async:false,
	            type: 'post',
	            url: "{{route('opembelian-readheader')}}",
	            headers: {
	                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
	            },
	            data: {
	                'TglAwal' : '1999-01-01',
	                'TglAkhir' : GetDate,
	                'KodeVendor' :jQuery('#KodeSupplier').val(),
	                'Status' : 'O'
	            },
	            dataType: 'json',
	            success: function(response) {
	                CreateCombobox(response.data)
	            }
	        })
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
      		console.log(allRowsData)
      		var oDetail = [];

      		for (var i = 0; i < allRowsData.length; i++) {
      			// Things[i]
      			if (allRowsData[i]['KodeItem'] != "") {

      				var oItem = {
      					'NoUrut' : allRowsData[i]['NoUrut'],
						'KodeItem' : allRowsData[i]['KodeItem'],
						'Qty' : allRowsData[i]['QtyFaktur'],
						'Satuan' : allRowsData[i]['Satuan'],
						'Harga' : allRowsData[i]['Harga'],
						'Discount' : allRowsData[i]['Discount'],
						'HargaNet' : allRowsData[i]['HargaNet'],
						'BaseReff' : NoOrderPembelian,
						'BaseLine' : allRowsData[i]['BaseLine'],
						'KodeGudang' : allRowsData[i]['KodeGudang'],
      				}
      				
      				oDetail.push(oItem)
      			}
      		}

			var oData = {
				'NoTransaksi' : jQuery('#NoTransaksi').val(),
				'TglTransaksi' : jQuery('#TglTransaksi').val(),
				'TglJatuhTempo' : jQuery('#TglJatuhTempo').val(),
				'NoReff' : jQuery('#NoReff').val(),
				'KodeSupplier' : jQuery('#KodeSupplier').val(),
				'KodeTermin' : jQuery('#KodeTermin').val(),
				'Termin' : TotalTermin,
				'TotalTransaksi' : jQuery('#TotalTransaksi').attr("originalvalue"),
				'Potongan' : jQuery('#Potongan').attr("originalvalue"),
				'Pajak' : 0,
				'TotalPembelian' : jQuery('#TotalPembelian').attr("originalvalue"),
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
					url: "{{route('fpembelian-storeJson')}}",
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
		                        window.location.href = '{{url("fpembelian")}}';
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
					url: "{{route('fpembelian-editJson')}}",
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
		                        window.location.href = '{{url("fpembelian")}}';
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
		

		function CopyFromOrder(Data) {
			var oData = [];
			$.ajax({
	            async:false,
	            type: 'post',
	            url: "{{route('opembelian-readdetail')}}",
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
	                		'KodeGudang' : "",
	                		'QtyOrder'	: parseFloat(v.Qty),
	                		'QtyFaktur' : 0,
	                		'Satuan' : v.Satuan,
	                		'Harga' : parseFloat(v.Harga),
	                		'Discount' : parseFloat(v.Discount)
	                	}

	                	oData.push(temp)

	                	index +=1;
	                });
	                console.log(oData)
	                BindGridDetail(oData)
	            }
	        });

			// Get Header
	        $.ajax({
	            async:false,
	            type: 'post',
	            url: "{{route('opembelian-findheader')}}",
	            headers: {
	                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
	            },
	            data: {
	                'NoTransaksi' : Data.NoTransaksi,
	            },
	            dataType: 'json',
	            success: function(response) {
	                jQuery('#KodeTermin').val(response.data[0]["KodeTermin"]).trigger('change');
	                jQuery('#TglTransaksi').val(response.data[0]["TglTransaksi"]);
	                jQuery('#TglJatuhTempo').val(response.data[0]["TglJatuhTempo"]);
	                jQuery('#NoReff').val(response.data[0]["NoReff"]);
	                jQuery('#Keterangan').val(response.data[0]["Keterangan"]);
	            }
	        })

	        CalculateTotal();
		}
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

      			if (allRowsData[i]['KodeItem'] != "") {

      				console.log(allRowsData[i]['QtyFaktur'])
      				var Qty = (typeof(allRowsData[i]['QtyFaktur'])) === "undefined" ? 0 : allRowsData[i]['QtyFaktur'];
	      			var Harga = (typeof(allRowsData[i]['Harga'])) == "undefined" ? 0 : allRowsData[i]['Harga'];
	      			var Discount = (typeof(allRowsData[i]['Discount'])) == "undefined" ? 0 : allRowsData[i]['Discount'];

      				TotalTransaksi += Qty * Harga;
      				console.log(TotalTransaksi)
	      			if (Discount > 0) {

	      				var diskon = TotalTransaksi * Discount / 100
	      				TotalPotongan += parseFloat(diskon);
	      			}
      			}
      		}

      		formatCurrency(jQuery('#TotalTransaksi'), TotalTransaksi);
      		formatCurrency(jQuery('#Potongan'), TotalPotongan);
      		formatCurrency(jQuery('#TotalPembelian'), TotalTransaksi - TotalPotongan);
		}

		function CreateCombobox(data) {
			jQuery('#gridBox').dxDropDownBox({
                displayExpr(item) {
                	CopyFromOrder(item);
                	NoOrderPembelian = item.NoTransaksi;
			    	return `${item.NoTransaksi}`;
			    },
			    placeholder: 'Pilih Nomor Order',
                dataSource:data,
                showClearButton: true,
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
                }
			})

			// jQuery("#gridBox").append(customDropDown);
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
	                    dataField: "BaseLine",
	                    caption: "#",
	                    allowEditing:false,
	                    allowSorting: false,
	                    visible:false,
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
	                    dataField: "QtyOrder",
	                    caption: "Qty Order",
	                    allowEditing:false,
	                    format: { type: 'fixedPoint', precision: 2 },
	                    allowSorting: false 
	                },
	                {
	                    dataField: "QtyFaktur",
	                    caption: "Qty Faktur",
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
	                    		HargaNet = rowData.QtyFaktur * rowData.Harga;
	                    		HargaGross = rowData.QtyFaktur * rowData.Harga;
	                    	}
	                    	else{
	                    		console.log("HargaGross = " + HargaGross)
	                    		HargaGross = rowData.QtyFaktur * rowData.Harga;

	                    		var diskon = HargaGross * rowData.Discount / 100
	                    		console.log("Diskon = " + diskon)
	                    		HargaNet = HargaGross - diskon;
	                    	}

	                    	return HargaNet
	                    },
	                    allowSorting: false 
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

			console.log(dataGridInstance)

			var xItem = '<?php echo json_encode($item); ?>'
			var oItem = JSON.parse(xItem);

			// dx-link dx-link-edit


			// console.log(dataGridInstance)
			var allRowsData  = dataGridInstance.option("dataSource");
        	var newData = { NoUrut: allRowsData.length + 1,KodeItem:"",KodeGudang:"", Qty: 0, Satuan: "", Harga:0, Discount:0, HargaNet:0 }
        	dataGridInstance.option("dataSource", [...dataGridInstance.option("dataSource"), newData]);
        	dataGridInstance.refresh();

        	dataGridInstance.on('rowUpdated', function(e) {
        		// console.log(e)
        		CalculateTotal();
        	})
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
				if (e.parentType === "dataRow" && e.dataField === "KodeItem") {
			        e.editorOptions.onFocusOut = (x) => {
			            // same here
			            var rowIndex = dataGridInstance.getRowIndexByKey(e.row.key);
			            var allRowsData  = dataGridInstance.getDataSource().items();

			            var Satuan = "";
			            for (var i = 0; i < oItem.length; i++) {
			            	console.log(oItem[i].KodeItem + " == " +e.row.cells[1].value);
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
	                    console.log($focusedRow);
	                    if ($saveButton.length) {
	                        $saveButton.trigger("click");
	                    }

	                    dataGridInstance.saveEditData();
	                    

	                    var allRowsData  = dataGridInstance.option("dataSource");
	                    var newData = { NoUrut: allRowsData.length+1,KodeItem:"", Qty: 0, Satuan: "", Harga:0, Discount:0, HargaNet:0 }
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