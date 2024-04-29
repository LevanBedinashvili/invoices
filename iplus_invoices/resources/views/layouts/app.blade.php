<!doctype html>
<html lang="en">


<!-- Mirrored from themesdesign.in/webadmin/layouts/{{ route('index') }} by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 20 Jul 2023 01:21:56 GMT -->
<head>

    <meta charset="utf-8" />
    <title>iPlus | ინვოისები & საგარანტიო</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="" name="description" />
    <link rel="stylesheet" href="//cdn.web-fonts.ge/fonts/bpg-square-mtavruli/css/bpg-square-mtavruli.min.css">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


    <link rel="shortcut icon" href="{{ asset('template/images/favicon.ico') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">
    <!-- plugin css -->
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>


    <link href="{{ asset('template/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet" type="text/css" />



    <!-- Bootstrap Css -->
    <link href="{{ asset('template/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('template/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('template/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />


    <style>
        * {
            font-family: "BPG Square Mtavruli", sans-serif !important;
        }
    </style>


</head>



<body>
<div id="layout-wrapper">

    <header id="page-topbar" class="isvertical-topbar">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box">
                    <a href="{{ route('index') }}" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="{{ asset('template/azx_crat-75.jpg') }}" alt="" width="100px;" >
                                </span>
                        <span class="logo-lg">
                                    <img src="{{ asset('template/azx_crat-75.jpg') }}" alt="" height="26" width="100px;">
                                </span>
                    </a>

                    <a href="{{ route('index') }}" class="logo logo-light">
                                <span class="logo-lg">
                                    <img src="{{ asset('template/images/logo-light.png') }}" alt="" height="30" width="100px;">
                                </span>
                        <span class="logo-sm">
                                    <img src="{{ asset('template/images/logo-light-sm.png') }}" alt="" height="50" width="100px;">
                                </span>
                    </a>
                </div>

                <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect vertical-menu-btn">
                    <i class="bx bx-menu align-middle"></i>
                </button>

            </div>

            <div class="d-flex">
                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item user text-start d-flex align-items-center" id="page-header-user-dropdown-v"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="rounded-circle header-profile-user" src="{{ asset('template/guest.png') }}"
                             alt="Header Avatar">
                        <span class="d-none d-xl-inline-block ms-2 fw-medium font-size-15">{{ Auth::user()->name }}</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end pt-0">
                        <div class="p-3 border-bottom">
                            <h6 class="mb-0">{{ Auth::user()->name }}</h6>
                            <p class="mb-0 font-size-11 text-muted">{{ Auth::user()->email }}</p>
                        </div>
                        <a class="dropdown-item" href="{{ route('profile.index') }}"><i class="mdi mdi-account-circle text-muted font-size-16 align-middle me-2"></i> <span class="align-middle">პროფილი</span></a>
                        <a class="dropdown-item" href="{{ route('user.logout') }}"><i class="mdi mdi-logout text-muted font-size-16 align-middle me-2"></i> <span class="align-middle">გასვლა</span></a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- ========== Left Sidebar Start ========== -->
    <div class="vertical-menu">

        <!-- LOGO -->
        <div class="navbar-brand-box">
            <a href="{{ route('index') }}" class="logo logo-dark">
                        <span class="logo-sm">
                        </span>
                <span class="logo-lg">
                            <img src="{{ asset('template/azx_crat-75.jpg') }}" alt="" height="50" width="200">
                        </span>
            </a>

            <a href="{{ route('index') }}" class="logo logo-light">
                        <span class="logo-lg">
                            <img src="{{ asset('template/azx_crat-75.jpg') }}" alt="" height="50" width="200">
                        </span>
            </a>
        </div>

        <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect vertical-menu-btn">
            <i class="bx bx-menu"></i>
        </button>

        <div data-simplebar class="sidebar-menu-scroll">

            <!--- Sidemenu -->
            <div id="sidebar-menu">
                <!-- Left Menu Start -->
                <ul class="metismenu list-unstyled" id="side-menu">


                    <li>
                        <a href="{{ route('index') }}">
                            <i class="bx bx-home-alt icon nav-icon"></i>
                            <span class="menu-item" data-key="t-horizontal">მთავარი</span>
                        </a>
                    </li>

                    @if(Auth::user()->role_id == 1)


                    <li>
                        <a href="{{ route('branch.index') }}">
                            <i class="bx bx-layout icon nav-icon"></i>
                            <span class="menu-item" data-key="t-horizontal">ფილიალები</span>
                        </a>
                    </li>


                    {{-- <li>
                        <a href="{{ route('product.index') }}">
                            <i class="bx bx-file icon nav-icon"></i>
                            <span class="menu-item" data-key="t-horizontal">პროდუქტები</span>
                        </a>
                    </li> --}}


                    <li>
                        <a href="{{ route('payment.index') }}">
                            <i class="bx bx-file icon nav-icon"></i>
                            <span class="menu-item" data-key="t-horizontal">გადახდის ტიპები</span>
                        </a>
                    </li>


                    <li>
                        <a href="{{ route('templates.index') }}">
                            <i class="bx bx-file icon nav-icon"></i>
                            <span class="menu-item" data-key="t-horizontal">საგარანტიოს დიზაინი</span>
                        </a>
                    </li>


                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i class="bx bx-user-circle icon nav-icon"></i>
                            <span class="menu-item" data-key="t-contacts">ადმინ მენეჯმენტი</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('users.index') }}" data-key="t-user-grid">ადმინების სია</a></li>
                            <li><a href="{{ route('users.create') }}" data-key="t-user-list">ადმინის დამატება</a></li>
                        </ul>
                    </li>

                    @endif

                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i class="bx bx-receipt icon nav-icon"></i>
                            <span class="menu-item" data-key="t-ecommerce">ინვოისები</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('invoice.index') }}" data-key="t-products">ინვოისების სია</a></li>
                            <li><a href="{{ route('invoice.create') }}" data-key="t-product-detail">ინვოისის დამატება</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i class="bx bx-store icon nav-icon"></i>
                            <span class="menu-item" data-key="t-ecommerce">საგარანტიო</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('warranty.index') }}" data-key="t-products">საგარანტიოს სია</a></li>
                            <li><a href="{{ route('warranty.create') }}" data-key="t-product-detail">საგარანტიოს დამატება</a></li>
                        </ul>
                    </li>

                </ul>
            </div>
            <!-- Sidebar -->
        </div>
    </div>

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        @yield('content')

    </div>
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <script>document.write(new Date().getFullYear())</script> © iPlus.com.ge
                    </div>

                </div>
            </div>
        </footer>
    </div>

<!-- Right Sidebar -->
<div class="right-bar">
    <div data-simplebar class="h-100">
        <div class="rightbar-title d-flex align-items-center bg-dark p-3">

            <h5 class="m-0 me-2 text-white"></h5>

            <a href="javascript:void(0);" class="right-bar-toggle-close ms-auto">
                <i class="mdi mdi-close noti-icon"></i>
            </a>
        </div>

        <!-- Settings -->
        <hr class="m-0" />

        <div class="p-4">
            <h6 class="mb-3">Layout</h6>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="layout"
                       id="layout-vertical" value="vertical">
                <label class="form-check-label" for="layout-vertical">Vertical</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="layout"
                       id="layout-horizontal" value="horizontal">
                <label class="form-check-label" for="layout-horizontal">Horizontal</label>
            </div>

            <h6 class="mt-4 mb-3">Layout Mode</h6>

            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="layout-mode"
                       id="layout-mode-light" value="light">
                <label class="form-check-label" for="layout-mode-light">Light</label>
            </div>

            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="layout-mode"
                       id="layout-mode-dark" value="dark">
                <label class="form-check-label" for="layout-mode-dark">Dark</label>
            </div>

            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="layout-mode"
                       id="layout-mode-bordered" value="bordered">
                <label class="form-check-label" for="layout-mode-bordered">Bordered</label>
            </div>

            <h6 class="mt-4 mb-3">Layout Width</h6>

            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="layout-width"
                       id="layout-width-fluid" value="fluid" onchange="document.body.setAttribute('data-layout-size', 'fluid')">
                <label class="form-check-label" for="layout-width-fluid">Fluid</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="layout-width"
                       id="layout-width-boxed" value="boxed" onchange="document.body.setAttribute('data-layout-size', 'boxed')">
                <label class="form-check-label" for="layout-width-boxed">Boxed</label>
            </div>

            <h6 class="mt-4 mb-3">Layout Position</h6>

            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="layout-position"
                       id="layout-position-fixed" value="fixed" onchange="document.body.setAttribute('data-layout-scrollable', 'false')">
                <label class="form-check-label" for="layout-position-fixed">Fixed</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="layout-position"
                       id="layout-position-scrollable" value="scrollable" onchange="document.body.setAttribute('data-layout-scrollable', 'true')">
                <label class="form-check-label" for="layout-position-scrollable">Scrollable</label>
            </div>

            <h6 class="mt-4 mb-3">Topbar Type</h6>


            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="topbar-color"
                       id="topbar-color-light" value="light" onchange="document.body.setAttribute('data-topbar', 'light')">
                <label class="form-check-label" for="topbar-color-light">Light</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="topbar-color"
                       id="topbar-color-dark" value="dark" onchange="document.body.setAttribute('data-topbar', 'dark')">
                <label class="form-check-label" for="topbar-color-dark">Dark</label>
            </div>

            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="topbar-color"
                       id="topbar-type-hidden" value="hidden" onchange="document.body.setAttribute('data-topbar', 'hidden')">
                <label class="form-check-label" for="topbar-type-hidden">Hidden</label>
            </div>


            <div id="sidebar-setting">
                <h6 class="mt-4 mb-3 sidebar-setting">Sidebar Size</h6>

                <div class="form-check sidebar-setting">
                    <input class="form-check-input" type="radio" name="sidebar-size"
                           id="sidebar-size-default" value="default" onchange="document.body.setAttribute('data-sidebar-size', 'lg')">
                    <label class="form-check-label" for="sidebar-size-default">Default</label>
                </div>
                <div class="form-check sidebar-setting">
                    <input class="form-check-input" type="radio" name="sidebar-size"
                           id="sidebar-size-compact" value="compact" onchange="document.body.setAttribute('data-sidebar-size', 'md')">
                    <label class="form-check-label" for="sidebar-size-compact">Compact</label>
                </div>
                <div class="form-check sidebar-setting">
                    <input class="form-check-input" type="radio" name="sidebar-size"
                           id="sidebar-size-small" value="small" onchange="document.body.setAttribute('data-sidebar-size', 'sm')">
                    <label class="form-check-label" for="sidebar-size-small">Small (Icon View)</label>
                </div>

                <h6 class="mt-4 mb-3 sidebar-setting">Sidebar Color</h6>

                <div class="form-check sidebar-setting">
                    <input class="form-check-input" type="radio" name="sidebar-color"
                           id="sidebar-color-light" value="light" onchange="document.body.setAttribute('data-sidebar', 'light')">
                    <label class="form-check-label" for="sidebar-color-light">Light</label>
                </div>
                <div class="form-check sidebar-setting">
                    <input class="form-check-input" type="radio" name="sidebar-color"
                           id="sidebar-color-dark" value="dark" onchange="document.body.setAttribute('data-sidebar', 'dark')">
                    <label class="form-check-label" for="sidebar-color-dark">Dark</label>
                </div>
                <div class="form-check sidebar-setting">
                    <input class="form-check-input" type="radio" name="sidebar-color"
                           id="sidebar-color-brand" value="brand" onchange="document.body.setAttribute('data-sidebar', 'brand')">
                    <label class="form-check-label" for="sidebar-color-brand">Brand</label>
                </div>
            </div>

            <h6 class="mt-4 mb-3">Direction</h6>

            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="layout-direction"
                       id="layout-direction-ltr" value="ltr">
                <label class="form-check-label" for="layout-direction-ltr">LTR</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="layout-direction"
                       id="layout-direction-rtl" value="rtl">
                <label class="form-check-label" for="layout-direction-rtl">RTL</label>
            </div>

        </div>

    </div> <!-- end slimscroll-menu-->
</div>
<!-- /Right-bar -->

<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<script src="https://code.jquery.com/jquery-3.7.0.js"> </script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"> </script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"> </script>
<script>
    new DataTable('#example');
</script>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="{{ asset('template/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('template/libs/metismenujs/metismenujs.min.js') }}"></script>
<script src="{{ asset('template/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('template/libs/eva-icons/eva.min.js') }}"></script>

<script src="{{ asset('template/libs/apexcharts/apexcharts.min.js') }}"></script>

<script src="{{ asset('template/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
<script src="{{ asset('template/libs/jsvectormap/maps/world-merc.js') }}"></script>

<script src="{{ asset('template/js/pages/dashboard.init.js') }}"></script>

<script src="{{ asset('template/js/app.js') }}"></script>




</body>

<style>
    #my-select-id{
        margin-top: 15px;
    }
</style>

</html>
