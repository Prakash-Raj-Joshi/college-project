<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}
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
      <li><a href="index.html">Home</a></li>
      <li><a href="#features">Features</a></li>
      <li><a href="stories.html">Stories</a></li>
      <li><a href="contact.html">Contact</a></li>
      <li><a href="login.html">Login</a></li>
      <li><a href="g.html.html">Therapists</a></li>
    </ul>
    <a href="backend/auth/logout.php">Logout</a>

  </nav>

  <!-- HEADER -->
  <!-- <header> -->
    <!-- <h1>MindBridge</h1> -->
  <!-- </header> -->

  <!-- HERO -->
  <section class="hero">
    <div class="intro-text">
      <h2>Share your story. Connect with support.</h2>
      <p>MindBridge offers a secure place to open up about mental health, identity, or life struggles — with the option to reach professionals when you're ready.</p>
      <button onclick="navigateToForm()">Start Your Journey</button>
    </div>
  </section>

  <!-- FEATURES -->
  <section class="features" id="features">
    <div class="feature">
      <a href="safe-sharing.html">
        <img src="image/19.jpg" alt="Safe sharing" />
        <h3>Safe Sharing</h3>
        <p>Post anonymously or openly. Your voice matters, your comfort comes first.</p>
      </a>
      <a href="safe-sharing.html" class="see-more-btn">See More</a>
    </div>
    <!-- Coomunity support -->
    <div class="feature">
      <a href="community support.html">
        <img src="image/13.jpg" alt="Community support" />
        <h3>Community Support</h3>
        <p>Read, relate, and respond to others on their paths — because no one heals alone.</p>
      </a>
      <a href="community support.html" class="see-more-btn">See More</a>
    </div>
    <!-- Professional Access -->
    <div class="feature">
      <a href="g.html.html">
        <img src="image/22.jpg" alt="Professional support" />
        <h3>Professional Access</h3>
        <p>Connect with certified mental health professionals when you are ready.</p>
      </a>
      <a href="g.html.html" class="see-more-btn">See More</a>
    </div>
  </section>

  <!-- FOOTER -->
  <footer>
    <p>Your voice, your story. Join the community.</p>
    <div class="footer-content">
      <a href="index.html">Home</a>
      <a href="contact.html">Contact</a>
      <a href="login.html">Login</a>
      <a href="g.html.html">Therapists</a>
    </div>
    <p class="copy">&copy; 2025 MindBridge. Empowering voices, one story at a time.</p>
  </footer>

  <!-- JS -->
  <script>
    function navigateToForm() {
      alert("Redirecting to story submission form... (feature coming soon)");
    }

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
