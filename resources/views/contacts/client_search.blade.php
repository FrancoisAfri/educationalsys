@extends('layouts.main_layout')
@section('page_dependencies')
        <!-- bootstrap datepicker -->
<link rel="stylesheet" href="/bower_components/AdminLTE/plugins/daterangepicker/daterangepicker.css">
<!-- bootstrap file input -->
<link href="/bower_components/bootstrap_fileinput/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    <div class="row">
        <!-- New User Form -->
        <div class="col-md-8 col-md-offset-2">
            <!-- Horizontal Form -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <i class="fa fa-user pull-right"></i>
                    <h3 class="box-title">Education Search</h3>
                    <p>Enter search details:</p>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" id="report_form" method="POST">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="search_type" class="col-sm-2 control-label">Search Type</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <select class="form-control select2{{ $errors->has('project_id') ? ' has-error' : '' }}"
                                            name="search_type" id="search_type" style="width: 100%;"
                                            onchange="changetype(this.value)" required>
                                        <option value="1">Educator</option>
                                        <option value="2">Public</option>
                                        <option value="3">Learner</option>
                                        <option value="4">Group Learner</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group proj_act_dd{{ $errors->has('project_id') ? ' has-error' : '' }}">
                            <label for="project_id" class="col-sm-2 control-label">Project</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-bar-chart"></i>
                                    </div>
                                    <select id="project_id" name="project_id" class="form-control select2" style="width: 100%;">
                                        <option value="">*** Select Project ***</option>
                                        @foreach($projects as $projects)
                                            <option value="{{ $projects->id }}">{{ $projects->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group proj_act_dd{{ $errors->has('activity_id') ? ' has-error' : '' }}">
                            <label for="activity_id" class="col-sm-2 control-label">Activity</label>

                            <div class="col-sm-10">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-bar-chart"></i>
                                    </div>
                                    <select id="activity_id" name="activity_id" class="form-control select2" style="width: 100%;">
                                        <option value="">*** Select a project first ***</option>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group educators{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="search_type" class="col-sm-2 control-label">Educator First Name</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <input type="text" class="form-control" id="name" value="{{ old('name') }}"
                                           name="educator_name" value="" placeholder="Enter Educator Name...">
                                </div>
                            </div>
                        </div>
                        <div class="form-group educators{{ $errors->has('educator_ID') ? ' has-error' : '' }}">
                            <label for="search_type" class="col-sm-2 control-label">Educator ID Number</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <input type="text" class="form-control" id="educator_ID" name="educator_ID"
                                           value="{{ old('educator_ID') }}" placeholder="Enter Educator ID Number...">
                                </div>
                            </div>
                        </div>
                        <div class="form-group educators{{ $errors->has('educator_number') ? ' has-error' : '' }}">
                            <label for="search_type" class="col-sm-2 control-label">Educator Cell Number</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <input type="text" class="form-control" id="educator_number" name="educator_number"
                                           value="{{ old('educator_number') }}"
                                           placeholder="Enter Educator Cell Number...">
                                </div>
                            </div>
                        </div>
                        <div class="form-group publics{{ $errors->has('public_name') ? ' has-error' : '' }}">
                            <label for="search_type" class="col-sm-2 control-label">Public Name</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <input type="text" class="form-control" id="public_name" name="public_name"
                                           value="{{ old('public_name') }}" placeholder="Enter Public Name...">
                                </div>
                            </div>
                        </div>
                        <div class="form-group publics{{ $errors->has('public_number') ? ' has-error' : '' }}">
                            <label for="search_type" class="col-sm-2 control-label">Public ID Number</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <input type="text" class="form-control" id="public_number" name="public_number"
                                           value="{{ old('public_number') }}" placeholder="Enter Public ID Number...">
                                </div>
                            </div>
                        </div>
                        <div class="form-group publics{{ $errors->has('public_cell_number') ? ' has-error' : '' }}">
                            <label for="search_type" class="col-sm-2 control-label">Public Cell Number</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <input type="text" class="form-control" id="public_cell_number"
                                           name="public_cell_number" value="{{ old('public_cell_number') }}"
                                           placeholder="Enter Public Cell Number...">
                                </div>
                            </div>
                        </div>
                        <div class="form-group learners{{ $errors->has('learner_name') ? ' has-error' : '' }}">
                            <label for="search_type" class="col-sm-2 control-label">Learner Name</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <input type="text" class="form-control" id="learner_name" name="learner_name"
                                           value="{{ old('learner_name') }}" placeholder="Enter Learner Name...">
                                </div>
                            </div>
                        </div>
                        <div class="form-group learners{{ $errors->has('learner_id') ? ' has-error' : '' }}">
                            <label for="search_type" class="col-sm-2 control-label">Learner Number</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <input type="text" class="form-control" id="learner_id" name="learner_id"
                                           value="{{ old('learner_id') }}" placeholder="Enter Learner Number...">
                                </div>
                            </div>
                        </div>
                        <div class="form-group learners{{ $errors->has('learner_number') ? ' has-error' : '' }}">
                            <label for="search_type" class="col-sm-2 control-label">Learner Cell Number</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <input type="text" class="form-control" id="learner_number" name="learner_number"
                                           value="{{ old('learner_number') }}"
                                           placeholder="Enter Learner Cell Number...">
                                </div>
                            </div>
                        </div>
                        <div class="form-group groups{{ $errors->has('school_id') ? ' has-error' : '' }}">
                            <label for="search_type" class="col-sm-2 control-label">Schools</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-building"></i>
                                    </div>
                                    <select class="form-control select2" style="width: 100%;" id="school_id"
                                            name="school_id">
                                        <option value="{{ old('school_id') }}">*** Select a School ***</option>
                                        @foreach($schools as $school)
                                            <option value="{{ $school->id }}">{{ $school->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group groups">
                            <label for="search_type" class="col-sm-2 control-label">Date Attended</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control daterangepicker" id="date_attended"
                                           name="date_attended" placeholder="  dd/mm/yyyy" value="{{ old('date') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-user-plus"></i> Search
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
        //Cancel button click event
        /*document.getElementById("cancel").onclick = function () {
         location.href = "/contacts";
         };*/
        $(function () {
            //Initialize Select2 Elements
            $(".select2").select2();
            //Date Range picker
            $('.daterangepicker').daterangepicker({
                format: 'dd/mm/yyyy',
                endDate: '-1d',
                autoclose: true
            });
            $('.educators').show();
            $('.publics').hide();
            $('.learners').hide();
            $('.groups').hide();
            $('#report_form').attr('action', '/educator/search');

            //load activities on project change
            $('#project_id').change(function () {
                var projectID = $(this).val();
                populateActivityDD(projectID);
            });
        });
        function changetype(type) {
            if (type == 1) {
                $('.educators').show();
                $('.publics').hide();
                $('.learners').hide();
                $('.groups').hide();
                $('.proj_act_dd').show();
                $('#report_form').attr('action', '/educator/search');
            }
            else if (type == 2) {
                $('.educators').hide();
                $('.publics').show();
                $('.learners').hide();
                $('.groups').hide();
                $('.proj_act_dd').show();
                $('#report_form').attr('action', '/public_search');
            }
            else if (type == 3) {
                $('.educators').hide();
                $('.publics').hide();
                $('.groups').hide();
                $('.learners').show();
                $('.proj_act_dd').show();
                $('#report_form').attr('action', '/learner/search');
            }
            else if (type == 4) {
                $('.educators').hide();
                $('.publics').hide();
                $('.learners').hide();
                $('.groups').show();
                $('#project_id').val('');
                $('#activity_id').val('');
                $('.proj_act_dd').hide();
                $('#report_form').attr('action', '/group/search');
            }
        }
        //Phone mask
        $("[data-mask]").inputmask();

        passedActivityID = 0;
        //function to populate the projects drop down
        function populateActivityDD(project_id, loadAll) {
            loadAll = loadAll || -1;
            $.post("{!! route('activitydropdown') !!}", {
                        option: project_id,
                        _token: $('input[name=_token]').val(),
                        load_all: loadAll
                    },
                    function (data) {
                        var activities = $('#activity_id');
                        var firstDDOption = "*** Select an Activity ***";
                        if (project_id > 0) firstDDOption = "*** Select an Activity ***";
                        else if (project_id == '') firstDDOption = "*** Select a Project First ***";
                        activities.empty();
                        activities
                                .append($("<option></option>")
                                        .attr("value", '')
                                        .text(firstDDOption));
                        $.each(data, function (key, value) {
                            var option = $("<option></option>")
                                    .attr("value", value)
                                    .text(key);
                            if (passedActivityID == value) option.attr("selected", "selected");
                            activities.append(option);
                            ;
                        });
                    });
        }
    </script>
@endsection