<?php
// Start session and check for admin login
if(!isset($_SESSION)){
    session_start();
}

if (!isset($_SESSION['is_admin_login'])) {
    header("Location: adminlogin.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Instructor Dashboard - LearnEase</title>
  <link rel="stylesheet" href="/LearnEase/S.E_Project-main/styles.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>

  <nav class="navbar">
    <div class="container">
      <a href="index.php" class="logo">Learn<span>Ease</span></a>
      <ul class="nav-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="Admin/admincourses.php">Courses</a></li>
        <li><a href="instructor-dashboard.php">Dashboard</a></li>
      </ul>
      
      <div class="nav-actions" style="display: flex; align-items: center;">
        <span style="margin-right: 1.5rem; color: #2C3E50;">
            👨‍🏫 <?php echo $_SESSION['admin_name']; ?>
        </span>
        
        <a href="logout.php" class="btn btn-outline" style="margin-right: 1rem;">Logout</a>

        <a href="changepassword.php" 
           style="text-decoration: none; color: #34495E; font-size: 0.9rem; font-weight: 600; transition: color 0.3s ease;"
           onmouseover="this.style.color='#3498DB';" 
           onmouseout="this.style.color='#34495E';">
           🔑 Change Password
        </a>
      </div>
    </div>
  </nav>