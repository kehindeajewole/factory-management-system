<?php
  require 'header.php';
  require_once(ABSPATH . 'controllers/supplier-controllers.php');
?>
    <div class="container-fluid body-main py-4">
    <div class="row">
        <div class="container-fluid">
        <div class="py-1">
            <h1 class="mb-0 text-white">Edit Supplier</h1>
        </div>
        </div>
        <!-- Data content start-->
        <div class="container-fluid">
            <div class="card p-4">
            <div class="row">
                <div class="col-md-6">
                <form action="edit-supplier.php?seid=<?php echo $_GET['seid']; ?>" method="post">
                    <?php if ( count($errors) === 0 && !empty($success['sup_edit_success']) ): ?>
                        <div class="gen-form-success"> <?php echo $success['sup_edit_success']; ?> </div>
                    <?php endif; ?>
                        <?php if ( count($errors) > 0 && !empty($errors['sup_edit_fail']) ): ?>
                        <div class="gen-form-errors"> <?php echo $errors['sup_edit_fail']; ?> </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <input type="hidden" name="sup-id" value="<?php echo $supId ;?>">
                        <label for="sup-fname" class="form-control-label">First Name</label>
                        <input class="form-control" type="text" id="sup-fname" name="sup-fname" value="<?php echo $supfirstname; ?>" >
                        <?php if ( count($errors) > 0  && !empty($errors['supfname']) ): ?>
                            <div class="form-errors"> <?php echo $errors['supfname']; ?> </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="sup-lname" class="form-control-label">Last Name</label>
                        <input class="form-control" type="text" id="sup-lname" name="sup-lname" value="<?php echo $suplastname; ?>" >
                        <?php if ( count($errors) > 0  && !empty($errors['suplname']) ): ?>
                            <div class="form-errors"> <?php echo $errors['suplname']; ?> </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="sup-coy-name" class="form-control-label">Company Name</label>
                        <input class="form-control" type="text" id="sup-coy-name" name="sup-coy-name" value="<?php echo $supcoyname; ?>" >
                        <?php if ( count($errors) > 0  && !empty($errors['supcoyname']) ): ?>
                            <div class="form-errors"> <?php echo $errors['supcoyname']; ?> </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="sup-addy" class="form-control-label">Address</label>
                        <input class="form-control" type="text" id="sup-addy" name="sup-addy" value="<?php echo $supaddy; ?>" >
                        <?php if ( count($errors) > 0  && !empty($errors['supaddy']) ): ?>
                            <div class="form-errors"> <?php echo $errors['supaddy']; ?> </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="sup-email" class="form-control-label">Email</label>
                        <input class="form-control" type="text" id="sup-email" name="sup-email" value="<?php echo $supemail; ?>" >
                        <?php if ( count($errors) > 0  && !empty($errors['supemail']) ): ?>
                            <div class="form-errors"> <?php echo $errors['supemail']; ?> </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="sup-phone" class="form-control-label">Phone</label>
                        <input class="form-control" type="text" id="sup-phone" name="sup-phone" value="<?php echo $supphone; ?>" >
                        <?php if ( count($errors) > 0  && !empty($errors['supphone']) ): ?>
                            <div class="form-errors"> <?php echo $errors['supphone']; ?> </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <input class="btn btn-fms my-4 btn-block" type="submit" value="Update Supplier" name="edit-supplier" >
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