<div class="auth-card">
    <div class="card-body">
        <h2 class="text-center mb-5"> {{ __('Create Your Account') }}</h2>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            @if ($redirect_to_checkout)
            <input type="hidden" value="{{true}}" name="redirect_to_checkout">
            @endif
            <div class="form-group row">
                <div class="col-md-12">
                    <input placeholder="{{ __('Name') }}" type="text"
                        class="form-control @error('register_name') is-invalid @enderror" name="register_name"
                        value="{{ old('register_name') }}" required autocomplete="name" autofocus>

                    @error('register_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">


                <div class="col-md-12">
                    <input placeholder="{{ __('E-Mail Address') }}" type="email"
                        class="form-control @error('register_email') is-invalid @enderror" name="register_email"
                        value="{{ old('register_email') }}" required autocomplete="email">

                    @error('register_email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">

                <div class="col-md-12">
                    <input placeholder="{{ __('Phone') }}" type="text"
                        class="form-control @error('register_phone') is-invalid @enderror" name="register_phone"
                        value="{{ old('register_phone') }}" required autocomplete="phone" autofocus>

                    @error('register_phone')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-12">
                    <input placeholder="{{ __('Password') }}" type="password"
                        class="form-control @error('register_password') is-invalid @enderror" name="register_password"
                        required autocomplete="new-password">

                    @error('register_password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-12">
                    <input placeholder="{{ __('Confirm Password') }}" type="password" class="form-control"
                        name="register_password_confirmation" required autocomplete="new-password">
                </div>
            </div>
            <div class="form-group row">
                <a class="btn btn-link ml-auto" href="{{ route('login') }}">
                    {{ __('Already have an account ?') }}
                </a>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-12">
                    <button type="submit" class="btn-orange btn-square btn-block">
                        {{ __('Register') }}
                    </button>

                </div>
            </div>
        </form>
    </div>

</div>
