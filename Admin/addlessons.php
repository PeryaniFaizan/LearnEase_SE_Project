<?php
// 1. Session and Connection
include('../dbConnection.php');
session_start();

if (!isset($_SESSION['is_admin_login'])) {
    header("Location: adminlogin.php");
    exit();
}

$msg = "";

// 2. SEARCH LOGIC: Fetch course name based on ID
if (isset($_REQUEST['checkidBtn'])) {
    if ($_REQUEST['checkid'] == "") {
        $msg = '<div style="color: #e67e22; text-align: center; font-weight: bold;">⚠️ Please Enter Course ID</div>';
    } else {
        $sql = "SELECT * FROM course WHERE course_id = {$_REQUEST['checkid']}";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        if (($row['course_id']) == $_REQUEST['checkid']) {
            $_SESSION['course_id'] = $row['course_id'];
            $_SESSION['course_name'] = $row['course_name'];
        } else {
            $msg = '<div style="color: #e74c3c; text-align: center; font-weight: bold;">❌ Course Not Found</div>';
        }
    }
}

// 3. INSERT LOGIC: Add lesson to the database
if (isset($_REQUEST['lessonSubmitBtn'])) {
    if (($_REQUEST['lesson_name'] == "") || ($_REQUEST['lesson_desc'] == "") || ($_FILES['lesson_link']['name'] == "")) {
        $msg = '<div style="color: #e67e22; text-align: center; font-weight: bold;">⚠️ Please Fill All Fields</div>';
    } else {
        $lesson_name = $_REQUEST['lesson_name'];
        $lesson_desc = $_REQUEST['lesson_desc'];
        $course_id = $_REQUEST['course_id'];
        $course_name = $_REQUEST['course_name'];
        
        $lesson_link = $_FILES['lesson_link']['name'];
        $lesson_link_temp = $_FILES['lesson_link']['tmp_name'];
        $link_folder = '../lessonvid/' . $lesson_link;
        move_uploaded_file($lesson_link_temp, $link_folder);

        $sql = "INSERT INTO lesson (lesson_name, lesson_desc, lesson_link, course_id, course_name) 
                VALUES ('$lesson_name', '$lesson_desc', '$link_folder', '$course_id', '$course_name')";

        if ($conn->query($sql) === TRUE) {
            $msg = '<div style="color: #27ae60; text-align: center; font-weight: bold;">✅ Lesson Added Successfully!</div>';
        } else {
            $msg = '<div style="color: #e74c3c; text-align: center;">❌ Error: ' . $conn->error . '</div>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Lesson - LearnEase</title>
  <link rel="stylesheet" href="../styles.css">
</head>
<body style="background-color: #f8f9fa;">

  <nav class="navbar">
    <div class="container">
      <a href="../instructor-dashboard.php" class="logo">Learn<span>Ease</span></a>
      <div class="nav-actions">
        <span style="margin-right: 1rem;">👨‍🏫 <?php echo $_SESSION['admin_name']; ?></span>
        <a href="../logout.php" class="btn btn-outline">Logout</a>
      </div>
    </div>
  </nav>

  <section style="margin: 3rem 0;">
    <div class="container" style="max-width: 600px;">
      
      <div class="card" style="padding: 1.5rem; margin-bottom: 2rem; background: white; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
        <form action="" method="GET" style="display: flex; gap: 10px; align-items: flex-end;">
          <div style="flex: 1;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Enter Course ID to Start:</label>
            <input type="number" name="checkid" placeholder="e.g. 16" required style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 6px;">
          </div>
          <button type="submit" name="checkidBtn" style="background: #3498DB; color: white; padding: 0.8rem 1.5rem; border: none; border-radius: 6px; cursor: pointer; font-weight: bold;">Search</button>
        </form>
      </div>

      <?php echo $msg; ?>

      <?php if (isset($_SESSION['course_id'])) { ?>
      <div class="card" style="padding: 2.5rem; background: white; border-radius: 12px; box-shadow: 0 8px 30px rgba(0,0,0,0.08);">
        <h2 style="margin-bottom: 2rem; color: #2C3E50; text-align: center;">📽️ Add Lesson to "<?php echo $_SESSION['course_name']; ?>"</h2>
        
        <form action="" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="course_id" value="<?php echo $_SESSION['course_id']; ?>">
          <input type="hidden" name="course_name" value="<?php echo $_SESSION['course_name']; ?>">

          <div style="margin-bottom: 1.2rem;">
            <label style="font-weight: 600; display: block; margin-bottom: 0.5rem;">Lesson Name</label>
            <input type="text" name="lesson_name" required style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 6px;">
          </div>

          <div style="margin-bottom: 1.2rem;">
            <label style="font-weight: 600; display: block; margin-bottom: 0.5rem;">Description</label>
            <textarea name="lesson_desc" rows="3" required style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 6px;"></textarea>
          </div>

          <div style="margin-bottom: 2rem;">
            <label style="font-weight: 600; display: block; margin-bottom: 0.5rem;">Lesson Video File</label>
            <input type="file" name="lesson_link" required style="width: 100%; padding: 0.6rem; border: 1px solid #ddd; border-radius: 6px;">
          </div>

          <div style="display: flex; gap: 10px;">
            <button type="submit" name="lessonSubmitBtn" style="flex: 3; background: #2ECC71; color: white; padding: 1rem; border: none; border-radius: 6px; font-weight: bold; cursor: pointer;">Save Lesson</button>
            
            <a href="lesson.php" style="flex: 1; text-align: center; background: #f1f2f6; color: #2C3E50; padding: 1rem; border-radius: 6px; text-decoration: none; font-weight: bold; border: 1px solid #ddd;">Cancel</a>
          </div>
        </form>
      </div>
      <?php } ?>

    </div>
  </section>

</body>
</html>