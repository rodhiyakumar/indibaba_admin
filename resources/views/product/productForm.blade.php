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
                                                <label>Category <i class="text-danger">*</i></label>
                                                <select class="form-control" name="categoryId" id="categoryId" required>
                                                    <option value="">Select</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category['id'] }}" @if (isset($id) && $category['id'] === $product['categoryId']) selected @endif>
                                                            {{ $category['categoryName'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Brand <i class="text-danger">*</i></label>
                                                <select class="form-control" name="brandId" id="brandId" required>
                                                    <option value="">Select</option>
                                                    @foreach ($brands as $brand)
                                                        <option value="{{ $brand['id'] }}" @if (isset($id) && $brand['id'] === $product['brandId']) selected @endif>
                                                            {{ $brand['brandName'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        {{-- <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Sub Category <i class="text-danger">*</i></label>
                                                <select class="form-control" name="subCategoryId" id="subCategoryId" required>
                                                    <option value="">Select</option>
                                                </select>
                                            </div>
                                        </div> --}}
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Type <i class="text-danger">*</i></label>
                                                <input type="text" name="name" id="name" class="form-control" value="{{ isset($id) ? $product['name'] : '' }}" placeholder="Enter Name" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Series/Cycle Capacity</label>
                                                <input type="text" name="electricalSpecsValue" id="electricalSpecsValue" class="form-control" value="{{ isset($id) ? $product['electricalSpecsValue'] : '' }}" placeholder="Enter 100, 50, 30, etc" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Capacity</label>
                                                <input type="text" name="electricalSpecsUnit" id="electricalSpecsUnit" class="form-control" value="{{ isset($id) ? $product['electricalSpecsUnit'] : '' }}" placeholder="Enter mAh, V, A, Hz, etc" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Grade</label>
                                                <input type="text" name="grade" id="grade" class="form-control" value="{{ isset($id) ? $product['grade'] : '' }}" placeholder="Enter Grade">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Rating <i class="text-danger">*</i></label>
                                                <input type="number" min="0" name="rating" id="rating" class="form-control" value="{{ isset($id) ? $product['rating'] : '0' }}" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Review Count <i class="text-danger">*</i></label>
                                                <input type="number" min="0" name="reviewCount" id="reviewCount" class="form-control" value="{{ isset($id) ? $product['reviewCount'] : '0' }}" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Model <i class="text-danger">*</i></label>
                                                <input type="text" name="model" id="model" class="form-control" value="{{ isset($id) ? $product['model'] : '' }}" placeholder="Enter Model" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Inventory Code <i class="text-danger">*</i></label>
                                                <input type="text" name="inventoryCode" id="inventoryCode" class="form-control" value="{{ isset($id) ? $product['inventoryCode'] : '' }}" placeholder="Enter Inventory Code" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Tax Rate <i class="text-danger">*</i></label>
                                                <input type="text" name="taxRate" id="taxRate" class="form-control" value="{{ isset($id) ? $product['taxRate'] : '' }}" placeholder="Eg: 5, 12, 18" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>HSN <i class="text-danger">*</i></label>
                                                <input type="text" name="hsn" id="hsn" class="form-control" value="{{ isset($id) ? $product['hsn'] : '' }}" placeholder="Enter HSN" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>MOQ <i class="text-danger">*</i></label>
                                                <input type="number" name="moq" id="moq" class="form-control" value="{{ isset($id) ? $product['moq'] : '' }}" placeholder="Enter MOQ" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Qty <i class="text-danger">*</i></label>
                                                <input type="number" name="qty" id="qty" class="form-control" value="{{ isset($id) ? $product['qty'] : '' }}" placeholder="Enter Qty" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Original Price (MRP Price) <i class="text-danger">*</i></label>
                                                <input type="text" name="originalPrice" id="originalPrice" class="form-control" value="{{ isset($id) ? $product['originalPrice'] : '' }}" placeholder="Enter Original Price" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Selling Price <i class="text-danger">*</i></label>
                                                <input type="text" name="sellingPrice" id="sellingPrice" class="form-control" value="{{ isset($id) ? $product['sellingPrice'] : '' }}" placeholder="Enter Selling Price" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Weight <i class="text-danger">*</i>(in grams)</label>
                                                <input type="text" name="weight" id="weight" class="form-control" value="{{ isset($id) ? $product['weight'] : '' }}" placeholder="Enter Weight" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Featured <i class="text-danger">*</i></label>
                                                <select class="form-control" id="isFeatured" name="isFeatured" required>
                                                    <option value="1" {{ isset($id) ? ($product['isFeatured'] == 1 ? 'selected' : '') : '' }}>Yes</option>
                                                    <option value="0" {{ isset($id) ? ($product['isFeatured'] == 0 ? 'selected' : '') : '' }}>No</option>
                                                </select>
                                            </div>
                                        </div>
                                        @if (isset($id))
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Active <i class="text-danger">*</i></label>
                                                    <select class="form-control" name="isActive" id="isActive">
                                                        <option value="1" {{ isset($id) ? ($product['isActive'] == 1 ? 'selected' : '') : '' }}>Yes</option>
                                                        <option value="0" {{ isset($id) ? ($product['isActive'] == 0 ? 'selected' : '') : '' }}>No</option>
                                                    </select>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="row" id="master_images_box">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Master Image <i class="text-danger">*</i> (Recommended Size: w: 800px, h: 800px)</label>
                                                <div id="masterUploadDropzone" class="dropzone {{ isset($id) && !empty($product['masterImage']) ? 'd-none' : 'd-show' }}">
                                                </div>
                                            </div>
                                        </div>
                                        @if (isset($id) && $product['masterImage'])
                                            <div class="dropzone-preload col-sm-1 text-center">
                                                <img src="{{ $product['masterImage'] }}" class="img-fluid">
                                                <a href="javascript:void(0)" class="btn btn-xs btn-danger" onclick="deleteMasterImage('{{ $product['masterImage'] }}')"><i class="fa fa-trash"></i></a>
                                            </div>
                                        @endif
                                        <input type="hidden" name="masterImage" class="form-control" id="masterImage" value="{{ isset($id) ? $product['masterImage'] : '' }}" placeholder="">
                                    </div>
                                    <div class="row" id="images_box">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Images (Recommended Size: w: 800px, h: 800px)</label>
                                                <div id="imageUploadDropzone" class="dropzone">
                                                </div>
                                            </div>
                                        </div>
                                        @if (isset($id) && $product['images'])
                                            @foreach ($productImages as $key => $pi)
                                                <div class="dropzone-preload dropzone-image-{{ $key }} col-sm-1 text-center">
                                                    <img src="{{ $pi['file'] }}" class="img-fluid">
                                                    <a href="javascript:void(0)" class="btn btn-xs btn-danger" onclick="deleteImage('{{ $pi['file'] }}')"><i class="fa fa-trash"></i></a>
                                                </div>
                                            @endforeach
                                        @endif
                                        <input type="hidden" name="images" class="form-control" id="images" value="{{ isset($id) ? $product['images'] : '' }}" placeholder="">
                                    </div>
                                    <div class="row" id="applications_images_box">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Application Image</label>
                                                <div id="applicationsUploadDropzone" class="dropzone {{ isset($id) && !empty($product['applicationImage']) ? 'd-none' : 'd-show' }}">
                                                </div>
                                            </div>
                                        </div>
                                        @if (isset($id) && $product['applicationImage'])
                                            <div class="dropzone-preload col-sm-1 text-center">
                                                <img src="{{ $product['applicationImage'] }}" class="img-fluid">
                                                <a href="javascript:void(0)" class="btn btn-xs btn-danger" onclick="deleteApplicationImage('{{ $product['applicationImage'] }}')"><i class="fa fa-trash"></i></a>
                                            </div>
                                        @endif
                                        <input type="hidden" name="applicationImage" class="form-control" id="applicationImage" value="{{ isset($id) ? $product['applicationImage'] : '' }}" placeholder="">
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Meta Title</label>
                                                <input type="text" name="metaTitle" id="metaTitle" class="form-control" value="{{ isset($id) && isset($product['metaTitle']) ? $product['metaTitle'] : '' }}" placeholder="Enter Meta Title">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Meta Keyword</label>
                                                <input type="text" name="metaKeyword" id="metaKeyword" class="form-control" value="{{ isset($id) && isset($product['metaKeyword']) ? $product['metaKeyword'] : '' }}" placeholder="Enter Meta Keyword">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Meta Description</label>
                                                <input type="text" name="metaDescription" id="metaDescription" class="form-control" value="{{ isset($id) && isset($product['metaDescription']) ? $product['metaDescription'] : '' }}" placeholder="Enter Meta Description">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Description</label>
                                                <textarea id="description" name="description">{{ isset($id) ? $product['description'] : '' }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Specifications</label>
                                                <textarea id="specification" name="specification">{{ isset($id) ? $product['specification'] : '' }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-rounded btn-success btn-outline">
                                        <i class="ti-save-alt"></i> {{ isset($id) ? 'Update' : 'Save' }}
                                    </button>
                                    @if (isset($id))
                                        <a href="{{ route('product.list') }}" class="btn btn-rounded  btn-outline mr-1">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
    <script>
        var submitUrl = "{{ route('product.store') }}";
        var redirectUrl = "{{ route('product.list') }}";
        var product, productId = "";
        @if (isset($id))
            var product = @json($product);
            var productId = @json($id);
            submitUrl = "{{ route('product.update', ['id' => ':id']) }}";
            submitUrl = submitUrl.replace(':id', productId);

            // getSubCategory(product.categoryId);
            // $("#subCategoryId").val(product.subCategoryId)
        @endif

        // $(document).on("change", "#categoryId", function(e) {
        //     getSubCategory(e.target.value);
        // })


        $(document).ready(function() {
            $('#description').summernote({
                height: 200
            });
            $('#specification').summernote({
                height: 200
            });
        })

        // Dropzone Setting
        Dropzone.autoDiscover = false;
        var masterUploadedImages = [];
        var applicationsUploadedImages = [];
        var uploadedImages = [];
        @if (isset($productImages) && is_array($productImages) && count($productImages) > 0)
            uploadedImages = @json($productImages);
        @endif
        var applicationsDropzone = new Dropzone("#applicationsUploadDropzone", {
            url: HOST_URL + `/dropzone`,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            maxFiles: 1,
            parallelUploads: 1,
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
                    formData.append("type", "products");
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
                            applicationsUploadedImages.push(response
                                .file); // store filename or URL
                            var response = JSON.parse(response);
                            if (response.status) {
                                $("#applicationImage").val(response.data.public_url);
                            }
                        },
                        error: function(xhr) {
                            console.error("Upload Failed", xhr.responseText);
                        }
                    });
                });
            }
        });

        var masterDropzone = new Dropzone("#masterUploadDropzone", {
            url: HOST_URL + `/dropzone`,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            maxFiles: 1,
            parallelUploads: 1,
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
                    formData.append("type", "products");
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
                            masterUploadedImages.push(response
                                .file); // store filename or URL
                            var response = JSON.parse(response);
                            if (response.status) {
                                $("#masterImage").val(response.data.public_url);
                            } else {
                                // Throw error inside Dropzone UI
                                var errorMessage = response.message || "Upload failed from API";
                                showDropzoneError(file, errorMessage);
                                // Clear hidden input if set
                                $("#masterImage").val('');
                            }
                        },
                        error: function(xhr) {
                            console.error("Upload Failed", xhr.responseText);
                        }
                    });
                });
            }
        });

        var imageDropzone = new Dropzone("#imageUploadDropzone", {
            url: HOST_URL + `/dropzone`,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            maxFiles: 10 - uploadedImages.length,
            parallelUploads: 10 - uploadedImages.length,
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
                    formData.append("type", "products");
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
                            var response = JSON.parse(response);
                            uploadedImages.push({
                                uuid: file.upload.uuid,
                                file: response.data
                                    .public_url
                            });

                            if (response.status) {
                                $("#images").val(uploadedImages.map((item) => item.file).join(","));
                            } else {
                                // Throw error inside Dropzone UI
                                var errorMessage = response.message || "Upload failed from API";
                                showDropzoneError(file, errorMessage);
                                // Clear hidden input if set
                                $("#images").val('');
                            }
                        },
                        error: function(xhr) {
                            console.error("Upload Failed", xhr.responseText);
                        }
                    });
                });
                this.on("removedfile", function(file) {
                    let filterFile = uploadedImages.filter((item, index) => item.uuid != file.upload.uuid);
                    uploadedImages = filterFile;
                    $("#images").val(uploadedImages.map((item) => item.file).join(","));
                });
            }
        });

        // Helper function to force Dropzone error UI
        function showDropzoneError(file, message) {
            file.status = Dropzone.ERROR;
            if (file.previewElement) {
                file.previewElement.classList.add("dz-error");
                file.previewElement.classList.remove("dz-success");

                // Inject message into Dropzone's default error container
                var errorMsgNode = file.previewElement.querySelector("[data-dz-errormessage]");
                if (errorMsgNode) {
                    errorMsgNode.textContent = message;
                }
            }
        }

        function reset_btn() {
            $("#addForm")[0].reset();
            applicationsDropzone.destroy();
            masterDropzone.destroy();
            imageDropzone.destroy();
            $('#description').summernote('code', '');
            $('#specification').summernote('code', '');
        }

        // Delete Category
        function deleteApplicationImage(url) {
            const chk = confirm('Are you sure you want to delete this file?');
            if (chk === true) {
                applicationsDropzone.options.maxFiles = 1;
                $(".dropzone-preload").html("");
                $("#applicationImage").val("");
                $("#applicationsUploadDropzone").removeClass("d-none");
                $("#applicationsUploadDropzone").addClass("d-show");
            }
        }

        // Delete Category
        function deleteMasterImage(url) {
            const chk = confirm('Are you sure you want to delete this file?');
            if (chk === true) {
                masterDropzone.options.maxFiles = 1;
                $(".dropzone-preload").html("");
                $("#masterImage").val("");
                $("#masterUploadDropzone").removeClass("d-none");
                $("#masterUploadDropzone").addClass("d-show");
            }
        }

        // Delete Category
        function deleteImage(url) {
            const chk = confirm('Are you sure you want to delete this file?');
            if (chk === true) {
                var index = uploadedImages.findIndex(t => t.file === url);
                uploadedImages = uploadedImages.filter(t => t.file !== url);
                $(".dropzone-preload img[src='" + url + "']").parent().remove();
                $("#images").val(uploadedImages.map((item) => item.file).join(","));
            }
        }


        $("#addForm, #updateForm").validate({
            rules: {
                originalPrice: {
                    required: true,
                    number: true,
                    min: 1
                },
                sellingPrice: {
                    required: true,
                    number: true
                },
                taxRate: {
                    required: true,
                    number: true
                }
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
                var description = encodeURIComponent($('#description').summernote('code'));
                if (description == '%3Cp%3E%3Cbr%3E%3C%2Fp%3E') {
                    description = '';
                }
                data.append('description', description);
                var specification = encodeURIComponent($('#specification').summernote('code'));
                if (specification == '%3Cp%3E%3Cbr%3E%3C%2Fp%3E') {
                    specification = '';
                }
                data.append('specification', specification);
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
                            if (productId) window.location.href = redirectUrl;
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


        // Get Subcategory
        function getSubCategory(value) {
            $.ajax({
                url: "{{ route('subCategory.fetch') }}",
                success: function(result) {
                    var option = "<option>Select</option>";
                    for (const ele of result.data) {
                        if (value == ele.categoryId) {
                            var selected = productId && ele.id === product.subCategoryId ? "selected" : "";
                            option += `<option value="${ele.id}" ${selected}>${ele.subCategoryName}</option>`;
                        }
                    }
                    $("#subCategoryId").html(option)
                }
            });
        }
    </script>
@endsection
