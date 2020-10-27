@extends('layouts.main_layout')
@section('page_dependencies')

    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/datatables/dataTables.bootstrap.css">
@endsection
@section('content')
    <div class="row">
        <!-- New User Form -->
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <!--<form class="form-horizontal" method="get" action="/education/search">-->
                <div class="box box-success">
                    <div class="box-header with-border">
                        <i class="fa fa-user pull-right"></i>
                        <h3 class="box-title">Registered Clients</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->

                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <p class="lead">{{ $className->label . ': ' . $className->name }}</p>
                            </div>
                        </div>
                        <!--<div class="box">-->
                            <!-- /.box-header -->
                            <!--<div class="box-body">-->
                                <table id="registered-people" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>ID Number</th>
                                        <th>Registration Date</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if (count($registrations) > 0)
                                        @foreach($registrations as $registration)
                                            <tr>
                                                <td>{{ !empty($registration->client->full_name) ? $registration->client->full_name : '' }}</td>
                                                <td>{{ !empty($registration->client->id_number) ? $registration->client->id_number : '' }}</td>
                                                <td>{{ !empty($registration->created_at) ? $registration->created_at->format('d-m-Y') : '' }}</td>
                                                <td style="text-align: center;"><button type="button" class="btn btn-xs btn-primary btn-flat" data-registration="{{ $registration }}" data-toggle="modal" data-target="#capture-results-modal">Capture Results</button></td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                    <!--<tfoot>
                                    <tr>
                                        <th>Name</th>
                                        <th>Code</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Budget Expenditure</th>
                                        <th>Budget Income</th>
                                    </tr>
                                    </tfoot>-->
                                </table>
                            <!--</div>-->
                            <!-- /.box-body -->
                        <!--</div>-->
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button id="btn_back" class="btn btn-default pull-left"><i class="fa fa-arrow-left"></i> Back</button>
                    </div>
                    <!-- /.box-footer -->
                </div>
            <!--</form>-->
            <!-- /.box -->
        </div>
        <!-- End new User Form-->
        <!-- Include results modal forms -->
        @if(count($registrations) > 0)
            @include('results.partials.capture_results_modal', ['modal_title' => 'Capture Results'])
        @endif
    </div>
    @endsection

    @section('page_script')
    <!-- DataTables -->
    <script src="/bower_components/AdminLTE/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/bower_components/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js"></script>

    <!-- Ajax form submit -->
    <script src="/custom_components/js/modal_ajax_submit.js"></script>

    <script type="text/javascript">
        $(function () {
            $('#registered-people').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true
            });

            $('#btn_back').click(function () {
                location.href = '/education/loadclients';
            });

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

            //Load results(fields) on modal show
            var regID = 0;
            $('#capture-results-modal').on('show.bs.modal', function (event) {
                var subjectNames =JSON.parse('{!! $subjectNames !!}');
                var regType = parseInt('{{ $regType }}');
                var button = $(event.relatedTarget); // Button that triggered the modal
                var registration = button.data('registration'); // Extract info from data-* attributes
                var subjects = registration.subjects;
                regID = registration.id;
                var modal = $(this);
                var resultTable = modal.find('#results_table');
                resultTable.empty();

                $.each(subjects, function(key, value) {

                    var subjectName = '';// subjectID = 0;
                    //console.log(subjectNames);
                    if (regType == 1) { //Subjects (learner)
                        //subjectID = value.subject_id;
                        subjectName = subjectNames[value.subject_id];
                    }
                    else if (regType == 2) { //Modules (educator)
                        //subjectID = value.id;
                        subjectName = value.module_name;
                    }
                    else if (regType == 3) { //area (general public)
                        //subjectID = value.area_id;
                        subjectName = subjectNames[value.area_id];
                    }

                    var inputLabel = $('<label for="result[]" class="control-label"></label>').html(subjectName);
                    var labelTD = $('<td></td>').html(inputLabel);

                    var input = $('<input class="form-control input-sm" type="number" class="form-control" placeholder="Enter the Result...">')
                        .attr("name", "results[]")
                        .val(value.result);
                    var inputGroupAddon = $('<div class="input-group-addon"><i class="fa fa-percent"></i></div>');
                    var inputGroup = $('<div class="input-group"></div>').append(input, inputGroupAddon);
                    var inputTD = $('<td></td>').html(inputGroup);

                    var tr = $('<tr></tr>').append(labelTD, inputTD);
                    var hiddenInput = $('<input type="hidden">')
                        .attr("name", "reg_subject_ids[]")
                        .val(value.id);
                    resultTable.append(tr, hiddenInput);
                });
            });

            //Post result form to server using ajax (form data object)
            $('#save-results').on('click', function() {
                var strUrl = '/education/registration/' + regID + '/result';
                var formName = 'capture-results-form';
                var modalID = 'capture-results-modal';
                var submitBtnID = 'save-results';
                var redirectUrl = 'reload()';
                var successMsgTitle = 'Result Saved!';
                var successMsg = 'The results have been saved successfully.';
                modalFormDataSubmit(strUrl, formName, modalID, submitBtnID, redirectUrl, successMsgTitle, successMsg);
            });
        });

    </script>
@endsection