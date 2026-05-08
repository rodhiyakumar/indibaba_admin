<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="">

    <title>Login</title>

    <!-- Vendors Style-->
    <link rel="stylesheet" href="{{ asset('assets/css/vendors_css.css') }}">

    <!-- Style-->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/skin_color.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <link href="{{ asset('assets/css/jquery.toast.css') }}" rel="stylesheet" type="text/css" />
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

        /* Turn off scrollbar when body element has the loading class */
        body.loading {
            overflow: hidden;
        }

        /* Make spinner image visible when body element has the loading class */
        body.loading #loadingDiv {
            display: block;
        }
    </style>
</head>

<body class="hold-transition theme-primary bg-img" data-overlay="5">
    <div id="loadingDiv">
        <div class="loader"></div>
    </div>
    <div class="container h-p100">
        <div class="row align-items-center justify-content-md-center h-p100">

            <div class="col-12">
                <div class="row justify-content-center no-gutters">
                    <div class="col-lg-5 col-md-5 col-12">
                        <div class="bg-white rounded30 shadow-lg">
                            <div class="content-top-agile p-20 pb-0">
                                <h2 class="text-primary">Let's Get Started</h2>
                                <p class="mb-0">Sign in to continue to Admin.</p>
                            </div>
                            <div class="p-40">
                                <form id="admin_login" method="post">
                                    <div class="form-group">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-transparent"><i class="ti-user"></i></span>
                                            </div>
                                            <input type="text" name="email_id" class="form-control pl-15 bg-transparent" placeholder="Email Id">
                                            {{ csrf_field() }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text  bg-transparent"><i class="ti-lock"></i></span>
                                            </div>
                                            <input type="password" name="password" class="form-control pl-15 bg-transparent" placeholder="Password">
                                        </div>
                                    </div>
                                    <div class="row">
                                        {{-- <div class="col-6">
                                            <div class="checkbox">
                                                <input type="checkbox" id="basic_checkbox_1">
                                                <label for="basic_checkbox_1">Remember Me</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="fog-pwd text-right">
                                                <a href="javascript:void(0)" class="hover-warning"><i class="ion ion-locked"></i> Forgot pwd?</a><br>
                                            </div>
                                        </div> --}}
                                        <!-- /.col -->
                                        <div class="col-12 text-center">
                                            <button type="submit" class="btn btn-danger mt-10">SIGN IN</button>
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Vendor JS -->
    <script src="{{ asset('assets/js/vendors.min.js') }}"></script>
    <script src="{{ asset('assets/assets/icons/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.toast.js') }}"></script>
</body>

</html>
<script>
    // const APP_URL = {
    //     !!json_encode(url('/')) !!
    // }
    // $(document).ready(function(){

    // 	// console.log("{{ url('/') }}");
    // 	// console.log(APP_URL);
    // });
</script>
<script>
    $("#admin_login").validate({
        rules: {
            email_id: {
                required: true,
                email: true
            },
            password: 'required',
        },
        errorPlacement: function errorPlacement(error, element) {
            var $parent = $(element).parents('.input-group');
            // Do not duplicate errors
            if ($parent.find('.jquery-validation-error').length) {
                return;
            }
            $parent.append(
                error.addClass('jquery-validation-error small form-text invalid-feedback')
            );
        },
        highlight: function(element) {
            var $el = $(element);
            var $parent = $(element).parents('.form-group');
            $el.addClass('is-invalid');
        },
        unhighlight: function(element) {
            $(element).parents('.form-group').find('.is-invalid').removeClass('is-invalid');
        },
        submitHandler: function(form) {
            var data = $(form).serialize();
            $.ajax({
                type: 'post',
                url: "{{ route('auth') }}",
                data: data,
                dataType: 'json',
                beforeSend: function() {
                    $("body").addClass("loading");
                },
                success: function(result) {
                    if (result.status) {
                        $.toast({
                            heading: result.toastHeading,
                            text: result.message,
                            icon: result.toastIcon,
                            hideAfter: 5000,
                            position: 'top-right',
                        });
                        window.setTimeout(() => {
                            window.location.href = "{{ route('dashboard') }}";
                        }, 1000);
                    } else {
                        $.toast({
                            heading: result.toastHeading,
                            text: result.message,
                            icon: result.toastIcon,
                            hideAfter: 5000,
                            position: 'top-right',
                        });
                    }
                },
                complete: function() {
                    $("body").removeClass("loading");
                },
            });
        }
    });
</script>
