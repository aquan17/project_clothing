<!doctype html>
<html lang="en" data-bs-theme="light" data-footer="dark">

@include('client.layout.component.head')

<body>
    @include('client.layout.component.top')
    <!-- start header -->
    @include('client.layout.component.header')
    <!-- end header -->
    <!-- start section -->
    @yield('content')
    <!-- end section -->
    @include('client.layout.component.sale')
    <!-- start footer -->
    @include('client.layout.component.footer')
    <!-- end scroll progress -->
    <!-- javascript libraries -->
    <!-- JS Core Libraries -->
    <script src="{{ asset('client/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('client/libs/simplebar/simplebar.min.js') }}"></script>

    <!-- Plugin JS (các thư viện phụ thuộc vào core) -->
    <script src="{{ asset('client/js/plugins.js') }}"></script>

    <!-- Các script riêng cho từng trang (qua ) -->
    @stack('scripts')

    <!-- Script khởi tạo giao diện menu (nên đặt sau khi các JS khác đã load) -->
    <script src="{{ asset('client/js/frontend/menu.init.js') }}"></script>
    <script>
        var isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
    </script>

    {{-- @include('client.layout.component.script') --}}
    <!-- end javascript libraries -->
</body>

</html>
