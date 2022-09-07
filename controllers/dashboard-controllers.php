<?php

//Users Queries
$usersQuery = "SELECT * FROM users";
$stmtUsers = $conn->prepare($usersQuery); 
$stmtUsers->execute();
$resultUsers = $stmtUsers->get_result();
$usersQueryCount= $resultUsers->num_rows;

//Suppliers Queries
$supQuery = "SELECT * FROM suppliers";
$stmtSup = $conn->prepare($supQuery); 
$stmtSup->execute();
$resultSup = $stmtSup->get_result();
$supQueryCount= $resultSup->num_rows;

//Customers Queries
$custQuery = "SELECT * FROM customers";
$stmtCust = $conn->prepare($custQuery); 
$stmtCust->execute();
$resultCust = $stmtCust->get_result();
$custQueryCount= $resultCust->num_rows;

//Products Queries
$prodQuery = "SELECT * FROM products";
$stmtProd = $conn->prepare($prodQuery); 
$stmtProd->execute();
$resultProd = $stmtProd->get_result();
$prodQueryCount= $resultProd->num_rows;

//Materials Queries
$matQuery = "SELECT * FROM materials";
$stmtMat = $conn->prepare($matQuery); 
$stmtMat->execute();
$resultMat = $stmtMat->get_result();
$matQueryCount= $resultMat->num_rows;

//Orders Queries
$orderQuery = "SELECT * FROM orders";
$stmtOrder = $conn->prepare($orderQuery); 
$stmtOrder->execute();
$resultOrder = $stmtOrder->get_result();
$orderQueryCount= $resultOrder->num_rows;

?>