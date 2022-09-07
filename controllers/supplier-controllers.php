<?php

//store error variables
$errors = array();

$supfirstname = "";
$suplastname = "";
$supemail = "";
$supcoyname = "";
$supaddy = "";
$supphone = "";

//get the customer details on submit and validate
if ( isset( $_POST['add-supplier'] ) ) {
    $supfirstname = filter_var($_POST['sup-fname'], FILTER_SANITIZE_STRING);
    $suplastname = filter_var($_POST['sup-lname'], FILTER_SANITIZE_STRING);
    $supemail = filter_var($_POST['sup-email'], FILTER_SANITIZE_EMAIL);
    $supcoyname = filter_var($_POST['sup-coy-name'], FILTER_SANITIZE_STRING);
    $supaddy = filter_var($_POST['sup-addy'], FILTER_SANITIZE_STRING);
    $supphone = filter_var($_POST['sup-phone'], FILTER_SANITIZE_STRING);

    //validation
    if ( empty($supfirstname) ) {
        $errors['supfname'] = "First Name Required";
    }
    if ( !preg_match("/^[A-Za-z]+(((\'|\-)?([A-Za-z])+))?$/", $supfirstname) && !empty($supfirstname) ) {
        $errors['supfname'] = "First name is invalid";
    }
    if ( empty($suplastname) ) {
        $errors['suplname'] = "Last Name required";
    }
    if ( !preg_match("/^[A-Za-z]+(((\'|\-)?([A-Za-z])+))?$/", $suplastname) && !empty($suplastname)  ) {
        $errors['supfname'] = "Last Name is invalid";
    }
    if ( empty($supemail) ) {
        $errors['supemail'] = "Supplier Email required";
    }
    if ( !filter_var($supemail, FILTER_VALIDATE_EMAIL) && !empty($supemail)  ) {
        $errors['supemail'] = "Email address is invalid";
    }
    if ( empty($supphone) ) {
        $errors['supphone'] = "Phone Number required";
    }
    if ( !preg_match("/(^[0-9]*$)|(^[\+]?[234]\d{12}$)/", $supphone) && !empty($supphone)  ) {
        $errors['supphone'] = "Phone Number is invalid";
    }
    if ( empty($supcoyname) ) {
        $errors['supcoyname'] = "Supplier Company Name is required";
    }
    if ( empty($supaddy) ) {
        $errors['supaddy'] = "Supplier Address is required";
    }

    if ( count($errors) === 0 ) {
        $sql = "INSERT INTO suppliers (sup_fname, sup_lname, sup_coy_name, sup_addy, sup_phone, sup_email) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssssss', $supfirstname, $suplastname, $supcoyname, $supaddy, $supphone, $supemail);

        if ( $stmt->execute() ) {
            $supfirstname = "";
            $suplastname = "";
            $supemail = "";
            $supcoyname = "";
            $supaddy = "";
            $supphone = "";      

            $success['sup_add_success'] = "Supplier Registered Successfully";
        } else {
            $errors['sup_add_fail'] = "Supplier registration failed: Please try again later";
        }
    } else {
        $errors['sup_add_fail'] = "One or more fields has errors.";
    }

}

//Update customer details STEP 1: Get data from DB
if ( isset($_GET['seid']) ) {
    $supId = htmlspecialchars($_GET['seid']);

    $dataQuery = "SELECT * FROM suppliers WHERE sup_id=? LIMIT 1";
    $stmt = $conn->prepare($dataQuery); 
    $stmt->bind_param("s", $supId);
    $stmt->execute();
    $result = $stmt->get_result();
    $supplier = $result->fetch_assoc();

    $supfirstname = $supplier['sup_fname'];
    $suplastname = $supplier['sup_lname'];
    $supemail = $supplier['sup_email'];
    $supcoyname = $supplier['sup_coy_name'];
    $supaddy = $supplier['sup_addy'];
    $supphone = $supplier['sup_phone'];
}

//Update customer details STEP 2: update DB
if ( isset( $_POST['edit-supplier'] ) ) {
    $supfirstname = filter_var($_POST['sup-fname'], FILTER_SANITIZE_STRING);
    $suplastname = filter_var($_POST['sup-lname'], FILTER_SANITIZE_STRING);
    $supemail = filter_var($_POST['sup-email'], FILTER_SANITIZE_EMAIL);
    $supcoyname = filter_var($_POST['sup-coy-name'], FILTER_SANITIZE_STRING);
    $supaddy = filter_var($_POST['sup-addy'], FILTER_SANITIZE_STRING);
    $supphone = filter_var($_POST['sup-phone'], FILTER_SANITIZE_STRING);
    $supId = $_POST['sup-id'];

    //validation
    if ( empty($supfirstname) ) {
        $errors['supfname'] = "First Name Required";
    }
    if ( !preg_match("/^[A-Za-z]+(((\'|\-)?([A-Za-z])+))?$/", $supfirstname) && !empty($supfirstname) ) {
        $errors['supfname'] = "First name is invalid";
    }
    if ( empty($suplastname) ) {
        $errors['suplname'] = "Last Name required";
    }
    if ( !preg_match("/^[A-Za-z]+(((\'|\-)?([A-Za-z])+))?$/", $suplastname) && !empty($suplastname)  ) {
        $errors['supfname'] = "Last Name is invalid";
    }
    if ( empty($supemail) ) {
        $errors['supemail'] = "Supplier Email required";
    }
    if ( !filter_var($supemail, FILTER_VALIDATE_EMAIL) && !empty($supemail)  ) {
        $errors['supemail'] = "Email address is invalid";
    }
    if ( empty($supphone) ) {
        $errors['supphone'] = "Phone Number required";
    }
    if ( !preg_match("/(^[0-9]*$)|(^[\+]?[234]\d{12}$)/", $supphone) && !empty($supphone)  ) {
        $errors['supphone'] = "Phone Number is invalid";
    }
    if ( empty($supcoyname) ) {
        $errors['supcoyname'] = "Supplier Company Name is required";
    }
    if ( empty($supaddy) ) {
        $errors['supaddy'] = "Supplier Address is required";
    }
  
    if ( count($errors) === 0 ) {
        $sql = "UPDATE suppliers SET sup_fname=?, sup_lname=?, sup_coy_name=?, sup_addy=?, sup_phone=?, sup_email=? WHERE sup_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssssss', $supfirstname, $suplastname, $supcoyname, $supaddy, $supphone, $supemail, $supId );    

        if ( $stmt->execute() ) {
            $success['sup_edit_success'] = "Supplier Details Updated Successfully";
        } else {
            $errors['sup_edit_fail'] = "Supplier Update failed: Please try again later";
        }   
    } else {
        $errors['sup_edit_fail'] = "One or more fields have errors.";
    }
}