<?php
session_start();

$host = 'localhost';
$dbname = 'library_db';
$user = 'root';
$pass = '';

header('Content-Type: application/json');

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        if (empty($username) || empty($email) || empty($password)) {
            echo json_encode(['error' => "All fields are required!"]);
            exit();
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Check if username or email already exists in the 'users' table
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);

        if ($stmt->rowCount() > 0) {
            echo json_encode(['error' => "Username or Email already exists."]);
            exit();
        }

        // Insert the new user into the 'users' table
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $hashedPassword]);

        echo json_encode(['success' => "Member added successfully!"]);
        exit();
    }
} catch (PDOException $e) {
    echo json_encode(['error' => "Database error: " . $e->getMessage()]);
    exit();
}
?>