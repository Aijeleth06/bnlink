<?php 
require('php-includes/connect.php');
include('php-includes/check-login.php');
$error = false;
$email = $_SESSION['userid'];
    $uijx = "1thouk";
    $zsdt = "5thouk";
    $xrqq = "10thouk";
?>
<?php 
if(isset($_POST['submit'])){
        
    $pins = mysqli_real_escape_string($con,$_POST['pins']);
    $haa = mysqli_real_escape_string($con,$_POST['hash']);
    $qujxq = mysqli_real_escape_string($con,$_POST['typeo']);
    $date = date("Y-m-d");
    if($qujxq === '1thouk'){
        if (!preg_match("/^[0-9]{1,}$/", $pins)){
            $error = true;
            $pin_error = "Invalid Input";
        }
        if($pins != ""){
        if($pins > 0){
        if($haa != "" && (strlen($haa) == 64) || (strlen($haa) == 8)){
            $amount = $pins*20;
            $query=mysqli_query($con, "INSERT INTO pinrequest(email,pins,amount,PinType,hash,Pdate) VALUES('" . $email . "','" . $pins . "','" . $amount . "','" . $qujxq . "','" . $haa . "','" . $date . "')");
        if($query){
            $msg = "Requested $".$amount.".00 of starter pins with hash code: ".$haa;
            mysqli_query($con,"INSERT INTO logs(state,userid,message,date) VALUES('active','$email','$msg',now())");
            echo '<script>alert("Pin Request sent successfully");window.location.assign("pin-request.php");</script>';
        }else{
            echo '<script>alert("Please fill all the fields");</script>';
        }
        }else{
            $error = true;
            $pin_error = "Please enter valid Reference ID or Hash code";
        }
        }else{
            $error = true;
            $pin_error = "Please enter exact number of pins";   
        }}else{
            $error = true;
            $pin_error = "Please enter number of pins";
        }
    }
    if($qujxq === '5thouk'){
        if (!preg_match("/^[0-9]{1,}$/", $pins)){
            $error = true;
            $pin_error = "Invalid Input";
        }
        if($pins != ""){
        if($pins > 0){
        if($haa != "" && (strlen($haa) == 64) || (strlen($haa) == 8)){
            $amount = $pins*100;
            $query=mysqli_query($con, "INSERT INTO pinrequest(email,pins,amount,PinType,hash,Pdate) VALUES('" . $email . "','" . $pins . "','" . $amount . "','" . $qujxq . "','" . $haa . "','" . $date . "')");
        if($query){
            $msg = "Requested $".$amount.".00 of diamond pins with hash code: ".$haa;
            mysqli_query($con,"INSERT INTO logs(state,userid,message,date) VALUES('active','$email','$msg',now())");
            echo '<script>alert("Pin Request sent successfully");window.location.assign("pin-request.php");</script>';
        }else{
            echo '<script>alert("Please fill all the fields");</script>';
        }
        }else{
            $error = true;
            $pin_error = "Please enter valid hash code";
        }
        }else{
            $error = true;
            $pin_error = "Please enter exact number of pins";   
        }}else{
            $error = true;
            $pin_error = "Please enter number of pins";
        }
    }
    if($qujxq === '10thouk'){
        if (!preg_match("/^[0-9]{1,}$/", $pins)){
            $error = true;
            $pin_error = "Invalid Input";
        }
        if($pins != ""){
        if($pins > 0){
        if($haa != "" && (strlen($haa) == 64) || (strlen($haa) == 8)){
            $amount = $pins*200;
            $query=mysqli_query($con, "INSERT INTO pinrequest(email,pins,amount,PinType,hash,Pdate) VALUES('" . $email . "','" . $pins . "','" . $amount . "','" . $qujxq . "','" . $haa . "','" . $date . "')");
        if($query){
            $msg = "Requested $".$amount.".00 of elite pins with hash code: ".$haa;
            mysqli_query($con,"INSERT INTO logs(state,userid,message,date) VALUES('active','$email','$msg',now())");
            echo '<script>alert("Pin Request sent successfully");window.location.assign("pin-request.php");</script>';
        }else{
            $error = true;
            $pin_error = "Logging Error...";
        }
        }else{
            $error = true;
            $pin_error = "Please enter valid hash code";
        }
        }else{
            $error = true;
            $pin_error = "Please enter exact number of pins";   
        }}else{
            $error = true;
            $pin_error = "Please enter number of pins";
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
    height: 300px;
    overflow-y: auto;
    font-size: 12px;
}
.ai_R tbody{
    height: 175px;
    overflow-y: auto;
    font-size: 10px;
}
tbody td, thead th {
    width: 25%;
    float: left;
}
body.modal-open {
    overflow: auto;
}

.modal::-webkit-scrollbar {
    width: 0 !important; /*removes the scrollbar but still scrollable*/
    /* reference: http://stackoverflow.com/a/26500272/2259400 */
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
                        <h1 class="page-header"><span class="label label-info" style="font-size: 25px;"><i class="fa fa-thumb-tack" style="color:#337ab7"></i> Pin-Request</span></h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-md-12">
                    <div class="alert alert-info">
                    <span>Send your payment here</span><br>
                        <span><a href="#" class="alert-link">Peso Wallet Address:</a><a  id="copyTarget"> 3K5tVdgJFSBQhFua2QtJt5DxtaJ3z6ciuW</a></span>&nbsp&nbsp&nbsp<button style="font-size: 10px;" type="button" id="copyButton" class="btn btn-outline btn-info">Copy</button><br>
                        <span><a href="#" class="alert-link">Bitcoin Wallet Address:</a><a  id="copyyTarget"> 3HFoE2CTJLKw4tcF7kS99GorYNWW6vzSv8</a></span>&nbsp&nbsp&nbsp<button style="font-size: 10px;" type="button" id="copyyButton" class="btn btn-outline btn-info">Copy</button>
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
        <a class="btn btn-success" href="#successModal" data-toggle="modal"><i class="fa fa-circle-o-notch"></i> Request Starter Package</a>
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
      <input type="number" min="1" name="pins" id="input" onkeyup="myFunction()" class="form-control" placeholder="Number of pins" required>
    </div>
    <div class="input-group">
    <div class="input-group-addon"><a><i class="fa fa-slack fa-fw"></i></a></div>
      <input type="text" name="hash" class="form-control" id="exampleInputAmount" placeholder="Attach Ref. ID / Hash Code" required>
    </div><br>
    <input type="hidden" name="typeo" id="xyz" class="form-control" value="<?php echo $uijx; ?>" required>
   </div>
   <div class="col-md-3">
   <div class="form-group">
    <a>Total Amount</a>
          <p id="demo"></p>
  </div></div>
                </div><div class="clearfix"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="submit" class="btn btn-success pull-right" data-next="modal">Request Pin</button>
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
        <a class="btn btn-warning" href="#warningModal" data-toggle="modal"><i class="fa fa-ra"></i> Request Diamond Package</a>
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
    <div class="input-group">
    <div class="input-group-addon"><a><i class="fa fa-slack fa-fw"></i></a></div>
      <input type="text" name="hash" class="form-control" id="exampleInputAmount" placeholder="Attach Ref. ID / Hash Code" required>
    </div><br>
    <input type="hidden" name="typeo" id="xyyz" class="form-control" value="<?php echo $zsdt; ?>" required>
   </div>
   <div class="col-md-3">
   <div class="form-group">
    <a>Total Amount</a>
          <p id="demmo"></p>
  </div></div>
    </div><div class="clearfix"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" name="submit" class="btn btn-warning pull-right">Request Pin</button>
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
        <a class="btn btn-primary" href="#primaryModal" data-toggle="modal"><i class="fa fa-ge"></i> Request Elite Package</a>
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
        <div class="input-group">
    <div class="input-group-addon"><a><i class="fa fa-slack fa-fw"></i></a></div>
      <input type="text" name="hash" class="form-control" id="exampleInputAmount" placeholder="Attach Ref. ID / Hash Code" required>
    </div><br>
    <input type='hidden' name='typeo' id="xyzz" class='form-control' value='<?php echo $xrqq; ?>' required>
  </div>
     <div class="col-md-3">
   <div class="form-group">
    <a>Total Amount</a>
          <p id="demoo"></p>
  </div>
  </div>
                </div><div class="clearfix"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" name="submit" class="btn btn-primary pull-right" data-next="modal">Request Pin</button>
                </div>
                </form>
                

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</article>
                <div class="row">
                    <div class="col-lg-12">
                    <br><br>
                        <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID No.</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                            <?php 
                            $i=1;
                                $query = mysqli_query($con,"SELECT * FROM pinrequest WHERE email = '$email' ORDER BY id desc");
                                if(mysqli_num_rows($query)>0){
                                    while($row=mysqli_fetch_array($query)){
                                        $amount = $row['amount'];
                                        $date=$row['Pdate'];
                                        $status = $row['status'];
                                    ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo "$ ".$amount." .00"; ?></td>
                                            <td><?php echo $date; ?></td>
                                            <td><?php if($status == 'open'){echo 'processing';}else{echo 'completed';}  ?></td>
                                        </tr>
                                    <?php
                                    }
                                }else{
                            ?>
                                <tr>
                                    <td colspan="4">You have no pin request yet.</td>
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
<script>
function myFunction() {
    var b = <?php echo $le; ?>;
    var x = document.getElementById("input").value;
        var t = x*20;
    document.getElementById("demo").innerHTML = "$ "+t+".00";
}
function myFunnction() {
    var b = <?php echo $le; ?>;
    var x = document.getElementById("inputt").value;
        var t = x*200;
    document.getElementById("demoo").innerHTML = "$ "+t+".00";
}
function diamond() {
    var b = <?php echo $le; ?>;
    var x = document.getElementById("innput").value;
        var t = x*100;
    document.getElementById("demmo").innerHTML = "$ "+t+".00";
}
document.getElementById("copyButton").addEventListener("click", function() {
    copyToClipboard(document.getElementById("copyTarget"));
});
document.getElementById("copyyButton").addEventListener("click", function() {
    copyToClipboard(document.getElementById("copyyTarget"));
});
</script>
</body>

</html>
