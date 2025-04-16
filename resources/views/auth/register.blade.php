@extends('admin.layouts.master')
@section('title', 'Register')
@php
    $journal = request()->journal;
@endphp
@section('content')


<div class="container">
    <div class="row justify-content-center ij_login">

        @if(isset($journal))
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
                @endif
            </center>
            <div class="info">
                Click for more information <a href="#" target="_blank">about the journal</a><br>
            </div>
        </div>
        @endif


        <div class="col-md-6 ijform_sec text-center">
            <h2>
                {{ __('Register/Sign-up') }}

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


                    <h3>Author Signup</h3>


                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <input type="hidden" class="form-control" name="user_type" value="W"/>

                    <input type="hidden" class="form-control" name="journal_id" value={{$journal}}>

                    <div class="form-group">
                        <label for="name" class="mb-0 text-left d-block">{{ __('Name') }}</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>

                    <div class="form-group">
                        <label for="email" class="mb-0 text-left d-block">{{ __('E-Mail ID') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone" class="mb-0 text-left d-block">{{ __('Mobile') }}</label>
                        <input id="phone" type="number" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone" placeholder="91XXXXXXXXXX">

                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>


                    <div class="form-group">
                        <label for="password" class="mb-0 text-left d-block">{{ __('Password') }}</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>

                    <div class="form-group">
                        <label for="password-confirm" class="mb-0 text-left d-block">{{ __('Confirm Password') }}</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>

                    <div class="form-group" style="white-space: nowrap; color: blue; font-size:0.8rem">
                    <p><input type="checkbox" required>  Make sure Entered Valid E-mail ID & Mobile No.For Status Notifications</p>
                    </div>

                    <div class="form-group">
                            <button type="submit" class="btn btn-blue d-block w-100">
                                {{ __('Register') }}
                            </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
























