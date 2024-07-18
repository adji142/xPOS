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
					<a href="{{route('pembayaranpembeliankonsinyasi')}}">Daftar Pembayaran</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Pembayaran</li>
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
										@if (count($pembayarankonsinyasiheader) > 0)
											<input type="hidden" name="formtype" id="formtype" value="edit">
                                    		Edit Pembayaran
	                                	@else
	                                		<input type="hidden" name="formtype" id="formtype" value="add">
	                                    	Tambah Pembayaran
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
                            				<input type="text" class="form-control" id="NoTransaksi" name="NoTransaksi" placeholder="<Auto>" value="{{ count($pembayarankonsinyasiheader) > 0 ? $pembayarankonsinyasiheader[0]['NoTransaksi'] : '' }}" required="">
                            			</fieldset>
                            		</div>

                            		<div class="col-md-3">
                            			<label  class="text-body">Tanggal Transaksi</label>
                            			<fieldset class="form-group mb-3">
                            				<input type="date" class="form-control" id="TglTransaksi" name="TglTransaksi" placeholder="<Auto>" value="{{ count($pembayarankonsinyasiheader) > 0 ? $pembayarankonsinyasiheader[0]['TglTransaksi'] : '' }}" required="">
                            			</fieldset>
                            		</div>

                            		<div class="col-md-3">
                            			<label  class="text-body">Supplier</label>
                            			<fieldset class="form-group mb-3">
                            				<select name="KodeSupplier" id="KodeSupplier" class="js-example-basic-single js-states form-control bg-transparent" >
												<option value="">Pilih Supplier</option>
												@foreach($supplier as $ko)
													<option 
                                                        value="{{ $ko->KodeSupplier }}"
                                                        {{ count($pembayarankonsinyasiheader) > 0 ? $pembayarankonsinyasiheader[0]['KodeSupplier'] == $ko->KodeSupplier ? "selected" : '' :""}}
                                                    >
                                                        {{ $ko->NamaSupplier }}
                                                    </option>
												@endforeach
												
											</select>
                            			</fieldset>
                            		</div>

                            		<div class="col-md-3">
                            			<label  class="text-body">Status</label>
                            			<fieldset class="form-group mb-3">
                            				<select name="Status" id="Status" class="js-example-basic-single js-states form-control bg-transparent" >
												<option value="O" {{ count($pembayarankonsinyasiheader) > 0 ? $pembayarankonsinyasiheader[0]['Status'] == 'O' ? "selected" : '' :""}} >OPEN</option>
												<option disabled="" value="C" {{ count($pembayarankonsinyasiheader) > 0 ? $pembayarankonsinyasiheader[0]['Status'] == 'C' ? "selected" : '' :""}} >CLOSE</option>
												<option value="D" {{ count($pembayarankonsinyasiheader) > 0 ? $pembayarankonsinyasiheader[0]['Status'] == 'D' ? "selected" : '' :""}}>CANCEL</option>
												
											</select>
                            			</fieldset>
                            		</div>

                            		<div class="col-md-6">
                            			<label  class="text-body">Metode Pembayaran</label>
                            			<fieldset class="form-group mb-3">
                            				<select name="KodeMetodePembayaran" id="KodeMetodePembayaran" class="js-example-basic-single js-states form-control bg-transparent" >
												<option value="-1">Pilih Metode Pembayaran</option>
												@foreach($metodepembayaran as $ko)
													<option 
                                                        value="{{ $ko->id }}"
                                                        {{ count($pembayarankonsinyasiheader) > 0 ? $pembayarankonsinyasiheader[0]['KodeMetodePembayaran'] == $ko->id ? "selected" : '' :""}}
                                                    >
                                                        {{ $ko->NamaMetodePembayaran }}
                                                    </option>
												@endforeach
												
											</select>
                            			</fieldset>
                            		</div>

                            		<div class="col-md-6">
                            			<label  class="text-body">No. Reff</label>
                            			<fieldset class="form-group mb-3">
                            				<input type="text" class="form-control" id="NoReff" name="NoReff" placeholder="Nomor Refrensi" value="{{ count($pembayarankonsinyasiheader) > 0 ? $pembayarankonsinyasiheader[0]['NoReff'] : '' }}" required="">
                            			</fieldset>
                            		</div>

                            		<div class="col-md-12">
                            			<label  class="text-body">Keterangan</label>
                            			<fieldset class="form-group mb-3">
                            				<input type="text" class="form-control" id="Keterangan" name="Keterangan" placeholder="<Auto>" value="{{ count($pembayarankonsinyasiheader) > 0 ? $pembayarankonsinyasiheader[0]['Keterangan'] : '' }}" required="">
                            			</fieldset>
                            		</div>
                                    <div class="col-md-12">
                                        <center>
                                            <label  class="text-body">Periode Penjualan</label>
                                        </center>
                                    </div>
                                    <div class="col-md-4">
                            			<label  class="text-body">Tanggal Awal</label>
                            			<fieldset class="form-group mb-3">
                            				<input type="date" class="form-control" id="TglAwal" name="TglAwal" >
                            			</fieldset>
                            		</div>
                                    <div class="col-md-4">
                            			<label  class="text-body">Tanggal Akhir</label>
                            			<fieldset class="form-group mb-3">
                            				<input type="date" class="form-control" id="TglAkhir" name="TglAkhir" >
                            			</fieldset>
                            		</div>
                                    <div class="col-md-4">
                            			<label  class="text-body">.</label>
                            			<fieldset class="form-group mb-3">
                            				<button type="button" id="btKalkulasi" class="btn btn-warning text-white font-weight-bold me-1 mb-1">Kalkulasi</button>
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
                            					<td>Total Pembayaran</td>
                            					<td>:</td>
                            					<td><input type="text" align="right" name="TotalPembayaran" id="TotalPembayaran" readonly="" class="form-control aligned-textbox" value="{{ count($pembayarankonsinyasiheader) > 0 ? $pembayarankonsinyasiheader[0]['TotalPembayaran'] : '0' }}"></td>
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
    var pembayaranHeader = [];
	var pembayaranDetail = [];

    jQuery(function () {
        jQuery(document).ready(function() {
            var now = new Date();
	    	var day = ("0" + now.getDate()).slice(-2);
	    	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	    	var firstDay = now.getFullYear()+"-"+month+"-01";
	    	var NowDay = now.getFullYear()+"-"+month+"-"+day;

	    	jQuery('#TglTransaksi').val(NowDay);
            jQuery('#TglAwal').val(firstDay);
            jQuery('#TglAkhir').val(NowDay);
        });

        jQuery('#btKalkulasi').click(function(){
            $.ajax({
	            async:false,
	            type: 'post',
	            url: "{{route('pembayaranpembeliankonsinyasi-readpenjualan')}}",
	            headers: {
	                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
	            },
	            data: {
	                'TglAwal' : jQuery('#TglAwal').val(),
	                'TglAkhir' : jQuery('#TglAkhir').val(),
	                'KodeVendor' :jQuery('#KodeSupplier').val()
	            },
	            dataType: 'json',
	            success: function(response) {

	                BindGridDetail(response.data);
	            }
	        })
        });

		jQuery('#btSave').click(function () {
			jQuery('#btSave').text('Tunggu Sebentar.....');
      		jQuery('#btSave').attr('disabled',true);

      		if (jQuery('#KodeSupplier').val() == "") {
      			Swal.fire({
                  icon: "error",
                  title: "Opps...",
                  text: "Supplier Harus di isi",
                })
                jQuery('#btSave').text('Save');
                jQuery('#btSave').attr('disabled',false);
                jQuery('#KodeSupplier').focus();
                return;
      		}

      		if (jQuery('#KodeMetodePembayaran').val() == "-1") {
      			Swal.fire({
                  icon: "error",
                  title: "Opps...",
                  text: "Metode Pembayaran Harus di isi",
                })
                jQuery('#btSave').text('Save');
                jQuery('#btSave').attr('disabled',false);
                jQuery('#KodeSupplier').focus();
                return;
      		}

      		var dataGridInstance = jQuery('#gridContainerDetail').dxDataGrid('instance');
      		var allRowsData  = dataGridInstance.getSelectedRowsData();
      		console.log(allRowsData)
      		var oDetail = [];

      		for (var i = 0; i < allRowsData.length; i++) {
      			// Things[i]
      			if (allRowsData[i]['KodeItem'] != "") {

      				var oItem = {
						'BaseReff' : allRowsData[i]['NoTransaksi'],
						'BaseLine' : allRowsData[i]['NoUrut'],
						'TotalPembayaran' : allRowsData[i]['TotalTransaksi'],
						'KodeMetodePembayaran' : jQuery('#KodeMetodePembayaran').val(),
						'Keterangan' : jQuery('#Keterangan').val()
      				}
      				
      				oDetail.push(oItem)
      			}
      		}

      		var oData = {
				'NoTransaksi' : jQuery('#NoTransaksi').val(),
				'TglTransaksi' : jQuery('#TglTransaksi').val(),
				'KodeSupplier' : jQuery('#KodeSupplier').val(),
				'Status' : jQuery('#Status').val(),
				'KodeMetodePembayaran' : jQuery('#KodeMetodePembayaran').val(),
				'NoReff' : jQuery('#NoReff').val(),
				'Keterangan' : jQuery('#Keterangan').val(),
				'TotalPembayaran' : jQuery('#TotalPembayaran').attr("originalvalue"),
				'Detail' : oDetail
			}

			if (jQuery('#formtype').val() == "add") {
				$.ajax({
					url: "{{route('pembayaranpembeliankonsinyasi-storeJson')}}",
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
		                        window.location.href = '{{url("pembayaranpembeliankonsinyasi")}}';
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
					url: "{{route('pembayaranpembeliankonsinyasi-editJson')}}",
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
		                        window.location.href = '{{url("pembayaranpembeliankonsinyasi")}}';
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

        function BindGridDetail(data) {
            var dataGridInstance = jQuery("#gridContainerDetail").dxDataGrid({
				allowColumnResizing: true,
				dataSource: data,
				keyExpr: "NoTransaksi",
				showBorders: true,
	            allowColumnResizing: true,
	            columnAutoWidth: true,
	            showBorders: true,
	            paging: {
	                enabled: true,
	                pageSize: 30
	            },
	            editing: {
	                mode: "cell",
	                allowUpdating: true,
	                texts: {
	                    confirmDeleteMessage: ''  
	                }
	            },
                selection:{
                    mode:'multiple'
                },
	            columns: [
                    {
	                    dataField: "NamaItem",
	                    caption: "Item",
	                    allowEditing:false,
	                    allowSorting: true,
                        groupIndex:0
	                },
                    {
	                    dataField: "NoTransaksi",
	                    caption: "No. TRX",
	                    allowEditing:false,
	                    allowSorting: true,
	                },
                    {
	                    dataField: "NamaSupplier",
	                    caption: "Supplier",
	                    allowEditing:false,
	                    allowSorting: true,
	                },
	                {
	                    dataField: "KodeItem",
	                    caption: "KodeItem",
	                    allowEditing:false,
	                    allowSorting: true,
	                },
					{
	                    dataField: "NoUrut",
	                    caption: "#",
	                    allowEditing:false,
	                    allowSorting: true,
	                },
                    {
	                    dataField: "Qty",
	                    caption: "Terjual",
	                    allowEditing:false,
	                    format: { type: 'fixedPoint', precision: 2 },
	                    allowSorting: true 
	                },
	                {
	                    dataField: "TotalTransaksi",
	                    caption: "Total Transaksi",
	                    allowEditing:false,
	                    format: { type: 'fixedPoint', precision: 2 },
	                    allowSorting: true 
	                },
	            ],
                onSelectionChanged: function(e) {
                    CalculateTotal();
                },
			}).dxDataGrid('instance');
        } 
        
        function CalculateTotal() {
			var dataGridInstance = jQuery('#gridContainerDetail').dxDataGrid('instance');
      		var allRowsData  = dataGridInstance.getSelectedRowsData();
      		var TotalPembayaran = 0;

      		console.log(allRowsData)
      		for (var i = 0; i < allRowsData.length; i++) {
      			console.log(allRowsData[i]['QtyFaktur'])
      			TotalPembayaran += (typeof(allRowsData[i]['TotalTransaksi'])) == "undefined" ? 0 : allRowsData[i]['TotalTransaksi'];
      		}

      		formatCurrency(jQuery('#TotalPembayaran'), TotalPembayaran);
		}
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
    });
</script>
@endpush