<?php
// 1. Session and Connection
include('../dbConnection.php');
session_start();

// Security: Check if Admin is logged in
if (!isset($_SESSION['is_admin_login'])) {
    header("Location: adminlogin.php");
    exit();
}

// 2. LOGIC: DELETE ENTIRE STUDENT
if (isset($_REQUEST['delete'])) {
    $sql_getId= "SELECT user_id FROM stddata WHERE stu_id = {$_REQUEST['stu_id']}";
    $res_getId = $conn->query($sql_getId);
    $row_getId = $res_getId->fetch_assoc();
    $user_id = $row_getId['user_id'];
    $sql_std = "DELETE FROM stddata WHERE stu_id = {$_REQUEST['stu_id']}";
    $sql_user = "DELETE FROM user WHERE user_id = $user_id";
    if ($conn->query($sql_std) === TRUE ) {
      if($conn->query($sql_user) === TRUE ){
      echo '<meta http-equiv="refresh" content="0;URL=?deleted_student" />';
    }
  }
}

// 3. LOGIC: KICK STUDENT FROM SPECIFIC COURSE
if (isset($_POST['remove_course'])) {
    $cid_remove = $_POST['course_id_remove'];
    $email_remove = $_POST['stu_email_remove'];
    
    // Delete only the enrollment record
    $sql_kick = "DELETE FROM courseorder WHERE course_id = '$cid_remove' AND stu_email = '$email_remove'";
    if ($conn->query($sql_kick) === TRUE) {
        echo '<meta http-equiv="refresh" content="0;URL=?kicked_from_course" />';
    } else {
        echo "Error: " . $conn->error;
    }
}

// 4. DYNAMIC STATS LOGIC
// Count Courses
$sql_course = "SELECT COUNT(*) as total_courses FROM course";
$res_course = $conn->query($sql_course);
$row_course = $res_course->fetch_assoc();
$total_courses = $row_course['total_courses'];

// Count Students
$sql_stu_count = "SELECT COUNT(*) as total_stu FROM stddata";
$res_stu_count = $conn->query($sql_stu_count);
$row_stu_count = $res_stu_count->fetch_assoc();
$total_students = $row_stu_count['total_stu'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management - LearnEase</title>
    <link rel="stylesheet" href="../styles.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Custom style for the course tag container */
        .course-tag {
            display: inline-flex;
            align-items: center;
            background: #e1f5fe;
            color: #0288d1;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 0.85rem;
            margin-right: 5px;
            margin-bottom: 5px;
            border: 1px solid #b3e5fc;
        }
        /* Style for the mini 'x' button inside the tag */
        .kick-btn {
            background: none;
            border: none;
            color: #d32f2f;
            margin-left: 5px;
            cursor: pointer;
            font-weight: bold;
            font-size: 1rem;
            line-height: 1;
            padding: 0 2px;
        }
        .kick-btn:hover {
            color: #b71c1c;
        }
    </style>
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
            <span style="margin-right: 1rem; color: #2C3E50;">
                👨‍🏫 <?php echo $_SESSION['admin_name']; ?>
            </span>
            <a href="../logout.php" class="btn btn-outline">Logout</a>
        </div>
    </div>
</nav>

<section style="margin-top: 2rem;">
  <div class="container">
    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
      <div class="card" style="padding: 2rem; background: white; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); text-align: center;">
        <div style="font-size: 2.5rem; color: #4A90E2; margin-bottom: 0.5rem;"><?php echo $total_courses; ?></div>
        <h3 style="font-size: 1.1rem; color: #7F8C8D;">Your Courses</h3>
      </div>
      <div class="card" style="padding: 2rem; background: white; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); text-align: center;">
        <div style="font-size: 2.5rem; color: #50C878; margin-bottom: 0.5rem;"><?php echo $total_students; ?></div>
        <h3 style="font-size: 1.1rem; color: #7F8C8D;">Total Students</h3>
      </div>
    </div>
  </div>
</section>

<section style="margin: 2rem 0;">
    <div class="container">
      <div class="card" style="padding: 1.5rem; background: white; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); overflow-x: auto;">
        <h2 style="margin-bottom: 1.5rem; color: #2C3E50;">👨‍🎓 Student Management</h2>
        
        <table style="width: 100%; border-collapse: collapse; min-width: 600px;">
          <thead>
            <tr style="background-color: #f8f9fa; text-align: left;">
              <th style="padding: 1rem; border-bottom: 2px solid #dee2e6;">ID</th>
              <th style="padding: 1rem; border-bottom: 2px solid #dee2e6;">Name</th>
              <th style="padding: 1rem; border-bottom: 2px solid #dee2e6;">Email</th>
              <th style="padding: 1rem; border-bottom: 2px solid #dee2e6;">Enrolled Courses</th>
              <th style="padding: 1rem; border-bottom: 2px solid #dee2e6; text-align: center;">Delete Student</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $sql = "SELECT stu_id, stu_name, stu_email FROM stddata";
            $result = $conn->query($sql);

            if($result && $result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                   // if($row[role] == 'admin') continue; // Skip admin users
                    $stu_email = $row['stu_email'];
            ?>
                <tr style="border-bottom: 1px solid #eee;">
                  <td style="padding: 1rem; font-weight: bold;"><?php echo $row['stu_id']; ?></td>
                  <td style="padding: 1rem;"><?php echo $row['stu_name']; ?></td>
                  <td style="padding: 1rem;"><?php echo $row['stu_email']; ?></td>
                  
                  <td style="padding: 1rem;">
                    <?php 
                        // Query: Fetch Course Name AND Course ID
                        $sql_enrolled = "SELECT c.course_name, c.course_id 
                                         FROM courseorder AS co 
                                         JOIN course AS c ON c.course_id = co.course_id 
                                         WHERE co.stu_email = '$stu_email'";
                        $res_enrolled = $conn->query($sql_enrolled);
                        
                        if($res_enrolled && $res_enrolled->num_rows > 0){
                            // Loop through courses
                            while($course_row = $res_enrolled->fetch_assoc()){
                    ?>
                                <div class="course-tag">
                                    <?php echo $course_row['course_name']; ?>
                                    
                                    <form method="POST" style="display:inline;" onsubmit="return confirm('Kick student from <?php echo $course_row['course_name']; ?>?');">
                                        <input type="hidden" name="course_id_remove" value="<?php echo $course_row['course_id']; ?>">
                                        <input type="hidden" name="stu_email_remove" value="<?php echo $stu_email; ?>">
                                        <button type="submit" name="remove_course" class="kick-btn" title="Remove from this course">×</button>
                                    </form>
                                </div>
                    <?php 
                            }
                        } else {
                            echo '<span style="color: #95a5a6; font-style: italic;">Not Enrolled</span>';
                        }
                    ?>
                  </td>

                  <td style="padding: 1rem;">
                    <div style="display: flex; gap: 15px; justify-content: center;">
                      <form method="POST" onsubmit="return confirm('Delete this student completely? This cannot be undone.');" style="margin:0;">
                        <input type="hidden" name="stu_id" value="<?php echo $row['stu_id']; ?>">
                        <button type="submit" name="delete" style="background:none; border:none; color: #E74C3C; cursor: pointer; font-size: 1.2rem;" title="Delete Entire Account">
                          <i class="fas fa-trash-alt"></i>
                        </button>
                      </form>
                    </div>
                  </td>
                </tr>
            <?php
                }
            } else {
                echo "<tr><td colspan='5' style='text-align:center; padding:2rem;'>No students found.</td></tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
</section>

</body>
</html>