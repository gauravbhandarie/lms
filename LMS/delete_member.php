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

    // Handle GET request for deletion
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
        $id = $_GET['id'];

        // Delete the member by id
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
        $stmt->execute([':id' => $id]);

        if ($stmt->rowCount() > 0) {
            // Successfully deleted
            $response = [
                'success' => true,
                'message' => 'Member deleted sucessfully.'
            ];
        } else {
            // No rows affected, meaning no user with that ID was found
            $response = [
                'success' => false,
                'message' => 'No member found with ID ' . $id
            ];
        }
        echo json_encode($response);
    } else {
        // Invalid request method or missing ID
        $response = [
            'success' => false,
            'message' => 'Invalid request method or missing member ID.'
        ];
        echo json_encode($response);
    }
} catch (PDOException $e) {
    // Catch database-related errors and return the message
    $response = [
        'success' => false,
        'message' => 'User has borrowed books'
    ];
    echo json_encode($response);
}
?>
