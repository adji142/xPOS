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
        :root {
            --primary-color: #007bff;
            --secondary-color: #6c757d;
            --success-color: #28a745;
            --danger-color: #dc3545;
            --warning-color: #ffc107;
            --info-color: #17a2b8;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
        }

        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: url({{ asset('images/misc/bg-login3.jpg')}});
            background-size: cover;
            background-position: center;
        }

        .scroll-wrapper {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem;
        }

        .card-register {
            background-color: rgba(255, 255, 255, 0.95);
            padding: 2.5rem;
            border-radius: 1rem;
            width: 100%;
            max-width: 900px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 8px 32px 0 rgba( 31, 38, 135, 0.37 );
        }

        h2 {
            font-weight: 700;
            font-size: 2.2rem;
            margin-bottom: 2rem;
            color: var(--dark-color);
        }

        label {
            font-weight: 600;
            font-size: 1rem;
            color: var(--secondary-color);
        }

        .form-control, .js-example-basic-single {
            font-size: 1rem;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            border: 1px solid #ced4da;
            transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
        }

        .form-control:focus, .js-example-basic-single:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25);
        }

        .product-card-container {
            display: flex;
            overflow-x: auto;
            padding: 20px 5px;
            gap: 20px;
            scroll-behavior: smooth;
        }

        .product-card-container::-webkit-scrollbar {
            height: 8px;
        }

        .product-card-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .product-card-container::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }

        .product-card-container::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        .product-card {
            flex: 0 0 auto;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 220px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
            border: 2px solid transparent;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .product-card.clicked {
            border-color: var(--primary-color);
            box-shadow: 0 8px 25px rgba(0, 123, 255, 0.25);
        }

        .product-card img {
            width: 100%;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        .product-card h5 {
            font-size: 1.1rem;
            font-weight: 600;
            margin: 0 0 10px;
            color: var(--dark-color);
        }

        .product-card .deskripsi {
            font-size: 0.85rem;
            color: var(--secondary-color);
            min-height: 50px;
        }

        .product-card .price {
            font-size: 1.25rem;
            color: var(--danger-color);
            font-weight: bold;
        }

        .product-details .original-price {
            font-size: 1rem;
            color: var(--secondary-color);
            text-decoration: line-through;
        }

        .product-details .discount-price {
            font-size: 1.25rem;
            color: var(--success-color);
            font-weight: bold;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-warning {
            background-color: var(--warning-color);
            border-color: var(--warning-color);
        }

    </style>
</head>
<body>
    <div class="scroll-wrapper">
        <div class="card-register">
            <div class="text-center mb-4">
                <img src="{{ asset('images/misc/LogoFront.png')}}" alt="logo" style="width: 150px;">
                <h2 class="mt-3">Formulir Pendaftaran</h2>
            </div>
            <form method="POST" action="{{ route('action-daftar') }}" id="DaftarLangganan">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="NamaPartner" class="form-label">Nama Perusahaan</label>
                        <input required type="text" name="NamaPartner" class="form-control" placeholder="Masukan Nama Perusahaan" id="NamaPartner">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="JenisUsaha" class="form-label">Jenis Usaha</label>
                        <select required id="JenisUsaha" name="JenisUsaha" class="js-example-basic-single form-control">
                            <option value="" disabled selected>Pilih Jenis Usaha</option>
                            <option value="Retail">Retail</option>
                            <option value="FnB">Food and Beverage</option>
                            <option value="Hiburan">Hiburan</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="NamaPIC" class="form-label">Nama Penanggung Jawab</label>
                        <input required type="text" name="NamaPIC" class="form-control" placeholder="Masukan Nama Penanggung Jawab" id="NamaPIC">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="NoHP" class="form-label">Nomor Ponsel</label>
                        <input required type="number" name="NoHP" class="form-control" placeholder="Contoh: 6281234567890" id="NoHP">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input required type="email" name="email" class="form-control" placeholder="contoh: email@domain.com" id="email">
                </div>

                <hr class="my-4">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="ProvID" class="form-label">Provinsi</label>
                        <select required id="ProvID" name="ProvID" class="js-example-basic-single form-control">
                            <option value="">Pilih Provinsi</option>
                            @foreach($provinsi as $ko)
                                <option value="{{ $ko->prov_id }}">{{ $ko->prov_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="KotaID" class="form-label">Kota</label>
                        <select required id="KotaID" name="KotaID" class="js-example-basic-single form-control">
                            <option value="">Pilih Kota</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="KecID" class="form-label">Kecamatan</label>
                        <select required id="KecID" name="KecID" class="js-example-basic-single form-control">
                            <option value="">Pilih Kecamatan</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="KelID" class="form-label">Kelurahan</label>
                        <select required id="KelID" name="KelID" class="js-example-basic-single form-control">
                            <option value="">Pilih Kelurahan</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="AlamatTagihan" class="form-label">Alamat Lengkap</label>
                    <textarea required id="AlamatTagihan" name="AlamatTagihan" class="form-control" placeholder="Masukan alamat lengkap" rows="3"></textarea>
                </div>

                <hr class="my-4">

                <div class="form-group mb-3">
                    <label class="text-body mb-2 d-block text-center">Pilih Paket Berlangganan</label>
                    <div class="product-card-container"></div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label">Kata Sandi</label>
                        <input required type="password" name="password" placeholder="Kata Sandi" class="form-control" id="password">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="ulangipassword" class="form-label">Ulangi Kata Sandi</label>
                        <input required type="password" name="ulangipassword" placeholder="Ulangi Kata Sandi" class="form-control" id="ulangipassword">
                    </div>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="chkApprove">
                    <label class="form-check-label" for="chkApprove">
                        Saya telah membaca dan menyetujui <a href="#" data-bs-toggle="modal" data-bs-target="#TnCModal">Syarat dan Ketentuan</a>
                    </label>
                </div>

                <div class="form-group row mt-4">
                    <div class="col-6">
                        <button type="submit" class="btn btn-primary text-white font-weight-bold w-100 py-2" id="btRegister" disabled>
                            Daftar
                        </button>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('login') }}" class="btn btn-warning text-white font-weight-bold w-100 py-2">
                            Login
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @include('sweetalert::alert')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/plugin.bundle.min.js')}}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('api/jqueryvalidate/jquery.validate.min.js')}}"></script>
    <script src="{{asset('api/select2/select2.min.js')}}"></script>

<script type="text/javascript">
    jQuery(function () {
        var oProvinsi = {!! json_encode($provinsi) !!};
        var oKota = {!! json_encode($kota) !!};
        var ProductSelected = "";
        var ProductPrice = 0;

        function init() {
            $('.js-example-basic-single').select2({
                theme: "bootstrap-5"
            });
            $('#btRegister').attr('disabled', true);
        }

        function handleProvinsiChange() {
            $('#ProvID').change(function () {
                const selectedProvID = $(this).val();
                const filterKota = oKota.filter(kota => kota.prov_id == selectedProvID);
                
                $('#KotaID').empty().append(new Option("Pilih Kota", ""));
                $.each(filterKota, function (k, v) {
                    $('#KotaID').append(new Option(v.city_name, v.city_id));
                });
            });
        }

        function handleKotaChange() {
            $('#KotaID').change(function () {
                fetchDemografiData('dem_kecamatan', 'kota_id', $(this).val(), '#KecID', 'Pilih Kecamatan', 'dis_id', 'dis_name');
            });
        }

        function handleKecamatanChange() {
            $('#KecID').change(function () {
                fetchDemografiData('dem_kelurahan', 'kec_id', $(this).val(), '#KelID', 'Pilih Kelurahan', 'subdis_id', 'subdis_name');
            });
        }

        function fetchDemografiData(table, field, value, targetElement, defaultOptionText, idField, nameField) {
            $.ajax({
                type: 'post',
                url: "{{route('demografipelanggan')}}",
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                data: { 'Table': table, 'Field': field, 'Value': value },
                dataType: 'json',
                success: function(response) {
                    let target = $(targetElement);
                    target.empty().append(new Option(defaultOptionText, ""));
                    $.each(response.data, function (k, v) {
                        target.append(new Option(v[nameField], v[idField]));
                    });
                },
                error: function() {
                    console.error("Failed to fetch demografi data.");
                }
            });
        }

        function handleJenisUsahaChange() {
            $('#JenisUsaha').change(function () {
                createProduct($(this).val());
            });
        }

        function handleProductCardClick() {
            $('.product-card-container').on('click', '.product-card', function() {
                $('.product-card').removeClass('clicked');
                $(this).addClass('clicked');
                ProductSelected = $(this).attr("attr-productselected");
                ProductPrice = $(this).attr("attr-productprice");
            });
        }

        function handleApprovalChange() {
            $('#chkApprove').on('change', function() {
                $('#btRegister').prop('disabled', !$(this).is(':checked'));
            });
        }

        function handleFormSubmit() {
            $('#DaftarLangganan').submit(function (event) {
                event.preventDefault();
                let form = $(this);
                let btRegister = $('#btRegister');

                btRegister.text('Tunggu Sebentar...').attr('disabled', true);

                let formData = form.serializeArray();
                formData.push({ name: 'ProductSelected', value: ProductSelected });

                $.post(form.attr('action'), formData)
                    .done(function(response) {
                        Swal.fire({
                            title: "Berhasil!",
                            html: "Registrasi berhasil. Silakan periksa email Anda (termasuk folder spam/junk) untuk link konfirmasi.",
                            icon: "success",
                        }).then(() => {
                            window.location.href = '{{url("/")}}';
                        });
                    })
                    .fail(function() {
                        Swal.fire({
                            title: "Gagal!",
                            text: "Terjadi kesalahan saat melakukan registrasi. Silakan coba lagi.",
                            icon: "error",
                        }).then(() => {
                            btRegister.text('Daftar').attr('disabled', false);
                        });
                    });
            });
        }

        function createProduct(jenisUsaha) {
            var oData = {!! json_encode($subscriptionheader) !!};
            let filteredProducts = oData.filter(product => product.JenisUsaha == jenisUsaha);
            let container = $(".product-card-container");
            container.empty();

            $.each(filteredProducts, function (k, v) {
                let priceHTML = v.Potongan > 0 ?
                    `<div class="original-price">Rp ${v.Harga.toLocaleString('id-ID')}</div><div class="discount-price">Rp ${(v.Harga - v.Potongan).toLocaleString('id-ID')}</div>` :
                    `<div class="price">Rp ${v.Harga.toLocaleString('id-ID')}</div>`;

                let xHTML = `
                    <div class="product-card" attr-productselected="${v.NoTransaksi}" attr-productprice="${v.Harga - v.Potongan}">
                        <img src="{{ asset('images/custom/subscription.png') }}" alt="Subscription Plan">
                        <div class="product-details text-center">
                            <h5>${v.NamaSubscription}</h5>
                            <div class="deskripsi mb-2">${v.DeskripsiSubscription}</div>
                            ${priceHTML}
                        </div>
                    </div>`;
                container.append(xHTML);
            });
        }

        // Initialize
        init();
        handleProvinsiChange();
        handleKotaChange();
        handleKecamatanChange();
        handleJenisUsahaChange();
        handleProductCardClick();
        handleApprovalChange();
        handleFormSubmit();
    });
</script>
</html>
