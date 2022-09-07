<?php
    require 'header.php';
    $usersQuery = "SELECT * FROM users";
    $stmtUsers = $conn->prepare($usersQuery); 
    $stmtUsers->execute();
    $resultUsers = $stmtUsers->get_result();
    $usersQueryCount= $resultUsers->num_rows;

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
                <h1 class="mb-0 text-white">All Users</h1>
            </div>
        </div>
    <!-- Content Start -->
    <div class="card">
        <div class="py-4 col-sm-3">
            <a class="btn btn-fms my-4" href="add-user.php" role="button">+ Add User</a>
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
                        <th scope="col" class="sort">Email</th>
                        <th scope="col" class="sort">Role</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody class="list">
                    <?php if( $usersQueryCount > 0 ) :?>
                    <?php while ( $row = $resultUsers->fetch_assoc() ): ?>
                    <tr>
                        <td>
                            <?php echo $counter; ?>
                        </td>
                        <td>
                            <?php echo $row["user_first_name"] . " " . $row["user_last_name"] ; ?>
                        </td>
                        <td class="table-addy">
                            <?php echo $row["user_email"]; ?>
                        </td>
                        <td>
                            <?php echo $row["role"]; ?>
                        </td>
                        <td class="text-right">
                            <div class="table-btn">
                                <a class="table-btn-edit" href="edit-user.php?ueid=<?php echo $row['user_id']; ?>">Edit</a>
                                <a id="del-inv" class="table-btn-del" href="../controllers/delete-controllers.php?userdelid=<?php echo $row['user_id']; ?>">Delete</a>
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