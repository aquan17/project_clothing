@extends('client.layout.clientLayout')
@section('content')
@include('client.layout.component.slider')
        <!-- end section -->
        <!-- start section -->
       @include('client.layout.component.banner')
        <!-- end section -->
        <!-- start section -->
        {{-- @include('client.layout.component.product') --}}
        @yield('product')
        <!-- end section -->
        <!-- start section -->
       @include('client.layout.component.new')
@endsection