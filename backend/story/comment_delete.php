<?php
session_start();
require_once "../config/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login.php");
    exit();
}

$id = intval($_GET['id']);

mysqli_query($conn,
    "DELETE FROM comments
     WHERE id = $id
     AND user_id = {$_SESSION['user_id']}"
);

header("Location: ../../index.php#stories");
exit();
