<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>invoice card</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
      body {
        margin-top: 20px;
        background-color: #eee;
      }

      .card {
        box-shadow: 0 20px 27px 0 rgb(0 0 0 / 5%);
      }

      .card {
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border: 0 solid rgba(0, 0, 0, .125);
        border-radius: 1rem;
      }
    </style>
  </head>
  <body>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css" integrity="sha256-2XFplPlrFClt0bIdPgpz8H7ojnk10H69xRqd9+uTShA=" crossorigin="anonymous" />
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <div class="invoice-title">
                <h4 class="float-end font-size-15">#{{ $data[0]["NoTransaksi"] }}
                </h4>
                <div class="mb-4">
                  <h2 class="mb-1 text-muted">{{ $data[0]["NamaPartner"] }}</h2>
                </div>
                <div class="text-muted">
                  <p class="mb-1">{{ $data[0]["AlamatTagihan"] }}</p>
                  <p>
                    <i class="uil uil-phone me-1"></i> {{ $data[0]["NoTlp"] }}
                  </p>
                </div>
              </div>
              <hr class="my-4">
              <div class="row">
                <div class="col-sm-6">
                  <div class="text-muted">
                    <h5 class="font-size-16 mb-3">Ditagihkan Kepada:</h5>
                    <h5 class="font-size-15 mb-2">{{ $data[0]["NamaPelanggan"] }}</h5>
                    <p class="mb-1">{{ $data[0]["Alamat"] }}</p>
                    <p class="mb-1">
                        {{ $data[0]["Email"] }}
                    </p>
                    <p>{{ $data[0]["NoTlp1"] }}</p>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="text-muted text-sm-end">
                    <div>
                      <h5 class="font-size-15 mb-1">No. Doc:</h5>
                      <p>#{{ $data[0]["NoTransaksi"] }}</p>
                    </div>
                    <div class="mt-4">
                      <h5 class="font-size-15 mb-1">Tgl. Doc:</h5>
                      <p>{{ $data[0]["TglTransaksi"] }}</p>
                    </div>
                    <div class="mt-4">
                      <h5 class="font-size-15 mb-1">Tgl. Jatuh Tempo:</h5>
                      <p>{{ $data[0]["TglJatuhTempo"] }}</p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="py-2">
                <h5 class="font-size-15">Order Summary</h5>
                <div>
                  <table class="table align-middle table-nowrap table-centered mb-0">
                    <thead>
                      <tr>
                        <th style="width: 70px;">No.</th>
                        <th>Deskripsi</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th class="text-end" style="width: 120px;">Total</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php $LineNumber = 0; ?>
					    @foreach($data as $v)
                            <tr>
                                <th scope="row">{{$LineNumber +1}}</th>
                                <td>
                                    <div>
                                    <h5 class="text-truncate font-size-14 mb-1">{{ $v['NamaItem'] }}</h5>
                                    </div>
                                </td>
                                <td>{{ number_format($v['Harga']) }}</td>
                                <td>{{ number_format($v['Qty']) }}</td>
                                <td class="text-end">{{ number_format($v['HargaNet']) }}</td>
                            </tr>
                        @endforeach
                      
                      
                      <tr>
                        <th scope="row" colspan="4" class="text-end">Sub Total</th>
                        <td class="text-end">{{ number_format($data[0]['SubTotal']) }}</td>
                      </tr>
                      <tr>
                        <th scope="row" colspan="4" class="border-0 text-end"> Discount :</th>
                        <td class="border-0 text-end">- {{ number_format($data[0]['Diskon']) }}</td>
                      </tr>
                      <tr>
                        <th scope="row" colspan="4" class="border-0 text-end"> Tax</th>
                        <td class="border-0 text-end">{{ number_format($data[0]['Pajak']) }}</td>
                      </tr>
                      <tr>
                        <th scope="row" colspan="4" class="border-0 text-end">Total</th>
                        <td class="border-0 text-end">
                          <h4 class="m-0 fw-semibold">{{ number_format($data[0]['Total']) }}</h4>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="d-print-none mt-4">
                  <div class="float-end">
                    <a href="javascript:window.print()" class="btn btn-success me-1">
                      <i class="fa fa-print"></i>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript"></script>
  </body>
</html>