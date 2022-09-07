<?php
session_start();
require '../path.php';
include(ABSPATH . 'model/db.php');

if( isset($_GET['cartid']) ) {
    $cartId = htmlspecialchars($_GET['cartid']);
    $cartprodid = $_POST['id'];
    $cartprodqty = $_POST['qty'];
    $cartprodsaleprice = $_POST['amount'];
    $cartprodamount = $cartprodsaleprice * $cartprodqty;
    $cartuser = $_SESSION['role'];
    $cartprodname = $_POST['name'];
    $todaysDate = date("Y-m-d");

    $sql_ins = "INSERT INTO cart (cart_sku_id, cart_prod_qty, cart_prod_sale_price, cart_prod_amount, cart_user, cart_date) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt_ins = $conn->stmt_init();
    $stmt_ins = $conn->prepare($sql_ins);
    $stmt_ins->bind_param("ssssss", $cartprodid, $cartprodqty, $cartprodsaleprice, $cartprodamount, $cartuser, $todaysDate);    

    if ( $stmt_ins->execute() ) {
        $_SESSION['success'] = $cartprodname . " added to cart successfully";
        $_SESSION['timeout'] = time();
    } else {
        $_SESSION['cart_add_fail'] = "Request failed: Please try again later.";
    }
    
    $response = [
        "id" => $_POST['id'],
        "qty" => $_POST['qty'],
        "sale_price" => $_POST['amount'],
        "prod_name" => $_POST['name'],
        "user" => $_SESSION['role']
    ];

    echo json_encode($response);
}
