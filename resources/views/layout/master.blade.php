<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Website quản lý luận văn khoa công nghệ thông tin">
    <meta name="author" content="">
    <title>QUẢN LÝ LUẬN VĂN TỐT NGHIỆP</title>
    <link rel="icon" href="upload/mortarboard.png">
    <base href="{{asset('')}}" >
    <!-- Bootstrap Core CSS -->
    <link href="admin_asset/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="admin_asset/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="admin_asset/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="admin_asset/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="css/datatables.min.css">
	<link rel="stylesheet" href="css/css.css">
	
</head>
<body class='color'>
	<div class="container">
		<div class="row">
            <div class="col-md-12 banner">
                <img src="upload/stulogo_01.png" style="float: left;" alt="">
                <img src="upload/fordoan_02.png" style="float: right;" alt="">
            </div>
			
		</div>
        <div class="row">
		  @yield('content')
        </div>
	</div>

	<!-- jQuery -->
    <script src="admin_asset/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="admin_asset/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="admin_asset/bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="admin_asset/dist/js/sb-admin-2.js"></script>

    <!-- DataTables JavaScript -->
    {{-- <script src="admin_asset/bower_components/DataTables/media/js/jquery.dataTables.min.js"></script> --}}
    {{-- <script src="admin_asset/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script> --}}
    <script type="text/javascript" src="js/datatables.min.js"></script>
    @yield('script')
</body>
</html>