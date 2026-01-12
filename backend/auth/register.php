<?php
require_once "../config/db.php";

$name     = $_POST['name'];
$email    = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$query = "INSERT INTO users (name, email, password)
          VALUES ('$name', '$email', '$password')";

if (mysqli_query($conn, $query)) {
    echo "User registered successfully";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
