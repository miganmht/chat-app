<?php

include("database.php");

// Get the sender and receiver from the AJAX request
$usernameh = $_GET["sender"];
$usernamec = $_GET["receiver"];

// Use prepared statements to prevent SQL injection
$query = "SELECT * FROM `message` WHERE (usernamesender = '$usernameh' AND usernamereciver = '$usernamec') OR (usernamesender = '$usernamec' AND usernamereciver = '$usernameh') ORDER BY date ASC";
$result = $conn->query($query);
$messages = array();

// Loop through the result and add each row to the messages array
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}
// Convert the messages array to JSON format
$jsonResponse = json_encode($messages);

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response back to the JavaScript code
echo $jsonResponse;

// Close the database connection
$conn->close();
