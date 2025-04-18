<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  @foreach( $settings as $setting )
  <!-- App Title -->
  <title>@yield('title') | {{ $setting->title }}</title>

  <!-- App favicon -->
  <link rel="shortcut icon" href="{{ asset('/uploads/setting/'.$setting->favicon_path) }}">
  <meta name="description" content="{{ $setting->description }}">
  <meta name="keywords" content="{{ $setting->keywords }}">
  @endforeach

  @if(empty($setting))
  <!-- App Title -->
  <title>@yield('title')</title>
  @endif

  <!-- Bootstrap core CSS -->
  <link href="{{ asset('frontend/css/bootstrap.min.css') }}" rel="stylesheet">
  <!-- Font Awesome CSS -->
  <link href="{{ asset('frontend/css/font-awesome.min.css') }}" rel="stylesheet">
  <!-- Jasny CSS -->
  <link href="{{ asset('frontend/css/jasny-bootstrap.min.css') }}" rel="stylesheet">
  <!-- Animate CSS -->
  <link href="{{ asset('frontend/css/animate.css') }}" rel="stylesheet">
  <!-- Code CSS -->
  <link href="{{ asset('frontend/css/tomorrow-night.css') }}" rel="stylesheet" />
  <!-- Gallery CSS -->
  <link href="{{ asset('frontend/css/bootstrap-gallery.css') }}" rel="stylesheet">
  <!-- ColorBox CSS -->
  <link href="{{ asset('frontend/css/colorbox.css') }}" rel="stylesheet">

  <!-- Custom font -->
  <link href='http://fonts.googleapis.com/css?family=Raleway:400,200,100,300,500,600,700,800,900' rel='stylesheet' type='text/css'>
  <link href='http://fonts.googleapis.com/css?family=Roboto+Slab&amp;subset=latin,latin-ext' rel='stylesheet' type='text/css'>

  <!-- Custom styles for this template -->
  <link href="{{ asset('frontend/css/style.css') }}" rel="stylesheet">

</head>
<body>
  <div class="page-loader">
    <div class="loader-in">Loading...</div>
    <div class="loader-out">Loading...</div>
  </div>

  <div class="canvas">
    <div class="canvas-overlay"></div>
    <header>
      <nav class="navbar navbar-fixed-top navbar-laread">
        <div class="container">
          <div class="navbar-header">
            @if(isset($setting))
            <a class="navbar-brand" href="{{ URL('/') }}"><img height="64" src="{{ asset('/uploads/setting/'.$setting->logo_path) }}" alt="logo"></a>
            @endif
          </div>

          <!-- Authentication Links -->
          @guest
          <a href="#" data-toggle="modal" data-target="#login-form" class="modal-form">
            <i class="fa fa-user"></i>
          </a>
          @else
          <a href="{{ URL('/dashboard') }}" target="_blank" class="modal-form">
            <i class="fa fa-user"></i>
          </a>
          @endguest


          <button type="button" class="navbar-toggle collapsed menu-collapse" data-toggle="collapse" data-target="#main-nav">
            <span class="sr-only">Toggle navigation</span>
            <i class="fa fa-plus"></i>
          </button>
          <div class="collapse navbar-collapse" id="main-nav">
            <ul class="nav navbar-nav">
              <li class="{{ Request::path() == '/' ? 'active' : '' }}">
                <a href="{{ URL('/') }}">HOME</a>
              </li>
              <li class="{{ Request::is('article*') ? 'active' : '' }}">
                <a href="{{ URL('/articles') }}" class="dropdown-toggle" role="button" aria-expanded="false">Articles</a>
                <ul class="dropdown-menu" role="menu">
                @if(isset($article_submenus))
                  @foreach( $article_submenus as $article_submenu )
                  <li>
                    <a href="{{ URL('/article/category/'.$article_submenu->id) }}">
                      {{ $article_submenu->title }}
                    </a>
                  </li>
                  @endforeach
                @endif
                </ul>
              </li>
              <li class="{{ Request::is('author*') ? 'active' : '' }}">
                <a href="{{ URL('/authors') }}">Authors</a>
              </li>
              <li class="{{ Request::path() == 'requirement' ? 'active' : '' }}">
                <a href="{{ URL('/requirement') }}">Requirements</a>
              </li>
              <li class="{{ Request::path() == 'contact' ? 'active' : '' }}">
                <a href="{{ URL('/contact') }}">Contact</a>
              </li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </nav>
    </header>


      <!-- Content Start -->
      @yield('content')
      <!-- Content End -->


    <footer class="container-fluid footer">
      <div class="container text-center">
        @if(isset($setting))
        <div class="footer-logo"><img src="{{ asset('/uploads/setting/'.$setting->logo_path) }}" alt="logo"></div>
        @endif

        <p class="laread-motto">
          @if(isset($settings))
            @foreach( $settings as $setting )
              © {!! $setting->footer_text !!}
            @endforeach
          @endif
        </p>
        <div class="laread-social">
        @if(isset($socials))
          @foreach( $socials as $social )
            @if(isset($social->facebook))
            <a href="{{ $social->facebook }}" target="_blank"><i class="fa fa-facebook"></i></a>
            @endif
            @if(isset($social->twitter))
            <a href="{{ $social->twitter }}" target="_blank"><i class="fa fa-twitter"></i></a>
            @endif
            @if(isset($social->linkedin))
            <a href="{{ $social->linkedin }}" target="_blank"><i class="fa fa-linkedin"></i></a>
            @endif
            @if(isset($social->instagram))
            <a href="{{ $social->instagram }}" target="_blank"><i class="fa fa-instagram"></i></a>
            @endif
            @if(isset($social->pinterest))
            <a href="{{ $social->pinterest }}" target="_blank"><i class="fa fa-pinterest"></i></a>
            @endif
            @if(isset($social->youtube))
            <a href="{{ $social->youtube }}" target="_blank"><i class="fa fa-youtube-play"></i></a>
            @endif
          @endforeach
        @endif
        </div>
      </div>
    </footer>
  </div>


  <!-- Login Modal -->
  <div class="modal leread-modal fade" id="login-form" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content" id="login-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><i class="fa fa-unlock-alt"></i>Sign In</h4>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
              <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

              @error('email')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
            </div>
            <div class="form-group">
              <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

              @error('password')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
            </div>
            <div class="linkbox">
              @if (Route::has('password.request'))
                  <a href="{{ route('password.request') }}">
                      {{ __('Forgot password ?') }}
                  </a>
              @endif

              @if (Route::has('register'))
              <span>No account ?  <a href="{{ route('register') }}">Sign Up</a></span>
              @endif

              <span class="form-warning"><i class="fa fa-exclamation"></i>Fill the require.</span>
            </div>
            <div class="linkbox">
              <label><input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}><span>Remember me</span><i class="fa"></i></label>
              <button type="submit" class="btn btn-golden btn-signin">SIGN IN</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript
  ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <script src="{{ asset('frontend/js/jquery.min.js') }}"></script>
  <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('frontend/js/jasny-bootstrap.min.js') }}"></script>
  <script src="{{ asset('frontend/js/prettify.js') }}"></script>
  <script src="{{ asset('frontend/js/lang-css.js') }}"></script>
  <script src="{{ asset('frontend/js/jquery.blueimp-gallery.min.js') }}"></script>
  <script src="{{ asset('frontend/js/imagesloaded.js') }}"></script>
  <script src="{{ asset('frontend/js/masonry.js') }}"></script>
  <script src="{{ asset('frontend/js/viewportchecker.js') }}"></script>
  <script src="{{ asset('frontend/js/isotope.pkgd.min.js') }}"></script>
  <script src="{{ asset('frontend/js/jquery.ellipsis.min.js') }}"></script>
  <script src="{{ asset('frontend/js/jquery.dotdotdot.min.js') }}"></script>
  <script src="{{ asset('frontend/js/jquery.colorbox-min.js') }}"></script>
  <script src="{{ asset('frontend/js/jquery.nicescroll.min.js') }}"></script>
  <script src="{{ asset('frontend/js/calendar.js') }}"></script>
  <script src="{{ asset('frontend/js/jquery.touchSwipe.min.js') }}"></script>
  <script src="{{ asset('frontend/js/script.js') }}"></script>
</body>
</html>
