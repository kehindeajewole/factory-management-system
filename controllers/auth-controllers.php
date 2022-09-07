<?php
session_start();

include(ABSPATH . 'model/db.php');

//store error variables
$errors = array();

$firstname = "";
$lastname = "";
$email = "";
$password = "";
$passwordconf = "";

//get the user details on registration submit and validate
if ( isset( $_POST['signup-submit'] ) ) {

    $firstname =  filter_var($_POST['first-name'], FILTER_SANITIZE_STRING);
    $lastname = filter_var($_POST['last-name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['user-email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['user-pass'];
    $passwordconf = $_POST['user-pass-conf'];

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
    if ( empty($passwordconf) ) {
        $errors['password-conf'] = "Re-confirm password";
    }
    if ( $password !== $passwordconf ) {
        $errors['password-conf'] = "Password do not match";
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
        $role = "user";

        $sql = "INSERT INTO users (user_first_name, user_last_name, user_email, password, role, token) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssssss', $firstname, $lastname, $email, $password, $role, $token);

        if ( $stmt->execute() ) {
            $user_id = $conn->insert_id;
            $_SESSION['id'] = $user_id;
            $_SESSION['firstname'] = $firstname;
            $_SESSION['lastname'] = $lastname;            

            header('location:'. BASE_URL . '/views/dashboard.php');
            exit();
        } else {
            $errors['login_fail'] = "Registration failed: Error connecting to server";
        }
    } else {
        $errors['login_fail'] = "One or more fields has errors.";
    }

}


//get the user details on login submit and validate
if ( isset( $_POST['login-submit'] ) ) {
    $email = filter_var($_POST['user-email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['user-pass'];

    //validation
    if ( empty($email) ) {
        $errors['email'] = "Email required";
    }
    if ( !filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($email)  ) {
        $errors['email'] = "Email address is invalid";
    }
    if ( empty($password) ) {
        $errors['password'] = "Password required";
    }

    if ( count($errors) === 0 ) {
    $sql = "SELECT * FROM users WHERE user_email=? LIMIT 1";
    $stmt = $conn->stmt_init();

    if(!$stmt->prepare($sql)){
        $errors['login_fail'] = "Login failed: Please try again later"; 
    } else {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
            if($user = $result->fetch_assoc()) {
                if( password_verify($password, $user['password']) ) {
                    $_SESSION['id'] = $user['user_id'];
                    $_SESSION['firstname'] = $user['user_first_name'];
                    $_SESSION['lastname'] = $user['user_last_name'];       
                    $_SESSION['role'] = $user['role'];
                    
                    if($_SESSION['role'] === "admin" || $_SESSION['role'] === "production" || $_SESSION['role'] === "accountant" || $_SESSION['role'] === "procurement" || $_SESSION['role'] === "sales"){
                        header('location:'. BASE_URL . '/views/dashboard.php');
                        exit();
                    }
                    
                } else {
                    $errors['login_fail'] = "Invalid email or password";
                }
            } else {
                $errors['login_fail'] = "Request failed: Please try again later";
            }
        }
    }
}    

//Logout the user
if ( isset( $_GET['admin-logout'] ) ) {
    session_destroy();
    unset( $_SESSION['id'] );
    unset( $_SESSION['firstname'] );
    unset( $_SESSION['lastname'] );
    unset( $_SESSION['role'] );
    header('location:'. BASE_URL . '/login.php');
    exit();
}
