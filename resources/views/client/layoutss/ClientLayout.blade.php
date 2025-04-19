<!DOCTYPE html>
<html lang="en">
    
{{-- head --}}
@include('client.layout.components.head')
{{-- end head --}}

<body class="animsition">
    {{-- <!-- Header --> --}}
    @if (Request::is('/'))
    <!-- Hiển thị header dành cho trang chủ -->
    @include('client.layout.components.header')
@else
    <!-- Hiển thị header dành cho các trang khác -->
    @include('client.layout.components.header1')
@endif


    {{-- @yield('header') --}}
    @include('client.layout.components.cart')
    @yield('content')

    <!-- Footer -->
    @include('client.layout.components.footer')

    <!-- Back to top -->
    @include('client.layout.components.back_to_top')

    <!-- Modal1 -->
    @include('client.layout.components.modal1')

    <!-- script -->
    @include('client.layout.components.script')
</body>
</html>