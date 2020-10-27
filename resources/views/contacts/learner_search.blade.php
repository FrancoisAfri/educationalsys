@extends('layouts.main_layout')
@section('page_dependencies')
   
	<link rel="stylesheet" href="/bower_components/AdminLTE/plugins/datatables/dataTables.bootstrap.css">
@endsection
@section('content')
    <div class="row">
        <!-- New User Form -->
        <div class="col-md-12">
            <!-- Horizontal Form -->
			<form class="form-horizontal" method="POST" action="/learner/search/print" target="_blank">
                <input type="hidden" name="learner_name" value="{{!empty($learner_name) ? $learner_name : ''}}">
                <input type="hidden" name="learner_id" value="{{!empty($learner_id) ? $learner_id : ''}}">
                <input type="hidden" name="learner_number" value="{{!empty($learner_number) ? $learner_number : ''}}">
                <input type="hidden" name="project_id" value="{{!empty($project_id) ? $project_id : ''}}">
                <input type="hidden" name="activity_id" value="{{!empty($activity_id) ? $activity_id : ''}}">
                {{ csrf_field() }}

            <div class="box box-primary">
                <div class="box-header with-border">
                    <i class="fa fa-user pull-right"></i>
                    <h3 class="box-title">Learner Search Result</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->

                <div class="box-body">
				<div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>Firstname</th>
                    <th>Surname</th>
                    <th>ID Number</th>
                    <th>Gender</th>
                    <th>Cell Number</th>
                    <th>Physical Address</th>
                </tr>
                </thead>
                <tbody>
				@if (count($learners) > 0)
					@foreach($learners as $learner)
					<tr>
                        <td style="width: 2px;" class="text-center">{{ $loop->iteration }}</td>
                        <td><a href="{{ '/contacts/learner/'.$learner->id.'/edit'}}" >{{ !empty($learner->first_name) ? $learner->first_name : '' }}</a></td>
                        <td>{{ !empty($learner->surname) ? $learner->surname : '' }}</td>
                        <td>{{ !empty($learner->id_number) ? $learner->id_number : '' }}</td>
                        <td>{{ !empty($learner->gender) ? 'Male' : 'Female' }}</td>
                        <td>{{ !empty($learner->cell_number) ? $learner->cell_number : '' }}</td>
                        <td>{{ !empty($learner->physical_address) ? $learner->physical_address : '' }}</td>
					</tr>
					@endforeach
				@endif
                </tbody>
                <tfoot>
                <tr>
                    <th class="text-center">#</th>
                    <th>Firstname</th>
                    <th>Surname</th>
                    <th>ID Number</th>
                    <th>Gender</th>
                    <th>Cell Number</th>
                    <th>Physical Address</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
                     </div>   
                    <!-- /.box-body -->
                    <div class="box-footer">
					    <button type="button" id="cancel" class="btn btn-default pull-left"><i class="fa fa-arrow-left"></i> Cancel</button>
                        <button type="submit" id="btn_print" class="btn btn-primary pull-right"><i class="fa fa-print"></i> Print</button>
                    </div>
                    <!-- /.box-footer -->
            </div>
			</form>
            <!-- /.box -->
        </div>
        <!-- End new User Form-->
    </div>
    @endsection

    @section('page_script')
	<!-- DataTables -->
<script src="/bower_components/AdminLTE/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/bower_components/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js"></script>
    <!-- End Bootstrap File input -->

    <script type="text/javascript">
	//Cancel button click event
	document.getElementById("cancel").onclick = function () {
		location.href = "/contacts/general_search";
	};
	 $(function () {
		 $('#example2').DataTable({
		  "paging": true,
		  "lengthChange": true,
		  "searching": true,
		  "ordering": true,
		  "info": true,
		  "autoWidth": true
    });
        });
		
    </script>
@endsection