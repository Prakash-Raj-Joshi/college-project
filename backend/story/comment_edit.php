<?php
session_start();
require_once "../config/db.php";

$id = $_GET['id'];

$result = mysqli_query($conn,
  "SELECT * FROM comments WHERE id = $id"
);

$comment = mysqli_fetch_assoc($result);

// Security check
if ($comment['user_id'] != $_SESSION['user_id']) {
    die("Unauthorized");
}
?>

<h2>Edit Comment</h2>

<form action="comment_update.php" method="POST">
  <input type="hidden" name="id" value="<?php echo $comment['id']; ?>">

  <textarea name="comment" rows="4" required
            style="width:100%;padding:10px;">
    <?php echo htmlspecialchars($comment['comment']); ?>
  </textarea>

  <br><br>
  <button type="submit">Update Comment</button>
</form>
