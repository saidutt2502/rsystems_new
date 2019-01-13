<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Rsystems | User Login</title>

		<meta name="description" content="User login page" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="/core/css/bootstrap.min.css" />
		<link rel="stylesheet" href="/core/font-awesome/4.5.0/css/font-awesome.min.css" />

		<!-- text fonts -->
		<link rel="stylesheet" href="/core/css/fonts.googleapis.com.css" />

		<!-- ace styles -->
		<link rel="stylesheet" href="/core/css/ace.min.css" />

		<!--[if lte IE 9]>
			<link rel="stylesheet" href="/core/css/ace-part2.min.css" />
		<![endif]-->
		<link rel="stylesheet" href="/core/css/ace-rtl.min.css" />

		<!--[if lte IE 9]>
		  <link rel="stylesheet" href="/core/css/ace-ie.min.css" />
		<![endif]-->

		<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

		<!--[if lte IE 8]>
		<script src="/core/js/html5shiv.min.js"></script>
		<script src="/core/js/respond.min.js"></script>
		<![endif]-->
	</head>

	<body class="login-layout light-login ">
		<div class="main-container">
			<div class="main-content">
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<div class="login-container">
							<div class="center">
								<h1>
									<i class="ace-icon fa fa-leaf green"></i>
									<span class="red">User</span>
									<span class="white grey" id="id-text2">RSystems</span>
								</h1>
								<h4 class="blue" id="id-company-text">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Rosenberger | India</h4>
							</div>

							<div class="space-6"></div>

							<div class="position-relative">
								<div id="login-box" class="login-box visible widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header blue lighter bigger">
												<i class="ace-icon fa fa-coffee green"></i>
												Login
											</h4>

											<div class="space-6"></div>
											@if (session('status'))
												<div class="alert alert-success">
													{{ session('status') }}
												</div>
											@endif
											<form method="POST" action="{{ route('login') }}" autocomplete="off">
                                                @csrf
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="text" name="email" class="form-control" placeholder="Email" />
															<i class="ace-icon fa fa-user"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="password" name="password" class="form-control" placeholder="Password" />
															<i class="ace-icon fa fa-lock"></i>
														</span>
													</label>

		@php $locations = DB::table('rs_locations')->get(); @endphp

													<label class="block clearfix">
														<select required name="location" class="form-control" id="form-field-select-1">
																<option value="">Select Location</option>
															@foreach($locations as $each_location)
																<option value="{{$each_location->id}}">{{$each_location->name}}</option>
															@endforeach
														</select>
													</label>

													<div class="space"></div>

													<div class="clearfix">
														<label class="inline">
															<input type="checkbox" value="true" class="ace" name="remember" > 
															<span class="lbl"> Remember Me</span>
														</label>

														<button type="submit" class="width-35 pull-right btn btn-sm btn-primary">
															<i class="ace-icon fa fa-key"></i>
															<span class="bigger-110">Login</span>
														</button>
													</div>

													<div class="space-4"></div>
												</fieldset>
											</form>
										</div><!-- /.widget-main -->

										<div class="toolbar clearfix">
											<div>
												<a href="#" data-target="#forgot-box" class="forgot-password-link">
													<i class="ace-icon fa fa-arrow-left"></i>
													I forgot my password
												</a>
											</div>

											<div>
												<a href="#" data-target="#signup-box" class="user-signup-link">
													I want to register
													<i class="ace-icon fa fa-arrow-right"></i>
												</a>
											</div>
										</div>
									</div><!-- /.widget-body -->
								</div><!-- /.login-box -->

								<div id="forgot-box" class="forgot-box widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header red lighter bigger">
												<i class="ace-icon fa fa-key"></i>
												Retrieve Password
											</h4>

											<div class="space-6"></div>
											<p>
												Enter your email and to receive instructions
												@if (session('status'))
													<div class="alert alert-success" role="alert">
														{{ session('status') }}
													</div>
												@endif
											</p>
											<form method="POST" action="{{ route('password.email') }}" aria-label="{{ __('Reset Password') }}">
                       							 @csrf
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="email" class="form-control" placeholder="Email" name="email" />
															<i class="ace-icon fa fa-envelope"></i>
														</span>
													</label>

													<div class="clearfix">
														<button type="submit" class="width-35 pull-right btn btn-sm btn-danger">
															<i class="ace-icon fa fa-lightbulb-o"></i>
															<span class="bigger-110">Send Me!</span>
														</button>
													</div>
												</fieldset>
											</form>
										</div><!-- /.widget-main -->

										<div class="toolbar center">
											<a href="#" data-target="#login-box" class="back-to-login-link">
												Back to login
												<i class="ace-icon fa fa-arrow-right"></i>
											</a>
										</div>
									</div><!-- /.widget-body -->
								</div><!-- /.forgot-box -->

								<div id="signup-box" class="signup-box widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header green lighter bigger">
												<i class="ace-icon fa fa-users blue"></i>
												New User Registration
											</h4>

											<div class="space-6"></div>
											<p> Enter your details to begin: </p>
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input  id="emp_email" type="email" class="form-control" placeholder="Email" />
															<i class="ace-icon fa fa-envelope"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input  id="emp_name" type="text" class="form-control" placeholder="Name" />
															<i class="ace-icon fa fa-user"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input id="emp_id" type="text" class="form-control" placeholder="Employee ID" />
															<i class="ace-icon fa fa-user"></i>
														</span>
													</label>

													<label class="block clearfix">
														<select name="location" class="form-control" id="emp_location">
																<option value="0">Select Location</option>
															@foreach($locations as $each_location)
																<option value="{{$each_location->id}}">{{$each_location->name}}</option>
															@endforeach
														</select>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input id="emp_password" type="password" class="form-control" placeholder="Password" />
															<i class="ace-icon fa fa-lock"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input id="r_password" type="password" class="form-control" placeholder="Repeat password" />
															<i class="ace-icon fa fa-retweet"></i>
														</span>
													</label>

													<div class="space-24"></div>

													<div class="clearfix">
														<button type="reset" class="width-30 pull-left btn btn-sm">
															<i class="ace-icon fa fa-refresh"></i>
															<span class="bigger-110">Reset</span>
														</button>

														<button id="add_user" type="button" class="width-65 pull-right btn btn-sm btn-success">
															<span class="bigger-110">Register</span>

															<i class="ace-icon fa fa-arrow-right icon-on-right"></i>
														</button>
													</div>
												</fieldset>
										</div>

										<div class="toolbar center">
											<a href="#" data-target="#login-box" class="back-to-login-link">
												<i class="ace-icon fa fa-arrow-left"></i>
												Back to login
											</a>
										</div>
									</div><!-- /.widget-body -->
								</div><!-- /.signup-box -->
							</div><!-- /.position-relative -->
						</div>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.main-content -->
		</div><!-- /.main-container -->

		    <input type="hidden" value="{{URL::to('step')}}" id="url_ajax">

		<!-- basic scripts -->

		<!--[if !IE]> -->
		<script src="/core/js/jquery-2.1.4.min.js"></script>

		<!-- <![endif]-->

		<!--[if IE]>
<script src="/core/js/jquery-1.11.3.min.js"></script>
<![endif]-->
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='/core/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>

		<!-- inline scripts related to this page -->
		<script type="text/javascript">
                jQuery(function($) {
                        $(document).on('click', '.toolbar a[data-target]', function(e) {
                            e.preventDefault();
                            var target = $(this).data('target');
                            $('.widget-box.visible').removeClass('visible');//hide others
                            $(target).addClass('visible');//show target
						});
						
						$('#add_user').click(function(){
							if($('#emp_password').val() != $('#r_password').val()){
									alert("Passwords Do not match");
							}else{
										$.ajax({
												type: 'post',
												url: $('#url_ajax').val(),
												data: {
													function_name: 'add_user_register',
													email: $('#emp_email').val(),
													password: $('#emp_password').val(),
													emp_id: $('#emp_id').val(),
													name: $('#emp_name').val(),
													loc_id: $('#emp_location').val(),
													'_token': $('input[name=_token]').val()
												},
												success: function (data) {
													if (data.success) {
															location.reload();
													}
												}
											});
								
						}
	
					});
				});
		</script>
	</body>
</html>
