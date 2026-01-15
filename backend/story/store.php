<?php
session_start();
require "../config/db.php";

// 🔒 Only logged-in users
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login.php");
    exit();
}

$title = trim($_POST['title']);
$content = trim($_POST['content']);
$user_id = $_SESSION['user_id'];

if ($title === "" || $content === "") {
    echo "All fields are required.";
    exit();
}

// Insert story
$query = "INSERT INTO stories (user_id, title, content)
          VALUES ('$user_id', '$title', '$content')";

if (mysqli_query($conn, $query)) {
    header("Location: ../../index.php");
    exit();
} else {
    echo "Error: " . mysqli_error($conn);
}
