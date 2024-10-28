<?php
session_start(); // Start the session

// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'library_db');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("User not logged in."); // Handle the case where the user is not logged in
}
$user_id = $_SESSION['user_id']; // Use the session user ID

// Fetch user profile from the 'users' table
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Update profile if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']); // Updated to 'username'
    $email = trim($_POST['email']);

    // Simple validation
    if (empty($username) || empty($email)) {
        $error_message = "Name and email are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email format.";
    } else {
        // Prepare the SQL statement to update the 'users' table
        $update_sql = $conn->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
        $update_sql->bind_param("ssi", $username, $email, $user_id); // Bind 'username'

        if ($update_sql->execute()) {
            $success_message = "Profile updated successfully!";
            // Refresh user data after update
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
        } else {
            $error_message = "Error updating profile: " . $update_sql->error;
        }
        $update_sql->close();
    }
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="member.css">
</head>
<body>
    <div class="dashboard-container">
        <header>
            <h1>Your Profile</h1>
            <nav>
                <ul>
                    <li><a href="member-dashboard.html">Dashboard</a></li>
                    <li><a href="books.php">Books</a></li>
                    <li><a href="borrowed-books.php">Borrowed Books</a></li>
                    <li><a href="member-logout.php">Logout</a></li>
                </ul>
            </nav>
        </header>

        <section id="content">
            <h2>Update Your Profile</h2>

            <!-- Display success or error message -->
            <?php if (isset($success_message)): ?>
                <p style="color: green;"><?php echo $success_message; ?></p>
            <?php elseif (isset($error_message)): ?>
                <p style="color: red;"><?php echo $error_message; ?></p>
            <?php endif; ?>

            <!-- Profile update form -->
            <form method="post" action="profile.php">
                <label for="name">Name:</label>
                <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>

                <label for="email">Email:</label>
                <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

                <button type="submit">Update Profile</button>
            </form>
        </section>

        <footer>
            <p>&copy; 2024 Library Management System</p>
        </footer>
    </div>
</body>
</html>
