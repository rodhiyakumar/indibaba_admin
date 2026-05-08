@extends('layout/master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="container-full">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="d-flex align-items-center">
                    <div class="mr-auto">
                        <h3 class="page-title">{{ $title }}</h3>
                        <div class="d-inline-block align-items-center">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href={{ url('dashboard') }}><i class="fa fa-home"></i></a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-12 col-lg-7 col-xl-8">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li><a class="active" href="#profile" data-toggle="tab">Profile</a></li>
                                <li><a href="#settings" data-toggle="tab">Settings</a></li>
                            </ul>
                            <div class="tab-content">
                                {{-- Profile tab --}}
                                <div class="active tab-pane" id="profile">
                                    <div class="box p-15">
                                        <form class="form-horizontal form-element col-12" id="profileUpdate">
                                            <div class="form-group row">
                                                <label for="inputName" class="col-sm-2 control-label">Name</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="name" class="form-control" placeholder="Enter Name" value="{{ $currentUser['name'] }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputEmail" class="col-sm-2 control-label">Email</label>
                                                <div class="col-sm-10">
                                                    <input type="email" class="form-control" readonly value="{{ $currentUser['email'] }}" placeholder="Enter Email">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputPhone" class="col-sm-2 control-label">Mobile No</label>

                                                <div class="col-sm-10">
                                                    <input type="text" name="mobile" maxlength="13" class="form-control" placeholder="Enter Mobile No" value="{{ $currentUser['mobile'] }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="ml-auto col-sm-10">
                                                    <button type="submit" class="btn btn-success">Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                {{-- settings tab --}}
                                <div class="tab-pane" id="settings">
                                    <div class="box p-15">
                                        <form class="form-horizontal form-element col-12" id="changePassword">
                                            <div class="form-group row">
                                                <label for="inputName" class="col-sm-2 control-label">Old Password</label>
                                                <div class="col-sm-10">
                                                    <input type="password" name="old" class="form-control" placeholder="Enter Old Password">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputEmail" class="col-sm-2 control-label">New Password</label>
                                                <div class="col-sm-10">
                                                    <input type="password" name="new" class="form-control" placeholder="Enter New Password">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputPhone" class="col-sm-2 control-label">Confirm
                                                    Password</label>

                                                <div class="col-sm-10">
                                                    <input type="password" name="confirm" class="form-control" placeholder="Enter Confirm Password">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="ml-auto col-sm-10">
                                                    <button type="submit" class="btn btn-success">Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                {{-- basic tab --}}
                            </div>
                        </div>
                    </div>
                    <!-- /.col -->

                    <div class="col-12 col-lg-5 col-xl-4">
                        <div class="box box-widget widget-user">
                            <!-- Add the bg color to the header using any of the bg-* classes -->
                            <div class="widget-user-header bg-black" style="background: url({{ asset('assets/images/gallery/full/10.jpg') }}) center center;">
                                <h3 class="widget-user-username">{{ $currentUser['name'] }}</h3>
                            </div>
                            <div class="widget-user-image">
                                <img class="rounded-circle" src={{ asset('assets/img/user.png') }}>
                            </div>
                        </div>
                        <br /><br />
                        <div class="box">
                            <div class="box-body box-profile">
                                <div class="row">
                                    <div class="col-12">
                                        <div>
                                            <p>Email :<span class="text-gray pl-10">{{ $currentUser['email'] }}</span>
                                            </p>
                                            <p>Mobile :<span class="text-gray pl-10">{{ $currentUser['mobile'] }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </section>
            <!-- /.content -->
        </div>
    </div>
    <!-- /.content-wrapper -->
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $("#profileUpdate").validate({
                rules: {
                    phone_no: {
                        required: true,
                        number: true
                    },
                    name: 'required',
                },
                errorPlacement: function errorPlacement(error, element) {
                    var $parent = $(element).parents('.form-group .col-sm-10');
                    // Do not duplicate errors
                    if ($parent.find('.jquery-validation-error').length) {
                        return;
                    }
                    $parent.append(
                        error.addClass('jquery-validation-error small form-text invalid-feedback')
                    );
                },
                highlight: function(element) {},
                unhighlight: function(element) {},
                submitHandler: function(form) {

                    var data = $(form).serialize() + "&_token={{ csrf_token() }}&type=profile";
                    $.ajax({
                        type: 'post',
                        url: "{{ route('profile.update') }}",
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
                                const name = result.name.split(' ');
                                $(".user-profile .info h5").html(name[0]);
                                $(".widget-user .widget-user-username").html(name[0]);
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

            $("#changePassword").validate({
                rules: {
                    old: 'required',
                    new: 'required',
                    confirm: 'required'
                },
                errorPlacement: function errorPlacement(error, element) {
                    var $parent = $(element).parents('.form-group .col-sm-10');
                    // Do not duplicate errors
                    if ($parent.find('.jquery-validation-error').length) {
                        return;
                    }
                    $parent.append(
                        error.addClass('jquery-validation-error small form-text invalid-feedback')
                    );
                },
                highlight: function(element) {},
                unhighlight: function(element) {},
                submitHandler: function(form) {

                    var data = $(form).serialize() + "&_token={{ csrf_token() }}&type=password";
                    $.ajax({
                        type: 'post',
                        url: "{{ url('update-profile') }}",
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
                                $("#changePassword")[0].reset();
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
        });
    </script>
@endsection
