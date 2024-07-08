@extends('parts.header')
	
@section('content')

<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">Buat Barcode Identifikasi</li>
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
									<h3 class="card-label mb-0 font-weight-bold text-body">Barcode Identifikasi 
									</h3>
								</div>
							</div>
						
						</div>


					</div>
				</div>

                <div class="row">
                    <div class="col-12  px-4">
                        <div class="card card-custom gutter-b bg-white border-0" >
                            <div class="card-header" >
								Filter Data
							</div>
                            <div class="card-body" >
                                <div class="row">
                                    <div class="col-md-3">
                                        <label  class="text-body">Orientasi</label>
                                        <select name="Orientasi" id="Orientasi" class="js-example-basic-single js-states form-control bg-transparent" >
                                            <option value="">Pilih Orientasi</option>
                                            <option value="Potrait">Potrait</option>
                                            <option value="Lanscape">Lanscape</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label  class="text-body">Kertas</label>
                                        <select name="JenisKertas" id="JenisKertas" class="js-example-basic-single js-states form-control bg-transparent" >
                                            <option value="">Pilih Kertas</option>
                                            @foreach($kertas as $ko)
                                                <option value="{{ $ko->id }}" >
                                                    {{ $ko->NamaKertas }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label  class="text-body">Panjang Label (Cm)</label>
                                        <input type="number" class="form-control bg-transparent" placeholder="Panjang" value="0" id="PanjangLabel">
                                    </div>
                                    <div class="col-md-2">
                                        <label  class="text-body">Lebar Label (Cm)</label>
                                        <input type="number" class="form-control bg-transparent" placeholder="Lebar" value="0" id="LebarLabel">
                                    </div>
                                    <div class="col-md-2">
                                        <label  class="text-body">Gap (Cm)</label>
                                        <input type="number" class="form-control bg-transparent" placeholder="Lebar" value="0" id="Gap">
                                    </div>

                                    <div class="col-md-12">
                                        <label  class="text-body">Kelompok Item</label>
                                        <select name="JenisItem" id="JenisItem" class="js-example-basic-single js-states form-control bg-transparent" >
                                            <option value="">Pilih Kelompok Item</option>
                                            @foreach($jenisitem as $ko)
                                                <option value="{{ $ko->KodeJenis }}" >
                                                    {{ $ko->NamaJenis }}
                                                </option>
                                            @endforeach
                                            
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label  class="text-body">Barang Awal</label>
                                        <select name="KodeItemAwal" id="KodeItemAwal" class="js-example-basic-single js-states form-control bg-transparent" >
                                            <option value="">Pilih barang</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label  class="text-body">Barang Akhir</label>
                                        <select name="KodeItemAkhir" id="KodeItemAkhir" class="js-example-basic-single js-states form-control bg-transparent" >
                                            <option value="">Pilih barang</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <!-- <label  class="text-body">Status User</label> -->
                                        <br>
                                        <button id="btCetak" class="btn btn-danger text-white font-weight-bold me-1 mb-1">Cetak Barcode</button>
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

<script type="text/javascript">
    var PaperSize = [];
	jQuery(document).ready(function() {
        
	});

    jQuery('#JenisKertas').change(function(){
        $.ajax({
            url: "{{route('report-getpapersize')}}",
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
            },
            data: {'IDKertas': jQuery('#JenisKertas').val()},
            success: function(response) {
                PaperSize = response.data;
            }
        })
    });

    jQuery('#JenisItem').change(function(){
        $.ajax({
            url: "{{route('itemmaster-ViewJson')}}",
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
            },
            data: {
                'KodeJenis': jQuery('#JenisItem').val(),
                'Merk': "",
                'TipeItem': "",
                'Active': "Y",
                'Scan': "",
                'TipeItemIN': "",
            },
            success: function(response) {
                // PaperSize = response.data;

                jQuery('#KodeItemAwal').empty();
                jQuery('#KodeItemAkhir').empty();
            	var newOption = jQuery('<option>', {
		        	value: "",
		        	text: "Pilih Barang"
		        });
		        jQuery('#KodeItemAwal').append(newOption);
                jQuery('#KodeItemAkhir').append(newOption);

		        $.each(response.data,function (k,v) {
		        	var newOption = jQuery('<option>', {
			        	value: v.KodeItem,
			        	text: v.KodeItem + " - " + v.NamaItem
			        });
                    var newOption2 = jQuery('<option>', {
			        	value: v.KodeItem,
			        	text: v.KodeItem + " - " + v.NamaItem
			        });

			        jQuery('#KodeItemAwal').append(newOption);
                    jQuery('#KodeItemAkhir').append(newOption2);
		        });
            }
        })
    });

    jQuery('#btCetak').click(function () {

        var Orientasi = jQuery('#Orientasi').val();
        var JenisKertas = jQuery('#JenisKertas').val();
        var PanjangLabel = jQuery('#PanjangLabel').val();
        var LebarLabel = jQuery('#LebarLabel').val();
        var Gap = jQuery('#Gap').val();
        var KodeItemAwal = jQuery('#KodeItemAwal').val();
        var KodeItemAkhir = jQuery('#KodeItemAkhir').val();

        if(Orientasi == "" || JenisKertas == "" || PanjangLabel == "" || LebarLabel == "" || Gap == "" || KodeItemAwal == "" || KodeItemAkhir == ""){
            Swal.fire({
                icon: "error",
                title: "Opps...",
                text: "Semua Informasi Harus diisikan",
            }).then((result)=>{
                return;
            });
        }
        else{
            let url = new URL("{{ route('report-generatetemplate') }}");
            url.searchParams.append('Orientasi', jQuery('#Orientasi').val());
            url.searchParams.append('JenisKertas', jQuery('#JenisKertas').val());
            url.searchParams.append('PanjangLabel', jQuery('#PanjangLabel').val());
            url.searchParams.append('LebarLabel', jQuery('#LebarLabel').val());
            url.searchParams.append('Gap', jQuery('#Gap').val());
            url.searchParams.append('KodeItemAwal', jQuery('#KodeItemAwal').val());
            url.searchParams.append('KodeItemAkhir', jQuery('#KodeItemAkhir').val());
            url.searchParams.append('JenisItem', jQuery('#JenisItem').val());

            // console.log(url.toString()); 
            window.location.href = url.toString();
        }

        

        
    });
</script>
@endpush