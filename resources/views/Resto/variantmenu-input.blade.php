@extends('parts.header')
	
@section('content')

<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">
					<a href="{{route('grupvariant')}}">Grup Variant</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Input Grup Variant</li>
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
                                        @if (count($variantheader)> 0)
                                            Edit Grup Variant
                                        @else
                                            Tambah Grup Variant
                                        @endif
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
                                @if (count($variantheader)> 0)
                                <form action="{{route('grupvariant-edit')}}" method="post">
                                @else
                                <form action="{{route('grupvariant-store')}}" method="post">
                                @endif
                            		@csrf
	                            	<div class="form-group row">
                                        <div class="col-md-3">
	                            			<label  class="text-body">Tipe Pilihan Grup Variant</label>
	                            			<fieldset class="form-group mb-3">
	                            				<select name="OpsiPilihan" id="OpsiPilihan" class="js-example-basic-single js-states form-control bg-transparent" required>
                                                    <option value="Single">Single</option>
                                                    <option value="Multiple">Multiple</option>
                                                    <option value="Optional">Optional</option>
                                                </select>
                                                <input type="hidden" id="id" name="id">
	                            			</fieldset>
	                            		</div>
	                            		<div class="col-md-8">
	                            			<label  class="text-body">Nama Grup Variant</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="text" class="form-control" id="NamaGrup" name="NamaGrup" placeholder="Isikan Nama Grup Varian"  required>
	                            			</fieldset>
	                            		</div>
                                        <div class="col-md-12">
                                            <strong>Pilihan Variant</strong> <br>
                                            <small>Anda dapat menambahankan pilihan varian dan menambahkan harga jika diperlukan</small>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="table-responsive" id="printableTable">
                                                <table id="VariantTable" class="display" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Nama Varian</th>
                                                            <th>Tambahan Harga</th>
                                                            <th class=" no-sort text-end">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="AppendArea">
                                                        <tr>
                                                            <td colspan="3" id="btAddRow">
                                                                <center><i class="fas fa-plus" style="color: red"></i> <font style="color: red"> Tambah Data</font> </center>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
	                            		<div class="col-md-12">
	                            			<button type="submit" class="btn btn-success text-white font-weight-bold me-1 mb-1">Simpan</button>
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
    var rowIndex = 0;
    var dataHeader = [];
    var dataDetail = [];
	$(function () {
		$(document).ready(function () {
            dataHeader = <?php echo json_encode($variantheader); ?>;
            dataDetail = <?php echo json_encode($variantdetail); ?>;

            // console.log(dataHeader)
            if (dataHeader.length > 0) {
                jQuery('#OpsiPilihan').val(dataHeader[0]['OpsiPilihan']).trigger('change');
                jQuery('#NamaGrup').val(dataHeader[0]['NamaGrup']);
                jQuery('#id').val(dataHeader[0]['id']);

                for (let index = 0; index < dataDetail.length; index++) {
                    // const element = array[index];
                    addNewLine(dataDetail[index]['NamaVariant'],dataDetail[index]['ExtraPrice']);
                    
                }
            }
            jQuery('#VariantTable').DataTable();
		});

        jQuery('#btAddRow').click(function () {
            addNewLine('',0);
        });
        $('.btn btn-danger RemoveLineItem').click(function() {
            alert('Data')
            // event.preventDefault();
            var href = jQuery(this).attr('href');
            console.log(href)
        });

        function addNewLine(Name, ExtraPrice) {
            // Generate random text for Row ID
            var RandomID = generateRandomText(10);
            var newRow = document.createElement('tr');
            newRow.className = RandomID;
            var VarianNameCol = document.createElement('td');
            var ExtraPriceCol = document.createElement('td');
            var RemoveCol = document.createElement('td');

            var VariantNameText = document.createElement('input');
            VariantNameText.type  = 'text';
            VariantNameText.name = 'txtVariantName['+rowIndex+'][Name]';
            VariantNameText.placeholder = "Tambah Varian Menu";
            VariantNameText.className = 'form-control';
            VariantNameText.required = true;
            VariantNameText.value = Name;
            VarianNameCol.appendChild(VariantNameText);

            var ExtraPriceText = document.createElement('input');
            ExtraPriceText.type  = 'number';
            ExtraPriceText.name = 'txtVariantName['+rowIndex+'][ExtraCost]';
            ExtraPriceText.placeholder = "Tambah Extra  Price";
            ExtraPriceText.className = 'form-control';
            ExtraPriceText.value = ExtraPrice;
            ExtraPriceText.required = true;
            ExtraPriceCol.appendChild(ExtraPriceText);

            var RemoveText = document.createElement('button');
            RemoveText.innerText   = 'Delete Data';
            RemoveText.type   = 'button';
            // RemoveText.style.color = "red";
            // RemoveText.href = "#"+RandomID;
            RemoveText.className = "btn btn-danger RemoveLineItem";
            RemoveText.id = "RemoveLineItem";
            RemoveText.onclick = function() {
                // alert('Button in row  clicked! ' + RandomID);
                var elements = document.querySelectorAll('.'+RandomID);
                // elements.remove();
                elements.forEach(function(element) {
                    element.remove();
                });
                // console.log(elements)
            };
            RemoveCol.appendChild(RemoveText);

            newRow.appendChild(VarianNameCol);
            newRow.appendChild(ExtraPriceCol);
            newRow.appendChild(RemoveCol);
            document.getElementById('AppendArea').appendChild(newRow);

            rowIndex += 1;
        }
        function RemoveLine(Index) {
            
        }

        function generateRandomText(length) {
            const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            let randomText = '';
            for (let i = 0; i < length; i++) {
                const randomIndex = Math.floor(Math.random() * characters.length);
                randomText += characters[randomIndex];
            }
            return randomText;
        }
	})
</script>
@endpush