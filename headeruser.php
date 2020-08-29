<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Chorn Glory | Dashboard</title>
  <!-- jQuery -->
  <script src=" plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src=" plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src=" dist/js/adminlte.min.js"></script>

  <!-- DataTables -->
  <script src="plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="Chart.js-2.9.3/dist/Chart.min.js"></script>

  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="plugins/select2/css/select2.min.css">

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">


  <!-- date-range-picker -->
  <script src="plugins/daterangepicker/daterangepicker.js"></script>
  <!-- Select2 -->
  <script src=" plugins/select2/js/select2.full.min.js"></script>
  <!-- Bootstrap4 Duallistbox -->
  <script src=" plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
  <!-- InputMask -->
  <script src=" plugins/moment/moment.min.js"></script>
  <script src=" plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
  <!-- date-range-picker -->
  <!--  <script src=" plugins/daterangepicker/daterangepicker.js"></script>-->
  <!-- bootstrap color picker -->
  <script src=" plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src=" plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- Bootstrap Switch -->
  <script src=" plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>

  <!--     sweetalert-->
  <script src="plugins/swwetalert/sweetalert.min.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <!--  <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>-->
  <style>
    h,p {font-family: 'Khmer Busra MOE';}
  </style>
</head>
<body class="hold-transition sidebar-mini sidebar-collapse">
<div class="">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light ">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>

      <!--      <li class="nav-item d-none d-sm-inline-block">-->
      <!---->
      <!--      </li>-->
      <li class="nav-item d-none d-sm-inline-block">
        <button type="button" class="btn btn-secondary" onclick="history.back();"><i class="fas fa-arrow-circle-left"></i></button>
      </li>

      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>
    <!-- SEARCH FORM -->
    <!--    <form class="form-inline ml-3">-->
    <!--      <div class="input-group input-group-sm">-->
    <!--        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">-->
    <!--        <div class="input-group-append">-->
    <!--          <button class="btn btn-navbar" type="submit">-->
    <!--            <i class="fas fa-search"></i>-->
    <!--          </button>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--    </form>-->
    <div class="navbar-nav ml-auto">
      <ul>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="createorder.php" class="btn btn-success btn-inline-block"><i class="fas fa-plus-circle"></i> Order</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="logout.php" class="btn btn-danger"><strong> <i class="fas fa-sign-out-alt"></i></strong>
          </a>
        </li>
      </ul>
    </div>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->

    <a href="" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">CGT </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Welcome <strong><?php
              echo $_SESSION['username'];
              ?></strong> </a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

          <li class="nav-item">
            <a href="user.php" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="createorder.php" class="nav-link">
              <i class="nav-icon fas fa-shopping-cart"></i>
              <p> Create Order</p>

            </a>
          </li>
          <li class="nav-item">
            <a href="orderlist.php" class="nav-link">
              <i class="nav-icon fas fa-file-invoice-dollar"></i>
              <p> Invoices Order</p>

            </a>
          </li>
          <li class="nav-item">
            <a href="acc_setting.php" class="nav-link">
              <i class="nav-icon far fa-user-circle"></i>
              <p>
                Account Setting
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="logout.php" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                Sign Out
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
</div>
<!---->
<!--</body>-->
