<!DOCTYPE html>
<html lang="en">
<head>
  <?php
  include("config.php");
  if (isset($_COOKIE['PrivatePageLogin'])) {
  if ($_COOKIE['PrivatePageLogin'] == md5($paneluser.$panelpass.$nonsense)) {
  ?>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>IPLogger | Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<?php
try {
    $dbConn= new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPassword);


    //Successfully connected to database
} catch (PDOException $e) {
    die();
}
$dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //Set the PDO error mode to exception.

//start useragent sql stuff
$sqlrua = 'SELECT UAString FROM rejectedua';
$ruaquery = $dbConn->query($sqlrua); //count the rejected useragents and set as var
$RUACount = $ruaquery->fetchAll(\PDO::FETCH_ASSOC);
///end useragent sql stuff

//start Loggedip sql stuff
$sqlips = 'SELECT ip FROM users';
$ipsquery = $dbConn->query($sqlips); //count the rejected useragents and set as var
$ipsCount = $ipsquery->fetchAll(\PDO::FETCH_ASSOC);
///end Loggedip sql stuff

?>
<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__wobble" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <!--<li class="nav-item d-none d-sm-inline-block">
        <a href="javascript:logout()" class="nav-link">Logout</a>
      </li>-->
    </ul>
  </nav>
  <!-- /.navbar -->
<script>
function logout()
{
    document.cookie=document.cookie+";max-age=0";
    document.cookie=document.cookie;
    setTimeout("location.reload(true);", 2000);
}
</script>
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="panel.php" class="brand-link">
      <span class="brand-text font-weight-light">IPLogger</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-header">General</li>
          <li class="nav-item">
            <a href="panel.php" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                IP Logger
              </p>
            </a>
          </li>
          </li>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Statistics</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-users"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Log Count</span>
                <span class="info-box-number">
                  <?php
                  $alltotal = count($RUACount) + count($ipsCount);
                  echo($alltotal);
                  ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-user-plus"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Valid Useragents / Logged IP's</span>
                <span class="info-box-number"><?php echo(count($ipsCount));?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-user-slash"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Rejected Useragents</span>
                <span class="info-box-number"><?php echo(count($RUACount));?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-list"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Useragent Whitelist Status</span>
                <span class="info-box-number"><?php echo((boolval($whitelistedUA) ? 'true' : 'false'));?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
        </div>
        <!-- /.row -->

        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <div class="col-md-8">
            <!-- TABLE: LATEST ORDERS -->
            <div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title">50 Latest Logs</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table m-0">
                    <thead>
                    <tr>
                      <th>IP Address</th>
                      <th>Country</th>
                      <th>Time Logged</th>
                    </tr>
                    </thead>
                    <tbody>
                      <?php
                      $tablesql = "SELECT * FROM `users` ORDER BY `logtime` DESC LIMIT 50";
                  		$tablequery = $dbConn->prepare($tablesql);
                  		$tablequery->execute();

                  		while($fetch = $tablequery->fetch()){
                  ?>

                  <tr>
                  	<td><?php echo long2ip($fetch['ip'])?></td>
                  	<td><?php echo $fetch['country']?></td>
                  	<td><?php echo $fetch['logtime']?></td>
                  </tr>

                  <?php
                  		}
                  ?>
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                <a href="javascript:void(0)" class="btn btn-sm btn-info float-left">View More Logs</a>
                <a href="javascript:void(0)" class="btn btn-sm btn-danger float-right">View All Logs</a>
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2021 <a href="https://kneesox.moe">Kneesox</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0-dev
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="plugins/raphael/raphael.min.js"></script>
<script src="plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="plugins/jquery-mapael/maps/usa_states.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>

<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard2.js"></script>
</body>
</html>
<?php
      exit;
   } else {
      echo "Bad Cookie.";
      exit;
   }
}
if (isset($_GET['u']) && $_GET['p'] == "login") {
   if ($_POST['u'] != $paneluser) {
      echo "Sorry, that username does not match.";
      //exit;
    } else if ($_POST['p'] != $panelpass) {
         echo "Sorry, that password does not match.";
         //exit;
    }

    else if ($_POST['u'] == $paneluser && $_POST['p'] == $panelpass) {
      setcookie('PrivatePageLogin', md5($_POST['u'].$_POST['p'].$nonsense));
      header("Location: $_SERVER[PHP_SELF]");
   } else {
      echo "Sorry, you could not be logged in at this time.";
   }
 }
?>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?u=login&p=login" name="signup-form">
  <style>
  body {
      background-color: #909090;
  }
  </style>
<div class="login">
<label>Username</label>
<input type="text" id="u" name="u" />
</div>
<div class="form-element">
<label>Password</label>
<input type="password" id="p" name="p"/>
</div>
<button type="submit" id="login" name="login" value="login">Login</button>
</form>
