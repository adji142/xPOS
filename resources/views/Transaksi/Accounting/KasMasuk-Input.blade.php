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
#tblkaskeluardetail thead th {
    pointer-events: none;
}

</style>
<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">
					<a href="{{route('kasmasuk')}}">Daftar Transaksi Kas Masuk</a>    
				</li>
				<li class="breadcrumb-item active" aria-current="page">Kas Masuk</li>
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
										@if (count($kasmasukheader) > 0)
											<input type="hidden" name="formtype" id="formtype" value="edit">
                                    		Edit Transaksi Kas Masuk
	                                	@else
	                                		<input type="hidden" name="formtype" id="formtype" value="add">
	                                    	Tambah Transaksi Kas Masuk
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
								@if (count($kasmasukheader) > 0)
                            		<form action="#" method="post" id="frmSaveKasKeluar">
                            	@else
                                	<form action="#" method="post" id="frmSaveKasKeluar">
                            	@endif
                            		@csrf
									<div class="form-group row">
										<div class="col-md-4">
											<label  class="text-body">No Transaksi (*)</label>
											<fieldset class="form-group mb-3">
												<input type="text" class="form-control" id="NoTransaksi" name="NoTransaksi" placeholder="<Auto>" value="{{ count($kasmasukheader) > 0 ? $kasmasukheader[0]['NoTransaksi'] : '' }}" readonly>
											</fieldset>
											
										</div>

										<div class="col-md-4">
											<label  class="text-body">Tanggal Transaksi</label>
											<fieldset class="form-group mb-3">
												<input type="date" class="form-control" id="TglTransaksi" name="TglTransaksi" placeholder="<Auto>" value="{{ count($kasmasukheader) > 0 ? $kasmasukheader[0]['TglTransaksi'] : '' }}" required="">
											</fieldset>
										</div>

										<div class="col-md-4">
											<label  class="text-body">Status</label>
											<fieldset class="form-group mb-3">
												<select name="StatusDocument" id="StatusDocument" class="js-example-basic-single js-states form-control bg-transparent" >
													<option value="O" {{ count($kasmasukheader) > 0 ? $kasmasukheader[0]['StatusDocument'] == 'O' ? "selected" : '' :""}} >OPEN</option>
													<option value="D" {{ count($kasmasukheader) > 0 ? $kasmasukheader[0]['StatusDocument'] == 'D' ? "selected" : '' :""}}>CANCEL</option>
													
												</select>
											</fieldset>
										</div>

										<div class="col-md-6">
											<label  class="text-body">Masuk Ke Akun</label>
											<fieldset class="form-group mb-3">
												<select name="KodeAkun" id="KodeAkun" class="js-example-basic-single js-states form-control bg-transparent" >
													<option value="" {{ count($kasmasukheader) > 0 ? $kasmasukheader[0]['KodeAkun'] == '' ? "selected" : '' :""}} >Pilih Akun</option>
													@foreach($rekening as $ko)
														<option value="{{ $ko->KodeRekening }}" {{ count($kasmasukheader) > 0 ? $kasmasukheader[0]['KodeAkun'] == $ko->KodeRekening ? "selected" : '' :""}}>
															{{ $ko->NamaRekening }}
														</option>
													@endforeach
												</select>
											</fieldset>
										</div>

										<div class="col-md-6">
											<label  class="text-body">Jumlah</label>
											<fieldset class="form-group mb-3">
												<input type="text" class="form-control" id="TotalTransaksi" TotalTransaksi="NoReff" placeholder="0.00" >
											</fieldset>
										</div>

										<div class="col-md-12">
											<label  class="text-body">Keterangan</label>
											<fieldset class="form-group mb-3">
												<input type="text" class="form-control" name="Keterangan" id="Keterangan" TotalTransaksi="NoReff" placeholder="Keterangan" value="{{ count($kasmasukheader) > 0 ? $kasmasukheader[0]['Keterangan'] : '' }}" >
											</fieldset>
										</div>

										<div class="col-md-12">
											<div class="table-responsive" id="printableTable">
												<table id="tblkaskeluardetail" class="display" style="width:100%">
													<thead>
														<tr>
															<th width="20px" class="no-sort">#</th>
															<th width="250px" class="no-sort">Akun</th>
															<th class="no-sort">Keterangan</th>
															<th class="no-sort">Jumlah</th>
															<th width="70px" class="no-sort text-end">Action</th>
														</tr>
													</thead>
													<tbody id="AppendArea">
														
													</tbody>
												</table>
											</div>
										</div>

										<div class="col-md-12">
											<div class="row">
												<div class="col-md-7"></div>
												<div class="col-md-5">
													<table class="table right-table">
														<tbody>
															<tr class="d-flex align-items-center justify-content-between">
																<th class="border-0 font-size-h5 mb-0 font-size-bold text-dark">
																	Total Transaksi
																</th>
																<td class="border-0 justify-content-end d-flex text-dark font-size-base">
																	<input type="text" name="TotalTransaksi" id="_TotalTransaksi" value="0" class="form-control TotalText">
																</td>
																
															</tr>
														</tbody>
													</table>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<button type="submit" id="btSave" class="btn btn-success text-white font-weight-bold me-1 mb-1">Simpan</button>
										</div>
									</div>
								</form>
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

    var oKasMasukDetail = [];
    var oListAccount = [];
	var LastLineNumber = 0;
	var _TotalTransaksi = 0;
	jQuery(function () {
		jQuery(document).ready(function() {
			var now = new Date();
	    	var day = ("0" + now.getDate()).slice(-2);
	    	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	    	var firstDay = now.getFullYear()+"-"+month+"-01";
	    	var NowDay = now.getFullYear()+"-"+month+"-"+day;
	    	GetDate = now.getFullYear()+"-"+month+"-"+day;

	    	jQuery('#TglTransaksi').val(NowDay);
            oKasMasukDetail = <?php echo json_encode($kasmasukdetail); ?>;
            oListAccount = <?php echo json_encode($rekeningDetail); ?>;
	    	console.log(oKasMasukDetail);
	    	jurnalHeader = <?php echo json_encode($kasmasukheader); ?>;
			if (jQuery('#formtype').val() == "edit") {

	      		StatusTransaksi = jurnalHeader[0]["StatusDocument"];
	      		var KodeTransaksi = jurnalHeader[0]["KodeTransaksi"];
	      		console.log(jurnalHeader)
	      		if (StatusTransaksi != "O") {
	      			jQuery('#TglTransaksi').attr('disabled',true);
	      			jQuery('#KodeTransaksi').attr('disabled',true);
	      			jQuery('#NoReff').attr('disabled',true);
	      			jQuery('#Status').attr('disabled',true);
	      			jQuery('#btSave').attr('disabled',true);
	      		}
	      		
				formatCurrency(jQuery('#TotalTransaksi'), jurnalHeader[0]["TotalTransaksi"]);
	      		// CreateCombobox([])
	      		jQuery('#KodeTransaksi').val(KodeTransaksi).trigger('change');
				for (let index = 0; index < oKasMasukDetail.length; index++) {
					addNewLine(oKasMasukDetail[index], index);
				}

				jQuery('#tblkaskeluardetail').DataTable({
					colReorder: false,
				});
				addNewLine([],oKasMasukDetail.length);
				jQuery(".dynamiCombo").select2();
				AsignRowNumber();
				jQuery('.dataTables_empty').first().remove();
				SetEnableCommand();

				updateTotalDisplay();
	      		// valueExpr: "NoTransaksi",
			}
			else{
				jQuery('#tblkaskeluardetail').DataTable({
					colReorder: false,
				});
				addNewLine([],0);
				jQuery(".dynamiCombo").select2();
				AsignRowNumber();
				jQuery('.dataTables_empty').first().remove();
				SetEnableCommand();
			}
		});


        function addNewLine(oData, index) {
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

			// console.log(oData['KodeRekening']);
            var KodeAkunText = document.createElement('select');
            KodeAkunText.name = 'DetailParameter['+index+'][KodeAkun]';
            KodeAkunText.className = 'dynamiCombo js-states form-control bg-transparent';
            KodeAkunText.value = oData['KodeRekening'];
			KodeAkunText.id = "cboKodeAkun";
            KodeAkunText.setAttribute('KodeAkun', oData['KodeRekening']);

			const option = document.createElement('option');
			option.value = "";
			option.text = "PILIH REKENING";
			KodeAkunText.appendChild(option);

			oListAccount.forEach(optionData => {
				const option = document.createElement('option');
				option.value = optionData.KodeRekening;
				option.text = optionData.NamaRekening;

				if (optionData.KodeRekening === oData['KodeAkun']) {
					option.selected = true; // Set the selected attribute
				}

				KodeAkunText.appendChild(option);
			});

			jQuery(KodeAkunText).on('change', function () {
				// console.log(LastLineNumber);
				var comboBoxes = document.getElementsByClassName('dynamiCombo');
				var isAddNewRow = true;
				for (var i = 0; i < comboBoxes.length; i++) {
					var value = comboBoxes[i].value;
					console.log(value);
					if (value == "") {
						isAddNewRow = false;
						break;
					}
				}

				if (isAddNewRow) {
					addNewLine([], index+1)	
				}
				jQuery(".dynamiCombo").select2();
				AsignRowNumber();
				SetEnableCommand();
			});
			
            KodeAkunCol.appendChild(KodeAkunText);
			// jQuery(KodeAkunText).val(oData["KodeAkun"]).change();
            

            var KeteranganText = document.createElement('input');
            KeteranganText.type  = 'text';
            KeteranganText.name = 'DetailParameter['+index+'][Keterangan]';
            KeteranganText.placeholder = "Keterangan";
            KeteranganText.className = 'form-control';
            KeteranganText.value = (typeof oData["Keterangan"] === "undefined" ? "" : oData["Keterangan"]);
            KeteranganText.id = "RowKeterangan";
            KeteranganCol.appendChild(KeteranganText);

            var JumlahTransaksiText = document.createElement('input');
            JumlahTransaksiText.type  = 'text';
            JumlahTransaksiText.name = 'DetailParameter['+index+'][TotalTransaksi]';
            JumlahTransaksiText.placeholder = "0.0";
            JumlahTransaksiText.className = 'txtTotalTransaksi form-control';
            JumlahTransaksiText.value = (typeof oData["TotalTransaksi"] === "undefined" ? "0" : oData["TotalTransaksi"]);
            JumlahTransaksiText.required = true;
			
			jQuery(JumlahTransaksiText).on('focusout', function (e) {

				let caretPosition = this.selectionStart;
				let formattedValue = formatNumber(this.value);
				this.value = formattedValue;

				this.selectionStart = caretPosition;
				this.selectionEnd = caretPosition +1;
				JumlahTransaksiText.setAttribute('TrxTotal', this.value.replace(/,/g, ""));

				updateTotalDisplay(); 
			});

			jQuery(JumlahTransaksiText).on('focusin', function (e) {

				var TextOri = this.value.length;
				let caretPosition = this.selectionStart;
				this.value = this.value.replace(/,/g, "");

				this.selectionStart = caretPosition;
				this.selectionEnd = TextOri;
			});

			TotalTransaksiCol.appendChild(JumlahTransaksiText);

            var RemoveText = document.createElement('button');
            RemoveText.innerText   = 'Delete';
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
				updateTotalDisplay(); 
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
					LastLineNumber = index+1;
                }
            });
        }
		function formatNumber(value) {
			value = value.replace(/[^0-9.]/g, '');
			let parts = value.split('.');
			parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
			if (parts[1]) {
				parts[1] = parts[1].substring(0, 2); // Take only first two decimal digits
			}
			return parts.join('.');
		}

		function updateTotalDisplay() {
			// document.getElementById('_TotalTransaksi').innerText = _TotalTransaksi.toFixed(2);
			var txttotal = document.getElementsByClassName('txtTotalTransaksi');
			var totalRow = 0;
			for (var i = 0; i < txttotal.length; i++) {
				var value = txttotal[i].value.toString().replace(/,/g, "");
				// console.log(value);
				if (value != "") {
					totalRow += parseFloat(value);	
				}
			}

			formatCurrency(jQuery('#_TotalTransaksi'), totalRow);
			SetEnableCommand();
		}

		jQuery("#TotalTransaksi").on('focusout', function () {
			formatCurrency(jQuery('#TotalTransaksi'), jQuery("#TotalTransaksi").val());
			SetEnableCommand();
		});

		jQuery('#frmSaveKasKeluar').on('submit', function(event) {
			jQuery('#btSave').text('Tunggu Sebentar.....');
      		jQuery('#btSave').attr('disabled',true);

			event.preventDefault();
			var formData = jQuery(this).serializeArray();
			formData.forEach(function(item) {
				if (item.name === 'TotalTransaksi') { // Change 'name' to the parameter you want to modify
					item.value = jQuery("#_TotalTransaksi").attr("originalvalue"); // Set your desired value here
					
				}
				if (item.name.includes('DetailParameter') && item.name.includes('[TotalTransaksi]')) {
					// Update `TotalTransaksi` value for all indices
					item.value = item.value.replace(/,/g, ""); // Set your desired value here
				}
				// console.log(item);
			});
			console.log(formData);
			var urlData = (jQuery('#formtype').val() == "add" ? '{{ route("kasmasuk-store") }}' : '{{ route("kasmasuk-edit") }}')
			$.ajax({
                url: urlData, // Route to handle form submission
                method: 'POST',
                data: $.param(formData),
                success: function(response) {
                    if (response.success == true) {
						Swal.fire({
							text: "Data berhasil disimpan!",
							icon: "success",
							title: "Horray...",
							// text: "Data berhasil disimpan! <br> " + response.Kembalian,
						}).then((result)=>{
							jQuery('#btSave').text('Save');
							jQuery('#btSave').attr('disabled',false);
							// location.reload();
							window.location.href = '{{url("kasmasuk")}}';
						});
					}
					else{
						Swal.fire({
							text: "Error Data " + response.message,
							icon: "error",
							title: "woopss...",
							// text: "Data berhasil disimpan! <br> " + response.Kembalian,
						}).then((result)=>{
							jQuery('#btSave').text('Save');
							jQuery('#btSave').attr('disabled',false);
						});
					}
                },
                error: function(xhr, status, error) {
					Swal.fire({
						text: "Error Data " + error,
						icon: "error",
						title: "woopss...",
						// text: "Data berhasil disimpan! <br> " + response.Kembalian,
					}).then((result)=>{
						jQuery('#btSave').text('Save');
						jQuery('#btSave').attr('disabled',false);
					});
                }
            });
		});

		jQuery('#KodeTransaksi').change(function () {
			SetEnableCommand();
		})

		function SetEnableCommand() {
			var nError = 0;
			var comboBoxes = document.getElementsByClassName('dynamiCombo');
			var txttotal = document.getElementsByClassName('txtTotalTransaksi');

			var allString = "";
			var totalValue = 0;

			for (var i = 0; i < comboBoxes.length; i++) {
				var value = comboBoxes[i].value;
				allString += value;
			}

			for (var i = 0; i < txttotal.length; i++) {
				var value = txttotal[i].value.toString().replace(/,/g, "");
				// console.log(value);
				if (value != "") {
					totalValue += parseFloat(value);	
				}
			}

			if (allString == "") {
				nError +=1;
			}
			if (totalValue == 0) {
				nError +=1;
			}

			if (jQuery('#KodeAkun').val() == "") {
				nError +=1;
			}

			if (jQuery("#TotalTransaksi").attr("originalvalue") == 0) {
				nError +=1;
			}

			if (jQuery("#TotalTransaksi").attr("originalvalue") != jQuery("#_TotalTransaksi").attr("originalvalue")) {
				nError +=1;
			}


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