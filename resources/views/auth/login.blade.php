@extends('layouts.app')

@section('content')
<div class="container pt-5 col-xl-4 col-lg-6 col-md-8">
    <div class="bg-light p-5 mb-5">
        <h3 class="font-weight-light text-center text-muted p-5">LOGIN</h3>
        <form method="POST" action="{{ route('login') }}" class="">
            @csrf

            <div class="form-group">
                <label for="email" class="font-weight-light text-muted"><small>{{ __('E-Mail Address') }}</small></label>
                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} br-0 p-2" name="email" value="{{ old('email') }}" required autofocus>

                @if ($errors->has('email'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                <label for="password" class="font-weight-light text-muted"><small>{{ __('Password') }}</small></label>
                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }} br-0 p-2" name="password" required>

                @if ($errors->has('password'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group mb-4">
                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} class="br-0">
                <span class="font-weight-light text-muted"><small>Remember me</small></span>
            </div>

            <button type="submit" class="btn btn-dark btn-block br-0 p-2 font-weight-light" dusk="login-submit-button">Login</button>
            {{-- <a class="btn btn-link" href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a> --}}
        </form>
    </div>
</div>
@endsection
