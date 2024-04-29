@extends('parts.header')
	
@section('content')

<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">
					<a href="{{route('gruppelanggan')}}">Grup Customer</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Input Grup Customer</li>
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
									<h3 class="card-label mb-0 font-weight-bold text-body">
										G/L Account Setting
									</h3>
								</div>
							</div>
						
						</div>


					</div>
				</div>

				<div class="row">
					<div class="col-12  px-4">
						<div class="card card-custom gutter-b bg-white border-0" >
							<div class="card-body" >
								<form action="{{route('acctsetting-edit')}}" method="post">
                            		@csrf
                            		<div class="row">
                            			<div class="col-md-3">
											<ul class="nav flex-column nav-pills mb-3" id="v-pills-tab1" role="tablist" aria-orientation="vertical">
												<li class="nav-item">
													<a class="nav-link active" id="inventory-tab2" data-bs-toggle="pill" href="#inventory" role="tab" aria-controls="inventory" aria-selected="true">Inventory</a>
												</li>
												<li class="nav-item">
													<a class="nav-link" id="pembelian-tab2" data-bs-toggle="pill" href="#pembelian" role="tab" aria-controls="pembelian" aria-selected="true">
														Pembelian
													</a>
												</li>
												<li class="nav-item">
													<a class="nav-link" id="penjualan-tab2" data-bs-toggle="pill" href="#penjualan" role="tab" aria-controls="penjualan" aria-selected="true">
														Penjualan
													</a>
												</li>
												<li class="nav-item">
													<a class="nav-link" id="konsinyasi-tab2" data-bs-toggle="pill" href="#konsinyasi" role="tab" aria-controls="konsinyasi" aria-selected="false">Konsinyasi</a>
												</li>
												<li class="nav-item">
													<a class="nav-link" id="lainlain-tab2" data-bs-toggle="pill" href="#lainlain" role="tab" aria-controls="lainlain" aria-selected="false">Lain Lain</a>
												</li>
											</ul>
                                        </div>

                                        <div class="col-md-9">
                                        	<div class="tab-content" id="v-pills-tabContent">
                                        		<div class="tab-pane show active" id="inventory" role="tabpanel" aria-labelledby="inventory-tab">
                                        			<div class="form-group row">
                                        				<div class="col-md-9">
                                        					<label >Harga Pokok Penjualan</label>
                                        					<fieldset class="form-group mb-3">
                                        						<select class="js-example-basic-single js-states form-control bg-transparent" name="InvAcctHargaPokokPenjualan" id="InvAcctHargaPokokPenjualan">
																	<option value="">Pilih Akun</option>
																	@foreach($account as $ko)
																		<option 
				                                                            value="{{ $ko->KodeRekening }}"
				                                                            {{ count($settingakun) > 0 ? $settingakun[0]['InvAcctHargaPokokPenjualan'] == $ko->KodeRekening ? "selected" : '' :""}}>
				                                                            {{ $ko->NamaRekening }}
				                                                        </option>
																	@endforeach
																</select>
                                        					</fieldset>
                                        				</div>

                                        				<div class="col-md-9">
                                        					<label >Pendapatan Penjualan</label>
                                        					<fieldset class="form-group mb-3">
                                        						<select class="js-example-basic-single js-states form-control bg-transparent" name="InvAcctPendapatanJual" id="InvAcctPendapatanJual">
																	<option value="">Pilih Akun</option>
																	@foreach($account as $ko)
																		<option 
				                                                            value="{{ $ko->KodeRekening }}"
				                                                            {{ count($settingakun) > 0 ? $settingakun[0]['InvAcctPendapatanJual'] == $ko->KodeRekening ? "selected" : '' :""}}>
				                                                            {{ $ko->NamaRekening }}
				                                                        </option>
																	@endforeach
																</select>
                                        					</fieldset>
                                        				</div>

                                        				<div class="col-md-9">
                                        					<label >Pendapatan Jasa</label>
                                        					<fieldset class="form-group mb-3">
                                        						<select class="js-example-basic-single js-states form-control bg-transparent" name="InvAcctPendapatanJasa" id="InvAcctPendapatanJasa">
																	<option value="">Pilih Akun</option>
																	@foreach($account as $ko)
																		<option 
				                                                            value="{{ $ko->KodeRekening }}"
				                                                            {{ count($settingakun) > 0 ? $settingakun[0]['InvAcctPendapatanJasa'] == $ko->KodeRekening ? "selected" : '' :""}}>
				                                                            {{ $ko->NamaRekening }}
				                                                        </option>
																	@endforeach
																</select>
                                        					</fieldset>
                                        				</div>

                                        				<div class="col-md-9">
                                        					<label >Persediaan</label>
                                        					<fieldset class="form-group mb-3">
                                        						<select class="js-example-basic-single js-states form-control bg-transparent" name="InvAcctPersediaan" id="InvAcctPersediaan">
																	<option value="">Pilih Akun</option>
																	@foreach($account as $ko)
																		<option 
				                                                            value="{{ $ko->KodeRekening }}"
				                                                            {{ count($settingakun) > 0 ? $settingakun[0]['InvAcctPersediaan'] == $ko->KodeRekening ? "selected" : '' :""}}>
				                                                            {{ $ko->NamaRekening }}
				                                                        </option>
																	@endforeach
																</select>
                                        					</fieldset>
                                        				</div>

                                        				<div class="col-md-9">
                                        					<label >Pendapatan Non Inventory</label>
                                        					<fieldset class="form-group mb-3">
                                        						<select class="js-example-basic-single js-states form-control bg-transparent" name="InvAcctPendapatanNonInventory" id="InvAcctPendapatanNonInventory">
																	<option value="">Pilih Akun</option>
																	@foreach($account as $ko)
																		<option 
				                                                            value="{{ $ko->KodeRekening }}"
				                                                            {{ count($settingakun) > 0 ? $settingakun[0]['InvAcctPendapatanNonInventory'] == $ko->KodeRekening ? "selected" : '' :""}}>
				                                                            {{ $ko->NamaRekening }}
				                                                        </option>
																	@endforeach
																</select>
                                        					</fieldset>
                                        				</div>

                                        				<div class="col-md-9">
                                        					<label >Pendapatan Lain Lain</label>
                                        					<fieldset class="form-group mb-3">
                                        						<select class="js-example-basic-single js-states form-control bg-transparent" name="InvAcctPendapatanLainLain" id="InvAcctPendapatanLainLain">
																	<option value="">Pilih Akun</option>
																	@foreach($account as $ko)
																		<option 
				                                                            value="{{ $ko->KodeRekening }}"
				                                                            {{ count($settingakun) > 0 ? $settingakun[0]['InvAcctPendapatanLainLain'] == $ko->KodeRekening ? "selected" : '' :""}}>
				                                                            {{ $ko->NamaRekening }}
				                                                        </option>
																	@endforeach
																</select>
                                        					</fieldset>
                                        				</div>

                                        				<div class="col-md-9">
                                        					<label >Penyesuaan Stock Masuk</label>
                                        					<fieldset class="form-group mb-3">
                                        						<select class="js-example-basic-single js-states form-control bg-transparent" name="InvAcctPenyesuaiaanStockMasuk" id="InvAcctPenyesuaiaanStockMasuk">
																	<option value="">Pilih Akun</option>
																	@foreach($account as $ko)
																		<option 
				                                                            value="{{ $ko->KodeRekening }}"
				                                                            {{ count($settingakun) > 0 ? $settingakun[0]['InvAcctPenyesuaiaanStockMasuk'] == $ko->KodeRekening ? "selected" : '' :""}}>
				                                                            {{ $ko->NamaRekening }}
				                                                        </option>
																	@endforeach
																</select>
                                        					</fieldset>
                                        				</div>

                                        				<div class="col-md-9">
                                        					<label >Penyesuaan Stock Keluar</label>
                                        					<fieldset class="form-group mb-3">
                                        						<select class="js-example-basic-single js-states form-control bg-transparent" name="InvAcctPenyesuaiaanStockKeluar" id="InvAcctPenyesuaiaanStockKeluar">
																	<option value="">Pilih Akun</option>
																	@foreach($account as $ko)
																		<option 
				                                                            value="{{ $ko->KodeRekening }}"
				                                                            {{ count($settingakun) > 0 ? $settingakun[0]['InvAcctPenyesuaiaanStockKeluar'] == $ko->KodeRekening ? "selected" : '' :""}}>
				                                                            {{ $ko->NamaRekening }}
				                                                        </option>
																	@endforeach
																</select>
                                        					</fieldset>
                                        				</div>

                                        			</div>
                                        		</div>

                                        		<div class="tab-pane" id="pembelian" role="tabpanel" aria-labelledby="pembelian-tab">
                                        			<div class="form-group row">
                                        				<div class="col-md-9">
                                        					<label >Pajak Pembelian</label>
                                        					<fieldset class="form-group mb-3">
                                        						<select class="js-example-basic-single js-states form-control bg-transparent" name="PbAcctPajakPembelian" id="PbAcctPajakPembelian">
																	<option value="">Pilih Akun</option>
																	@foreach($account as $ko)
																		<option 
				                                                            value="{{ $ko->KodeRekening }}"
				                                                            {{ count($settingakun) > 0 ? $settingakun[0]['PbAcctPajakPembelian'] == $ko->KodeRekening ? "selected" : '' :""}}>
				                                                            {{ $ko->NamaRekening }}
				                                                        </option>
																	@endforeach
																</select>
                                        					</fieldset>
                                        				</div>

                                        				<div class="col-md-9">
                                        					<label >Pembayaran Pembelian Tunai</label>
                                        					<fieldset class="form-group mb-3">
                                        						<select class="js-example-basic-single js-states form-control bg-transparent" name="PbAcctPembayaranTunai" id="PbAcctPembayaranTunai">
																	<option value="">Pilih Akun</option>
																	@foreach($account as $ko)
																		<option 
				                                                            value="{{ $ko->KodeRekening }}"
				                                                            {{ count($settingakun) > 0 ? $settingakun[0]['PbAcctPembayaranTunai'] == $ko->KodeRekening ? "selected" : '' :""}}>
				                                                            {{ $ko->NamaRekening }}
				                                                        </option>
																	@endforeach
																</select>
                                        					</fieldset>
                                        				</div>

                                        				<div class="col-md-9">
                                        					<label >Pembayaran Pembelian Non Tunai</label>
                                        					<fieldset class="form-group mb-3">
                                        						<select class="js-example-basic-single js-states form-control bg-transparent" name="PbAcctPembayaranNonTunai" id="PbAcctPembayaranNonTunai">
																	<option value="">Pilih Akun</option>
																	@foreach($account as $ko)
																		<option 
				                                                            value="{{ $ko->KodeRekening }}"
				                                                            {{ count($settingakun) > 0 ? $settingakun[0]['PbAcctPembayaranNonTunai'] == $ko->KodeRekening ? "selected" : '' :""}}>
				                                                            {{ $ko->NamaRekening }}
				                                                        </option>
																	@endforeach
																</select>
                                        					</fieldset>
                                        				</div>

                                        				<div class="col-md-9">
                                        					<label >Akun Hutang</label>
                                        					<fieldset class="form-group mb-3">
                                        						<select class="js-example-basic-single js-states form-control bg-transparent" name="PbAcctHutang" id="PbAcctHutang">
																	<option value="">Pilih Akun</option>
																	@foreach($account as $ko)
																		<option 
				                                                            value="{{ $ko->KodeRekening }}"
				                                                            {{ count($settingakun) > 0 ? $settingakun[0]['PbAcctHutang'] == $ko->KodeRekening ? "selected" : '' :""}}>
				                                                            {{ $ko->NamaRekening }}
				                                                        </option>
																	@endforeach
																</select>
                                        					</fieldset>
                                        				</div>

                                        				<div class="col-md-9">
                                        					<label >Akun Uang Muka Pembelian</label>
                                        					<fieldset class="form-group mb-3">
                                        						<select class="js-example-basic-single js-states form-control bg-transparent" name="PbAcctUangMukaPembelian" id="PbAcctUangMukaPembelian">
																	<option value="">Pilih Akun</option>
																	@foreach($account as $ko)
																		<option 
				                                                            value="{{ $ko->KodeRekening }}"
				                                                            {{ count($settingakun) > 0 ? $settingakun[0]['PbAcctUangMukaPembelian'] == $ko->KodeRekening ? "selected" : '' :""}}>
				                                                            {{ $ko->NamaRekening }}
				                                                        </option>
																	@endforeach
																</select>
                                        					</fieldset>
                                        				</div>

                                        			</div>
                                        		</div>

                                        		<div class="tab-pane" id="penjualan" role="tabpanel" aria-labelledby="penjualan-tab">
                                        			<div class="form-group row">
                                        				<div class="col-md-9">
                                        					<label >Pajak Penjualan</label>
                                        					<fieldset class="form-group mb-3">
                                        						<select class="js-example-basic-single js-states form-control bg-transparent" name="PjAcctPajakPenjualan" id="PjAcctPajakPenjualan">
																	<option value="">Pilih Akun</option>
																	@foreach($account as $ko)
																		<option 
				                                                            value="{{ $ko->KodeRekening }}"
				                                                            {{ count($settingakun) > 0 ? $settingakun[0]['PjAcctPajakPenjualan'] == $ko->KodeRekening ? "selected" : '' :""}}>
				                                                            {{ $ko->NamaRekening }}
				                                                        </option>
																	@endforeach
																</select>
                                        					</fieldset>
                                        				</div>

                                        				<div class="col-md-9">
                                        					<label >Pembayaran Penjualan Tunai</label>
                                        					<fieldset class="form-group mb-3">
                                        						<select class="js-example-basic-single js-states form-control bg-transparent" name="PjAcctPenjualanTunai" id="PjAcctPenjualanTunai">
																	<option value="">Pilih Akun</option>
																	@foreach($account as $ko)
																		<option 
				                                                            value="{{ $ko->KodeRekening }}"
				                                                            {{ count($settingakun) > 0 ? $settingakun[0]['PjAcctPenjualanTunai'] == $ko->KodeRekening ? "selected" : '' :""}}>
				                                                            {{ $ko->NamaRekening }}
				                                                        </option>
																	@endforeach
																</select>
                                        					</fieldset>
                                        				</div>

                                        				<div class="col-md-9">
                                        					<label >Pembayaran Penjualan Non Tunai</label>
                                        					<fieldset class="form-group mb-3">
                                        						<select class="js-example-basic-single js-states form-control bg-transparent" name="PjAcctPenjualanNonTunai" id="PjAcctPenjualanNonTunai">
																	<option value="">Pilih Akun</option>
																	@foreach($account as $ko)
																		<option 
				                                                            value="{{ $ko->KodeRekening }}"
				                                                            {{ count($settingakun) > 0 ? $settingakun[0]['PjAcctPenjualanNonTunai'] == $ko->KodeRekening ? "selected" : '' :""}}>
				                                                            {{ $ko->NamaRekening }}
				                                                        </option>
																	@endforeach
																</select>
                                        					</fieldset>
                                        				</div>

                                        				<div class="col-md-9">
                                        					<label >Akun Piutang</label>
                                        					<fieldset class="form-group mb-3">
                                        						<select class="js-example-basic-single js-states form-control bg-transparent" name="PjAcctPiutang" id="PjAcctPiutang">
																	<option value="">Pilih Akun</option>
																	@foreach($account as $ko)
																		<option 
				                                                            value="{{ $ko->KodeRekening }}"
				                                                            {{ count($settingakun) > 0 ? $settingakun[0]['PjAcctPiutang'] == $ko->KodeRekening ? "selected" : '' :""}}>
				                                                            {{ $ko->NamaRekening }}
				                                                        </option>
																	@endforeach
																</select>
                                        					</fieldset>
                                        				</div>

                                        				<div class="col-md-9">
                                        					<label >Akun Uang Muka Penjualan</label>
                                        					<fieldset class="form-group mb-3">
                                        						<select class="js-example-basic-single js-states form-control bg-transparent" name="PjAcctUangMukaPenjualan" id="PjAcctUangMukaPenjualan">
																	<option value="">Pilih Akun</option>
																	@foreach($account as $ko)
																		<option 
				                                                            value="{{ $ko->KodeRekening }}"
				                                                            {{ count($settingakun) > 0 ? $settingakun[0]['PjAcctUangMukaPenjualan'] == $ko->KodeRekening ? "selected" : '' :""}}>
				                                                            {{ $ko->NamaRekening }}
				                                                        </option>
																	@endforeach
																</select>
                                        					</fieldset>
                                        				</div>
                                        			</div>
                                        		</div>

                                        		<div class="tab-pane" id="konsinyasi" role="tabpanel" aria-labelledby="konsinyasi-tab">
                                        			<div class="form-group row">
                                        				<div class="col-md-9">
                                        					<label >Hutang Konsinyasi</label>
                                        					<fieldset class="form-group mb-3">
                                        						<select class="js-example-basic-single js-states form-control bg-transparent" name="KnAcctHutangKonsinyasi" id="KnAcctHutangKonsinyasi">
																	<option value="">Pilih Akun</option>
																	@foreach($account as $ko)
																		<option 
				                                                            value="{{ $ko->KodeRekening }}"
				                                                            {{ count($settingakun) > 0 ? $settingakun[0]['KnAcctHutangKonsinyasi'] == $ko->KodeRekening ? "selected" : '' :""}}>
				                                                            {{ $ko->NamaRekening }}
				                                                        </option>
																	@endforeach
																</select>
                                        					</fieldset>
                                        				</div>

                                        				<div class="col-md-9">
                                        					<label >Pembayaran Hutang Konsinyasi</label>
                                        					<fieldset class="form-group mb-3">
                                        						<select class="js-example-basic-single js-states form-control bg-transparent" name="KnAcctPembayaranHutang" id="KnAcctPembayaranHutang">
																	<option value="">Pilih Akun</option>
																	@foreach($account as $ko)
																		<option 
				                                                            value="{{ $ko->KodeRekening }}"
				                                                            {{ count($settingakun) > 0 ? $settingakun[0]['KnAcctPembayaranHutang'] == $ko->KodeRekening ? "selected" : '' :""}}>
				                                                            {{ $ko->NamaRekening }}
				                                                        </option>
																	@endforeach
																</select>
                                        					</fieldset>
                                        				</div>

                                        			</div>
                                        		</div>

                                        		<div class="tab-pane" id="lainlain" role="tabpanel" aria-labelledby="lainlain-tab">
                                        			<div class="form-group row">
                                        				<div class="col-md-9">
                                        					<label >Modal</label>
                                        					<fieldset class="form-group mb-3">
                                        						<select class="js-example-basic-single js-states form-control bg-transparent" name="OthAcctModal" id="OthAcctModal">
																	<option value="">Pilih Akun</option>
																	@foreach($account as $ko)
																		<option 
				                                                            value="{{ $ko->KodeRekening }}"
				                                                            {{ count($settingakun) > 0 ? $settingakun[0]['OthAcctModal'] == $ko->KodeRekening ? "selected" : '' :""}}>
				                                                            {{ $ko->NamaRekening }}
				                                                        </option>
																	@endforeach
																</select>
                                        					</fieldset>
                                        				</div>

                                        				<div class="col-md-9">
                                        					<label >Prive</label>
                                        					<fieldset class="form-group mb-3">
                                        						<select class="js-example-basic-single js-states form-control bg-transparent" name="OthAcctPrive" id="OthAcctPrive">
																	<option value="">Pilih Akun</option>
																	@foreach($account as $ko)
																		<option 
				                                                            value="{{ $ko->KodeRekening }}"
				                                                            {{ count($settingakun) > 0 ? $settingakun[0]['OthAcctPrive'] == $ko->KodeRekening ? "selected" : '' :""}}>
				                                                            {{ $ko->NamaRekening }}
				                                                        </option>
																	@endforeach
																</select>
                                        					</fieldset>
                                        				</div>

                                        				<div class="col-md-9">
                                        					<label >Laba Ditahan</label>
                                        					<fieldset class="form-group mb-3">
                                        						<select class="js-example-basic-single js-states form-control bg-transparent" name="OthAcctLabaDitahan" id="OthAcctLabaDitahan">
																	<option value="">Pilih Akun</option>
																	@foreach($account as $ko)
																		<option 
				                                                            value="{{ $ko->KodeRekening }}"
				                                                            {{ count($settingakun) > 0 ? $settingakun[0]['OthAcctLabaDitahan'] == $ko->KodeRekening ? "selected" : '' :""}}>
				                                                            {{ $ko->NamaRekening }}
				                                                        </option>
																	@endforeach
																</select>
                                        					</fieldset>
                                        				</div>

                                        				<div class="col-md-9">
                                        					<label >Laba Tahun Berjalan</label>
                                        					<fieldset class="form-group mb-3">
                                        						<select class="js-example-basic-single js-states form-control bg-transparent" name="OthAcctLabaTahunBerjalan" id="OthAcctLabaTahunBerjalan">
																	<option value="">Pilih Akun</option>
																	@foreach($account as $ko)
																		<option 
				                                                            value="{{ $ko->KodeRekening }}"
				                                                            {{ count($settingakun) > 0 ? $settingakun[0]['OthAcctLabaTahunBerjalan'] == $ko->KodeRekening ? "selected" : '' :""}}>
				                                                            {{ $ko->NamaRekening }}
				                                                        </option>
																	@endforeach
																</select>
                                        					</fieldset>
                                        				</div>

                                        			</div>
                                        		</div>

                                        	</div>
                                        </div>
                                        <div class="col-md-3">

                                        </div>
                                        <div class="col-md-9">
                                        	<button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                            		</div>

                            	</form>
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
	$(function () {
		$(document).ready(function () {
			$('#LevelHarga').select2();
		})
	})
</script>
@endpush