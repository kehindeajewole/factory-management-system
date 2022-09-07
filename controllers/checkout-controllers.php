<?php

//store error variables
$errors = array();

$ordertotal = "";
$orderstatus = "";
$custname = "";
$todaysDate = date("Y-m-d");

$custnames = [
    '' => 'Select Customer',
];

$custQuery = "SELECT * FROM customers";
$stmtCust = $conn->prepare($custQuery); 
$stmtCust->execute();
$resultCust = $stmtCust->get_result();
$custQueryCount= $resultCust->num_rows;

if( $custQueryCount > 0 ) :
   while ( $row = $resultCust->fetch_assoc() ):
      $custnames += [$row["cust_id"] => $row["cust_fname"]." ".$row["cust_lname"]."(".$row["coy_name"].")"];
   endwhile;
endif ;

//get the order details on submit and validate
if ( isset( $_POST['place-order'] ) ) {
   $custname = filter_var($_POST['cust-name'], FILTER_SANITIZE_STRING);
   $ordertotal = filter_var($_POST['order-total'], FILTER_SANITIZE_STRING);
   $orderstatus = "Pending Payment";

   //validation
   if ( empty($custname) ) {
      $errors['custname'] = "Please select customer name";
   }


   if ( count($errors) === 0 ) {
       $sql = "INSERT INTO orders (order_cust_id, order_total, order_status, order_created_date) VALUES (?, ?, ?, ?)";
       $stmt = $conn->prepare($sql);
       $stmt->bind_param('ssss', $custname, $ordertotal, $orderstatus, $todaysDate);

       if ( $stmt->execute() ) {
            $order_ref_id = $conn->insert_id;

            $cartQuery = "SELECT * FROM cart INNER JOIN skus ON cart.cart_sku_id = skus.sku_id WHERE cart_user=?";
            $stmtCart = $conn->prepare($cartQuery); 
            $stmtCart->bind_param("s", $_SESSION['role']);
            $stmtCart->execute();
            $resultCart = $stmtCart->get_result();
            $cartQueryCount= $resultCart->num_rows;

            if( $cartQueryCount > 0 ) :
               while ( $row = $resultCart->fetch_assoc() ):
                  $order_sku_id = $row["sku_id"];
                  $order_prod_qty = $row["cart_prod_qty"];
                  $order_prod_sale_price = $row["cart_prod_sale_price"];
                  $order_prod_amount = $row["cart_prod_amount"];
                  
                  $sql2 = "INSERT INTO order_details (order_det_ref_id, order_det_sku_id, order_det_prod_qty, order_det_prod_sale_price, order_det_prod_amount, order_det_date) VALUES (?, ?, ?, ?, ?, ?)";
                  $stmt2 = $conn->prepare($sql2);
                  $stmt2->bind_param('ssssss', $order_ref_id, $order_sku_id, $order_prod_qty, $order_prod_sale_price, $order_prod_amount, $todaysDate);
                  $stmt2->execute();

               endwhile; 
            endif;

            $sql_del = 'DELETE FROM cart WHERE cart_user=? AND cart_date=?';
            $stmt_del = $conn->stmt_init();
            $stmt_del = $conn->prepare($sql_del);
            $stmt_del->bind_param("ss", $_SESSION['role'], $todaysDate);  
            $stmt_del->execute();

            $custname = "";
            $ordertotal = "";
            $orderstatus = "";  
          
            echo("<script>window.location = '".BASE_URL."/views/thank-you.php?id=".$order_ref_id."';</script>");

       } else {
           $errors['checkout_fail'] = "Customer registration failed: Please try again later";
       }
   } else {
       $errors['checkout_fail'] = "One or more fields has errors.";
   }

}