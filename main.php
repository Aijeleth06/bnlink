<!DOCTYPE html>
<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6 lt8"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7 lt8"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8 lt8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
    <head>                    
    <?php session_start();
                     if(isset($_SESSION['userid'])){
                        echo '<script>window.location.assign("home");</script>';
                    }
if(isset($_POST['signup'])){
include('php-includes/connect.php');
$capping = 500;
$search = mysqli_real_escape_string($con,$_POST['SponsorID']);
$side='';
$sponsorID = mysqli_real_escape_string($con,$_POST['SponsorID']);
$pin = mysqli_real_escape_string($con,$_POST['ActivationPin']);
$mobile = mysqli_real_escape_string($con,$_POST['MobileNo']);
$address = mysqli_real_escape_string($con,$_POST['Address']);
$fua = mysqli_real_escape_string($con,$_POST['fullname']);
$email = mysqli_real_escape_string($con,$_POST['email']);
$password = mysqli_real_escape_string($con, $_POST['password']);
$cpassword = mysqli_real_escape_string($con, $_POST['cpassword']);
$side = mysqli_real_escape_string($con,$_POST['side']);
$error = false;
$flag = 0;
if($pin!='' && $email!='' && $mobile!='' && $address!='' && $fua!='' &&  $side!=''){
//User filled all the fields.
if(pin_check($pin)){
if(filter_var($sponsorID,FILTER_VALIDATE_EMAIL)){
//Pin is ok
if(email_check($email)){
//Email is ok
if($password != $cpassword) {
       echo '<script>alert("Your password does not match");</script>';
    }else{
        $flag=1;
    }
}
else{
//check email
echo '<script>alert("This user id is already availble.");</script>';
}
}}else{
//check pin
    $error = true;
    $pin_error = "Invalid Pin";
}
}else{
//check all fields are fill
echo '<script>alert("Please fill all the fields.");</script>';
}
if($flag==1){
$next_under = $sponsorID;
$countunder=1;
$u = 1;
while($countunder>0){
$next_under;
$checkunder = tree_data($next_under);
switch ($side) {
    case 'left':
        $leftunder = $checkunder['left'];
        if($leftunder==''){
            $under_userid = $next_under;
            $checkpin = mysqli_query($con,"SELECT PinType FROM pinlist WHERE pin='$pin' limit 1");
            $uer = mysqli_fetch_array($checkpin);
            $PinType = $uer['PinType'];
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
    $dinc = 4;
    $dir = 1;
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
                $dinc = 20;
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
                $dinc = 0;
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
                $dinc = 20;
                $dir = 0;
                break;
            case '10thouk':
                $dinc = 40;
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
                $dinc = 20;
                $dir = 0;
                $dircount = 0;
                break;
            case '10thouk':
                $dinc = 0;
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
}else{
            $next_under = $checkunder['left'];
        }
if($leftunder==''){
    $countunder = 0;
}
        break;
    
    default:
        $rightunder = $checkunder['right'];
        if($rightunder==''){
            $under_userid = $next_under;
            $checkpin = mysqli_query($con,"SELECT PinType FROM pinlist WHERE pin='$pin' limit 1");
            $uer = mysqli_fetch_array($checkpin);
            $PinType = $uer['PinType'];
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
    $dinc = 4;
    $dir = 1;
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
                $dinc = 20;
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
                $dinc = 0;
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
                $dinc = 20;
                $dir = 0;
                break;
            case '10thouk':
                $dinc = 40;
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
                $dinc = 20;
                $dir = 0;
                $dircount = 0;
                break;
            case '10thouk':
                $dinc = 0;
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
}else{
            $next_under = $checkunder['right'];
        }
if($rightunder==''){
    $countunder = 0;
}
        break;
}
$u++;
}//close loop


}
}
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
                    if(isset($_POST['alright'])){
require('php-includes/connect.php');
$email = mysqli_real_escape_string($con,$_POST['email']);
$password = mysqli_real_escape_string($con,$_POST['password']);

$query = mysqli_query($con,"SELECT * FROM user where Email='$email' AND Password='$password'");
    if (mysqli_fetch_array($query)) {
         $_SESSION['userid'] = $email;
         $_SESSION['id'] = session_id();
    $_SESSION['login_type'] = "user";
    $query = mysqli_query($con,"SELECT CheckPoints,rightcount,leftcount FROM tree where userid='$email' LIMIT 1");
    $chk = mysqli_fetch_array($query);
    $chkstate = $chk['CheckPoints'];
    $rcount = $chk['rightcount'];
    $lcount = $chk['leftcount'];
    if($chkstate!='updated'){
        if($lcount>$rcount){
            $points = ($lcount-$rcount)*100;
            $query = mysqli_query($con,"UPDATE tree set leftpointval='$points' where userid='$email' LIMIT 1");
        }
        if($rcount>$lcount){
            $points = ($rcount-$lcount)*100;
            $query = mysqli_query($con,"UPDATE tree set rightpointval='$points' where userid='$email' LIMIT 1");
        }
        $query = mysqli_query($con,"UPDATE tree set CheckPoints='updated' where userid='$email' LIMIT 1");
        mysqli_close($con);
    }
    echo '<script>alert("Login Success.");window.location.assign("home");</script>';
}else{
    $failed = "Email ID or password is wrong.";
}
}
?>
        <meta charset="UTF-8" />
        <!-- <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">  -->
        <title>Login | Pesobit Affiliate</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <meta name="description" content="To bring more people into investing cryptocurrency and become poverty free in the future" />
        <meta name="keywords" content="pesobit, pessobit affiliate, cryptocurrency, invest, earn pesobit, :target, pseudo-class" />
        <meta name="author" content="Codrops" />
        <link rel="shortcut icon" href="../favicon.ico"> 
        <link rel="stylesheet" type="text/css" href="css/demo.css" />
        <link rel="stylesheet" type="text/css" href="css/style.css" />
        <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="css/animate-custom.css" />
        <script src='https://www.google.com/recaptcha/api.js'></script>
    </head>
    <body>
        <div class="container">
            <header>
                <h1>Be Ahead of The Game</h1>
            </header>
            <section>               
                <div id="container_demo" >
                    <!-- hidden anchor to stop jump http://www.css3create.com/Astuce-Empecher-le-scroll-avec-l-utilisation-de-target#wrap4  -->
                    <a class="hiddenanchor" id="toregister"></a>
                    <a class="hiddenanchor" id="tologin"></a>
                    <div id="wrapper">
                        <div id="login" class="animate form">
                            <form method = "POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" autocomplete="on"> 
                                <h1>PesoBit Affiliate<br/>Login</h1> 
                                <p> 
                                    <label for="username" class="uname" data-icon="u" > Your email</label>
                                     <input id="username" name="email" required="required" type="email" value="<?php if(isset($email)){echo $email;} ?>" placeholder="mymail@mail.com"/>
                                     <?php if(isset($failed)){ ?><span class="text-danger"><?php echo $failed; ?></span><?php } ?>
                                </p>
                                <p> 
                                    <label for="password" class="youpasswd" data-icon="p"> Your password </label>
                                    <input id="password" type="password" name="password" required="required" type="password" placeholder="eg. X8df!90EO" /> 
                                </p>
                                <p class="keeplogin"> 
                                    <input type="checkbox" name="loginkeeping" id="loginkeeping" value="loginkeeping" /> 
                                    <label for="loginkeeping">Keep me logged in</label>
                                </p>
                                <p class="login button"> 
                                    <input name="alright" type="submit" value="Login" /> 
                                </p>
                                <!-- <div class="g-recaptcha" data-sitekey="6LcYZCoUAAAAAFgqcxe6XxbxdhgmI6hVjxsAYtYE"></div> -->
                                <p class="change_link">
                                    Not a member yet ?
                                    <!-- <a href="#toregister" class="to_register">Join us</a> -->
                                    <a href="#toregister" class="to_register">Join us</a>
                                </p>
                            </form>
                        </div>
                        <div id="register" class="animate form">
                            <form  method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" autocomplete="on"> 
                                <h1> Sign up </h1> 
<!--                                 <p> 
                                    <label for="usernamesignup" class="uname" data-icon="u">Sponsor ID</label>
                                    <input id="usernamesignup" name="SponsorID" required="required" type="email" placeholder="Sponsor Email" />
                                </p> -->
                                <p> 
                                    <label for="usernamesignup" class="uname" data-icon="e">Sponsor ID</label>
                                    <input id="usernamesignup" name="SponsorID" required="required" type="email" value = "<?php if(isset($sponsorID)) echo $sponsorID; ?>" placeholder="Sponsor Email Address" />
                                </p>
                                <p> 
                                    <label for="usernamesignup" class="uname" data-icon="p">Activation Pin</label>
                                    <input id="usernamesignup" name="ActivationPin" required="required" type="text" value = "<?php if(isset($pin)) echo $pin; ?>" placeholder="Activation Code" />
                                </p>
                                <p> 
                                    <label for="usernamesignup" class="uname" data-icon="u">Full Name</label>
                                    <input id="usernamesignup" name="fullname" required="required" type="text" value = "<?php if(isset($fua)) echo $fua; ?>" placeholder="First Name & Last Name" />
                                </p>
                                <p> 
                                    <label for="usernamesignup" class="uname" data-icon="A">Address</label>
                                    <input id="usernamesignup" name="Address" required="required" type="text" value = "<?php if(isset($address)) echo $address; ?>" placeholder="Your Address" />
                                </p>
                                <p> 
                                    <label for="usernamesignup" class="uname" data-icon="#">Mobile #</label>
                                    <input id="usernamesignup" name="MobileNo" required="required" type="text" value = "<?php if(isset($mobile)) echo $mobile; ?>" placeholder="+58752878954" />
                                </p>
                                <p> 
                                    <label for="usernamesignup" class="uname">Placement Position</label>
                                    <select name="side">
                                        <option value="left">Left</option>
                                        <option value="right">Right</option>
                                    </select>
                                </p>
                                <p> 
                                    <label for="emailsignup" class="youmail" data-icon="e" > Your email (This will serve as your username)</label>
                                    <input id="emailsignup" name="email" required="required" type="email" value = "<?php if(isset($email)) echo $email; ?>" placeholder="mymail@mail.com"/> 
                                </p>
                                <p> 
                                    <label for="passwordsignup" class="youpasswd" data-icon="p">Your password </label>
                                    <input id="passwordsignup" name="password" required="required" type="password" placeholder="eg. X8df!90EO"/>
                                </p>
                                <p> 
                                    <label for="passwordsignup_confirm" class="youpasswd" data-icon="p">Please confirm your password </label>
                                    <input id="passwordsignup_confirm" name="cpassword" required="required" type="password" placeholder="eg. X8df!90EO"/>
                                </p>
                                <p class="signin button"> 
                                    <input type="submit" name="signup" value="Sign up"/> 
                                </p>
                                <p class="change_link">  
                                    Already a member ?
                                    <a href="#tologin" class="to_register"> Go and log in </a>
                                </p>
                            </form>
                        </div>

                        
                    </div>
                </div>  
            </section>
        </div>
    </body>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
</html>