<?php
    require 'header.php';
    $supQuery = "SELECT * FROM suppliers";
    $stmtSup = $conn->prepare($supQuery); 
    $stmtSup->execute();
    $resultSup = $stmtSup->get_result();
    $supQueryCount= $resultSup->num_rows;

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
                <h1 class="mb-0 text-white">All Suppliers</h1>
            </div>
        </div>
    <!-- Content Start -->
    <div class="card">
        <div class="py-4 col-sm-3">
            <?php if ($_SESSION['role'] === "admin" || $_SESSION['role'] === "procurement" ) :?>
            <a class="btn btn-fms my-4" href="add-supplier.php" role="button">+ Add Supplier</a>
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
                        <th scope="col" class="sort">Full Name</th>
                        <th scope="col" class="sort">Company Name</th>
                        <th scope="col" class="sort">Address</th>
                        <th scope="col" class="sort">Email</th>
                        <th scope="col" class="sort">Phone</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody class="list">
                    <?php if( $supQueryCount > 0 ) :?>
                    <?php while ( $row = $resultSup->fetch_assoc() ): ?>
                    <tr>
                        <td>
                            <?php echo $counter; ?>
                        </td>
                        <td>
                            <?php echo $row["sup_fname"] . " " . $row["sup_lname"] ; ?>
                        </td>
                        <td>
                            <?php echo $row["sup_coy_name"]; ?>
                        </td>
                        <td class="table-addy">
                            <?php echo $row["sup_addy"]; ?>
                        </td>
                        <td>
                            <?php echo $row["sup_email"]; ?>
                        </td>
                        <td>
                            <?php echo $row["sup_phone"]; ?>
                        </td>
                        <td class="text-right">
                            <?php if ($_SESSION['role'] === "admin" || $_SESSION['role'] === "procurement" ) :?>
                            <div class="table-btn">
                                <a class="table-btn-edit" href="edit-supplier.php?seid=<?php echo $row['sup_id']; ?>">Edit</a>
                                <a id="del-inv" class="table-btn-del" href="../controllers/delete-controllers.php?supdelid=<?php echo $row['sup_id']; ?>">Delete</a>
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