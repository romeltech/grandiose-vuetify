@extends('layouts.app')

@section('admin-content')

    <h2 class="mb-3">{{ _('Product Fields') }}</h2>
    <product-field-list></product-field-list>
    
@endsection