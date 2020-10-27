@extends('layouts.main_layout')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-success">
                <div class="box-header">
                    <i class="fa fa-file pull-right"></i>
                    <h3 class="box-title">{{ $str_report_type }} Report</h3>
                    <p>Report Details:</p>
                </div>
                <!-- /.box-header -->
                <form class="form-horizontal" id="report_print_form" method="POST">
                    <input type="hidden" name="search_type" value="{{!empty($search_type) ? $search_type : ''}}">
                    <input type="hidden" name="programme_id" value="{{!empty($programme_id) ? $programme_id : ''}}">
                    <input type="hidden" name="start_from" value="{{!empty($start_from) ? $start_from : ''}}">
                    <input type="hidden" name="start_to" value="{{!empty($start_to) ? $start_to : ''}}">
                    {{ csrf_field() }}

                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                                    <strong class="lead">Finance Report Parameters</strong><br>
                                    <strong>Report Type:</strong> <em>{{ $str_report_type }}</em> &nbsp; &nbsp;
                                    @if(!empty($programme))
                                        | &nbsp; &nbsp; <strong>Programme:</strong> <em>{{ $programme }}</em> &nbsp; &nbsp;
                                    @endif
                                    @if($search_type == 2 || $search_type == 3)
                                        @if(!empty($project))
                                            | &nbsp; &nbsp; <strong>Project:</strong> <em>{{ $project }}</em> &nbsp; &nbsp;
                                        @endif
                                    @endif
                                    @if($search_type == 3)
                                        @if(!empty($activity))
                                            | &nbsp; &nbsp; <strong>Project:</strong> <em>{{ $activity }}</em> &nbsp; &nbsp;
                                        @endif
                                    @endif
                                    @if(!empty($start_date_range))
                                        | &nbsp; &nbsp; <strong>Start Date Range:</strong> <em>{{ $start_date_range }}</em> &nbsp; &nbsp;
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div style="overflow-x:auto;">
                            <table class="table table-striped">
                                <tr>
                                    <th>Programme</th>
                                    @if($search_type == 2 || $search_type == 3)
                                        <th>Project</th>
                                    @endif
                                    @if($search_type == 3)
                                        <th>Activity</th>
                                    @endif
                                    <th style="text-align: right;">Budgeted Income</th>
                                    <th style="text-align: right;">Actual Income</th>
                                    <th style="text-align: right;">Income Diff.</th>
                                    <th style="text-align: right;">Budgeted Expenditure</th>
                                    <th style="text-align: right;">Actual Expenditure</th>
                                    <th style="text-align: right;">Expenditure Diff.</th>
                                    <th style="text-align: right;">Income Expenditure Diff.</th>
                                    <th style="text-align: right;">Over/Under Budget</th>
                                </tr>
                                @if($search_type == 1)
                                    @if(count($programmes) > 0)
                                        @foreach($programmes as $programme)
                                            <tr>
                                                <td>{{ !empty($programme->name) ? $programme->name : '' }}</td>
                                                <td style="text-align: right;" nowrap>{{ !empty($programme->budget_income) ? 'R ' . number_format($programme->budget_income, 2) : '' }}</td>
                                                <td style="text-align: right;" nowrap>{{ ($programme->income) ? 'R ' . number_format($programme->income->sum('amount'), 2) : '' }}</td>
                                                <td style="text-align: right;" nowrap>{{ 'R ' . number_format(($programme->budget_income - $programme->income->sum('amount')), 2) }}</td>
                                                <td style="text-align: right;" nowrap>{{ !empty($programme->budget_expenditure) ? 'R ' . number_format($programme->budget_expenditure, 2) : '' }}</td>
                                                <td style="text-align: right;" nowrap>{{ ($programme->expenditure) ? 'R ' . number_format($programme->expenditure->sum('amount'), 2) : '' }}</td>
                                                <td style="text-align: right;" nowrap>{{ 'R ' . number_format(($programme->budget_expenditure - $programme->expenditure->sum('amount')), 2) }}</td>
                                                <td style="text-align: right;" nowrap>{{ 'R ' . number_format($diff = ($programme->income->sum('amount') - $programme->expenditure->sum('amount')), 2) }}</td>
                                                <td style="text-align: right;">
                                                    @if($diff > 0)
                                                        <span class="label label-success">under budget</span>
                                                    @elseif($diff == 0)
                                                        <span class="label label-warning">on budget</span>
                                                    @elseif($diff < 0)
                                                        <span class="label label-danger">over budget</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @elseif($search_type == 2)
                                    @if(count($projects) > 0)
                                        @foreach($projects as $project)
                                            <tr>
                                                <td>{{ ($project->programme) ? $project->programme->name : '' }}</td>
                                                <td>{{ !empty($project->name) ? $project->name : '' }}</td>
                                                <td style="text-align: right;" nowrap>{{ !empty($project->budget_income) ? 'R ' . number_format($project->budget_income, 2) : '' }}</td>
                                                <td style="text-align: right;" nowrap>{{ ($project->income) ? 'R ' . number_format($project->income->sum('amount'), 2) : '' }}</td>
                                                <td style="text-align: right;" nowrap>{{ 'R ' . number_format(($project->budget_income - $project->income->sum('amount')), 2) }}</td>
                                                <td style="text-align: right;" nowrap>{{ !empty($project->budget_expenditure) ? 'R ' . number_format($project->budget_expenditure, 2) : '' }}</td>
                                                <td style="text-align: right;" nowrap>{{ ($project->expenditure) ? 'R ' . number_format($project->expenditure->sum('amount'), 2) : '' }}</td>
                                                <td style="text-align: right;" nowrap>{{ 'R ' . number_format(($project->budget_expenditure - $project->expenditure->sum('amount')), 2) }}</td>
                                                <td style="text-align: right;" nowrap>{{ 'R ' . number_format($diff = ($project->income->sum('amount') - $project->expenditure->sum('amount')), 2) }}</td>
                                                <td style="text-align: right;">
                                                    @if($diff > 0)
                                                        <span class="label label-success">under budget</span>
                                                    @elseif($diff == 0)
                                                        <span class="label label-warning">on budget</span>
                                                    @elseif($diff < 0)
                                                        <span class="label label-danger">over budget</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @elseif($search_type == 3)
                                    @if(count($activities) > 0)
                                        @foreach($activities as $activity)
                                            <tr>
                                                <td>{{ ($activity->project && $activity->project->programme) ? $activity->project->programme->name : '' }}</td>
                                                <td>{{ ($activity->project) ? $activity->project->name : '' }}</td>
                                                <td>{{ !empty($activity->name) ? $activity->name : '' }}</td>
                                                <td style="text-align: right;" nowrap>{{ !empty($activity->budget_income) ? 'R ' . number_format($activity->budget_income, 2) : '' }}</td>
                                                <td style="text-align: right;" nowrap>{{ ($activity->income) ? 'R ' . number_format($activity->income->sum('amount'), 2) : '' }}</td>
                                                <td style="text-align: right;" nowrap>{{ 'R ' . number_format(($activity->budget_income - $activity->income->sum('amount')), 2) }}</td>
                                                <td style="text-align: right;" nowrap>{{ !empty($activity->budget_expenditure) ? 'R ' . number_format($activity->budget_expenditure, 2) : '' }}</td>
                                                <td style="text-align: right;" nowrap>{{ ($activity->expenditure) ? 'R ' . number_format($activity->expenditure->sum('amount'), 2) : '' }}</td>
                                                <td style="text-align: right;" nowrap>{{ 'R ' . number_format(($activity->budget_expenditure - $activity->expenditure->sum('amount')), 2) }}</td>
                                                <td style="text-align: right;" nowrap>{{ 'R ' . number_format($diff = ($activity->income->sum('amount') - $activity->expenditure->sum('amount')), 2) }}</td>
                                                <td style="text-align: right;">
                                                    @if($diff > 0)
                                                        <span class="label label-success">under budget</span>
                                                    @elseif($diff == 0)
                                                        <span class="label label-warning">on budget</span>
                                                    @elseif($diff < 0)
                                                        <span class="label label-danger">over budget</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @endif
                            </table>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="button" class="btn btn-default pull-left" id="back"><i class="fa fa-arrow-left"></i> Back</button>
                        <button type="submit" class="btn btn-primary pull-right" id="print_report"><i
                                    class="fa fa-print"></i> Print Report
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('page_script')
    <script type="text/javascript">
        $(function () {
            //Cancel button click event
            $('#back').click(function () {
                location.href = "/reports/finance";
            });

            //Change form action
            var reportType = parseInt({{ $search_type }});
            changeAction(reportType);
        });
        //function to change form action
        function changeAction(reportType) {
            if (reportType == 1) { //Programme
                $('#report_print_form').attr('action', '/reports/programme/finance/print/1');
            }
            else if (reportType == 2) { //Project
                $('#report_print_form').attr('action', '/reports/project/finance/print/1');
            }
            else if (reportType == 3) { //Activity
                $('#report_print_form').attr('action', '/reports/activity/finance/print/1');
            }
            return reportType;
        }
    </script>
@endsection