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
					<a href="{{route('kaskeluar')}}">Daftar Transaksi Kas Keluar</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Kas Keluar</li>
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
										@if (count($kaskeluarheader) > 0)
											<input type="hidden" name="formtype" id="formtype" value="edit">
                                    		Edit Transaksi Kas Keluar
	                                	@else
	                                		<input type="hidden" name="formtype" id="formtype" value="add">
	                                    	Tambah Transaksi Kas Keluar
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
                            				<input type="text" class="form-control" id="NoTransaksi" name="NoTransaksi" placeholder="<Auto>" value="{{ count($kaskeluarheader) > 0 ? $kaskeluarheader[0]['NoTransaksi'] : '' }}" required="">
                            			</fieldset>
                            			
                            		</div>

                            		<div class="col-md-4">
                            			<label  class="text-body">Tanggal Transaksi</label>
                            			<fieldset class="form-group mb-3">
                            				<input type="date" class="form-control" id="TglTransaksi" name="TglTransaksi" placeholder="<Auto>" value="{{ count($kaskeluarheader) > 0 ? $kaskeluarheader[0]['TglTransaksi'] : '' }}" required="">
                            			</fieldset>
                            		</div>

                            		<div class="col-md-4">
                            			<label  class="text-body">Status</label>
                            			<fieldset class="form-group mb-3">
                            				<select name="Status" id="Status" class="js-example-basic-single js-states form-control bg-transparent" >
												<option value="O" {{ count($kaskeluarheader) > 0 ? $kaskeluarheader[0]['Status'] == 'O' ? "selected" : '' :""}} >OPEN</option>
												<option value="D" {{ count($kaskeluarheader) > 0 ? $kaskeluarheader[0]['Status'] == 'D' ? "selected" : '' :""}}>CANCEL</option>
												
											</select>
                            			</fieldset>
                            		</div>

                                    <div class="col-md-6">
                            			<label  class="text-body">Keluar dari Akun</label>
                            			<fieldset class="form-group mb-3">
                            				<select name="KodeAkun" id="KodeAkun" class="js-example-basic-single js-states form-control bg-transparent" >
												<option value="" {{ count($kaskeluarheader) > 0 ? $kaskeluarheader[0]['KodeAkun'] == '' ? "selected" : '' :""}} >Pilih Akun</option>
												@foreach($rekening as $ko)
													<option value="{{ $ko->KodeRekening }}" {{ count($kaskeluarheader) > 0 ? $kaskeluarheader[0]['KodeAkun'] == $ko->KodeRekening ? "selected" : '' :""}}>
                                                        {{ $ko->NamaRekening }}
                                                    </option>
												@endforeach
											</select>
                            			</fieldset>
                            		</div>

                            		<div class="col-md-6">
                            			<label  class="text-body">Jumlah</label>
                            			<fieldset class="form-group mb-3">
                            				<input type="text" class="form-control" id="TotalTransaksi" TotalTransaksi="NoReff" placeholder="0.00" value="{{ count($kaskeluarheader) > 0 ? $kaskeluarheader[0]['TotalTransaksi'] : '0' }}" >
                            			</fieldset>
                            		</div>

                            		<div class="col-md-12">
                                        <div class="table-responsive" id="printableTable">
                                            <table id="tblkaskeluardetail" class="display" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Akun</th>
                                                        <th>Keterangan</th>
                                                        <th>Jumlah</th>
                                                        <th class=" no-sort text-end">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="AppendArea">
                                                    <tr>
                                                        <td colspan="5" id="btAddRow">
                                                            <center><i class="fas fa-plus" style="color: red"></i> <font style="color: red"> Tambah Data</font> </center>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
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
	var jurnalHeader = [];
	var jurnalDetail = [];
	var filteredOrderDetail = [];
	var GetDate = '';
	var NoOrderPembelian = '';

    var oKasKeluarDetail = [];
    var oListAccount = [];
	jQuery(function () {
		jQuery(document).ready(function() {
			var now = new Date();
	    	var day = ("0" + now.getDate()).slice(-2);
	    	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	    	var firstDay = now.getFullYear()+"-"+month+"-01";
	    	var NowDay = now.getFullYear()+"-"+month+"-"+day;
	    	GetDate = now.getFullYear()+"-"+month+"-"+day;

	    	jQuery('#TglTransaksi').val(NowDay);
            oKasKeluarDetail = <?php echo json_encode($kaskeluardetail); ?>;
            oListAccount = <?php echo json_encode($rekeningDetail); ?>;
	    	// console.log(jQuery('#formtype').val())
	    	jurnalHeader = <?php echo json_encode($kaskeluarheader); ?>;
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
	      		
	      		// CreateCombobox([])
	      		jQuery('#KodeTransaksi').val(KodeTransaksi).trigger('change');
	      		// valueExpr: "NoTransaksi",
			}
			else{
				// BindGridDetail([])	
			}

            jQuery('#tblkaskeluardetail').DataTable();
			SetEnableCommand();
		});

        jQuery('#btAddRow').click(function () {
            jQuery('#modallookupItem').modal({backdrop: 'static', keyboard: false})
            jQuery('#modallookupItem').modal('show');
            // console.log(orderHeader)
            var ColumnData = [
                {
                    dataField: "KodeRekening",
                    caption: "Kode Akun",
                    allowSorting: true,
                    allowEditing : false
                },
                {
                    dataField: "NamaRekening",
                    caption: "Nama Rekening",
                    allowSorting: true,
                    allowEditing : false
                }
            ];
            BindLookupServices("gridLookupitem", "KodeRekening", oListAccount, ColumnData,"multiple");
        });

        jQuery('#btSelectItem').click(function () {
            var dataGridInstance = jQuery('#gridLookupitem').dxDataGrid('instance');
            var dataGridDetailInstance = jQuery('#gridContainerRakitan').dxDataGrid('instance');

            var selectedRows = dataGridInstance.getSelectedRowsData();

            // console.log(selectedRows[0]["KodeItem"]);
            if (selectedRows.length > 0) {
                for (let index = 0; index < selectedRows.length; index++) {
                    // console.log("Add Row : " + index)
                    // console.log(CheckifExist(selectedRows[index]["KodeItem"]));
                    if (!CheckifExist(selectedRows[index]["KodeRekening"])) {
                        addNewLine(selectedRows[index], index +1);   
                    }
                }
            }

            dataGridInstance.deselectAll();
            // AsignRowNumber();
        });


        function addNewLine(oData, index) {
        console.log(oData)
            var RandomID = generateRandomText(10);
            var newRow = document.createElement('tr');
            newRow.className = RandomID;
            newRow.id = "InputSectionData"

            var nomorCol = document.createElement('td');
            var KodeAkunCol = document.createElement('td');
            var KeteranganCol = document.createElement('td');
            var TotalTransaksiCol = document.createElement('td');
            var RemoveCol = document.createElement('td');

            // var nomorObj = document.createElement('label');
            // nomorObj.innerText   = index;
            // nomorCol.appendChild(nomorObj);

            var KodeAkunText = document.createElement('input');
            KodeAkunText.type  = 'text';
            KodeAkunText.name = 'DetailParameter['+index+'][KodeAkun]';
            KodeAkunText.className = 'form-control';
            KodeAkunText.required = true;
            KodeAkunText.value = oData['NamaRekening'];
            KodeAkunText.setAttribute('KodeAkun', oData['KodeRekening']);
            KodeAkunText.readOnly = true;
            KodeAkunCol.appendChild(KodeAkunText);
            

            var KeteranganText = document.createElement('input');
            KeteranganText.type  = 'text';
            KeteranganText.name = 'DetailParameter['+index+'][Keterangan]';
            KeteranganText.placeholder = "Keterangan";
            KeteranganText.className = 'form-control';
            KeteranganText.value = "";
            KeteranganText.required = true;
            KeteranganText.id = "RowKeterangan";
            KeteranganCol.appendChild(KeteranganText);

            var JumlahTransaksiText = document.createElement('input');
            JumlahTransaksiText.type  = 'number';
            JumlahTransaksiText.name = 'DetailParameter['+index+'][TotalTransaksi]';
            JumlahTransaksiText.placeholder = "Jumlah Transaksi";
            JumlahTransaksiText.className = 'form-control';
            JumlahTransaksiText.value = oData['TotalTransaksi'];
            JumlahTransaksiText.required = true;
            TotalTransaksiCol.appendChild(JumlahTransaksiText);

            var RemoveText = document.createElement('button');
            RemoveText.innerText   = 'Delete Data';
            RemoveText.type   = 'button';
            // RemoveText.style.color = "red";
            // RemoveText.href = "#"+RandomID;
            RemoveText.className = "btn btn-danger RemoveLineItem";
            RemoveText.id = "RemoveLineItem";
            RemoveText.onclick = function() {
                // alert('Button in row  clicked! ' + RandomID);
                var elements = document.querySelectorAll('.'+RandomID);
                // elements.remove();
                elements.forEach(function(element) {
                    element.remove();
                });
                AsignRowNumber();
                // console.log(elements)
            };
            RemoveCol.appendChild(RemoveText);

            newRow.appendChild(nomorCol);
            newRow.appendChild(KodeAkunCol);
            newRow.appendChild(KeteranganCol);
            newRow.appendChild(TotalTransaksiCol);
            newRow.appendChild(RemoveCol);
            document.getElementById('AppendArea').appendChild(newRow);

        }

        function CheckifExist(KodeItemBaru) {
            var retData = false;

            var tbody = document.querySelectorAll('#InputSectionData');
            // console.log(tbody);
            tbody.forEach(function(row, index) {
                var cells = row.querySelectorAll('td');
                
                // console.log(cells)
                cells.forEach(function(cell) {
                    var inputElement = cell.querySelector('input[type="text"]');
                    if (inputElement) {
                        var customAttribute = inputElement.getAttribute('KodeAkun'); // Change 'data-custom-attribute' to your actual attribute name
                        
                        if (customAttribute == KodeItemBaru) {
                            retData = true;
                        }
                        // Log or use the custom attribute value
                        // console.log('Row:', index + 1, 'Custom Attribute:', customAttribute);
                    }
                });
            });

            return retData;
        }

        function generateRandomText(length) {
            const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            let randomText = '';
            for (let i = 0; i < length; i++) {
                const randomIndex = Math.floor(Math.random() * characters.length);
                randomText += characters[randomIndex];
            }
            return randomText;
        }
        
        function AsignRowNumber() {
            var tbody = document.querySelectorAll('#InputSectionData');
            tbody.forEach(function(row, index) {
                var firstCell = row.querySelector('td:first-child');
                if (firstCell) {
                    firstCell.textContent = index + 1;
                }
            });
        }

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
					url: "{{route('kaskeluar-store')}}",
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
		                        window.location.href = '{{url("kaskeluar")}}';
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
					url: "{{route('kaskeluar-edit')}}",
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
		                        window.location.href = '{{url("kaskeluar")}}';
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