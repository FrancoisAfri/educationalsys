@extends('layouts.main_layout')
@section('page_dependencies')
   
	<link rel="stylesheet" href="/bower_components/AdminLTE/plugins/datatables/dataTables.bootstrap.css">
@endsection
@section('content')
    <div class="row">
        <!-- New User Form -->
        <div class="col-md-12">
            <!-- Horizontal Form -->
			<form class="form-horizontal" method="POST" action="/educator/search/print" target="_blank">
                <input type="hidden" name="educator_name" value="{{!empty($educator_name) ? $educator_name : ''}}">
                <input type="hidden" name="educator_ID" value="{{!empty($educator_ID) ? $educator_ID : ''}}">
                <input type="hidden" name="educator_number" value="{{!empty($educator_number) ? $educator_number : ''}}">
                <input type="hidden" name="project_id" value="{{!empty($project_id) ? $project_id : ''}}">
                <input type="hidden" name="activity_id" value="{{!empty($activity_id) ? $activity_id : ''}}">
                {{ csrf_field() }}

            <div class="box box-primary">
                <div class="box-header with-border">
                    <i class="fa fa-user pull-right"></i>
                    <h3 class="box-title">Educators Search Result</h3>
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
				@if (count($educators) > 0)
					@foreach($educators as $educator)
					<tr>
                        <td style="width: 2px;" class="text-center">{{ $loop->iteration }}</td>
                        <td><a href="{{ '/contacts/educator/'.$educator->id.'/edit'}}" >{{ !empty($educator->first_name) ? $educator->first_name : '' }}</a></td>
                        <td>{{ !empty($educator->surname) ? $educator->surname : '' }}</td>
                        <td>{{ !empty($educator->id_number) ? $educator->id_number : '' }}</td>
                        <td>{{ !empty($educator->gender) ? 'Male' : 'Female' }}</td>
                        <td>{{ !empty($educator->cell_number) ? $educator->cell_number : '' }}</td>
                        <td>{{ !empty($educator->physical_address) ? $educator->physical_address : '' }}</td>
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