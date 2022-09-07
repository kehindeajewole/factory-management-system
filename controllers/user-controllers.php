<?php

//store error variables
$errors = array();

$firstname = "";
$lastname = "";
$email = "";
$password = "";
$role= "";
$todaysDate = date("Y-m-d");
$roles= [
    '' => 'Select Role',
    'admin' => 'Admin',
    'production' => 'Production',
    'accountant' => 'Accountant',
    'procurement' => 'Procurement',
    'sales' => 'Sales',
];

//get the user details on submit and validate
if ( isset( $_POST['add-user'] ) ) {
    $firstname =  filter_var($_POST['first-name'], FILTER_SANITIZE_STRING);
    $lastname = filter_var($_POST['last-name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['user-pass'];
    $role = filter_var($_POST['role'], FILTER_SANITIZE_STRING);

    //validation
    if ( empty($firstname) ) {
        $errors['firstname'] = "First name Required";
    }
    if ( !preg_match("/^[A-Za-z]+(((\'|\-)?([A-Za-z])+))?$/", $firstname) && !empty($firstname) ) {
        $errors['firstname'] = "First name  is invalid";
    }
    if ( empty($lastname) ) {
        $errors['lastname'] = "Last name required";
    }
    if ( !preg_match("/^[A-Za-z]+(((\'|\-)?([A-Za-z])+))?$/", $lastname) && !empty($lastname)  ) {
        $errors['lastname'] = "Last name  is invalid";
    }
    if ( empty($email) ) {
        $errors['email'] = "Email required";
    }
    if ( !filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($email)  ) {
        $errors['email'] = "Email address is invalid";
    }
    if ( empty($password) ) {
        $errors['password'] = "Password required";
    }
    if ( $role === "" ) {
        $errors['role'] = "Select user role";
    }

    //check if email exists
    $emailQuery = "SELECT * FROM users WHERE user_email=? LIMIT 1";
    $stmt = $conn->prepare($emailQuery); 
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $userCount = $result->num_rows;
    if($userCount > 0) {
        $errors['email'] = "Email already exists";
    }

    if ( count($errors) === 0 ) {
        $password = password_hash( $password, PASSWORD_DEFAULT );
        $token = bin2hex( random_bytes(50) );

        $sql = "INSERT INTO users (user_first_name, user_last_name, user_email, password, role, token, user_created_date) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssssss', $firstname, $lastname, $email, $password, $role, $token, $todaysDate);

        if ( $stmt->execute() ) {
            $firstname = "";
            $lastname = "";
            $email = "";
            $password = "";
            $role= "";

            $success['user_add_success'] = "User Registered Successfully";       
        } else {
            $errors['user_add_fail'] = "User registration failed: Please try again later";
        }
    } else {
        $errors['user_add_fail'] = "One or more fields has errors.";
    }
}

//Update user details STEP 1: Get data from DB
if ( isset($_GET['ueid']) ) {
    $userId = htmlspecialchars($_GET['ueid']);

    $dataQuery = "SELECT * FROM users WHERE user_id=? LIMIT 1";
    $stmt = $conn->prepare($dataQuery); 
    $stmt->bind_param("s", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    $firstname = $user['user_first_name'];
    $lastname = $user['user_last_name'];
    $email = $user['user_email'];
    $role= $user['role'];
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

//Update user details STEP 2: update DB
if ( isset( $_POST['edit-user'] ) ) {
    $firstname =  filter_var($_POST['first-name'], FILTER_SANITIZE_STRING);
    $lastname = filter_var($_POST['last-name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $role = filter_var($_POST['role'], FILTER_SANITIZE_STRING);
    $userId = $_POST['user-id'];

    //validation
    if ( empty($firstname) ) {
        $errors['firstname'] = "First name Required";
    }
    if ( !preg_match("/^[A-Za-z]+(((\'|\-)?([A-Za-z])+))?$/", $firstname) && !empty($firstname) ) {
        $errors['firstname'] = "First name  is invalid";
    }
    if ( empty($lastname) ) {
        $errors['lastname'] = "Last name required";
    }
    if ( !preg_match("/^[A-Za-z]+(((\'|\-)?([A-Za-z])+))?$/", $lastname) && !empty($lastname)  ) {
        $errors['lastname'] = "Last name  is invalid";
    }
    if ( empty($email) ) {
        $errors['email'] = "Email required";
    }
    if ( !filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($email)  ) {
        $errors['email'] = "Email address is invalid";
    }
    if ( $role === "" ) {
        $errors['role'] = "Select user role";
    }
  
    if ( count($errors) === 0 ) {
        $sql = "UPDATE users SET user_first_name=?, user_last_name=?, user_email=?, role=? WHERE user_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssss', $firstname, $lastname, $email, $role, $userId );    

        if ( $stmt->execute() ) {
            $success['user_edit_success'] = "User Details Updated Successfully";
        } else {
            $errors['user_edit_fail'] = "User Update failed: Please try again later";
        }   
    } else {
        $errors['user_edit_fail'] = "One or more fields have errors.";
    }
}