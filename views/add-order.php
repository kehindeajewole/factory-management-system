<?php
    require 'header.php';
    $dataQuery = "SELECT * FROM products INNER JOIN skus ON products.prod_name = skus.sku_id";
    $stmt = $conn->prepare($dataQuery); 
    $stmt->execute();
    $result = $stmt->get_result();
    $queryCount= $result->num_rows;

    //unset success message after deleting customer
    if( isset($_SESSION['timeout']) ) {
        if (  time() > ($_SESSION['timeout'] + 1 )){
            unset($_SESSION['success']);
            unset($_SESSION['timeout']);
        } 
    }
    if( isset($_SESSION['cart_add_fail']) ) {
        unset($_SESSION['cart_add_fail']);
    }
?>
    <div class="container-fluid body-main py-4">
    <div class="row">
        <div class="container-fluid">
        <div class="py-1">
            <h1 class="mb-0 text-white">Order Product</h1>
        </div>
        </div>
        <!-- Data content start-->
        <div class="container-fluid">
            <div class="card p-4">
            <div class="row">
                <div class="col-md-12">
                <div class="container">
                    <a class="btn btn-fms my-4" href="cart.php" role="button">View cart <i class="bi bi-cart4"></i></a>
                    <?php if ( isset($_SESSION['success']) ): ?>
                        <div class="gen-form-success  app-success-alert"> <?php echo $_SESSION['success']; ?> <a href="cart.php">View cart</a></div>
                    <?php endif; ?>
                    <?php if ( isset($_SESSION['cart_add_fail']) ): ?>
                        <div class="gen-form-errors"> <?php echo $_SESSION['cart_add_fail']; ?> </div>
                    <?php endif; ?>
                </div>   
                <!-- Product Start -->
                <div class="container text-center">
                    <div class="row update-unit-qty-all">
                        <?php if( $queryCount > 0 ) :?>
                        <?php while ( $row = $result->fetch_assoc() ): ?>
                            <div class="col-sm-4 my-3">
                            <div class="card" style="width: 100%;">
                                <img src="../assets/images/<?php echo $row["sku_image"] ; ?>" class="card-img-top" alt="<?php echo $row["sku_name"] ; ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $row["sku_name"] ; ?></h5>
                                    <p class="card-text">₦<?php echo number_format($row["prod_sale"]) ; ?></p>
                                    <div class="update-unit-qty-parent">
                                    <div class="update-unit-qty" data-id="<?php echo $row['prod_name']; ?>" data-qty="1" data-amount="<?php echo $row['prod_sale']; ?>" data-name="<?php echo $row['sku_name']; ?>">
                                        <span class="btn-inc-dec qty-btn-dec">-</span>
                                        <input type="number" name="unit-qty" class="unit-qty" min="1" value="1">
                                        <span class="btn-inc-dec qty-btn-inc">+</span>
                                    </div>
                                    <a href="#" class="btn btn-fms btn-block mt-4">Add to cart</a>
                                    </div>
                                </div>
                            </div>
                            </div>
                        <?php endwhile; ?>
                        <?php endif ; ?>
                    </div>
                </div>
                <!-- Product End -->
                </div>
            </div>
            </div>
        </div>            
        <!-- Data content end-->
    </div>
<?php
  require 'footer.php';
?>