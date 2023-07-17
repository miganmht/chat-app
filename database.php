<?php 
// connect to the database
$conn=mysqli_connect("localhost","root","","miganmhtphp");

// check conn
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>