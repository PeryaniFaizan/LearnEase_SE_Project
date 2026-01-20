<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Us - LearnEase</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <?php 
  include('./header.php');
  include('./dbConnection.php'); // Include DB connection for stats

  // Fetch Real Stats from Database
  // 1. Count Students
  $sql_student = "SELECT * FROM stddata";
  $result_student = $conn->query($sql_student);
  $total_students = $result_student->num_rows;

  // 2. Count Courses
  $sql_course = "SELECT * FROM course";
  $result_course = $conn->query($sql_course);
  $total_courses = $result_course->num_rows;
  ?>

  <section style="background: linear-gradient(135deg, #4A90E2 0%, #50C878 100%); color: white; padding: 5rem 0;">
    <div class="container text-center">
      <h1 style="font-size: 3rem; color: white;">About LearnEase</h1>
      <p style="font-size: 1.3rem; color: white;">Empowering learners worldwide to achieve their goals</p>
    </div>
  </section>

  <section>
    <div class="container">
      <div style="max-width: 800px; margin: 0 auto; text-align: center;">
        <h2>Our Mission</h2>
        <p style="font-size: 1.1rem;">At LearnEase, we believe that quality education should be accessible to everyone, everywhere. Our mission is to connect passionate instructors with eager learners, creating a vibrant community where knowledge flows freely and skills are developed through hands-on practice.</p>
      </div>
    </div>
  </section>

  <section style="background-color: white;">
    <div class="container">
      <h2 class="text-center">Our Values</h2>
      <div class="grid grid-3">
        <div class="card text-center">
          <div style="font-size: 3rem; color: #4A90E2; margin-bottom: 1rem;">🎯</div>
          <h3>Quality First</h3>
          <p>We maintain high standards for all courses, ensuring every learner gets the best educational experience possible.</p>
        </div>

        <div class="card text-center">
          <div style="font-size: 3rem; color: #50C878; margin-bottom: 1rem;">🌍</div>
          <h3>Accessibility</h3>
          <p>Education should be available to everyone. We strive to make learning affordable and accessible worldwide.</p>
        </div>

        <div class="card text-center">
          <div style="font-size: 3rem; color: #F39C12; margin-bottom: 1rem;">🤝</div>
          <h3>Community</h3>
          <p>We foster a supportive learning environment where students and instructors can connect and grow together.</p>
        </div>

        <div class="card text-center">
          <div style="font-size: 3rem; color: #E74C3C; margin-bottom: 1rem;">💡</div>
          <h3>Innovation</h3>
          <p>We continuously improve our platform with cutting-edge technology to enhance the learning experience.</p>
        </div>

        <div class="card text-center">
          <div style="font-size: 3rem; color: #9B59B6; margin-bottom: 1rem;">✨</div>
          <h3>Excellence</h3>
          <p>We are committed to excellence in everything we do, from course content to student support.</p>
        </div>

        <div class="card text-center">
          <div style="font-size: 3rem; color: #1ABC9C; margin-bottom: 1rem;">🚀</div>
          <h3>Growth</h3>
          <p>We help learners and instructors achieve their full potential through continuous skill development.</p>
        </div>
      </div>
    </div>
  </section>

  <section style="background: linear-gradient(135deg, #2C3E50 0%, #34495E 100%); color: white; padding: 4rem 0;">
    <div class="container">
      <h2 class="text-center" style="color: white; margin-bottom: 3rem;">LearnEase by the Numbers</h2>
      <div class="grid grid-4">
        <div class="text-center">
          <div style="font-size: 3rem; font-weight: bold; color: #50C878; margin-bottom: 0.5rem;">
             <?php echo $total_students; ?>+
          </div>
          <p style="font-size: 1.1rem; color: white;">Active Students</p>
        </div>
        
        <div class="text-center">
          <div style="font-size: 3rem; font-weight: bold; color: #50C878; margin-bottom: 0.5rem;">
             <?php echo $total_courses; ?>+
          </div>
          <p style="font-size: 1.1rem; color: white;">Courses Available</p>
        </div>
      </div>
    </div>
  </section>

  <section>
    <div class="container">
      <h2 class="text-center">How LearnEase Works</h2>
      <div class="grid grid-3">
        <div class="text-center">
          <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #4A90E2 0%, #50C878 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; color: white; font-size: 2rem; font-weight: bold;">1</div>
          <h3>Choose Your Course</h3>
          <p>Browse our extensive catalog of courses across various subjects and skill levels. Find the perfect course that matches your learning goals.</p>
        </div>

        <div class="text-center">
          <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #4A90E2 0%, #50C878 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; color: white; font-size: 2rem; font-weight: bold;">2</div>
          <h3>Learn at Your Pace</h3>
          <p>Access video lessons, reading materials, and practice exercises anytime, anywhere. Learn on your schedule with lifetime access.</p>
        </div>

        <div class="text-center">
          <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #4A90E2 0%, #50C878 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; color: white; font-size: 2rem; font-weight: bold;">3</div>
          <h3>Master New Skills</h3>
          <p>Apply what you've learned through practical exercises and real-world examples to build confidence and advance your career.</p>
        </div>
      </div>
    </div>
  </section>

  <section>
    <div class="container">
      <div class="text-center" style="max-width: 800px; margin: 0 auto;">
        <h2>Get in Touch</h2>
        <p style="font-size: 1.1rem; margin-bottom: 2rem;">Have questions? We're here to help! Reach out to our support team anytime.</p>
        <div class="grid grid-3" style="text-align: center;">
          <div class="card">
            <div style="font-size: 2.5rem; color: #4A90E2; margin-bottom: 1rem;">📧</div>
            <h4>Email Us</h4>
            <p style="color: #7F8C8D;">support@learnease.com</p>
          </div>
          <div class="card">
            <div style="font-size: 2.5rem; color: #F39C12; margin-bottom: 1rem;">📞</div>
            <h4>Call Us</h4>
            <p style="color: #7F8C8D;">1-800-LEARN-NOW</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php 
  // LOGIC: Only show this CTA if NO ONE is logged in
  if(!isset($_SESSION['is_login']) && !isset($_SESSION['is_admin_login'])){
  ?>
  <section style="background-color: #2C3E50; color: white; text-align: center;">
    <div class="container">
      <h2 style="color: white;">Ready to Start Your Learning Journey?</h2>
      <p style="font-size: 1.2rem; color: white; margin-bottom: 2rem;">Join thousands of students already learning on LearnEase</p>
      <a href="register.php" class="btn btn-secondary" style="padding: 1rem 2.5rem; font-size: 1.1rem;">Get Started Free</a>
    </div>
  </section>
  <?php } ?>

  <?php 
  include('./footer.php');
  ?>
</body>
</html>