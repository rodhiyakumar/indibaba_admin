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
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Category Name <i class="text-danger">*</i></label>
                                                <input type="text" name="categoryName" id="categoryName" class="form-control" value="{{ isset($id) ? $category['categoryName'] : '' }}" placeholder="Enter Category Name">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Category Icon (Recommended size: W: 400px x H: 400px)</label>
                                                <div id="imageUploadDropzone" class="dropzone"></div>
                                                @if (isset($id) && $category['image'])
                                                    <div class="dropzone-preload col-sm-1 text-center">
                                                        <img src="{{ $category['image'] }}" class="img-fluid">
                                                        <a href="javascript:void(0)" class="btn btn-xs btn-danger" onclick="deleteFile('{{ $category['image'] }}')"><i class="fa fa-trash"></i></a>
                                                    </div>
                                                @endif
                                                <input type="hidden" name="image" id="image" class="form-control" value="{{ isset($id) ? $category['image'] : '' }}" placeholder="Image">
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
        var submitUrl = "{{ route('category.store') }}";
        var redirectUrl = "{{ route('category.list') }}";
        var category, categoryId = "";
        @if (isset($id))
            var category = @json($category);
            var categoryId = @json($id);
            submitUrl = "{{ route('category.update', ['id' => ':id']) }}";
            submitUrl = submitUrl.replace(':id', categoryId);
        @endif

        Dropzone.autoDiscover = false;
        var uploadedImages = [];

        var myDropzone = new Dropzone("#imageUploadDropzone", {
            url: HOST_URL + `/dropzone`,
            // autoProcessQueue: false,
            // uploadMultiple: false,
            maxFiles: 1,
            maxFilesize: 1,
            acceptedFiles: "image/jpeg,image/jpg,image/png",
            addRemoveLinks: true,
            dictDefaultMessage: "Drag and drop image here or click to upload",
            init: function() {
                this.on("addedfile", function(file) {
                    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                    if (!allowedTypes.includes(file.type)) {
                        this.removeFile(file);
                        return;
                    }

                    let formData = new FormData();
                    formData.append("file", file);
                    formData.append("type", "category");
                    $.ajax({
                        url: "{{ route('upload') }}", // Your Laravel API route
                        method: "POST",
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            console.log("Upload Success", response);
                            uploadedImages.push(response.file); // store filename or URL
                            var response = JSON.parse(response);
                            if (response.status) {
                                $("#image").val(response.data.public_url);
                            }
                        },
                        error: function(xhr) {
                            console.error("Upload Failed", xhr.responseText);
                        }
                    });
                });
            }
        });

        $(document).ready(function() {})

        function reset_btn() {}

        $("#addForm, #updateForm").validate({
            rules: {
                // categoryName: "required"
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

        // Delete Category
        function deleteFile(url) {
            const chk = confirm('Are you sure you want to delete this file?');
            var deleteUrl = "{{ route('subCategory.deleteFile', ['id' => ':id']) }}";
            deleteUrl = deleteUrl.replace(':id', categoryId);
            if (chk === true) {
                $(".dropzone-preload").html("");
                $("#image").val("");
            }
        }
    </script>
@endsection
