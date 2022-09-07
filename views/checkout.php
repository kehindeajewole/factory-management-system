<?php
    require 'header.php';
    $cartQuery = "SELECT * FROM cart INNER JOIN skus ON cart.cart_sku_id = skus.sku_id WHERE cart_user=?";
    $stmtCart = $conn->prepare($cartQuery); 
    $stmtCart->bind_param("s", $_SESSION['role']);
    $stmtCart->execute();
    $resultCart = $stmtCart->get_result();
    $cartQueryCount= $resultCart->num_rows;

    $counter = 1;
    $total = 0;

    require_once(ABSPATH . 'controllers/checkout-controllers.php');
  
    //unset success message after deleting customer
    if( isset($_SESSION['timeout']) ) {
        if (  time() > ($_SESSION['timeout'] + 3 )){
            unset($_SESSION['success']);
            unset($_SESSION['timeout']);
        } 
    }
    if( isset($_SESSION['delete_fail']) ) {
        unset($_SESSION['delete_fail']);
    }  
?>
<div class="container-fluid body-main py-4">
    <div class="row">
        <div class="container-fluid">
            <div class="py-1">
                <h1 class="mb-0 text-white">Checkout</h1>
            </div>
        </div>
    <!-- Content Start -->
    <div class="card">
        <div class="py-4 col-sm-6">
            <a class="btn btn-fms my-4" href="cart.php" role="button"><i class="bi bi-arrow-left"></i> Back to cart</a>
        </div>
        <div class="col-sm-4">
            <form action="checkout.php" method="post">
                <?php if ( count($errors) === 0 && !empty($success['checkout_success']) ): ?>
                    <div class="gen-form-success"> <?php echo $success['checkout_success']; ?> </div>
                <?php endif; ?>
                    <?php if ( count($errors) > 0 && !empty($errors['checkout_fail']) ): ?>
                    <div class="gen-form-errors"> <?php echo $errors['checkout_fail']; ?> </div>
                <?php endif; ?>
                <div class="form-group">
                    <label for="cust-name" class="form-control-label">Customer Name</label>
                    <select class="form-control" name="cust-name" id="cust-name">
                        <?php foreach ($custnames as $value => $label): ?>
                            <option value="<?php echo $value; ?>" <?php if ( $custname == $value) { echo 'selected'; } ?>>
                                <?php echo $label; ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                    <?php if ( count($errors) > 0  && !empty($errors['custname']) ): ?>
                        <div class="form-errors"> <?php echo $errors['custname']; ?> </div>
                    <?php endif; ?>
                </div>
        </div>
        <div class="table-responsive app-checkout">
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th scope="col" class="sort">S/N</th>
                        <th scope="col" class="sort">Product Name</th>
                        <th scope="col" class="sort">Qty</th>
                        <th scope="col" class="sort">Price (₦)</th>
                        <th scope="col" class="sort">Total (₦)</th>
                    </tr>
                </thead>
                <tbody class="list">
                    <?php if( $cartQueryCount > 0 ) :?>
                    <?php while ( $row = $resultCart->fetch_assoc() ): ?>
                    <tr>
                        <td>
                            <?php echo $counter; ?>
                        </td>
                        <td>
                            <?php echo $row["sku_name"]; ?>
                        </td>
                        <td>
                            <?php echo $row["cart_prod_qty"]; ?>
                        </td>
                        <td>
                            <?php echo number_format($row["cart_prod_sale_price"]); ?>
                        </td>
                        <td>
                            <?php echo number_format($row["cart_prod_amount"]); ?>
                        </td>
                    </tr>
                    <?php $counter++ ; ?> 
                    <?php $total = $total +  $row["cart_prod_amount"]; ?>  
                    <?php endwhile; ?>
                    <?php endif ; ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <h4>Grand Total</h4>
                        </td>
                        <td>
                            <h4>₦<?php echo number_format($total) ; ?> </h4>
                        </td>
                        <td>
                            <div class="form-group">
                                <input type="hidden" name="order-total" value="<?php echo $total ;?>">
                                <input class="btn btn-fms btn-block" type="submit" value="Place Order" name="place-order" >
                            </div>
                        <td>
                    </tr>
                </tbody>
            </table>
        </div>
        </form>
    </div>
    <!-- Content End -->    
</div>

<?php
  require 'footer.php';
?>