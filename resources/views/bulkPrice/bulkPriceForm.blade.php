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
                                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}"><i class="mdi mdi-home-outline"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('bulk-price.list', ['pid' => $product['id']]) }}">{{ $product['name'] }}</a>
                                    </li>
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
                            <form method="post">
                                <div class="box-header with-boder">
                                    <h4 class="box-title">{{ $title }}</h4>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Price Range <i class="text-danger">*</i></label>
                                                <input type="text" class="form-control" name="priceRange" id="priceRange" disabled={{ isset($id) ? true : false }} value="{{ isset($id) ? $bulkPrice['priceRange'] : '' }}" placeholder="Enter 0-10, 11-20, 21-30, etc" required />
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Price <i class="text-danger">*</i></label>
                                                <input type="number" min="1" class="form-control" name="price" id="price" value="{{ isset($id) ? $bulkPrice['price'] : '' }}" placeholder="Enter price" required />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <button type="button" id="save" class="btn btn-rounded btn-success btn-outline">
                                        <i class="ti-save-alt"></i> {{ isset($id) ? 'Update' : 'Save' }}
                                    </button>
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
    <script>
        var submitUrl = "{{ route('bulk-price.store', ['pid' => ':pid']) }}";
        var redirectUrl = "{{ route('bulk-price.list', ['pid' => ':pid']) }}";
        var pid = "";
        var id = "";
        @if (isset($pid))
            pid = @json($pid);
            redirectUrl = redirectUrl.replace(':pid', pid);
            submitUrl = submitUrl.replace(':pid', pid);
        @endif

        @if (isset($id))
            id = @json($id);
            submitUrl = "{{ route('bulk-price.update', ['pid' => ':pid', 'id' => ':id']) }}";
            submitUrl = submitUrl.replace(':pid', pid);
            submitUrl = submitUrl.replace(':id', id);
        @endif

        $("#save").click(function() {
            var priceRange = $("#priceRange").val();
            var price = $("#price").val();
            if (price < 0) {
                $.toast({
                    heading: 'Validation Error',
                    text: 'Price must be greater than 0',
                    icon: 'error',
                    hideAfter: 5000,
                    position: 'top-right',
                });
                return;
            }
            $.ajax({
                type: 'post',
                url: submitUrl,
                data: JSON.stringify({
                    productId: pid,
                    priceRange: priceRange,
                    price: price
                }),
                contentType: "application/json",
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                beforeSend: function() {
                    $("body").addClass("loading");
                },
                success: function(result) {
                    var response = (typeof result === 'string') ? JSON.parse(result) : result;

                    if (response.status) {
                        $.toast({
                            heading: response.toastHeading,
                            text: response.message,
                            icon: response.toastIcon,
                            hideAfter: 5000,
                            position: 'top-right',
                        });
                        window.location.href = redirectUrl;
                        reset_btn();
                    } else {
                        $.toast({
                            heading: response.toastHeading,
                            text: response.message,
                            icon: response.toastIcon,
                            hideAfter: 5000,
                            position: 'top-right',
                        });
                    }
                },
                complete: function() {
                    $("body").removeClass("loading");
                },
            });
        })
    </script>
@endsection
