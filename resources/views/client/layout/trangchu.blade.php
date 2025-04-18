@extends('client.layout.ClientLayout')
@section('title', 'Trang Chủ')
@section('header')
    @include('client.layout.components.header')
   <!-- Slider -->
 
@endsection
@section('content')
{{-- @include('client.layout.components.header') --}}
 
@include('client.layout.components.slider')

<!-- Banner -->
@include('client.layout.components.banner')
    <!-- Product -->
    {{-- @include('client.layout.components.product') --}}
    @yield('product')
@endsection