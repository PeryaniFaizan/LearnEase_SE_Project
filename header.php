<?php
// Header fragment (no <html>/<head>/<body>) — path-aware so it works when included from root or subfolders
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

// Determine base prefix for links/styles when included from subfolders
$base = (strpos($_SERVER['PHP_SELF'], '/Student/') !== false || strpos($_SERVER['PHP_SELF'], '/Admin/') !== false) ? '../' : '';
$stylesheet_path = $base . 'styles.css';

// Include DB connection if not already included
include_once('dbConnection.php');

// Fetch student image if logged in
$stuImg = '';
if (isset($_SESSION['is_login'])) {
  $stuLogEmail = $_SESSION['stuLogEmail'];
  $sql_img = "SELECT stu_img FROM stddata WHERE stu_email = '$stuLogEmail'";
  $result_img = $conn->query($sql_img);
  if ($result_img && $row_img = $result_img->fetch_assoc()) {
    $stuImg = $row_img['stu_img'];
    // Normalize stored path and prefix base
    $stuImg = ltrim(str_replace('../', '', $stuImg), './');
    $stuImg = $base . $stuImg;
  }
}
?>

<link rel="stylesheet" href="<?php echo $stylesheet_path; ?>">

<nav class="navbar">
  <div class="container">
    <a class="logo" href="<?php echo $base; ?>index.php">Learn<span>Ease</span></a>

    <?php if (isset($_SESSION['is_login'])) { ?>
      <!-- Logged-in links -->
      <ul class="nav-links">
        <li><a href="<?php echo $base; ?>index.php">Home</a></li>
        <li><a href="<?php echo $base; ?>about.php">About</a></li>
        <li><a href="<?php echo $base; ?>courses.php">Courses</a></li>
        <li><a href="<?php echo $base; ?>student-dashboard.php">Dashboard</a></li>
      </ul>

      <div class="nav-actions">
        <div style="display: flex; align-items: center; gap: 15px;">
          <a href="<?php echo $base; ?>Student/studentprof.php" title="View Profile">
            <img src="<?php echo (!empty($stuImg)) ? $stuImg : ($base . 'image/student/default.png'); ?>" 
                 alt="Profile" class="nav-profile-img">
          </a>
          <a href="<?php echo $base; ?>logout.php" class="btn btn-outline">Log Out</a>
        </div>
      </div>

    <?php } else { ?>
      <!-- Not logged-in links -->
      <ul class="nav-links">
        <li><a href="<?php echo $base; ?>index.php">Home</a></li>
        <li><a href="<?php echo $base; ?>about.php">About</a></li>
        <li><a href="<?php echo $base; ?>courses.php">Courses</a></li>
      </ul>

      <div class="nav-actions">
        <a href="<?php echo $base; ?>login.php" class="btn btn-outline" style="margin-right: 10px;">Login</a>
        <a href="<?php echo $base; ?>register.php" class="btn btn-primary">Sign Up</a>
      </div>
    <?php } ?>
  </div>
</nav>