@extends('layouts.app')

@section('content')
<v-container id="g-login">
    <v-row class="justify-center">
        <v-col cols="12" sm="12" md="5">
            <v-card id="g-register">
                <v-card-title class="px-5 pt-5 pb-0">{{ __('Create Account') }}</v-card-title>
                <v-card-text class="py-5 px-5">
                    <v-form 
                    method="POST"
                    action="{{ route('register') }}"
                    ref="form"
                    v-model="valid"
                    lazy-validation>
                        @csrf
                        <v-text-field
                            outlined
                            required
                            autocomplete="name" 
                            id="name"
                            type="text"
                            name="name"
                            label="{{ __('Name') }}"
                            {{-- v-model="regname"
                            :rules="regnamerules" --}}
                            value="{{ old('name') }}"
                            @error('name')
                                error
                                error-messages="{{ $message }}"
                            @enderror>
                        </v-text-field>

                        <v-text-field
                            outlined
                            required
                            autocomplete="email"
                            id="email"
                            type="email"
                            name="email"
                            label="{{ __('E-Mail Address') }}"
                            {{-- v-model="regemail"
                            :rules="regemailrules" --}}
                            value="{{ old('email') }}"
                            @error('email')
                                error
                                error-messages="{{ $message }}"
                            @enderror>
                        </v-text-field>

                        <v-text-field
                            outlined
                            required
                            autocomplete="phone" 
                            id="phone"
                            type="text"
                            name="phone"
                            label="{{ __('Mobile Number') }}"
                            {{-- v-model="regname"
                            :rules="regnamerules" --}}
                            value="{{ old('phone') }}"
                            @error('phone')
                                error
                                error-messages="{{ $message }}"
                            @enderror>
                        </v-text-field>

                        <v-text-field
                            outlined
                            required
                            autocomplete="new-password"
                            id="password"
                            type="password"
                            name="password"
                            label="{{ __('Password') }}"
                            {{-- v-model="regpassword"
                            :rules="regpasswordrules" --}}
                            value="{{ old('password') }}"
                            @error('password')
                                error
                                error-messages="{{ $message }}"
                            @enderror>
                        </v-text-field>

                        <v-text-field
                            outlined
                            required
                            autocomplete="new-password"
                            id="password-confirm"
                            type="password"
                            name="password_confirmation"
                            label="{{ __('Confirm Password') }}"
                            {{-- v-model="regpassword"
                            :rules="regpasswordrules" --}}
                        >
                        </v-text-field>
                        <v-btn 
                            width="100%"
                            height="55"
                            large
                            color="primary"
                            class="mb-2"
                            type="submit"
                            :disabled="!valid"
                            @click="validate">
                            {{ __('Register') }}
                        </v-btn>
                        <v-card-actions class="justify-center flex-column">
                            <a href="{{ route('login') }}">{{ __('I already have an account') }}</a>
                        </v-card-actions>
                    </v-form>
                </v-card-text>
            </v-card>
        </v-col>
    </v-row>
</v-container>
@endsection
