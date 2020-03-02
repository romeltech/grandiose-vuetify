@extends('layouts.app')

@section('admin-content')
    {{-- {{ $product->categories }} --}}
    <admin-product  :product="{{ $product->toJson() }}" :categories="{{ $product->categories }}" ></admin-product>
@endsection