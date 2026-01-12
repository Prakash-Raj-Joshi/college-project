<?php
require_once "../config/db.php";

$email = $_POST['email'];
$password = $_POST['password'];

// check user exists
$query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) === 1) {
    $user = mysqli_fetch_assoc($result);

    // verify password
    if (password_verify($password, $user['password'])) {
        echo "Login successful";
    } else {
        echo "Invalid password";
    }
} else {
    echo "User not found";
}
