@extends('parts.header')
	
@section('content')
<style type="text/css">
    .disabled-link {
        pointer-events: none; /* Disables click events */
        color: gray; /* Changes the color to indicate the link is disabled */
        text-decoration: none; /* Optional: Remove underline */
        cursor: default; /* Changes the cursor to indicate it's not clickable */
    }
</style>
<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">Booking List</li>
			</ol>
		</nav>
	</div>
</div>
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
									<h3 class="card-label mb-0 font-weight-bold text-body">Daftar Booking Online
									</h3>
								</div>
							    <div class="icons d-flex">
									<a href="{{ $BookingURLString }}" class="btn btn-outline-primary rounded-pill font-weight-bold me-1 mb-1" target="_blank">Buka Website Booking Online</a>
								
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
							</div>
						</div>
					</div>
					<div class="col-12  px-4">
						<div class="card card-custom gutter-b bg-white border-0" >
							<div class="card-body" >
								<div class="dx-viewport demo-container">
				                	<div id="data-grid-demo">
				                  		<div id="gridContainerHeader"></div>
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



@endsection

@push('scripts')
<script type="text/javascript">
    const documentBaseUrl = "{{ route('document') }}";
	jQuery(document).ready(function() {
		var now = new Date();
    	var day = ("0" + now.getDate()).slice(-2);
    	var month = ("0" + (now.getMonth() + 1)).slice(-2);
    	var firstDay = now.getFullYear()+"-"+month+"-01";
    	var NowDay = now.getFullYear()+"-"+month+"-"+day;

    	jQuery('#TglAwal').val(firstDay);
    	jQuery('#TglAkhir').val(NowDay);

		// bindGridHeader([]);
        GetHeader();
	});

    jQuery('#btSearch').click(function () {
        GetHeader();
    });

    jQuery('#btnProses').click(function () {
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

    function GetHeader() {
        $.ajax({
            async:false,
            type: 'post',
            url: "{{route('booking-getBookingsList')}}",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
            },
            data: {
                'TglAwal' : jQuery('#TglAwal').val(),
                'TglAkhir' : jQuery('#TglAkhir').val()
            },
            dataType: 'json',
            success: function(response) {
                console.log(response)
                bindGridHeader(response)
            }
        })
    }

	function bindGridHeader(data) {
		var dataGridInstance = jQuery("#gridContainerHeader").dxDataGrid({
			allowColumnResizing: true,
			dataSource: data,
			keyExpr: "NoTransaksi",
			showBorders: true,
            allowColumnReordering: true,
            allowColumnResizing: true,
            columnAutoWidth: true,
            showBorders: true,
            paging: {
                enabled: true,
                pageSize: 10
            },
            editing: {
                mode: "row",
                // allowAdding:true,
                // allowUpdating: true,
                // allowDeleting: true,
                texts: {
                    confirmDeleteMessage: ''  
                }
            },
            searchPanel: {
	            visible: true,
	            width: 240,
	            placeholder: "Search..."
	        },
            selection: {
                mode: "single" // Enable single selection mode
            },
            columns: [
                {
                    dataField: "NoTransaksi",
                    caption: "No Transaksi",
                    allowEditing:false
                },
                {
                    dataField: "Email",
                    caption: "Email",
                    allowEditing:false
                },
                {
                    dataField: "NamaTitikLampu",
                    caption: "Meja",
                    allowEditing:false
                },
                {
                    dataField: "TglBooking",
                    caption: "Tanggal Booking",
                    allowEditing:false
                },
                {
                    dataField: "JamMulai",
                    caption: "Jam Mulai",
                    allowEditing:false
                },
                {
                    dataField: "JamSelesai",
                    caption: "Jam Selesai",
                    allowEditing:false
                },
                {
                    dataField: "StatusTransaksi",
                    caption: "Status",
                    allowEditing:false
                },
                {
                    dataField: "NetTotal",
                    caption: "Total Transaksi (Rp)",
                    allowEditing:false,
                    format: { type: 'fixedPoint', precision: 2 }
                },
                {
                    caption: "Action",
                    fixed: true,
                    cellTemplate: function(cellElement, cellInfo) {
                        var link = "delivery/form/"+cellInfo.data.NoTransaksi;
                        var LinkAccess = "";

                        LinkAccess += "<button title = 'Cetak Document' class='btn btn-outline-success font-weight-bold me-1 mb-1' onclick=\"showDetailModal('" + cellInfo.data.NoTransaksi + "')\"><i class='fas fa-eye'></i></button>";
                        LinkAccess += "<button title ='Hapus Transaksi' class='btn btn-outline-success font-weight-bold me-1 mb-1' onclick=\"ShowCheckInModal('" + cellInfo.data.NoTransaksi + "')\"><i class='fas fa-check'></i></button>";
                        // LinkAccess += "<a href = '#' class='btn btn-outline-danger font-weight-bold me-1 mb-1' id = 'btBayar' >Bayar</a>";

                        cellElement.append(LinkAccess);
                    }
                },
            ],
            onRowClick: function(e) {
                const rowElement = e.component.getRowElement(e.rowIndex);
                rowElement.addClass('row-highlight');
                // console.log('Row entered:', e.data);
                GetDetail(e.data.NoTransaksi)
            }
		}).dxDataGrid('instance');


	}

    function showDetailModal(noTransaksi) {
        $.ajax({
             url: `/booking/get-detailBooking/${noTransaksi}`,
            type: "GET",
            dataType: "json",
            success: function (data) {

                let tglBookingDate = new Date(data.TglBooking);
                let tglBooking = `${tglBookingDate.getFullYear()}-${(tglBookingDate.getMonth() + 1).toString().padStart(2, '0')}-${tglBookingDate.getDate().toString().padStart(2, '0')}`;


                jQuery("#modalNoTransaksi").text(data.NoTransaksi);
                jQuery("#modalKodePelanggan").text(data.KodePelanggan);
                jQuery("#modalNamaPelanggan").text(data.NamaPelanggan);
                jQuery("#modalEmail").text(data.Email);
                jQuery("#modalMeja").text(data.NamaTitikLampu);
                jQuery("#modalTglBooking").text(tglBooking);
                jQuery("#modalJenisPaket").text(data.JenisPaket);
                jQuery("#modalJamMulai").text(data.JamMulai);
                jQuery("#modalJamSelesai").text(data.JamSelesai);
                jQuery("#modalStatus").text(data.StatusTransaksi);
                jQuery("#modalTotalTransaksiBrutto").text(data.TotalTransaksi.toLocaleString("id-ID"));
                jQuery("#modalTotalDiskon").text(data.TotalDiskon.toLocaleString("id-ID"));
                jQuery("#modalTotalTransaksi").text(data.NetTotal.toLocaleString("id-ID"));
                jQuery("#modalKeterangan").text(data.Keterangan);

                jQuery("#detailModal").modal("show");
            },
            error: function () {
                alert("Gagal mengambil detail transaksi!");
            }
        });
    }

    function ShowCheckInModal(noTransaksi) {
         $.ajax({
            url: `/booking/get-detailBooking/${noTransaksi}`,
            type: "GET",
            dataType: "json",
            success: function (data) {
                jQuery("#modalMejaNoTransaksi").text(data.NoTransaksi).attr("data-id", data.TglBooking);
                jQuery("#modalMejaEmail").text(data.Email).attr("data-id", data.KodePelanggan);
                jQuery("#modalMejaJamMulai").text(data.JamMulai);
                jQuery("#modalMejaJamSelesai").text(data.JamSelesai).attr("data-id", data.DurasiPaket);
                jQuery("#modalMejaJenisPaket").text(data.JenisPaket).attr("data-id", data.paketid);
                jQuery("#modalMejaGrossTotal").text(data.TotalTransaksi);
                jQuery("#modalMejaDiscountTotal").text(data.TotalDiskon);
                jQuery("#modalMejaNetTotal").text(data.NetTotal);

                // GET LIST MEJA dan tampilkan checklist
                getMejaList(noTransaksi);

                jQuery("#detailModalMeja").modal("show");
            },
            error: function () {
                alert("Gagal mengambil detail transaksi!");
            }
        });
    }

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

        })
    }

    function DeleteData(noTransaksi) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Data akan dihapus dan tidak dapat dikembalikan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal',
            allowOutsideClick: false,
            allowEscapeKey: false,
            preConfirm: () => {
                const confirmBtn = Swal.getConfirmButton();
                confirmBtn.disabled = true;
                confirmBtn.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menghapus...`;

                // 2. Jalankan AJAX dan return promise ke preConfirm
                return $.ajax({
                async: true,
                type: 'POST',
                url: "{{ route('delivery-delete') }}",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    'NoTransaksi': noTransaksi
                },
                dataType: 'json'
                }).then(response => {
                    if (response.success == true) {
                        Swal.fire({
                        icon: 'success',
                        title: 'Horray...',
                        html: 'Data berhasil dihapus!',
                        }).then(() => location.reload());
                    } else {
                        throw new Error(response.message || 'Gagal menghapus data.');
                    }
                }).catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: error.message || 'Terjadi kesalahan saat menghapus data.'
                    });
                });
            }
        })
    }

</script>
@endpush