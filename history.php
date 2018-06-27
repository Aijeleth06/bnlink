<?php 
    include('php-includes/connect.php');
    include('php-includes/check-login.php');
    $userid = $_SESSION['userid'];
    mysqli_query($con,"UPDATE logs SET vision='seen' WHERE userid='$userid'");
/*    if($_POST && isset($_POST['close']) && isset($_POST['closed'])){
      $xx = $_POST['closed'];
      mysqli_query($con,"update logs set state='closed' where id='$xx'");
      mysqli_close($con);
    }*/
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>History | PesoBit</title>

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
                    <div class="col-lg-12"><br>
                    <div class="row">
                    <div class="col-md-4 pull-right">
  <div class="input-group">
    <input type="text" name="search_text" id="aisearch" class="form-control" placeholder="Search for history">
    <div class="input-group-btn">
      <div class="btn btn-default">
        <i class="glyphicon glyphicon-search"></i>
      </div>
    </div>
  </div><br></div></div>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <tr>
                                    <th></th>
                                    <th><a>History</a></th>
                                    <th><a>Date time</th>
                                    
                                </tr>
                                <?php 
                                    $i=1;
                                    $query = mysqli_query($con,"SELECT * FROM logs WHERE userid='$userid' AND state = 'active' ORDER BY id DESC");
                                    if(mysqli_num_rows($query)>0){
                                        while($row=mysqli_fetch_array($query)){
                                           $mesid = $row['id'];
                                            $mes = $row['message'];
                                            $logd = $row['date'];
                                ?>
                                    <tr>
                                        <td>
                                        <!-- <form method="POST" class="form-inline">
                                        <input type="hidden" name="closed" value="<?php echo $mesid; ?>" required>
                                          <button type="submit" name="close" class="close" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </form> -->
                                        </td>
                                        <td><a><?php echo $mes; ?></a></td>
                                        <td><a><?php echo $logd; ?></a></td>
                                    </tr>
                                <?php
                                        }
                                    }else{
                                ?>
                                    <tr>
                                        <td colspan="2"><a>No recent activities yet.</a></td>
                                    </tr>
                                <?php
                                    }
                                    mysqli_close($con);
                                ?>
                            </table>
                        </div>
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

</body>

</html>
