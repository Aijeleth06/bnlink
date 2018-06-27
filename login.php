<?php 
session_start();
if(isset($_POST['alright'])){
$email = mysqli_real_escape_string($con,$_POST['email']);
$password = mysqli_real_escape_string($con,$_POST['password']);

$query = mysqli_query($con,"SELECT * FROM user where Email='$email' AND Password='$password'");
if(mysqli_num_rows($query)>0){
    $_SESSION['userid'] = $email;
    $_SESSION['id'] = session_id();
    $_SESSION['login_type'] = "user";

    echo '<script>alert("Login Success.");window.location.assign("home.php");</script>';
}else{
    echo '<script>alert("Email ID or password is wrong.");window.location.assign("index.php");</script>';
}
}
?>
