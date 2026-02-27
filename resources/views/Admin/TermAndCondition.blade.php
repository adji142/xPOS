@extends('parts.header')
	
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

                                        Edit Term and Condition
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
                                <form action="{{route('tnc-edit')}}" method="post">
                                @csrf
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <label  class="text-body">Term and Condition</label>
                                            <input type="hidden" name="id" id="id" value="1">
                                            <fieldset class="form-group mb-3">
                                                <textarea id="DeskripsiSubscription" name="DeskripsiSubscription" class="bg-transparent text-dark">
                                                {{ $tnc ? $tnc->termcondition : '' }}
                                                </textarea>
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

			$('#LevelHarga').select2();
		});

	});
</script>
@endpush