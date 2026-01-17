<?php
session_start();
require_once "../config/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $story_id = intval($_POST['story_id']);
    $comment = trim($_POST['comment']);
    $user_id = $_SESSION['user_id'];

    if ($comment !== "") {
        $stmt = mysqli_prepare(
            $conn,
            "INSERT INTO comments (story_id, user_id, comment)
             VALUES (?, ?, ?)"
        );
        mysqli_stmt_bind_param($stmt, "iis",
            $story_id, $user_id, $comment
        );
        mysqli_stmt_execute($stmt);
    }
}

header("Location: ../../index.php#stories");
exit();
