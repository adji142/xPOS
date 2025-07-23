@extends('parts.header')

@section('content')
<div class="container mt-4">

    <a href="{{ url()->previous() }}" class="btn btn-secondary mb-3">← Kembali</a>

    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">{{ $data->Judul }}</h4>
            <small class="text-muted">Kategori: {{ ucfirst($data->Kategori) }} | Dibuat pada: {{ $data->created_at->format('d M Y H:i') }}</small>
        </div>
        <div class="card-body">
            @if ($data->Thumbnail)
                <div class="mb-3 text-center">
                    <img src="data:image/png;base64,{{ $data->Thumbnail }}" alt="Thumbnail" class="img-fluid rounded shadow-sm" style="max-height: 300px;">
                </div>
            @endif

            <div class="konten">
                {!! $data->Konten !!}
            </div>
        </div>
    </div>

</div>
@endsection
