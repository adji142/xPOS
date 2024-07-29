@extends('partadmin.headeradmin')
	
@section('content')
<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">Pengguna Aplikasi</li>
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
									<h3 class="card-label mb-0 font-weight-bold text-body">Daftar Pengguna Aplikasi 
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
								<div class="table-responsive" id="printableTable">
									<table id="orderTable" class="display" style="width:100%">
										<thead>
											<tr>
                                                <th class="no-sort">Action</th>
												<th>Kode Partner</th>
												<th>Nama Partner</th>
                                                <th>Status</th>
												<th>Alamat</th>
												<th>No. Tlp</th>
                                                <th>No. Tlp Alternatif</th>
                                                <th>Nama PIC</th>
                                                <th>Mulai Berlangganan</th>
                                                <th>Selesai Berlangganan</th>
                                                <th>Toleransi (Hari)</th>
                                                <th>Tanggal Jatuh Tempo</th>
                                                <th>Jenis Usaha</th>
                                                <th>Paket Berlangganan</th>
											</tr>
										</thead>
										<tbody>
											@if (count($oCompany) > 0)
                                                @foreach ($oCompany as $v)
                                                    @if ($v['KodePartner'] != "999999")
                                                        <tr>
                                                            <th class=" no-sort text-end">
                                                                @if ($v['Subscription'] == "Bill" && $v['StatusSubscription'=='Belum Bayar'])
                                                                    <button class="btn btn-outline-primary" onclick="ShowDetail('{{ $v['KodePartner'] }}')">Buat Tagihan</button>
                                                                @endif

                                                                @if ($v['isSuspended'] == 0)
                                                                    <button class="btn btn-outline-danger" onclick="Suspend('{{ $v['KodePartner'] }}')">Suspend</button>
                                                                @else
                                                                    <button class="btn btn-outline-warning" onclick="UnSuspend('{{ $v['KodePartner'] }}')">Buka Suspend</button>
                                                                @endif

                                                                @if ($v['StatusSubscription'] == "Perlu Aktivasi-danger")
                                                                    <button class="btn btn-outline-success" onclick="Aktivasi('{{ $v['KodePartner'] }}')">Aktivasi</button>
                                                                @endif
                                                            </th>
                                                            <th>{{ $v['KodePartner'] }}</th>
                                                            <th>{{ $v['NamaPartner'] }}</th>
                                                            <th>
                                                                {{-- <span class="mr-0 text-success">Approved</span> --}}
                                                                @php
                                                                    $oData = explode('-',$v['StatusSubscription']);
                                                                    // echo $oData[0];
                                                                    echo '<span class="mr-0 text-'.$oData[1].'">
                                                                            '.$oData[0].'
                                                                        </span>'
                                                                    // var_dump($oData);
                                                                @endphp
                                                            </th>
                                                            <th>{{ $v['AlamatTagihan'] }}</th>
                                                            <th>{{ $v['NoTlp'] }}</th>
                                                            <th>{{ $v['NoHP'] }}</th>
                                                            <th>{{ $v['NamaPIC'] }}</th>
                                                            <th>{{ $v['StartSubs'] }}</th>
                                                            <th>{{ $v['EndSubs'] }}</th>
                                                            <th>{{ $v['ExtraDays'] }}</th>
                                                            <th>{{ $v['JatuhTempo'] }}</th>
                                                            <th>{{ $v['JenisUsaha'] }}</th>
                                                            <th>{{ $v['NamaSubscription'] }}</th>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endif
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
		</div>
	</div>
	
</div>

<div class="modal fade text-left" id="LookupBuatTagihan" tabindex="-1" role="dialog" aria-labelledby="LookupBuatTagihan" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h3 class="modal-title" id="myModalLabel1444">Tagihan Pelanggan</h3>
			<button type="button" class="close rounded-pill btn btn-sm btn-icon btn-light btn-hover-primary m-0" data-bs-dismiss="modal" aria-label="Close">
			  <svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-x" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
				  <path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
			  </svg>
			</button>
		  </div>
		  <div class="modal-body">
			<div class="col-md-12">
				<div class="form-group row">
					<div class="col-md-12">
            			<label  class="text-body">Kode Pelanggan</label>
            			<fieldset class="form-group mb-3">
            				<input type="text" class="form-control" id="ModalKodePelanggan" name="ModalKodePelanggan" placeholder="<AUTO>" readonly="" >
            			</fieldset>
            			
            		</div>
            		
            		<div class="col-md-12">
            			<label  class="text-body">Nama Pelanggan</label>
            			<fieldset class="form-group mb-3">
            				<input type="text" class="form-control" id="ModalNamaPelanggan" name="ModalNamaPelanggan" placeholder="Masukan Nama Pelanggan" required="">
            			</fieldset>
            			
            		</div>

                    <div class="col-md-6">
                        <label  class="text-body">Tanggal Tagihan</label>
                        <fieldset class="form-group mb-3">
                            <input type="date" class="form-control" id="ModalTglTransaksi" name="ModalTglTransaksi" placeholder="Masukan Harga">
                        </fieldset>
                    </div>

                    <div class="col-md-6">
                        <label  class="text-body">Tanggal Jatuh Tempo</label>
                        <fieldset class="form-group mb-3">
                            <input type="date" class="form-control" id="ModalTglJatuhTempo" name="ModalTglJatuhTempo" placeholder="Masukan Harga">
                        </fieldset>
                    </div>

                    <div class="col-md-12">
            			<label  class="text-body">Produk Langganan</label>
            			<fieldset class="form-group mb-3">
            				<select name="ModalKodePaketLangganan" id="ModalKodePaketLangganan" class="js-example-basic-single js-states form-control bg-transparent" name="state" required="">
								<option value="">Pilih Produk Langganan</option>
								@foreach($subs as $ko)
									<option value="{{ $ko->NoTransaksi }}">
                                        {{ $ko->NamaSubscription }}
                                    </option>
								@endforeach
								
							</select>
            			</fieldset>
            			
            		</div>

                    <div class="col-md-12">
                        <label  class="text-body">Keterangan</label>
                        <fieldset class="form-group mb-3">
                            <input id="ModalCatatan" name="ModalCatatan" class="bg-transparent text-dark"></input>
                        </fieldset>
                    </div>

                    <div class="col-md-12">
                        <label  class="text-body">Harga Produk</label>
                        <fieldset class="form-group mb-3">
                            <input readonly type="text" class="form-control" id="ModalHarga" name="ModalHarga" placeholder="Masukan Harga">
                        </fieldset>
                    </div>

                    <div class="col-md-6">
                        <label  class="text-body">Mulai Berlanggnan</label>
                        <fieldset class="form-group mb-3">
                            <input type="date" class="form-control" id="ModalStartSubs" name="ModalStartSubs" placeholder="Masukan Harga">
                        </fieldset>
                    </div>

                    <div class="col-md-6">
                        <label  class="text-body">Selesai Berlanggnan</label>
                        <fieldset class="form-group mb-3">
                            <input type="date" class="form-control" id="ModalEndSubs" name="ModalEndSubs" placeholder="Masukan Harga">
                        </fieldset>
                    </div>

				</div>
			</div>
			<hr>
			<div class="form-group row justify-content-end mb-0">
				<div class="col-md-6  text-end">
					<button type="button" class="btn btn-primary" id="btSaveTagihan">Simpan Data</button>
				</div>
			</div>
		  </div>
		</div>
	</div>	  	  
</div>

<div class="modal fade text-left" id="LookupSuspend" tabindex="-1" role="dialog" aria-labelledby="LookupBuatTagihan" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h3 class="modal-title" id="myModalLabel1444">Suspend Pelanggan</h3>
			<button type="button" class="close rounded-pill btn btn-sm btn-icon btn-light btn-hover-primary m-0" data-bs-dismiss="modal" aria-label="Close">
			  <svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-x" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
				  <path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
			  </svg>
			</button>
		  </div>
		  <div class="modal-body">
			<div class="col-md-12">
                <form action="{{route('penggunaaplikasi-suspend')}}" method="post">
                    @csrf
                    <div class="form-group row">
                        <div class="col-md-3">
                            <label  class="text-body">Kode Partner</label>
                            <fieldset class="form-group mb-3">
                                <input readonly type="text" id="ModalKodePartner" name="KodePartner" class="form-control" required>
                            </fieldset>
                        </div>
                        <div class="col-md-8">
                            <label  class="text-body">Nama Partner</label>
                            <fieldset class="form-group mb-3">
                                <input readonly type="text" id="ModalNamaPartner" name="NamaPartner" class="form-control" required>
                            </fieldset>
                        </div>
                        <div class="col-md-12">
                            <label  class="text-body">Alasan Suspend</label>
                            <fieldset class="form-group mb-3">
                                <input type="hidden" value="1" id="isSuspended" name="isSuspended">
                                <input type="text" id="ModalSuspendReason" name="SuspendReason" class="form-control" required>
                            </fieldset>
                        </div>
    
                    </div>
                    <hr>
                    <div class="form-group row justify-content-end mb-0">
                        <div class="col-md-6  text-end">
                            <button type="submit" class="btn btn-primary" id="btSaveTagihan">Simpan Data</button>
                        </div>
                    </div>
                </form>
			</div>
		  </div>
		</div>
	</div>	  	  
</div>


<div class="modal fade text-left" id="LookupUnSuspend" tabindex="-1" role="dialog" aria-labelledby="LookupBuatTagihan" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h3 class="modal-title" id="myModalLabel1444">Buka Suspend Pelanggan</h3>
			<button type="button" class="close rounded-pill btn btn-sm btn-icon btn-light btn-hover-primary m-0" data-bs-dismiss="modal" aria-label="Close">
			  <svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-x" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
				  <path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
			  </svg>
			</button>
		  </div>
		  <div class="modal-body">
			<div class="col-md-12">
                <form action="{{route('penggunaaplikasi-suspend')}}" method="post">
                    @csrf
                    <div class="form-group row">
                        <div class="col-md-3">
                            <label  class="text-body">Kode Partner</label>
                            <fieldset class="form-group mb-3">
                                <input readonly type="text" id="ModalKodePartnerBuka" name="KodePartner" class="form-control" required>
                            </fieldset>
                        </div>
                        <div class="col-md-8">
                            <label  class="text-body">Nama Partner</label>
                            <fieldset class="form-group mb-3">
                                <input readonly type="text" id="ModalNamaPartnerBuka" name="NamaPartner" class="form-control" required>
                            </fieldset>
                        </div>
                        <div class="col-md-12">
                            <label  class="text-body">Tanggal Berakhir Langganan</label>
                            <fieldset class="form-group mb-3">
                                <input type="hidden" value="0" name="isSuspended">
                                <input type="date" id="ModalEndSubsBuka" name="EndSubs" class="form-control" required>
                            </fieldset>
                        </div>
    
                    </div>
                    <hr>
                    <div class="form-group row justify-content-end mb-0">
                        <div class="col-md-6  text-end">
                            <button type="submit" class="btn btn-primary" id="btSaveTagihan">Simpan Data</button>
                        </div>
                    </div>
                </form>
			</div>
		  </div>
		</div>
	</div>	  	  
</div>

<div class="modal fade text-left" id="LookupAktivasi" tabindex="-1" role="dialog" aria-labelledby="LookupBuatTagihan" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h3 class="modal-title" id="myModalLabel1444">Buka Suspend Pelanggan</h3>
			<button type="button" class="close rounded-pill btn btn-sm btn-icon btn-light btn-hover-primary m-0" data-bs-dismiss="modal" aria-label="Close">
			  <svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-x" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
				  <path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
			  </svg>
			</button>
		  </div>
		  <div class="modal-body">
			<div class="col-md-12">
                <form action="{{route('penggunaaplikasi-suspend')}}" method="post">
                    @csrf
                    <div class="form-group row">
                        <div class="col-md-3">
                            <label  class="text-body">Kode Partner</label>
                            <fieldset class="form-group mb-3">
                                <input type="hidden" value="2" name="isSuspended">
                                <input readonly type="text" id="ModalKodePartnerAktivasi" name="KodePartner" class="form-control" required>
                            </fieldset>
                        </div>
                        <div class="col-md-8">
                            <label  class="text-body">Nama Partner</label>
                            <fieldset class="form-group mb-3">
                                <input readonly type="text" id="ModalNamaPartnerAktivasi" name="NamaPartner" class="form-control" required>
                            </fieldset>
                        </div>
                        <div class="col-md-6">
                            <label  class="text-body">Tanggal Mulai Langganan</label>
                            <fieldset class="form-group mb-3">
                                <input type="date" id="ModalStartSubsAktivasi" name="StartSubs" class="form-control" required>
                            </fieldset>
                        </div>
                        <div class="col-md-6">
                            <label  class="text-body">Tanggal Berakhir Langganan</label>
                            <fieldset class="form-group mb-3">
                                <input type="date" id="ModalEndSubsAktivasi" name="EndSubs" class="form-control" required>
                            </fieldset>
                        </div>
    
                    </div>
                    <hr>
                    <div class="form-group row justify-content-end mb-0">
                        <div class="col-md-6  text-end">
                            <button type="submit" class="btn btn-primary" id="btSaveTagihan">Simpan Data</button>
                        </div>
                    </div>
                </form>
			</div>
		  </div>
		</div>
	</div>	  	  
</div>

@endsection

@push('scripts')
<script type="text/javascript">
    var oCompany;
    var oSubs;

	jQuery(document).ready(function() {
        var now = new Date();
        var day = ("0" + now.getDate()).slice(-2);
        var month = ("0" + (now.getMonth() + 1)).slice(-2);
        var firstDay = now.getFullYear()+"-"+month+"-01";
        var NowDay = now.getFullYear()+"-"+month+"-"+day;
        GetDate = now.getFullYear()+"-"+month+"-"+day;

        jQuery('#ModalTglTransaksi').val(NowDay);
        jQuery('#ModalTglJatuhTempo').val(NowDay);
        jQuery('#ModalEndSubsBuka').val(NowDay);

        jQuery('#ModalStartSubsAktivasi').val(firstDay);
        jQuery('#ModalEndSubsAktivasi').val(NowDay);


		jQuery('#orderTable').DataTable({
			"pagingType": "simple_numbers",
	  
		"columnDefs": [ {
		  "targets"  : 'no-sort',
		  "orderable": false,
		}],
		});

        jQuery('.js-example-basic-single').select2({
            dropdownParent: $('#LookupBuatTagihan')
        });

        oCompany = <?php echo $oCompany; ?>;
        oSubs = <?php echo $subs; ?>;

        // console.log(oCompany);
        // console.log(oSubs);
	} );
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

    function ShowDetail(Partner) {
        jQuery('#LookupBuatTagihan').modal({backdrop: 'static', keyboard: false})
		jQuery('#LookupBuatTagihan').modal('show');

        // alert('asd');
        const filterPelanggan = oCompany.filter(comp => comp.KodePartner === Partner);
        // console.log(filterPelanggan[0]);
        jQuery('#ModalKodePelanggan').val(Partner);
        jQuery('#ModalNamaPelanggan').val(filterPelanggan[0]['NamaPartner']);
        jQuery('#ModalKodePaketLangganan').val(filterPelanggan[0]['KodePaketLangganan']).trigger('change');
        jQuery('#ModalStartSubs').val(filterPelanggan[0]['EndSubs'])
        jQuery('#ModalEndSubs').val(filterPelanggan[0]['EndSubs']);
        // console.log(filterPelanggan[0]['EndSubs'].getDate())
    }

    function Suspend(Partner) {
        const filterPelanggan = oCompany.filter(comp => comp.KodePartner === Partner);

        jQuery('#ModalKodePartner').val(filterPelanggan[0]['KodePartner']);
        jQuery('#ModalNamaPartner').val(filterPelanggan[0]['NamaPartner']);

        jQuery('#LookupSuspend').modal({backdrop: 'static', keyboard: false})
		jQuery('#LookupSuspend').modal('show');
    }

    function UnSuspend(Partner) {
        const filterPelanggan = oCompany.filter(comp => comp.KodePartner === Partner);

        jQuery('#ModalKodePartnerBuka').val(filterPelanggan[0]['KodePartner']);
        jQuery('#ModalNamaPartnerBuka').val(filterPelanggan[0]['NamaPartner']);

        jQuery('#LookupUnSuspend').modal({backdrop: 'static', keyboard: false})
		jQuery('#LookupUnSuspend').modal('show');
    }

    function Aktivasi(Partner) {
        const filterPelanggan = oCompany.filter(comp => comp.KodePartner === Partner);

        jQuery('#ModalKodePartnerAktivasi').val(filterPelanggan[0]['KodePartner']);
        jQuery('#ModalNamaPartnerAktivasi').val(filterPelanggan[0]['NamaPartner']);

        jQuery('#LookupAktivasi').modal({backdrop: 'static', keyboard: false})
		jQuery('#LookupAktivasi').modal('show');
    }

    jQuery('#ModalKodePaketLangganan').change(function () {
        // console.log(oSubs);
        const filterSubs = oSubs.filter(subs => subs.NoTransaksi === jQuery('#ModalKodePaketLangganan').val());
        // DeskripsiSubscriptionInstance.setData(filterSubs[0]['DeskripsiSubscription']);
        // console.log(filterSubs[0]['Harga'])
        formatCurrency($('#ModalHarga'), filterSubs[0]['Harga']);
    });

    jQuery('#btSaveTagihan').click(function () {
        // jQuery('#btSaveTagihan').text('Tunggu Sebentar.....');
        // jQuery('#btSaveTagihan').attr('disabled',true);

        var oDetail = [];
        var oItem = {
            'NoTransaksi' : '',
            'NoUrut' : -1,
            'Harga' : jQuery('#ModalHarga').attr("originalvalue"),
            'Catatan' : jQuery('#ModalCatatan').val(),
            'KodePelanggan' : jQuery('#ModalKodePelanggan').val(),
        }
        oDetail.push(oItem)
        let currentDate = moment();
        // const filterPelanggan = oCompany.filter(comp => comp.KodePartner === Partner);

        var oData = {
            'NoTransaksi' : '',
            'TglTransaksi' : jQuery('#ModalTglTransaksi').val(),
            'TglJatuhTempo' : jQuery('#ModalTglJatuhTempo').val(),
            'KodePaketLangganan' : jQuery('#ModalKodePaketLangganan').val(),
            'Catatan' : DeskripsiSubscriptionInstance.getData(),
            'KodePelanggan' : jQuery('#ModalKodePelanggan').val(),
            'TotalTagihan' : jQuery('#ModalHarga').attr("originalvalue"),
            'TotalBayar' : 0,
            'Status' : 'O',
            'StartSubs' : jQuery('#ModalStartSubs').val(),
            'EndSubs' : jQuery('#ModalEndSubs').val(),
            'Detail' : oDetail
        }

        // console.log(oData);
        $.ajax({
            url: "{{route('invpengguna-storeJson')}}",
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
                        window.location.href = '{{url("penggunaaplikasi")}}';
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
        });
    });
</script>
@endpush