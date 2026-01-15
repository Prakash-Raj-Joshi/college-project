<?php
require_once "../config/db.php";

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];

// hash password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// check if email already exists
$check = "SELECT id FROM users WHERE email='$email'";
$result = mysqli_query($conn, $check);

if (mysqli_num_rows($result) > 0) {
    echo "Email already registered";
    exit();
}

// insert new user
$query = "INSERT INTO users (name, email, password)
          VALUES ('$name', '$email', '$hashedPassword')";

if (mysqli_query($conn, $query)) {
    header("Location: ../../login.php");
    exit();
} else {
    echo "Registration failed";
}
