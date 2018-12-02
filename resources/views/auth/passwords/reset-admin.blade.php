<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Rsystems | Admin Reset Password</title>

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
									<span class="red">Admin</span>
									<span class="white grey" id="id-text2">RSystems</span>
								</h1>
								<h4 class="blue" id="id-company-text">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Rosenberger | India</h4>
							</div>

							<div class="space-6"></div>

							<div class="position-relative">
								<div id="login-box" class="login-box visible widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header red lighter bigger">
												<i class="ace-icon fa fa-key"></i>
												Reset Password
											</h4>

											<div class="space-6"></div>
											<p>
												Enter your Details
											</p>
                                            <form method="POST" action="{{ route('admin.confirm_reset.submit') }}" >
                                                @csrf
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="email" class="form-control" placeholder="Email" name="email" />
															<i class="ace-icon fa fa-envelope"></i>
														</span>
													</label>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="password" class="form-control" placeholder="secret key" name="str_random" />
															<i class="ace-icon fa fa-key"></i>
														</span>
													</label>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="password" class="form-control" placeholder="Password" name="password" />
															<i class="ace-icon fa fa-key"></i>
														</span>
													</label>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="password" class="form-control" placeholder="Confirm Password" name="password_confirmation" />
														</span>
													</label>

													<div class="clearfix">
														<button type="submit" class="width-35 pull-right btn btn-sm btn-danger">
															<i class="ace-icon fa fa-lightbulb-o"></i>
															<span class="bigger-110">Change!</span>
														</button>
													</div>
												</fieldset>
											</form>
										</div><!-- /.widget-main -->
									</div><!-- /.widget-body -->
								</div><!-- /.forgot-box -->
							</div><!-- /.position-relative -->
						</div>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.main-content -->
		</div><!-- /.main-container -->

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
                    });
		</script>
	</body>
</html>
