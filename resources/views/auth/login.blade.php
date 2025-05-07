<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>{{ config('app.name', 'CRM') }} - Login</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="YM Service App." name="description" />
        <meta content="Techzaa" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('cms/favicon.ico') }}">
        <!-- Theme Config Js -->
        <script src="{{ asset('cms/assets/js/config.js') }}"></script>
        <!-- App css -->
        <link href="{{ asset('cms/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />
        <!-- Icons css -->
        <link href="{{ asset('cms/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    </head>

    <body class="authentication-bg position-relative">

        <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5 position-relative">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xxl-8 col-lg-10">
                        <div class="card overflow-hidden">
                            <div class="row g-0">
                                <div class="col-lg-6 d-none d-lg-block p-2">
                                    <img src="{{ asset('cms/assets/images/auth-img.jpg')}}" alt="" class="img-fluid rounded h-100">
                                </div>
                                <div class="col-lg-6">
                                    <div class="d-flex flex-column h-100">
                                        <div class="auth-brand p-4">
                                            <a href="index.html" class="logo-dark">
                                                <img src="{{ asset('cms/assets/images/logo-dark.png')}}" alt="dark logo" height="22">
                                            </a>
                                        </div>
                                        <div class="p-4 my-auto">
                                            <h4 class="fs-20">Sign In</h4>
                                            <p class="text-muted mb-3">Enter your email address and password to access
                                                account.
                                            </p>

                                            <!-- form -->
                                            <form  method="POST" action="{{ route('login') }}">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="emailaddress" class="form-label">Email address</label>
                                                    <input class="form-control" type="email" id="emailaddress" name="email" required=""
                                                           placeholder="Enter your email">
                                                     @error('email')
                                                        <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                                                        @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label for="password" class="form-label">Password</label>
                                                    <input class="form-control" type="password" name="password" required="" id="password"
                                                           placeholder="Enter your password">
                                                </div>
                                                <div class="mb-3">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                               id="checkbox-signin" name="remember" >
                                                        <label class="form-check-label" for="checkbox-signin">Remember
                                                            me</label>
                                                    </div>
                                                </div>
                                                <div class="mb-0 text-start">
                                                    <button class="btn btn-soft-primary w-100" type="submit"><i
                                                            class="ri-login-circle-fill me-1"></i> <span class="fw-bold">Log
                                                            In</span> </button>
                                                </div>
                                            </form>
                                            <!-- end form-->
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end page -->
        <!-- Vendor js -->
        <script src="{{ asset('cms/assets/js/vendor.min.js')}}"></script>
        <!-- App js -->
        <script src="{{ asset('cms/assets/js/app.min.js') }}"></script>
    </body>
</html>