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
                    <h3 class="box-title">Activity</h3>
                    <p>Activity details:</p>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form method="POST" action="{{ '/education/activity/'.$activity->id.'/update' }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('PATCH') }}

                    <div class="box-body">
                        <div class="callout {{ $status_labels[$activity->status] }}">
                            <h4><i class="fa fa-info-circle"></i> Activity Status</h4>

                            <p>{{ $status_strings[$activity->status] }}{{ ($activity->status === -1) ? ' for the following reason: ' . $activity->rejection_reason : '.' }}</p>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="name" class="control-label">Activity Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                           value="{{ $activity->name }}">
                                </div>
                                <!-- /.form-group -->
                                <div class="form-group{{ $errors->has('code') ? ' has-error' : '' }}">
                                    <label for="code" class="control-label">Activity Code</label>
                                    <input type="text" class="form-control" id="code" name="code"
                                           value="{{ $activity->code }}" disabled>
                                </div>
                                <!-- /.form-group -->
                                <div class="form-group{{ $errors->has('start_date') ? ' has-error' : '' }}">
                                    <label for="start_date" class="control-label">Start Date</label>
                                    <input type="text" class="form-control datepicker" id="start_date" name="start_date"
                                           value="{{ !empty($activity->start_date) ? date('d/m/Y', $activity->start_date) : '' }}"
                                    >
                                </div>
                                <!-- /.form-group -->
                                <div class="form-group{{ $errors->has('end_date') ? ' has-error' : '' }}">
                                    <label for="end_date" class="control-label">End Date</label>
                                    <input type="text" class="form-control datepicker" id="end_date" name="end_date"
                                           value="{{ !empty($activity->end_date) ? date('d/m/Y', $activity->end_date) : '' }}"
                                    >
                                </div>
                                <!-- /.form-group -->
                                <div class="form-group{{ $errors->has('topic') ? ' has-error' : '' }}">
                                    <label for="topic" class="control-label">Topic</label>
                                    <input type="text" class="form-control" id="topic" name="topic"
                                           value="{{ $activity->topic }}">
                                </div>
                                <!-- /.form-group -->
                                <div class="form-group{{ $errors->has('budget_expenditure') ? ' has-error' : '' }}">
                                    <label for="budget" class="control-label">Budget</label>
                                    <input type="text" class="form-control" id="budget" name="budget"
                                           value="{{ !empty($activity->budget) ? 'R ' . number_format($activity->budget, 2) : '' }}"
                                    >
                                </div>
                                <!-- /.form-group -->
                                <div class="form-group{{ $errors->has('project_id') ? ' has-error' : '' }}">
                                    <label for="project_id" class="control-label">Project</label>
                                    <select class="form-control select2" style="width: 100%;" id="project_id" name="project_id">
                                        <option value="">*** Select a Project ***</option>
                                        @foreach($projects as $project)
                                            <option value="{{ $project->id }}"{{ ($project->id === $activity->project_id) ? ' selected="selected"' : '' }}>{{ $project->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- /.form-group -->
                                <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                    <label for="description" class="control-label">Brief Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="4"
                                    >{{ $activity->description }}</textarea>
                                </div>
                                <!-- /.form-group -->
                            </div>
                            <!-- /.col -->
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('actual_cost') ? ' has-error' : '' }}">
                                    <label for="actual_cost" class="control-label">Actual Cost</label>
                                    <input type="text" class="form-control" id="actual_cost" name="actual_cost"
                                           value="{{ !empty($activity->actual_cost) ? 'R ' . number_format($activity->actual_cost, 2) : '' }}"
                                    >
                                </div>
                                <!-- /.form-group -->
                                <div class="form-group{{ $errors->has('facilitator_id') ? ' has-error' : '' }}">
                                    <label for="facilitator_id" class="control-label">Activity Facilitator</label>
                                    <select class="form-control select2" style="width: 100%;" id="facilitator_id" name="facilitator_id">
                                        <option value="">*** Select a Facilitator ***</option>
                                        @foreach($facilitators as $facilitator)
                                            <option value="{{ $facilitator->id }}"{{ ($facilitator->id === $activity->facilitator_id) ? ' selected="selected"' : '' }}>{{ $facilitator->first_name . ' ' . $facilitator->surname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- /.form-group -->
                                <div class="form-group{{ $errors->has('sponsor_id') ? ' has-error' : '' }}">
                                    <label for="sponsor_id" class="control-label">External Sponsor</label>
                                    <select class="form-control select2" style="width: 100%;" id="sponsor_id"
                                            name="sponsor_id">
                                        <option value="">*** Select a Sponsor ***</option>
                                        @foreach($sponsors as $sponsor)
                                            <option value="{{ $sponsor->id }}"{{ ($sponsor->id == $activity->sponsor_id) ? ' selected="selected"' : '' }}>{{ $sponsor->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- /.form-group -->
                                <div class="form-group{{ $errors->has('sponsorship_amount') ? ' has-error' : '' }}">
                                    <label for="sponsorship_amount" class="control-label">Value of Sponsorship</label>
                                    <input type="text" class="form-control" id="sponsorship_amount"
                                           name="sponsorship_amount"
                                           value="{{ !empty($activity->sponsorship_amount) ? 'R ' . number_format($activity->sponsorship_amount, 2) : '' }}"
                                    >
                                </div>
                                <!-- /.form-group -->
                                <div class="form-group{{ $errors->has('service_provider_id') ? ' has-error' : '' }}">
                                    <label for="service_provider_id" class="control-label">Service Provider</label>
                                    <select class="form-control select2" style="width: 100%;" id="service_provider_id" name="service_provider_id">
                                        <option value="">*** Select a Service Provider ***</option>
                                        @foreach($service_providers as $provider)
                                            <option value="{{ $provider->id }}"{{ ($provider->id === $activity->service_provider_id) ? ' selected="selected"' : '' }}>{{ $provider->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- /.form-group -->
                                <div class="form-group{{ $errors->has('contract_amount') ? ' has-error' : '' }}">
                                    <label for="contract_amount" class="control-label">Contract Value</label>
                                    <input type="text" class="form-control" id="contract_amount" name="contract_amount"
                                           value="{{ !empty($activity->contract_amount) ? 'R ' . number_format($activity->contract_amount, 2) : '' }}"
                                    >
                                </div>
                                <!-- /.form-group -->
                                <div class="form-group{{ $errors->has('contract_doc') ? ' has-error' : '' }}">
                                    <label for="contract_doc" class="control-label">Contract Document</label>
                                    @if(!empty($contract_doc))
                                        <br><a class="btn btn-default btn-flat btn-block" href="{{ $contract_doc }}"
                                               target="_blank"><i class="fa fa-file-pdf-o"></i> Click Here To View The
                                            Document</a>
                                    @endif
                                    <br><input type="file" id="contract_doc" name="contract_doc" class="file file-loading" data-allowed-file-extensions='["pdf", "docx"]' data-show-upload="false">
                                </div>
                                <!-- /.form-group -->
                                <div class="form-group{{ $errors->has('supporting_doc') ? ' has-error' : '' }}">
                                    <label for="supporting_doc" class="control-label">Other Supporting Document</label>
                                    @if(!empty($supporting_doc))
                                        <br><a class="btn btn-default btn-flat btn-block" href="{{ $supporting_doc }}"
                                               target="_blank"><i class="fa fa-file-pdf-o"></i> Click Here To View The
                                            Document</a>
                                    @endif
                                    <br><input type="file" id="supporting_doc" name="supporting_doc" class="file file-loading" data-allowed-file-extensions='["pdf", "docx", "doc"]' data-show-upload="false">
                                </div>
                                <!-- /.form-group -->
                                @if($activity->status === 3)
                                    <div class="form-group">
                                        <label>Comment</label>
                                        <textarea class="form-control" id="comment" name="comment" rows="4"
                                        >{{ $activity->comment }}</textarea>
                                    </div>
                                    <!-- /.form-group -->
                                @endif
                            </div>
                            <!-- /.col -->
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer" style="text-align: center;">
                        <a href="{{ '/education/activity/' . $activity->id . '/view' }}" id="back" class="btn btn-default pull-left"><i class="fa fa-arrow-left"></i> Cancel</a>
                        <button type="submit" id="save" class="btn btn-success pull-right"><i class="fa fa-floppy-o"></i> Save</button>
                    </div>
                    <!-- /.box-footer -->
                </form>
            </div>
            <!-- /.box -->
        </div>
        <!-- End new User Form-->

        <!-- script to add learners -->

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
        /*document.getElementById("cancel").onclick = function () {
         location.href = "/contacts";
         };*/
        $(function () {
            //Initialize Select2 Elements
            $(".select2").select2();

            //Phone mask
            $("[data-mask]").inputmask();

            //Date picker
            $('.datepicker').datepicker({
                format: 'dd/mm/yyyy',
                autoclose: true
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
                var strUrl = '{{ '/education/activity/' . $activity->id . '/reject' }}';
                var objData = {
                    rejection_reason: $('#rejection_reason').val(),
                    _token: $('input[name=_token]').val()
                };
                var modalID = 'rejection-reason-modal';
                var submitBtnID = 'submit-rejection-reason';
                var redirectUrl = '{{ '/education/activity/' . $activity->id . '/view' }}';
                var successMsgTitle = 'Activity Rejected!';
                var successMsg = 'The activity has been rejected. An email stating the rejection reason(s) has been sent to the person who loaded this activity.';
                modalAjaxSubmit(strUrl, objData, modalID, submitBtnID, redirectUrl, successMsgTitle, successMsg);
            });

            //Submit comment (complete) form to serve with ajax
            $('#submit-comment').on('click', function () {
                var strUrl = '{{ '/education/activity/' . $activity->id . '/complete' }}';
                var objData = {
                    comment: $('#comment').val(),
                    _token: $('input[name=_token]').val()
                };
                var modalID = 'comment-modal';
                var submitBtnID = 'submit-comment';
                var redirectUrl = '{{ '/education/activity/' . $activity->id . '/view' }}';
                var successMsgTitle = 'Activity Completed!';
                var successMsg = 'The activity has been completed. An email notification has been sent to the Education and Learning Manager.';
                modalAjaxSubmit(strUrl, objData, modalID, submitBtnID, redirectUrl, successMsgTitle, successMsg);
            });

            //Submit programme expenditures form to server with ajax
            $('#save-expenditure').on('click', function () {
                var strUrl = '{{ '/education/activity/' . $activity->id . '/addexpenditure' }}';
                var objData = {
                    amount: $('#amount').val(),
                    date_added: $('#date_added').val(),
                    supplier_name: $('#supplier_name').val(),
                    supporting_doc: $('#supporting_doc').val(),

                    _token: $('input[name=_token]').val()
                };
                var modalID = 'add-expenditure-modal';
                var submitBtnID = 'save-expenditure';
                var redirectUrl = '{{ '/education/activity/' . $activity->id . '/view' }}'; // live it like that
                var successMsgTitle = 'expenditure Updated successfully!';
                var successMsg = 'The expenditure has been successfully added.';
                var errorAlert = 'invalid-exp-input-alert';
                modalAjaxSubmit(strUrl, objData, modalID, submitBtnID, redirectUrl, successMsgTitle, successMsg, errorAlert);
            });


            //Submit programme income form to server with ajax

            $('#save_income').on('click', function () {
                var strUrl = '{{ '/education/activity/' . $activity->id . '/addincome' }}';
                var objData = {
                    inc_amount: $('#inc_amount').val(),
                    inc_date_added: $('#inc_date_added').val(),
                    inc_supplier_name: $('#inc_supplier_name').val(),
                    supporting_doc: $('#inc_supporting_doc').val(),

                    _token: $('input[name=_token]').val()
                };
                var modalID = 'add-income-modal';
                var submitBtnID = 'save-income';
                var redirectUrl = '{{ '/education/activity/' . $activity->id . '/view' }}'; // live it like that
                var successMsgTitle = 'income Updated successfully!';
                var successMsg = 'The income has been successfully added.';
                var errorAlert = 'invalid-exp-input-alert';
                modalAjaxSubmit(strUrl, objData, modalID, submitBtnID, redirectUrl, successMsgTitle, successMsg, errorAlert);
            });
        });
        function deleteRecord() {
            location.href = "/activity/delete/{{ $activity->id }}";
        }
    </script>
@endsection