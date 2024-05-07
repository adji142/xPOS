@extends('parts.header')
	
@section('content')

<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">Penomoran Dokumen</li>
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
									<h3 class="card-label mb-0 font-weight-bold text-body">Penomoran Dokumen 
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
								<div class="dx-viewport demo-container">
				                	<div id="data-grid-demo">
				                  		<div id="gridContainerDocNum"></div>
				                  		<small style="color: red">Tekan Enter saat selesai edit data</small>
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

@endsection

@push('scripts')
<script type="text/javascript">
	jQuery(document).ready(function() {
		getData()
	});

	function getData() {
		$.ajax({
      		async:false,
      		type: 'post',
			url: "{{route('docnum-ViewJson')}}",
			headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
            },
            data: {},
            dataType: 'json',
            success: function(response) {
            	bindGrid(response.data)
            }
		})
	}

	function bindGrid(data) {
		var dataGridInstance = jQuery("#gridContainerDocNum").dxDataGrid({
			allowColumnResizing: true,
			dataSource: data,
			keyExpr: "KodeDokumen",
			showBorders: true,
            allowColumnReordering: true,
            allowColumnResizing: true,
            columnAutoWidth: true,
            showBorders: true,
            paging: {
                enabled: true,
                pageSize: 30
            },
            editing: {
                mode: "cell",
                // allowAdding:true,
                allowUpdating: true,
                texts: {
                    confirmDeleteMessage: ''  
                }
            },
            searchPanel: {
	            visible: true,
	            width: 240,
	            placeholder: "Search..."
	        },
            columns: [
                {
                    dataField: "KodeDokumen",
                    caption: "KodeDokumen",
                    allowEditing:false,
                    visible:false
                },
                {
                    dataField: "NamaDokumen",
                    caption: "Dokumen",
                    allowEditing:false
                },
                {
                    dataField: "prefix",
                    caption: "Prefix",
                    allowEditing:true
                },
                {
                    dataField: "NumberLength",
                    caption: "Panjang Penomoran",
                    allowEditing:true,
                    dataType:"number"
                },
            ],
            onRowUpdated:function (e) {
            	console.log(e);
            	$.ajax({
		      		async:false,
		      		type: 'POST',
					url: "{{route('docnum-store')}}",
					headers: {
		                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
		            },
		            data: {
		            	'DocumentID' : e.key,
		            	'prefix' : e.data.prefix,
		            	'NumberLength' : e.data.NumberLength
		            },
		            dataType: 'json',
		            success: function(response) {
		            	if (response.success == true) {
				            Swal.fire({
				              type: 'success',
				              title: 'Horay',
				              text: 'Data Berhasil Disimpan',
				            }).then((result)=>{
			      				location.reload();
				            });
		            	}
		            	else{
		            		Swal.fire({
				              type: 'error',
				              title: 'woopss',
				              text: 'Gagal Menyimpan Data ' + response.message,
				            });
		            	}
		            }
				})
            }
		});
	}
</script>
@endpush