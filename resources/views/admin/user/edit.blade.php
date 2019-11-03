@extends('layouts.app')

@section('admin-content')

    <h2 class="mb-3">{{ _('Add User') }}</h2>
    <v-row>
        <v-col class="col-12 col-md-5">
            {{-- {{$meh}} --}}
                {{-- edit-id="{{$id}}" --}}
            {{-- user-id="{{ $user->id }}" --}}
            <edit-user-form user-id="{{ $user->id }}" ></edit-user-form>
        </v-col>
    </v-row>
@endsection