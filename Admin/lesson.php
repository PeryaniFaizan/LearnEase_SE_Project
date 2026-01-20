<?php
// 1. Session and Connection
include('../dbConnection.php');
session_start();

if (!isset($_SESSION['is_admin_login'])) {
    header("Location: adminlogin.php");
    exit();
}

$msg = "";

// 2. DELETE LESSON LOGIC
if(isset($_REQUEST['delete'])) {
    $sql = "DELETE FROM lesson WHERE lesson_id = {$_REQUEST['id']}";
    if($conn->query($sql) === TRUE) {
        $msg = '<div style="color: #27ae60; text-align: center; font-weight: bold; margin-bottom:1rem;">✅ Lesson Deleted Successfully!</div>';
    }
}

// 3. SEARCH LOGIC: Fetch course details
if (isset($_REQUEST['checkidBtn'])) {
    if ($_REQUEST['checkid'] == "") {
        $msg = '<div style="color: #e67e22; text-align: center; font-weight: bold; margin-bottom:1rem;">⚠️ Please Enter Course ID</div>';
    } else {
        $sql = "SELECT * FROM course WHERE course_id = {$_REQUEST['checkid']}";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        if (isset($row['course_id']) && ($row['course_id'] == $_REQUEST['checkid'])) {
            $_SESSION['course_id'] = $row['course_id'];
            $_SESSION['course_name'] = $row['course_name'];
        } else {
            $msg = '<div style="color: #e74c3c; text-align: center; font-weight: bold; margin-bottom:1rem;">❌ Course Not Found</div>';
            unset($_SESSION['course_id']);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Lessons - LearnEase</title>
  <link rel="stylesheet" href="../styles.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body style="background-color: #f8f9fa;">

  <nav class="navbar">
    <div class="container">
      <a href="../instructor-dashboard.php" class="logo">Learn<span>Ease</span></a>
      <ul class="nav-links">
            <li><a href="../instructor-dashboard.php">Dashboard</a></li>
            <li><a href="../about.php">About</a></li>
            <!-- <li><a href="admincourses.php">Courses</a></li> -->
        </ul>
      <div class="nav-actions">
        <span style="margin-right: 1rem;">👨‍🏫 <?php echo $_SESSION['admin_name']; ?></span>
        <a href="../logout.php" class="btn btn-outline">Logout</a>
      </div>
    </div>
  </nav>

  <section style="margin: 3rem 0;">
    <div class="container">
      
      <div class="card" style="padding: 1.5rem; margin-bottom: 2rem; background: white; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); max-width: 600px; margin-left: auto; margin-right: auto;">
        <form action="" method="GET" style="display: flex; gap: 10px; align-items: flex-end;">
          <div style="flex: 1;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Course ID:</label>
            <input type="number" name="checkid" value="<?php if(isset($_SESSION['course_id'])){ echo $_SESSION['course_id']; } ?>" placeholder="e.g. 16" required style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 6px;">
          </div>
          <button type="submit" name="checkidBtn" style="background: #3498DB; color: white; padding: 0.8rem 1.5rem; border: none; border-radius: 6px; cursor: pointer; font-weight: bold;">Search</button>
        </form>
      </div>

      <?php echo $msg; ?>

      <?php if (isset($_SESSION['course_id'])) { 
          echo '<h2 style="text-align: center; margin-bottom: 1.5rem; color: #2C3E50;">Lessons for: '.$_SESSION['course_name'].'</h2>';
          
          $sql = "SELECT * FROM lesson WHERE course_id = {$_SESSION['course_id']}";
          $result = $conn->query($sql);
          ?>
          <div class="card" style="padding: 1.5rem; background: white; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; min-width: 600px;">
              <thead>
                <tr style="background-color: #f8f9fa; text-align: left;">
                  <th style="padding: 1rem; border-bottom: 2px solid #dee2e6;">ID</th>
                  <th style="padding: 1rem; border-bottom: 2px solid #dee2e6;">Lesson Name</th>
                  <th style="padding: 1rem; border-bottom: 2px solid #dee2e6;">Video Link/Path</th>
                  <th style="padding: 1rem; border-bottom: 2px solid #dee2e6; text-align: center;">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) { ?>
                    <tr style="border-bottom: 1px solid #eee;">
                      <td style="padding: 1rem; font-weight: bold;"><?php echo $row['lesson_id']; ?></td>
                      <td style="padding: 1rem;"><?php echo $row['lesson_name']; ?></td>
                      <td style="padding: 1rem; font-size: 0.85rem; color: #7f8c8d;"><?php echo $row['lesson_link']; ?></td>
                      <td style="padding: 1rem; text-align: center;">
                        <form method="POST" onsubmit="return confirm('Delete this lesson?');" style="margin: 0;">
                          <input type="hidden" name="id" value="<?php echo $row['lesson_id']; ?>">
                          <button type="submit" name="delete" style="background: none; border: none; color: #E74C3C; cursor: pointer; font-size: 1.2rem;">
                            <i class="fas fa-trash-alt"></i>
                          </button>
                        </form>
                      </td>
                    </tr>
                <?php } } else {
                    echo '<tr><td colspan="4" style="text-align: center; padding: 2rem; color: #7f8c8d;">No lessons found. Click the + button to add one.</td></tr>';
                } ?>
              </tbody>
            </table>
          </div>

          <a href="addlessons.php" 
             style="position: fixed; bottom: 40px; right: 40px; background: #2ECC71; color: white; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 30px; text-decoration: none; box-shadow: 0 4px 10px rgba(0,0,0,0.2); z-index: 1000; transition: transform 0.2s;"
             onmouseover="this.style.transform='scale(1.1)';" 
             onmouseout="this.style.transform='scale(1)';"
             title="Add New Lesson">
            <i class="fas fa-plus"></i>
          </a>
      <?php } ?>

    </div>
  </section>

</body>
</html>