@extends('parts.header')
	
@section('content')

<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">Log Aktifitas</li>
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
									<h3 class="card-label mb-0 font-weight-bold text-body">Log Aktivitas
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
								<div class="table-responsive" id="printableTable">
									<table id="orderTable" class="display" style="width:100%">
										<thead>
											<tr>
												<th>Nama Tabel</th>
												<th>Action</th>
                                                <th>User</th>
                                                <th>IP Address</th>
												<th>URL Endpoint</th>
                                                <th>TimeStamp</th>
                                                <th class=" no-sort text-end">Action</th>
											</tr>
										</thead>
										<tbody>
											@if (count($oData) > 0)
												@foreach ($oData as $v)
													<tr>
														<td>{{ $v['table'] }}</td>
														<td>{{ $v['action'] }}</td>
														<td>{{ $v['user_name'] }}</td>
														<td>{{ $v['ip'] }}</td>
														<td>{{ $v['url'] }}</td>
                                                        <td>{{ $v['created_at'] }}</td>
                                                        <td>
                                                            @if ($v['action'] == 'updated')
                                                                <button class='btn btn-outline-success font-weight-bold me-1 mb-1' data-bs-toggle="modal" data-bs-target="#logDetailModal" data-log="{{ json_encode($v) }}"><i class='fas fa-eye'></i></button>
                                                            @endif
                                                        </td>

													</tr>
												@endforeach
											@endif
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
		</div>
	</div>
	
</div>

<!-- Modal -->
<div class="modal fade" id="logDetailModal" tabindex="-1" role="dialog" aria-labelledby="logDetailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="logDetailModalLabel">Log Details</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-6">
                <h6>Old Data</h6>
                <pre id="old-data-content"></pre>
            </div>
            <div class="col-6">
                <h6>New Data</h6>
                <pre id="new-data-content"></pre>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('#orderTable').DataTable({
			"pagingType": "simple_numbers",
	  
		"columnDefs": [ {
		  "targets"  : 'no-sort',
		  "orderable": false,
		}]
		});

        jQuery('#logDetailModal').on('show.bs.modal', function (event) {
            var button = jQuery(event.relatedTarget); // Button that triggered the modal
            var log = button.data('log'); // Extract info from data-* attributes
            
            var modal = jQuery(this);
            modal.find('.modal-title').text('Log Details for Table: ' + log.table + ' (ID: ' + log.id + ')');

            var beforeText = '';
            var afterText = '';

            try {
                // The 'changes' property might be a string that needs to be parsed
                var changes = typeof log.changes === 'string' ? JSON.parse(log.changes) : log.changes;

                for (var key in changes) {
                    if (changes.hasOwnProperty(key)) {
                        var change = changes[key];
                        var from = change.from !== null ? change.from : 'null';
                        var to = change.to !== null ? change.to : 'null';

                        beforeText += key + ': ' + from + '\n';
                        afterText += key + ': ' + to + '\n';
                    }
                }
            } catch (e) {
                beforeText = 'Error parsing changes data.';
                afterText = 'Error parsing changes data.';
                console.error('Error parsing log.changes:', e);
            }

            modal.find('#old-data-content').text(beforeText.trim());
            modal.find('#new-data-content').text(afterText.trim());
        });
	} );
</script>
@endpush