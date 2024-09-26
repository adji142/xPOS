@extends('parts.header')
	
@section('content')
<style type="text/css">
    .xContainer{
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        vertical-align: middle;
    }
    .image_result{
        display: flex;
        justify-content: center;
        align-items: center;
        border: 1px solid black;
        /*flex-grow: 1;*/
        vertical-align: middle;
        align-content: center;
        flex-basis: 200;
        width: 200px;
        height: 200px;
    }
    .image_result img {
        max-width: 100%; /* Fit the image to the container width */
        width: 100%;
        height: 100%; /* Maintain the aspect ratio */
        object-fit: cover;
    }
</style>
<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">
					<a href="{{route('menu')}}">Menu</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Input Menu</li>
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
										@if (count($menuheader) > 0)
                                    		Edit Menu
	                                	@else
	                                    	Tambah Menu
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
								@if (count($menuheader) > 0)
                            		<form action="{{route('menu-edit')}}" method="post">
                            	@else
                                	<form action="{{route('menu-store')}}" method="post">
                            	@endif
                            		@csrf
	                            	<div class="form-group row">

                                        {{-- Start Hire --}}
                                        <div class="col-md-12"> 
                                            <fieldset class="form-group mb-3">
                                                <input type="hidden" class="form-control" id="id" name="id" value="{{ count($menuheader) > 0 ? $menuheader[0]['id'] : '' }}" required="" {{ count($menuheader) > 0 ? 'readonly' : '' }} >
                                                <textarea id = "image_base64" name = "image_base64" style="display: none;"> {{ count($menuheader) > 0 ? $menuheader[0]['Gambar'] : '' }} </textarea>
                                                
                                                <input type="file" id="Attachment" name="Attachment" accept=".jpg" class="btn btn-warning" style="display: none;"/>
                                                <div class="xContainer">
                                                    <div id="image_result" class="image_result">
                                                        @if (count($menuheader) > 0)
                                                            <img src=" {{$menuheader[0]['Gambar']}} ">
                                                        @else
                                                            <img src="https://www.generationsforpeace.org/wp-content/uploads/2018/03/empty.jpg">
                                                        @endif
                                                    </div>
                                                </div>
                                            </fieldset>
                                            
                                        </div>
                                        
                                        <div class="col-md-12">
                                            <label  class="text-body">Item Menu</label>
                                            <fieldset class="form-group mb-3">
                                                <select name="KodeItemHasil" id="KodeItemHasil" class="js-example-basic-single js-states form-control bg-transparent">
                                                    <option value="">Pilih Item Menu</option>
                                                    @foreach($itemhasil as $ko)
                                                        <option value="{{ $ko->KodeItem }}" {{ $ko->KodeItem == (count($menuheader) > 0 ? $menuheader[0]['KodeItemHasil'] : '') ? 'selected' : '' }}>
                                                            {{ $ko->NamaItem }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </fieldset>
                                        </div>

                                        <div class="col-md-6">
                                            <label  class="text-body">Harga Pokok</label>
                                            <fieldset class="form-group mb-3">
                                                <input readonly type="text" class="form-control" id="HargaPokokStandar" name="HargaPokokStandar" value="{{ count($menuheader) > 0 ? $menuheader[0]['HargaPokokStandar'] : '0' }}" >
                                            </fieldset>
                                        </div>

                                        <div class="col-md-6">
                                            <label  class="text-body">Harga Jual</label>
                                            <fieldset class="form-group mb-3">
                                                <input type="number" class="form-control" id="HargaJual" name="HargaJual" value="{{ count($menuheader) > 0 ? $menuheader[0]['HargaJual'] : '0' }}" >
                                            </fieldset>
                                        </div>
                                        <hr>
                                        <div class="col-md-12">
                                            <h3 class="card-label mb-0 font-weight-bold" style="text-align: center">
                                                Tambahkan Bahan Atau Resep
                                            </h3>
                                        </div>
                                        <div class="col-md-12">
                                            <small><i>Silahkan masukan rencana bahan untuk membuat Menu ini</i></small>
                                            <div class="table-responsive" id="printableTable">
                                                <table id="MenuDetail" class="display" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Item Bahan</th>
                                                            <th>Pemakaian</th>
                                                            <th>Satuan</th>
                                                            <th class=" no-sort text-end">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="AppendArea">
                                                        <tr>
                                                            <td colspan="6" id="btAddRow">
                                                                <center><i class="fas fa-plus" style="color: red"></i> <font style="color: red"> Tambah Data</font> </center>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div style="margin-bottom: 20px"></div>
                                        <hr>
                                        <div style="margin-bottom: 20px"></div>
                                        <div class="col-md-12">
                                            <h3 class="card-label mb-0 font-weight-bold" style="text-align: center">
                                                Tambahkan Variant Menu
                                            </h3>
                                        </div>
                                        <div class="col-md-12">
                                            <small><i>Silahkan masukan Varian dari Menu ini (Jika Ada)</i></small>
                                            <div class="table-responsive" id="printableTable">
                                                <table id="MenuVariant" class="display" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Keterangan</th>
                                                            <th>Exra Price</th>
                                                            <th class=" no-sort text-end">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="AppendVariantArea">
                                                        <tr>
                                                            <td colspan="6" id="btAddVariantRow">
                                                                <center><i class="fas fa-plus" style="color: red"></i> <font style="color: red"> Tambah Data</font> </center>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div style="margin-bottom: 20px"></div>
                                        <hr>
                                        <div style="margin-bottom: 20px"></div>
                                        <div class="col-md-12">
                                            <h3 class="card-label mb-0 font-weight-bold" style="text-align: center">
                                                Tambahkan Addon
                                            </h3>
                                        </div>
                                        <div class="col-md-12">
                                            <small><i>Silahkan masukan Addon Menu dari Menu ini (Jika Ada)</i></small>
                                            <div class="table-responsive" id="printableTable">
                                                <table id="MenuAddon" class="display" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Keterangan</th>
                                                            <th>Exra Price</th>
                                                            <th class=" no-sort text-end">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="AppendAddonMenuArea">
                                                        <tr>
                                                            <td colspan="6" id="btAddAddonRow">
                                                                <center><i class="fas fa-plus" style="color: red"></i> <font style="color: red"> Tambah Data</font> </center>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
	                            		<div class="col-md-12">
	                            			<button type="submit" class="btn btn-success text-white font-weight-bold me-1 mb-1">Simpan</button>
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

<div class="modal fade text-left w-100" id="modallookupVariant" tabindex="-1" role="dialog" aria-labelledby="myModalLabel16" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h4 class="modal-title" id="myModalLabel16">Daftar Variant</h4>
		  <button type="button" class="close rounded-pill btn btn-sm btn-icon btn-primary m-0" data-bs-dismiss="modal" aria-label="Close">
			<svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-x" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
			<path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
			</svg>	
			</button>
		</div>
		<div class="modal-body">
		  <div id="gridLookupvariant"></div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-primary ms-1" id="btSelectVariant" data-bs-dismiss="modal">
				<span class="">Pilih Variant</span>
			</button>
			</div> 		
	  </div>
	</div>
</div>

<div class="modal fade text-left w-100" id="modallookupAddon" tabindex="-1" role="dialog" aria-labelledby="myModalLabel16" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h4 class="modal-title" id="myModalLabel16">Daftar Addon</h4>
		  <button type="button" class="close rounded-pill btn btn-sm btn-icon btn-primary m-0" data-bs-dismiss="modal" aria-label="Close">
			<svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-x" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
			<path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
			</svg>	
			</button>
		</div>
		<div class="modal-body">
		  <div id="gridLookupAddon"></div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-primary ms-1" id="btSelectAddon" data-bs-dismiss="modal">
				<span class="">Pilih Addon</span>
			</button>
			</div> 		
	  </div>
	</div>
</div>
@endsection

@push('scripts')
@extends('parts.generaljs')
<script type="text/javascript">
    var _URL = window.URL || window.webkitURL;
    var _URLePub = window.URL || window.webkitURL;

    var oItemBahan = [];
    var oVariantHeader = [];
    var oVariantDetail = [];
    var oDataMenuHeader = [];
    var oDataMenuDetail = [];
    var oDataMenuVariant = [];
    var oDataMenuAddon = [];
    var oDaftarAddon = [];
    var TableID = "";
	$(function () {
        jQuery(document).ready(function () {

            oItemBahan = <?php echo json_encode($itembahan); ?>;
            oVariantHeader = <?php echo json_encode($variantheader); ?>;
            oVariantDetail = <?php echo json_encode($variantdetail); ?>;

            oDataMenuHeader = <?php echo json_encode($menuheader); ?>;
            oDataMenuDetail = <?php echo json_encode($menudetail); ?>;
            oDataMenuVariant = <?php echo json_encode($menuvariant); ?>;

            oDataMenuAddon = <?php echo json_encode($menuaddon); ?>;
            oDaftarAddon = <?php echo json_encode($daftaraddon); ?>;

            for (let index = 0; index < oDataMenuDetail.length; index++) {
                // addNewLine(oDataMenuDetail[index]['NamaVariant'],oDataMenuDetail[index]['ExtraPrice']);
                var oData = {
                    'KodeItem' : oDataMenuDetail[index]['KodeItemRM'],
                    'NamaItem' : oDataMenuDetail[index]['NamaItem'],
                    'QtyBahan' : oDataMenuDetail[index]['QtyBahan'],
                    'Satuan'   : oDataMenuDetail[index]['Satuan'],
                }
                addNewLine(oData, index +1);   
            }

            for (let index = 0; index < oDataMenuVariant.length; index++) {
                var oData = {
                    'id' : oDataMenuVariant[index]['id'],
                    'NamaGrup' : oDataMenuVariant[index]['NamaGrup']
                }
                addNewLineVariant(oData, index +1);   
            }

            for (let index = 0; index < oDataMenuAddon.length; index++) {
                
                var oData = {
                    'id' : oDataMenuAddon[index]['id'],
                    'NamaAddon' : oDataMenuAddon[index]['NamaAddon'],
                    'HargaAddon' : oDataMenuAddon[index]['HargaAddon']
                }
                addNewLineAddon(oData, index +1)
            }

            AsignRowNumber();
            jQuery('#MenuDetail').DataTable();
            jQuery('#MenuAddon').DataTable();
            
        })
	});

    jQuery('#btAddRow').click(function () {
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
        BindLookupServices("gridLookupitem", "KodeItem", oItemBahan, ColumnData,"multiple");
    });

    jQuery('#btAddVariantRow').click(function () {
        jQuery('#modallookupVariant').modal({backdrop: 'static', keyboard: false})
        jQuery('#modallookupVariant').modal('show');
        // console.log(orderHeader)
        var ColumnData = [
            {
                dataField: "OpsiPilihan",
                caption: "Opsi Pilihan",
                allowSorting: true,
                allowEditing : false
            },
            {
                dataField: "NamaGrup",
                caption: "Grup Varian",
                allowSorting: true,
                allowEditing : false
            },
        ];
        BindLookupServices("gridLookupvariant", "id", oVariantHeader, ColumnData,"multiple");
    });

    jQuery('#btAddAddonRow').click(function () {
        jQuery('#modallookupAddon').modal({backdrop: 'static', keyboard: false})
        jQuery('#modallookupAddon').modal('show');
        console.log(oDaftarAddon)
        var ColumnData = [
            {
                dataField: "NamaAddon",
                caption: "Nama Addon",
                allowSorting: true,
                allowEditing : false
            },
            {
                dataField: "HargaAddon",
                caption: "Extra Cost",
                allowSorting: true,
                allowEditing : false
            },
        ];
        BindLookupServices("gridLookupAddon", "id", oDaftarAddon, ColumnData,"multiple");
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
                if (!CheckifExist(selectedRows[index]["KodeItem"])) {
                    addNewLine(selectedRows[index], index +1);   
                }
            }
		}

        dataGridInstance.deselectAll();
        AsignRowNumber();
	});

    jQuery('#btSelectVariant').click(function () {
		var dataGridInstance = jQuery('#gridLookupvariant').dxDataGrid('instance');
		var dataGridDetailInstance = jQuery('#gridLookupvariant').dxDataGrid('instance');

		var selectedRows = dataGridInstance.getSelectedRowsData();
        // addNewLineVariant(selectedRows,0)
		// console.log(selectedRows[0]["KodeItem"]);
		if (selectedRows.length > 0) {
            for (let index = 0; index < selectedRows.length; index++) {
                // console.log("Add Row : " + index)
                // console.log(CheckifExist(selectedRows[index]["KodeItem"]));
                if (!CheckVariantifExist(selectedRows[index]["id"])) {
                    addNewLineVariant(selectedRows[index], index +1);   
                }
            }
		}
        dataGridInstance.deselectAll();
        jQuery('#MenuVariant').DataTable();
        // AsignRowNumber();
	});

    jQuery('#btSelectAddon').click(function () {
        var dataGridInstance = jQuery('#gridLookupAddon').dxDataGrid('instance');
		var dataGridDetailInstance = jQuery('#gridLookupAddon').dxDataGrid('instance');
        var selectedRows = dataGridInstance.getSelectedRowsData();

        if (selectedRows.length > 0) {
            for (let index = 0; index < selectedRows.length; index++) {
                // console.log("Add Row : " + index)
                // console.log(CheckifExist(selectedRows[index]["KodeItem"]));
                addNewLineAddon(selectedRows[index], index +1); 
            }
		}
        dataGridInstance.deselectAll();
        jQuery('#MenuAddon').DataTable();
    })

    jQuery('#image_result').click(function(){
        $('#Attachment').click();
    });

    $("#Attachment").change(function(){
      var file = $(this)[0].files[0];
      img = new Image();
      img.src = _URL.createObjectURL(file);
      var imgwidth = 0;
      var imgheight = 0;
      img.onload = function () {
        imgwidth = this.width;
        imgheight = this.height;
        $('#width').val(imgwidth);
        $('#height').val(imgheight);
      }
      readURL(this);
      encodeImagetoBase64(this);
      // alert("Current width=" + imgwidth + ", " + "Original height=" + imgheight);
    });

    function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
          
        reader.onload = function (e) {
          // console.log(e.target.result);
          $('#image_result').html("<img src ='"+e.target.result+"'> ");
        }
        reader.readAsDataURL(input.files[0]);
      }
    }
    function encodeImagetoBase64(element) {
      $('#image_base64').val('');
        var file = element.files[0];
        var reader = new FileReader();
        reader.onloadend = function() {
          // $(".link").attr("href",reader.result);
          // $(".link").text(reader.result);
          $('#image_base64').val(reader.result);
        }
        reader.readAsDataURL(file);
    }

    function addNewLine(oData, index) {
        // console.log(oData)
        var RandomID = generateRandomText(10);
        var newRow = document.createElement('tr');
        newRow.className = RandomID;
        newRow.id = "InputSectionData"

        var nomorCol = document.createElement('td');
        var NamaBahanCol = document.createElement('td');
        var PemakaianCol = document.createElement('td');
        var SatuanCol = document.createElement('td');
        var RemoveCol = document.createElement('td');

        // var nomorObj = document.createElement('label');
        // nomorObj.innerText   = index;
        // nomorCol.appendChild(nomorObj);

        var NamaBahanText = document.createElement('input');
        NamaBahanText.type  = 'text';
        NamaBahanText.name = 'DetailParameter['+index+'][NamaBahan]';
        NamaBahanText.placeholder = "Tambah Nama Bahan";
        NamaBahanText.className = 'form-control';
        NamaBahanText.required = true;
        NamaBahanText.value = oData['NamaItem'];
        NamaBahanText.setAttribute('KodeBahan', oData['KodeItem']);
        NamaBahanText.readOnly = true;
        NamaBahanCol.appendChild(NamaBahanText);

        var KodeItemText = document.createElement('input');
        KodeItemText.type = "hidden";
        KodeItemText.name = 'DetailParameter['+index+'][KodeItem]';
        KodeItemText.value = oData['KodeItem'];
        NamaBahanCol.appendChild(KodeItemText);
        

        var PemakaianText = document.createElement('input');
        PemakaianText.type  = 'number';
        PemakaianText.name = 'DetailParameter['+index+'][Pemakaian]';
        PemakaianText.placeholder = "Pemakaian Bahan";
        PemakaianText.className = 'form-control';
        PemakaianText.value = (oData['QtyBahan'] != 0) ? oData['QtyBahan'] : 0;
        PemakaianText.required = true;
        PemakaianText.id = "JumlahPemakaianBahan";
        PemakaianText.addEventListener('input', function() {
            let value = PemakaianText.value;
            // console.log('Current Value: ' + value);
            // PemakaianText.value = value;
            PemakaianText.setAttribute('JumlahPemakaian', value);
        });
        PemakaianCol.appendChild(PemakaianText);

        var SatuanText = document.createElement('input');
        SatuanText.type  = 'text';
        SatuanText.name = 'DetailParameter['+index+'][Satuan]';
        SatuanText.placeholder = "Pemakaian Bahan";
        SatuanText.className = 'form-control';
        SatuanText.value = oData['Satuan'];
        SatuanText.required = true;
        SatuanText.readOnly = true;
        SatuanCol.appendChild(SatuanText);

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
        newRow.appendChild(NamaBahanCol);
        newRow.appendChild(PemakaianCol);
        newRow.appendChild(SatuanCol);
        newRow.appendChild(RemoveCol);
        document.getElementById('AppendArea').appendChild(newRow);

    }

    function addNewLineVariant(oData, index) {
        console.log(oData);
        var RandomID = generateRandomText(10);
        var newRow = document.createElement('tr');
        newRow.className = RandomID;
        newRow.id = "InputSectionDataVariant"

        // New Row
        var GrupColl = document.createElement('td');
        var RemoveCol = document.createElement('td');

        GrupColl.setAttribute('colspan','3')
        // GrupColl.textContent = oData["NamaGrup"]
        GrupColl.style.textAlign  = "center"
        GrupColl.innerHTML = '<font size="4" color="#333">'+oData["NamaGrup"]+'</font>';

        // Remove one Grup
        var RemoveText = document.createElement('button');
        RemoveText.innerText   = 'Delete Data';
        RemoveText.type   = 'button';
        // RemoveText.style.color = "red";
        // RemoveText.href = "#"+RandomID;
        RemoveText.className = "btn btn-danger RemoveLineItem";
        RemoveText.id = "RemoveLineVariant";
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
        RemoveCol.style.textAlign = 'right'

        newRow.appendChild(GrupColl);
        newRow.appendChild(RemoveCol);

        document.getElementById('AppendVariantArea').appendChild(newRow);
        // var nomorObj = document.createElement('label');
        // nomorObj.innerText   = index;
        // nomorCol.appendChild(nomorObj);

        console.log(oVariantDetail);
        let filteredVariantDetail = oVariantDetail.filter(function(variant) {
            return variant.variant_id == oData["id"];
        });

        // console.log(filteredVariantDetail)

        for (let index = 0; index < filteredVariantDetail.length; index++) {
            var newRowDetail = document.createElement('tr');
            newRowDetail.className = RandomID;
            newRowDetail.id = "InputSectionDataVariant"

            var nomorCol = document.createElement('td');
            var KeteranganCol = document.createElement('td');
            var ExtraPriceCol = document.createElement('td');
            var ToggleCol = document.createElement('td');

            // const element = array[index];
            var KeteranganText = document.createElement('input');
            KeteranganText.type  = 'text';
            KeteranganText.name = 'DetailVariant['+index+'][NamaVariant]';
            KeteranganText.className = 'form-control';
            KeteranganText.required = true;
            KeteranganText.value = filteredVariantDetail[index]['NamaVariant'];
            KeteranganText.readOnly = true;
            KeteranganText.setAttribute('variant_id', oData["id"]);
            KeteranganCol.appendChild(KeteranganText);

            var KeteranganHiddenText = document.createElement('input');
            KeteranganHiddenText.type  = 'hidden';
            KeteranganHiddenText.name = 'DetailVariant['+index+'][variant_id]';
            KeteranganHiddenText.required = true;
            KeteranganHiddenText.value = filteredVariantDetail[index]["id"];
            KeteranganHiddenText.readOnly = true;
            KeteranganCol.appendChild(KeteranganHiddenText);

            var ExtraPriceText = document.createElement('input');
            ExtraPriceText.type  = 'number';
            ExtraPriceText.name = 'DetailVariant['+index+'][ExtraPrice]';
            ExtraPriceText.className = 'form-control';
            ExtraPriceText.value = filteredVariantDetail[index]['ExtraPrice'];
            ExtraPriceText.readOnly = true;
            ExtraPriceCol.appendChild(ExtraPriceText);

            var ToggleText = document.createElement('input');
            ToggleText.type   = 'checkbox';
            ToggleText.id    = 'toggleButton';
            ToggleText.checked = true;
            
            ToggleCol.appendChild(ToggleText);

            newRowDetail.appendChild(nomorCol);
            newRowDetail.appendChild(KeteranganCol);
            newRowDetail.appendChild(ExtraPriceCol);
            newRowDetail.appendChild(ToggleCol);

            document.getElementById('AppendVariantArea').appendChild(newRowDetail);
        }
    }


    function addNewLineAddon(oData, index) {
        // console.log(oData);
        var RandomID = generateRandomText(10);
        var newRow = document.createElement('tr');
        newRow.className = RandomID;
        newRow.id = "InputSectionDataAddon"

        // New Row
		var tbody = document.querySelectorAll('#InputSectionDataAddon');
		// console.log(tbody);
        var index = 0;

		if (tbody.length > 0) {
			index = tbody.length + 1;
		}




        var existingRow = Array.from(document.querySelectorAll('input[id="txtAddonID"]')).find(function(input) {
            console.log(input.value.toString() + " => "  + oData["id"].toString())
			return input.value.toString() === oData["id"].toString();
		});

        console.log(existingRow);

        if (!existingRow) {
            var AddonCol = document.createElement('td');
            var ExtraPriceCol = document.createElement('td');
            var RemoveCol = document.createElement('td');

            var AddonID = document.createElement('input');
            var AddonText = document.createElement('input');
            var ExtraPriceText = document.createElement('input');

            AddonText.type  = 'text';
            AddonText.id = "txtNamaAddon";
            AddonText.name = 'DetailAddon['+index+'][NamaAddon]';
            AddonText.placeholder = "Tambah Addon";
            AddonText.className = 'form-control';
            AddonText.required = true;
            AddonText.value = oData["NamaAddon"];
            AddonText.readOnly = true;
            AddonText.title = oData["NamaAddon"];
            // AddonText.setAttribute('AddonID', oData["id"]);
            AddonCol.appendChild(AddonText);

            AddonID.type  = 'hidden';
            AddonID.id = "txtAddonID";
            AddonID.name = 'DetailAddon['+index+'][AddonID]';
            AddonID.placeholder = "Tambah Addon";
            AddonID.className = 'form-control';
            AddonID.required = true;
            AddonID.value = oData["id"];
            AddonID.readOnly = true;
            AddonID.title = oData["id"];
            // AddonText.setAttribute('AddonID', oData["id"]);
            AddonCol.appendChild(AddonID);

            ExtraPriceText.type  = 'text';
            ExtraPriceText.id = "txtHargaAddon";
            ExtraPriceText.name = 'DetailAddon['+index+'][HargaAddon]';
            ExtraPriceText.placeholder = "Tambah Addon";
            ExtraPriceText.className = 'form-control';
            ExtraPriceText.required = true;
            ExtraPriceText.value = oData["HargaAddon"];
            ExtraPriceText.readOnly = true;
            ExtraPriceText.title = oData["HargaAddon"];
            ExtraPriceCol.appendChild(ExtraPriceText);

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
            };
            RemoveCol.appendChild(RemoveText);

            newRow.appendChild(AddonCol);
            newRow.appendChild(ExtraPriceCol);
            newRow.appendChild(RemoveCol);

            document.getElementById('AppendAddonMenuArea').appendChild(newRow);
        }
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
                    var customAttribute = inputElement.getAttribute('kodebahan'); // Change 'data-custom-attribute' to your actual attribute name
                    
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

    function CheckVariantifExist(variant_id) {
        var retData = false;

        var tbody = document.querySelectorAll('#InputSectionDataVariant');
        // console.log(tbody);
        tbody.forEach(function(row, index) {
            var cells = row.querySelectorAll('td');
            
            // console.log(cells)
            cells.forEach(function(cell) {
                var inputElement = cell.querySelector('input[type="text"]');
                if (inputElement) {
                    var customAttribute = inputElement.getAttribute('variant_id'); // Change 'data-custom-attribute' to your actual attribute name
                    
                    if (customAttribute == variant_id) {
                        retData = true;
                    }
                    // Log or use the custom attribute value
                    // console.log('Row:', index + 1, 'Custom Attribute:', customAttribute);
                }
            });
        });

        return retData;
    }
</script>
@endpush