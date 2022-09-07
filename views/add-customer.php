<?php
  require 'header.php';
  require_once(ABSPATH . 'controllers/customer-controllers.php');
?>
    <div class="container-fluid body-main py-4">
    <div class="row">
        <div class="container-fluid">
        <div class="py-1">
            <h1 class="mb-0 text-white">Add Customer</h1>
        </div>
        </div>
        <!-- Data content start-->
        <div class="container-fluid">
            <div class="card p-4">
            <div class="row">
                <div class="col-md-6">
                <form action="add-customer.php" method="post">
                    <?php if ( count($errors) === 0 && !empty($success['cust_add_success']) ): ?>
                        <div class="gen-form-success"> <?php echo $success['cust_add_success']; ?> </div>
                    <?php endif; ?>
                        <?php if ( count($errors) > 0 && !empty($errors['cust_add_fail']) ): ?>
                        <div class="gen-form-errors"> <?php echo $errors['cust_add_fail']; ?> </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label for="cust-fname" class="form-control-label">First Name</label>
                        <input class="form-control" type="text" id="cust-fname" name="cust-fname" value="<?php echo $firstname; ?>" >
                        <?php if ( count($errors) > 0  && !empty($errors['custfname']) ): ?>
                            <div class="form-errors"> <?php echo $errors['custfname']; ?> </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="cust-lname" class="form-control-label">Last Name</label>
                        <input class="form-control" type="text" id="cust-lname" name="cust-lname" value="<?php echo $lastname; ?>" >
                        <?php if ( count($errors) > 0  && !empty($errors['custlname']) ): ?>
                            <div class="form-errors"> <?php echo $errors['custlname']; ?> </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="coy-name" class="form-control-label">Company Name</label>
                        <input class="form-control" type="text" id="coy-name" name="coy-name" value="<?php echo $coyname; ?>" >
                        <?php if ( count($errors) > 0  && !empty($errors['coyname']) ): ?>
                            <div class="form-errors"> <?php echo $errors['coyname']; ?> </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="coy-addy" class="form-control-label">Company Address</label>
                        <input class="form-control" type="text" id="coy-addy" name="coy-addy" value="<?php echo $coyaddy; ?>" >
                        <?php if ( count($errors) > 0  && !empty($errors['coyaddy']) ): ?>
                            <div class="form-errors"> <?php echo $errors['coyaddy']; ?> </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="coy-email" class="form-control-label">Company Email</label>
                        <input class="form-control" type="text" id="coy-email" name="coy-email" value="<?php echo $coyemail; ?>" >
                        <?php if ( count($errors) > 0  && !empty($errors['coyemail']) ): ?>
                            <div class="form-errors"> <?php echo $errors['coyemail']; ?> </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="coy-phone" class="form-control-label">Company Phone</label>
                        <input class="form-control" type="text" id="coy-phone" name="coy-phone" value="<?php echo $coyphone; ?>" >
                        <?php if ( count($errors) > 0  && !empty($errors['coyphone']) ): ?>
                            <div class="form-errors"> <?php echo $errors['coyphone']; ?> </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <input class="btn btn-fms my-4 btn-block" type="submit" value="Add Customer" name="add-customer" >
                    </div>
                </form>
                </div>
            </div>
            </div>
        </div>            
        <!-- Data content end-->
    </div>
<?php
  require 'footer.php';
?>