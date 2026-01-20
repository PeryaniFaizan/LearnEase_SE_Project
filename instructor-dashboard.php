<?php
// ==========================================
// 1. DATABASE CONNECTION & SECURITY CHECKS
// ==========================================

include_once('dbConnection.php'); 

if(!isset($_SESSION)){
    session_start();
}

// Security Gate: Check if the user is logged in as an Admin/Instructor.
if(!isset($_SESSION['is_admin_login'])){
    header("Location: adminlogin.php");
    exit();
}

$instructorName = "Hitler"; // Ideally fetch this from $_SESSION['admin_name']

// ==========================================
// 2. FETCH DASHBOARD STATISTICS (DYNAMIC DATA)
// ==========================================

// Active Courses count
$sql_active = "SELECT COUNT(*) as total FROM course WHERE course_author = '$instructorName'";
$res_active = $conn->query($sql_active);
$total_active_courses = ($res_active) ? $res_active->fetch_assoc()['total'] : 0;

// Total Students global count
$sql_students = "SELECT COUNT(*) as total FROM stddata";
$res_students = $conn->query($sql_students);
$total_students = ($res_students) ? $res_students->fetch_assoc()['total'] : 0;

// Total Lessons global count
$sql_lessons = "SELECT COUNT(*) as total FROM lesson";
$res_lessons = $conn->query($sql_lessons);
$total_lessons = ($res_lessons) ? $res_lessons->fetch_assoc()['total'] : 0;

// Hours of Content global sum
$sql_hours = "SELECT SUM(course_duration) as total FROM course";
$res_hours = $conn->query($sql_hours);
$total_hours = ($res_hours) ? $res_hours->fetch_assoc()['total'] : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Instructor Dashboard - LearnEase</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    .instructor-course-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 1.5rem;
    }
    @media (max-width: 768px) {
      .instructor-course-grid { grid-template-columns: 1fr; }
    }
    .mb-1 { margin-bottom: 1rem; }
    .section-title { margin-bottom: 2rem; border-left: 5px solid #4A90E2; padding-left: 15px; }
  </style>
</head>
<body>

  <nav class="navbar">
    <div class="container">
        <a href="instructor-dashboard.php" class="logo">Learn<span>Ease</span></a>
        <div class="nav-actions">
            <span style="margin-right: 1.5rem;">👨‍🏫 <?php echo isset($_SESSION['admin_name']) ? $_SESSION['admin_name'] : 'Instructor'; ?></span>
            <a href="logout.php" class="btn btn-outline">Logout</a>
            <a href="Admin/adminchangepass.php" class="btn btn-outline" style="margin-left: 10px;">Change Password</a>
        </div>
    </div>
  </nav>

 <section style="background: linear-gradient(135deg, #4A90E2 0%, #50C878 100%); color: white; padding: 3rem 0;">
    <div class="container">
      <div style="display: flex; justify-content: space-between; align-items: center;">
        
        <h1 style="color: white; margin: 0;">
            Welcome back, <?php echo isset($_SESSION['admin_name']) ? $_SESSION['admin_name'] : 'Instructor'; ?>!
        </h1>

        <a href="Admin/addcourse.php" class="btn" style="background: white; color: #4A90E2; font-weight: bold;">+ New Course</a>
        
      </div>
    </div>
  </section>

  <section style="padding: 2rem 0;">
    <div class="container">
      <div class="grid grid-4">
        <div class="card text-center">
          <div style="font-size: 2.5rem; color: #4A90E2;"><?php echo $total_active_courses; ?></div>
          <h3 style="color: #7F8C8D;">Active Courses</h3>
        </div>
        <div class="card text-center">
          <div style="font-size: 2.5rem; color: #50C878;"><?php echo number_format($total_students); ?></div>
          <h3 style="color: #7F8C8D;">Total Students</h3>
        </div>
        <div class="card text-center">
          <div style="font-size: 2.5rem; color: #F39C12;"><?php echo $total_lessons; ?></div>
          <h3 style="color: #7F8C8D;">Total Lessons</h3>
        </div>
        <div class="card text-center">
          <div style="font-size: 2.5rem; color: #E74C3C;"><?php echo ($total_hours) ? $total_hours : 0; ?></div>
          <h3 style="color: #7F8C8D;">Content Hours</h3>
        </div>
      </div>
    </div>
  </section>

  <section style="padding: 4rem 0; background-color: white; border-top: 1px solid #eee;">
    <div class="container">
      <h2 class="section-title">Instructor Quick Actions</h2>
      <div class="grid grid-4">
        <a href="Admin/lesson.php" class="card text-center" style="text-decoration: none; color: inherit;">
          <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">📝</div>
          <h3 style="font-size: 1rem;">Add Lessons</h3>
        </a>
        <a href="Admin/admincourses.php" class="card text-center" style="text-decoration: none; color: inherit;">
          <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">🎬</div>
          <h3 style="font-size: 1rem;">Course Management</h3>
        </a>
        <a href="Admin/newcourse.php" class="card text-center" style="text-decoration: none; color: inherit;">
          <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">⚙️</div>
          <h3 style="font-size: 1rem;">Student Management</h3>
        </a>
        <!-- <a href="#" class="card text-center" style="text-decoration: none; color: inherit;">
          <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">📊</div>
          <h3 style="font-size: 1rem;">Analytics</h3>
        </a> -->
      </div>
    </div>
  </section>

  <section style="background-color: #f9f9f9; padding: 4rem 0;">
    <div class="container">
      <h2 class="section-title">My Published Courses</h2>
      <div class="instructor-course-grid">
        <?php
          $sql_my = "SELECT * FROM course WHERE course_author = '$instructorName'";
          $res_my = $conn->query($sql_my);
          if($res_my && $res_my->num_rows > 0) {
              while($row = $res_my->fetch_assoc()) {
                  $c_id = $row['course_id'];
                  $c_img = str_replace('../', './', $row['course_img']); 
        ?>
            <div class="card">
              <div style="display: flex; gap: 1rem;">
                <img src="<?php echo $c_img; ?>" style="width: 150px; height: 100px; object-fit: cover; border-radius: 5px;">
                <div style="flex: 1;">
                  <h3 style="margin-top:0;"><?php echo $row['course_name']; ?></h3>
                  <p style="color: #7F8C8D;">Rs <?php echo $row['course_price']; ?> | <?php echo $row['course_duration']; ?></p>
                  <div style="margin-top: 1rem;">
                    <a href="Admin/editcourse.php?id=<?php echo $c_id; ?>" class="btn btn-outline" style="font-size: 0.8rem; width: 100%; text-align: center;">Edit Course Details</a>
                  </div>
                </div>
              </div>
            </div>
        <?php } } else { echo "<p>No courses found.</p>"; } ?>
      </div>
    </div>
  </section>

  <section style="padding: 4rem 0; background-color: white; border-top: 1px solid #eee;">
    <div class="container">
      <h2 class="section-title">Recent Student Activity</h2>
      <div class="grid grid-2">
        <?php
          $sql_recent = "SELECT co.order_date, s.stu_name, c.course_name 
                          FROM courseorder AS co 
                          JOIN stddata AS s ON co.stu_email = s.stu_email 
                          JOIN course AS c ON co.course_id = c.course_id 
                          ORDER BY co.co_id DESC LIMIT 4";
          $res_recent = $conn->query($sql_recent);
          if($res_recent && $res_recent->num_rows > 0) {
              while($enroll = $res_recent->fetch_assoc()) {
        ?>
            <div class="card mb-1">
               <div style="flex: 1;">
                  <h3 style="font-size: 1rem; margin: 0; color: #2C3E50;"><?php echo $enroll['stu_name']; ?></h3>
                  <p style="font-size: 0.85rem; color: #7F8C8D; margin: 5px 0 0 0;">Joined: <?php echo $enroll['course_name']; ?></p>
               </div>
               <div style="margin-top: 10px; text-align: right;">
                  <span style="font-size: 0.8rem; color: #95a5a6; font-style: italic;"><?php echo $enroll['order_date']; ?></span>
               </div>
            </div>
        <?php } } ?>
      </div>
    </div>
  </section>

  <?php include('./footer.php'); ?>
</body>
</html>