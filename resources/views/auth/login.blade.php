@extends('layouts.app')

@section('content')
<v-container id="g-login">
    <v-row class="justify-center">
        <v-col cols="12" sm="6" md="4">
            <v-card id="loginform">
                <v-card-title class="px-5">Login</v-card-title>
                <v-card-text class="py-5 px-5">
                    <v-form 
                    method="POST" 
                    action="{{ route('login') }}"
                    ref="form"
                    v-model="valid"
                    lazy-validation>
                        @csrf
                        <v-text-field
                            outlined
                            required
                            autofocus
                            id="email"
                            type="email"
                            name="email"
                            label="Email"
                            v-model="email"
                            :rules="emailrules"
                            @error('email')
                            {{-- placeholder="{{ old('email')}}" --}}
                                value="{{ old('email') }}"
                                error
                                error-messages="{{ old('email')}} {{ $message }}"
                            @enderror
                        ></v-text-field>
                        <v-text-field
                            outlined
                            required
                            id="password"
                            label="Password"
                            type="password"
                            name="password"
                            v-model="password"
                            :rules="passwordrules"
                            @error('password')
                                error
                                error-messages="{{ $message }}"
                            @enderror
                        ></v-text-field>
                        <v-btn 
                            width="100%"
                            height="55"
                            large
                            color="primary"
                            type="submit"
                            :disabled="!valid"
                            @click="validate"
                        >{{ __('LOGIN') }}</v-btn>
                    </v-form>
                </v-card-text>
            </v-card>
        </v-col>
    </v-row>
</v-container>


{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}
@endsection

@section('scripts')
    {{-- <script src="{{ asset('js/login.js') }}"></script> --}}
@endsection