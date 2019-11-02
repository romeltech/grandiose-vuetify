@extends('layouts.app')

@section('admin-content')

    <h2 class="mb-3">{{ _('Manage Users') }}</h2>
    <v-row>
        <v-col class="col-12 col-md-5">
            {{-- {{$users}} --}}
            <user-list :users="{{$users}}"></user-list>

            {{-- {{ $users->links() }} --}}
            
        </v-col>
    </v-row>
@endsection