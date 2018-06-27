<?php 
    include('php-includes/connect.php');
    include('php-includes/check-login.php');
    $userid = $_SESSION['userid'];
$checkref = tree_data($userid);
$refID = $checkref['referralID'];
if($refID==''){
 $newrefcode = refcodegenerate();
 mysqli_query($con,"update tree set referralID='$newrefcode' where userid='$userid'");
 mysqli_close($con);
 header("Refresh:0");
}
    function refcodegenerate(){
        global $con;
        $generated_refcode = substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', mt_rand(1,8))),1,8);

        $query = mysqli_query($con, "SELECT * FROM tree WHERE referralID = '$generated_refcode'");
        if(mysqli_num_rows($query)>0){
            refcode_generate();
        }else{
            return $generated_refcode;
        }
      }
        function tree_data($userid){
        global $con;
        $data = array();
        $query = mysqli_query($con, "SELECT * FROM tree WHERE userid = '$userid'");
        $result = mysqli_fetch_array($query);
        $data['referralID'] = $result['referralID'];
        return $data;
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

    <title>My Referral Link | PesoBit</title>

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
                        <h1 class="page-header"><span class="label label-info" style="font-size: 25px;"><i class="fa fa-link" style="color:#337ab7"></i> My Referral Link</span></h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
<a class="text-success" href="ref?ref=<?php echo $refID; ?>" target="_blank" id="copyTarget">dashboard.pesobitaffiliate.com/ref?=<?php echo $refID; ?></a>&nbsp&nbsp<button style="font-size: 10px;" type="button" id="copyButton" class="btn btn-outline btn-info">Copy</button>

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
    <script>document.getElementById("copyButton").addEventListener("click", function() {
    copyToClipboard(document.getElementById("copyTarget"));
});</script>
</body>

</html>
