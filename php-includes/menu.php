<?php require('php-includes/connect.php');
date_default_timezone_set('Asia/Manila'); ;
$userid = $_SESSION['userid'];
$ai =mysqli_query($con,"select * from income where userid='$userid'");
$je = mysqli_fetch_array($ai);
$thisid = $je['id'];
$le = $je['total_bal'];
$pa = $je['PackageType'];
$menq =mysqli_query($con,"select * from user where email='$userid'");
$menr = mysqli_fetch_array($menq);
$apass = $menr['Password'];
$bbal = $menr['bankacc'];
$bnkn = $menr['bnkn'];
$pbal = $menr['psbaddress'];
$bitbal = $menr['btcaddress'];
$aaccount = $menr['account'];
$homeaddress = $menr['HomeAddress'];
$mobile = $menr['Mobile'];
?>
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">PesoBit Affiliate</a>
            </div>
            <!-- /.navbar-header -->


            <ul class="nav navbar-top-links navbar-right">
                <!-- /.dropdown -->
                <p class="navbar-text"><span class="label label-success" style="font-size: 16px;"><i class="fa fa-money fa-fw"></i> P <?php echo $le.".00"; ?></span></p>
                <p class="navbar-text"> Signed in as <?php echo $_SESSION['userid']; ?></p>
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
                <?php if($pa === '1thouk'){ ?>
                <a class="navbar-text" style="color:#5cb85c" href="#" data-toggle="popover" data-placement="bottom" data-trigger="hover" data-content="Starter Type"><i class="fa fa-circle-o-notch" ></i></a>
                <?php } ?>
                <?php if($pa === '5thouk'){ ?>
                <a class="navbar-text" style="color:#f0ad4e" href="#" data-toggle="popover" data-placement="bottom" data-trigger="hover" data-content="Diamond Type"><i class="fa fa-ra" ></i></a>
                <?php } ?>
                <?php if($pa === '10thouk'){ ?>
                <a class="navbar-text" style="color:#337ab7" href="#" data-toggle="popover" data-placement="bottom" data-trigger="hover" data-content="Elite Type"><i class="fa fa-ge" ></i></a>
                <?php } ?>
<script>
$(document).ready(function(){
    $('[data-toggle="popover"]').popover();   
});
function copyToClipboard(elem) {
      // create hidden text element, if it doesn't already exist
    var targetId = "_hiddenCopyText_";
    var isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA";
    var origSelectionStart, origSelectionEnd;
    if (isInput) {
        // can just use the original source element for the selection and copy
        target = elem;
        origSelectionStart = elem.selectionStart;
        origSelectionEnd = elem.selectionEnd;
    } else {
        // must use a temporary form element for the selection and copy
        target = document.getElementById(targetId);
        if (!target) {
            var target = document.createElement("textarea");
            target.style.position = "absolute";
            target.style.left = "-9999px";
            target.style.top = "0";
            target.id = targetId;
            document.body.appendChild(target);
        }
        target.textContent = elem.textContent;
    }
    // select the content
    var currentFocus = document.activeElement;
    target.focus();
    target.setSelectionRange(0, target.value.length);
    
    // copy the selection
    var succeed;
    try {
          succeed = document.execCommand("copy");
    } catch(e) {
        succeed = false;
    }
    // restore original focus
    if (currentFocus && typeof currentFocus.focus === "function") {
        currentFocus.focus();
    }
    
    if (isInput) {
        // restore prior selection
        elem.setSelectionRange(origSelectionStart, origSelectionEnd);
    } else {
        // clear temporary content
        target.textContent = "";
    }
    return succeed;
}
</script>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <span class="badge" style="background-color: #428bca;">
                            <?php 
                                $result = $con->query("SELECT COUNT(*) FROM logs WHERE vision='new' AND userid = '$userid'");
                                $eyes = $result->fetch_row();
                                echo $eyes[0];
                            ?>
                        </span><i class="fa fa-bell fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                    <?php 
                                    $i=1;
                                    /*$query = mysqli_query($con,"SELECT * FROM logs WHERE userid='$userid' AND state = 'active' AND message LIKE '%You have been paid%' ORDER BY id DESC LIMIT 4");*/
                                    $query = mysqli_query($con,"SELECT * FROM logs WHERE userid='$userid' AND state = 'active' ORDER BY id DESC LIMIT 4");
                                    if(mysqli_num_rows($query)>0){
                                        while($row=mysqli_fetch_array($query)){
                                           $mesid = $row['id'];
                                            $mes = $row['message'];
                                            $logd = $row['date'];
                    ?>
                        <li>
                            <a href="history">
                                <div class="alert alert-info">
                                    <i class="fa fa-usd fa-fw"></i><?php echo $mes; ?>
                                    <span class="pull-right text-muted small">
                                        <?php 
 echo facebook_time_ago($logd);  
                                        ?>
                                    </span>
                                </div>
                            </a>
                        </li>
                        <?php
                        }
                        ?>
                        <li>
                            <a class="text-center" href="history">
                                <strong>See History</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                        <?php 
                        }else{
                        ?>
                            <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-exclamation-circle fa-fw"></i>
                                    <a>No messages yet.</a>
                                </div>
                            </a>
                        </li>
                        <?php
                        }
                        ?>
                    </ul>
                    <!-- /.dropdown-alerts -->
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-message">
                        <li><a href="profile"><i class="fa fa-user fa-fw"></i> My Profile</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li><a href="help"><i class="fa fa-question fa-fw"></i> Help</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="home"><i class="fa fa-home fa-fw"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="gencode"><i class="fa fa-key fa-fw"></i> Generate Pin</a>
                        </li>
                        <li>
                            <a href="pin-request"><i class="fa fa-thumb-tack fa-fw"></i> Pin Request</a>
                        </li>
                        <li>
                            <a href="pin"><i class="fa fa-eye fa-fw"></i>  View Pins</a>
                        </li>
                        <li>
                            <a href="tree"><i class="fa fa-tree fa-sitemap fa-fw"></i> Genealogy</a>
                        </li>
                        <li>
                            <a href="pwallet"><i class="fa fa-credit-card-alt fa-fw"></i>  PesoBit Wallet</a>
                        </li>
                        <li>
                            <a href="bwallet"><i class="fa fa-credit-card fa-fw"></i>  Bitcoin Wallet</a>
                        </li>
                        <li>
                            <a href="mwallet"><i class="fa fa-dollar fa-fw"></i>My Commission</a>
                        </li>
                        <li>
                            <a href="cashout"><i class="fa fa-money fa-fw"></i> Withdraw</a>
                        </li>
                        <li>
                            <a href="myref"><i class="fa fa-link fa-fw"></i>  My Refferal Link</a>
                        </li>
                        <li>
                            <a href="upgrade"><i class="fa fa-arrow-up fa-fw"></i>  Upgrade</a>
                        </li>
                        <li><a href="history"><i class="fa fa-history fa-fw"></i> History</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
        <?php 
 function facebook_time_ago($timestamp)  
 {  
      $time_ago = strtotime($timestamp);  
      $current_time = time();  
      $time_difference = $current_time - $time_ago;  
      $seconds = $time_difference;  
      $minutes      = round($seconds / 60 );           // value 60 is seconds  
      $hours           = round($seconds / 3600);           //value 3600 is 60 minutes * 60 sec  
      $days          = round($seconds / 86400);          //86400 = 24 * 60 * 60;  
      $weeks          = round($seconds / 604800);          // 7*24*60*60;  
      $months          = round($seconds / 2629440);     //((365+365+365+365+366)/5/12)*24*60*60  
      $years          = round($seconds / 31553280);     //(365+365+365+365+366)/5 * 24 * 60 * 60  
      if($seconds <= 60)  
      {  
     return "Just Now";  
   }  
      else if($minutes <=60)  
      {  
     if($minutes==1)  
           {  
       return "one minute ago";  
     }  
     else  
           {  
       return "$minutes minutes ago";  
     }  
   }  
      else if($hours <=24)  
      {  
     if($hours==1)  
           {  
       return "an hour ago";  
     }  
           else  
           {  
       return "$hours hrs ago";  
     }  
   }  
      else if($days <= 7)  
      {  
     if($days==1)  
           {  
       return "yesterday";  
     }  
           else  
           {  
       return "$days days ago";  
     }  
   }  
      else if($weeks <= 4.3) //4.3 == 52/12  
      {  
     if($weeks==1)  
           {  
       return "a week ago";  
     }  
           else  
           {  
       return "$weeks weeks ago";  
     }  
   }  
       else if($months <=12)  
      {  
     if($months==1)  
           {  
       return "a month ago";  
     }  
           else  
           {  
       return "$months months ago";  
     }  
   }  
      else  
      {  
     if($years==1)  
           {  
       return "one year ago";  
     }  
           else  
           {  
       return "$years years ago";  
     }  
   }  
 }          ?>
 <style>
    .dropdown .dropdown-menu {
    -webkit-transition: all 0.3s;
    -moz-transition: all 0.3s;
    -ms-transition: all 0.3s;
    -o-transition: all 0.3s;
    transition: all 0.3s;

    max-height: 0;
    display: block;
    overflow: hidden;
    opacity: 0;
}

.dropdown:hover .dropdown-menu {
    max-height: 450px;
    opacity: 1;
}

 </style>
