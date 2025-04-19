<!doctype html>
<html class="no-js" lang="en">
    @include('client.layout.component.head')
    <body data-mobile-nav-style="classic">
        <!-- start header -->
        @include('client.layout.component.header')
        <!-- end header --> 
        <!-- start section -->
        @yield('content')
        <!-- end section -->
        <!-- start footer -->
        @include('client.layout.component.footer')
        <!-- end scroll progress -->
        <!-- javascript libraries -->
       @include('client.layout.component.script')
        <!-- end javascript libraries -->
    </body>
</html>