<?php
session_start();

/* 🔒 Protect page */
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once "backend/config/db.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>MindBridge</title>
  <link rel="stylesheet" href="style/style.css">
</head>
<body>

<!-- NAV -->
<nav>
  <div class="logo">MindBridge</div>
  <ul id="nav-menu">
    <li><a href="index.php">Home</a></li>
    <li><a href="#stories">Stories</a></li>
    <li><a href="contact.html">Contact</a></li>
  </ul>
  <a href="backend/auth/logout.php">Logout</a>
  <a href="notifications.php">🔔</a>

</nav>

<!-- HERO -->
<section class="hero">
  <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?> 👋</h2>
</section>

<!-- STORY FORM -->
<section id="stories">
  <h2 style="text-align:center;">Share Your Story</h2>

  <form action="backend/story/store.php" method="POST"
        style="max-width:600px;margin:20px auto;">

    <input type="text" name="title" placeholder="Story Title" required
           style="width:100%;padding:10px;margin-bottom:10px;">

    <textarea name="content" placeholder="Write your story..."
              rows="6" required
              style="width:100%;padding:10px;"></textarea>

    <label>
      <input type="checkbox" name="is_anonymous" value="1">
      Post anonymously
    </label><br><br>

    <button type="submit">Post Story</button>
  </form>
</section>

<hr>

<!-- COMMUNITY STORIES -->
<section>
  <h2 style="text-align:center;">Community Stories</h2>

<?php
$sql = "
SELECT 
    stories.*,
    users.name,
    (SELECT COUNT(*) FROM likes WHERE likes.story_id = stories.id) AS like_count,
    (SELECT id FROM likes 
     WHERE likes.story_id = stories.id 
     AND likes.user_id = {$_SESSION['user_id']}) AS liked
FROM stories
JOIN users ON stories.user_id = users.id
ORDER BY stories.created_at DESC
";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) === 0) {
    echo "<p style='text-align:center;'>No stories yet.</p>";
}

while ($story = mysqli_fetch_assoc($result)) {
?>
  <!-- STORY CARD -->
  <div style="max-width:700px;margin:20px auto;border-bottom:1px solid #ccc;padding:10px;">

    <h3><?php echo htmlspecialchars($story['title']); ?></h3>

    <p><?php echo nl2br(htmlspecialchars($story['content'])); ?></p>

    <small>
      —
      <?php
        echo $story['is_anonymous']
             ? "Anonymous"
             : htmlspecialchars($story['name']);
      ?>
    </small>

    <!-- ❤️ LIKE -->
    <div style="margin-top:8px;">
      <a href="backend/story/like.php?id=<?php echo $story['id']; ?>"
         style="text-decoration:none;font-size:18px;">
        <?php echo $story['liked'] ? "❤️" : "🤍"; ?>
        <?php echo $story['like_count']; ?>
      </a>

      <?php if ($story['user_id'] == $_SESSION['user_id']) { ?>
        | <a href="backend/story/delete.php?id=<?php echo $story['id']; ?>"
             onclick="return confirm('Delete this story?')">
             Delete
          </a>
      <?php } ?>
    </div>

    <!-- ================= STEP E-3: COMMENT FORM ================= -->
    <form action="backend/story/comment_store.php" method="POST"
          style="margin-top:10px;">
      <input type="hidden" name="story_id"
             value="<?php echo $story['id']; ?>">

      <input type="text" name="comment"
             placeholder="Write a comment..."
             required
             style="width:70%;padding:6px;">

      <button type="submit">Comment</button>
    </form>

    <!-- ================= STEP E-4: SHOW COMMENTS ================= -->
    <?php
    $sid = $story['id'];
    $comments = mysqli_query($conn, "
        SELECT comments.*, users.name
        FROM comments
        JOIN users ON comments.user_id = users.id
        WHERE comments.story_id = $sid
        ORDER BY comments.created_at ASC
    ");

    while ($c = mysqli_fetch_assoc($comments)) {
    ?>
      <div style="margin-left:20px;margin-top:5px;">
        <small>
          <b><?php echo htmlspecialchars($c['name']); ?>:</b>
          <?php echo htmlspecialchars($c['comment']); ?>
        </small>

        <?php if ($c['user_id'] == $_SESSION['user_id']) { ?>
  <a href="backend/story/comment_edit.php?id=<?php echo $c['id']; ?>">✏️</a>
  <a href="backend/story/comment_delete.php?id=<?php echo $c['id']; ?>"
     onclick="return confirm('Delete comment?')">❌</a>
<?php } ?>

      </div>
    <?php } ?>

  </div>
<?php } ?>
</section>

</body>
</html>
