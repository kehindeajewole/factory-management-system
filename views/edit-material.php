<?php
  require 'header.php';
  require_once(ABSPATH . 'controllers/material-controllers.php');
?>
    <div class="container-fluid body-main py-4">
    <div class="row">
        <div class="container-fluid">
        <div class="py-1">
            <h1 class="mb-0 text-white">Edit Material</h1>
        </div>
        </div>
        <!-- Data content start-->
        <div class="container-fluid">
            <div class="card p-4 mb-5">
            <div class="row">
                <div class="col-md-6">
                <form action="edit-material.php?meid=<?php echo $_GET['meid']; ?>" method="post">
                    <?php if ( count($errors) === 0 && !empty($success['mat_edit_success']) ): ?>
                        <div class="gen-form-success"> <?php echo $success['mat_edit_success']; ?> </div>
                    <?php endif; ?>
                        <?php if ( count($errors) > 0 && !empty($errors['mat_edit_fail']) ): ?>
                        <div class="gen-form-errors"> <?php echo $errors['mat_edit_fail']; ?> </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <input type="hidden" name="mat-id" value="<?php echo $matId ;?>">
                        <label for="mat-name" class="form-control-label">Item Name</label>
                        <input class="form-control" type="text" id="mat-name" name="mat-name" value="<?php echo $matname; ?>" >
                        <?php if ( count($errors) > 0  && !empty($errors['matname']) ): ?>
                            <div class="form-errors"> <?php echo $errors['matname']; ?> </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="sup-name" class="form-control-label">Supplier Name</label>
                        <select class="form-control" name="sup-name" id="sup-name">
                            <?php foreach ($supnames as $value => $label): ?>
                                <option value="<?php echo $value; ?>" <?php if ( $supname == $value) { echo 'selected'; } ?>>
                                    <?php echo $label; ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                        <?php if ( count($errors) > 0  && !empty($errors['supname']) ): ?>
                            <div class="form-errors"> <?php echo $errors['supname']; ?> </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="mat-cost" class="form-control-label">Cost of Purchase</label>
                        <input class="form-control" type="text" id="mat-cost" name="mat-cost" value="<?php echo $matcost; ?>" >
                        <?php if ( count($errors) > 0  && !empty($errors['matcost']) ): ?>
                            <div class="form-errors"> <?php echo $errors['matcost']; ?> </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="mat-qty" class="form-control-label">Quantity Supplied</label>
                        <input class="form-control" type="text" id="mat-qty" name="mat-qty" value="<?php echo $matqty; ?>" >
                        <?php if ( count($errors) > 0  && !empty($errors['matqty']) ): ?>
                            <div class="form-errors"> <?php echo $errors['matqty']; ?> </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <input class="btn btn-fms my-4 btn-block" type="submit" value="Edit Material" name="edit-material" >
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