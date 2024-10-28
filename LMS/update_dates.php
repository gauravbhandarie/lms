<?php
session_start();

$host = 'localhost';
$dbname = 'library_db';
$username = 'root';
$password = '';
$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get data from AJAX request
$borrowed_id = $_POST['borrowed_id'];
$column = $_POST['column'];
$value = $_POST['value'];

// Update the respective date (borrow_date or return_date)
if ($column === 'borrow_date' || $column === 'return_date') {
    $stmt = $conn->prepare("UPDATE borrowed_books SET $column = ? WHERE id = ?");
    $stmt->bind_param("si", $value, $borrowed_id);

    if ($stmt->execute()) {
        echo "Date updated successfully.";
    } else {
        echo "Error updating date: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
