<?php
// Database connection
$host = 'localhost';
$db = 'library_db';
$user = 'root';
$pass = '';

try {
    // Connect to the database
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the form has been submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Get form data
        $bookId = $_POST['book_id'];
        $memberId = $_POST['member_id'];

        // Set the return_date to mark the book as returned
        $stmt = $conn->prepare("UPDATE borrowed_books SET return_date = NOW() WHERE book_id = :book_id AND user_id = :user_id AND return_date IS NULL");
        $stmt->execute([':book_id' => $bookId, ':user_id' => $memberId]);

        // Check if the update was successful
        if ($stmt->rowCount() > 0) {
            // Delete the record from the borrowed_books table
            $deleteStmt = $conn->prepare("DELETE FROM borrowed_books WHERE book_id = :book_id AND user_id = :user_id");
            $deleteStmt->execute([':book_id' => $bookId, ':user_id' => $memberId]);

            echo json_encode(['success' => true, 'message' => 'Book returned and record deleted successfully!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to return the book. No matching record found.']);
        }
    }
} catch (PDOException $e) {
    // Handle any database connection or query error
    echo json_encode(['success' => false, 'message' => 'Database Error: ' . $e->getMessage()]);
}
?>
