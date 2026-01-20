<?php 
  include('./dbConnection.php'); 
  include('./header.php'); 

  if(!isset($_SESSION)){
    session_start();
  }

  // Security: Redirect if not logged in
  if(!isset($_SESSION['is_login'])){
    header("Location: login.php");
    exit();
  }

  $stuEmail = $_SESSION['stuLogEmail'];

  // 1. Dynamic Fetch: Number of Enrolled Courses
  $sql_count = "SELECT COUNT(*) as total_enrolled FROM courseorder WHERE stu_email = '$stuEmail'";
  $res_count = $conn->query($sql_count);
  $enrolled_count = 0;
  if($res_count && $row_count = $res_count->fetch_assoc()){
      $enrolled_count = $row_count['total_enrolled'];
  }

  // 2. Dynamic Fetch: Learning Hours (Sum of durations from course table)
  $sql_hours = "SELECT SUM(c.course_duration) as total_hours 
                FROM courseorder AS co 
                JOIN course AS c ON co.course_id = c.course_id 
                WHERE co.stu_email = '$stuEmail'";
  $res_hours = $conn->query($sql_hours);
  $total_learning_hours = 0;
  if($res_hours && $row_hours = $res_hours->fetch_assoc()){
      $total_learning_hours = $row_hours['total_hours'] ? $row_hours['total_hours'] : 0;
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Dashboard - LearnEase</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <section style="background: linear-gradient(135deg, #4A90E2 0%, #50C878 100%); color: white; padding: 3rem 0;">
    <div class="container">
      <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
          <h1 style="color: white; margin: 0;">Welcome back, <?php echo isset($_SESSION['stu_name']) ? $_SESSION['stu_name'] : "Student"; ?> ! 👋</h1>
          <p style="color: white; font-size: 1.1rem; margin-top: 0.5rem;">Continue your learning journey</p>
        </div>
        <a href="./Student/studentprof.php" class="btn" style="background: rgba(255, 255, 255, 0.2); color: white; border: 1px solid white; padding: 0.8rem 1.5rem; border-radius: 8px; text-decoration: none; font-weight: bold; display: inline-flex; align-items: center; gap: 8px;">
            👤 View Profile
        </a>
      </div>
    </div>
  </section>

  <section>
    <div class="container">
      <div class="grid grid-4">
        <a href="Student/enrolledcourses.php" style="text-decoration: none; color: inherit;">
          <div class="card text-center" style="cursor: pointer; transition: 0.3s;">
            <div style="font-size: 2.5rem; color: #4A90E2; margin-bottom: 0.5rem;"><?php echo $enrolled_count; ?></div>
            <h3 style="font-size: 1.1rem; color: #7F8C8D;">Enrolled Courses</h3>
          </div>
        </a>
        
        <div class="card text-center">
          <div style="font-size: 2.5rem; color: #F39C12; margin-bottom: 0.5rem;">0</div>
          <h3 style="font-size: 1.1rem; color: #7F8C8D;">Certificates</h3>
        </div>
        
        <div class="card text-center">
          <div style="font-size: 2.5rem; color: #E74C3C; margin-bottom: 0.5rem;"><?php echo $total_learning_hours; ?></div>
          <h3 style="font-size: 1.1rem; color: #7F8C8D;">Learning Hours</h3>
        </div>
      </div>
    </div>
  </section>

  <section style="background-color: white; padding: 4rem 0;">
    <div class="container">
      <h2 style="margin-bottom: 2rem;">Recommended for You</h2>
      <div class="grid grid-3">
        <?php
          $sql = "SELECT * FROM course ORDER BY RAND() LIMIT 3";
          $result = $conn->query($sql);

          if($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
              $course_id = $row['course_id'];
              $course_name = $row['course_name'];
              $course_desc = $row['course_desc'];
              $course_author = $row['course_author'];
              $course_img = $row['course_img'];
              $final_img = str_replace('../', './', $course_img); //
        ?>
            <div class="card">
              <img src="<?php echo $final_img; ?>" alt="<?php echo $course_name; ?>" style="width: 100%; height: 200px; object-fit: cover; border-radius: 5px; margin-bottom: 1rem;">
              <h3 style="font-size: 1.1rem;"><?php echo $course_name; ?></h3>
              <p style="font-size: 0.9rem; color: #7F8C8D;"><?php echo substr($course_desc, 0, 70); ?>...</p>
              <p style="font-size: 0.9rem; color: #7F8C8D; margin-top: 0.5rem;">Instructor: <?php echo $course_author; ?></p>
              <div style="margin-top: 1rem;">
                <span class="badge badge-primary">Course</span>
              </div>
              <a href="coursedetail.php?course_id=<?php echo $course_id; ?>" class="btn btn-secondary mt-1" style="width: 100%;">
                Enroll for Free
              </a>
            </div>
        <?php
            }
          }
        ?>
      </div>
      <div style="text-align: center; margin-top: 3rem;">
        <a href="courses.php" class="btn btn-outline" style="padding: 1rem 3rem; font-weight: bold; border-radius: 8px;">
          View All Courses
        </a>
      </div>
    </div>
  </section>

  <?php include('./footer.php'); ?>
</body>
</html>