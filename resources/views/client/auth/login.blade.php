@extends('layouts.header')

@section('css')
    <link rel="stylesheet" href="{{ url('backend') }}/assets/vendor/css/pages/page-auth.css" />
@endsection

@section('body')

<body>

 <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
          <!-- Register -->
            <div class="card">
                <div class="card-body">
                    <!-- Logo -->
                    <div class="app-brand justify-content-center">
                        <span class="app-brand-text demo text-body fw-bolder mb-2">Logo</span>
                    </div>

                    <form id="formAuthentication" class="mb-3" action="{{ route('client.login.post') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('trans.auth.email') }}</label>
                            <input
                                type="text"
                                class="form-control"
                                id="email"
                                name="email"
                                placeholder="{{ __('trans.auth.email') }}"
                                autofocus
                            />
                        </div>

                        <div class="mb-3 form-password-toggle">
                            <div class="d-flex justify-content-between">
                                <label class="form-label" for="password">{{ __('trans.auth.password') }}</label>
                                {{-- <a href="auth-forgot-password-basic.html">
                                    <small>Forgot Password?</small>
                                </a> --}}
                            </div>
                            <div class="input-group input-group-merge">
                                <input
                                type="password"
                                id="password"
                                class="form-control"
                                name="password"
                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                aria-describedby="password" />
                                <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                            </div>
                        </div>
                        {{-- <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember-me" />
                                <label class="form-check-label" for="remember-me"> Remember Me </label>
                            </div>
                        </div> --}}

                        @error('email_or_password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                        <div class="my-3">
                            <button class="btn btn-primary d-grid w-100" type="submit">{{ __('trans.auth.login') }}</button>
                        </div>
                    </form>

                </div>
            </div>
          <!-- /Register -->
        </div>
      </div>
    </div>

    <script src="{{ url('backend') }}/assets/js/main.js"></script>
</body>

@endsection
