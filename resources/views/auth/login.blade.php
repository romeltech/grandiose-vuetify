@extends('layouts.app')

@section('content')
<v-container id="g-login">
    <v-row class="justify-center">
        <v-col cols="12" sm="6" md="4">
            <v-card id="loginform">
                <v-card-title class="px-5 pt-5 pb-0">{{ __('Login') }}</v-card-title>
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
                            autocomplete="email"
                            id="email"
                            type="email"
                            name="email"
                            label="{{ __('Email') }}"
                            v-model="email"
                            :rules="emailrules"
                            autofocus
                            @error('email')
                            {{-- placeholder="{{ old('email')}}" {{ $message }} --}}
                                value="{{ old('email') }}"
                                autofocus
                                error
                                error-messages="{{ old('email')}} do not match in our records"
                            @enderror>
                        </v-text-field>
                        <v-text-field
                            outlined
                            required
                            autocomplete="password"
                            id="password"
                            label="{{ __('Password') }}"
                            type="password"
                            name="password"
                            v-model="password"
                            :rules="passwordrules"
                            @error('password')
                                error
                                error-messages="{{ $message }}"
                                autofocus
                            @enderror>
                        </v-text-field>
                        <v-checkbox
                            type="checkbox"
                            name="remember"
                            id="remember"
                            {{ old('remember') ? 'checked' : '' }}
                            label="Remember me"
                            color="primary"
                            class="mt-0">
                        </v-checkbox>
                        <v-btn 
                            width="100%"
                            height="55"
                            large
                            color="primary"
                            class="mb-5"
                            type="submit"
                            :disabled="!valid"
                            @click="validate"
                        >{{ __('LOGIN') }}</v-btn>
                        {{-- <hr class="mb-5"> --}}
                        {{-- <div class="g-separator mb-5"></div> --}}
                        <v-card-actions class="justify-center flex-column py-0">
                            <a href="{{ route('password.request') }}" class="pb-2">{{ __('Forgot your password?') }}</a>
                            <a href="{{ route('register') }}">{{ __('Create account') }}</a>
                        </v-card-actions>
                      
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