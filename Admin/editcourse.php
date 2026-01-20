<?php
// 1. Session and Connection
include('../dbConnection.php');
session_start();

// Redirect if not logged in
if (!isset($_SESSION['is_admin_login'])) {
    header("Location: adminlogin.php");
    exit();
}

$msg = ""; // Initializing to prevent "Undefined variable" error

// 2. UPDATE LOGIC: Handles saving changes when the button is clicked
if (isset($_REQUEST['courseUpdateBtn'])) {
    // Checking for Empty Fields
    if (
        ($_REQUEST['course_id'] == "") || ($_REQUEST['course_name'] == "") || 
        ($_REQUEST['course_desc'] == "") || ($_REQUEST['course_author'] == "") || 
        ($_REQUEST['course_duration'] == "") || ($_REQUEST['course_price'] == "") || 
        ($_REQUEST['course_original_price'] == "")
    ) {
        $msg = '<div style="color: #e67e22; margin-bottom: 1rem; font-weight: bold; text-align: center;">⚠️ Please Fill All Fields</div>';
    } else {
        // Assigning Form Values to Variables
        $cid = $_REQUEST['course_id'];
        $cname = $_REQUEST['course_name'];
        $cdesc = $_REQUEST['course_desc'];
        $cauthor = $_REQUEST['course_author'];
        $cduration = $_REQUEST['course_duration'];
        $cprice = $_REQUEST['course_price'];
        $coriginalprice = $_REQUEST['course_original_price'];
        
        // Handle Image Logic: If a new file is uploaded, use it. Otherwise, keep the old path.
        if ($_FILES['course_img']['name'] != "") {
            $course_img = $_FILES['course_img']['name'];
            $course_img_temp = $_FILES['course_img']['tmp_name'];
            $img_folder = '../image/courseimg/' . $course_img;
            move_uploaded_file($course_img_temp, $img_folder);
        } else {
            // Keep the existing image if no new one is selected
            $img_folder = $_REQUEST['old_course_img'];
        }

        // Final SQL UPDATE Query
        $sql = "UPDATE course SET 
                course_name = '$cname', 
                course_desc = '$cdesc', 
                course_author = '$cauthor', 
                course_img = '$img_folder', 
                course_duration = '$cduration', 
                course_price = '$cprice', 
                course_original_price = '$coriginalprice' 
                WHERE course_id = '$cid'";

        if ($conn->query($sql) === TRUE) {
            $msg = '<div style="color: #27ae60; margin-bottom: 1rem; font-weight: bold; text-align: center;">✅ Course Updated Successfully! Redirecting...</div>';
            // Refresh back to the course list after success
            echo '<meta http-equiv="refresh" content="1.5;URL=../instructor-dashboard.php" />';
        } else {
            $msg = '<div style="color: #e74c3c; margin-bottom: 1rem; font-weight: bold; text-align: center;">❌ Update Failed: ' . $conn->error . '</div>';
        }
    }
}

// 3. FETCH LOGIC: Get data to show in the form based on the ID in the URL
if (isset($_REQUEST['id'])) {
    $sql = "SELECT * FROM course WHERE course_id = {$_REQUEST['id']}";
    $result = $conn->query($sql);
    if($result->num_rows == 1) {
        $row = $result->fetch_assoc();
    } else {
        echo "Course not found.";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Course - LearnEase</title>
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
        
        <h2 style="margin-bottom: 2rem; color: #2C3E50; text-align: center;">✏️ Edit Course Details</h2>
        
        <?php echo $msg; ?> <form action="" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="course_id" value="<?php echo $row['course_id']; ?>"> 

          <div style="margin-bottom: 1.2rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Course Name</label>
            <input type="text" name="course_name" value="<?php echo $row['course_name']; ?>" required 
                   style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 6px;">
          </div>

          <div style="margin-bottom: 1.2rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Description</label>
            <textarea name="course_desc" rows="3" required 
                      style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 6px; font-family: inherit;"><?php echo $row['course_desc']; ?></textarea>
          </div>

          <div style="display: flex; gap: 15px; margin-bottom: 1.2rem;">
            <div style="flex: 1;">
              <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Author</label>
              <input type="text" name="course_author" value="<?php echo $row['course_author']; ?>" required 
                     style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 6px;">
            </div>
            <div style="flex: 1;">
              <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Duration</label>
              <input type="text" name="course_duration" value="<?php echo $row['course_duration']; ?>" required 
                     style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 6px;">
            </div>
          </div>

          <div style="display: flex; gap: 15px; margin-bottom: 1.2rem;">
            <div style="flex: 1;">
              <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Original Price</label>
              <input type="number" name="course_original_price" value="<?php echo $row['course_original_price']; ?>" required 
                     style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 6px;">
            </div>
            <div style="flex: 1;">
              <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Selling Price</label>
              <input type="number" name="course_price" value="<?php echo $row['course_price']; ?>" required 
                     style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 6px;">
            </div>
          </div>

          <div style="margin-bottom: 2rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Course Image</label>
            <img src="<?php echo $row['course_img']; ?>" alt="courseimg" style="width: 120px; margin-bottom: 10px; border-radius: 5px; display: block; border: 1px solid #ddd;">
            
            <input type="hidden" name="old_course_img" value="<?php echo $row['course_img']; ?>">
            <input type="file" name="course_img" style="width: 100%; padding: 0.6rem; border: 1px solid #ddd; border-radius: 6px;">
          </div>

          <div style="display: flex; gap: 10px;">
            <button type="submit" name="courseUpdateBtn" 
                    style="flex: 3; background: #3498DB; color: white; border: none; padding: 1rem; border-radius: 6px; cursor: pointer; font-weight: bold;">
              Update Course
            </button>
            <a href="../instructor-dashboard.php" 
               style="flex: 1; text-align: center; background: #95a5a6; color: white; padding: 1rem; border-radius: 6px; text-decoration: none; font-weight: bold;">
              Close
            </a>
          </div>
        </form>

      </div>
    </div>
  </section>

</body>
</html>