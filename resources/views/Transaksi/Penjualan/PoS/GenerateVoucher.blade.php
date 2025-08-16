<!DOCTYPE html>
<!--
Template Name: Kundol Admin - Bootstrap 4 HTML Admin Dashboard Theme
Author: Themes-coder
Website: https://themes-coder.com/
Contact: sales@themes-coder.com
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<html lang="en">
<!--begin::Head-->

<head>
	
	<meta charset="utf-8" />
	<title>Admin | Penjualan FnB</title>
	<meta name="description" content="Updates and statistics" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<!--begin::Fonts-->
	<!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" /> -->
	<!--end::Fonts-->

	<!--begin::Global Theme Styles(used by all pages)-->
	<link href="{{ asset('css/style.css?v=1.0')}}" rel="stylesheet" type="text/css" />
	<!--end::Global Theme Styles-->

	<link href="{{ asset('api/pace/pace-theme-flat-top.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('api/mcustomscrollbar/jquery.mCustomScrollbar.css')}}" rel="stylesheet" type="text/css" />
	
	{{-- <link href="http://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" /> --}}
	<link href="{{asset('api/datatable/jquery.dataTables.min.css')}}" rel="stylesheet" type="text/css" />
	<link href="https://unpkg.com/multiple-select@1.5.2/dist/multiple-select.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
	<link href="{{asset('api/select2/select2.min.css')}}" rel="stylesheet" />

	<link rel="shortcut icon" href="{{ asset('media/logos/favicon.ico')}}" />

    {{-- Datatable --}}
    <link href="{{asset('api/datatable/jquery.dataTables.min.css')}}" rel="stylesheet" type="text/css" />
	<style type="text/css">
		

	</style>
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="tc_body" class="header-fixed header-mobile-fixed subheader-enabled aside-enabled aside-fixed">
   
    <header class="pos-header bg-white">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-xl-4 col-lg-4 col-md-6">
                    <div class="greeting-text">
                     <h3 class="card-label mb-0 font-weight-bold text-primary">WELCOME
                     </h3>
                     <h3 class="card-label mb-0 ">
                         {{ Auth::user()->name }}
                     </h3>
                    </div>
             
                </div>
                <div class="col-xl-4 col-lg-5 col-md-6  clock-main">
                 <div class="clock">
                   <div class="datetime-content">
                     <ul>
                         <li id="hours"></li>
                         <li id="point1">:</li>
                         <li id="min"></li>
                         <li id="point">:</li>
                         <li id="sec"></li>
                     </ul>
                   </div>
                  <div class="datetime-content">
                     <div id="Date"  class=""></div>
                  </div>
                 
                 </div>
                 
                </div>
                <div class="col-xl-4 col-lg-3 col-md-12  order-lg-last order-second">
 
                 <div class="topbar justify-content-end">
                     <div class="topbar-item folder-data">
                      <div class="btn btn-icon  w-auto h-auto btn-clean d-flex align-items-center py-0 me-3"  data-bs-toggle="modal" data-bs-target="#folderpop"
                      >
                          <span class="badge badge-pill badge-primary" id="_draftCount">0</span>
                          <span class="symbol symbol-35  symbol-light-success">
                              <span class="symbol-label bg-warning font-size-h5 ">
                                  <svg width="20px" height="20px" xmlns="http://www.w3.org/2000/svg" fill="#ffff"  viewBox="0 0 16 16">
                                      <path d="M9.828 3h3.982a2 2 0 0 1 1.992 2.181l-.637 7A2 2 0 0 1 13.174 14H2.826a2 2 0 0 1-1.991-1.819l-.637-7a1.99 1.99 0 0 1 .342-1.31L.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3zm-8.322.12C1.72 3.042 1.95 3 2.19 3h5.396l-.707-.707A1 1 0 0 0 6.172 2H2.5a1 1 0 0 0-1 .981l.006.139z"></path>
                                    </svg>
                              </span>
                          </span>
                      </div>
                  
                     </div>
              
                  <div class="dropdown">
                      <div class="topbar-item" data-bs-toggle="dropdown" data-display="static">
                          <div class="btn btn-icon w-auto h-auto btn-clean d-flex align-items-center py-0">
                          
                              <span class="symbol symbol-35 symbol-light-success">
                                  <span class="symbol-label font-size-h5 ">
                                      <svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-person-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                          <path fill-rule="evenodd" d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"></path>
                                      </svg>
                                  </span>
                              </span>
                          </div>
                      </div>
  
                      <div class="dropdown-menu dropdown-menu-right" style="min-width: 150px;">
  
  
                          <a href="{{ route('logout') }}" class="dropdown-item">
                              <span class="svg-icon svg-icon-xl svg-icon-primary me-2">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-power">
                                      <path d="M18.36 6.64a9 9 0 1 1-12.73 0"></path>
                                      <line x1="12" y1="2" x2="12" y2="12"></line>
                                  </svg>
                              </span>
                              Logout
                          </a>
                      </div>
  
                  </div>
                 </div>
          
                 </div>
            </div>
        </div>
    </header>

    <div class="container mt-4">
        <div class="row">
            <!-- Card Generate Voucher -->
            <div class="col-lg-4 col-md-6">
                <div class="card" style="width: 100%; padding: 10px;">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Generate Voucher Diskon</h4>
                    </div>
                    <div class="card-body">
                        <form id="voucherForm" action="/booking/voucher-store" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="voucherCode" class="form-label">Kode Voucher</label>
                                <input type="text" class="form-control" id="voucherCode" name="voucherCode" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="discountPercent" class="form-label">Persentase Diskon (%)</label>
                                <input type="number" class="form-control" id="discountPercent" name="discountPercent" required>
                            </div>
                            <div class="mb-3">
                                <label for="maximalDiscount" class="form-label">Maksimal Diskon (Rp)</label>
                                <input type="number" class="form-control" id="maximalDiscount" name="maximalDiscount" required>
                            </div>
                            <div class="mb-3">
                                <label for="discountQuota" class="form-label">Kuota Diskon</label>
                                <input type="number" class="form-control" id="discountQuota" name="discountQuota" required>
                            </div>
                            <div class="mb-3">
                                <label for="startDate" class="form-label">Tanggal Mulai Berlaku</label>
                                <input type="date" class="form-control" id="startDate" name="startDate" required style="width: 200px;">
                            </div>
                            <div class="mb-3">
                                <label for="expiryDate" class="form-label">Tanggal Kadaluarsa</label>
                                <input type="date" class="form-control" id="expiryDate" name="expiryDate" required style="width: 200px;">
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Deskripsi</label>
                                <input type="text" class="form-control" id="description" name="description" required>
                            </div>
                            <button type="submit" class="btn btn-success">Simpan Voucher</button>
                        </form>
                    </div>
                </div>
            </div>
    
            <!-- List Voucher -->
            <div class="col-lg-8 col-md-6 mt-4 mt-md-0">
                <div class="card" style="width: 100%;">
                    <div class="card-header bg-secondary text-white">
                        <h4 class="mb-0">Daftar Voucher Diskon</h4>
                    </div>
                    <div class="card-body">
                        <table id="voucherTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Diskon (%)</th>
                                    <th>Maks Diskon (Rp)</th>
                                    <th>Kuota (Rp)</th>
                                    <th>Tgl Awal</th>
                                    <th>Kadaluarsa</th>
                                    <th>Tgl Dibuat</th>
                                </tr>
                            </thead>
                            <tbody id="voucherList">
                                <!-- Data voucher akan muncul di sini -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/plugin.bundle.min.js')}}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js')}}"></script>
<!-- <script src="http://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script> -->
<script src="https://unpkg.com/multiple-select@1.5.2/dist/multiple-select.min.js"></script>
<!-- <script src="{{ asset('js/sweetalert.js')}}"></script> -->
<!-- <script src="{{ asset('js/sweetalert1.js')}}"></script> -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('js/script.bundle.js')}}"></script>
<link href="{{ asset('devexpress/dx.light.css')}}" rel="stylesheet" type="text/css" />
<script src="{{asset('devexpress/dx.all.js')}}"></script>
<script src="{{asset('api/select2/select2.min.js')}}"></script>
@if (env('MIDTRANS_IS_PRODUCTION') == 'false')
<script src="{{ env('MIDTRANS_DEV_URL') }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
@else
<script src="{{ env('MIDTRANS_PROD_URL') }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
@endif
<script src="{{asset('api/datatable/jquery.dataTables.min.js')}}"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/35.3.1/inline/ckeditor.js"></script>
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<!-- jQuery (Wajib) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

</body>
<!--end::Body-->
</html>
@extends('parts.generaljs')
<script type="text/javascript">

$(document).ready(function() {
    function generateVoucherCode() {
        let chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        let code = "";
        for (let i = 0; i < 8; i++) {
            code += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        return code;
    }

    $("#voucherCode").val(generateVoucherCode());
});

	$(document).ready(function() {
    $("#voucherForm").submit(function(event) {
        event.preventDefault(); // Mencegah reload halaman
        
        let formData = {
            voucherCode: $("#voucherCode").val(),
            discountPercent: $("#discountPercent").val(),
            maximalDiscount: $("#maximalDiscount").val(),
            discountQuota: $("#discountQuota").val(),
            description: $("#description").val(),
            startDate : $("#startDate").val(),
            expiryDate: $("#expiryDate").val()
        };

        $.ajax({
            url: "/booking/voucher-store", // Ganti dengan endpoint penyimpanan voucher di backend
            type: "POST",
            data: formData,
            dataType: "json",
            headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") // Tambahkan CSRF token di header
                },
            success: function(response) {
                Swal.fire({
                    title: "Sukses!",
                    text: "Voucher berhasil disimpan!",
                    icon: "success",
                    confirmButtonText: "OK"
                });
                $("#voucherForm")[0].reset(); // Reset form setelah sukses
            },
            error: function(xhr) {
                Swal.fire({
                    title: "Gagal!",
                    text: "Terjadi kesalahan saat menyimpan voucher.",
                    icon: "error",
                    confirmButtonText: "Tutup"
                });
            }
        });

        let xData = {
                            "voucherCode": formData.voucherCode,
                            "discountPercent": formData.discountPercent,
                            "maximalDiscount": formData.maximalDiscount,
                            "discountQuota": formData.discountQuota,
                            "description": formData.description,
                            "startDate" : formData.startDate,
                            "expiryDate": formData.expiryDate
                        };

                        $.ajax({
            type: 'POST',
            url: "/booking/voucher-store", 
            headers: {
										'X-CSRF-TOKEN': '{{ csrf_token() }}' 
									},
            data: JSON.stringify(xData),
            contentType: "application/json", 
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: "success",
                        title: 'Sukses',
                        text: 'Data Berhasil Disimpan',
                    }).then(() => {
                        //location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: 'Error',
                        text: response.message,
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", xhr.responseText);
                Swal.fire({
                    icon: "error",
                    title: 'Error',
                    text: 'Terjadi kesalahan saat memperbarui data.',
                });
            }
        });

    });
});

$(document).ready(function () {
        fetchVouchers(); // Panggil saat halaman dimuat

        function fetchVouchers() {
            $.ajax({
                url: "/booking/get-listVoucher",
                type: "GET",
                dataType: "json",
                success: function (response) {
                    let voucherTable = $("#voucherList");
                    voucherTable.empty(); // Kosongkan tabel sebelum mengisi ulang

                    response.forEach(function (voucher) {
                        let dt = new Date(voucher.created_at);
                        let formattedDate = `${dt.getFullYear()}-${String(dt.getMonth() + 1).padStart(2, '0')}-${String(dt.getDate()).padStart(2, '0')} ${String(dt.getHours()).padStart(2, '0')}:${String(dt.getMinutes()).padStart(2, '0')}:${String(dt.getSeconds()).padStart(2, '0')}`;

                        voucherTable.append(`
                            <tr>
                                <td>${voucher.VoucherCode}</td>
                                <td>${voucher.DiscountPercent}%</td>
                                <td>Rp ${voucher.MaximalDiscount.toLocaleString()}</td>
                                <td>${voucher.DiscountQuota.toLocaleString()}</td>
                                <td>${voucher.StartDate}</td>
                                <td>${voucher.EndDate}</td>
                                <td>${formattedDate}</td>
                            </tr>
                        `);
                    });

                    if ($.fn.DataTable.isDataTable("#voucherTable")) {
                $("#voucherTable").DataTable().destroy();
            }

            $("#voucherTable").DataTable({
                order: [[6, "desc"]],
                pageLength: 10, // Menampilkan 10 data per halaman
                lengthChange: false, // Hilangkan opsi untuk ubah jumlah data per halaman
                ordering: true, // Aktifkan fitur sorting
                searching: true, // Aktifkan pencarian
                responsive: true // Agar tampilan mobile lebih baik
            });
                },
                error: function (xhr) {
                    console.error("Gagal mengambil data voucher:", xhr);
                }
            });
        }
    });


    
</script>