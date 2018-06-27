<?php 
include('php-includes/connect.php');

/* 	$query = mysqli_query($con,"SELECT userid,day_trans FROM income");
		if(mysqli_num_rows($query)>0){
			while($row=mysqli_fetch_array($query)){
				$affuse = $row['userid'];
				$affdai = $row['day_trans'];
				if($affdai > 10){
					mysqli_query($con, "UPDATE tree set leftcount = 0, rightcount = 0 WHERE userid = '$affuse'");
					mysqli_query($con, "UPDATE income set day_trans=0 WHERE userid = '$affuse'");
				}else{
					mysqli_query($con, "UPDATE income set day_trans=0 WHERE userid = '$affuse'");
				}
			}
		}*/
mysqli_query($con, "UPDATE admin set should=0");
/*/usr/local/bin/php -q /home/pesoaff/x_y06z.php*/
?>