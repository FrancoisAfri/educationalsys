<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Group Learner List Printed By {{ $user->person->first_name.' '. $user->person->surname }}</title>
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
                    <img height="60" src="{{ $company_logo }}" alt="logo">
                    <small class="pull-right">Date: {{$date}}</small>
                </h2>
            </div>
            <!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row">
            <div class="col-sm-12 text-center">
                <h3>Group Learner Search Result</h3>
                <br>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
        <div class="row">
            <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
            <div class="panel box box-primary">
                <div class="box-body">
                    <table class="table table-striped">
                        <tr>
                            <th class="text-center">#</th>
                            <th>School</th>
                            <th>School Tel</th>
                            <th>School Email</th>
                            <th>School Address</th>
                            <th>Date Attended</th>
                        </tr>
                        @if(count($groups) > 0)
                            @foreach($groups as $group)
                                <tr>
                                    <td style="width: 2px;" class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ !empty($group->name)  ? $group->name  : '' }}</td>
                                    <td>{{ !empty($group->phone_number) ? $group->phone_number : '' }}</td>
                                    <td>{{ !empty($group->email) ? $group->email : '' }}</td>
                                    <td>{{ !empty($group->phys_address) ? $group->phys_address : '' }}</td>
                                    <td>{{ !empty($group->date_attended) ? date('Y M d', $group->date_attended) : '' }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </table>
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