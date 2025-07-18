<!DOCTYPE html>
<html lang="en">

<head>
	
	<meta charset="utf-8" />
	<title>Admin | Dashboard</title>
	<meta name="description" content="Updates and statistics" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

	<link href="{{ asset('css/style.css?v=1.0')}}" rel="stylesheet" type="text/css" />
	<!--end::Global Theme Styles-->

	<link href="{{ asset('api/pace/pace-theme-flat-top.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('api/mcustomscrollbar/jquery.mCustomScrollbar.css')}}" rel="stylesheet" type="text/css" />
	
	<link href="{{ asset('api/datatable/jquery.dataTables.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('api/select2/select2.min.css')}}" rel="stylesheet" />

	<link rel="shortcut icon" href="{{ asset('media/logos/favicon.ico')}}" />

    <style>
        .custom-card {
            height: 500px; /* Adjust the height as needed */
            overflow-y: auto;
            border-radius: 15px; /* Rounded corners */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow */
            background-color: #fff; /* White background */
            transition: all 0.3s ease; /* Smooth transition for any changes */
        }

        /* Custom scrollbar styling */
        .custom-card::-webkit-scrollbar {
            width: 5px; /* Width of the scrollbar */
        }

        .custom-card::-webkit-scrollbar-track {
            background: #f1f1f1; /* Background of the scrollbar track */
            border-radius: 5px; /* Rounded track */
        }

        .custom-card::-webkit-scrollbar-thumb {
            background: #888; /* Color of the scrollbar thumb */
            border-radius: 5px; /* Rounded thumb */
        }

        .custom-card::-webkit-scrollbar-thumb:hover {
            background: #555; /* Color of the scrollbar thumb on hover */
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
<!--end::Head-->
<!--begin::Body-->

<body id="tc_body" class="">
	   <!-- Paste this code after body tag -->
	<div class="l-form" style="background-image: url({{ asset('images/misc/bg-login3.jpg')}}); background-size: cover;">
        <div class="card custom-card">
            <form method="post" action="{{ route('action-daftar') }}" class="adminloginform" id="DaftarLangganan">
                @csrf
                <div class="maintitle">
                    <div class="card-title mb-0">
                        <h3 class="card-label font-weight-bold mb-0 text-body">
                            <img src="{{ asset('images/misc/LogoFront.png')}}" alt="logo" width="30%">
                        </h3>
                    
                    </div>
                    <h5 class="font-size-h5 mb-0 mt-3 text-dark">
                        Isikan Form berikut untuk Melakukan registrasi
                    </h5>
    
                </div>
                
                <div class="form-group  row">
                    <div class="col-lg-2 col-3 ">
                        <label for="exampleInputEmail1" class="mb-0 text-dark">
                            <svg xmlns="http://www.w3.org/2000/svg"  width="20px" height="20px" fill="currentColor" class="bi bi-globe-americas" viewBox="0 0 16 16">
                                <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0M2.04 4.326c.325 1.329 2.532 2.54 3.717 3.19.48.263.793.434.743.484q-.121.12-.242.234c-.416.396-.787.749-.758 1.266.035.634.618.824 1.214 1.017.577.188 1.168.38 1.286.983.082.417-.075.988-.22 1.52-.215.782-.406 1.48.22 1.48 1.5-.5 3.798-3.186 4-5 .138-1.243-2-2-3.5-2.5-.478-.16-.755.081-.99.284-.172.15-.322.279-.51.216-.445-.148-2.5-2-1.5-2.5.78-.39.952-.171 1.227.182.078.099.163.208.273.318.609.304.662-.132.723-.633.039-.322.081-.671.277-.867.434-.434 1.265-.791 2.028-1.12.712-.306 1.365-.587 1.579-.88A7 7 0 1 1 2.04 4.327Z"/>
                            </svg>
                        </label>
                    </div>
                        <div class="col-lg-10 col-9 pl-0">
                        <select required id="JenisUsaha" name="JenisUsaha" class="js-example-basic-single form-control text-dark border-0 p-0 h-20px font-size-h5">
                            <option value="" >Pilih Jenis Usaha</option>
                            <option value="Retail" >Retail</option>
                            <option value="FnB" >Food and Beverage</option>
                            <option value="Hiburan" >Hiburan</option>
                        </select>
                    </div>
                 
                </div>

                <div class="form-group  row">
                    <div class="col-lg-2 col-3 ">
                        <label for="exampleInputEmail1" class="mb-0 text-dark">
                            <svg xmlns="http://www.w3.org/2000/svg"  width="20px" height="20px" fill="currentColor" class="bi bi-person-check" viewBox="0 0 16 16">
                                <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m1.679-4.493-1.335 2.226a.75.75 0 0 1-1.174.144l-.774-.773a.5.5 0 0 1 .708-.708l.547.548 1.17-1.951a.5.5 0 1 1 .858.514M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4"/>
                                <path d="M8.256 14a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1z"/>
                            </svg>
                        </label>
                    </div>
                        <div class="col-lg-10 col-9 pl-0">
                        <input required type="text" name="NamaPartner" class="form-control text-dark border-0 p-0 h-20px font-size-h5" placeholder="Masukan Nama Perusahaan" id="NamaPartner" aria-describedby="emailHelp">
                
                    </div>
                 
                </div>
    
                <div class="form-group  row">
                    <div class="col-lg-2 col-3 ">
                        <label for="exampleInputEmail1" class="mb-0 text-dark">
                            <svg xmlns="http://www.w3.org/2000/svg"  width="20px" height="20px" fill="currentColor" class="bi bi-person-vcard" viewBox="0 0 16 16">
                                <path d="M5 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4m4-2.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5M9 8a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4A.5.5 0 0 1 9 8m1 2.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5"/>
                                <path d="M2 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2zM1 4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H8.96q.04-.245.04-.5C9 10.567 7.21 9 5 9c-2.086 0-3.8 1.398-3.984 3.181A1 1 0 0 1 1 12z"/>
                            </svg>
                        </label>
                    </div>
                        <div class="col-lg-10 col-9 pl-0">
                        <input required type="text" name="NamaPIC" class="form-control text-dark border-0 p-0 h-20px font-size-h5" placeholder="Masukan Nama Penanggung Jawab" id="NamaPIC" aria-describedby="emailHelp">
                
                    </div>
                 
                </div>
    
                <div class="form-group  row">
                    <div class="col-lg-2 col-3 ">
                        <label for="exampleInputEmail1" class="mb-0 text-dark">
                            <svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-person" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0zM8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6 5c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                                </svg>
                        </label>
                    </div>
                        <div class="col-lg-10 col-9 pl-0">
                        <input required type="email" name="email" class="form-control text-dark border-0 p-0 h-20px font-size-h5" placeholder="example@mail.com" id="exampleInputEmail1" aria-describedby="emailHelp">
                
                    </div>
                 
                </div>
    
                <div class="form-group  row">
                    <div class="col-lg-2 col-3 ">
                        <label for="exampleInputEmail1" class="mb-0 text-dark">
                            <svg xmlns="http://www.w3.org/2000/svg"  width="20px" height="20px" fill="currentColor" class="bi bi-telephone-fill" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z"/>
                            </svg>
                        </label>
                    </div>
                        <div class="col-lg-10 col-9 pl-0">
                        <input required type="number" name="NoHP" class="form-control text-dark border-0 p-0 h-20px font-size-h5" placeholder="6281325058258" id="NoHP" aria-describedby="emailHelp">
                
                    </div>
                 
                </div>
    
                <div class="form-group  row">
                    <div class="col-lg-2 col-3 ">
                        <label for="exampleInputEmail1" class="mb-0 text-dark">
                            <svg xmlns="http://www.w3.org/2000/svg"  width="20px" height="20px" fill="currentColor" class="bi bi-globe-americas" viewBox="0 0 16 16">
                                <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0M2.04 4.326c.325 1.329 2.532 2.54 3.717 3.19.48.263.793.434.743.484q-.121.12-.242.234c-.416.396-.787.749-.758 1.266.035.634.618.824 1.214 1.017.577.188 1.168.38 1.286.983.082.417-.075.988-.22 1.52-.215.782-.406 1.48.22 1.48 1.5-.5 3.798-3.186 4-5 .138-1.243-2-2-3.5-2.5-.478-.16-.755.081-.99.284-.172.15-.322.279-.51.216-.445-.148-2.5-2-1.5-2.5.78-.39.952-.171 1.227.182.078.099.163.208.273.318.609.304.662-.132.723-.633.039-.322.081-.671.277-.867.434-.434 1.265-.791 2.028-1.12.712-.306 1.365-.587 1.579-.88A7 7 0 1 1 2.04 4.327Z"/>
                            </svg>
                        </label>
                    </div>
                        <div class="col-lg-10 col-9 pl-0">
                        <select required id="ProvID" name="ProvID" class="js-example-basic-single form-control text-dark border-0 p-0 h-20px font-size-h5">
                            <option value="">Pilih Provinsi</option>
                            @foreach($provinsi as $ko)
                                <option value="{{ $ko->prov_id }}">
                                    {{ $ko->prov_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                 
                </div>
    
                <div class="form-group  row">
                    <div class="col-lg-2 col-3 ">
                        <label for="exampleInputEmail1" class="mb-0 text-dark">
                            <svg xmlns="http://www.w3.org/2000/svg"  width="20px" height="20px" fill="currentColor" class="bi bi-globe-americas" viewBox="0 0 16 16">
                                <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0M2.04 4.326c.325 1.329 2.532 2.54 3.717 3.19.48.263.793.434.743.484q-.121.12-.242.234c-.416.396-.787.749-.758 1.266.035.634.618.824 1.214 1.017.577.188 1.168.38 1.286.983.082.417-.075.988-.22 1.52-.215.782-.406 1.48.22 1.48 1.5-.5 3.798-3.186 4-5 .138-1.243-2-2-3.5-2.5-.478-.16-.755.081-.99.284-.172.15-.322.279-.51.216-.445-.148-2.5-2-1.5-2.5.78-.39.952-.171 1.227.182.078.099.163.208.273.318.609.304.662-.132.723-.633.039-.322.081-.671.277-.867.434-.434 1.265-.791 2.028-1.12.712-.306 1.365-.587 1.579-.88A7 7 0 1 1 2.04 4.327Z"/>
                            </svg>
                        </label>
                    </div>
                        <div class="col-lg-10 col-9 pl-0">
                        <select required id="KotaID" name="KotaID" class="js-example-basic-single form-control text-dark border-0 p-0 h-20px font-size-h5">
                            <option value="">Pilih Kota</option>
                        </select>
                    </div>
                 
                </div>
    
                <div class="form-group  row">
                    <div class="col-lg-2 col-3 ">
                        <label for="exampleInputEmail1" class="mb-0 text-dark">
                            <svg xmlns="http://www.w3.org/2000/svg"  width="20px" height="20px" fill="currentColor" class="bi bi-globe-americas" viewBox="0 0 16 16">
                                <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0M2.04 4.326c.325 1.329 2.532 2.54 3.717 3.19.48.263.793.434.743.484q-.121.12-.242.234c-.416.396-.787.749-.758 1.266.035.634.618.824 1.214 1.017.577.188 1.168.38 1.286.983.082.417-.075.988-.22 1.52-.215.782-.406 1.48.22 1.48 1.5-.5 3.798-3.186 4-5 .138-1.243-2-2-3.5-2.5-.478-.16-.755.081-.99.284-.172.15-.322.279-.51.216-.445-.148-2.5-2-1.5-2.5.78-.39.952-.171 1.227.182.078.099.163.208.273.318.609.304.662-.132.723-.633.039-.322.081-.671.277-.867.434-.434 1.265-.791 2.028-1.12.712-.306 1.365-.587 1.579-.88A7 7 0 1 1 2.04 4.327Z"/>
                            </svg>
                        </label>
                    </div>
                        <div class="col-lg-10 col-9 pl-0">
                        <select required id="KecID" name="KecID" class="js-example-basic-single form-control text-dark border-0 p-0 h-20px font-size-h5">
                            <option value="">Pilih Kecamatan</option>
                        </select>
                    </div>
                 
                </div>
                
                <div class="form-group  row">
                    <div class="col-lg-2 col-3 ">
                        <label for="exampleInputEmail1" class="mb-0 text-dark">
                            <svg xmlns="http://www.w3.org/2000/svg"  width="20px" height="20px" fill="currentColor" class="bi bi-globe-americas" viewBox="0 0 16 16">
                                <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0M2.04 4.326c.325 1.329 2.532 2.54 3.717 3.19.48.263.793.434.743.484q-.121.12-.242.234c-.416.396-.787.749-.758 1.266.035.634.618.824 1.214 1.017.577.188 1.168.38 1.286.983.082.417-.075.988-.22 1.52-.215.782-.406 1.48.22 1.48 1.5-.5 3.798-3.186 4-5 .138-1.243-2-2-3.5-2.5-.478-.16-.755.081-.99.284-.172.15-.322.279-.51.216-.445-.148-2.5-2-1.5-2.5.78-.39.952-.171 1.227.182.078.099.163.208.273.318.609.304.662-.132.723-.633.039-.322.081-.671.277-.867.434-.434 1.265-.791 2.028-1.12.712-.306 1.365-.587 1.579-.88A7 7 0 1 1 2.04 4.327Z"/>
                            </svg>
                        </label>
                    </div>
                        <div class="col-lg-10 col-9 pl-0">
                        <select required id="KelID" name="KelID" class="js-example-basic-single form-control text-dark border-0 p-0 h-20px font-size-h5">
                            <option value="">Pilih Kelurahan</option>
                        </select>
                    </div>
                 
                </div>
    
    
                <div class="form-group  row">
                    <div class="col-lg-2 col-3 ">
                        <label for="exampleInputEmail1" class="mb-0 text-dark">
                            <svg xmlns="http://www.w3.org/2000/svg"  width="20px" height="20px" fill="currentColor" class="bi bi-telephone-fill" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z"/>
                            </svg>
                        </label>
                    </div>
                        <div class="col-lg-10 col-9 pl-0">
    
                        <textarea required id="AlamatTagihan" name="AlamatTagihan" class="form-control text-dark border-0 p-0 h-20px font-size-h5" placeholder="Masukan alamat"></textarea>
                    </div>
                 
                </div>

                <div class="form-group  row">
                    <center>
                        <label  class="text-body">Pilih Paket Berlangganan</label>
                    </center>
                    <div class="product-card-container">
                    </div>
                </div>
    
                <div class="form-group row ">
                    <div class="col-lg-2 col-3 ">
                        <label for="exampleInputPassword1" class="mb-0 text-dark">
                            <svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-lock" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M11.5 8h-7a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1h7a1 1 0 0 0 1-1V9a1 1 0 0 0-1-1zm-7-1a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h7a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-7zm0-3a3.5 3.5 0 1 1 7 0v3h-1V4a2.5 2.5 0 0 0-5 0v3h-1V4z"/>
                                </svg>
                        </label>
                    </div>
                        <div class="col-lg-10 col-9 pl-0">
                        <input required type="password" name="password" placeholder="Password" class="form-control text-dark border-0 p-0 h-20px font-size-h5" id="exampleInputPassword1">
                    </div>
                
                </div>
    
                <div class="form-group row ">
                    <div class="col-lg-2 col-3 ">
                        <label for="exampleInputPassword1" class="mb-0 text-dark">
                            <svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-lock" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M11.5 8h-7a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1h7a1 1 0 0 0 1-1V9a1 1 0 0 0-1-1zm-7-1a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h7a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-7zm0-3a3.5 3.5 0 1 1 7 0v3h-1V4a2.5 2.5 0 0 0-5 0v3h-1V4z"/>
                                </svg>
                        </label>
                    </div>
                        <div class="col-lg-10 col-9 pl-0">
                        <input required type="password" name="ulangipassword" placeholder="Ulangi Password" class="form-control text-dark border-0 p-0 h-20px font-size-h5" id="ulangipassword">
                    </div>
                
                </div>
                <div class="form-group row ">
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
</div>

<div class="modal fade" id="TnCModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false" >
	<div class="modal-dialog modal-dialog-scrollable" role="document">
		<div class="modal-content">
			<div class="modal-header">
			  <h5 class="modal-title" id="exampleModalScrollableTitle">Term and Condition</h5>
			  <button type="button" class="close rounded-pill btn btn-sm btn-icon btn-light btn-hover-primary m-0" data-bs-dismiss="modal" aria-label="Close">
				<svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-x" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
					<path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
				</svg>
			  </button>
			</div>
			<div class="modal-body">
				{!! $tnc->termcondition !!}
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-light" data-bs-dismiss="modal"> 
					<span class="">Tutup</span>
				</button>
			</div> 		
		</div>
	</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@include('sweetalert::alert')

	
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/plugin.bundle.min.js')}}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js')}}"></script>
<script src="{{ asset('api/jqueryvalidate/jquery.validate.min.js')}}"></script>
<script src="{{asset('api/select2/select2.min.js')}}"></script>
</body>
<!--end::Body-->
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
            console.log(ProductSelected);
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