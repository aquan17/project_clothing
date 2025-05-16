@extends('client.layout.clientlayout')
@section('title', 'Đăng Ký')
@section('content')
    <section class="section auth">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <p class="text-muted fs-15">Đăng ký để nhận thêm nhiều ưu đãi hơn nha!</p>
                            <div class="p-2">
                                 <form method="POST" action="{{ route('register') }}">
                                @csrf
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Tên của bạn <span
                                                class="text-danger">*</span></label>
                                        <input id="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror" name="name"
                                            value="{{ old('name') }}" placeholder="Nhập Tên" required autocomplete="name" autofocus>
                                         @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="useremail" class="form-label">Email <span
                                                class="text-danger">*</span></label>
                                                 <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" required autocomplete="email"  placeholder="Nhập email">
                                    
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">            
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="password-input">Mật Khẩu</label>
                                        <div class="position-relative auth-pass-inputgroup">
                                     
                                            <input id="password" type="password"
                                            class="form-control pe-5 password-input @error('password') is-invalid @enderror" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                            required autocomplete="new-password" placeholder="Nhập mật khẩu">
                                            <button
                                                class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                                type="button" id="password-addon"><i
                                                    class="ri-eye-fill align-middle"></i></button>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="password-confirm">Xác Nhận Mật Khẩu</label>
                                        <div class="position-relative auth-pass-inputgroup">
                                              <input id="password-confirm" type="password" class="form-control pe-5 password-input"
                                            name="password_confirmation" required autocomplete="new-password" placeholder="Nhập lại mật khẩu">
                                           
                                         <button
                                                class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                                type="button" ><i
                                                    class="ri-eye-fill align-middle"></i></button>
                                            <div class="invalid-feedback">
                                                Passwords do not match
                                            </div>
                                        </div>
                                    </div>
                                    

                                    <div class="mt-4">
                                        <button class="btn btn-primary w-100" type="submit">Sign Up</button>
                                    </div>

                                    <div class="mt-4 text-center">
                                        <div class="signin-other-title">
                                            <h5 class="fs-13 mb-4 title text-muted">Create account with</h5>
                                        </div>

                                        <div>
                                            <button type="button" class="btn btn-soft-primary btn-icon "><i
                                                    class="ri-facebook-fill fs-16"></i></button>
                                            <button type="button" class="btn btn-soft-danger btn-icon "><i
                                                    class="ri-google-fill fs-16"></i></button>
                                            <button type="button" class="btn btn-soft-dark btn-icon "><i
                                                    class="ri-github-fill fs-16"></i></button>
                                            <button type="button" class="btn btn-soft-info btn-icon "><i
                                                    class="ri-twitter-fill fs-16"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="mt-4 text-center">
                               <p class="mb-0">Bạn đã có tài khoản? @if (Route::has('login'))
                                            <a href="{{ route('login') }}"
                                                class="fw-semibold text-secondary text-decoration-underline"> Đăng nhập</a>
                                        @endif
                                    </p>
                            </div>
                        </div>
                        {{-- start --}}
                        <div class="card-header">{{ __('Register') }}</div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <div class="row mb-3">
                                    <label for="name"
                                        class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror" name="name"
                                            value="{{ old('name') }}" required autocomplete="name" autofocus>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="email"
                                        class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" required autocomplete="email">

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="password"
                                        class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            required autocomplete="new-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="password-confirm"
                                        class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control"
                                            name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                </div>

                                <div class="row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Register') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        {{-- end --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script src="{{ asset('client/js/pages/password-addon.init.js') }}"></script>
@endpush
