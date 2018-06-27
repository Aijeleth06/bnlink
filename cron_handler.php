<?php 
include('php-includes/connect.php');
$doc = new DOMDocument();
mysqli_query($con,"update admin should = 0");
?>