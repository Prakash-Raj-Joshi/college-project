<?php
session_start();
require_once "backend/config/db.php";

mysqli_query($conn,
  "UPDATE notifications SET is_read=1 WHERE user_id={$_SESSION['user_id']}"
);

$result = mysqli_query($conn,
  "SELECT * FROM notifications 
   WHERE user_id={$_SESSION['user_id']}
   ORDER BY created_at DESC"
);
?>

<h2>Your Notifications</h2>

<?php while ($n = mysqli_fetch_assoc($result)) { ?>
  <p>
    <?php echo htmlspecialchars($n['message']); ?>
    <a href="<?php echo $n['link']; ?>">View</a>
  </p>
<?php } ?>
