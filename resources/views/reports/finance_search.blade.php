@extends('layouts.main_layout')
@section('page_dependencies')
        <!-- bootstrap datepicker -->
<link rel="stylesheet" href="/bower_components/AdminLTE/plugins/daterangepicker/daterangepicker.css">
<!-- iCheck -->
<link rel="stylesheet" href="/bower_components/AdminLTE/plugins/iCheck/square/green.css">
@endsection
@section('content')
    <div class="row">
        <!-- New User Form -->
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <i class="fa fa-bug pull-right"></i>
                    <h3 class="box-title">Reports Criteria</h3>
                    <p>Enter criteria to be matched in the report:</p>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" id="report_form" method="POST">
                    {{ csrf_field() }}

                    <div class="box-body">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger alert-dismissible fade in">
                                <button type="button" class="close" data-dismiss="alert"
                                        aria-hidden="true">&times;</button>
                                <h4><i class="icon fa fa-ban"></i> Invalid Input Data!</h4>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="form-group{{ $errors->has('search_type') ? ' has-error' : '' }}">
                            <label for="search_type" class="col-sm-2 control-label">Report Type</label>

                            <div class="col-sm-10">
                                <label class="radio-inline" style="padding-left: 0px;"><input type="radio"
                                                                                              id="rdo_programme"
                                                                                              name="search_type"
                                                                                              value="1" checked>
                                    programme</label>
                                <label class="radio-inline"><input type="radio" id="rdo_project" name="search_type"
                                                                   value="2"> Project</label>
                                <label class="radio-inline"><input type="radio" id="rdo_activity" name="search_type"
                                                                   value="3"> Activity</label>
                            </div>
                        </div>
                        <!--
                    <div class="form-group">
                        <label for="search_type" class="col-sm-2 control-label">Report Type</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-user"></i>
                            </div>
                            <select class="form-control" name="search_type" id="search_type" placeholder="Select Report Type"  onchange="changetype(this.value)"  required>
                                <option value="1">Programme</option>
                                <option value="2">Project</option>
                                <option value="3">Activity</option>
                            </select>
                            </div>
                        </div>
                    </div>
                    -->
                        <div class="form-group">
                            <label for="start_date_range" class="col-sm-2 control-label">Start Date Range</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <input type="text" class="form-control daterangepicker" id="start_date_range"
                                           name="start_date_range" placeholder="Select a Date Range...">
                                </div>
                            </div>
                        </div>
                            <!--
                        <div class="form-group">
                            <label for="search_type" class="col-sm-2 control-label">End Date</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <input type="text" class="form-control daterangepicker" id="end_date"
                                           name="end_date" value="" placeholder="Select End Date...">
                                </div>
                            </div>
                        </div>
                            -->
                        <div class="form-group programmes">
                            <label for="programme_id" class="col-sm-2 control-label">Programme</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-graduation-cap"></i>
                                    </div>
                                    <select class="form-control select2" style="width: 100%;" id="programme_id"
                                            name="programme_id">
                                        <option value="">*** Select a Programme ***</option>
                                        @foreach($programmes as $programme)
                                            <option value="{{ $programme->id }}">{{ $programme->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group projects">
                            <label for="project_id" class="col-sm-2 control-label">Project</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-graduation-cap"></i>
                                    </div>
                                    <select class="form-control select2" style="width: 100%;" id="project_id"
                                            name="project_id">
                                        <option value="">*** Select a Programme First ***</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group activities">
                            <label for="activity_id" class="col-sm-2 control-label">Activity</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-graduation-cap"></i>
                                    </div>
                                    <select class="form-control select2" style="width: 100%;" id="activity_id"
                                            name="activity_id">
                                        <option value="">*** Select a Project First ***</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-user-plus"></i>
                            Generate
                        </button>
                    </div>
                    <!-- /.box-footer -->
                </form>
            </div>
            <!-- /.box -->
        </div>
        <!-- End new User Form-->
    </div>
    @endsection

    @section('page_script')
            <!-- Select 2-->
    <script src="/bower_components/AdminLTE/plugins/select2/select2.full.min.js"></script>
    <!-- InputMask -->
    <script src="/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.js"></script>
    <script src="/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.extensions.js"></script>

    <!-- Bootstrap date picker -->
    <script src="/bower_components/AdminLTE/plugins/daterangepicker/moment.min.js"></script>
    <script src="/bower_components/AdminLTE/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- iCheck -->
    <script src="/bower_components/AdminLTE/plugins/iCheck/icheck.min.js"></script>
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
    <!-- 		//Date picker
		$('.datepicker').datepicker({
			format: 'dd/mm/yyyy',
			endDate: '-1d',
			autoclose: true
            }); -->
    <!-- End Bootstrap File input -->

    <script type="text/javascript">
        $(function () {
            //Initialize Select2 Elements
            $(".select2").select2();

            //Date Range picker
            $('.daterangepicker').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear',
                    format: 'DD/MM/YYYY'
                }
            });
            $('.daterangepicker').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
            });
            $('.daterangepicker').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });

            //Initialize iCheck/iRadio Elements
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
                increaseArea: '20%' // optional
            });

            //show/hide fields on load
            var reportType = $("input[name='search_type']:checked").val();
            hideFields(reportType);

            //show/hide fields on radio change
            $('#rdo_programme, #rdo_project, #rdo_activity').on('ifChecked', function(){
                var reportType = $(this).val();
                hideFields(reportType);
            });

            //repopulate projects dropdown when a programme has been changed
            $('#programme_id').change(function(){
                var programmeID = $(this).val();
                populateProjectDD(programmeID, 1);
            });

            //load activities on project change
            $('#project_id').change(function(){
                var projectID = $(this).val();
                populateActivityList(projectID, 1);
            });
        });
        //function to hide/show fields depending on the report type
        function hideFields(reportType) {
            if (reportType == 1) { //Programme
                $('#programme_id').select2().val('').trigger("change");
                $('.projects, .activities').hide();
                $('.programmes').show();
                $('#report_form').attr('action', '/reports/programme/finance');
            }
            else if (reportType == 2) { //Project
                $('#programme_id').select2().val('').trigger("change");
                $('.activities').hide();
                $('.programmes, .projects').show();
                $('#report_form').attr('action', '/reports/project/finance');
            }
            else if (reportType == 3) { //Activity
                $('#programme_id').select2().val('').trigger("change");
                $('.programmes, .projects, .activities').show();
                $('#report_form').attr('action', '/reports/activity/finance');
            }
            return reportType;
        }
        //function to populate the projects drop down
        function populateProjectDD(programme_id, incComplete, loadAll) {
            incComplete = incComplete || -1;
            loadAll = loadAll || -1;
            $.post("{!! route('projectsdropdown') !!}", { option: programme_id, _token: $('input[name=_token]').val(), inc_complete: incComplete, load_all: loadAll },
                    function(data) {
                        var projects = $('#project_id');
                        var firstDDOption = "*** Select a Project ***";
                        if (programme_id > 0) firstDDOption = "*** Select a Project ***";
                        else if (programme_id == '') firstDDOption = "*** Select a Programme First ***";
                        projects.empty();
                        projects
                                .append($("<option></option>")
                                        .attr("value",'')
                                        .text(firstDDOption));
                        $.each(data, function(key, value) {
                            projects
                                    .append($("<option></option>")
                                            .attr("value",value)
                                            .text(key));
                        });
                    });
        }
        //function to populate the activity drop down
        function populateActivityList(project_id, incComplete, loadAll) {
            incComplete = incComplete || -1;
            loadAll = loadAll || -1;
            $.post("{!! route('activitydropdown') !!}", { option: project_id, _token: $('input[name=_token]').val(), inc_complete: incComplete, load_all: loadAll },
                    function(data) {
                        var activity = $('#activity_id');
                        var firstDDOption = "*** Select an Activity ***";
                        if (project_id > 0) firstDDOption = "*** Select an Activity ***";
                        else if (project_id == '') firstDDOption = "*** Select a Project First ***";
                        activity.empty();
                        activity
                                .append($("<option></option>")
                                        .attr("value",'')
                                        .text(firstDDOption));
                        $.each(data, function(key, value) {
                            var option = $("<option></option>")
                                    .attr("value",value)
                                    .text(key);
                            //if(passedActivityID == value) option.attr("selected","selected");
                            activity.append(option);
                        });
                    });
        }
    </script>
@endsection