<?php
// Database connection
$host = 'localhost';
$db = 'library_db';
$user = 'root';
$pass = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Get form data
        $bookId = $_POST['book_id'];
        $userId = $_POST['member_id'];
        $borrowDate = $_POST['issue_date'];

        // Insert new record into borrowed_books table
        $stmt = $conn->prepare("INSERT INTO borrowed_books (user_id, book_id, borrow_date, return_date) 
                                VALUES (:user_id, :book_id, :borrow_date, NULL)");

        $stmt->execute([
            ':user_id' => $userId,
            ':book_id' => $bookId,
            ':borrow_date' => $borrowDate
        ]);

        // Return success or failure as JSON
        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => true, 'message' => 'Book issued successfully!']);
	
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to issue the book.']);

        }
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'No user found ']);
}
?>
