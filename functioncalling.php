<?php
        include('php-includes/check-login.php');
if (isset($_POST['secure']) && isset($_POST['member']) && isset($_POST['reference'])) {
        require('php-includes/connect.php');
$userem = $_SESSION['userid'];
$userincid=mysqli_real_escape_string($con,$_POST['reference']);
$username=mysqli_real_escape_string($con,$_POST['member']);
$query =mysqli_query($con,"select under_userid from user where email='$userem'");
$trackunder = mysqli_fetch_array($query);
$under_userid = $trackunder['under_userid'];
$query =mysqli_query($con,"select SponsorID,PackageType from tree where userid='$userem'");
$PinType = mysqli_fetch_array($query);
$SponsorID = $PinType['SponsorID'];
$error = false;
if($username != $userem){
	$error = true;
}
if(!$error){
	$query = mysqli_query($con,"SELECT id,userid FROM income WHERE id = '$userincid' AND username = '$username'");
	if(mysqli_num_rows($query)=1){
/*begin*/
$side='';
/*$pin = mysqli_real_escape_string($con,$_POST['pin']);
$mobile = mysqli_real_escape_string($con,$_POST['mobile']);
$address = mysqli_real_escape_string($con,$_POST['address']);
$fua = mysqli_real_escape_string($con,$_POST['fullname']);
$email = mysqli_real_escape_string($con,$_POST['email']);
$password = mysqli_real_escape_string($con, $_POST['password']);
$cpassword = mysqli_real_escape_string($con, $_POST['cpassword']);*/
$side = mysqli_real_escape_string($con,$_POST['side']);
$thirdside = mysqli_real_escape_string($con,$_POST['thirdside']);
$flag = 0;
if($pin!='' && $under_userid!='' && $side!=''){
//User filled all the fields.
if(filter_var($sponsorID,FILTER_VALIDATE_EMAIL)){
$sponscheck = mysqli_query($con, "SELECT * FROM user WHERE email = '$sponsorID'");
if(mysqli_num_rows($sponscheck)>0){
//Pin is ok
if(!email_check($email)){
//Email is ok
if(!email_check($under_userid)){
//Under userid is ok
//Side check
        $flag=1;
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
}
else{
//check all fields are fill
echo '<script>alert("Please fill all the fields.");</script>';
}
//Now we are heree
//It means all the information is correct
//Now we will save all the information
if($flag==1){
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
/*End*/
	}
}
$query =mysqli_query($con,"select * from completedoffers where offer='$offerid' AND email='$userem'");
if(mysqli_num_rows($query)>0){
    $query = mysqli_query($con,"UPDATE completedoffers SET uniclicks=uniclicks+1 WHERE email = '$userem' AND offer = '$offerid'");
}
else{
    $query = mysqli_query($con,"INSERT INTO completedoffers(offer,email,uniclicks) VALUES('$offerid','$userem','1')");
}
}else{
    header('Location: http://app.unilinkpro.com/404.php');
}
?>