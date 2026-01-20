<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LearnEase - Your Path to Knowledge</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <?php 
    // Start session if not already started
    if(!isset($_SESSION)) { 
        session_start(); 
    }
    include('./header.php'); 
    include('./dbConnection.php'); 
  ?>

  <section class="hero" style="background: linear-gradient(135deg, #4A90E2 0%, #50C878 100%); color: white; padding: 5rem 0;">
    <div class="container text-center">
      <h1 style="font-size: 3rem; color: white;">Welcome to LearnEase</h1>
      <p style="font-size: 1.3rem; margin-bottom: 2rem; color: white;">Unlock your potential with expert-led courses</p>
      
      <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
        <?php 
        // --- LOGIC CHANGE HERE ---
        // If user is logged in, show 'My Dashboard' instead of 'Get Started Free'
        if (isset($_SESSION['is_login'])) { 
            // CORRECTED LINK: Points to student-dashboard.php in the root folder
            echo '<a href="student-dashboard.php" class="btn btn-secondary" style="padding: 1rem 2rem; font-size: 1.1rem;">My Dashboard</a>';
        } else {
            echo '<a href="register.php" class="btn btn-secondary" style="padding: 1rem 2rem; font-size: 1.1rem;">Get Started Free</a>';
        }
        ?>
        <a href="about.php" class="btn btn-outline" style="padding: 1rem 2rem; font-size: 1.1rem; border-color: white; color: white;">Learn More</a>
      </div>
    </div>
  </section>

  <section>
    <div class="container">
      <h2 class="text-center">Why Choose LearnEase?</h2>
      <div class="grid grid-3">
        <div class="card text-center">
          <div style="font-size: 3rem; color: #4A90E2; margin-bottom: 1rem;">📚</div>
          <h3>Expert Instructors</h3>
          <p>Learn from industry professionals with real-world experience</p>
        </div>
        <div class="card text-center">
          <div style="font-size: 3rem; color: #50C878; margin-bottom: 1rem;">⏰</div>
          <h3>Learn at Your Pace</h3>
          <p>Access courses anytime, anywhere, on any device</p>
        </div>
        <div class="card text-center">
          <div style="font-size: 3rem; color: #F39C12; margin-bottom: 1rem;">🎓</div>
          <h3>Earn Certificates</h3>
          <p>Get recognized for your achievements with course certificates</p>
        </div>
      </div>
    </div>
  </section>

<section style="background-color: white; padding: 4rem 0;">
  <div class="container">
    <h2 class="text-center" style="margin-bottom: 3rem;">Featured Courses</h2>
    
    <div class="grid grid-3">
      <?php
        // 1. Fetching up to 6 courses
        $sql = "SELECT * FROM course LIMIT 6";
        $result = $conn->query($sql);

        if($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
            $course_id = $row['course_id'];
            $course_name = $row['course_name'];
            $course_desc = $row['course_desc'];
            $course_author = $row['course_author'];
            $course_img = $row['course_img'];
            $final_img = str_replace('../', './', $course_img); 
      ?>
        <div class="card">
          <img src="<?php echo $final_img; ?>" alt="<?php echo $course_name; ?>" style="width: 100%; height: 200px; object-fit: cover; border-radius: 5px; margin-bottom: 1rem;">
          
          <div class="card-header">
            <h3 class="card-title"><?php echo $course_name; ?></h3>
            <span class="badge badge-primary">Course</span>
          </div>

          <div class="card-body">
            <p><?php echo substr($course_desc, 0, 80); ?>...</p> 
            <p style="font-size: 0.9rem; color: #7F8C8D; margin-top: 0.5rem;">
              Instructor: <?php echo $course_author; ?>
            </p>
            <a href="coursedetail.php?course_id=<?php echo $course_id; ?>" class="btn btn-primary mt-1" style="width: 100%;">
              Enroll for Free
            </a>
          </div>
        </div>
      <?php
          }
        } else {
          echo "<p class='text-center'>No courses found in the database.</p>";
        }
      ?>
    </div> 

    <div class="text-center" style="margin-top: 3rem;">
      <a href="courses.php" class="btn btn-outline" style="padding: 1rem 3rem; font-weight: bold; font-size: 1.1rem; border-width: 2px;">
        View All Courses
      </a>
    </div>

  </div>
</section>

  <section style="background-color: #2C3E50; color: white; text-align: center; padding: 4rem 0;">
    <div class="container">
      <h2 style="color: white;">Ready to Start Learning?</h2>
      <p style="font-size: 1.2rem; color: white; margin-bottom: 2rem;">Join thousands of students already learning on LearnEase</p>
      
      <?php if(!isset($_SESSION['is_login'])) { ?>
        <a href="register.php" class="btn btn-secondary" style="padding: 1rem 2.5rem; font-size: 1.1rem;">Create Free Account</a>
      <?php } ?>
      
    </div>
  </section>

  <?php include('./footer.php'); ?>
</body>
</html>