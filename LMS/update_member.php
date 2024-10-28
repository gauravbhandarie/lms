<?php
header('Content-Type: application/json');

// Database connection
$host = 'localhost';
$dbname = 'library_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if data was sent with the request
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Prepare SQL query, update password only if it's provided
        if (!empty($password)) {
            $stmt = $pdo->prepare("UPDATE users SET username = :username, email = :email, password = :password WHERE id = :id");
            $stmt->execute([':username' => $username, ':email' => $email, ':password' => password_hash($password, PASSWORD_DEFAULT), ':id' => $id]);
        } else {
            $stmt = $pdo->prepare("UPDATE users SET username = :username, email = :email WHERE id = :id");
            $stmt->execute([':username' => $username, ':email' => $email, ':id' => $id]);
        }

        echo json_encode(['success' => true, 'message' => 'Member updated successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
