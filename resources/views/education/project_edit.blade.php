@extends('layouts.main_layout')

@section('page_dependencies')
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/datepicker/datepicker3.css">
    <!-- Select2
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">-->
    <!-- bootstrap file input -->
    <link href="/bower_components/bootstrap_fileinput/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
    <div class="row">
        <!-- New User Form -->
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-success">
                <div class="box-header with-border">
                    <i class="fa fa-file pull-right"></i>
                    <h3 class="box-title">Project</h3>
                    <p>Project details:</p>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form method="POST" action="/project/update/{{ $projects->id }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('PATCH') }}

                    <div class="box-body">
                        <div class="callout {{ $status_labels[$projects->status] }}">
                            <h4><i class="fa fa-info-circle"></i> Project Status</h4>

                            <p>{{ $status_strings[$projects->status] }}{{ ($projects->status === -1) ? ' for the following reason: ' . $projects->rejection_reason : '.' }}</p>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="control-label">Project Name:</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                           value="{{ $projects->name }}">
                                </div>
                                <!-- /.form-group -->
                                <div class="form-group">
                                    <label for="code" class="control-label">Project Code:</label>
                                    <input type="text" class="form-control" id="code" name="code"
                                           value="{{ $projects->code }}" disabled>
                                </div>
                                <!-- /.form-group -->
                                <div class="form-group">
                                    <label for="start_date" class="control-label">Start Date:</label>
                                    <input type="text" class="form-control datepicker" id="start_date" name="start_date"
                                           value="{{ !empty($projects->start_date) ? date('d/m/Y', $projects->start_date) : '' }}"
                                    >
                                </div>
                                <!-- /.form-group -->
                                <div class="form-group">
                                    <label for="end_date" class="control-label">End Date:</label>
                                    <input type="text" class="form-control datepicker" id="end_date" name="end_date"
                                           value="{{ !empty($projects->end_date) ? date('d/m/Y', $projects->end_date) : '' }}"
                                    >
                                </div>
                                <!-- /.form-group -->
                                <div class="form-group{{ $errors->has('programme_id') ? ' has-error' : '' }}">
                                    <label for="programme_id" class="control-label">Programme</label>
                                    <select class="form-control select2" style="width: 100%;" id="programme_id" name="programme_id" required>
                                        <option selected="selected" value="0">*** Select a Programme ***</option>
                                        @foreach($programmes as $programme)
                                            <option value="{{ $programme->id }}"{{ ($programme->id === $projects->programme_id) ? ' selected="selected"' : '' }}>{{ $programme->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- /.form-group -->
                                <div class="form-group{{ $errors->has('facilitator_id') ? ' has-error' : '' }}">
                                    <label for="facilitator_id" class="control-label">Project Facilitator</label>
                                    <select class="form-control select2" style="width: 100%;" id="facilitator_id" name="facilitator_id">
                                        <option value="">*** Select a Facilitator ***</option>
                                        @foreach($facilitators as $facilitator)
                                            <option value="{{ $facilitator->id }}"{{ ($facilitator->id === $projects->facilitator_id) ? ' selected="selected"' : '' }}>{{ $facilitator->first_name . ' ' . $facilitator->surname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- /.form-group -->
                                <div class="form-group{{ $errors->has('manager_id') ? ' has-error' : '' }}">
                                    <label for="manager_id" class="control-label">Project Manager</label>
                                    <select class="form-control select2" style="width: 100%;" id="manager_id" name="manager_id" required>
                                        <option selected="selected" value="0">*** Select a Manager ***</option>
                                        @foreach($managers as $manager)
                                            <option value="{{ $manager->id }}"{{ ($manager->id === $projects->manager_id) ? ' selected="selected"' : '' }}>{{ $manager->first_name.' '.$manager->surname}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- /.form-group -->
                                <div class="form-group">
                                    <label for="description" class="control-label">Brief Description:</label>
                                    <textarea class="form-control" id="description" name="description" rows="4"
                                    >{{ !empty($projects->description) ? $projects->description  : '' }}</textarea>
                                </div>
                                <!-- /.form-group -->
                            </div>
                            <!-- /.col -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="budget" class="control-label">Budget:</label>
                                    <input type="text" class="form-control" id="budget" name="budget"
                                           value="{{ !empty($projects->budget) ? 'R ' . number_format($projects->budget, 2) : '' }}"
                                    >
                                </div>
                                <!-- /.form-group -->
                                <div class="form-group{{ $errors->has('sponsor_id') ? ' has-error' : '' }}">
                                    <label for="sponsor_id" class="control-label">External Sponsor</label>
                                    <select class="form-control select2" style="width: 100%;" id="sponsor_id" name="sponsor_id">
                                        <option value="">*** Select a Sponsor ***</option>
                                        @foreach($sponsors as $sponsor)
                                            <option value="{{ $sponsor->id }}"{{ ($sponsor->id == $projects->sponsor_id) ? ' selected="selected"' : '' }}>{{ $sponsor->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- /.form-group -->
                                <div class="form-group">
                                    <label for="sponsorship_amount" class="control-label">Value of Sponsorship:</label>
                                    <input type="text" class="form-control" id="sponsorship_amount"
                                           name="sponsorship_amount"
                                           value="{{ !empty($projects->sponsorship_amount) ? 'R ' . number_format($projects->sponsorship_amount, 2) : '' }}"
                                    >
                                </div>
                                <!-- /.form-group -->
                                <div class="form-group{{ $errors->has('service_provider_id') ? ' has-error' : '' }}">
                                    <label for="service_provider_id" class="control-label">Service Provider</label>
                                    <select class="form-control select2" style="width: 100%;" id="service_provider_id" name="service_provider_id">
                                        <option value="">*** Select a Service Provider ***</option>
                                        @foreach($service_providers as $provider)
                                            <option value="{{ $provider->id }}"{{ ($provider->id == $projects->service_provider_id) ? ' selected="selected"' : '' }}>{{ $provider->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- /.form-group -->
                                <div class="form-group">
                                    <label for="contract_amount" class="control-label">Contract Value:</label>
                                    <input type="number" class="form-control" id="contract_amount"
                                           name="contract_amount"
                                           value="{{ !empty($projects->contract_amount) ? 'R ' . number_format($projects->contract_amount, 2) : '' }}"
                                    >
                                </div>
                                <!-- /.form-group -->
                                <div class="form-group">
                                    <label for="contract_doc" class="control-label">Contract Document:</label>
                                    @if(!empty($contract_doc))
                                        <br><a class="btn btn-default btn-flat btn-block" href="{{ $contract_doc }}"
                                               target="_blank"><i class="fa fa-file-pdf-o"></i> Click Here To View The
                                            Document</a>
                                    @endif
                                    <br><input type="file" id="contract_doc" name="contract_doc" class="file file-loading" data-allowed-file-extensions='["pdf", "docx", "doc"]' data-show-upload="false">
                                </div>
                                <!-- /.form-group -->
                                <div class="form-group">
                                    <label for="supporting_doc" class="control-label">Other Supporting
                                        Document: </label>
                                    @if(!empty($supporting_doc))
                                        <br><a class="btn btn-default btn-flat btn-block" href="{{ $supporting_doc }}"
                                               target="_blank"><i class="fa fa-file-pdf-o"></i> Click Here To View The
                                            Document</a>
                                    @endif
                                    <br><input type="file" id="supporting_doc" name="supporting_doc" class="file file-loading" data-allowed-file-extensions='["pdf", "docx", "doc"]' data-show-upload="false">
                                </div>
                            @if(!empty($projects->status) && $projects->status === 3)
                                <!-- /.form-group -->
                                    <div class="form-group">
                                        <label>Comment</label>
                                        <textarea class="form-control" id="comment" name="comment" rows="4"
                                        >{{ $projects->description }}</textarea>
                                    </div>
                            @endif
                            <!-- /.form-group -->
                            </div>
                            <!-- /.col -->
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer" style="text-align: center;">
                        <a href="{{ '/project/view/' . $projects->id }}" id="back" class="btn btn-default pull-left"><i class="fa fa-arrow-left"></i> Cancel</a>
                        <button type="submit" id="save" class="btn btn-success pull-right"><i class="fa fa-floppy-o"></i> Save</button>
                    </div>
                    <!-- /.box-footer -->
                </form>
            </div>
            <!-- /.box -->
        </div>
        <!-- End new User Form-->
    <!-- Confirmation Modal -->
    </div>

@endsection

@section('page_script')
    <!-- Select2 -->
    <script src="/bower_components/AdminLTE/plugins/select2/select2.full.min.js"></script>

    <!-- bootstrap datepicker -->
    <script src="/bower_components/AdminLTE/plugins/datepicker/bootstrap-datepicker.js"></script>

    <!-- Start Bootstrap File input -->
    <!-- canvas-to-blob.min.js is only needed if you wish to resize images before upload. This must be loaded before fileinput.min.js -->
    <script src="/bower_components/bootstrap_fileinput/js/plugins/canvas-to-blob.min.js"
            type="text/javascript"></script>
    <!-- the main fileinput plugin file -->
    <!-- sortable.min.js is only needed if you wish to sort / rearrange files in initial preview. This must be loaded before fileinput.min.js -->
    <script src="/bower_components/bootstrap_fileinput/js/plugins/sortable.min.js" type="text/javascript"></script>
    <!-- purify.min.js is only needed if you wish to purify HTML content in your preview for HTML files. This must be loaded before fileinput.min.js -->
    <script src="/bower_components/bootstrap_fileinput/js/plugins/purify.min.js" type="text/javascript"></script>
    <!-- the main fileinput plugin file -->
    <script src="/bower_components/bootstrap_fileinput/js/fileinput.min.js"></script>
    <!-- optionally if you need a theme like font awesome theme you can include it as mentioned below -->
    <script src="/bower_components/bootstrap_fileinput/themes/fa/theme.js"></script>
    <!-- optionally if you need translation for your language then include locale file as mentioned below -->
    <!--<script src="/bower_components/bootstrap_fileinput/js/locales/<lang>.js"></script>-->
    <!-- End Bootstrap File input -->

    <!-- InputMask -->
    <script src="/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.js"></script>
    <script src="/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.extensions.js"></script>

    <!-- Ajax form submit -->
    <script src="/custom_components/js/modal_ajax_submit.js"></script>

    <script type="text/javascript">
        //Cancel button click event

        $(function () {
            //Initialize Select2 Elements
            $(".select2").select2();

            //Phone mask
            $("[data-mask]").inputmask();

            //Date picker
            $('.datepicker').datepicker({
                format: 'dd/mm/yyyy',
                autoclose: true,
                todayHighlight: true
            });

            // [bootstrap file input] initialize with defaults
            $("#input-1").fileinput();
            // with plugin options
            //$("#input-id").fileinput({'showUpload':false, 'previewFileType':'any'});

            //Vertically center modals on page
            function reposition() {
                var modal = $(this),
                    dialog = modal.find('.modal-dialog');
                modal.css('display', 'block');

                // Dividing by two centers the modal exactly, but dividing by three
                // or four works better for larger screens.
                dialog.css("margin-top", Math.max(0, ($(window).height() - dialog.height()) / 2));
            }

            // Reposition when a modal is shown
            $('.modal').on('show.bs.modal', reposition);
            // Reposition when the window is resized
            $(window).on('resize', function () {
                $('.modal:visible').each(reposition);
            });

            //Show success action modal
            $('#success-action-modal').modal('show');

            //Submit rejection form to serve with ajax
            $('#submit-rejection-reason').on('click', function () {
                $.ajax({
                    method: 'POST',
                    url: '{{ '/project/' . $projects->id . '/reject' }}',
                    data: {
                        rejection_reason: $('#rejection_reason').val(),
                        _token: $('input[name=_token]').val()
                    },
                    success: function (success) {
                        //console.log(success);
                        $('.form-group').removeClass('has-error'); //Remove the has error class to all form-groups
                        //$('form[name=set-rates-form]').trigger('reset'); //Reset the form

                        var successHTML = '<button type="button" id="close-invalid-input-alert" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4><i class="icon fa fa-check"></i> Project Rejected!</h4>';
                        successHTML += 'The Project has been rejected. An email stating the rejection reason(s) has been sent to the applicant.';
                        $('#success-alert').addClass('alert alert-success alert-dismissible')
                            .fadeIn()
                            .html(successHTML);

                        //auto hide modal after 7 seconds
                        $("#rejection-reason-modal").alert();
                        window.setTimeout(function () {
                            $("#rejection-reason-modal").modal('hide');
                        }, 5000);

                        //autoclose alert after 7 seconds
                        $("#success-alert").alert();
                        window.setTimeout(function () {
                            $("#success-alert").fadeOut('slow');
                        }, 5000);
                    },
                    error: function (xhr) {
                        //console.log(xhr);
                        //if(xhr.status === 401) //redirect if not authenticated
                        //$( location ).prop( 'pathname', 'auth/login' );
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON; //get the errors response data
                            //console.log(errors);

                            $('.form-group').removeClass('has-error'); //Remove the has error class to all form-groups

                            var errorsHTML = '<button type="button" id="close-invalid-input-alert" class="close" aria-hidden="true">&times;</button><h4><i class="icon fa fa-ban"></i> Invalid Input!</h4><ul>';
                            $.each(errors, function (key, value) {
                                errorsHTML += '<li>' + value[0] + '</li>'; //shows only the first error.
                                $('#' + key).closest('.form-group')
                                    .addClass('has-error'); //Add the has error class to form-groups with errors
                            });
                            errorsHTML += '</ul>';

                            $('#invalid-input-alert').addClass('alert alert-danger alert-dismissible')
                                .fadeIn()
                                .html(errorsHTML);

                            //autoclose alert after 7 seconds
                            $("#invalid-input-alert").alert();
                            window.setTimeout(function () {
                                $("#invalid-input-alert").fadeOut('slow');
                            }, 7000);

                            //Close btn click
                            $('#close-invalid-input-alert').on('click', function () {
                                $("#invalid-input-alert").fadeOut('slow');
                            });
                        }
                    }
                });
            });
            //Submit comment (complete) form to serve with ajax
            $('#submit-comment').on('click', function () {
                var strUrl = '{{ '/education/project/' . $projects->id . '/complete' }}';
                var objData = {
                    comment: $('#comment').val(),
                    _token: $('input[name=_token]').val()
                };
                var modalID = 'comment-modal';
                var submitBtnID = 'submit-comment';
                var redirectUrl = '{{ '/project/view/' . $projects->id }}';
                var successMsgTitle = 'Project Completed!';
                var successMsg = 'The project has been completed. An email notification has been sent to the General Manager.';
                modalAjaxSubmit(strUrl, objData, modalID, submitBtnID, redirectUrl, successMsgTitle, successMsg);
            });
            //submit project expenditure to server
            $('#save-expenditure').on('click', function () {
                var strUrl = '{{ '/education/project/' . $projects->id . '/addexpenditure' }}';
                var objData = {
                    amount: $('#amount').val(),
                    date_added: $('#date_added').val(),
                    supplier_name: $('#supplier_name').val(),
                    supporting_doc: $('#supporting_doc').val(),
                    _token: $('input[name=_token]').val()
                };
                var modalID = 'add-expenditure-modal';
                var submitBtnID = 'save-expenditure';
                var redirectUrl = '{{ '/project/view/' . $projects->id }}';
                var successMsgTitle = 'Expenditure Added';
                var successMsg = 'The expenditure has been successfully added!';
                modalAjaxSubmit(strUrl, objData, modalID, submitBtnID, redirectUrl, successMsgTitle, successMsg);
            });
            //submit project income to server
            $('#save_income').on('click', function () {
                var strUrl = '{{ '/education/project/' . $projects->id . '/addincome' }}';
                var objData = {
                    inc_amount: $('#inc_amount').val(),
                    inc_date_added: $('#inc_date_added').val(),
                    inc_supplier_name: $('#inc_supplier_name').val(),
                    inc_supporting_doc: $('#inc_supporting_doc').val(),
                    _token: $('input[name=_token]').val()
                };
                var modalID = 'add-income-modal';
                var submitBtnID = 'save_income';
                var redirectUrl = '{{ '/project/view/' . $projects->id }}';
                var successMsgTitle = 'Income Added';
                var successMsg = 'The income has been successfully added!';
                modalAjaxSubmit(strUrl, objData, modalID, submitBtnID, redirectUrl, successMsgTitle, successMsg);
            });
        });
        function deleteRecord() {
            location.href = "/project/delete/{{ $projects->id }}";
        }
    </script>
@endsection