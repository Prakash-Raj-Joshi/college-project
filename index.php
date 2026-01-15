<?php
session_start();

// 🔒 Protect page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // FIXED (was login.html ❌)
    exit();
}

require "backend/config/db.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>MindBridge - Share. Connect. Heal.</title>
  <link rel="stylesheet" href="style/style.css">
</head>
<body>

<!-- NAVIGATION -->
<nav>
  <div class="logo">
    <img src="image/newlogo.PNG" alt="MindBridge">
  </div>

  <div class="menu-toggle" onclick="toggleMenu()" aria-label="Toggle navigation menu" role="button" tabindex="0">
    <span></span>
    <span></span>
    <span></span>
  </div>

  <ul id="nav-menu">
    <li><a href="index.php">Home</a></li>
    <li><a href="#features">Features</a></li>
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
      MindBridge offers a secure place to open up about mental health, identity,
      or life struggles — with the option to reach professionals when you're ready.
    </p>
  </div>
</section>

<!-- STORY FORM -->
<section id="stories" class="features">
  <h2 style="text-align:center;">Share Your Story</h2>

  <form action="backend/story/store.php" method="POST" style="max-width:600px;margin:20px auto;">
    <input type="text" name="title" placeholder="Story Title" required
           style="width:100%;padding:10px;margin-bottom:10px;">

    <textarea name="content" placeholder="Write your story..."
              rows="6" required
              style="width:100%;padding:10px;"></textarea>

    <button type="submit" style="margin-top:10px;padding:10px 20px;">
      Post Story
    </button>
  </form>
</section>

<hr>

<!-- STORY LIST -->
<section class="features">
  <h2 style="text-align:center;">Community Stories</h2>

<?php
$result = mysqli_query($conn, "
    SELECT stories.*, users.name 
    FROM stories 
    JOIN users ON stories.user_id = users.id
    ORDER BY stories.created_at DESC
");

if (mysqli_num_rows($result) === 0) {
    echo "<p style='text-align:center;'>No stories yet.</p>";
}

while ($story = mysqli_fetch_assoc($result)) {
    echo "<div style='max-width:700px;margin:20px auto;border-bottom:1px solid #ccc;padding-bottom:10px;'>";
    echo "<h3>" . htmlspecialchars($story['title']) . "</h3>";
    echo "<p>" . nl2br(htmlspecialchars($story['content'])) . "</p>";
    echo "<small>— " . htmlspecialchars($story['name']) . "</small>";
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
  <p class="copy">&copy; 2025 MindBridge. Empowering voices, one story at a time.</p>
</footer>

<!-- JS -->
<script>
function toggleMenu() {
  const menu = document.getElementById('nav-menu');
  menu.classList.toggle('show');
}

document.querySelector('.menu-toggle').addEventListener('keydown', function(e) {
  if (e.key === 'Enter' || e.key === ' ') {
    e.preventDefault();
    toggleMenu();
  }
});
</script>

</body>
</html>
