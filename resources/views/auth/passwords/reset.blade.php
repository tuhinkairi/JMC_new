@extends('admin.layouts.master')
@section('title', 'Reset Password')
@section('content')
<div class="container">
    <div class="row justify-content-center ij_login">
        <div class="col-md-6 ijform_sec text-center">

            <h2>
                {{ __('Reset Password') }}
            </h2><br>

            <div class="form_box">

                    <div class="text-center w-75 m-auto">
                        <a href="{{ URL('/') }}">
                            <span><img src="{{ asset('/backend/images/company_logo.png') }}" height="58" alt="Logo"></span>
                        </a>
                    </div><br>
                    <p class="text-muted">Enter your new password.</p>

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group row">
                            <label for="email" class="mb-0 text-left d-block">{{ __('E-Mail Address') }}</label>

                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="form-group row">
                            <label for="password" class="mb-0 text-left d-block">{{ __('Password') }}</label>

                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="mb-0 text-left d-block">{{ __('Confirm Password') }}</label>

                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>

                        <div class="form-group mb-0">
                                <button type="submit" class="btn btn-blue">
                                    {{ __('Reset Password') }}
                                </button>
                        </div>
                        <p><span>&#160;</span></p>
                    </form>
        </div>
    </div>
</div>
@endsection
