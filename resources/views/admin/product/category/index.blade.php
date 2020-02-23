@extends('layouts.app')

@section('admin-content')
    <div class="col">
        <h2 class="mb-3">{{ _('Product Categories') }}</h2>
        <product-categories></product-categories>
    </div>
@endsection