<?php
session_start(); // Start the session to track the login state

// Database connection
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
        $stmt = $pdo->prepare("SELECT * FROM librarians WHERE username = ?");
        $stmt->execute([$username]);
        $librarian = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if the username exists and the password matches
        if ($librarian && password_verify($password, $librarian['password'])) {
            // Set session variable to indicate successful login
            $_SESSION['librarian_id'] = $librarian['id'];

            // Redirect to the dashboard page if credentials are correct
            header("Location: librarian-dashboard.html");
            exit();
        } else {
            // Invalid credentials; redirect back with an error message
            header("Location: librarian-login.html?error=1");
            exit();
        }
    }
} catch (PDOException $e) {
    // Redirect with a database error message if there's an issue with the connection
    header("Location: librarian-login.html?error=2");
    exit();
}
