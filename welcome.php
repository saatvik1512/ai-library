<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome</title>
</head>
<body>
  <?php
  session_start(); // Start session (if not already started)
  if (isset($_SESSION['username'])) {
    echo "<h1>Hello, " . $_SESSION['username'] . "!</h1>"; // Display welcome message with username
  } else {
    echo "You are not logged in."; // Message if session is not set (e.g., user refreshed page)
  }
  ?>
</body>
</html>
