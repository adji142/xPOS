<!DOCTYPE html>
<!--
Template Name: Kundol Admin - Bootstrap 4 HTML Admin Dashboard Theme
Author: Themes-coder
Website: https://themes-coder.com/
Contact: sales@themes-coder.com
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<html lang="en">
<!--begin::Head-->

<head>
	
	<meta charset="utf-8" />
	<title>Admin | Dashboard</title>
	<meta name="description" content="Updates and statistics" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<!--begin::Fonts-->
	<!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" /> -->
	<!--end::Fonts-->

	<!--begin::Global Theme Styles(used by all pages)-->
	<link href="{{ asset('css/style.css?v=1.0')}}" rel="stylesheet" type="text/css" />
	<!--end::Global Theme Styles-->

	<link href="{{ asset('api/pace/pace-theme-flat-top.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('api/mcustomscrollbar/jquery.mCustomScrollbar.css')}}" rel="stylesheet" type="text/css" />
	
	<link href="{{ asset('api/datatable/jquery.dataTables.min.css')}}" rel="stylesheet" type="text/css" />


	<link rel="shortcut icon" href="{{ asset('media/logos/favicon.ico')}}" />
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="tc_body" class="">
	   <!-- Paste this code after body tag -->
	<div class="l-form" style="background-image: url({{ asset('images/misc/bg-login3.jpg')}}); background-size: contain; background-position: center; background-color: #d00904; background-repeat: no-repeat;">
		<form method="post" action="{{route('SendEmailResetPassword')}}" class="adminloginform">
			@csrf
			<div class="maintitle">
				<div class="card-title mb-0">
					<h3 class="card-label font-weight-bold mb-0 text-body">
						<img src="{{ asset('images/misc/LogoFront.png')}}" alt="logo" width="30%">
					</h3>
				
				</div>
				<h5 class="font-size-h5 mb-0 mt-3 text-dark">
					Reset Password.
				</h5>

			</div>
			<div class="form-group  row">
				<div class="col-lg-2 col-3 ">
					<label for="exampleInputEmail1" class="mb-0 text-dark">
						<svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-person" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd" d="M10 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0zM8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6 5c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
							</svg>
					</label>
				</div>
					<div class="col-lg-10 col-9 pl-0">
					<input type="email" name="email" class="form-control bg-transparent text-dark border-0 p-0 h-20px font-size-h5" placeholder="example@mail.com" id="exampleInputEmail1" aria-describedby="emailHelp">
			
				</div>
			 
			</div>
			<div class="form-group row ">
				<div class="col-12">
					<button type="submit" class="btn btn-primary text-white font-weight-bold w-100 py-3 mt-3">
						Reset Password
					</button>
				</div>
			</div>
	</form>
</div>
@include('sweetalert::alert')

	

<script src="{{ asset('js/plugin.bundle.min.js')}}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js')}}"></script>
<script src="{{ asset('api/jqueryvalidate/jquery.validate.min.js')}}"></script>


<!-- <script src="{{ asset('js/script.bundle.js')}}"></script> -->
</body>
<!--end::Body-->
<script>
	$('#btDaftar').click(function () {
		// alert('sfasdsa');
	})
</script>

</html>