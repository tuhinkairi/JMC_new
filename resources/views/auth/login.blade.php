@extends('admin.layouts.master')
@section('title', 'Login')
@php
    $journal = request()->journal;
@endphp
@section('content')
<div class="container">
    <div class="row justify-content-center ij_login">


        <div class="col-md-6 ijdemo_sec text-center ">
            <h1>Welcome to</h1>
            @if ($journal == 1)
                                    <h3>International Journal of Innovative Research in Engineering</h3>
                                @elseif ($journal == 2)
                                    <h3>International Journal of Scientific Research in Engineering & Technology</h3>
                                @elseif ($journal == 3)
                                    <h3>International Journal of Recent Trends in Multidisciplinary Research</h3>
                                @elseif ($journal == 4)
                                    <h3>Indian Journal of Electrical and Electronics Engineering</h3>
                                @elseif ($journal == 5)
                                    <h3>Indian Journal of Electronics and Communication Engineering</h3>
                                @elseif ($journal == 6)
                                    <h3>Indian Journal of Computer Science and Technology</h3>
            @endif
            <h4>Editorial Management System</h4>
            <center>
                @if ($journal == 1)
                    <div><img src="{{ asset('/backend/images/ijire_image.png') }}" height="230" class="thumbnail"></div>
                    <a href="{{ route('register') }}/?journal={{$journal}}" class="btn btn-blue d-block mw-50 mt-3 mb-1">Create a new account</a>
                @elseif ($journal == 2)
                    <div><img src="{{ asset('/backend/images/Ijsreat_image.png') }}" height="230" class="thumbnail"></div>
                    <a href="{{ route('register') }}/?journal={{$journal}}" class="btn btn-blue d-block mw-50 mt-3 mb-1">Create a new account</a>
                @elseif ($journal == 3)
                    <div><img src="{{ asset('/backend/images/ijrtmr_image.png') }}" height="230" class="thumbnail"></div>
                    <a href="{{ route('register') }}/?journal={{$journal}}" class="btn btn-blue d-block mw-50 mt-3 mb-1">Create a new account</a>
                @elseif ($journal == 4)
                    <div><img src="{{ asset('/backend/images/Indjeee_image.png') }}" height="230" class="thumbnail"></div>
                    <a href="{{ route('register') }}/?journal={{$journal}}" class="btn btn-blue d-block mw-50 mt-3 mb-1">Create a new account</a>
                @elseif ($journal == 5)
                    <div><img src="{{ asset('/backend/images/indjece_image.png') }}" height="230" class="thumbnail"></div>
                    <a href="{{ route('register') }}/?journal={{$journal}}" class="btn btn-blue d-block mw-50 mt-3 mb-1">Create a new account</a>
                @elseif ($journal == 6)
                    <div><img src="{{ asset('/backend/images/Indjcst_image.png') }}" height="230" class="thumbnail"></div>
                    <a href="{{ route('register') }}/?journal={{$journal}}" class="btn btn-blue d-block mw-50 mt-3 mb-1">Create a new account</a>
                @else
                    <div><img src="{{ asset('/backend/images/company_logo.png') }}" height="100" class="thumbnail"></div>
                @endif
            </center>
            <div class="info">
                @if ($journal == 1)
                    Click for more information <a href="https://www.theijire.com/" target="_blank">about the journal</a><br>
                @elseif ($journal == 2)
                    Click for more information <a href="https://www.ijsreat.com/" target="_blank">about the journal</a><br>
                @elseif ($journal == 3)
                    Click for more information <a href="https://www.ijrtmr.com/" target="_blank">about the journal</a><br>
                @elseif ($journal == 4)
                    Click for more information <a href="https://fdrpjournals.org/indjeee" target="_blank">about the journal</a><br>
                @elseif ($journal == 5)
                    Click for more information <a href="https://fdrpjournals.org/indjece" target="_blank">about the journal</a><br>
                @elseif ($journal == 6)
                    Click for more information <a href="https://www.indjcst.com/" target="_blank">about the journal</a><br>
                @else
                    Click for more information <a href="#" target="_blank">about the journal</a><br>
                @endif
            
                
            </div>
        </div>



        <div class="col-md-6 ijform_sec text-center">
            <h2>
                {{ __('Login') }}

                <!-- Include Flash Messages -->
                {{-- @include('admin.inc.message') --}}
            </h2>

            <div class="form_box">

                {{-- <div class="w-75 m-auto">
                    @foreach( $settings as $setting )
                    <a href="{{ URL('/') }}">
                        <span><img src="{{ asset('/uploads/setting/'.$setting->logo_path) }}" alt="Logo"></span>
                    </a>
                    @endforeach
                    <p class="text-muted">Enter your email address and password to login.</p>
                </div> --}}

                @if (isset($journal))
                    <h3>Author Login</h3>
                @else
                    <h3>Editor and Reviewer Login</h3>
                @endif


                <form class="mt-3" method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group ">
                        <label for="email" class="mb-0 text-left d-block">{{ __('E-Mail ID') }}</label>

                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        {{-- <input id="email" type="hidden" class="form-control" name="journal_id" value="{{$journal}}"> --}}

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group ">
                        <label for="password" class="mb-0 text-left d-block">{{ __('Password') }}</label>

                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>


                    <div class="form-group text-left">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                            <label class="custom-control-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                    </div>
                    <div class="form-group ">
                        <button type="submit" class="btn btn-blue d-block w-100">
                            {{ __('Login') }}
                        </button>
                    </div>

                    <div class="form-group mb-0">
                        @if (Route::has('password.request'))
                            <a class="" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        @endif

                        {{-- @if (Route::has('register'))
                        <p class="mt-3">Don't have an account? <a href="{{ route('register') }}/?journal={{$journal}}"><b>Sign Up</b></a></p>
                        @endif --}}

                        <div style="text-align: justify;">
    <h4 style="color: red; margin-right: auto; margin-left: auto; text-align: center;">Note:</h4>
    <h5 style="text-align: justify;">
        Once an author account is created, the author can monitor the status of articles, the review process, the acceptance status, copyright formalities, and final submission & FAQ’s.
    </h5>
</div>


                    </div>
                    <p><span>&#160;</span></p>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
