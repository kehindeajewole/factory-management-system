<?php
  require 'header.php';
  require_once(ABSPATH . 'controllers/product-controllers.php');
?>
    <div class="container-fluid body-main py-4">
    <div class="row">
        <div class="container-fluid">
        <div class="py-1">
            <h1 class="mb-0 text-white">Edit SKU</h1>
        </div>
        </div>
        <!-- Data content start-->
        <div class="container-fluid">
            <div class="card p-4">
            <div class="row">
                <div class="col-md-6">
                <form action="edit-sku.php?seid=<?php echo $_GET['seid']; ?>" method="post" enctype="multipart/form-data">
                    <?php if ( count($errors) === 0 && !empty($success['sku_edit_success']) ): ?>
                        <div class="gen-form-success"> <?php echo $success['sku_edit_success']; ?> </div>
                    <?php endif; ?>
                        <?php if ( count($errors) > 0 && !empty($errors['sku_edit_fail']) ): ?>
                        <div class="gen-form-errors"> <?php echo $errors['sku_edit_fail']; ?> </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label for="sku-image" class="form-control-label">SKU Image</label>
                        <div class="sku-image"><img src='../assets/images/<?php echo $skuimage ;?>' alt="<?php echo $skuname ; ?>" /></div>
                        <input type="hidden" name="sku-image-curr" value="<?php echo $skuimage ;?>">
                        <input class="form-control" type="file" id="sku-image" name="sku-image" >
                        <?php if ( count($errors) > 0 && !empty($errors['skuimage']) ): ?>
                            <div class="form-errors"> <?php echo $errors['skuimage']; ?> </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="sku-id" value="<?php echo $skuId ;?>">
                        <label for="sku-name" class="form-control-label">SKU Name</label>
                        <input class="form-control" type="text" id="sku-name" name="sku-name" value="<?php echo $skuname; ?>" >
                        <?php if ( count($errors) > 0  && !empty($errors['skuname']) ): ?>
                            <div class="form-errors"> <?php echo $errors['skuname']; ?> </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <input class="btn btn-fms my-4 btn-block" type="submit" value="Update SKU" name="edit-sku" >
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