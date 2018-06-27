<?php 
session_start();
require('php-includes/connect.php');
$userid = mysqli_real_escape_string($con,$_POST['userid']);
$password = mysqli_real_escape_string($con,$_POST['password']);

$query = mysqli_query($con,"SELECT * FROM admin where userid='$userid' AND password='$password'");
if(mysqli_num_rows($query)>0){
	$_SESSION['userid'] = $userid;
	$_SESSION['id'] = session_id();
	$_SESSION['login_type'] = "admin";

	echo '<script>alert("Login Success.");window.location.assign("home.php");</script>';
}else{
	echo '<script>alert("User ID or password is wrong.");window.location.assign("index.php");</script>';
}

?>