@extends('layouts.app')

@section('content')
    <v-container id="shop-page">
        <v-row class="justify-center">
            {{-- @foreach ($products as $product) --}}
                {{-- {{$product->imagepath}}
                {{$product->title}}
                {{$product->price}}
                {{$product->description}} --}}
                <?php //print_r($products) ?>
                <product-card></product-card>


            {{-- @endforeach --}}
        </v-row>
    </v-container>
@endsection

@section('scripts')
    {{-- <script src="{{ asset('js/login.js') }}"></script> --}}
@endsection