<?php
    require 'header.php';
    $skuQuery = "SELECT * FROM skus";
    $stmtSku = $conn->prepare($skuQuery); 
    $stmtSku->execute();
    $resultSku = $stmtSku->get_result();
    $skuQueryCount= $resultSku->num_rows;

    $counter = 1;
  
    //unset success message after deleting customer
    if( isset($_SESSION['timeout']) ) {
        if (  time() > ($_SESSION['timeout'] + 3 )){
            unset($_SESSION['success']);
            unset($_SESSION['timeout']);
        } 
    }
    if( isset($_SESSION['delete_fail']) ) {
        unset($_SESSION['delete_fail']);
    }  
?>
<div class="container-fluid body-main py-4">
    <div class="row">
        <div class="container-fluid">
            <div class="py-1">
                <h1 class="mb-0 text-white">All SKUs</h1>
            </div>
        </div>
    <!-- Content Start -->
    <div class="card">
        <div class="py-4">
            <div class="title-btn">
                <div><a class="btn btn-fms my-sm-4" href="add-sku.php" role="button">+ Add New SKU</a></div>
                <div><a class="btn btn-fms my-sm-4" href="all-products.php" role="button">View All Products</a></div>
            </div>
            <div class="col-sm-3">
            <?php if ( isset($_SESSION['success']) ): ?>
                <div class="gen-form-success"> <?php echo $_SESSION['success']; ?> </div>
            <?php endif; ?>
            <?php if ( isset($_SESSION['delete_fail']) ): ?>
                <div class="gen-form-errors"> <?php echo $_SESSION['delete_fail']; ?> </div>
            <?php endif; ?>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th scope="col" class="sort">S/N</th>
                        <th scope="col" class="sort">SKU Name</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody class="list">
                    <?php if( $skuQueryCount > 0 ) :?>
                    <?php while ( $row = $resultSku->fetch_assoc() ): ?>
                    <tr>
                        <td>
                            <?php echo $counter; ?>
                        </td>
                        <td>
                            <?php echo $row["sku_name"]; ?>
                        </td>
                        <td class="text-right">
                            <div class="table-btn">
                                <a class="table-btn-edit" href="edit-sku.php?seid=<?php echo $row['sku_id']; ?>">Edit</a>
                                <a id="del-inv" class="table-btn-del" href="../controllers/delete-controllers.php?skudelid=<?php echo $row['sku_id']; ?>">Delete</a>
                            </div>
                        </td>
                    </tr>
                    <?php $counter++ ; ?>  
                    <?php endwhile; ?>
                    <?php endif ; ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Content End -->    
</div>

<?php
  require 'footer.php';
?>