<?php
session_start();
require_once "../config/db.php";

// 🔒 Must be logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login.php");
    exit();
}

// 🛑 Validate story id
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: ../../index.php");
    exit();
}

$story_id = (int) $_GET['id'];
$user_id  = (int) $_SESSION['user_id'];

// 🔍 Check if already liked
$check = mysqli_query($conn, "
    SELECT id FROM likes 
    WHERE story_id = $story_id 
    AND user_id = $user_id
");

if (mysqli_num_rows($check) > 0) {

    // ❌ Unlike
    mysqli_query($conn, "
        DELETE FROM likes 
        WHERE story_id = $story_id 
        AND user_id = $user_id
    ");

} else {

    // ❤️ Like
    mysqli_query($conn, "
        INSERT INTO likes (story_id, user_id) 
        VALUES ($story_id, $user_id)
    ");

    // 🔔 Notification
    $story = mysqli_fetch_assoc(
        mysqli_query($conn, "SELECT user_id FROM stories WHERE id = $story_id")
    );

    if ($story && $story['user_id'] != $user_id) {

        $msg = mysqli_real_escape_string(
            $conn,
            $_SESSION['user_name'] . " liked your story ❤️"
        );

        // Avoid duplicate unread notification
        $exists = mysqli_query($conn, "
            SELECT id FROM notifications 
            WHERE user_id = {$story['user_id']} 
            AND message = '$msg' 
            AND is_read = 0
        ");

        if (mysqli_num_rows($exists) == 0) {
            mysqli_query($conn, "
                INSERT INTO notifications (user_id, message, link)
                VALUES (
                    {$story['user_id']},
                    '$msg',
                    'index.php#story-$story_id'
                )
            ");
        }
    }
}

// 🔁 Redirect back
header("Location: ../../index.php");
exit();
