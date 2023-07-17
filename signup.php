<?php
$usernameErr = $passwordErr = "";
$errors = array();
include("database.php");
if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Validate username
    if (empty($username)) {
        $errors["username"] = "Username is required.";
    } elseif (!preg_match("/^[a-zA-Z0-9_]+$/", $username)) {
        $errors["username"] = "Username should only contain letters, numbers, and underscores.";
    } else{
        $query="SELECT * FROM user WHERE username='$username'";
        if($conn->query($query)->num_rows>0){
            $errors["username"] = "Username Alredy exist";
        }
    }

    // Validate password
    if (empty($password)) {
        $errors["password"] = "Password is required.";
    } elseif (strlen($password) < 8) {
        $errors["password"] = "Password should be at least 8 characters long.";
    }

    // Check for errors
    if (count($errors) == 0) {
        // No errors, proceed with database insertion
        
        $query = "INSERT INTO `user` (`username`, `password`) VALUES ('$username','$password')";
        $usernamemysql=mysqli_real_escape_string($conn,$username);
        $passwordmysql=mysqli_real_escape_string($conn,$password);
        if(mysqli_query($conn,$query)){
            header("Location:login.php");
        }else{
            //echo "error ".mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html>
    <?php include("template/header.php") ?>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h2>Signup</h2>
                <form action="signup.php" method="post">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" class="form-control" required>
                        <?php if (isset($errors["username"])) : ?>
                            <p class="text-danger"><?php echo $errors["username"]; ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control" required>
                        <?php if (isset($errors["password"])) : ?>
                            <p class="text-danger"><?php echo $errors["password"]; ?></p>
                        <?php endif; ?>
                    </div>
                    <button type="submit" name="submit" value="submit" class="btn btn-primary">Signup</button>
                </form>
            </div>
        </div>
    </div>
    <?php include("template/footer.php") ?>
</body>
</html>
