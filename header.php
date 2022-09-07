<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>
      <?php if (strpos($_SERVER['REQUEST_URI'], "login") !== false) :?> FMS - Login <?php endif; ?>
      <?php if (strpos($_SERVER['REQUEST_URI'], "register") !== false) :?> FMS - Register <?php endif; ?>
      <?php if (strpos($_SERVER['REQUEST_URI'], "reset-message") !== false) :?> FMS - Reset Message <?php endif; ?>
      <?php if (strpos($_SERVER['REQUEST_URI'], "reset-password") !== false) :?> FMS - Reset Password <?php endif; ?>
      <?php if (strpos($_SERVER['REQUEST_URI'], "forgot-password") !== false) :?> FMS - Forgot Password <?php endif; ?>
  </title>
  <!-- Favicon -->
  <link rel="icon" href="assets/images/favicon.png" type="image/png">
  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
  <!-- Icons -->
  <link rel="stylesheet" href="assets/vendor/nucleo/css/nucleo.css" type="text/css">
  <link rel="stylesheet" href="assets/vendor/@fortawesome/fontawesome-free/css/all.min.css" type="text/css">
  <link rel="stylesheet" href="assets/css/app.css" type="text/css">
  <link rel="stylesheet" href="assets/css/style.css" type="text/css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
</head>