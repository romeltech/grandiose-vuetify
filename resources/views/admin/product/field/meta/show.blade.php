@extends('layouts.app')

@section('admin-content')

    {{-- <h2 class="mb-3">{{ $product_id->pf_value.' '._('field') }}</h2> --}}
    {{-- <field-meta-list :field-meta="{{ $fieldMeta ?? '' }}"></field-meta-list> --}}
    {{-- <field-meta-list :field-meta="{{ $fieldMeta ?? ''->toJson() }}"></field-meta-list> --}}
    <field-meta-list 
        {{-- :product-field="{{ $product_id->toJson() }}"  --}}
        
        >
        {{-- :field-meta="{{ $fieldMeta ?? ''->product_field_metas->field_meta_key->toJson() }}" --}}
    </field-meta-list>
    <h1>{{ $productfield->field_metas[0]->field_meta_key }}</h1>
    {{-- <h1>{{ $productfield->field_metas->field_meta_key }}</h1> --}}
    
    {{-- <h1>{{ $fieldMeta->product_field_metas->field_meta_key }}</h1> --}}
    {{-- <field-meta-list :product-field="'{!! json_encode($product_id) !!}'"></field-meta-list> --}}
    {{-- <field-meta-list :product-field={!! json_encode($product_id) !!}></field-meta-list> --}}
@endsection