@extends('layouts.main_layout')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Project Statistics</h3>
                </div>
                <!-- /.box-header -->
                <form class="form-horizontal" method="POST" action="/reports/project_stats/print">
                    <input type="hidden" name="start_date" value="{{!empty($start_date) ? $start_date : ''}}">
                    <input type="hidden" name="end_date" value="{{!empty($end_date) ? $end_date : ''}}">
                    <input type="hidden" name="programme_id" value="{{!empty($project_id) ? $project_id : ''}}">
                    {{ csrf_field() }}

                    <div class="box-body">
                        <!-- Collapsible section containing the amortization schedule -->
                        <div class="box-group" id="accordion">
                            <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                            <div class="panel box box-primary">
                                <div class="box-body">
                                    <table class="table table-striped">
                                        <tr>
                                            <th>Project</th>
                                            <th>Male</th>
                                            <th>Female</th>
                                            <th>Black</th>
                                            <th>White</th>
                                            <th>Coloured</th>
                                            <th>Total</th>
                                        </tr>
                                        @if(count($projects) > 0)
                                            @foreach($projects as $project)
                                                <tr>
                                                    <td><a href="/reports/activity_stats/{{ $project->id }}">{{ !empty($project->name) ? $project->name : '' }}</a></td>
                                                    <td>{{ (($project->regMalePublic && $project->regMalePublic->count) ? $project->regMalePublic->count : 0) +
                                                     (($project->regMaleEducators && $project->regMaleEducators->count) ? $project->regMaleEducators->count : 0) +
                                                     (($project->regMaleLearners && $project->regMaleLearners->count) ? $project->regMaleLearners->count : 0) }}</td>
                                                    <td>{{ (($project->regFemalePublic && $project->regFemalePublic->count) ? $project->regFemalePublic->count : 0) +
                                                     (($project->regFemaleEducators && $project->regFemaleEducators->count) ? $project->regFemaleEducators->count : 0) +
                                                     (($project->regFemaleLearners && $project->regFemaleLearners->count) ? $project->regFemaleLearners->count : 0) }}</td>
                                                    <td>{{ (($project->regBlackPublic && $project->regBlackPublic->count) ? $project->regBlackPublic->count : 0) +
                                                     (($project->regBlackEducators && $project->regBlackEducators->count) ? $project->regBlackEducators->count : 0) +
                                                     (($project->regBlackLearners && $project->regBlackLearners->count) ? $project->regBlackLearners->count : 0) }}</td>
                                                    <td>{{ (($project->regWhitePublic && $project->regWhitePublic->count) ? $project->regWhitePublic->count : 0) +
                                                     (($project->regWhiteEducators && $project->regWhiteEducators->count) ? $project->regWhiteEducators->count : 0) +
                                                     (($project->regWhiteLearners && $project->regWhiteLearners->count) ? $project->regWhiteLearners->count : 0) }}</td>
                                                    <td>{{ (($project->regColouredPublic && $project->regColouredPublic->count) ? $project->regColouredPublic->count : 0) +
                                                     (($project->regColouredEducators && $project->regColouredEducators->count) ? $project->regColouredEducators->count : 0) +
                                                     (($project->regColouredLearners && $project->regColouredLearners->count) ? $project->regColouredLearners->count : 0) }}</td>
                                                    <td>{{ ($project->regPeople && $project->regPeople->count) ? $project->regPeople->count : 0 }}</td>
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