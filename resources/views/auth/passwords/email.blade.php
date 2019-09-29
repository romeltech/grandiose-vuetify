@extends('layouts.app')

@section('content')
<v-container id="g-login">
    <v-row class="justify-center">
        <v-col cols="12" sm="6" md="4">
            <v-card id="loginform">
                <v-card-title class="px-5 pt-5 pb-0">{{ __('Reset Password') }}</v-card-title>
                <v-card-text class="py-5 px-5">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <v-text-field
                            outlined
                            required
                            autocomplete="email"
                            id="email"
                            type="email"
                            name="email"
                            label="{{ __('E-Mail Address') }}"
                            v-model="email"
                            :rules="emailrules"
                            value="{{ old('email') }}"
                            @error('email')
                                error
                                error-messages="{{ $message }}"
                            @enderror>
                        </v-text-field>
                        <v-btn 
                            width="100%"
                            height="55"
                            large
                            color="primary"
                            class="mb-5"
                            type="submit"
                            :disabled="!valid"
                            @click="validate"
                            >
                        {{ __('Send Password Reset Link') }}</v-btn>
                    </form>
                </v-card-text>
            </v-card>
        </v-col>
    </v-row>
</v-container>
@endsection
