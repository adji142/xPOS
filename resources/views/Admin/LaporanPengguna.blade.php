@extends('parts.header')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 mt-4">
            <div class="card p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0">Laporan Pengguna Aplikasi</h4>
                    <div>
                        <a href="{{ route('laporanpengguna-export-excel') }}" class="btn btn-success">
                            <i class="fas fa-file-excel me-1"></i> Export Excel
                        </a>
                        <a href="{{ route('laporanpengguna-export-pdf') }}" class="btn btn-danger">
                            <i class="fas fa-file-pdf me-1"></i> Export PDF
                        </a>
                    </div>
                </div>
                <hr>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="laporanPenggunaTable">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Kode Partner</th>
                                <th>Nama Partner</th>
                                <th>Status</th>
                                <th>Email</th>
                                <th>No. Tlp</th>
                                <th>Nama PIC</th>
                                <th>Mulai Berlangganan</th>
                                <th>Expired Date</th>
                                <th>Lama Berlangganan</th>
                                <th>Jenis Usaha</th>
                                <th>Paket Berlangganan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($oCompany as $index => $company)
                            @php
                                $start = \Carbon\Carbon::parse($company->StartSubs);
                                $end = \Carbon\Carbon::parse($company->EndSubs);
                                $duration = $start->diffInDays($end) . " Hari";
                                
                                $statusParts = explode('-', $company->StatusSubscription);
                                $statusText = $statusParts[0];
                                $statusClass = isset($statusParts[1]) ? $statusParts[1] : 'secondary';
                            @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $company->KodePartner }}</td>
                                <td>{{ $company->NamaPartner }}</td>
                                <td>
                                    <span class="badge bg-{{ $statusClass }}">{{ $statusText }}</span>
                                </td>
                                <td>{{ $company->email }}</td>
                                <td>{{ $company->NoTlp }}</td>
                                <td>{{ $company->NamaPIC }}</td>
                                <td>{{ $company->StartSubs }}</td>
                                <td>{{ $company->EndSubs }}</td>
                                <td>{{ $duration }}</td>
                                <td>{{ $company->JenisUsaha }}</td>
                                <td>{{ $company->NamaSubscription }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#laporanPenggunaTable').DataTable({
            responsive: true,
            pageLength: 25,
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Selanjutnya",
                    previous: "Sebelumnya"
                }
            }
        });
    });
</script>
@endpush
