<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.html");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Dashboard | MindBridge</title>
</head>
<body>

<h2>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?> 👋</h2>
<p>You are logged in successfully.</p>

<a href="auth/logout.php">Logout</a>

</body>
</html>
