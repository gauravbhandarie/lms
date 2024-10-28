<?php
// Start session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not logged in.']);
    exit();
}

// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'library_db');

// Check connection
if ($conn->connect_error) {
    echo json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]);
    exit();
}

// Retrieve user ID from session
$user_id = $_SESSION['user_id'];

// Debug: Check if user ID is set
if (empty($user_id)) {
    echo json_encode(['error' => 'User ID is not set in the session.']);
    exit();
}

// Fetch user information from the users table
$sql = "SELECT * FROM users WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if the query was successful
if (!$result) {
    echo json_encode(['error' => 'Query failed: ' . $conn->error]);
    exit();
}

$user = $result->fetch_assoc();

// Check if user exists
if (!$user) {
    echo json_encode(['error' => 'No user found.']);
    exit();
}

// Fetch the number of borrowed books from the borrowed_books table
$borrowed_sql = "SELECT COUNT(*) as count FROM borrowed_books WHERE user_id=?";
$borrowed_stmt = $conn->prepare($borrowed_sql);
$borrowed_stmt->bind_param("i", $user_id);
$borrowed_stmt->execute();
$borrowed_result = $borrowed_stmt->get_result();

// Check if the query was successful
if (!$borrowed_result) {
    echo json_encode(['error' => 'Query failed: ' . $conn->error]);
    exit();
}

$borrowed_data = $borrowed_result->fetch_assoc();

// Create an array to send as a response
$response = [
    'name' => $user['username'], // Adjust field name as per your users table structure
    'email' => $user['email'],
    'borrowed_books_count' => $borrowed_data['count']
];

// Set the content type to JSON
header('Content-Type: application/json');

// Return the response as JSON
echo json_encode($response);

$conn->close();
?>