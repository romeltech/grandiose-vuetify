@extends('layouts.app')

@section('admin-content')

    <admin-product  :product="{{ $product[0]->toJson() }}" ></admin-product>

@endsection