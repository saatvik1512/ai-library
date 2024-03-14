<?php
// Database connection details (replace with your actual credentials)
$servername = "localhost";
$username = "root";
$password = ""; // Update with your actual password
$dbname = "auth";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Function to check for existing user (crucial for login)
function isExistingUser($email, $conn) {
  $sql = "SELECT * FROM users WHERE email = ?";

  try {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->num_rows > 0;
  } catch (mysqli_sql_exception $e) {
    echo "Error checking for existing user: " . $e->getMessage();
    return false; // Indicate error occurred
  }
}

// Get form data (sanitize to prevent SQL injection)
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

// Check if user exists (essential for login)
if (!isExistingUser($email, $conn)) {
  echo "Email not found. Please try again.";
  exit(); // Terminate script execution if user doesn't exist
}

// Login logic (use prepared statements and password verification)
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  if (password_verify($password, $row['password'])) {
    // Login successful, start a session and redirect
    session_start();
    $_SESSION['username'] = $row['username']; // Store username in session
    header("Location: welcome.php"); // Redirect to welcome page
    exit();
  } else {
    // Incorrect password, display an error message
    echo "Incorrect password.";
  }
} else {
  // Should not reach here due to the existing user check
  echo "An unexpected error occurred."; // Handle unexpected cases gracefully
}

$conn->close();
?>
