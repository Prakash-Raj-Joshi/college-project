<?php
require_once "../config/db.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: /mindbridge/backend/dashboard.php");


    exit();
}

$email = trim($_POST['email']);
$password = $_POST['password'];

// Check user exists
$query = "SELECT * FROM users WHERE email = ? LIMIT 1";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if ($user = mysqli_fetch_assoc($result)) {

    if (password_verify($password, $user['password'])) {

        $_SESSION['user_id']   = $user['id'];
        $_SESSION['user_name'] = $user['name'];

        header("Location: ../dashboard.php");
        exit();

    } else {
        echo "Invalid password";
    }

} else {
    echo "User not found";
}
