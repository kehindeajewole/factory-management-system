<?php

//store error variables
$errors = array();

$matname = "";
$supname = "";
$matcost = "";
$matqty = "";
$todaysDate = date("Y-m-d");

$supnames = [
    '' => 'Select Supplier',
];

$supQuery = "SELECT * FROM suppliers";
$stmtSup = $conn->prepare($supQuery); 
$stmtSup->execute();
$resultSup = $stmtSup->get_result();
$supQueryCount= $resultSup->num_rows;

if( $supQueryCount > 0 ) :
   while ( $row = $resultSup->fetch_assoc() ):
      $supnames += [$row["sup_id"] => $row["sup_fname"]." ".$row["sup_lname"]."(".$row["sup_coy_name"].")"];
   endwhile;
endif ;

//get the materials details on submit and validate
if ( isset( $_POST['add-material'] ) ) {
    $matname = filter_var($_POST['mat-name'], FILTER_SANITIZE_STRING);
    $supname = filter_var($_POST['sup-name'], FILTER_SANITIZE_STRING);
    $matcost = filter_var($_POST['mat-cost'], FILTER_SANITIZE_STRING);
    $matqty = filter_var($_POST['mat-qty'], FILTER_SANITIZE_STRING);
 
    //validation
    if ( empty($matname) ) {
        $errors['matname'] = "Item name is required";
    }
    if ( empty($supname) ) {
        $errors['supname'] = "Supplier name is required";
    }
    if ( empty($matcost) ) {
        $errors['matcost'] = "Cost of Purchase is required";
    }
    if ( !preg_match("/(^[0-9]*$)/", $matcost) && !empty($matcost) ) {
        $errors['matcost'] = "Please enter a valid integer";
    }
    if ( empty($matqty) ) {
        $errors['matqty'] = "Quantity Supplied is required";
    }
    if ( !preg_match("/(^[0-9]*$)/", $matqty) && !empty($matqty) ) {
        $errors['matqty'] = "Please enter a valid integer";
    } 
 
    if ( count($errors) === 0 ) {
        $matqtyout = 0;
        $matqtyleft = $matqty;

        $sql = "INSERT INTO materials (mat_name, mat_sup_id, mat_cost, mat_qty_total, mat_qty_out, mat_qty_left, mat_created_date) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssssss', $matname, $supname, $matcost, $matqty, $matqtyout, $matqtyleft, $todaysDate);
 
        if ( $stmt->execute() ) {
            $matname = "";
            $supname = "";
            $matcost = "";
            $matqty = ""; 
           
            $_SESSION['timeout'] = time();
            $_SESSION['success'] = "Materials added successfully";
           
            echo("<script>window.location = '".BASE_URL."/views/all-materials.php';</script>");
 
        } else {
            $errors['mat_add_fail'] = "Customer registration failed: Please try again later";
        }
    } else {
        $errors['mat_add_fail'] = "One or more fields has errors.";
    }
 
 }

//Edit materials details STEP 1: Get data from DB
if ( isset($_GET['meid']) ) {
    $matId = htmlspecialchars($_GET['meid']);

    $dataQuery = "SELECT * FROM materials WHERE mat_id=? LIMIT 1";
    $stmt = $conn->prepare($dataQuery); 
    $stmt->bind_param("s", $matId);
    $stmt->execute();
    $result = $stmt->get_result();
    $material = $result->fetch_assoc();

    $matname = $material['mat_name'];
    $supname = $material['mat_sup_id'];
    $matcost = $material['mat_cost'];
    $matqty = $material['mat_qty_total'];
}

//Edit materials details STEP 2: update DB
if ( isset( $_POST['edit-material'] ) ) {
    $matname = filter_var($_POST['mat-name'], FILTER_SANITIZE_STRING);
    $supname = filter_var($_POST['sup-name'], FILTER_SANITIZE_STRING);
    $matcost = filter_var($_POST['mat-cost'], FILTER_SANITIZE_STRING);
    $matqty = filter_var($_POST['mat-qty'], FILTER_SANITIZE_STRING);
    $matId = $_POST['mat-id'];

    //validation
    if ( empty($matname) ) {
        $errors['matname'] = "Item name is required";
    }
    if ( empty($supname) ) {
        $errors['supname'] = "Supplier name is required";
    }
    if ( empty($matcost) ) {
        $errors['matcost'] = "Cost of Purchase is required";
    }
    if ( !preg_match("/(^[0-9]*$)/", $matcost) && !empty($matcost) ) {
        $errors['matcost'] = "Please enter a valid integer";
    }
    if ( empty($matqty) ) {
        $errors['matqty'] = "Quantity Supplied is required";
    }
    if ( !preg_match("/(^[0-9]*$)/", $matqty) && !empty($matqty) ) {
        $errors['matqty'] = "Please enter a valid integer";
    } 
  
    if ( count($errors) === 0 ) {
        $matqtyout = 0;
        $matqtyleft = $matqty;

        $sql = "UPDATE materials SET mat_name=?, mat_sup_id=?, 	mat_cost=?, mat_qty_total=?, mat_qty_out=?, mat_qty_left=? WHERE mat_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssssss', $matname, $supname, $matcost, $matqty, $matqtyout, $matqtyleft, $matId);    

        if ( $stmt->execute() ) {
            $success['mat_edit_success'] = "Raw Materials Details Edited Successfully";
        } else {
            $errors['mat_edit_fail'] = "Raw Materials Edit failed: Please try again later";
        }   
    } else {
        $errors['mat_edit_fail'] = "One or more fields have errors.";
    }
}

//Update materials details STEP 1: Get data from DB
if ( isset($_GET['muid']) ) {
    $matId = htmlspecialchars($_GET['muid']);

    $dataQuery = "SELECT * FROM materials WHERE mat_id=? LIMIT 1";
    $stmt = $conn->prepare($dataQuery); 
    $stmt->bind_param("s", $matId);
    $stmt->execute();
    $result = $stmt->get_result();
    $material = $result->fetch_assoc();

    $matname = $material['mat_name'];
    $supname = $material['mat_sup_id'];
    $matcost = $material['mat_cost'];
    $matqty = $material['mat_qty_total'];
    $matqtyhid = $material['mat_qty_total'];
    $matused = $material['mat_qty_out'];
}

//Update materials details STEP 2: update DB
if ( isset( $_POST['update-material'] ) ) {
    $matqtyhid = filter_var($_POST['mat-qty-hid'], FILTER_SANITIZE_STRING);
    $matused = filter_var($_POST['mat-used'], FILTER_SANITIZE_STRING);
    $matId = $_POST['mat-id'];

    //validation
    if ( empty($matused) ) {
        $errors['matused'] = "Quantity used is required";
    }
    if ( !preg_match("/(^[0-9]*$)/", $matused) && !empty($matused) ) {
        $errors['matused'] = "Please enter a valid integer";
    }  
  
    if ( count($errors) === 0 ) {
        $matqtyleft = $matqtyhid - $matused;

        $sql = "UPDATE materials SET mat_qty_out=?, mat_qty_left=? WHERE mat_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sss', $matused, $matqtyleft, $matId);    

        if ( $stmt->execute() ) {
            $success['mat_update_success'] = "Raw Materials Details Updated Successfully";
        } else {
            $errors['mat_update_fail'] = "Raw Materials Update failed: Please try again later";
        }   
    } else {
        $errors['mat_update_fail'] = "One or more fields have errors.";
    }
}