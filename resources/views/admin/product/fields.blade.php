@extends('layouts.app')

@section('admin-content')

    <h2 class="mb-3">{{ _('Product Fields') }}</h2>
    <v-row>
        <v-col class="col-12 col-md-10 col-xl-6">
            This is the product fields.
            {{-- <user-list :users-list="{{ $users->toJson() }}"></user-list>
            {{ $users->links() }} --}}
        </v-col>
    </v-row>
@endsection