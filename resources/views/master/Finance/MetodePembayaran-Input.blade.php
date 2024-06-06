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
					<a href="{{route('metodepembayaran')}}">MetodePembayaran</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Input MetodePembayaran</li>
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
										@if (count($metodepembayaran) > 0)
                                    		Edit Metode Pembayaran
	                                	@else
	                                    	Tambah Metode Pembayaran
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
								@if (count($metodepembayaran) > 0)
                            		<form action="{{route('metodepembayaran-edit')}}" method="post">
                            	@else
                                	<form action="{{route('metodepembayaran-store')}}" method="post">
                            	@endif
                            		@csrf
	                            	<div class="form-group row">
	                            		<div class="col-md-3">
	                            			<!-- <label  class="text-body">Kode MetodePembayaran</label> -->
	                            			<fieldset class="form-group mb-3">
	                            				<input type="hidden" class="form-control" id="id" name="id" placeholder="Masukan Kode MetodePembayaran" value="{{ count($metodepembayaran) > 0 ? $metodepembayaran[0]['id'] : '' }}" required="" {{ count($metodepembayaran) > 0 ? 'readonly' : '' }} >
	                            			</fieldset>
	                            			
	                            		</div>
	                            		<div class="col-md-12"> 
	                            			<fieldset class="form-group mb-3">
	                            				<textarea id = "image_base64" name = "image_base64" style="display: none;"> {{ count($metodepembayaran) > 0 ? $metodepembayaran[0]['Image'] : '' }} </textarea>
	                            				
	                            				<input type="file" id="Attachment" name="Attachment" accept=".jpg, .png" class="btn btn-warning" style="display: none;"/>
	                            				<div class="xContainer">
									                <div id="image_result" class="image_result">
									                	@if (count($metodepembayaran) > 0)
				                                    		<img src=" {{$metodepembayaran[0]['Image']}} ">
				                                    	@else
				                                    		<img src="https://www.generationsforpeace.org/wp-content/uploads/2018/03/empty.jpg">
					                                	@endif
									                </div>
									            </div>
	                            			</fieldset>
	                            			
	                            		</div>

	                            		<div class="col-md-12">
	                            			<label  class="text-body">Nama Metode Pembayaran</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="text" class="form-control" id="NamaMetodePembayaran" name="NamaMetodePembayaran" placeholder="Masukan Nama MetodePembayaran" value="{{ count($metodepembayaran) > 0 ? $metodepembayaran[0]['NamaMetodePembayaran'] : '' }}" required="">
	                            			</fieldset>
	                            			
	                            		</div>

	                            		<div class="col-md-12">
	                            			<label  class="text-body">Akun Pembayaran</label>
	                            			<fieldset class="form-group mb-3">
	                            				<select name="AkunPembayaran" id="AkunPembayaran" class="js-example-basic-single js-states form-control bg-transparent">
													<option value="">Pilih Akun</option>
													@foreach($rekeningakutansi as $ko)
														<option value="{{ $ko->KodeRekening }}" {{ count($metodepembayaran) > 0 ? $metodepembayaran[0]['AkunPembayaran'] == $ko->KodeRekening ? 'selected' :'':'' }} >
				                                            {{ $ko->NamaRekening }}
				                                        </option>
													@endforeach
												</select>
	                            			</fieldset>
	                            		</div>

	                            		<div class="col-md-6">
	                            			<label  class="text-body">Metode Verifikasi</label>
	                            			<fieldset class="form-group mb-3">
	                            				<select name="MetodeVerifikasi" id="MetodeVerifikasi" class="js-example-basic-single js-states form-control bg-transparent" name="state" >
													<option value="MANUAL" {{ count($metodepembayaran) > 0 ? $metodepembayaran[0]['MetodeVerifikasi'] == 'MANUAL' ? "selected" : '' :""}}>MANUAL</option>
													<option value="AUTO" {{ count($metodepembayaran) > 0 ? $metodepembayaran[0]['MetodeVerifikasi'] == 'AUTO' ? "selected" : '' :""}}>AUTO</option>
												</select>
	                            			</fieldset>
	                            			
	                            		</div>
	                            		<div class="col-md-6">
	                            			<label  class="text-body">Tipe Pembayaran</label>
	                            			<fieldset class="form-group mb-3">
	                            				<select name="TipePembayaran" id="TipePembayaran" class="js-example-basic-single js-states form-control bg-transparent" name="state" >
													<option value="TUNAI" {{ count($metodepembayaran) > 0 ? $metodepembayaran[0]['TipePembayaran'] == 'TUNAI' ? "selected" : '' :""}}>TUNAI</option>
													<option value="NON TUNAI" {{ count($metodepembayaran) > 0 ? $metodepembayaran[0]['TipePembayaran'] == 'NON TUNAI' ? "selected" : '' :""}}>NON TUNAI</option>
												</select>
	                            			</fieldset>
	                            			
	                            		</div>

	                            		<div class="col-md-6">
	                            			<label  class="text-body">Status</label>
	                            			<fieldset class="form-group mb-3">
	                            				<select name="Active" id="Active" class="js-example-basic-single js-states form-control bg-transparent" name="state" >
													<option value="Y" {{ count($metodepembayaran) > 0 ? $metodepembayaran[0]['Active'] == 'Y' ? "selected" : '' :""}}>Active</option>
													<option value="N" {{ count($metodepembayaran) > 0 ? $metodepembayaran[0]['Active'] == 'N' ? "selected" : '' :""}}>Inactive</option>
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
	var _URL = window.URL || window.webkitURL;
    var _URLePub = window.URL || window.webkitURL;
	jQuery(function () {
		jQuery(document).ready(function() {
			var metodepembayaran = <?php echo $metodepembayaran ?>;
			
			if (metodepembayaran.length > 0) {
				jQuery('#AkunPembayaran').val(metodepembayaran[0]["AkunPembayaran"]).trigger('change')
			}
		})
	});

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
</script>
@endpush