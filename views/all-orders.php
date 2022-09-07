<?php
    require 'header.php';
    $orderQuery = "SELECT * FROM orders INNER JOIN customers ON orders.order_cust_id = customers.cust_id";
    $stmtOrder = $conn->prepare($orderQuery); 
    $stmtOrder->execute();
    $resultOrder = $stmtOrder->get_result();
    $orderQueryCount = $resultOrder->num_rows;
    
    $counter = 1;
    //unset success message after deleting customer
    if( isset($_SESSION['timeout']) ) {
        if ( time() > ($_SESSION['timeout'] + 1 )){
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
                <h1 class="mb-0 text-white">All Orders</h1>
            </div>
        </div>
    <!-- Content Start -->
    <div class="card">
        <div class="py-4">
            <div class="title-btn">
                <?php if ($_SESSION['role'] === "admin" || $_SESSION['role'] === "sales" ) :?>
                <div><a class="btn btn-fms my-sm-4" href="add-order.php" role="button">+ Add New Order</a></div>
                <?php endif; ?>
            </div>
            <div class="col-sm-3">
            <?php if ( isset($_SESSION['success']) ): ?>
                <div class="gen-form-success"> <?php echo $_SESSION['success']; ?> </div>
            <?php endif; ?>
            <?php if ( isset($_SESSION['delete_fail']) ): ?>
                <div class="gen-form-errors"> <?php echo $_SESSION['delete_fail']; ?> </div>
            <?php endif; ?>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th scope="col" class="sort">S/N</th>
                        <th scope="col" class="sort">Customer Name</th>
                        <th scope="col" class="sort">Order Total(₦)</th>
                        <th scope="col" class="sort">Order Status</th>
                        <th scope="col" class="sort">Order Date</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody class="list">
                    <?php if( $orderQueryCount > 0 ) :?>
                    <?php while ( $row = $resultOrder->fetch_assoc() ): ?>
                    <tr>
                        <td>
                            <?php echo $counter; ?>
                        </td>
                        <td>
                            <?php echo $row["cust_fname"]." ".$row["cust_lname"]."(".$row["coy_name"].")" ; ?>
                        </td>
                        <td>
                            <?php echo number_format($row["order_total"]); ?>
                        </td>
                        <td>
                            <?php if( $row['order_status'] === "Pending Payment" ) :?>
                                <span class="badge rounded-pill text-bg-warning">Pending Payment</span>
                            <?php elseif( $row['order_status'] === "Payment Received" ): ?>
                                <span class="badge rounded-pill text-bg-info">Payment Received</span>
                            <?php elseif( $row['order_status'] === "Order Delivered" ): ?>
                                <span class="badge rounded-pill text-bg-success">Order Delivered</span>                            
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php echo date('d-M-Y', strtotime($row['order_created_date'])); ?>
                        </td>
                        <td class="text-right">
                            <div class="table-btn">
                                <a class="table-btn-edit" href="view-order.php?void=<?php echo $row['order_id']; ?>">View</a>
                                
                                <?php if ($_SESSION['role'] === "admin" || $_SESSION['role'] === "accountant") :?>
                                <a class="table-btn-edit" href="edit-order.php?eoid=<?php echo $row['order_id']; ?>">Edit</a>
                                <?php endif; ?>

                                <?php if ($_SESSION['role'] === "admin" ) :?>
                                <a id="del-inv" class="table-btn-del" href="../controllers/delete-controllers.php?orderdelid=<?php echo $row['order_id']; ?>">Delete</a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php $counter++ ; ?>  
                    <?php endwhile; ?>
                    <?php endif ; ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Content End -->    
</div>

<?php
  require 'footer.php';
?>