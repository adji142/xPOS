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
.dx-dropdowneditor-input-wrapper{
    height: 50% !important;
}

</style>
<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">
					<a href="{{route('fpenjualan')}}">Daftar Faktur Penjualan</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Faktur Penjualan</li>
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
                                    		Edit Faktur Penjualan
	                                	@else
	                                		<input type="hidden" name="formtype" id="formtype" value="add">
	                                    	Tambah Faktur Penjualan
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

                            		<div class="col-md-12">
                            			<label  class="text-body">No Reff</label>
                            			<fieldset class="form-group mb-3">
                            				<input type="text" class="form-control" id="NoReff" name="NoReff" placeholder="Masukan No Reff" value="{{ count($fakturheader) > 0 ? $fakturheader[0]['NoReff'] : '' }}" >
                            			</fieldset>
                            		</div>

                            		<div class="col-md-6">
                            			<label  class="text-body">Keterangan</label>
                            			<div id="Keterangan" style="height: 100px;">
                                            {!! count($fakturheader) > 0 ? $fakturheader[0]['Keterangan'] : '' !!}
                                        </div>
                            		</div>

                                    <div class="col-md-6">
                            			<label  class="text-body">Syarat dan Ketentuan</label>
                            			<div id="SyaratDanKetentuan" style="height: 100px;">
                                            {!! count($fakturheader) > 0 ? $fakturheader[0]['SyaratDanKetentuan'] : '' !!}
                                        </div>
                            		</div>

                            		<div class="col-md-12">
                                        <label class="text-body">Detail Item</label>
                                        <table class="table table-bordered" id="tableDetailItem">
                                            <thead>
                                                <tr>
                                                    <th style="width: 30%">Item</th>
                                                    <th style="width: 10%">Qty Faktur</th>
                                                    <th style="width: 15%">Gudang</th>
                                                    <th style="width: 15%">Harga</th>
                                                    <th style="width: 15%">PPN</th>
                                                    <th style="width: 15%">Total</th>
                                                    <th style="width: 10%"><button type="button" id="btnAddRow" class="btn btn-sm btn-success">+</button></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <select class="form-control select-item select2" name="item[]" style="width: 100%">
                                                            <option value="">Pilih Item</option>
                                                            @foreach($item as $it)
                                                                <option value="{{ $it->KodeItem }}" data-harga="{{ $it->HargaJual }}" data-satuan="{{ $it->Satuan }}" data-qtykonversi="{{ $it->QtyKonversi }}" data-hpp="{{ $it->HargaPokokPenjualan }}" data-namaitem="{{ $it->NamaItem }}">
                                                                    {{ $it->NamaItem }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td><input type="number" name="qtyfaktur[]" class="form-control qtyfaktur" value="1" min="1" /></td>
                                                    <td>
                                                        <select class="form-control select-gudang select2" name="gudang[]" style="width: 100%">
                                                            <option value="">Pilih gudang</option>
                                                            @foreach($gudang as $gd)
                                                                <option value="{{ $gd->KodeGudang }}">
                                                                    {{ $gd->NamaGudang }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="harga[]" class="form-control harga" readonly/>
                                                        <input type="hidden" name="hpp[]" class="form-control hpp" readonly/>
                                                        <input type="hidden" name="diskon[]" class="form-control diskon" value="0" />
                                                        <input type="hidden" name="baseline[]" class="form-control baseline" value="-1" />
                                                    </td>
                                                    <td><input type="text" name="ppn[]" class="form-control ppn" readonly/></td>
                                                    <td><input type="text" name="total[]" class="form-control total" readonly /></td>
                                                    <td><button type="button" class="btn btn-sm btn-danger btnRemoveRow">-</button></td>
                                                </tr>
                                            </tbody>
                                        </table>
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
                            					<td><input type="text" align="right" name="TotalPenjualan" id="TotalPenjualan" readonly="" class="form-control aligned-textbox" value="{{ count($fakturheader) > 0 ? $fakturheader[0]['TotalPembelian'] : '0' }}"></td>
                            				</tr>
                            			</table>
                            		</div>

                            		<div class="col-md-12">
                            			<button type="button" id="btSave" class="btn btn-success text-white font-weight-bold me-1 mb-1">
                                            <span id="submit-text">Simpan</span>
                                            <span id="submit-spinner" class="spinner-border spinner-border-sm" style="display: none;" role="status" aria-hidden="true"></span>
                                        </button>
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

<script>
    var NoOrderPembelian = '';

    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var firstDay = now.getFullYear()+"-"+month+"-01";
    var NowDay = now.getFullYear()+"-"+month+"-"+day;

    var TotalTermin = 0;
    var orderDetailData = <?php echo json_encode($orderdetail) ?>;
    var oPPN = <?php echo $ppnpercent ?>;
    var oPPNInclude = <?php echo $ppninclude ?>;


    // init Quill
    var quill_Keterangan = new Quill('#Keterangan', {
        theme: 'snow'
    });
    var quill_SyaratDanKetentuan = new Quill('#SyaratDanKetentuan', {
        theme: 'snow'
    });
    // Init select2
    jQuery('.select2').select2({ width: 'resolve' });


    $(document).ready(function () {
        jQuery('#TglTransaksi').val(NowDay);
        jQuery('#TglJatuhTempo').val(NowDay);


        fakturheader = <?php echo json_encode($fakturheader); ?>;
        fakturdetail = <?php echo json_encode($fakturdetail); ?>;
        if (jQuery('#formtype').val() == "edit") {

        }
        else{
            CreateCombobox([]);
        }
    });

    jQuery('#KodePelanggan').change(function () {
        $.ajax({
            async:false,
            type: 'post',
            url: "{{route('delivery-readheader')}}",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
            },
            data: {
                'TglAwal' : '1999-01-01',
                'TglAkhir' : now.getFullYear()+"-"+month+"-"+day,
                'KodePelanggan' :jQuery('#KodePelanggan').val(),
                'Status' : (jQuery('#formtype').val()) == "add" ? 'O' : ''
            },
            dataType: 'json',
            success: function(response) {
                filteredOrderDetail = response.data;
                CreateCombobox(response.data)
            }
        })
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
    });

    // Hitung otomatis saat input berubah
    jQuery('#tableDetailItem').on('input change', '.qtyfaktur, .harga, .diskon', function () {
        let row = jQuery(this).closest('tr');
        calculateRowTotal(row);
        updateSummary();
    });

    // Auto-isi harga dari select item
    jQuery('#tableDetailItem').on('change', '.select-item', function () {
        let harga = parseFloat(jQuery(this).find(':selected').data('harga')) || 0;
        let hargapokok = parseFloat(jQuery(this).find(':selected').data('hpp')) || 0;
        let row = jQuery(this).closest('tr');

        let hargaSebelumPPN = 0;
        let hargaSet = 0;
        let nilaiPPN = 0;

        if (oPPNInclude == 1) {
            // Jika harga sudah termasuk PPN
            hargaSebelumPPN = oPPN > 0 ? harga / (1 + oPPN / 100) : harga;
            nilaiPPN = harga - hargaSebelumPPN;
            hargaSet = hargaSebelumPPN;

            // force total bulat
            let totalDibulatkan = Math.round((hargaSet + nilaiPPN));

            let koreksi = harga - totalDibulatkan;

            // sesuaikan harga untuk tetap bulat di total
            hargaSet += koreksi;
        } else {
            // Jika harga belum termasuk PPN
            nilaiPPN = oPPN > 0 ? harga * (oPPN / 100) : 0;
            hargaSet = harga; // harga tetap
        }

        row.find('.harga').val(harga);
        row.find('.ppn').val(nilaiPPN);
        row.find('.qtyfaktur').val(1);
        row.find('.diskon').val(0);
        row.find('.hpp').val(hargapokok);

        calculateRowTotal(row);
        updateSummary();
    });

    // Tambah baris
    jQuery('#btnAddRow').on('click', function () {
        let tableBody = jQuery('#tableDetailItem tbody');
        let newRow = tableBody.find('tr:first').clone();

        newRow.find('input').val('');
        newRow.find('select').val('').trigger('change');
        newRow.find('.total').val(''); // pastikan total kosong

        tableBody.append(newRow);
        newRow.find('.select2').select2({ width: 'resolve' });
    });

    // Hapus baris
    jQuery('#tableDetailItem').on('click', '.btnRemoveRow', function () {
        let row = jQuery(this).closest('tr');
        let tableBody = jQuery('#tableDetailItem tbody');

        row.remove();
        updateSummary();
    });

    // Hitung default pada load awal
    jQuery('#tableDetailItem tbody tr').each(function () {
        calculateRowTotal(this);
    });


    function CreateCombobox(data) {
        jQuery('#gridBox').dxDropDownBox({
            displayExpr(item) {
                if (jQuery('#formtype').val() == "add") {
                    CopyFromOrder(item);
                }
                console.log(item)
                if (typeof item != "undefined") {
                    NoOrderPembelian = item.NoTransaksi;
                    return `${item.NoTransaksi}`;
                }
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

    function CopyFromOrder(Data) {
        // console.log(Data);
        var oData = [];
        if (typeof Data != "undefined" ) {
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
                    console.log(response)
                    // BindGridOrder(response.data)
                    const tableBody = jQuery('#tableDetailItem tbody');
                    tableBody.empty(); // hapus semua baris default
                    var index = 1;

                    $.each(response.data,function (k,v) {
                        const newRow = `
                            <tr>
                                <td>
                                    <select class="form-control select2 select-item" name="item[]">
                                        <option value="">Pilih Item</option>
                                        @foreach($item as $i)
                                            <option value="{{ $i->KodeItem }}"
                                                data-harga="{{ $i->HargaJual }}"
                                                data-satuan="{{ $i->Satuan }}"
                                                data-qtykonversi="{{ $i->QtyKonversi }}"
                                                data-hpp="{{ $i->HargaPokokPenjualan }}"
                                                data-namaitem="{{ $i->NamaItem }}">
                                                {{ $i->NamaItem }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="number" class="form-control qtyfaktur" value="0" min=1 max="${v.Qty}"/></td>
                                <td>
                                    <select class="form-control select2 select-gudang" name="gudang[]">
                                        <option value="">Pilih Gudang</option>
                                        @foreach($gudang as $gd)
                                            <option value="{{ $gd->KodeGudang }}">
                                                {{ $gd->NamaGudang }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="text" class="form-control harga" value="${v.Harga}" originalvalue="${v.Harga}" readonly/>
                                    <input type="hidden" class="form-control diskon" value="${v.Discount}" readonly/>
                                    <input type="hidden" class="form-control hpp" value="${v.HargaPokokPenjualan}" originalvalue="${v.HargaPokokPenjualan}" readonly/>
                                    <input type="hidden" class="form-control baseline" value="${v.NoUrut}" originalvalue="${v.NoUrut}" readonly/>
                                </td>
                                <td><input type="text" name="ppn[]" class="form-control ppn" value="${v.VatTotal}" originalvalue="${v.VatTotal}" readonly/></td>
                                <td><input type="text" class="form-control total" readonly/></td>
                                <td><button type="button" class="btn btn-sm btn-danger btnRemoveRow">-</button></td>
                            </tr>
                        `;
                        const row = jQuery(newRow);
                        
                        tableBody.append(row);

                        // Set selected item
                        row.find('.select-item').val(v.KodeItem).trigger('change');
                        row.find('.select-gudang').val(v.KodeGudang).trigger('change');
                        row.find('.select2').select2({ width: 'resolve' });

                        // Kalkulasi ulang total
                        calculateRowTotal(row);

                        index +=1;
                    });
                }
            });

            // Get Header
            $.ajax({
                async:false,
                type: 'post',
                url: "{{route('delivery-findheader')}}",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
                },
                data: {
                    'NoTransaksi' : Data.NoTransaksi,
                },
                dataType: 'json',
                success: function(response) {
                    jQuery('#KodeTermin').val(response.data[0]["KodeTermin"]).trigger('change');
                    jQuery('#TglTransaksi').val(NowDay);
                    jQuery('#TglJatuhTempo').val(response.data[0]["TglJatuhTempo"]);
                    jQuery('#NoReff').val(response.data[0]["NoReff"]);

                    quill_SyaratDanKetentuan.root.innerHTML = response.data[0]["SyaratDanKetentuan"];
                    quill_Keterangan.root.innerHTML = response.data[0]["Keterangan"];
                }
            })
        }
        updateSummary();
    }

    jQuery('#btSave').on('click', function(){
        let formtype = jQuery('#formtype').val();
        let NoTransaksi = jQuery('#NoTransaksi').val();

        let Keterangan = quill_Keterangan.root.innerHTML;
        let SyaratDanKetentuan = quill_SyaratDanKetentuan.root.innerHTML;

        const isEdit = jQuery('#formtype').val() == 'edit'; // pastikan ada elemen dengan id=id jika edit

        // jQuery('#submit-text').hide();
        jQuery('#submit-text').text('Saving...').show();
        jQuery('#submit-spinner').show();
        jQuery('#btSave').prop('disabled', true);
        
        // Get all item details

        var oData = {
            'NoTransaksi' : jQuery('#NoTransaksi').val(),
            'TglTransaksi' : jQuery('#TglTransaksi').val(),
            'TglJatuhTempo' : jQuery('#TglJatuhTempo').val(),
            'NoReff' : jQuery('#NoReff').val(),
            'KodePelanggan' : jQuery('#KodePelanggan').val(),
            'KodeTermin' : jQuery('#KodeTermin').val(),
            'Termin' : TotalTermin,
            'TotalTransaksi' : jQuery('#TotalTransaksi').attr("originalvalue"),
            'Potongan' : jQuery('#Potongan').attr("originalvalue"),
            'Pajak' : jQuery('#Pajak').attr('originalvalue'),
            'TotalPembelian' : jQuery('#TotalPenjualan').attr("originalvalue"),
            'TotalRetur' : 0,
            'TotalPembayaran' : 0,
            'Status' : jQuery('#Status').val(),
            'Keterangan' : Keterangan,
            'MetodeBayar' :'',
            'ReffPembayaran' : '',
            'KodeSales' :'',
            'SyaratDanKetentuan' : SyaratDanKetentuan,
            'Detail' : []
        }

        var index = 0;
        jQuery('#tableDetailItem tbody tr').each(function() {
            const row = jQuery(this);

            const qtyfaktur = parseFloat(row.find('.qtyfaktur').val()) || 0;
            const harga = parseFloat(row.find('.harga').val()) || 0;
            const diskon = parseFloat(row.find('.diskon').val()) || 0;
            const ppn = parseFloat(row.find('.ppn').attr("originalvalue")) || 0;

            // Hitung subtotal
            const subtotal = qtyfaktur * harga;
            const totalDiskon = (subtotal * diskon) / 100;
            const afterDiskon = subtotal - totalDiskon;

            const rowData = {
                'NoUrut' : index,
                'KodeItem' : row.find('.select-item').val(),
                'NamaItem' : row.find('.select-item option:selected').data('namaitem'),
                'Qty' : qtyfaktur * row.find('.select-item option:selected').data('qtykonversi'),
                'QtyKonversi' : row.find('.select-item option:selected').data('qtykonversi'),
                'Satuan' : row.find('.select-item option:selected').data('satuan'),
                'Harga' : harga,
                'Discount' : diskon,
                'HargaNet' : afterDiskon + ppn,
                'BaseReff' : (NoOrderPembelian) != "" ? NoOrderPembelian : "",
                'BaseLine' : row.find('.baseline').val(),
                'BaseType' : (NoOrderPembelian) != "" ? "DLN" : "",
                'KodeGudang' : row.find('.select-gudang').val(),
                'LineStatus':'O',
                'VatPercent': oPPN,
                'VatTotal': ppn,
                'HargaPokokPenjualan': row.find('.select-item option:selected').data('hpp'),
            };
            

            // Memperbarui nilai Total pada kolom di DOM

            // Push data ke oData
            oData.Detail.push(rowData);
            index++;
        });


        // Send data to server using AJAX
        console.log(oData);

        if (jQuery('#formtype').val() == "add") {
            $.ajax({
                url: "{{route('fpenjualan-storeJson')}}",
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
                            window.location.href = '{{url("fpenjualan")}}';
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
                url: "{{route('fpenjualan-editJson')}}",
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
                            window.location.href = '{{url("fpenjualan")}}';
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

    function calculateRowTotal(row) {
        let qty = parseFloat(jQuery(row).find('.qtyfaktur').val()) || 0;
        let hargaInput = parseFloat(jQuery(row).find('.harga').val()) || 0;
        let diskon = parseFloat(jQuery(row).find('.diskon').val()) || 0;

        console.log("Qty : " + qty);

        let hargaSebelumPPN, afterDiskon, nilaiPPN, hargaNet;

        // Jika harga sudah termasuk PPN
        if (oPPNInclude == 1 && oPPN > 0) {
            // Hitung harga sebelum PPN
            hargaSebelumPPN = hargaInput / (1 + oPPN / 100);
            let subtotal = qty * hargaSebelumPPN;
            let totalDiskon = subtotal * (diskon / 100);
            let dpp = subtotal - totalDiskon;

            console.log("Subtotal : " + subtotal);
            console.log("Total Diskon : " + totalDiskon);
            console.log("DPP : " + dpp);
            

            nilaiPPN = dpp * (oPPN / 100);
            hargaNet = dpp + nilaiPPN;

        } else {
            // Harga belum termasuk PPN, langsung pakai input
            hargaSebelumPPN = hargaInput;
            let subtotal = qty * hargaSebelumPPN;
            let totalDiskon = subtotal * (diskon / 100);
            let dpp = subtotal - totalDiskon;
            nilaiPPN = oPPN > 0 ? dpp * (oPPN / 100) : 0;
            hargaNet = dpp + nilaiPPN;
        }

        console.log("Nilai PPN : " + nilaiPPN);
        console.log("Harga Net : " + hargaNet);

        jQuery(row).find('.ppn')
        .val(nilaiPPN.toFixed(2))
        .attr("originalvalue", nilaiPPN.toFixed(2));

        jQuery(row).find('.total')
        .val(hargaNet.toFixed(2))
        .attr("originalvalue", hargaNet.toFixed(2));

        jQuery(row).find('.harga')
        .attr("originalvalue", hargaSebelumPPN.toFixed(2));
        
        formatCurrency(jQuery(row).find('.ppn'), nilaiPPN.toFixed(2));
        formatCurrency(jQuery(row).find('.total'), hargaNet.toFixed(2));
    }


    function updateSummary() {
        let subtotal = 0;
        let totalPPN = 0;
        let totalDiskon = 0;
        let total = 0;

        jQuery('#tableDetailItem tbody tr').each(function () {
            let qty = parseFloat(jQuery(this).find('.qtyfaktur').val()) || 0;
            let harga = parseFloat(jQuery(this).find('.harga').val()) || 0;
            let diskon = parseFloat(jQuery(this).find('.diskon').val()) || 0;
            let ppn = parseFloat(jQuery(this).find('.ppn').attr("originalvalue")) || 0;
            let hargaNet = parseFloat(jQuery(this).find('.total').attr("originalvalue")) || 0;
            let hargaSebelumPPN = parseFloat(jQuery(this).find('.harga').attr("originalvalue")) || 0;

            let barisSubtotal = qty * hargaSebelumPPN;
            let barisDiskon = hargaSebelumPPN * (diskon / 100);

            console.log("Baris Subtotal : " + barisSubtotal);

            subtotal += barisSubtotal;
            totalDiskon += barisDiskon;
            totalPPN += ppn;
            total += hargaNet;
        });

        let dpp = subtotal - totalDiskon;

        formatCurrency(jQuery('#TotalTransaksi'), dpp);
        formatCurrency(jQuery('#Potongan'), totalDiskon);
        formatCurrency(jQuery('#TotalPenjualan'), total);
        formatCurrency(jQuery('#Pajak'), totalPPN);

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