<?php 
    if(isset($_POST["submit"])){
        echo $_POST["username"];
        echo $_POST["password"];
    }else{

    }
?>
<!DOCTYPE html>
<html>
    <?php include("template/header.php") ?>
    <div class="container">
        <h1>Welcome to the MiganMHT PHP</h1>
    </div>
    <?php include("template/footer.php") ?>
</body>

</html>