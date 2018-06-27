<?php 
    include('php-includes/check-login.php');
    include('php-includes/connect.php');
    $product_amount = 20;
?>
<?php 
    if(isset($_POST['send'])){
        $userid = mysqli_real_escape_string($con,$_POST['userid']);
        $tpins = mysqli_real_escape_string($con,$_POST['pins']);
        $typeo = mysqli_real_escape_string($con,$_POST['typeo']);
        $id = mysqli_real_escape_string($con,$_POST['id']);
        $total = mysqli_real_escape_string($con,$_POST['amount']);
if($typeo === '1thouk'){
        //inserting pin
        $i=1;
        while($i<=$tpins){

                $new_pin = pingenerate();
            
            mysqli_query($con,"INSERT INTO pinlist(userid,pin,PinType,owner) VALUES('$userid','$new_pin','$typeo','$userid')");
            $i++;
        }
        //updating pin request status
        mysqli_query($con,"UPDATE pinrequest set status ='close' WHERE id = '$id' limit 1");
        $msg = "Received ".$tpins." starter pins for $ ".$total.".00";
        mysqli_query($con,"INSERT INTO logs(state,userid,message,date) VALUES('active','$userid','$msg',now())");
        echo '<script>alert("Pin sent successfully.");window.location.assign("view-pin-request.php");</script>';
    }
if($typeo === '5thouk'){
        //inserting pin
        $i=1;
        while($i<=$tpins){

                $new_pin = pingenerate();
            
            mysqli_query($con,"INSERT INTO pinlist(userid,pin,PinType,owner) VALUES('$userid','$new_pin','$typeo','$userid')");
            $i++;
        }
        //updating pin request status
        mysqli_query($con,"UPDATE pinrequest set status ='close' WHERE id = '$id' limit 1");
        $msg = "Received ".$tpins." diamond pins for $ ".$total.".00";
        mysqli_query($con,"INSERT INTO logs(state,userid,message,date) VALUES('active','$userid','$msg',now())");
        echo '<script>alert("Pin sent successfully.");window.location.assign("view-pin-request.php");</script>';
    }
if($typeo === '10thouk'){
        //inserting pin
        $i=1;
        while($i<=$tpins){

                $new_pin = pingenerate();
            
            mysqli_query($con,"INSERT INTO pinlist(userid,pin,PinType,owner) VALUES('$userid','$new_pin','$typeo','$userid')");
            $i++;
        }
        //updating pin request status
        mysqli_query($con,"UPDATE pinrequest set status ='close' WHERE id = '$id' limit 1");
        $msg = "Received ".$tpins." elite pins for $ ".$total.".00";
        mysqli_query($con,"INSERT INTO logs(state,userid,message,date) VALUES('active','$userid','$msg',now())");
        echo '<script>alert("Pin sent successfully.");window.location.assign("view-pin-request.php");</script>';
    }
}

    if(isset($_POST['cancel'])){
        $userid = mysqli_real_escape_string($con,$_POST['userid']);
        $amount = mysqli_real_escape_string($con,$_POST['amount']);
        $id = mysqli_real_escape_string($con,$_POST['id']);
        //updating pin request status
        mysqli_query($con,"UPDATE pinrequest set status ='close' WHERE id = '$id' limit 1");

        //echo '<script>alert("Pin sent successfully.");window.location.assign("view-pin-request.php");</script>';
    }
    //Generate Pin
    function pingenerate(){
        global $con;
        $generated_pin = substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', mt_rand(1,10))),1,10);

        $query = mysqli_query($con, "SELECT * FROM pinlist WHERE pin = '$generated_pin'");
        if(mysqli_num_rows($query)>0){
            pin_generate();
        }else{
            return $generated_pin;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Pin Request | PesoBit</title>

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
                        <h1 class="page-header"><span class="label label-info" style="font-size: 25px;"><i class="fa fa-key" style="color:#337ab7"></i> Pin Requests</span></h1>
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
                                <th>Date</th>
                                <th>Pin Type</th>
                                <th>Hash Code</th>
                                <th>Send</th>
                                <th>Cancel</th>

                            </tr>
                            <?php 
                                $query=mysqli_query($con,"SELECT * FROM pinrequest WHERE status ='open' ORDER BY id DESC");
                                if(mysqli_num_rows($query)>0){
                                    $i=1;
                                    while($row=mysqli_fetch_array($query)){
                                        $id = $row['id'];
                                        $email = $row['email'];
                                        $haa = $row['hash'];
                                        $amount = $row['amount'];
                                        $ptype = $row['PinType'];
                                        $date = $row['Pdate'];
                                        $pins = $row['Pins'];
                            ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo $email; ?></td>
                                    <td><?php echo $amount; ?></td>
                                    <td><?php echo $date; ?></td>
                                    <td><?php 
                                        switch ($ptype) {
                                            case '1thouk':
                                                echo "Starter";
                                                break;
                                            case '5thouk':
                                                echo "Diamond";
                                                break;
                                            case '10thouk':
                                                echo "Elite";
                                                break;
                                            
                                            default:
                                                # code...
                                                break;
                                        }
                                    ?></td>
                                    <td><?php echo $haa; ?></td>
                                <form method="POST">
                                    <input type="hidden" name="userid" value="<?php echo $email; ?>">
                                    <input type="hidden" name="pins" value="<?php echo $pins ?>">
                                    <input type="hidden" name="typeo" value="<?php echo $ptype ?>">
                                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                                    <input type="hidden" name="amount" value="<?php echo $amount; ?>">
                                    <td><input type="submit" name="send" value="Send" class="btn btn-primary"></td>
                                    <td><input type="submit" name="cancel" value="Cancel" class="btn btn-danger"></td>
                                </form>
                                </tr>
                                <?php
                                    }
                                }else{
                                    ?>
                                    <tr>
                                        <td colspan="6" align"center">You have no pin request.</td>
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
