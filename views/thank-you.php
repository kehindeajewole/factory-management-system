<?php
    require 'header.php';

    $orderId = htmlspecialchars($_GET['id']);
    $thankYouQuery = "SELECT * FROM orders INNER JOIN customers ON orders.order_cust_id = customers.cust_id WHERE order_id=?";
    $stmtThankYou = $conn->prepare($thankYouQuery); 
    $stmtThankYou->bind_param("s", $orderId);
    $stmtThankYou->execute();
    $resultThankYou = $stmtThankYou->get_result();
    $row = $resultThankYou->fetch_assoc();

    $orderDetQuery = "SELECT * FROM order_details INNER JOIN skus ON order_details.order_det_sku_id = skus.sku_id WHERE order_det_ref_id=?";
    $stmtOrderDet = $conn->prepare($orderDetQuery); 
    $stmtOrderDet->bind_param("s", $orderId);
    $stmtOrderDet->execute();
    $resultOrderDet = $stmtOrderDet->get_result();
    $orderDetQueryCount = $resultOrderDet->num_rows;

    $counter = 1;
    $total = 0;

?>
<div class="container-fluid body-main py-4">
    <div class="row">
        <div class="container-fluid">
            <div class="py-1">
                <h1 class="mb-0 text-white">Order Received</h1>
            </div>
        </div>
        <!-- Content Start -->
        <div class="card">
            <div class="app-thank-you text-center">
                <i class="bi bi-check-circle"></i>
            </div>

            <div class="container">
                <div class="row app-thank-you">
                    <div class="col-sm-6 my-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Order Status</h5>
                                <h6 class="card-subtitle mb-2 text-muted">
                                <?php if( $row['order_status'] === "Pending Payment" ) :?>
                                    <span class="badge rounded-pill text-bg-warning">Pending</span>
                                <?php elseif( $row['order_status'] === "Payment Received" ): ?>
                                    <span class="badge rounded-pill text-bg-info">Payment Received</span>
                                <?php elseif( $row['order_status'] === "Order Delivered" ): ?>
                                    <span class="badge rounded-pill text-bg-success">Order Delivered</span>                            
                                <?php endif; ?>
                                </h6>
                                <p class="card-text">Kindly credit our bank account to compete the order </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 my-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Our Bank Details</h5>
                                <p class="card-text"><strong>Bank Name:</strong> Master Bank</p>
                                  <p class="card-text"><strong>Account Name:</strong> Factory Management System</p>
                                <p class="card-text"><strong>Account Number:</strong> 101023456</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 my-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Customer Details</h5>
                                <p class="card-text"><?php echo $row["cust_fname"] . " " . $row["cust_lname"] ; ?></p>
                                <p class="card-text"><?php echo $row["coy_name"] ; ?></p>
                                <p class="card-text"><?php echo $row["coy_addy"] ; ?></p>
                                <p class="card-text"><?php echo $row["coy_phone"] . ", " . $row["coy_email"]; ?></p>
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
            </div>
        </div>
        <!-- Content End -->    
    </div>

<?php
  require 'footer.php';
?>