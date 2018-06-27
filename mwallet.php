<?php 
    include('php-includes/connect.php');
    include('php-includes/check-login.php');
    $userid = $_SESSION['userid'];
$query =mysqli_query($con,"select * from user where email='".$userid."'");
$result = mysqli_fetch_array($query);
$account = $result['account'];
$homeaddress = $result['HomeAddress'];
$mobile = $result['Mobile'];
$account = $result['account'];
$psbadd = $result['psbaddress'];
$btcadd = $result['btcaddress'];
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>My Commission | PesoBit</title>

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
</style>
</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include('php-includes/menu.php'); ?>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
<span class="label label-info" style="font-size: 25px;">My Commission</span><br><br></h1>

                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
<?php 
  $query =mysqli_query($con,"select * from income where userid='$userid'");
$result = mysqli_fetch_array($query);
$dbal = $result['directr_bal'];
$bbal = $result['binaryt_bal'];
$tbal = $result['total_bal'];
?>
    <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-<?php if($tbal > 0){ echo "green";}else{echo "red";} ?>">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-usd fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">$<?php echo $tbal; ?></div>
                                    <div>Total Bonus</div>
                                </div>
                            </div>
                        </div>
                        <ul class="nav">
                    <li class="dropdown">
                        <a href="#">
                            <div class="panel-footer" style="color:#5cb85c;">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                                    <ul class="dropdown-menu dropdown-messages">
                        <li>
                <div class="panel panel-green">
                        <div class="panel-heading">
                            Total Bonus
                        </div>
                        <div class="panel-body">
                            <p class="text-center"><img src="img/bonus.png" width="60px" height="53px"></p><a style="color: #5cb85c;">You can earn either by direct referral or binary team bonus</a>
                        </div>
                    </div>
                        </li>
                    </ul>
                    <!-- /.dropdown-alerts -->
                </li></ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-<?php if($dbal > 0){ echo "yellow";}else{echo "red";} ?>">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-child fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">$ <?php echo $dbal; ?></div>
                                    <div>Direct Referral Bonus</div>
                                </div>
                            </div>
                        </div>
                        <ul class="nav">
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <div class="panel-footer" style="color:#f0ad4e;">
                                <span class="pull-left" >View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    <ul class="dropdown-menu dropdown-messages">
                        <li>
                <div class="panel panel-yellow">
                        <div class="panel-heading">
                            Direct Referral Bonus
                        </div>
                        <div class="panel-body">
                            <p class="text-center"><img src="img/direct.png" width="60px" height="50px"></p><a style="color: #f0ad4e;">You can earn by joining a user through your sponsor ID. Referral link will be up soon</a>
                        </div>
                    </div>
                        </li>
                    </ul>
                    <!-- /.dropdown-alerts -->
                </li></ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-<?php if($bbal > 0){ echo "primary";}else{echo "red";} ?>">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-users fa-4x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">$ <?php echo $bbal; ?></div>
                                    <div>Binary Team Bonus</div>
                                </div>
                            </div>
                        </div>
                        <ul class="nav">
                    <li class="dropdown">
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                                    <ul class="dropdown-menu dropdown-messages">
                        <li>
                <div class="panel panel-info">
                        <div class="panel-heading">
                            Binary Team Bonus
                        </div>
                        <div class="panel-body">
                            <p class="text-center"><img src="img/binary.png" width="75px" height="53px"></p><a>You can earn through pairing both sides</a>
                        </div>
                    </div>
                        </li>
                    </ul>
                    <!-- /.dropdown-alerts -->
                </li></ul>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>

</body>

</html>
