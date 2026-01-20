<?php
// 1. Session and Connection
include('../dbConnection.php');
session_start();

// Redirect if not logged in
if (!isset($_SESSION['is_admin_login'])) {
    header("Location: adminlogin.php");
    exit();
}

$msg = "";

// 2. Handle Form Submission
if (isset($_POST['courseSubmitBtn'])) {
    // Checking for Empty Fields
    if (
        ($_POST['course_name'] == "") || ($_POST['course_desc'] == "") || 
        ($_POST['course_author'] == "") || ($_POST['course_duration'] == "") || 
        ($_POST['course_price'] == "") || ($_POST['course_original_price'] == "")
    ) {
        $msg = '<div style="color: #e74c3c; margin-bottom: 1.5rem; font-weight: bold; text-align: center;">⚠️ Please Fill All Fields</div>';
    } else {
        // Assigning Values
        $course_name = $_POST['course_name'];
        $course_desc = $_POST['course_desc'];
        $course_author = $_POST['course_author'];
        $course_duration = $_POST['course_duration'];
        $course_price = $_POST['course_price'];
        $course_original_price = $_POST['course_original_price'];
        
        // Image Upload Logic
        $course_img = $_FILES['course_img']['name'];
        $course_img_temp = $_FILES['course_img']['tmp_name'];
        $img_folder = '../image/courseimg/' . $course_img;
        
        // Ensure directory exists
        if (!is_dir('../image/courseimg/')) {
            mkdir('../image/courseimg/', 0777, true);
        }
        
        move_uploaded_file($course_img_temp, $img_folder);

        // SQL Query
        $sql = "INSERT INTO course (course_name, course_desc, course_author, course_img, course_duration, course_price, course_original_price) 
                VALUES ('$course_name', '$course_desc', '$course_author', '$img_folder', '$course_duration', '$course_price', '$course_original_price')";

        if ($conn->query($sql) === TRUE) {
            // SUCCESS: Use JS redirect to avoid double insertion on refresh
            echo '<script>alert("Course Added Successfully!"); window.location.href="admincourses.php";</script>';
            exit();
        } else {
            $msg = '<div style="color: #e74c3c; margin-bottom: 1.5rem; font-weight: bold; text-align: center;">❌ Error: ' . $conn->error . '</div>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Course - LearnEase</title>
  <link rel="stylesheet" href="../styles.css">
</head>
<body style="background-color: #f8f9fa;">

  <nav class="navbar">
    <div class="container">
      <a href="../instructor-dashboard.php" class="logo">Learn<span>Ease</span></a>
      
      <ul class="nav-links">
          <li><a href="../instructor-dashboard.php">Dashboard</a></li>
          <li><a href="../about.php">About</a></li>
          <li><a href="admincourses.php">Courses</a></li>

         </ul>
      <div class="nav-actions">
        <span style="margin-right: 1rem; color: #2C3E50;">👨‍🏫 <?php echo $_SESSION['admin_name']; ?></span>
        <a href="../logout.php" class="btn btn-outline">Logout</a>
      </div>
    </div>
  </nav>

  <section style="margin: 3rem 0;">
    <div class="container" style="max-width: 700px;">
      <div class="card" style="padding: 2.5rem; background: white; border-radius: 12px; box-shadow: 0 8px 30px rgba(0,0,0,0.08);">
        
        <h2 style="margin-bottom: 2rem; color: #2C3E50; text-align: center;">📚 Create New Course</h2>
        
        <?php echo $msg; ?>

        <form action="" method="POST" enctype="multipart/form-data">
          <div style="margin-bottom: 1.2rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Course Name</label>
            <input type="text" name="course_name" placeholder="Enter course title" required 
                   style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 6px;">
          </div>

          <div style="margin-bottom: 1.2rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Course Description</label>
            <textarea name="course_desc" rows="3" placeholder="What will students learn?" required 
                      style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 6px; font-family: inherit;"></textarea>
          </div>

          <div style="display: flex; gap: 15px; margin-bottom: 1.2rem;">
            <div style="flex: 1;">
              <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Author</label>
              <input type="text" name="course_author" value="<?php echo $_SESSION['admin_name']; ?>" readonly 
                      style="width: 100%; padding: 0.8rem; border: 1px solid #eee; border-radius: 6px; background: #f9f9f9; color: #777;">
            </div>
            <div style="flex: 1;">
              <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Duration</label>
              <input type="text" name="course_duration" placeholder="e.g. 15 Hours" required 
                      style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 6px;">
            </div>
          </div>

          <div style="display: flex; gap: 15px; margin-bottom: 1.2rem;">
            <div style="flex: 1;">
              <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Original Price (Rs)</label>
              <input type="number" name="course_original_price" required 
                      style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 6px;">
            </div>
            <div style="flex: 1;">
              <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Selling Price (Rs)</label>
              <input type="number" name="course_price" required 
                      style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 6px;">
            </div>
          </div>

          <div style="margin-bottom: 2rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Course Banner Image</label>
            <input type="file" name="course_img" required 
                   style="width: 100%; padding: 0.6rem; border: 2px dashed #3498DB; border-radius: 6px; background: #f0f7ff;">
          </div>

          <div style="display: flex; gap: 10px;">
            <button type="submit" name="courseSubmitBtn" 
                    style="flex: 3; background: linear-gradient(135deg, #3498DB, #2ECC71); color: white; border: none; padding: 1rem; border-radius: 6px; cursor: pointer; font-weight: bold;">
              🚀 Save Course
            </button>
            <a href="admincourses.php" 
               style="flex: 1; text-align: center; background: #f1f2f6; color: #2C3E50; padding: 1rem; border-radius: 6px; text-decoration: none; font-weight: bold; border: 1px solid #ddd;">
              Cancel
            </a>
          </div>
        </form>

      </div>
    </div>
  </section>

</body>
</html>