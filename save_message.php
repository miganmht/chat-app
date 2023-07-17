<?php
include("database.php");

// Get the sender, receiver, and message from the AJAX request
$usernameh = $_POST["sender"];
$usernamec = $_POST["receiver"];
$message = $_POST["message"];

// Use prepared statements to prevent SQL injection
$query = "INSERT INTO `message` (`usernamesender`, `usernamereciver`, `message`) VALUES (?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("sss", $usernameh, $usernamec, $message);

// Execute the prepared statement
if ($stmt->execute()) {
    // Insertion successful
    echo "Message saved successfully.";
} else {
    // Error occurred
    echo "Error: " . $stmt->error;
}

// Close the prepared statement and database connection
$stmt->close();
$conn->close();
?>
