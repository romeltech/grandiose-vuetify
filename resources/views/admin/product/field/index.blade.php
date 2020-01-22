@extends('layouts.app')

@section('admin-content')

    <h2 class="mb-3">{{ _('Product Fields') }}</h2>
    <v-row>
        <v-col class="col-12 col-md-3">
            <add-product-field></add-product-field>
        </v-col>
        <v-col class="col-12 col-md-8">
            {{-- <product-field-list :product-fields="{{ $productfields->toJson() }}"></product-field-list> --}}
            <product-field-list></product-field-list>
        </v-col>

    </v-row>
@endsection