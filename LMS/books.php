<?php
session_start();

$host = 'localhost';
$dbname = 'library_db';
$username = 'root';
$password = '';
$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user is logged in by verifying the session variable
if (!isset($_SESSION['user_id'])) {
    die("Please log in to access this page.");
}

// Handle adding a book
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_book'])) {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $available = 1;

    $sql = "INSERT INTO books (title, author, genre, available) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $title, $author, $genre, $available);
    if ($stmt->execute()) {
        echo "<p>New book added successfully!</p>";
    } else {
        echo "<p>Error adding book: " . $conn->error . "</p>";
    }
    $stmt->close();
}

// Handle borrowing a book
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['borrow_book'])) {
    $book_id = $_POST['book_id'];
    $user_id = $_SESSION['user_id'];

    // Check if the user has already borrowed the book
    $check_sql = "SELECT * FROM borrowed_books WHERE book_id = ? AND user_id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ii", $book_id, $user_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        echo "<p>You have already borrowed this book.</p>";
    } else {
        // Get current date
        $borrow_date = date('Y-m-d');

        $sql = "INSERT INTO borrowed_books (book_id, user_id, borrow_date) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iis", $book_id, $user_id, $borrow_date);
        if ($stmt->execute()) {
            header("Location: borrowed-books.php");
            exit();
        } else {
            echo "<p>Error borrowing book: " . $conn->error . "</p>";
        }
    }

    $check_stmt->close();
}

// Fetch available books
$sql = "SELECT * FROM books";
$result = $conn->query($sql);

// Fetch username for welcome message
$user_id = $_SESSION['user_id'];
$user_query = $conn->prepare("SELECT username FROM users WHERE id = ?");
$user_query->bind_param("i", $user_id);
$user_query->execute();
$user_query->bind_result($username);
$user_query->fetch();
$user_query->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management</title>
    <link rel="stylesheet" href="member.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e6f9e6; /* Light green background */
            color: #2e6e2e; /* Dark green text */
            margin: 0;
            padding: 20px;
        }

        h2, h3 {
            color: #3d993d; /* Medium green */
        }

        form {
            background-color: #c2f0c2; /* Light green for form */
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin: 10px 0 5px;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #2e6e2e; /* Dark green border */
            border-radius: 4px;
        }

        button {
            background-color: #3d993d; /* Medium green button */
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }

        button:hover {
            background-color: #2e6e2e; /* Darker green on hover */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #2e6e2e; /* Dark green border */
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #3d993d; /* Medium green for header */
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2; /* Light grey for even rows */
        }

        a {
            color: #2e6e2e; /* Dark green for links */
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
    <header>
        <h1>Welcome, <span id="member-name"><?php echo htmlspecialchars($username); ?></span>!</h1>
        <nav>
            <ul>
                <li><a href="member-dashboard.html">Home</a></li>
                <li><a href="borrowed-books.php">Borrowed Books</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="member-logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

<h2>Available Books</h2>
<form method="POST">
    <h3>Add a New Book</h3>
    <label for="title">Title:</label>
    <input type="text" id="title" name="title" required>

    <label for="author">Author:</label>
    <input type="text" id="author" name="author" required>

    <label for="genre">Genre:</label>
    <input type="text" id="genre" name="genre" required>

    <button type="submit" name="add_book">Add Book</button>
</form>

<table>
    <thead>
        <tr>
            <th>Book ID</th>
            <th>Title</th>
            <th>Author</th>
            <th>Genre</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        while ($book = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$book['id']}</td>";
            echo "<td>{$book['title']}</td>";
            echo "<td>{$book['author']}</td>";
            echo "<td>{$book['genre']}</td>";
            echo "<td>" . ($book['available'] ? 'Available' : 'Borrowed') . "</td>";
            echo "<td>
                    <form method='POST' style='display:inline;'>
                        <input type='hidden' name='book_id' value='{$book['id']}'>
                        <button type='submit' name='borrow_book'>Borrow</button>
                    </form>
                  </td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>

</body>
</html>

<?php
$conn->close();
?>