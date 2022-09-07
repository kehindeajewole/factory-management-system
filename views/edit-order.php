<?php
    require 'header.php';
    require_once(ABSPATH . 'controllers/order-status-controllers.php');
    $counter = 1;
    $total = 0;
?>
<div class="container-fluid body-main py-4">
    <div class="row">
        <div class="container-fluid">
            <div class="py-1">
                <h1 class="mb-0 text-white">Edit Order Details</h1>
            </div>
        </div>
        <!-- Content Start -->
        <div class="card mb-5">
            <div class="container">
                <div class="col-sm-6">
                    <a class="btn btn-fms my-4" href="all-orders.php" role="button"><i class="bi bi-arrow-left"></i> Back to orders</a>
                </div>
            </div>
            <div class="container">
                <div class="col-sm-6">
                    <form action="edit-order.php?eoid=<?php echo $_GET['eoid']; ?>" method="post">
                        <?php if ( count($errors) === 0 && !empty($success['status_edit_success']) ): ?>
                            <div class="gen-form-success"> <?php echo $success['status_edit_success']; ?> </div>
                        <?php endif; ?>
                            <?php if ( count($errors) > 0 && !empty($errors['status_edit_fail']) ): ?>
                            <div class="gen-form-errors"> <?php echo $errors['status_edit_fail']; ?> </div>
                        <?php endif; ?>
                        <div class="form-group">
                            <label for="order-status" class="form-control-label">Update Order Status</label>
                            <select class="form-control" name="order-status" id="order-status">
                                <?php foreach ($statuses as $value => $label): ?>
                                    <option value="<?php echo $value; ?>" <?php if ( $status == $value) { echo 'selected'; } ?>>
                                        <?php echo $label; ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                            <?php if ( count($errors) > 0  && !empty($errors['orderstatus']) ): ?>
                                <div class="form-errors"> <?php echo $errors['orderstatus']; ?> </div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <input class="btn btn-fms my-4 btn-block" type="submit" value="Update Order Status" name="update-status" >
                        </div>
                    </form>
                </div>
            </div>
            <div class="container">
                <div class="row app-thank-you">
                    <div class="col-sm-12 my-3">
                        <h5 class="card-title">Customer Details</h5>
                        <p class="card-text"><?php echo $row["cust_fname"] . " " . $row["cust_lname"] ; ?></p>
                        <p class="card-text"><?php echo $row["coy_name"] ; ?></p>
                        <p class="card-text"><?php echo $row["coy_addy"] ; ?></p>
                        <p class="card-text"><?php echo $row["coy_phone"] . ", " . $row["coy_email"]; ?></p>
                        <!-- Order Status Start-->
                        <h5 class="card-title">Order Status</h5>
                        <h6 class="card-subtitle mb-5 text-muted">
                            <?php if( $row['order_status'] === "Pending Payment" ) :?>
                                <span class="badge rounded-pill text-bg-warning">Pending</span>
                            <?php elseif( $row['order_status'] === "Payment Received" ): ?>
                                <span class="badge rounded-pill text-bg-info">Payment Received</span>
                            <?php elseif( $row['order_status'] === "Order Delivered" ): ?>
                                <span class="badge rounded-pill text-bg-success">Order Delivered</span>                            
                            <?php endif; ?>
                        </h6>
                        <!-- Order Status End-->
                        <!-- Order Details Start -->
                        <h5 class="card-title">Order Details</h5>
                        <div class="table-responsive">
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
                                    <?php if( $orderDetQueryCount > 0 ) :?>
                                    <?php while (  $row = $resultOrderDet->fetch_assoc() ): ?>
                                    <tr>
                                        <td>
                                            <?php echo $counter; ?>
                                        </td>
                                        <td>
                                            <?php echo $row["sku_name"] ; ?>
                                        </td>
                                        <td>
                                            <?php echo $row["order_det_prod_qty"]; ?>
                                        </td>
                                        <td>
                                            <?php echo number_format($row["order_det_prod_sale_price"]); ?>
                                        </td>
                                        <td>
                                            <?php echo number_format($row["order_det_prod_amount"]); ?>
                                        </td>
                                    </tr>
                                    <?php $counter++ ; ?>
                                    <?php $total = $total +  $row["order_det_prod_amount"]; ?>    
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
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- Order Details End -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Content End -->    
    </div>

<?php
  require 'footer.php';
?>