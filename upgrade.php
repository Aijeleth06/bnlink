<?php 
    include('php-includes/connect.php');
    include('php-includes/check-login.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Upgrade | PesoBit</title>

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
        <?php
         include('php-includes/menu.php');
    $userid = $_SESSION['userid'];
if(isset($_POST['submit'])){
    $thisupgrade = mysqli_real_escape_string($con,$_POST['UpgradeType']);
if($thisupgrade == 'BonusPlus'){
    $type_error = "Reward being processed...";
}else{
    if($pa != $thisupgrade){
    switch ($thisupgrade) {
        case 'ElitePackage':
            $myupgrade = "10thouk";
            break;
        
        default:
            $myupgrade = "5thouk";
            break;
    }
    $query = mysqli_query($con,"SELECT * FROM pinlist WHERE userid='$userid' AND PinType='$myupgrade' AND status = 'open'");
    if(mysqli_num_rows($query)>0){
                $query = mysqli_query($con,"update pinlist set status='close' AND PinType='$myupgrade' AND codeuser='$userid' where userid='$userid' AND status='open' AND PinType='$myupgrade' LIMIT 1");
                $query = mysqli_query($con,"update tree set PackageType='$myupgrade' where userid='$userid' LIMIT 1");
                $query = mysqli_query($con,"update income set PackageType='$myupgrade' where userid='$userid' LIMIT 1");
                $msg = "You have upgraded your account into ".$thisupgrade;
                $query = mysqli_query($con,"INSERT INTO logs(userid,message,date) VALUES('$userid','$msg',now())");
                $con->close();
                echo "<script>setTimeout('improve(".$thisid.")', 2000);</script>"
                echo "
  <div class='modal fade' id='myModal' role='dialog'>
    <div class='modal-dialog'>

      <div class='modal-content'>
      <div class='alert alert-success' role='alert'>
        <div class='modal-header'>
          <button type='button' class='close' data-dismiss='modal'>&times;</button>
          <h4 class='modal-title text-center'>Congratulations!</h4>
        </div>
        <div class='modal-body'>
          <p>You have succesfully upgraded your account into ".$thisupgrade."</p>
          <p>Redirecting to homepage in 3... 2.. 1.</>
        </div>
        <div class='modal-footer'>
          <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
        </div>
        </div>
      </div>
      
    </div>
  </div>";
              echo "<script>   
function Redirect() 
{  
window.location='home'; 
} 
setTimeout('Redirect()', 5000);   
</script>";
    }else{$type_error = "You will need to acquire at least one pin of this type";}  
}else{
    $type_error = "Tracking this info...";
}
}

}
         ?>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><span class="label label-info" style="font-size: 25px;"><i class="fa fa-arrow-up" style="color:#337ab7"></i> Upgrade Account</span></h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                <div class="col-xs-6">
                        <div class="alert alert-info">
                            <strong>Reminder:</strong> This will cost you a pin relative to your chosen type of upgrade.
                    </div>
                </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
<form method="POST" class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      <select name="UpgradeType" placeholder="Upgrade Type" required value="" class="form-control">
      <?php 
        switch ($pa) {
            case '5thouk':
                echo "<option value='ElitePackage'>Elite Package</option><br>";
                break;
            
            case '10thouk':
                echo "<option value='BonusPlus'>Receive Bonus(coming soon...)</option>";
                break;
            default:
                echo "<option value='DiamondPackage'>Diamond Package</option>
            <option value='ElitePackage'>Elite Package</option>";
                break;
        }
      ?>
        </select><?php if(isset($type_error)){ ?><span class="text-danger"><?php echo $type_error ?></span><?php } ?><br><br>
      <button type="submit" name="submit" class="btn btn-default pull-right" id="load" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Processing Upgrade"><a>Confirm Upgrade</a></button>
</form>

                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script>$('.btn').on('click', function() {
    var $this = $(this);
  $this.button('loading');
    setTimeout(function() {
       $this.button('reset');
   }, 8000);
});
</script>
<script>
function improve(id) {
  var user = "<?php echo $userid; ?>"
  var x=id;
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("demo").innerHTML = this.responseText;
    }
  };
  window.open("offer?user_id=<?php echo $userpointid; ?>&offer_id="+x,"_blank");
      window.setTimeout(function () {
  xhttp.open("POST", "functioncalling.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("secure=accesstoken&member="+user+"&reference="+x);
    }, 45000)
}
</script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>
    <script>document.getElementById("copyButton").addEventListener("click", function() {
    copyToClipboard(document.getElementById("copyTarget"));
});</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>


<script>
    $(window).load(function()
{
    $('#myModal').modal('show');
});
</script>
</body>

</html>
