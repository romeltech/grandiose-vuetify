@extends('layouts.app')

@section('admin-content')

    <h2 class="mb-3">{{ _('Edit User') }}</h2>
    <v-row>
        <v-col class="col-12 col-md-5">
            {{-- {{$user->toJson()}} --}}
                {{-- edit-id="{{$id}}" --}}
            {{-- {{ $user->id }}
            {{ $user->name }}
            {{ $user->email }} --}}
            {{-- {{ $user->toJson() }} --}}
            {{-- <edit-user-form user-data="{{ $user }}" ></edit-user-form> --}}
            {{-- <edit-user-form user-data="{{ json_encode($user) }}" ></edit-user-form> --}}
            <edit-user-form 
                user-id="{{ $user->id}}"
                user-name="{{ $user->name}}"
                user-email="{{ $user->email}}"
                user-role="{{ $user->role}}"
                user-password="{{ $user->password}}">
            </edit-user-form>
            {{-- <edit-user-form user-data="'{!! json_encode($user) !!}'" ></edit-user-form> --}}
        </v-col>
    </v-row>
@endsection