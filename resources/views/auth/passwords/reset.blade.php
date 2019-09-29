@extends('layouts.app')

@section('content')
<v-container id="g-login">
    <v-row class="justify-center">
        <v-col cols="12" sm="6" md="4">
            <v-card id="loginform">
                <v-card-title class="px-5 pt-5 pb-0">{{ __('Login') }}</v-card-title>
                <v-card-text class="py-5 px-5">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <v-text-field
                        outlined
                        required
                        id="email"
                        type="email"
                        name="email"
                        label="{{ __('Email') }}"
                        v-model="email"
                        :rules="emailrules"
                        @error('email')
                            value="{{ old('email') }}"
                            error
                            error-messages="{{ old('email')}} do not match in our records"
                        @enderror>
                    </v-text-field>
                </v-card-text>
            </v-card>
        </v-col>
    </v-row>
</v-container>
@endsection
