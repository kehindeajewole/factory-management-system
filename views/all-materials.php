<?php
    require 'header.php';
    $matQuery = "SELECT * FROM materials INNER JOIN suppliers ON materials.mat_sup_id = suppliers.sup_id";
    $stmtMat = $conn->prepare($matQuery); 
    $stmtMat->execute();
    $resultMat = $stmtMat->get_result();
    $matQueryCount= $resultMat->num_rows;

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
                <h1 class="mb-0 text-white">All Materials</h1>
            </div>
        </div>
    <!-- Content Start -->
    <div class="card">
        <div class="py-4 col-sm-3">
            <?php if ($_SESSION['role'] === "admin" || $_SESSION['role'] === "procurement" ) :?>
            <a class="btn btn-fms my-4" href="add-material.php" role="button">+ Add Raw Material</a>
            <?php endif; ?>
            <?php if ( isset($_SESSION['success']) ): ?>
                <div class="gen-form-success"> <?php echo $_SESSION['success']; ?> </div>
            <?php endif; ?>
            <?php if ( isset($_SESSION['delete_fail']) ): ?>
                <div class="gen-form-errors"> <?php echo $_SESSION['delete_fail']; ?> </div>
            <?php endif; ?>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th scope="col" class="sort">S/N</th>
                        <th scope="col" class="sort">Item Name</th>
                        <th scope="col" class="sort">Supplier Name</th>
                        <th scope="col" class="sort">Cost of Purchase(₦)</th>
                        <th scope="col" class="sort">Quantity Supplied</th>
                        <th scope="col" class="sort">Quantity Used</th>
                        <th scope="col" class="sort">Quantity Left</th>
                        <th scope="col" class="sort">Supplied Date</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody class="list">
                    <?php if( $matQueryCount > 0 ) :?>
                    <?php while ( $row = $resultMat->fetch_assoc() ): ?>
                    <tr>
                        <td>
                            <?php echo $counter; ?>
                        </td>
                        <td>
                            <?php echo $row["mat_name"]; ?>
                        </td>
                        <td>
                            <?php echo $row["sup_fname"]." ".$row["sup_lname"]." (".$row["sup_coy_name"].")" ; ?>
                        </td>
                        <td>
                            <?php echo number_format($row["mat_cost"]); ?>
                        </td>
                        <td>
                            <?php echo $row["mat_qty_total"]; ?>
                        </td>
                        <td>
                            <?php echo $row["mat_qty_out"]; ?>
                        </td>
                        <td>
                            <?php echo $row["mat_qty_left"]; ?>
                        </td>
                        <td>
                            <?php echo date('d-M-Y', strtotime($row["mat_created_date"])); ?>
                        </td>
                        <td class="text-right">
                        <?php if ($_SESSION['role'] === "admin" || $_SESSION['role'] === "procurement" ) :?>
                            <div class="table-btn">
                                <a class="table-btn-edit" href="edit-material.php?meid=<?php echo $row['mat_id']; ?>">Edit</a>
                                <a class="table-btn-edit" href="update-material.php?muid=<?php echo $row['mat_id']; ?>">Update</a>
                                <a id="del-inv" class="table-btn-del" href="../controllers/delete-controllers.php?matdelid=<?php echo $row['mat_id']; ?>">Delete</a>
                            </div>
                            <?php endif; ?>
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