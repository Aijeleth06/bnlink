<?php 
    include('php-includes/connect.php');
    include('php-includes/check-login.php');
    $userid = $_SESSION['userid'];
    $error = false;
if(isset($_POST['send'])){
$ry =mysqli_query($con,"select * FROM income where userid='$userid'");
$lt = mysqli_fetch_array($ry);
$th = $lt['total_bal'];
$sh =mysqli_query($con,"select * FROM user where Email='$userid'");
$ah = mysqli_fetch_array($sh);
$bk = $ah['bankacc'];
$bt = $ah['btcaddress'];
    $aamount = mysqli_real_escape_string($con,$_POST['amount']);
    $aproc = mysqli_real_escape_string($con,$_POST['o2']);
    $bnkno = mysqli_real_escape_string($con,$_POST['bank']);
    $date = date("Y-m-d");
    if($aamount!=''){
        if($aproc!=''){
        if($aamount > 19){
        if($aamount <= $th){
        $expect = $aamount-($aamount*.10);
        if($aproc === $bk){
        mysqli_query($con, "INSERT INTO payrequest(email,bnkn,address,amount,expect,paydate) VALUES('" . $userid . "','" . $bnkno . "','" . $aproc . "','" . $aamount . "','" . $expect . "','" . $date . "')");
        mysqli_query($con,"update income set total_bal=total_bal-'$aamount' where userid='$userid'");
        $newtotal = $th-$aamount;
        $msg = "You have requested $ ".$aamount.".00 for withdrawal using your ".$bnkno;
        $tmsg = "You have $ ".$newtotal.".00 total balance as of ".date('l \t\h\e jS');
        mysqli_query($con,"INSERT INTO logs(userid,message,date) VALUES('$userid','$msg',now())");
        mysqli_query($con,"INSERT INTO logs(userid,message,date) VALUES('$userid','$tmsg',now())");
            echo '<script>alert("Withdrawal Request sent successfully");window.location.assign("cashout.php");</script>';
            mysqli_close($con);
        }else if($aproc === $bt){
            mysqli_query($con, "INSERT INTO payrequest(email,btcadd,amount,expect,paydate) VALUES('" . $userid . "','" . $aproc . "','" . $aamount . "','" . $expect . "','" . $date . "')");
            mysqli_query($con,"update income set total_bal=total_bal-'$aamount' where userid='$userid'");
        $newtotal = $th-$aamount;
        $msg = "You have requested $ ".$aamount.".00 for withdrawal using your Bitcoin Address";
        $tmsg = "You have $ ".$newtotal.".00 total balance as of ".date('l \t\h\e jS');
        mysqli_query($con,"INSERT INTO logs(userid,message,date) VALUES('$userid','$msg',now())");
        mysqli_query($con,"INSERT INTO logs(userid,message,date) VALUES('$userid','$tmsg',now())");
             echo '<script>alert("Withdrawal Request sent successfully");window.location.assign("cashout.php");</script>';
            mysqli_close($con);
        }else{
            $error = true;
            $with_error = "Logging error...";
            mysqli_close($con);
        }
    }else{
        $error = true;
        $with_error = "Insufficient Balance";
        mysqli_close($con);
    }}else{
        $error = true;
        $with_error = "Amount not valid";
        mysqli_close($con);
    }
    }else{
        $error = true;
        $with_error = "Address not valid";
        mysqli_close($con);
    }}else{
        $error = true;
        $with_error = "Please enter amount";
        mysqli_close($con);
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

    <title>Withdraw | PesoBit</title>

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
  table {
        width: 100%;
    }

thead, tbody, tr, td, th { display: block; }
tr:after {
    content: ' ';
    display: block;
    visibility: hidden;
    clear: both;
}
.table{
  font-size: 14px;
}
thead th {
    height: 35px;

    /*text-align: left;*/
}

tbody {
    height: 150px;
    overflow-y: auto;
    font-size: 12px;
}

thead {
    /* fallback */
}


tbody td, thead th {
    width: 25%;
    float: right;
}
.checkbox label:after, 
.radio label:after {
    content: '';
    display: table;
    clear: both;
}

.checkbox .cr,
.radio .cr {
    position: relative;
    display: inline-block;
    border: 1px solid #a9a9a9;
    border-radius: .25em;
    width: 1.3em;
    height: 1.3em;
    float: left;
    margin-right: .5em;
}

.radio .cr {
    border-radius: 50%;
}

.checkbox .cr .cr-icon,
.radio .cr .cr-icon {
    position: absolute;
    font-size: .8em;
    line-height: 0;
    top: 50%;
    left: 20%;
}

.radio .cr .cr-icon {
    margin-left: 0.04em;
}
.checkbox label input[type="checkbox"],
.radio label input[type="radio"] {
    display: none;
}

.checkbox label input[type="checkbox"] + .cr > .cr-icon,
.radio label input[type="radio"] + .cr > .cr-icon {
    transform: scale(3) rotateZ(-20deg);
    opacity: 0;
    transition: all .3s ease-in;
}

.checkbox label input[type="checkbox"]:checked + .cr > .cr-icon,
.radio label input[type="radio"]:checked + .cr > .cr-icon {
    transform: scale(1) rotateZ(0deg);
    opacity: 1;
}

.checkbox label input[type="checkbox"]:disabled + .cr,
.radio label input[type="radio"]:disabled + .cr {
    opacity: .5;
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
                        <h1 class="page-header"></h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
<?php 
  $query =mysqli_query($con,"select * from income where userid='$userid'");
$result = mysqli_fetch_array($query);
$tbal = $result['total_bal'];
?>
<div class="row"> 
<div class="col-lg-6">
<form class="form-inline" method="POST" onkeypress="return event.keyCode != 13;">
<fieldset <?php if(($bbal!='' && $bnkn!='') or ($bitbal!='')){echo " ";}else{echo "disabled";} ?>>
<div class="text-center"><span class="label label-info" style="font-size: 24px;">Withdraw Commission</span></div>

<br>
<?php if ($bbal === '') { ?>
<div class="alert alert-danger">
  Please provide your bank address
</div>
<?php } ?>
<?php if ($bnkn === '') { ?>
<div class="alert alert-danger">
  Please provide your bank name
</div>
<?php } ?>
<?php if ($bitbal === '') { ?>
<div class="alert alert-danger">
  Pelase provide your bitcoin address
</div>
<?php } ?>
<?php if (isset($with_error)) { ?>
<div class="alert alert-danger">
  <?php echo $with_error; ?>
</div>
<?php } ?>
<?php if (isset($with_success)) { ?>
<div class="alert alert-success">
  <?php echo $with_success; ?>
</div>
<?php } ?>
    <div class="col-sm-12">
        <div class="radio <?php if ($bbal === '' or $bnkn === '') { echo 'disabled'; }?>">
          <label>
            <input type="radio" name="o2" id="type" value="<?php echo $bbal; ?>" <?php if ($bbal === '' or $bnkn === '') { echo 'disabled'; }else if($bbal!='' && $bnkn!=''){echo "checked";}?>>
            <span class="cr"><i class="cr-icon glyphicon glyphicon-arrow-right"></i></span>
            <img style="width: 5cm;height: 5cm;" src="img/Bank.png">
          </label>
          <label>
            <input type="radio" name="o2" id="typeo" value="<?php echo $bitbal; ?>" <?php if ($bitbal === '') { echo 'disabled'; }else if($bbal==='' or $bnkn===''){echo "checked";}?>>
            <span class="cr"><i class="cr-icon glyphicon glyphicon-arrow-right"></i></span>
            <img style="width: 5cm;" src="img/Bitcoin.png">
          </label>
        </div>
     <input type="hidden" name="bank" id="bank" class="form-control" value="<?php echo $bnkn; ?>" required>
    </div>
  <div class="form-group pull-right">
    <label class="sr-only" for="exampleInputAmount">Amount (in dollars)</label>
    <div class="input-group">
      <div class="input-group-addon">$</div>
      <input type="number" min="1" class="form-control" name="amount" id="input" placeholder="Amount">
      <div class="input-group-addon">.00</div>
    </div>
    <button type="button" class="btn btn-info" data-toggle="modal" onclick="myFunction()" data-target="#myModal">Send Request</button>
    <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Are you sure you want to proceed?</h4>
        </div>
        <div class="modal-body">
<div class="alert alert-success">
  <strong><p class="text-center">PLEASE CONFIRM TRANSACTION</p></strong>
</div>
        <a>Amount</a>
          <p id="demo"></p>
        <p><span class="text-danger">- 10% fee</span></p>
        <a>Expected Total Amount</a>
          <p id="demo2"></p>
        <a>Type of transmission</a>
          <p id="demo1"></p>
        </div>
        <div class="modal-footer">
          <button type="submit" name="send" class="btn btn-primary pull-right">Confirm</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        </div>
      </div>
      
    </div>

    </div>  
  </div>
  </fieldset>
</form>
</div>
<div class="col-xs-6">
                    <div class="alert alert-info">
                            <strong>For information:</strong> 10% will be deducted upon withdrawal.
                    </div>
                    <div class="alert alert-info">
                            <strong> $ 20 minimum withdrawal</strong>
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
function myFunction() {
    var x = document.getElementById("input").value;
    var t = x-(x*.10);
    if (document.getElementById('type').checked) {
  var y = document.getElementById('type').value;
  var z = document.getElementById('bank').value;
}else if (document.getElementById('typeo').checked){
    var y = document.getElementById('typeo').value;
    var z = "Bitcoin";
}
    document.getElementById("demo").innerHTML = "$ "+x+".00";
    document.getElementById("demo2").innerHTML = "$ "+t;
    document.getElementById("demo1").innerHTML = z+" "+y;
}
</script>

</body>

</html>
