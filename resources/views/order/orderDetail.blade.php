<style>
    select[readonly] {
        pointer-events: none;
    }
</style>
@extends('layout/master')
@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="page-title">{{ $title }}</h3>
                    <div>
                        <span class="badge badge-primary">{{ ucfirst($order['orderStatus']['name']) }}</span><br />
                        <a href="{{ route('order.print', $order['id']) }}" target="_blank" class="">
                            Print Invoice
                        </a>
                    </div>
                </div>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href={{ url('dashboard') }}><i class="mdi mdi-home-outline"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $title }}
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-lg-12 col-12">
                        <div>
                            {{-- order details --}}
                            <div class="card mb-4 shadow-sm">
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <h6 class="text-muted">Customer</h6>
                                            <strong>{{ $order['userAuth']['name'] }} ({{ $order['userAuth']['mobile'] }})</strong><br />
                                            {{ $order['userAuth']['email'] }}</p>
                                        </div>
                                        <div class="col-md-6 text-md-right">
                                            <h6 class="text-muted">Order Date</h6>
                                            <p class="mb-0">{{ $order['createdAt'] }}</p>
                                        </div>
                                    </div>
                                    <hr>
                                    {{-- {{ dd($order['cartDetails']) }} --}}
                                    <!-- Products -->
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Product</th>
                                                    <th width="120">Price</th>
                                                    <th width="100">Qty</th>
                                                    <th width="120">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($order['cartDetails'] as $item)
                                                    <tr>
                                                        <td>
                                                            <div class="media align-items-center">
                                                                <img src="{{ $item['masterImage'] ?? 'https://via.placeholder.com/60' }}" class="mr-3 rounded" width="60" alt="{{ $item['name'] }}">
                                                                <div class="media-body">
                                                                    <h6 class="mt-0">{{ $item['name'] }}</h6>
                                                                    @if ($item['size'])
                                                                        <small class="text-muted">{{ $item['size'] }}</small>
                                                                    @endif
                                                                    @if ($item['color'])
                                                                        <small class="text-muted">({{ $item['color'] }})</small>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>{{ number_format($item['price'], 2) }}</td>
                                                        <td>{{ $item['qty'] }}</td>
                                                        <td>{{ number_format($item['price'] * $item['qty'], 2) }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Totals -->
                                    <div class="row justify-content-end">
                                        <div class="col-md-5">
                                            <ul class="list-group list-group-flush">
                                                {{-- <li class="list-group-item d-flex justify-content-between">
                                                    <span>Subtotal</span>
                                                    <strong>{{ number_format($order['orderAmount'], 2) }}</strong>
                                                </li> --}}
                                                <li class="list-group-item d-flex justify-content-between">
                                                    <span>Shipping</span>
                                                    <strong>{{ number_format($order['shippingAmount'], 2) }}</strong>
                                                </li>
                                                @if (!empty($order['discountAmount']))
                                                    <li class="list-group-item d-flex justify-content-between">
                                                        <span>Discount</span>
                                                        <strong> -
                                                            {{ number_format($order['discountAmount'], 2) }}</strong>
                                                    </li>
                                                @endif
                                                <li class="list-group-item d-flex justify-content-between">
                                                    <span>Tax</span>
                                                    <strong>{{ number_format($order['taxAmount'], 2) }}</strong>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between font-weight-bold">
                                                    <span>Total</span>
                                                    <span class="text-success">{{ number_format($order['orderAmount'], 2) }}</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Shipping Address -->
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header bg-dark text-white">
                                    Shipping Address
                                </div>
                                <div class="card-body">
                                    <p class="mb-1"><strong>{{ $order['userOrderAddress']['name'] }}</strong>
                                    </p>
                                    <p>{{ $order['userOrderAddress']['addressLine1'] }}
                                        {{ $order['userOrderAddress']['addressLine2'] }}<br />
                                        {{ $order['userOrderAddress']['city'] }},
                                        {{ $order['userOrderAddress']['state'] }} -
                                        {{ $order['userOrderAddress']['pincode'] }}<br />
                                        Mobile: {{ $order['userOrderAddress']['mobile'] }}</p>
                                </div>
                            </div>

                            <!-- Payment Info -->
                            <div class="card shadow-sm">
                                <div class="card-header bg-dark text-white">
                                    Payment Information
                                </div>
                                <div class="card-body">
                                    <p>
                                        <span>Payment Method:</span>
                                        <strong>{{ strtoupper($order['paymentDetails']['paymentMethod'] ?? 'N/A') }}</strong><br />
                                        <span>Payment Txn ID:</span>
                                        <strong>{{ $order['paymentDetails']['paymentTxnId'] ?? 'N/A' }}</strong><br />


                                        <span>Order ID:</span>
                                        <strong class="text-uppercase">{{ $order['paymentDetails']['paymentOrderId'] ?? 'N/A' }}</strong><br />
                                        <span>Status:</span>
                                        @if (strtoupper($order['paymentDetails']['paymentStatus'] ?? 'N/A') === 'PAID')
                                            <span class="badge badge-success">Paid</span>
                                        @elseif (strtoupper($order['paymentDetails']['paymentStatus'] ?? 'N/A') === 'PENDING')
                                            <span class="badge badge-warning">Pending</span>
                                        @else
                                            <span class="badge badge-danger">Failed</span>
                                        @endif
                                        @if ($order['returnReason'])
                                            <br />
                                            <span>Cancelled/Returned Reason: <strong>{{ $order['returnReason']['returnReason']['name'] }}</strong></span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            {{-- end order details --}}

                        </div>
                    </div>

                    <div class="col-lg-12 col-12">
                        <form method="post" id="updateOrderStatus">
                            <div class="box">
                                <div class="box-header with-boder">
                                    <h4 class="box-title">Update Order</h4>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Payement Status <i class="text-danger">*</i></label>
                                                <select class="form-control" {{ $order['isCod'] == 1 ? 'readonly' : '' }} name="paymentStatus" id="paymentStatus">
                                                    <option value="">Select</option>
                                                    @foreach ($orderStatus['paymentStatus'] as $ps)
                                                        <option value="{{ $ps['id'] }}" @if (isset($id) && $ps['name'] === ($order['paymentDetails']['paymentStatus'] ?? 'N/A')) selected @endif>
                                                            {{ $ps['name'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Order Status <i class="text-danger">*</i></label>
                                                <select class="form-control" name="orderStatusId" id="orderStatusId">
                                                    @foreach ($orderStatus['orderStatus'] as $os)
                                                        @if ($os['id'] >= $order['orderStatus']['id'])
                                                            <option value="{{ $os['id'] }}" @if (isset($id) && $os['id'] === $order['orderStatus']['id']) selected @endif>
                                                                {{ $os['name'] }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row d-none" id="reasonBlock">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Reason <i class="text-danger">*</i></label>
                                                <select class="form-control" name="reasonId" id="reasonId">
                                                    <option value="">Select</option>
                                                    @foreach ($returnReason as $rr)
                                                        <option value="{{ $rr['id'] }}">{{ $rr['name'] }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="box-footer">
                                    <button type="submit" class="btn btn-rounded btn-success btn-outline">
                                        <i class="ti-save-alt"></i> Save
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    @if ($order['orderStatusId'] >= 3)
                        <div class="col-lg-12 col-12">
                            <form method="post" id="updateOrderShipping">
                                <div class="box">
                                    <div class="box-header with-boder">
                                        <h4 class="box-title">Update Shipping</h4>
                                    </div>
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>AWB/Tracking No </label>
                                                    <input type="text" name="trackingNo" id="trackingNo" value="{{ $order['orderShipping']['trackingNo'] ?? '' }}" class="form-control" placeholder="AWB/Tracking No" />
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Tracking Link </label>
                                                    <input type="text" name="trackingLink" id="trackingLink" value="{{ $order['orderShipping']['trackingLink'] ?? '' }}" class="form-control" placeholder="Tracking Link" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($order['orderStatusId'] <= 3)
                                        <div class="box-footer">
                                            <button type="submit" class="btn btn-rounded btn-success btn-outline">
                                                <i class="ti-save-alt"></i> Save
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
            </section>
        </div>
    </div>
@endsection


@section('scripts')
    <script src="{{ asset('assets/js/summernote-bs4.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>

    <script>
        var submitUrl = "";
        var orderId = "";
        var shippingSubmitUrl = "";
        var rules = {
            paymentStatus: "required",
            orderStatusId: "required",
            reasonId: 'required'
        };
        @if (isset($id))
            var orderId = @json($id);
            submitUrl = "{{ route('order.update', ['id' => ':id']) }}";
            submitUrl = submitUrl.replace(':id', orderId);

            shippingSubmitUrl = "{{ route('order.updateShipping', ['id' => ':id']) }}";
            shippingSubmitUrl = shippingSubmitUrl.replace(':id', orderId);
        @endif

        $("#orderStatusId").change(function() {
            var value = $(this).val();
            $("#reasonBlock").addClass("d-none");
            if (parseInt(value) === 6 || parseInt(value) === 5) {
                rules = {
                    paymentStatus: "required",
                    orderStatusId: "required",
                    reasonId: 'required'
                };
                $("#reasonBlock").removeClass("d-none")
            } else {
                rules = {
                    paymentStatus: "required",
                    orderStatusId: "required"
                };
            }
        })

        $("#updateOrderStatus").validate({
            rules: rules,
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
                if (confirm('Are you sure? You want to update status.')) {
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
                                window.location.reload();
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
            }
        });

        $("#updateOrderShipping").validate({
            rules: rules,
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
                if (confirm('Are you sure? You want to shipping details.')) {
                    var data = new FormData(form);
                    data.append('_token', "{{ csrf_token() }}");
                    $.ajax({
                        type: 'post',
                        url: shippingSubmitUrl,
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
                                window.location.reload();
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
            }
        });
    </script>
@endsection
