<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8" />

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        @foreach( $settings as $setting )
        <!-- App Title -->
        <title>@yield('title') | {{ $setting->title }}</title>

        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('/backend/images/title.png') }}">
        @endforeach

        @if(empty($setting))
        <!-- App Title -->
        <title>@yield('title')</title>
        @endif

        <!-- App css -->
        <link href="{{ asset('backend/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('backend/css/all.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('backend/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('backend/css/summernote-bs4.css') }}" rel="stylesheet" type="text/css" />


        <!-- third party css -->
        <link href="{{ asset('backend/css/vendor/dataTables.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('backend/css/vendor/switchery.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- third party css end -->


        <link href="{{ asset('backend/css/app.css') }}" rel="stylesheet" type="text/css" />

    </head>

    <body>

        <!-- Begin page -->
        <div id="wrapper">
            <!-- loading section added-->
            <div id="loadingScreen" style="display:none">
            <style>
    #loadingScreen {
      position: fixed;
      top: 0;
      left: 0;
      width: 100vw;
      height: 100vh;
      background-color: #f8f9fa;
      z-index: 9999;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
    }
  </style>
                <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-3 fw-medium">Please wait while we prepare your experience...</p>
            </div>
            @auth
            <!-- ========== Left Sidebar Start ========== -->
            @if(Auth::user()->user_type == 'A')
            <div class="left-side-menu left-side-menu-dark-admin">
            @else
            <div class="left-side-menu left-side-menu-dark">
            @endif
                <span class="logo-lg">
                    <img src="{{ asset('/backend/images/company_logo.png') }}" alt="logo" style="margin-top: -31px;" width="240" height="57">
                </span>
                <div class="slimscroll-menu">

                    @if(Request::is('dashboard*'))
                    <!--- Sidemenu -->
                    @include('admin.inc.sidebar')
                    <!-- End Sidebar -->
                    @endif

                    <div class="clearfix"></div>

                </div>
                <!-- Sidebar -left -->

            </div>
            <!-- Left Sidebar End -->
            @endauth


            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="@auth content-page @else container-fluid  @endauth">
                <div class="content">
                    <!-- Topbar Start -->
                    <div class="navbar-custom">

                        <ul class="list-unstyled topbar-right-menu float-right mb-0">

                            <!-- Authentication Links -->
                            @guest
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                                {{-- @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                    </li>
                                @endif --}}
                            @else


                            <li class="dropdown notification-list">
                                <a class="nav-link dropdown-toggle nav-user mr-0" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                    @if(isset(Auth::user()->image_path))
                                    <img src="{{ asset('/uploads/profile/'.Auth::user()->image_path) }}" onerror="this.onerror=null;this.src='/backend/images/users/user.png';" alt="user-image" class="rounded-circle">
                                    @else
                                    <img src="{{ asset('/backend/images/users/user.png') }}" alt="user-image" class="rounded-circle">
                                    @endif
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated profile-dropdown ">
                                    <!-- item-->
                                    <div class="dropdown-header noti-title">
                                        <h6 class="text-overflow m-0">Welcome !
                                            <small class="pro-user-name ml-1">
                                                {{ Auth::user()->name }}
                                            </small>
                                        </h6>
                                    </div>
                                    <!-- item-->
                                    {{-- <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <i class="fe-user"></i>
                                        <span>My Account</span>
                                    </a> --}}

                                    @can('isAdmin')
                                    <!-- item-->
                                    <a href="{{ URL::route('setting.index') }}" class="dropdown-item notify-item">
                                        <i class="fe-settings"></i>
                                        <span>Settings</span>
                                    </a>
                                    @endcan

                                    <div class="dropdown-divider"></div>

                                    @php
                                        $logout_check_admin_or_author = auth()->user()->journal_id;
                                    @endphp
                                    @if(!empty($logout_check_admin_or_author))
                                        <?php $id = $logout_check_admin_or_author; ?>
                                    @else
                                        <?php $id = 0; ?>
                                    @endif

                                    <!-- item-->
                                    <a href="{{url('logout/'.$id)}}" class="dropdown-item">


                                        <i class="fe-log-out"></i>
                                        <span>Logout</span>
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>

                                </div>
                            </li>

                            @endguest

                        </ul>
                        <button class="button-menu-mobile open-left disable-btn" style="color:blue;">
                            <i class="fe-menu"></i>
                        </button>
                        <div class="app-search">
                            <!-- <form>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search...">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fe-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form> -->
                        </div>
                    </div>
                    <!-- end Topbar -->


                    <!-- Start Content-->
                    @yield('content')
                    <!-- End Content-->



                </div> <!-- content -->

                <!-- Footer Start -->
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                @if(isset($setting))
                                Copyrights &copy; - {{ $setting->title }}
                                @endif
                            </div>
                            <div class="col-md-6">
                                <div class="text-md-right footer-links d-none d-sm-block">
                                    <a href="{{ URL('/') }}">Home</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
                <!-- end Footer -->


            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->

        <!-- App js -->

        <script src="{{ asset('backend/js/vendor.min.js') }}"></script>
        <script src="{{ asset('backend/js/all.min.js') }}"></script>
        <script src="{{ asset('backend/js/summernote-bs4.js') }}"></script>


        <!-- third party js -->
        <script src="{{ asset('backend/js/vendor/jquery.dataTables.js') }}"></script>
        <script src="{{ asset('backend/js/vendor/dataTables.bootstrap4.js') }}"></script>
        <script src="{{ asset('backend/js/vendor/switchery.min.js') }}"></script>
        <!-- third party js ends -->


        <script src="{{ asset('backend/js/app.js') }}"></script>


    </body>
</html>
