@extends('layouts.app')

@section('content')
    <v-container id="products-page" style="max-width:100%;">
        <div class="row">
            <div class="col-12 col-md-3">
                <side-bar></side-bar>
            </div>
            <div class="col-12 col-md-9">
                <product-list></product-list>
            </div>
        </div>
    </v-container>
@endsection