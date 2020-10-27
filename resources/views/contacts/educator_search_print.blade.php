<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Educators List Printed By {{ $user->person->first_name.' '. $user->person->surname }}</title>
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
                <h3>Educators Search Result</h3>
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
                            <th>Firstname</th>
                            <th>Surname</th>
                            <th>ID Number</th>
                            <th>Gender</th>
                            <th>Cell Number</th>
                            <th>Physical Address</th>
                        </tr>
                        @if(count($educators) > 0)
                            @foreach($educators as $educator)
                                <tr>
                                    <td style="width: 2px;" class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ !empty($educator->first_name) ? $educator->first_name : '' }}</td>
                                    <td>{{ !empty($educator->surname) ? $educator->surname : '' }}</td>
                                    <td>{{ !empty($educator->id_number) ? $educator->id_number : '' }}</td>
                                    <td>{{ !empty($educator->gender) ? 'Male' : 'Female' }}</td>
                                    <td>{{ !empty($educator->cell_number) ? $educator->cell_number : '' }}</td>
                                    <td>{{ !empty($educator->physical_address) ? $educator->physical_address : '' }}</td>
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