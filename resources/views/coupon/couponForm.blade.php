@extends('layout/master')
@section('content')
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
                                    <li class="breadcrumb-item"><a href={{ url('dashboard') }}><i class="mdi mdi-home-outline"></i></a></li>
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
                    <div class="col-lg-12 col-12">
                        <div class="box">
                            <form method="post" id="{{ isset($id) ? 'updateForm' : 'addForm' }}">
                                <input type="hidden" name="edit_id" value="{{ isset($id) ? $id : '' }}">
                                <div class="box-header with-boder">
                                    <h4 class="box-title">{{ isset($id) ? 'Update' : 'Add' }}</h4>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Coupon Name <i class="text-danger">*</i></label>
                                                <input type="text" name="couponName" id="couponName" class="form-control" value="{{ isset($id) ? $coupon['couponName'] : '' }}" placeholder="Enter Coupon Name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Discount <i class="text-danger">*</i></label>
                                                <input type="text" name="couponDiscount" id="couponDiscount" class="form-control" value="{{ isset($id) ? $coupon['couponDiscount'] : '' }}" placeholder="Enter Discount">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-rounded btn-success btn-outline">
                                        <i class="ti-save-alt"></i> {{ isset($id) ? 'Update' : 'Save' }}
                                    </button>
                                    @if (isset($id))
                                        <a href="{{ url('add-product') }}" class="btn btn-rounded  btn-outline mr-1">
                                            <i class="ti-trash"></i> Cancel
                                        </a>
                                    @else
                                        <button type="reset" onclick="reset_btn()" class="btn btn-rounded  btn-outline mr-1">
                                            <i class="ti-trash"></i> Reset
                                        </button>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection


@section('scripts')
    <script src="{{ asset('assets/js/summernote-bs4.min.js') }}"></script>
    <script>
        var submitUrl = "{{ route('coupon.store') }}";
        var redirectUrl = "{{ route('coupon.list') }}";
        var coupon, couponId = "";
        @if (isset($id))
            var coupon = @json($coupon);
            var couponId = @json($id);
            submitUrl = "{{ route('coupon.update', ['id' => ':id']) }}";
            submitUrl = submitUrl.replace(':id', couponId);
        @endif

        $(document).ready(function() {})

        function reset_btn() {}

        $("#addForm, #updateForm").validate({
            rules: {
                couponName: "required",
                couponDiscount: "required"
            },
            errorPlacement: function errorPlacement(error, element) {
                var $parent = $(element).parents('.form-group');
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
                var data = new FormData(form);
                data.append('_token', "{{ csrf_token() }}");
                $.ajax({
                    type: 'post',
                    url: submitUrl,
                    data: data,
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
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
                            window.location.href = redirectUrl;
                            reset_btn();
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
@endsection
