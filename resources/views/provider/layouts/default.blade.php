<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <link href="{{ asset('web/img/fav.png') }}" rel="shortcut icon" type="image/x-icon"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ILC-Input Language Center') }}</title>


	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="{{ asset('backend/assets/css/icons/icomoon/styles.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('backend/assets/css/minified/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('backend/assets/css/minified/core.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('backend/assets/css/minified/components.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/assets/css/minified/colors.min.css') }}" rel="stylesheet" type="text/css">
    <link type="text/css" rel="stylesheet" href="{{ asset('backend/assets/summernote/summernote.css') }}" />
    <!-- /global stylesheets --> 
    <style>
        .add-new {
            color: #fff!important;
        }
        .add-new:hover {
            opacity: 1 !important;
        }
        .panel>.dataTables_wrapper .table-bordered {
            border: 1px solid #ddd;
        }
        .dataTables_length {
            margin: 20px 0 20px 20px;
        }
        .dataTables_filter {
            margin: 20px 0 20px 20px;
        }
        .dataTables_info {
            margin-bottom: 20px;
        }
        .dataTables_paginate {
            margin: 20px 0 20px 20px;
        }
        .action-icon {
            padding: 0px 10px 0 0;
        }

        .kv-fileinput-upload {
            display: none;
        }
    </style>
</head>
<body class="navbar-top">
    <div id="app">
        <!-- Main navbar -->
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-header">
                <a class="navbar-brand" href="{{route('provider.home')}}">
                    {{-- <img src="{{ asset('backend/assets/images/logo_light.png') }}" alt=""> --}}
                    <i class="icon-book text-size-mediam"></i>
                    Book Sharing
                </a>

                <ul class="nav navbar-nav pull-right visible-xs-block">
                    <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
                    <li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
                </ul>
            </div>

            <div class="navbar-collapse collapse" id="navbar-mobile">
                <ul class="nav navbar-nav">
                    <li>
                        <a class="sidebar-control sidebar-main-toggle hidden-xs">
                            <i class="icon-paragraph-justify3"></i>
                        </a>
                    </li>
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown dropdown-user">
                        <a class="dropdown-toggle" data-toggle="dropdown">
                            <img src="{{ asset('backend/assets/images/placeholder.jpg') }}" alt="">
                            <span>{{ $userInfo->name }}</span>
                            <i class="caret"></i>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href="{{route('provider.profile')}}"><i class="icon-user-plus"></i> My profile</a></li>
                            {{-- <li><a href="#"><i class="icon-coins"></i> My balance</a></li>
                            <li><a href="#"><span class="badge badge-warning pull-right">58</span> <i class="icon-comment-discussion"></i> Messages</a></li>
                            <li class="divider"></li> --}}
                            {{-- <li><a href="#"><i class="icon-cog5"></i> Account settings</a></li> --}}
                            <li><a href="{{ route('provider.logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();"><i class="icon-switch2"></i> Logout</a>
                                <form id="logout-form" action="{{ route('provider.logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /main navbar -->
        
        <!-- Page container -->
        <div class="page-container">
            <!-- Page content -->
            <div class="page-content">
                <!-- Main sidebar -->
                <div class="sidebar sidebar-main sidebar-fixed">
                    <div class="sidebar-content">
                        <!-- User menu -->
                        <div class="sidebar-user">
                            <div class="category-content">
                                <div class="media">
                                    <a href="#" class="media-left"><img src="{{ asset('backend/assets/images/placeholder.jpg') }}" class="img-circle img-sm" alt=""></a>
                                    <div class="media-body">
                                        <span class="media-heading text-semibold"> {{ Auth::guard('provider')->user()->name }} </span>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /user menu -->


                        <!-- Main navigation -->
                        <div class="sidebar-category sidebar-category-visible">
                            <div class="category-content no-padding">
                                <ul class="navigation navigation-main navigation-accordion">

                                    <!-- Default -->
                                    <li class="navigation-header"><span>Default</span> <i class="icon-menu" title="Main pages"></i></li>
                                    <li class="{{ (request()->is('provider/home')) ? 'active' : '' }}"><a href="{{route('provider.home')}}"><i class="icon-home4"></i> <span>Home</span></a></li>
                                    
                                    <!-- /Default -->

                                    <!-- Website Setup -->
                                    <li class="navigation-header"><span>Website Setup</span> <i class="icon-menu" title="Main pages"></i></li>
                                    <li>
                                        <a href="#"><i class="icon-stack2"></i> <span>Book</span></a>
                                        <ul>
                                            <li class="{{ (request()->is('provider/author*')) ? 'active' : '' }}">
                                                <a href="{{route('provider.author.index')}}">
                                                    <i class="icon-notebook"></i> 
                                                    <span>Author</span>
                                                </a>
                                            </li>
                                            <li class="{{ (request()->is('provider/bookCategory*')) ? 'active' : '' }}">
                                                <a href="{{route('provider.bookCategory.index')}}">
                                                    <i class="icon-notebook"></i> 
                                                    <span>Book Category</span>
                                                </a>
                                            </li>
                                            <li class="{{ (request()->is('provider/allBooks*')) ? 'active' : '' }}">
                                                <a href="{{route('provider.allBooks')}}">
                                                    <i class="icon-books"></i> 
                                                    @php($pendingBook = DB::table('books')->where('valid', 1)->where('approved_status', 0)->count())
                                                    <span>All Books</span>
                                                    <span class="text-danger" style="margin-left: 5px;">({{$pendingBook}})</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="#"><i class="icon-user"></i> <span>User</span></a>
                                        <ul>
                                            <li class="{{ (request()->is('provider/allUsers*')) ? 'active' : '' }}">
                                                <a href="{{route('provider.allUsers.index')}}">
                                                    <i class="icon-users"></i> 
                                                    <span>All Users</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="navigation-header"><span>Software Setup</span> <i class="icon-menu" title="Main pages"></i></li>
                                    <li>
                                        <a href="#"><i class="icon-stack2"></i> <span>Settings</span></a>
                                        <ul>
                                            <li class="{{ (request()->is('provider/language')) ? 'active' : '' }}">
                                                <a href="{{route('provider.language.index')}}"><i class="icon-home4"></i> <span>Language</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    
                                    <!-- /Website Setup -->

                                    <!-- Course Setup -->
                                    {{-- <li class="navigation-header"><span>Course Setup</span> <i class="icon-menu" title="Forms"></i></li>
                                    <li>
                                        <a href="#"><i class="icon-book3"></i> <span>Course Archive</span></a>
                                        <ul>
                                            <li class="{{ (request()->is('provider/teacher*')) ? 'active' : '' }}"><a href="{{route('provider.teacher.index')}}"><i class="icon-user-tie"></i> <span>Teacher</span></a></li>
                                            <li class="{{ (request()->is('provider/course*')) ? 'active' : '' }}"><a href="{{route('provider.course.index')}}"><i class="icon-book3"></i> <span>Course</span></a></li>
                                        </ul>
                                    </li>
                                    <li class="{{ (request()->is('provider/assignPackage*')) ? 'active' : '' }}"><a href="{{route('provider.assignPackage.index')}}"><i class="icon-books"></i> <span>Assign Courses</span></a></li>
                                    <li class="{{ (request()->is('provider/studentList*')) ? 'active' : '' }}"><a href="{{route('provider.studentList')}}"><i class="icon-user-tie"></i> <span>Student Login</span></a></li> --}}

                                    {{-- <li class="{{ (request()->is('provider/scheduledList*')) ? 'active' : '' }}"><a href="{{route('provider.scheduledListCourses')}}"><i class="icon-database-time2"></i> <span>Assign Schedules</span></a></li> --}}
                                    
                                    <!-- /Course Setup -->
                                </ul>
                            </div>
                        </div>
                        <!-- /main navigation -->

                    </div>
                </div>
                <!-- /main sidebar -->


                <!-- Main content -->
                <div class="content-wrapper">

                    @yield('content')

                </div>
                <!-- /main content -->

                
            </div>
            <!-- /page content -->
        </div>
        <!-- /page container -->
    </div>

    
	<!-- Core JS files -->
	<script type="text/javascript" src="{{ asset('backend/assets/js/plugins/loaders/pace.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/assets/js/core/libraries/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/assets/js/popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/assets/js/core/libraries/bootstrap.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('backend/assets/js/plugins/loaders/blockui.min.js') }}"></script>
    <!-- /core JS files -->
    <!-- /Bootbox JS files -->
    <script type="text/javascript" src="{{ asset('backend/assets/js/bootbox.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/assets/js/bootbox.locales.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('backend/assets/summernote/summernote.min.js') }}"></script>

	<!-- Theme JS files -->
	<script type="text/javascript" src="{{ asset('backend/assets/js/plugins/tables/datatables/datatables.min.js') }}"></script>
    <!-- Fixed Sidebar JS files -->
    <script type="text/javascript" src="{{ asset('backend/assets/js/plugins/ui/nicescroll.min.js') }}"></script>
    
    <!-- Sweet Alert JS files -->
    <script type="text/javascript" src="{{ asset('backend/assets/js/plugins/notifications/sweet_alert.min.js') }}"></script>

    
    <!-- Form JS files -->
    <script type="text/javascript" src="{{ asset('backend/assets/js/plugins/forms/validation/validate.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('backend/assets/js/plugins/forms/selects/bootstrap_multiselect.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/assets/js/plugins/forms/inputs/touchspin.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('backend/assets/js/core/libraries/jquery_ui/interactions.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('backend/assets/js/plugins/forms/selects/select2.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('backend/assets/js/plugins/forms/styling/switch.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('backend/assets/js/plugins/forms/styling/switchery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/assets/js/plugins/forms/styling/uniform.min.js') }}"></script>
    <!-- Form JS files -->

    <!-- Uploader JS files -->
    <script type="text/javascript" src="{{ asset('backend/assets/js/plugins/uploaders/fileinput.min.js') }}"></script>

    
    <!-- UserProfile JS files -->
	{{-- <script type="text/javascript" src="{{ asset('backend/assets/js/plugins/visualization/echarts/echarts.js') }}"></script> --}}
	
    <script type="text/javascript" src="{{ asset('backend/assets/js/core/app.js') }}"></script>
    <!-- Fixed Sidebar JS files -->
    <script type="text/javascript" src="{{ asset('backend/assets/js/layout_fixed_custom.js') }}"></script>
    <!-- Datatable JS files -->
    <script type="text/javascript" src="{{ asset('backend/assets/js/pages/datatables_advanced.js') }}"></script>
    <!-- Form Validation JS files -->
    <script type="text/javascript" src="{{ asset('backend/assets/js/pages/form_validation.js') }}"></script>
    <!-- Select2 JS files -->
    <script type="text/javascript" src="{{ asset('backend/assets/js/pages/form_select2.js') }}"></script>

    <!-- UserProfile JS files -->
    {{-- <script type="text/javascript" src="{{ asset('backend/assets/js/pages/user_pages_profile.js') }}"></script> --}}

    <!-- Uploader JS files -->
    <script type="text/javascript" src="{{ asset('backend/assets/js/pages/uploader_bootstrap.js') }}"></script>
    

    
    <!-- /theme JS files -->
    <script type="text/javascript" src="{{ asset('backend/assets/js/custom_frame.js') }}"></script>

    <!-- Per Page JS files -->
    @stack('javascript')
    <!-- /Per Page JS files -->


</body>
</html>
