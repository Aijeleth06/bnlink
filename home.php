<?php 
    include('php-includes/check-login.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <title>Home | PesoBit</title>

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
<style type="text/css">
  table {
        width: 100%;
    }

thead, tbody, tr, td, th { display: block; }
tr:after {
    content: ' ';
    display: block;
    visibility: hidden;
    clear: both;
}
.table{
  font-size: 14px;
}
thead th {
    height: 35px;

    /*text-align: left;*/
}

tbody {
    height: 300px;
    overflow-y: auto;
    font-size: 12px;
}
.ai_R tbody{
    height: 175px;
    overflow-y: auto;
    font-size: 10px;
}

thead {
    /* fallback */
}


tbody td, thead th {
    width: 20%;
    float: left;
}
</style>
</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include('php-includes/menu.php'); ?>

        <!-- Page Content -->
        <div id="page-wrapper"><br>
        <div class="text-center"><span class='btn btn-info loading'>Good Day fellow user!<br>We will be launching our new update!<br>New Features will be added and we will update our Pesobit cryptocurrency<br> into TOA which offers greater opportunity. Watch how TOA has rapidly increased<br>its value on the Market Cap. <br><br>Considering our innovative upgrade, we are concerned about your current account.<br>Never worry, they are highly secured and we keep your information and credentials private and encrypted to<br> prevent your account from getting compromised. Your account balances and available pins will remain with its <br>value and number. <br>Stay with us, Stay updated. We will keep you on track in building your wealth in Digital Revolution. </span>
        </div>
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><span class="label label-success" style="font-size: 25px;">Dashboard</span></h1> 
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="container-fluid">
                <div class="container">


  <div class="row">
  <div class="col-xs-5">
  <div id="myCarousel" class="carousel slide" data-ride="carousel" style="width: 12cm;">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner">
      <div class="item active">
        <img src="img/ben.jpg" alt="Los Angeles" style="width:100%;">
      </div>

      <div class="item">
        <img src="img/bill.jpg" alt="Chicago" style="width:100%;">
      </div>
    
      <div class="item">
        <img src="img/bank.jpg" alt="New york" style="width:100%;">
      </div>
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
  </div>
  </div>

      </div>
      <div class="modal-footer">
  <div class="row">
                    <div class="col-xs-8">
                    <br><br><span><p class="text-center"> Withdrawal Log</p></span>
                        <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID No.</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Paid on</th>
                            </tr>
                        </thead>
                            <?php 
                            $i=1;
                                $query = mysqli_query($con,"SELECT * FROM payrequest WHERE email = '$userid' ORDER BY id desc");
                                if(mysqli_num_rows($query)>0){
                                    while($row=mysqli_fetch_array($query)){
                                        $amount = $row['amount'];
                                        $date=$row['paydate'];
                                        $status = $row['status'];
                                        $paidon = $row['paidon'];
                                    ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo $amount; ?></td>
                                            <td><?php echo $date; ?></td>
                                            <td><?php echo $status; ?></td>
                                            <td><?php echo $paidon; ?></td>
                                        </tr>
                                    <?php
                                    }
                                }else{
                            ?>
                                <tr>
                                    <td colspan="4">You have no pin request yet.</td>
                                </tr>
                            <?php
                                }
                            ?>
                        </table>
                    </div>
                </div>
                <!-- /.row -->
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

    <script src="vendor/bootstrap/js/jquery.cookie.js"></script>
    <script>
$(document).ready(function() {
    if ($.cookie("pop") == null) {
        $("#ageModal").modal("show");
    $.cookie("pop", "2");
    }
});
</script>
<!-- Modal -->
<div class="modal fade" id="ageModal" tabindex="-1" role="dialog" aria-labelledby="ageModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
  <div class="alert alert-success" role="alert">
        <div class="modal-header">
        <h4 class="modal-title" id="ageModalLabel">Welcome <?php echo $aaccount; ?>!</h4>
      </div>
      <div class="modal-body">
  <p>You have successfully logged in. Have a great day!</p>
</div>
</div>
    </div>
  </div>
</div>  
</body>

</html>
