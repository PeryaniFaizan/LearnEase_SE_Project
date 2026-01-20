<?php
// 1. Corrected Paths for the Student subfolder
include_once('../dbConnection.php'); 

if(!isset($_SESSION)){
    session_start();
}

// Security: Redirect if student is not logged in
if (!isset($_SESSION['is_login'])) {
    header("Location: ../login.php");
    exit();
}

$stuEmail = $_SESSION['stuLogEmail']; 

// Default fallback (relative to Student/ folder)
$stuImg = '../image/student/default.png';

$sql_img = "SELECT stu_img FROM stddata WHERE stu_email = '$stuEmail'";
$res_img = $conn->query($sql_img);

if ($res_img && $res_img->num_rows > 0) {
    $row_img = $res_img->fetch_assoc();
    if (!empty($row_img['stu_img'])) {
        $candidate = $row_img['stu_img'];
        // If local path, prefer it only if the file exists; otherwise keep fallback
        if (strpos($candidate, 'http') === 0 || file_exists($candidate)) {
            $stuImg = $candidate;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Courses - LearnEase</title>
  <link rel="stylesheet" href="../styles.css">
  
  <style>
    .card {
        transition: all 0.3s ease;
        border: 1px solid transparent; /* Reserve space so it doesn't jump */
    }
    .card:hover {
        /* Blue outline color matching your theme */
        border-color: #4A90E2; 
        /* Optional: Add a soft blue glow and slight lift */
        box-shadow: 0 4px 15px rgba(74, 144, 226, 0.3);
        transform: translateY(-5px);
    }
  </style>
</head>
<body style="background-color: #f8f9fa;">

  <nav class="navbar">
    <div class="container">
      <a href="../student-dashboard.php" class="logo">Learn<span>Ease</span></a>
      
      <ul class="nav-links">
        <li><a href="../student-dashboard.php">Home</a></li>
        <li><a href="../about.php">About</a></li>
        <li><a href="../courses.php">Courses</a></li>
      </ul>
      
      <div class="nav-actions">
        <div style="display: flex; align-items: center; gap: 15px;">
           
           <a href="studentprof.php" title="View Profile">
               <img src="<?php echo (!empty($stuImg)) ? $stuImg : '../image/student/default.png'; ?>" 
                    style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover; border: 1px solid #ddd; cursor: pointer;">
           </a>
           
           <a href="../logout.php" class="btn btn-outline">Log Out</a>
        </div>
      </div>
    </div>
  </nav>

  <section style="background: linear-gradient(135deg, #4A90E2 0%, #50C878 100%); color: white; padding: 3rem 0;">
    <div class="container">
      <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
          <h1 style="color: white; margin: 0;">My Enrolled Courses</h1>
          <p style="color: white; font-size: 1.1rem; margin-top: 0.5rem;">Access all your learning materials in one place</p>
        </div>
        <a href="../student-dashboard.php" class="btn" style="background: rgba(255, 255, 255, 0.2); color: white; border: 1px solid white; padding: 0.8rem 1.5rem; border-radius: 8px; text-decoration: none; font-weight: bold;">
          📊 Dashboard
        </a>
      </div>
    </div>
  </section>

  <section style="margin: 4rem 0;">
    <div class="container">
      <div class="grid grid-3">
        <?php
          // 2. Fetch courses using the JOIN logic
          $sql = "SELECT co.course_id, c.course_name, c.course_desc, c.course_author, c.course_img 
                  FROM courseorder AS co 
                  JOIN course AS c ON co.course_id = c.course_id 
                  WHERE co.stu_email = '$stuEmail'";
          
          $result = $conn->query($sql);

          if($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
              $course_id = $row['course_id'];
              $course_name = $row['course_name'];
              $course_desc = $row['course_desc'];
              $course_author = $row['course_author'];
              $course_img = $row['course_img'];
              
              $final_img = $course_img; 
        ?>
            <div class="card">
              <img src="<?php echo $final_img; ?>" alt="<?php echo $course_name; ?>" style="width: 100%; height: 200px; object-fit: cover; border-radius: 5px; margin-bottom: 1rem;">
              
              <div class="card-header">
                <h3 class="card-title"><?php echo $course_name; ?></h3>
                <span class="badge badge-success">Enrolled</span>
              </div>

              <div class="card-body">
                <p><?php echo substr($course_desc, 0, 80); ?>...</p> 
                <p style="font-size: 0.9rem; color: #7F8C8D; margin-top: 0.5rem;">
                  Instructor: <?php echo $course_author; ?>
                </p>
                
                <a href="./watchlesson.php?course_id=<?php echo $course_id; ?>" class="btn btn-primary mt-1" style="width: 100%;">
                  Watch Lessons
                </a>
              </div>
            </div>
        <?php
            }
          } else {
            echo '
            <div class="card text-center" style="grid-column: span 3; padding: 4rem;">
                <h3 style="color: #7F8C8D;">You haven\'t enrolled in any courses yet.</h3>
                <a href="../courses.php" class="btn btn-primary mt-1">Browse Courses</a>
            </div>';
          }
        ?>
      </div>
    </div>
  </section>

  <?php include('../footer.php'); ?>
</body>
</html>