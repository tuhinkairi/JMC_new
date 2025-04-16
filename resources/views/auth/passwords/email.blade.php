@extends('admin.layouts.master')
@section('title', 'Email')
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
                    <p class="text-muted">Enter your account email address.</p>
                    @if (session('status'))
                        <div class="alert alert-success form-group row" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="mb-0 text-left d-block">{{ __('E-Mail Address') }}</label>


                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                        </div>

                        <div class="form-group mb-0">

                                <button type="submit" class="btn btn-blue">
                                    {{ __('Send Password Reset Link') }}
                                </button>

                        </div>
                    </form>
                </div>
            </div>
</div>
@endsection
