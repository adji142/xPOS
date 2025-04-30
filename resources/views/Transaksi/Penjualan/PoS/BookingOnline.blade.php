<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Booking Online Table di {{ $company->NamaPartner }}</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="{{ asset('assets/favicon.ico') }}" />

        <!-- Font Awesome icons (free version)-->
        {{-- <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script> --}}
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
		<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        
    </head>
    <body id="page-top">
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
            <div class="container">
                <a class="navbar-brand" href="#page-top" style="color: yellow; font-weight: bold;">
                    {{ $company->NamaPartner }}
                </a>     
                <input type="hidden" id="kodePartner" value="{{ $company->KodePartner }}">
           
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    Menu
                    <i class="fas fa-bars ms-1"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">
                        {{-- <li class="nav-item"><a class="nav-link" href="#services">Services</a></li> --}}
                        <li class="nav-item"><a class="nav-link" href="#portfolio">Booking</a></li>
                        <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                        <li class="nav-item"><a class="nav-link" href="#team">Gallery</a></li>
                        <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Masthead-->
        <header class="masthead" style="position: relative; background-image: url('{{ $company->BannerBooking}}'); background-size: cover; background-position: center; ">
            <div class="overlay" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5);"></div>
    
    <div class="container position-relative">
        <div class="masthead-subheading">{!! $company->HeadlineBanner  !!}</div>
        <div class="masthead-heading text-uppercase">{!! $company->SubHeadlineBanner  !!}</div>
    </div>
        </header>
        <!-- Services-->
        {{-- <section class="page-section" id="services">
            <div class="container">
                <div class="text-center">
                    <h2 class="section-heading text-uppercase">Services</h2>
                    <h3 class="section-subheading text-muted">Lorem ipsum dolor sit amet consectetur.</h3>
                </div>
                <div class="row text-center">
                    <div class="col-md-4">
                        <span class="fa-stack fa-4x">
                            <i class="fas fa-circle fa-stack-2x text-primary"></i>
                            <i class="fas fa-shopping-cart fa-stack-1x fa-inverse"></i>
                        </span>
                        <h4 class="my-3">E-Commerce</h4>
                        <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima maxime quam architecto quo inventore harum ex magni, dicta impedit.</p>
                    </div>
                    <div class="col-md-4">
                        <span class="fa-stack fa-4x">
                            <i class="fas fa-circle fa-stack-2x text-primary"></i>
                            <i class="fas fa-laptop fa-stack-1x fa-inverse"></i>
                        </span>
                        <h4 class="my-3">Responsive Design</h4>
                        <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima maxime quam architecto quo inventore harum ex magni, dicta impedit.</p>
                    </div>
                    <div class="col-md-4">
                        <span class="fa-stack fa-4x">
                            <i class="fas fa-circle fa-stack-2x text-primary"></i>
                            <i class="fas fa-lock fa-stack-1x fa-inverse"></i>
                        </span>
                        <h4 class="my-3">Web Security</h4>
                        <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima maxime quam architecto quo inventore harum ex magni, dicta impedit.</p>
                    </div>
                </div>
            </div>
        </section> --}}
        <!-- Portfolio Grid-->
        <section class="page-section bg-light" id="portfolio">
            <div class="container">
                <div class="text-center">
                    <h2 class="section-heading text-uppercase">Booking Meja</h2>
                    <h3 class="section-subheading text-muted"></h3>
                </div>
                <div class="row">
                    @foreach($titikLampu as $lampu)
        <div class="col-lg-4 col-sm-6 mb-4">
            <div class="portfolio-item">
                <a class="portfolio-link" data-bs-toggle="modal" href="#portfolioModal{{ $lampu->id }}">
                    <div class="portfolio-hover">
                        <div class="portfolio-hover-content">
                            <i class="fas fa-plus fa-3x"></i>
                        </div>
                    </div>
                    <img class="img-fluid" src="{{ asset('assets/img/portfolio/meja.jpg') }}" alt="..." />
                </a>
                <div class="portfolio-caption">
                    <div class="portfolio-caption-heading">{{ $lampu->NamaTitikLampu }}</div>
                </div>
            </div>
        </div>
        @endforeach
                    
                </div>
            </div>
        </section>
        <!-- About-->
        <section class="page-section" id="about">
            <div class="container">
                <div class="text-center">
                    <h2 class="section-heading text-uppercase">About Us</h2>
                    <h3 class="section-subheading text-muted">{!! $company->AboutUs !!}</h3>
                </div>
                <div class="text-center">
                    <h2 class="section-heading text-uppercase">Term And Condition</h2>
                    <h3 class="section-subheading text-muted">{!! $company->TermAndCondition !!}</h3>
                </div>
                {{-- <ul class="timeline">
                    <li>
                        <div class="timeline-image"><img class="rounded-circle img-fluid" src="assets/img/about/1.jpg" alt="..." /></div>
                        <div class="timeline-panel">
                            <div class="timeline-heading">
                                <h4>2009-2011</h4>
                                <h4 class="subheading">Our Humble Beginnings</h4>
                            </div>
                            <div class="timeline-body"><p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt ut voluptatum eius sapiente, totam reiciendis temporibus qui quibusdam, recusandae sit vero unde, sed, incidunt et ea quo dolore laudantium consectetur!</p></div>
                        </div>
                    </li>
                    <li class="timeline-inverted">
                        <div class="timeline-image"><img class="rounded-circle img-fluid" src="assets/img/about/2.jpg" alt="..." /></div>
                        <div class="timeline-panel">
                            <div class="timeline-heading">
                                <h4>March 2011</h4>
                                <h4 class="subheading">An Agency is Born</h4>
                            </div>
                            <div class="timeline-body"><p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt ut voluptatum eius sapiente, totam reiciendis temporibus qui quibusdam, recusandae sit vero unde, sed, incidunt et ea quo dolore laudantium consectetur!</p></div>
                        </div>
                    </li>
                    <li>
                        <div class="timeline-image"><img class="rounded-circle img-fluid" src="assets/img/about/3.jpg" alt="..." /></div>
                        <div class="timeline-panel">
                            <div class="timeline-heading">
                                <h4>December 2015</h4>
                                <h4 class="subheading">Transition to Full Service</h4>
                            </div>
                            <div class="timeline-body"><p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt ut voluptatum eius sapiente, totam reiciendis temporibus qui quibusdam, recusandae sit vero unde, sed, incidunt et ea quo dolore laudantium consectetur!</p></div>
                        </div>
                    </li>
                    <li class="timeline-inverted">
                        <div class="timeline-image"><img class="rounded-circle img-fluid" src="assets/img/about/4.jpg" alt="..." /></div>
                        <div class="timeline-panel">
                            <div class="timeline-heading">
                                <h4>July 2020</h4>
                                <h4 class="subheading">Phase Two Expansion</h4>
                            </div>
                            <div class="timeline-body"><p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt ut voluptatum eius sapiente, totam reiciendis temporibus qui quibusdam, recusandae sit vero unde, sed, incidunt et ea quo dolore laudantium consectetur!</p></div>
                        </div>
                    </li>
                    <li class="timeline-inverted">
                        <div class="timeline-image">
                            <h4>
                                Be Part
                                <br />
                                Of Our
                                <br />
                                Story!
                            </h4>
                        </div>
                    </li>
                </ul> --}}
            </div>
        </section>
        <!-- Team-->
        <section class="page-section bg-light" id="team">
            <div class="container">
                <div class="text-center">
                    <h2 class="section-heading text-uppercase">Gallery</h2>
                    <h3 class="section-subheading text-muted">  </h3>
                </div>
               <!-- Grid Gallery -->
<div class="row">
    @foreach($gallery as $galleries)
        @foreach($galleries->toArray() as $index => $image)
            @if(!is_null($image) && !empty($image))
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="team-member">
                        <!-- Klik gambar untuk membuka modal -->
                        <img class="mx-auto rounded-circle img-thumbnail" src="{{ $image }}" alt="Gallery Image" 
                            data-bs-toggle="modal" data-bs-target="#imageModal{{ $index }}" style="cursor: pointer; ">
                    </div>
                </div>

                <!-- Modal untuk menampilkan gambar full-size -->
                <div class="modal fade" id="imageModal{{ $index }}" tabindex="-1" aria-labelledby="imageModalLabel{{ $index }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="imageModalLabel{{ $index }}">Preview Gambar</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-center">
                                <img src="{{ $image }}" style="max-width: 100%; height: auto;" alt="Full Image">
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    @endforeach
</div>

                
                {{-- <div class="row">
                    <div class="col-lg-8 mx-auto text-center"><p class="large text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut eaque, laboriosam veritatis, quos non quis ad perspiciatis, totam corporis ea, alias ut unde.</p></div> --}}
                
            </div>
        </section>
        <!-- Clients-->
        {{-- <div class="py-5">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-3 col-sm-6 my-3">
                        <a href="#!"><img class="img-fluid img-brand d-block mx-auto" src="assets/img/logos/microsoft.svg" alt="..." aria-label="Microsoft Logo" /></a>
                    </div>
                    <div class="col-md-3 col-sm-6 my-3">
                        <a href="#!"><img class="img-fluid img-brand d-block mx-auto" src="assets/img/logos/google.svg" alt="..." aria-label="Google Logo" /></a>
                    </div>
                    <div class="col-md-3 col-sm-6 my-3">
                        <a href="#!"><img class="img-fluid img-brand d-block mx-auto" src="assets/img/logos/facebook.svg" alt="..." aria-label="Facebook Logo" /></a>
                    </div>
                    <div class="col-md-3 col-sm-6 my-3">
                        <a href="#!"><img class="img-fluid img-brand d-block mx-auto" src="assets/img/logos/ibm.svg" alt="..." aria-label="IBM Logo" /></a>
                    </div>
                </div>
            </div>
        </div> --}}
        <!-- Contact-->
        <section class="page-section" id="contact">
            <div class="container">
                <div class="text-center">
                    <h2 class="section-heading text-uppercase">Contact Us</h2>
                    <h3 class="section-subheading text-muted" style="color: white !important;">Hubungi kami untuk informasi lebih lanjut.</h3>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-6 text-center">
                        <div class="mb-4">
                            <h4 class="text-uppercase" style="color: white;">Alamat</h4>
                            <p class="text-muted" style="color: yellow !important;">{{ $company->AlamatTagihan}}</p>
                        </div>
                        <div class="mb-4">
                            <h4 class="text-uppercase" style="color: white;">Telepon</h4>
                            <p class="text-muted"><a href="tel:{{ $company->NoTlp}}">{{ $company->NoTlp}}</a></p>
                        </div>
                        <div class="mb-4">
                            <h4 class="text-uppercase" style="color: white;">Email</h4>
                            <p class="text-muted"><a href="mailto:{{ $user->email}}">{{ $user->email}}</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Footer-->
        <footer class="footer py-4">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-4 text-lg-start">Copyright &copy; AIS System Solo 2025</div>
                    {{-- <div class="col-lg-4 my-3 my-lg-0">
                        <a class="btn btn-dark btn-social mx-2" href="#!" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-dark btn-social mx-2" href="#!" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-dark btn-social mx-2" href="#!" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <a class="link-dark text-decoration-none me-3" href="#!">Privacy Policy</a>
                        <a class="link-dark text-decoration-none" href="#!">Terms of Use</a>
                    </div> --}}
                </div>
            </div>
        </footer>
        <!-- Portfolio Modals-->
        <!-- Portfolio item 1 modal popup-->
        @foreach($titikLampu as $lampu)

        <div class="portfolio-modal modal fade" id="portfolioModal{{ $lampu->id }}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="close-modal" data-bs-dismiss="modal"><img src="{{ asset('assets/img/close-icon.svg') }}" alt="Close modal" />
                    </div>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="modal-body">
                                    <!-- Project details-->
                                    <h2 class="text-uppercase">{{$lampu->NamaTitikLampu}}</h2>
                                    <input type="hidden" name="idMeja" value="{{ $lampu->id }}">
                                    <p class="item-intro text-muted">Meja Bisa Di Booking dari Jam: {{ $company->JamAwalBooking}} - {{ $company->fJamAkhirBooking}}</p>
                                    {{-- <img class="img-fluid d-block mx-auto" src="assets/img/portfolio/1.jpg" alt="..." /> --}}
                                    {{-- <p>Use this area to describe your project. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Est blanditiis dolorem culpa incidunt minus dignissimos deserunt repellat aperiam quasi sunt officia expedita beatae cupiditate, maiores repudiandae, nostrum, reiciendis facere nemo!</p> --}}
                                    <ul class="list-group w-100">
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <strong >Nama Lengkap:</strong>
                                            <input type="text" class="form-control w-75" name="namaLengkap">
                                        </li>
                                    
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <strong >Email Address:</strong>
                                            <input type="email" class="form-control w-75" name="email">
                                        </li>
                                    
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <strong >No Telp:</strong>
                                            <input type="tel" class="form-control w-75" name="noTelp">
                                        </li>
                                    
                                        <li class="list-group-item text-center fw-bold">---</li>
                                    
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <strong>Pilih Tanggal Booking:</strong>
                                            <input type="date" class="form-control w-75 text-center" name="tanggalbooking" id="tanggalbooking">
                                        </li>
                                    
                                        <div id="bookingInfo" class="text-danger text-center my-2"></div>
                                    
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <strong>Jam Awal Booking:</strong>
                                            <input type="text" class="form-control w-75 text-center" name="jamMulai" id="jamMulai" step="60">
                                        </li>
                                    
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <strong>Jam Akhir Booking:</strong>
                                            <input type="text" class="form-control w-75 text-center" name="jamSelesai" id="jamSelesai" step="60">
                                        </li>
                                    
                                        <li class="list-group-item text-center fw-bold">---</li>
                                    
                                        <li class="list-group-item">
                                            <strong>Pilih Paket :</strong>
                                            <div class="mt-2">
                                                @foreach ($paketTransaksi as $paket)
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="paket" 
                                                            value="{{ $paket->id }}" id="paket{{ $paket->id }}" 
                                                            data-harga="{{ $paket->HargaNormal }}" 
                                                            data-jenis="{{ $paket->JenisPaket }}">
                                                        <label class="form-check-label" for="paket{{ $paket->id }}">
                                                            {{ $paket->NamaPaket }} - Rp {{ number_format($paket->HargaNormal, 0, ',', '.') }} 
                                                            per {{ $paket->JenisPaket }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </li>
                                    
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <strong>Extra Request:</strong>
                                            <textarea class="form-control w-75" name="extraRequest" rows="3"></textarea>
                                        </li>

                                        <li class="list-group-item d-flex flex-column">
                                            <strong>Kode Voucher Discount:</strong>
                                            <input type="text" class="form-control w-100 mt-2" name="voucherCode" id="voucherCode">
                                            <button class="btn btn-primary mt-2 w-30 mx-auto" type="button" id="applyVoucher">Apply</button>
                                            
                                            <div class="voucherInfo text-danger text-center my-2"></div>
                                        </li>

                                        
                                    
                                        <li class="list-group-item d-flex flex-column">
                                            <strong class="fs-6">Total Transaksi: Rp <span id="totalAsli" class="fs-6 text-danger">0</span></strong>
                                            <strong class="fs-6">Total Diskon: Rp <span id="totalDiskon" class="fs-6 text-warning">0</span></strong>
                                            <strong class="fs-4">Total Setelah Diskon: Rp <span id="totalTransaksi" class="fs-3 fw-bold text-success">0</span></strong>
                                        </li>
                                                                               
                                    </ul>
                                    
                                    <div class="d-flex justify-content-center gap-3 mt-4">
                                        <button class="btn btn-success btn-lg text-uppercase" id="btn-success" type="button">
                                            <i class="fas fa-check me-1"></i>
                                            Bayar
                                        </button>
                                    
                                        <button class="btn btn-danger btn-lg text-uppercase" data-bs-dismiss="modal" type="button">
                                            <i class="fas fa-xmark me-1"></i>
                                            Batal
                                        </button>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        
       
        <!-- Core theme JS-->
        <script src="{{ asset('js/scripts.js') }}"></script>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ $midtransclientkey }}"></script>
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <!-- * *                               SB Forms JS                               * *-->
        <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
        <script>
  function hitungTotal(event) {
    let modal = event.target.closest(".modal");
    let jamMulai = modal.querySelector("input[name='jamMulai']").value;
    let jamSelesai = modal.querySelector("input[name='jamSelesai']").value;
    let paketDipilih = modal.querySelector("input[name='paket']:checked");
    let voucherCode = modal.querySelector("input[name='voucherCode']").value.trim();
    var kodePartner = document.getElementById('kodePartner').value;
    

    if (!jamMulai || !jamSelesai || !paketDipilih) {
        updateTotal(0, 0, 0);
        return;
    }

    let harga = parseInt(paketDipilih.getAttribute("data-harga"));
    let jenisPaket = paketDipilih.getAttribute("data-jenis");

    // Konversi jam ke menit
    let [jamAwal, menitAwal] = jamMulai.split(":").map(Number);
    let [jamAkhir, menitAkhir] = jamSelesai.split(":").map(Number);
    let totalMenit = (jamAkhir * 60 + menitAkhir) - (jamAwal * 60 + menitAwal);

    let totalAsli = 0;
    if (jenisPaket.toLowerCase() === "jam") {
        let totalJam = Math.ceil(totalMenit / 60);
        totalAsli = harga * totalJam;
    } else if (jenisPaket.toLowerCase() === "menit") {
        totalAsli = harga * totalMenit;
    }

    let totalDiskon = 0;
    let totalSetelahDiskon = totalAsli;

    console.log("Total Asli sebelum diskon:", totalAsli);

    function updateTotal(finalTotal, discount, originalTotal) {
        modal.querySelector("#totalAsli").innerText = originalTotal.toLocaleString("id-ID");
        modal.querySelector("#totalDiskon").innerText = discount.toLocaleString("id-ID");
        modal.querySelector("#totalTransaksi").innerText = finalTotal.toLocaleString("id-ID");
    }

    if (voucherCode === "") {
        updateTotal(totalSetelahDiskon, totalDiskon, totalAsli);
        return;
    }

    $.ajax({
        url: `/booking/${kodePartner}/get-DiscountVoucher`,
        type: 'GET',
        data: { code: voucherCode, kodePartner: kodePartner },
        dataType: 'json',
        success: function (data) {
            console.log("Response voucher:", data);
            
            if (data.success) {

                let discountPercent = parseFloat(data.discountPercent) / 100;
                let maximalDiscount = parseFloat(data.maximalDiscount);
                let discountQuota = parseFloat(data.discountQuota);

                console.log("Diskon persen:", discountPercent);
                console.log("Maksimal diskon:", maximalDiscount);
                console.log("Kuota diskon:", discountQuota);

                if (discountQuota >= totalAsli) {
                    let calculatedDiscount = totalAsli * discountPercent;
                    totalDiskon = Math.min(calculatedDiscount, maximalDiscount);
                    totalSetelahDiskon = totalAsli - totalDiskon;

                    console.log("Diskon diterapkan:", totalDiskon);

                  
                } else {
                    console.log("Kuota diskon tidak mencukupi, diskon tidak diterapkan.");
                    
                }
            } else {
                console.log("Kode voucher tidak valid atau tidak ditemukan.");
                
            }
            
            updateTotal(totalSetelahDiskon, totalDiskon, totalAsli);
           

        },
        error: function (xhr, status, error) {
            console.error("Error fetching voucher data:", error);
            updateTotal(totalSetelahDiskon, totalDiskon, totalAsli);
        }
    });
}



// Event listener untuk perubahan input
document.addEventListener("change", function (event) {
    if (
        event.target.matches("input[name='jamMulai']") ||
        event.target.matches("input[name='jamSelesai']") ||
        event.target.matches("input[name='paket']") ||
        event.target.matches("input[name='voucherCode']")
    ) {
        hitungTotal(event);
    }
});


document.addEventListener("DOMContentLoaded", function () {
    flatpickr("#jamMulai", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",  // 24-hour format: H = hour (00-23), i = minutes
        time_24hr: true
    });
    flatpickr("#jamSelesai", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",  // 24-hour format: H = hour (00-23), i = minutes
        time_24hr: true
    });

    document.querySelectorAll(".btn-success").forEach(button => {
        button.addEventListener("click", function (event) {
            var kodePartner = document.getElementById('kodePartner').value;
            let modal = event.target.closest(".modal");
            let modalId = modal.id; 

            let lampuId = modalId.replace("portfolioModal", "");

            let formData = {
    namaLengkap: modal.querySelector("input[name='namaLengkap']").value,
    mejaID: lampuId,
    email: modal.querySelector("input[name='email']").value,
    noTelp: modal.querySelector("input[name='noTelp']").value,
    tanggalBooking: modal.querySelector("input[name='tanggalbooking']").value,
    jamMulai: modal.querySelector("input[name='jamMulai']").value,
    jamSelesai: modal.querySelector("input[name='jamSelesai']").value,
    paketid: modal.querySelector("input[name='paket']:checked")?.value || null,
    ExtraRequest: modal.querySelector("textarea[name='extraRequest']").value,
    totalPembelian: parseInt(modal.querySelector("#totalTransaksi").innerText.replace(/\D/g, "")),
    totalAsli: parseInt(modal.querySelector("#totalAsli").innerText.replace(/\D/g, "")),
    totalDiskon: parseInt(modal.querySelector("#totalDiskon").innerText.replace(/\D/g, "")),
    voucherCode: modal.querySelector("input[name='voucherCode']").value,
    kodePartner: kodePartner,
};
            
            // Validasi hanya untuk field yang wajib diisi
if (!formData.namaLengkap || !formData.email || 
    !formData.tanggalBooking || !formData.jamMulai || !formData.jamSelesai || 
    !formData.paketid) {
    
    Swal.fire({
        icon: "warning",
        title: "Oops...",
        text: "Mohon isi semua data yang diperlukan!",
    });
    return;
}
            
            let noTransaksi = "BOOKING"+Date.now(); // Contoh nomor transaksi unik
            PaymentGateWay($(button), "Bayar", formData);
        });
    });
});

function PaymentGateWay(ButtonObject, ButtonDefaultText, formData) {
    ButtonObject.text('Tunggu Sebentar.....');
    ButtonObject.attr('disabled', true);

    console.log("FormData:", formData);  // Debugging
console.log("TotalPembelian:", formData.totalPembelian);

    
    let oData = {
        'NoTransaksi': formData.NoTransaksi,
        'TotalPembelian': formData.totalPembelian,
        "kodePartner": formData.kodePartner,
    };
    
    fetch("{{route('booking-create-gateway')}}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(oData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.snap_token) {
            snap.pay(data.snap_token, {
                onSuccess: function (result) {
                    if (result.transaction_status === "cancel") {
                        ButtonObject.text('Bayar');
                        ButtonObject.attr('disabled', false);
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Pembayaran Dibatalkan",
                        });
                    } else {
                        let xData = {
                            "NoTransaksi": formData.NoTransaksi,
                            "TglBooking": formData.tanggalBooking,
                            "Keterangan": result.payment_type + "#" + (result.va_numbers?.[0]?.bank || "") + "#" + (result.va_numbers?.[0]?.va_number || ""),
                            "JamMulai": formData.jamMulai,
                            "JamSelesai": formData.jamSelesai,
                            "mejaID": formData.mejaID,
                            "paketid": formData.paketid,
                            "KodeSales": "-",
                            "KodePelanggan": "-",
                            "StatusTransaksi": 0,
                            "ExtraRequest": formData.ExtraRequest,
                            "TotalTransaksi": formData.totalAsli,
                            "TotalTax": 0,
                            "TotalDiskon": formData.totalDiskon,
                            "TotalLainLain": 0,
                            "NetTotal": formData.totalPembelian,
                            "NamaPelanggan": formData.namaLengkap,
                            "Email": formData.email,
                            "NoTlp1": formData.noTelp,
                            "VoucherCode" : formData.voucherCode,
                            "kodePartner": formData.kodePartner,
                        };
                        
                        fetch("{{route('booking-pay-gateway')}}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify(xData)
                        })
                        .then(response => response.json())
                        .then(response => {
                            if (response.success) {
                                Swal.fire({
                                    icon: "success",
                                    title: 'Berhasil',
                                    text: 'Pembayaran berhasil disimpan, Silahkan Cek Email Anda!',
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                ButtonObject.text('Bayar');
                                ButtonObject.attr('disabled', false);
                                Swal.fire({
                                    icon: "error",
                                    title: 'Error',
                                    text: response.message,
                                });
                            }
                        });
                    }
                },
                onError: function (result) {
                    ButtonObject.text('Bayar');
                    ButtonObject.attr('disabled', false);
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Terjadi kesalahan saat pembayaran",
                    });
                },
                onClose: function () {
                    ButtonObject.text('Bayar');
                    ButtonObject.attr('disabled', false);
                    console.log('Pelanggan menutup popup pembayaran');
                }
            });
        } else {
            ButtonObject.text('Bayar');
            ButtonObject.attr('disabled', false);
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: data.error,
            });
        }
    })
    .catch(error => console.error('Error:', error));
}

$(document).ready(function () {
    let bookedSlots = {}; // Objek untuk menyimpan daftar jam yang sudah dibooking berdasarkan ID meja

    // Event ketika tanggal booking diubah
    $(document).on('change', 'input[name="tanggalbooking"]', function () {
        var selectedDate = $(this).val();
        var modal = $(this).closest('.modal-body');
        var idMeja = modal.find('input[name="idMeja"]').val();
        var bookingInfoContainer = modal.find('#bookingInfo');
        var kodePartner = document.getElementById('kodePartner').value;

        bookingInfoContainer.html('');
        bookedSlots[idMeja] = []; // Reset daftar booking sebelumnya untuk meja ini

        if (selectedDate && idMeja) {
            $.ajax({
                url: `/booking/${kodePartner}/get-bookedtable`,
                type: 'GET',
                data: { tanggal: selectedDate, idMeja: idMeja },
                success: function (data) {
                    if (data.length > 0) {
                        var infoHtml = '<strong>Meja ini sudah dibooking:</strong><ul>';
                        data.forEach(function (booking) {
                            infoHtml += '<li>Jam ' + booking.JamMulai + ' - ' + booking.JamSelesai + '</li>';
                            bookedSlots[idMeja].push({ start: booking.JamMulai, end: booking.JamSelesai }); // Simpan waktu booking untuk meja ini
                        });
                        infoHtml += '</ul>';
                        bookingInfoContainer.html(infoHtml);
                    } else {
                        bookingInfoContainer.html('<strong>Meja ini masih tersedia di tanggal ini.</strong>');
                    }
                },
                error: function () {
                    bookingInfoContainer.html('<strong>Terjadi kesalahan saat mengambil data.</strong>');
                }
            });
        }
    });

    // Validasi input jam booking (Gunakan event delegation untuk semua modal)
    $(document).on('change', 'input[name="jamMulai"], input[name="jamSelesai"]', function () {
        var modal = $(this).closest('.modal-body');
        var idMeja = modal.find('input[name="idMeja"]').val();
        var jamMulai = modal.find('input[name="jamMulai"]').val();
        var jamSelesai = modal.find('input[name="jamSelesai"]').val();
        var errorMessage = '';

        if (jamMulai && jamSelesai) {
            var mulai = jamMulai + ':00';
            var selesai = jamSelesai + ':00';

            for (let i = 0; i < bookedSlots[idMeja].length; i++) {
                let bookedStart = bookedSlots[idMeja][i].start;
                let bookedEnd = bookedSlots[idMeja][i].end;

                // Cek apakah input waktu bentrok dengan booking yang ada
                if ((mulai >= bookedStart && mulai < bookedEnd) || (selesai > bookedStart && selesai <= bookedEnd) || (mulai <= bookedStart && selesai >= bookedEnd)) {
                    errorMessage = 'Waktu yang dipilih bertabrakan dengan booking lain (' + bookedStart + ' - ' + bookedEnd + ')';
                    break;
                }
            }

            if (errorMessage) {
                alert(errorMessage);
                $(this).val(''); // Kosongkan input yang salah
            }
        }
    });
});


        </script>

    </body>
</html>
