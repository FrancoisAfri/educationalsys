@extends('layouts.main_layout')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Programme Statistics</h3>
                </div>
                <!-- /.box-header -->
                <form class="form-horizontal" method="POST" action="/reports/programme_stats/print">
                    <input type="hidden" name="start_date" value="{{!empty($start_date) ? $start_date : ''}}">
                    <input type="hidden" name="end_date" value="{{!empty($end_date) ? $end_date : ''}}">
                    {{ csrf_field() }}

                    <div class="box-body">
                        <!-- Collapsible section containing the amortization schedule -->
                        <div class="box-group" id="accordion">
                            <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                            <div class="panel box box-primary">
                                <div class="box-body">
                                    <table class="table table-striped">
                                        <tr>
                                            <th>Programme</th>
                                            <th>Male</th>
                                            <th>Female</th>
                                            <th>Black</th>
                                            <th>White</th>
                                            <th>Coloured</th>
                                            <th>Total</th>
                                        </tr>
                                        @if(count($programmes) > 0)
                                            @foreach($programmes as $programme)
                                                <tr>
                                                    <td><a href="/reports/project_stats/{{ $programme->id }}">{{ !empty($programme->name) ? $programme->name : '' }}</a></td>
                                                    <td>{{ (($programme->regMalePublic && $programme->regMalePublic->count) ? $programme->regMalePublic->count : 0) +
                                                     (($programme->regMaleEducators && $programme->regMaleEducators->count) ? $programme->regMaleEducators->count : 0) +
                                                     (($programme->regMaleLearners && $programme->regMaleLearners->count) ? $programme->regMaleLearners->count : 0) }}</td>
                                                    <td>{{ (($programme->regFemalePublic && $programme->regFemalePublic->count) ? $programme->regFemalePublic->count : 0) +
                                                     (($programme->regFemaleEducators && $programme->regFemaleEducators->count) ? $programme->regFemaleEducators->count : 0) +
                                                     (($programme->regFemaleLearners && $programme->regFemaleLearners->count) ? $programme->regFemaleLearners->count : 0) }}</td>
                                                    <td>{{ (($programme->regBlackPublic && $programme->regBlackPublic->count) ? $programme->regBlackPublic->count : 0) +
                                                     (($programme->regBlackEducators && $programme->regBlackEducators->count) ? $programme->regBlackEducators->count : 0) +
                                                     (($programme->regBlackLearners && $programme->regBlackLearners->count) ? $programme->regBlackLearners->count : 0) }}</td>
                                                    <td>{{ (($programme->regWhitePublic && $programme->regWhitePublic->count) ? $programme->regWhitePublic->count : 0) +
                                                     (($programme->regWhiteEducators && $programme->regWhiteEducators->count) ? $programme->regWhiteEducators->count : 0) +
                                                     (($programme->regWhiteLearners && $programme->regWhiteLearners->count) ? $programme->regWhiteLearners->count : 0) }}</td>
                                                    <td>{{ (($programme->regColouredPublic && $programme->regColouredPublic->count) ? $programme->regColouredPublic->count : 0) +
                                                     (($programme->regColouredEducators && $programme->regColouredEducators->count) ? $programme->regColouredEducators->count : 0) +
                                                     (($programme->regColouredLearners && $programme->regColouredLearners->count) ? $programme->regColouredLearners->count : 0) }}</td>
                                                    <td>{{ ($programme->regPeople && $programme->regPeople->count) ? $programme->regPeople->count : 0 }}</td>
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