<?php
session_start();
require_once "../config/db.php";

/* 🔒 Must be logged in */
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login.php");
    exit();
}

/* Validate story id */
if (!isset($_GET['id'])) {
    header("Location: ../../index.php");
    exit();
}

$story_id = (int) $_GET['id'];
$user_id  = (int) $_SESSION['user_id'];

/* Fetch story ONLY if it belongs to user */
$query = "SELECT * FROM stories WHERE id = $story_id AND user_id = $user_id";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) !== 1) {
    echo "Access denied.";
    exit();
}

$story = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Story</title>
</head>
<body>

<h2>Edit Your Story</h2>

<form action="update.php" method="POST">
  <input type="hidden" name="id" value="<?php echo $story['id']; ?>">

  <input type="text" name="title" required
         value="<?php echo htmlspecialchars($story['title']); ?>">

  <br><br>

  <textarea name="content" rows="6" required><?php
    echo htmlspecialchars($story['content']);
  ?></textarea>

  <br><br>

  <button type="submit">Update Story</button>
</form>

<br>
<a href="../../index.php">⬅ Back</a>

</body>
</html>
