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
					<a href="{{route('openjualan')}}">Daftar Order Penjualan</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Order Penjualan</li>
			</ol>
		</nav>
	</div>
</div>

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
										@if (count($orderheader) > 0)
											<input type="hidden" name="formtype" id="formtype" value="edit">
                                    		Edit Order Penjualan
	                                	@else
	                                		<input type="hidden" name="formtype" id="formtype" value="add">
	                                    	Tambah Order Penjualan
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
                            		<div class="col-md-2">
                            			<label  class="text-body">No Transaksi (*)</label>
                            			<fieldset class="form-group mb-3">
                            				<input type="text" class="form-control" id="NoTransaksi" name="NoTransaksi" placeholder="<Auto>" value="{{ count($orderheader) > 0 ? $orderheader[0]['NoTransaksi'] : '' }}" required="">
                            			</fieldset>
                            			
                            		</div>

                            		<div class="col-md-3">
                            			<label  class="text-body">Status</label>
                            			<fieldset class="form-group mb-3">
                            				<select name="Status" id="Status" class="js-example-basic-single js-states form-control bg-transparent" >
												<option value="O" {{ count($orderheader) > 0 ? $orderheader[0]['Status'] == 'O' ? "selected" : '' :""}} >OPEN</option>
												<option value="C" {{ count($orderheader) > 0 ? $orderheader[0]['Status'] == 'C' ? "selected" : '' :""}} >CLOSE</option>
												<option value="D" {{ count($orderheader) > 0 ? $orderheader[0]['Status'] == 'D' ? "selected" : '' :""}}>CANCEL</option>
												
											</select>
                            			</fieldset>
                            		</div>

                            		<div class="col-md-3">
                            			<label  class="text-body">Pelanggan</label>
                            			<fieldset class="form-group mb-3">
                            				<select name="KodePelanggan" id="KodePelanggan" class="js-example-basic-single js-states form-control bg-transparent" >
												<option value="-1">Pilih Pelanggan</option>
												@foreach($pelanggan as $ko)
													<option 
                                                        value="{{ $ko->KodePelanggan }}"
                                                        {{ count($orderheader) > 0 ? $orderheader[0]['KodePelanggan'] == $ko->KodePelanggan ? "selected" : '' :""}}
                                                    >
                                                        {{ $ko->NamaPelanggan }}
                                                    </option>
												@endforeach
												
											</select>
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
                                                        {{ count($orderheader) > 0 ? $orderheader[0]['KodeTermin'] == $ko->id ? "selected" : '' :""}}
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
                            				<input type="date" class="form-control" id="TglTransaksi" name="TglTransaksi" placeholder="<Auto>" value="{{ count($orderheader) > 0 ? $orderheader[0]['TglTransaksi'] : '' }}" required="">
                            			</fieldset>
                            		</div>

                            		<div class="col-md-3">
                            			<label  class="text-body">Tanggal Jatuh Tempo</label>
                            			<fieldset class="form-group mb-3">
                            				<input type="date" class="form-control" id="TglJatuhTempo" name="TglJatuhTempo" placeholder="<Auto>" value="{{ count($orderheader) > 0 ? $orderheader[0]['TglJatuhTempo'] : '' }}" required="">
                            			</fieldset>
                            		</div>

                            		<div class="col-md-6">
                            			<label  class="text-body">No Reff</label>
                            			<fieldset class="form-group mb-3">
                            				<input type="text" class="form-control" id="NoReff" name="NoReff" placeholder="Masukan No Reff" value="{{ count($orderheader) > 0 ? $orderheader[0]['NoReff'] : '' }}" >
                            			</fieldset>
                            		</div>

                                    <div class="col-md-6">
                            			<label  class="text-body">Keterangan</label>
                            			<div id="Keterangan" style="height: 100px;">
                                            {!! count($orderheader) > 0 ? $orderheader[0]['Keterangan'] : '' !!}
                                        </div>
                            		</div>

                                    <div class="col-md-6">
                            			<label  class="text-body">Syarat dan Ketentuan</label>
                            			<div id="SyaratDanKetentuan" style="height: 100px;">
                                            {!! count($orderheader) > 0 ? $orderheader[0]['SyaratDanKetentuan'] : '' !!}
                                        </div>
                            		</div>

                                    <br>
                                    <div class="col-md-12"><hr></div>
                                    

                            		{{-- Detail Hire --}}

                                    <div class="col-md-12">
                                        <label class="text-body">Detail Item</label>
                                        <table class="table table-bordered" id="tableDetailItem">
                                            <thead>
                                                <tr>
                                                    <th style="width: 30%">Item</th>
                                                    <th style="width: 10%">Qty</th>
                                                    <th style="width: 15%">Harga</th>
                                                    <th style="width: 10%">Diskon (%)</th>
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
                                                                <option value="{{ $it->KodeItem }}" data-harga="{{ $it->HargaJual }}" data-satuan="{{ $it->Satuan }}" data-qtykonversi="{{ $it->QtyKonversi }}">
                                                                    {{ $it->NamaItem }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td><input type="number" name="qty[]" class="form-control qty" value="1" min="1" /></td>
                                                    <td><input type="text" name="harga[]" class="form-control harga" /></td>
                                                    <td><input type="text" name="diskon[]" class="form-control diskon" value="0" /></td>
                                                    <td><input type="text" name="ppn[]" class="form-control ppn" /></td>
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
                            					<td><input type="text" align="right" name="TotalTransaksi" id="TotalTransaksi" class="form-control aligned-textbox" value="{{ count($orderheader) > 0 ? $orderheader[0]['TotalTransaksi'] : '0' }}" readonly=""></td>
                            				</tr>
                                            <tr>
                            					<td>PPN</td>
                            					<td>:</td>
                            					<td><input type="text" align="right" name="Pajak" id="Pajak" readonly="" class="form-control aligned-textbox" value="{{ count($orderheader) > 0 ? $orderheader[0]['Pajak'] : '0' }}"></td>
                            				</tr>
                            				<tr>
                            					<td>Diskon</td>
                            					<td>:</td>
                            					<td><input type="text" align="right" name="Potongan" id="Potongan" readonly="" class="form-control aligned-textbox" value="{{ count($orderheader) > 0 ? $orderheader[0]['Potongan'] : '0' }}"></td>
                            				</tr>
                            				<tr>
                            					<td>Total</td>
                            					<td>:</td>
                            					<td><input type="text" align="right" name="TotalPenjualan" id="TotalPenjualan" readonly="" class="form-control aligned-textbox" value="{{ count($orderheader) > 0 ? $orderheader[0]['TotalPenjualan'] : '0' }}"></td>
                            				</tr>
                            			</table>
                            		</div>

                                    <div class="row"></div>

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

@endsection

@push('scripts')
@extends('parts.generaljs')

<!-- Select2 -->

<script>
$(document).ready(function () {
    var TotalTermin = 0;
    var orderDetailData = <?php echo json_encode($orderdetail) ?>;
    var oPPN = <?php echo $ppnpercent ?>;
    var oPPNInclude = <?php echo $ppninclude ?>;

    console.log(oPPN);
    console.log(oPPNInclude);

    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var firstDay = now.getFullYear()+"-"+month+"-01";
    var NowDay = now.getFullYear()+"-"+month+"-"+day;

    jQuery('#TglTransaksi').val(NowDay);
    jQuery('#TglJatuhTempo').val(NowDay);

    // init Quill
    var quill_Keterangan = new Quill('#Keterangan', {
        theme: 'snow'
    });
    var quill_SyaratDanKetentuan = new Quill('#SyaratDanKetentuan', {
        theme: 'snow'
    });
    // Init select2
    jQuery('.select2').select2({ width: 'resolve' });

    if (jQuery('#formtype').val() === 'edit' && orderDetailData.length > 0) {
        const tableBody = jQuery('#tableDetailItem tbody');
        tableBody.empty(); // hapus semua baris default

        orderDetailData.forEach(function(item, index) {
            const newRow = `
                <tr>
                    <td>
                        <select class="form-control select2 select-item" name="item[]">
                            <option value="">Pilih Item</option>
                            @foreach($item as $i)
                                <option value="{{ $i->KodeItem }}"
                                    data-harga="{{ $i->HargaDefault }}"
                                    data-satuan="{{ $i->Satuan }}"
                                    data-qtykonversi="{{ $i->QtyKonversi }}">
                                    {{ $i->NamaItem }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="number" class="form-control qty" value="${item.Qty}" /></td>
                    <td><input type="text" class="form-control harga" value="${item.Harga}" /></td>
                    <td><input type="text" class="form-control diskon" value="${item.Discount}" /></td>
                    <td><input type="text" name="ppn[]" class="form-control ppn" value="${item.VatTotal}"/></td>
                    <td><input type="text" class="form-control total" readonly /></td>
                    <td><button type="button" class="btn btn-sm btn-danger btnRemoveRow">-</button></td>
                </tr>
            `;

            const row = jQuery(newRow);
            tableBody.append(row);

            // Set selected item
            row.find('.select-item').val(item.KodeItem).trigger('change');
            row.find('.select2').select2({ width: 'resolve' });

            // Kalkulasi ulang total
            calculateRowTotal(row);
        });

        updateSummary();
    }



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

    function calculateRowTotal(row) {
        let qty = parseFloat(jQuery(row).find('.qty').val()) || 0;
        let hargaInput = parseFloat(jQuery(row).find('.harga').val()) || 0;
        let diskon = parseFloat(jQuery(row).find('.diskon').val()) || 0;

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
            let qty = parseFloat(jQuery(this).find('.qty').val()) || 0;
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

    // Hitung otomatis saat input berubah
    jQuery('#tableDetailItem').on('input change', '.qty, .harga, .diskon', function () {
        let row = jQuery(this).closest('tr');
        calculateRowTotal(row);
        updateSummary();
    });

    // Auto-isi harga dari select item
    jQuery('#tableDetailItem').on('change', '.select-item', function () {
        let harga = parseFloat(jQuery(this).find(':selected').data('harga')) || 0;
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
        row.find('.qty').val(1);
        row.find('.diskon').val(0);

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
        // newRow.find('.select2-selection.select2-selection--single').hide();
        // newRow.find('span.selection').css('display', 'none');
        // newRow.find('span.selection > span.select2-selection.select2-selection--single').css('display', 'none');
    });

    // Hapus baris
    jQuery('#tableDetailItem').on('click', '.btnRemoveRow', function () {
        // if (jQuery('#tableDetailItem tbody tr').length > 1) {
        //     jQuery(this).closest('tr').remove();
        // }
        let row = jQuery(this).closest('tr');
        let tableBody = jQuery('#tableDetailItem tbody');
        
        if (row.is(':first-child')) {
            // Reset semua nilai di baris pertama
            row.find('input').val('');
            row.find('select').val('').trigger('change');
            row.find('.total').val('');
        } else {
            row.remove();
        }
        updateSummary();
    });

    // Hitung default pada load awal
    jQuery('#tableDetailItem tbody tr').each(function () {
        calculateRowTotal(this);
    });

    // Save Method

    jQuery('#btSave').on('click', function(){
        let formtype = jQuery('#formtype').val();
        let NoTransaksi = jQuery('#NoTransaksi').val();
        let Status = jQuery('#Status').val();
        let KodePelanggan = jQuery('#KodePelanggan').val();
        let KodeTermin = jQuery('#KodeTermin').val();
        let TglTransaksi = jQuery('#TglTransaksi').val();
        let TglJatuhTempo = jQuery('#TglJatuhTempo').val();
        let NoReff = jQuery('#NoReff').val();
        let Keterangan = quill_Keterangan.root.innerHTML;
        let SyaratDanKetentuan = quill_SyaratDanKetentuan.root.innerHTML;

        const isEdit = jQuery('#formtype').val() == 'edit'; // pastikan ada elemen dengan id=id jika edit
        const endpoint = isEdit ?  "{{route('openjualan-editJson')}}" : "{{route('openjualan-storeJson')}}";

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
            'Pajak' : jQuery('#Pajak').attr("originalvalue"),
            'TotalPenjualan' : jQuery('#TotalPenjualan').attr("originalvalue"),
            'TotalRetur' : 0,
            'TotalPembayaran' : 0,
            'Status' : jQuery('#Status').val(),
            'Keterangan' : Keterangan,
            'SyaratDanKetentuan' : SyaratDanKetentuan,
            'Detail' : []
        }

        var index = 0;
        jQuery('#tableDetailItem tbody tr').each(function() {
            const row = jQuery(this);

            const qty = parseFloat(row.find('.qty').val()) || 0;
            const harga = parseFloat(row.find('.harga').val()) || 0;
            const diskon = parseFloat(row.find('.diskon').val()) || 0;
            const ppn = parseFloat(row.find('.ppn').attr("originalvalue")) || 0;

            // Hitung subtotal
            const subtotal = qty * harga;
            const totalDiskon = (subtotal * diskon) / 100;
            const afterDiskon = subtotal - totalDiskon;

            const rowData = {
                'NoUrut' : index,
                'KodeItem' : row.find('.select-item').val(),
                'Qty' : qty,
                'QtyKonversi' : qty * row.find('.select-item option:selected').data('qtykonversi'),
                'Satuan' : row.find('.select-item option:selected').data('satuan'),
                'Harga' : harga,
                'VatPercent' : oPPN,
                'Discount' : diskon,
                'HargaNet' : afterDiskon,
                'LineStatus':"O",
                'VatTotal' : ppn,
            };
            

            // Memperbarui nilai Total pada kolom di DOM

            // Push data ke oData
            oData.Detail.push(rowData);
            index++;
        });


        // Send data to server using AJAX
        // console.log(oData);

        if (jQuery('#formtype').val() == "add") {
            $.ajax({
                url: "{{route('openjualan-storeJson')}}",
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
                            window.location.href = '{{url("openjualan")}}';
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
                url: "{{route('openjualan-editJson')}}",
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
                            window.location.href = '{{url("openjualan")}}';
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
});
</script>
@endpush
