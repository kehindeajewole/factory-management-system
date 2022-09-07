<?php
  require 'header.php';
  require_once(ABSPATH . 'controllers/user-controllers.php');
?>
    <div class="container-fluid body-main py-4">
    <div class="row">
        <div class="container-fluid">
        <div class="py-1">
            <h1 class="mb-0 text-white">Add User</h1>
        </div>
        </div>
        <!-- Data content start-->
        <div class="container-fluid">
            <div class="card p-4">
            <div class="row">
                <div class="col-md-6">
                <form action="add-user.php" method="post">
                    <?php if ( count($errors) === 0 && !empty($success['user_add_success']) ): ?>
                        <div class="gen-form-success"> <?php echo $success['user_add_success']; ?> </div>
                    <?php endif; ?>
                        <?php if ( count($errors) > 0 && !empty($errors['user_add_fail']) ): ?>
                        <div class="gen-form-errors"> <?php echo $errors['user_add_fail']; ?> </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label for="first-name" class="form-control-label">First Name</label>
                        <input class="form-control" type="text" id="first-name" name="first-name" value="<?php echo $firstname; ?>" >
                        <?php if ( count($errors) > 0  && !empty($errors['firstname']) ): ?>
                            <div class="form-errors"> <?php echo $errors['firstname']; ?> </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="last-name" class="form-control-label">Last Name</label>
                        <input class="form-control" type="text" id="last-name" name="last-name" value="<?php echo $lastname; ?>" >
                        <?php if ( count($errors) > 0  && !empty($errors['lastname']) ): ?>
                            <div class="form-errors"> <?php echo $errors['lastname']; ?> </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="email" class="form-control-label">Email</label>
                        <input class="form-control" type="text" id="email" name="email" value="<?php echo $email; ?>" >
                        <?php if ( count($errors) > 0  && !empty($errors['email']) ): ?>
                            <div class="form-errors"> <?php echo $errors['email']; ?> </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="role" class="form-control-label">Role</label>
                        <select class="form-control" name="role" id="role">
                            <?php foreach ($roles as $value => $label): ?>
                                <option value="<?php echo $value; ?>" <?php if ( $role == $value) { echo 'selected'; } ?>>
                                    <?php echo $label; ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                        <?php if ( count($errors) > 0  && !empty($errors['role']) ): ?>
                            <div class="form-errors"> <?php echo $errors['role']; ?> </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="password" class="form-control-label">Password</label>
                        <input class="form-control" id="password" type="password" name="user-pass" value="<?php echo $password; ?>">
                        <?php if ( count($errors) > 0  && !empty($errors['password']) ): ?>
                            <div class="form-errors"> <?php echo $errors['password']; ?> </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <input class="btn btn-fms my-4 btn-block" type="submit" value="Add User" name="add-user" >
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