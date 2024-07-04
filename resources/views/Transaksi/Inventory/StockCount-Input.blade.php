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
					<a href="{{route('gr')}}">Daftar Stock Opname History</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Stock Opname</li>
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
										@if (count($stockcountheader) > 0)
											<input type="hidden" name="formtype" id="formtype" value="edit">
                                    		Edit Stock Opname
	                                	@else
	                                		<input type="hidden" name="formtype" id="formtype" value="add">
	                                    	Tambah Stock Opname
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
                            				<input type="text" class="form-control" id="NoTransaksi" name="NoTransaksi" placeholder="<Auto>" value="{{ count($stockcountheader) > 0 ? $stockcountheader[0]['NoTransaksi'] : '' }}" required="">
                            			</fieldset>
                            			
                            		</div>

                            		<div class="col-md-3">
                            			<label  class="text-body">Tanggal Transaksi</label>
                            			<fieldset class="form-group mb-3">
                            				<input type="date" class="form-control" id="TglTransaksi" name="TglTransaksi" placeholder="<Auto>" value="{{ count($stockcountheader) > 0 ? $stockcountheader[0]['TglTransaksi'] : '' }}" required="">
                            			</fieldset>
                            		</div>

                                    <div class="col-md-3">
                            			<label  class="text-body">Karyawan</label>
                            			<fieldset class="form-group mb-3">
                            				<select class="js-example-basic-single js-states form-control bg-transparent" id="KodeKaryawan" name="KodeKaryawan">
												<option value="">Pilih Karyawan</option>
												@foreach($sales as $ko)
													<option value="{{ $ko->KodeSales }}">
	                                                    {{ $ko->NamaSales }}
	                                                </option>
												@endforeach
											</select>
                            			</fieldset>
                            		</div>

									<div class="col-md-3">
                            			<label  class="text-body">Gudang</label>
                            			<fieldset class="form-group mb-3">
                            				<select class="js-example-basic-single js-states form-control bg-transparent" id="KodeGudang" name="KodeGudang">
												<option value="">Pilih Gudang</option>
												@foreach($gudang as $ko)
													<option value="{{ $ko->KodeGudang }}">
	                                                    {{ $ko->NamaGudang }}
	                                                </option>
												@endforeach
											</select>
                            			</fieldset>
                            		</div>

                            		<div class="col-md-12">
                            			<label  class="text-body">Keterangan</label>
                            			<fieldset class="form-group mb-3">
                            				<input type="text" class="form-control" id="Keterangan" name="Keterangan" placeholder="Masukan Keterangan" value="{{ count($stockcountheader) > 0 ? $stockcountheader[0]['Keterangan'] : '' }}" >
                            			</fieldset>
                            		</div>

                                    {{-- <div class="col-md-3 col-6">
                                        <div class="card card-custom gutter-b bg-white border-0" style="cursor: pointer;" id="cardMulai">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <center>
                                                            <h3 class="card-label mb-0 font-weight-bold text-body ">Jam Mulai
                                                            </h3><br>
                                                            <h2 style="color: red">
                                                                <div id="TglMulai">-</div>
                                                                <div id="JamMulai">-</div>
                                                            </h2>
                                                            <small>Klik / tab untuk mulai</small>
                                                        </center>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-6">
                                        <div class="card card-custom gutter-b bg-white border-0" style="cursor: pointer;" id="cardSelesai">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <center>
                                                            <h3 class="card-label mb-0 font-weight-bold text-body ">Jam Selesai
                                                            </h3><br>
                                                            <h2 style="color: green">
                                                                <div id="TglSelesai">-</div>
                                                                <label id="selesaiHour"></label> :
                                                                <label id="selesaiMin"></label> :
                                                                <label id="selesaiSec"></label>
                                                            </h2>
                                                            <small>Klik / tab untuk Mengakhiri</small>
                                                        </center>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}

                                    <div class="col-md-3 col-6">
                                        <div class="card card-custom gutter-b bg-white border-0" id="cardSelesai">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <center>
                                                            <h3 class="card-label mb-0 font-weight-bold text-body ">Total Stock
                                                            </h3><br>
                                                            <h1 style="color: brown" id="_TotalStock">0</h1>
                                                        </center>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-6">
                                        <div class="card card-custom gutter-b bg-white border-0" id="cardSelesai">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <center>
                                                            <h3 class="card-label mb-0 font-weight-bold text-body ">Total Opname
                                                            </h3><br>
                                                            <h1 style="color: chartreuse" id="_TotalOpname">0</h1>
                                                        </center>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-10">
										<label >Select Product</label>
										<fieldset class="form-group mb-0 d-flex barcodeselection">
											<select class="form-control w-25" id="exampleFormControlSelect1">
												<option>Barcode / Nama / Kode</option>
											  </select>
											<input type="text" class="form-control border-dark" id="_Barcode" placeholder="Scan Barcode / Nama Item / Kode Item">
										</fieldset>
									</div>
									<div class="col-md-2">
										<label >Jumlah</label>
										<fieldset class="form-group mb-0 d-flex barcodeselection">
											<input type="number" class="form-control border-dark" id="_Qty" placeholder="" value="1">
										</fieldset>
									</div>

                                    <span style="margin: 0 10px;"></span>
                                    <label> <font color="Red">F2</font> - Edit Qty Item Terakhir </label>
									<span style="margin: 0 10px;"></span>

                            		<div class="col-md-12">
                            			<div class="dx-viewport demo-container">
						                	<div id="data-grid-demo">
						                  		<div id="gridContainerDetail"></div>
						                	</div>
						              	</div>
                            		</div>

                            		<div class="col-md-12">
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

<div class="modal fade text-left" id="LookupItem" tabindex="-1" role="dialog" aria-labelledby="LookupItem" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h3 class="modal-title" id="myModalLabel1444">Add Shipping Cost</h3>
			<button type="button" class="close rounded-pill btn btn-sm btn-icon btn-light btn-hover-primary m-0" data-bs-dismiss="modal" aria-label="Close">
			  <svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-x" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
				  <path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
			  </svg>
			</button>
		  </div>
		  <div class="modal-body">
			<div class="col-md-12">
				<div class="dx-viewport demo-container">
                	<div id="data-grid-demo">
                  		<div id="gridLookupItem"></div>
                	</div>
              	</div>
			</div>
			<hr>
			<div class="form-group row justify-content-end mb-0">
				<div class="col-md-6  text-end">
					<button type="button" class="btn btn-primary" id="btPilihLookupData">Pilih Data</button>
				</div>
			</div>
		  </div>
		</div>
	</div>	  	  
</div>

@endsection

@push('scripts')
@extends('parts.generaljs')

<script type="text/javascript">

    var TglMulai = "";
    var TglSelesai = "";

	var _LastInputed = "";
    let intervalId1;
    let intervalId2;
    let intervalId3;
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

            if (jQuery('#formtype').val() == "edit") {
                bindGrid([]);
			}
			else{
				bindGrid([])	
			}
		});

        jQuery('#cardMulai').click(function () {
            // Jam Running Selesai
            var seconds = seconds = new Date().getSeconds();
            var minutes = new Date().getMinutes();
            var hours = new Date().getHours();
            intervalId1 = setInterval( function() {
            // Create an object newDate () and extract the second of the current time
            seconds = new Date().getSeconds();
            // Add a leading zero to the value of seconds
            jQuery("#selesaiSec").html(( seconds < 10 ? "0" : "" ) + seconds);
            },1000);
            
            intervalId2 = setInterval( function() {
                // Create an object newDate () and extract the minutes of the current time
                minutes = new Date().getMinutes();
                // Add a leading zero to the minutes
                jQuery("#selesaiMin").html(( minutes < 10 ? "0" : "" ) + minutes);
            },1000);
                
            intervalId3 = setInterval( function() {
                // Create an object newDate () and extract the clock from the current time
                hours = new Date().getHours();
                // Add a leading zero to the value of hours
                jQuery("#selesaiHour").html(( hours < 10 ? "0" : "" ) + hours);
            }, 1000);

            var now = new Date();
	    	var day = ("0" + now.getDate()).slice(-2);
	    	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	    	var firstDay = now.getFullYear()+"-"+month+"-01";
	    	var NowDay = now.getFullYear()+"-"+month+"-"+day;
	    	GetDate = now.getFullYear()+"-"+month+"-"+day;

            jQuery('#TglMulai').html(day +"/" + month+"/"+now.getFullYear());
            jQuery('#TglSelesai').html(day +"/" + month+"/"+now.getFullYear());
            jQuery('#JamMulai').html((( hours < 10 ? "0" : "" ) + hours) +" : " + (( minutes < 10 ? "0" : "" ) + minutes)+" : "+ (( seconds < 10 ? "0" : "" ) + seconds));

			if(intervalId1 != null){
				jQuery('#_Barcode').attr("readonly", false);
				jQuery('#_Qty').attr("readonly", false);

				jQuery('#_TotalStock').html("0");
				jQuery('#_TotalOpname').html("0");
			}
        });

        jQuery('#cardSelesai').click(function () {
            var seconds = seconds = new Date().getSeconds();
            var minutes = new Date().getMinutes();
            var hours = new Date().getHours();

            // jQuery('#JamSelesai').html((( hours < 10 ? "0" : "" ) + hours) +" : " + (( minutes < 10 ? "0" : "" ) + minutes)+" : "+ (( seconds < 10 ? "0" : "" ) + seconds));

            clearInterval(intervalId1);
            clearInterval(intervalId2);
            clearInterval(intervalId3);
            intervalId1 = null;
            intervalId2 = null;
            intervalId3 = null;
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
						'KodeGudang' : jQuery('#KodeGudang').val(),
						'NoUrut' : allRowsData[i]['NoUrut'],
						'KodeItem' : allRowsData[i]['KodeItem'],
						'Qty' : allRowsData[i]['Qty'],
						'Stock' : allRowsData[i]['Stock'],
      				}
      				
      				oDetail.push(oItem)
      			}
      		}

			var oData = {
				'NoTransaksi' : jQuery('#NoTransaksi').val(),
				'TglTransaksi' : jQuery('#TglTransaksi').val(),
				'KodeKaryawan' : jQuery('#KodeKaryawan').val(),
				'Keterangan' : jQuery('#Keterangan').val(),
				'Detail' : oDetail
			}
			// var originalvalue = jQuery("#TotalTransaksi").attr("originalvalue");

			// console.log(oData)
			if (jQuery('#formtype').val() == "add") {
				$.ajax({
					url: "{{route('stockopname-storeJson')}}",
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
		                        window.location.href = '{{url("stockopname")}}';
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
					url: "{{route('stockopname-editJson')}}",
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
		                        window.location.href = '{{url("stockopname")}}';
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

        $('#_Barcode').on("keypress", function(e) {
	        if (e.keyCode == 13) {
				if(jQuery('#KodeGudang').val() == ""){
					Swal.fire({
						icon: "error",
						title: "Error",
						text: "Pilih Gudang Terlebih Dahulu",
					}).then((result) => {
						// location.reload();
						$('#_Barcode').val("")
						$('#_Barcode').focus()
					});	
				}
				else{
					$.ajax({
						async:false,
						type: 'post',
						url: "{{route('itemmaster-readstockperwhs')}}",
						headers: {
							'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
						},
						data: {
							'KodeJenis' : '',
							'Merk' 		: '',
							'TipeItem' 	: '',
							'Active' 	: 'Y',
							'Scan'		: jQuery('#_Barcode').val(),
							'TipeItemIN' : '1,3',
							'KodeGudang' : jQuery('#KodeGudang').val()
						},
						dataType: 'json',
						success: function(response) {
							// console.log(response);
							var dataGridInstance = jQuery('#gridContainerDetail').dxDataGrid('instance');
							var allRowsData  = dataGridInstance.getDataSource().items();

							if (response.data.length > 1) {
								bindGridLookup(response.data);
								jQuery('#LookupItem').modal({backdrop: 'static', keyboard: false})
								jQuery('#LookupItem').modal('show');

							}
							else{
								if (response.data.length > 0) {
									var objIndex = allRowsData.findIndex(obj => obj.KodeItem == response.data[0]['KodeItem']);

									// console.log(objIndex);
									// console.log(allRowsData)
									if (objIndex != -1) {

										allRowsData[objIndex].Qty = allRowsData[objIndex].Qty + 1;

										bindGrid(allRowsData);
										dataGridInstance.refresh();
									}
									else{
										var dataSource = dataGridInstance.getDataSource();
										var item = {
											'KodeItem' 	 	: response.data[0]['KodeItem'],
											'NamaItem'	 	: response.data[0]['NamaItem'],
											'Barcode'	 	: response.data[0]['Barcode'],
											'Qty'	 	 	: 1,
											'Stock' 	 	: response.data[0]['Stock'],
										}

										dataSource.store().insert(item).then(function() {
											dataSource.reload();
										})

						//        		dataGridInstance.option("dataSource", [...dataGridInstance.option("dataSource"), item]);
										// dataGridInstance.refresh();
									}
									_LastInputed = response.data[0]['KodeItem'];
								}
								else{
									Swal.fire({
									icon: "error",
									title: "Error",
									text: "Data Tidak ditemukan",
									}).then((result) => {
									// location.reload();
									$('#_Barcode').val("")
									$('#_Barcode').focus()
									});	
								}

							}
							$('#_Barcode').val("")
							$('#_Barcode').focus()

							console.log(allRowsData)
						}
					});
				}
	        }
		});

        $('#_Barcode').on("keydown", function(e) {
			if (e.keyCode == 113) { //Qty
				e.preventDefault();
	        	// console.log('F2')

	        	if (_LastInputed != "") {
	        		$('#_Qty').focus();
	        		$('#_Qty').select();
	        	}
	        }
			CalculateTotal();
		});

        $('#btPilihLookupData').click(function () {
			var dataGridInstance = jQuery('#gridLookupItem').dxDataGrid('instance');
			var selectedRows = dataGridInstance.getSelectedRowsData();

			if (selectedRows.length > 0) {
				jQuery('#LookupItem').modal('hide');
				$('#_Barcode').val(selectedRows[0]['KodeItem']);
				$('#_Barcode').focus();

				var e = $.Event('keypress');
				e.keyCode = 13;
				$('#_Barcode').trigger(e);
			}

		});

        $('#_Qty').on("keypress", function(e) {
			var dataGridInstance = jQuery('#gridContainerDetail').dxDataGrid('instance');
      		var allRowsData  = dataGridInstance.getDataSource().items();

			if (e.keyCode == 13) {
				var objIndex = allRowsData.findIndex(obj => obj.KodeItem == _LastInputed);

        		// console.log(objIndex);
        		// console.log(allRowsData)
        		if (objIndex != -1) {
        			allRowsData[objIndex].Qty = parseFloat($('#_Qty').val());

        			bindGrid(allRowsData);
        			dataGridInstance.refresh();

        			$('#_Qty').val(1);
        			$('#_Barcode').focus();
        		}
			}
            CalculateTotal();
		});

        function sumNamedArray(arr, prop) {
            // console.log(arr)
            return arr.reduce((accumulator, currentValue) => parseFloat(accumulator) + parseFloat(currentValue[prop]), 0);
        }

        function CalculateTotal() {
            var dataGridInstance = jQuery('#gridContainerDetail').dxDataGrid('instance');
      		var allRowsData  = dataGridInstance.getDataSource().items();

			const TotalStock = sumNamedArray(allRowsData, "Stock");
			const TotalOpname = sumNamedArray(allRowsData, "Qty");

			jQuery('#_TotalStock').html("");
			jQuery('#_TotalOpname').html("");

			jQuery('#_TotalStock').html(TotalStock);
			jQuery('#_TotalOpname').html(TotalOpname);
        }
		function bindGrid(data) {
			var AllowManipulation = false;
			// if (StatusTransaksi != "O") {
			// 	AllowManipulation = false;
			// }
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
	                allowUpdating: true,
	                allowDeleting: true,
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
	                    allowEditing:false,
	                    allowSorting: false,
                        cellTemplate: function(container, options) {
                            container.text(options.rowIndex + 1);
                        }
	                },
	                {
	                    dataField: "KodeItem",
	                    caption: "Kode Item",
					    allowSorting: false,
					    allowEditing:AllowManipulation
	                },
                    {
	                    dataField: "Barcode",
	                    caption: "Barcode",
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
	                    dataField: "Qty",
	                    caption: "Qty",
	                    allowEditing:AllowManipulation,
	                    format: { type: 'fixedPoint', precision: 2 },
	                    allowSorting: false 
	                },
                    {
	                    dataField: "Stock",
	                    caption: "OnHand",
	                    allowEditing:AllowManipulation,
	                    format: { type: 'fixedPoint', precision: 2 },
	                    allowSorting: false 
	                }
	            ],
			    onContentReady: function(e) {
			    	CalculateTotal();
		        },
		        onCellClick:function (e) {
		        	var rowData = dataGridInstance.option("dataSource");
		            var columnIndex = e.columnIndex;
		            // console.log(e)
		        	if (columnIndex >= 1 && columnIndex <= 9) {
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
		}

	});

    function bindGridLookup(data) {
		// gridLookupItem
		var dataGridInstance = jQuery("#gridLookupItem").dxDataGrid({
			allowColumnResizing: true,
			dataSource: data,
			keyExpr: "KodeItem",
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
                texts: {
                    confirmDeleteMessage: ''  
                }
            },
            selection: {
                mode: "single" // Enable single selection mode
            },
            searchPanel: {
	            visible: true,
	            width: 240,
	            placeholder: "Search..."
	        },
            columns: [
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
            ]
		}).dxDataGrid('instance');
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
</script>
@endpush