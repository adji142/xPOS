@extends('partadmin.headeradmin')
	
@section('content')
<style>
    /* Basic styling to prevent CSS conflicts */
    .ck-editor__editable {
        white-space: normal !important;
    }
</style>
<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">
					<a href="{{route('subs')}}"></a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Input Produk Berlangganan</li>
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

                                        @if (count($subscriptionheader) > 0)
                                        Edit Produk Berlangganan
                                    		<input type="hidden" name="formtype" id="formtype" value="edit">
	                                	@else
                                        Tambah Produk Berlangganan
	                                    	<input type="hidden" name="formtype" id="formtype" value="add">
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
                                        <label  class="text-body">Kode Produk Berlangganan</label>
                                        <fieldset class="form-group mb-3">
                                            <input type="text" class="form-control" id="NoTransaksi" name="NoTransaksi" placeholder="Masukan Kode Produk Berlangganan" value="{{ count($subscriptionheader) > 0 ? $subscriptionheader[0]['NoTransaksi'] : '' }}" {{ count($subscriptionheader) > 0 ? 'readonly' : '' }}>
                                        </fieldset>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <label  class="text-body">Nama Produk Berlangganan</label>
                                        <fieldset class="form-group mb-3">
                                            <input type="text" class="form-control" id="NamaSubscription" name="NamaSubscription" placeholder="Masukan Nama Produk Berlangganan" value="{{ count($subscriptionheader) > 0 ? $subscriptionheader[0]['NamaSubscription'] : '' }}">
                                        </fieldset>
                                    </div>
                                    <div class="col-md-3">
                                        
                                        <label  class="text-body">Jenis Usaha</label>
                                        <fieldset class="form-group mb-3">
                                            <select required id="JenisUsaha" name="JenisUsaha" class="js-example-basic-single form-control text-dark border-0 p-0 h-20px font-size-h5">
                                                <option value=""  {{ count($subscriptionheader) > 0 ? $subscriptionheader[0]['JenisUsaha'] == "" ? 'selected' : '' : '' }}>Pilih Jenis Usaha</option>
                                                <option value="Retail" {{ count($subscriptionheader) > 0 ? $subscriptionheader[0]['JenisUsaha'] == "Retail" ? 'selected' : '' : '' }} >Retail</option>
                                                <option value="FnB" {{ count($subscriptionheader) > 0 ? $subscriptionheader[0]['JenisUsaha'] == "FnB" ? 'selected' : '' : '' }}>Food and Beverage</option>
                                                <option value="Hiburan" {{ count($subscriptionheader) > 0 ? $subscriptionheader[0]['JenisUsaha'] == "Hiburan" ? 'selected' : '' : '' }}>Hiburan</option>
                                            </select>
                                        </fieldset>
                                    </div>
                                    <div class="col-md-3">
                                        <label  class="text-body">Tanggal Berlaku</label>
                                        <fieldset class="form-group mb-3">
                                            <input type="date" class="form-control" id="Tanggal" name="Tanggal" placeholder="Masukan Kode Produk Berlangganan" value="{{ count($subscriptionheader) > 0 ? $subscriptionheader[0]['Tanggal'] : '' }}">
                                        </fieldset>
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <label  class="text-body">Deskripsi Produk</label>
                                        <fieldset class="form-group mb-3">
                                            <textarea id="DeskripsiSubscription" name="DeskripsiSubscription" class="bg-transparent text-dark">
                                            {{ count($subscriptionheader) > 0 ? $subscriptionheader[0]['DeskripsiSubscription'] : '' }}
                                            </textarea>
                                        </fieldset>
                                    </div>

                                    <div class="col-md-6">
                                        <label  class="text-body">Harga</label>
                                        <fieldset class="form-group mb-3">
                                            <input type="number" class="form-control" id="Harga" name="Harga" placeholder="Masukan Harga" value="{{ count($subscriptionheader) > 0 ? $subscriptionheader[0]['Harga'] : '' }}">
                                        </fieldset>
                                    </div>

                                    <div class="col-md-6">
                                        <label  class="text-body">Lama Berlangganan (Bulan)</label>
                                        <fieldset class="form-group mb-3">
                                            <input type="number" class="form-control" id="LamaSubsription" name="LamaSubsription" placeholder="Masukan Lama Berlangganan" value="{{ count($subscriptionheader) > 0 ? $subscriptionheader[0]['LamaSubsription'] : '' }}">
                                        </fieldset>
                                    </div>

                                    <div class="col-md-12">
                                        <fieldset class="form-group mb-3">
                                            <input type="checkbox" class="checkbox-input" id="AllowAccounting" name="AllowAccounting" placeholder="Masukan Harga" {{ count($subscriptionheader) > 0 ? $subscriptionheader[0]['AllowAccounting'] == 1 ? 'checked' : '' : '' }}>
                                            <label  class="text-body" for="AllowAccounting">Integrasi Akutansi</label>
                                        </fieldset>

                                        <fieldset class="form-group mb-3">
                                            <input type="checkbox" class="checkbox-input" id="AllowPesananMeja" name="AllowPesananMeja" placeholder="Masukan Harga" {{ count($subscriptionheader) > 0 ? $subscriptionheader[0]['AllowPesananMeja'] == 1 ? 'checked' : '' : '' }}>
                                            <label  class="text-body" for="AllowPesananMeja">Integrasi Pesanan Di Meja (Khusus FnB)</label>
                                        </fieldset>
                                        <fieldset class="form-group mb-3">
                                            <input type="checkbox" class="checkbox-input" id="AllowPaymentGateway" name="AllowPaymentGateway" placeholder="Masukan Harga" {{ count($subscriptionheader) > 0 ? $subscriptionheader[0]['AllowPaymentGateway'] == 1 ? 'checked' : '' : '' }}>
                                            <label  class="text-body" for="AllowPaymentGateway">Integrasi QRIS</label>
                                        </fieldset>
                                        <fieldset class="form-group mb-3">
                                            <input type="checkbox" class="checkbox-input" id="AllowKatalogOnline" name="AllowKatalogOnline" placeholder="Masukan Harga" {{ count($subscriptionheader) > 0 ? $subscriptionheader[0]['AllowKatalogOnline'] == 1 ? 'checked' : '' : '' }}>
                                            <label  class="text-body" for="AllowKatalogOnline">Integrasi Katalog Online</label>
                                        </fieldset>
                                    </div>

                                    <hr>

                                    <center><h2>Akses Menu</h2></center>

                                    <div >
                                        <div class="dd" id="nestable">
                                            <ol class="dd-list">
                                                <?php 
                                                    $noUrut = 0;
                                                ?>
                                                @foreach ($permissionrole as $lv1)
                                                    @if ($lv1['ParentType'] == 1)
                                                        <li class="dd-item" data-id="{{ $noUrut }}">
                                                            <div class="dd-handle">{{$lv1['PermissionName']}}</div>
                                                            <div class="inner-content">
                                                                <div class="custom-control switch custom-switch-info custom-control-inline form-check form-switch me-0">
                                                                    @if ($lv1['Selected'] != "")
                                                                        <input type="checkbox" class=" form-check-input" id="chk{{str_replace(' ','',$lv1['MenuID'])}}" checked="" value="{{ $lv1['MenuID']}}">
                                                                    @else
                                                                        <input type="checkbox" class=" form-check-input" id="chk{{str_replace(' ','',$lv1['MenuID'])}}" value="{{ $lv1['MenuID']}}">
                                                                    @endif
                                                                  <label class=" form-check-label me-1" for="chk{{str_replace(' ','',$lv1['MenuID'])}}">
                                                                  </label>
                                                                </div>
                                                            </div>
    
                                                            @if (count($lv1['submenu']) > 0)
                                                                @foreach ($lv1['submenu'] as $lv2)
                                                                    @if ($lv2['ParentType'] == 1)
                                                                        <ol class="dd-list">
                                                                            <li class="dd-item" data-id="{{ $noUrut }}">
                                                                                <div class="dd-handle">{{$lv2['PermissionName']}}</div>
                                                                                <div class="inner-content">
                                                                                    <div class="custom-control switch custom-switch-info custom-control-inline form-check form-switch me-0">
                                                                                        @if ($lv2['Selected'] != "")
                                                                                            <input type="checkbox" class=" form-check-input" id="chk{{str_replace(' ','',$lv2['MenuID'])}}" checked="" value="{{ $lv2['MenuID']}}">
                                                                                        @else
                                                                                            <input type="checkbox" class=" form-check-input" id="chk{{str_replace(' ','',$lv2['MenuID'])}}" value="{{ $lv2['MenuID']}}">
                                                                                        @endif
                                                                                      <label class=" form-check-label me-1" for="chk{{str_replace(' ','',$lv2['MenuID'])}}">
                                                                                      </label>
                                                                                    </div>
                                                                                </div>
    
                                                                                @if (count($lv2['submenu']) > 0)
                                                                                    @foreach ($lv2['submenu'] as $lv3)
                                                                                        <ol class="dd-list">
                                                                                            <li class="dd-item" data-id="{{ $noUrut }}">
                                                                                                <div class="dd-handle">{{$lv3['PermissionName']}}</div>
                                                                                                <div class="inner-content">
                                                                                                    <div class="custom-control switch custom-switch-info custom-control-inline form-check form-switch me-0">
                                                                                                    @if ($lv3['Selected'] != "")
                                                                                                        <input type="checkbox" class=" form-check-input" id="chk{{str_replace(' ','',$lv3['MenuID'])}}" checked="" value="{{ $lv3['MenuID']}}">
                                                                                                    @else
                                                                                                        <input type="checkbox" class=" form-check-input" id="chk{{str_replace(' ','',$lv3['MenuID'])}}" value="{{ $lv3['MenuID']}}">
                                                                                                    @endif
                                                                                                      <label class=" form-check-label me-1" for="chk{{str_replace(' ','',$lv3['MenuID'])}}">
                                                                                                      </label>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </li>
                                                                                        </ol>
                                                                                    @endforeach
                                                                                @endif
                                                                            </li>
                                                                        </ol>
    
                                                                    @else
                                                                        <ol class="dd-list">
                                                                            <li class="dd-item" data-id="{{ $noUrut }}">
                                                                                <div class="dd-handle">{{$lv2['PermissionName']}}</div>
                                                                                <div class="inner-content">
                                                                                    <div class="custom-control switch custom-switch-info custom-control-inline form-check form-switch me-0">
                                                                                        @if ($lv2['Selected'] != "")
                                                                                            <input type="checkbox" class=" form-check-input" id="chk{{str_replace(' ','',$lv2['MenuID'])}}" checked="" value="{{ $lv2['MenuID']}}">
                                                                                        @else
                                                                                            <input type="checkbox" class=" form-check-input" id="chk{{str_replace(' ','',$lv2['MenuID'])}}" value="{{ $lv2['MenuID']}}">
                                                                                        @endif
                                                                                      <label class=" form-check-label me-1" for="chk{{str_replace(' ','',$lv2['MenuID'])}}">
                                                                                      </label>
                                                                                    </div>
                                                                                </div>
                                                                            </li>
                                                                        </ol>
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        </li>
                                                    @endif
    
                                                    <?php 
                                                        $noUrut +=1;
                                                    ?>
                                                @endforeach
                                            </ol>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button id="btSave" name="btSave" type="button" class="btn btn-success text-white font-weight-bold me-1 mb-1">Simpan</button>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/jquery.nestable.js')}}"></script>
<script type="text/javascript">
	$(function () {
        let DeskripsiSubscriptionInstance;
		$(document).ready(function () {
            ClassicEditor.create(document.querySelector('#DeskripsiSubscription')).then( editor => {DeskripsiSubscriptionInstance = editor})
			.catch( error => {
			    console.error( error );
			});
            jQuery('#nestable').nestable({
                collapsedClass:'dd-collapsed',
            }).nestable('collapseAll');
		});

        // Save
        jQuery('#btSave').click(function () {
            jQuery('#btSave').text('Tunggu Sebentar.....');
            jQuery('#btSave').attr('disabled',true);

            var oDetail = [];
            var dataPermission = <?php echo json_encode($permission); ?>

            for (var i = 0; i < dataPermission.length; i++) {
				// Things[i]
				var checkbox = jQuery("#chk"+dataPermission[i]['id']+":checked").val()

				if (typeof checkbox === 'undefined') {
					console.log('Blank')
				}
				else{
					var item = {
						'PermissionID' : checkbox
					}
					oDetail.push(item)
				}

				// console.log(dataPermission[i]['id'] + ' '+ checkbox);
			}

            var oData = {
				'NoTransaksi' : jQuery('#NoTransaksi').val(),
                'Tanggal' : jQuery('#Tanggal').val(),
                'NamaSubscription' : jQuery('#NamaSubscription').val(),
                'DeskripsiSubscription' : DeskripsiSubscriptionInstance.getData(),
                'Harga' : jQuery('#Harga').val(),
                'LamaSubsription' : jQuery('#LamaSubsription').val(),
                'AllowAccounting' : jQuery('#AllowAccounting').prop('checked') ? 1 : 0,
                'AllowPesananMeja' : jQuery('#AllowPesananMeja').prop('checked') ? 1 : 0,
                'AllowPaymentGateway' : jQuery('#AllowPaymentGateway').prop('checked') ? 1 : 0,
                'AllowKatalogOnline' : jQuery('#AllowKatalogOnline').prop('checked') ? 1 : 0,
                'JenisUsaha' : jQuery('#JenisUsaha').val(),
				'Detail' : oDetail
			};

            // console.log(oData);
            var formtype = jQuery('#formtype').val();

            if (formtype == 'add') {
				$.ajax({
					url: "{{route('subs-storeJson')}}",
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
		                        window.location.href = '{{url("subs")}}';
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
				$.ajax({
					url: "{{route('subs-editJson')}}",
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
		                        window.location.href = '{{url("subs")}}';
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
        });
	});
</script>
@endpush