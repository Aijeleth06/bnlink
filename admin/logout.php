<?php 
session_start();
session_destroy();
echo '<script>alert("Logout Sucess");window.location.assign("index.php");</script>';
?>