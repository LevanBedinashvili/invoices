<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>iPlus Invoices</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="W3crm:Customer Relationship Management Admin Bootstrap 5 Template">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/favicon.png') }}">
    <link rel="stylesheet" href="//cdn.web-fonts.ge/fonts/bpg-square-mtavruli/css/bpg-square-mtavruli.min.css">
    <link href="{{ asset('template/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="{{ asset('template/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('template/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <style>
        * {
            font-family: "BPG Square Mtavruli", sans-serif !important;
        }
    </style>
</head>

<body>

<div class="authentication-bg min-vh-100">
    <div class="bg-overlay bg-light"></div>
    <div class="container">
        <div class="d-flex flex-column min-vh-100 px-3 pt-4">
            <div class="row justify-content-center my-auto">
                <div class="col-md-8 col-lg-6 col-xl-5">

                    <div class="mb-4 pb-2">
                        <a href="index.html" class="d-block auth-logo">
                            <img src="{{ asset('assets/images/logo-dark.png') }}" alt="" height="30"
                                 class="auth-logo-dark me-start">
                            <img src="{{ asset('assets/images/logo-light.png') }}" alt="" height="30"
                                 class="auth-logo-light me-start">
                        </a>
                    </div>

                    <div class="card">
                        <div class="card-body p-4">
                            <div class="text-center mt-2">
                                <h5>ავტორიზაცია</h5>
                                <p class="text-muted">შესვლა iPlus Invoices-ში</p>
                            </div>
                            <div class="p-2 mt-4">
                                <form action="{{ route('login') }}" method="POST">
                                    @csrf
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <div class="mb-3">
                                        <label class="form-label" for="email">ელ.ფოსტა</label>
                                        <div class="position-relative input-custom-icon">
                                            <input type="email" class="form-control" id="email"
                                                   placeholder="hello@example.com" name="email">
                                            <span class="bx bx-user"></span>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="password">პაროლი</label>
                                        <div class="position-relative auth-pass-inputgroup input-custom-icon">
                                            <span class="bx bx-lock-alt"></span>
                                            <input type="password" class="form-control" id="password"
                                                   name="password">
                                        </div>
                                    </div>
                                    <div class="form-check py-1">
                                        <input type="checkbox" class="form-check-input" id="remember"
                                               name="remember">
                                        <label class="form-check-label" for="remember">დამახსოვრება</label>
                                    </div>
                                    <div class="mt-3">
                                        <button class="btn btn-primary w-100 waves-effect waves-light"
                                                type="submit">შესვლა</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div><!-- end col -->
            </div><!-- end row -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center p-4">
                        <p>© <script>document.write(new Date().getFullYear())</script> iPlus.com.ge</p>
                    </div>
                </div>
            </div>

        </div>
    </div><!-- end container -->
</div>
<!-- end authentication section -->

<!-- JAVASCRIPT -->
<script src="{{ asset('template/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('template/libs/metismenujs/metismenujs.min.js') }}"></script>
<script src="{{ asset('template/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('template/libs/eva-icons/eva.min.js') }}"></script>
<script src="{{ asset('template/js/pages/pass-addon.init.js') }}"></script>
</body>

</html>
