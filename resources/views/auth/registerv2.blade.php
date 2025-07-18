<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pendaftaran</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{asset('api/select2/select2.min.css')}}" rel="stylesheet" />
    <style>
        body, html {
            height: 100%;
            margin: 0;
        }

        body {
            background: url({{ asset('images/misc/bg-login3.jpg')}});
            background-size: cover;
        }

        .scroll-wrapper {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem;
        }

        .card-register {
            background-color: rgba(255, 255, 255);
            padding: 2rem;
            border-radius: 1rem;
            width: 100%;
            max-width: 850px;
            max-height: 70vh;
            overflow-y: auto;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }

        h2 {
            font-weight: 700;
            font-size: 1.9rem;
            margin-bottom: 1.5rem;
        }
        .form-container {
            background-color: rgba(255, 255, 255, 1); /* putih semi transparan */
            padding: 3rem;
            border-radius: 1.5rem;
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 700px;
        }
        label {
            font-weight: 600;
            font-size: 1.1rem;
        }
        input.form-control {
            font-size: 1.05rem;
            padding: 0.75rem;
        }
        h4 {
            font-size: 2rem;
            font-weight: bold;
        }

        .product-card-container {
            display: flex;
            overflow-x: auto;
            padding: 20px;
            gap: 15px;
            scroll-behavior: smooth; /* Smooth scrolling */
        }

        .product-card-container::-webkit-scrollbar {
            height: 12px; /* Height of the horizontal scrollbar */
        }

        .product-card-container::-webkit-scrollbar-track {
            background: #f1f1f1; /* Background of the scrollbar track */
            border-radius: 10px; /* Rounded track */
        }

        .product-card-container::-webkit-scrollbar-thumb {
            background: #888; /* Color of the scrollbar thumb */
            border-radius: 10px; /* Rounded thumb */
        }

        .product-card-container::-webkit-scrollbar-thumb:hover {
            background: #555; /* Color of the scrollbar thumb on hover */
        }

        .product-card {
            flex: 0 0 auto;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 15px;
            width: 200px; /* Adjust the width of the product card */
            transition: transform 0.3s ease;
        }

        .product-card img {
            width: 100%;
            border-radius: 10px;
            margin-bottom: 10px;
        }

        .product-card h5 {
            font-size: 18px;
            margin: 0 0 10px;
        }

        .product-card .deskripsi {
            font-size: 12px;
            margin: 0;
        }
        .product-card .price {
            font-size: 18px;
            color: #ff0000;
            font-weight: bold;
            margin: 0;
        }

        .product-details .original-price {
            font-size: 18px;
            color: #ff0000;
            text-decoration: line-through;
            margin: 0;
        }

        .product-details .discount-price {
            font-size: 20px;
            color: #2bff00;
            font-weight: bold;
            margin: 0;
        }

        .product-card:hover {
            transform: translateY(-10px);
        }

        .product-card.clicked {
            background-color: #e0f7fa; /* New background color when clicked */
        }
    </style>
</head>
<body>
    <div class="scroll-wrapper">
        <div class="card-register">
            <h2 class="text-center">Formulir Pendaftaran</h2>
            <form method="POST" action="{{ route('action-daftar') }}" id="DaftarLangganan">
                @csrf

                <center>
                    <img src="{{ asset('images/misc/LogoFront.png')}}" alt="logo" width="30%">
                </center>

                <div class="mb-3">
                    <label for="JenisUsaha" class="form-label">Jenis Usaha</label>
                    <select required id="JenisUsaha" name="JenisUsaha" class="js-example-basic-single form-control">
                        <option value="" >Pilih Jenis Usaha</option>
                        <option value="Retail" >Retail</option>
                        <option value="FnB" >Food and Beverage</option>
                        <option value="Hiburan" >Hiburan</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="NamaPartner" class="form-label">Nama Perusahaan</label>
                    <input required type="text" name="NamaPartner" class="form-control " placeholder="Masukan Nama Perusahaan" id="NamaPartner" aria-describedby="emailHelp">
                </div>

                <div class="mb-3">
                    <label for="NamaPIC" class="form-label">Nama Penanggung Jawab</label>
                    <input required type="text" name="NamaPIC" class="form-control " placeholder="Masukan Nama Penanggung Jawab" id="NamaPIC" aria-describedby="emailHelp">
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input required type="email" name="email" class="form-control " placeholder="Email ex: email@gmail.com" id="email" aria-describedby="emailHelp">
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Nomor Ponsel</label>
                    <input required type="number" name="NoHP" class="form-control " placeholder="No. HP ex: 6281325058258" id="NoHP" aria-describedby="emailHelp">
                </div>

                <div class="mb-3">
                    <label for="ProvID" class="form-label">Provinsi</label>
                    <select required id="ProvID" name="ProvID" class="js-example-basic-single form-control ">
                        <option value="">Pilih Provinsi</option>
                        @foreach($provinsi as $ko)
                            <option value="{{ $ko->prov_id }}">
                                {{ $ko->prov_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="KotaID" class="form-label">Kota</label>
                    <select required id="KotaID" name="KotaID" class="js-example-basic-single form-control">
                        <option value="">Pilih Kota</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="KecID" class="form-label">Kecamatan</label>
                    <select required id="KecID" name="KecID" class="js-example-basic-single form-control">
                        <option value="">Pilih Kecamatan</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="KelID" class="form-label">Kelurahan</label>
                    <select required id="KelID" name="KelID" class="js-example-basic-single form-control">
                        <option value="">Pilih Kelurahan</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="AlamatTagihan" class="form-label">Alamat</label>
                    <textarea required id="AlamatTagihan" name="AlamatTagihan" class="form-control" placeholder="Masukan alamat"></textarea>
                </div>

                <div class="form-group  row">
                    <center>
                        <label  class="text-body">Pilih Paket Berlangganan</label>
                    </center>
                    <div class="product-card-container"></div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Kata Sandi</label>
                    <input required type="password" name="password" placeholder="Kata Sandi" class="form-control" id="password">
                </div>

                <div class="mb-3">
                    <label for="ulangipassword" class="form-label">Ulangi Kata Sandi</label>
                    <input required type="password" name="ulangipassword" placeholder="Ulangi Kata Sandi" class="form-control" id="ulangipassword">
                </div>

                <div class="mb-3">
                    <small><input id="chkApprove" type="checkbox"> Saya telah Membaca dan Menyetuji <a href="#" data-bs-toggle="modal" data-bs-target="#TnCModal">Syarat dan Ketentuan</a></small>
                </div>
                

                <div class="form-group row ">
                    <div class="col-6">
                        <button type="submit" class="btn btn-primary text-white font-weight-bold w-100 py-3 mt-3" id="btRegister">
                            Daftar
                        </button>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('login') }}" class="btn btn-warning text-white font-weight-bold w-100 py-3 mt-3" id="btRegister">
                            Login
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@include('sweetalert::alert')

	
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/plugin.bundle.min.js')}}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js')}}"></script>
<script src="{{ asset('api/jqueryvalidate/jquery.validate.min.js')}}"></script>
<script src="{{asset('api/select2/select2.min.js')}}"></script>

<script type="text/javascript">
    jQuery(function () {
        var oProvinsi;
        var oKota;
        var oKelurahan;
        var oKecamatan;

        var ProductSelected = "";
        var ProductPrice = 0;

        jQuery(document).ready(function() {
            jQuery('.js-example-basic-single').select2();

            oProvinsi = <?php echo $provinsi; ?>;
            oKota = <?php echo $kota; ?>;

            jQuery('#btRegister').attr('disabled',true);
            // CreateProduct();
        });

        jQuery('#ProvID').change(function () {
            const filterKota = oKota.filter(kota => kota.prov_id == jQuery('#ProvID').val());
            $('#KotaID').empty();
            var newOption = $('<option>', {
                value: -1,
                text: "Pilih Kota"
            });
            $('#KotaID').append(newOption);

            $.each(filterKota,function (k,v) {
                var newOption = $('<option>', {
                    value: v.city_id,
                    text: v.city_name
                });

                $('#KotaID').append(newOption);
            });
        });

        jQuery('#KotaID').change(function () {
            $.ajax({
                async:false,
                type: 'post',
                url: "{{route('demografipelanggan')}}",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
                },
                data: {
                    'Table' : 'dem_kecamatan',
                    'Field' : 'kota_id',
                    'Value' : jQuery('#KotaID').val()
                },
                dataType: 'json',
                success: function(response) {
                    // bindGridHeader(response.data)
                    $('#KecID').empty();
                    var newOption = $('<option>', {
                        value: -1,
                        text: "Pilih Kecamatan"
                    });
                    $('#KecID').append(newOption); 
                    $.each(response.data,function (k,v) {
                        var newOption = $('<option>', {
                            value: v.dis_id,
                            text: v.dis_name
                        });

                        $('#KecID').append(newOption);
                    });
                }
            })
        });

        jQuery('#KecID').change(function () {
            $.ajax({
                async:false,
                type: 'post',
                url: "{{route('demografipelanggan')}}",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
                },
                data: {
                    'Table' : 'dem_kelurahan',
                    'Field' : 'kec_id',
                    'Value' : jQuery('#KecID').val()
                },
                dataType: 'json',
                success: function(response) {
                    $('#KelID').empty();
                    var newOption = $('<option>', {
                        value: -1,
                        text: "Pilih Kelurahan"
                    });
                    $('#KelID').append(newOption); 
                    $.each(response.data,function (k,v) {
                        var newOption = $('<option>', {
                            value: v.subdis_id,
                            text: v.subdis_name
                        });

                        $('#KelID').append(newOption);
                    });
                }
            })

            // const filterkel = oKelurahan.filter(kel => kel.kec_id == jQuery('#KecID').val());

            // $('#KelID').empty();
            // var newOption = $('<option>', {
            //     value: -1,
            //     text: "Pilih Kelurahan"
            // });
            // $('#KelID').append(newOption); 
            // $.each(filterkel,function (k,v) {
            //     var newOption = $('<option>', {
            //         value: v.subdis_id,
            //         text: v.subdis_name
            //     });

            //     $('#KelID').append(newOption);
            // });
        });

        jQuery('#JenisUsaha').change(function () {
            CreateProduct(jQuery('#JenisUsaha').val());
        })

        // jQuery('.product-card').click(function() {
        //     console.log('asdassdsasd');
        //     jQuery('.product-card').removeClass('clicked');
        //     jQuery(this).addClass('clicked');

        //     ProductSelected = jQuery('.product-card.clicked').attr("attr-productselected");
        //     ProductPrice = jQuery('.product-card').attr("attr-productprice");
        //     console.log(ProductSelected);
        // });

        jQuery('.product-card-container').on('click', '.product-card', function() {
            console.log('asdassdsasd');
            jQuery('.product-card').removeClass('clicked');
            jQuery(this).addClass('clicked');

            ProductSelected = jQuery(this).attr("attr-productselected");
            ProductPrice = jQuery(this).attr("attr-productprice");
            console.log(ProductPrice);
        });

        jQuery('#chkApprove').on('change', function() {
            if (jQuery(this).is(':checked')) {
                jQuery('#btRegister').prop('disabled', false);
            } else {
                jQuery('#btRegister').prop('disabled', true);
            }
        });

        jQuery('#DaftarLangganan').submit(function (event) {
            jQuery('#btRegister').text('Tunggu Sebentar.....');
      		jQuery('#btRegister').attr('disabled',true);

            event.preventDefault();
            var form = $(this);
            var formData = form.serializeArray();
            formData.push({ name: 'ProductSelected', value: ProductSelected });
            $.post(form.attr('action'), formData, function(response) {
                // Handle the server response here
                console.log(response);
                Swal.fire({
                    html: "Registrasi Berhasil dilakukan, silahkan konfirmasi melalui link yang dikirimkan, silahkan cek folder inbox / spam / junk di email anda",
                    icon: "success",
                    title: "Horray...",
                    // text: "Data berhasil disimpan! <br> " + response.Kembalian,
                }).then((result)=>{
                    window.location.href = '{{url("/")}}';
                });
            }).fail(function(jqXHR, textStatus, errorThrown) {
                // Handle any errors here
                console.error("Submission failed: ", textStatus, errorThrown);
                Swal.fire({
                    html: "Gagal Melakukan registrasi : ",
                    icon: "error",
                    title: "whoops...",
                    // text: "Data berhasil disimpan! <br> " + response.Kembalian,
                }).then((result)=>{
                    jQuery('#btRegister').text('Daftar');
      		        jQuery('#btRegister').attr('disabled',false);
                });
            });
        });

        function CreateProduct(JenisUsaha) {
            var oData = <?php echo json_encode($subscriptionheader); ?>;
            // console.log(oData);
            let filteredProducts = oData.filter(function(product) {
                return product.JenisUsaha == JenisUsaha;
            });
            jQuery(".product-card-container").empty();
            $.each(filteredProducts,function (k,v) {
                var xHTML = '<div class="product-card" attr-productselected="'+v.NoTransaksi+'" attr-productprice="'+(v.Harga - v.Potongan)+'">';
                        xHTML += '<img src="{{ asset('images/custom/subscription.png') }}" alt="Product 1">';
                        xHTML += '<div class="product-details">';
                            xHTML += '<center><h5>'+v.NamaSubscription+'</h5></center>';
                            xHTML += '<div class="deskripsi">'+v.DeskripsiSubscription+'</div>'
                            xHTML += '<center>';
                                if (v.Potongan > 0) {
                                    xHTML += '<div class="original-price">'+v.Harga+'</div>';
                                    xHTML += '<div class=discount-price>'+(v.Harga - v.Potongan)+'</div>';
                                }
                                else{
                                    xHTML += '<div class="price">'+v.Harga+'</div>';
                                }
                            xHTML += '</center>';
                        xHTML += '</div>';
                    xHTML += "</div>";

                    // console.log(xHTML);
                    jQuery(".product-card-container").append(xHTML);
            });

        }
    });
</script>
</html>
