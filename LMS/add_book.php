<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "library_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => $conn->connect_error]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);

$title = $data['title'];
$author = $data['author'];
$genre = $data['genre'];

$sql = "INSERT INTO books (title, author, genre) VALUES ('$title', '$author', '$genre')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $conn->error]);
}

$conn->close();
?>
