<?php
// Database connection
$host = 'localhost';
$db = 'library_db';
$user = 'root';
$pass = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_GET['query'])) {
        $searchTerm = $_GET['query'];

        // Fetch matching book titles and their IDs
        $stmt = $conn->prepare("SELECT id, title AS name FROM books WHERE title LIKE :title LIMIT 10");
        $stmt->execute([':title' => '%' . $searchTerm . '%']);

        $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($books);  // Return the result as JSON
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database Error: ' . $e->getMessage()]);
}
?>
