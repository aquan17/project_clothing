<!doctype html>
<html lang="en" data-bs-theme="light" data-footer="dark">

@include('client.layout.component.head')

<body>
    @include('client.layout.component.top')

    <!-- start header -->
    @include('client.layout.component.header')
    <!-- end header -->
   
@if(session()->has('user_name'))
    <div class="alert alert-login alert-dismissible fade show mt-3" role="alert" style="font-weight: 500; font-size: 1.1rem;">
        <i class="bi bi-check-circle-fill me-2"></i>
        Chào người đẹp <strong>{{ session('user_name') }}</strong>!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif


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
    <style>
.alert-login {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 1050;
    min-width: 300px;
    border: none;
    border-radius: 10px;
    padding: 16px 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    animation: slideIn 0.3s ease-out;
    background: linear-gradient(135deg, #FF416C 0%, #FF4B2B 100%);
    color: white;
    font-weight: 500;
}

@keyframes slideIn {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

.alert-login i,
.alert-login strong {
    color: white;
}
.btn-close {
    opacity: 0.5;
    transition: opacity 0.2s;
}

.btn-close:hover {
    opacity: 1;
}
</style>

<script>
// Tự động ẩn alert sau 3 giây
document.addEventListener('DOMContentLoaded', function() {
    const alert = document.querySelector('.alert-login');
    if(alert) {
        setTimeout(function() {
            alert.classList.remove('show');
            setTimeout(function() {
                alert.remove();
            }, 300);
        }, 3000);
    }
});
</script>
</body>

</html>
