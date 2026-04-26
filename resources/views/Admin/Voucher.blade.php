@extends('parts.header')

@section('content')

<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white mb-0 px-0 py-2">
                <li class="breadcrumb-item active" aria-current="page">Manajemen Voucher</li>
            </ol>
        </nav>
    </div>
</div>
<!--end::Subheader-->

<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        <div class="row">

            <!-- Page Header -->
            <div class="col-lg-12 col-xl-12 px-4">
                <div class="card card-custom gutter-b bg-transparent shadow-none border-0">
                    <div class="card-header align-items-center border-bottom-dark px-0">
                        <div class="card-title mb-0">
                            <h3 class="card-label mb-0 font-weight-bold text-body">Manajemen Voucher</h3>
                        </div>
                        <div class="icons d-flex">
                            <a href="{{ url('voucher/form/-') }}" class="btn btn-outline-primary rounded-pill font-weight-bold me-1 mb-1">
                                <i class="bi bi-plus-lg me-1"></i> Tambah Voucher
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table Card -->
            <div class="col-12 px-4">
                <div class="card card-custom gutter-b bg-white border-0">
                    <div class="card-body">
                        <div class="table-responsive" id="printableTable">
                            <table id="voucherTable" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Kode Voucher</th>
                                        <th>Tipe</th>
                                        <th>Nilai</th>
                                        <th>Maks. Diskon</th>
                                        <th>Limit Penggunaan</th>
                                        <th>Terpakai</th>
                                        <th>Berlaku Hingga</th>
                                        <th>Status</th>
                                        <th class="no-sort text-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($vouchers as $v)
                                    <tr>
                                        <td><strong>{{ $v->code }}</strong></td>
                                        <td>
                                            @if($v->type === 'percentage')
                                                <span class="badge bg-info text-white">Persentase</span>
                                            @else
                                                <span class="badge bg-secondary text-white">Nominal</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($v->type === 'percentage')
                                                {{ number_format($v->value, 0) }}%
                                            @else
                                                Rp {{ number_format($v->value, 0, ',', '.') }}
                                            @endif
                                        </td>
                                        <td>
                                            @if($v->max_discount)
                                                Rp {{ number_format($v->max_discount, 0, ',', '.') }}
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($v->usage_limit)
                                                {{ $v->usage_limit }}
                                            @else
                                                <span class="text-muted">Tak terbatas</span>
                                            @endif
                                        </td>
                                        <td>{{ $v->used_count }}</td>
                                        <td>
                                            @if($v->expires_at)
                                                {{ \Carbon\Carbon::parse($v->expires_at)->format('d/m/Y') }}
                                                @if(\Carbon\Carbon::parse($v->expires_at)->isPast())
                                                    <span class="badge bg-danger text-white ms-1">Kedaluwarsa</span>
                                                @endif
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input toggle-active" type="checkbox"
                                                    data-id="{{ $v->id }}"
                                                    {{ $v->is_active ? 'checked' : '' }}>
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ url('voucher/form/' . $v->id) }}"
                                               class="btn btn-outline-primary btn-sm" title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <form action="{{ route('voucher-delete', $v->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-muted py-4">Belum ada data voucher.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!--end::Entry-->

@endsection

@push('scripts')
<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery('#voucherTable').DataTable({
            "pagingType": "simple_numbers",
            "columnDefs": [{
                "targets": 'no-sort',
                "orderable": false
            }]
        });

        // Toggle aktif/nonaktif via AJAX
        jQuery(document).on('change', '.toggle-active', function () {
            const id      = jQuery(this).data('id');
            const checked = jQuery(this);

            jQuery.ajax({
                url: '/voucher/toggle/' + id,
                type: 'POST',
                data: { _token: '{{ csrf_token() }}' },
                success: function (res) {
                    if (!res.success) {
                        checked.prop('checked', !checked.prop('checked'));
                        Swal.fire('Error', res.message || 'Gagal mengubah status.', 'error');
                    }
                },
                error: function () {
                    checked.prop('checked', !checked.prop('checked'));
                    Swal.fire('Error', 'Terjadi kesalahan.', 'error');
                }
            });
        });
    });
</script>
@endpush
