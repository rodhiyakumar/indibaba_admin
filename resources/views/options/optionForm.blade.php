@php
    $previousUrl = url("/admin/exam/$examId/question/$qid/option");
@endphp
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
                            <form method="post" id="{{ isset($id) ? 'updateOption' : 'addOption' }}">
                                <input type="hidden" name="edit_id" value="{{ isset($id) ? $id : '' }}">
                                <div class="box-header with-boder d-flex justify-content-between">
                                    <h4 class="box-title">{{ isset($id) ? 'Update' : 'Add' }}</h4>
                                    <a href="{{ $previousUrl }}" class="btn btn-rounded btn-sm btn-outline mr-1">
                                        <i class="ti-arrow-left"></i> Back
                                    </a>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Option <i class="text-danger">*</i></label>
                                                <textarea id="option" name="option">{{ isset($id) ? $option['option'] : '' }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Is Correct <i class="text-danger">*</i></label>
                                                <select class="form-control" name="isCorrect" id="isCorrect">
                                                    <option value="0" @if (isset($id) && $option['isCorrect'] === 0) selected @endif>No</option>
                                                    <option value="1" @if (isset($id) && $option['isCorrect'] === 1) selected @endif>Yes</option>
                                                </select>
                                            </div>
                                        </div>
                                        @if (isset($id))
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Is Active <i class="text-danger">*</i></label>
                                                    <select class="form-control" name="isActive" id="isActive">
                                                        <option value="1" @if (isset($id) && $option['isActive'] === 1) selected @endif>Yes</option>
                                                        <option value="0" @if (isset($id) && $option['isActive'] === 0) selected @endif>No</option>
                                                    </select>
                                                </div>
                                            </div>
                                        @endif
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
    <script>
        var examId = @json($examId);
        var questionId = @json($qid);
        var optionId = "";
        @if (isset($id))
            optionId = @json($id);
        @endif
        $(document).ready(function() {
            $('#option').summernote({
                height: 200
            });
        })

        function reset_btn() {
            $("#addOption")[0].reset();
            $('#option').summernote('code', '');
        }

        function cancel_btn() {
            window.location.href = "{{ $previousUrl }}";
        }

        $("#addOption, #updateOption").validate({
            rules: {
                questionId: "required",
                option: "required"
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
                var option = encodeURIComponent($('#option').summernote('code'));
                if (option == '%3Cp%3E%3Cbr%3E%3C%2Fp%3E') {
                    option = '';
                }
                data.append('_token', "{{ csrf_token() }}");
                data.append('option', option);
                $.ajax({
                    type: 'post',
                    url: (optionId !== '') ? HOST_URL + `/admin/exam/${examId}/question/${questionId}/option/${optionId}/update` : HOST_URL +
                        `/admin/exam/${examId}/question/${questionId}/option/store`,
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
                            if (optionId !== '')
                                cancel_btn();
                            else
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
