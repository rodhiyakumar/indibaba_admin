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
                            <div class="box-header with-boder">
                                <h4 class="">List</h4>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped mb-0" id="dataTable">

                                        <thead>
                                            <tr>
                                                <th scope="col">Action</th>
                                                <th scope="col">Image</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Category</th>
                                                <th scope="col">Brand</th>
                                                <th scope="col">Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection


@section('scripts')
    <script>
        const editProductUrl = "{{ route('product.edit', ['id' => ':id']) }}";
        const productBulkPriceUrl = "{{ route('bulk-price.list', ['pid' => ':pid']) }}";
        $(document).ready(function() {
            getAllProducts();
        })

        // Delete Category
        function deleteProduct(id) {
            const chk = confirm('Are you sure you want to delete this item?');
            var deleteUrl = "{{ route('product.delete', ['id' => ':id']) }}";
            deleteUrl = deleteUrl.replace(':id', id);
            if (chk === true) {
                $.ajax({
                    url: deleteUrl,
                    type: 'delete',
                    dataType: 'json',
                    data: {
                        '_token': "{{ csrf_token() }}",
                        id
                    },
                    beforeSend: function() {
                        $("body").addClass("loading");
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
                            getAllProducts();
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

        // Get All Category
        function getAllProducts() {
            $("#dataTable").dataTable().fnDestroy();
            $('#dataTable').DataTable({
                ajax: "{{ route('product.fetch') }}",
                "bSort": false,
                // "serverSide": true,
                "processing": true,
                aoColumns: [{
                        mData: null,
                        "bSortable": false,
                        "mRender": function(d) {
                            let btn = '';
                            const editUrl = editProductUrl.replace(':id', d.id);
                            const bulkPriceUrl = productBulkPriceUrl.replace(':pid', d.id);
                            btn +=
                                `<a href='${editUrl}' class='btn btn-xs btn-success '><i class="fa fa-edit"></i></a>`;
                            btn +=
                                `<a href='javascript:void(0)' onclick='deleteProduct(${d.id})' class='mx-2 btn btn-xs btn-danger deleteProduct'><i class="fa fa-trash"></i></a>`;
                            btn +=
                                `<a href='${bulkPriceUrl}' class='btn btn-xs btn-info deleteProduct'><i class="fa fa-list"></i></a>`;
                            return btn;
                        }
                    }, {
                        mData: null,
                        "bSortable": false,
                        "mRender": function(d) {

                            return `<img src='${d.masterImage}' style='width: 130px; height: 130px; object-fit: cover;'/>`;
                        }
                    },
                    {
                        mData: 'name'
                    },
                    {
                        mData: null,
                        "mRender": function(d) {
                            return d.brand ? d.brand.brandName : ''
                        }
                    },
                    {
                        mData: null,
                        "mRender": function(d) {
                            return d.category ? d.category.categoryName : ''
                        }
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
    </script>
@endsection
