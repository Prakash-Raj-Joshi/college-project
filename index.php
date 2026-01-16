<?php
session_start();

/* 🔒 STEP A1 — Protect page */
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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MindBridge - Share. Connect. Heal.</title>
  <link rel="stylesheet" href="style/style.css">
</head>
<body>

<!-- NAVIGATION -->
<nav>
  <div class="logo">
    <img src="image/newlogo.PNG" alt="MindBridge">
  </div>

  <div class="menu-toggle" onclick="toggleMenu()" role="button" tabindex="0">
    <span></span><span></span><span></span>
  </div>

  <ul id="nav-menu">
    <li><a href="index.php">Home</a></li>
    <li><a href="#stories">Stories</a></li>
    <li><a href="contact.html">Contact</a></li>
  </ul>

  <a href="backend/auth/logout.php">Logout</a>
</nav>

<!-- HERO -->
<section class="hero">
  <div class="intro-text">
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?> 👋</h2>
    <p>
      MindBridge offers a secure place to open up about mental health,
      identity, or life struggles — with the option to reach professionals.
    </p>
  </div>
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
</label>


    <button type="submit" style="margin-top:10px;padding:10px 20px;">
      Post Story
    </button>
  </form>
</section>

<hr>

<!-- COMMUNITY STORIES -->
<section>
  <h2 style="text-align:center;">Community Stories</h2>

<?php
$sql = "
  SELECT stories.id, stories.title, stories.content, stories.user_id,
         users.name
  FROM stories
  JOIN users ON stories.user_id = users.id
  ORDER BY stories.created_at DESC
";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) === 0) {
    echo "<p style='text-align:center;'>No stories yet.</p>";
}

while ($story = mysqli_fetch_assoc($result)) {
    echo "<div style='max-width:700px;margin:20px auto;
                  border-bottom:1px solid #ccc;padding-bottom:10px;'>";
    
    echo "<h3>" . htmlspecialchars($story['title']) . "</h3>";
    echo "<p>" . nl2br(htmlspecialchars($story['content'])) . "</p>";
    if ($story['is_anonymous']) {
    echo "<small>— Anonymous</small>";
} else {
    echo "<small>— " . htmlspecialchars($story['name']) . "</small>";
}


    /* 🔐 STEP B — Ownership check */
    if ((int)$story['user_id'] === (int)$_SESSION['user_id']) {
    echo ' | <a href="backend/story/edit.php?id=' . (int)$story['id'] . '">Edit</a>';
    echo ' | <a href="backend/story/delete.php?id=' . (int)$story['id'] . '"
             onclick="return confirm(\'Delete this story?\')">Delete</a>';
}


    echo "</div>";
}
?>
</section>

<!-- FOOTER -->
<footer>
  <p>Your voice, your story. Join the community.</p>
  <div class="footer-content">
    <a href="index.php">Home</a>
    <a href="contact.html">Contact</a>
  </div>
  <p class="copy">&copy; 2025 MindBridge</p>
</footer>

<!-- JS -->
<script>
function toggleMenu() {
  document.getElementById('nav-menu').classList.toggle('show');
}

document.querySelector('.menu-toggle')
  .addEventListener('keydown', function(e) {
    if (e.key === 'Enter' || e.key === ' ') {
      e.preventDefault();
      toggleMenu();
    }
  });
</script>

</body>
</html>
