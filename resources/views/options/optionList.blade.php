{{-- @php
    $previousUrl = url("/admin/exam/$examId/question") . '/' . base64_encode($exam['examName']);
@endphp --}}
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
                    <div>
                        <a href="{{ route('option.create', ['id' => $examId, 'qid' => $qid]) }}" class="btn btn-primary">Add
                            Option</a>
                    </div>
                </div>
            </div>
            {{-- {{ dd($question) }} --}}
            <div class="row pr-3 pl-3 pt-3 pb-2">
                <div class="col-lg-12 col-12">
                    <b>Question:</b><br />
                    {!! $question['question'] !!}
                </div>
            </div>
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-lg-12 col-12">
                        <div class="box">
                            <div class="box-header with-boder d-flex justify-content-between">
                                <h4 class="box-title">List</h4>
                                {{-- <a href="{{ $previousUrl }}" class="btn btn-rounded btn-sm btn-outline mr-1">
                                    <i class="ti-arrow-left"></i> Back
                                </a> --}}
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped mb-0" id="dataTable">

                                        <thead>
                                            <tr>
                                                <th scope="col">Action</th>
                                                <th scope="col">Option</th>
                                                <th scope="col">Correct</th>
                                                <th scope="col">Status</th>
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
        var examId = @json($examId);
        var qid = @json($qid);
        $(document).ready(function() {
            getAllOptions();
        })


        // Delete Category
        function deleteOption(id) {
            const chk = confirm('Are you sure you want to delete this item?');
            if (chk === true) {
                $.ajax({
                    url: HOST_URL + `/admin/exam/${examId}/question/${qid}/option/${id}/delete`,
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
                            getAllOptions();
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

        // Get All Course
        function getAllOptions() {
            $("#dataTable").dataTable().fnDestroy();
            $('#dataTable').DataTable({
                ajax: HOST_URL + `/admin/exam/${examId}/question/${qid}/option/fetch-options`,
                "bSort": false,
                // "serverSide": true,
                "processing": true,
                aoColumns: [{
                        mData: null,
                        "bSortable": false,
                        "mRender": function(d) {
                            let btn = '';
                            btn +=
                                `<a href='{{ url('exam/${examId}/question/${qid}/option/${d.id}/edit') }}'  class='btn btn-xs btn-success '><i class="fa fa-edit"></i></a>&nbsp;`;
                            btn +=
                                `<a href='javascript:void(0)' onclick='deleteOption(${d.id})' class='btn btn-xs btn-danger deleteCategory'><i class="fa fa-trash"></i></a>`;
                            return btn;
                        }
                    },
                    {
                        mData: 'option'
                    },
                    {
                        mData: null,
                        "mRender": function(d) {
                            return d.isCorrect === 1 ? 'Yes' : 'No'
                        }
                    },
                    {
                        mData: null,
                        "mRender": function(d) {
                            return d.isActive === 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">In Active</span>'
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
