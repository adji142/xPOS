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
				<li class="breadcrumb-item active" aria-current="page">Term and Condition</li>
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
                                        Edit App Setting {{ $envArray['APP_NAME'] }}
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
                                <form action="{{route('appsetting-update')}}" method="post">
                                @csrf
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <label  class="text-body">Apps Name</label>
                                            <fieldset class="form-group mb-3">
                                                <input type="text" class="form-control" id="APP_NAME" name="APP_NAME" placeholder="Masukan Nama Aplikasi" value="{{ $envArray['APP_NAME'] }}">
                                            </fieldset>
                                        </div>

                                        <div class="col-md-3">
                                            <label  class="text-body">Tipe Server</label>
                                            <fieldset class="form-group mb-3">
                                                <input type="text" class="form-control" id="MAIL_MAILER" name="MAIL_MAILER" placeholder="Masukan Tipe Server" value="{{ $envArray['MAIL_MAILER'] }}">
                                            </fieldset>
                                        </div>

                                        <div class="col-md-3">
                                            <label  class="text-body">Alamat Email Server</label>
                                            <fieldset class="form-group mb-3">
                                                <input type="text" class="form-control" id="MAIL_HOST" name="MAIL_HOST" placeholder="Masukan Alamat Email Server" value="{{ $envArray['MAIL_HOST'] }}">
                                            </fieldset>
                                        </div>

                                        <div class="col-md-3">
                                            <label  class="text-body">Port Server</label>
                                            <fieldset class="form-group mb-3">
                                                <input type="number" class="form-control" id="MAIL_PORT" name="MAIL_PORT" placeholder="Masukan Port" value="{{ $envArray['MAIL_PORT'] }}">
                                            </fieldset>
                                        </div>

                                        <div class="col-md-3">
                                            <label  class="text-body">Encryption</label>
                                            <fieldset class="form-group mb-3">
                                                <input type="text" class="form-control" id="MAIL_ENCRYPTION" name="MAIL_ENCRYPTION" placeholder="Masukan Encryption" value="{{ $envArray['MAIL_ENCRYPTION'] }}">
                                            </fieldset>
                                        </div>

                                        <div class="col-md-4">
                                            <label  class="text-body">Username Email</label>
                                            <fieldset class="form-group mb-3">
                                                <input type="mail" class="form-control" id="MAIL_USERNAME" name="MAIL_USERNAME" placeholder="Masukan Username Email" value="{{ $envArray['MAIL_USERNAME'] }}">
                                            </fieldset>
                                        </div>

                                        <div class="col-md-4">
                                            <label  class="text-body">Password Email</label>
                                            <fieldset class="form-group mb-3">
                                                <input type="password" class="form-control" id="MAIL_PASSWORD" name="MAIL_PASSWORD" placeholder="Masukan Password Email" value="{{ $envArray['MAIL_PASSWORD'] }}">
                                            </fieldset>
                                        </div>

                                        <div class="col-md-4">
                                            <label  class="text-body">Alamat Pengirim Email</label>
                                            <fieldset class="form-group mb-3">
                                                <input type="text" class="form-control" id="MAIL_FROM_ADDRESS" name="MAIL_FROM_ADDRESS" placeholder="Masukan Alamat Pengirim Email" value="{{ $envArray['MAIL_FROM_ADDRESS'] }}">
                                            </fieldset>
                                        </div>

                                        <div class="col-md-6">
                                            <label  class="text-body">MidTrans Server Key</label>
                                            <fieldset class="form-group mb-3">
                                                <input type="text" class="form-control" id="MIDTRANS_SERVER_KEY" name="MIDTRANS_SERVER_KEY" placeholder="Masukan MidTrans Server Key" value="{{ $envArray['MIDTRANS_SERVER_KEY'] }}">
                                            </fieldset>
                                        </div>

                                        <div class="col-md-6">
                                            <label  class="text-body">MidTrans Client Key</label>
                                            <fieldset class="form-group mb-3">
                                                <input type="text" class="form-control" id="MIDTRANS_CLIENT_KEY" name="MIDTRANS_CLIENT_KEY" placeholder="Masukan MidTrans Client Key" value="{{ $envArray['MIDTRANS_CLIENT_KEY'] }}">
                                            </fieldset>
                                        </div>

                                        <div class="col-md-6">
                                            <label  class="text-body">MidTrans Mercant ID</label>
                                            <fieldset class="form-group mb-3">
                                                <input type="text" class="form-control" id="MIDTRANS_MERCHAT_ID" name="MIDTRANS_MERCHAT_ID" placeholder="Masukan MidTrans Mercant ID" value="{{ $envArray['MIDTRANS_MERCHAT_ID'] }}">
                                            </fieldset>
                                        </div>

                                        <div class="col-md-6">
                                            <label  class="text-body">IS Production</label>
                                            <fieldset class="form-group mb-3">
                                                <select required id="MIDTRANS_IS_PRODUCTION" name="MIDTRANS_IS_PRODUCTION" class="js-example-basic-single form-control text-dark border-0 p-0 h-20px font-size-h5">
                                                    <option value="true"  {{ $envArray['MIDTRANS_MERCHAT_ID'] ? 'selected':'' }}>True</option>
                                                    <option value="false" {{ $envArray['MIDTRANS_MERCHAT_ID'] ? 'selected':'' }}>False</option>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/jquery.nestable.js')}}"></script>
<script type="text/javascript">
	
</script>
@endpush