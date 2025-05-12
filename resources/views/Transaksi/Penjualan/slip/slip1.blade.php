<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Receipt page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
      body {
        margin-top: 10px;
        background: #eee;
      }
    </style>
  </head>
  <body>
    <div class="container bootdey">
      <div class="row invoice row-printable">
        <div class="col-md-10">
          <div class="panel panel-default plain" id="dash_0">
            <div class="panel-body p30">
              <div class="row">
                <div class="col-lg-6">
                  <div class="invoice-logo">
                    <img width="100" src="{{ $data[0]['icon'] }}" alt="Invoice logo">
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="invoice-from">
                    <ul class="list-unstyled text-right">
                      <li>{{ $data[0]["NamaPartner"] }}</li>
                      <li>{{ $data[0]["AlamatTagihan"] }}</li>
                      <li>VAT Number {{ $data[0]["NPWP"] }}</li>
                    </ul>
                  </div>
                </div>
                <div class="col-lg-12">
                  <div class="invoice-details mt25">
                    <div class="well">
                      <ul class="list-unstyled mb0">
                        <li>
                          <strong>Invoice</strong> #{{ $data[0]["NoTransaksi"] }}
                        </li>
                        <li>
                          <strong>Tanggal:</strong> {{ $data[0]["TglTransaksi"] }}
                        </li>
                        <li>
                          <strong>Tanggal Jatuh tempo:</strong> {{ $data[0]["TglJatuhTempo"] }}
                        </li>
                      </ul>
                    </div>
                  </div>
                  <div class="invoice-to mt25">
                    <ul class="list-unstyled">
                      <li>
                        <strong>Ditagihkan Kepada :</strong>
                      </li>
                      <li>{{ $data[0]["NamaPelanggan"] }}</li>
                      <li>{{ $data[0]["Alamat"] }}</li>
                    </ul>
                  </div>
                  <div class="invoice-items">
                    <div class="table-responsive" style="overflow: hidden; outline: none;" tabindex="0">
                      <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th class="per70 text-center">Description</th>
                            <th class="per5 text-center">Qty</th>
                            <th class="per5 text-center">Satuan</th>
                            <th class="per25 text-center">Total</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $v)
                                <tr>
                                    <td>{{ $v['NamaItem'] }}</td>
                                    <td class="text-center">{{ number_format($v['Qty']) }}</td>
                                    <td>{{ $v['Satuan'] }}</td>
                                    <td class="text-center">{{ number_format($v['HargaNet']) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                          <tr>
                            <th colspan="2" class="text-right">Sub Total:</th>
                            <th class="text-center">{{ number_format($data[0]["SubTotal"]) }}</th>
                          </tr>
                          <tr>
                            <th colspan="2" class="text-right">VAT:</th>
                            <th class="text-center">{{ number_format($data[0]["Pajak"]) }}</th>
                          </tr>
                          <tr>
                            <th colspan="2" class="text-right">Discount:</th>
                            <th class="text-center">{{ number_format($data[0]["Diskon"]) }}</th>
                          </tr>
                          <tr>
                            <th colspan="2" class="text-right">Total:</th>
                            <th class="text-center">{{ number_format($data[0]["Total"]) }}</th>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                  </div>
                  <div class="invoice-footer mt25">
                    <p class="text-center">Generated on , {{ date("Y-M-d H:i:s") }} 
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script type="text/javascript"></script>
  </body>
</html>