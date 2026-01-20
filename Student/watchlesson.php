<?php
// 1. Corrected Paths to reach the root directory
include_once('../dbConnection.php'); 
include_once('../header.php');
if(!isset($_SESSION)){
    session_start();
}

// Security: Redirect if not logged in
if(!isset($_SESSION['is_login'])){
    header("Location: ../login.php");
    exit();
}

$stuEmail = $_SESSION['stuLogEmail'];

// Fetch student image for the custom navbar
$sql_img = "SELECT stu_img FROM stddata WHERE stu_email = '$stuEmail'";
$res_img = $conn->query($sql_img);
$row_img = $res_img->fetch_assoc();
$stuImg = $row_img['stu_img'];

// 2. Validate Enrollment and Course ID
if(isset($_GET['course_id'])){
    $course_id = $_GET['course_id'];

    // Verify student is enrolled in this course
    $check_enroll = "SELECT * FROM courseorder WHERE stu_email = '$stuEmail' AND course_id = '$course_id' AND status = 'Success'";
    $res_enroll = $conn->query($check_enroll);
    
    if($res_enroll->num_rows == 0){
        echo "<script>alert('You are not enrolled in this course.'); window.location.href='../student-dashboard.php';</script>";
        exit();
    }
} else {
    header("Location: ../student-dashboard.php");
    exit();
}

// 3. Fetch All Lessons for the Sidebar
$sql_lessons = "SELECT * FROM lesson WHERE course_id = '$course_id'";
$res_lessons = $conn->query($sql_lessons);

// 4. Determine which lesson to display
$lesson_to_show = null;
if(isset($_GET['lesson_id'])){
    $l_id = $_GET['lesson_id'];
    $res_current = $conn->query("SELECT * FROM lesson WHERE lesson_id = '$l_id'");
    $lesson_to_show = $res_current->fetch_assoc();
} else {
    $res_first = $conn->query("SELECT * FROM lesson WHERE course_id = '$course_id' LIMIT 1");
    $lesson_to_show = $res_first->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Watch Lessons - LearnEase</title>
  <link rel="stylesheet" href="../styles.css">
  <style>
    .watch-container { display: flex; height: calc(100vh - 70px); background: #f8f9fa; }
    .lesson-sidebar { width: 300px; background: white; border-right: 1px solid #ddd; overflow-y: auto; padding: 1.5rem; }
    .video-main { flex: 1; padding: 2.5rem; overflow-y: auto; }
    .lesson-item { padding: 1rem; border-radius: 8px; margin-bottom: 0.5rem; cursor: pointer; text-decoration: none; color: #2C3E50; display: block; border: 1px solid transparent; transition: 0.3s; }
    .lesson-item:hover { background: #f0f7ff; border-color: #4A90E2; }
    .lesson-active { background: #4A90E2 !important; color: white !important; font-weight: bold; }
    .video-wrapper { position: relative; padding-bottom: 56.25%; height: 0; border-radius: 12px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1); margin-bottom: 2rem; }
    .video-wrapper video { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: #000; }
  </style>
</head>
<body>

  <!-- <nav class="navbar">
    <div class="container">
      <a href="../index.php" class="logo">Learn<span>Ease</span></a>
      
      <div class="nav-actions">
        <div style="display: flex; align-items: center; gap: 15px;">
           <img src="<?php echo (!empty($stuImg)) ? $stuImg : '../image/student/default.png'; ?>" 
                style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover; border: 1px solid #ddd;">
           <a href="../logout.php" class="btn btn-outline">Log Out</a>
        </div>
      </div>
    </div>
  </nav> -->

  <div class="watch-container">
      <div class="lesson-sidebar">
          <h3 style="margin-bottom: 1.5rem; color: #2C3E50;">Course Content</h3>
          <?php 
          if($res_lessons->num_rows > 0) {
              $count = 1;
              $res_lessons->data_seek(0);
              while($l_row = $res_lessons->fetch_assoc()) {
                  $active_class = ($lesson_to_show['lesson_id'] == $l_row['lesson_id']) ? 'lesson-active' : '';
                  echo '<a href="watchlesson.php?course_id='.$course_id.'&lesson_id='.$l_row['lesson_id'].'" class="lesson-item '.$active_class.'">
                          '.$count.'. '.$l_row['lesson_name'].'
                        </a>';
                  $count++;
              }
          }
          ?>
      </div>

      <div class="video-main">
          <?php if($lesson_to_show): ?>
              <div class="video-wrapper">
                  <video id="videoarea" src="<?php echo $lesson_to_show['lesson_link']; ?>" controls controlList="nodownload"></video>
              </div>
              
              <h2 style="color: #2C3E50; margin-bottom: 1rem;"><?php echo $lesson_to_show['lesson_name']; ?></h2>
              <hr style="border: 0; border-top: 1px solid #ddd; margin-bottom: 1.5rem;">
              <p style="line-height: 1.6; color: #7F8C8D; font-size: 1.1rem;">
                  <strong>Lesson Description:</strong><br>
                  <?php echo $lesson_to_show['lesson_desc']; ?>
              </p>
          <?php else: ?>
              <div class="card text-center" style="padding: 4rem;">
                  <h3>No lessons found for this course.</h3>
              </div>
          <?php endif; ?>
      </div>
  </div>

</body>
</html>