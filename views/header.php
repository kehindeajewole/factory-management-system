<?php
require '../path.php';
require(ABSPATH . 'controllers/auth-controllers.php');

if ($_SESSION['role'] !== "admin" && $_SESSION['role'] !== "production" && $_SESSION['role'] !== "accountant" && $_SESSION['role'] !== "procurement" && $_SESSION['role'] !== "sales" ) {
  header('location:'. BASE_URL . '/login.php');
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>FMS Admin - Dashboard</title>
  <!-- Favicon -->
  <link rel="icon" href="../assets/images/favicon.png" type="image/png">
  <!-- Icons -->
  <link rel="stylesheet" href="../assets/css/nucleo-icons.css" />
  <link rel="stylesheet" href="../assets/css/nucleo-svg.css" />
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="../assets/css/app.css" type="text/css">
  <link rel="stylesheet" href="../assets/css/style.css" type="text/css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
</head>

<body class="g-sidenav-show  bg-gray-100">
  <div class="min-height-300 header-bg-fms position-absolute w-100"></div>
  <aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 " id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="/" target="_blank">
        <img src="../assets/images/FMS_Logo.png" class="navbar-brand-img h-100" alt="FMS Logo">
      </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link <?php if (strpos($_SERVER['REQUEST_URI'], "dashboard") !== false) :?>active<?php endif; ?>" href="dashboard.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
        <?php if ($_SESSION['role'] === "admin" || $_SESSION['role'] === "sales" || $_SESSION['role'] === "accountant" ) :?>
        <li class="nav-item">
          <a class="nav-link <?php if (strpos($_SERVER['REQUEST_URI'], "all-customers") !== false) :?>active<?php endif; ?>" href="all-customers.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Customers</span>
          </a>
        </li>
        <?php endif; ?>
        <?php if ($_SESSION['role'] === "admin") :?>
        <li class="nav-item">
          <a class="nav-link <?php if (strpos($_SERVER['REQUEST_URI'], "all-users") !== false) :?>active<?php endif; ?>" href="all-users.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-app text-info text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Users</span>
          </a>
        </li>
        <?php endif; ?>
        <?php if ($_SESSION['role'] === "admin" || $_SESSION['role'] === "production") :?>
        <li class="nav-item">
          <a class="nav-link <?php if (strpos($_SERVER['REQUEST_URI'], "all-products") !== false) :?>active<?php endif; ?>" href="all-products.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-world-2 text-danger text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Products</span>
          </a>
        </li>
        <?php endif; ?>
        <?php if ($_SESSION['role'] === "admin" || $_SESSION['role'] === "sales" || $_SESSION['role'] === "accountant" ) :?>
        <li class="nav-item">
          <a class="nav-link <?php if (strpos($_SERVER['REQUEST_URI'], "all-orders") !== false) :?>active<?php endif; ?>" href="all-orders.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-money-coins text-danger text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Orders</span>
          </a>
        </li>
        <?php endif; ?>
        <?php if ($_SESSION['role'] === "admin" || $_SESSION['role'] === "production" || $_SESSION['role'] === "procurement" || $_SESSION['role'] === "accountant" ) :?>
        <li class="nav-item">
          <a class="nav-link <?php if (strpos($_SERVER['REQUEST_URI'], "all-suppliers") !== false) :?>active<?php endif; ?>" href="all-suppliers.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-delivery-fast text-danger text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Suppliers</span>
          </a>
        </li>
        <?php endif; ?>
        <?php if ($_SESSION['role'] === "admin" || $_SESSION['role'] === "production" || $_SESSION['role'] === "procurement" || $_SESSION['role'] === "accountant" ) :?>
        <li class="nav-item">
          <a class="nav-link <?php if (strpos($_SERVER['REQUEST_URI'], "all-materials") !== false) :?>active<?php endif; ?>" href="all-materials.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-delivery-fast text-danger text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Raw Materials</span>
          </a>
        </li>
        <?php endif; ?>
        <li class="nav-item">
          <a class="nav-link" href="dashboard.php?admin-logout=1">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-world-2 text-danger text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Logout</span>
          </a>
        </li>
      </ul>
    </div>
  </aside>
  <!-- Start Main from header -->
  <main class="main-content position-relative border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
      <div class="container-fluid py-1 px-3">
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            <a class="navbar-brand m-0 fms-lg" href="/" target="_blank">
              <img src="../assets/images/FMS_Logo_White.png" class="navbar-brand-img h-100" alt="FMS Logo">
            </a>
          </div>
          <ul class="navbar-nav  justify-content-end">
            <li class="nav-item d-flex align-items-center">
              <a href="" class="nav-link text-white font-weight-bold px-0">
                <i class="fa fa-user me-sm-1"></i>
                <span class="d-sm-inline d-none">Welcome, <?php echo ucwords($_SESSION['role']); ?></span>
              </a>
            </li>
            <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line bg-white"></i>
                  <i class="sidenav-toggler-line bg-white"></i>
                  <i class="sidenav-toggler-line bg-white"></i>
                </div>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->
