<!DOCTYPE html>

<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>{{ config('app.name', 'Admin | Dashboard') }}</title>
		<meta name="description" content="Updates and statistics" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />


		<!--begin::Global Theme Styles(used by all pages)-->
		<link href="{{ asset('css/style.css?v=1.0')}}" rel="stylesheet" type="text/css" />
		<!--end::Global Theme Styles-->

		<link href="{{ asset('api/pace/pace-theme-flat-top.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('api/mcustomscrollbar/jquery.mCustomScrollbar.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('api/datatable/jquery.dataTables.min.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('api/select2/select2.min.css')}}" rel="stylesheet" />
		<link href="{{asset('api/multiple-select/multiple-select.min.css')}}" rel="stylesheet">


		<link rel="shortcut icon" href="{{ asset('media/logos/favicon.ico')}}" />
	</head>

	<body id="tc_body" class="header-fixed header-mobile-fixed subheader-enabled aside-enabled aside-fixed">


	<!--begin::Header Mobile-->
	<div id="tc_header_mobile" class="header-mobile align-items-center header-mobile-fixed">
		<!--begin::Logo-->
		<a href="index.html" class="brand-logo">

			<span class="brand-text"><img style="height: 25px;" alt="Logo" src="{{ asset('images/misc/logo.png')}}" /></span>

		</a>
		<!--end::Logo-->
		<!--begin::Toolbar-->
		<div class="d-flex align-items-center">
           
			<div class="posicon">
				<a href="pos.html" class="btn btn-primary d-flex align-items-center justify-content-center white me-2">POS</a>
			</div>
			<button class="btn p-0" id="tc_aside_mobile_toggle">
				<svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-justify-right" fill="currentColor"
					xmlns="http://www.w3.org/2000/svg">
					<path fill-rule="evenodd"
						d="M6 12.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-4-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z" />
				</svg>
			</button>

			<button class="btn p-0 ms-2" id="tc_header_mobile_topbar_toggle">
				<span class="svg-icon svg-icon-xl">

					<svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-person-fill" fill="currentColor"
						xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd"
							d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
					</svg>

				</span>
			</button>

		</div>
		<!--end::Toolbar-->
	</div>
	<!--end::Header Mobile-->
	<!--begin::Main-->
	<div class="d-flex flex-column flex-root">
		<!--begin::Page-->
		<div class="d-flex flex-row flex-column-fluid page">
			<div class="aside aside-left aside-fixed d-flex flex-column flex-row-auto" id="tc_aside">
				<!--begin::Brand-->
				<div class="brand flex-column-auto" id="tc_brand">
					<!--begin::Logo-->
					<a href="index.html" class="brand-logo">
						<img class="brand-image" style="height: 25px;" alt="Logo" src="{{ asset('images/misc/k.png')}}" />
						<span class="brand-text"><img style="height: 25px;" alt="Logo"
								src="{{asset('images/misc/logo.png')}}" /></span>

					</a>
					<!--end::Logo-->
				</div>
				<!--end::Brand-->
				<!--begin::Aside Menu-->
				<div class="aside-menu-wrapper flex-column-fluid overflow-auto h-100" id="tc_aside_menu_wrapper">
					<!--begin::Menu Container-->
					<div id="tc_aside_menu" class="aside-menu  mb-5" data-menu-vertical="1" data-menu-scroll="1" data-menu-dropdown-timeout="500">
						<!--begin::Menu Nav-->
						<div id="accordion">
							<ul class="nav flex-column">
								<li class="nav-item active">
									<a href="index.html" class="nav-link">
										<span class="svg-icon nav-icon">
											<svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px"
												viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
												stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
												<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
												<polyline points="9 22 9 12 15 12 15 22"></polyline>
											</svg>
										</span>
										<span class="nav-text">
											Dashboard
										</span>
									</a>
								</li>

								<!-- Dynamic Menu -->
								@foreach ($navbars as $lv1)
									@if ($lv1['ParentType'] == 1)
										<li class="nav-item">
											<a class="nav-link" data-bs-toggle="collapse"  href="javascript:void(0)" data-bs-target="#{{$lv1['PermissionName']}}" role="button" aria-expanded="false" aria-controls="{{$lv1['PermissionName']}}">
												<span class="svg-icon nav-icon">
													<i class="{{$lv1['Icon']}} font-size-h4"></i>
												</span>
												<span class="nav-text">{{$lv1['PermissionName']}}</span>
												<i class="fas fa-chevron-right fa-rotate-90"></i>
											</a>
										</li>

										<div class="collapse nav-collapse" id="{{$lv1['PermissionName']}}" data-bs-parent="#accordion">
											<div id="accordion1">
												<ul class="nav flex-column">
													@if (count($lv1['submenu']) > 0)
														@foreach ($lv1['submenu'] as $lv2)
															@if ($lv2['ParentType'] == 1)
																<li class="nav-item">
																	<a  class="nav-link sub-nav-link" data-bs-toggle="collapse" href="#{{str_replace(' ','',$lv2['PermissionName'])}}" role="button" aria-expanded="false" aria-controls="{{str_replace(' ','',$lv2['PermissionName'])}}">
																		<span class="svg-icon nav-icon d-flex justify-content-center">
																			<svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
																				<path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
																			  </svg>
																		</span>
																		<span class="nav-text">{{$lv2['PermissionName']}}</span>
																		<i class="fas fa-chevron-right fa-rotate-90"></i>
																	</a>

																	<div class="collapse nav-collapse" id="{{str_replace(' ','',$lv2['PermissionName'])}}" data-bs-parent="#accordion1">
																		<ul class="nav flex-column">
																			@if (count($lv2['submenu']) > 0)
																				@foreach ($lv2['submenu'] as $lv3)
																					<li class="nav-item">
																						<a href="{{ route($lv3['Link']) }}" class="nav-link mini-sub-nav-link">
																						
																							<span class="nav-text">{{$lv3['PermissionName']}}</span>
																						</a>
																						
																					</li>
																				@endforeach
																			@endif
																		</ul>
																	</div>
																</li>
															@else
																<li class="nav-item">
																	<a href="{{ route($lv2['Link']) }}" class="nav-link sub-nav-link">
																		<span class="svg-icon nav-icon d-flex justify-content-center">
																			<svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
																				<path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
																			  </svg>
																		</span>
																		<span class="nav-text">{{$lv2['PermissionName']}}</span>
																	</a>
																</li>
															@endif
														@endforeach
													@endif
												</ul>
											</div>
										</div>
									@else
										<div>else lv1</div>
									@endif
								@endforeach
							</ul>
						</div>
						<!--end::Menu Nav-->
					</div>
					<!--end::Menu Container-->
				</div>
				<!--end::Aside Menu-->
			</div>
		</div>

		<!--begin::Aside-->
		
		<div class="aside-overlay"></div>
		<!--end::Aside-->
		<!--begin::Wrapper-->
		<div class="d-flex flex-column flex-row-fluid wrapper" id="tc_wrapper">
			<!--begin::Header-->
			<div id="tc_header" class="header header-fixed">
				<!--begin::Container-->
				<div class="container-fluid d-flex align-items-stretch justify-content-between">
					<!--begin::Header Menu Wrapper-->
					<div class="header-menu-wrapper header-menu-wrapper-left" id="tc_header_menu_wrapper">
						<!--begin::Header Menu-->
						<div id="tc_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
							<!--begin::Header Nav-->
							<ul class="menu-nav">

									<li class="menu-item menu-item-open menu-item-here menu-item-submenu menu-item-rel menu-item-open menu-item-here menu-item-active p-0"
									data-menu-toggle="click" aria-haspopup="true">
									<!--begin::Toggle-->
									<div class="btn  btn-clean btn-dropdown mr-0 p-0" id="tc_aside_toggle">
										<span class="svg-icon svg-icon-xl svg-icon-primary">

											<svg width="24px" height="24px" viewBox="0 0 16 16" class="bi bi-list"
												fill="currentColor" xmlns="http://www.w3.org/2000/svg">
												<path fill-rule="evenodd"
													d="M2.5 11.5A.5.5 0 0 1 3 11h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 7h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 3h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
											</svg>
										</span>
									</div>
									<!--end::Toolbar-->
								</li>

							</ul>
							<!--end::Header Nav-->
						</div>
						<!--end::Header Menu-->
					</div>
					<!--end::Header Menu Wrapper-->
					<!--begin::Topbar-->
					<div class="topbar">
						<div class="posicon d-lg-block d-none">
							<a href="pos.html" class="btn btn-primary white me-2">POS</a>
						</div>

						<!--begin::Quick Actions-->
						<div class="dropdown">

							<div class="topbar-item" data-bs-toggle="dropdown" data-offset="10px,0px">
								<div id="kt_open_fullscreen" class="btn btn-icon btn-clean btn-dropdown me-1"
									onclick="openFullscreen();">
									<span class="svg-icon svg-icon-xl svg-icon-primary">

										<svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-fullscreen"
											fill="currentColor" xmlns="http://www.w3.org/2000/svg">
											<path fill-rule="evenodd"
												d="M1.5 1a.5.5 0 0 0-.5.5v4a.5.5 0 0 1-1 0v-4A1.5 1.5 0 0 1 1.5 0h4a.5.5 0 0 1 0 1h-4zM10 .5a.5.5 0 0 1 .5-.5h4A1.5 1.5 0 0 1 16 1.5v4a.5.5 0 0 1-1 0v-4a.5.5 0 0 0-.5-.5h-4a.5.5 0 0 1-.5-.5zM.5 10a.5.5 0 0 1 .5.5v4a.5.5 0 0 0 .5.5h4a.5.5 0 0 1 0 1h-4A1.5 1.5 0 0 1 0 14.5v-4a.5.5 0 0 1 .5-.5zm15 0a.5.5 0 0 1 .5.5v4a1.5 1.5 0 0 1-1.5 1.5h-4a.5.5 0 0 1 0-1h4a.5.5 0 0 0 .5-.5v-4a.5.5 0 0 1 .5-.5z" />
										</svg>



									</span>

								</div>

								<div id="kt_close_fullscreen" class="btn btn-icon btn-clean btn-dropdown me-1"
									onclick="closeFullscreen();" style="display: none;">
									<span class="svg-icon svg-icon-xl svg-icon-primary">
										<svg width="20px" height="20px" viewBox="0 0 16 16"
											class="bi bi-fullscreen-exit" fill="currentColor"
											xmlns="http://www.w3.org/2000/svg">
											<path fill-rule="evenodd"
												d="M5.5 0a.5.5 0 0 1 .5.5v4A1.5 1.5 0 0 1 4.5 6h-4a.5.5 0 0 1 0-1h4a.5.5 0 0 0 .5-.5v-4a.5.5 0 0 1 .5-.5zm5 0a.5.5 0 0 1 .5.5v4a.5.5 0 0 0 .5.5h4a.5.5 0 0 1 0 1h-4A1.5 1.5 0 0 1 10 4.5v-4a.5.5 0 0 1 .5-.5zM0 10.5a.5.5 0 0 1 .5-.5h4A1.5 1.5 0 0 1 6 11.5v4a.5.5 0 0 1-1 0v-4a.5.5 0 0 0-.5-.5h-4a.5.5 0 0 1-.5-.5zm10 1a1.5 1.5 0 0 1 1.5-1.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 0-.5.5v4a.5.5 0 0 1-1 0v-4z" />
										</svg>
									</span>
								</div>
							</div>



						</div>
						<!--end::Quick Actions-->

						<!--begin::user-->
						<div class="dropdown">

							<div class="topbar-item" data-bs-toggle="dropdown" data-display="static">
								<div class="btn btn-icon w-auto btn-clean d-flex align-items-center pr-1 ps-3">
									<span class="text-dark-50 font-size-base d-none d-xl-inline me-3">Angilina
										Deo</span>
									<span class="symbol symbol-35 symbol-light-success">
										<span class="symbol-label font-size-h5 ">
											<svg width="20px" height="20px" viewBox="0 0 16 16"
												class="bi bi-person-fill" fill="currentColor"
												xmlns="http://www.w3.org/2000/svg">
												<path fill-rule="evenodd"
													d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
											</svg>
										</span>
									</span>
								</div>
							</div>

							<div class="dropdown-menu dropdown-menu-right" style="min-width: 150px;">

								<a href="#" class="dropdown-item">
									<span class="svg-icon svg-icon-xl svg-icon-primary me-2">
										<svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px"
											viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
											stroke-linecap="round" stroke-linejoin="round"
											class="feather feather-user">
											<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
											<circle cx="12" cy="7" r="4"></circle>
										</svg>
									</span>
									Edit Profile
								</a>

								<a href="#" class="dropdown-item">
									<span class="svg-icon svg-icon-xl svg-icon-primary me-2">
										<svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px"
											viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
											stroke-linecap="round" stroke-linejoin="round"
											class="feather feather-power">
											<path d="M18.36 6.64a9 9 0 1 1-12.73 0"></path>
											<line x1="12" y1="2" x2="12" y2="12"></line>
										</svg>
									</span>
									Logout
								</a>
							</div>

						</div>
						<!--end::user-->


					</div>
					<!--end::Topbar-->
				</div>
				<!--end::Container-->
			</div>
			<!--end::Header-->
			<!--begin::Content-->
			<div class="content d-flex flex-column flex-column-fluid" id="tc_content">
				@yield('content')
			</div>
			
			<div class="footer bg-white py-4 d-flex flex-lg-column" id="tc_footer">
				
				<div
					class="container-fluid d-flex flex-column flex-md-row align-items-center justify-content-between">
					
					<div class="text-dark order-2 order-md-1">
						<span class="text-muted font-weight-bold me-2">2020©</span>
						<a href="#" target="_blank" class="text-dark-75 text-hover-primary">Themescoder</a>
					</div>

					<div class="nav nav-dark">
						<a href="#" target="_blank" class="nav-link pl-0 pr-5">About</a>
						<a href="#c" target="_blank" class="nav-link pl-0 pr-5">Team</a>
						<a href="#" target="_blank" class="nav-link pl-0 pr-0">Contact</a>
					</div>

				</div>

			</div>
			<!--end::Footer-->
		</div>
		<!--end::Wrapper-->
	</div>
	<!--end::Page-->
<!-- </div> -->
<!--end::Main-->


	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="{{asset('js/plugin.bundle.min.js')}}"></script>
	<script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
	
	<!-- Dev Express -->
	<!-- <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/23.2.5/css/dx.light.css">
	<script type="text/javascript" src="https://cdn3.devexpress.com/jslib/23.2.5/js/dx.all.js"></script> -->
	<link href="{{ asset('devexpress/dx.light.css')}}" rel="stylesheet" type="text/css" />
	<script src="{{asset('devexpress/dx.all.js')}}"></script>
	<!-- End DevExpress -->
	<script src="{{asset('js/slick.min.js')}}"></script>
	<script src="{{asset('api/jqueryvalidate/jquery.validate.min.js')}}"></script>
	<script src="{{asset('api/apexcharts/apexcharts.js')}}"></script>
	<script src="{{asset('api/apexcharts/scriptcharts.js')}}"></script> 
	<script src="{{asset('api/pace/pace.js')}}"></script>
	<script src="{{asset('api/mcustomscrollbar/jquery.mCustomScrollbar.concat.min.js')}}"></script>
	<script src="{{asset('api/quill/quill.min.js')}}"></script>
	<script src="{{asset('api/editor/classic.ckeditor.js')}}"></script>
	<script src="{{asset('api/editor/inline.ckeditor.js')}}"></script>
	<script src="{{asset('api/datatable/jquery.dataTables.min.js')}}"></script>
	<script src="{{asset('api/select2/select2.min.js')}}"></script>
	<script src="{{asset('api/multiple-select/multiple-select.min.js')}}"></script>
	<script src="{{asset('js/script.bundle.js')}}"></script>
	<script src="{{asset('js/script-slick.js')}}"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script>
		// In your Javascript (external .js resource or <script> tag)
		jQuery(document).ready(function() {
			jQuery('.js-example-basic-single').select2();
		});
	</script>	
	@include('sweetalert::alert')

	@stack('scripts')
</body>
<!--end::Body-->



</html>