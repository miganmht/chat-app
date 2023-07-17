<?php include("database.php") ?>
<?php
$usernameErr = $passwordErr = "";

if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    // Validate password
    if (empty($password)) {
        $passwordErr = "Password is required.";
    }
    // Validate username
    if (empty($username)) {
        $usernameErr = "Username is required.";
    } else {
        $query = "SELECT * FROM user WHERE username='$username' AND password='$password'";
        
        $result=$conn->query($query);
        
        if ($result->num_rows == 0) {
            $errors["usernameorpass"] = "Username or password dosent Exist";
            
        } else {
            session_start();
            $_SESSION["username"]=$username;
            header("Location:chatlist.php");
        }
    }
}
?>

<!DOCTYPE html>
<html>
<?php include("template/header.php") ?>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h2>Login</h2>
                <form action="login.php" method="post">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" class="form-control" required>
                        <?php if (!empty($usernameErr)) : ?>
                            <p class="text-danger"><?php echo $errors["username"]; ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control" required>
                        <?php if (!empty($errors["usernameorpass"])) : ?>
                            <p class="text-danger"><?php echo $errors["usernameorpass"]; ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6">
                        <p>Don't have an account? <a href="signup.php">Signup here</a>.</p>
                    </div>
                    <button type="submit" name="submit" value="submit" class="btn btn-primary">Login</button>
                </form>
            </div>
        </div>
    </div>
    <?php include("template/footer.php") ?>
</body>

</html>