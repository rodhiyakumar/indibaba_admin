@extends('layout/master')
@section('content')
    @if (request()->route()->parameters)
        @php
            $params = request()->route()->parameters;
            $id = $params['id'];
        @endphp
    @endif
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
            {{-- {{ dd($category['categoryName']) }} --}}




            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-lg-6 col-12">
                        <div class="box">
                            <div class="box-header with-boder">
                                <h4 class="">Create Coupon</h4>
                            </div>
                            <form class="form" id="{{ isset($id) ? 'update_category' : 'add_category' }}" novalidate="novalidate">
                                {{-- @csrf --}}
                                <div class="box-body">
                                    @if (session('categoryUpdate') !== null)
                                        <div class="alert alert-success alert-dismissible">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                            <i class="icon fa fa-check"></i> {{ session('categoryUpdate') }}
                                        </div>
                                    @endif
                                    <input type="hidden" name="edit_id" value="{{ isset($id) ? $id : '' }}">
                                    <div class="form-group">
                                        <label>Course <i class="text-danger">*</i></label>
                                        <select class="form-control" id="courseId" name="courseId">
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label> Coupon Name <i>*</i></label>
                                        <input type="text" value="{{ isset($id) ? $coupon['couponName'] : '' }}" name="couponName" id="couponName" class="form-control" placeholder="Enter Coupon Name">
                                    </div>
                                    <div class="form-group">
                                        <label> Coupon Discount <i>*</i></label>
                                        <input type="text" value="{{ isset($id) ? $coupon['couponDiscount'] : '' }}" name="couponDiscount" id="couponDiscount" class="form-control" placeholder="Enter Coupon Discount">
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-rounded btn-success btn-outline">
                                        <i class="ti-save-alt"></i>
                                        Save
                                    </button>
                                    @if (isset($id))
                                        <a href="{{ url('course-category') }}" class="btn btn-rounded  btn-outline mr-1">
                                            <i class="ti-trash"></i> Cancel
                                        </a>
                                    @else
                                        <button type="reset" class="btn btn-rounded  btn-outline mr-1">
                                            <i class="ti-trash"></i> Reset
                                        </button>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="box">
                            <div class="box-header with-boder">
                                <h4 class="">List</h4>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped mb-0" id="dataTable">

                                        <thead>
                                            <tr>
                                                <th scope="col">Action</th>
                                                <th scope="col">Coupon</th>
                                                <th scope="col">Course</th>
                                                <th scope="col">Discount</th>
                                                <th scope="col">Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
            </section>
            <!-- /.content -->
        </div>
    </div>
@endsection


@section('scripts')
    <script>
        var course = @json($course);
        var couponId = '';
        @if (isset($id))
            var coupon = @json($coupon);
            couponId = @json($id);
        @endif
        $(document).ready(function() {
            getCoupons();
            getCourse();
        });

        function getCourse() {
            var html = `<option>Select</option>`;
            course.forEach(cc => {
                html += `<option value="${cc.id}">${cc.courseName}</option>`;
            });
            $("#courseId").html(html);
            if (couponId && couponId != '') {
                $("#courseId").val(coupon.courseId);
            }
        }
        // get course category
        function getCoupons() {
            $("#dataTable").dataTable().fnDestroy();
            $('#dataTable').DataTable({
                ajax: "{{ url('get-coupon') }}",
                "bSort": false,
                // "serverSide": true,
                "processing": true,
                aoColumns: [{
                        mData: null,
                        "bSortable": false,
                        "mRender": function(d) {
                            let btn = '';
                            btn +=
                                `<a href='{{ url('coupon') }}/${d.id}'  class='btn btn-xs btn-success '><i class="fa fa-edit"></i></a>&nbsp;`;
                            btn +=
                                `<a href='javascript:void(0)' onclick='deleteCategory(${d.id})' class='btn btn-xs btn-danger deleteCategory'><i class="fa fa-trash"></i></a>`;
                            // btn += `<a href='javascript:void(0)'></a>`;
                            return btn;
                        }
                    },
                    {
                        mData: 'couponName'
                    },
                    {
                        mData: null,
                        "mRender": function(d) {
                            return d.course ? d.course.courseName : ''
                        }
                    },
                    {
                        mData: 'couponDiscount'
                    },
                    {
                        mData: null,
                        "sWidth": "200px",
                        "mRender": function(d) {
                            let date =
                                `<b>Created At</b> ${date_time_format(d.createdAt,'MMM, DD YYYY')}<br/>`;
                            date += `<b>Updated At</b> ${date_time_format(d.updatedAt,'MMM, DD YYYY')}`;
                            return date;
                        }
                    }
                ]
            });
        }

        // store category
        $("#add_category").validate({
            rules: {
                couponName: 'required',
                couponDiscount: 'required',
                courseId: 'required'
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
                var data = $(form).serialize() + "&_token={{ csrf_token() }}";
                console.log(data);
                $.ajax({
                    type: 'post',
                    url: "{{ url('add-coupon-action') }}",
                    data: data,
                    dataType: 'json',
                    beforeSend: function() {
                        $("body").addClass("loading");
                    },
                    success: function(result) {
                        if (result.code == 401) {
                            window.location.href = "{{ url('logout') }}";
                        } else if (result.status) {
                            $.toast({
                                heading: result.toastHeading,
                                text: result.message,
                                icon: result.toastIcon,
                                hideAfter: 5000,
                                position: 'top-right',
                            });
                            $("#add_category")[0].reset();
                            getCoupons();
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


        // update  course category
        $("#update_category").validate({
            rules: {
                couponName: 'required',
                couponDiscount: 'required',
                courseId: 'required'
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
                var data = $(form).serialize() + "&_token={{ csrf_token() }}";
                $.ajax({
                    type: 'post',
                    url: "{{ url('edit-coupon-action') }}",
                    data: data,
                    dataType: 'json',
                    beforeSend: function() {
                        $("body").addClass("loading");
                    },
                    success: function(result) {
                        if (result.code == 401) {
                            window.location.href = "{{ url('logout') }}";
                        } else if (result.status) {
                            window.location.href = "{{ url('coupon') }}";
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


        // delete a category
        function deleteCategory(id) {
            const chk = confirm('Are you sure you want to delete this item?');
            if (chk === true) {
                $.ajax({
                    url: "{{ url('delete-coupon-action') }}/" + id,
                    type: 'delete',
                    data: {
                        '_token': "{{ csrf_token() }}",
                        id
                    },
                    success: function(result) {
                        if (result.status) {
                            $.toast({
                                heading: 'Success',
                                text: result.message,
                                icon: 'success',
                                hideAfter: 5000,
                                position: 'top-right',
                            });
                            getCoupons();
                        } else {
                            $.toast({
                                heading: 'Error',
                                text: result.message,
                                icon: 'error',
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
        }
    </script>
@endsection
