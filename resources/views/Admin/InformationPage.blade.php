@extends('parts.header')

@section('content')

<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white mb-0 px-0 py-2">
                <li class="breadcrumb-item active" aria-current="page">Daftar Informasi</li>
            </ol>
        </nav>
    </div>
</div>
<!--end::Subheader-->

<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 px-4">
                <div class="row">
                    <div class="col-lg-12 col-xl-12 px-4">
                        <div class="card card-custom gutter-b bg-transparent shadow-none border-0">
                            <div class="card-header align-items-center border-bottom-dark px-0">
                                <div class="card-title mb-0">
                                    <h3 class="card-label mb-0 font-weight-bold text-body">Daftar Informasi</h3>
                                </div>
                                <div class="icons d-flex">
                                    <a href="{{ url('faq/form/-') }}" class="btn btn-outline-primary rounded-pill font-weight-bold me-1 mb-1">Tambah Informasi</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TABEL -->
                <div class="row">
                    <div class="col-12 px-4">
                        <div class="card card-custom gutter-b bg-white border-0">
                            <div class="card-body">
                                <div class="table-responsive" id="printableTable">
                                    <table id="orderTable" class="display" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Judul</th>
                                                <th>Tanggal</th>
                                                <th>Kategori</th>
                                                <th>Status</th>
                                                <th class="no-sort text-end">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($listinformasi) > 0)
                                                @foreach($listinformasi as $info)
                                                    <tr>
                                                        <td>{{ $info['Judul'] }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($info['Tanggal'])->format('d M Y') }}</td>
                                                        <td>{{ $info['Kategori'] }}</td>
                                                        <td>{{ $info['Status'] }}</td>
                                                        <td>
                                                            <div class="card-toolbar text-end">
                                                                <button class="btn p-0 shadow-none" type="button" id="dropdownAction{{ $loop->index }}" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <span class="svg-icon">
                                                                        <svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-three-dots text-body" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                                            <path fill-rule="evenodd" d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"></path>
                                                                        </svg>
                                                                    </span>
                                                                </button>
                                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownAction{{ $loop->index }}">
                                                                    <a class="dropdown-item" href="{{ url('faq/form/' . $info['id']) }}">Edit</a>
                                                                    <a class="dropdown-item" title="Delete" href="{{ route('faq-delete', $info['id']) }}" data-confirm-delete="true">Delete</a>
                                                                </div>
                                                            </div>
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
                <!-- END TABEL -->
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
            "columnDefs": [{
                "targets": 'no-sort',
                "orderable": false,
            }]
        });
    });
</script>
@endpush
