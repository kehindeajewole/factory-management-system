<?php
session_start();
require '../path.php';
include(ABSPATH . 'model/db.php');

//Delete an SKU From database
if( isset($_GET['skudelid']) ) {
    $delId = htmlspecialchars($_GET['skudelid']);
    $sql_del = 'DELETE FROM skus WHERE sku_id=?';
    $stmt_del = $conn->stmt_init();
    $stmt_del = $conn->prepare($sql_del);
    $stmt_del->bind_param("s", $delId);    

    if ( $stmt_del->execute() ) {
        $_SESSION['success'] = "SKU deleted successfully";
        $_SESSION['timeout'] = time();
        header("location: ../views/all-skus.php");
        exit();  
    } else {
        $_SESSION['delete_fail'] = "Request failed: Please try again later.";
    } 
}

//Delete a Product From database
if( isset($_GET['proddelid']) ) {
    $delId = htmlspecialchars($_GET['proddelid']);
    $sql_del = 'DELETE FROM products WHERE prod_id=?';
    $stmt_del = $conn->stmt_init();
    $stmt_del = $conn->prepare($sql_del);
    $stmt_del->bind_param("s", $delId);    

    if ( $stmt_del->execute() ) {
        $_SESSION['success'] = "Product deleted successfully";
        $_SESSION['timeout'] = time();
        header("location: ../views/all-products.php");
        exit();  
    } else {
        $_SESSION['delete_fail'] = "Request failed: Please try again later.";
    } 
}

//Delete an item in the cart and in database
if( isset($_GET['cartdelid']) ) {
    $delId = htmlspecialchars($_GET['cartdelid']);
    $delName = htmlspecialchars($_GET['cartpname']);
    $sql_del = 'DELETE FROM cart WHERE cart_id=?';
    $stmt_del = $conn->stmt_init();
    $stmt_del = $conn->prepare($sql_del);
    $stmt_del->bind_param("s", $delId);    

    if ( $stmt_del->execute() ) {
        $_SESSION['success'] = $delName . " deleted successfully";
        $_SESSION['timeout'] = time();
        header("location: ../views/checkout.php");
        exit();  
    } else {
        $_SESSION['delete_fail'] = "Request failed: Please try again later.";
    } 
}

//Delete an order in database
if( isset($_GET['orderdelid']) ) {
    $delId = htmlspecialchars($_GET['orderdelid']);
    $sql_del = 'DELETE FROM orders WHERE order_id=?';
    $stmt_del = $conn->stmt_init();
    $stmt_del = $conn->prepare($sql_del);
    $stmt_del->bind_param("s", $delId);    

    if ( $stmt_del->execute() ) {
        $_SESSION['success'] = "Order deleted successfully";
        $_SESSION['timeout'] = time();
        header("location: ../views/all-orders.php");
        exit();  
    } else {
        $_SESSION['delete_fail'] = "Request failed: Please try again later.";
    } 
}

//Delete a raw material item in database
if( isset($_GET['matdelid']) ) {
    $delId = htmlspecialchars($_GET['matdelid']);
    $sql_del = 'DELETE FROM materials WHERE mat_id=?';
    $stmt_del = $conn->stmt_init();
    $stmt_del = $conn->prepare($sql_del);
    $stmt_del->bind_param("s", $delId);    

    if ( $stmt_del->execute() ) {
        $_SESSION['success'] = "Material deleted successfully";
        $_SESSION['timeout'] = time();
        header("location: ../views/all-materials.php");
        exit();  
    } else {
        $_SESSION['delete_fail'] = "Request failed: Please try again later.";
    } 
}

//Delete a user From database
if( isset($_GET['userdelid']) ) {
    $delId = htmlspecialchars($_GET['userdelid']);
    $sql_del = 'DELETE FROM users WHERE user_id=?';
    $stmt_del = $conn->stmt_init();
    $stmt_del = $conn->prepare($sql_del);
    $stmt_del->bind_param("s", $delId);    

    if ( $stmt_del->execute() ) {
        $_SESSION['success'] = "User deleted successfully";
        $_SESSION['timeout'] = time();
        header("location: ../views/all-users.php");
        exit();  
    } else {
        $_SESSION['delete_fail'] = "Request failed: Please try again later.";
    } 
}

//Delete a customer From database
if( isset($_GET['custdelid']) ) {
    $delId = htmlspecialchars($_GET['custdelid']);
    $sql_del = 'DELETE FROM customers WHERE cust_id=?';
    $stmt_del = $conn->stmt_init();
    $stmt_del = $conn->prepare($sql_del);
    $stmt_del->bind_param("s", $delId);    

    if ( $stmt_del->execute() ) {
        $_SESSION['success'] = "Customer deleted successfully";
        $_SESSION['timeout'] = time();
        header("location: ../views/all-customers.php");
        exit();  
    } else {
        $_SESSION['delete_fail'] = "Request failed: Please try again later.";
    } 
}

//Delete a supplier From database
if( isset($_GET['supdelid']) ) {
    $delId = htmlspecialchars($_GET['supdelid']);
    $sql_del = 'DELETE FROM suppliers WHERE sup_id=?';
    $stmt_del = $conn->stmt_init();
    $stmt_del = $conn->prepare($sql_del);
    $stmt_del->bind_param("s", $delId);    

    if ( $stmt_del->execute() ) {
        $_SESSION['success'] = "Supplier deleted successfully";
        $_SESSION['timeout'] = time();
        header("location: ../views/all-suppliers.php");
        exit();  
    } else {
        $_SESSION['delete_fail'] = "Request failed: Please try again later.";
    } 
}