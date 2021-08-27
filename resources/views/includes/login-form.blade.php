<div class="auth-card">
    <div class="card-body">
        <h2 class="text-center mb-5"> {{ __('Login Into Your Account') }}</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            @if ($redirect_to_checkout)
            <input type="hidden" value="{{true}}" name="redirect_to_checkout">
            @endif
            <div class="form-group row mb-4">


                <div class="col-md-12">
                    <input placeholder="{{ __('E-Mail Address') }}" type="email"
                        class="form-control @error('email') is-invalid @enderror" name="email"
                        value="{{ old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row mb-4">


                <div class="col-md-12">
                    <input placeholder="{{ __('Password') }}" type="password"
                        class="form-control @error('password') is-invalid @enderror" name="password" required
                        autocomplete="current-password">

                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group d-flex flex-column flex-lg-row justify-content-between align-items-center mb-4">
                <div class="">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                            {{ old('remember') ? 'checked' : '' }}>

                        <label class="form-check-label" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                </div>
                @if (Route::has('password.request'))
                <div>
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                </div>
                @endif
            </div>


            <div class="form-group row mb-0">
                <div class="col-md-12">
                    <button type="submit" class="btn-orange btn-square btn-block">
                        {{ __('Login') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
