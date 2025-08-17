@extends('parts.header')

@section('content')
<style type="text/css">
	.xContainer{
		display: flex;
		flex-wrap: wrap;
		justify-content: center;
		align-items: center;
		vertical-align: middle;
	}
	.image_result{
		display: flex;
		justify-content: center;
		align-items: center;
		border: 1px solid black;
		vertical-align: middle;
		align-content: center;
		width: 150px;
		height: 200px;
	}
	.image_result img {
		max-width: 100%;
		height: 100%;
	}

	.ql-font span[data-value="sans-serif"]::before { content: 'Sans Serif'; }
	.ql-font span[data-value="serif"]::before { content: 'Serif'; }
	.ql-font span[data-value="monospace"]::before { content: 'Monospace'; }
	.ql-font span[data-value="arial"]::before { content: 'Arial'; }
	.ql-font span[data-value="comic-sans"]::before { content: 'Comic Sans'; }
	.ql-font span[data-value="times-new-roman"]::before { content: 'Times New Roman'; }
	.ql-font span[data-value="courier-new"]::before { content: 'Courier New'; }
	.ql-font span[data-value="georgia"]::before { content: 'Georgia'; }

	.ql-font-arial { font-family: Arial, sans-serif; }
	.ql-font-comic-sans { font-family: 'Comic Sans MS', cursive, sans-serif; }
	.ql-font-times-new-roman { font-family: 'Times New Roman', Times, serif; }
	.ql-font-courier-new { font-family: 'Courier New', Courier, monospace; }
	.ql-font-georgia { font-family: Georgia, serif; }

</style>
<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item">
					<a href="{{route('faq')}}">FAQ & Tutorial</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Input FAQ & Tutorial</li>
			</ol>
		</nav>
	</div>
</div>
<div class="d-flex flex-column-fluid">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 px-4">
				<div class="card card-custom gutter-b bg-white border-0">
					<div class="card-body">
                        @if (count($data) > 0)
                            <form action="{{route('faq-edit')}}" method="post">
                        @else
                            <form action="{{route('faq-store')}}" method="post">
                        @endif
							@csrf
							<input type="hidden" name="id" value="{{ isset($data[0]) ? $data[0]['id'] : '' }}">

							<div class="form-group">
								<label>Judul</label>
								<input type="text" class="form-control" name="Judul" value="{{ isset($data[0]) ? $data[0]['Judul'] : '' }}" required>
							</div>

							<div class="form-group">
								<label>Kategori</label>
								<select class="form-control" name="Kategori" required>
									<option value="FAQ" {{ isset($data[0]) && $data[0]['Kategori'] == 'faq' ? 'selected' : '' }}>FAQ</option>
									<option value="TUTORIAL" {{ isset($data[0]) && $data[0]['Kategori'] == 'tutorial' ? 'selected' : '' }}>TUTORIAL</option>
								</select>
							</div>

							{{-- <div class="form-group">
								<label>Thumbnail</label><br>
								<textarea id="image_base64" name="ThumbnailBase64" style="display: none;">{{ isset($data[0]) ? $data[0]['ThumbnailBase64'] : '' }}</textarea>
								<input type="file" id="Attachment" accept=".jpg, .png" class="btn btn-warning" style="display: none;">
								<div class="xContainer">
									<div id="image_result" class="image_result">
										<img src="{{ isset($data[0]) ? $data[0]['ThumbnailBase64'] : 'https://www.generationsforpeace.org/wp-content/uploads/2018/03/empty.jpg' }}">
									</div>
								</div>
							</div> --}}

							<div class="form-group">
								<label>Konten</label>
								<div id="toolbar">
									<select class="ql-font"></select>
									<select class="ql-size"></select>
									<button class="ql-bold"></button>
									<button class="ql-italic"></button>
									<button class="ql-underline"></button>
									<button class="ql-link"></button>
									<button class="ql-image"></button>
									<button class="ql-list" value="ordered"></button>
									<button class="ql-list" value="bullet"></button>
									<select class="ql-align"></select>
								</div>
								<div id="editor-container" style="height: 300px;">{!! isset($data[0]) ? $data[0]['Konten'] : '' !!}</div>
								<textarea name="Konten" id="Konten" style="display: none">{!! isset($data[0]) ? $data[0]['Konten'] : '' !!}</textarea>
							</div>

							<div class="form-group">
								<label>Status</label>
								<select class="form-control" name="IsPublished">
									<option value="1" {{ isset($data[0]) && $data[0]['IsPublished'] == '1' ? 'selected' : '' }}>Published</option>
									<option value="0" {{ isset($data[0]) && $data[0]['IsPublished'] == '0' ? 'selected' : '' }}>Draft</option>
								</select>
							</div>

							<button type="submit" class="btn btn-success">Simpan</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection

@push('scripts')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/quill-image-resize-module@3.0.0/image-resize.min.js"></script>

<script>
	const Font = Quill.import('formats/font');
	Font.whitelist = ['sans-serif', 'serif', 'monospace', 'arial', 'comic-sans', 'times-new-roman', 'courier-new', 'georgia'];
	Quill.register(Font, true);

	const Size = Quill.import('formats/size');
	Size.whitelist = ['small', false, 'large', 'huge'];
	Quill.register(Size, true);

	// Inisialisasi Quill
	const quill = new Quill('#editor-container', {
		theme: 'snow',
		modules: {
		toolbar: {
			container: "#toolbar",
			handlers: {
			image: function () {
				const input = document.createElement('input');
				input.setAttribute('type', 'file');
				input.setAttribute('accept', 'image/*');
				input.click();
				input.onchange = () => {
				const file = input.files[0];
				const reader = new FileReader();
				reader.onload = (e) => {
					const range = quill.getSelection();
					quill.insertEmbed(range.index, 'image', e.target.result);
				};
				reader.readAsDataURL(file);
				};
			}
			}
		},
		imageResize: {
			modules: ['Resize', 'DisplaySize']
		}
		}
	});
//   var quill = new Quill('#editor-container', {
//     theme: 'snow'
//   });
  $("form").submit(function () {
    $("#Konten").val(quill.root.innerHTML);
  });

  $('#image_result').click(function () {
    $('#Attachment').click();
  });

  $('#Attachment').change(function () {
    var file = this.files[0];
    if (!file) return;
    var reader = new FileReader();
    reader.onloadend = function () {
      $('#image_base64').val(reader.result);
      $('#image_result').html("<img src='" + reader.result + "'>");
    }
    reader.readAsDataURL(file);
  });
</script>
@endpush