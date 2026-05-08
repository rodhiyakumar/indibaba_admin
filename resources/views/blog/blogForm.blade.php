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
                            <form method="post" id="{{ isset($id) ? 'updateBlog' : 'addBlog' }}">
                                <input type="hidden" name="edit_id" value="{{ isset($id) ? $id : '' }}">
                                <div class="box-header with-boder">
                                    <h4 class="box-title">{{ isset($id) ? 'Update' : 'Add' }}</h4>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Title <i class="text-danger">*</i></label>
                                                <input type="text" name="title" id="title" class="form-control" value="{{ isset($id) && isset($blog['title']) ? $blog['title'] : '' }}" placeholder="Enter Title" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Meta Description</label>
                                                <input type="text" name="metaDescription" id="metaDescription" class="form-control" value="{{ isset($id) && isset($blog['metaDescription']) ? $blog['metaDescription'] : '' }}" placeholder="Enter Meta Description">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        @if (isset($id))
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Active <i class="text-danger">*</i></label>
                                                    <select class="form-control" name="isActive" id="isActive" required>
                                                        <option value="1" @if (isset($id) && $blog['isActive'] === 1) selected @endif>Yes</option>
                                                        <option value="0" @if (isset($id) && $blog['isActive'] === 0) selected @endif>No</option>
                                                    </select>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="row" id="images_box">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Images <i class="text-danger">*</i> (Recommended size: W: 2000px x H: 1300px)</label>
                                                <div id="imageUploadDropzone" class="dropzone {{ isset($id) && !empty($blog['image']) ? 'd-none' : 'd-show' }}">
                                                </div>
                                            </div>
                                        </div>
                                        @if (isset($id) && $blog['image'])
                                            <div class="dropzone-preload col-sm-1 text-center">
                                                <img src="{{ $blog['image'] }}" class="img-fluid">
                                                <a href="javascript:void(0)" class="btn btn-xs btn-danger" onclick="deleteBlogFile('{{ $blog['image'] }}')"><i class="fa fa-trash"></i></a>
                                            </div>
                                        @endif
                                        <input type="hidden" name="image" class="form-control" id="image" value="{{ isset($id) ? '' : '' }}" placeholder="">
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Description</label>
                                                <textarea id="description" name="description">{{ isset($id) ? $blog['description'] : '' }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-rounded btn-success btn-outline">
                                        <i class="ti-save-alt"></i> {{ isset($id) ? 'Update' : 'Save' }}
                                    </button>
                                    @if (isset($id))
                                        <button type="reset" onclick="cancel_btn()" class="btn btn-rounded  btn-outline mr-1">
                                            <i class="ti-trash"></i> Cancel
                                        </button>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
    <script>
        var submitUrl = "{{ route('blog.store') }}";
        var redirectUrl = "{{ route('blog.list') }}";
        var blogId = '';
        var blog = '';
        @if (isset($id))
            blog = @json($blog);
            blogId = @json($id);
            $("#image").val(blog.image);
            submitUrl = "{{ route('blog.update', ['id' => ':id']) }}";
            submitUrl = submitUrl.replace(':id', blogId);
        @endif

        $(document).ready(function() {
            $('#description').summernote({
                height: 200
            });


            // var isHaveUploadImage = {{ isset($id) && !empty($blog['image']) ? 1 : 0 }};
            // if (isHaveUploadImage) {
            //     $("#imageUploadDropzone").hide();
            // }

        })

        // Dropzone Setting
        Dropzone.autoDiscover = false;
        var uploadedImages = [];

        var myDropzone = new Dropzone("#imageUploadDropzone", {
            url: HOST_URL + `/dropzone`,
            maxFiles: 1,
            parallelUploads: 5,
            acceptedFiles: "image/jpeg,image/jpg,image/png",
            addRemoveLinks: true,
            maxFilesize: 1,
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
                    formData.append("type", "blog");
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

        function reset_btn() {
            $("#addBlog")[0].reset();
            myDropzone.destroy();
            $('#description').summernote('code', '');
        }

        function cancel_btn() {
            window.location.href = redirectUrl;
        }

        // Delete Category
        function deleteBlogFile(url) {
            const chk = confirm('Are you sure you want to delete this file?');
            var deleteUrl = "{{ route('blog.deleteFile', ['id' => ':id']) }}";
            deleteUrl = deleteUrl.replace(':id', blogId);
            if (chk === true) {
                myDropzone.options.maxFiles = 1;
                $(".dropzone-preload").html("");
                $("#blogImage").val("");
                $("#imageUploadDropzone").removeClass("d-none");
                $("#imageUploadDropzone").addClass("d-show");
            }
        }

        $("#addBlog, #updateBlog").validate({
            rules: {},
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
                var description = encodeURIComponent($('#description').summernote('code'));
                if (description == '%3Cp%3E%3Cbr%3E%3C%2Fp%3E') {
                    description = '';
                }
                data.append('description', description);
                data.append('_token', "{{ csrf_token() }}");
                $.ajax({
                    type: 'post',
                    url: (blogId !== '') ? HOST_URL +
                        `/blog/${blogId}/update` : HOST_URL + "/blog/store",
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
                            if (blogId !== '') {
                                cancel_btn();
                            } else {
                                reset_btn();
                            }
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
