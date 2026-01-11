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
    width: 150px;
    height: 200px;
  }
  .image_result img {
    max-width: 100%; /* Fit the image to the container width */
    height: 100%; /* Maintain the aspect ratio */
  }
</style>

<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">
					<a href="{{route('titiklampu')}}">Titik Lampu</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Input Titik Lampu</li>
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
										@if (count($titiklampu) > 0)
                                    		Edit Titik Lampu
	                                	@else
	                                    	Tambah Titik Lampu
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
								@if (count($titiklampu) > 0)
                            		<form action="{{route('titiklampu-editJson')}}" method="post">
                            	@else
                                	<form action="{{route('titiklampu-storeJson')}}" method="post">
                            	@endif
                            		@csrf
	                            	<div class="form-group row">
	                            		<div class="col-md-12">
	                            			<label  class="text-body">Nama Titik Lampu</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="text" class="form-control" id="NamaTitikLampu" name="NamaTitikLampu" placeholder="Masukan Nama Titik Lampu" value="{{ count($titiklampu) > 0 ? $titiklampu[0]['NamaTitikLampu'] : '' }}" required="">
                                                <input type="hidden" class="form-control" id="id" name="id" value="{{ count($titiklampu) > 0 ? $titiklampu[0]['id'] : '' }}">
	                            			</fieldset>
	                            			
	                            		</div>

                                        <div class="col-md-4">
	                            			<label  class="text-body">Controller</label>
	                            			<fieldset class="form-group mb-3">
                                                <select name="ControllerID" id="ControllerID" class="js-example-basic-single js-states form-control bg-transparent">
                                                    <option value="">Pilih Kelompok Meja</option>
                                                    @foreach($controller as $ko)
                                                        <option value="{{ $ko->id }}" {{ $ko->id == (count($titiklampu) > 0 ? $titiklampu[0]['ControllerID'] : '') ? 'selected' : '' }}>
                                                            {{ $ko->NamaController }}
                                                        </option>
                                                    @endforeach
                                                </select>
	                            			</fieldset>
	                            			
	                            		</div>

                                        <div class="col-md-4">
	                            			<label  class="text-body">Digital Input Port</label>
	                            			<fieldset class="form-group mb-3">
                                                <select name="DigitalInput" id="DigitalInput" class="js-example-basic-single js-states form-control bg-transparent">
                                                    <option value="-1">Digital Input Port</option>
                                                    @for ($i = 1; $i < 11; $i++)
                                                    <option value="{{ $i }}" {{ $i == (count($titiklampu) > 0 ? $titiklampu[0]['DigitalInput'] : '') ? 'selected' : '' }}>{{ $i }}</option>
                                                    @endfor
                                                </select>
	                            			</fieldset>
	                            			
	                            		</div>

										<div class="col-md-4">
	                            			<label  class="text-body">Kelompok Lampu</label>
	                            			<fieldset class="form-group mb-3">
                                                <select name="KelompokLampu" id="KelompokLampu" class="js-example-basic-single js-states form-control bg-transparent">
                                                    <option value="">Pilih Kelompok Lampu</option>
                                                    @foreach($kelompoklampu as $ko)
                                                        <option value="{{ $ko->KodeKelompok }}" {{ $ko->KodeKelompok == (count($titiklampu) > 0 ? $titiklampu[0]['KelompokLampu'] : '') ? 'selected' : '' }}>
                                                            {{ $ko->NamaKelompok }}
                                                        </option>
                                                    @endforeach
                                                </select>
	                            			</fieldset>
	                            			
	                            		</div>

										<div class="col-md-12">
											<label  class="text-body">Deskripsi</label>
											<fieldset class="form-group mb-12">
												<div id="Deskripsi">
													{!! count($titiklampu) > 0 ? $titiklampu[0]['Deskripsi'] : '' !!}
												</div>
											</fieldset>
										</div>

										<div class="col-md-12"> 
	                            			<label  class="text-body">Gambar</label>
	                            			<fieldset class="form-group mb-3">
	                            				<textarea id = "image_base64" name = "image_base64" style="display: none;"> {{ count($titiklampu) > 0 ? $titiklampu[0]['Gambar'] : '' }} </textarea>
	                            				
	                            				<input type="file" id="Attachment" name="Attachment" accept=".jpg, .png" class="btn btn-warning" style="display: none;"/>
	                            				<div class="xContainer">
									                <div id="image_result" class="image_result">
									                	@if (count($titiklampu) > 0 && $titiklampu[0]['Gambar'] != '')
				                                    		<img src=" {{$titiklampu[0]['Gambar']}} ">
				                                    	@else
				                                    		<img src="https://www.generationsforpeace.org/wp-content/uploads/2018/03/empty.jpg">
					                                	@endif
									                </div>
									            </div>
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
	$(function () {
		const quill_Deskripsi = new Quill('#Deskripsi', {
			theme: 'snow'
		});

		var _URL = window.URL || window.webkitURL;
		jQuery('#image_result').click(function(){
            $('#Attachment').click();
        });

        $("#Attachment").change(function(){
            var file = $(this)[0].files[0];
            var img = new Image();
            img.src = _URL.createObjectURL(file);
            img.onload = function () {
            }
            readURL(this);
            encodeImagetoBase64(this);
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
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
                $('#image_base64').val(reader.result);
            }
            reader.readAsDataURL(file);
        }

		$(document).ready(function () {
			$('#LevelHarga').select2();
		});

		jQuery('form').submit(function(e) {

			e.preventDefault(); // Prevent default form submission

			var form = $(this);
			var formData = form.serializeArray();
			var actionUrl = form.attr('action');
			var submitButton = form.find("button[type='submit']");
			submitButton.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Processing...');

			var Deskripsi = quill_Deskripsi.root.innerHTML;
			

			formData.push({ name: "Deskripsi", value: Deskripsi });

			$.ajax({
				url: actionUrl,
				type: 'POST',
				data: formData,
				dataType: 'json',
				success: function(response) {
					if(response.success == true){
						swal.fire({
							title: 'Success',
							text: response.message,
							icon: 'success',
							confirmButtonText: 'OK'
						}).then(function() {
							window.location.href = "{{ route('titiklampu') }}";
						});
					} else {
						swal.fire({
							title: 'Error',
							text: response.message,
							icon: 'error',
							confirmButtonText: 'OK'
						}).then(function() {
							submitButton.prop('disabled', false).html('Save');
						});
					}
				},
			});
		});
	})
</script>
@endpush