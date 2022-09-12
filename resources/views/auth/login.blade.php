@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

                    <div class="card-body-login">
                        <h1>BIENVENIDOS</h1>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="input-form">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="input-form">


                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password" required
                                    autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>


                            <div>
                            <button type="submit" class="btn-login">
                                {{ __('Login') }}
                            </button>
                        </div>
                        <div class="input-form">
                            @if (Route::has('password.request'))
                                <a class="btn-new-link" href="{{ route('password.request') }}">
                                    Olvido su contraseña?
                                </a>
                            @endif
                        </div>
                        </form>
                    </div>
            
      
        </div>
    </div>
@endsection
