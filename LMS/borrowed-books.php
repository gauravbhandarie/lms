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

$user_id = $_SESSION['user_id'];

// Handle borrowing a book
if (isset($_GET['book_id'])) {
    $book_id = $_GET['book_id'];
    $return_date = $_GET['return_date'];

    $stmt = $conn->prepare("INSERT INTO borrowed_books (user_id, book_id, borrow_date, return_date) VALUES (?, ?, CURDATE(), ?)");
    $stmt->bind_param("iis", $user_id, $book_id, $return_date);

    if ($stmt->execute()) {
        $update_sql = "UPDATE books SET available = 0 WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("i", $book_id);
        $update_stmt->execute();
        echo "<p>Book borrowed successfully!</p>";
    } else {
        echo "<p>Error borrowing book: " . $conn->error . "</p>";
    }

    $stmt->close();
}

// Fetch borrowed books for the logged-in user
$sql = "SELECT borrowed_books.id AS borrowed_id, books.title, books.author, borrowed_books.borrow_date, borrowed_books.return_date 
        FROM borrowed_books 
        JOIN books ON borrowed_books.book_id = books.id 
        WHERE borrowed_books.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Fetch username for welcome message
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
    <title>My Borrowed Books</title>
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

        input[type="text"], input[type="date"] {
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
    <script>
        // Function to update the date via AJAX
        function updateDate(borrowedId, column, newValue) {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "update_dates.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    console.log(xhr.responseText); // Log response, handle success/failure here
                }
            };
            xhr.send("borrowed_id=" + borrowedId + "&column=" + column + "&value=" + encodeURIComponent(newValue));
        }

        // Function to make the cell editable and track original value
        function makeEditable(cell, borrowedId, column) {
            const originalValue = cell.innerText.trim(); // Store the original value when cell is clicked
            cell.contentEditable = true;
            cell.focus();

            cell.addEventListener("blur", function() {
                const newValue = cell.innerText.trim(); // Get the new value after editing

                // Check if the value has actually changed before sending an update
                if (newValue !== originalValue) {
                    updateDate(borrowedId, column, newValue); // Update only if value has changed
                }
                cell.contentEditable = false; // Make the cell non-editable again
            });
        }
    </script>
</head>
<body>
    <div class="dashboard-container">
        <header>
            <h1>Welcome, <span id="member-name"><?php echo htmlspecialchars($username); ?></span>!</h1>
            <nav>
                <ul>
                    <li><a href="member-dashboard.html">Home</a></li>
                    <li><a href="books.php">Books</a></li>
                    <li><a href="profile.php">Profile</a></li>
                    <li><a href="member-logout.php">Logout</a></li>
                </ul>
            </nav>
        </header>
        
        <h2>Borrow a Book</h2>
        <form action="" method="GET">
            <label for="book_id">Book ID:</label>
            <input type="text" name="book_id" id="book_id" required>
            <label for="return_date">Return Date:</label>
            <input type="date" name="return_date" id="return_date" required>
            <button type="submit">Borrow Book</button>
        </form>

        <h2>My Borrowed Books</h2>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Borrow Date</th>
                    <th>Return Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($borrowed = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($borrowed['title']) . "</td>";
                    echo "<td>" . htmlspecialchars($borrowed['author']) . "</td>";
                    echo "<td contenteditable='true' onfocus='makeEditable(this, {$borrowed['borrowed_id']}, \"borrow_date\")'>" . htmlspecialchars($borrowed['borrow_date']) . "</td>";
                    echo "<td contenteditable='true' onfocus='makeEditable(this, {$borrowed['borrowed_id']}, \"return_date\")'>" . htmlspecialchars($borrowed['return_date']) . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>