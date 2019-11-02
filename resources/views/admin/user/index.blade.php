@extends('layouts.app')

@section('admin-content')

    <h2 class="mb-3">{{ _('Manage Users') }}</h2>
    <v-row>
        <v-col class="col-12 col-md-6">

            <user-list :users-list="{{ $users->toJson() }}"></user-list>

            {{ $users->links() }}
            
        </v-col>
    </v-row>
@endsection