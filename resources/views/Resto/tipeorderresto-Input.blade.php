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
					<a href="{{route('tipeorderresto')}}">Tipe Order Resto</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Input Tipe Order Resto</li>
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
										@if (count($tipeorderresto) > 0)
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
								@if (count($tipeorderresto) > 0)
                            		<form action="{{route('tipeorderresto-edit')}}" method="post">
                            	@else
                                	<form action="{{route('tipeorderresto-store')}}" method="post">
                            	@endif
                            		@csrf
	                            	<div class="form-group row">
	                            		<div class="col-md-3">
	                            			<!-- <label  class="text-body">Kode Tipe Order Resto</label> -->
	                            			<fieldset class="form-group mb-3">
	                            				<input type="hidden" class="form-control" id="id" name="id" placeholder="Masukan Kode Tipe Order Resto" value="{{ count($tipeorderresto) > 0 ? $tipeorderresto[0]['id'] : '' }}" required="" {{ count($tipeorderresto) > 0 ? 'readonly' : '' }} >
	                            			</fieldset>
	                            			
	                            		</div>
	                            		<div class="col-md-12"> 
	                            			<fieldset class="form-group mb-3">
	                            				<textarea id = "image_base64" name = "image_base64" style="display: none;"> {{ count($tipeorderresto) > 0 ? $tipeorderresto[0]['Icon'] : '' }} </textarea>
	                            				
	                            				<input type="file" id="Attachment" name="Attachment" accept=".jpg, .png" class="btn btn-warning" style="display: none;"/>
	                            				<div class="xContainer">
									                <div id="image_result" class="image_result">
									                	@if (count($tipeorderresto) > 0)
				                                    		<img src=" {{$tipeorderresto[0]['Icon']}} ">
				                                    	@else
				                                    		<img src="https://www.generationsforpeace.org/wp-content/uploads/2018/03/empty.jpg">
					                                	@endif
									                </div>
									            </div>
	                            			</fieldset>
	                            			
	                            		</div>

	                            		<div class="col-md-12">
	                            			<label  class="text-body">Nama Jenis Order</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="text" class="form-control" id="NamaJenisOrder" name="NamaJenisOrder" placeholder="Masukan Nama Jenis Order" value="{{ count($tipeorderresto) > 0 ? $tipeorderresto[0]['NamaJenisOrder'] : '' }}" required="">
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
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script type="text/javascript">
	var _URL = window.URL || window.webkitURL;
    var _URLePub = window.URL || window.webkitURL;
	jQuery(function () {
		jQuery(document).ready(function() {
			var tipeorderresto = <?php echo $tipeorderresto ?>;
			
			if (tipeorderresto.length > 0) {
				jQuery('#AkunPembayaran').val(tipeorderresto[0]["AkunPembayaran"]).trigger('change');
				jQuery('#MetodeVerifikasi').val(tipeorderresto[0]["MetodeVerifikasi"]).trigger('change');
			}
		})
	});

	jQuery('#MetodeVerifikasi').change(function () {
		// MetodeVerifikasi
		// alert('asdasd');
		if(jQuery('#MetodeVerifikasi').val() == "AUTO"){
			jQuery('#divMidtrans').css({
				"display" : "contents"
			})
		}
		else{
			jQuery('#divMidtrans').css({
				"display" : "none"
			})
		}
	});

	jQuery('#image_result').click(function(){
        $('#Attachment').click();
    });

	jQuery('#btTestKoneksi').click(function () {
		fetch('/xpos/create-transaction', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json',
				'X-CSRF-TOKEN': '{{ csrf_token() }}'
			},
			body: JSON.stringify({
				// Tambahkan data transaksi jika diperlukan
			})
		})
		.then(response => response.json())
		.then(data => {
			if (data.snap_token) {
				snap.pay(data.snap_token);
			} else {
				alert('Error: ' + data.error);
			}
		})
		.catch(error => console.error('Error:', error));
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