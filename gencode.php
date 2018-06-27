<?php 
    include('php-includes/connect.php');
    include('php-includes/check-login.php');
    $error = false;
    $userid = $_SESSION['userid'];
    $ue =mysqli_query($con,"select * from income where userid='$userid'");
    $uer = mysqli_fetch_array($ue);
    $tbal = $uer['total_bal'];
    $uijx = "1thouk";
    $zsdt = "5thouk";
    $xrqq = "10thouk";
?>
<?php
    if(isset($_POST['submit'])){
        $pin = mysqli_real_escape_string($con,$_POST['pins']);
        $qujxq = mysqli_real_escape_string($con,$_POST['typeo']);
    if($qujxq === '1thouk'){
        if (!preg_match("/^[0-9]{1,}$/", $pin)){
            $error = true;
            $pin_error = "Invalid Input";
        }
        if($pin!=''){
        $total = $pin*22;
        if($tbal < 22 or $tbal < $total){
            $error = true;
            $pin_error = "Inssuficient Balance";
        }
        }else{
            $error = true;
            $pin_error = "Enter number of pins";
        }
        if(!$error){
            if(mysqli_query($con,"INSERT INTO pinrequest(email,amount,PinType,hash,Pdate,status) VALUES('" . $userid . "','" . $total . "','" . $qujxq . "','" . "Requested" . "', NOW() + INTERVAL 12 HOUR, '" . "close" . "')")){
            $i=1;
            while($i<=$pin){
            $new_pin = pingenerate();
            mysqli_query($con,"INSERT INTO pinlist(userid,pin,PinType,owner) VALUES('$userid','$new_pin','$qujxq','$userid')");
            mysqli_query($con,"update income set total_bal=total_bal-22 where userid='$userid'");
            $i++;
        }
        $i = $i-1;
        $rwo = mysqli_query($con,"SELECT total_bal FROM income WHERE userid = '$userid'");
        $rw = mysqli_fetch_array($rwo);
        $newtotal = $rw['total_bal'];
        $msg = "You have generated ".$i." Starter pins for a total of $ ".$total.".00";
        $tmsg = "You have $ ".$newtotal.".00 total balance as of ".date('l \t\h\e jS');
        mysqli_query($con,"INSERT INTO logs(userid,message,date) VALUES('$userid','$msg',now())");
        mysqli_query($con,"INSERT INTO logs(userid,message,date) VALUES('$userid','$tmsg',now())");
        $successmsg = "Pins successfuly generated!";
        mysqli_close($con);
    }
        } else {
                    $errormsg = "Invalid Input";
                }
    }if($qujxq === '10thouk'){
        if (!preg_match("/^[0-9]{1,}$/", $pin)){
            $error = true;
            $pin_error = "Invalid Input";
        }
        if($pin!=''){
        $total = $pin*(200+(200*.10));
        if($tbal < 220 or $tbal < $total){
            $error = true;
            $pin_error = "Inssuficient Balance";
        }
        }else{
            $error = true;
            $pin_error = "Enter number of pins";
        }
        if(!$error){
            if(mysqli_query($con,"INSERT INTO pinrequest(email,amount,PinType,hash,Pdate,status) VALUES('" . $userid . "','" . $total . "','" . $qujxq . "','" . "Requested" . "', NOW() + INTERVAL 12 HOUR, '" . "close" . "')")){
            $i=1;
            while($i<=$pin){
            $new_pin = pingenerate();
            mysqli_query($con,"INSERT INTO pinlist(userid,pin,PinType,owner) VALUES('$userid','$new_pin','$qujxq','$userid')");
            mysqli_query($con,"update income set total_bal=total_bal-220 where userid='$userid'");
            $i++;
        }
        $i = $i-1;
        $rwo = mysqli_query($con,"SELECT total_bal FROM income WHERE userid = '$userid'");
        $rw = mysqli_fetch_array($rwo);
        $newtotal = $rw['total_bal'];
        $msg = "You have generated ".$i." Elite pins for a total of $ ".$total.".00";
        $tmsg = "You have $ ".$newtotal.".00 total balance as of ".date('l \t\h\e jS');
        mysqli_query($con,"INSERT INTO logs(userid,message,date) VALUES('$userid','$msg',now())");
        mysqli_query($con,"INSERT INTO logs(userid,message,date) VALUES('$userid','$tmsg',now())");
        $successmsg = "Pins successfuly generated!";
        mysqli_close($con);
    }
    }}}
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

    <title>Generate Pins | PesoBit</title>

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
    .modal-header-success {
    color:#fff;
    padding:9px 15px;
    border-bottom:1px solid #eee;
    background-color: #5cb85c;
    -webkit-border-top-left-radius: 5px;
    -webkit-border-top-right-radius: 5px;
    -moz-border-radius-topleft: 5px;
    -moz-border-radius-topright: 5px;
     border-top-left-radius: 5px;
     border-top-right-radius: 5px;
}
.modal-header-warning {
    color:#fff;
    padding:9px 15px;
    border-bottom:1px solid #eee;
    background-color: orange;
    -webkit-border-top-left-radius: 5px;
    -webkit-border-top-right-radius: 5px;
    -moz-border-radius-topleft: 5px;
    -moz-border-radius-topright: 5px;
     border-top-left-radius: 5px;
     border-top-right-radius: 5px;
}
.modal-header-primary {
    color:#fff;
    padding:9px 15px;
    border-bottom:1px solid #eee;
    background-color: #112299;
    -webkit-border-top-left-radius: 5px;
    -webkit-border-top-right-radius: 5px;
    -moz-border-radius-topleft: 5px;
    -moz-border-radius-topright: 5px;
     border-top-left-radius: 5px;
     border-top-right-radius: 5px;
}

.text-center{
    text-align: center;
    margin: 1.25rem 0;
    border-bottom: 1px solid #dadada;
    padding: 1.25rem 0;
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
                        <h1 class="page-header"><span class="label label-info" style="font-size: 25px;"><i class="fa fa-key" style="color:#337ab7"></i> Generate Pins</span></h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-4">
                    
                        <div class="form-group <?php if($tbal > 19){ echo "has-success";}else{echo "has-error";} ?> has-feedback">
                            <label class="control-label" for="inputGroupSuccess1"></label>
                         <div class="input-group">
                             <span class="input-group-addon">Available Balance</span>
                             <span class="input-group-addon">$
                              <?php echo $le; ?>
                              </span>
                        </div>
                        
                            <!-- <span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span> -->
                             <span id="inputGroupSuccess1Status" class="sr-only">(success)</span>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="alert alert-info">
                            <strong>Reminder:</strong> 10% will be deducted upon generating a pin.
                    </div>
                    </div>
                </div> 
<?php if (isset($successmsg)) { ?>
<div class="alert alert-success">
  <?php echo $successmsg; ?>
</div>
<?php } ?>
<?php if (isset($pin_error)) { ?>
<div class="alert alert-danger">
  <?php echo $pin_error; ?>
</div>
<?php } ?>  

<!--========== First Modal ==========-->
<article class="col-md-3 well" style="margin-left: 1cm; margin-right: 1cm;">
    <h2 class="text-center"><i class="fa fa-circle-o-notch fa-4x" style="color:#5cb85c"></i></h2>
    <h3 class="page-header text-center" style="color:#5cb85c"><i class="fa">STARTER</i><br />
        <small style="color:#5cb85c">$ 20</small>
    </h3><hr> 
    <div class="text-center">
        <a class="btn btn-success" href="#successModal" data-toggle="modal"><i class="fa fa-circle-o-notch"></i> Generate Starter Package</a>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-success">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">[ × ]</button>
                    <h2 class="text-center"><i class="fa fa-circle-o-notch fa-4x"></i></h2><h2 class="text-center">   <i class="fa">Starter Package</i></h2>
                </div>
                <div class="modal-body">
    <form method="POST" class="form-inline" action="<?php echo $_SERVER['PHP_SELF']; ?>">
   <div class="form-group">
    <label class="sr-only" for="exampleInputAmount">Amount (in dollars)</label>
    <div class="input-group">
        <div class="input-group-addon"><a><i class="fa fa-thumb-tack fa-fw"></i></a></div>
      <input type="number" min="1" name="pins" id="input" onkeyup="myFunction()" class="form-control" placeholder="Number of pins">
    </div>
    <input type="hidden" name="typeo" id="xyz" class="form-control" value="<?php echo $uijx; ?>" required>
   </div>
   <div class="col-md-3">
   <div class="form-group">
    <a>Total Amount</a>
          <p id="demo"></p>
  </div></div>
  <div class="row text-danger" id="demo1"></div>
                </div><div class="clearfix"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="submit" class="btn btn-success pull-right" data-next="modal">Generate Pin</button>
                </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</article>

<!--========== Second Modal ==========-->
<article class="col-md-3 well" style="margin-left: 1cm; margin-right: 1cm;">
    <h2 class="text-center"><i class="fa fa-ra fa-4x" style="color:#f0ad4e"></i></h2>
    <h3 class="page-header text-center" style="color:#f0ad4e"><i class="fa">DIAMOND</i><br />
        <small style="color:#f0ad4e">$ 100</small>
    </h3><hr>
    <div class="text-center">
        <a class="btn btn-warning" href="#warningModal" data-toggle="modal"><i class="fa fa-ra"></i> Generate Diamond Package</a>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="warningModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-warning">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h2 class="text-center"><i class="fa fa-ra fa-4x"></i></h2><h2 class="text-center">   <i class="fa">Diamond Package</i></h2>
                </div>
                <div class="modal-body">
                <form method="POST" class="form-inline" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <div class="form-group">
    <label class="sr-only" for="exampleInputAmount">Amount (in dollars)</label>
    <div class="input-group">
        <div class="input-group-addon"><a><i class="fa fa-thumb-tack fa-fw"></i></a></div>
      <input type="number" min="1" name="pins" id="innput" onkeyup="diamond()" class="form-control" placeholder="Number of pins">
    </div>
    <input type="hidden" name="typeo" id="xyyz" class="form-control" value="<?php echo $zsdt; ?>" required>
   </div>
   <div class="col-md-3">
   <div class="form-group">
    <a>Total Amount</a>
          <p id="demmo"></p>
  </div></div>
  <div class="row text-danger" id="demo3"></div>
    </div><div class="clearfix"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" name="submit" class="btn btn-warning pull-right">Generate Pin</button>
                </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</article>

<!--========== Third Modal ==========-->
<article class="col-md-3 well" style="margin-left: 1cm; margin-right: 1cm;">
    <h2 class="text-center"><i class="fa fa-ge fa-4x" style="color:#337ab7"></i></h2>
    <h3 class="page-header text-center" style="color:#337ab7"><i class="fa">ELITE</i><br />
        <small style="color:#337ab7">$ 200</small>
    </h3><hr>
    <div class="text-center">
        <a class="btn btn-primary" href="#primaryModal" data-toggle="modal"><i class="fa fa-ge"></i> Generate Elite Package</a>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="primaryModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> [ × ] </button>
                    <h2 class="text-center"><i class="fa fa-ge fa-4x"></i></h2><h2 class="text-center">   <i class="fa">Elite Package</i></h2>
                </div>
                <div class="modal-body">
                <form method="POST" class="form-inline" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="form-group">
    <label class="sr-only" for="exampleInputAmount">Amount (in dollars)</label>
    <div class="input-group">
        <div class="input-group-addon"><a><i class="fa fa-thumb-tack fa-fw"></i></a></div>
      <input type="number" min="1" name="pins" onkeyup="myFunnction()" class="form-control" id="inputt" placeholder="Number of pins">
    </div>
    <input type='hidden' name='typeo' id="xyzz" class='form-control' value='<?php echo $xrqq; ?>' required>
  </div>
     <div class="col-md-3">
   <div class="form-group">
    <a>Total Amount</a>
          <p id="demoo"></p>
  </div>
  </div>
  <div class="row text-danger" id="demo2"></div>
                </div><div class="clearfix"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" name="submit" class="btn btn-primary pull-right" data-next="modal">Generate Pin</button>
                </div>
                </form>
                

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</article>
<div class="form-group has-success has-feedback"></div><br>
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
function myFunction() {
    var b = <?php echo $le; ?>;
    var x = document.getElementById("input").value;
        var t = x*22;
    document.getElementById("demo").innerHTML = "$ "+t+".00";
    if (t>b) {
        var xzqn = "Please enter an amount within your current balance";
    }else{
        var xzqn = "";
    }
    document.getElementById("demo1").innerHTML = xzqn;
    
}
function myFunnction() {
    var b = <?php echo $le; ?>;
    var x = document.getElementById("inputt").value;
        var t = x*(200+(200*.10));
    document.getElementById("demoo").innerHTML = "$ "+t+".00";
    if (t>b) {
        var xzqn = "Please enter an amount within your current balance";
    }else{
        var xzqn = "";
    }
    document.getElementById("demo2").innerHTML = xzqn;
    
}
function diamond() {
    var b = <?php echo $le; ?>;
    var x = document.getElementById("innput").value;
        var t = x*(100+(100*.10));
    document.getElementById("demmo").innerHTML = "$ "+t+".00";
    if (t>b) {
        var xzqn = "Please enter an amount within your current balance";
    }else{
        var xzqn = "";
    }
    document.getElementById("demo3").innerHTML = xzqn;
    
}
</script>
</body>

</html>
