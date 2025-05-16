@extends('client.layout.clientlayout')
@section('title', 'Đang nhập')
@section('content')
    <section class="section auth">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <p class="text-muted fs-15">
                                Đăng nhập để tiếp tục đến Toner.</p>
                            <div class="p-2">
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                   <input type="hidden" name="redirect" value="{{ request()->query('redirect', url()->previous()) }}">
                                    <div class="mb-3">
                                        <label for="emmail" class="form-label">Username</label>
                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" required autocomplete="email" autofocus>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <div class="float-end">
                                            @if (Route::has('password.request'))
                                                <a class="text-muted" href="{{ route('password.request') }}">
                                                    {{ __('Forgot password?') }}
                                                </a>
                                            @endif
                                            {{-- <a href="auth-pass-reset-basic.html" class="text-muted">Forgot password?</a> --}}
                                        </div>
                                        <label class="form-label" for="password-input">Password</label>
                                        <div class="position-relative auth-pass-inputgroup mb-3">
                                            <input id="password" type="password"
                                                class="form-control password-input @error('password') is-invalid @enderror"
                                                name="password" required autocomplete="current-password">
                                            <button
                                                class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                                type="button" id="password-addon"><i
                                                    class="ri-eye-fill align-middle"></i></button>
                                        </div>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember"
                                            id="auth-remember-check" {{ old('remember') ? 'checked' : '' }}>
                                        {{-- <input class="form-check-input" type="checkbox" value="" id="auth-remember-check"> --}}
                                        <label class="form-check-label" for="auth-remember-check">Remember me</label>
                                    </div>

                                    <div class="mt-4">
                                        <button class="btn btn-primary w-100" type="submit">Sign In</button>
                                    </div>

                                    <div class="mt-4 pt-2 text-center">
                                        <div class="signin-other-title">
                                            <h5 class="fs-13 mb-4 title">Sign In with</h5>
                                        </div>
                                        <div class="pt-2 hstack gap-2 justify-content-center">
                                            <button type="button" class="btn btn-soft-primary btn-icon"><i
                                                    class="ri-facebook-fill fs-16"></i></button>
                                            <button type="button" class="btn btn-soft-danger btn-icon"><i
                                                    class="ri-google-fill fs-16"></i></button>
                                            <button type="button" class="btn btn-soft-dark btn-icon"><i
                                                    class="ri-github-fill fs-16"></i></button>
                                            <button type="button" class="btn btn-soft-info btn-icon"><i
                                                    class="ri-twitter-fill fs-16"></i></button>
                                        </div>
                                    </div>
                                </form>
                                <div class="text-center mt-5">
                                    <p class="mb-0">Bạn chưa có tài khoản? @if (Route::has('register'))
                                            <a href="{{ route('register') }}"
                                                class="fw-semibold text-secondary text-decoration-underline"> Đăng ký</a>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script src="{{ asset('client/js/pages/password-addon.init.js') }}"></script>
@endpush
