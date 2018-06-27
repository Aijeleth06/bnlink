<?php 
    include('php-includes/connect.php');
    include('php-includes/check-login.php');
    $userid = $_SESSION['userid'];
    $error = false;
    $uijx = "1thouk";
    $zsdt = "5thouk";
    $xrqq = "10thouk";
    if(isset($_POST['transmult'])){

    $pintransmult = mysqli_real_escape_string($con,$_POST['pinsmult']);
    $transtomult = mysqli_real_escape_string($con,$_POST['emailmult']);
    $qujxq = mysqli_real_escape_string($con,$_POST['typeo']);
    if (!preg_match("/^[0-9]{1,}$/", $pintransmult)){
            $error = true;
            $pin_error = "Invalid Input";
        }
        if(!filter_var($transtomult,FILTER_VALIDATE_EMAIL) or $transtomult === '') {
        $error = true;
        $con->close();
        $email_error = "Please Enter Valid Email ID";
    }
    if($transtomult === $userid){
        $error = true;
             $email_error = "You cannot transfer pins to your current account";
    }
    if($pintransmult==='') {
    $error = true;
    $errormsg = "Logging error...";
     }
    if($pintransmult<1) {
    $error = true;
    $errormsg = "Logging error...";
     }
     $result = $con->query("SELECT id FROM user WHERE Email = '$transtomult'");
     if($result->num_rows == 0) {
            $error = true;
             $email_error = "User does not exist";
    }
    $chk = $con->query("SELECT id FROM pinlist WHERE userid = '$userid' AND PinType = '$qujxq' AND status = 'open'");
     if($chk->num_rows < $pintransmult) {
        switch ($qujxq) {
            case '1thouk':
            $error = true;
             $email_error = "Insufficient starter pins";
                break;
            case '5thouk':
            $error = true;
             $email_error = "Insufficient diamond pins";
                break;
            case '10thouk':
            $error = true;
             $email_error = "Insufficient elite pins";
                break;
            default:
                # code...
                break;
        }
        }
    if (!$error) {
    if(mysqli_query($con, "UPDATE pinlist set userid = '$transtomult', forward = '$userid' WHERE userid = '$userid' AND PinType='$qujxq' AND status = 'open' order by id limit ".$pintransmult)) {
        switch ($qujxq) {
            case '1thouk':
                $ptype = "Starter";
                break;
            case '5thouk':
                $ptype = "Diamond";
                break;
            case '10thouk':
                $ptype = "Elite";
                break;
            default:
                # code...
                break;
        }
        $msg = "Transferred ".$pintransmult." ".$ptype. " pins to ".$transtomult;
        $msg1 = "Received ".$pintransmult." ".$ptype." pins from ".$userid;
        mysqli_query($con,"INSERT INTO logs(userid,message,date) VALUES('$userid','$msg',now())");
        mysqli_query($con,"INSERT INTO logs(userid,message,date) VALUES('$transtomult','$msg1',now())");
      $successmsg = "Successfully Transferred";
    $con->close();
    } else {
      $errormsg = "Logging error...";
    }
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

    <title>Pin | PesoBit</title>

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
    <style>
        .input-xs {
  height: 22px;
  padding: 2px 5px;
  font-size: 12px;
  line-height: 1.5; /* If Placeholder of the input is moved up, rem/modify this. */
  border-radius: 3px;
}
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
                        <h1 class="page-header"><span class="label label-info" style="font-size: 25px;"><i class="fa fa-eye" style="color:#337ab7"></i> My Pins</span></h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                                                                    <?php if (isset($successmsg)) { ?>
                                            <div class="alert alert-success"><span class="text-center">
                                              <?php echo $successmsg; ?>
                                            </div></span>
                                            <?php } ?>
                                            <?php if (isset($email_error)) { ?><span class="text-center">
                                            <div class="alert alert-danger">
                                              <?php echo $email_error; ?>
                                            </div></span>
                                            <?php } ?>
                                            <?php if (isset($errormsg)) { ?><span class="text-center">
                                            <div class="alert alert-danger">
                                              <?php echo $errormsg; ?>
                                            </div></span>
                                            <?php } ?>
<div class="alert alert-info">
  <strong>Updated!</strong> You can transfer multiple pins here.
</div>
</div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <i class="fa fa-circle-o-notch fa-2x"> Starter Pins</i>
                        </div>
                        <div class="panel-body">
                        <div class="row">
                        <div class="col-lg-8">
                        <form method="POST" class="form-inline" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <div class="form-group">
                        <div class="input-group">
                        <div class="input-group-addon input-xs"><a><i class="fa fa-thumb-tack fa-fw"></i></a></div>
                        <input type="number" min="1" name="pinsmult" class="form-control input-xs" id="exampleInputAmount" placeholder="pins" required>
                        </div>
                        <div class="input-group">
                        <div class="input-group-addon input-xs"><a><i class="fa fa-at fa-fw"></i></a></div>
                            <input type="hidden" name="pin" value="<?php echo $pin; ?>" required>
                            <input type="email" name="emailmult" class="form-control input-xs" id="exampleInputAmount" placeholder="Enter Email ID" required>
                            <input type="hidden" name="typeo" id="xyz" class="form-control" value="<?php echo $uijx; ?>" required>
                        </div>
                            <button type="submit" name="transmult" class="btn btn-outline btn-primary btn-xs">Transfer Pins</button>
                        </div>
                        </form><br>
                        </div>
                        </div>
                        <table class="table table-bordered table-striped">
                                <tr>
                                    <th><a>No.</a></th>
                                    <th><a>Pin</a></th>
                                </tr>
                                <?php 
                                    $i=1;
                                    $query = mysqli_query($con,"SELECT * FROM pinlist WHERE userid='$userid' AND PinType='1thouk' AND status = 'open'");
                                    if(mysqli_num_rows($query)>0){
                                        while($row=mysqli_fetch_array($query)){
                                            $pin = $row['pin'];
                                ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td id="copysTarget"><?php echo $pin; ?></td>
                                <?php 
                                    if($i==1){
                                ?>
                                        <td><button style="font-size: 10px;" type="button" id="copysButton" class="btn btn-outline btn-info">Copy</button></td>
                                <?php
                                    }
                                ?>
                                    </tr>
                                <?php
                                    $i++;
                                        }
                                    }else{
                                ?>
                                    <tr>
                                        <td colspan="2">You don't have Starter pins yet.</td>
                                    </tr>
                                <?php
                                    }
                                ?>
                            </table>
                        </div>
                        <div class="panel-footer">
                            <!-- Panel Footer -->
                        </div>
                    </div>
                    <!-- /.col-lg-4 -->
                </div>
                <div class="col-lg-4">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <i class="fa fa-ra fa-2x"> Diamond Pins</i>
                        </div>
                        <div class="panel-body">
                        <div class="row">
                        <div class="col-lg-8">
            <form method="POST" class="form-inline" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <div class="form-group">
                        <div class="input-group">
                        <div class="input-group-addon input-xs"><a><i class="fa fa-thumb-tack fa-fw"></i></a></div>
                        <input type="number" min="1" name="pinsmult" class="form-control input-xs" id="exampleInputAmount" placeholder="pins">
                        </div>
                        <div class="input-group">
                        <div class="input-group-addon input-xs"><a><i class="fa fa-at fa-fw"></i></a></div>
                            <input type="hidden" name="pin" value="<?php echo $pin; ?>" required>
                            <input type="email" name="emailmult" class="form-control input-xs" id="exampleInputAmount" placeholder="Enter Email ID" required>
                            <input type="hidden" name="typeo" id="xyz" class="form-control" value="<?php echo $zsdt; ?>" required>
                        </div>
                            <button type="submit" name="transmult" class="btn btn-outline btn-primary btn-xs">Transfer Pins</button>
                        </div>
                        </form><br>
                        </div>
                        </div>
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th><a>No.</a></th>
                                    <th><a>Pin</a></th>
                                </tr>
                                <?php 
                                    $i=1;
                                    $query = mysqli_query($con,"SELECT * FROM pinlist WHERE userid='$userid' AND PinType='5thouk' AND status = 'open'");
                                    if(mysqli_num_rows($query)>0){
                                        while($row=mysqli_fetch_array($query)){
                                            $pin = $row['pin'];
                                ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td id="copydTarget"><?php echo $pin; ?></td>
                                <?php 
                                    if($i==1){
                                ?>
                                        <td><button style="font-size: 10px;" type="button" id="copydButton" class="btn btn-outline btn-info">Copy</button></td>
                                <?php
                                    }
                                ?>
                                    </tr>
                                <?php
                                    $i++;
                                        }
                                    }else{
                                ?>
                                    <tr>
                                        <td colspan="2">You don't have Diamond pins yet.</td>
                                    </tr>
                                <?php
                                    }
                                ?>
                            </table>
                        </div>
                        <div class="panel-footer">
                            <!-- Panel Footer -->
                        </div>
                    </div>
                    <!-- /.col-lg-4 -->
                </div>
                <div class="col-lg-4">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-ge fa-2x"> Elite Pins</i>
                        </div>
                        <div class="panel-body">
                        <div class="row">
                        <div class="col-lg-8">
            <form method="POST" class="form-inline" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <div class="form-group">
                        <div class="input-group">
                        <div class="input-group-addon input-xs"><a><i class="fa fa-thumb-tack fa-fw"></i></a></div>
                        <input type="number" min="1" name="pinsmult" class="form-control input-xs" id="exampleInputAmount" placeholder="pins">
                        </div>
                        <div class="input-group">
                        <div class="input-group-addon input-xs"><a><i class="fa fa-at fa-fw"></i></a></div>
                            <input type="hidden" name="pin" value="<?php echo $pin; ?>" required>
                            <input type="email" name="emailmult" class="form-control input-xs" id="exampleInputAmount" placeholder="Enter Email ID" required>
                            <input type="hidden" name="typeo" id="xyz" class="form-control" value="<?php echo $xrqq; ?>" required>
                        </div>
                            <button type="submit" name="transmult" class="btn btn-outline btn-primary btn-xs">Transfer Pins</button>
                        </div>
                        </form><br>
                        </div>
                        </div>
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th><a>No.</a></th>
                                    <th><a>Pin</a></th>
                                </tr>
                                <?php 
                                    $i=1;
                                    $query = mysqli_query($con,"SELECT * FROM pinlist WHERE userid='$userid'AND PinType='10thouk' AND status = 'open'");
                                    if(mysqli_num_rows($query)>0){
                                        while($row=mysqli_fetch_array($query)){
                                            $pin = $row['pin'];
                                ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td id="copyeTarget"><?php echo $pin; ?></td>
                                <?php 
                                    if($i==1){
                                ?>
                                        <td><button style="font-size: 10px;" type="button" id="copyeButton" class="btn btn-outline btn-info">Copy</button></td>
                                <?php
                                    }
                                ?>
                                    </tr>
                                <?php
                                    $i++;
                                        }
                                    }else{
                                ?>
                                    <tr>
                                        <td colspan="2">You don't have Elite pins yet.</td>
                                    </tr>
                                <?php
                                    }
                                ?>
                            </table>
                        </div>
                        <div class="panel-footer">
                            <!-- Panel Footer -->
                        </div>
                    </div>
                    <!-- /.col-lg-4 -->
                </div>
            </div>
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
    <script>
        document.getElementById("copysButton").addEventListener("click", function() {
    copyToClipboard(document.getElementById("copysTarget"));
});
                document.getElementById("copydButton").addEventListener("click", function() {
    copyToClipboard(document.getElementById("copydTarget"));
});
                document.getElementById("copyeButton").addEventListener("click", function() {
    copyToClipboard(document.getElementById("copyeTarget"));
});
    </script>

</body>

</html>
