<?php require('php-includes/connect.php');
$ref = $_GET['ref'];
if(isset($ref)){
$qquery =mysqli_query($con,"select referralID,userid from tree where referralID='$ref'");
$uer = mysqli_fetch_array($qquery);
$userid = $uer['userid'];
$checkref = user_data($userid);
$refname = $checkref['account'];
if(mysqli_num_rows($qquery)>0){

?>
<!DOCTYPE html>
<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6 lt8"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7 lt8"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8 lt8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="UTF-8" />
        <!-- <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">  -->
        <title>Register | Pesobit Affiliate</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <meta name="description" content="To bring more people into investing cryptocurrency and become poverty free in the future" />
        <meta name="keywords" content="pesobit, pessobit affiliate, cryptocurrency, invest, earn pesobit, :target, pseudo-class" />
        <meta name="author" content="Codrops" />
        <link rel="shortcut icon" href="../favicon.ico"> 
        <link rel="stylesheet" type="text/css" href="css/demo.css" />
        <link rel="stylesheet" type="text/css" href="css/style.css" />
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
                    <div id="wrapper">
                        <div id="login" class="animate form">
                            <form  method="POST" action="verify" autocomplete="on"> 
                                <h1 style="font-size: 35px;"> Welcome To Pesobit Affiliate</h1>
                                <h1 style="font-size: 30px;"> You have been invited by <br><?php echo $refname; ?></h1>
                                <p> 
                                    <input id="usernamesignup" name="SponsorID" required="required" type="hidden" value="<?php echo $userid; ?>" placeholder="Sponsor Email" />
                                </p>
                                <p> 
                                    <label for="usernamesignup" class="uname" data-icon="p">Activation Pin</label>
                                    <input id="usernamesignup" name="ActivationPin" required="required" type="text" placeholder="Activation Code" />
                                </p>
                                <p> 
                                    <label for="usernamesignup" class="uname" data-icon="u">Full Name</label>
                                    <input id="usernamesignup" name="fullname" required="required" type="text" placeholder="First Name & Last Name" />
                                </p>
                                <p> 
                                    <label for="usernamesignup" class="uname" data-icon="A">Address</label>
                                    <input id="usernamesignup" name="Address" required="required" type="text" placeholder="Your Address" />
                                </p>
                                <p> 
                                    <label for="usernamesignup" class="uname" data-icon="#">Mobile #</label>
                                    <input id="usernamesignup" name="MobileNo" required="required" type="text" placeholder="+587 528 7895 40" />
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
                                    <input id="emailsignup" name="email" required="required" type="email" placeholder="mymail@mail.com"/> 
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
                                    <a href="main"> Go and log in </a>
                                </p>
                            </form>
                        </div>

                        
                    </div>
                </div>  
            </section>
        </div>
    <?php
}
else{ echo '<script>alert("Invalid Referral Link");</script>'; header("Refresh:0; url=index"); }
}else{
    echo '<script>alert("Invalid Referral Link");</script>'; header("Refresh:0; url=index");
}
    function user_data($userid){
        global $con;
        $data = array();
        $query = mysqli_query($con, "SELECT account FROM user WHERE email = '$userid'");
        $result = mysqli_fetch_array($query);
        $data['account'] = $result['account'];
        return $data;
    }
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
    </body>
</html>