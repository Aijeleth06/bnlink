<?php 
    include('php-includes/connect.php');
    include('php-includes/check-login.php');
    $userid = $_SESSION['userid'];
    $mydata = tree_data($userid);
    $myacctype = $mydata['PackageType'];
    $mydirs = $mydata['Directs'];
    $capping = 500;
    $search = $userid;
?>
<?php
//User cliced on join
if(isset($_POST['join_user'])){
$side='';
$sponsorID = mysqli_real_escape_string($con,$_POST['sponsorID']);
$pin = mysqli_real_escape_string($con,$_POST['pin']);
$mobile = mysqli_real_escape_string($con,$_POST['mobile']);
$address = mysqli_real_escape_string($con,$_POST['address']);
$fua = mysqli_real_escape_string($con,$_POST['fullname']);
$email = mysqli_real_escape_string($con,$_POST['email']);
$password = mysqli_real_escape_string($con, $_POST['password']);
$cpassword = mysqli_real_escape_string($con, $_POST['cpassword']);
$under_userid = mysqli_real_escape_string($con,$_POST['under_userid']);
$side = mysqli_real_escape_string($con,$_POST['side']);
$thirdside = mysqli_real_escape_string($con,$_POST['thirdside']);
$flag = 0;
if($pin!='' && $email!='' && $mobile!='' && $address!='' && $fua!='' && $under_userid!='' && $side!=''){
//User filled all the fields.
if(pin_check($pin)){
if(filter_var($sponsorID,FILTER_VALIDATE_EMAIL)){
$sponscheck = mysqli_query($con, "SELECT * FROM user WHERE email = '$sponsorID'");
if(mysqli_num_rows($sponscheck)>0){
//Pin is ok
if(email_check($email)){
//Email is ok
if(!email_check($under_userid)){
//Under userid is ok
if(side_check($under_userid,$side)){
//Side check
if($password != $cpassword) {
       echo '<script>alert("Your password does not match");</script>';
    }else{
        $flag=1;
    }
}
else{
echo '<script>alert("The side you selected is not available.");</script>';
}
}
else{
//check under userid
echo '<script>alert("Invalid Under userid.");</script>';
}
}
else{
//check email
echo '<script>alert("This user id is already availble.");</script>';
}
}else{
    echo '<script>alert("Sponsor does not exist");</script>';
}}else{
echo '<script>alert("Invalid sponsor ID");</script>';
}
}else{
//check pin
echo '<script>alert("Invalid pin");</script>';
}
}
else{
//check all fields are fill
echo '<script>alert("Please fill all the fields.");</script>';
}
//Now we are heree
//It means all the information is correct
//Now we will save all the information
if($flag==1){
    $checkpin = mysqli_query($con,"SELECT PinType FROM pinlist WHERE pin='$pin' limit 1");
    $uer = mysqli_fetch_array($checkpin);
    $PinType = $uer['PinType'];
//Insert into User profile
$query = mysqli_query($con,"insert into user(`email`,`password`,`mobile`,`Homeaddress`,`account`,`under_userid`,`side`) values('$email','$password','$mobile','$address','$fua','$under_userid','$side')");
//Insert into Tree
//So that later on we can view tree.
$query = mysqli_query($con,"insert into tree(`userid`,`SponsorID`,`PackageType`) values('$email','$sponsorID','$PinType')");
//Insert to side
$query = mysqli_query($con,"update tree set `$side`='$email' where userid='$under_userid'");
//Update pin status to close
$query = mysqli_query($con,"update pinlist set status='close', codeuser='$email' where pin='$pin'");
//Inset into Icome
$query = mysqli_query($con,"insert into income (`userid`,`PackageType`) values('$email','$PinType')");

$next_sponsor = $sponsorID;
$dircount=1;
$c = 1;
while($dircount>0){
$next_sponsor;
$checkpackage = tree_data($next_sponsor);
$countdirs = $checkpackage['Directs'];
$packtype = $checkpackage['PackageType'];
if($packtype=='1thouk'){
    if($c==1){
            switch ($PinType) {
            case '1thouk':
                $dinc = 4;
                $dir = 1;
                break;
            case '5thouk':
                $dinc = 10;
                $dir = 1;
                break;
            case '10thouk':
                $dinc = 20;
                $dir = 1;
                break;
            default:
                $dinc = 0;
                $dir = 0;
                break;
            }
}else{
    $dinc = 0;
    $dir = 0;
}
}else if($packtype=='5thouk'){
    if($countdirs >= 2){
            switch ($PinType) {
            case '1thouk':
                $dinc = 4;
                $dir = 0;
                break;
            case '5thouk':
                $dinc = 10;
                $dir = 1;
                break;
            case '10thouk':
                $dinc = 20;
                $dir = 0;
                break;
            default:
                $dinc = 0;
                break;
            }
        }else{
            switch ($PinType) {
            case '1thouk':
                $dinc = 4;
                $dir = 0;
                break;
            case '5thouk':
                $dinc = 10;
                $dir = 1;
                break;
            case '10thouk':
                $dinc = 20;
                $dir = 0;
                break;
            default:
                $dinc = 0;
                $dir = 0;
              
        }
    }
}else if($packtype=='10thouk'){
    if($countdirs >= 2){
            switch ($PinType) {
            case '1thouk':
                $dinc = 4;
                $dir = 0;
                break;
            case '5thouk':
                $dinc = 10;
                $dir = 0;
                break;
            case '10thouk':
                $dinc = 20;
                $dir = 1;
                break;
            default:
                $dinc = 0;
                $dir = 0;
                break;
            }
        }else{
            switch ($PinType) {
            case '1thouk':
                $dinc = 4;
                $dir = 0;
                break;
            case '5thouk':
                $dinc = 10;
                $dir = 0;
                $dircount = 0;
                break;
            case '10thouk':
                $dinc = 20;
                $dir = 1;
                break;
            default:
                $dinc = 0;
                $dir = 0;
              
        }
    }
}

$query = mysqli_query($con,"update income set point_val=point_val+100,day_bal=day_bal+4,total_bal=total_bal+$dinc,directr_bal=directr_bal+'$dinc' where userid='$next_sponsor'");
$query = mysqli_query($con,"update tree set Directs=Directs+'$dir' where userid='$next_sponsor'");
if($countdirs >= 2 || $packtype=='1thouk'){
    $dircount = 0;
}
$next_sponsor = $checkpackage['SponsorID'];
if($next_sponsor==''){
    $dircount = 0;
}
$c++;
}


 $query = mysqli_query($con, "update income set point_val = point_val+100 WHERE userid = '$under_userid' AND userid <> '$search'");
echo mysqli_error($con);
//This is the main part to join a user\
//If you will do any mistake here. Then the site will not work.
//Update count and Income.
$temp_under_userid = $under_userid;
$temp_side_count = $side.'count'; //leftcount or rightcount
$temp_pointside_count = $side.'pointval';
$temp_side = $side;
$total_count=1;
$i=1;
while($total_count>0){
$i;
$q = mysqli_query($con,"select * from tree where userid='$temp_under_userid'");
$r = mysqli_fetch_array($q);
$current_temp_side_count = $r[$temp_side_count]+1;
if($PinType==='1thouk'){
    $current_temp_pointside_count = $r[$temp_pointside_count]+100;
}else if($PinType==='5thouk'){
    $current_temp_pointside_count = $r[$temp_pointside_count]+500;
}else if($PinType==='10thouk'){
    $current_temp_pointside_count = $r[$temp_pointside_count]+1000;
}
$temp_under_userid;
$temp_side_count;
$temp_pointside_count;
mysqli_query($con,"update tree set `$temp_side_count`=$current_temp_side_count, `$temp_pointside_count`=$current_temp_pointside_count where userid='$temp_under_userid'");
//income
if($temp_under_userid!=""){
$income_data = income($temp_under_userid);
//check capping
//$income_data['day_bal'];
if($income_data['day_bal']<$capping){
$tree_data = tree($temp_under_userid);
//check leftplusright
//$tree_data['leftcount'];
//$tree_data['rightcount'];
//$leftplusright;
$temp_pointleft_count = $tree_data['leftpointval'];
$temp_pointright_count = $tree_data['rightpointval'];
$temp_left_count = $tree_data['leftcount'];
$temp_right_count = $tree_data['rightcount'];
//Both left and right side should at least 1 user
if($temp_pointleft_count>0 && $temp_pointright_count>0){
if($temp_side=='left'){
$temp_pointleft_count;
$temp_pointright_count;

if($temp_pointleft_count<=$temp_pointright_count){
$leftpoint = $temp_pointleft_count-$temp_pointleft_count;
$rightpoint = $temp_pointright_count-$temp_pointleft_count;
$inc = $temp_pointleft_count/25;
$new_day_bal = $income_data['day_bal']+4;
$new_binaryt_bal = $income_data['binaryt_bal']+$inc;
$new_point_val = $income_data['point_val']-200;
$new_total_bal = $income_data['total_bal']+$inc;
//update income
$q =mysqli_query($con,"select * from income where userid='$temp_under_userid'");
$r = mysqli_fetch_array($q);
$temp_day_trans = $r['day_trans'];
$qa =mysqli_query($con,"select * from income where userid='$userid'");
$ri = mysqli_fetch_array($qa);
$day_trans = $r['day_trans'];
if($day_trans > 9){
    mysqli_query($con,"update income set day_bal='$new_day_bal', point_val='$new_point_val', day_trans=day_trans+1 where userid='$temp_under_userid' limit 1");
    mysqli_query($con,"update tree set leftpointval='$leftpoint', rightpointval='$rightpoint' where userid='$temp_under_userid'");
}else{
mysqli_query($con,"update income set day_bal='$new_day_bal', binaryt_bal='$new_binaryt_bal', point_val='$new_point_val', total_bal='$new_total_bal', day_trans=day_trans+1 where userid='$temp_under_userid' limit 1");
    mysqli_query($con,"update tree set leftpointval='$leftpoint', rightpointval='$rightpoint' where userid='$temp_under_userid'");
}

}if($temp_pointright_count<=$temp_pointleft_count){
$leftpoint = $temp_pointleft_count-$temp_pointright_count;
$rightpoint = $temp_pointright_count-$temp_pointright_count;
$inc = $temp_pointright_count/25;
$new_day_bal = $income_data['day_bal']+4;
$new_binaryt_bal = $income_data['binaryt_bal']+$inc;
$new_point_val = $income_data['point_val']-200;
$new_total_bal = $income_data['total_bal']+$inc;
$temp_under_userid;
//update income
$q =mysqli_query($con,"select * from income where userid='$temp_under_userid'");
$r = mysqli_fetch_array($q);
$day_trans = $r['day_trans'];
if($day_trans > 9){
    mysqli_query($con,"update income set day_bal='$new_day_bal', point_val='$new_point_val', day_trans=day_trans+1 where userid='$temp_under_userid'");
    mysqli_query($con,"update tree set leftpointval='$leftpoint', rightpointval='$rightpoint' where userid='$temp_under_userid'");
}else{
mysqli_query($con,"update income set day_bal='$new_day_bal', binaryt_bal='$new_binaryt_bal', point_val='$new_point_val', total_bal='$new_total_bal', day_trans=day_trans+1 where userid='$temp_under_userid'");
    mysqli_query($con,"update tree set leftpointval='$leftpoint', rightpointval='$rightpoint' where userid='$temp_under_userid'");
}
}}
else{
if($temp_pointright_count<=$temp_pointleft_count){
$leftpoint = $temp_pointleft_count-$temp_pointright_count;
$rightpoint = $temp_pointright_count-$temp_pointright_count;
$inc = $temp_pointright_count/25;
$new_day_bal = $income_data['day_bal']+4;
$new_binaryt_bal = $income_data['binaryt_bal']+$inc;
$new_point_val = $income_data['point_val']-200;
$new_total_bal = $income_data['total_bal']+$inc;
$temp_under_userid;
//update income
$q =mysqli_query($con,"select * from income where userid='$temp_under_userid'");
$r = mysqli_fetch_array($q);
$day_trans = $r['day_trans'];
if($day_trans > 9){
    mysqli_query($con,"update income set day_bal='$new_day_bal', point_val='$new_point_val', day_trans=day_trans+1 where userid='$temp_under_userid'");
    mysqli_query($con,"update tree set leftpointval='$leftpoint', rightpointval='$rightpoint' where userid='$temp_under_userid'");
}else{
mysqli_query($con,"update income set day_bal='$new_day_bal', binaryt_bal='$new_binaryt_bal', point_val='$new_point_val', total_bal='$new_total_bal', day_trans=day_trans+1 where userid='$temp_under_userid'");
    mysqli_query($con,"update tree set leftpointval='$leftpoint', rightpointval='$rightpoint' where userid='$temp_under_userid'");
}
}if($temp_pointleft_count<=$temp_pointright_count){
$leftpoint = $temp_pointleft_count-$temp_pointleft_count;
$rightpoint = $temp_pointright_count-$temp_pointleft_count;
$inc = $temp_pointleft_count/25;
$new_day_bal = $income_data['day_bal']+4;
$new_binaryt_bal = $income_data['binaryt_bal']+$inc;
$new_point_val = $income_data['point_val']-200;
$new_total_bal = $income_data['total_bal']+$inc;
//update income
$q =mysqli_query($con,"select * from income where userid='$temp_under_userid'");
$r = mysqli_fetch_array($q);
$temp_day_trans = $r['day_trans'];
$qa =mysqli_query($con,"select * from income where userid='$userid'");
$ri = mysqli_fetch_array($qa);
$day_trans = $r['day_trans'];
if($day_trans > 9){
    mysqli_query($con,"update income set day_bal='$new_day_bal', point_val='$new_point_val', day_trans=day_trans+1 where userid='$temp_under_userid' limit 1");
    mysqli_query($con,"update tree set leftpointval='$leftpoint', rightpointval='$rightpoint' where userid='$temp_under_userid'");
}else{
mysqli_query($con,"update income set day_bal='$new_day_bal', binaryt_bal='$new_binaryt_bal', point_val='$new_point_val', total_bal='$new_total_bal', day_trans=day_trans+1 where userid='$temp_under_userid' limit 1");
    mysqli_query($con,"update tree set leftpointval='$leftpoint', rightpointval='$rightpoint' where userid='$temp_under_userid'");
}

}
}
}//Both left and right side should at least 1 user
}
//change under_userid
$next_under_userid = getUnderId($temp_under_userid);
$temp_side = getUnderIdPlace($temp_under_userid);
$temp_side_count = $temp_side.'count';
$temp_pointside_count = $temp_side.'pointval';
$temp_under_userid = $next_under_userid;
$i++;
}
//Chaeck for the last user
if($temp_under_userid==""){
$total_count=0;
}
}//Loop

echo mysqli_error($con);
echo '<script>alert("Success! You are verified affiliate!");</script>';
}
}
?><!--/join user-->
<?php 
//functions
function pin_check($pin){
global $con,$userid;
$query =mysqli_query($con,"select * from pinlist where pin='$pin' and status='open'");
if(mysqli_num_rows($query)>0){
return true;
}
else{
return false;
}
}
function email_check($email){
global $con;
$query =mysqli_query($con,"select * from user where email='$email'");
if(mysqli_num_rows($query)>0){
return false;
}
else{
return true;
}
}
function side_check($email,$side){
global $con;
$query =mysqli_query($con,"select * from tree where userid='$email'");
$result = mysqli_fetch_array($query);
$side_value = $result[$side];
if($side_value==''){
return true;
}
else{
return false;
}
}
function income($userid){
global $con;
$data = array();
$query = mysqli_query($con,"select * from income where userid='$userid'");
$result = mysqli_fetch_array($query);
$data['day_bal'] = $result['day_bal'];
$data['binaryt_bal'] = $result['binaryt_bal'];
$data['point_val'] = $result['point_val'];
/*$data['lpoint_val'] = $result['lpoint_val'];
$data['rpoint_val'] = $result['rpoint_val'];*/
$data['total_bal'] = $result['total_bal'];
return $data;
}
function tree($userid){
global $con;
$data = array();
$query = mysqli_query($con,"select * from tree where userid='$userid'");
$result = mysqli_fetch_array($query);
$data['left'] = $result['left'];
$data['right'] = $result['right'];
$data['leftcount'] = $result['leftcount'];
$data['rightcount'] = $result['rightcount'];
$data['leftpointval'] = $result['leftpointval'];
$data['rightpointval'] = $result['rightpointval'];
return $data;
}
function getUnderId($userid){
global $con;
$query = mysqli_query($con,"select * from user where email='$userid'");
$result = mysqli_fetch_array($query);
return $result['under_userid'];
}
function getUnderIdPlace($userid){
global $con;
$query = mysqli_query($con,"select * from user where email='$userid'");
$result = mysqli_fetch_array($query);
return $result['side'];
}
?>
<?php 
    function tree_data($userid){
        global $con;
        $data = array();
        $query = mysqli_query($con, "SELECT * FROM tree WHERE userid = '$userid'");
        $result = mysqli_fetch_array($query);
        $data['Directs'] = $result['Directs'];
        $data['PackageType'] = $result['PackageType'];
        $data['SponsorID'] = $result['SponsorID'];
        $data['left'] = $result['left'];
        $data['right'] = $result['right'];
        $data['leftcount'] = $result['leftcount'];
        $data['rightcount'] = $result['rightcount'];
        $data['leftpointval'] = $result['leftpointval'];
        $data['rightpointval'] = $result['rightpointval'];
        return $data;
    }
?>
<?php
    if(isset($_GET['search-id'])){
        $search_id = mysqli_real_escape_string($con, $_GET['search-id']);
        if($search_id != ""){
            $query_check = mysqli_query($con, "SELECT * FROM user WHERE email = '$search_id'");
            if(mysqli_num_rows($query_check)>0){
                $search = $search_id;
            }else{
                echo '<script>alert("Access Denied");window.location.assign("tree.php");</script>';
            }
        }else{
            echo '<script>alert("Access Denied");window.location.assign("tree.php");</script>';
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

    <title>Geneology | PesoBit</title>

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
/*Author: Kosmom.ru*/.loading,.loading>td,.loading>th,.nav li.loading.active>a,.pagination li.loading,.pagination>li.active.loading>a,.pager>li.loading>a{
    background-image: linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, rgba(0, 0, 0, 0) 25%, rgba(0, 0, 0, 0) 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, rgba(0, 0, 0, 0) 75%, rgba(0, 0, 0, 0));
    background-size: 40px 40px;
animation: 2s linear 0s normal none infinite progress-bar-stripes;
-webkit-animation: progress-bar-stripes 2s linear infinite;
}
.btn.btn-default.loading,input[type="text"].loading,select.loading,textarea.loading,.well.loading,.list-group-item.loading,.pagination>li.active.loading>a,.pager>li.loading>a{
background-image: linear-gradient(45deg, rgba(235, 235, 235, 0.15) 25%, rgba(0, 0, 0, 0) 25%, rgba(0, 0, 0, 0) 50%, rgba(235, 235, 235, 0.15) 50%, rgba(235, 235, 235, 0.15) 75%, rgba(0, 0, 0, 0) 75%, rgba(0, 0, 0, 0));
}
    .form-control {width:120px;}
.popover {max-width:400px;}
label{
    display:inline-block;
    width:100px;
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
                        <h1 class="page-header"><span class="label label-info" style="font-size: 25px;"><i class="fa fa-sitemap" style="color:#337ab7"></i> Geneology</span><p class="text-center">
                        <?php 
                                $data = tree_data($search);
                                $acctype = $data['PackageType'];
                                $sponsID = $data['SponsorID'];
                                $mydirects = $data['Directs'];
                        if($myacctype === '1thouk'){ ?><br>
                            <span class='btn btn-info loading'>Welcome to your geneology!<br>You might wonder with the changes. <br>Try to click <a href="help">here.</a> See all the details and try to be more strategic in building your own success here.</span></p></h1>
                        <?php } 
                        if($myacctype === '5thouk'){ 
                            switch ($mydirs) {
                                case '0':
                                    echo "<span class='btn btn-primary loading'>Start referring 3 diamond accounts then get your unlimited bonus!<br><a href='help' style='color:white;'>Got some questions? Click here.</a></span></p></h1>";
                                    break;
                                case '1':
                                    echo "<span class='btn btn-info loading'>2 more diamond accounts. You are getting close to your unlimited bonus!<br><a href='help' style='color:white;'>Got some questions? Click here.</a></span></p></h1>";
                                    break;
                                case '2':
                                    echo "<span class='btn btn-warning loading'>1 more diamond account. You are so close to your unlimited bonus!<br><a href='help' style='color:white;'>Got some questions? Click here.</a></span></p></h1>";
                                    break;
                                default:
                                    echo "<span class='btn btn-success loading'>Congratulations! Enjoy your unlimited bonus!<br><a href='help' style='color:white;'>Got some questions? Click here.</a></span></p></h1>";
                                    break;
                            }
                        ?>
                        <?php } 
                        if($myacctype === '10thouk'){ 

                            switch ($mydirs) {
                                case '0':
                                    echo "<span class='btn btn-primary loading'>Start referring 3 elite accounts then get your unlimited bonus!<br>Got some questions?<a href='help' style='color:white;'> Click here.</a></span></p></h1>";
                                    break;
                                case '1':
                                    echo "<span class='btn btn-info loading'>2 more elite accounts. You are getting close to your unlimited bonus!<br>Got some questions?<a href='help' style='color:white;'> Click here.</a></span></p></h1>";
                                    break;
                                case '2':
                                    echo "<span class='btn btn-warning loading'>1 more elite account. You are so close to your unlimited bonus<br>Got some questions?<a href='help' style='color:white;'> Click here.</a></span></p></h1>";
                                    break;
                                default:
                                    echo "<span class='btn btn-success loading'>Congratulations! Enjoy your unlimited bonus!<br>Got some questions?<a href='help' style='color:white;'> Click here.</a></span></p></h1>";
                                    break;
                            }
                        ?>
                        <?php } ?>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                <form class="form-inline pull-left">
                <div class="col-lg-12">
<div class="form-group">
    <div class="input-group">
      <div class="input-group-addon">@</div>
    <input type="text" name="search-id" id="exampleInputAmount" placeholder="Enter User ID" class="form-control" required>
    </div>
  </div>
  <input type="submit" name="search" class="btn btn-info" value = "Search">
  </div>
                </form>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="table" align="center" border="0" style="text-align:center">
                            <tr height="150">
                            <td>
                              <label class="btn btn-outline btn-info">Left Points<br><span class="badge"><?php echo $data['leftpointval']; ?></span></label> 
                            </td>
                                <!-- <td><?php echo $data['leftcount']; ?></td> -->
                                <td colspan="2">
                <?php if($acctype === '1thouk'){ ?>
                                <i class="fa fa-circle-o-notch fa-4x" data-toggle="popover" data-placement="bottom" data-trigger="hover" data-content="<p class='text-center'>Starter Type</p> <p style='font-size:10px;'>Referred By: <?php echo "$sponsID"; ?></p>" data-html="true" style="color:#5cb85c"></i><p><?php echo $search; ?></p>
                <?php } 
                                if($acctype === '5thouk'){ ?>
                                <i class="fa fa-ra fa-4x" data-toggle="popover" data-placement="bottom" data-trigger="hover" data-content="<p class='text-center'>Diamond Type</p> <p style='font-size:10px;'>Referred By: <?php echo "$sponsID"; ?></p>" data-html="true" style="color:#f0ad4e"></i><p><?php echo $search; ?></p>
                <?php } 
                                if($acctype === '10thouk'){ ?>
                                <i class="fa fa-ge fa-4x" data-toggle="popover" data-placement="bottom" data-trigger="hover" data-content="<p class='text-center'>Elite Type <p style='font-size:10px;'>Referred By: <?php echo "$sponsID"; ?></p>" data-html="true" style="color:#337ab7"></i><p><?php echo $search; ?></p>
                <?php } ?>
                                </td>
                                <!-- <td><?php echo $data['rightcount']; ?></td> -->
                            <td>

                              <label class="btn btn-outline btn-info">Right Points<br><span class="badge"><?php echo $data['rightpointval']; ?></span></label>
                                <!-- <?php echo $pointi; ?> -->
                            </td>
                            </tr>
                            <tr height="150">
                            <?php 
                                $first_left_user = $data['left'];
                                $first_right_user = $data['right'];
                                $firstsecdata = tree_data($first_left_user);
                                $firstsecacctype = $firstsecdata['PackageType'];
                                $firstsecsponsID = $firstsecdata['SponsorID'];
                                $secsecdata = tree_data($first_right_user);
                                $secsecacctype = $secsecdata['PackageType'];
                                $secsecsponsID = $secsecdata['SponsorID'];
                            ?>
                            <?php 
                                if($first_left_user != ""){
                            ?>
                                <td colspan="2">
                <?php if($firstsecacctype === '1thouk'){ ?>
                                <a href="tree.php?search-id=<?php echo $first_left_user ?>"><i class="fa fa-circle-o-notch fa-4x" data-toggle="popover" data-placement="bottom" data-trigger="hover" data-content="<p class='text-center'>Starter Type <p style='font-size:10px;'>Referred By: <?php echo "$firstsecsponsID"; ?></p>" data-html="true" style="color:#5cb85c"></i><p><?php echo $first_left_user ?></p></a>
                <?php } if($firstsecacctype === '5thouk'){ ?>
                                <a href="tree.php?search-id=<?php echo $first_left_user ?>"><i class="fa fa-ra fa-4x" data-toggle="popover" data-placement="bottom" data-trigger="hover" data-content="<p class='text-center'>Diamond Type <p style='font-size:10px;'>Referred By: <?php echo "$firstsecsponsID"; ?></p>" data-html="true" style="color:#f0ad4e"></i><p><?php echo $first_left_user ?></p></a>
                <?php } if($firstsecacctype === '10thouk'){ ?>
                                <a href="tree.php?search-id=<?php echo $first_left_user ?>"><i class="fa fa-ge fa-4x" data-toggle="popover" data-placement="bottom" data-trigger="hover" data-content="<p class='text-center'>Elite Type <p style='font-size:10px;'>Referred By: <?php echo "$firstsecsponsID"; ?></p>" data-html="true" style="color:#337ab7"></i><p><?php echo $first_left_user ?></p></a>
                <?php }
                ?>
                                </td>
                                <?php 
                                }else{ 
                                ?>
                                    <td colspan="2">

<ul class="list-unstyled">
    <li><a data-placement="right" data-toggle="popovera" data-title="Add Left Side" data-container="body" type="button" data-html="true" href="#" id="login"><i class="fa fa-user-plus fa-4x" style="color:#337ab7"></i></a></li>
    <div id="popovera-content" class="hide">
<form method="POST" class="form-inline">
<div class="form-group">
<label>Sponsor ID</label>
<input type="email" name="sponsorID" class="form-control" placeholder="Enter Sponsor" value="<?php echo $_SESSION['userid']; ?>" required>
</div>
<div class="form-group">
<label>Pin</label>
<input type="text" name="pin" class="form-control" placeholder="Enter valid pin" required>
</div>
<div class="form-group">
<label>Full Name</label>
<input type="text" name="fullname" class="form-control" placeholder="Enter user's full name" required>
</div>
<div class="form-group">
<label>Mobile</label>
<input type="text" name="mobile" class="form-control" placeholder="Enter mobile number" required>
</div>
<div class="form-group">
<label>Address</label>
<input type="text" name="address" class="form-control"  placeholder="Enter user's address" required>
</div>
<div class="form-group">
<label>Email</label>
<input type="email" name="email" class="form-control"  placeholder="Enter user's valid email" required>
</div>
<div class="form-group">
<label>Password</label>
<input type="password" data-regex="^[^\s]{6,20}$" name="password"  placeholder="Enter user's password" class="form-control" required>
</div>
<div class="form-group">
<label>Confirm Password</label>
<input type="password" name="cpassword" class="form-control" data-match="password"  placeholder="Confirm user's password" data-match-title="Your password and confirmation password do not match" required>
</div>
<div class="form-group">
<input type="hidden" name="under_userid" class="form-control" value="<?php echo $search; ?>" required>
</div>
<div class="form-group">
<input type="hidden" name="side" value="left" />
</div>
<div class="form-group">
<input type="hidden" name="thirdside" value="firstside" />
</div>
<div class="form-group">
<input type="submit" name="join_user" class="btn btn-primary" value="Join">
</div>
</form>
    </div>
</ul>

                                    <p><?php echo $first_left_user ?></p></td>
                                <?php
                                }  
                                ?>
                            <?php 
                                if($first_right_user != ""){
                            ?>
                                <td colspan="2"><a href="tree.php?search-id=<?php echo $first_right_user ?>">
                <?php if($secsecacctype === '1thouk'){ ?>
                                <a href="tree.php?search-id=<?php echo $first_right_user ?>"><i class="fa fa-circle-o-notch fa-4x" data-toggle="popover" data-placement="bottom" data-trigger="hover" data-content="<p class='text-center'>Starter Type <p style='font-size:10px;'>Referred By: <?php echo "$secsecsponsID"; ?></p>" data-html="true" style="color:#5cb85c"></i><p><?php echo $first_right_user ?></p></a>
                <?php } if($secsecacctype === '5thouk'){ ?>
                                <a href="tree.php?search-id=<?php echo $first_right_user ?>"><i class="fa fa-ra fa-4x" data-toggle="popover" data-placement="bottom" data-trigger="hover" data-content="<p class='text-center'>Diamond Type <p style='font-size:10px;'>Referred By: <?php echo "$secsecsponsID"; ?></p>" data-html="true" style="color:#f0ad4e"></i><p><?php echo $first_right_user ?></p></a>
                <?php } if($secsecacctype === '10thouk'){ ?>
                                <a href="tree.php?search-id=<?php echo $first_right_user ?>"><i class="fa fa-ge fa-4x" data-toggle="popover" data-placement="bottom" data-trigger="hover" data-content="<p class='text-center'>Elite Type <p style='font-size:10px;'>Referred By: <?php echo "$secsecsponsID"; ?></p>" data-html="true" style="color:#337ab7"></i><p><?php echo $first_right_user ?></p></a>
                <?php }
                ?>
                                </td>
                                <?php 
                                }else{
                                ?>
                                    <td colspan="2">  
<ul class="list-unstyled">
    <li><a data-placement="left" data-toggle="popoveri" data-title="Add Right Side" data-container="body" type="button" data-html="true" href="#" id="login"><i class="fa fa-user-plus fa-4x" style="color:#337ab7"></i></a></li>
        <div id="popoveri-content" class="hide">
<form method="POST" class="form-inline">
<div class="form-group">
<label>Sponsor ID</label>
<input type="email" name="sponsorID" class="form-control" placeholder="Enter Sponsor" value="<?php echo $_SESSION['userid']; ?>" required>
</div>
<div class="form-group">
<label>Pin</label>
<input type="text" name="pin" class="form-control" placeholder="Enter valid pin" required>
</div>
<div class="form-group">
<label>Full Name</label>
<input type="text" name="fullname" class="form-control" placeholder="Enter user's full name" required>
</div>
<div class="form-group">
<label>Mobile</label>
<input type="text" name="mobile" class="form-control" placeholder="Enter mobile number" required>
</div>
<div class="form-group">
<label>Address</label>
<input type="text" name="address" class="form-control"  placeholder="Enter user's address" required>
</div>
<div class="form-group">
<label>Email</label>
<input type="email" name="email" class="form-control"  placeholder="Enter user's valid email" required>
</div>
<div class="form-group">
<label>Password</label>
<input type="password" data-regex="^[^\s]{6,20}$" name="password"  placeholder="Enter user's password" class="form-control" required>
</div>
<div class="form-group">
<label>Confirm Password</label>
<input type="password" name="cpassword" class="form-control" data-match="password"  placeholder="Confirm user's password" data-match-title="Your password and confirmation password do not match" required>
</div>
<div class="form-group">
<input type="hidden" name="under_userid" class="form-control" value="<?php echo $search; ?>" required>
</div>
<div class="form-group">
<input type="hidden" name="side" value="right" />
</div>
<div class="form-group">
<input type="hidden" name="thirdside" value="secondside" />
</div>
<div class="form-group">
<input type="submit" name="join_user" class="btn btn-primary" value="Join">
</div>
</form>
    </div>
</ul>

  <p><?php echo $first_right_user; ?></p></td>
                                <?php
                                }  
                                ?>
                                
                            </tr>
                            <tr height="150">
                            <?php 
$data_first_left_user = tree_data($first_left_user);
$second_left_user = $data_first_left_user['left'];
$second_right_user = $data_first_left_user['right'];

$datafirthirdacctype = tree_data($second_left_user);
$firthirdacctype = $datafirthirdacctype['PackageType'];
$firthirdsponsID = $datafirthirdacctype['SponsorID'];

$datasecthirdacctype = tree_data($second_right_user);
$secthirdacctype = $datasecthirdacctype['PackageType'];
$secthirdsponsID = $datasecthirdacctype['SponsorID'];

$data_first_right_user = tree_data($first_right_user);
$third_left_user = $data_first_right_user['left'];
$thidr_right_user = $data_first_right_user['right'];

$datathithirdacctype = tree_data($third_left_user);
$thithirdacctype = $datathithirdacctype['PackageType'];
$thithirdsponsID = $datathithirdacctype['SponsorID'];

$datafouthirdacctype = tree_data($thidr_right_user);
$fouthirdacctype = $datafouthirdacctype['PackageType'];
$fouthirdsponsID = $datafouthirdacctype['SponsorID'];
?>
<?php 
if($second_left_user!=""){
?>
<td>
                <?php if($firthirdacctype === '1thouk'){ ?>
                                <a href="tree.php?search-id=<?php echo $second_left_user ?>"><i class="fa fa-circle-o-notch fa-4x" data-toggle="popover" data-placement="bottom" data-trigger="hover" data-content="<p class='text-center'>Starter Type<p style='font-size:10px;'>Referred By: <?php echo "$firthirdsponsID"; ?></p>" data-html="true" style="color:#5cb85c"></i><p><?php echo $second_left_user ?></p></a>
                <?php } if($firthirdacctype === '5thouk'){ ?>
                                <a href="tree.php?search-id=<?php echo $second_left_user ?>"><i class="fa fa-ra fa-4x" data-toggle="popover" data-placement="bottom" data-trigger="hover" data-content="<p class='text-center'>Diamond Type<p style='font-size:10px;'>Referred By: <?php echo "$firthirdsponsID"; ?></p>" data-html="true" style="color:#f0ad4e"></i><p><?php echo $second_left_user ?></p></a>
                <?php } if($firthirdacctype === '10thouk'){ ?>
                                <a href="tree.php?search-id=<?php echo $second_left_user ?>"><i class="fa fa-ge fa-4x" data-toggle="popover" data-placement="bottom" data-trigger="hover" data-content="<p class='text-center'>Elite Type<p style='font-size:10px;'>Referred By: <?php echo "$firthirdsponsID"; ?></p>" data-html="true" style="color:#337ab7"></i><p><?php echo $second_left_user ?></p></a>
                <?php }
                ?>
</td>
<?php 
}
else if($first_left_user != ""){
?>
<td>
<ul class="list-unstyled">
    <li><a data-placement="top" data-toggle="popoverj" data-title="Add Left Side" data-container="body" type="button" data-html="true" href="#" id="login"><i class="fa fa-user-plus fa-4x" style="color:#C0C0C0"></i></a></li>
    <div id="popoverj-content" class="hide">
<form method="POST" class="form-inline">
<div class="form-group">
<label>Sponsor ID</label>
<input type="email" name="sponsorID" class="form-control" placeholder="Enter Sponsor" value="<?php echo $_SESSION['userid']; ?>" required>
</div>
<div class="form-group">
<label>Pin</label>
<input type="text" name="pin" class="form-control" placeholder="Enter valid pin" required>
</div>
<div class="form-group">
<label>Full Name</label>
<input type="text" name="fullname" class="form-control" placeholder="Enter user's full name" required>
</div>
<div class="form-group">
<label>Mobile</label>
<input type="text" name="mobile" class="form-control" placeholder="Enter mobile number" required>
</div>
<div class="form-group">
<label>Address</label>
<input type="text" name="address" class="form-control"  placeholder="Enter user's address" required>
</div>
<div class="form-group">
<label>Email</label>
<input type="email" name="email" class="form-control"  placeholder="Enter user's valid email" required>
</div>
<div class="form-group">
<label>Password</label>
<input type="password" data-regex="^[^\s]{6,20}$" name="password"  placeholder="Enter user's password" class="form-control" required>
</div>
<div class="form-group">
<label>Confirm Password</label>
<input type="password" name="cpassword" class="form-control" data-match="password"  placeholder="Confirm user's password" data-match-title="Your password and confirmation password do not match" required>
</div>
<div class="form-group">
<input type="hidden" name="under_userid" class="form-control" value="<?php echo $first_left_user; ?>" required>
</div>
<div class="form-group">
<input type="hidden" name="side" value="left" />
</div>
<div class="form-group">
<input type="hidden" name="thirdside" value="leftside" />
</div>
<div class="form-group">
<input type="submit" name="join_user" class="btn btn-primary" value="Join">
</div>
</form>
    </div>
</ul>
</td>
<?php    
}else{
?>
    <td><i class="fa fa-user fa-4x" style="color:#C0C0C0"></i></td>
<?php
}
?>
<?php 
if($second_right_user!=""){
?>
<td>
                <?php if($secthirdacctype === '1thouk'){ ?>
                                <a href="tree.php?search-id=<?php echo $second_right_user ?>"><i class="fa fa-circle-o-notch fa-4x" data-toggle="popover" data-placement="bottom" data-trigger="hover" data-content="<p class='text-center'>Starter Type<p style='font-size:10px;'>Referred By: <?php echo "$secthirdsponsID"; ?></p>" data-html="true" style="color:#5cb85c"></i><p><?php echo $second_right_user ?></p></a>
                <?php } if($secthirdacctype === '5thouk'){ ?>
                                <a href="tree.php?search-id=<?php echo $second_right_user ?>"><i class="fa fa-ra fa-4x" data-toggle="popover" data-placement="bottom" data-trigger="hover" data-content="<p class='text-center'>Diamond Type<p style='font-size:10px;'>Referred By: <?php echo "$secthirdsponsID"; ?></p>" data-html="true" style="color:#f0ad4e"></i><p><?php echo $second_right_user ?></p></a>
                <?php } if($secthirdacctype === '10thouk'){ ?>
                                <a href="tree.php?search-id=<?php echo $second_right_user ?>"><i class="fa fa-ge fa-4x" data-toggle="popover" data-placement="bottom" data-trigger="hover" data-content="<p class='text-center'>Elite Type<p style='font-size:10px;'>Referred By: <?php echo "$secthirdsponsID"; ?></p>" data-html="true" style="color:#337ab7"></i><p><?php echo $second_right_user ?></p></a>
                <?php }
                ?>
</td>
<?php 
}
else if($first_left_user != ""){
?>
    <td>
<ul class="list-unstyled">
    <li><a data-placement="top" data-toggle="popovere" data-title="Add Right Side" data-container="body" type="button" data-html="true" href="#" id="login"><i class="fa fa-user-plus fa-4x" style="color:#C0C0C0"></i></a></li>
    <div id="popovere-content" class="hide">
<form method="POST" class="form-inline">
<div class="form-group">
<label>Sponsor ID</label>
<input type="email" name="sponsorID" class="form-control" placeholder="Enter Sponsor" value="<?php echo $_SESSION['userid']; ?>" required>
</div>
<div class="form-group">
<label>Pin</label>
<input type="text" name="pin" class="form-control" placeholder="Enter valid pin" required>
</div>
<div class="form-group">
<label>Full Name</label>
<input type="text" name="fullname" class="form-control" placeholder="Enter user's full name" required>
</div>
<div class="form-group">
<label>Mobile</label>
<input type="text" name="mobile" class="form-control" placeholder="Enter mobile number" required>
</div>
<div class="form-group">
<label>Address</label>
<input type="text" name="address" class="form-control"  placeholder="Enter user's address" required>
</div>
<div class="form-group">
<label>Email</label>
<input type="email" name="email" class="form-control"  placeholder="Enter user's valid email" required>
</div>
<div class="form-group">
<label>Password</label>
<input type="password" data-regex="^[^\s]{6,20}$" name="password"  placeholder="Enter user's password" class="form-control" required>
</div>
<div class="form-group">
<label>Confirm Password</label>
<input type="password" name="cpassword" class="form-control" data-match="password"  placeholder="Confirm user's password" data-match-title="Your password and confirmation password do not match" required>
</div>
<div class="form-group">
<input type="hidden" name="under_userid" class="form-control" value="<?php echo $first_left_user; ?>" required>
</div>
<div class="form-group">
<input type="hidden" name="side" value="right" />
</div>
<div class="form-group">
<input type="hidden" name="thirdside" value="leftside" />
</div>
<div class="form-group">
<input type="submit" name="join_user" class="btn btn-primary" value="Join">
</div>
</form>
    </div>
</ul>
</td>
<?php    
}else{
?>
    <td><i class="fa fa-user fa-4x" style="color:#C0C0C0"></i></td>
<?php
}
?>
<?php 
if($third_left_user!=""){
?>
<td>
                <?php if($thithirdacctype === '1thouk'){ ?>
                                <a href="tree.php?search-id=<?php echo $third_left_user ?>"><i class="fa fa-circle-o-notch fa-4x" data-toggle="popover" data-placement="bottom" data-trigger="hover" data-content="<p class='text-center'>Starter Type<p style='font-size:10px;'>Referred By: <?php echo $thithirdsponsID; ?></p>" data-html="true" style="color:#5cb85c"></i><p><?php echo $third_left_user ?></p></a>
                <?php } if($thithirdacctype === '5thouk'){ ?>
                                <a href="tree.php?search-id=<?php echo $third_left_user ?>"><i class="fa fa-ra fa-4x" data-toggle="popover" data-placement="bottom" data-trigger="hover" data-content="<p class='text-center'>Diamond Type<p style='font-size:10px;'>Referred By: <?php echo "$thithirdsponsID"; ?></p>" data-html="true" style="color:#f0ad4e"></i><p><?php echo $third_left_user ?></p></a>
                <?php } if($thithirdacctype === '10thouk'){ ?>
                                <a href="tree.php?search-id=<?php echo $third_left_user ?>"><i class="fa fa-ge fa-4x" data-toggle="popover" data-placement="bottom" data-trigger="hover" data-content="<p class='text-center'>Elite Type<p style='font-size:10px;'>Referred By: <?php echo "$thithirdsponsID"; ?></p>" data-html="true" style="color:#337ab7"></i><p><?php echo $third_left_user ?></p></a>
                <?php }
                ?>
</td>
<?php 
}
else if($first_right_user != ""){
?>
    <td>
<ul class="list-unstyled">
    <li><a data-placement="top" data-toggle="popoverl" data-title="Add Left Side" data-container="body" type="button" data-html="true" href="#" id="login"><i class="fa fa-user-plus fa-4x" style="color:#C0C0C0"></i></a></li>
    <div id="popoverl-content" class="hide">
<form method="POST" class="form-inline">
<div class="form-group">
<label>Sponsor ID</label>
<input type="email" name="sponsorID" class="form-control" placeholder="Enter Sponsor" value="<?php echo $_SESSION['userid']; ?>" required>
</div>
<div class="form-group">
<label>Pin</label>
<input type="text" name="pin" class="form-control" placeholder="Enter valid pin" required>
</div>
<div class="form-group">
<label>Full Name</label>
<input type="text" name="fullname" class="form-control" placeholder="Enter user's full name" required>
</div>
<div class="form-group">
<label>Mobile</label>
<input type="text" name="mobile" class="form-control" placeholder="Enter mobile number" required>
</div>
<div class="form-group">
<label>Address</label>
<input type="text" name="address" class="form-control"  placeholder="Enter user's address" required>
</div>
<div class="form-group">
<label>Email</label>
<input type="email" name="email" class="form-control"  placeholder="Enter user's valid email" required>
</div>
<div class="form-group">
<label>Password</label>
<input type="password" data-regex="^[^\s]{6,20}$" name="password"  placeholder="Enter user's password" class="form-control" required>
</div>
<div class="form-group">
<label>Confirm Password</label>
<input type="password" name="cpassword" class="form-control" data-match="password"  placeholder="Confirm user's password" data-match-title="Your password and confirmation password do not match" required>
</div>
<div class="form-group">
<input type="hidden" name="under_userid" class="form-control" value="<?php echo $first_right_user; ?>" required>
</div>
<div class="form-group">
<input type="hidden" name="side" value="left" />
</div>
<div class="form-group">
<input type="hidden" name="thirdside" value="rightside" />
</div>
<div class="form-group">
<input type="submit" name="join_user" class="btn btn-primary" value="Join">
</div>
</form>
    </div>
</ul>
</td>
<?php    
}else{
?>
    <td><i class="fa fa-user fa-4x" style="color:#C0C0C0"></i></td>
<?php
}
?>
<?php 
if($thidr_right_user!=""){
?>
<td>
                <?php if($fouthirdacctype === '1thouk'){ ?>
                                <a href="tree.php?search-id=<?php echo $thidr_right_user ?>"><i class="fa fa-circle-o-notch fa-4x" data-toggle="popover" data-placement="bottom" data-trigger="hover" data-content="<p class='text-center'>Starter Type<p style='font-size:10px;'>Referred By: <?php echo "$fouthirdsponsID"; ?></p>" data-html="true" style="color:#5cb85c"></i><p><?php echo $thidr_right_user ?></p></a>
                <?php } if($fouthirdacctype === '5thouk'){ ?>
                                <a href="tree.php?search-id=<?php echo $thidr_right_user ?>"><i class="fa fa-ra fa-4x" data-toggle="popover" data-placement="bottom" data-trigger="hover" data-content="<p class='text-center'>Diamond Type<p style='font-size:10px;'>Referred By: <?php echo "$fouthirdsponsID"; ?></p>" data-html="true" style="color:#f0ad4e"></i><p><?php echo $thidr_right_user ?></p></a>
                <?php } if($fouthirdacctype === '10thouk'){ ?>
                                <a href="tree.php?search-id=<?php echo $thidr_right_user ?>"><i class="fa fa-ge fa-4x" data-toggle="popover" data-placement="bottom" data-trigger="hover" data-content="<p class='text-center'>Elite Type<p style='font-size:10px;'>Referred By: <?php echo "$fouthirdsponsID"; ?></p>" data-html="true" style="color:#337ab7"></i><p><?php echo $thidr_right_user ?></p></a>
                <?php }
                ?>
</td>
<?php 
}
else if($first_right_user != ""){
?>
    <td>
<ul class="list-unstyled">
    <li><a data-placement="top" data-toggle="popovert" data-title="Add Right Side" data-container="body" type="button" data-html="true" href="#" id="login"><i class="fa fa-user-plus fa-4x" style="color:#C0C0C0"></i></a></li>
    <div id="popovert-content" class="hide">
<form method="POST" class="form-inline">
<div class="form-group">
<label>Sponsor ID</label>
<input type="email" name="sponsorID" class="form-control" placeholder="Enter Sponsor" value="<?php echo $_SESSION['userid']; ?>" required>
</div>
<div class="form-group">
<label>Pin</label>
<input type="text" name="pin" class="form-control" placeholder="Enter valid pin" required>
</div>
<div class="form-group">
<label>Full Name</label>
<input type="text" name="fullname" class="form-control" placeholder="Enter user's full name" required>
</div>
<div class="form-group">
<label>Mobile</label>
<input type="text" name="mobile" class="form-control" placeholder="Enter mobile number" required>
</div>
<div class="form-group">
<label>Address</label>
<input type="text" name="address" class="form-control"  placeholder="Enter user's address" required>
</div>
<div class="form-group">
<label>Email</label>
<input type="email" name="email" class="form-control"  placeholder="Enter user's valid email" required>
</div>
<div class="form-group">
<label>Password</label>
<input type="password" data-regex="^[^\s]{6,20}$" name="password"  placeholder="Enter user's password" class="form-control" required>
</div>
<div class="form-group">
<label>Confirm Password</label>
<input type="password" name="cpassword" class="form-control" data-match="password"  placeholder="Confirm user's password" data-match-title="Your password and confirmation password do not match" required>
</div>
<div class="form-group">
<input type="hidden" name="under_userid" class="form-control" value="<?php echo $first_right_user; ?>" required>
</div>
<div class="form-group">
<input type="hidden" name="side" value="right" />
</div>
<div class="form-group">
<input type="hidden" name="thirdside" value="rightside" />
</div>
<div class="form-group">
<input type="submit" name="join_user" class="btn btn-primary" value="Join">
</div>
</form>
    </div>
</ul>
</td>
<?php    
}else{
?>
    <td><i class="fa fa-user fa-4x" style="color:#C0C0C0"></i></td>
<?php
}
?>
</tr>
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
<script>
    $("[data-toggle=popoveri]").popover({
    html: true, 
    content: function() {
          return $('#popoveri-content').html();
        }
});
    $("[data-toggle=popovera]").popover({
    html: true, 
    content: function() {
          return $('#popovera-content').html();
        }
});
    $("[data-toggle=popoverj]").popover({
    html: true, 
    content: function() {
          return $('#popoverj-content').html();
        }
});
    $("[data-toggle=popovere]").popover({
    html: true, 
    content: function() {
          return $('#popovere-content').html();
        }
});
    $("[data-toggle=popoverl]").popover({
    html: true, 
    content: function() {
          return $('#popoverl-content').html();
        }
});
        $("[data-toggle=popovert]").popover({
    html: true, 
    content: function() {
          return $('#popovert-content').html();
        }
});
</script>
</body>

</html>
