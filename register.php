<?php
    require 'path.php';
    require_once(ABSPATH . 'controllers/auth-controllers.php');
    include 'header.php';
    
    //Unset success session after password reset
    if( isset($_SESSION['timeout']) ) {
        if (  time() > ($_SESSION['timeout'] + 3 )){
            unset($_SESSION['success']);
            unset($_SESSION['timeout']);
        } 
    }
?>

<body>
  <div class="container my-5">
    <div class="row justify-content-center">
      <div class="col-sm-10 text-center">
        <a href="/"><img src="assets/images/FMS_Logo.png" alt="Factory Management System Logo"></a>
        <h1 class="pt-5">Welcome, manage your business like a boss</h1>
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-sm-6 mt-3">
      <p class="app-text-bold">Sign up for a free account</p>
      <?php if ( count($errors) > 0 && !empty($errors['login_fail']) ): ?>
          <div class="gen-form-errors alert alert-danger" role="alert"> <?php echo $errors['login_fail']; ?> </div>
      <?php endif; ?>
      <?php if ( isset($_SESSION['success']) ): ?>
          <div class="gen-form-success alert alert-success" role="alert"> <?php echo $_SESSION['success']; ?> </div>
      <?php endif; ?>
      <form role="form" action="register.php" method="post">
      <div class="mb-3">
          <label for="first-name" class="form-label">First Name</label>
          <input class="form-control" id="first-name" type="text" name="first-name" value="<?php echo $firstname; ?>">
          <div class="form-text">
              <?php if ( count($errors) > 0 && !empty($errors['firstname']) ): ?>
                  <div class="form-errors"> <?php echo $errors['firstname']; ?> </div>
              <?php endif; ?>
          </div>
        </div>
        <div class="mb-3">
          <label for="last-name" class="form-label">Last Name</label>
          <input class="form-control" id="last-name" type="text" name="last-name" value="<?php echo $lastname; ?>">
          <div class="form-text">
              <?php if ( count($errors) > 0 && !empty($errors['lastname']) ): ?>
                  <div class="form-errors"> <?php echo $errors['lastname']; ?> </div>
              <?php endif; ?>
          </div>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email address</label>
          <input class="form-control" id="email" type="email" name="user-email" value="<?php echo $email; ?>">
          <div class="form-text">
              <?php if ( count($errors) > 0 && !empty($errors['email']) ): ?>
                  <div class="form-errors"> <?php echo $errors['email']; ?> </div>
              <?php endif; ?>
          </div>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input class="form-control" id="password" type="password" name="user-pass" value="<?php echo $password; ?>">
          <div class="form-text">
              <?php if ( count($errors) > 0  && !empty($errors['password']) ): ?>
                  <div class="form-errors"> <?php echo $errors['password']; ?> </div>
              <?php endif; ?>
          </div>
        </div>
        <div class="mb-3">
          <label for="confirm-password" class="form-label">Confirm Password</label>
          <input class="form-control" id="confirm-password" type="password" name="user-pass-conf" value="<?php echo $passwordconf; ?>">
          <div class="form-text">
              <?php if ( count($errors) > 0  && !empty($errors['password-conf']) ): ?>
                  <div class="form-errors"> <?php echo $errors['password-conf']; ?> </div>
              <?php endif; ?>
          </div>
        </div>
        <button type="submit" class="btn btn-fms btn-block" name="signup-submit">Create account</button>
      </form>
      <div class="row mt-3">
        <div class="col-6 gen-text-color">
            <small>Have an account already? <a href="login.php">Log In</small></a>
        </div>
      </div>
      </div>
    </div>

    </div>
  </div>

<?php
    include 'footer.php';
?>