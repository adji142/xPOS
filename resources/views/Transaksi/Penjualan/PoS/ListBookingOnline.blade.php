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
						<div id="btOpenListBooking" class="btn btn-icon  w-auto h-auto btn-clean d-flex align-items-center py-0 me-3">
							<span class="symbol symbol-35  symbol-light-success">
								<a href="{{ route('billing') }}" target="_blank" class="btn btn-warning">Kembali ke billing</a>
							</span>
						</div>

                        <div id="btOpenListBooking" class="btn btn-icon  w-auto h-auto btn-clean d-flex align-items-center py-0 me-3">
							<span class="symbol symbol-35  symbol-light-success">
								<a href="{{ $BookingURLString }}" target="_blank" class="btn btn-warning">Web Booking</a>
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

    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header bg-secondary text-white">
                        <h4 class="mb-0">Daftar Booking Online</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <label  class="text-body">Tanggal Awal</label>
                                <input type="date" name="TglAwal" id="TglAwal" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label  class="text-body">Tanggal Akhir</label>
                                <input type="date" name="TglAkhir" id="TglAkhir" class="form-control">
                            </div>

                            <div class="col-md-3">
                                <br>
                                <button class="btn btn-outline-primary rounded-pill font-weight-bold me-1 mb-1" id="btSearch">Cari Data</button>
                            </div>
                        </div>
                        <div class="table-responsive"> <!-- Tambahkan ini -->
                            <table id="bookingTableContainer" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No Transaksi</th>
                                        <th>Email</th>
                                        <th>Meja</th>
                                        <th>Tanggal Booking</th>
                                        <th>Jam Mulai</th>
                                        <th>Jam Selesai</th>
                                        <th>Status</th>
                                        <th>Total Transaksi (Rp)</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="bookingTable">
                                    <!-- Data akan di-load melalui AJAX -->
                                </tbody>
                            </table>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail Transaksi -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable"> 
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Transaksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive"> <!-- Tambahkan ini -->
                    <table class="table table-bordered">
                        <tbody>
                            <tr><th>No Transaksi</th><td id="modalNoTransaksi"></td></tr>
                            <tr><th>Kode Pelanggan</th><td id="modalKodePelanggan"></td></tr>
                            <tr><th>Nama</th><td id="modalNamaPelanggan"></td></tr>
                            <tr><th>Email</th><td id="modalEmail"></td></tr>
                            <tr><th>Meja</th><td id="modalMeja"></td></tr>
                            <tr><th>Tanggal Booking</th><td id="modalTglBooking"></td></tr>
                            <tr><th>Jenis Paket</th><td id="modalJenisPaket"></td></tr>
                            <tr><th>Jam Mulai</th><td id="modalJamMulai"></td></tr>
                            <tr><th>Jam Selesai</th><td id="modalJamSelesai"></td></tr>
                            <tr><th>Status</th><td id="modalStatus"></td></tr>
                            <tr><th>Total Transaksi</th><td id="modalTotalTransaksiBrutto"></td></tr>
                            <tr><th>Total Diskon</th><td id="modalTotalDiskon"></td></tr>
                            <tr><th>Net Total Transaksi</th><td id="modalTotalTransaksi"></td></tr>
                            <tr><th>Keterangan</th><td id="modalKeterangan"></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

 <!-- Modal Konfirmasi Meja -->
 <div class="modal fade" id="detailModalMeja" tabindex="-1" aria-labelledby="detailModalMejaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalMejaLabel">Konfirmasi Check In </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Kolom Kiri (Informasi Transaksi) -->
                    <div class="col-md-4">
                        <div class="mb-2">
                            <label class="fw-bold">No Transaksi:</label>
                            <p id="modalMejaNoTransaksi" class="border p-2 rounded bg-light"></p>
                        </div>
                        <div class="mb-2">
                            <label class="fw-bold">Email:</label>
                            <p id="modalMejaEmail" class="border p-2 rounded bg-light"></p>
                        </div>
                        <div class="mb-2">
                            <label class="fw-bold">Jam Mulai:</label>
                            <p id="modalMejaJamMulai" class="border p-2 rounded bg-light"></p>
                        </div>
                        <div class="mb-2">
                            <label class="fw-bold">Jam Selesai:</label>
                            <p id="modalMejaJamSelesai" class="border p-2 rounded bg-light"></p>
                        </div>
                        <div class="mb-2">
                            <label class="fw-bold">Jenis Paket</label>
                            <p id="modalMejaJenisPaket" class="border p-2 rounded bg-light"></p>
                        </div>
                        <div class="mb-2" hidden>
                            <label class="fw-bold">Gross Total</label>
                            <p id="modalMejaGrossTotal" class="border p-2 rounded bg-light"></p>
                        </div>
                        <div class="mb-2" hidden>
                            <label class="fw-bold">Discount Total</label>
                            <p id="modalMejaDiscountTotal" class="border p-2 rounded bg-light"></p>
                        </div>
                        <div class="mb-2" hidden>
                            <label class="fw-bold">Net Total</label>
                            <p id="modalMejaNetTotal" class="border p-2 rounded bg-light"></p>
                        </div>
                    </div>

                    <!-- Kolom Kanan (Checklist Pilih Meja) -->
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="fw-bold">Check In Di Meja:</label>
                            <div id="mejaChecklistContainer" class="border p-3 rounded bg-light">
                                <!-- Checklist akan dimasukkan dengan JavaScript -->
                            </div>
                        </div>
                        
                        <!-- Tombol Proses dan Batal -->
                        <div class="d-flex justify-content-start gap-2">
                            <button id="btnProses" class="btn btn-success">Proses</button>
                            <button id="btnBatal" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </div>

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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>


</body>
<!--end::Body-->
</html>
@extends('parts.generaljs')
<script type="text/javascript">
	$(document).ready(function () {
    loadBookings();

    function loadBookings() {
        $.ajax({
            url: "/get-Bookings",
            type: "GET",
            dataType: "json",
            success: function (response) {
                let bookings = $("#bookingTable");
                bookings.empty(); // Kosongkan tabel sebelum mengisi ulang

                response.forEach(function (detail) {
                    let tglBookingDate = new Date(detail.TglBooking);
                    let tglBooking = `${tglBookingDate.getFullYear()}-${(tglBookingDate.getMonth() + 1).toString().padStart(2, '0')}-${tglBookingDate.getDate().toString().padStart(2, '0')}`;

                    
                    let isCheckIn = detail.StatusTransaksi.toUpperCase() === "CHECK IN";

                    bookings.append(`
                        <tr>
                            <td>${detail.NoTransaksi}</td>
                            <td>${detail.Email}</td>
                            <td>${detail.NamaTitikLampu}</td>
                            <td>${tglBooking}</td>
                            <td>${detail.JamMulai}</td>
                            <td>${detail.JamSelesai}</td>
                            <td>${detail.StatusTransaksi}</td>
                            <td>${detail.NetTotal.toLocaleString("id-ID")}</td>
                            <td>
                                <div class="d-flex gap-2">
                                   <button class="btn btn-primary btn-sm w-100 view-detail" data-id="${detail.NoTransaksi}">View</button>
                                <button class="btn btn-success btn-sm w-100 checkin" data-id="${detail.NoTransaksi}" ${isCheckIn ? 'disabled' : ''}>CheckIn</button>
                                </div>
                            </td>
                        </tr>
                    `);
                });

                if ($.fn.DataTable.isDataTable("#bookingTableContainer")) {
                    $("#bookingTableContainer").DataTable().destroy();
                }

                $("#bookingTableContainer").DataTable({
                    order: [[3, "desc"]],
                    pageLength: 10,
                    lengthChange: false,
                    ordering: true,
                    searching: true,
                    responsive: true
                });
            },
            error: function (xhr) {
                console.error("Gagal mengambil data:", xhr);
            }
        });
    }

    loadBookings();

    // Event Klik Tombol View Detail
    $(document).on("click", ".view-detail", function () {
        let noTransaksi = $(this).data("id");

        $.ajax({
            url: `/booking/get-detailBooking/${noTransaksi}`,
            type: "GET",
            dataType: "json",
            success: function (data) {

                let tglBookingDate = new Date(data.TglBooking);
                let tglBooking = `${tglBookingDate.getFullYear()}-${(tglBookingDate.getMonth() + 1).toString().padStart(2, '0')}-${tglBookingDate.getDate().toString().padStart(2, '0')}`;


                $("#modalNoTransaksi").text(data.NoTransaksi);
                $("#modalKodePelanggan").text(data.KodePelanggan);
                $("#modalNamaPelanggan").text(data.NamaPelanggan);
                $("#modalEmail").text(data.Email);
                $("#modalMeja").text(data.NamaTitikLampu);
                $("#modalTglBooking").text(tglBooking);
                $("#modalJenisPaket").text(data.JenisPaket);
                $("#modalJamMulai").text(data.JamMulai);
                $("#modalJamSelesai").text(data.JamSelesai);
                $("#modalStatus").text(data.StatusTransaksi);
                $("#modalTotalTransaksiBrutto").text(data.TotalTransaksi.toLocaleString("id-ID"));
                $("#modalTotalDiskon").text(data.TotalDiskon.toLocaleString("id-ID"));
                $("#modalTotalTransaksi").text(data.NetTotal.toLocaleString("id-ID"));
                $("#modalKeterangan").text(data.Keterangan);

                $("#detailModal").modal("show");
            },
            error: function () {
                alert("Gagal mengambil detail transaksi!");
            }
        });
    });

    // Event Klik Tombol Check in
    $(document).on("click", ".checkin", function () {
        let noTransaksi = $(this).data("id");

        $.ajax({
            url: `/booking/get-detailBooking/${noTransaksi}`,
            type: "GET",
            dataType: "json",
            success: function (data) {
                $("#modalMejaNoTransaksi").text(data.NoTransaksi).attr("data-id", data.TglBooking);
                $("#modalMejaEmail").text(data.Email).attr("data-id", data.KodePelanggan);
                $("#modalMejaJamMulai").text(data.JamMulai);
                $("#modalMejaJamSelesai").text(data.JamSelesai).attr("data-id", data.DurasiPaket);
                $("#modalMejaJenisPaket").text(data.JenisPaket).attr("data-id", data.paketid);
                $("#modalMejaGrossTotal").text(data.TotalTransaksi);
                $("#modalMejaDiscountTotal").text(data.TotalDiskon);
                $("#modalMejaNetTotal").text(data.NetTotal);

                // GET LIST MEJA dan tampilkan checklist
                getMejaList(noTransaksi);

                $("#detailModalMeja").modal("show");
            },
            error: function () {
                alert("Gagal mengambil detail transaksi!");
            }
        });
    });

    // Fungsi untuk mengambil daftar meja dan mencocokkan dengan meja yang sudah dipesan
    function getMejaList(noTransaksi) {
        $.ajax({
            url: "/get-meja",
            type: "GET",
            dataType: "json",
            success: function (mejaData) {
                $.ajax({
    url: `/booking/get-meja-by-transaksi/${noTransaksi}`,
    type: "GET",
    dataType: "json",
    success: function (response) {
        let mejaContainer = $("#mejaChecklistContainer");
        mejaContainer.empty();

        if (!response.mejaID) {
            console.error("MejaID tidak ditemukan!");
            return;
        }

        // Pastikan mejaData sudah ada sebelum looping
        if (typeof mejaData === "undefined" || mejaData.length === 0) {
            console.error("Data meja tidak ditemukan!");
            return;
        }

        mejaData.forEach((meja) => {
    let isChecked = response.mejaID == meja.id ? "checked" : "";
    let radioButton = `
        <div class="form-check">
            <input class="form-check-input meja-radio" type="radio" name="meja" id="meja${meja.id}" data-id="${meja.id}" ${isChecked}>
            <label class="form-check-label" for="meja${meja.id}">
                ${meja.NamaTitikLampu}
            </label>
        </div>
    `;
    mejaContainer.append(radioButton);
});

    },
    error: function (xhr) {
        console.error("Gagal mengambil daftar meja untuk transaksi.", xhr);
    }
});

            },
            error: function () {
                console.error("Gagal mengambil daftar meja!");
            }
        });
    }

    $(document).on("click", "#btnProses", function () {
    let noTransaksi = $("#modalMejaNoTransaksi").text();
    let tglBooking = $("#modalMejaNoTransaksi").attr("data-id");
    let email = $("#modalMejaEmail").text();
    let kodePelanggan = $("#modalMejaEmail").attr("data-id");
    let jamMulai = $("#modalMejaJamMulai").text();
    let jamSelesai = $("#modalMejaJamSelesai").text();
    let durasiPaket = $("#modalMejaJamSelesai").attr("data-id");
    let paketid = $("#modalMejaJenisPaket").attr("data-id");
    let jenisPaket = $("#modalMejaJenisPaket").text();
    let selectedMeja = $("input[name='meja']:checked").data("id");
    let grossTotal = $("#modalMejaGrossTotal").text();
    let discTotal = $("#modalMejaDiscountTotal").text();
    let netTotal = $("#modalMejaNetTotal").text();

    let tglBookingFormatted = tglBooking.split(" ")[0]; // Ambil hanya YYYY-MM-DD
let jamMulaiFormatted = jamMulai.trim(); // Pastikan tidak ada spasi ekstra
let jamSelesaiFormatted = jamSelesai.trim();

console.log(`Formatted tglBooking: '${tglBookingFormatted}', jamMulai: '${jamMulaiFormatted}', jamSelesai: '${jamSelesaiFormatted}'`);

let mulai = new Date(`${tglBookingFormatted}T${jamMulaiFormatted}`);
let selesai = new Date(`${tglBookingFormatted}T${jamSelesaiFormatted}`);

let durasiJam = 0;  

if (isNaN(mulai) || isNaN(selesai)) {
    console.error("Format tanggal atau waktu salah!");
} else {
    let selisihMs = selesai - mulai;
     durasiJam = selisihMs / (1000 * 60 * 60);
    console.log("Durasi dalam jam:", durasiJam);
}

    if (!selectedMeja) {
        alert("Silakan pilih meja sebelum melanjutkan!");
        return;
    }

    
    let xData = {
        "NoTransaksi": noTransaksi,
        "TglBooking": tglBooking,
        "Email": email,
        "KodePelanggan": kodePelanggan,
        "JamMulai": jamMulai,
        "JamSelesai": jamSelesai,
        "DurasiPaket": durasiJam,
        "JenisPaket": jenisPaket,
        "paketid": paketid,
        "tableid": selectedMeja,
        "GrossTotal": grossTotal,
        "DiscTotal": discTotal,
        "NetTotal": netTotal,
        "KodeSales": "SL0001",
        "Status": "1"
                        };

                        $.ajax({
            type: 'POST',
            url: "/booking/insert-tableorderheader", 
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
                        location.reload();
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



    
</script>