<?php 
    include('php-includes/check-login.php');
    require('php-includes/connect.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Income | PesoBit</title>

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
                        <h1 class="page-header"><span class="label label-info" style="font-size: 25px;"><i class="fa fa-group" style="color:#337ab7"></i> Users Income</span></h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class = "table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>$.N.</th>
                                        <th>User</th>
                                        <th>Direct</th>
                                        <th>Binary</th>
                                        <th>Total</th>
                                        <th class="text-center">Transactions</th>
                                    </tr>
                                <tbody>
                                    <?php 
                                        $query =mysqli_query($con, "SELECT * FROM income WHERE total_bal>0 ORDER BY total_bal DESC");
                                        if(mysqli_num_rows($query) > 0){
                                            $i=1;
                                            while ($row = mysqli_fetch_array($query)) {
                                               $userid = $row['userid'];
                                               $tbal = $row['total_bal'];
                                               $bbal = $row['binaryt_bal'];
                                               $dbal = $row['directr_bal'];
                                               $dtrans = $row['day_trans'];
                                    ?>
                                            <tr>
                                                <td><?php echo $i++; ?></td>
                                                <td><?php echo $userid; ?></td>
                                                <td><?php echo '$ '.$dbal; ?></td>
                                                <td><?php echo '$ '.$bbal; ?></td>
                                                <td><a><?php echo '$ '.$tbal; ?></a></td>
                                                <td class="text-center"><a><?php echo $dtrans; ?></a></td>
                                            </tr>
                                    <?php
                                            }
                                        }else{
                                    ?>
                                            <tr>
                                                <td colspan="5">No User exist</td>
                                            </tr>
                                    <?php
                                        }
                                    ?>
                                </tbody>
                                </thead>
                            </table>
                        </div>
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
