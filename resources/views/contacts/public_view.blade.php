@extends('layouts.main_layout')

@section('page_dependencies')
        <!-- bootstrap datepicker -->
<link rel="stylesheet" href="/bower_components/AdminLTE/plugins/datepicker/datepicker3.css">
<!-- iCheck -->
<link rel="stylesheet" href="/bower_components/AdminLTE/plugins/iCheck/square/green.css">
<!-- bootstrap file input -->
<link href="/bower_components/bootstrap_fileinput/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="row">
        <!-- User Form -->
        <div class="col-md-8 col-md-offset-2">
            <!-- Horizontal Form -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <i class="fa fa-user pull-right"></i>
                    <h3 class="box-title">Client</h3>
                    <p>Client details:</p>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" method="POST" action="/public/{{ $public->id }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('PATCH') }}

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
                                            <option value="{{ $projects->id }}"{{ ($public->project_id === $projects->id ) ? ' selected' : '' }}>{{ $projects->name }}</option>
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
						<div class="form-group{{ $errors->has('project_id') ? ' has-error' : '' }}">
                            <label for="appliction_type" class="col-sm-3 control-label">Application Type</label>
                            <div class="col-sm-9">
                                <div class="input-group">
								<div class="input-group-addon">
                              <i class="fa fa-user"></i>
                            </div>
                                    <select class="form-control" name="type" id="type" placeholder="Select Appliction Type"  onchange="changeApplicant(this.value)"  required>
									<option value="1" {{ (!empty($public->type) && $public->type == 1) ? ' selected': '' }}>Short term</option>
									<option value="2" {{ (!empty($public->type) && $public->type == 2) ? ' selected': '' }}>Long term</option>
								  </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="names" class="col-sm-3 control-label">Name & Surname</label>
                            <div class="col-sm-9">
                                <div class="input-group">
								<div class="input-group-addon">
                              <i class="fa fa-user"></i>
                            </div>
                                    <input type="text" class="form-control" id="names" name="names" value="{{ $public->names }}" placeholder="Name & Surname" required>
                                </div>
                            </div>
                        </div>
						<div class="form-group">
                            <label for="id_number" class="col-sm-3 control-label">ID Number</label>

                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-book"></i>
                                    </div>
                                    <input type="number" class="form-control" id="id_number" name="id_number" value="{{ $public->id_number }}" placeholder="ID Number">
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
                                    <select name="ethnicity" class="form-control">
                                        <option value="">*** Select Ethnic Group ***</option>
                                        @foreach($ethnicities as $ethnicity)
                                            <option value="{{ $ethnicity->id }}"  {{ (isset($public) && $ethnicity->id == $public->ethnicity) ? ' selected': '' }}>{{ $ethnicity->value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
						 <div class="form-group">
                            <label for="gender" class="col-sm-3 control-label">Gender</label>

                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-venus-mars"></i>
                                    </div>
                                    <select name="gender" class="form-control">
                                        <option value="">*** Select gender ***</option>
                                        <option value="1"  {{ (!empty($public->gender) && $public->gender == 1) ? ' selected': '' }}>Male</option>
                                        <option value="2" {{ (!empty($public->gender) && $public->gender == 2) ? ' selected': '' }}>Female</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="cell_number" class="col-sm-3 control-label">Cell Number</label>

                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-phone"></i>
                                    </div>
                                    <input type="tel" class="form-control" id="cell_number" name="cell_number" value="{{ $public->cell_number }}" data-inputmask='"mask": "(999) 999-9999"' placeholder="Cell Number" data-mask>
                                </div>
                            </div>
                        </div>
						<div class="form-group shortterm">
                            <label for="activity_id" class="col-sm-3 control-label">Activity/Project</label>

                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-bar-chart"></i>
                                    </div>
                                    <select name="activity_id" class="form-control">
                                        <option value="">*** Select Activity/Project ***</option>
                                        @foreach($activities as $activity)
                                            <option value="{{ $activity->id }}" {{ (isset($public) && $activity->id == $public->activity_id) ? ' selected': '' }}>{{ $activity->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
						<div class="form-group longterm">
                            <label for="phys_address" class="col-sm-3 control-label">Residential Address</label>

                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-home"></i>
                                    </div>
                                    <textarea name="phys_address" class="form-control" placeholder="Residential Address">{{ $public->phys_address }}</textarea>
                                </div>
                            </div>
                        </div>
						<div class="form-group longterm">
                            <label for="postal_address" class="col-sm-3 control-label">Postal Address</label>

                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-home"></i>
                                    </div>
                                    <textarea name="postal_address" class="form-control" placeholder="Postal Address">{{ $public->postal_address }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group longterm">
                            <label for="email" class="col-sm-3 control-label">Email Address</label>

                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-envelope"></i>
                                    </div>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ $public->email }}" placeholder="Email Address">
                                </div>
                            </div>
                        </div>
						<div class="form-group longterm">
                            <label for="highest_qualification" class="col-sm-3 control-label">Highest qualification</label>

                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-envelope"></i>
                                    </div>
                                    <input type="text" class="form-control" id="highest_qualification" name="highest_qualification" value="{{ $public->highest_qualification }}" placeholder="Highest qualification">
                                </div>
                            </div>
                        </div>
						<div class="form-group longterm">
                            <label for="previous_computer_exp" class="col-sm-3 control-label">Previous computer experience</label>

                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-envelope"></i>
                                    </div>
                                    <input type="text" class="form-control" id="previous_computer_exp" name="previous_computer_exp" value="{{ $public->previous_computer_exp }}" placeholder="Previous computer experience">
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
                                            <option value="Word of Mouth"{{ ('Word of Mouth' == $public->programme_discovery) ? ' selected="selected"' : '' }}>Word of Mouth</option>
                                            <option value="Internet"{{ ('Internet' == $public->programme_discovery) ? ' selected="selected"' : '' }}>Internet</option>
                                            <option value="Newspaper"{{ ('Newspaper' == $public->programme_discovery) ? ' selected="selected"' : '' }}>Newspaper</option>
                                            <option value="Pamphlet"{{ ('Pamphlet' == $public->programme_discovery) ? ' selected="selected"' : '' }}>Pamphlet/Brochure</option>
                                            <option value="Other"{{ ('Other' == $public->programme_discovery) ? ' selected="selected"' : '' }}>Other</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
						<div class="form-group longterm">
                            <label for="completed_certificates" class="col-sm-3 control-label">Completed Certificates</label>

                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-envelope"></i>
                                    </div>
                                    <input type="text" class="form-control" id="completed_certificates" name="completed_certificates" value="{{ $public->completed_certificates }}" placeholder="Completed Certificates">
                                </div>
                            </div>
                        </div>
						 <div class="form-group longterm">
                            <label for="date" class="col-sm-3 control-label">Date</label>

                            <div class="col-sm-9">
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control datepicker" name="date" placeholder="  dd/mm/yyyy" value="{{ date('Y M d', $public->date)}}">
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
                        </div>-->
						<div class="form-group longterm">
                            <label for="result" class="col-sm-3 control-label">Results</label>

                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                       <i class="fa fa-book"></i>
                                    </div>
                                    <input type="text" class="form-control" id="result" name="result" value="{{ $public->result }}" placeholder="Results">
                                </div>
                            </div>
                        </div>
						<div class="form-group longterm">
                            <label for="registration_fee" class="col-sm-3 control-label">Registration fee</label>

                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-book"></i>
                                    </div>
                                    <input type="text" class="form-control" id="registration_fee" name="registration_fee" value="{{ $public->registration_fee }}"  placeholder="Registration fee">
                                </div>
                            </div>
                        </div>
                        <div class="form-group longterm{{ $errors->has('employment_status') ? ' has-error' : '' }}">
                            <label for="employment_status" class="col-sm-3 control-label">Employment Status</label>

                            <div class="col-sm-9">
                                <label class="radio-inline" style="padding-left: 0px;"><input type="radio" id="rdo_employed" name="employment_status" value="employed"{{('employed' == $public->employment_status) ? ' checked' : ''}}> Employed</label>
                                <label class="radio-inline"><input type="radio" id="rdo_unemployed" name="employment_status" value="unemployed"{{('unemployed' == $public->employment_status) ? ' checked' : ''}}> Unemployed</label>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="button" id="cancel" class="btn btn-default"><i class="fa fa-arrow-left"></i> Cancel</button>
                        <button type="submit" name="command" id="update" class="btn btn-primary pull-right"><i class="fa fa-upload"></i> Update</button>
				   </div>
                    <!-- /.box-footer -->
                </form>
            </div>
            <!-- /.box -->
        </div>
        <!-- End new User Form-->
        <!-- Confirmation Modal -->
        @if(Session('success_edit'))
            @include('contacts.partials.success_action', ['modal_title' => 'Person Details Updated!', 'modal_content' => session('success_edit')])
        @elseif(Session('success_add'))
            @include('contacts.partials.success_action_2buttons', ['modal_title' => 'Person Added!', 'modal_content' => session('success_add')])
        @endif
    </div>
@endsection

@section('page_script')
            <!-- bootstrap datepicker -->
    <script src="/bower_components/AdminLTE/plugins/datepicker/bootstrap-datepicker.js"></script>

    <!-- iCheck -->
    <script src="/bower_components/AdminLTE/plugins/iCheck/icheck.min.js"></script>

    <!-- InputMask -->
    <script src="/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.js"></script>
    <script src="/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.extensions.js"></script>

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

    <script>
        $(function () {
            //Cancel button click event
            document.getElementById("cancel").onclick = function () {
                location.href = "{{ $back }}";
            };
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
			if ( {{ $public->type }} == 1)
			{
				$('.longterm').hide();
				$('.shortterm').show();
			}
			else if ( {{ $public->type  }} == 2)
			{
				$('.shortterm').hide();
				$('.longterm').show();
			}

            //Phone mask
            $("[data-mask]").inputmask();

            // [bootstrap file input] initialize with defaults
            $("#input-1").fileinput();
            // with plugin options
            //$("#input-id").fileinput({'showUpload':false, 'previewFileType':'any'});

            //Tooltip
            $('[data-toggle="tooltip"]').tooltip();

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

            //load activities on page load
            var projID = parseInt('{{ $public->project_id }}');
            if (projID > 0) populateActivityDD(projID);

            //load activities on project change
            $('#project_id').change(function(){
                var projectID = $(this).val();
                populateActivityDD(projectID);
            });

            //Show success action modal
            $('#success-action-modal').modal('show');
             //add more button click
            $('#add-more-clt').click(function () {
                location.href = href="/contacts/public";
                location.href = "{!! route('genpubregistration', ['project' => !empty($public->project_id) ? $public->project_id : -1, 'activity' => !empty($public->activity_id) ? $public->activity_id : -1]) !!}";
            });
        });
		function changeApplicant(type)
		{
			if (type == 1)
			{
				$('.longterm').hide();
				$('.shortterm').show();
			}
			else
			{
				$('.shortterm').hide();
				$('.longterm').show();
			}
				
		}
        passedActivityID = parseInt('{{ $public->activity_id }}');
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