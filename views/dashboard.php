<?php
  require 'header.php';
  require(ABSPATH . 'controllers/dashboard-controllers.php');
?>
    <div class="container-fluid body-main py-4">
      <div class="row">
      <div class="container-fluid">
        <div class="py-1">
            <h1 class="mb-0 text-white">Dashboard</h1>
        </div>
      </div>
        <!-- Card Start -->
        <div class="col-xl-4 col-sm-6 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Total <br>Customers</p>
                    <h5 class="font-weight-bolder">
                      <?php echo $custQueryCount; ?>
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                    <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Card End -->
        <!-- Card Start -->
        <div class="col-xl-4 col-sm-6 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Total <br>Orders</p>
                    <h5 class="font-weight-bolder">
                      <?php echo $orderQueryCount; ?>
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                    <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Card End -->
        <!-- Card Start -->
        <div class="col-xl-4 col-sm-6 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Total <br>Materials</p>
                    <h5 class="font-weight-bolder">
                      <?php echo $matQueryCount; ?>
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                    <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Card End -->
        <!-- Card Start -->
        <div class="col-xl-4 col-sm-6 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Total <br>Suppliers</p>
                    <h5 class="font-weight-bolder">
                      <?php echo $supQueryCount; ?>
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                    <i class="ni ni-delivery-fast text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Card End -->
        <!-- Card Start -->
        <div class="col-xl-4 col-sm-6 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Total <br>Products</p>
                    <h5 class="font-weight-bolder">
                      <?php echo $prodQueryCount; ?>
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                    <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Card End -->
        <!-- Card Start -->
        <div class="col-xl-4 col-sm-6 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Total <br>Users</p>
                    <h5 class="font-weight-bolder">
                      <?php echo $usersQueryCount; ?>
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                    <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Card End -->
      </div>
      

<?php
  require 'footer.php';
?>