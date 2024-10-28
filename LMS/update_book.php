<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Set content type to JSON
header('Content-Type: application/json');

// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "library_db";

// Establish database connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => "Connection failed: " . $conn->connect_error]);
    exit();
}

// Get JSON input data
$data = json_decode(file_get_contents("php://input"), true);
if (!$data) {
    echo json_encode(['success' => false, 'error' => "Invalid JSON input"]);
    exit();
}

// Escape data to prevent SQL injection
$originalTitle = $conn->real_escape_string($data['originalTitle']);
$title = $conn->real_escape_string($data['title']);
$author = $conn->real_escape_string($data['author']);
$genre = $conn->real_escape_string($data['genre']);

// Update the book details based on the original title
$sql = "UPDATE books SET title='$title', author='$author', genre='$genre' WHERE title='$originalTitle'";
if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => "Error updating book: " . $conn->error]);
}

// Close the connection
$conn->close();
exit();
?>
