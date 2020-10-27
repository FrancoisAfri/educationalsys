@extends('layouts.main_layout')
@section('page_dependencies')
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="/bower_components/AdminLTE/plugins/datepicker/datepicker3.css">
<!-- iCheck -->
<link rel="stylesheet" href="/bower_components/AdminLTE/plugins/iCheck/square/green.css">
@endsection
@section('content')
    <div class="row">
        <!-- New User Form -->
        <div class="col-md-8 col-md-offset-2">
            <!-- Horizontal Form -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <i class="fa fa-user pull-right"></i>
                    <h3 class="box-title">New Public Registration</h3>
                    <p>Enter Public Registration details:</p>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" method="POST" action="/add_public_registration"
                      enctype="multipart/form-data">
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
                        <div class="form-group{{ $errors->has('project_id') ? ' has-error' : '' }}">
                            <label for="project_id" class="col-sm-3 control-label">Project</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-bar-chart"></i>
                                    </div>
                                    <select id="project_id" name="project_id" class="form-control select2">
                                        <option value="">*** Select Project ***</option>
                                        @foreach($projects as $projects)
                                            <option value="{{ $projects->id }}"{{ ($project_id != -1) ? ' selected' : '' }}>{{ $projects->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('activity_id') ? ' has-error' : '' }}">
                            <label for="activity_id" class="col-sm-3 control-label">Activity</label>

                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-bar-chart"></i>
                                    </div>
                                    <select id="activity_id" name="activity_id" class="form-control select2">
                                        <option value="">*** Select a project first ***</option>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                            <label for="appliction_type" class="col-sm-3 control-label">Application Type</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <select class="form-control select2" name="type" id="type"
                                            placeholder="Select Appliction Type" onchange="changeApplicant(this.value)"
                                            required>
                                        <option value="1"{{ (1 == old('type')) ? ' selected' : '' }}>Short term</option>
                                        <option value="2"{{ (2 == old('type')) ? ' selected' : '' }}>Long term</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('names') ? ' has-error' : '' }}">
                            <label for="names" class="col-sm-3 control-label">Name & Surname</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <input type="text" class="form-control" id="names" name="names"
                                           value="{{ old('names') }}" placeholder="Name & Surname">
                                </div>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('id_number') ? ' has-error' : '' }}">
                            <label for="id_number" class="col-sm-3 control-label">ID Number</label>

                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-book"></i>
                                    </div>
                                    <input type="number" class="form-control" id="id_number"
                                           value="{{ old('id_number') }}" name="id_number" value=""
                                           placeholder="ID Number">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ethnicity" class="col-sm-3 control-label">Ethnicity</label>

                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-bar-chart"></i>
                                    </div>
                                    <select name="ethnicity" class="form-control select2">
                                        <option value="">*** Select Ethnic Group ***</option>
                                        @foreach($ethnicities as $ethnicity)
                                            <option value="{{ $ethnicity->id }}"{{ ($ethnicity->id == old('ethnicity')) ? ' selected' : '' }}>{{ $ethnicity->value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
                            <label for="gender" class="col-sm-3 control-label">Gender</label>

                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-venus-mars"></i>
                                    </div>
                                    <select name="gender" class="form-control select2">
                                        <!--<option value="">*** Select gender ***</option>-->
                                        <option value="1"{{ (1 == old('gender')) ? ' selected' : '' }}>Male</option>
                                        <option value="2"{{ (2 == old('gender')) ? ' selected' : '' }}>Female</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('cell_number') ? ' has-error' : '' }}">
                            <label for="cell_number" class="col-sm-3 control-label">Cell Number</label>

                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-phone"></i>
                                    </div>
                                    <input type="tel" class="form-control" id="cell_number" name="cell_number" value=""
                                           data-inputmask='"mask": "(999) 999-9999"' placeholder="Cell Number"
                                           value="{{ old('cell_number') }}" data-mask>
                                </div>
                            </div>
                        </div>
                        <div class="form-group longterm{{ $errors->has('phys_address') ? ' has-error' : '' }}">
                            <label for="phys_address" class="col-sm-3 control-label">Residential Address</label>

                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-home"></i>
                                    </div>
                                    <textarea name="phys_address" class="form-control" value="{{ old('phys_address') }}"
                                              placeholder="Residential Address"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group longterm {{ $errors->has('postal_address') ? ' has-error' : '' }}">
                            <label for="postal_address" class="col-sm-3 control-label">Postal Address</label>

                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-home"></i>
                                    </div>
                                    <textarea name="postal_address" value="{{ old('postal_address') }}"
                                              class="form-control" placeholder="Postal Address"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group longterm {{ $errors->has('email_address') ? ' has-error' : '' }}">
                            <label for="email_address" class="col-sm-3 control-label">Email Address</label>

                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-envelope"></i>
                                    </div>
                                    <input type="email" class="form-control" id="email_address"
                                           value="{{ old('email_address') }}" name="email_address" value=""
                                           placeholder="Email Address">
                                </div>
                            </div>
                        </div>
                        <div class="form-group longterm{{ $errors->has('highest_qualification') ? ' has-error' : '' }}">
                            <label for="highest_qualification" class="col-sm-3 control-label">Highest
                                qualification</label>

                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-envelope"></i>
                                    </div>
                                    <input type="text" class="form-control" id="highest_qualification"
                                           value="{{ old('highest_qualification') }}" name="highest_qualification"
                                           placeholder="Highest qualification">
                                </div>
                            </div>
                        </div>
                        <div class="form-group longterm{{ $errors->has('previous_computer_exp') ? ' has-error' : '' }}">
                            <label for="previous_computer_exp" class="col-sm-3 control-label">Previous computer
                                experience</label>

                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-envelope"></i>
                                    </div>
                                    <input type="text" class="form-control" id="previous_computer_exp"
                                           name="previous_computer_exp" value="{{ old('previous_computer_exp') }}"
                                           placeholder="Previous computer experience">
                                </div>
                            </div>
                        </div>
                        <div class="form-group longterm{{ $errors->has('programme_discovery') ? ' has-error' : '' }}">
                            <label for="programme_discovery" class="col-sm-3 control-label">How did you know about this
                                programme?</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-info-circle"></i>
                                    </div>
                                    <select class="form-control select2" style="width: 100%;" id="programme_discovery" name="programme_discovery">
                                        <option value="">How did you know about this programme?</option>
                                        <option value="Word of Mouth"{{ ('Word of Mouth' == old('programme_discovery')) ? ' selected="selected"' : '' }}>Word of Mouth</option>
                                        <option value="Internet"{{ ('Internet' == old('programme_discovery')) ? ' selected="selected"' : '' }}>Internet</option>
                                        <option value="Newspaper"{{ ('Newspaper' == old('programme_discovery')) ? ' selected="selected"' : '' }}>Newspaper</option>
                                        <option value="Pamphlet"{{ ('Pamphlet' == old('programme_discovery')) ? ' selected="selected"' : '' }}>Pamphlet/Brochure</option>
                                        <option value="Other"{{ ('Other' == old('programme_discovery')) ? ' selected="selected"' : '' }}>Other</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group longterm{{ $errors->has('completed_certificates') ? ' has-error' : '' }}">
                            <label for="completed_certificates" class="col-sm-3 control-label">Completed
                                Certificates</label>

                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-envelope"></i>
                                    </div>
                                    <input type="text" class="form-control" id="completed_certificates"
                                           name="completed_certificates" value="{{ old('completed_certificates') }}"
                                           placeholder="Completed Certificates">
                                </div>
                            </div>
                        </div>
                        <div class="form-group longterm{{ $errors->has('date') ? ' has-error' : '' }}">
                            <label for="date" class="col-sm-3 control-label">Date</label>

                            <div class="col-sm-9">
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control datepicker" name="date"
                                           placeholder="  dd/mm/yyyy" value="{{ old('date') }}">
                                </div>
                            </div>
                        </div>
                        <!-- <div class="form-group longterm">
                            <label for="attendance_doc" class="col-sm-3 control-label">Attendance</label>

                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-book"></i>
                                    </div>
                                    <input type="file" id="attendance_doc" name="attendance_doc" class="file file-loading" data-allowed-file-extensions='["pdf", "docx"]' data-show-upload="false">
                                </div>
                            </div>
                        </div> -->
                        <div class="form-group longterm{{ $errors->has('result') ? ' has-error' : '' }}">
                            <label for="results" class="col-sm-3 control-label">Results</label>

                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-book"></i>
                                    </div>
                                    <input type="text" class="form-control" id="result" name="result"
                                           value="{{ old('result') }}" placeholder="Results">
                                </div>
                            </div>
                        </div>
                        <div class="form-group longterm{{ $errors->has('registration_fee') ? ' has-error' : '' }}">
                            <label for="registration_fee" class="col-sm-3 control-label">Registration fee</label>

                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        R
                                    </div>
                                    <input type="text" class="form-control" id="registration_fee"
                                           name="registration_fee" value="{{ old('registration_fee') }}"
                                           placeholder="Registration fee" onkeyup="this.value=this.value.replace(/[^\d\.{1}]/,'')"
                                           onchange="convertMoney(this);">
                                </div>
                            </div>
                        </div>
                        <div class="form-group longterm{{ $errors->has('employment_status') ? ' has-error' : '' }}">
                            <label for="employment_status" class="col-sm-3 control-label">Employment Status</label>

                            <div class="col-sm-9">
                                <label class="radio-inline" style="padding-left: 0px;"><input type="radio" id="rdo_employed" name="employment_status" value="employed"{{('employed' == old('employment_status')) ? ' checked' : ''}}> Employed</label>
                                <label class="radio-inline"><input type="radio" id="rdo_unemployed" name="employment_status" value="unemployed"{{('unemployed' == old('employment_status')) ? ' checked' : ''}}> Unemployed</label>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button id="cancel" class="btn btn-default"><i class="fa fa-arrow-left"></i> Cancel</button>
                        <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-user-plus"></i> Add
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
            <!-- InputMask -->
    <script src="/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.js"></script>
    <script src="/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.extensions.js"></script>

    <!-- Select2 -->
    <script src="/bower_components/AdminLTE/plugins/select2/select2.full.min.js"></script>

    <script src="/bower_components/AdminLTE/plugins/datepicker/bootstrap-datepicker.js"></script>

    <!-- iCheck -->
    <script src="/bower_components/AdminLTE/plugins/iCheck/icheck.min.js"></script>

    <script type="text/javascript">
        //Cancel button click event
        document.getElementById("cancel").onclick = function () {
            location.href = "/contacts";
        };
        $(function () {
            //Initialize Select2 Elements
            $(".select2").select2();
            //Initialize iCheck/iRadio Elements
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
                increaseArea: '20%' // optional
            });
            //Date picker
            $('.datepicker').datepicker({
                format: 'dd/mm/yyyy',
                endDate: '-1d',
                autoclose: true,
                todayHighlight: true
            });
            //Phone mask
            $("[data-mask]").inputmask();

            //load activities on page load if project passed by default url
            var projID = $('#project_id').val();
            if (projID > 0) populateActivityDD(projID);

            //load activities on project change
            $('#project_id').change(function () {
                var projectID = $(this).val()
                populateActivityDD(projectID);
            });
            $('.longterm').hide();
            var applicationType = $('#type').val();
            changeApplicant(applicationType);
        });
        function changeApplicant(type) {
            if (type == 1) {
                $('.longterm').hide();
                $('.shortterm').show();
            }
            else {
                $('.shortterm').hide();
                $('.longterm').show();
            }

        }
        //Phone mask
        $("[data-mask]").inputmask();
        //select the project sent from url
        var passedActivityID = parseInt("{{ $activity_id }}");
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
        //Money format function
        function convertMoney(textBox) {
            var value = textBox.value;
            if (value.length > 1)
            {
                var str = value.toString().split('.');
                if (str[0].length >= 4) {
                    str[0] = str[0].replace(/(\d)(?=(\d{3})+$)/g, '$1,');
                }
                if (str[1] && str[1].length >= 5) {
                    str[1] = str[1].replace(/(\d{3})/g, '$1 ');
                }
                value = str + '.00';
            }
            else value = '';
            $(textBox).val(value);
            //console.log(value);
        }
    </script>
@endsection