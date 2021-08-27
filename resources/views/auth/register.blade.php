@extends('layouts.app')
@section('title')
Inscription -
@endsection
@section('description')
Rejoignez-nous pour le dîner
@endsection
@section('content')
@include('includes.breadcrumb' , ['pageName'=> "Register"])

<main id="main">
    <section class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card auth-card">

                    <div class="card-body">
                        <h2 class="text-center mb-5"> {{ __('Create Your Account') }}</h2>


                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="form-group row">


                                <div class="col-md-12">
                                    <input placeholder="{{ __('Name') }}" id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">


                                <div class="col-md-12">
                                    <input placeholder="{{ __('E-Mail Address') }}" id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">

                                <div class="col-md-12">
                                    <input placeholder="{{ __('Phone') }}" id="phone" type="text"
                                        class="form-control @error('phone') is-invalid @enderror" name="phone"
                                        value="{{ old('phone') }}" required autocomplete="phone" autofocus>

                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <input placeholder="{{ __('Password') }}" id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <input placeholder="{{ __('Confirm Password') }}" id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password">
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
            </div>
        </div>
        </div>
    </section>
</main>
@endsection
