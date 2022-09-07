<?php
    require 'header.php';
    $prodsQuery = "SELECT * FROM products INNER JOIN skus ON products.prod_name = skus.sku_id";
    $stmtProds = $conn->prepare($prodsQuery); 
    $stmtProds->execute();
    $resultProds = $stmtProds->get_result();
    $prodsQueryCount= $resultProds->num_rows;

    $counter = 1;
    //unset success message after deleting customer
    if( isset($_SESSION['timeout']) ) {
        if ( time() > ($_SESSION['timeout'] + 3 )){
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
                <h1 class="mb-0 text-white">All Products</h1>
            </div>
        </div>
    <!-- Content Start -->
    <div class="card">
        <div class="py-4">
            <div class="title-btn">
                <div><a class="btn btn-fms my-sm-4" href="add-product.php" role="button">+ Add New Product</a></div>
                <div><a class="btn btn-fms my-sm-4" href="all-skus.php" role="button">+ View All SKUs</a></div>
                <div><a class="btn btn-fms my-sm-4" href="add-sku.php" role="button">+ Add SKU</a></div>
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
                        <th scope="col" class="sort">Product Name</th>
                        <th scope="col" class="sort">Cost of Production (₦)</th>
                        <th scope="col" class="sort">Selling Price (₦)</th>
                        <th scope="col" class="sort">Qty Produced</th>
                        <th scope="col" class="sort">Production Date</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody class="list">
                    <?php if( $prodsQueryCount > 0 ) :?>
                    <?php while ( $row = $resultProds->fetch_assoc() ): ?>
                    <tr>
                        <td>
                            <?php echo $counter; ?>
                        </td>
                        <td>
                            <?php echo $row["sku_name"] ; ?>
                        </td>
                        <td>
                            <?php echo $row["prod_cost"]; ?>
                        </td>
                        <td>
                            <?php echo $row["prod_sale"]; ?>
                        </td>
                        <td>
                            <?php echo $row["prod_qty"]; ?>
                        </td>
                        <td>
                            <?php echo date('d-M-Y', strtotime($row['prod_manu_date'])); ?>
                        </td>
                        <td class="text-right">
                            <div class="table-btn">
                                <a class="table-btn-edit" href="edit-product.php?peid=<?php echo $row['prod_id']; ?>">Edit</a>
                                <a id="del-inv" class="table-btn-del" href="../controllers/delete-controllers.php?proddelid=<?php echo $row['prod_id']; ?>">Delete</a>
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