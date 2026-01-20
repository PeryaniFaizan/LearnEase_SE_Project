<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learn_Ease</title>
</head>
<body>
    
    <?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // --- 1. DEFINE STATUS VARIABLES ---
    $isAdmin   = isset($_SESSION['is_admin_login']) && $_SESSION['is_admin_login'];
    $isStudent = isset($_SESSION['is_login']) && $_SESSION['is_login'];
    // Guest is true only if NEITHER Admin nor Student is logged in
    $isGuest   = !$isAdmin && !$isStudent;

    // --- 2. PREPARE LINKS BASED ON STATUS ---

    // A. Student Links Setup
    // Default (Guest): Point to Login
    $studentLinks = [
        'Dashboard' => 'login.php',
        'Courses'   => 'login.php',
        'Profile'   => 'login.php'
    ];

    if ($isStudent) {
        // If Student is logged in: Point to actual pages
        $studentLinks = [
            'Dashboard' => 'student-dashboard.php',
            'Courses'   => '../Student/enrolledcourses.php',
            'Profile'   => 'Student/studentprof.php'
        ];
    }

    // B. Instructor Links Setup
    // Default (Guest): Point to Admin Login
    $instructorLinks = [
        'Dashboard' => 'adminlogin.php',
        'Create'    => 'adminlogin.php',
        'Manage'    => 'adminlogin.php'
    ];

    if ($isAdmin) {
        // If Admin is logged in: Point to actual pages
        // Updated 'Dashboard' to point to 'instructor-dashboard.php' as requested
        $instructorLinks = [
            'Dashboard' => 'instructor-dashboard.php', 
            'Create'    => 'Admin/addcourse.php',
            'Manage'    => 'Admin/newcourse.php'
        ];
    }
    ?>

    <footer class="footer">
    <div class="container">
      <div class="footer-content">
        
        <div class="footer-section">
          <h3>LearnEase</h3>
          <p>Empowering learners worldwide with quality education and expert instruction.</p>
        </div>
        
        <div class="footer-section">
          <h3>Quick Links</h3>
          <ul>
            <?php 
            // HOME LINK LOGIC
            if ($isAdmin) {
                // Admin Home -> Instructor Dashboard
                echo '<li><a href="instructor-dashboard.php">Home</a></li>';
            } elseif ($isStudent) {
                // Student Home -> Student Dashboard
                echo '<li><a href="student-dashboard.php">Home</a></li>';
            } else {
                // Guest Home -> Index
                echo '<li><a href="index.php">Home</a></li>';
            }
            ?>
            <li><a href="about.php">About Us</a></li>
            <li><a href="courses.php">Courses</a></li>
            <?php 
            // LOGIN/LOGOUT LOGIC
            if ($isStudent || $isAdmin) {
                echo '<li><a href="logout.php">Logout</a></li>';
            } else {
                echo '<li><a href="login.php">Login</a></li>';
            }
            ?>
          </ul>
        </div>
        
        <?php 
        // SECTION 3: For Students
        // Logic: Show if Guest OR Student (Hide if Admin)
        if ($isGuest || $isStudent) { 
        ?>
        <div class="footer-section">
          <h3>For Students</h3>
          <ul>
            <li><a href="<?php echo $studentLinks['Dashboard']; ?>">My Dashboard</a></li>
            <li><a href="<?php echo $studentLinks['Courses']; ?>">My Courses</a></li>
            <li><a href="<?php echo $studentLinks['Profile']; ?>">My Profile</a></li>
          </ul>
        </div>
        <?php } ?>

        <?php 
        // SECTION 4: For Instructors
        // Logic: Show if Guest OR Admin (Hide if Student)
        if ($isGuest || $isAdmin) { 
        ?>
        <div class="footer-section">
          <h3>For Instructors</h3>
          <ul>
            <li><a href="<?php echo $instructorLinks['Dashboard']; ?>">Instructor Dashboard</a></li>
            <li><a href="<?php echo $instructorLinks['Create']; ?>">Create Course</a></li>
            <li><a href="<?php echo $instructorLinks['Manage']; ?>">Student Management</a></li>
          </ul>
        </div>
        <?php } ?>
        
      </div>
      <div class="footer-bottom">
        <p>&copy; 2025 LearnEase. All rights reserved.</p>
      </div>
    </div>
  </footer>
</body>
</html>