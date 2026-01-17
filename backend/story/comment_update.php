<?php
session_start();
require_once "../config/db.php";

$id = $_POST['id'];
$comment = mysqli_real_escape_string($conn, $_POST['comment']);

mysqli_query($conn,
  "UPDATE comments SET comment='$comment' WHERE id=$id"
);

header("Location: ../../index.php");
exit();
