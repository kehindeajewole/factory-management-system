<?php

//store error variables
$errors = array();

$firstname = "";
$lastname = "";
$coyemail = "";
$coyname = "";
$coyaddy = "";
$coyphone = "";

//get the customer details on submit and validate
if ( isset( $_POST['add-customer'] ) ) {
    $firstname = filter_var($_POST['cust-fname'], FILTER_SANITIZE_STRING);
    $lastname = filter_var($_POST['cust-lname'], FILTER_SANITIZE_STRING);
    $coyemail = filter_var($_POST['coy-email'], FILTER_SANITIZE_EMAIL);
    $coyname = filter_var($_POST['coy-name'], FILTER_SANITIZE_STRING);
    $coyaddy = filter_var($_POST['coy-addy'], FILTER_SANITIZE_STRING);
    $coyphone = filter_var($_POST['coy-phone'], FILTER_SANITIZE_STRING);

    //validation
    if ( empty($firstname) ) {
        $errors['custfname'] = "First name Required";
    }
    if ( !preg_match("/^[A-Za-z]+(((\'|\-)?([A-Za-z])+))?$/", $firstname) && !empty($firstname) ) {
        $errors['custfname'] = "First name is invalid";
    }
    if ( empty($lastname) ) {
        $errors['custlname'] = "Last name required";
    }
    if ( !preg_match("/^[A-Za-z]+(((\'|\-)?([A-Za-z])+))?$/", $lastname) && !empty($lastname)  ) {
        $errors['custfname'] = "Last name is invalid";
    }
    if ( empty($coyemail) ) {
        $errors['coyemail'] = "Company Email required";
    }
    if ( !filter_var($coyemail, FILTER_VALIDATE_EMAIL) && !empty($coyemail)  ) {
        $errors['coyemail'] = "Email address is invalid";
    }
    if ( empty($coyphone) ) {
        $errors['coyphone'] = "Compnay Phone Number required";
    }
    if ( !preg_match("/(^[0-9]*$)|(^[\+]?[234]\d{12}$)/", $coyphone) && !empty($coyphone)  ) {
        $errors['coyphone'] = "Company Phone Number is invalid";
    }
    if ( empty($coyname) ) {
        $errors['coyname'] = "Company Name is required";
    }
    if ( empty($coyaddy) ) {
        $errors['coyaddy'] = "Company Address is required";
    }

    if ( count($errors) === 0 ) {
        $sql = "INSERT INTO customers (cust_fname, cust_lname, coy_name, coy_addy, coy_phone, coy_email) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssssss', $firstname, $lastname, $coyname, $coyaddy, $coyphone, $coyemail);

        if ( $stmt->execute() ) {
            $firstname = "";
            $lastname = "";
            $coyemail = "";
            $coyname = "";
            $coyaddy = "";
            $coyphone = "";       

            $success['cust_add_success'] = "Customer Registration Successful";
        } else {
            $errors['cust_add_fail'] = "Customer registration failed: Please try again later";
        }
    } else {
        $errors['cust_add_fail'] = "One or more fields has errors.";
    }

}

//Update customer details STEP 1: Get data from DB
if ( isset($_GET['ceid']) ) {
    $custId = htmlspecialchars($_GET['ceid']);

    $dataQuery = "SELECT * FROM customers WHERE cust_id=? LIMIT 1";
    $stmt = $conn->prepare($dataQuery); 
    $stmt->bind_param("s", $custId);
    $stmt->execute();
    $result = $stmt->get_result();
    $customer = $result->fetch_assoc();

    $firstname = $customer['cust_fname'];
    $lastname = $customer['cust_lname'];
    $coyemail = $customer['coy_email'];
    $coyname = $customer['coy_name'];
    $coyaddy = $customer['coy_addy'];
    $coyphone = $customer['coy_phone'];
}

//Update customer details STEP 2: update DB
if ( isset( $_POST['edit-customer'] ) ) {
    $firstname = filter_var($_POST['cust-fname'], FILTER_SANITIZE_STRING);
    $lastname = filter_var($_POST['cust-lname'], FILTER_SANITIZE_STRING);
    $coyemail = filter_var($_POST['coy-email'], FILTER_SANITIZE_EMAIL);
    $coyname = filter_var($_POST['coy-name'], FILTER_SANITIZE_STRING);
    $coyaddy = filter_var($_POST['coy-addy'], FILTER_SANITIZE_STRING);
    $coyphone = filter_var($_POST['coy-phone'], FILTER_SANITIZE_STRING);
    $custId = $_POST['cust-id'];

    //validation
    if ( empty($firstname) ) {
        $errors['custfname'] = "First name Required";
    }
    if ( !preg_match("/^[A-Za-z]+(((\'|\-)?([A-Za-z])+))?$/", $firstname) && !empty($firstname) ) {
        $errors['custfname'] = "First name is invalid";
    }
    if ( empty($lastname) ) {
        $errors['custlname'] = "Last name required";
    }
    if ( !preg_match("/^[A-Za-z]+(((\'|\-)?([A-Za-z])+))?$/", $lastname) && !empty($lastname)  ) {
        $errors['custfname'] = "Last name is invalid";
    }
    if ( empty($coyemail) ) {
        $errors['coyemail'] = "Company Email required";
    }
    if ( !filter_var($coyemail, FILTER_VALIDATE_EMAIL) && !empty($coyemail)  ) {
        $errors['coyemail'] = "Email address is invalid";
    }
    if ( empty($coyphone) ) {
        $errors['coyphone'] = "Compnay Phone Number required";
    }
    if ( !preg_match("/(^[0-9]*$)|(^[\+]?[234]\d{12}$)/", $coyphone) && !empty($coyphone)  ) {
        $errors['coyphone'] = "Company Phone Number is invalid";
    }
    if ( empty($coyname) ) {
        $errors['coyname'] = "Company Name is required";
    }
    if ( empty($coyaddy) ) {
        $errors['coyaddy'] = "Company Address is required";
    }
  
    if ( count($errors) === 0 ) {
        $sql = "UPDATE customers SET cust_fname=?, cust_lname=?, coy_name=?, coy_addy=?, coy_phone=?, coy_email=? WHERE cust_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssssss', $firstname, $lastname, $coyname, $coyaddy, $coyphone, $coyemail, $custId );    

        if ( $stmt->execute() ) {
            $success['cust_edit_success'] = "Customer Details Updated Successfully";
        } else {
            $errors['cust_edit_fail'] = "Customer Update failed: Please try again later";
        }   
    } else {
        $errors['cust_edit_fail'] = "One or more fields have errors.";
    }
}