<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Finance Report Printed By {{ $user->person->first_name.' '. $user->person->surname }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="/bower_components/AdminLTE/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
   -->
    <link rel="stylesheet" href="/bower_components/AdminLTE/dist/css/AdminLTE.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body onload="window.print();">
<div class="wrapper">
    <!-- Main content -->
    <section class="invoice">
        <!-- title row -->
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    <img width="196" height="60" src="{{ $company_logo }}" alt="logo">
                    <small class="pull-right">Date: {{$date}}</small>
                </h2>
            </div>
            <!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">
            <div class="col-sm-8 invoice-col">
                <address>
                    <strong>{{ $company_name }}</strong><br>
                    P O BOX 6377<br>
                    SECUNDA<br>
                    2302<br>
                </address>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
        <div class="row">
            <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
            <div class="panel box box-success">
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
            </div>

        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>