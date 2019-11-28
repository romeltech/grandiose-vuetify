@extends('layouts.app')

@section('content')
    <v-container id="products-page">
        <product-card :products="{{ json_encode($products) }}"></product-card>
    </v-container>
@endsection