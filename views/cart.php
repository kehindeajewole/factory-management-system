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
            <a class="btn btn-fms my-4" href="add-order.php" role="button"><i class="bi bi-arrow-left"></i> Back to Order</a>
            <?php if ( isset($_SESSION['success']) ): ?>
                <div class="gen-form-success"> <?php echo $_SESSION['success']; ?> </div>
            <?php endif; ?>
            <?php if ( isset($_SESSION['delete_fail']) ): ?>
                <div class="gen-form-errors"> <?php echo $_SESSION['delete_fail']; ?> </div>
            <?php endif; ?>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th scope="col" class="sort">S/N</th>
                        <th scope="col" class="sort">Product Name</th>
                        <th scope="col" class="sort">Qty</th>
                        <th scope="col" class="sort">Price (₦)</th>
                        <th scope="col" class="sort">Total (₦)</th>
                        <th scope="col"></th>
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
                        <td class="text-right">
                            <div class="table-btn">
                                <a id="del-inv" class="table-btn-del" href="../controllers/delete-controllers.php?cartdelid=<?php echo $row['cart_id']; ?>&cartpname=<?php echo $row['sku_name']; ?>">Delete</a>
                            </div>
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
                        <td class="text-right">
                            <div class="table-btn">
                                <a id="del-inv" class="btn btn-fms btn-block" href="checkout.php">Checkout <i class="bi bi-arrow-right"></i></a>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Content End -->    
</div>

<?php
  require 'footer.php';
?>