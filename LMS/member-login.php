<?php
session_start(); // Start the session to track the login state

// Database connection details
$host = 'localhost';
$dbname = 'library_db';  // Change this to your database name
$user = 'root';  // MySQL username
$pass = '';  // MySQL password

// Establish connection to the database
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        // Prepare SQL query to fetch user data based on the username
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if the username exists and the password matches
        if ($user && password_verify($password, $user['password'])) {
            // Set session variable to indicate successful login
            $_SESSION['user_id'] = $user['id'];

            // Redirect to the member dashboard page if credentials are correct
            header("Location: member-dashboard.html");
            exit();
        } else {
            // Invalid credentials; redirect back with an error message
            header("Location: member-login.html?error=1");
            exit();
        }
    }
} catch (PDOException $e) {
    // Redirect with a database error message if there's an issue with the connection
    header("Location: member-login.html?error=2");
    exit();
}
?>
