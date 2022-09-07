<?php

//store error variables
$errors = array();

$resultThankYou = "";
$row = "";
$status = "";
$resultOrderDet = "";
$orderDetQueryCount ="";

$statuses = [
    '' => 'Select Status',
    'Pending Payment' => 'Pending Payment',
    'Payment Received' => 'Payment Received',
    'Order Delivered' => 'Order Delivered'
];

if ( isset($_GET['eoid']) ) {
    $orderId = htmlspecialchars($_GET['eoid']);
    $thankYouQuery = "SELECT * FROM orders INNER JOIN customers ON orders.order_cust_id = customers.cust_id WHERE order_id=?";
    $stmtThankYou = $conn->prepare($thankYouQuery); 
    $stmtThankYou->bind_param("s", $orderId);
    $stmtThankYou->execute();
    $resultThankYou = $stmtThankYou->get_result();
    $row = $resultThankYou->fetch_assoc();

    $status = $row["order_status"];

    $orderDetQuery = "SELECT * FROM order_details INNER JOIN skus ON order_details.order_det_sku_id = skus.sku_id WHERE order_det_ref_id=?";
    $stmtOrderDet = $conn->prepare($orderDetQuery); 
    $stmtOrderDet->bind_param("s", $orderId);
    $stmtOrderDet->execute();
    $resultOrderDet = $stmtOrderDet->get_result();
    $orderDetQueryCount = $resultOrderDet->num_rows;
}

if ( isset( $_POST['update-status'] ) ) {
    $editstatus = filter_var($_POST['order-status'], FILTER_SANITIZE_STRING);
    $orderId = htmlspecialchars($_GET['eoid']);

    //validation
    if ( empty($editstatus ) ) {
        $errors['orderstatus'] = "Select order status";
    }
  
    if ( count($errors) === 0 ) {
        $sql = "UPDATE orders SET order_status=? WHERE order_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $editstatus, $orderId );    

        if ( $stmt->execute() ) {
            $_SESSION['timeout'] = time();
            $_SESSION['success'] = "Status Updated Successfully";
           
            echo("<script>window.location = '".BASE_URL."/views/all-orders.php';</script>");
        } else {
            $errors['status_edit_fail'] = "Status Update failed: Please try again later";
        }   
    } else {
        $errors['status_edit_fail'] = "One or more fields have errors.";
    }
}