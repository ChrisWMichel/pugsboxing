<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{csrf_token()}} "/>

    <title>Administrator</title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
    <link href='{{asset("vendor/fullcalendar/fullcalendar.print.min.css")}}' rel='stylesheet' media='print' />
    <link href="{{asset('vendor/fullcalendar/fullcalendar.min.css')}}" rel='stylesheet' />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.css">
    <link rel="stylesheet" href="{{asset('css/font-awesome.css')}}" >
    <link rel="stylesheet" href="{{asset('css/metisMenu.css')}}">
    <link rel="stylesheet" href="{{asset('css/sb-admin-2.css')}}">
    <link rel="stylesheet" href="{{asset('css/admin.css')}}">

    {{--jQuery messaging--}}
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    @yield('styles')
<style>
    .nav-second-level{
        margin-left:20px;
    }
</style>

</head>

<body id="admin-page">

<div id="wrapper" class="container">


    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/"  target="_blank">Public Home</a>
        </div>
        <!-- /.navbar-header -->


        <ul class="nav navbar-nav navbar-right">
            @if(auth()->guest())
                @if(!Request::is('/login'))
                    <li><a href="{{ url('/login') }}">Login</a></li>
                @endif

            @else
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ auth()->user()->firstname }} <span class="caret"></span></a>
                    <ul class="dropdown-menu dropdown-user" role="menu">
                        <li><a href="{{ url('/logout') }}">Logout</a></li>

                       {{-- <li><a href="{{ url('/admin/profile') }}/{{auth()->user()->id}}">Profile</a></li>--}}
                    </ul>
                </li>
            @endif
        </ul>


        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse in">
                <ul class="nav" id="side-menu">

                    <li>
                        <a href="/admin"><i class="fa fa-calendar fa-fw"></i> Schedule</a>
                    </li>

                    <li>
                        <a href="#"><i class="fa fa-cubes fa-fw"></i> CMS<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="{{route('header.index')}}">Header</a>
                            </li>
                            <li>
                                <a href="{{route('home.index')}}">Home</a>
                            </li>

                            <li>
                                <a href="#">Membership<span class="fa arrow"></span></a> {{--{{route('posts.create')}}--}}
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="{{route('categories.index')}}">Categories</a>    {{--{{route('media.index')}}--}}
                                    </li>

                                    <li>
                                        <a href="{{route('packages.index')}}">Packages</a>
                                    </li>
                                    <li>
                                        <a href="{{route('packagedesc')}}">Descriptions</a>
                                    </li>

                                </ul>
                            </li>
                            <li>
                                <a href="{{route('schedule.index')}}">Class Schedule</a> {{--{{route('comments.index')}}--}}
                            </li>

                            <li>
                                <a href="{{route('about.index')}}">About</a>
                            </li>
                            <li>
                                <a href="{{route('admincontact.index')}}">Contact</a>
                            </li>

                        </ul>
                        <!-- /.nav-second-level -->
                    </li>


                    <li>
                        <a href="#"><i class="fa fa-users fa-fw" aria-hidden="true" ></i> Members<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="{{route('members.index')}}">All Members</a>
                            </li>

                            <li>
                                <a href="{{route('new_member')}}">New Member</a>
                            </li>

                        </ul>
                        <!-- /.nav-second-level -->
                    </li>


                    <li>
                        <a href="{{route('open_message')}}"><i class="fa fa-envelope fa-fw"></i> Send Message</a>
                    </li>

                    {{--<li>
                        <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Charts<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="flot.html">Flot Charts</a>
                            </li>
                            <li>
                                <a href="morris.html">Morris.js Charts</a>
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                    <li>
                        <a href="tables.html"><i class="fa fa-table fa-fw"></i> Tables</a>
                    </li>
                    <li>
                        <a href="forms.html"><i class="fa fa-edit fa-fw"></i> Forms</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-wrench fa-fw"></i> UI Elements<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="panels-wells.html">Panels and Wells</a>
                            </li>
                            <li>
                                <a href="buttons.html">Buttons</a>
                            </li>
                            <li>
                                <a href="notifications.html">Notifications</a>
                            </li>
                            <li>
                                <a href="typography.html">Typography</a>
                            </li>
                            <li>
                                <a href="icons.html"> Icons</a>
                            </li>
                            <li>
                                <a href="grid.html">Grid</a>
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>--}}
                    @if(\Illuminate\Support\Facades\Auth::user()->isAdmin)
                    <li> {{-- class="active"--}}
                        <a href="{{route('newAdmin')}}"><i class="fa fa-plus-circle fa-fw"></i> Create Admin</a> {{--<span class="fa arrow"></span>--}}

                    </li>
                    @endif
                </ul>


            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>







    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">


                    @yield('content')
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<!-- jQuery -->
<script src="{{asset('bower_components/jquery/dist/jquery.min.js')}}"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{asset('bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>

<script src="{{asset('js/metisMenu.js')}}"></script>
<script src="{{asset('js/sb-admin-2.js')}}"></script>
<script src="{{asset('js/scripts.js')}}"></script>

{{--jQuery Messaging--}}


@yield('scripts')

<script>
    $('#flash-overlay-modal').modal();

    $('div.alert').not('.alert-important').delay(5000).fadeOut(350);
</script>

</body>

</html>
