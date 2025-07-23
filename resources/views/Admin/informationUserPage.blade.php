@extends('parts.header')

@section('content')
<div class="container">

    <h2 class="mb-4">Informasi Pengguna</h2>

    <div class="accordion" id="accordionInformasi">

        {{-- FAQ Section --}}
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingFAQ">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFAQ" aria-expanded="true" aria-controls="collapseFAQ">
                    💬 Daftar FAQ
                </button>
            </h2>
            <div id="collapseFAQ" class="accordion-collapse collapse show" aria-labelledby="headingFAQ" data-bs-parent="#accordionInformasi">
                <div class="accordion-body">
                    <table class="table table-bordered table-hover" id="faqTable">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Konten</th>
                                <th>Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($faq as $item)
                            <tr>
                                <td>{{ $item->Judul }}</td>
                                <td>{!! \Illuminate\Support\Str::limit(strip_tags($item->Konten), 150) !!}</td>
                                <td>{{ $item->created_at->format('d M Y') }}</td>
                                <td>
                                    <a href="{{ url('faq/detail/' . $item['id']) }}" class="btn btn-sm btn-primary">Lihat Detail</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Tutorial Section --}}
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingTutorial">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTutorial" aria-expanded="false" aria-controls="collapseTutorial">
                    🎓 Daftar Tutorial
                </button>
            </h2>
            <div id="collapseTutorial" class="accordion-collapse collapse" aria-labelledby="headingTutorial" data-bs-parent="#accordionInformasi">
                <div class="accordion-body">
                    <table class="table table-bordered table-hover" id="tutorialTable">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Konten</th>
                                <th>Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tutorial as $item)
                            <tr>
                                <td>{{ $item->Judul }}</td>
                                <td>{!! \Illuminate\Support\Str::limit(strip_tags($item->Konten), 150) !!}</td>
                                <td>{{ $item->created_at->format('d M Y') }}</td>
                                <td>
                                    <a href="{{ url('faq/detail/' . $item['id']) }}" class="btn btn-sm btn-primary">Lihat Detail</a>
                                </td>
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
 <script type="text/javascript">
        jQuery(document).ready(function() {
            jQuery('#faqTable').DataTable({
                "pagingType": "simple_numbers",
                "columnDefs": [{
                    "targets": 'no-sort',
                    "orderable": false,
                }]
            });

            jQuery('#tutorialTable').DataTable({
                "pagingType": "simple_numbers",
                "columnDefs": [{
                    "targets": 'no-sort',
                    "orderable": false,
                }]
            });
        });
    </script>
@endpush
