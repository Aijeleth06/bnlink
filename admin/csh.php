<?php 
    include('php-includes/check-login.php');
    include('php-includes/connect.php');
    $product_amount = 20;
?>
<?php 
    if(isset($_POST['send'])){
        $userid = mysqli_real_escape_string($con,$_POST['ema']);
        $amount = mysqli_real_escape_string($con,$_POST['amo']);
        $bankn = mysqli_real_escape_string($con,$_POST['ban']);
        $bankadd = mysqli_real_escape_string($con,$_POST['add']);
        $btcadd = mysqli_real_escape_string($con,$_POST['abt']);

        $id = mysqli_real_escape_string($con,$_POST['id']);
        //updating pin request status
        mysqli_query($con,"UPDATE payrequest set status ='paid',paidon=NOW() WHERE id = '$id' limit 1");
        $tamount = $amount-($amount*.10);
        if($bankn!='' && $bankadd!=''){
        $msg = "You have been paid $ ".$tamount." in your ".$bankn." address";
        mysqli_query($con,"INSERT INTO logs(userid,message,date) VALUES('$userid','$msg',now())");
        }else if($btcadd!=''&& $bankn==='' && $bankadd===''){
        $msg = "You have been paid $ ".$tamount." in your Bitcoin Address";
        mysqli_query($con,"INSERT INTO logs(userid,message,date) VALUES('$userid','$msg',now())");
        }
    }
    if(isset($_POST['cancel'])){
        $userid = mysqli_real_escape_string($con,$_POST['ema']);
        $amount = mysqli_real_escape_string($con,$_POST['amo']);
        $id = mysqli_real_escape_string($con,$_POST['id']);
        //updating pin request status
        mysqli_query($con,"UPDATE payrequest set status ='cancelled' WHERE id = '$id' limit 1");

        //echo '<script>alert("Pin sent successfully.");window.location.assign("view-pin-request.php");</script>';
    }
    //Generate Pin
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Withdrawal Request | PesoBit</title>

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
                        <h1 class="page-header"><span class="label label-success" style="font-size: 25px;"><i class="fa fa-money" style="color:#337ab7"></i> Cashout Request</span></h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                    <br><br>
                        <table class="table table-bordered table-striped">
                            <tr>
                                <th>ID</th>
                                <th>Userid</th>
                                <th>Amount</th>
                                <th>Expected</th>
                                <th>BTC Address</th>
                                <th>Bank Name</th>
                                <th>Bank Address</th>
                                <th>Date</th>
                                <th>Send</th>
                                <th>Cancel</th>

                            </tr>
                            <?php 
                                $query=mysqli_query($con,"SELECT * FROM payrequest WHERE status ='processing'");
                                if(mysqli_num_rows($query)>0){
                                    $i=1;
                                    while($row=mysqli_fetch_array($query)){
                                        $id = $row['id'];
                                        $ema = $row['email'];
                                        $amo = $row['amount'];
                                        $exp = $row['expect'];
                                        $abt = $row['btcadd'];
                                        $ban = $row['bnkn'];
                                        $add = $row['address'];
                                        $dat = $row['paydate'];
                            ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo $ema; ?></td>
                                    <td><?php echo $amo; ?></td>
                                    <td><?php echo $exp; ?></td>
                                    <td><?php echo $abt; ?></td>
                                    <td><?php echo $ban; ?></td>
                                    <td><?php echo $add; ?></td>
                                    <td><?php echo $dat; ?></td>
                                <form method="POST">
                                    <input type="hidden" name="ema" value="<?php echo $ema; ?>">
                                    <input type="hidden" name="amo" value="<?php echo $amo; ?>">
                                    <input type="hidden" name="add" value="<?php echo $add; ?>">
                                    <input type="hidden" name="ban" value="<?php echo $ban; ?>">
                                    <input type="hidden" name="abt" value="<?php echo $abt; ?>">
                                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                                    <td><input type="submit" name="send" value="Send" class="btn btn-primary"></td>
                                    <td><input type="submit" name="cancel" value="Cancel" class="btn btn-danger"></td>
                                </form>
                                </tr>
                                <?php
                                    }
                                }else{
                                    ?>
                                    <tr>
                                        <td colspan="6" align"center">No Cash-out Request</td>
                                    </tr>
                            <?php
                                }
                            ?>
                        </table>
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
