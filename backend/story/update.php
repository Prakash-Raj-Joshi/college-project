<?php
session_start();
require_once "../config/db.php";

/* 🔒 Must be logged in */
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login.php");
    exit();
}

if (!isset($_POST['id'], $_POST['title'], $_POST['content'])) {
    header("Location: ../../index.php");
    exit();
}

$story_id = (int) $_POST['id'];
$user_id  = (int) $_SESSION['user_id'];

$title   = mysqli_real_escape_string($conn, $_POST['title']);
$content = mysqli_real_escape_string($conn, $_POST['content']);

/* 🔐 Update ONLY if owner */
$query = "
  UPDATE stories
  SET title = '$title', content = '$content'
  WHERE id = $story_id AND user_id = $user_id
";

mysqli_query($conn, $query);

header("Location: ../../index.php");
exit();
