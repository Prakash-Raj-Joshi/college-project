<?php
session_start();
require_once "../config/db.php";

// 🔒 Must be logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login.php");
    exit();
}

// Validate story id
if (!isset($_GET['id'])) {
    header("Location: ../../index.php");
    exit();
}

$story_id = (int) $_GET['id'];
$user_id  = $_SESSION['user_id'];

// 🔐 Delete ONLY if story belongs to logged-in user
$query = "DELETE FROM stories WHERE id = $story_id AND user_id = $user_id";
mysqli_query($conn, $query);

header("Location: ../../index.php");
exit();
