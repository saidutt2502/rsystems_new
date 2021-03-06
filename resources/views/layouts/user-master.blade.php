<?php
$taxisettings=DB::table('rs_taxisettings')->where('location_id',session('location'))->first();

$stationary_admin=DB::table('rs_admin2modules')
->join('rs_location2department','rs_location2department.department','rs_admin2modules.department')
->where('rs_location2department.location',session('location'))
->where('rs_admin2modules.user_id',session('user_id'))
->where('rs_admin2modules.module_id','1')
->first();

$hk_admin=DB::table('rs_admin2modules')
->join('rs_location2department','rs_location2department.department','rs_admin2modules.department')
->where('rs_location2department.location',session('location'))
->where('rs_admin2modules.user_id',session('user_id'))
->where('rs_admin2modules.module_id','6')
->first();

$taxi_admin=DB::table('rs_admin2modules')
->join('rs_location2department','rs_location2department.department','rs_admin2modules.department')
->where('rs_location2department.location',session('location'))
->where('rs_admin2modules.user_id',session('user_id'))
->where('rs_admin2modules.module_id','2')
->first();

$gatepass_admin=DB::table('rs_admin2modules')
->join('rs_location2department','rs_location2department.department','rs_admin2modules.department')
->where('rs_location2department.location',session('location'))
->where('rs_admin2modules.user_id',session('user_id'))
->where('rs_admin2modules.module_id','3')
->first();

$safety_admin=DB::table('rs_admin2modules')
->join('rs_location2department','rs_location2department.department','rs_admin2modules.department')
->where('rs_location2department.location',session('location'))
->where('rs_admin2modules.user_id',session('user_id'))
->where('rs_admin2modules.module_id','4')
->first();

$production_admin=DB::table('rs_admin2modules')
				  ->join('rs_location2department','rs_location2department.department','rs_admin2modules.department')
				  ->where('rs_location2department.location',session('location'))
				  ->where('rs_admin2modules.user_id',session('user_id'))
				  ->where('rs_admin2modules.module_id','5')
				  ->first();
$user_type=DB::table('users')->where('id',session('user_id'))->value('user_type_id');

$user_admin=DB::table('admins')
				  ->join('users','users.email','admins.email')
				  ->where('users.id',session('user_id'))
				  ->select('admins.*')
				  ->first();


$depts = DB::table('rs_tms_users2dept')
			->join('rs_tms_departments','rs_tms_departments.id','=','rs_tms_users2dept.dept_id')
			->where('rs_tms_users2dept.user_id',session('user_id'))
			->select('rs_tms_departments.id as id','rs_tms_departments.name as name')
			->get();
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Rsystems </title>

		<meta name="description" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="/core/css/bootstrap.min.css" />
		<link rel="stylesheet" href="/core/font-awesome/4.5.0/css/font-awesome.min.css" />

		<!-- page specific plugin styles -->

		<!-- text fonts -->
		<link rel="stylesheet" href="/core/css/fonts.googleapis.com.css" />

		<!-- ace styles -->
		<link rel="stylesheet" href="/core/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />

		<!--[if lte IE 9]>
			<link rel="stylesheet" href="/core/css/ace-part2.min.css" class="ace-main-stylesheet" />
		<![endif]-->
		<link rel="stylesheet" href="/core/css/ace-skins.min.css" />
		<link rel="stylesheet" href="/core/css/ace-rtl.min.css" />

		<!--[if lte IE 9]>
		  <link rel="stylesheet" href="/core/css/ace-ie.min.css" />
		<![endif]-->
		
		<link rel="stylesheet" href="/core/css/jquery-ui.custom.min.css" />
		<link rel="stylesheet" href="/core/css/jquery.gritter.min.css" />
		
        <!-- chosen css -->
        <link rel="stylesheet" href="/core/css/chosen.min.css" />

		<!-- inline styles related to this page -->
         @yield('css-files')

		<!-- ace settings handler -->
		<script src="/core/js/ace-extra.min.js"></script>

		<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

		<!--[if lte IE 8]>
		<script src="/core/js/html5shiv.min.js"></script>
		<script src="/core/js/respond.min.js"></script>
		<![endif]-->
	</head>

	<body class="no-skin">
	<div id="navbar" class="navbar navbar-default ace-save-state">
			<div class="navbar-container ace-save-state" id="navbar-container">
				<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
					<span class="sr-only">Toggle sidebar</span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>
				</button>

				<div class="navbar-header pull-left">
					
						<img src="/images/logo.jpg" height="44.5px" width="180px">
					
				</div>

				<div class="navbar-buttons navbar-header pull-right" role="navigation">
					<ul class="nav ace-nav">
					<!-- <li class="grey dropdown-modal">
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">
								<i class="ace-icon fa fa-tasks"></i>
								<span class="badge badge-grey">4</span>
							</a>

							<ul class="dropdown-menu-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
								<li class="dropdown-header">
									<i class="ace-icon fa fa-check"></i>
									4 Tasks to complete
								</li>

								<li class="dropdown-content">
									<ul class="dropdown-menu dropdown-navbar">
										<li>
											<a href="#">
												<div class="clearfix">
													<span class="pull-left">Software Update</span>
													<span class="pull-right">65%</span>
												</div>

												<div class="progress progress-mini">
													<div style="width:65%" class="progress-bar"></div>
												</div>
											</a>
										</li>
									</ul>
								</li>

								<li class="dropdown-footer">
									<a href="#">
										See tasks with details
										<i class="ace-icon fa fa-arrow-right"></i>
									</a>
								</li>
							</ul>
						</li> -->

						<!-- <li class="purple dropdown-modal">
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">
								<i class="ace-icon fa fa-bell icon-animated-bell"></i>
								<span class="badge badge-important">8</span>
							</a>

							<ul class="dropdown-menu-right dropdown-navbar navbar-pink dropdown-menu dropdown-caret dropdown-close">
								<li class="dropdown-header">
									<i class="ace-icon fa fa-exclamation-triangle"></i>
									8 Notifications
								</li>

								<li class="dropdown-content">
									<ul class="dropdown-menu dropdown-navbar navbar-pink">
										<li>
											<a href="#">
												<div class="clearfix">
													<span class="pull-left">
														<i class="btn btn-xs no-hover btn-pink fa fa-comment"></i>
														New Comments
													</span>
													<span class="pull-right badge badge-info">+12</span>
												</div>
											</a>
										</li>
									</ul>
								</li>

								<li class="dropdown-footer">
									<a href="#">
										See all notifications
										<i class="ace-icon fa fa-arrow-right"></i>
									</a>
								</li>
							</ul>
						</li> -->

						<!-- <li class="green dropdown-modal">
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">
								<i class="ace-icon fa fa-envelope icon-animated-vertical"></i>
								<span class="badge badge-success">5</span>
							</a>

							<ul class="dropdown-menu-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
								<li class="dropdown-header">
									<i class="ace-icon fa fa-envelope-o"></i>
									5 Messages
								</li>

								<li class="dropdown-content">
									<ul class="dropdown-menu dropdown-navbar">
										<li>
											<a href="#" class="clearfix">
												<img src="assets/images/avatars/avatar5.png" class="msg-photo" alt="Fred's Avatar" />
												<span class="msg-body">
													<span class="msg-title">
														<span class="blue">Fred:</span>
														Vestibulum id penatibus et auctor  ...
													</span>

													<span class="msg-time">
														<i class="ace-icon fa fa-clock-o"></i>
														<span>10:09 am</span>
													</span>
												</span>
											</a>
										</li>
									</ul>
								</li>

								<li class="dropdown-footer">
									<a href="inbox.html">
										See all messages
										<i class="ace-icon fa fa-arrow-right"></i>
									</a>
								</li>
							</ul>
						</li> -->

						<li class="light-blue dropdown-modal">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle">
								<img class="nav-user-photo" src="/core/images/avatars/avatar2.png" alt="Jason's Photo" />
								<span class="user-info">
									<small>Welcome,</small>
									<!-- Logged in user's Name -->
										<?php $name = DB::table('users')->where('id', session('user_id'))->value('name'); ?>
									{{$name}}
								</span>

								<i class="ace-icon fa fa-caret-down"></i>
							</a>

							<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
								<!-- <li>
									<a href="#">
										<i class="ace-icon fa fa-cog"></i>
										Settings
									</a>
								</li>

								<li>
									<a href="profile.html">
										<i class="ace-icon fa fa-user"></i>
										Profile
									</a>
								</li> -->

								<!-- <li class="divider"></li> -->

								<li>
                                        <a href="{{ route('logout') }}" class="waves-effect"  onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="ace-icon fa fa-power-off"></i>Logout</a><form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div><!-- /.navbar-container -->
		</div>

		<div class="main-container ace-save-state" id="main-container">
			<script type="text/javascript">
				try{ace.settings.loadState('main-container')}catch(e){}
			</script>

			<div id="sidebar" class="sidebar responsive ace-save-state">
				<script type="text/javascript">
					try{ace.settings.loadState('sidebar')}catch(e){}
				</script>

				<div class="sidebar-shortcuts" id="sidebar-shortcuts">				
				
					<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
					    
						<button class="btn btn-warning" id="taxi">
						<i class="ace-icon fa fa-taxi"></i>
						</button>
						
                        
						<button class="btn btn-info" id="stationary">
						<i class="ace-icon fa fa-pencil"></i>
						</button>
						

						<button class="btn btn-success" id="gatepass">
							<i class="ace-icon fa fa-sticky-note-o"></i>
						</button>

						<button class="btn btn-danger" id="issues">
							<i class="ace-icon fa fa-registered"></i>
						</button>
					</div>

					<!-- <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
						<span class="btn btn-success"></span>

						<span class="btn btn-info"></span>

						<span class="btn btn-warning"></span>

						<span class="btn btn-danger"></span>
					</div> -->
				</div><!-- /.sidebar-shortcuts -->

				<ul class="nav nav-list">
					<li id="dashboard" class="">
						<a href="/home">
							<i class="menu-icon fa fa-tachometer"></i>
							<span class="menu-text"> Dashboard </span>
						</a>

						<b class="arrow"></b>
					</li>
					@if($user_admin)
					@if($user_admin->user_type=='2')
					<li class="">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-cog"></i>
							<span class="menu-text"> Department  </span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu" id="inception-nav-menu">
							<li class="">
								<a href="/admin/oc_structure">
									<i class="menu-icon fa fa-caret-right"></i>
									Organisation Chart
								</a>

								<b class="arrow"></b>
							</li>
							<li class="" id="step2-menu-nav">
								<a href="/admin/hod_cc">
									<i class="menu-icon fa fa-caret-right"></i>
									Cost Centers
								</a>

								<b class="arrow"></b>
							</li>
							<li class="" id="step2-menu-nav">
								<a href="/admin/assign-admins">
									<i class="menu-icon fa fa-caret-right"></i>
									Module Information
								</a>

								<b class="arrow"></b>
							</li>
						</ul>
					</li>
					@endif
					@endif
					<li id="approvals_menu_id" class="">
						<a href="/approvals">
							<i class="menu-icon fa fa-check-square-o  "></i>
							<span class="menu-text"> Approvals </span>
						</a>

						<b class="arrow"></b>
					</li>
					@if($stationary_admin || $safety_admin )
					<li id="approvals_menu_id" class="">
						<a href="/issues-approvals">
							<i class="menu-icon fa fa-share-square-o"></i>
							<span class="menu-text"> Issues </span>
						</a>

						<b class="arrow"></b>
					</li>
					@endif
					<li class="">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-pencil "></i>
							<span class="menu-text"> Stationary </span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu" id="item-nav-menu">
						@if($stationary_admin)
							<li class="">
								<a href="/items">
									<i class="menu-icon fa fa-caret-right"></i>
									Stock Master
								</a>

								<b class="arrow"></b>
							</li>
						@endif	
							<li class="" id="stationary_request_li_to_be">
								<a href="/my-request_st">
									<i class="menu-icon fa fa-caret-right"></i>
									Request Form&nbsp;
								</a>

								<b class="arrow"></b>
							</li>
						</ul>
					</li>
					<li class="">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-taxi "></i>
							<span class="menu-text"> Taxi </span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu" id="">
						@if($taxi_admin)
							<li class="">
								<a href="/taxi-settings">
									<i class="menu-icon fa  fa-caret-right"></i>
									Taxi Settings
								</a>

								<b class="arrow"></b>
							</li>
							@endif
							@if($taxi_admin)
							@if($taxisettings)
							<li class="">
								<a href="/taxi-details">
									<i class="menu-icon fa  fa-caret-right"></i>
									Taxi Details
								</a>

								<b class="arrow"></b>
							</li>
							@endif
							@endif
							<li class="">
								<a href="/taxi-request">
									<i class="menu-icon fa  fa-caret-right"></i>
									 Request Form
								</a>

								<b class="arrow"></b>
							</li>
							@if($taxi_admin)
							<li class="">
								<a href="/taxi-schedule">
									<i class="menu-icon fa  fa-caret-right"></i>
									Schedule and Validation
								</a>

								<b class="arrow"></b>
							</li>
							@endif
                            @if($taxi_admin || $user_type=='2')
							<li class="">
								<a href="/taxi-closing">
									<i class="menu-icon fa  fa-caret-right"></i>
									Taxi Closing
								</a>

								<b class="arrow"></b>
							</li>
							@endif
							@if($taxi_admin)
							<li class="">
								<a href="/taxi-report">
									<i class="menu-icon fa  fa-caret-right"></i>
									Reports
								</a>

								<b class="arrow"></b>
							</li>
							@endif
							<!-- @if($taxi_admin)
							<li class="">
								<a href="/taxi-old_records">
									<i class="menu-icon fa  fa-caret-right"></i>
									Old Records
								</a>

								<b class="arrow"></b>
							</li>
							@endif -->
						</ul>
					</li>

                    <li class="">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-sticky-note-o"></i>
							<span class="menu-text"> Gatepass </span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu" id="item-nav-menu_gp">
						@if($gatepass_admin)
							<li class="">
								<a href="/gp_settings">
									<i class="menu-icon fa fa-caret-right"></i>
									Gatepass Settings
								</a>

								<b class="arrow"></b>
							</li>
							@endif
							<li class="" id="gp_request_li_to_be">
								<a href="/my-request_gp">
									<i class="menu-icon fa fa-caret-right"></i>
									 Request Form
								</a>

								<b class="arrow"></b>
							</li>
							@if($gatepass_admin || $user_type=='2')
							<li class="">
								<a href="/gp_close">
									<i class="menu-icon fa fa-caret-right"></i>
									Gatepass Closing
								</a>

								<b class="arrow"></b>
							</li>
							@endif
							@if($gatepass_admin)
							<li class="">
								<a href="/gp_reports">
									<i class="menu-icon fa fa-caret-right"></i>
									Reports
								</a>

								<b class="arrow"></b>
							</li>
							@endif
						</ul>
                    </li>
					<li class="">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-exclamation-triangle"></i>
							<span class="menu-text"> Safety </span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu" id="item-nav-menu_st">
						@if($safety_admin)
							<li class="">
								<a href="/shoes">
									<i class="menu-icon fa fa-caret-right"></i>
									 Stock Master
								</a>

								<b class="arrow"></b>
							</li>
							@endif

							<li class="" id="st_request_li_to_be">
								<a href="/my-request_shoes">
									<i class="menu-icon fa fa-caret-right"></i>
									 Request Form
								</a>

								<b class="arrow"></b>
							</li>
						</ul>
                    </li>

					@if($hk_admin || $user_type=='3')
					<li class="">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-odnoklassniki"></i>
							<span class="menu-text"> Housekeeping </span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu" id="item-nav-menu_hk">
						@if($hk_admin)
							<li class="">
								<a href="/housekeeping_master">
									<i class="menu-icon fa fa-caret-right"></i>
									Stock Master
								</a>

								<b class="arrow"></b>
							</li>
						@endif	
							<li class="" id="hk_request_li_to_be">
								<a href="/my-request_hk">
									<i class="menu-icon fa fa-caret-right"></i>
									Request Form&nbsp;
								</a>

								<b class="arrow"></b>
							</li>
						</ul>
					</li>
					@endif
                    <li class="">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-th-list"></i>
							<span class="menu-text"> Production Tracker </span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu" id="item-nav-menu">
							@if($production_admin)
							<li class="">
								<a href="/production">
									<i class="menu-icon fa fa-caret-right"></i>
									 Settings
								</a>

								<b class="arrow"></b>
							</li>
							<li class="">
								<a href="/edit-production">
									<i class="menu-icon fa fa-caret-right"></i>
									 Planners
								</a>

								<b class="arrow"></b>
							</li>
							@endif
							<li class="">
								<a href="/production-schedule">
									<i class="menu-icon fa fa-caret-right"></i>
									 Tracker
								</a>

								<b class="arrow"></b>
							</li>
						</ul>
                    </li>


					<li class="">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-registered  "></i>
							<span class="menu-text"> Rsystem Issues </span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu" id="">
							<li class="">
								<a href="/issue-tracker">
									<i class="menu-icon fa  fa-caret-right"></i>
									Tracker
								</a>

								<b class="arrow"></b>
							</li>

							<!-- <li class="">
								<a href="/issue-tracker_serv">
									<i class="menu-icon fa  fa-caret-right"></i>
									Tracker
								</a>

								<b class="arrow"></b>
							</li> -->
						</ul>
					</li>

					<!-- <li class="">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa fa-wrench"></i>
							<span class="menu-text"> Tool Management </span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu" id="item-nav-menu_tms">
						
							<li class="">
								<a href="/tms_deptadmin">
									<i class="menu-icon fa fa-caret-right"></i>
									 Departments &amp Administrators
								</a>

								<b class="arrow"></b>
							</li>

							<li class="">
								<a href="/tms_sup">
									<i class="menu-icon fa fa-caret-right"></i>
									 Supervisors
								</a>

								<b class="arrow"></b>
							</li>

							<li class="">
								<a href="/tms_wlp">
									<i class="menu-icon fa fa-caret-right"></i>
									 Workstations,Lines &amp Products
								</a>

								<b class="arrow"></b>
							</li>

							<li id="dept">
								<a href="/tms_wlp">
									<i class="menu-icon fa fa-caret-right"></i>
									 Tools
								</a>

								<b class="arrow"></b>
							</li>

						


						</ul>
                    </li> -->

                    <!-- <li class="">
                            <a href="{{ route('logout') }}" class="waves-effect"  onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="menu-icon fa fa-power-off"></i>
							<span class="menu-text">Logout </span></a><form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
						<b class="arrow"></b>
					</li> -->
				</ul><!-- /.nav-list -->

				<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
					<i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
				</div>
			</div>

			<div class="main-content">
				<div class="main-content-inner">
					<div class="breadcrumbs ace-save-state" id="breadcrumbs">
						<ul class="breadcrumb">
                        <li>
                            <i class="ace-icon fa fa-home home-icon"></i><a href="#">Home</a>
                        </li>
                           @yield('breadcrumb')
						</ul><!-- /.breadcrumb -->
                    </div>
                    
                    
					<div class="page-content">

                        <div class="page-header">
                                @yield('page-header')
                        </div>

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
                                        @yield('main-content')
										<!-- Modal -->
<div id="myModal_selectdept" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
 <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Department</h4>
      </div>
      <div class="modal-body">
      <label>Select Department</label>
      <div class="input-group col-sm-12">
      <select  id="select_dept" name="select_dept" class="chosen-container chosen-container-single chosen-select">
	   @foreach($depts as $eachDept)
		<option value="{{$eachDept->id}}">{{$eachDept->name}}</option>
	   @endforeach
	  </select> 
      </div>
      </div>
      <br><br><br>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="confirm_proceed">Proceed</button>
      </div>
    </div>

  </div>
</div>
<!-- Modal End -->
								<!-- PAGE CONTENT ENDS -->
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->

			<div class="footer">
				<div class="footer-inner">
					<div class="footer-content">
						<span class="bigger-120">
							<b>Rosenberger|India</b> &copy; 
						</span>
					</div>
				</div>
			</div>

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->

		<!-- basic scripts -->

		<!--[if !IE]> -->
		<script src="/core/js/jquery-2.1.4.min.js"></script>

		<!-- <![endif]-->

		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='/core/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="/core/js/bootstrap.min.js"></script>

		<!-- ace scripts -->
		<script src="/core/js/ace-elements.min.js"></script>
		<script src="/core/js/ace.min.js"></script>
		<script src="/core/js/jquery.gritter.min.js"></script>


		<!-- chosen scripts -->
		<script src="/core/js/chosen.jquery.min.js"></script>
		<script src="/core/js/menu.js"></script>

		 <script src="{{ asset('master/user.js') }}" defer></script>
		

		<!-- inline scripts related to this page -->
            @yield('js-files')
	</body>
</html>
