@extends('client.layout.ClientLayout')

@section('content')
    @include('client.layout.component.banner')
    @include('client.layout.component.new')
    @yield('product')
    @include('client.layout.component.introduction')  
    @include('client.layout.component.script')
@endsection

