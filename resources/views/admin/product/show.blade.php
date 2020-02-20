@extends('layouts.app')

@section('admin-content')

    <admin-product  :products="{{ $products[0]->toJson() }}" ></admin-product>

@endsection