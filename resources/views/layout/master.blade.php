<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="">
    <title>{{ $title }}</title>
    <!-- Vendors Style-->
    <link rel="stylesheet" href="{{ asset('assets/css/vendors_css.css') }}">
    <!-- Style-->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/skin_color.css') }}">
    <link href="{{ asset('assets/css/cropper.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/jquery.toast.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/css/dropzone.min.css') }}">
    <link href="{{ asset('assets/css/summernote-bs4.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <style>
        .loader,
        .loader:after {
            border-radius: 50%;
            width: 50px;
            height: 50px;
        }

        .loader {
            top: 45%;
            margin: auto;
            font-size: 10px;
            position: relative;
            text-indent: -9999em;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #171717;
            -webkit-transform: translateZ(0);
            -ms-transform: translateZ(0);
            transform: translateZ(0);
            -webkit-animation: load8 1.1s infinite linear;
            animation: load8 1.1s infinite linear;
        }

        @-webkit-keyframes load8 {
            0% {
                -webkit-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        @keyframes load8 {
            0% {
                -webkit-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        #loadingDiv {
            display: none;
            position: fixed;
            z-index: 999999;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.8);
        }


        /* @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        } */

        /* Turn off scrollbar when body element has the loading class */
        body.loading {
            overflow: hidden;
        }

        /* Make spinner image visible when body element has the loading class */
        body.loading #loadingDiv {
            display: block;
        }

        .main-header .justify-content-between {
            justify-content: normal !important;
        }

        .d-show {
            display: block;
        }

        .d-hide {
            display: none;
        }
    </style>
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary">
    <div id="loadingDiv">
        <div class="loader"></div>
    </div>
    <div class="wrapper">
        <header class="main-header">
            <div class="d-flex align-items-center logo-box justify-content-between">
                <a href="#" class="waves-effect waves-light nav-link rounded d-none d-md-inline-block mx-10 push-btn" data-toggle="push-menu" role="button">
                    <i class="ti-menu"></i>
                </a>
                <!-- Logo -->
                <a href={{ url('dashboard') }} class="logo">
                    <!-- logo-->
                    <div class="logo-lg">
                        Admin Panel
                        {{-- <span class="light-logo"><img src="{{ url('assets/img/logo.png') }}" style="max-width: 72%;" alt="logo">
                        </span>
                        <span class="dark-logo"><img src="{{ url('assets/img/logo.png') }}" style="max-width: 72%;" alt="logo">
                        </span> --}}
                    </div>
                </a>
            </div>
            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top pl-10">
                <div class="app-menu">
                    <ul class="header-megamenu nav">
                    </ul>
                </div>
                <!-- Sidebar toggle button-->
                <div class="navbar-custom-menu r-side">
                    <ul class="nav navbar-nav">
                        <li class="btn-group nav-item d-lg-inline-flex d-none">
                            <a href="#" data-provide="fullscreen" class="waves-effect waves-light nav-link rounded full-screen" title="Full Screen">
                                <i class="ti-fullscreen"></i>
                            </a>
                        </li>
                        <li class="dropdown user user-menu">
                            <a href="#" class="waves-effect waves-light dropdown-toggle" data-toggle="dropdown" title="User">
                                <i class="ti-user"></i>
                            </a>
                            <ul class="dropdown-menu animated flipInX">
                                <li class="user-body">
                                    <a class="dropdown-item" href={{ url('profile') }}><i class="ti-user text-muted mr-2"></i> Profile</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ url('logout') }}">
                                        <i class="ti-lock text-muted mr-2"></i> Logout
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- Left side bar start -->
        @include('layout/menus')
        <!-- Left side bar end -->
        <!-- Content Wrapper. Contains page content -->
        @yield('content')
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            &copy; 2023 Indibaba. Powered by <a href="https://www.capthronetechnologies.com" target="_blank">Capthrone Technologies</a>.
        </footer>
    </div>
    <!-- Vendor JS -->
    <script src="{{ asset('assets/js/vendors.min.js') }}"></script>
    <script src="{{ asset('assets/assets/icons/feather-icons/feather.min.js') }}"></script>
    {{-- @if (Request::path() == 'dashboard')
        <script src="{{ asset('assets/assets/vendor_components/apexcharts-bundle/dist/apexcharts.js') }}"></script>
        <script src="{{ asset('assets/assets/vendor_components/progressbar.js-master/dist/progressbar.js') }}"></script>
        <script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
    @endif --}}
    <!-- Florence Admin App -->
    <script src="{{ asset('assets/js/template.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="{{ asset('assets/js/demo.js') }}"></script>
    @yield('autocomplete-scripts')
    <script src="{{ asset('assets/js/pages/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.toast.js') }}"></script>
    <script src="{{ asset('assets/js/cropper.js') }}"></script>
    <script src="{{ asset('assets/assets/vendor_components/datatable/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/ckeditor/ckeditor.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="{{ asset('assets/js/dropzone.min.js') }}"></script>
    <script>
        const HOST_URL = "{{ url('/') }}";
        const admin_id = "{{ session('admin_id') }}";
        //split created/update by name
        function split_createdBy(name) {
            const sp_name = name.split(" ");
            return sp_name[0];
        }

        function date_time_format(date, format) {
            return moment(date).format(format);
        }
        const replaceCkeditor =
            `<span class="cke_reset cke_widget_drag_handler_container" style="background: url(&quot;{{ url('ckeditor/plugins/widget/images/handle.png') }}&quot;) rgba(220, 220, 220, 0.5); top: -15px; left: 0px;"><img class="cke_reset cke_widget_drag_handler" data-cke-widget-drag-handler="1" src="data:image/gif;base64,R0lGODlhAQABAPABAP///wAAACH5BAEKAAAALAAAAAABAAEAAAICRAEAOw==" width="15" title="Click and drag to move" height="15" role="presentation" draggable="true"></span>`;
    </script>
    @yield('scripts')
</body>

</html>
