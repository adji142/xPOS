@extends('parts.header')
	
@section('content')

<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">
					<a href="{{route('user')}}">Users</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Input Users</li>
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
										@if (count($users) > 0)
                                    		Edit Users
	                                	@else
	                                    	Tambah Users
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
								@if (count($users) > 0)
                            		<form action="{{route('user-edit')}}" method="post">
                            	@else
                                	<form action="{{route('user-store')}}" method="post">
                            	@endif
                            		@csrf
	                            	<div class="form-group row">
	                            		<div class="col-md-12">
	                            			<label  class="text-body">Kode Users</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="hidden" class="form-control" id="id" name="id" placeholder="<AUTO>" value="{{ count($users) > 0 ? $users[0]['id'] : '' }}" readonly="" >
	                            			</fieldset>
	                            			
	                            		</div>
	                            		
	                            		<div class="col-md-12">
	                            			<label  class="text-body">Nama Users</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="text" class="form-control" id="name" name="name" placeholder="Masukan Nama Users" value="{{ count($users) > 0 ? $users[0]['name'] : '' }}" required="">
	                            			</fieldset>
	                            			
	                            		</div>

	                            		<div class="col-md-12">
	                            			<label  class="text-body">Email</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="mail" class="form-control" id="email" name="email" placeholder="Masukan Email Users" value="{{ count($users) > 0 ? $users[0]['email'] : '' }}" required="">
	                            			</fieldset>
	                            			
	                            		</div>

	                            		<div class="col-md-12">
	                            			<label  class="text-body">Password</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="password" class="form-control" id="password" name="password" placeholder="Masukan Password" required="" value="******************" >
	                            			</fieldset>
	                            			
	                            		</div>

	                            		<div class="col-md-6">
	                            			<label  class="text-body">Kelompok Akses</label>
	                            			<fieldset class="form-group mb-3">
	                            				<select name="KelompokAkses" id="KelompokAkses" class="js-example-basic-single js-states form-control bg-transparent" name="state" required="">
													<option value="">Pilih Kelompok Akses</option>
													@foreach($rolesdata as $ko)
														<option 
                                                            value="{{ $ko->id }}"
                                                            {{ count($users) > 0 ? $users[0]['KelompokAkses'] == $ko->id ? "selected" : '' :""}}
                                                        >
                                                            {{ $ko->RoleName }}
                                                        </option>
													@endforeach
													
												</select>
	                            			</fieldset>
	                            			
	                            		</div>

	                            		<div class="col-md-6">
	                            			<label  class="text-body">Status</label>
	                            			<fieldset class="form-group mb-3">
	                            				<select name="Active" id="Active" class="js-example-basic-single js-states form-control bg-transparent" name="state" >
													<option value="Y" {{ count($users) > 0 ? $users[0]['Active'] == 'Y' ? "selected" : '' :""}}>Active</option>
													<option value="N" {{ count($users) > 0 ? $users[0]['Active'] == 'N' ? "selected" : '' :""}}>Tidak Active</option>
												</select>
	                            			</fieldset>
	                            			
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

@endsection

@push('scripts')
<script type="text/javascript">
	// jQuery(document).ready(function() {
	// 	jQuery('.js-example-basic-multiple').select2();
	// });
	jQuery(function () {
		jQuery(document).ready(function() {
			jQuery('.js-example-basic-single').select2();
		});
	})
</script>
@endpush