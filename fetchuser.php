<?php
// Load the users

include("database.php");

$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

$query = "SELECT * FROM `user` WHERE username LIKE '%$searchTerm%'";
$result = $conn->query($query);

// Prepare an array to store the users
$users = array();

// Fetch each row from the result and add it to the users array
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

// Convert the users array to JSON format
$jsonResponse = json_encode($users);

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response back to the JavaScript code
echo $jsonResponse;
?>