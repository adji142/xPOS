@extends('parts.header')
	
@section('content')

<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">
					<a href="{{route('roles')}}">Kelompok Akses</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Input Kelompok Akses</li>
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
										@if (count($roles) > 0)
                                    		Edit Kelompok Akses
                                    		<input type="hidden" name="formtype" id="formtype" value="edit">
	                                	@else
	                                    	Tambah Kelompok Akses
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
                            		<div class="col-md-12">
                            			<label  class="text-body" style="display: none;">Kode Grup</label>
                            			<fieldset class="form-group mb-3">
                            				<input type="hidden" class="form-control" id="id" name="id" placeholder="Masukan Kode Grup" value="{{ count($roles) > 0 ? $roles[0]['id'] : '' }}" >
                            			</fieldset>
                            			
                            		</div>
                            		
                            		<div class="col-md-12">
                            			<label  class="text-body">Nama Grup</label>
                            			<fieldset class="form-group mb-3">
                            				<input type="text" class="form-control" id="RoleName" name="RoleName" placeholder="Masukan Nama Kelompok AKses" value="{{ count($roles) > 0 ? $roles[0]['RoleName'] : '' }}" required="">
                            			</fieldset>
                            			<?php 
                            				// echo json_encode($permissionrole);
                            			?>
                            		</div>

                            		<!-- <div class="col-md-12">
                            			<button type="submit" class="btn btn-success text-white font-weight-bold me-1 mb-1">Simpan</button>
                            		</div> -->
                            	</div>
							</div>
						</div>
					</div>
					<div class="col-12  px-4">
						<div class="card card-custom gutter-b bg-white border-0" >
							<div class="card-header border-0 align-items-center">
								<h3 class="card-label mb-0 font-weight-bold text-body">Hak Akses
								</h3>
							</div>
							<div class="card-body">
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
							</div>
						</div>
					</div>

					<div class="col-md-12">
	        			<button type="button" class="btn btn-success text-white font-weight-bold me-1 mb-1" id="btSave">Simpan</button>
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
	jQuery('#nestable').nestable({
		collapsedClass:'dd-collapsed',
	}).nestable('collapseAll')
	
	var dataPermission = <?php echo json_encode($permission); ?>

	jQuery(function () {
		jQuery(document).ready(function() {
			// console.log(dataPermission);
		});

		jQuery('#btSave').click(function () {
			// alert('test')
			jQuery('#btSave').text('Tunggu Sebentar');
		    jQuery('#btSave').attr('disabled',true);
			var oDetail = [];
			for (var i = 0; i < dataPermission.length; i++) {
				// Things[i]
				var checkbox = jQuery("#chk"+dataPermission[i]['id']+":checked").val()

				if (typeof checkbox === 'undefined') {
					console.log('Blank')
				}
				else{
					var item = {
						'id' : checkbox
					}
					oDetail.push(item)
				}

				// console.log(dataPermission[i]['id'] + ' '+ checkbox);
			}
			var oData = {
				'id' : jQuery('#id').val(),
				'RoleName' : jQuery('#RoleName').val(),
				'permissionrole' : oDetail
			};
			// console.log(oData)

			var formtype = $('#formtype').val();
			console.log(formtype);
			if (formtype == 'add') {
				$.ajax({
					url: "{{route('roles-store')}}",
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
		                        window.location.href = '{{url("roles")}}';
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
					url: "{{route('roles-edit')}}",
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
		                        window.location.href = '{{url("roles")}}';
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
		})
	});
</script>
@endpush