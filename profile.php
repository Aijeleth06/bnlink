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

    <title>My Pesobit Wallet| PesoBit</title>

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
if(isset($_POST['submit'])){
$userid = $_SESSION['userid'];
$error = false;
  $fname = mysqli_real_escape_string($con,$_POST['fullname']);
  $ahome = mysqli_real_escape_string($con,$_POST['homeaddress']);
  $amobile = mysqli_real_escape_string($con,$_POST['mobileno']);
  $apsb = mysqli_real_escape_string($con,$_POST['psb']);
  $abtc = mysqli_real_escape_string($con,$_POST['btc']);
  $abnk = mysqli_real_escape_string($con,$_POST['bank']);
  $bnkna = mysqli_real_escape_string($con,$_POST['Bankname']);

  if(!preg_match("/^[a-zA-Z ]+$/",$fname)) {
    $error = true;
    $fname_error = "Name must contain only alphabets and space";
  }
  if(strlen($apsb) > 34) {
    $error = true;
    $psb_error = "Invalid Pesobit Address";
  } 
  if(strlen($abtc) > 34) {
    $error = true;
    $btc_error = "Invalid Bitcoin Address";
  } 
    if (!$error) {
    if(mysqli_query($con, "UPDATE user set mobile = '$amobile', HomeAddress = '$ahome', account = '$fname', psbaddress = '$apsb', btcaddress = '$abtc', bankacc = '$abnk', bnkn = '$bnkna' WHERE Email = '$userid'")) {
      $successmsg = "Successfully Updated";
    } else {
      $errormsg = "Logging error...";
    }
  }

}
 include('php-includes/menu.php'); 
if(isset($_POST['confirm'])){
$userid = $_SESSION['userid'];
$error = false;
  $acurrent = mysqli_real_escape_string($con,$_POST['cur_pass']);
  $anew = mysqli_real_escape_string($con,$_POST['new_pass']);
  $aconfirm = mysqli_real_escape_string($con,$_POST['cpass']);
    if($acurrent <> $apass) {
    $error = true;
    $curpassword_error = "Current Password is incorrect";
  } 
  if(strlen($anew) < 6) {
    $error = true;
    $password_error = "Password must be minimum of 6 characters";
  } 
  if($anew != $aconfirm) {
    $error = true;
    $cpassword_error = "Password and Confirm Password doesn't match";
  }
    if (!$error) {
    if(mysqli_query($con, "UPDATE user set password = '$anew' WHERE Email = '$userid'")) {
      $successmsg = "Successfully Updated";
    } else {
      $errormsg = "Error 404";
    }
  }

}
?>
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">My Profile</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-8">
<?php if (isset($successmsg)) { ?>
<div class="alert alert-success">
  <?php echo $successmsg; ?>
</div>
<?php } ?>
<?php if (isset($errormsg)) { ?>
<div class="alert alert-danger">
  <?php echo $errormsg; ?>
</div>
<?php } ?>
<form method="POST" class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<a>
  <div class="form-group">
 <label for="inputEmail3" class="col-sm-2 control-label">My Email</label>
    <div class="col-sm-10">
        <label class="col-sm-2 control-label"><?php echo $userid; ?></label>
    </div>
      </div>
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">Full Name</label>
    <div class="col-sm-10">
      <input type="text" name="fullname" class="form-control" id="inputEmail3" placeholder="Your full name" value="<?php echo $aaccount; ?>">
      <span class="text-danger"><?php if (isset($fname_error)) echo $fname_error; ?></span>
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">My Home Address</label>
    <div class="col-sm-10">
      <input type="text" name="homeaddress" class="form-control" placeholder="Your home address" id="inputEmail3" value="<?php echo $homeaddress; ?>">
      <span class="text-danger"><?php if (isset($homeadd_error)) echo $homeadd_error; ?></span>
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">Mobile No.</label>
    <div class="col-sm-10">
      <input type="text" name="mobileno" class="form-control" placeholder="Your mobile number" id="inputEmail3" value="<?php echo $mobile; ?>">
      <span class="text-danger"><?php if (isset($mobile_error)) echo $mobile_error; ?></span>
    </div>
  </div>
  <div class="form-group">
  <label for="inputPassword3" class="col-sm-8 control-label">PesoBit Wallet Address</label>
  </div>
    <div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label"></label>
    <div class="col-sm-10">
      <input type="text" name="psb" class="form-control" placeholder="Enter your PSB Wallet address here" id="inputPassword3" value="<?php echo $pbal; ?>" >
      <span class="text-danger"><?php if (isset($psb_error)) echo $psb_error; ?></span>
    </div>
  </div>
  <div class="form-group">
  <label for="inputPassword3" class="col-sm-8 control-label">Bitcoin Wallet Address</label>
  </div>
    <div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label"></label>
    <div class="col-sm-10">
      <input type="text" name="btc" class="form-control" placeholder="Enter your Bitcoin Wallet address here" id="inputPassword3" value="<?php echo $bitbal; ?>" >
      <span class="text-danger"><?php if (isset($btc_error)) echo $btc_error; ?></span>
    </div>
  </div>
    <div class="form-group">
  <label for="inputPassword3" class="col-sm-8 control-label">Bank Account</label>
  </div>
    <div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label"></label>
    <div class="col-sm-10">
      <input type="text" name="bank" class="form-control" placeholder="Enter your bank account number" id="inputPassword3" value="<?php echo $bbal; ?>" >
      <span class="text-danger"><?php if (isset($bnk_error)) echo $bnk_error; ?></span>
      <br>
      <select name="Bankname" placeholder="Bank" class="form-control">
            <option value="<?php switch ($bnkn) {
              case 'AlliedBank':
                echo 'AlliedBank';
                break;
              case 'AsiaUnitedBank':
                echo 'AsiaUnitedBank';
                break;
              case 'BankofCommerce':
                echo 'BankofCommerce';
                break;
              case 'BDO':
                echo 'BDO';
                break; 
              case 'BPI':
                echo 'BPI';
                break; 
              case 'BPIFamily':
                echo 'BPIFamily';
                break;  
              case 'ChinaBank':
                echo 'ChinaBank';
                break; 
              case 'ChinaBankSavings':
                echo 'ChinaBankSavings';
                break; 
              case 'DevelopmentBankofthePhilippines':
                echo 'DevelopmentBankofthePhilippines';
                break; 
              case 'HSBC':
                echo 'HSBC';
                break; 
              case 'LandBank':
                echo 'LandBank';
                break; 
              case 'MayBank':
                echo 'MayBank';
                break; 
              case 'MetroBank':
                echo 'MetroBank';
                break; 
              case 'PBCom':
                echo 'PBCom';
                break; 
              case 'PlantersBank':
                echo 'AsiaUnitedBank';
                break; 
              case 'PNB':
                echo 'PNB';
                break; 
              case 'PSBank':
                echo 'PSBank';
                break; 
              case 'RCBC':
                echo 'RCBC';
                break; 
              case 'RCBCSavings':
                echo 'RCBCSavings';
                break;
              case 'RobinsonsBank':
                echo 'RobinsonsBank';
                break;
              case 'SecurityBank':
                echo 'SecurityBank';
                break;
              case 'SecurityBankSavings':
                echo 'SecurityBankSavings';
                break;
              case 'StandardChartered':
                echo 'StandardChartered';
                break;
              case 'SterlingBankofAsia':
                echo 'SterlingBankofAsia';
                break;
              case 'UCPB':
                echo 'UCPB';
                break;
              case 'UnionBankofthePhilippines':
                echo 'UnionBankofthePhilippines';
                break;
              case 'WealthBank':
                echo 'WealthBank';
                break;
              default:
                break;
            } ?>"><?php switch ($bnkn) {
              case 'AlliedBank':
                echo 'Allied Bank';
                break;
              case 'AsiaUnitedBank':
                echo 'Asia United Bank';
                break;
              case 'BankofCommerce':
                echo 'Bank of Commerce';
                break;
              case 'BDO':
                echo 'BDO';
                break; 
              case 'BPI':
                echo 'BPI';
                break; 
              case 'BPIFamily':
                echo 'BPIFamily';
                break;  
              case 'ChinaBank':
                echo 'ChinaBank';
                break; 
              case 'ChinaBankSavings':
                echo 'China Bank Savings';
                break; 
              case 'DevelopmentBankofthePhilippines':
                echo 'Development Bank of the Philippines';
                break; 
              case 'HSBC':
                echo 'HSBC';
                break; 
              case 'LandBank':
                echo 'LandBank';
                break; 
              case 'MayBank':
                echo 'MayBank';
                break; 
              case 'MetroBank':
                echo 'MetroBank';
                break; 
              case 'PBCom':
                echo 'PBCom';
                break; 
              case 'PlantersBank':
                echo 'Asia United Bank';
                break; 
              case 'PNB':
                echo 'PNB';
                break; 
              case 'PSBank':
                echo 'PSBank';
                break; 
              case 'RCBC':
                echo 'RCBC';
                break; 
              case 'RCBCSavings':
                echo 'RCBCSavings';
                break;
              case 'RobinsonsBank':
                echo 'Robinsons Bank';
                break;
              case 'SecurityBank':
                echo 'Security Bank';
                break;
              case 'SecurityBankSavings':
                echo 'Security Bank Savings';
                break;
              case 'StandardChartered':
                echo 'Standard Chartered';
                break;
              case 'SterlingBankofAsia':
                echo 'Sterling Bank of Asia';
                break;
              case 'UCPB':
                echo 'UCPB';
                break;
              case 'UnionBankofthePhilippines':
                echo 'Union Bank of the Philippines';
                break;
              case 'WealthBank':
                echo 'WealthBank';
                break;
              default:
                break;
            } ?></option>
            <option value="AlliedBank">Allied Bank</option>
            <option value="AsiaUnitedBank">Asia United Bank</option>
            <option value="BankofCommerce">Bank of Commerce</option>
            <option value="BDO">BDO</option>
            <option value="BPI">BPI</option>
            <option value="BPIFamily">BPI Family</option>
            <option value="ChinaBank">China Bank</option>            
            <option value="ChinaBankSavings">China Bank Savings</option>
            <option value="DevelopmentBankofthePhilippines">Development Bank of the Philippines</option>
            <option value="HSBC">HSBC</option>
            <option value="LandBank">Land Bank</option>
            <option value="MayBank">May Bank</option>
            <option value="MetroBank">Metro Bank</option>
            <option value="PBCom">PBCom</option>
            <option value="PlantersBank">Planters Bank</option>
            <option value="PNB">PNB</option>
            <option value="PSBank">PSBank</option>
            <option value="RCBC">RCBC</option>
            <option value="RCBCSavings">RCBC Savings</option>
            <option value="RobinsonsBank">Robinsons Bank</option>
            <option value="SecurityBank">Security Bank</option>
            <option value="SecurityBankSavings">Security Bank Savings</option>
            <option value="StandardChartered">Standard Chartered</option>
            <option value="SterlingBankofAsia">Sterling Bank of Asia</option>
            <option value="UCPB">UCPB</option>
            <option value="UnionBankofthePhilippines">Union Bank of the Philippines</option>
            <option value="WealthBank">WealthBank</option>
        </select><br>
      <button type="submit" name="submit" class="btn btn-default pull-right"><a>Save changes</a></button>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-10"></div>
</a>
</form>
<span class="text-success"><?php if (isset($successmsg)) { echo $successmsg; } ?></span>
      <span class="text-danger"><?php if (isset($errormsg)) { echo $errormsg; } ?></span>
<form method="POST" class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<a>
  <div class="form-group">
  <label for="inputPassword3" class="col-sm-8 control-label">Change Password</label>
  </div>
    <div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label">Current Password</label>
    <div class="col-sm-10">
      <input type="password" name="cur_pass" placeholder="Enter Current Password" class="form-control" id="inputPassword3" required>
      <span class="text-danger"><?php if (isset($curpassword_error)) echo $curpassword_error; ?></span>
    </div>
  </div>
    <div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label">New Password</label>
    <div class="col-sm-10">
      <input type="password" name="new_pass" placeholder="Enter New Password" class="form-control" id="inputPassword3" required>
      <span class="text-danger"><?php if (isset($password_error)) echo $password_error; ?></span>
    </div>
  </div>
  <div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label">Confirm Password</label>
    <div class="col-sm-10">
      <input type="password" name="cpass" placeholder="Confirm Password" class="form-control" id="inputPassword3" required>
      <span class="text-danger"><?php if (isset($cpassword_error)) echo $cpassword_error; ?></span>
      <br>
      <button type="submit" name="confirm" class="btn btn-default pull-right"><a>Save changes</a></button>
    </div>
  </div>
</a>
</form>
<span class="text-success"><?php if (isset($successmsgs)) { echo $successmsgs; } ?></span>
      <span class="text-danger"><?php if (isset($errormsgs)) { echo $errormsgs; } ?></span>
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
