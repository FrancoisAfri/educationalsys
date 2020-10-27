@extends('layouts.main_layout')

@section('page_dependencies')
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/datepicker/datepicker3.css">
    <!-- Select2
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">-->
    <!-- bootstrap file input -->
    <link href="/bower_components/bootstrap_fileinput/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="row">
        <!-- New User Form -->
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-success">
                <div class="box-header with-border">
                    <i class="fa fa-file pull-right"></i>
                    <h3 class="box-title">Programme</h3>
                    <p>Programme details:</p>
                </div>
                <!-- /.box-header -->
                <!-- form enctype="multipart/form-data"-->
                <form method="POST" action="{{ '/education/programme/'.$programme->id.'/update' }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('PATCH') }}

                    <div class="box-body">
                        <div class="callout {{ $status_labels[$programme->status] }}">
                            <h4><i class="fa fa-info-circle"></i> Programme Status</h4>

                            <p>{{ $status_strings[$programme->status] }}{{ ($programme->status === -1) ? ' for the following reason: ' . $programme->rejection_reason : '.' }}</p>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="name" class="control-label">Programme Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ $programme->name }}" placeholder="Enter Programme Name...">
                                </div>
                                <!-- /.form-group -->
                                <div class="form-group{{ $errors->has('code') ? ' has-error' : '' }}">
                                    <label for="code" class="control-label">Programme Code</label>
                                    <input type="text" class="form-control" id="code" name="code" value="{{ $programme->code }}" placeholder="Enter Programme Code..." disabled>
                                </div>
                                <!-- /.form-group -->
                                <div class="form-group{{ $errors->has('start_date') ? ' has-error' : '' }}">
                                    <label for="start_date" class="control-label">Start Date</label>
                                    <input type="text" class="form-control datepicker" id="start_date" name="start_date" value="{{ !empty($programme->start_date) ? date('d/m/Y', $programme->start_date) : '' }}" placeholder="Select Programme Start Date...">
                                </div>
                                <!-- /.form-group -->
                                <div class="form-group{{ $errors->has('end_date') ? ' has-error' : '' }}">
                                    <label for="end_date" class="control-label">End Date</label>
                                    <input type="text" class="form-control datepicker" id="end_date" name="end_date" value="{{ !empty($programme->end_date) ? date('d/m/Y', $programme->end_date) : '' }}" placeholder="Select Programme End Date...">
                                </div>
                                <!-- /.form-group -->
                                <div class="form-group{{ $errors->has('budget_expenditure') ? ' has-error' : '' }}">
                                    <label for="budget_expenditure" class="control-label">Budget Expenditure</label>
                                    <input type="texte" class="form-control" id="budget_expenditure" name="budget_expenditure" value="{{ !empty($programme->budget_expenditure) ? 'R ' . number_format($programme->budget_expenditure, 2) : '' }}" placeholder="Budget Expenditure...">
                                </div>
                                <!-- /.form-group -->
                                <div class="form-group{{ $errors->has('budget_income') ? ' has-error' : '' }}">
                                    <label for="budget_income" class="control-label">Budget Income</label>
                                    <input type="text" class="form-control" id="budget_income" name="budget_income" value="{{ !empty($programme->budget_income) ? 'R ' . number_format($programme->budget_income, 2) : '' }}" placeholder="Enter Budget Income...">
                                </div>
                                <!-- /.form-group -->
                                <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                    <label for="description" class="control-label">Brief Description</label>
                                    <textarea class="form-control" id="description" name="description" placeholder="Brief Description of the Programme..." rows="4">{{ $programme->description }}</textarea>
                                </div>
                                <!-- /.form-group -->
                            </div>
                            <!-- /.col -->
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('sponsor_id') ? ' has-error' : '' }}">
                                    <label for="sponsor_id" class="control-label">External Sponsor</label>
                                    <select class="form-control select2" style="width: 100%;" id="sponsor_id" name="sponsor_id">
                                        <option value="">*** Select a Sponsor ***</option>
                                        @foreach($sponsors as $sponsor)
                                            <option value="{{ $sponsor->id }}"{{ ($sponsor->id == $programme->sponsor_id) ? ' selected="selected"' : '' }}>{{ $sponsor->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- /.form-group -->
                                <!-- /.form-group -->
                                <div class="form-group{{ $errors->has('sponsorship_amount') ? ' has-error' : '' }}">
                                    <label for="sponsorship_amount" class="control-label">Value of Sponsorship</label>
                                    <input type="text" class="form-control" id="sponsorship_amount" name="sponsorship_amount" value="{{ !empty($programme->sponsorship_amount) ? 'R ' . number_format($programme->sponsorship_amount, 2) : '' }}" placeholder="Value of Sponsorship...">
                                </div>
                                <!-- /.form-group -->
                                <div class="form-group{{ $errors->has('service_provider_id') ? ' has-error' : '' }}">
                                    <label for="service_provider_id" class="control-label">Service Provider</label>
                                    <select class="form-control select2" style="width: 100%;" id="service_provider_id" name="service_provider_id">
                                        <option value="">*** Select a Service Provider ***</option>
                                        @foreach($service_providers as $provider)
                                            <option value="{{ $provider->id }}"{{ ($provider->id == $programme->service_provider_id) ? ' selected="selected"' : '' }}>{{ $provider->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- /.form-group -->
                                <div class="form-group{{ $errors->has('contract_amount') ? ' has-error' : '' }}">
                                    <label for="contract_amount" class="control-label">Contract Value</label>
                                    <input type="text" class="form-control" id="contract_amount" name="contract_amount" value="{{ !empty($programme->contract_amount) ? 'R ' . number_format($programme->contract_amount, 2) : '' }}" placeholder="Contract Value...">
                                </div>
                                <!-- /.form-group -->
                                <div class="form-group{{ $errors->has('contract_doc') ? ' has-error' : '' }}">
                                    <label for="contract_doc" class="control-label">Contract Document</label>
                                    @if(!empty($contract_doc))
                                        <br><a class="btn btn-default btn-flat btn-block" href="{{ $contract_doc }}" target="_blank"><i class="fa fa-file-pdf-o"></i> Click Here To View The Document</a>
                                    @endif
                                    <br><input type="file" id="contract_doc" name="contract_doc" class="file file-loading" data-allowed-file-extensions='["pdf", "docx", "doc"]' data-show-upload="false">
                                <!--<input type="file" id="contract_doc" name="contract_doc" class="file file-loading" data-allowed-file-extensions='["pdf", "docx"]' data-show-upload="false">-->
                                </div>
                                <!-- /.form-group -->
                                <div class="form-group{{ $errors->has('supporting_doc') ? ' has-error' : '' }}">
                                    <label for="supporting_doc" class="control-label">Other Supporting Document</label>
                                    @if(!empty($supporting_doc))
                                        <br><a class="btn btn-default btn-flat btn-block" href="{{ $supporting_doc }}" target="_blank"><i class="fa fa-file-pdf-o"></i> Click Here To View The Document</a>
                                    @endif
                                    <br><input type="file" id="supporting_doc" name="supporting_doc" class="file file-loading" data-allowed-file-extensions='["pdf", "docx", "doc"]' data-show-upload="false">
                                </div>
                                <!-- /.form-group -->
                                <div class="form-group{{ $errors->has('manager_id') ? ' has-error' : '' }}">
                                    <label for="manager_id" class="control-label">Programme Manager</label>
                                    <select class="form-control select2" style="width: 100%;" id="manager_id" name="manager_id">
                                        <option value="">*** Select the Programme Manager ***</option>
                                        @foreach($programme_managers as $manager)
                                            <option value="{{ $manager->id }}"{{ ($manager->id === $programme->manager_id) ? ' selected="selected"' : '' }}>{{ $manager->first_name . ' ' . $manager->surname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- /.form-group -->
                                @if($programme->status === 3)
                                    <div class="form-group{{ $errors->has('comment') ? ' has-error' : '' }}">
                                        <label for="comment" class="control-label">Comment</label>
                                        <textarea class="form-control" id="comment" name="comment" placeholder="Enter a Comment at the end of the Programme..." rows="4">{{ $programme->comment }}</textarea>
                                    </div>
                                    <!-- /.form-group -->
                                @endif
                            </div>
                            <!-- /.col -->
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer" style="text-align: center;">
                        <a href="{{ '/education/programme/' . $programme->id . '/view' }}" id="back" class="btn btn-default pull-left"><i class="fa fa-arrow-left"></i> Cancel</a>
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
    <script src="/bower_components/bootstrap_fileinput/js/plugins/canvas-to-blob.min.js" type="text/javascript"></script>
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
            $(window).on('resize', function() {
                $('.modal:visible').each(reposition);
            });
        });
    </script>
@endsection