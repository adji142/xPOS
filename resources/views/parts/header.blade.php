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

			<span class="brand-text"><img style="height: 100%;" alt="Logo" src="{{ asset('images/misc/logo-dashboard.png')}}" /></span>

		</a>
		<!--end::Logo-->
		<!--begin::Toolbar-->
		<div class="d-flex align-items-center">
           
			<div class="posicon">
				<a href="{{ url('fpenjualan/pos') }}" class="btn btn-primary d-flex align-items-center justify-content-center white me-2">POS</a>
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
						<img class="brand-image" style="height: 100%;" alt="Logo" src="{{ asset('images/misc/logo-dashboard.png')}}" />
						<span class="brand-text"><img style="height: 100%;" alt="Logo"
								src="{{asset('images/misc/logo-dashboard.png')}}" /></span>

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
									<a href="{{ route('dashboard') }}" class="nav-link">
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

								<li class="nav-item">
									<a href="https://api.whatsapp.com/send/?phone=6282258493130&text=Saya%20ada%20kendala%20di%20PoS&type=phone_number&app_absent=0" target="_blank" class="nav-link">
										<span class="svg-icon nav-icon">
											<svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20px" height="20px" viewBox="0 0 100 100">
												<path d="M 50 15 C 30.68158 15 15 30.68158 15 50 C 15 56.13094 16.607004 61.884452 19.378906 66.896484 L 15.072266 82.464844 C 14.671771 83.913976 16.085438 85.328373 17.535156 84.925781 L 33.105469 80.619141 C 38.11809 83.391483 43.869654 85 50 85 C 69.31842 85 85 69.31842 85 50 C 85 30.68158 69.31842 15 50 15 z M 50 17 C 68.23758 17 83 31.76242 83 50 C 83 68.23758 68.23758 83 50 83 C 44.064811 83 38.507278 81.426921 33.695312 78.685547 A 1.0001 1.0001 0 0 0 32.933594 78.591797 L 17 82.998047 L 21.408203 67.066406 A 1.0001 1.0001 0 0 0 21.3125 66.304688 C 18.572114 61.493724 17 55.935189 17 50 C 17 31.76242 31.76242 17 50 17 z M 50 22 C 34.541787 22 22 34.541787 22 50 C 22 55.881567 23.836204 61.330109 26.935547 65.835938 L 24.408203 74.976562 A 0.50005 0.50005 0 0 0 25.023438 75.591797 L 34.164062 73.064453 C 38.670353 76.164715 44.118498 78 50 78 C 65.458213 78 78 65.458213 78 50 C 78 42.300345 74.888757 35.321559 69.855469 30.259766 A 0.50064154 0.50064154 0 0 0 69.144531 30.964844 C 73.999243 35.84705 77 42.569655 77 50 C 77 64.917787 64.917787 77 50 77 C 44.23771 77 38.905865 75.191654 34.521484 72.117188 A 0.50005 0.50005 0 0 0 34.101562 72.044922 L 25.607422 74.394531 L 27.957031 65.900391 A 0.50005 0.50005 0 0 0 27.884766 65.480469 C 24.810274 61.096051 23 55.763251 23 50 C 23 35.082213 35.082213 23 50 23 C 52.55371 23 55.020926 23.36246 57.363281 24.025391 A 0.50048162 0.50048162 0 1 0 57.636719 23.0625 C 55.209074 22.375431 52.64829 22 50 22 z M 60.496094 24.078125 A 0.50005 0.50005 0 0 0 60.308594 25.041016 C 61.322994 25.460903 62.30459 25.942928 63.253906 26.478516 A 0.50005 0.50005 0 1 0 63.746094 25.609375 C 62.76341 25.054963 61.745006 24.5533 60.691406 24.117188 A 0.50005 0.50005 0 0 0 60.496094 24.078125 z M 65.501953 26.78125 A 0.50005 0.50005 0 0 0 65.21875 27.697266 C 65.896135 28.160326 66.552092 28.652154 67.181641 29.171875 A 0.50014932 0.50014932 0 0 0 67.818359 28.400391 C 67.163908 27.860112 66.481865 27.351987 65.78125 26.873047 A 0.50005 0.50005 0 0 0 65.501953 26.78125 z M 38.505859 34.007812 C 37.845251 34.007813 36.824284 34.260032 35.978516 35.199219 C 35.271123 35.972723 32.998047 38.173727 32.998047 42.396484 C 32.998047 46.679817 36.023022 50.663593 36.412109 51.195312 L 36.414062 51.199219 L 36.416016 51.201172 C 36.430436 51.220332 36.575724 51.438775 36.775391 51.734375 C 36.975058 52.029975 37.248201 52.42704 37.589844 52.898438 C 38.273129 53.841229 39.231039 55.081376 40.439453 56.410156 C 42.856281 59.067717 46.270549 62.086384 50.5 63.777344 L 50.5 63.779297 C 53.950904 65.155835 56.049506 65.717908 57.503906 65.916016 C 58.958307 66.114123 59.774729 65.934404 60.470703 65.871094 L 60.472656 65.871094 C 61.387233 65.783994 62.594991 65.255966 63.746094 64.501953 C 64.897196 63.747941 65.973248 62.780676 66.378906 61.625 C 66.731316 60.624677 66.90952 59.697083 66.972656 58.958984 C 67.004226 58.589935 67.006568 58.268044 66.986328 58 C 66.966088 57.731956 66.952928 57.536276 66.816406 57.300781 L 66.814453 57.300781 C 66.637307 56.996725 66.369529 56.822032 66.078125 56.660156 C 65.787163 56.498526 65.449818 56.34545 65.052734 56.144531 L 65.050781 56.144531 C 64.637858 55.933746 63.442559 55.335311 62.248047 54.751953 C 61.052867 54.16827 59.91589 53.618524 59.449219 53.445312 L 59.447266 53.445312 C 59.064546 53.305532 58.679978 53.164003 58.230469 53.216797 C 57.78096 53.269587 57.352991 53.568619 57.033203 54.052734 C 56.544054 54.793239 54.963453 56.687978 54.5 57.222656 L 54.5 57.224609 L 54.498047 57.224609 C 54.307125 57.445275 54.196764 57.501114 54.064453 57.517578 C 53.932143 57.534038 53.705281 57.493568 53.341797 57.3125 L 53.345703 57.316406 C 52.873162 57.075171 52.068986 56.779112 50.955078 56.175781 C 49.841171 55.57245 48.447878 54.678493 46.929688 53.306641 C 44.585287 51.188617 42.970013 48.538118 42.507812 47.734375 L 42.507812 47.732422 C 42.322359 47.412661 42.342497 47.293967 42.390625 47.162109 C 42.438345 47.031376 42.583064 46.859731 42.78125 46.658203 L 42.785156 46.654297 C 43.200691 46.240138 43.642306 45.646556 44.033203 45.185547 L 44.035156 45.183594 L 44.035156 45.181641 C 44.474846 44.654232 44.641734 44.250708 44.908203 43.716797 L 44.910156 43.714844 L 44.910156 43.712891 C 45.255851 43.00208 45.073483 42.306015 44.84375 41.833984 C 44.81903 41.781934 44.67238 41.42699 44.486328 40.964844 C 44.299771 40.501443 44.059641 39.903463 43.804688 39.267578 C 43.294778 37.995809 42.722418 36.57638 42.353516 35.746094 C 42.023682 35.00017 41.647885 34.547881 41.222656 34.298828 C 40.798805 34.050582 40.378251 34.037375 40.085938 34.027344 L 40.082031 34.027344 C 39.59203 34.006824 39.04652 34.007812 38.505859 34.007812 z M 38.505859 35.007812 C 39.047859 35.007812 39.583912 35.008017 40.042969 35.027344 L 40.044922 35.027344 L 40.046875 35.027344 C 40.336463 35.037344 40.523526 35.048914 40.716797 35.162109 C 40.910068 35.275306 41.161287 35.521315 41.439453 36.150391 L 41.439453 36.152344 C 41.792551 36.947058 42.367862 38.370894 42.876953 39.640625 C 43.131499 40.275491 43.371026 40.871978 43.558594 41.337891 C 43.746162 41.803803 43.868468 42.11061 43.943359 42.267578 L 43.943359 42.269531 L 43.945312 42.271484 C 44.117584 42.625453 44.200021 42.888202 44.011719 43.275391 C 43.732078 43.836093 43.628816 44.10771 43.267578 44.541016 L 43.271484 44.539062 C 42.849498 45.036737 42.395601 45.631526 42.076172 45.949219 L 42.074219 45.951172 L 42.072266 45.953125 C 41.866106 46.162324 41.597043 46.42067 41.451172 46.820312 C 41.3053 47.219955 41.353032 47.735136 41.642578 48.234375 C 42.131246 49.08401 43.779342 51.807915 46.259766 54.048828 C 47.843016 55.479235 49.308033 56.420713 50.478516 57.054688 C 51.649358 57.688856 52.55612 58.035267 52.892578 58.207031 L 52.894531 58.207031 L 52.896484 58.208984 C 53.348 58.433911 53.76331 58.562551 54.1875 58.509766 C 54.611115 58.457056 54.970009 58.206586 55.253906 57.878906 C 55.740453 57.317584 57.27629 55.501011 57.869141 54.603516 C 58.090353 54.268631 58.203462 54.22569 58.345703 54.208984 C 58.487944 54.192274 58.744235 54.253544 59.103516 54.384766 C 59.387252 54.490292 60.619807 55.069829 61.808594 55.650391 C 62.998414 56.231457 64.200934 56.832627 64.597656 57.035156 L 64.599609 57.035156 C 65.017738 57.246782 65.358451 57.403579 65.591797 57.533203 C 65.825143 57.662827 65.927318 57.761791 65.951172 57.802734 C 65.914652 57.739734 65.975324 57.878684 65.990234 58.076172 C 66.005144 58.273659 66.002419 58.547971 65.974609 58.873047 C 65.918999 59.523198 65.758137 60.377292 65.435547 61.292969 C 65.166206 62.060292 64.247616 62.979278 63.199219 63.666016 C 62.150821 64.352753 60.955329 64.820103 60.378906 64.875 C 59.591675 64.94676 58.967575 65.104839 57.638672 64.923828 C 56.308822 64.742686 54.27919 64.209071 50.871094 62.849609 C 46.851545 61.242569 43.534109 58.32722 41.179688 55.738281 C 40.002477 54.443812 39.065309 53.232645 38.398438 52.3125 C 38.065002 51.852427 37.799306 51.465642 37.603516 51.175781 C 37.407726 50.885921 37.302422 50.715952 37.214844 50.599609 C 36.797398 50.029115 33.998047 46.195201 33.998047 42.396484 C 33.998047 38.519242 35.92619 36.737542 36.716797 35.873047 L 36.716797 35.871094 L 36.71875 35.871094 C 37.356331 35.161334 38.097339 35.007812 38.505859 35.007812 z"></path>
											</svg>
										</span>
										<span class="nav-text">
											Support
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
																	<a href="{{ url($lv2['Link']) }}" class="nav-link sub-nav-link">
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
									
									<div class="topbar">
										<div class="dropdown btn btn-danger">
											<div class="topbar-item">
												<div class="btn btn-icon w-auto btn-clean d-flex align-items-center pr-1 ps-3">
													<span class="symbol symbol-35 symbol-light-success">
														<span class="symbol-label font-size-h5 ">
															<img src = "{{ $cData[0]['icon'] }}" width="20px" height="20px">
															<!-- <svg width="20px" height="20px" viewBox="0 0 16 16"
																class="bi bi-person-fill" fill="currentColor"
																xmlns="http://www.w3.org/2000/svg">
																<path fill-rule="evenodd"
																	d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
															</svg> -->
														</span>
													</span>
													<label></label>
													<a href="{{ url('companysetting') }}" class="text-dark-50 font-size-base d-none d-xl-inline me-3"> {{ $cData[0]['NamaPartner'] }}</a>
												</div>
											</div>

										</div>
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
							<a href="{{ url('booking/Q0wwMDAz') }}" class="btn btn-primary white me-2">BOOKING</a>
						</div>		
						
						<div class="posicon d-lg-block d-none">
							<a href="{{ url('fpenjualan/pos') }}" class="btn btn-primary white me-2">POS</a>
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
									<span class="text-dark-50 font-size-base d-none d-xl-inline me-3">{{ Auth::user()->name }}</span>
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

								<a href="{{ route('logout') }}" class="dropdown-item">
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
						<span class="text-muted font-weight-bold me-2">2024©</span>
						<a href="https://dstechsmart.com/" target="_blank" class="text-dark-75 text-hover-primary">dstechsmart.com</a>
					</div>

					<div class="nav nav-dark">
						<a href="https://api.whatsapp.com/send/?phone=6282258493130&text=Saya%20ada%20kendala%20di%20PoS&type=phone_number&app_absent=0" target="_blank" class="nav-link pl-0 pr-0">Contact</a>
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
	<ul class="sticky-toolbar nav flex-column bg-primary" title="Setting" style="display: none;">

		<li class="nav-item" id="kt_demo_panel_toggle" data-bs-toggle="tooltip" title="" data-bs-placement="right"
			data-original-title="Check out more demos">
			<a class="btn btn-sm btn-icon text-white" href="#">
				<svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-gear fa-spin" fill="currentColor"
					xmlns="http://www.w3.org/2000/svg">
					<path fill-rule="evenodd"
						d="M8.837 1.626c-.246-.835-1.428-.835-1.674 0l-.094.319A1.873 1.873 0 0 1 4.377 3.06l-.292-.16c-.764-.415-1.6.42-1.184 1.185l.159.292a1.873 1.873 0 0 1-1.115 2.692l-.319.094c-.835.246-.835 1.428 0 1.674l.319.094a1.873 1.873 0 0 1 1.115 2.693l-.16.291c-.415.764.42 1.6 1.185 1.184l.292-.159a1.873 1.873 0 0 1 2.692 1.116l.094.318c.246.835 1.428.835 1.674 0l.094-.319a1.873 1.873 0 0 1 2.693-1.115l.291.16c.764.415 1.6-.42 1.184-1.185l-.159-.291a1.873 1.873 0 0 1 1.116-2.693l.318-.094c.835-.246.835-1.428 0-1.674l-.319-.094a1.873 1.873 0 0 1-1.115-2.692l.16-.292c.415-.764-.42-1.6-1.185-1.184l-.291.159A1.873 1.873 0 0 1 8.93 1.945l-.094-.319zm-2.633-.283c.527-1.79 3.065-1.79 3.592 0l.094.319a.873.873 0 0 0 1.255.52l.292-.16c1.64-.892 3.434.901 2.54 2.541l-.159.292a.873.873 0 0 0 .52 1.255l.319.094c1.79.527 1.79 3.065 0 3.592l-.319.094a.873.873 0 0 0-.52 1.255l.16.292c.893 1.64-.902 3.434-2.541 2.54l-.292-.159a.873.873 0 0 0-1.255.52l-.094.319c-.527 1.79-3.065 1.79-3.592 0l-.094-.319a.873.873 0 0 0-1.255-.52l-.292.16c-1.64.893-3.433-.902-2.54-2.541l.159-.292a.873.873 0 0 0-.52-1.255l-.319-.094c-1.79-.527-1.79-3.065 0-3.592l.319-.094a.873.873 0 0 0 .52-1.255l-.16-.292c-.892-1.64.902-3.433 2.541-2.54l.292.159a.873.873 0 0 0 1.255-.52l.094-.319z" />
					<path fill-rule="evenodd"
						d="M8 5.754a2.246 2.246 0 1 0 0 4.492 2.246 2.246 0 0 0 0-4.492zM4.754 8a3.246 3.246 0 1 1 6.492 0 3.246 3.246 0 0 1-6.492 0z" />
				</svg>
			</a>
		</li>
	</ul>
	<div id="kt_color_panel" class="offcanvas offcanvas-right kt-color-panel p-5">
		<div class="offcanvas-header d-flex align-items-center justify-content-between pb-3">
			<h4 class="font-size-h4 font-weight-bold m-0">Theme Config
			</h4>
			<a href="#" class="btn btn-sm btn-icon btn-light btn-hover-primary" id="kt_color_panel_close">
				<svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-x" fill="currentColor"
					xmlns="http://www.w3.org/2000/svg">
					<path fill-rule="evenodd"
						d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
				</svg>
			</a>
		</div>
		<hr>
		<div class="offcanvas-content">
			<!-- Theme options starts -->
			<div id="customizer-theme-layout" class="customizer-theme-layout">

				<h5 class="mt-1">Theme Layout</h5>
				<div class="theme-layout">
					<div class="d-flex justify-content-start">
						<div class="my-3">
							<div class="btn-group btn-group-toggle">
								<label class="btn btn-primary p-2 active">
									<input type="radio" name="layoutOptions" value="false" id="radio-light" checked="">
									Light
								</label>
								<label class="btn btn-primary p-2">
									<input type="radio" name="layoutOptions" value="false" id="radio-dark"> Dark
								</label>

							</div>

						</div>

					</div>
				</div>
				<hr>
				<h5 class="mt-1">RTL Layout</h5>
				<div class="rtl-layout">
					<div class="d-flex justify-content-start">
						<div class="my-3 btn-rtl">
							<div class="toggle">
								<span class="circle"></span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<hr>

			<!-- Theme options starts -->
			<div id="customizer-theme-colors" class="customizer-theme-colors">
				<h5>Theme Colors</h5>
				<!-- <input id="ColorPicker1" class="colorpicker-theme" type="color" value="#ae69f5" name="Background"> -->
				<ul class="list-inline unstyled-list d-flex">
					<li class="color-box me-2">
						<div id="color-theme-default" class="d-flex rounded w-20px h-20px" style="background-color: #ae69f5d9;">
						</div>
					</li>
					<li class="color-box me-2">
						<div id="color-theme-blue" class="d-flex rounded w-20px h-20px" style="background-color: blue;">
						</div>
					</li>
					<li class="color-box me-2">
						<div id="color-theme-red" class="d-flex rounded w-20px h-20px" style="background-color: red;">
						</div>
					</li>
					<li class="color-box me-2">
						<div id="color-theme-green" class="d-flex rounded w-20px h-20px" style="background-color: green;">
						</div>
					</li>
					<li class="color-box me-2">
						<div id="color-theme-yellow" class="d-flex rounded w-20px h-20px" style="background-color: #ffc107;">
						</div>
					</li>
					<li class="color-box me-2">
						<div id="color-theme-navy-blue" class="d-flex rounded w-20px h-20px" style="background-color: #000080;">
						</div>
					</li>

				</ul>
				<hr>
			</div>


		</div>
	</div>

	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="{{asset('js/plugin.bundle.min.js')}}"></script>
	<script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
	
	<!-- Dev Express -->
	<!-- <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/23.2.5/css/dx.light.css">
	<script type="text/javascript" src="https://cdn3.devexpress.com/jslib/23.2.5/js/dx.all.js"></script> -->
	<link href="{{ asset('devexpress/dx.light.css')}}" rel="stylesheet" type="text/css" />
	<script src="{{asset('devexpress/dx.all.js')}}"></script>
	<script src="{{asset('devexpress/jspdf.umd.min.js')}}"></script>
	<script src="{{asset('devexpress/jspdf.plugin.autotable.min.js')}}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/babel-polyfill/7.4.0/polyfill.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.1.1/exceljs.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.2/FileSaver.min.js"></script>

	<!-- End DevExpress -->
	<script src="{{asset('js/slick.min.js')}}"></script>
	<script src="{{asset('api/jqueryvalidate/jquery.validate.min.js')}}"></script>
	<script src="{{asset('api/apexcharts/apexcharts.js')}}"></script>
	{{-- <script src="{{asset('api/apexcharts/scriptcharts.js')}}"></script> --}}
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
	<link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script><script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
	<script>
		// In your Javascript (external .js resource or <script> tag)
		jQuery(document).ready(function() {
			jQuery('body').addClass('color-theme-red');
			jQuery('.js-example-basic-single').select2();
			var options = {
				debug: 'info',
				modules: {
					toolbar: '#toolbar'
				},
				placeholder: 'Compose an epic...',
				readOnly: true,
				theme: 'snow'
			};
			console.log(options);
		});
	</script>
	@include('sweetalert::alert')

	@stack('scripts')
</body>
<!--end::Body-->



</html>