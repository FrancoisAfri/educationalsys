@extends('layouts.main_layout')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Activity Statistics</h3>
                </div>
                <!-- /.box-header -->
                <form class="form-horizontal" method="POST" action="/reports/project_stats/print">
                    <input type="hidden" name="start_date" value="{{!empty($start_date) ? $start_date : ''}}">
                    <input type="hidden" name="end_date" value="{{!empty($end_date) ? $end_date : ''}}">
                    <input type="hidden" name="project_id" value="{{!empty($project_id) ? $project_id : ''}}">
                    {{ csrf_field() }}

                    <div class="box-body">
                        <!-- Collapsible section containing the amortization schedule -->
                        <div class="box-group" id="accordion">
                            <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                            <div class="panel box box-primary">
                                <div class="box-body">
                                    <table class="table table-striped">
                                        <tr>
                                            <th>Activity</th>
                                            <th>Male</th>
                                            <th>Female</th>
                                            <th>Black</th>
                                            <th>White</th>
                                            <th>Coloured</th>
                                            <th>Total</th>
                                        </tr>
                                        @if(count($activities) > 0)
                                            @foreach($activities as $activity)
                                                <tr>
                                                    <td>{{ !empty($activity->name) ? $activity->name : '' }}</td>
                                                    <td>{{ (($activity->regMalePublic && $activity->regMalePublic->count) ? $activity->regMalePublic->count : 0) +
                                                     (($activity->regMaleEducators && $activity->regMaleEducators->count) ? $activity->regMaleEducators->count : 0) +
                                                     (($activity->regMaleLearners && $activity->regMaleLearners->count) ? $activity->regMaleLearners->count : 0) }}</td>
                                                    <td>{{ (($activity->regFemalePublic && $activity->regFemalePublic->count) ? $activity->regFemalePublic->count : 0) +
                                                     (($activity->regFemaleEducators && $activity->regFemaleEducators->count) ? $activity->regFemaleEducators->count : 0) +
                                                     (($activity->regFemaleLearners && $activity->regFemaleLearners->count) ? $activity->regFemaleLearners->count : 0) }}</td>
                                                    <td>{{ (($activity->regBlackPublic && $activity->regBlackPublic->count) ? $activity->regBlackPublic->count : 0) +
                                                     (($activity->regBlackEducators && $activity->regBlackEducators->count) ? $activity->regBlackEducators->count : 0) +
                                                     (($activity->regBlackLearners && $activity->regBlackLearners->count) ? $activity->regBlackLearners->count : 0) }}</td>
                                                    <td>{{ (($activity->regWhitePublic && $activity->regWhitePublic->count) ? $activity->regWhitePublic->count : 0) +
                                                     (($activity->regWhiteEducators && $activity->regWhiteEducators->count) ? $activity->regWhiteEducators->count : 0) +
                                                     (($activity->regWhiteLearners && $activity->regWhiteLearners->count) ? $activity->regWhiteLearners->count : 0) }}</td>
                                                    <td>{{ (($activity->regColouredPublic && $activity->regColouredPublic->count) ? $activity->regColouredPublic->count : 0) +
                                                     (($activity->regColouredEducators && $activity->regColouredEducators->count) ? $activity->regColouredEducators->count : 0) +
                                                     (($activity->regColouredLearners && $activity->regColouredLearners->count) ? $activity->regColouredLearners->count : 0) }}</td>
                                                    <td>{{ ($activity->regPeople && $activity->regPeople->count) ? $activity->regPeople->count : 0 }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </table>
                                    <div class="row no-print">
                                        <div class="col-xs-12">
                                            <button type="submit" class="btn btn-primary pull-right"><i
                                                        class="fa fa-print"></i>Print report
                                            </button>
                                        </div>
                                    </div>
                                    <!-- End amortization /table -->
                                </div>
                            </div>
                        </div>
                        <!-- /. End Collapsible section containing the amortization schedule -->
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('page_script')
    <script type="text/javascript">
        //Cancel button click event
        document.getElementById("back_to_search").onclick = function () {
            location.href = "/reports/programme";
        };
    </script>
@endsection