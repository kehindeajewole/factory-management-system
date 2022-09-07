<?php
  require 'header.php';
  require_once(ABSPATH . 'controllers/product-controllers.php');
?>
    <div class="container-fluid body-main py-4">
    <div class="row">
        <div class="container-fluid">
        <div class="py-1">
            <h1 class="mb-0 text-white">Edit Product</h1>
        </div>
        </div>
        <!-- Data content start-->
        <div class="container-fluid">
            <div class="card p-4">
            <div class="row">
                <div class="col-md-6">
                <form action="edit-product.php?peid=<?php echo $_GET['peid']; ?>" method="post">
                    <?php if ( count($errors) === 0 && !empty($success['prod_edit_success']) ): ?>
                        <div class="gen-form-success"> <?php echo $success['prod_edit_success']; ?> </div>
                    <?php endif; ?>
                        <?php if ( count($errors) > 0 && !empty($errors['prod_edit_fail']) ): ?>
                        <div class="gen-form-errors"> <?php echo $errors['prod_edit_fail']; ?> </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <input type="hidden" name="prod-id" value="<?php echo $prodId ;?>">
                        <label for="prod-name" class="form-control-label">Product Name</label>
                        <select class="form-control" name="prod-name" id="prod-name">
                            <?php foreach ($prodnames as $value => $label): ?>
                                <option value="<?php echo $value; ?>" <?php if ( $prodname == $value) { echo 'selected'; } ?>>
                                    <?php echo $label; ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                        <?php if ( count($errors) > 0  && !empty($errors['prodname']) ): ?>
                            <div class="form-errors"> <?php echo $errors['prodname']; ?> </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="prod-cost" class="form-control-label">Cost of Production</label>
                        <input class="form-control" type="text" id="prod-cost" name="prod-cost" value="<?php echo $prodcost; ?>" >
                        <?php if ( count($errors) > 0  && !empty($errors['prodcost']) ): ?>
                            <div class="form-errors"> <?php echo $errors['prodcost']; ?> </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="prod-sale" class="form-control-label">Sale Price</label>
                        <input class="form-control" type="text" id="prod-sale" name="prod-sale" value="<?php echo $prodsale; ?>" >
                        <?php if ( count($errors) > 0  && !empty($errors['prodsale']) ): ?>
                            <div class="form-errors"> <?php echo $errors['prodsale']; ?> </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="prod-qty" class="form-control-label">Qty Produced</label>
                        <input class="form-control" type="text" id="prod-qty" name="prod-qty" value="<?php echo $prodqty; ?>" >
                        <?php if ( count($errors) > 0  && !empty($errors['prodqty']) ): ?>
                            <div class="form-errors"> <?php echo $errors['prodqty']; ?> </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="prod-date" class="form-control-label">Production Date</label>
                        <input class="form-control" type="date" id="prod-date" name="prod-date" value="<?php echo $proddate; ?>" >
                        <?php if ( count($errors) > 0  && !empty($errors['proddate']) ): ?>
                            <div class="form-errors"> <?php echo $errors['proddate']; ?> </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <input class="btn btn-fms my-4 btn-block" type="submit" value="Update Product" name="edit-product" >
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