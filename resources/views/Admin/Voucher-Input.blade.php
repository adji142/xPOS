@extends('parts.header')

@section('content')

<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white mb-0 px-0 py-2">
                <li class="breadcrumb-item">
                    <a href="{{ url('voucher') }}">Manajemen Voucher</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $voucher ? 'Edit Voucher' : 'Tambah Voucher' }}
                </li>
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
                            <h3 class="card-label mb-0 font-weight-bold text-body">
                                {{ $voucher ? 'Edit Voucher' : 'Tambah Voucher' }}
                            </h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Card -->
            <div class="col-12 px-4">
                <div class="card card-custom gutter-b bg-white border-0">
                    <div class="card-body">

                        <form action="{{ $voucher ? route('voucher-edit') : route('voucher-store') }}" method="POST">
                            @csrf
                            @if($voucher)
                                <input type="hidden" name="id" value="{{ $voucher->id }}">
                            @endif

                            <div class="form-group row">

                                <!-- Kode Voucher -->
                                <div class="col-md-4">
                                    <label class="text-body">Kode Voucher <span class="text-danger">*</span></label>
                                    <fieldset class="form-group mb-3">
                                        <input type="text" class="form-control text-uppercase" id="code" name="code"
                                               placeholder="Contoh: DISKON10"
                                               value="{{ old('code', $voucher->code ?? '') }}"
                                               style="text-transform:uppercase"
                                               required>
                                    </fieldset>
                                </div>

                                <!-- Tipe Diskon -->
                                <div class="col-md-4">
                                    <label class="text-body">Tipe Diskon <span class="text-danger">*</span></label>
                                    <fieldset class="form-group mb-3">
                                        <select name="type" id="type"
                                                class="js-example-basic-single form-control bg-transparent" required>
                                            <option value="">-- Pilih Tipe --</option>
                                            <option value="percentage"
                                                {{ old('type', $voucher->type ?? '') === 'percentage' ? 'selected' : '' }}>
                                                Persentase (%)
                                            </option>
                                            <option value="fixed"
                                                {{ old('type', $voucher->type ?? '') === 'fixed' ? 'selected' : '' }}>
                                                Nominal (Rp)
                                            </option>
                                        </select>
                                    </fieldset>
                                </div>

                                <!-- Nilai Diskon -->
                                <div class="col-md-4">
                                    <label class="text-body" id="value-label">
                                        Nilai Diskon <span class="text-danger">*</span>
                                    </label>
                                    <fieldset class="form-group mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text" id="value-prefix">%</span>
                                            <input type="number" class="form-control" id="value" name="value"
                                                   placeholder="0" min="0" step="0.01"
                                                   value="{{ old('value', $voucher->value ?? '') }}"
                                                   required>
                                        </div>
                                    </fieldset>
                                </div>

                                <!-- Maksimal Diskon -->
                                <div class="col-md-4" id="max-discount-wrapper">
                                    <label class="text-body">Maksimal Diskon (Rp)</label>
                                    <fieldset class="form-group mb-3">
                                        <input type="number" class="form-control" id="max_discount" name="max_discount"
                                               placeholder="Kosongkan jika tidak ada batas"
                                               min="0" step="0.01"
                                               value="{{ old('max_discount', $voucher->max_discount ?? '') }}">
                                    </fieldset>
                                </div>

                                <!-- Limit Penggunaan -->
                                <div class="col-md-4">
                                    <label class="text-body">Limit Penggunaan</label>
                                    <fieldset class="form-group mb-3">
                                        <input type="number" class="form-control" id="usage_limit" name="usage_limit"
                                               placeholder="Kosongkan jika tak terbatas"
                                               min="1"
                                               value="{{ old('usage_limit', $voucher->usage_limit ?? '') }}">
                                    </fieldset>
                                </div>

                                <!-- Tanggal Kadaluarsa -->
                                <div class="col-md-4">
                                    <label class="text-body">Berlaku Hingga</label>
                                    <fieldset class="form-group mb-3">
                                        <input type="date" class="form-control" id="expires_at" name="expires_at"
                                               value="{{ old('expires_at', $voucher && $voucher->expires_at ? \Carbon\Carbon::parse($voucher->expires_at)->format('Y-m-d') : '') }}">
                                    </fieldset>
                                </div>

                                <!-- Status Aktif -->
                                <div class="col-md-4">
                                    <label class="text-body">Status</label>
                                    <fieldset class="form-group mb-3">
                                        <select name="is_active" id="is_active"
                                                class="js-example-basic-single form-control bg-transparent">
                                            <option value="1"
                                                {{ old('is_active', $voucher->is_active ?? 1) == 1 ? 'selected' : '' }}>
                                                Aktif
                                            </option>
                                            <option value="0"
                                                {{ old('is_active', $voucher->is_active ?? 1) == 0 ? 'selected' : '' }}>
                                                Nonaktif
                                            </option>
                                        </select>
                                    </fieldset>
                                </div>

                            </div>

                            <!-- Buttons -->
                            <div class="col-md-12 mt-2">
                                <button type="submit" class="btn btn-success text-white font-weight-bold me-1 mb-1">
                                    <i class="bi bi-save me-1"></i>
                                    {{ $voucher ? 'Simpan Perubahan' : 'Simpan Voucher' }}
                                </button>
                                <a href="{{ url('voucher') }}" class="btn btn-danger font-weight-bold me-1 mb-1">
                                    <i class="bi bi-x-circle me-1"></i> Batal
                                </a>
                            </div>

                        </form>

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
        jQuery('.js-example-basic-single').select2();

        updateValuePrefix();

        jQuery('#type').on('change', function () {
            updateValuePrefix();
        });

        function updateValuePrefix() {
            const type = jQuery('#type').val();
            if (type === 'percentage') {
                jQuery('#value-prefix').text('%');
                jQuery('#value').attr('max', 100);
                jQuery('#max-discount-wrapper').show();
            } else if (type === 'fixed') {
                jQuery('#value-prefix').text('Rp');
                jQuery('#value').removeAttr('max');
                jQuery('#max-discount-wrapper').hide();
            } else {
                jQuery('#value-prefix').text('#');
                jQuery('#max-discount-wrapper').show();
            }
        }
    });
</script>
@endpush
