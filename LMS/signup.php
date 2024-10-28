<?php
// Start session to display messages
session_start();

// Database connection parameters
$host = 'localhost'; // or '127.0.0.1'
$dbname = 'library_db'; // Your database name
$user = 'root'; // Your MySQL username
$pass = ''; // Your MySQL password

header('Content-Type: application/json'); // Set response type to JSON

try {
    // Create a new PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        // Validate input
        if (empty($username) || empty($email) || empty($password)) {
            echo json_encode(['error' => "All fields are required!"]);
            exit();
        }

        // Hash the password for security
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Check if username already exists
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);

        if ($stmt->rowCount() > 0) {
            echo json_encode(['error' => "Username already exists."]);
            exit();
        }

        // Check if email already exists
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->rowCount() > 0) {
            echo json_encode(['error' => "Email already exists."]);
            exit();
        }

        // Prepare SQL query to insert user data
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $hashedPassword]);

        // On success, return success message
        echo json_encode(['success' => "Account created successfully! Please log in."]);
        exit();
    }
} catch (PDOException $e) {
    // Handle unexpected database errors
    echo json_encode(['error' => "Database error: " . $e->getMessage()]);
    exit();
}
?>
